<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PayuStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payu:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payu check payment status and update order';

    protected $configParams = [];
    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();

        $this->configParams = [
            'key' => config('epicconfig.PAYUMONEY.PAYUMONEY_MERCHANT_KEY'),
            'cc_api_transUrl' => config('epicconfig.PAYUMONEY.API_URL'),
            'salt' => config('epicconfig.PAYUMONEY.PAYUMONEY_SALT'),
        ];
    }

    public function handle()
    {

    }

}
