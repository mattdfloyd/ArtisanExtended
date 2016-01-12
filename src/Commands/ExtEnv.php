<?php namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtEnv extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:env {environment}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change the environment for your application.';

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
    $old_env = $this->laravel['config']['app.env'];

    $file = base_path('.env');

    if (file_exists($file))
    {
      file_put_contents($file, str_replace('ENV=' . $old_env, 'ENV=' . $this->argument('environment'), file_get_contents($file)));

      return $this->info('The environment has been changed successfully to: ' . $this->argument('environment'));
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
			array('environment', InputArgument::REQUIRED, 'Environment of your application'),
		);
	}

}
