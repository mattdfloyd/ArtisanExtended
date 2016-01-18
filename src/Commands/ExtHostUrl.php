<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtHostUrl extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:url {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the URL for your application.';

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
        $old_url = $this->laravel['config']['app.url'];

        $file = config_path().'/app.php';

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                "'url' => '".$old_url."',",
                "'url' => '".$this->argument('url')."',",
                file_get_contents($file)
            ));

            return $this->info('The URL has been changed '.
                               'successfully to: '.$this->argument('url'));
        }

        return $this->error('The app.php configuration file is missing.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['url', InputArgument::REQUIRED, 'URL of your application',],
        ];
    }
}
