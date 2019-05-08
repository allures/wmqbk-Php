<?php
header("Content-type: text/html; charset=utf-8");
require_once 'app/class/config.php';
if(!isset($_GET['up'])){
echo '此文件升级v1.0预览版数据库为v1.0正式版，使用前请备份好数据库文件。<br />';
echo '<a href="?up=1">开始升级</a>';
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
    pic     VARCHAR (50),
    pics    VARCHAR (500),
    fm      VARCHAR (20),
    atime   DATETIME      DEFAULT (datetime(\'now\', \'localtime\') ),
    ist     INT (1)       DEFAULT (0),
    num     INTEGER       DEFAULT (0),
    pass    VARCHAR (32) 
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
					   pic as pics,
                       fm,
                       atime,
                       ist,
                       num,
                       pass
                  FROM sqlitestudio_temp_table';
$db->runsql($sql4);
$sql5 = 'DROP TABLE sqlitestudio_temp_table';
$db->runsql($sql5);
echo '升级完成';