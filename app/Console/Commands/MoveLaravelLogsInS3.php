<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;

class MoveLaravelLogsInS3 extends Command
{
    protected $signature = 'logs:movetos3';
    protected $description = 'Move Laravel log files to S3';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Laravel logs File move cron start at: ' . now());

        // AWS configuration
        $s3Bucket = 'mum-epicon-source';
        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Get all log channels from the configuration
        $logChannels = config('logging.channels');
        $todayDate = Carbon::today()->format('Y-m-d');

        foreach ($logChannels as $channel => $settings) {
            // Check if the log channel has a 'path' setting
            if (isset($settings['path'])) {
                // Handle daily log file with date suffix if driver is 'daily'
                $logFilePath = $settings['path'];
                if (isset($settings['driver']) && $settings['driver'] === 'daily') {
                    $logFilePath = preg_replace('/\.log$/', "-{$todayDate}.log", $logFilePath);
                }

                $s3Key = "EPICON-WEB-LOGS/logs/{$channel}/{$channel}-{$todayDate}.log";

                try {
                    // Upload the log file to S3 if it exists
                    if (file_exists($logFilePath)) {
                        $result = $s3Client->putObject([
                            'Bucket' => $s3Bucket,
                            'Key'    => $s3Key,
                            'SourceFile' => $logFilePath,
                            'ACL'    => 'private',
                        ]);

                        Log::info("Log file '{$channel}' moved to S3: {$result['ObjectURL']}\n");

                        // Optionally delete the local log file after uploading
                        // unlink($logFilePath);
                    } else {
                        Log::info("Log file '{$channel}' does not exist at path: {$logFilePath}");
                    }
                } catch (AwsException $e) {
                    $error = "Error moving {$channel} log: " . $e->getMessage();
                    Log::info("Error: {{$error}} at " . now());
                }
            }
        }

        Log::info('Laravel logs File move cron end at: ' . now());
    }
}
