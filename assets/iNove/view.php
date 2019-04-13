<?php if(!defined('wmblog'))exit; ?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php echo $title;?>_<?php echo $webtitle;?></title>
<meta name="keywords" content="微博,日志,无名" />
<meta name="description" content="<?php echo $sum;?>" />
<link href="assets/<?php echo $template;?>/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrap">
  <?php include "head.php";?>
  <div id="content">
    <div id="main">         
<div id="log-<?php echo $v['id'];?>" class="boxPost">
<?php if ($v['title']<>"") echo '<h1>'.$title.'</h1>';?>
<div class="textPost"><?php  if($v['pass']==""){echo $v['content']; }else { echo '<span style="color:red;">这是一篇密码日志！</span><br /><input placeholder="请输入密码..."  type="password" value="" id="password" class="pass" /> <button class="btn" onclick="ckpass(\''.$v['id'].'\');" />确认</button>';}?></div><p class="time"><?php  echo $v['atime']?> 通过 <?php echo $v['fm']?> </p>
<p class="navPost">  
	<?php  view_admin($v['id'],$v['ist']);?>
</p></div>  
   <div id="comment_list" class="comment_list">
        <?php  foreach($list as $v){?>
		<div class="comlist" id="Com-<?php  echo $v['id'];?>"><div id="Ctext-<?php  echo $v['id'];?>"><p><strong><?php  echo $v['pname'];?></strong>：<?php if($v['isn']==1 && $admin===0){echo '评论审核中...'; } else { echo $v['pcontent'];}?></p>
		<?php if($v['rcontent']<>""){?><p class="re">&nbsp;&nbsp;<strong style="color:#C00">回复</strong>：<span><?php echo $v['rcontent']; ?></span></p><?php }?>
		</div><p class="time"><?php echo $v['ptime']; ?></p><p class="navPost"><?php pl_admin( $v['id'], $v['cid'], $v['isn']);?></p></div>
       <?php } ?>
    </div>	
	 <a name="pl"></a><p><input name="pname" tabindex="1" placeholder="您的昵称" id="pname" type="text" class="log" value="<?php echo @$_COOKIE['pname'];?>" maxlength="10" /></p><p><textarea tabindex="2" placeholder="随便说点什么吧..." name="plog" rows="3" id="plog" class="log"></textarea></p>
	 <?php  if($safecode==1){?>
	 <p id="codep"><input type="text" id="safecode" placeholder="右侧计算答案" name="safecode" autocomplete="off" class="log" value=""/> <img src="app/class/codes.php" id="codeimg" style="cursor:pointer" alt="更换一道题！" onclick="reloadcode()"/></p>
	 <?php }?>
	 <p><button name="add" onClick="addpl('<?php echo $id;?>','<?php echo $safecode;?>')" id="add" class="btn"> 提 交 </button> <button name="bck" onClick="history.back();" id="bck" class="btn"> 返 回 </button></p> 
    </div>
    <?php include ("right.php");?>
  </div>
  <div id="footer"><?php include "foot.php";?></div>
</div>
<script type="text/javascript" language="javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/ajax.js"></script>
</body>
</html>