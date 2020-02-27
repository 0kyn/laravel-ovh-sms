<?php

namespace Okn\OvhSms;

use GuzzleHttp\Client;

class OvhSms
{
    private $options = [
        'charset' => 'UTF-8',
        'class' => 'phoneDisplay',
        'coding' => '7bit',
        'noStopClause' => false,
        'priority' => 'high',
        'senderForResponse' => true,
        'validityPeriod' => 2880,
    ];

    private $appKey;
    private $appSecret;
    private $endpoint;
    private $consumerKey;
    private $serviceName;
    private $sslVerify;

    private $message;

    private $maxParts;

    public function __construct($config)
    {
        $this->appKey = $config['app_key'];
        $this->appSecret = $config['app_secret'];
        $this->endpoint = $config['endpoint'];
        $this->consumerKey = $config['consumer_key'];
        $this->serviceName = $config['service_name'];
        $this->sslVerify = isset($config['ssl_verify']) && !$config['ssl_verify'] ? false : true;

        $client = new Client([
            'timeout'         => 30,
            'connect_timeout' => 5,
            'verify' => $this->sslVerify
        ]);

        $ovh = new \Ovh\Api(
            $this->appKey,
            $this->appSecret,
            $this->endpoint,
            $this->consumerKey,
            $client
        );
        $this->client = $ovh;
    }

    public function createMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function limitParts(int $number)
    {
        $this->maxParts = $number;

        return $this;
    }

    private function estimateParts($message, $noStopClause = false, $senderType = 'alpha')
    {
        $data = [
            'message' => $message,
            'noStopClause' => $noStopClause,
            'senderType' => $senderType,
        ];

        $parts = $this->client->post('/sms/estimate/', $data)['parts'];

        return $parts;
    }

    public function setServiceName(string $serviceName)
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    public function send(array $phoneNumbers, array $options = [])
    {
        if (count($options) > 0) {
            foreach ($options as $k => $v) {
                $this->options[$k] = $v;
            }
        }

        if (is_null($this->serviceName)) {
            throw new \Exception('You must set a service name in the .env file (OVHSMS_SERVICE_NAME) or with setServiceName($name) function.');
        }

        if ($this->maxParts > 0) {
            $estimatedParts = $this->estimateParts($this->message);
            if ($estimatedParts > $this->maxParts) {
                throw new \Exception('The estimated parts number (' . $estimatedParts . ') is over the limit you defined (' . $this->maxParts . ')');
            }
        }

        $options = [
            'message' => $this->message,
            'receivers' => $phoneNumbers
        ];
        $data = (object) array_merge($this->options, $options);

        $response = $this->client->post('/sms/' . $this->serviceName . '/jobs', $data);

        return $response;
    }
}
