<?php if(!defined('WMBLOG'))exit;?>
<!DOCTYPE HTML>
<html>
<html>
<head>
<meta charset="utf-8" />
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<meta name="applicable-device"content="pc,mobile">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title><?php echo $tit.'_'.$webtitle;?></title>
<meta name="keywords" content="<?php echo $key;?>" />
<meta name="description" content="<?php echo $des;?>" />
<meta name="robots" content="index,follow" />
<meta name="applicable-device"content="pc,mobile">
<!-- og tag -->
<meta property="og:type" content="article"/>
<meta property="og:title" content="<?php echo $tit.'_'.$webtitle;?>">
<meta property="og:type" content="article"/>
<meta property="og:site_name" content="<?php echo $webtitle;?>" />
<meta property="og:description" content="<?php echo $des;?>">
<meta property="og:url" content="<?php echo $url;?>"> 
<meta property="article:tag" content="<?php echo $key;?>" />
<!-- QQ Browser optimization -->
<meta itemprop="description" content="<?php echo $des;?>">
<link href="assets/<?php echo TEMPLATE;?>/style.css?v=4.0" rel="stylesheet" type="text/css" />
<?php if($tpl=='post.php'){?>
<link href="https://cdn.jsdelivr.net/gh/allures/wmqbk-Php@master/assets/js/wangeditor/css/wangEditor.min.css" rel="stylesheet" type="text/css" />
<?php }?>
<?php if($tpl=='view.php'){?>
<link href="https://cdn.jsdelivr.net/gh/allures/wmqbk-Php@master/assets/js/highlightjs/dark.css" rel="stylesheet" type="text/css" />
<?php }?>
</head>
<body>
<div id="header"> 
<a id="menu_toggle" href="#"><i id="menu" class="iconfont menu"></i></a>  
<div class="navbar-wrap">
  <div class="box-m">
    <div class="logo">
      <h1 id="title"><a href="./"><?php echo $webtitle;?></a></h1>   
    </div>	   
      <ul id="nav" class="collapse"> 
		<?php webmenu();?>
      </ul>   
      </div>
</div>
<div class="other-wrap collapse">
	  <div class="other box-m">
	   <div class="desc"><?php echo $motto;?></div>
<form method="get" class="search-form" action="<?php echo $file;?>"><input class="search-text" name="s" autocomplete="off" placeholder=" " required="required" type="text" value="<?php echo $s;?>"><button class="search-submit" alt="搜索" type="submit">search</button></form>
</div>
</div>
</div>
<div id="wrap"> 
