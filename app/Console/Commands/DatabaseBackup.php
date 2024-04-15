<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respaldo BD diario de la aplicación';

    public function __construct(){
        parent::__construct();
    }


    public function handle(){
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";

        // Create backup folder and set permission if not exist.
        $storageAt = storage_path() . "/app/backups/";
        if(!File::exists($storageAt))
        File::makeDirectory($storageAt, 0755, true, true);


        $command = "".env('DB_DUMP_PATH', 'mysqldump')." --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE');

        return exec($command . " > " . $storageAt . $filename);
    }
}

