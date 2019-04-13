<?php if(!defined('wmblog'))exit; ?><div id="header">
    <div id="caption">
      <h2 id="title"><a href="./"><?php echo $webtitle;?></a></h2>
      <div id="tagline"><?php echo $webdesc;?></div>
    </div>
    <div id="navigation">
      <ul id="nav">
	    <?php if($rewrite ==1){?>
        <li class="page_item"><a href="index.html">首页</a></li>
        <li><a href="comment.html">评论</a></li>
		<?php }else{?>
        <li class="page_item"><a href="<?php echo $file;?>">首页</a></li>
        <li><a href="<?php echo $file;?>?act=plist">评论</a></li>
		<?php }  
		 if ($admin ==1) {?>
             <li><a href="<?php echo $file;?>?act=add" title="发布微博">发布</a></li>	 
		<li><a href="<?php echo $file;?>?act=set" title="设置微博">设置</a></li>
		<li><a href="<?php echo $file;?>?act=wid" title="设置边栏">边栏</a></li>
		<li><a href="<?php echo $file;?>?act=logout" title="退出">退出</a></li>
       <?php }else{ ?>
        <li><a href="<?php echo $file;?>?act=login" title="登陆到微博">登录</a></li>
	   <?php } ?>		 
      </ul>
      <div id="other">
	   <form action="" id="searchbox" method="get"> 
         <input type="text" x-webkit-speech="" placeholder="搜索..." name="s" class="search"><button class="btn" type="submit">搜索</button>    
      </form>
      </div>
    </div>
  </div>
