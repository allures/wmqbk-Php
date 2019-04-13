<?php if(!defined('wmblog'))exit; ?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title><?php echo $btn; ?>微博_无名轻博客</title>
<link href="assets/<?php echo $template;?>/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrap">
   <?php include "head.php";?>
  <div id="content">
    <div id="main">      
	 <div class="ef"><input class="log" size="40" name="tit" id="tit" value="<?php echo @$v['title']; ?>" placeholder="标题 (可为空)" type="text">
	 
	 <?php if($act ==='edit'){?>
	 <input class="log" size="20" name="atime" id="atime" value="<?php echo $v['atime']; ?>" type="text">
      <?php }?>	 
	 </div>
	 <div class="ef"><textarea name="sum" placeholder="描述，为空自动提取" rows="2" id="sum" class="log addlog"><?php echo @$v['sum']; ?></textarea></div>
	 <div class="ef"><textarea name="log" rows="12" id="log" class="log addlog"><?php echo @$v['content']; ?></textarea><input name="c" id="c" value="<?php echo $act; ?>" type="hidden"><input name="id" id="id" value="<?php echo @$id; ?>" type="hidden"></div>	 
	 <input name="pic" id="pic" type="hidden" value="<?php echo @$v['pic'];?>" /> 	  
	 <div class="scrollCon">	 
	 <ul id="piclist">	
	 <li><img data="nopic" src="assets/<?php echo $template;?>/images/nopic.png" /></li>
		<?php
		 if($act == 'edit'){
		$pics = empty($v['pics'])?array():explode(',',$v['pics']);	 
        foreach($pics as $kk=>$ss){			 
		  echo str_replace('b_','s_',$ss)==$v['pic']?'<li class="picls pick"><img src="'.$ss.'" /></li>':'<li class="picls"><img src="'.$ss.'" /></li>';		   
		}
	    }else{
		$pics = array();
		}
		?>
	 </ul>
	 </div>
	 <div class="ef"><input maxlength="8" name="pass" id="pass" class="log" placeholder="密码" value="<?php echo @$v['pass'];?>" type="text" /></div>	  
	 <button name="add" id="addpost" onclick="savelog();" class="btn"> <?php echo $btn; ?> </button> 
    </div>
     <?php include ("right.php");?>
  </div>
  <div id="footer"><?php include ("foot.php");?></div>
</div>
<script type="text/javascript" language="javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/edit/nicEdit.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/ajax.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/laydate/laydate.js"></script>
<script>
var pic_arr = <?php echo json_encode($pics);?>; 
new nicEditor({iconsPath : 'assets/js/edit/nicEditorIcons.gif',fullPanel : true}).panelInstance('log');
<?php
if($act=='edit'){echo "laydate.render({elem:'#atime',type:'datetime'});";}
?>
function up_callback(P){
   pic_arr.push(P.replace(/http.+?com/,""));
   $('#piclist').append('<li class="picls"><img src="'+P.replace(/http.+?com/,"")+'"></li>');
}
$("#piclist").on("click",'li',function(){
	var img = $(this).find("img").attr("src");
	var data = $(this).find("img").attr("data");
	if(data == 'nopic'){$('#pic').val('');}else{$('#pic').val(img);}
	$(this).addClass('pick').siblings('li').removeClass('pick');	
});
</script>
</body>
</html>