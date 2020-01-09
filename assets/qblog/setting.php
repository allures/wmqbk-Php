<?php if(!defined('wmblog'))exit; ?>
<?php include "head.php";?>
  <div id="content">
    <div id="main"<?php if($widget=="0") echo ' class="w100"';?> style="background:#fff;padding:15px;box-sizing:border-box;">
	<ul class="tabtitle">
	 <li class="on">博客设置</li>  
	 <li onclick="upCache()">更新缓存</li>
   </ul>
    <form id="formset" style="clear:both;margin:10px 0 0 10px;">
	<div class="s_e">
		<strong>您的昵称:</strong>
		<input type="text" class="input_narrow" name="webuser" value="<?php echo $set['webuser'];?>" maxlength="15" />
	</div>
	<div class="s_e">
		<strong>登陆密码:</strong>
		<input type="text" class="input_narrow" name="webpass" placeholder="不修改请留空" maxlength="15" />
	</div>
	<div class="s_e">
		<strong>微博标题:</strong>
		<input type="text" class="input_narrow" name="webtitle" value="<?php echo $set['webtitle'];?>" maxlength="30" />
	</div> 
		<div class="s_e">
		<strong>微博关键词:</strong>
		<input type="text" class="input_narrow" name="webkey" value="<?php echo $set['webkey'];?>" maxlength="30" />
	</div> 
		<div class="s_e">
		<strong>微博描述:</strong> 
		<textarea name="webdesc" class="input_textarea" onkeydown="if(event.keyCode==13){return false;}"><?php echo $set['webdesc'];?></textarea>
	</div> 
	<div class="s_e">
		<strong>微博座右铭:</strong> 
		<textarea name="motto" class="input_textarea" onkeydown="if(event.keyCode==13){return false;}"><?php echo $set['motto'];?></textarea>		 	 
	</div> 
	<div class="s_e">
		<strong>导航菜单:</strong> 
		<textarea name="webmenu" class="input_textarea"><?php echo $set['webmenu'];?></textarea>
	</div> 
	<div class="s_e">
		<strong>博客分类(英文逗号分隔):</strong> 
		<input type="text" name="webclass" class="input_narrow" value="<?php echo $set['webclass'];?>" /> 
	</div> 
	<div class="s_e">
		<strong>备案号:</strong>
		<input type="text" class="input_narrow" name="icp" value="<?php echo $set['icp'];?>" maxlength="30" />
	</div> 
	 <div class="s_e">
		<strong>评论微信通知Token:<span class="tips">(前往<a href="https://g.fpx.ink/" target="_blank">https://g.fpx.ink/</a>获取)</span></strong>
		<input type="text" class="input_narrow" name="token" value="<?php echo $set['token'];?>" maxlength="32" />
	</div> 
	<div class="s_e">
        <strong>其它设置:</strong>
		<span>评论审核:</span> <input type="checkbox" value="1" name="plsh" <?php if($set['plsh']==1) echo 'checked'; ?>/>
		<span>验证码:</span> <input type="checkbox" value="1" name="safecode" <?php if($set['safecode']==1) echo 'checked'; ?>/>
		<span>伪静态:</span> <input type="checkbox" value="1" name="rewrite" <?php if($set['rewrite']==1) echo 'checked'; ?>/>
		<span>边栏:</span> <input type="checkbox" value="1" name="widget" <?php if($set['widget']==1) echo 'checked'; ?>/> 
	</div>	 
	<div class="s_s">
		<button name="save" type="button"  class="btn" onclick="saveset();" /> 保存 </button>  <span id="errmsg"></span>
	</div>

	<div id="result" class="s_r"></div>
     </form>
    </div>
     <?php include ("right.php");?>
  </div>
  </div>
<?php include ("foot.php");?>
</body>
</html>