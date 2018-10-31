<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['updateProfile']))		
{
	$name=Input::get('name');
	$add=nl2br(Input::get('address'));
	$email=Input::get('email');
	$number=Input::get('number');
	$website=Input::get('website');

	$image=$_FILES['image']['name'];
	$tmpimg=$_FILES['image']['tmp_name'];
	$size=$_FILES['image']['size'];
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["image"]["name"]);
	$extension = end($temp);
	
	
	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();
	$branch_id=$find_who_row->branch_id;		
	$rowId=$find_who_row->id;		
	
    if((!empty($name)) && (!empty($add)) && (!empty($email)) && (!empty($number)))
	{		
		if($image)
			{
				if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/png") || ($_FILES["image"]["type"] == "image/pjpeg")) 
		           {
					   $logo_old=$find_who_row->logo;		
	
						$url = $_FILES["image"]["name"]; 
						
						$random=rand(0,9898989);
						$time=time();
						$randName=$time.$random;
						$url=explode('.',$url);
						$ext=end($url);
						$file=$randName.".".$ext;
						
						$durl = "logo/".$file;
					
						$up=DB::getInstance()->update('branches','id',$branch_id,$tmpimg,$durl,array('name' => $name, 'address' => $add, 'email' => $email, 'number'=> $number, 'website' => $website,'logo'=> $file));
						
						unlink('logo/'.$logo_old);
						
						$_SESSION['msg']="Profile Updated Successfully";
								?>
										<script>window.location='profile.php';</script>
								<?php
					 }
				 else
					 {
						$_SESSION['err']="File Invalid Try Again";
					 }
			}
		else
			{
						$up=DB::getInstance()->update('branches','id',$branch_id,$url,$durl,array('name' => $name, 'address' => $add, 'email' => $email, 'number'=> $number,'website' => $website));
						$_SESSION['msg']="Profile Updated Successfully";
									?>
										<script>window.location='profile.php';</script>
										
									<?php
			}
    }
	else
	{
		$_SESSION['err']="All Fields are required";
	}
}
								
    $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();
	$branch_id=$find_who_row->branch_id;

	$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
	$branchData_Row=$branchData->first();

	
	
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
	<?php
						if(isset($_SESSION['msg']))
						{ ?>
						<div class="alert alert-block alert-success">
								<a class="close" data-dismiss="alert" href="#">Close</a>
  								<h4 class="alert-heading">Congo!</h4>
  								<?php echo $_SESSION['msg'];?>
							</div><?php
							//unset($_SESSION['msg']);
							} ?>
							
				<?php
						if(isset($_SESSION['err']))
						{ ?>
						<div class="alert alert-block alert-danger">
								<a class="close" data-dismiss="alert" href="#">Close</a>
  								<h4 class="alert-heading">Sorry!</h4>
  								<?php echo $_SESSION['err'];?>
							</div><?php
							//unset($_SESSION['err']);
							} ?>
							
				
			<div class="row-fluid">
		
		<?php
		if((isset($_REQUEST['mode'])) && ($_REQUEST['mode']=="edit"))
		{
            $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
			$find_who_row=$find_who->first();
            $loginType=$find_who_row->login_type;
            $branch_id=$find_who_row->branch_id;

			$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
			$branchData_Row=$branchData->first();
			
		?>
			<div class="span6">
					<div class="box">
						<div class="box-head tabs">
							<h3>Update Profile</h3>
							
						</div>
						<div class="box-content box-nomargin">
						<div class="box-content">
						
									
								
							<div class="tab-content">
									<div class="tab-pane active" id="basic">
										<form method="post" action="" enctype="multipart/form-data">
							
									<div class="control-group">
													<label class="control-label" for="form-field-1">Compnay Name:</label>
		                             <div class="controls">
										<input type="text" name="name" id="form-field-1"  value="<?php echo $branchData_Row->name;?>" style="width:90%" <?php if($loginType==2) { ?> readonly <?php } ?>/>
									</div>
									                </div>
													
									<div class="control-group">
													<label class="control-label" for="form-field-1">Username :</label>
		                             <div class="controls">
										<input type="text" name="username" id="form-field-1"  value="<?php echo $find_who_row->username;?>" readonly style="width:90%"/>
									</div>
									                </div>
													<div class="control-group">
													<label class="control-label" for="form-field-1">Address :</label>
		                             <div class="controls">
		                             
										<textarea rows="2" cols="5" name="address" id="form-field-1"  <?php if($loginType==2) { ?> readonly <?php } ?> style="width:90%"/><?php echo strip_tags($branchData_Row->address);?></textarea>
									</div>
									                </div>
													<div class="control-group">
													<label class="control-label" for="form-field-1">Email Id:</label>
		                             <div class="controls">
										<input type="text" name="email" id="form-field-1"  value="<?php echo $branchData_Row->email;?>" <?php if($loginType==2) { ?> readonly <?php } ?> style="width:90%"/>
									</div>
									                </div>
													<div class="control-group">
													<label class="control-label" for="form-field-1"> Number :</label>
		                             <div class="controls">
										<input type="text" name="number" id="form-field-1"  value="<?php echo $branchData_Row->number;?>" <?php if($loginType==2) { ?> readonly <?php } ?> style="width:90%"/>
									</div>
									                </div>
													
													<div class="control-group">
													<label class="control-label" for="form-field-1"> Website :</label>
		                             <div class="controls">
										<input type="text" name="website" id="form-field-1" <?php if($loginType==2) { ?> readonly <?php } ?> value="<?php echo $branchData_Row->website;?>" style="width:90%"/>
									</div>
									                </div>
								
									<div class="control-group">
													<label class="control-label" for="form-field-1"> Logo :</label>
		                             <div class="controls">
									    <img src="<?php echo $base_url; ?>logo/<?php echo $branchData_Row->logo;?>" style="width:50%;"><br/><br/>
										<input type="file" name="image" id="form-field-1"  value="<?php echo $branchData_Row->logo;?>" <?php if($loginType==2) { ?> disabled <?php } ?>/>
									</div>
									                </div>
													
									<div class="control-group">
									<div class="controls">
									<input type="submit" class="btn btn-green3 pull-right" name="updateProfile" value="Submit">
									</div>
									</div>
									</form>
									</div>
								
							</div>
						
						</div>
					</div>
				</div>
			</div>
			
			<?php
			}
			else
			{
				
					
				    $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
					$find_who_row=$find_who->first();
					$login_type=$find_who_row->login_type;
					$branch_id=$find_who_row->branch_id;

					$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
					$branchData_Row=$branchData->first();
					
			?>
			<div class="span12">
				<div class="box">
					<div class="box-head">
						<h3>Your Profile</h3>
					</div>
					<div class="box-content">
					<a href="change-password.php" class="btn btn-mini btn-green3 pull-right" style="margin-left: 10px;">Change Password</a>
					
					<?php
					if($login_type==4)
					{
					?>
					<a href="profile.php?mode=edit" class="btn btn-mini btn-red3 pull-right">Update Profile</a>
					
					<?php
			         }
					?>
					
						<div class="cl">
							<div class="pull-left">
								
								<img src="<?php echo $baseurl; ?>logo/<?php echo $branchData_Row->logo; ?>" alt="<?php echo $branchData_Row->name; ?>" style="width:150px">
							</div>
							<div class="details pull-left userprofile">
								<table class="table table-striped table-detail">
									<tbody>
									<tr>
										<th>Company Name: </th>
										<td><?php echo $branchData_Row->name; ?></td>
									</tr>
								
									<tr>
										<th>Username: </th>
										<td><?php echo $find_who_row->username; ?></td>
									</tr>
									<tr>
										<th>Address: </th>
										<td><?php echo $branchData_Row->address; ?></td>
									</tr>
									<tr>
										<th>Email: </th>
										<td><?php echo $branchData_Row->email; ?></td>
									</tr>
									<tr>
										<th>Contact No.: </th>
										<td><?php echo $branchData_Row->number; ?></td>
									</tr>

									<?php
									$website=$branchData_Row->website;
									if($website!="")
									{
										$website=$website;
									}
									else
									{
										$website="---";
									}
									?>
									<tr>
										<th>Website: </th>
										<td><?php echo $website; ?></td>
									</tr>
								</tbody></table>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			
			<?php
			}
			?>
		</div>
	</div>
</div>	


<?php include('common/footer.php'); ?>