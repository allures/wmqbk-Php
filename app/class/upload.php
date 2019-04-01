<?php
require_once(dirname(__FILE__)."/config.php");
$loginStat =1;
if( isset($_FILES['picture']) && !empty($_FILES['picture']['name']) )
{
	if( !$loginStat )
	{		 
		jsmsg(1,'not login');
	}
	else
	{
		if( $_FILES['picture']['size'] > 3145728 )
		{
 
			jsmsg(1,'图片不能超过3M');
		}
		else
		{
			$imgInfo = @getimagesize($_FILES['picture']['tmp_name']);

			if( !$imgInfo || !in_array($imgInfo[2], array(1,2,3)) )
			{			 
				jsmsg(1,'您上传的不是一张有效的图片');
				exit();
			}
			switch($imgInfo[2])
				{
					case 1:
						$fileType = ".gif";
						break;
					case 2:
						$fileType = ".jpg";
						break;
					case 3:
						$fileType = ".png";
						break;
				}

				$savePath = date('Y/m');
				$saveName = "_".date('His')."_".rand().$fileType;



			if(COSUP == 1){
			   $saveImage =  '/file/'.$savePath."/".$saveName;
			   $data = file_get_contents($_FILES['picture']['tmp_name']);
               $res = cosUpload($data, $saveImage);
			   jsmsg(0,array($res));
			   
			}else{
			//$imgInfo = @getimagesize($_FILES['picture']['tmp_name']);

			//if( !$imgInfo || !in_array($imgInfo[2], array(1,2,3)) )
			//{			 
				//jsmsg(1,'您上传的不是一张有效的图片');
			//}
			//else
			//{
				
				mkDirs(ROOT_PATH."assets/file/".$savePath);

				$saveImage = ROOT_PATH."assets/file/".$savePath."/b".$saveName;

				if( @move_uploaded_file($_FILES['picture']['tmp_name'], $saveImage) )
				{					
					
					if( $imgInfo[0] > 560 || $imgInfo[1] > 560 )
					{
						createImg($saveImage,$saveImage,$imgInfo,560,560);
					}

					//echo "1 ".$savePath."/s".$saveName;
					$resImage = str_replace(ROOT_PATH,'',$saveImage);
					jsmsg(0,array($resImage));
				}
				else
				{					 
					jsmsg(1,'上传失败');
				}
			//}
			}// end cos else
		} //end login else
	}
}

function cosUpload($data, $path) {

    $url = BucketURL . $path;
    //$data = file_get_contents($file);
    $header = array(
        'Authorization: ' . RequestSign('put', $path),
        'Date: ' . gmdate('D, d M Y H:i:s T')
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $data = curl_exec($curl);
	$info = curl_getinfo($curl);
	//print_r($info);
    //$error = curl_error($curl);
    curl_close($curl);
    return $info['url'];
}

function RequestSign($method, $path) {
    $signTime = (string)(time() - 60) . ';' . (string)(time() + 1200);
    $host = parse_url(BucketURL);
    $httpString = sprintf("%s\n%s\n\nhost=%s\n", strtolower($method), $path, $host['host']);
    $stringToSign = sprintf("sha1\n%s\n%s\n", $signTime, sha1($httpString));
    $signKey = hash_hmac('sha1', $signTime, SecretKey);
    $signature = hash_hmac('sha1', $stringToSign, $signKey);
    return sprintf('q-sign-algorithm=sha1&q-ak=%s&q-sign-time=%s&q-key-time=%s&q-header-list=host&q-url-param-list=&q-signature=%s', SecretId, $signTime, $signTime, $signature);
}
