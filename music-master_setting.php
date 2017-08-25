<?php!defined('EMLOG_ROOT') && exit('access deined!');
require_once(EMLOG_ROOT.'/init.php');
function secsToStr($secs) {
    if($secs>=3600){
    $hours=floor($secs/3600);   
    $secs=$secs%3600;
    $r.=$hours;
    if($secs>0){$r.=':';}}
    if($secs>=60){
    $minutes=floor($secs/60); 
    $secs=$secs%60;
    $r.=$minutes;
    if($secs>0){$r.=':';}}
    $r.=$secs;
    return $r;
}
function playtime($time){
$playtime=substr($time,0,3);
$output = secsToStr($playtime);
return $output;
}
function plugin_setting_view(){
$db = Database::getInstance();
if(isset($_POST['stitle'])){
	$sql = " SELECT * FROM `".DB_PREFIX."music` WHERE `music_title` ='{$_POST['stitle']}' or `music_author` ='{$_POST['stitle']}' or `music_id` ='{$_POST['stitle']}' LIMIT 1";
	}else{
		$sql = " SELECT * FROM `".DB_PREFIX."music` ORDER BY `id` DESC";
	}
	$rs = $db -> query($sql);
	$totals = $db ->num_rows($rs); 
require_once('music-master_config.php');
if(isset($_POST['vid'])){
if(empty($_POST['vid'])){
echo "<script>alert('ID不能为空');location.href = document.referrer;</script>";
}
$mname = BLOG_URL."content/plugins/music-master/api.php?name={$_POST['vid']}";
$mauthor = BLOG_URL."content/plugins/music-master/api.php?author={$_POST['vid']}";
$mpic = BLOG_URL."content/plugins/music-master/api.php?pic={$_POST['vid']}";
$mtime = BLOG_URL."content/plugins/music-master/api.php?time={$_POST['vid']}";
$mlrc = BLOG_URL."content/plugins/music-master/api.php?lrc={$_POST['vid']}";
$music_title=file_get_contents($mname);
$music_author=file_get_contents($mauthor);                   
$music_time=playtime(file_get_contents($mtime));
$music_pic=file_get_contents($mpic);
$music_lrc = file_get_contents($mlrc);
}
?>
<script type="text/javascript">
$(document).ready(function(){
 $(function(){
   $('input:reset').click(function(){
     $('.clear').val("");
    });
  });
  });
$("#menu_mg").addClass('active');
$("#kmusic").addClass('active-page');
</script>
<div class="heading-bg  card-views">
<ul class="breadcrumbs">
<li><a href="./"><i class="fa fa-home"></i> 首页</a></li><li class="active">音乐收藏</li>
</ul>
</div>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default card-view">
<form  method="post" action="" >
     <div class="form-group form-inline">
        <input placeholder="添加ID" value="<?php echo $_POST['vid']; ?>" type="text" name="vid" class="form-control clear" style="width:150px;" />
        <input type="submit" class="btn btn-primary" value="获取信息">
   <input  type="reset"  class="btn btn-warning" onClick=""  value="清空"/>
        </div>
   </form>
<form action="plugin.php?plugin=music-master&action=setting&config=add&token=<?php echo LoginAuth::genToken(); ?>" method="post"   name="form" >
<div class="form-group">
	<label>音乐ID</label>
<input type="text" name="music_id" value="<?php echo $_POST['vid'] ?>" class="form-control clear" style="width:150px;" >
</div>
<div class="form-group">
	<label>歌名</label>
<input type="text" name="music_title" value="<?php echo $music_title  ?>" class="form-control clear" style="width:250px;">
</div>
<div class="form-group">
	<label>歌手</label>
<input type="text" name="music_author" value="<?php echo $music_author  ?>" class="form-control clear" style="width:250px;">
</div>
<div class="form-group">
	<label>时长</label>
<input type="text" name="music_time" value="<?php echo $music_time  ?>" class="form-control clear">
</div>
<div class="form-group">
	<label>封面</label>
<input type="text" name="music_pic" value="<?php echo $music_pic  ?>" class="form-control clear">
</div>
<div class="form-group">
	<label>歌词</label>
<textarea name="music_lrc" rows="5"  class="form-control clear"><?php echo $music_lrc  ?>
</textarea>
</div>
<div class="form-group">
   <input id="res" name="res" type="reset"  style="display:none">
 <button type="submit" class="btn btn-success" >添加音乐</button>
 </div>
</form>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default card-view">
<form action="plugin.php?plugin=music-master&action=setting&config=set" method="post"   name="form" >
<div class="form-group form-inline">
	<label>总歌曲</label>
<input type="text" name="total" value="<?php echo $totals ?>"  class="form-control" readonly="value" style="width:50px;" >
<label>每页显示</label> <input type="text" name="music_num" value="<?php echo $music_num ?>"  class="form-control" style="width:50px;" >
	<select name="music_order" class="form-control">
	<option value="DESC"  <?php if($music_order=="DESC"){?>selected="selected"<?php }?> >较新的</option>
	<option value="ASC" <?php if($music_order=="ASC"){?>selected="selected"<?php }?>>较旧的</option>
	</select>
</div>
<div class="form-group">
	<label>底部内容</label>
		<textarea name="music_ad" rows="2"  class="form-control"><?php echo $music_ad  ?>
</textarea>
</div>
<div class="form-group">
   <input id="res" name="res" type="reset"  style="display:none">
 <button type="submit" class="btn btn-info" >保存</button>
 </div>
</form>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default card-view">
<div class="form-group">
    <form action="" method="post" class="form-inline">
  <input placeholder="搜索ID/歌名/歌手" value="<?php echo $_POST['stitle']; ?>" type="text" name="stitle" class="form-control clear"  />
        <input type="submit" class="btn btn-primary" value="搜索">
           <input id="res" name="res" type="reset"  class="btn btn-warning" onClick=""  value="清空"/>
                                </form>
                                </div>
<div class="table-wrap ">
<div class="table-responsive">
<table class="table table-striped table-bordered mb-0">
<thead>
      <tr>
        <th>序号</th>
        <th>音乐ID</th>
        <th>歌曲</th>
        <th>歌手</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>             
   	<?php
while($row = $db -> fetch_array($rs)){$i++; ?>	
<tr>
       <td><?php echo $i;?></td>	
       <td><?php echo $row['music_id'];?></td>
              <td><?php echo $row['music_title'];?></td>
      <td><?php echo $row['music_author'];?></td>                     
                     <td>
 <a href="../content/plugins/music-master/do.php?dele=<?php echo $row['music_id'];?>&token=<?php echo LoginAuth::genToken(); ?>">删除</a>
                     </form>
                     </td>
                     </tr>
<?php }?>
</tbody>
 </table>
 </div>
 </div>
 </div>
 </div>
 </div>
<?php
}
function plugin_setting()
{
$config=$_GET["config"];
if($config=="set"){  
$total = isset($_POST['total']) ? addslashes(trim($_POST['total'])) : '';
$music_num = isset($_POST['music_num']) ? addslashes($_POST['music_num']) : '';
$music_ad = isset($_POST['music_ad']) ? addslashes($_POST['music_ad']) : '';
$music_order = isset($_POST['music_order']) ? addslashes($_POST['music_order']) : '';
  $data = "<?php
  \$total = '".$total."'+1;
  \$music_num = '".$music_num."';
  \$music_order = '".$music_order."';
  \$music_ad = '".$music_ad."';
  ?>";
$file = EMLOG_ROOT.'/content/plugins/music-master/music-master_config.php';
@ $fp = fopen($file, 'wb') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/music-master/music-master_config.php的权限为755或777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
@ $fw = fwrite($fp,$data) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/music-master/music-master_config.php的权限为755或777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
fclose($fp);
}
if($config=="add"){  
LoginAuth::checkToken();
$DB = Database::getInstance();
global $CACHE;
$music_id = isset($_POST['music_id']) ? addslashes($_POST['music_id']) : '';
$music_title = isset($_POST['music_title']) ? addslashes($_POST['music_title']) : '';
$music_author = isset($_POST['music_author']) ? addslashes(trim($_POST['music_author'])) : '';
$music_time = isset($_POST['music_time']) ? addslashes(trim($_POST['music_time'])) : '';
$music_pic = isset($_POST['music_pic']) ? addslashes(trim($_POST['music_pic'])) : '';
$music_lrc = isset($_POST['music_lrc']) ? addslashes(trim($_POST['music_lrc'])) : '';
$is_add_sql = $DB->query("SELECT 1 FROM ".DB_PREFIX."music WHERE music_id='".$music_id."'");
if (!$DB->num_rows($is_add_sql) && !empty($_POST['music_id'])) {
echo "<script>alert('恭喜添加该歌曲成功');location.href = document.referrer;</script>";
$DB->query(" INSERT INTO `".DB_PREFIX."music` ( `music_id`,`music_title`,`music_author`,`music_pic`,`music_time`,`music_lrc`) VALUES ( '".$music_id."','".$music_title."','".$music_author."','".$music_pic."','".$music_time."','".$music_lrc."')");
$id = $db -> insert_id();
}else{
emMsg('添加失败,该歌曲已存在数据库中','javascript:history.back(-1);');
}
}
}
?>