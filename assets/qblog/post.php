<?php if(!defined('wmblog'))exit; ?>
<?php include "head.php";?>
  <div id="content">
    <div id="main"<?php if($widget=="0") echo ' class="w100"';?> style="background:#fff;padding:15px;box-sizing:border-box;">  
	<form id="post">
	 <div class="ef"><input class="input_narrow" size="40" name="title" id="title" value='<?php echo @$vv['title']; ?>' placeholder="标题 (可为空)" type="text"></div>
	 <?php if($act ==='edit'){?>
	 <div class="ef"><input class="input_narrow" size="20" name="atime" id="atime" value="<?php echo $vv['atime']; ?>" type="text"> </div>
      <?php }?>	
	 <div class="ef"><div rows="12" id="log"><?php echo @$vv['content']; ?></div></div>	 
	 <div class="ef"><div id="picup">
     <img style="display:none" id="pic" width="90" height="60">上传缩略图	
	 <span id="delpic">删除</span>
	 <input id="upload-input" type="file" accept="image/*" onchange="showImg(this)" />
	 </div>	
	 </div>	
	 <div class="ef">
      <select name="tid" class="select"> 
	  <?php foreach ($class as $k=>$s){?>
	  <option value="<?php echo $k; ?>" <?php if($vv['tid']==$k) echo 'selected';?>><?php echo $s; ?></option>
     <?php }?>	
	 </select>
     </div>
	 <div class="ef"><input class="input_narrow" size="40" name="key" id="key" value='<?php echo @$vv['key']; ?>' placeholder="关键词 (可为空)" type="text"></div>
	 <div class="ef"><textarea name="sum" placeholder="描述，为空自动提取" rows="2" id="sum" class="input_textarea"><?php echo @$vv['sum']; ?></textarea></div>
	 <div class="ef"><input maxlength="8" name="pass" id="pass" class="input_narrow" placeholder="密码" value="<?php echo @$vv['pass']; ?>" type="text" /></div>	 
	  <div class="ef"><input type="checkbox" name="hide" id="hide" <?php if(@$vv['hide']==1) echo 'checked'; ?>/> 私密 <input name="lock" type="checkbox" id="lock" <?php if(@$vv['lock']==1) echo 'checked'; ?>/> 禁评</div>
	  <input name="c" id="c" value="<?php echo $act; ?>" type="hidden">
	 <input name="id" id="id" value="<?php echo $id; ?>" type="hidden"><button type="button" id="addpost" onclick="savelog();" class="btn"> <?php echo $tit; ?> </button> <span id="errmsg"></span>
	 </form>
    </div>
     <?php include ("right.php");?>
  </div>
  </div>
<?php include ("foot.php");?>
<script type="text/javascript" src="assets/js/wangeditor/wangEditor.min.js"></script>
<?php if($act ==='edit'){?>
<script type="text/javascript" language="javascript" src="assets/js/laydate/laydate.js"></script>
<?php }?>
<script>
var apic = 0;
var act = 'thum';
<?php if($act=='edit'){echo "laydate.render({elem:'#atime',type:'datetime'});";}?>
function delpic(e){
   var p = e.attr('src');
   $.post("app/class/ajax.php?act=delpic", {pic: p}, function(ret){}, 'json');
}
 var pics = '<?php echo @$vv['pics'];?>'; 
 var pic_arr = pics==''?[]:pics.split(',');
 var upic = '<?php echo @$vv['pic'];?>';
 var editor=new wangEditor('log');
 editor.config.menuFixed = false;
 editor.config.menus=['source','bold','strikethrough','eraser','forecolor','quote','alignleft','aligncenter','alignright','link','unlink','img','video','insertcode',];
 editor.config.uploadImgUrl = 'app/class/upload.php';
 editor.config.uploadImgFileName = 'picture'
 editor.config.uploadImgFns.onload = function (resultText, xhr) {
        //var originalName = editor.uploadImgOriginalName || '';  
        var obj = JSON.parse(resultText);
		if(obj.error == 0){
		  pic_arr.push(obj.url);	
		 if (upic=='' && apic==0)
		 {
            $.get("./app/class/ajax.php?act=thum&d="+obj.url,function(data){if(data.result=='200'){ 			
			    upic = data.message;
                $("#pic").attr("src",upic).show();
			    $('#delpic').show();
			}else{alert(data.message);}},'json');
		 }
		 apic++;
         editor.command(null, 'insertHtml', '<img src="' + obj.url + '" style="max-width:100%;"/>');
		}else{
		 alert(obj.message);
		}
 };
 editor.create();
 if(upic!=''){
   $("#pic").attr("src",upic).show()
   $('#delpic').show()
 }
 $('#delpic').on('click',function() {//绑定鼠标划出事件
   delpic($("#pic"));
   upic = '';
   $("#pic").attr("src",'').hide();
   $('#delpic').hide()
});
function showImg(input) {
		 var fd = new FormData();
        fd.append("picture",input.files[0]);
		$.ajax({
            url: 'app/class/upload.php?act=thum',
            type: 'post',
			dataType:'json',
            processData: false,
            contentType: false,
            data: fd,
            success: function (ret) {	
                upic = ret.url
                $("#pic").attr("src",upic).show();
			    $('#delpic').show()
            }
        }) 
}
 </script>
</body>
</html>