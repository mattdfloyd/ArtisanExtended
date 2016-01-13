<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtRedisPort extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'redis:port {redisport}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change the redis port for your application.';

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
    $old_redis_port = $this->laravel['config']['database.redis.default.port'];

    $file = base_path('.env');

    if (file_exists($file))
    {
      file_put_contents($file, str_replace('REDIS_PORT=' . $old_redis_port, 'REDIS_PORT=' . $this->argument('redisport'), file_get_contents($file)));

      return $this->info('The redis port has been changed successfully to: ' . $this->argument('redisport'));
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
			array('redisport', InputArgument::REQUIRED, 'Redis port of your application'),
		);
	}

}
