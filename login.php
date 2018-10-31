<?php
session_start();


error_reporting(0);
require_once("core/init.php");
 
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

if(isset($_REQUEST['submit']))
{
$email=stripslashes($_REQUEST['email']);
$pass=stripslashes($_REQUEST['password']);

$del = DB::getInstance()->query("SELECT * FROM `admin` WHERE `username`='$email' and  `password`='$pass' and `status`='1' and (branch_id IN (SELECT id FROM branches WHERE `status`='1'))");
$count = $del->ount();
if($count==0)
{
$_SESSION['record_user']=$email;
$_SESSION['record_pass']=$pass;
$_SESSION['record_date_time']=date('Y-m-d H:i:s');
$_SESSION['record_status']='Failed';

$msg="Inavalid Username or Password";

}
else{
$result = $del->first();
$_SESSION['username']=$result->username;

if(isset($_REQUEST['token']))
{
$_SESSION['record_user']=$email;
$_SESSION['record_pass']=$pass;
$_SESSION['login_type'] = $result->login_type;
$_SESSION['record_date_time']=date('Y-m-d H:i:s');
$_SESSION['record_status']='Success';
?>
<script>window.location='<?php echo base64_decode($_REQUEST['token']) ?>'</script>
<?php
}
else{
$_SESSION['record_user']=$email;
$_SESSION['record_pass']=$pass;
$_SESSION['login_type'] = $result->login_type;
$_SESSION['record_date_time']=date('Y-m-d H:i:s');
$_SESSION['record_status']='Success';
?>
<script>window.location='index.php'</script>
<?php
}
}
}


$GetData=DB::getInstance()->getmultiple('admin',array('login_type' => 4));
$rowData=$GetData->first();
$branch_id=$rowData->branch_id;

$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
$branchData_Row=$branchData->first();

include('common/css.php');	
?>
<body class="login-page">
    <div class="login-box">
        <div class="logo">
             <a href="javascript:void(0);"><img src="logo/<?php echo $branchData_Row->logo; ?>" style="width:100%"></a>
            <small>Welcome to the login page</small>
        </div>
        <div class="card">
            <div class="body">
               <form action=""  autocomplete="off" method="post" class="validate">
		<?php if($msg) {?>
		<div class="msg">
		
			<strong>Error!</strong><?php echo $msg;?>
			
		</div><?php } ?>
                    
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" name="email" class="form-control {required:true}" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control {required:true}" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" name="submit" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="sign-up.html">Register Now!</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include('common/js.php');	?>

</body>

</html>
