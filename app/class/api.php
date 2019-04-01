<?php
require_once 'config.php';
$c = isset($_GET['act'])?$_GET['act']:'';
$d = isset($_GET['d'])?$_GET['d']:'';
$p = isset($_GET['p'])?intval($_GET['p']):1;
$id = isset($_REQUEST['id'])?intval($_REQUEST['id']):0;
$db =new DbHelpClass(); 

 if($c == 'dellog'){
	 chkadm();  
	 $b =  $db->runsql("delete from `Log` where id=:id",array("id"=>$id));
     $b =  $db->runsql("delete from `Pl` where cid=:id",array("id"=>$id));
	 logmsg($b);
}

 if($c == 'addpl'){	 
	 $code = $_POST['scode'];
	 if($set['safecode'] ==1){
	   if($code!=$_SESSION['code']){
	      logmsg(0,'验证码错误！');
	   }
	 }
	 $arr['cid'] = $id;
	 $arr['pname'] = mb_substr(strip_tags(trim($_POST['pname'])),0,20,'utf-8');
     $arr['pcontent'] = mb_substr(strip_tags(trim($_POST['plog'])),0,250,'utf-8');
	 $arr['isn'] = $set['plsh'];
	 if($admin !=1){
	    if($arr['pname'] == $set['webuser']){ $arr['pname']='网友';}
	 }
	 $b =  $db->runsql("insert into `Pl` (cid,pname,pcontent,isn)values(:cid,:pname,:pcontent,:isn)",$arr);
	 if($b){$db->runsql("update `Log` set num=num+1 where id=:id",array("id"=>$arr['cid']));}
	 $arr['ptime'] = date('Y-m-d H:i:s');
	 $str = '<div class="comlist" id="Com-'.$b.'"><div id="Ctext-'.$b.'"><p><strong>'.$arr['pname'].'</strong>：'.$arr['pcontent'].'</p>
				</div><p class="time">'.$arr['ptime'].'</p>';
      if($_SESSION['admin']==1) $str = $str.'<p class="navPost"><a href="javascript:void(0)" onclick="repl(\''.$b.'\',\''.$arr['cid'].'\')" title="回复评论">回复</a>&nbsp;<a href="javascript:void(0)" onclick="delpl(\''.$b.'\',\''.$arr['cid'].'\')" class="item">删除</a></p>';	
				$str = $str.'</div>';
     setcookie('pname',$arr['pname'],time()+3600*24*30,'/');
	 logmsg($b,$str);

}

 if($c == 'shpl'){
	chkadm();
    $b = $db->runsql("update `Pl` set isn=0 where id=:id",array("id"=>$id));
	logmsg($b);
 }

if($c == 'plsave'){
	$arr['id'] = $id;
	$arr['rcontent'] = $_POST['rlog'];
	$b =  $db->runsql("update `Pl` set rcontent=:rcontent where id=:id",$arr);
	logmsg($b);
}

if($c == 'ckpass'){
	$ps = isset($_POST['ps'])?$_POST['ps']:'';     
	$rs =  $db->getdata("select content,pass from `Log` where id=:id",array('id'=>$id));
	$_ps = $rs[0]['pass'];
	//print_r($rs);
	if($_ps==$ps){
	logmsg(1,$rs[0]['content']);
	}else{
	logmsg(0,'密码错误！');
	}
	
}

 if($c == 'delpl'){
	 chkadm(); 
	 $cid = isset($_GET['cid'])?intval($_GET['cid']):0;
	 $b =  $db->runsql("delete from `Pl` where id=:id",array("id"=>$id));
	 if($b){$db->runsql("update `Log` set num=num-1 where id=:id",array("id"=>$cid));} 
	 logmsg($b);
} 

if($c=='saveset'){
   chkadm(); 
   $arr = $_POST; 
   $_SESSION['set'] = '';
   $b =  $db->runsql("update `Set` set webuser=:webuser,webtitle=:webtitle,webdesc=:webdesc,plsh=:plsh,rewrite=:rewrite,safecode=:safecode,icp=:icp where id=1",$arr);
   logmsg($b);
}

if($c=='savewid'){
   chkadm(); 
   $arr = $_POST;   
   if($id >0){
	  $arr['id'] = $id;
      $b =  $db->runsql("update `Wid` set title=:title,html=:html,ord=:ord where id=:id",$arr);	
   }else{	 
	  $b =  $db->runsql("insert into `Wid`(title,html,ord)values(:title,:html,:ord)",$arr); 	 
   }
   logmsg($b);
}

if($c=='delwid'){
	chkadm();
	if($id>4){
     $b =  $db->runsql("delete from `Wid` where id=:id",array('id'=>$id));
     logmsg($b);
	}
}

if($c=='savelog'){
	chkadm();  
	$arr['content'] = $_POST['logs'];	
	$arr['sum'] = strip_tags($_POST['sum']);	
	$arr['title'] = $_POST['tit'];
	$arr['pass'] = $_POST['pass'];
	$arr['pic'] = $_POST['pic'];
	$c = $_POST['c'];	
	 
	  if(empty($arr['sum'])){
		  if(empty($arr['pass'])){
		      $arr['sum'] = mb_substr(strip_tags($arr['content']),0,100,'utf-8');
		   }else{
		      $arr['sum'] = '这是一篇密码日志！';
		  }
	    
	  }
 
	if(!empty($arr['pic'])){
	   if(COSUP == 0){
	   if(strpos($arr['pic'],'/b_')>1){
	   $Image = ROOT_PATH.$arr['pic'];
	   $imgInfo = @getimagesize($Image);
       $saveImage = str_replace('/b_','/s_',$Image);
	   createImg($Image,$saveImage,$imgInfo,ImgW,ImgH,1);
       $arr['pic'] = str_replace(ROOT_PATH,'',$saveImage);
		   }
	   }
	}
	if($c=='add'){
    $arr['fm'] = '网页';
	$b =  $db->runsql("insert into `Log`(title,sum,content,pic,fm,pass)values(:title,:sum,:content,:pic,:fm,:pass)",$arr);
	}else{
		$arr['id'] = $id;
		$arr['atime'] = $_POST['atime'];
		//print_r($arr);
	    $b =  $db->runsql("update `Log` set title=:title,sum=:sum,content=:content,pic=:pic,pass=:pass,atime=:atime where id=:id",$arr);
	}
	logmsg($b);
}

if($c == 'zdlog'){
	  chkadm();
	  $arr['id'] = $id;
      $arr['ist'] = intval($d);
      $b = $db->runsql("update `Log` set ist=:ist where id=:id",$arr);
      $msg = $d==0?'置顶':'取消';
	  logmsg($b,$msg);
}  


function chkadm(){
  if($_SESSION['admin']!=1){
     exit('0');
  }
}

function logmsg($b,$msg='操作成功！'){
    if($b>0){
	   $arr['result'] = 200;
	   $arr['message'] = $msg;
	}else{
	    $arr['result'] = 500;
		if(empty($msg)){
		  $arr['message'] = '操作失败！';
		}else{
	      $arr['message'] = $msg;
		}
	}
	echo json_encode($arr);exit();
}