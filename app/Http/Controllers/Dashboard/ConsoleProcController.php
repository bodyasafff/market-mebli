<?php

namespace App\Http\Controllers\Dashboard;

use App\Application;
use App\Models\Datasets\ProcessList;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ConsoleProcController extends DashboardController
{
    public function index($procId = 1, $procNum = 1)
    {
        if($setting = Setting::where('id', Setting::consoleProcFlag($procId, $procNum))->first()){
            $lastUpdate = Carbon::parse($setting->updated_at)->format('d.m.Y H:i');
        }else{
            $lastUpdate = Carbon::now()->format('d.m.Y H:i');
        }

        if(!ProcessList::checkEnv($procId)){
            return redirect()->route('dashboard.index');
        }

        if($processList = ProcessList::findById($procId)){
            $countProc = $processList['count'];
            $infoProc = $processList['name'];
            $note = !empty($processList['note']) ? $processList['note'] : '';
        }else{
            return redirect()->route('dashboard.index');
        }

        $loadavg = sys_getloadavg()[0];

        return view('dashboard.console-proc.index', compact('procId', 'procNum', 'lastUpdate', 'countProc', 'infoProc', 'note', 'loadavg'));
    }

    public function totalResult($procId, $procNum)
    {
        $logFilePath = self::logFilePath($procId, $procNum);

        $tail = shell_exec('tail -n 30 '.$logFilePath);
        $filesize = filesize($logFilePath);

        return [
            'flag' => (int)Setting::getValue(Setting::consoleProcFlag($procId, $procNum)),
            'loadavg' => implode(' | ', sys_getloadavg()).' | Log size: '.$filesize,
            'logtail' => str_replace(PHP_EOL, '<br>', Str::limit(strip_tags($tail), 100000)),
        ];
    }

    public function start($procId, $procNum)
    {
        if(Setting::checkValue(Setting::consoleProcFlag($procId, $procNum), 1)){
            return 0;
        }

        $logFilePath = self::logFilePath($procId, $procNum);

        file_put_contents($logFilePath, '');
        if($procId == 100){
            shell_exec('php '.base_path().'/artisan scout:import "App\Models\Article" >> '.$logFilePath.' &');
        }else{
            shell_exec('php '.base_path().'/artisan console-proc-'.$procId.' --procNum='.$procNum.' >> '.$logFilePath.' &');
        }

        return 1;
    }

    public function stop($procId, $procNum)
    {
        Setting::updateValue(Setting::consoleProcFlag($procId, $procNum), 0);
        return 1;
    }

    public function clearLog($procId, $procNum)
    {
        $logFilePath = self::logFilePath($procId, $procNum);
        file_put_contents($logFilePath, '');
        return 1;
    }

    //-------------------------------------------

    static function logFilePath($procId, $procNum)
    {
        $logFilePath = base_path().'/storage/logs/console_proc_'.$procId.'_'.$procNum.'.log';
        if(!file_exists($logFilePath)){
            file_put_contents($logFilePath, '');
        }
        return $logFilePath;
    }
}
