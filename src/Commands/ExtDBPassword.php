<?php

namespace Sebpro\ArtisanExt\Commands;

use DB;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ExtDBPassword extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:password {databasepassword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the database password for '.
                             'your application.';

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
        $old_db_password = $this->laravel['config']['database.connections.'.
                           $this->laravel['config']['database.default'].
                           '.password'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                'DB_PASSWORD='.$old_db_password,
                'DB_PASSWORD='.$this->argument('databasepassword'),
                file_get_contents($file)
            ));

            return $this->info('The database password has been changed '.
                               'successfully to: '.
                               $this->argument('databasepassword'));
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
                'databasepassword',
                InputArgument::REQUIRED,
                'Database password for your application',
            ],
        ];
    }
}
