<?php
error_reporting(E_ALL);
require_once 'fson.php';
$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
function curl($url){
	$curl = curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,30);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt ($curl, CURLOPT_REFERER, "http://music.163.com/");
	curl_setopt($curl, CURLOPT_USERAGENT,  "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.157 Safari/537.36");    
	$src = curl_exec($curl);
	curl_close($curl);    
	return $src;
}
if($_GET["name"]){
$id = $_GET["name"];
$output=curl('https://music.163.com/api/song/detail/?id=' . $id . '&ids=%5B' . $id . '%5D');
$output_arr = $json->decode($output);
$mp3_name = $output_arr["songs"][0]["name"];
header('Content-Type: text/plain'); 
echo $mp3_name;
}
if($_GET["author"]){
$id = $_GET["author"];
$output=curl('https://music.163.com/api/song/detail/?id=' . $id . '&ids=%5B' . $id . '%5D');
$output_arr = $json->decode($output);
$mp3_author = $output_arr["songs"][0]["artists"][0]["name"];
header('Content-Type: text/plain'); 
echo $mp3_author;
}
if($_GET["pic"]){
$id = $_GET["pic"];
$output=curl('https://music.163.com/api/song/detail/?id=' . $id . '&ids=%5B' . $id . '%5D');
$output_arr = $json->decode($output);
$mp3_pic = $output_arr["songs"][0]["album"]["picUrl"];
header('Content-Type: text/plain'); 
echo $mp3_pic;
}
if($_GET["lrc"]){
$id = $_GET["lrc"];
$output=curl('https://music.163.com/api/song/lyric/?os=pc&id=' . $id . '&lv=-1&kv=-1&tv=-1');
$output_arr  = $json->decode($output);
 if ( $output_arr['code'] == 200 && isset($output_arr['lrc']['lyric']) && $output_arr['lrc']['lyric'] ){
$mp3_lrc = $output_arr['lrc']['lyric'];
header('Content-Type: text/plain'); 
echo $mp3_lrc;
}else{
echo '暂时还没有歌词';
}
}
if($_GET["time"]){
$id = $_GET["time"];
$output=curl('https://music.163.com/api/song/detail/?id=' . $id . '&ids=%5B' . $id . '%5D');
$output_arr = $json->decode($output);
$mp3_time = $output_arr["songs"][0]["duration"];
header('Content-Type: text/plain'); 
echo $mp3_time;
}
