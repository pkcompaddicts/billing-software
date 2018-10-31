<?php

$actual_link = "http://$_SERVER[HTTP_HOST]"; 

switch($actual_link)
{
	
case (($actual_link=="http://compaddicts.org") || ($actual_link=="http://www.compaddicts.org")):

$host='localhost';
$db = 'comcts_pos_invoice';
$user = 'comcts_pos_invoi';
$password = '1ls@,ed$QxMc';

$baseurl=$actual_link."/product/pos-invoice/";

break;


case "http://localhost": 


$host='127.0.0.1';
$db = 'smartinvoice';
$user = 'root';
$password = '';
$baseurl=$actual_link."/smartinvoice/";
	
	
break;
}

$dsn = 'mysql:dbname='.$db.';host='.$host;

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
date_default_timezone_set('Asia/Calcutta');
$present_datec = date("Y-m-d, H:i:s");
$present_date = date("Y-m-d");


//define('OWNER_EMAIL','sonal@compaddicts.in');
?>