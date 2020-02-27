<?php

namespace Okn\OvhSms\Console;

use Illuminate\Console\Command;

class OvhSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ovhsms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install OvhSms wrapper';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Installing OvhSms wrapper...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "Okn\OvhSms\OvhSmsServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed OvhSms wrapper');
    }
}
