<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RunApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this task to install dependanceis and run migrations and run seedars';

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
     * @return int
     */
    public function handle()
    {
        //install composer debendansies
        exec('composer update');

        //migrate database
        $this->call('migrate:fresh');

        //seed fake data if there is no data
        if (! User::first()) {
            $this->call('db:seed');
        }

        //run application
        $this->info('You can access API from: http://127.0.0.1:8000/api');
        $this->call('serv');
    }
}
