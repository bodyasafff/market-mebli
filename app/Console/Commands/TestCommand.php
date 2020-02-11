<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'test-run';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        echo "--- start\n";

        echo "-------------- end\n";
        return;
    }
}
