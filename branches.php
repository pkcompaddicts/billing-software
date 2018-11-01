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
$del=DB::getInstance()->delete('branches',array('id','=',$id));
$_SESSION['msg']='Deleted Successfully';
?>
<script>window.location='branches.php'</script>
<?php
break;
case "activate":
$id=base64_decode($_REQUEST['id']);
$up=DB::getInstance()->update('branches','id',$id,$tmpimg= null,$path= null,array('status' => 1));
$_SESSION['msg']="Activated Successfully";
?>
<script>window.location='branches.php'</script>
<?php
break;
case "deactivate":
$id=base64_decode($_REQUEST['id']);
$up=DB::getInstance()->update('branches','id',$id,$tmpimg= null,$path= null,array('status' => 0));
$_SESSION['msg']="Deactivated Successfully";
?>
<script>window.location='branches.php'</script>
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
$del=DB::getInstance()->delete('branches',array('id','=',$id));
}
$_SESSION['msg']="Selected Items Deleted Successfully";
?>
<script>window.location='branches.php'</script>
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
$up=DB::getInstance()->update('branches','id',$id,$tmpimg= null,$path= null,array('status' => 0));
}
$_SESSION['msg']="Selected Items Deactivated Successfully";
?>
<script>window.location='branches.php'</script>
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
$up=DB::getInstance()->update('branches','id',$id,$tmpimg= null,$path= null,array('status' => 1));
}
$_SESSION['msg']="Selected Items Activated Successfully";
?>
<script>window.location='branches.php'</script>
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
                                <a href="add-branch.php" class="btn btn-lg btn-warning btn-block pull-right" >Add Branches</a>
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
						</div>
						
						<?php
							
							} ?>
							
			          <?php
						if(isset($_SESSION['err']))
						{ ?>
						   <div class="alert alert-block alert-error text-error">
								<a class="close" data-dismiss="alert" href="#">X</a>
								<?php echo $_SESSION['err'];?>
							 </div>
						<?php
							
							} ?>
					</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
                    <div class="card">
					
                        <div class="header">
                            <h2>
                                Branches
                            </h2>
							
                            <ul class="header-dropdown m-r--5">
                                <!--<li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>-->
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                       <tr>
										<th><input type="checkbox" onclick="checkAll(this)"></th>
										<th>Name</th>
										<th>Address</th>
										<th>Contact Details</th>
										<th>Logo</th>
										<th>Branch Type</th>
										<th>Added On</th>
										<th>Action</th>
										<!--<th></th>-->
									   </tr>
                                    </thead>
                                    <tfoot>
                                       <tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
												<th>Name</th>
												<th>Address</th>
												<th>Contact Details</th>
												<th>Logo</th>
												
												<th>Branch Type</th>
												<th>Added On</th>
												<th>Action</th>
												<!--<th></th>-->
												</tr>
                                    </tfoot>
                                    <tbody>
                                        	<?php 
								            $per_page = 10;  
								            $del=DB::getInstance()->query("select * from branches ORDER by id DESC");
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

											$del=DB::getInstance()->query("select * from branches ORDER by id DESC LIMIT $start,$per_page");
											foreach($del->results() as $row)
											{
												 $branchType=$row->branch_type;
												 
												 switch($branchType)
												 {
													 case "1":
													 
													  $branch_type="Head office";
													  
													 break;
													 
													 case "2":
													 
													  $branch_type="Branch office";
													  
													 break;
												 }
											?>
												<tr>
												<td><input type="checkbox" value="<?php echo $row->id ;?>" name="ch[]"></td>
										        <td><a href="<?php echo $row->website;?>" target="_blank"><?php echo $row->name;?></a></td>
										        <td><?php echo $row->address;?></td>
										        <td>
												   <b>Email :  </b> <?php echo $row->email;?><br/>
												   <b>Contact :  </b> <?php echo $row->number;?><br/>
												   
												</td>
										        <td><img src="logo/<?php echo $row->logo; ?>" style="width:150px"></td>
										       
										        <td><?php echo $branch_type;?></td>
												<td><?php echo date('F j,Y',strtotime($row->added_on)); ?></td>
                                              
												<td>
												
												 <?php 
														if($branchType!=1)
														{
															$status=$row->status;
															switch($status)
															{
															case "1":
															?>
															<a href="branches.php?id=<?php echo base64_encode($row->id);?>&mode=deactivate" ><i class="material-icons">done_all</i></a> 
															<?php
															break;
															case "0":
															?>
															<a href="branches.php?id=<?php echo base64_encode($row->id);?>&mode=activate" ><i class="material-icons">clear</i></a> 
															<?php
															break;
															
															}
															
															?>
															
												    <a href="branches.php?id=<?php echo base64_encode($row->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS CATEGORY')">
												           <i class="material-icons">delete</i>
													</a> 


															<?php
											            }
														
													?>
													
													<a href="add-branch.php?id=<?php echo base64_encode($row->id);?>&mode=edit" >
												       <i class="material-icons" >create</i>
													</a> 
													
												</td>
												
											<!--	<td><a href="#viewDetails" onclick="detailBranch("<?php echo $row->id;?>")" class="label label-success btn-inverse" >View Details</a>  </td>-->
												
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
