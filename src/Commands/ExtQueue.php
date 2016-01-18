<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtQueue extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:queue {queuedriver}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the queue driver for your application.';

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
        $old_queue_driver = $this->laravel['config']['queue.default'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                'QUEUE_DRIVER='.$old_queue_driver,
                'QUEUE_DRIVER='.$this->argument('environment'),
                file_get_contents($file)
            ));

            return $this->info('The queue driver has been changed '.
                               'successfully to: '.
                               $this->argument('queuedriver'));
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
            array('queuedriver', InputArgument::REQUIRED,
                  'Queue driver for your application'),
        );
    }
}
