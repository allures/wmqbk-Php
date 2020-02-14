<?php
if(!defined('WMBLOG'))exit;

function fsemmsg_init(){   
     $config['title'] = 'fsocko评论/回复邮件提醒通知';
     $config['file'] = 'fsemmsg.php';
     $config['act'] = 'addpl,plsave';
     $config['func'] = 'fsemmsg';
     $config['cfg'] = array('smtp服务器','邮箱地址','password'=>'邮箱密码','端口');
	 if(!function_exists("fsockopen")) {
             $config['error'] = "服务器不支持fsockopen！";             
     }
     return $config;
}

function fsemmsg_run($arr){
	 global $set;
	 $arg = $arr['args'];
     if($arr['act']=='plsave'){
	    $email = $arr['pmail'];
		if(filter_var($email, FILTER_VALIDATE_EMAIL)==false) return 'pmail empty';
		$text = '<b>您在<a href="'.$arr['r'].'">'.$set['webtitle'].'</a>评论被回复</b><hr>回复内容：'.$arr['rcontent'];
		$title = '评论回复通知';
	 }else{
	    $email = empty($set['webmail'])?$arg[1] : $set['webmail'];
		$text = '<b>评论地址：</b><a href="'.$arr['r'].'">'.$set['webtitle'].'</a><br><b>评论昵称：</b>'.$arr['pname'].'<br><b>评论内容：</b>'.$arr['pcontent'];
		$title = '您的博客收到新的评论';
	 } 
	 send_mail($email, $title, $text ,$set['webuser'],$arg);
} 


function send_mail($to, $subject = 'No subject', $body ,$loc='站长',$arg) {
    $loc_host = $loc;              //发信名
	$smtp_host = $arg[0];          //SMTP服务器地址
    $smtp_acc = $arg[1];           //Smtp认证的用户名，
    $smtp_pass = $arg[2];          //Smtp认证的密码
    $smtp_port = $arg[3];
    $from = $arg[1];              //发信人Email地址，你的发信信箱地址
    $headers = "Content-Type: text/html; charset=\"utf-8\"\r\nContent-Transfer-Encoding: base64";
    $lb="\r\n";                         //linebreak

    $hdr = explode($lb,$headers);     //解析后的hdr
    if($body) {
        $bdy = preg_replace("/^\./","..",explode($lb,$body));   //解析后的Body
    }

    $smtp = array(
        //1、EHLO，期待返回220或者250
        array("EHLO ".$loc_host.$lb,"220,250","HELO error: "),
        //2、发送Auth Login，期待返回334
        array("AUTH LOGIN".$lb,"334","AUTH error:"),
        //3、发送经过Base64编码的用户名，期待返回334
        array(base64_encode($smtp_acc).$lb,"334","AUTHENTIFICATION error : "),
        //4、发送经过Base64编码的密码，期待返回235
        array(base64_encode($smtp_pass).$lb,"235","AUTHENTIFICATION error : ")
    );
    //5、发送Mail From，期待返回250
    $smtp[] = array("MAIL FROM: <".$from.">".$lb,"250","MAIL FROM error: ");
    //6、发送Rcpt To。期待返回250
    $smtp[] = array("RCPT TO: <".$to.">".$lb,"250","RCPT TO error: ");
    //7、发送DATA，期待返回354
    $smtp[] = array("DATA".$lb,"354","DATA error: ");
    //8.0、发送From
    $smtp[] = array("From: ".$from.$lb,"","");
    //8.2、发送To
    $smtp[] = array("To: ".$to.$lb,"","");
    //8.1、发送标题
    $smtp[] = array("Subject: ".$subject.$lb,"","");
    //8.3、发送其他Header内容
    foreach($hdr as $h) {$smtp[] = array($h.$lb,"","");}
    //8.4、发送一个空行，结束Header发送
    $smtp[] = array($lb,"","");
    //8.5、发送信件主体
    if($bdy) {foreach($bdy as $b) {$smtp[] = array(base64_encode($b.$lb).$lb,"","");}}
    //9、发送“.”表示信件结束，期待返回250
    $smtp[] = array(".".$lb,"250","DATA(end)error: ");
    //10、发送Quit，退出，期待返回221
    $smtp[] = array("QUIT".$lb,"221","QUIT error: ");

    //打开smtp服务器端口
    //$fp = @fsockopen($smtp_host, $arg[3]);


	 if ($smtp_port == "465") {
        //SSL加密通信
        $fp = @fsockopen('ssl://'. $smtp_host, $smtp_port);
    }
    else {
        //普通无加密通信
        $fp = @fsockopen($smtp_host, $smtp_port);
    }

    if (!$fp) echo "Error: Cannot conect to ".$smtp_host."";
    while($result = @fgets($fp, 1024)){
        if(substr($result,3,1) == " ") { break; }
    }

    $result_str="";
    //发送smtp数组中的命令/数据
    foreach($smtp as $req){
        //发送信息
        @fputs($fp, $req[0]);
        //如果需要接收服务器返回信息，则
        if($req[1]){
            //接收信息
            while($result = @fgets($fp, 1024)){
                if(substr($result,3,1) == " ") { break; }
            };
            if (!strstr($req[1],substr($result,0,3))){
                $result_str.=$req[2].$result."";
            }
        }
    }
    //关闭连接
    @fclose($fp);
    return $result_str;
}