<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Sebpro\ArtisanExt\ArtisanExt;

class ExtPermCheck extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:permcheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the permissions on the storage and bootstrap/cache directories.';

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
        $permissions_array = ArtisanExt::checkPermissions();
        $count = 0;

        foreach ($permissions_array as $item => $value) {
            if ($value[key($value)] == true) {
                $count++;
                $this->info('The '.key($value).' directory is writable.');
            } else {
                $this->error('The '.key($value).' directory is not writable.');
            }
        }

        if ($count == count($permissions_array)) {
            return $this->info('All permissions are set correctly.');
        }

        return $this->error('Some of your permissions are not set correctly.
                             Check the laravel documentation for the correct '.
                            'permissions.');
    }
}
