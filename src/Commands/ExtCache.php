<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ExtCache extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:cache {cachedriver}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the cache driver for your application.';

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
        $old_cache_driver = $this->laravel['config']['cache.default'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents(
                $file,
                str_replace(
                    'CACHE_DRIVER='.$old_cache_driver,
                    'CACHE_DRIVER='.$this->argument('cachedriver'),
                    file_get_contents($file)
                )
            );

            return $this->info('The cache driver has been changed '.
                               'successfully to: '.
                               $this->argument('cachedriver'));
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
                'cachedriver',
                InputArgument::REQUIRED,
                'Cache driver for your application',
            ],
        ];
    }
}
