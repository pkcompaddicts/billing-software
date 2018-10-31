<?php 
include('common/header.php');
include('common/sidebar.php');


$service_id=$_REQUEST['id'];

$service_id=base64_decode($service_id);



$del=DB::getInstance()->query("SELECT * from `offline_store_invoice` where `id`='$service_id'");
$row=$del->first();

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
           
		  
                    <div class="card">
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
									<div class="header">
                            <h2>
                               Package Installment
                            </h2>
                            <h3 style="width:100%">
							<?php
													if($row->payment_status==0)
													{
													?>
							<a href="add-installment.php?id=<?php echo $_REQUEST['id']; ?>" class="btn btn-success btn-mini pull-right">Add Next Installment</a>
							<?php
							}
							?></h3>
                        </div>
                        <div class="body">
						<div class="table-responsive">
						
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                       <tr>
												<th > Sl No. </th>
													
													<th >Total Amount</th>
													
													<th >Amount Paid</th>
													
													<th >Remaining Amount</th>
													
													<th >Date</th>
												
													<th >Next Payment Date</th>
												
													<th>Remarks</th>
												</tr>
                                    </thead>
                                    <tfoot>
                                       <tr>
												<th > Sl No. </th>
													
													<th >Total Amount</th>
													
													<th >Amount Paid</th>
													
													<th >Remaining Amount</th>
													
													<th >Date</th>
												
													<th >Next Payment Date</th>
												
													<th>Remarks</th>
												</tr>
                                    </tfoot>
                                    <tbody>
<?php 
								            $per_page = 10;  
								            $del=DB::getInstance()->query("select * from offline_store_installment WHERE basic_tbl_id='$service_id' ORDER by id DESC");
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

												$sl=1;
											$del=DB::getInstance()->query("select * from offline_store_installment WHERE basic_tbl_id='$service_id' ORDER by id DESC LIMIT $start,$per_page");
											foreach($del->results() as $row)
											{
										    $uid=$row->uid;
											$next_installment=$row->next_installment;
											$remark=$row->remark;
											
											if($next_installment=="0000-00-00")
											{
											  $next_installment="----";
											}
											else
											{
											  $next_installment=date('F j,Y',strtotime($row->next_installment));
											}
											
											if($remark=="")
											{
											  $remark="----";
											}
											else
											{
											  $remark=$remark;
											}
											?>
												<tr>
													<td><?php echo $sl;?></td>
											
											<td>Rs. <?php echo $row->total_amount;?></td>
											<td>Rs. <?php echo round($row->current_installment_amount,2);?></td>
											<td >Rs. <?php echo round($row->remaining_amount,2);?></td>
											<td ><?php echo date('F j,Y',strtotime($row->paid_on));?></td>
											<td ><?php echo $next_installment;?></td>
											<td ><?php echo $remark;?><!--  &nbsp&nbsp <a href="edit-installment.php?id=<?php echo base64_encode($row->id)?>"><i class="icon-edit bigger-120"></i>--></td>
												
												</tr>
											    <?php
												$sl++;
												} 
												?>		
												
											</tbody>
										</table>
										<?php
										  $rowId=base64_encode($service_id);
										   $reload = $_SERVER['PHP_SELF'] . "?id=".$rowId."&tpages=" . $tpages;
											echo '<div class="pagination"><ul>';
											if ($total_pages > 1) {
												echo DB::getInstance()->paginate($reload, $show_page, $total_pages);
											}
											echo "</ul></div>";
											?>
											   
                                    </tbody>
                                </table>
                            </div>
						
						</div>
						</div>
						</div>



<?php include('common/footer.php'); ?>
