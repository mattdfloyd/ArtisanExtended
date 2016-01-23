<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Sebpro\ArtisanExt\ArtisanExt;

class ExtDBName extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'db:name
                           {databasename : The name of your database.}
                           {--C|check : When enabled, the system will check your database connection.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the database name for your application.';

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
        $old_db_name = $this->laravel['config']['database.connections.'.
                       $this->laravel['config']['database.default'].
                       '.database'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents(
                $file,
                str_replace(
                    'DB_DATABASE='.$old_db_name,
                    'DB_DATABASE='.$this->argument('databasename'),
                    file_get_contents($file)
                )
            );

            if ($this->option('check')) {

                $this->info('The database name has been changed '.
                  'successfully to: '.
                  $this->argument('databasename'));

                $this->laravel['config']['database.connections.'.
                $this->laravel['config']['database.default'].'.database'] = $this->argument('databasename');

                try {
                    ArtisanExt::checkDb();
                    return $this->info('Succesfully connected to the database.');
                } catch (\PDOException $e) {
                    return $this->error('Failed to connect to the database.');
                }
            }

            return $this->info('The database name has been changed '.
                               'successfully to: '.
                               $this->argument('databasename'));
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
                'databasename',
                InputArgument::REQUIRED,
                'Database name for your application',
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
