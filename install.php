<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<title>无名轻博客安装程序</title>
<style>
*{font-size:14px;}
.green{color:green;}
.red{color:red;}
</style>
</head>
<body>
<div style="padding:150px 0 0 0;line-height:30px;width:480px;margin:0 auto">
<?php
echo '<p class="red">注意：如果从V2.0升级请先运行<a href="uptov3.php">升级程序</a>后再安装</p><p>检测结果：</p>';
$odb = 'app/db/log3.db';
$cfg = 'app/class/app.php';
$upd = './assets/file/';
$err = 0;
if(is_writable($odb))
  {
  echo '<p class="green">数据库可写！[√]</p>';
  }
else
  {
	echo '<p class="red">'.$odb.'数据库不可写！[×]</p>';
    $err++;
  }
if(is_writable($cfg))
  {
    echo '<p class="green">配置文件可写！[√]</p>';
  }
else
  {
	echo '<p class="red">'.$cfg.'配置文件不可写！[×]</p>';
    $err++;
}
if(is_writable($upd))
  {
    echo '<p class="green">上传目录可写！[√]</p>';
  }
else
  {
	echo '<p class="red">'.$upd.'上传目录不可写！[×]</p>';
    $err++;
}
if($err>0){exit('权限不足，无法安装');}
if(isset($_GET['up']) && $_GET['up']=='1' ){
if (file_exists($odb)) {  
//更改密码：
$p = isset($_GET['p']) ? $_GET['p'] : '';
if(empty($p)){
  $p='admin';
}
$key =  md5(time().'WMQBK3');
$db = substr($key,16,12);;
$key = substr($key,10,6);
$key = 'WMQBK3_'.$key;
//echo $key.'</p>';
//echo $db;
$f = file_get_contents($cfg);
$f = preg_replace("/define\('KEY','.+?'\);/i","define('KEY','{$key}');",$f);
$f = preg_replace("/define\('DB',.+?;/i","define('DB',ROOT_PATH.'app/db/{$db}.db');",$f);
$f = str_replace('if(!defined("INSTALL")){@header("Location:install.php");exit();}',"define('INSTALL','TRUE');",$f);
$webpss = md5(md5($key.$p));
//修改数据库及配置文件
 rename($odb,"app/db/{$db}.db");
 $f = file_put_contents($cfg,$f);
 require_once $cfg;
 $db = new DbHelpClass();
 $sql = "update [set] set webpass='{$webpss}' where id=1";
 $db->runsql($sql); 
 //@session_destroy();
   $_SESSION[KEY.'set'] = array();
   $_SESSION[KEY.'admin'] = 1;
   //@unlink ($odb);
   @unlink ('install.php');
   @header('Location:index.php?act=set');  
 exit();
 }else{
    exit ('已经运行过安装程序！');
 }
}else{
   echo '<form action="install.php" method="get">  
  <p>设置密码: <input type="text" placeholder="留空为admin" name="p" />
  <input type="hidden" name="up" value="1" />
  <input type="submit" value="开始安装" /></p>
   </form>';
} 
?>
</div>
</body>
</html>