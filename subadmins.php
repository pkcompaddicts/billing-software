<?php 
include('common/header.php');
include('common/sidebar.php');

if(isset($_REQUEST['mode']))
{
$mode=$_REQUEST['mode'];

switch($mode)
{
case "delete":
$id=base64_decode($_REQUEST['id']);
$del=DB::getInstance()->delete('admin',array('id','=',$id));
$_SESSION['msg']='Deleted Successfully';
?>
<script>window.location='subadmins.php'</script>
<?php
break;
case "activate":
$id=base64_decode($_REQUEST['id']); 
$up=DB::getInstance()->update('admin','id',$id,$tmpimg= null,$path= null,array('status' => 1));
$_SESSION['msg']="Activated Successfully";
?>
<script>window.location='subadmins.php'</script>
<?php
break;
case "deactivate":
$id=base64_decode($_REQUEST['id']);
$up=DB::getInstance()->update('admin','id',$id,$tmpimg= null,$path= null,array('status' => 0));
$_SESSION['msg']="Deactivated Successfully";
?>
<script>window.location='subadmins.php'</script>
<?php
break;
}


}

if(isset($_REQUEST['deleteselected']))
{
$id=implode(',',$_REQUEST['ch']);
$fg=explode(',',$id);
$cnt=count($fg);
for($a=0;$a<$cnt;$a++)
{
$id=$fg[$a];
$del=DB::getInstance()->delete('admin',array('id','=',$id));
}
$_SESSION['msg']="Selected Items Deleted Successfully";
?>
<script>window.location='subadmins.php'</script>
<?php
}



if(isset($_REQUEST['deactivateselected']))
{
$id=implode(',',$_REQUEST['ch']);
$fg=explode(',',$id);
$cnt=count($fg);
for($a=0;$a<$cnt;$a++)
{
$id=$fg[$a];
$up=DB::getInstance()->update('admin','id',$id,$tmpimg= null,$path= null,array('status' => 0));
}
$_SESSION['msg']="Selected Items Deactivated Successfully";
?>
<script>window.location='subadmins.php'</script>
<?php
}

if(isset($_REQUEST['activateselected']))
{
$id=implode(',',$_REQUEST['ch']);
$fg=explode(',',$id);
$cnt=count($fg);
for($a=0;$a<$cnt;$a++)
{
$id=$fg[$a];
$up=DB::getInstance()->update('admin','id',$id,$tmpimg= null,$path= null,array('status' => 1));
}
$_SESSION['msg']="Selected Items Activated Successfully";
?>
<script>window.location='subadmins.php'</script>
<?php
}
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
<div class="row clearfix">
           <form action="" method="POST">
		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        
                        <div class="body">
                          
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                   <input type="submit" class="btn btn-lg btn-block btn-danger " name="deleteselected" onclick="return confirm('YOU ARE GOING TO DELETE SELECTED ITEMS')"  value="Delete Selected">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                    <input type="submit" class="btn btn-lg btn-block btn-success " name="activateselected" onclick="return confirm('YOU ARE GOING TO ACTIVATE SELECTED ITEMS')"  value="Activate Selected">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                     <input type="submit" class="btn btn-lg btn-block btn-info" name="deactivateselected" onclick="return confirm('YOU ARE GOING TO DEACTIVATE SELECTED ITEMS')"  value="Deactivate Selected">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <a href="add-subadmin.php" class="btn btn-lg btn-warning btn-block pull-right" >Add Subadmin</a>
                                </div>
                            </div>
                        
                    </div>
                </div>
		  
               
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php
						if(isset($_SESSION['msg']))
						{ ?>
						<div class="alert alert-block alert-success text-solve">
								<a class="close" data-dismiss="alert" href="#">X</a>
  								<?php echo $_SESSION['msg'];?>
							</div><?php
							
							} ?>
							
			<?php
						if(isset($_SESSION['err']))
						{ ?>
						<div class="alert alert-block alert-error text-error">
								<a class="close" data-dismiss="alert" href="#">X</a>
  								<?php echo $_SESSION['err'];?>
							</div><?php
							
							} ?>
			</div>				
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
                    <div class="card">
					
                        <div class="header">
                            <h2>
                                Sub Admin
                            </h2>
							
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <!-- <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                   <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>-->
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
												<th>Branch</th>
												<th>Name</th>
												<th>Username</th>
												<th>Password</th>
												<th>Last Login</th>
												
												<th>Added On</th>
												<th>Action</th>
												</tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
												<th>Branch</th>
												<th>Name</th>
												<th>Username</th>
												<th>Password</th>
												<th>Last Login</th>
												
												<th>Added On</th>
												<th>Action</th>
												</tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
								            $per_page = 10;  
								            $del=DB::getInstance()->query("select * from admin ORDER by id DESC");
											$total_results=$del->ount();
											$total_pages = ceil($total_results / $per_page);//total pages we going to have
											
											//-------------if page is setcheck------------------//
											if (isset($_REQUEST['page'])) {
												$show_page = $_REQUEST['page'];             //it will telles the current page
												if ($show_page > 0 && $show_page <= $total_pages) {
													$start = ($show_page - 1) * $per_page;
													$end = $start + $per_page;
												} else {
													// error - show first set of results
													$start = 0;              
													$end = $per_page;
												}
											} else {
												// if page isn't set, show first set of results
												$start = 0;
												$end = $per_page;
											}
											// display pagination
											$page = intval($_REQUEST['page']);

											$tpages=$total_pages;
											if ($page <= 0)
												$page = 1;

											$del=DB::getInstance()->query("select * from admin WHERE login_type!='4' ORDER by id DESC LIMIT $start,$per_page");
											foreach($del->results() as $row)
											{
											  $branchId=$row->branch_id;
											  
											  $branch_name=DB::getInstance()->query("SELECT * FROM `branches` where `id`='$branchId'");
											  $branch_name_row=$branch_name->first();
											  $BranchName=$branch_name_row->name;
											  $BranchAddress=$branch_name_row->address;
											  
											  ?>
												<tr>
												<td><input type="checkbox" value="<?php echo $row->id ;?>" name="ch[]"></td>
										        <td><?php echo $BranchName;?> , <?php echo $BranchAddress;?> </td>
										        <td><?php echo $row->signatory_name;?></td>
										        <td><?php echo $row->username;?></td>
										        <td><?php echo $row->password;?></td>
												<td><?php 
												   $lastLogin=$row->last_login;
												   if($lastLogin=="0000-00-00 00:00:00")
												   {
												     echo "-----";
												   }
												   else
												   {
												     echo date('F j,Y G:i a',strtotime($row->last_login));
												   }
												 ?></td>
												<td><?php echo date('F j,Y',strtotime($row->added_on)); ?></td>
                                              
												<td>
												
												 <?php 
															$status=$row->status;
															switch($status)
															{
															case "1":
															?>
															<a href="subadmins.php?id=<?php echo base64_encode($row->id);?>&mode=deactivate"><i class="material-icons">done_all</i></a> 
															<?php
															break;
															case "0":
															?>
															
															<a href="subadmins.php?id=<?php echo base64_encode($row->id);?>&mode=activate" ><i class="material-icons">clear</i></a> 
															<?php
															break;
															
															}
													?>
													
													<a  href="add-subadmin.php?id=<?php echo base64_encode($row->id);?>&mode=edit" >
												        <i class="material-icons" >create</i>
													</a> 
													
												    <a href="subadmins.php?id=<?php echo base64_encode($row->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS CATEGORY')">
												      <i class="material-icons">delete</i>
													</a> 


												</td>
												
												
												</tr>
											    <?php
												} 
												?>	
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					
                </div>
			
			</form>
</div>



<?php include('common/footer.php'); ?>
