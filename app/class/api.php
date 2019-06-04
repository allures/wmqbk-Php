<?php
require_once 'config.php';
$c = isset($_GET['act'])?$_GET['act']:'';
$d = isset($_GET['d'])?$_GET['d']:'';
$p = isset($_GET['p'])?intval($_GET['p']):1;
$id = isset($_REQUEST['id'])?intval($_REQUEST['id']):0;
$db = new DbHelpClass();

switch ($c) {

case 'dellog':
	 chkadm();
     $data = $db->getdata("select `pic`,`pics` from `Log` where id=:id", array(
            'id' => $id
     ));
	 $b =  $db->runsql("delete from `Log` where id=:id",array("id"=>$id));     
     $b =  $db->runsql("delete from `Pl` where cid=:id",array("id"=>$id));
	 delpic($data[0]['pics']);
	 delpic($data[0]['pic']);
	 logmsg($b);
break;

case 'addpl': 	 
	 if($set['safecode'] ==1){
	   $code = $_POST['scode'];
	   if($code!=$_SESSION['code']){
	      logmsg(0,'验证码错误！');
	   }
	 }
     $v = $db->getdata("select id from `Log` where id=:id",array('id'=>$id));
	 if(empty($v) || $v['lock']==1 || $v['hide']==1){
	   logmsg(0,'评论失败！');
	 } 
	 $arr['cid'] = $id;
	 $arr['pname'] = mb_substr(strip_tags(trim($_POST['pname'])),0,20,'utf-8');
     $arr['pcontent'] = mb_substr(strip_tags(trim($_POST['plog'])),0,250,'utf-8');
	 if(empty($arr['pname']) or empty($arr['pcontent'])) logmsg(0,'昵称/内容为空！');
	 $arr['isn'] = $set['plsh'];
	 if($admin !=1){
	    if($arr['pname'] == $set['webuser']){ $arr['pname']='网友';}
	 }
	 $b =  $db->runsql("insert into `Pl` (cid,pname,pcontent,isn)values(:cid,:pname,:pcontent,:isn)",$arr);
	 if($b){$db->runsql("update `Log` set num=num+1 where id=:id",array("id"=>$arr['cid']));}
	 $arr['ptime'] = date('Y-m-d H:i:s');
	 $str = pl_str($b,$arr['pname'],$arr['pcontent'],$arr['ptime']);
     setcookie('pname',$arr['pname'],time()+3600*24*30,'/');
	 logmsg($b,$str);
break;

case 'shpl':
	chkadm();
    $b = $db->runsql("update `Pl` set isn=0 where id=:id",array("id"=>$id));
	logmsg($b);
break;

case 'plsave':
	chkadm();    
	$arr['id'] = $id;
	$arr['rcontent'] = $_POST['rlog'];
	$b =  $db->runsql("update `Pl` set rcontent=:rcontent,isn=0 where id=:id",$arr);
	logmsg($b);
break;

case 'ckpass':
	$ps = isset($_POST['ps'])?$_POST['ps']:'';     
	$rs =  $db->getdata("select content,pass from `Log` where id=:id",array('id'=>$id));
	$_ps = $rs[0]['pass'];
	//print_r($rs);
	if($_ps==$ps){
	logmsg(1,$rs[0]['content']);
	}else{
	logmsg(0,'密码错误！');
	}
	
break;

case 'delpl':
	 chkadm(); 
	 $cid = isset($_GET['cid'])?intval($_GET['cid']):0;
	 $b =  $db->runsql("delete from `Pl` where id=:id",array("id"=>$id));
	 if($b){$db->runsql("update `Log` set num=num-1 where id=:id",array("id"=>$cid));} 
	 logmsg($b);
break;

case 'saveset':
   chkadm(); 
   $arr = $_POST; 
   $_SESSION['set'] = '';
   $b =  $db->runsql("update `Set` set webuser=:webuser,webtitle=:webtitle,webdesc=:webdesc,plsh=:plsh,rewrite=:rewrite,safecode=:safecode,icp=:icp,webmenu=:webmenu where id=1",$arr);
   logmsg($b);
break;

case 'savewid':
   chkadm(); 
   $arr = $_POST;   
   if($id >0){
	  $arr['id'] = $id;
      $b =  $db->runsql("update `Wid` set title=:title,html=:html,type=:type,ord=:ord where id=:id",$arr);	
   }else{	 
	  $b =  $db->runsql("insert into `Wid`(title,html,type,ord)values(:title,:html,:type,:ord)",$arr); 	 
   }
   logmsg($b);
break;

case 'delwid':
	chkadm(); 
	if($id>4){
     $b =  $db->runsql("delete from `Wid` where id=:id",array('id'=>$id));
     logmsg($b);
	}
break;
case 'delpic':
	chkadm();
	$pic = $_POST['pic'];
    delpic($pic);
break;
case 'savelog':
	chkadm();  
	$arr['content'] = $_POST['logs'];	
	$arr['sum'] = strip_tags($_POST['sum']);	
	$arr['title'] = $_POST['tit'];
	$arr['pass'] = $_POST['pass'];
	$arr['pic'] = $_POST['pic'];
    $arr['pics'] = $_POST['pics'];
	$arr['hide'] = $_POST['hide'];
	$arr['lock'] = $_POST['lock'];
	$c = $_POST['c'];	
	 
	  if(empty($arr['sum'])){
		  if(empty($arr['pass'])){
		      $arr['sum'] = mb_substr(strip_tags($arr['content']),0,100,'utf-8');
			  if(empty($arr['sum'])){
			     if(strpos($arr['content'],'<img' === FALSE)){
					 $arr['sum'] = '#分享';
				 }else{
				     $arr['sum'] = '#图片分享';
				 }
			  }
		   }else{
		      $arr['sum'] = '这是一篇密码日志！';
		  }
	    
	  } 
 
	if($c=='add'){
    $arr['fm'] = agent();
	$b =  $db->runsql("insert into `Log`(title,sum,content,pic,pics,fm,pass,hide,lock)values(:title,:sum,:content,:pic,:pics,:fm,:pass,:hide,:lock)",$arr);	 
	}else{
		$arr['id'] = $id;
		$arr['atime'] = $_POST['atime'];
	    $b =  $db->runsql("update `Log` set title=:title,sum=:sum,content=:content,pic=:pic,pics=:pics,pass=:pass,atime=:atime,hide=:hide,lock=:lock where id=:id",$arr);
		if($b==1) $b=$id;
	}
	logmsg($b);
break;

case 'zdlog':
	  chkadm();
	  $arr['id'] = $id;
      $arr['ist'] = intval($d);
      $b = $db->runsql("update `Log` set ist=:ist where id=:id",$arr);
      $msg = $d==0?'置顶':'取消';
	  logmsg($b,$msg);
break;

default:
   logmsg(0);
}
//end switch