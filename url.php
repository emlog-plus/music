<?php
// If you installed via composer, just use this code to requrie autoloader on the top of your projects.
require 'Meting.php';

// Or require file
// require 'Meting.php';

// Using Metowolf namespace
use Metowolf\Meting;

// Initialize to netease API
$API = new Meting('netease');
if($_GET['vid']!=''){ 
$musicId = $_GET['vid']; 
// Get data
$musicJson = $API->format(true)->lyric($musicId);
// Enjoy
$data=json_decode($musicJson);
header('Content-type: application/json; charset=UTF-8');
echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
}
if($_GET['url']!=''){ 
$musicId = $_GET['url']; 
$musicJson = $API->format(true)->url($musicId);
$data=json_decode($musicJson);

$mp3 =$data->url;
$mp3 =preg_replace('/m8/','m7',$mp3);
header('Content-Type: text/plain'); 
header('Location: ' . $mp3);
}
if($_GET['lrc']!=''){ 
$musicId = $_GET['lrc']; 
$musicJson = $API->format(true)->lyric($musicId);
$data=json_decode($musicJson);
$mp3_lrc =$data->lyric;
echo $mp3_lrc ;
}
