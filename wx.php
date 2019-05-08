<?php
define('HOST','http://demo.semlog.cn/');
define('TOKEN','11111111');
require_once 'app/class/config.php';
$db = new DbHelpClass();
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$act = isset($_GET['act']) ? $_GET['act'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$cid = isset($_GET['cid'])?intval($_GET['cid']):0;
if ($token == TOKEN){
switch ($act) {
case 'set':
echo 'set';
    break;
case 'log':
	$arr['content'] = '<p>'.$_POST['content'].'</p>';	
	$arr['sum'] =  mb_substr(strip_tags($arr['content']),0,100,'utf-8'); 
	$arr['pic'] = $_POST['pic'];
	$arr['pics'] = $arr['pic'];
	$arr['fm'] = 'Ð¡³ÌÐò';
	if(!empty($arr['pic'])) $arr['content'] = $arr['content'].'<p><img src="'.$arr['pic'].'" /></p>';
    if(strpos($arr['pic'],'/b_')>1){
	   $Image = ROOT_PATH.$arr['pic'];
	   $imgInfo = @getimagesize($Image);
       $saveImage = str_replace('/b_','/s_',$Image);
	   createImg($Image,$saveImage,$imgInfo,ImgW,ImgH,1);
       $arr['pic'] = str_replace(ROOT_PATH,'',$saveImage);
    }
    $b =  $db->runsql("insert into `Log`(title,sum,content,pic,pics,fm,pass)values(:title,:sum,:content,:pic,:pics,:fm,:pass)",$arr);
    logmsg($b);
    break;
case 'delpl':
    exit();
	 $b =  $db->runsql("delete from `Pl` where id=:id",array("id"=>$id));
	 if($b){$db->runsql("update `Log` set num=num-1 where id=:id",array("id"=>$cid));} 
	break;
case 'addpl':
     $id = isset($_POST['id'])?intval($_POST['id']):0;
	 $arr['cid'] = $id;
	 $arr['pname'] = mb_substr(strip_tags(trim($_POST['pname'])),0,20,'utf-8');
     $arr['pcontent'] = mb_substr(strip_tags(trim($_POST['pcontent'])),0,250,'utf-8');
	 $arr['isn'] = $set['plsh'];
	 if($arr['pname'] == $set['webuser']){ $arr['pname']='ÍøÓÑ';} 
	 $b =  $db->runsql("insert into `Pl` (cid,pname,pcontent,isn)values(:cid,:pname,:pcontent,:isn)",$arr);
	 if($b){$db->runsql("update `Log` set num=num+1 where id=:id",array("id"=>$arr['cid']));}
	 $arr['ptime'] = date('Y-m-d H:i:s');
	 $arr['id'] = $b;
	 $v['comment'] = $arr;
    echo json_encode($v);
	break;
case 'pl':
	$v['count'] = 20;
    $v['data'] = $db->getdata("select * from `Pl` order by id desc limit 0,20", array());
        echo json_encode($v);
	break;
case 'repl':
    exit();
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $arr['id'] = $id;    
	$arr['rcontent'] = $_POST['rcontent'];
	$b =  $db->runsql("update `Pl` set rcontent=:rcontent where id=:id",$arr);
	logmsg($b);
	break;
  case 'view':
     $v['data'] = $db->getdata("select * from `Log` where id=:id", array(
            'id' => $id
        ));        
        $v['data'][0]['content'] = @str_replace("<img ", "<img style='max-width:100%;height:auto;' ", $v['data'][0]['content']); 
        $v['data'][0]['content'] = @str_replace("src=\"assets","src=\"".HOST."assets", $v['data'][0]['content']);
        $v['comment'] = $db->getdata("select * from `Pl` where cid=:id order by id desc limit 0,15", array(
            'id' => $id
        ));
        echo json_encode($v);
    break;
  case 'upload':
    $admin = 1;
    require_once 'app/class/upload.php';
    break;
default:
      $per_page = 10;
$start = $per_page * ($page - 1);
        $v['count'] = $db->total('`Log`');
        $v['data'] = $db->getdata("select * from `Log` order by ist desc,atime desc limit $start,$per_page", array());
         echo json_encode($v);

}
} 