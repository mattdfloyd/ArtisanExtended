<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Sebpro\ArtisanExt\ArtisanExt;
use Symfony\Component\Console\Input\InputArgument;

class ExtDBHost extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'db:host
                           {databasehost : The host of your database server.}
                           {--C|check : When enabled, the system will check your database connection.}';

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

            if ($this->option('check')) {
                $this->info('The database host has been changed '.
                  'successfully to: '.
                  $this->argument('databasehost'));

                $this->laravel['config']['database.connections.'.
                $this->laravel['config']['database.default'].'.host'] = $this->argument('databasehost');

                try {
                    ArtisanExt::checkDb();

                    return $this->info('Succesfully connected to the database.');
                } catch (\PDOException $e) {
                    return $this->error('Failed to connect to the database.');
                }
            }

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
            [
                'check',
                'C',
                InputArgument::OPTIONAL,
                'Check the database connection',
            ],
        ];
    }
}
