<?php
require_once(dirname(__FILE__)."/config.php");
if( isset($_FILES['picture']) && !empty($_FILES['picture']['name']) )
{
	if( !$admin )
	{		 
		jsmsg(1,'not login');
	}
	else
	{
       //if($_FILES['picture']['size'] > 0‬)
       if($_FILES['picture']['size'] > 5242880 )
		{
 
			jsmsg(1,'图片不能超过5M');
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
			 
		} //end login else
	}
}