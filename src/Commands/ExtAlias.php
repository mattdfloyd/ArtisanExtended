<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtAlias extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:alias {alias}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add an alias.';

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
    $config_file = config_path() . '/app.php';

    if(!file_exists($config_file))
    {
      return $this->error('The app.php configuration file is missing.');
    }

    $config_file_data = file_get_contents($config_file);
    $artisan_ext_head =  '        /*' . "\n" . '         * Artisan Extended added aliases...' . "\n" . '         */' . "\n"; //78

    if(strpos($config_file_data, $artisan_ext_head) == false)
    {
      $pos = strpos($config_file_data, '\'aliases\' => [');
      $config_file_data_new = substr_replace($config_file_data, "\n" . $artisan_ext_head . '        ' . $this->argument('alias') . '::class,' . "\n" , $pos + 17, 0);
      file_put_contents($config_file, $config_file_data_new);
    }
    else
    {
      $pos = strpos($config_file_data, $artisan_ext_head);
      $config_file_data_new = substr_replace($config_file_data, '        ' . $this->argument('alias') . '::class,' . "\n", $pos + 68, 0);
    }

    file_put_contents($config_file_data, $config_file_data_new);
    return $this->info('The following alias has been succesfully added: ' . $this->argument('alias'));

  }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('alias', InputArgument::REQUIRED, 'The alias definition'),
		);
	}

}
