<?php if(!defined('wmblog'))exit; ?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title>首页_<?php echo $webtitle;?></title>
<meta name="keywords" content="无名微博,微博,无名的碎语,asp微博" />
<meta name="description" content="致力于为您提供快速、稳定，且在使用上又极其简单、舒适的个人微博服务。" />
<link href="assets/<?php echo $template;?>/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrap">
   <?php include "head.php";?>
  <div id="content">
    <div id="main">
   <?php foreach($list as $v){ ?>	 
      <div id="log-<?php echo $v['id']; ?>" class="boxPost">
	  <?php if($v['title']<>""){?><div class="textTitle"><a href="<?php echo vurl($v['id']); ?>"><strong><?php echo $v['title'];?></strong></a></div><?php } ?>
	  <?php if($v['pic']<>""){ ?><div class="textPic"><img src="<?php echo $v['pic'];?>?<?php echo ImgW; ?>" /></div><?php } ?>
	  <div class="textPost"><?php echo $v['sum']; ?></div>	  
	  <div class="textNav">
	  <p class="time"><?php echo timeago($v['atime']);?> 通过<?php echo $v['fm']; ?> <?php if($v['ist']==1){ ?><img width="31" title="置顶" style="vertical-align: middle;"  src="assets/<?php echo $template;?>/images/zd.gif" /><?php } ?></p>
      <p class="navPost"><a href="<?php echo vurl($v['id']);?>">评论(<?php echo  $v['num']; ?>)</a> 
	<?php  view_admin($v['id'],$v['ist'],0);?>
</p></div></div> 
 
<?php } ?>
	<div id="pager">
		<span class="info"> 共计：<?php echo $count; ?> 条记录 每页:<?php echo $per_page; ?>条</span><?php echo $pagelist; ?>
	</div>
    </div> 
	<?php include ("right.php");?>
  </div>
  <div id="footer"><?php include "foot.php";?></div>
</div>
<script type="text/javascript" language="javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/ajax.js"></script>
</body>
</html>