<?php
//url获取
$uri = $_SERVER['REQUEST_URI'];
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ?

    "https://": "http://";

$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
 //原脚本
$t1 = microtime(true);
require_once 'app/class/app.php';
require_once 'app/class/page.php';
$db = new DbHelpClass();
$p = isset($_GET['p']) ? intval($_GET['p']) : 1;
$act = isset($_GET['act']) ? $_GET['act'] : '';
$s = isset($_GET['s']) ? htmlspecialchars($_GET['s']) : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$tid = isset($_GET['tid']) ? $_GET['tid'] : '';
$tid = $tid===''?'':intval($tid);
$file = self();
$per_page = $set['page'];
$start = $per_page * ($p - 1);
if($widget=="1") $wid = $db->getdata("select * from `Wid` order by ord");
switch ($act) {
    case 'login':
		$tit = '登陆';
	    $ls = isset($_GET['l']) ? $_GET['l'] : '';
		if($ls==$set['lstr']){
        $tpl = 'login.php';
		}else{
			header('Location:' . $file);
		}
        break;

    case 'logout':
        unset($_SESSION[KEY.'admin']);
	    session_destroy();
        header('Location:' . $file);
        break;

    case 'dologin':
        $ps = isset($_POST['pass']) ? $_POST['pass'] : '';
	    $ls = isset($_POST['l']) ? $_POST['l'] : '';
		login($file,$ps,$ls);
        break;

    case 'archives':
		$tit = '归档';
	    $where =  $admin?'':'where hide=0';
        $archives = $db->getdata("select * from `Log` {$where} order by atime desc", array());
	    $tpl = 'archive.php';
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
		if($v['hide']=="1" && $admin==0){@header("http/1.1 404 not found");@header("status: 404 not found");exit('404 not found');}
        $title = $v['title'] == '' ? mb_substr(strip_tags($v['sum']) , 0, 15, 'utf-8') : $v['title'];
        $sum = str_replace('"','',strip_tags($v['sum']));
		$list = $db->getdata("select * from `Pl` where cid=:id", array(
            'id' => $id
        ));		
		$tit = strip_tags($title);
		$key = $v['key'];
		$des = str_replace("\n","",$sum);
        $tpl = 'view.php';
		pv($id);
        break;

    case 'plist':
		$where = $admin==1?'':'where hide=0';
        $count = $db->total('`Pl`',$where);
        $list = $db->getdata("select * from `Pl` $where order by id desc limit $start,$per_page", array());
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
		$key = $webkey.',评论,博客评论,评论列表';
		if($p>1)  $tit .= '_第'.$p.'页_';
        $tpl = 'plist.php';
        break;
    case 'target':
        $tpl = 'target.php'; 
		break;
    default:		
		$key = $webkey;
        if (empty($s)) {
			if($tid===''){
			   $where =  $admin?'':'where hide=0';
			   $_s = '';
			   $tit = '首页';
			}else{			   
			   $where =  $admin?'where tid='.$tid:'where hide=0 and tid='.$tid;
			   $_s = 'tid=' . $tid . '&';
			   $tit = $class[$tid];
			}			
            $count = $db->total('`Log`',$where);
            $list = $db->getdata("select * from `Log` $where order by ist desc,atime desc limit $start,$per_page", array());
            
        } else {
			$where =  $admin?'':'and hide=0';
            $_s = 's=' . $s . '&';
            $count = $db->total('`Log`', "where (title like '%$s%' or content like '%$s%') $where");
            $list = $db->getdata("select * from `Log` where (title like :s or content like :s) $where order by ist desc,atime desc limit $start,$per_page", array(
                "s" => $s
            ));
			$key = $key.',搜索结果';
			$tit = '搜索结果-'.$s;
        }
        if ($rewrite == 1 && empty($s)) {
			if($tid===''){
               $page_config['base_url'] = 'index-'; //当前的url，如果有参数需要拼接一下url
			}
			else{
		       $page_config['base_url'] = "list-". $tid . '-'; //当前的url，如果有参数需要拼接一下url
			}
               $page_config['suffix'] = '.html'; //当前的url，如果有参数需要拼接一下url
            
        } else {
            $page_config['base_url'] = $file . "?{$_s}p="; //当前的url，如果有参数需要拼接一下url
            
        }
        $page_config['total_rows'] = $count; //传递总数
        $page_config['per_page'] = $per_page; //传递每页的数量
        $page_config['cur_page'] = $p; //传递当前页码
        $pageStr = new Page($page_config);
        $pagelist = $pageStr->create_links(); //创建新页码
		if($p>1)  $tit .= '_第'.$p.'页_';
        $tpl = 'index.php';
}
include 'assets/'. TEMPLATE .'/'. $tpl;

//百度api推送
$urls = array(
    $url,
);
//在下面这行的引号当中填入你的接口调用地址
$api = '在这边填你的调用接口地址';
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
//这边会显示出接口调用的结果，如果放在PHP文件的末尾会影响网站的结构，所以最好加双斜杠变为注释，以便未来的时候开启。
//echo $result;
