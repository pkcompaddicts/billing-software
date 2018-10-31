<?php 
session_start();
include("core/init.php");
$date=date("Y-m-d, H:i:s");

$GetData=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$rowData=$GetData->first();
$id=$rowData->id;

$del=DB::getInstance()->updatewithoutimage('admin','id',$id,array('last_login' => $date));
							
unset($_SESSION['username']);
session_destroy();
?> 
<script>window.location='index.php'</script>   