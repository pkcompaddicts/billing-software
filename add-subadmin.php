<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['submit']))
{
	$date=date('Y-m-d H:i:s');
    $branch_id=Input::get('branch');
	$signatory_name=Input::get('signatory_name');
	$username=Input::get('username');
	$password=Input::get('password');
	$email=Input::get('email');
	$number=Input::get('number');

	
	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();	
	$added_by=$find_who_row->id;		
	
    if((!empty($branch_id)) && (!empty($signatory_name)) && (!empty($username)) && (!empty($password)) && (!empty($email)) && (!empty($number)))
	{		

				        $find_who=DB::getInstance()->get('admin',array('username','=',$username));
						$userCount=$find_who->ount();	
						
						if($userCount==0)
						{
						    $up=DB::getInstance()->insertwithoutimage('admin',array('signatory_name' => $signatory_name, 'username' => $username, 'email' => $email, 'number'=> $number, 'password' => $password, 'branch_id' => $branch_id, 'added_on' => $date,'added_by' => $added_by,'login_type' => 2));
					
						   $_SESSION['msg']="Subadmin Added Successfully";
									?>
										<script>window.location='subadmins.php';</script>
										
									<?php
						}
						else
						{
						  $_SESSION['err']="Sorry,username not available.Try Another.";
						}
						
    }
	else
	{
		$_SESSION['err']="All Fields are required";
	}
}





if(isset($_REQUEST['update']))
{
    $date=date('Y-m-d H:i:s');
    $id=Input::get('rid');
    $branch_id=Input::get('branch');
	$signatory_name=Input::get('signatory_name');
	$username=Input::get('username');
	$password=Input::get('password');
	$email=Input::get('email');
	$number=Input::get('number');
	

	
	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();	
	$added_by=$find_who_row->id;		
	
    if((!empty($branch_id)) && (!empty($signatory_name)) && (!empty($username)) && (!empty($password)) && (!empty($email)) && (!empty($number)))
	{		

				        $find_who=DB::getInstance()->query("SELECT * FROM admin where id!='$id' and username='$username'");
						$userCount=$find_who->ount();	
						
						if($userCount==0)
						{
						    $up=DB::getInstance()->updatewithoutimage('admin','id',$id,array('signatory_name' => $signatory_name, 'username' => $username, 'email' => $email, 'number'=> $number, 'password' => $password, 'branch_id' => $branch_id, 'updated_on' => $date,'updated_by' => $added_by,'login_type' => 2));
					
						   $_SESSION['msg']="Subadmin Updated Successfully";
									?>
										<script>window.location='subadmins.php';</script>
										
									<?php
						}
						else
						{
						  $_SESSION['err']="Sorry,username not available.Try Another.";
						}
						
    }
	else
	{
		$_SESSION['err']="All Fields are required";
	}
}


?>
<div class="block-header">
                <ol class="breadcrumb breadcrumb-bg-teal align-right">
                                <li><a href="javascript:void(0);"><i class="material-icons">home</i> Home</a></li>
                                <li><a href="javascript:history.back()">Back</a></li>
                               
                            </ol>
            </div>
			<div class="row clearfix">
			<?php
						if(isset($_SESSION['msg']))
						{ ?>
						<div class="alert alert-block alert-success">
								<a class="close" data-dismiss="alert" href="#">Close</a>
  								<h4 class="alert-heading">Congo!</h4>
  								<?php echo $_SESSION['msg'];?>
							</div><?php
							
							} ?>
							
			<?php
						if(isset($_SESSION['err']))
						{ ?>
						<div class="alert alert-block alert-error">
								<a class="close" data-dismiss="alert" href="#">Close</a>
  								<h4 class="alert-heading">Sorry!</h4>
  								<?php echo $_SESSION['err'];?>
							</div><?php
							
							} ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   
                            <?php
	if(isset($_REQUEST['mode']))
	{
	$mode=$_REQUEST['mode'];
	switch($mode)
	{
	case "edit":
	
	$id=base64_decode($_REQUEST['id']);
	$del=DB::getInstance()->get('admin',array('id','=',$id));
    $branchData_Row=$del->first();
	$branchId=$branchData_Row->branch_id;
	
	?>
	 <div class="card">
                        <div class="header">
                            <h2>
                               Update Sub Admin
                            </h2>
                            
                        </div>
                        <div class="body">
	<form method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="rid" value="<?php echo $id; ?>" >
		<div class="col-sm-6">
                                    <p>
                                        <b>Branch</b>
                                    </p>
                                    <select class="form-control show-tick"  name="branch" data-live-search="true" required>
									<option>Select Branch</option>
                                      <?php
											   $del=DB::getInstance()->getmultiple('branches',array('status' => 1));
											   foreach($del->results() as $row)
											   {
											     $rid=$row->id;
											     ?>
												   <option value="<?php echo $row->id; ?>" <?php if($branchId==$rid) { echo "selected"; } ?>><?php echo $row->name; ?> , <?php echo $row->address; ?></option>
												 <?php
											   }
											   ?>
                                    </select>
                                </div>
								<div class="col-sm-6">
								<label for="sign_name">Signatory Name:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="sign_name"  name="signatory_name" class="form-control" value="<?php echo $branchData_Row->signatory_name; ?>">
                                    </div>
                                </div>
								
								</div>
			<div class="col-sm-6">
			<label for="Username">Username:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="Username"  name="username" class="form-control" value="<?php echo $branchData_Row->username; ?>">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-6">
			<label for="Password">Password:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="Password"  name="password" class="form-control" value="<?php echo $branchData_Row->password; ?>">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-6">
			<label for="email">Email:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="email"  name="email" class="form-control" value="<?php echo $branchData_Row->email; ?>" >
                                    </div>
                                </div>
			</div>
			<div class="col-sm-6">
			<label for="Contact">Contact:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="Contact"  name="number" class="form-control" value="<?php echo $branchData_Row->number; ?>">
                                    </div>
                                </div>
									
			</div>	
			<input type="submit" class="btn btn-green3" name="update" value="Update">
			
</form>
</div>
				</div>
			</div>
		<?php
break;

}
		}
else
{

	
?>
<div class="card">
                        <div class="header">
                            <h2>
                               Add Sub Admin
                            </h2>
                            
                        </div>
                        <div class="body">
<form method="post" action="" enctype="multipart/form-data">
<div class="col-sm-6">
                                    <p>
                                        <b>Branch</b>
                                    </p>
                                    <select class="form-control show-tick"  name="branch" data-live-search="true" required>
                                      <option>Select Branch</option>
										       <?php
											   $del=DB::getInstance()->getmultiple('branches',array('status' => 1));
											   foreach($del->results() as $row)
											   {
											     ?>
												   <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?> , <?php echo $row->address; ?></option>
												 <?php
											   }
											   ?>
                                    </select>
                                </div>
								<div class="col-sm-6">
								<label for="sign_name">Signatory Name:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="sign_name"  name="signatory_name" class="form-control" placeholder="Signatory Name">
                                    </div>
                                </div>
								
								</div>
			<div class="col-sm-6">
			<label for="Username">Username:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="Username"  name="username" class="form-control" placeholder="Username">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-6">
			<label for="Password">Password:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="Password"  name="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-6">
			<label for="email">Email:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="email"  name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-6">
			<label for="Contact">Contact:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="Contact"  name="number" class="form-control" placeholder="Contact">
                                    </div>
                                </div>
			</div> <br>
			<input type="submit" name="submit" class="btn btn-primary m-t-15 waves-effect" value="Submit">
			
			</form>
			
			
					
						
						
					
								
								
						
<?php

}	?>
                        </div>
                    </div> 


<script>

function SelProType(vl)
{
if(vl==2)
{
	var ctId=$('#catId').val();
	
	 $.ajax({
		type: "POST",
		url: "ajax.php",
		data: 'mode=proType&catId=' + ctId,
		cache: true,
		success: function(dat){
			
	       $("#AjaxResult" ).html(dat);
		}  
		});
   }
   else
   {
	   $("#AjaxResult" ).html('');
   }
}
</script>

<?php include('common/footer.php'); ?>
