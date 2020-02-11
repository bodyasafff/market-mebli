<?php

function pusher_dump($data, $user_id = '', $filter = '', $comment = '')
{
    $pusher = PusherInstance::get_pusher();

    $data = print_r($data, true);

    $pusher->trigger([$user_id . '-channel'], $filter . '-event', ['comment' => $comment, 'data' => $data]);
}


function log_to_file($data, $file, $input = false)
{
    if ($data != '{"method_name":"ping","status":"success","data":1}') {
        if (!$file) {
            $file = 'null';
        } else if ($file == '*') {
            $file = 'other';
        }

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Kiev'));

        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );


        $time = $d->format('H:i:s.u');
        $date = $now->format('Y-m-d');

        $folder = '/var/www/bt2/api/application/logs/' . $date;
        $file = $folder . '/' . $file . '.php';

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $f = fopen($file, 'a');

        if ($input) {
            fwrite($f, $time . ' <<< ' . $input . ' | ' .$_SERVER['REMOTE_ADDR'] . PHP_EOL);
        }
        fwrite($f, $time . ' >>> ' . print_r($data, true) . PHP_EOL . PHP_EOL);
        fclose($f);
    }
}


