<?php

namespace Sebpro\ArtisanExt\Commands;

use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ExtDBHost extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:host {databasehost}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the database host for your application.';

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
     * @return void
     */
    public function handle()
    {
        $old_db_host = $this->laravel['config']['database.connections.'.
                       $this->laravel['config']['database.default'].'.host'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents(
                $file,
                str_replace(
                    'DB_HOST='.$old_db_host,
                    'DB_HOST='.$this->argument('databasehost'),
                    file_get_contents($file)
                )
            );

            return $this->info('The database host has been changed '.
                               'successfully to: '.
                               $this->argument('databasehost'));
        }

        return $this->error('The .env configuration file is missing.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'databasehost',
                InputArgument::REQUIRED,
                'Database host for your application',
            ],
        ];
    }
}
