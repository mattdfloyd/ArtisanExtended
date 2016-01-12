<?php namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtDBUser extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:user {databaseuser}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change the database user for your application.';

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
    $old_db_user = $this->laravel['config']['database.connections.' . $this->laravel['config']['database.default'] . '.username'];

    $file = base_path('.env');

    if (file_exists($file))
    {
      file_put_contents($file, str_replace('DB_USERNAME=' . $old_db_user, 'DB_USERNAME=' . $this->argument('databaseuser'), file_get_contents($file)));

      return $this->info('The database username has been changed successfully to: ' . $this->argument('databaseuser'));
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
			array('databaseuser', InputArgument::REQUIRED, 'Database host for your application'),
		);
	}

}
