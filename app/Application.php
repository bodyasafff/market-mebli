<?php

namespace App;

use App\Models\Article;

class Application extends \Illuminate\Foundation\Application
{
    static $procName = 'console_proc';
    static $procId = 0;
    static $procNum = 0;
    static $isConsole = false;
    static $isError = false;

}