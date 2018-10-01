<?php

namespace ArtinCMS\LUM\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lum:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulbish User management';

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
        $force = true ;
        $exitCode = Artisan::call('vendor:publish', [
            '--provider' => "ArtinCMS\LUM\LUMServiceProvider", '--force' => $force
        ]);
        return 'LARAVEL USER MANAGER INSTALL SUCCESSFULLY';
    }
}
