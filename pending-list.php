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
<div class="block-header">
                <ol class="breadcrumb breadcrumb-bg-teal align-right">
                                <li><a href="javascript:void(0);"><i class="material-icons">home</i> Home</a></li>
                                <li><a href="javascript:history.back()">Back</a></li>
                               
                            </ol>
            </div>
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
							
							
							
							
							 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
							 <div class="card">
                        <div class="header">
                            <h2 class="col-lg-6">
                             Pending Invoices
                            </h2>
                        
                        </div>
                        <div class="body">
							 <form action="" method="POST">
							<!--<input type="submit" class="btn btn-primary" name="deleteselected" onclick="return confirm('YOU ARE GOING TO DELETE SELECTED ITEMS')"  value="Delete Selected Abstract">-->
									<div  style="overflow-x:scroll">
										<table class='table table-striped table-bordered'>
											<thead>
												<tr>
												<th >Sl NO.</th>
											    <th ><b>Name</b></th>
												<th ><b>Amount</b></th>
												<th >Due date</th>
												</tr>
											</thead>
											<tbody>
								<?php 
                                            $sl=1;
                                            $Date = date('Y-m-d');
                                            $nextdate=date('Y-m-d', strtotime($Date. ' + 7 day'));
                                             $del=DB::getInstance()->query("select * from offline_store_invoice WHERE payment_status='0' $nowhereadded_by  ORDER by remaining_amount DESC");
                                            $count=$del->ount();
                                           
											
								
											$sl=0;
											foreach($del->results() as $row)
											{
											    $sl++;
										       $invoice=$row->invoice_no;
											   $getinvoice=DB::getInstance()->query("SELECT * FROM offline_store_invoice WHERE `invoice_no`='$invoice'");
											   $frow=$getinvoice->first();
											?>
												<tr>
												<td><?php echo $sl; ?></td>
												<!--<td><input type="checkbox" value="<?php echo $rt->id ;?>" name="ch[]"> </td>-->
										       
			                                    <td ><?php echo $frow->to_name;?> </td>									
			                                    <td >Rs. <?php echo $row->remaining_amount;?> </td>									
												
													
                                             <td ><?php echo date('F j,Y',strtotime($row->invoice_date)); ?></td>




						


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