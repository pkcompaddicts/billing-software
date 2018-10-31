<?php
class Mail
{

    public function sendmail($to,$subject,$msg,$from)
	
	{
                            $headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							
								$headers .= 'From: '.$from . "\r\n";
                            $mail= mail($to,$subject,$msg,$headers);
							return $mail;
	}
}
?>