<?php if(!defined('WMBLOG'))exit; ?>
<?php include "head.php";?> 
<div id="content" style="position: relative;">
<div id="main"<?php if($widget=="0") echo ' class="w100"';?> style="background:#fff;padding:15px;box-sizing:border-box;">
    <div class="archivepage">    
    <?php 
    $year=0; $mon=0; $i=0; $j=0;
    $output = '<div id="archives">';
	foreach($archives as $v){
        $year_tmp = date('Y',strtotime($v['atime']));
        $mon_tmp = date('m',strtotime($v['atime']));
        $y=$year; $m=$mon;
        if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
        if ($year != $year_tmp && $year > 0) $output .= '</ul>';
        if ($year != $year_tmp) {
            $year = $year_tmp;
            $output .= '<h2>'. $year .' 年</h2><ul>'; 
        }
        if ($mon != $mon_tmp) {
            $mon = $mon_tmp;
            $output .= '<li><span><b>'. $mon .' 月</b></span><ul>'; 
        }
        $title = $v['title'] == '' ? mb_substr(strip_tags($v['sum']) , 0, 25, 'utf-8') : $v['title'];
        $output .= '<li>'.date('d日: ',strtotime($v['atime'])).'<a href="'. vurl($v['id']) .'" title="'. $title .'">'. $title .'</a> <em>('. $v['num'].' 评论)</em></li>'; 
    }
    $output .= '</ul></li></ul></div>';
    echo $output;
	
    ?>    
        <div class="clearfix"></div>
    </div>
</div>
<?php include ("right.php");?>
</div>
</div>
<?php include "foot.php";?>
<?php echo $set['foot'];?>
</body>
</html>