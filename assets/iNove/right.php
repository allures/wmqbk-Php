<?php if(!defined('wmblog'))exit; ?><div id="sidebar"> 
	  <?php foreach($wid as $v){?>
      <div class="widget">
        <h2><?php echo $v['title'];?></h2>     
		<?php if($v['html']	==='topic'){?>	 
           <ul class="topic"><?php echo topic(10);?> </ul>
	    <?php }elseif ($v['html']	==='comment'){?>
           <ul class="comment"><?php echo comment(10);?></ul>	 
		<?php }else{?>
		  <ul><?php echo $v['html'];?></ul>
		<?php } ?>
      </div>	  
	 <?php } ?>	   
</div>