<?php
error_reporting(0);
session_start();
date_default_timezone_set('PRC');
$pass = "admin";
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__))."/");
define('ROOT_PATH',str_replace('app/class/','',BASE_PATH));
define('COSUP',0);
define('ImgW',180);
$admin = $_SESSION['admin'] == 1?1:0;
$set = getset();
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

function getset(){
  $db =new DbHelpClass(); 
  if(empty($_SESSION['set'])){
     $set = $db->getdata("select * from `Set` where id=1")[0];
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
function createImg($oldImg,$newImg,$imgInfo,$maxWidth=200,$maxHeight=200)
{
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

	$image_p = imagecreatetruecolor($maxWidth, $maxHeight);

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

	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $maxWidth, $maxHeight, $imgInfo[0], $imgInfo[1]);

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
           // $constr="DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=".realpath($path); 
            //$this->conn= new PDO("odbc:$constr") or die ("PDO Connection faild.");
			//$this->conn->prepare('set names gbk;');
			$this->conn = new PDO('sqlite:'.$path) or die ("PDO Connection faild.");

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