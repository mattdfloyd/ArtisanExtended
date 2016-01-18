<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtRedisPassword extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'redis:password {redispassword}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the redis password for your application.';

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
        $old_redis_password = $this->laravel['config']['database.redis.'.
                                                       'default.password'];

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                'REDIS_PASSWORD='.$old_redis_password,
                'REDIS_PASSWORD='.$this->argument('redispassword'),
                file_get_contents($file)
            ));

            return $this->info('The redis password has been changed '.
                               'successfully to: '.
                               $this->argument('redispassword'));
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
            ['redispassword', InputArgument::REQUIRED,
                  'Redis password for your application'],
        ];
    }
}
