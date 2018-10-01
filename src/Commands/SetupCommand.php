<?php

namespace ArtinCMS\LUM\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'lum:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup migration and models for user management';

    /**
     * Commands to call with their description.
     *
     * @var array
     */
    protected $calls = [
        'lum:publish' => 'Publishing Usermanagement Migration and Config',
        'laratrust:role' => 'Creating Role model',
        'laratrust:permission' => 'Creating Permission model',
        'laratrust:add-trait' => 'Adding LaratrustUserTrait to User model'
    ];

    /**
     * Create a new command instance
     *
     * @return void
     */
    public function __construct()
    {
        if (Config::get('laratrust.use_teams')) {
            $this->calls['laratrust:team'] = 'Creating Team model';
        }

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->calls as $command => $info) {
            $this->line(PHP_EOL . $info);
            $this->call($command);
        }
    }
}
