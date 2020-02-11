<?php
if($_POST['kdja3djd'] != 'd38dasd'){exit();}
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $_POST['url']);
if(!empty($_POST['post'])){
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, (array)json_decode($_POST['post']));
}
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
if(!empty($_POST['timeout'])){
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $_POST['timeout']);
    curl_setopt($curl, CURLOPT_TIMEOUT, $_POST['timeout']);
}
if(!empty($_POST['headers'])) {
    curl_setopt($curl, CURLOPT_HTTPHEADER, (array)json_decode($_POST['headers']));
}
if(!empty($_POST['useragent'])){
    curl_setopt($curl, CURLOPT_USERAGENT, $_POST['useragent']);
}
$response = curl_exec($curl);
curl_close($curl);
echo $response;