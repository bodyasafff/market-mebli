<?php

namespace App\Console\Commands;

use App\Application;
use App\Models\Setting;
use App\Repositories\BaseRepository;
use Illuminate\Console\Command;

class C1TestCommand extends Command
{
    protected $signature = 'console-proc-1 {--procNum=}';

    public function handle()
    {
        Application::$procName = 'console_proc';
        Application::$procId = 1;
        Application::$isConsole = true;
        Application::$procNum = $this->option('procNum') ? $this->option('procNum') : 1;

        if(Setting::checkValue(Setting::consoleProcFlag(), 1)) {
            BaseRepository::echoLog(Setting::consoleProcFlag()." is already run \n");
            return;
        }
        Setting::updateValue(Setting::consoleProcFlag(), 1);
        BaseRepository::echoLog(Setting::consoleProcFlag()." --- start\n");


        //---------------------------------------------------------



        //---------------------------------------------------------

        Setting::updateValue(Setting::consoleProcFlag(), 0);

        echo "\n";
        BaseRepository::echoLog(Setting::consoleProcFlag()."\n -----check all ok---- end\n");
        return;
    }
}
