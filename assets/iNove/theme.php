 <?php
function topic($n){
	global $db;
	$str = '';
    $rs =  $db->getdata("select id,title,sum,num from `Log` order by num desc limit 0,$n");
	foreach($rs as $v){	
		if(empty($v['title'])){
		  $title = mb_substr(strip_tags($v['sum']),0,14,'utf-8');
		}else{
		   $title = $v['title'];
		}
	  $str .= '<li><a href="'. vurl($v['id']) .'">'.$title.'</a> ('.$v['num'].')</li>';
	}
   return $str;
}

function comment($n){
  	global $db,$template;
	$str = '';
    $rs =  $db->getdata("select id,cid,pname,pcontent,rcontent,isn from `Pl` order by id desc limit 0,$n");
	foreach($rs as $v){	
		if($v['isn'] == 1){
		  $pcontent = '评论审核中';
		}else{
		  $pcontent = mb_substr($v['pcontent'],0,12,'utf-8');
		}
	  $str .= '<li><a href="'. vurl($v['cid']) .'#Com-'.$v['id'].'"><strong>'.$v['pname'].'</strong> : '.$pcontent.'</a>';

	  if(!empty($v['rcontent'])) {$str .= ' <img title="已回复" src="assets/'.$template.'/images/reply.gif" width="10" height="10" />';}
       $str .='</li>';
	}
   return $str;
} 

function pl_str($id,$pname,$pcontent,$ptime){
  $pl_tpl = '<div class="comlist" id="Com-%s"><div id="Ctext-%s"><p><strong>%s</strong>：%s</p></div><p class="time">%s</p></div>';
  return sprintf($pl_tpl,$id,$id,$pname,$pcontent,$ptime);
}

 function timeago($ptime) {
        $ptime = strtotime($ptime);
        $etime = time() - $ptime;
        if($etime < 1) return '刚刚';
        $interval = array (
            12 * 30 * 24 * 60 * 60  =>  '年前 ('.date('Y-m-d', $ptime).')',
            30 * 24 * 60 * 60       =>  '个月前 ('.date('m-d', $ptime).')',
            7 * 24 * 60 * 60        =>  '周前 ('.date('m-d', $ptime).')',
            24 * 60 * 60            =>  '天前',
            60 * 60                 =>  '小时前',
            60                      =>  '分钟前',
            1                       =>  '秒前'
        );
        foreach ($interval as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . $str;
            }
        }
}
?>