<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Validator;
use Redirect;
//use Intervention\Image\ImageManagerStatic as Image;
use Auth;
class sessionfilesclean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessionfilesclean:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lookup sessionfilesclean using this CLI';

    protected $configParams = [];

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
    public function handle(){
        date_default_timezone_set("Asia/Kolkata");
        $this->info("Lookup Script Started at ".date("Y-m-d H:i:s"));
        if(env('SESSION_FILE_CLEANUP_ENABLED')=='true'){
            $this->flushFile();
        }
        $this->info("Done at ".gmdate("Y-m-d H:i:s"));
    }

    public function flushFile()
    {
        $path = config('session.files');
        $today = strtotime(date("Y-m-d"));
        $no_of_old_days_cleanup = env('SESSION_FILE_CLEANUP_N_OF_DAYS',10);  
        $this->info(date("Y-m-d")); 
        if (File::exists($path)) {
            $files =   File::allFiles($path);
            $cnt = 0;
            if(count($files) > 0){
                foreach($files as $item){
                    $this->info($item);
                    $this->info("Content last changed: ".date("F d Y H:i:s.", filemtime($item)));
                    $last_modified_time = strtotime(date("Y-m-d", filemtime($item)));
                    $time_diff = $today - $last_modified_time;
                    $no_of_days_ago = floor($time_diff/3600/24); 
                    $this->info($no_of_days_ago ." days old");
                    if($no_of_days_ago > $no_of_old_days_cleanup){
                        $this->info("File: ". $item ." : ". date("F d Y H:i:s.", filemtime($item)) . " deleted");
                        File::delete($item);
                        $cnt++;
                    }
                }
                $this->info("Out of ".count($files) . " Files, ". $cnt . " files are ".$no_of_old_days_cleanup." days old and deleted");
            } else {
                $this->info("No files found.");
            }
            //File::delete($files);
            //error_log( count($files).' sessions flushed');
        } else {
            error_log('check your session path exists');
        }
    }
}