<?php
error_reporting(0);
session_start();
date_default_timezone_set('PRC');
$pass = "admin"; //上线前请修改密码！
$template = 'iNove'; //模板文件夹
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__))."/");
define('ROOT_PATH',str_replace('app/class/','',BASE_PATH));
define('COSUP',0);
define('ImgW',180);
define('ImgH',120);
define('ImgC','imageView2/1/w/180/h/120');
define('wmblog','TRUE');
$admin = isset($_SESSION['admin'])?$_SESSION['admin']:0;
$set = getset();
$webtitle= $set['webtitle'];
$webdesc= $set['webdesc'];
$rewrite = $set['rewrite'];
$plsh = $set['plsh'];
$safecode = $set['safecode'];
$icp = $set['icp'];
require_once ROOT_PATH.'assets/'.$template.'/theme.php';
function mkDirs($path)
{
	$array_path = explode("/",$path);

	$_path = "";
		
	for($i=0;$i<count($array_path);$i++)
	{
		$_path .= $array_path[$i]."/";

		if( !empty($array_path[$i]) && !file_exists($_path))
		{
			mkdir($_path,0777);
		}
	}
	
	return true;
}

function view_admin($id,$ist,$v=1){
global $admin;
$txt = $ist==1?'取消':'置顶';
$str = "<a id=\"zd-{$id}\" href=\"javascript:void(0)\" onclick=\"zdlog('{$id}')\">{$txt}</a>&nbsp;<a href=\"?act=edit&id={$id}\" title=\"编辑微博\">编辑</a>&nbsp;<a href=\"javascript:void(0)\" onclick=\"dellog('{$id}','1')\">删除</a>"; 
$def = $v == 1?"<a href=\"JavaScript:history.back();\">返回</a>&nbsp; <a href=\"JavaScript:DotRoll('pl')\">我要评论</a>":"";
echo $admin==1?$str:$def;
}

function pl_admin($id,$cid,$isn){
global $admin;
$str = "<a href=\"javascript:void(0)\" onclick=\"repl('{$id}','{$cid}')\" title=\"回复评论\">回复</a>&nbsp;<a href=\"javascript:void(0)\" onclick=\"delpl('{$id}','{$cid}')\" class=\"item\">删除</a>";
if($isn==1){
$str .= "&nbsp;<a id=\"sh-{$id}\" href=\"javascript:void(0)\" onclick=\"shpl('{$id}')\" class=\"item\">审核</a>";
}
echo $admin==1?$str:'';
}

function getset(){
  $db =new DbHelpClass(); 
  if(empty($_SESSION['set'])){
     $rs = $db->getdata("select * from `Set` where id=1");
     $set = $rs[0];
	 $_SESSION['set'] = $set;	 
  }else{
     $set = $_SESSION['set'];
  }
  return $set;
}

function jsmsg($n,$m){
   $arr['errno'] = $n;
   $arr['data'] = $m;
   echo json_encode($arr);
}


function vurl($id){
   global $rewrite;
   $url =  $rewrite?'post-'.$id.'.html':self().'?act=pl&id='.$id;
   return $url;
}

function self(){
    $self = $_SERVER['PHP_SELF']; 
    $php_self=substr($self,strrpos($self,'/')+1);
    return $php_self;
}

function agent(){
   if (isset($_SERVER['HTTP_USER_AGENT'])) {     
    if (preg_match("/(ios|iPad|iPhone|iPod|Android)/i", $_SERVER['HTTP_USER_AGENT'])) {
      return '手机';
    }elseif(preg_match("/(MicroMessenger)/i", $_SERVER['HTTP_USER_AGENT'])){
	  return '微信';
	}else{
	  return '网页';  
	} 
  }else{
	  return '网页';  
  } 
}

function createImg($oldImg,$newImg,$imgInfo,$maxWidth=200,$maxHeight=200,$cut=false)
{
	$_n_w = $maxWidth;
	$_n_h = $maxHeight;
	if( $maxWidth > $imgInfo[0] || $maxHeight > $imgInfo[1] )
	{
		$maxWidth = $imgInfo[0];

		$maxHeight = $imgInfo[1];
	}
	else
	{
		if ( $imgInfo[0] < $imgInfo[1] )
			$maxWidth = ($maxHeight / $imgInfo[1]) * $imgInfo[0];
		else
			$maxHeight = ($maxWidth / $imgInfo[0]) * $imgInfo[1];
	}

	$cw = 0;
	$ch = 0;
	if($cut){


  if ($maxWidth < $_n_w) { //如果新高度小于新容器高度
   $r = $_n_w / $maxWidth; //按长度求出等比例因子
   $maxWidth *= $r; //扩展填充后的长度
   $maxHeight *= $r; //扩展填充后的高度
   $ch = ($maxHeight - $_n_h) / 2; //求出裁剪点的高度
  }
  
  if ($maxHeight < $_n_h) { //如果新高度小于容器高度
   $r = $_n_h / $maxHeight; //按高度求出等比例因子
   $maxWidth *= $r; //扩展填充后的长度
   $maxHeight *= $r; //扩展填充后的高度
   $cw = ($maxWidth - $_n_w) / 2; //求出裁剪点的长度
  }	
  $image_p = imagecreatetruecolor($_n_w, $_n_h);	 
	} else{
	  $image_p = imagecreatetruecolor($maxWidth, $maxHeight);	 
	}

    
	switch($imgInfo[2])
	{
		case 1:
			$image = imagecreatefromgif($oldImg);
			break;
		case 2:
			$image = imagecreatefromjpeg($oldImg);
			break;
		case 3:
			$image = imagecreatefrompng($oldImg);
		break;
	}

	imagecopyresampled($image_p, $image, 0, 0, $cw , $ch , $maxWidth, $maxHeight, $imgInfo[0], $imgInfo[1]);

	imagejpeg($image_p, $newImg,100);

	imagedestroy($image_p);

	imagedestroy($image);

	return true;
}

class DbHelpClass
    {
        private $conn;
        private $qxId;
        private $ret;
        
        function __construct()
        {
            $path=ROOT_PATH."app/db/log.db";  
			try{
			   $this->conn = new PDO('sqlite:'.$path); 
			 }			
			catch(Exception $errinfo){
				die ("PDO Connection faild.(可能空间不支持pdo_sqlite，详细错误信息：)".$errinfo);
			}

        }
        
        /*读取*/
        function getdata($sql,$params=array())
        {
            $bind=$this->conn->prepare($sql);
            $arrKeys=array_keys($params);
            foreach($arrKeys as $row)
            {
				if(strpos($sql,"like")>-1){
				  $bind->bindValue(":".$row,'%'.$params[$row].'%');
				}else{
                  $bind->bindValue(":".$row,$params[$row]);
				}
            }
            $bind->execute();// or die('sql error:'.$sql);
            $result=$bind->fetchAll(PDO::FETCH_ASSOC);            
            return $result;
        }

        function total($tab_name,$tj='')//求总记录数目
           {
             $bind = $this->conn->prepare('SELECT count(id) as c FROM '.$tab_name.' '.$tj);
             $bind->execute();
             $result = $bind->fetchAll();
             return $result[0]['c'];
           }        
        /*添加,修改需调用此方法*/
        function runsql($sql,$params=array())
        {  
            $bind=$this->conn->prepare($sql);
            $arrKeys=array_keys($params); 
            foreach($arrKeys as $row)
            {
				 
                $bind->bindValue(":".$row,$params[$row]);
                
            }	
            $a = $bind->execute();//or die('sql error');
			if(strpos($sql,"insert")>-1){
			   return $this->conn->lastInsertId();
			}else{
              return $a;
			}
        }
    }
