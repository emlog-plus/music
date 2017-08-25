<?php
require_once('../../../init.php');
$id=$_GET['dele'];
if($id!=''){
LoginAuth::checkToken();
$db = Database::getInstance();
echo "<script>alert('删除成功');location.href = document.referrer;</script>";
$sql = " DELETE FROM `".DB_PREFIX."music` WHERE `music_id` = $id";
$db -> query($sql);
}
$ids=$_GET['update'];
if($_GET['update']){  
LoginAuth::checkToken();
$music_id = isset($_POST['music_id']) ? addslashes($_POST['music_id']) : '';
$music_title = isset($_POST['music_title']) ? addslashes($_POST['music_title']) : '';
$music_author = isset($_POST['music_author']) ? addslashes(trim($_POST['music_author'])) : '';
$music_time = isset($_POST['music_time']) ? addslashes(trim($_POST['music_time'])) : '';
$music_pic = isset($_POST['music_pic']) ? addslashes(trim($_POST['music_pic'])) : '';
$music_lrc = isset($_POST['music_lrc']) ? addslashes(trim($_POST['music_lrc'])) : '';
$DB = Database::getInstance();
$page="../../../admin/plugin.php?plugin=music-master";
echo "<script>alert('恭喜修改成功');javascript:window.location='$page';</script>";

$sql = " UPDATE `".DB_PREFIX."music` SET  `music_title` = '".$music_title."', `music_author` = '".$music_author."', `music_time` = '".$music_time."', `music_pic` = '".$music_pic."',`music_lrc` = '".$music_lrc."' WHERE `music_id` = $ids ";
$DB -> query($sql);
}
?>