<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtCipher extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:cipher {cipher}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Change the cipher that\'s being used for your application.';

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
    $old_cipher = $this->laravel['config']['app.cipher'];

    $file = config_path() . '/app.php';

    if (file_exists($file))
    {
      file_put_contents($file, str_replace("'cipher' => '" . $old_cipher . "',","'cipher' => '" . $this->argument('cipher') . "',", file_get_contents($file)));

      return $this->info('The cipher has been changed successfully to: ' . $this->argument('cipher'));
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
		return array(
			array('cipher', InputArgument::REQUIRED, 'Cipher used in your application'),
		);
	}

}
