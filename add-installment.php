<?php 
include('common/header.php');
include('common/sidebar.php');


$service_id=$_REQUEST['id'];

$service_id=base64_decode($service_id);



if(isset($_REQUEST['submit']))
{
   $rid=$_REQUEST['rid'];
   $total_amount=$_REQUEST['total_amount'];
   $remaining_amountold=$_REQUEST['remaining_amount'];
   $amount=$_REQUEST['amount'];
   $paid_on=$_REQUEST['paid_on'];
   $next_installment=$_REQUEST['next_installment'];
   $remark=$_REQUEST['remark'];
   
   if($amount > $remaining_amountold)
   {
     $_SESSION['err']="Amount can not be greater than remaining amount ( Rs. ".$remaining_amountold.")";
   }
   else
   {
   $remaining_amount = $remaining_amountold - $amount;
   
  $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
  $find_who_row=$find_who->first();
  $added_by=$find_who_row->id;
  
   $date=date('Y-m-d H:i:s');
   
   if(($remaining_amount==0) || ($remaining_amountold==$amount))
   {
     $paid=1;
   }
   else
   {
     $paid=0;
   }
   
   $InvDet=DB::getInstance()->get('offline_store_invoice',array('id','=',$rid));
   $InvDet_Row=$InvDet->first();
  $invoiceNo=$InvDet_Row->invoice_no;
  

    $in=DB::getInstance()->insert('offline_store_installment',null,null,array('basic_tbl_id' => $rid,'invoice_no' => $invoiceNo,'total_amount' => $total_amount,'current_installment_amount' => $amount,'remaining_amount' => $remaining_amount,'paid_on' => $paid_on,'next_installment' => $next_installment,'remark' => $remark,'added_on' => $date,'added_by' => $added_by));
	
   
   $up=DB::getInstance()->updatewithoutimage('offline_store_invoice','id',$rid,array('remaining_amount' => $remaining_amount,'payment_status' => $paid));
   
   $id=base64_encode($rid);
   
   $_SESSION['msg']="Installment added successfully";
   ?>
   <script>window.location='installments.php?id=<?php echo $id; ?>'</script>
   <?php
   }
}

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
          <div class="card col-lg-12 col-md-12 col-sm-12 col-xs-12">	
                    <div class="">
					<div class="header">
                            <h2>
                               Add Installment
                            </h2>
							
                            
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
							
                        <div class="body">
						<form method="post" action="" enctype="multipart/form-data">
						 <input type="hidden" name="rid" value="<?php echo $service_id; ?>">
												
												<input type="hidden" name="total_amount" id="total_amount" value="<?php echo $row->final_amount; ?>">
												<input type="hidden" name="remaining_amount" id="remaining_amount" value="<?php echo $row->remaining_amount; ?>">
						<div class="col-sm-6">
                           <label for="amt">Amount Paid in this Installment :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="amount" onblur="checkval()" id="amt" class="form-control"  placeholder="Amount">
                                    </div>
									<p class="help-block"  id="err_msg">
												Amount can not be greater than remaining amount ( Rs. <?php echo $row->remaining_amount; ?> )
											</p>
                                </div>	
								
                        </div>
						
						<div class="col-sm-6">

                               <label for="datepick">Paid On :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" name="paid_on" id="datepicker" class="form-control datepick"  >
                                    </div>
                                </div>	
						</div>
						<div class="col-sm-6">

                          <label for="datepicker">Next Payment Date :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="datepicker"   name="next_installment" class="form-control datepick"  >
                                    </div>
                                </div>	
						</div>
						<div class="col-sm-6">

						<label for="Remark">Remark :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="Remark"   name="remark" placeholder="Add your remark" class="form-control datepick"  >
                                    </div>
                                </div>	
                     </div>
					<div class="col-sm-6">
					<input type="submit" class="btn btn-green3" name="submit" value="Submit">
					</div>
					</div>		</form>
				</div>
		     </div>	
		</div>


<script>

	function checkval()
			{
			   var rm=parseFloat(document.getElementById('remaining_amount').value);
			   var amtnt=parseFloat(document.getElementById('amt').value);
			   
			   if(amtnt > rm)
			   {
			      alert('Amount can not be greater than remaining amount (Rs. '+ rm +')');
				  document.getElementById('err_msg').style.color="red";
			   }
			   else
			   {
			     document.getElementById('err_msg').style.color="black";
			   }
			}
			
</script>
<?php include('common/footer.php'); ?>
