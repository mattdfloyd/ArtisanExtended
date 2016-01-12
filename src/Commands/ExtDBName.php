<?php namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtDBName extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:name {databasename}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change the database name for your application.';

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
    $old_db_name = $this->laravel['config']['database.connections.' . $this->laravel['config']['database.default'] . '.database'];

    $file = base_path('.env');

    if (file_exists($file))
    {
      file_put_contents($file, str_replace('DB_DATABASE=' . $old_db_name, 'DB_DATABASE=' . $this->argument('databasename'), file_get_contents($file)));

      return $this->info('The database name has been changed successfully to: ' . $this->argument('databasename'));
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
			array('databasename', InputArgument::REQUIRED, 'Database name for your application'),
		);
	}

}