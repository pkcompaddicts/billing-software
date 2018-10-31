<?php 
include('common/header.php');
include('common/sidebar.php');
$date=date('Y-m-d');


	
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
				<div class="span12">
					<div class="box card" style="padding:6px; ">
						<div class="box-head tabs" >
							<h3 style="width:100%">Slips <a class="btn btn-xs btn-success pull-right" href="generate-invoice.php"> Generate New Slip</a></h3>
							
						</div>
						<div class="box-content box-nomargin">
						<div class="box-content">
						<?php
						if($msg!="")
						{
						?>
						<div class="alert alert-block alert-success">
								<a class="close" data-dismiss="alert" href="#">Close</a>
  								<h4 class="alert-heading">Congo!</h4>
  								<?php echo $msg;?>
							</div>
							<?php
							}
							?>
							
					
									
								
							<div class="body">
							<form action="" method="POST">
							<!--<input type="submit" class="btn btn-primary" name="deleteselected" onclick="return confirm('YOU ARE GOING TO DELETE SELECTED ITEMS')"  value="Delete Selected Abstract">-->
									<div  style="/*overflow-x:scroll*/">
										<table class='table table-striped table-bordered'>
											<thead>
												<tr>
												<th style="padding-left:4px;padding-right:4px">Sl NO.</th>
												<!--<th style="padding-left:4px;padding-right:4px"><input type="checkbox" onclick="checkAll(this)"></th>-->
											    <th style="padding-left:4px;padding-right:4px"><b>Invoice No</b></th>
 <th style="padding-left:4px;padding-right:4px">
<b>Customer</b></th>
											
												<th style="padding-left:4px;padding-right:4px"><b>Total Quantity</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Final Amount</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Added On</b></th>
												<th style="padding-left:4px;padding-right:4px"></th>
												<th style="padding-left:4px;padding-right:4px"><b></b></th>
											
												</tr>
											</thead>
											<tbody>
								<?php 
								
								 $per_page = 10;  
								            $del=DB::getInstance()->query("select * from offline_store_invoice WHERE taxable='0' $nowhereadded_by  ORDER by id DESC");
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

											
								$del=DB::getInstance()->query("select * from offline_store_invoice WHERE taxable='0' $nowhereadded_by ORDER by id DESC LIMIT $start,$per_page");
											$sl=0;
											foreach($del->results() as $rt)
											{
											$sl++;
										      $paymentStatus=$rt->payment_status;
											  switch($paymentStatus)
											  {
												  case "0":
												    $rid=base64_encode($rt->id);
												    $status='<a href="installments.php?id='.$rid.'" class="label label-important">Unpaid</a>';
												  break;
												  
												  case "1":
												   $rid=base64_encode($rt->id);
												   $status='<a href="slip-invoice.php?slip='.$rid.'" class="label label-success">Paid</a>';
												  break;
											  }
											?>
												<tr>
												<td style="padding-left:4px;padding-right:4px" ><?php echo $sl; ?></td>
												<!--<td style="padding-left:4px;padding-right:4px" ><input type="checkbox" value="<?php echo $rt->id ;?>" name="ch[]"> </td>-->
										        <td style="padding-left:4px;padding-right:4px"><?php echo $rt->invoice_no;?> </td>
			                                    <td style="padding-left:4px;padding-right:4px"><?php echo $rt->to_name;?> </td>									
													<td style="padding-left:4px;padding-right:4px"><?php echo $rt->total_qty;?> </td>
													<td style="padding-left:4px;padding-right:4px">Rs. <?php echo $rt->final_amount;?> </td>
<td style="padding-left:4px;padding-right:4px"><?php echo date('F j,Y',strtotime($rt->added_on)); ?></td>

<td style="padding-left:4px;padding-right:4px">
<span style="background-color:red; "><?php echo $status;?></span> &nbsp | &nbsp 
<!--<a href="invoices.php?id=<?php echo base64_encode($rt->id);?>" target="_blank" onclick="return confirm('Are you sure?');"><i class="icon-remove"></i></a> &nbsp | &nbsp -->
<a href="send-invoice.php?slip=<?php echo base64_encode($rt->id);?>" style="background-color:red; " target="_blank" onclick="return confirm('Are you sure?');" class="label label-important" >Send On Mail</a>

</td>


<td style="padding-left:4px;padding-right:4px">


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
										   $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
											echo '<div class="pagination"><ul>';
											if ($total_pages > 1) {
												echo DB::getInstance()->paginate($reload, $show_page, $total_pages);
											}
											echo "</ul></div>";
											?>
										
										
									</div>
								</form>
							</div>
						
						</div>
					</div>
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