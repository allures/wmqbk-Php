<?php
header("Content-type: text/html; charset=utf-8");
require_once 'app/class/config.php';
if(!isset($_GET['up'])){
 echo '此文件升级v1.1版数据库为v1.2版，使用前请备份好网站数据。<br />';
 echo '升级步骤：<br />1.先备份v1.1数据库文件；<br />2.上传v1.2完整程序覆盖；<br />3.上传v1.1数据库覆盖，运行本程序点击下方【开始升级】即可。<br /><a href="?up=1">开始升级</a>';
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
    lock    INT (1)       DEFAULT (0) 
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
                    pass
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
                       pass
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
    webdesc  VARCHAR (255),
    plsh     INT (1),
    rewrite  INT (1),
    safecode INT (1),
    icp      VARCHAR (20),
    webmenu  TEXT
)';
$db->runsql($sql3);
$sql4 = 'INSERT INTO [Set] (
                      id,
                      webuser,
                      webtitle,
                      webdesc,
                      plsh,
                      rewrite,
                      safecode,
                      icp                   )
                  SELECT id,
                         webuser,
                         webtitle,
                         webdesc,
                         plsh,
                         rewrite,
                         safecode,
                         icp                       
                    FROM sqlitestudio_temp_table;';
$db->runsql($sql4);
$sql5 = 'DROP TABLE sqlitestudio_temp_table';
$db->runsql($sql5);
$m = '<li><a href="@index">首页</a></li><li><a href="@comment">评论</a></li>';
$db->runsql("update `Set` set webmenu='$m'");
echo '升级完成。如果一片空白，则数据没有升级成功！';