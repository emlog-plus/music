<?php 
session_start();
require_once('../../../init.php');
$db = Database::getInstance();
if($_GET['urls']){
$url = $_GET['urls'];
$sql = " SELECT `music_id` FROM `".DB_PREFIX."music` WHERE `id` = '".$url."' LIMIT 1";
$rs_result = $db -> query($sql); 
if($go = $db ->fetch_array($rs_result)){
		$real_url = "http://www.sinkey.cc/music/".$go['music_id']."";
		header('Location: ' . $real_url);
	}else{
		header('HTTP/1.0 404 Not Found');
		emMsg('未找到,估计还没会地球,˚‧º·(˚ ˃̣̣̥᷄⌓˂̣̣̥᷅ )‧º·˚','javascript:history.back(-1);');
	}
}
if($_GET['pic']){
$pic=$_GET['pic'];
$sql2 = " SELECT `music_pic` FROM `".DB_PREFIX."music` WHERE `id` = '".$pic."' LIMIT 1";
$rs_r = $db -> query($sql2); 
if($po = $db ->fetch_array($rs_r)){
		$real_url = $po['music_pic'];
		header('Location: ' . $real_url);
	}else{
		header('HTTP/1.0 404 Not Found');
		emMsg('未找到,估计还没会地球,˚‧º·(˚ ˃̣̣̥᷄⌓˂̣̣̥᷅ )‧º·˚','javascript:history.back(-1);');
	}
}	
?>