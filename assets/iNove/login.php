<?php if(!defined('wmblog'))exit; ?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title>登录_无名轻博客</title>
<link href="assets/<?php echo $template;?>/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrap">
   <?php include ("head.php");?>
  <div id="content">
    <div id="main"> 
    <form action="<?php echo $file;?>?act=dologin" method="post"><label>登陆密码：</label><input name="pass" class="pass" type="password"> <button name="login" id="login" class="btn" type="submit"> 登 陆 </button>
	</form> 
    </div>
     <?php include ("right.php");?>
  </div>
  <div id="footer"><?php include ("foot.php");?></div>
</div>
</body>
</html>