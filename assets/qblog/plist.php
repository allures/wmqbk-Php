<?php if(!defined('wmblog'))exit; ?>
<?php include "head.php";?>
  <div id="content">
  <div id="main">
     <div id="comments">
	    <h3>评论列表</h3>
		 <ol class="comment_list">
         <?php foreach($list as $v){ ?>
		<li class="comlist" id="Com-<?php  echo $v['id'];?>">
		<div id="Ctext-<?php  echo $v['id'];?>" class="comment">
		<div class="comment_meta">
		<cite><?php echo $v['pname'];?></cite> <span class="time"><?php echo $v['ptime']; ?></span>
		<span class="reply"><a href="<?php echo vurl($v['cid']).'#Com-'.$v['id'];?>">[查看]</a> <?php pl_admin( $v['id'], $v['cid'], $v['isn']);?></span>
		</div>
		<p><?php if($v['isn']==1 && $admin===0){echo '评论审核中...'; } else { echo $v['pcontent'];}?></p>
		<?php if($v['rcontent']<>""){?><p class="re">&nbsp;&nbsp;<strong style="color:#C00">回复</strong>：<span><?php echo $v['rcontent']; ?></span></p><?php }?>
		</div>
		</li>

       <?php } ?>
		</ol>
	 </div> 
	 <div class="pagination">
		<span class="info"> 共计：<?php echo $count; ?> 条记录 每页:<?php echo $per_page; ?>条</span><?php echo $pagelist; ?>
	</div>
	 </div>
    <?php include ("right.php");?>
  </div></div>
<?php include ("foot.php");?>
</body>
</html> 