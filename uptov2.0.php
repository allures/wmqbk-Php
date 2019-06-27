<?php
header("Content-type: text/html; charset=utf-8");
require_once 'app/class/app.php';
if(!isset($_GET['up'])){
 echo '此文件升级v1.2版数据库为v2.0版，使用前请备份好网站数据。<br />';
 echo '升级步骤：<br />1.先备份v1.2数据库文件,保留assets/file目录其余全部删除；<br />2.上传v2.0完整程序覆盖；<br />3.上传v1.2数据库覆盖，运行本程序点击下方【开始升级】即可。<br /><a href="?up=1">开始升级</a>';
 exit();
}
$db = new DbHelpClass();
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
    tid     INT (2)       DEFAULT (0) 
)';
$db->runsql($sql3);
$sql4 = 'INSERT INTO Log (
                    id,
                    title,
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
                    lock
                )
                SELECT id,
                       title,
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
                       lock
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
    widget   INT (1)       DEFAULT (1) 
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
                      icp                   )
                  SELECT id,
                         webuser,
                         webtitle,
						 "博客,blog" as webkey,
						 "986e130796983ccc0c0b7d5a61b40f4c" as webpass,
                         webdesc,
						 webmenu,
						 "默认分类,心情日志" as webclass,
                         plsh,
                         rewrite,
                         safecode,
                         icp                       
                    FROM sqlitestudio_temp_table;';
$db->runsql($sql4);
$sql5 = 'DROP TABLE sqlitestudio_temp_table';
$db->runsql($sql5);
$_SESSION[KEY.'set'] = '';
//$m = '<li><a href="@index">首页</a></li><li><a href="@comment">评论</a></li>';
//$db->runsql("update `Set` set webmenu='$m'");
echo '升级完成！默认密码：admin';