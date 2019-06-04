<?php
$t1 = microtime(true);
require 'app/class/config.php';
require 'app/class/page.php';
$db = new DbHelpClass();
$p = isset($_GET['p']) ? intval($_GET['p']) : 1;
$act = isset($_GET['act']) ? $_GET['act'] : '';
$s = isset($_GET['s']) ? htmlspecialchars($_GET['s']) : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$file = self();
$per_page = 20;
$start = $per_page * ($p - 1);
$wid = $db->getdata("select * from `Wid` order by ord");
switch ($act) {
    case 'login':
		$tit = '登陆';
        $tpl = 'login.php';
        break;

    case 'logout':
        $_SESSION[KEY.'admin'] = 0;
        header('Location:' . $file);
        break;

    case 'dologin':
        $ps = isset($_POST['pass']) ? $_POST['pass'] : '';
        if ($ps == $pass) {
            $_SESSION[KEY.'admin'] = 1;
            header('Location:' . $file);
        } else {
            header('Location:' . $file . '?act=login');
        }
        break;

    case 'wid':
		chkadm();
	    $tit = '边栏设置';
        $tpl = 'widget.php';
        break;

    case 'add':
		chkadm();
        $tit = '发布';	 
        $tpl = 'post.php';
        break;

    case 'edit':
		chkadm();
        $rs = $db->getdata("select * from `Log` where id=:id", array(
            'id' => $id
        ));
        $vv = $rs[0];
        $tit = '编辑';
        $tpl = 'post.php';
        break;

    case 'set':
		chkadm();
	    $tit = '设置';
        $tpl = 'setting.php';
        break;

    case 'pl':

        $rs = $db->getdata("select * from `Log` where id=:id", array(
            'id' => $id
        ));	
        $v = $rs[0];		
		if(empty($v)){@header("http/1.1 404 not found");@header("status: 404 not found");exit('404 not found');}
		//echo $v['hide'];exit();
		if($v['hide']=="1" && $admin==0){@header("http/1.1 404 not found");@header("status: 404 not found");exit('404 not found');}
        $title = $v['title'] == '' ? mb_substr(strip_tags($v['sum']) , 0, 15, 'utf-8') : $v['title'];
        $sum = strip_tags($v['sum']);
		if($v['lock']=="0"){
        $list = $db->getdata("select * from `Pl` where cid=:id", array(
            'id' => $id
        ));
		}
		$tit = $title;
		$des = $sum;
        $tpl = 'view.php';
        break;

    case 'plist':
        $count = $db->total('`Pl`');
        $list = $db->getdata("select * from `Pl` order by id desc limit $start,$per_page", array());
        if ($rewrite == 1) {
            $page_config['base_url'] = "comment-"; //当前的url，如果有参数需要拼接一下url
            $page_config['suffix'] = ".html"; //当前的url，如果有参数需要拼接一下url
            
        } else {
            $page_config['base_url'] = $file . "?act=plist&p="; //当前的url，如果有参数需要拼接一下url
            
        }
        $page_config['total_rows'] = $count; //传递总数
        $page_config['per_page'] = $per_page; //传递每页的数量
        $page_config['cur_page'] = $p; //传递当前页码
        $pageStr = new Page($page_config);
        $pagelist = $pageStr->create_links(); //创建新页码
		$tit = '评论列表';
        $tpl = 'plist.php';
        break;

    default:		
        if (empty($s)) {
			$where =  $admin?'':'where hide=0';
            $count = $db->total('`Log`',$where);
            $list = $db->getdata("select * from `Log` $where order by ist desc,atime desc limit $start,$per_page", array());
            $_s = '';
        } else {
			$where =  $admin?'':'and hide=0';
            $_s = 's=' . $s . '&';
            $count = $db->total('`Log`', "where (title like '%$s%' or content like '%$s%') $where");
            $list = $db->getdata("select * from `Log` where (title like :s or content like :s) $where order by ist desc,atime desc limit $start,$per_page", array(
                "s" => $s
            ));
			$tit = '搜索结果-'.$s;
        }
        if ($rewrite == 1 && empty($s)) {
            $page_config['base_url'] = "index-"; //当前的url，如果有参数需要拼接一下url
            $page_config['suffix'] = ".html"; //当前的url，如果有参数需要拼接一下url
            
        } else {
            $page_config['base_url'] = $file . "?{$_s}p="; //当前的url，如果有参数需要拼接一下url
            
        }
        $page_config['total_rows'] = $count; //传递总数
        $page_config['per_page'] = $per_page; //传递每页的数量
        $page_config['cur_page'] = $p; //传递当前页码
        $pageStr = new Page($page_config);
        $pagelist = $pageStr->create_links(); //创建新页码
        $tpl = 'index.php';
}
include 'assets/'.$template .'/'. $tpl;
/*$db->runsql('DELETE FROM Log');
$db->runsql("DELETE FROM sqlite_sequence WHERE name = 'Log'"); 
$db->runsql('DELETE FROM Pl');
$db->runsql("DELETE FROM sqlite_sequence WHERE name = 'Pl'");*/