<?php
session_start();
error_reporting(0);
$actual_link = "http://$_SERVER[HTTP_HOST]";

switch($actual_link)
{
	
case (($actual_link=="http://compaddicts.org") || ($actual_link=="http://www.compaddicts.org")):

$host='localhost';
$db = 'comcts_pos_invoice';
$user = 'comcts_pos_invoi';
$password = '1ls@,ed$QxMc'; 

$baseurl=$actual_link."/product/smart-invoice/";

break;


case "http://localhost":


$host='127.0.0.1';
$db = 'smartinvoice';
$user = 'root';
$password = '';
$baseurl=$actual_link."/smartinvoice/";

	
break;
}
$product_name='product';
$item_name='item';

$admin_mail="admin@compaddicts.org";
date_default_timezone_set('Asia/Kolkata');
$GLOBALS['config'] =  array(
 		'mysql' => array(

          'host'     => $host,   
          'db'       => $db,
          'username' => $user,
          'password' => $password,
          'driver'   => 'pdo_mysql',
         ),
 		'remember' => array(

 		'cookie_name' => 'hash',
 		'cookie_expiry' => 604800  //this cookie time is set in seconds.



 			),
 		'session'  => array(

 		'session_name' => 'user',
        'token_name' => 'token',
       		
  				

 			),

	);

//spl_autoload_register  enables us to reduce that 10 lines of code for including files again and again to just one single line
//$class='DB';
spl_autoload_register(function($class){    	

require_once 'classes/' . $class . '.php';

});
require_once 'functions/sanitize.php';

?>