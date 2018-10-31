<?php 
include('common/header.php');
include('common/sidebar.php');
$date=date('Y-m-d');

$uid=base64_decode($_REQUEST['uid']);
	
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
                        <div class="header">
                            <h2>
                                Users Invoices
                            </h2>
							</div>
                        <div class="body">
						<form action="" method="POST">
						<div class="table-responsive">
						
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                       <tr>
												<th>Sl NO.</th>
												<!-- <th><input type="checkbox" onclick="checkAll(this)"></th>-->
											    <th><b>Invoice No</b></th>
                                                <th><b>Customer</b></th>
												 <th><b>Total Quantity</b></th>
												 <th><b>Final Amount</b></th>
												 <th><b>Added On</b></th>
												 <th></th>
												 <th><b></b></th>
												</tr>
                                    </thead>
                                    <tfoot>
                                       <tr>
												<th>Sl NO.</th>
												<!-- <th><input type="checkbox" onclick="checkAll(this)"></th>-->
											    <th><b>Invoice No</b></th>
                                                <th><b>Customer</b></th>
												 <th><b>Total Quantity</b></th>
												 <th><b>Final Amount</b></th>
												 <th><b>Added On</b></th>
												 <th></th>
												 <th><b></b></th>
												</tr>
                                    </tfoot>
                                    <tbody>
                                        	<?php 
								
								 $per_page = 10;  
								            $del=DB::getInstance()->query("select * from offline_store_invoice WHERE `distributor_id`='$uid' ORDER by id DESC");
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

											
								$del=DB::getInstance()->query("select * from offline_store_invoice `distributor_id`='$uid'  ORDER by id DESC LIMIT $start,$per_page");
											$sl=0;
											foreach($del->results() as $rt)
											{
											$sl++;
										      $paymentStatus=$rt->payment_status;
											  switch($paymentStatus)
											  {
												  case "0":
												    $status='<a class="label label-important">Unpaid</a>';
												  break;
												  
												  case "1":
												   $status='<a class="label label-success">Paid</a>';
												  break;
											  }
											?>
												<tr>
												<td  ><?php echo $sl; ?></td>
												<!--<td  ><input type="checkbox" value="<?php echo $rt->id ;?>" name="ch[]"> </td>-->
										        <td ><?php echo $rt->invoice_no;?> </td>
			                                    <td ><?php echo $rt->to_name;?> </td>									
													<td ><?php echo $rt->total_qty;?> </td>
													<td >Rs. <?php echo $rt->final_amount;?> </td>
<td ><?php echo date('F j,Y',strtotime($rt->added_on)); ?></td>
<td>
<span style="background-color:red; "><?php echo $status;?></span>|<a href="send-invoice.php?slip=<?php echo base64_encode($rt->id);?>" style="background-color:red; " target="_blank" onclick="return confirm('Are you sure?');" class="label label-important" >Send On Mail</a>
</td>

  
<!--<a href="invoices.php?id=<?php //echo base64_encode($rt->id);?>" target="_blank" onclick="return confirm('Are you sure?');"><i class="icon-remove"></i></a> &nbsp | &nbsp -->





<td >


<select style="width: 130px;" onchange="up(this.value,'<?php echo base64_encode($rt->id);?>')" >

<option value="" >Select Action</option>

<option value="slip-invoice">See Slip</option>
<?php
	if($paymentStatus==0)
		{
?>
<option value="add-installment">Add Installment</option>
<?php
		}
?>
<option value="installments">View All Installments</option>


</select>



</td>						


												</tr>
													<?php } ?>		
												
											</tbody>
										</table>
										<?php
										   
										   $reload = $_SERVER['PHP_SELF'] . "?uid=".$_REQUEST['uid']."&tpages=" . $tpages;
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
						</form>
						
						
						</div>
						</div>

									
			
			<script>
			function up(val,id)
			{
			var url=val + '.php';
			
			if((val == 'slip-invoice'))
			{
				window.open(url + '?slip='+id, '_blank');
			}
			else
			{
				window.location=url + '?id='+id;
			}
			
			}
			</script>
			
			
		</div>	
	</div>
</div>	
<?php include('common/footer.php'); ?>