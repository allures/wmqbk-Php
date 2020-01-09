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
define('INSTALL','TRUE');
echo '<p>此文件升级v2.0版数据库为v3版，请备份好网站数据并真阅读升级步骤！！！<br />';
 echo '升级步骤：<br />1.把v2.0数据库命名为log.db(如果你没更名忽略)<br />2.上传V3程序覆盖，运行本程序点击下方【开始升级】即可。<br /><a href="?up=1">开始升级</a></p>';
if(!isset($_GET['up'])){ 
   exit();
}
if (file_exists('app/db/log.db')) { 
   @unlink ('app/db/log3.db');
   echo '删除V3版本数据库<br />';
   rename('app/db/log.db','app/db/log3.db');
   echo '更名V2版本数据库为log3.db<br />';
   echo '开始升级...<br />';
}else{
   exit('V2.0数据库(app/db/log.db)文件丢失！');
}
require_once 'app/class/app.php';
if (file_exists('app/db/log3.db')) {  
  $db = new DbHelpClass('app/db/log3.db');
}else{
  exit('app/db/log3.db文件丢失！');
}
$sql1 = 'CREATE TABLE sqlitestudio_temp_table AS SELECT * FROM Log';
$db->runsql($sql1);
$sql2 = 'DROP TABLE Log';
$db->runsql($sql2);
$sql3 = 'CREATE TABLE Log (
    id      INTEGER       PRIMARY KEY AUTOINCREMENT,
    title   VARCHAR (100),
    [key]   VARCHAR (100),
    sum     VARCHAR (200),
    content TEXT,
    pic     VARCHAR (200),
    pics    VARCHAR (500),
    fm      VARCHAR (20),
    atime   DATETIME      DEFAULT (datetime(\'now\', \'localtime\') ),
    ist     INT (1)       DEFAULT (0),
    num     INTEGER       DEFAULT (0),
    pass    VARCHAR (32),
    hide    INT (1)       DEFAULT (0),
    lock    INT (1)       DEFAULT (0),
    tid     INT (2)       DEFAULT (0),
    pv      INTEGER       DEFAULT (0) 
)';
$db->runsql($sql3);
$sql4 = 'INSERT INTO Log (
                    id,
                    title,
					[key],
                    sum,
                    content,
                    pic,
					pics,
                    fm,
                    atime,
                    ist,
                    num,
                    pass,
					hide,
                    lock,
					tid
                )
                SELECT id,
                       title,
					   [key],
                       sum,
                       content,
                       pic,
					   pics,
                       fm,
                       atime,
                       ist,
                       num,
                       pass,
					   hide,
                       lock,
					   tid
                  FROM sqlitestudio_temp_table';
$db->runsql($sql4);
$sql5 = 'DROP TABLE sqlitestudio_temp_table';
$db->runsql($sql5);

$sql1 = 'CREATE TABLE sqlitestudio_temp_table AS SELECT * FROM [Set]';
$db->runsql($sql1);
$sql2 = 'DROP TABLE [Set]';
$db->runsql($sql2);
$sql3 = 'CREATE TABLE [Set] (
    id       INT (1),
    webuser  VARCHAR (10),
    webtitle VARCHAR (20),
    webkey   VARCHAR (100),
    webpass  VARCHAR (32),
    webdesc  VARCHAR (255),
    webmenu  TEXT,
    webclass VARCHAR (100),
    plsh     INT (1),
    rewrite  INT (1),
    safecode INT (1),
    icp      VARCHAR (20),
    widget   INT (1)       DEFAULT (1),
    motto    VARCHAR (255),
    token    CHAR (32) 
)';
$db->runsql($sql3);
$sql4 = 'INSERT INTO [Set] (
                      id,
                      webuser,
                      webtitle,
                      webkey,
                      webpass,
                      webdesc,
                      webmenu,
                      webclass,
                      plsh,
                      rewrite,
                      safecode,
                      icp,
                      widget,
                      motto                       
                  )
                  SELECT id,
                         webuser,
                         webtitle,
                         webkey,
                         webpass,
                         webdesc,
                         webmenu,
                         webclass,
                         plsh,
                         rewrite,
                         safecode,
                         icp,
                         widget,
                         "接受失败，但不选择放弃！" as motto                        
                    FROM sqlitestudio_temp_table';
$db->runsql($sql4);
$sql5 = 'DROP TABLE sqlitestudio_temp_table';
$db->runsql($sql5);



$sql1 = 'CREATE TABLE sqlitestudio_temp_table AS SELECT * FROM Pl';
$db->runsql($sql1);
$sql2 = 'DROP TABLE Pl';
$db->runsql($sql2);
$sql3 = 'CREATE TABLE Pl (
    id       INTEGER       PRIMARY KEY AUTOINCREMENT,
    cid      INTEGER,
    pname    VARCHAR (20),
    pcontent VARCHAR (300),
    rcontent VARCHAR (100),
    ptime    DATETIME      DEFAULT (datetime(\'now\', \'localtime\') ),
    isn      INT           DEFAULT (0),
    purl     VARCHAR (50) 
)';
$db->runsql($sql3);
$sql4 = 'INSERT INTO Pl (
                   id,
                   cid,
                   pname,
                   pcontent,
                   rcontent,
                   ptime,
                   isn 
               )
               SELECT id,
                      cid,
                      pname,
                      pcontent,
                      rcontent,
                      ptime,
                      isn 
                 FROM sqlitestudio_temp_table';
$db->runsql($sql4);
$sql5 = 'DROP TABLE sqlitestudio_temp_table';
$db->runsql($sql5);
$_SESSION[KEY.'set'] = '';
//$m = '<li><a href="@index">首页</a></li><li><a href="@comment">评论</a></li>';
//$db->runsql("update `Set` set webmenu='$m'");
echo '升级完成！ 请运行<a href="install.php">安装程序</a>';
@unlink ('uptov3.php');
?>
</div>
</body>
</html>