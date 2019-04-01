<?php
$t1 = microtime(true);
require_once 'app/class/config.php';
require_once 'app/class/page.php';
$template = 'assets/templete/';
$db =new DbHelpClass();
function vurl($id){
   global $rewrite;
   $url =  $rewrite?'post-'.$id.'.html':'?act=pl&id='.$id;
   return $url;
}
function topic($n){
	global $db;
	$str = '';
    $rs =  $db->getdata("select id,title,sum,num from `Log` order by num desc limit 0,$n");
	foreach($rs as $v){	
		if(empty($v['title'])){
		  $title = mb_substr(strip_tags($v['sum']),0,15,'utf-8');
		}else{
		   $title = $v['title'];
		}
	  $str .= '<li><a href="'. vurl($v['id']) .'">'.$title.'</a> ('.$v['num'].')</li>';
	}
   return $str;
}
function comment($n){
  	global $db;
	$str = '';
    $rs =  $db->getdata("select id,cid,pname,pcontent,isn from `Pl` order by id desc limit 0,$n");
	foreach($rs as $v){	
		if($v['isn'] == 1){
		  $pcontent = '评论审核中';
		}else{
		  $pcontent = mb_substr($v['pcontent'],0,15,'utf-8');
		}
	  $str .= '<li><a href="'. vurl($v['cid']) .'"><strong>'.$v['pname'].'</strong> : '.$pcontent.'</a></li>';
	}
   return $str;
}
$p = isset($_GET['p'])?intval($_GET['p']):1;
$act = isset($_GET['act'])?$_GET['act']:'';
$s = isset($_GET['s'])?$_GET['s']:'';
$id = isset($_GET['id'])?intval($_GET['id']):0;
 
 
//$set =  $db->getdata("select * from `Set` where id=1")[0];
$webtitle= $set['webtitle'];
$webdesc= $set['webdesc'];
$rewrite = $set['rewrite'];
$plsh = $set['plsh'];
$safecode = $set['safecode'];
$icp = $set['icp'];
$per_page = 20;
$start = $per_page*($p-1);
$wid =  $db->getdata("select * from `Wid` order by ord");
switch ($act) {
case 'login':
	$tpl = 'login.htm';
	break;
case 'logout':
    $_SESSION['admin'] = 0;
	header('Location:?'); 
	break;
case 'dologin':
   $ps =   isset($_POST['pass'])?$_POST['pass']:'';
   if($ps==$pass){
	   $_SESSION['admin'] = 1;
	   header('Location:?');
   }else{
      header('Location:?act=login');
   }
break;
case 'wid':
$tpl = 'widget.htm';
break;
case 'add':	 
	$btn = '发布';
	$tpl = 'post.htm';
break;
case 'edit':	
	$rs = $db->getdata("select * from `Log` where id=:id",array('id'=>$id));
$v = $rs[0];
	$btn = '编辑';
	$tpl = 'post.htm';
break;
case 'set':
	$tpl = 'setting.htm';
break;
case 'pl':
$rs = $db->getdata("select * from `Log` where id=:id",array('id'=>$id));
$v = $rs[0];
$title = $v['title']==''?mb_substr(strip_tags($v['sum']),0,15,'utf-8'):$v['title'];
$sum= strip_tags($v['sum']);
$list = $db->getdata("select * from `Pl` where cid=:id",array('id'=>$id));
$tpl = 'view.htm';
break;
case 'plist':
 $count = $db->total('`Pl`');
 $list =  $db->getdata("select * from `Pl` order by id desc limit $start,$per_page",array());
$config1['base_url'] = "?p="; //当前的url，如果有参数需要拼接一下url
$config1['total_rows'] = $count; //传递总数
$config1['per_page'] = $per_page; //传递每页的数量 
$config1['cur_page'] = $p; //传递当前页码
$pageStr = new Page($config1); 
$pagelist = $pageStr->create_links(); //创建新页码
$tpl = 'plist.htm';
	break;
default:
	 if(empty($s)){
		 $count = $db->total('`Log`');
	     $list =  $db->getdata("select * from `Log` order by ist desc,id desc limit $start,$per_page",array());
	 }else{
		 $count = $db->total('`Log`',"where title like '%$s%' or content like '%$s%'");
	     $list =  $db->getdata("select * from `Log` where title like :s or content like :s order by ist desc,id desc limit $start,$per_page",array("s"=>$s));
	 }




$config1['base_url'] = "?p="; //当前的url，如果有参数需要拼接一下url
$config1['total_rows'] = $count; //传递总数
$config1['per_page'] = $per_page; //传递每页的数量 
$config1['cur_page'] = $p; //传递当前页码
$pageStr = new Page($config1); 
$pagelist = $pageStr->create_links(); //创建新页码
$tpl = 'index.htm';
}
require_once $template.$tpl;