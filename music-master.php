<?php
/*
Plugin Name: 简单的音乐
Version: 1.2
Plugin URL: https://crazyus.ga
Description: 我的自用音乐收藏,可插入文章-精简版
ForEmlog: 6.0+
Author:	FLYER
Author Email: gao.eison@gmail.comAuthor URL: https://crazyus.ga
 */
!defined('EMLOG_ROOT') && exit('access deined!');

function music_menu() {
    echo '<li><a href="./plugin.php?plugin=music-master" id="music">音乐收藏</a></li>';
}
addAction('adm_sidebar_ext', 'music_menu');

function music_tool(){
echo '
<script type="text/javascript">
function add(id){
var appid = $("#id_"+id+"").data("id"); 
$($(".ke-edit-iframe:first").contents().find(".ke-content")).append("<m>"+appid+"</m>");
 $("#add_music").modal("hide");
}
</script>
<a href="#add_music" data-toggle="modal">插入音乐+</a>
<div aria-hidden="true" role="dialog" tabindex="-1" id="add_music" class="modal fade" style="display: none;">		
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
<h4 class="modal-title">插入音乐</h4>
</div>
<div class="modal-body">
<div class="form-group text-center">
<label class="col-lg-2 control-label">
<sup>要想插入生效,请关闭XSS防御</sup>
</label>
</div>
<div class="table-wrap ">
<div class="table-responsive">
<table class="table table-striped table-bordered mb-0">
<thead>
      <tr>
        <th>音乐ID</th>
        <th>歌曲</th>
        <th class="tdcenter" >操作</th>
      </tr>
    </thead>
    <tbody>';             
$db = Database::getInstance();
$sql = " SELECT * FROM `".DB_PREFIX."music` ORDER BY `id` DESC";
$rs = $db -> query($sql);
while($row = $db -> fetch_array($rs)){
$i++; 
echo '<tr>
<td>'.$row['music_id'].'</td>
<td>'.$row['music_title'].'</td>
<td class="tdcenter" >
<a id="id_'.$row['id'].'" data-id="'.$row['music_id'].'"  onclick="add('.$row['id'].');"> 插入</a>
</td>
</tr>';
 }
echo '
</tbody>
 </table>
 </div>
 </div>
</div>
</div> 
 </div> 
</div>   
 ';
 }
addAction('adm_writelog_head', 'music_tool');

function music_log(){
	$log_content =  ob_get_clean();
	$log_content = preg_replace_callback("|\<m>(.*?)\</m>|is",'aplayer',$log_content);
	if(Option::get('isgzipenable') == 'y' && function_exists('ob_gzhandler')){ob_start('ob_gzhandler');}else{ob_start();}
	echo $log_content;	
}
function aplayer($match){
$content = $match[1];
$db = Database::getInstance();
$sql = " SELECT `id`,`music_title`,`music_author`,`music_pic`,`music_lrc` FROM `".DB_PREFIX."music` WHERE `music_id` = '".$content."' ";
$rs = $db -> query($sql);
$row = $db -> fetch_array($rs);
$music=array(
'title'=>''.$row["music_title"].'',
'author'=>''.$row["music_author"].'',
'pic'=>''.BLOG_URL.'content/plugins/music-master/music_go.php?pic='.$row["id"].'',
'url'=>''.BLOG_URL.'content/plugins/music-master/music_go.php?urls='.$row["id"].'',
'lrc'=>''.$row["music_lrc"].'');
$music_id= json_encode($music);
	return '
	<div id="player" class="aplayer"></div>
	<script>
        var ap = new APlayer({
        element: document.getElementById("player"),
        narrow: false,
        preload: false,
        mutex: true,
        autoplay: false,
        showlrc: 1,
        music: '.$music_id.',
        theme: "#000",
        });
    ap.init();
</script>';
}
function music_css(){
	echo '<link rel="stylesheet" href="'.BLOG_URL.'content/plugins/music-master/APlayer.min.css">';
}
function music_js(){
	echo '<script type="text/javascript" src="'.BLOG_URL.'content/plugins/music-master/APlayer.min.js"></script>';
}
addAction('index_head', 'music_css');
addAction('index_head', 'music_js');
addAction('index_footer','music_log');

