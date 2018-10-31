<?php 
include('common/header.php');
include('common/sidebar.php');
$date=date('Y-m-d');
if(isset($_REQUEST['mode']))
{
  $mode=$_REQUEST['mode'];
  
  switch($mode)
  {
    case "delete":
	  
	  $id=base64_decode($_REQUEST['id']);
	  $del=DB::getInstance()->delete('users',array('id','=',$id));
	  
	  $del=DB::getInstance()->query("DELETE FROM offline_store_installment WHERE basic_tbl_id IN (SELECT id FROM offline_store_invoice WHERE distributor_id='$id')");
	 
	  $get=DB::getInstance()->query("SELECT * FROM offline_store_product_details WHERE basic_tbl_id IN (SELECT id FROM offline_store_invoice WHERE distributor_id='$id')");
	  foreach($get->results() as $rt)
	  {
	    $pro_rid=$rt->id;
	    $skuId=$rt->productsku_id; 
	    $product_id=$rt->product_id;
		
		if($skuId!="")
		{
		  $exsku=explode(',',$skuId);
		  $excount=count($exsku);
		  for($b=0;$b<$excount;$b++)
		  {
			  $skname=$exsku[$b];
			  $getSku=DB::getInstance()->getmultiple('product_stock_skuid',array('productid' => $product_id,'skuid' => $skname));
			  $rid=$getSku->first()->id;
		  
			  $up=DB::getInstance()->updatewithoutimage('product_stock_skuid','id',$rid,array('sold_status' => '0')); 
			  
		  }
		}
		
	    DB::getInstance()->delete('offline_store_product_details',array('id','=',$pro_rid));
	  }
	  
	  $del=DB::getInstance()->delete('offline_store_invoice',array('distributor_id','=',$id));
	  
	  ?>
	    <script>window.location='users.php?msg=Member Deleted Successfully'</script>
     <?php
	 
	break;
  }
}

$where=$whereadded_by;
if($_REQUEST['search']!=''){
   $key = $_REQUEST['search'];
   $where = "WHERE name LIKE '%".$key."%' OR email LIKE '%".$key."%' OR contact  LIKE '%".$key."%' OR customer_registration_number LIKE '%".$key."%' $nowhereadded_by ";
}

	
?>

<style>
.table.table-bordered tbody td{
	    text-align: center;
}
.table thead th
{
	font-weight:bold !important;
	text-shadow:0 0px 0 !important;
	background:#333 !important;
	color: #fff !important;
    border-color: #000 !important;
}

</style>


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

		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Users
                            </h2>
							</div>
                        <div class="body">
<form action="" method="POST">
<div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                       <tr>
												<th >Sl NO.</th>
												<!--<th ><input type="checkbox" onclick="checkAll(this)"></th>-->
											    <th ><b>Name</b></th>
                                                <th >
                                                <b>Email</b></th>
											
												<th ><b>Contact</b></th>
												<th ><b>Address</b></th>
												<th ><b>Added On</b></th>
												<th ><b></b></th>
												</tr>
                                    </thead>
                                    <tfoot>
                                       <tr>
												<th >Sl NO.</th>
												<!--<th ><input type="checkbox" onclick="checkAll(this)"></th>-->
											    <th ><b>Name</b></th>
                                                <th >
                                                <b>Email</b></th>
											
												<th ><b>Contact</b></th>
												<th ><b>Address</b></th>
												<th ><b>Added On</b></th>
												<th ><b></b></th>
												</tr>
                                    </tfoot>
                                    <tbody>
                                        	<?php 
								
								 $per_page = 10;  
								            $del=DB::getInstance()->query("select * from users $where ORDER by id DESC ");
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

											
								$del=DB::getInstance()->query("select * from users $where ORDER by id DESC LIMIT $start,$per_page");
											$sl=0;
											foreach($del->results() as $rt)
											{
											$sl++;
										    
											?>
												<tr>
												<td><?php echo $sl; ?></td>
												<!--<td><input type="checkbox" value="<?php echo $rt->id ;?>" name="ch[]"> </td>-->
										        <td ><?php echo $rt->name;?> </td>
			                                    <td ><?php echo $rt->email;?> </td>									
												<td ><?php echo $rt->contact;?> </td>
												<td ><?php echo $rt->address;?> </td>
                                                <td ><?php echo date('F j,Y g:i a',strtotime($rt->added_on)); ?></td>
                                                <td ><a href="user-invoices.php?uid=<?php echo base64_encode($rt->id);?>" target="_blank" class="label label-success btn-inverse" >See Invoices</a>
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
											   
                                    </tbody>
                                </table>
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
			
<?php include('common/footer.php'); ?>