<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \DB;
use \Schema;

class ExtProvider extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:provider';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add a service provider.';

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
		$file = config_path() . '/app.php';

		if(!file_exists($file))
		{
			return $this->error('The app.php configuration file is missing.');
		}

		$provider_path = $this->ask('What is the Service Provider\'s path?');
		$provider_line = '        ' . $provider_path . '::class,';

		$file_data = file_get_contents($file);
		$laravel_service_head = '        /*' . "\n" . '         * Laravel Framework Service Providers...' . "\n" . '         */' . "\n";
		$artisan_ext_head =  '        /*' . "\n" . '         * Artisan Extended added Service Providers...' . "\n" . '         */' . "\n"; //78

		if(strpos($file_data, $artisan_ext_head) == false)
		{
			$pos = strpos($file_data, '\'providers\' => [');
			$file_data_new = substr_replace($file_data, "\n" . $artisan_ext_head . $provider_line , $pos + 17, 0);
			file_put_contents($file, $file_data_new);
		}
		else
		{
			$pos = strpos($file_data, $artisan_ext_head);
			$file_data_new = substr_replace($file_data, $provider_line . "\n", $pos + 78, 0);
		}

		file_put_contents($file, $file_data_new);

		return $this->info('The following service provider has been succesfully added: ' . $provider_line);

	}


}
