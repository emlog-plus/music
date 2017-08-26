<?php
!defined('EMLOG_ROOT') && exit('access deined!');
require_once('music-master_config.php');
global $CACHE;
$options_cache = $CACHE->readCache('options');
$DB = Database::getInstance();
$num_page=$music_num; 
if (isset($_GET['page'])) { 
$page=max(1,intval($_GET['page']));
 } else { 
 $page=1;
  }; 
$start_from = ($page-1) * $num_page; 
$sql = " SELECT `id`,`music_id`,`music_title`,`music_author`,`music_time`,`music_pic`,`music_lrc` FROM `".DB_PREFIX."music` ORDER BY `id` ".$music_order." LIMIT ".$start_from.", ".$num_page."";
$rs_result = $DB -> query($sql); 
$res = $DB->once_fetch_array("SELECT naviname, hide FROM ".DB_PREFIX."navi WHERE url='".BLOG_URL."?plugin=music-master'");
$blogname = $options_cache['blogname'];
$site_title = $res['naviname'].' - '.Option::get('blogname');
$log_title = $res['naviname'];
$site_description = $bloginfo = Option::get('bloginfo');
$site_key = Option::get('site_key');
$istwitter = Option::get('istwitter');
$comments = array("commentStacks" => array());
$ckname = $ckmail = $ckurl = $verifyCode = false;
$icp = Option::get('icp');
$footer_info = Option::get('footer_info');
include View::getView('header');
?>
<div class="play">
<div id="player" class="aplayer"></div>
</div>
<div class="js_tab" id="index_tab">
          <table class="table table-striped table-hover ">
        <thead><tr><th style="width:18px">序号</th><th style="width:20%">歌曲</th><th style="width:20%">歌手</th><th style="width:15%">时长</th><th style="width:5px">试听</th><th style="width:5px">下载</th></tr></thead>
        <tbody>
   	<?php
   	while($row = $DB -> fetch_array($rs_result))         {$start_from++;?>
<tr id="id_<?php echo $start_from ?>">
<td class="info" data-title="<?php echo $row['music_title'] ?>" data-author="<?php echo $row['music_author'] ?>" data-url="<?php echo BLOG_URL;?>content/plugins/music-master/music_go.php?urls=<?php echo $row['id'] ?>" data-pic="<?php echo BLOG_URL;?>content/plugins/music-master/music_go.php?pic=<?php echo $row['id'] ?>" data-lrc="<?php echo $row['music_lrc'] ?>" >
</td>
<td style="width:2px"><?php echo $start_from ?></td>
<td style="width:5%"><?php echo $row['music_title'] ?></td>
<td style="width:20%"><?php echo $row['music_author'] ?></td>
<td style="width:15%"><?php echo $row['music_time'] ?></td>
<td style="width:5px">
<i class="iconfont margin_left" onclick="play(<?php echo $start_from ?>);"></i></td>
<td style="width:5px"><a href="<?php echo BLOG_URL;?>content/plugins/music-master/music_go.php?urls=<?php echo $row['id'] ?>" target="_blank"><i class="iconfont"></i></a>
</td>
</tr>
<?php };?>
</tbody>
</table>
</div> 
<p class="center" style="padding-top:10px;text-align: center;"><?php echo $music_ad ?></p>
<div id="pagenav">
<?php 
$sql = "SELECT * FROM " . DB_PREFIX . "music " ;
$rs_result =  $DB->query($sql); 
$total_records =  $DB->num_rows($rs_result);  
$total_pages = ceil($total_records / $num_page);  
for ($i=1; $i<=$total_pages; $i++) { 
if($i==$page){
 echo "<span>".$i."</span>"; 
}else{
 echo "<a href='?plugin=music-master&page=".$i."'>".$i."</a> "; 
}
}; 
?>
</div>
<link href="<?php echo BLOG_URL;?>content/plugins/music-master/music-master.css?ver=1680" type="text/css" rel="stylesheet">
<script>
var ap;
function play(id){
      if ($(".aplayer-music").length > 0)
        {
	      ap.pause();
        };
	var music = {
	     "url": $("#id_"+id+" .info").data("url"),
            "title": $("#id_"+id+" .info").data("title"),
            "author": $("#id_"+id+" .info").data("author"),
            "pic": $("#id_"+id+" .info").data("pic"),
            "lrc": $("#id_"+id+" .info").data("lrc"),
        };
ap = new APlayer({
        element: document.getElementById("player"),
        narrow: false,
        autoplay: false,
        preload: false,
        mutex: true,        
        showlrc: 1,
        theme: "#999",
        preload: "metadata",
        music: music,        
        });
       $(".aplayer-play").trigger("click");              
       ap.on('ended', function() {
if(id < <?php echo $start_from ?>){
       id=id+1;      
       return play(id);
       }
       });
}; 
</script>           
<?php
include View::getView('footer');
?>
            
