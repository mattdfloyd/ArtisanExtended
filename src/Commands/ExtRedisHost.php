<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtRedisHost extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'redis:host {redishost}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change the redis host for your application.';

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
    $old_redis_host = $this->laravel['config']['database.redis.default.host'];

    $file = base_path('.env');

    if (file_exists($file))
    {
      file_put_contents($file, str_replace('REDIS_HOST=' . $old_redis_host, 'REDIS_HOST=' . $this->argument('redishost'), file_get_contents($file)));

      return $this->info('The redis host has been changed successfully to: ' . $this->argument('redishost'));
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
			array('redishost', InputArgument::REQUIRED, 'Redis host for your application'),
		);
	}

}
