<?php if(!defined('wmblog'))exit; ?>
<?php include "head.php";?>
  <div id="content">
    <div id="main">         
<div id="article">
<?php if ($v['title']<>"") echo '<h1>'.$title.'</h1>';?>
<div class="text"><?php  if($v['pass']==""){echo $v['content']; }else { echo '<p style="color:red;">这是一篇密码日志！</p><p><input placeholder="请输入密码..." name="pass" type="password" value="" id="password" class="search-text" /> <button class="search-submit" onclick="ckpass(\''.$v['id'].'\');" />确认</button></p>';}?></div>

<p class="time clb"><?php  echo $v['atime']?> 通过 <?php echo $v['fm']?> </p>
<p class="navPost">  
	<?php  view_admin($v['id'],$v['ist']);?>
</p></div>  
   <div id="comments">
   <h3>共有<?php echo $v['num']; ?>条评论！</h3>
        <ol class="comment_list">
        <?php  $l=1;foreach($list as $v){?>
		<li class="comlist" id="Com-<?php  echo $v['id'];?>">
		<div id="Ctext-<?php  echo $v['id'];?>" class="comment">
		<div class="comment_meta">
		<cite><?php echo $v['pname'];?></cite> <span class="time"><?php echo $v['ptime']; ?></span>
		<span class="reply"><?php echo '<em>'.$l.'#</em> ';pl_admin( $v['id'], $v['cid'], $v['isn']);?></span>
		</div>
		<p><?php if($v['isn']==1 && $admin===0){echo '评论审核中...'; } else { echo $v['pcontent'];}?></p>
		<?php if($v['rcontent']<>""){?><p class="re">&nbsp;&nbsp;<strong style="color:#C00">回复</strong>：<span><?php echo $v['rcontent']; ?></span></p><?php }?>
		</div>
		</li>
       <?php $l++;} ?>
       </ol>
<div id="respond" class="comment-respond">
		<h3 id="reply-title" class="comment-reply-title">发表评论</h3>
 <a name="pl"></a>
<div class="s_e mt10"><input name="pname" tabindex="1" placeholder="您的昵称" id="pname" type="text" class="input_narrow" value="<?php echo @$_COOKIE['pname'];?>" maxlength="10" /></div>
<div class="s_e"><textarea tabindex="2" placeholder="发言要文明，评论有水平..." name="plog" rows="3" id="plog" class="input_textarea"></textarea></div>
	 <?php  if($safecode==1){?>
	 <div class="s_e"><input type="text" tabindex="3" id="safecode" placeholder="右侧计算答案" name="safecode" autocomplete="off"  class="input_narrow" value="" /> <img src="app/class/codes.php" id="codeimg" style="cursor:pointer" alt="更换一道题！" onclick="reloadcode()"/></div>
	 <?php }?>
	 <div class="s_e"><button name="add" onClick="addpl('<?php echo $id;?>','<?php echo $safecode;?>')" id="add" class="btn"> 提 交 </button> <button name="bck" onClick="history.back();" id="bck" class="btn"> 返 回 </button><span id="errmsg"></span></div>
</div>	
    </div>	
    </div>
    <?php include ("right.php");?>
  </div>
  </div>
<?php include "foot.php";?>
</body>
</html>