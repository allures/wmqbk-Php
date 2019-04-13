<?php if(!defined('wmblog'))exit; ?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title>设置_无名轻博客</title>
<link href="assets/<?php echo $template;?>/style.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<div id="wrap">
    <?php include "head.php";?>
  <div id="content">
    <div id="main">
	<ul class="tabtitle">
	 <li class="on">博客设置</li>  
   </ul>
    <form id="formset" style="clear:both;margin:10px 0 0 10px;">
	<div class="s_e">
		<strong>您的昵称:</strong>
		<input type="text" class="input_narrow" name="webuser" value="<?php echo $set['webuser'];?>" maxlength="15" />
	</div>
	<div class="s_e">
		<strong>微博标题:</strong>
		<input type="text" class="input_narrow" name="webtitle" value="<?php echo $set['webtitle'];?>" maxlength="30" />
	</div> 
	<div class="s_b">
		<strong>微博说明:</strong>
		<textarea name="webdesc" class="input_textarea" onkeydown="if(event.keyCode==13){:return false;}"><?php echo $set['webdesc'];?></textarea>
	</div> 
	<div class="s_e">
		<strong>备案号:</strong>
		<input type="text" class="input_narrow" name="icp" value="<?php echo $set['icp'];?>" maxlength="30" />
	</div> 
	<div class="s_d">
		<span>评论状态:</span>
		<select name="plsh" class="select"> 
           <option value="0" <?php if($set['plsh']== 0) echo 'selected';?>>开放</option> 
           <option value="1" <?php if($set['plsh']== 1) echo 'selected';?>>审核</option>	 
		</select>
	</div>
	<div class="s_d">
		<span>验证开关:</span>
		<select name="safecode" class="select">	 
           <option value="0" <?php if($set['safecode']== 0) echo 'selected';?>>关闭</option> 
           <option value="1" <?php if($set['safecode']== 1) echo 'selected';?>>打开</option>  
		</select>
	</div> 
	<div class="s_d">
		<span>静态组件:</span>
		<select name="rewrite" class="select">		
           <option value="0" <?php if($set['rewrite']== 0) echo 'selected';?>>关闭</option> 
           <option value="1" <?php if($set['rewrite']== 1) echo 'selected';?>>支持</option>	 
		</select> Rewrite等伪静态组件
	</div>
	<div class="s_s">
		<button name="save" type="button"  class="btn" onclick="saveset();" /> 保存 </button>  
	</div>

	<div id="result" class="s_r"></div>
     </form>
    </div>
     <?php include ("right.php");?>
  </div>
  <div id="footer"><?php include ("foot.php");?></div>
</div>
<script type="text/javascript" language="javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/ajax.js"></script>
</body>
</html>