<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Sebpro\ArtisanExt\ArtisanExt;
use Symfony\Component\Console\Input\InputArgument;

class ExtDBUser extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'db:user
                           {databaseuser : The user of your database.}
                           {--C|check : When enabled, the system will check your database connection.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the database user for your application.';

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
        $old_db_user = $this->laravel['config']['database.connections.'.
                       $this->laravel['config']['database.default'].
                       '.username'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                'DB_USERNAME='.$old_db_user,
                'DB_USERNAME='.$this->argument('databaseuser'),
                file_get_contents($file)
            ));

            if ($this->option('check')) {

                $this->info('The database user has been changed '.
                  'successfully to: '.
                  $this->argument('databaseuser'));

                $this->laravel['config']['database.connections.'.
                $this->laravel['config']['database.default'].'.username'] = $this->argument('databaseuser');

                try {
                    ArtisanExt::checkDb();
                    return $this->info('Succesfully connected to the database.');
                } catch (\PDOException $e) {
                    return $this->error('Failed to connect to the database.');
                }

                return $this->error('Failed to connect to the database.');
            }

            return $this->info('The database user has been changed '.
              'successfully to: '.
              $this->argument('databaseuser'));

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
                'databaseuser',
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
