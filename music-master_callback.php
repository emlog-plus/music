<?php
 !defined('EMLOG_ROOT') && exit('access deined!');
function callback_init()
{      
global $CACHE;
$DB = Database::getInstance();
$inDB = $DB->query("SELECT 1 FROM ".DB_PREFIX."navi WHERE url='".BLOG_URL."?plugin=music-master'");
if (!$DB->num_rows($inDB)) {
$DB->query("INSERT INTO ".DB_PREFIX."navi (naviname, url, newtab, hide, taxis, isdefault) VALUES('音乐', '".BLOG_URL."?plugin=music-master', 'n', 'n', 1, 'n')");
$dbcharset = 'utf8';
$type = 'MYISAM';
$add = $DB->getMysqlVersion() > '4.1' ? "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";":"TYPE=".$type.";";
$sql = "
CREATE TABLE `".DB_PREFIX."music` (
`id` int(10) unsigned NOT NULL auto_increment,
`music_id` varchar(255) NOT NULL,
`music_title` varchar(255) NOT NULL,
`music_author` varchar(255) NOT NULL,
`music_pic` varchar(255) NOT NULL,
`music_time` varchar(200) NOT NULL,
`music_lrc` text,
PRIMARY KEY  (`id`)
)".$add;
$DB->query($sql);
} else {
	$DB->query("UPDATE ".DB_PREFIX."navi SET hide='n' WHERE url='".BLOG_URL."?plugin=music-master'");
	       $dbcharset = 'utf8';
		$type = 'MYISAM';
		$add = $DB->getMysqlVersion() > '4.1' ? "ENGINE=".$type." DEFAULT CHARSET=".$dbcharset.";":"TYPE=".$type.";";
		$sql = "
CREATE TABLE `".DB_PREFIX."music` (
`id` int(10) unsigned NOT NULL auto_increment,
`music_id` varchar(255) NOT NULL,
`music_title` varchar(255) NOT NULL,
`music_author` varchar(255) NOT NULL,
`music_pic` varchar(255) NOT NULL,
`music_time` varchar(200) NOT NULL,
`music_lrc` text,
PRIMARY KEY  (`id`)
)".$add;
$DB->query($sql);
	}
	$CACHE->updateCache('navi');
}

function callback_rm(){
	global $CACHE;
	$DB = Database::getInstance();
	$DB->query("UPDATE ".DB_PREFIX."navi SET hide='y' WHERE url='".BLOG_URL."?plugin=music-master'");
       $query = $DB->query("DROP TABLE IF EXISTS ".DB_PREFIX."music");
      $CACHE->updateCache('navi');
}
?>