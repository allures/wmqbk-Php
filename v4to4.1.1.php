<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<title>无名轻博客安装程序</title>
<style>
body {
background: #444;
font-family: "Lucida Sans Unicode", Helvetica, "Microsoft Yahei", "Microsoft JhengHei", STHei, "Meiryo UI";
height:100%;color:#fff
}
a{color:#fff}

.abt{border: 1px solid #EFEFEF;
border-radius: 5px;
padding: 6px;
cursor: pointer; background: #fff;color:#000}
.txt{}
.green{color:green;}
.red{color:red;}
.ft{margin-top:40px;}
</style>
</head>
<body>

<div style="padding:100px 0 0 0;line-height:30px;width:750px;margin:0 auto">
<h1>欢迎使用</h1>
<p class="txt">无名轻博客是一款基于PHP+Sqlite的简单易用的个人微博系统(miniblog)。致力于为您提供快速、稳定，且在使用上又极其简单、舒适的博客服务。</p>
<?php
function endfoot(){
     echo '<p class="ft" align="center">Powered by <a href="https://fpx.ink/" target="_blank">无名轻博客</a> V4 ,  Design by <a href="https://www.4jax.net/" target="_blank">www.4jax.net</a></p>';
     exit('</div></body></html>');  
}
if(!isset($_GET['up'])){ 
echo '<p>此文件升级v4.0-v4.1版数据库为v4.1.1版，请备份好网站数据并真阅读升级步骤！！！<br />';
echo '升级步骤：1.上传V4.1.1程序(除数据库、config.php外)覆盖，运行本程序点击下方【开始升级】即可。<br /><br /><a class="abt" href="?up=1">开始升级</a></p>';
   endfoot();
}else{
include 'app/class/app.php';
$db = new DbHelpClass();
$sql1 = 'CREATE TABLE sqlitestudio_temp_table AS SELECT * FROM [Set]';
$db->runsql($sql1);
$sql2 = 'DROP TABLE [Set]';
$db->runsql($sql2);
$sql3 = 'CREATE TABLE [Set] (
    id       INT (1),
    webuser  VARCHAR (10),
    webmail  VARCHAR (30),
    webtitle VARCHAR (20),
    webkey   VARCHAR (100),
    webpass  VARCHAR (32),
	lstr  VARCHAR (20),
    webdesc  VARCHAR (255),
    webmenu  TEXT,
    webclass VARCHAR (100),
    plsh     INT (1),
    rewrite  INT (1),
    safecode INT (1),
    page     INTEGER,
    width    INTEGER,
    icp      VARCHAR (20),
    foot     TEXT,
    widget   INT (1)       DEFAULT (1),
    motto    VARCHAR (255),
    ver      CHAR (5) 
)';
$db->runsql($sql3);
$sql4 = 'INSERT INTO [Set] (
                      id,
                      webuser,
                      webtitle,
                      webkey,
                      webpass,
                      lstr,
                      webdesc,
                      webmenu,
                      webclass,
                      plsh,
                      rewrite,
                      safecode,
                      page,
                      width,
                      icp,
                      foot,
                      widget,
                      motto,
                      ver
                  )
                  SELECT id,
                         webuser,
                         webtitle,
                         webkey,
                         webpass,
						 "" as lstr,
                         webdesc,
                         webmenu,
                         webclass,
                         plsh,
                         rewrite,
                         safecode,
                         20 as page,
                         600 as width,
                         icp,
                         "<script>//统计代码</script>" as foot,
                         widget,
                         motto,
                         "4.1.1" as ver
                    FROM sqlitestudio_temp_table';
$db->runsql($sql4);
$sql5 = 'DROP TABLE sqlitestudio_temp_table';
$db->runsql($sql5); 
$_SESSION[$key.'set'] = '';
//$m = '<li><a href="@index">首页</a></li><li><a href="@comment">评论</a></li>';
//$db->runsql("update `Set` set webmenu='$m'");
echo '升级完成！';
echo '<p><a class="abt" href="index.php?ok">开始使用</a></p>';
@unlink ('v4to4.1.1.php'); endfoot();
}
?>
 