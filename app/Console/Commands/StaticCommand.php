<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StaticCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:static';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爱无尚静态分红';

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
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
