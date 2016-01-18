<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExtLocale extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:locale {locale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the locale for your application.';

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
        $old_locale = $this->laravel['config']['app.locale'];

        $file = config_path().'/app.php';

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                "'locale' => '".$old_locale."',",
                "'locale' => '".$this->argument('locale')."',",
                file_get_contents($file)
            ));

            return $this->info('The locale has been changed '.
                               'successfully to: '.$this->argument('locale'));
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
        return [
            ['locale', InputArgument::REQUIRED,
                  'Locale of your application'],
        ];
    }
}
