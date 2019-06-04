<?php if(!defined('wmblog'))exit;?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php echo $tit.'_'.$webtitle;?></title>
<meta name="keywords" content="<?php echo $key;?>" />
<meta name="description" content="<?php echo $des;?>" />
<link href="assets/<?php echo $template;?>/style.css" rel="stylesheet" type="text/css" />
<?php if($tpl=='post.php'){?>
<link href="assets/js/wangeditor/css/wangEditor.min.css" rel="stylesheet" type="text/css" />
<?php }?>
</head>
<body>
<div id="wrap"> 
<div id="header"> 
  <div class="box-m">
    <div class="logo">
      <h2 id="title"><a href="./"><?php echo $webtitle;?></a></h2>   
    </div>
	<a id="menu_toggle" href="#"><i id="menu" class="iconfont menu"></i></a>
    <div id="navigation">
      <ul id="nav"> 
		<?php   
		echo $webmenu;
		if ($admin ==1) {?>
        <li><a href="<?php echo $file;?>?act=add" title="发布微博">发布</a></li>	 
		<li><a href="<?php echo $file;?>?act=set" title="设置微博">设置</a></li>
		<li><a href="<?php echo $file;?>?act=wid" title="设置边栏">边栏</a></li>
		<li><a href="<?php echo $file;?>?act=logout" title="退出">退出</a></li>
       <?php }else{ ?>
        <li><a href="<?php echo $file;?>?act=login" title="登陆到微博">登录</a></li>
	   <?php } ?>
      </ul>  
    </div>
      </div>
	  <div class="other box-m">
	   <div class="desc"><?php echo $webdesc;?></div>
	   <form method="get" class="search-form" action="<?php echo $file;?>"> <input class="search-text" name="s" autocomplete="off" placeholder="输入关键词搜索..." required="required" type="text" value="<?php echo $s;?>"> <button class="search-submit" alt="搜索" type="submit">搜索</button></form>
	   </div>   
</div>