<?php
function random_NUM($length, $prefix)
{
$random_id_length = $length;
$rnd_id = crypt(uniqid(rand(),1)); 
$rnd_id = strip_tags(stripslashes($rnd_id)); 
$rnd_id = str_replace(".","",$rnd_id); 
$rnd_id = strrev(str_replace("/","",$rnd_id)); 
$rnd_id = substr($rnd_id,0,$random_id_length); 
$uid = $prefix."".$rnd_id;
return $uid;
}

function UP_file($TARGET_file, $TARGET_path)
{
$extension = end(explode(".", $_FILES["file"]["name"]));
if (($extension!='exe'))
  { 
     
	 if(!preg_match('/exe/',$_FILES["file"]["name"]))
	 {
		if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='JPG' || $extension=='JPEG' || $extension=='PNG')
		{
				  if ($_FILES["file"]["error"] > 0)
					{
					$stat="Return Code: " . $_FILES["file"]["error"];
					}
				  else
					{
				$target=$TARGET_path."".$TARGET_file;
				
					  if(move_uploaded_file($_FILES["file"]["tmp_name"], $target ))
					  {
					  $stat="1";
					    }
					}
		}	
		else{
			 $stat='Invalid File. This Extension not allowed';	
				
				}	
		}
		else{
		$stat='Invalid File. You file contain EXE, please rename it if problem continues.';	
		}
  }
else
  {
$stat="Invalid File. Don't use .exe";
  }
  return $stat;
}

//----------------------------------------------ENCRYPTION/DECRIPTION----------------------------------------------------->>>



$key = 'Your Key';
$string = 'My String'; // note the spaces
function enc($string)
{
$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
return $encrypted;
}

function denc($string)
{
$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
return $decrypted;
}

?>