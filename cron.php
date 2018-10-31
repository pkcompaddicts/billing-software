<?php
function send_sms($message,$phone){
$username= "t1compaddicts";
$password="1234567";
$message=urlencode($message);
$url="http://nimbusit.co.in/api/swsend.asp?username=".$username."&password=".$password."&sender=COMPAD&sendto=".$phone."&message=".$message."";
//$url="http://bulk.mnotification.com/smsapi?key=".$key."&to=".$phone."&msg=".$message."&sender_id=".$sender_id."";
$result=file_get_contents($url);
if($result=="1000"){
echo "Message sent";
}elseif($result=="1002"){
echo "Message not sent";
}elseif(($result=="1003")){
echo "You don't have enough balance";
}elseif(($result=="1004")){
echo "Invalid API Key";
}
}
$Date = date('Y-m-d');
$del=DB::getInstance()->query("SELECT * FROM  `offline_store_installment`  WHERE  `next_installment` =  '$Date' AND `remaining_amount`!='0' ORDER by id DESC");
$count=$del->ount();
if($count!=0){
foreach($del->results() as $row)
{
	$invoice=$row->invoice_no;
	$getinvoice=DB::getInstance()->query("SELECT * FROM offline_store_invoice WHERE `invoice_no`='$invoice'");
        $frow=$getinvoice->first();
//the message can be from a form field
$phone = $frow->from_contact; // the phone number can be from a form field
$message="Hello ".$frow->from_name." today is your EMI date. Thank You!";
send_sms($message,$phone);
//$url="http://nimbusit.co.in/api/swsend.asp?username=t1compaddicts&password=1234567&sender=COMPAD&sendto=9936534666&message=hello";
//file_get_contents($url);
}
}
?>