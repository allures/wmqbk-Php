<?php if(!defined('wmblog'))exit; ?>
<?php include "head.php";?>
  <div id="content">
    <div id="main" style="background:#fff;padding:15px;box-sizing:border-box;">      
	 <div class="ef"><input class="input_narrow" size="40" name="tit" id="tit" value="<?php echo @$v['title']; ?>" placeholder="标题 (可为空)" type="text">	  </div>
	 <?php if($act ==='edit'){?>
	 <div class="ef"><input class="input_narrow" size="20" name="atime" id="atime" value="<?php echo $v['atime']; ?>" type="text"> </div>
      <?php }?>	 	
	 <div class="ef"><textarea name="sum" placeholder="描述，为空自动提取" rows="2" id="sum" class="input_textarea"><?php echo @$v['sum']; ?></textarea></div>
	 <div class="ef"><div name="log" rows="12" id="log" class="nicEdit-main input_textarea"><?php echo @$v['content']; ?></div><input name="c" id="c" value="<?php echo $act; ?>" type="hidden"><input name="id" id="id" value="<?php echo $id; ?>" type="hidden"></div>	 	  
	 <div class="scrollCon ef">	 
	 <ul id="piclist">	
	 <!--<li><span class="iconfont" style="color:#ccc;font-size:40px;line-height:66px;position: relative;">&#xe604<input style="position: absolute;left: 0px;top: 0px;opacity: 0;width: 100%;height: 100%;" type="file" accept="image/*"></span></li>-->
		<?php
		 if($act == 'edit'){
		$pics = empty($v['pics'])?array():explode(',',$v['pics']);	 
        foreach($pics as $kk=>$ss){			 
		  echo str_replace('b_','s_',$ss)==$v['pic']?'<li class="picls pick"><img src="'.$v['pic'].'" /><i class="iconfont">&#xe635</i></li>':'<li class="picls"><img src="'.$ss.'" /><i class="iconfont">&#xe635</i></li>';		   
		}
	    }else{
		$pics = array();
		}
		?>
	 </ul>
	 </div>
	  <input name="pic" id="pic" type="hidden" value="<?php echo @$v['pic'];?>" /> 
	 <div class="ef"><input maxlength="8" name="pass" id="pass" class="input_narrow" placeholder="密码" value="<?php echo @$v['pass']; ?>" type="text" /></div>	  
	 <button name="add" id="addpost" onclick="savelog();" class="btn"> <?php echo $tit; ?> </button> <span id="errmsg"></span>
    </div>
     <?php include ("right.php");?>
  </div>
  </div>
<?php include ("foot.php");?>
<script type="text/javascript" src="assets/js/edit/nicEdit.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/laydate/laydate.js"></script>
<script>
var pic_arr = <?php echo json_encode($pics);?>; 
var ndPanel  = new nicEditor({iconsPath : 'assets/js/edit/nicEditorIcons.gif',fullPanel : true,xhtml:true,maxHeight:300}).panelInstance('log');
<?php
if($act=='edit'){echo "laydate.render({elem:'#atime',type:'datetime'});";}
?>
function up_callback(P){   
   pic_arr.push(P.replace(/http.+?com/,""));
   var slt = $('#piclist').append('<li class="picls"><img src="'+P+'"><i class="iconfont">&#xe635</i></li>'); 
   if(pic_arr.length==1){
      $('#piclist li img').click();
   }
}
$("#piclist").on("click",'img',function(){
	var img = $(this).attr("src");
	$('#pic').val(img==$('#pic').val()?'':img);
	$(this).parent().toggleClass('pick').siblings('li').removeClass('pick');	
});
$("#piclist").on("click",'i',function(){
    var img = $(this).siblings('img').attr("src");
	if(img==$('#pic').val()){
	   $('#pic').val('')
	}
    $(this).parent().remove();   
	var bimg = img.replace('s_','b_');
    var index = pic_arr.indexOf(bimg); 
    if (index>-1) { 
      pic_arr.splice(index, 1); 
    }	
	$('.nicEdit-main').find('img').filter('[src="'+bimg+'"]').remove();
    $.post("./app/class/api.php?act=delpic", {pic:img}, function(data) {if(data.result=='200'){}else{alert(data.message);}},'json')	 
});
</script>
</body>
</html>