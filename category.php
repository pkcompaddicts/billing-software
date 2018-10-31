<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['submit']))
{
$date=date('Y-m-d H:i:s');

$subcat=Input::get('subcat');

$seo=DB::getInstance()->seourl($subcat);

$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$find_who_row=$find_who->first();
$upby=$find_who_row->id;

if((!empty($subcat)) || ($subcat!=""))
{
	$up=DB::getInstance()->insert('categories',$tmp= null,$path= null,array('title' => $subcat,'uploaded_by' => $upby, 'uploaded_on' => $date,'status' => 1,'seourl' => $seo));
	$_SESSION['msg']="Category Added Successfully";
  ?>
<script>window.location='category.php'</script>
<?php
}
else
{
  $_SESSION['err']="Please enter category name";
}
}


if(isset($_REQUEST['mode']))
{
$mode=$_REQUEST['mode'];
switch($mode)
{
case "delete":
$id=base64_decode($_REQUEST['id']);
$del=DB::getInstance()->delete('categories',array('id','=',$id));
$_SESSION['msg']='Deleted Successfully';
?>
<script>window.location='category.php'</script>
<?php
break;
case "activate":
$id=base64_decode($_REQUEST['id']);
$up=DB::getInstance()->update('categories','id',$id,$tmpimg= null,$path= null,array('status' => 1));
$_SESSION['msg']="Activated Successfully";
?>
<script>window.location='category.php'</script>
<?php
break;
case "deactivate":
$id=base64_decode($_REQUEST['id']);
$up=DB::getInstance()->update('categories','id',$id,$tmpimg= null,$path= null,array('status' => 0));
$_SESSION['msg']="Deactivated Successfully";
?>
<script>window.location='category.php'</script>
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
$del=DB::getInstance()->delete('categories',array('id','=',$id));
}
$_SESSION['msg']="Selected Items Deleted Successfully";
?>
<script>window.location='category.php'</script>
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
$up=DB::getInstance()->update('categories','id',$id,$tmpimg= null,$path= null,array('status' => 0));
}
$_SESSION['msg']="Selected Items Deactivated Successfully";
?>
<script>window.location='category.php'</script>
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
$up=DB::getInstance()->update('categories','id',$id,$tmpimg= null,$path= null,array('status' => 1));
}
$_SESSION['msg']="Selected Items Activated Successfully";
?>
<script>window.location='category.php'</script>
<?php
}

if(isset($_REQUEST['update']))
{
$date=date('Y-m-d H:i:s');
$id=Input::get('id');

$subcat=Input::get('subcat');


$seo=DB::getInstance()->seourl($subcat);
	

$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$find_who_row=$find_who->first();
$upby=$find_who_row->id;


if((!empty($subcat)) || ($subcat!=""))
{
$up=DB::getInstance()->updatewithoutimage('categories','id',$id,array('title' => $subcat, 'updated_by' => $upby,'updated_on' => $date,'status' => 1,'seourl' => $seo));
$_SESSION['msg']="Updated Successfully";
?>
<script>window.location='category.php'</script>
<?php
}
else
{
	$_SESSION['err']="Please enter category name";
}
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
<div class="block-header">
                <ol class="breadcrumb breadcrumb-bg-teal align-right">
                                <li><a href="javascript:void(0);"><i class="material-icons">home</i> Home</a></li>
                                <li><a href="javascript:history.back()">Back</a></li>
                               
                            </ol>
            </div>
			
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
	$del=DB::getInstance()->get('categories',array('id','=',$id));
	?>
				<div class="card">
                        <div class="header">
                            <h2>
                               Update category
                            </h2>
                            
                        </div>
                        <div class="body">
	<form method="post" action="" enctype="multipart/form-data">
	<div class="row clearfix">
<input type="hidden" name="id" value="<?php echo $id ?>">
						
								<div class="col-sm-6">
<label for="grid12">Update Sub Category :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="grid12"  name="subcat" class="form-control" value="<?php echo $del->first()->title; ?>">
                                    </div>
                                </div>	
</div>								<div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="update" value="Update">	
									</div>
									

									</form>
									
								
							</div>
						
						</div></div>
					
		
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
                               Add category
                            </h2>
                            
                        </div>
                        <div class="body">
	
										<form method="post" action="" enctype="multipart/form-data">
										<div class="row clearfix">
							<div class="col-sm-6">
<label for="grid12">Enter Category :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="grid12"  name="subcat" class="form-control" placeholder="Enter Category">
                                    </div>
                                </div>	
</div>
<div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="submit" value="Submit">
									
								</div>

									</form>
									</div>
								
							</div>
						
						</div>
				

			
			
<?php

}	?>
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
                                <!--<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <a href="add-subadmin.php" class="btn btn-lg btn-warning btn-block pull-right" >Add Subadmin</a>
                                </div>-->
                            </div>
                        
                    </div>
                </div>
						 
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
                    <div class="card">
					
                        <div class="header">
                            <h2>
                                Sub Admin
                            </h2>
							
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
										
												<th>Category Name</th>
												
												<th>Uploaded On</th>

												
												<th>Action</th>
												</tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
										
												<th>Category Name</th>
												
												<th>Uploaded On</th>

												
												<th>Action</th>
												</tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
								            $per_page = 10;  
								            $del=DB::getInstance()->query("select * from categories ORDER by id DESC");
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

											$del=DB::getInstance()->query("select * from categories ORDER by id DESC LIMIT $start,$per_page");
											foreach($del->results() as $row)
											{
										    $uid=$row->uid;
											
											?>
												<tr>
												<td><input type="checkbox" value="<?php echo $row->id ;?>" name="ch[]"></td>
										        <td><?php echo $row->title;?></td>
												<td><?php echo date('F j,Y',strtotime($row->uploaded_on)); ?></td>
                                              
												<td>
												
												 <?php 
															$status=$row->status;
															switch($status)
															{
															case "1":
															?>
															<a href="category.php?id=<?php echo base64_encode($row->id);?>&mode=deactivate" ><i class="material-icons">done_all</i></a> 
															<?php
															break;
															case "0":
															?>
															<a href="category.php?id=<?php echo base64_encode($row->id);?>&mode=activate" ><i class="material-icons">clear</i></a> 
															<?php
															break;
															
															}
													?>
													
													<a href="category.php?id=<?php echo base64_encode($row->id);?>&mode=edit" >
												       <i class="material-icons" >create</i>
													</a> 
													
												    <a href="category.php?id=<?php echo base64_encode($row->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS CATEGORY')">
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
