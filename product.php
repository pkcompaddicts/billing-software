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
$del=DB::getInstance()->delete('products',array('id','=',$id));
$_SESSION['msg']='Deleted Successfully';
?>
<script>window.location='product.php'</script>
<?php
break;
case "activate":
$id=base64_decode($_REQUEST['id']);
$up=DB::getInstance()->update('products','id',$id,$tmpimg= null,$path= null,array('status' => 1));
$_SESSION['msg']="Activated Successfully";
?>
<script>window.location='product.php'</script>
<?php
break;
case "deactivate":
$id=base64_decode($_REQUEST['id']);
$up=DB::getInstance()->update('products','id',$id,$tmpimg= null,$path= null,array('status' => 0));
$_SESSION['msg']="Deactivated Successfully";
?>
<script>window.location='product.php'</script>
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
$del=DB::getInstance()->delete('products',array('id','=',$id));
}
$_SESSION['msg']="Selected Items Deleted Successfully";
?>
<script>window.location='product.php'</script>
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
$up=DB::getInstance()->update('products','id',$id,$tmpimg= null,$path= null,array('status' => 0));
}
$_SESSION['msg']="Selected Items Deactivated Successfully";
?>
<script>window.location='product.php'</script>
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
$up=DB::getInstance()->update('products','id',$id,$tmpimg= null,$path= null,array('status' => 1));
}
$_SESSION['msg']="Selected Items Activated Successfully";
?>
<script>window.location='product.php'</script>
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
<div class="block-header">
                <ol class="breadcrumb breadcrumb-bg-teal align-right">
                                <li><a href="javascript:void(0);"><i class="material-icons">home</i> Home</a></li>
                                <li><a href="javascript:history.back()">Back</a></li>
                               
                            </ol>
            </div>
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
                                <a href="add-product.php" class="btn btn-lg btn-warning btn-block pull-right" >Add <?php echo  ucfirst($product_name); ?></a>
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
							
							<?php
							
							$GetData=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
                            $rowData=$GetData->first();
                            $branch_id=$rowData->branch_id;
							
							$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
				            $branchData_Row=$branchData->first();
							$stockSetting=$branchData_Row->stock_setting;
							?>		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
                    <div class="card">
					
                        <div class="header">
                            <h2>
                               <?php echo  ucfirst($product_name); ?> List
                            </h2>
							
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
												<tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
												<th>Category Name</th>
												<th>Name</th>
												<th>Price</th>
												<th>Remaining Stock</th>
												
												<th>Uploaded On</th>
												<th>Action</th>
												<?php
												if($stockSetting==1)
												{
												?>
												<th></th>
												<?php
												}
												?>
												
												</tr>
											</thead>
											 <tfoot>
                                       <tr>
												<tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
												<th>Category Name</th>
												<th>Name</th>
												<th>Price</th>
												<th>Remaining Stock</th>
												
												<th>Uploaded On</th>
												<th>Action</th>
												<?php
												if($stockSetting==1)
												{
												?>
												<th></th>
												<?php
												}
												?>
												
												</tr>
                                    </tfoot>
											<tbody>
								<?php 
								            $per_page = 10;  
								            $del=DB::getInstance()->query("select * from products ORDER by id DESC");
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

											$del=DB::getInstance()->query("select * from products ORDER by id DESC LIMIT $start,$per_page");
											foreach($del->results() as $row)
											{
										       $catid=$row->category_id;
											   $cate=DB::getInstance()->getmultiple('categories',array('id' => $catid));
											?>
												<tr>
												<td><input type="checkbox" value="<?php echo $row->id ;?>" name="ch[]"></td>
										        <td><?php echo $cate->first()->title;?></td>
										        <td><?php echo $row->title;?></td>
										        <td>Rs. <?php echo $row->set_mrp;?></td>
										        <td><?php echo $row->stock_quantity;?></td>
												<td><?php echo date('F j,Y',strtotime($row->uploaded_on)); ?></td>
                                              
												<td>
												
												 <?php 
															$status=$row->status;
															switch($status)
															{
															case "1":
															?>
															<a href="product.php?id=<?php echo base64_encode($row->id);?>&mode=deactivate" ><i class="material-icons">done_all</i></a> 
															<?php
															break;
															case "0":
															?>
															<a href="product.php?id=<?php echo base64_encode($row->id);?>&mode=activate"  ><i class="material-icons">clear</i></a> 
															<?php
															break;
															
															}
													?>
													
													<a href="add-product.php?id=<?php echo base64_encode($row->id);?>&mode=edit" >
												       <i class="material-icons" >create</i>
													</a> 
													
												    <a href="product.php?id=<?php echo base64_encode($row->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS CATEGORY')">
												      <i class="material-icons">delete</i>
													</a> 


												</td>
												<?php
												if($stockSetting==1)
												{
												?>
												<td><a href="stock-quantity.php?id=<?php echo base64_encode($row->id);?>" class="label label-success btn-inverse" >Stock</a>  </td>
												<?php
											    }
												?>
												
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
