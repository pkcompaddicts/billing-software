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
$del=DB::getInstance()->delete('expense_income',array('id','=',$id));
$_SESSION['msg']='Deleted Successfully'; 
?>
<script>window.location='expense.php'</script>
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
$del=DB::getInstance()->delete('expense_income',array('id','=',$id));
}
$_SESSION['msg']="Selected Items Deleted Successfully";
?>
<script>window.location='expense.php'</script>
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
                                <!--<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                    <input type="submit" class="btn btn-lg btn-block btn-success " name="activateselected" onclick="return confirm('YOU ARE GOING TO ACTIVATE SELECTED ITEMS')"  value="Activate Selected">
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                     <input type="submit" class="btn btn-lg btn-block btn-info" name="deactivateselected" onclick="return confirm('YOU ARE GOING TO DEACTIVATE SELECTED ITEMS')"  value="Deactivate Selected">
                                </div>--->
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <a href="add-expense.php" class="btn btn-lg btn-warning btn-block pull-right" >Add Expence</a>
                                </div>
                            </div>
                        
                    </div>
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
                               Expenses List 
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
												<tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
												<th>Type</th>
												<th>Branch</th>
												<!--<th>Category</th>-->
												<th>Given By</th>
												<th>Received By</th>
												<th>Amount</th>
												<th>Paid On</th>
												<th>Payment</th>
												<th>Remarks</th>
												<th>Action</th>
												
												</tr>
											</thead>
											
											<tbody>
								<?php 
								             $per_page = 10;  
								            $del=DB::getInstance()->query("select * from expense_income  $whereadded_by ORDER by id DESC");
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

											$del=DB::getInstance()->query("select * from expense_income $whereadded_by  ORDER by id DESC LIMIT $start,$per_page");
											foreach($del->results() as $row)
											{
											   $branchId=$row->branch_id;
											   $entry_type=$row->entry_type;
											  
											   $branch_name=DB::getInstance()->query("SELECT * FROM `branches` where `id`='$branchId'");
											   $branch_name_row=$branch_name->first();
											   $BranchName=$branch_name_row->name;
											   $BranchAddress=$branch_name_row->address;
											   
										       $catid=$row->category_id;
											   $cate=DB::getInstance()->getmultiple('expense_category',array('id' => $catid));
											   
											   switch($entry_type)
											   {
												   case "1":
												     $entryType="Debit";
												   break;
												   
												   case "2":
												    $entryType="Credit";
												   break;
											   }
											?>
												<tr>
												<td><input type="checkbox" value="<?php echo $row->id ;?>" name="ch[]"></td>
										        <td><?php echo $entryType;
												 
												?><br/><b>Category:</b><?php echo  $cate->first()->title; ?></td>
										        <td><?php echo $BranchName;?> , <?php echo $BranchAddress;?></td>
										        <!--<td><?php echo $cate->first()->title;?></td>-->
										        <td>
												    <b>Name : </b> <?php echo $row->given_by_name;?>
												  <?php
												  if($row->given_by_email!="")
												  {
													  ?>
												   <br/><b>Email : </b> <?php echo $row->given_by_email;?>
													  <?php
												  }
												   if($row->given_by_contact!="")
												  {
													  ?>
												   <br/><b>Contact : </b> <?php echo $row->given_by_contact;?>
													  <?php
												  }
												  ?>
												</td>
										        <td>
												   <b>Name : </b> <?php echo $row->received_by_name;?>
												  <?php
												  if($row->received_by_email!="")
												  {
													  ?>
												   <br/><b>Email : </b> <?php echo $row->received_by_email;?>
													  <?php
												  }
												   if($row->received_by_contact!="")
												  {
													  ?>
												   <br/><b>Contact : </b> <?php echo $row->received_by_contact;?>
													  <?php
												  }
												  ?>
												</td>
										        <td>Rs. <?php echo $row->amount;?></td>
										        <td><?php echo date('F j,Y',strtotime($row->payment_date)); ?></td>
										        <td>
												   <?php
												$payment_mode=$row->payment_mode;
												
												switch($payment_mode)
												{
													case "1":  //**** Cash
													
													    ?>
														 <b>Payment Mode : </b> Cash
														<?php
														
													break;
													
													case "2":  //**** Cheque
													
													    ?>
														 <b>Payment Mode : </b> Cheque<br/>
														 <b>Cheque No. : </b> <?php echo $row->cheque_reference_no; ?><br/>
														 <b>Cheque Date : </b> <?php echo date('F j,Y',strtotime($row->cheque_date)); ?><br/>
														 <b>Bank Name : </b> <?php echo $row->bank_name; ?><br/>
														 <b>Bank Branch : </b> <?php echo $row->bank_branch; ?>
														<?php
														
													break;
													
													case "3":  //**** Others
													   ?>
														 <b>Payment Mode : </b> Others<br/>
														 <b>Reference No. : </b> <?php echo $row->cheque_reference_no; ?>
														<?php
													break;
												}
												?>
												</td>
												<td>
												<?php 
												  if($row->remarks!="")
												  {
													echo $row->remarks;  
												  }
												  else
												  {
													  echo "----";
												  }	
												  ?></td>
                                              
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
													
													<a href="add-expense.php?id=<?php echo base64_encode($row->id);?>&mode=edit" >
												       <i class="material-icons" >create</i>
													</a> 
													
												    <a href="expense.php?id=<?php echo base64_encode($row->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS CATEGORY')">
												      <i class="material-icons">delete</i>
													</a> 


												</td>
												</tr>
											    <?php
												} 
												?>		
												
											 </tbody>
                                </table>
								<?php
								   $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
									echo '<div class="pagination"><ul>';
									if ($total_pages > 1) {
										echo DB::getInstance()->paginate($reload, $show_page, $total_pages);
									}
									echo "</ul></div>";
								?>
										
                            </div>
                        </div>
                    </div>
					
                </div>
			
			</form>
</div>


<?php include('common/footer.php'); ?>
