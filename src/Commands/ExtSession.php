<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtSession extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:session {sessiondriver}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the session driver for your application.';

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
        $old_session_driver = $this->laravel['config']['session.driver'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                'SESSION_DRIVER='.$old_session_driver,
                'SESSION_DRIVER='.$this->argument('sessiondriver'),
                file_get_contents($file)
            ));

            return $this->info('The session driver has been changed '.
                               'successfully to: '.
                               $this->argument('sessiondriver'));
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
        return array(
            array('sessiondriver', InputArgument::REQUIRED,
                  'Session driver for your application'),
        );
    }
}
