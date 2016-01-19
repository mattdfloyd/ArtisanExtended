<?php

namespace Sebpro\ArtisanExt\Commands;

use Illuminate\Console\Command;
use Sebpro\ArtisanExt\ArtisanExt;

class ExtDBCheck extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check your database connection.';

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
        if (ArtisanExt::checkDb()) {
            return $this->info('Succesfully connected to the database.');
        }

        return $this->error('Failed to connect to the database.');
    }
}
