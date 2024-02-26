<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears all routes, views, caches and configs, reconfigures them';

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
        $this->call('clear');
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        // $this->call('view:cache');
        // $this->call('route:cache');
        $this->call('config:cache');
    }
}
