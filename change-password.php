<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['changePassword']))		
{
	$current_password=Input::get('current_password');
	$password=Input::get('password');
	$confirm_password=Input::get('confirm_password');
	
	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();
	$rowId=$find_who_row->id;	
	$oldpassword=$find_who_row->password;	
	
	if((!empty($current_password)) && (!empty($password)) && (!empty($confirm_password)))
	{
	  if($current_password!=$oldpassword)
	  {
	    $_SESSION['err']="Current Password do not match";
	  }
	  else
	  {
	     if($password!=$confirm_password)
		  {
			$_SESSION['err']="Confirm Password do not match";
		  }
		  else
		  {	 
		  
		     $up=DB::getInstance()->updatewithoutimage('admin','id',$rowId,array('password' => $password));
	         $_SESSION['msg']="Password Changed Successfully";
			 
				?>
					<script>window.location='profile.php';</script>
										
				<?php
			
		  }
	  }

	}
	else
	{
	  $_SESSION['err']="All fields are required";
	}
	
	
}
								
								
$del=DB::getInstance()->getmultiple('admin',array('login_type' => 4));
?>
<script language="javascript" type="text/javascript">	
function checkAll(bx) {
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox') {
      cbs[i].checked = bx.checked;
    }
  }
}
</script>
<link rel="stylesheet" href="css/uniform.default.css">


	<div class="content">
	
	
	
	<div class="row-fluid">
	                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                <?php
						    if(isset($_SESSION['msg']))
						    { ?>
						     <div class="alert alert-block alert-success text-solve">
								<a class="close" data-dismiss="alert" href="#">X</a>
  								<?php echo $_SESSION['msg'];?>
							</div>
							<?php} ?>
							<?php
							if(isset($_SESSION['err']))
							{ ?>
								 <div class="alert alert-block alert-error text-error">
									<a class="close" data-dismiss="alert" href="#">X</a>
									<?php echo $_SESSION['err'];?>
								 </div>
							<?php } ?>
			            </div>	
							
				
			<div class="row-fluid">
		
		<?php
	
            $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
			$find_who_row=$find_who->first();

		?>
			<div class="span6">
					<div class="box">
						<div class="box-head tabs">
							<h3>Change Password</h3>
							
						</div>
						<div class="box-content box-nomargin">
						<div class="box-content">
						
									
								
							<div class="tab-content">
									<div class="tab-pane active" id="basic">
										<form method="post" action="" enctype="multipart/form-data">
							
									<div class="control-group">
										<label class="control-label" for="form-field-1">Current Password:</label>
		                              <div class="controls">
										<input type="password" name="current_password" id="form-field-1"  style="width:90%"/>
									  </div>
									</div>
													
													
													
									<div class="control-group">
										<label class="control-label" for="form-field-1">Password:</label>
		                              <div class="controls">
										<input type="password" name="password" id="form-field-1"   style="width:90%"/>
									  </div>
									</div>
													
									<div class="control-group">
										<label class="control-label" for="form-field-1">Confirm Password:</label>
		                              <div class="controls">
										<input type="password" name="confirm_password" id="form-field-1" style="width:90%"/>
									  </div>
									</div>
												
													
									<div class="control-group">
									<div class="controls">
									<input type="submit" class="btn btn-green3 pull-right" name="changePassword" value="Change">
									</div>
									</div>
									</form>
									</div>
								
							</div>
						
						</div>
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
</div>	


<?php include('common/footer.php'); ?>