<?php if(!defined('wmblog'))exit; ?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title>侧栏_无名轻博客</title>
<link href="assets/<?php echo $template;?>/style.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<div id="wrap">
   <?php include "head.php";?>
  <div id="content">
    <div id="main"> 
   <ul class="tabtitle">
	  <?php foreach($wid as $v){?><li><?php echo $v['title']; ?></li> <?php } ?>
	<li>添加边栏</li>
   </ul>
	<?php foreach($wid as $v){?>
	<div class="tabcontent" style="display:none">
     <form id="formwid<?php echo $v['id'];?>">
	<div class="s_e">
		<strong>标题:</strong>
		<input type="text" class="input_narrow" name="title" value="<?php echo $v['title']; ?>" maxlength="15" />
	</div> 
	<div class="s_h">
		<strong>代码:</strong>（系统标签支持 comment topic）
		<textarea name="html" class="input_textarea" onkeydown="if(event.keyCode==13){return false;}"><?php echo $v['html']; ?></textarea>
	</div>
	<div class="s_e">
		<strong>排序:</strong>
		<input type="text" class="input_narrow" name="ord" value="<?php echo $v['ord']; ?>" maxlength="15" />
	</div> 
	<div class="s_s">
		<button name="save" type="button"  class="btn" onclick="savewid(<?php echo $v['id']; ?>)"> 保存 </button> 
        <button name="del" type="button"  class="btn" onclick="delwid(<?php echo $v['id']; ?>)"> 删除 </button>
	</div>
	<div id="result" class="s_r"></div>
	</form>
	</div>
   <?php } ?>
   <div class="tabcontent"  style="display:none">
    <form id="formwid0">
	<div class="s_e">
		<strong>标题:</strong>
		<input type="text" class="input_narrow" name="title" value="" maxlength="15" />
	</div> 
	<div class="s_h">
		<strong>代码:</strong>（系统标签支持 comment topic）
		<textarea name="html" class="input_textarea" onkeydown="if(event.keyCode==13){return false;}"></textarea>
	</div>
	<div class="s_e">
		<strong>排序:</strong>
		<input type="text" class="input_narrow" name="ord" value="" maxlength="15" />
	</div> 
	<div class="s_s">
		<button name="save" type="button"  onclick="savewid(0)" class="btn"> 保存 </button>
	</div>
	<div id="result" class="s_r"></div>
    </form>
	</div>
    </div>
     <?php include ("right.php");?>
  </div>
  <div id="footer"><?php include ("foot.php");?></div>
</div>
<script type="text/javascript" language="javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/ajax.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function () {
$('.tabtitle li:first').addClass('on');
 $('.tabcontent').eq(0).show(200);
$('.tabtitle li').click(function () {
  var index = $(this).index();
  $(this).addClass('on').siblings('li').removeClass('on');
  $('.tabcontent').eq(index).show(200).siblings('.tabcontent').hide();
}); 
})
</script>
</body>
</html>