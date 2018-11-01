<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['submitSlip']))
{

$customerid=$_REQUEST['customerid'];
$from_name=Input::get('name');
$from_email=Input::get('from_email');
$from_contact=Input::get('from_contact');	
$from_address=nl2br(Input::get('from_address')); 
$from_gst_number=Input::get('from_gst_number');

$to_name=Input::get('to_name');		
$to_email=Input::get('to_email');
$to_contact=Input::get('to_contact');	
$to_address=nl2br(Input::get('to_address'));
$to_state=Input::get('to_state');	
$to_gst_number=Input::get('to_gst_number');	
  
 $payment_type=Input::get('payment_type');	
$reference_no=Input::get('reference_no');	
 if(($payment_type=="cash") || ($payment_type==""))
   {
     $reference_no="";
   }
   else
   {
    $reference_no=$_REQUEST['reference_no'];
   }

   
if($customerid=="new")
	{ 
		
		$added_on=date('Y-m-d H:i:s');
		
		$find_who=DB::getInstance()->query("SELECT * from `admin` where `username`='".$_SESSION['username']."'");
        $find_who_row=$find_who->first();
	
	   $added_by=$find_who_row->id;
	
		$in=DB::getInstance()->insert('users',null,null,array('name' => $to_name,'email' => $to_email,'contact' => $to_contact,'address' => $to_address,'state' => $to_state,'gst_number' => $to_gst_number,'added_on' => $added_on,'added_by' => $added_by));
		$customerid=DB::getInstance()->lastinsert();
		
	} 
$invoice_no=Input::get('invoice_no'); 
$invoice_date=Input::get('invoice_date');	
$due_date=Input::get('due_date');

$taxable=Input::get('taxable');
$tax_rate=Input::get('tax_rate');	
$inclusive=Input::get('inclusive');

if((!isset($inclusive)) || ($inclusive==""))
{
	$inclusive=0;
}


if($taxable==0)
{
	$redirectLink="non-taxable-invoices.php";
}
else
{
	$redirectLink="taxable-invoices.php";
}



$discount_type=Input::get('discount_type');
$discount_in=Input::get('discount_in');	

if($discount_type==0)
{
  $discount=0;
  $discount_in=0;
}


$payment_status=Input::get('payment_status'); 

if((!isset($payment_status)) || ($payment_status==""))
{
	$payment_status=0;
}

$first_installment=Input::get('first_installment');	

$payment_date=Input::get('payment_date');


$total_amount=Input::get('total_amount');
$taxrate_amount=Input::get('taxrate_amount');
$final_amount=Input::get('final_amount');
$balance_due=Input::get('balance_due');	
 

$note=Input::get('note');
$note=nl2br($note);
$find_who=DB::getInstance()->query("SELECT * from `admin` where `username`='".$_SESSION['username']."'");
$find_who_row=$find_who->first();

$added_on=date('Y-m-d H:i:s');
$added_by=$find_who_row->id;
	
if(($balance_due=="0.00") && ($balance_due=="0"))
{
  $payment_status="1";
}	

$usertype="customer";
$distributor_id=$customerid;
 
$errbk=0;
$lmt = count($_REQUEST['book_name']);
for($j= 0; $j<$lmt; $j++)
{
  $bookname = $_REQUEST['book_name'][$j];
  if((empty($bookname)) || ($bookname==""))
  {
    $errbk++;
  }
}

if($errbk==0)
{
$in=DB::getInstance()->insert('offline_store_invoice',null,null,array('usertype' => $usertype,'distributor_id' => $distributor_id,'invoice_no' => $invoice_no,'from_name' => $from_name,'from_email' => $from_email,'from_contact' => $from_contact,'from_address' => $from_address,'from_gst_number' => $from_gst_number,'to_name' => $to_name,'to_email' => $to_email,'to_contact' => $to_contact,'to_address' => $to_address,'to_state' => $to_state,'to_gst_number' => $to_gst_number,'invoice_date' => $invoice_date,'due_date' => $due_date,'taxable' => $taxable,'tax_rate' => $tax_rate,'inclusive_exclusive' => $inclusive,'currency' => 'rs','total_amount' => $total_amount,'taxrate_amount' => $taxrate_amount,'final_amount' => $final_amount,'discount_type' => $discount_type,'note' => $note,'payment_status' => $payment_status,'first_installment' => $first_installment,'payment_date' => $payment_date,'remaining_amount' => $balance_due,'added_on' => $added_on,'added_by' => $added_by));

$LastId=DB::getInstance()->lastinsert();

$limit = count($_REQUEST['book_name']);

$totalQuantity=0;
for($i= 0; $i<$limit; $i++)
{
  $book_name = $_REQUEST['book_name'][$i];
  $book_id = $_REQUEST['book_id'][$i];
  $j=$i + 1;
  $sk="sku".$j;
  if((isset($_REQUEST[$sk])) || ($_REQUEST[$sk]!=""))
  {
  $skuId = implode(',',$_REQUEST[$sk]);
  }
  else
  {
   $skuId="";
  }
  $unit_price = $_REQUEST['unit_price'][$i];
  $qty = $_REQUEST['qty'][$i];
  $bookdiscount = $_REQUEST['discountamount'][$i];
  $amount = $_REQUEST['amount'][$i];
  
  $totalamount = $unit_price * $qty;
  $totalamount=round($totalamount,2);
  
  $totalQuantity = $totalQuantity + $qty;
  
  
  $in=DB::getInstance()->insert('offline_store_product_details',null,null,array('basic_tbl_id' => $LastId,'invoice_no' => $invoice_no,'productsku_id' => $skuId,'product_id' => $book_id,'product_name' => $book_name,'quantity' => $qty,'unit_price' => $unit_price,'total_amount' => $totalamount,'discount_in' => $discount_in,'discount_amount' => $bookdiscount,'final_amount' => $amount));
  
 	$GetData=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
    $rowData=$GetData->first();
    $branch_id=$rowData->branch_id;
							
	$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
	$branchData_Row=$branchData->first();
	$stockSetting=$branchData_Row->stock_setting;
	
	if($stockSetting==1)
	{
      $getpro=DB::getInstance()->getmultiple('products',array('id' => $book_id));
      $totalStock=$getpro->first()->stock_quantity;
      $finalstock = $totalStock - $qty;

      if($finalstock<0)
      {
      	$finalstock=0;
      }

      $up=DB::getInstance()->update('products','id',$book_id,$tmp= null,$path= null,array('stock_quantity' => $finalstock));
	  if((isset($_REQUEST[$sk])) || ($_REQUEST[$sk]!=""))
	  {
	  $exsku=explode(',',$skuId);
	  $excount=count($exsku);
	  for($b=0;$b<$excount;$b++)
	  {
		  $skname=$exsku[$b];
		  $getSku=DB::getInstance()->getmultiple('product_stock_skuid',array('productid' => $book_id,'skuid' => $skname));
		  $rid=$getSku->first()->id;
	  
		  $up=DB::getInstance()->updatewithoutimage('product_stock_skuid','id',$rid,array('sold_status' => '1')); 
		  
	  }
     }
   }
}

$up=DB::getInstance()->updatewithoutimage('offline_store_invoice','id',$LastId,array('total_qty' => $totalQuantity));


switch($payment_status)
{
	case "1":
	
	
		$added_on=date('Y-m-d H:i:s');
		$added_by='1';

	    $final_amount=Input::get('final_amount');
        $balance_due=Input::get('balance_due');
		
	    $in=DB::getInstance()->insert('offline_store_installment',null,null,array('basic_tbl_id' => $LastId,'invoice_no' => $invoice_no,'total_amount' => $final_amount,'current_installment_amount' => $final_amount,'remaining_amount' => $balance_due,'paid_on' => $payment_date,'added_on' => $added_on,'added_by' => $added_by,'payment_type' => $payment_type,'reference_no'=>$reference_no));
	  
	break;
	
	case "0":
	
	   $first_installment=$_REQUEST['first_installment'];
	   
	   if(($first_installment!="0.00") && ($first_installment!="0") && ($first_installment!=""))
	   {
		   $remainingamount= $final_amount - $first_installment;
		   $remainingamount=round($remainingamount,2);
		   $in=DB::getInstance()->insert('offline_store_installment',null,null,array('basic_tbl_id' => $LastId,'invoice_no' => $invoice_no,'total_amount' => $final_amount,'current_installment_amount' => $first_installment,'remaining_amount' => $remainingamount,'paid_on' => $payment_date,'added_on' => $added_on,'added_by' => $added_by,'payment_type' => $payment_type,'reference_no'=>$reference_no));
	   }
	break;
}
?>

<script>window.open('slip-invoice.php?slip=<?php echo base64_encode($LastId); ?>','_blank');</script>

<script>window.location='<?php echo $redirectLink; ?>'</script>
<?php
}
else
{
  $msg1="Item Name can not be empty.You have to add atleast one item.";
}
}


/**************cheking if the form has been submitted or nor************/

?>

<link rel="stylesheet" href="css/bootstrap.datepicker.css">
<style>
.inputHolder
{
  margin-bottom: 7px !important;
}

.invoice_to_from tr th
{
     width: 70px;
}
.invoice_to_from tr td input
{
margin-bottom:10px;
}

.DisYes
{
  display:none;
}

.AjaxResult p
{
 border-bottom:1px solid #ddd;
 cursor:pointer
}

.taxrate_tr
{
 display:none;
}
</style>

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="row">
					       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       <?php
						if($msg!="")
						{?>
						    <div class="alert alert-info alert-block text-solve">
								<a class="close" data-dismiss="alert" href="#">X</a>
  								
  								<?php echo $msg;?>
							</div>
							
							<?php
							}
							if($msg1!="")
							{
							?>
							<div class="alert alert-block alert-danger text-error">
							  <a class="close" data-dismiss="alert" href="#">X</a>
							  <?php echo $msg1;?>
							</div>
							<?php
							}?>
							
							</div>
					  </div>
                    <div class="card">
                        
                        <div class="body">
						
						
							<?php
							$GetData=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
                            $rowData=$GetData->first();
                            $branch_id=$rowData->branch_id;
							
							$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
				            $branchData_Row=$branchData->first();
							
                            $CompanyName=$branchData_Row->name;
                            $stockSetting=$branchData_Row->stock_setting;
                            $invpre=substr($CompanyName,0,3);
                            $invpre=strtoupper($invpre);
							?>
							<?php
									
									
										//************** TAXABLE INVOICE NUMBER STARTS **********************//
										
										
									 $tax_inv=DB::getInstance()->query("SELECT `id`,`invoice_no` FROM `offline_store_invoice` WHERE `taxable`='1' ORDER BY id DESC LIMIT 1");
									 $tax_InvRowCount=$tax_inv->ount();
									 if($tax_InvRowCount!=0)
									 {
										$tax_invRow=$tax_inv->first();
										$tax_id=$tax_invRow->id;
										$tax_lastInv=$tax_invRow->invoice_no;
										$tax_ex_inv=explode('/',$tax_lastInv);
										$tax_lastExinv=$tax_ex_inv[2];
										
										
										$tax_dt=DB::getInstance()->query("SELECT year(invoice_date) as pyear FROM `offline_store_invoice` WHERE id='$tax_id'");
										$tax_RowCount=$tax_dt->ount();
										
										$tax_dtRow=$tax_dt->first();
										$tax_pyear=$tax_dtRow->pyear;
										
										$tax_cyear=date('Y');
										
										if($tax_cyear==$tax_pyear)
										{
										  if($tax_RowCount==0)
										  {
										   $tax_lastnum="001";
										  }
										  else
										  {	  
											$tax_lastnum=$tax_lastExinv + 1;
											$tax_lastnum="00".$tax_lastnum;
										  }
										}
										else
										{
										 $tax_lastnum="001";
										}
								     }
								    else
								    {
									  $tax_cyear=date('Y');
								      $tax_lastnum="001";
								    }
								   
									$tax_r=date("y");
									$tax_lasttwoyear = $tax_r + 1;
									
									$tax_invoice_no=$invpre."/".$tax_cyear.$tax_lasttwoyear."/".$tax_lastnum;
									
									//************** TAXABLE INVOICE NUMBER ENDS **********************//
									
									
									
										//************** NON TAXABLE INVOICE NUMBER STARTS **********************//
										
										
									 $inv=DB::getInstance()->query("SELECT `id`,`invoice_no` FROM `offline_store_invoice` WHERE `taxable`='0' ORDER BY id DESC LIMIT 1");
									 $InvRowCount=$inv->ount();
									 if($InvRowCount!=0)
									 {
										$invRow=$inv->first();
										$id=$invRow->id;
										$lastInv=$invRow->invoice_no;
										$ex_inv=explode('/',$lastInv);
										$lastExinv=$ex_inv[2];
										
										
										$dt=DB::getInstance()->query("SELECT year(invoice_date) as pyear FROM `offline_store_invoice` WHERE id='$id'");
										$RowCount=$dt->ount();
										
										$dtRow=$dt->first();
										$pyear=$dtRow->pyear;
										
										$cyear=date('Y');
										
										if($cyear==$pyear)
										{
										  if($RowCount==0)
										  {
										   $lastnum="001";
										  }
										  else
										  {	  
											$lastnum=$lastExinv + 1;
											$lastnum="00".$lastnum;
										  }
										}
										else
										{
										 $lastnum="001";
										}
								     }
								    else
								    {
									  $cyear=date('Y');
								      $lastnum="001";
								    }
								   
									$r=date("y");
									$lasttwoyear = $r + 1;
									
									$non_tax_invoice_no=$invpre."/".$cyear."-".$lasttwoyear."/".$lastnum;
									
									//************** NON TAXABLE INVOICE NUMBER ENDS **********************//
									
									?>
									<input type="hidden" id="nontax_invoice_no" value="<?php echo $non_tax_invoice_no; ?>">
									<input type="hidden" id="tax_invoice_no" value="<?php echo $tax_invoice_no; ?>">
									
									<form name="myForm" onsubmit="return validateItem()" id ="myform" action=""   method="POST" enctype="multipart/form-data" >
							<div class="row clearfix">
                            <div class="col-lg-4">
                               <h2>Invoice
                            </h2></div>
							
							
							<div class="col-lg-4  align-center"> 
							<!--<h2><input type="text" id="invoice_no" class="form-control" value="<?php echo $non_tax_invoice_no; ?>" 
							name="invoice_no" readonly></h2> -->
							</div>
							<div class="col-lg-4 align-right">
							<img src="logo/<?php echo $branchData_Row->logo; ?>" class="img-responsive thumbnail">
							</div>
							</div>
							
  <div class="row clearfix">
         <div class="col-lg-8 col-md-9 col-sm-12 col-xs-12" style="border-right:1px solid #ece3e3; " >
		      <div class="row clearfix">
						   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" > <!-- START OF FROM SECTION -->
							  <div class="card">
								<div class="header"><h2>FROM</h2></div>
					         <div class="body">
								<label for="name">Name</label>
										<div class="form-group">
													<div class="form-line">
														<input type="text" id="name" class="form-control" value="<?php echo $branchData_Row->name; ?>" name="from_name" required>
													</div>
												</div>
						<label for="email">Email Address</label>
										<div class="form-group">
													<div class="form-line">
														<input type="email" id="email" class="form-control" value="<?php echo $branchData_Row->email; ?>" name="from_email" required>
													</div>
												</div>
						<label for="Contact">Contact</label>
										<div class="form-group">
													<div class="form-line">
														<input type="text" id="Contact" class="form-control" value="<?php echo $branchData_Row->number; ?>" name="from_contact" required>
													</div>
												</div>
							<label for="gst">GST Number</label>
										<div class="form-group">
													<div class="form-line">
														<input type="text" id="gst" class="form-control" value="<?php
														echo $branchData_Row->gst_number;  ?>" name="from_gst_number">
													</div>
										</div>
							<label for="from_address">Address </label> 
										 <div class="form-group">
								<textarea name="from_address" id="from_address" style="width:90%;height:60px; " required><?php echo strip_tags($branchData_Row->address); ?></textarea>
                                  </div>
						
						  
					   
					</div>
					  </div>
				  </div> <!-- END OF FROM SECTION -->
				  
				  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" > <!-- START OF FOR SECTION -->
                       <div class="card">
                           <div class="header">
                            <h2>
                                For
                            </h2>
                           
                        </div>
					    <input type="hidden" name="customerid" value="0" id="customerid"/>
					     <div class="body">
					            <label for="to_contact">Contact</label>
                                <div class="form-group">
                                            <div class="form-line">
											<input type="text" autocomplete="off" class="form-control" onkeyup="getCustomer(this.value)" id="to_contact" name="to_contact" required>
                                              <div id="customerList" style="display:none;position:absolute;z-index:9999;background: #2a2121;width: 100%;color: #fff;padding: 10px;height:400px;overflow-y:scroll;">
												
												</div>
                                            </div>
                                </div>
                                 <label for="name">Name</label>
                                <div class="form-group">
                                            <div class="form-line">
											
                                               <input type="text" class="form-control" id="to_name" name="to_name" readonly required>
                                            </div>
                                        </div>
								<label for="to_email">Email Address</label>
                                <div class="form-group">
                                            <div class="form-line">
											
                                                <input type="email" id="to_email" class="form-control" name="to_email" readonly required>
                                            </div>
                                        </div>
								
										
										
										<label for="state">State</label>
                                 <div class="form-group">
                                            <div class="form-line">
                                              <select name="to_state" id="to_state" onchange="selState(this.value)" style="width:100%;margin-top:10px" required>
 												       <option >Select State</option>
                                                       <?php
													   $sel_st=DB::getInstance()->query("SELECT DISTINCT state FROM `places`");
													   foreach($sel_st->results() as $row)
													   {
													     $stt=$row->state;
													     ?>
														 <option value="<?php echo $row->state; ?>" <?php if($stt=="Uttar Pradesh") { echo "selected"; } ?>><?php echo $row->state; ?></option>
														 <?php
													   }
													   ?>
												  </select>
                                            </div>
                                        </div>
										<label for="to_gst_number">GST Number</label>
                                <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="to_gst_number" class="form-control" placeholder="Customer GST Number (if Required)"  name="to_gst_number">
                                            </div>
                                        </div>
										<label for="to_address">Address</label>
                                        <div class="form-group">
                                              <textarea name="to_address" id="to_address" style="width:90%;height:60px;" required><?php echo strip_tags($branchData_Row->address); ?></textarea>
                                           
                                        </div>
                     
							  
                  
               
						</div>
							</div>
					</div><!--  END OF  FOR SECTION -->
					<hr/>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					
					<div class="card">
					   <div class="header" >
					      
					   </div>
					   <div class="body">
					                <div class="row clearfix">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 form-control-label">
											<label for="datepicker">Invoice Number</label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7">
											<div class="form-group">
												<div class="form-line">
												
												<input type="text" id="invoice_no" class="form-control" value="<?php echo $non_tax_invoice_no; ?>" 
							name="invoice_no" readonly>
												  
												</div>
											</div>
										</div>
									</div>
							         <div class="row clearfix">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 form-control-label">
											<label for="datepicker">Invoice Date </label>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-7">
											<div class="form-group">
												<div class="form-line">
												<input class="form-control date" type="date" value="<?php echo date('Y-m-d'); ?>" name="invoice_date" id="datepicker" required >
												  
												</div>
											</div>
										</div>
									</div>
									<div class="row clearfix">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 form-control-label">
                                        <label for="datepicker">Due Date </label>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
											<input class="form-control date" type="date" value="<?php echo date('Y-m-d'); ?>" name="due_date" id="datepicker"  >
                                              
                                            </div>
                                        </div>
                                    </div>
									</div>
									
					    </div>
					   </div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					     <div class="row clearfix">   <!-- START OF TABLE -->
							  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
							  <div class="card">
							  <div class="header">
							  <h2>Add <?php echo  ucfirst($item_name); ?>(s) List</h2>
							  </div>
							  <div class="body">
							 
							  <table class="table table-striped table-invoice table-bordered" style="margin-top: 20px;">
										<thead>
											<tr>
												<th style="width:50px">#</th>
												<th style="width: 200px;"><?php echo  ucfirst($item_name); ?></th>
												<?php
												if($stockSetting==1)
												{
												?>
												<th style="width: 200px;">SKU</th>
												<?php
												}
												?>
												<th style="width:110px">Price</th>
												<th style="width:110px">Qty</th>
												<th class="DisYes" style="width:110px">Discount</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody id="tblrw">
										
											<tr id="tr1">
												<td class='name'><a  onclick="delete_row('1')" style="cursor:pointer;"><i class="material-icons">remove</i></a></td>
												
												<td class='name' style="position:relative">
												
													<input type="text" autocomplete="off" id="bookname1" name="book_name[]" onkeyup="searchBook('1')" placeholder="Write Your Book Name Here" style="width: 90%;" required>
													<input type="hidden" id="bookId1" name="book_id[]" >
													
												
													<div class="AjaxResult" id="ajxSearchResult1" style="display:none;position:absolute;z-index:9999;background: #2a2121;width: 100%;color: #fff;padding: 10px;height:400px;overflow-y:scroll;">
													 
													</div>
												
												
												</td>
											   <?php
												if($stockSetting==1)
												{
												?>
												<td id="ajxSearchResultSku1" class='price' style="position:relative">
												
												</td>
												<?php
												}
												?>
												
												<td class='price'>
												
												 <input type="text" id="unitprice1" onkeyup="updateQty('1')" name="unit_price[]" placeholder="Unit price" required style="width: 80%;">
												
												</td>
												
												<td class='qty'>
												  <input type="text" id="qty1" value="1" onkeyup="updateQty('1')" name="qty[]" placeholder="Book Quantity" required style="width: 80%;">
												</td>
												
												<td class="DisYes" >
												  <input type="text" onkeyup="giveDiscount('1')" class="disValue" id="discount1" value="0" name="discountamount[]" placeholder="Discount" style="width: 80%;" required>
												</td>
												
												<td class='total' id='totalamount1'></td>
												
												<input type="hidden" id="amount1" value="0" class="booktotalamount" name="amount[]" >
												
												<input type="hidden" id="counterNo1" value="1" class="counterNumber" name="counterNumber[]" >
											</tr>
											
										</tbody>
										
										<tbody>
										
										<?php
										if($stockSetting==1)
										{
											$colspan_f="6";
											$colspan_s="5";
										}
										else
										{
											$colspan_f="5";
											$colspan_s="4";
										}
										?>
										    <tr>
											    <td class="DisYes"> </td>
												<td class='name' colspan="<?php echo $colspan_f; ?>" style="padding: 15px 6px;"><a onclick="add_row_tbl('<?php echo $stockSetting; ?>')" style="cursor:pointer;"><i class="material-icons">add</i></a></td>
												
											</tr>
											
										    <tr>
										  		
												<td class="DisYes"> </td>
												<td class='last' colspan="<?php echo $colspan_s; ?>" style="text-align: right;">Subtotal:</td>
												<td class='total' id="subtotal"> </td>
												<input type="hidden" id="total_amount" value="0"  required name="total_amount">
											</tr>
											
										     <tr class="taxrate_tr">
												
												<td class="DisYes"> </td>
												<td class='last' colspan="<?php echo $colspan_s; ?>" style="text-align: right;">Taxrate:</td>
												<td class='total' id="Taxrate">0.00%</td>
												<input type="hidden" id="taxrate_amount" value="0" name="taxrate_amount">
												
											</tr>
											
										    <tr>
												
												<td class="DisYes"> </td>
												<td class='last' colspan="<?php echo $colspan_s; ?>" style="text-align: right;">Total:</td>
												<td class='total' id="finalamount_tr"></td>
												<input type="hidden" id="final_amount" value="0"  required name="final_amount">
											</tr>
										
										    <tr>
												
												<td class="DisYes"> </td>
												<td class='last' colspan="<?php echo $colspan_s; ?>" style="text-align: right;">BALANCE DUE:</td>
												<td class='total' id="balanceamt_tr"></td>
												<input type="hidden" id="balance_due" value="0"  name="balance_due">
											</tr>
										</tbody>
										
										    
										
									</table>
									</div>
									
									</div><div class="row clearfix">
									<input type="hidden" id="counter" name="counter" value="1">
									<div class="col-sm-12">
<label for="grid12">Enter NOte :</label>
                                <div class="form-group">
                                    <div class="form-line">
									<textarea name="note" id="note" class="form-control input-square" rows="2" ></textarea>
                                      
                                    </div>
                                </div>	
</div>
                                
								
							  </div>
									</div>
						</div><!-- END OF TABLE -->
						
					</div>
		  
			  </div>
	     </div>
		<div class="col-lg-4 col-md-3 col-sm-12 col-xs-12" >
			<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    
							 <!-- Horizontal Layout -->
           
                    <div class="card">
                        <div class="header">
                            <h2>
                                Invoice Setting
                            </h2>
                           
                        </div>
						<?php
							$GetData=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
                            $rowData=$GetData->first();
							$branch_id=$rowData->branch_id;
							
							$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
				            $branchData_Row=$branchData->first();
                            $CompanyName=$branchData_Row->name;
							
                            $cgst_rate=$branchData_Row->cgst_rate;
                            $sgst_rate=$branchData_Row->sgst_rate;
                            $igst_rate=$branchData_Row->igst_rate;
  
                            $invpre=substr($CompanyName,0,3);
                            $invpre=strtoupper($invpre);
							?>
						 <div class="body">
						 
                       <div class="row clearfix">
					   <span class="card-inside-title">Tax : </span>
					    <hr style="margin:5px 0px 10px 0px;border-top: 1px solid #ece3e3;">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="taxable">Enabled </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                               <select id="taxable" name="taxable" class="form-control" onchange="InvoiceSetting('tax_setting')" >
												  <option value="0">Off</option>
												  <option value="1">On</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
									<div id="tax_setting" style="display:none">
										
										<div id="cgst_sgst" >
										  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                          <label for="discount_type">CGST Rate </label>
                                         </div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
											<div class="form-group">
												<div class="form-line">
												   <input type="text"  value="<?php echo $cgst_rate; ?>" style="width:55%;" readonly><span class="add-on">%</span>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                          <label for="discount_type">SGST Rate </label>
                                         </div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
											<div class="form-group">
												<div class="form-line">
												   <input type="text" value="<?php echo $sgst_rate; ?>" style="width:55%;" readonly><span class="add-on">%</span>
												</div>
											</div>
										</div>
										<!-- <div class="control-group inputHolder">
											<label for="check" class="control-label" style="width: 70px;text-align:left;float: left;">CGST Rate</label>
											<div class="controls" style="margin-left: 15px; float: left; width: 50%;">
											   <div class="input-append">
												 <input type="text" value="<?php echo $cgst_rate; ?>" style="width:55%;" readonly><span class="add-on">%</span>
												</div>
											</div>
										 </div>
										 <div class="control-group inputHolder">
											<label for="check" class="control-label" style="width: 70px;text-align:left;float: left;">SGST Rate</label>
											<div class="controls" style=" margin-left: 15px; float: left;width: 50%;">
											   <div class="input-append">
												 <input type="text" value="<?php echo $sgst_rate; ?>" style="width:55%;" readonly><span class="add-on">%</span>
												</div>
											</div>
										  </div>-->
										 
										 <?php 
										 $rate=$sgst_rate + $cgst_rate;
										 ?>
										 
										 <input type="hidden" id="igstrate" value="<?php echo $igst_rate; ?>">
										  <input type="hidden" id="gstrate" value="<?php echo $rate; ?>">
										 
										</div>
										 
										 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                          <label for="discount_type">GST Rate </label>
                                         </div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
											<div class="form-group">
												<div class="form-line">
												    <input type="text" name="tax_rate" id="tax_rate" value="<?php echo $rate; ?>" readonly  style="width:55%;"><span class="add-on">%</span>
												</div>
											</div>
										</div>
									    <!-- <div class="control-group inputHolder">
											<label for="check" class="control-label" id="rateLabel" style="width: 70px;text-align:left;float: left;">GST Rate</label>
											<div class="controls" style=" margin-left: 15px; float: left;width: 50%;">
											   <div class="input-append">
												 <input type="text" name="tax_rate" id="tax_rate" value="<?php echo $rate; ?>" readonly  style="width:55%;"><span class="add-on">%</span>
												</div>
											</div>
										 </div> -->
										
									     <div class="control-group inputHolder">
											<label for="check" class="control-label" style="width: 70px;text-align:left;float: left;">Inclusive ? </label>
											<div class="controls" style=" margin-left: 15px; float: left;width: 50%;">
											 
												 <input type="checkbox" id="inc_exc" onclick="getAmount()" name="inclusive" value="1">
												
											</div>
										 </div>
									    </div>
                                </div>
								 
								<div class="row clearfix">
								<span class="card-inside-title">Discount :</span>
								 <hr style="margin:5px 0px 10px 0px;border-top: 1px solid #ece3e3;">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="discount_type">Discount </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                               <select name="discount_type" class="form-control" id="discount_type" onchange="InvoiceSetting('discount_setting')" >
												  <option value="0">No Discount</option>
												  <option value="1">Same Discount</option>
												  <option value="2">Different Discount</option>
												</select>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
								<div  id="discount_setting" style="display:none">
								<div class="row clearfix">
                              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">    <label for="check" class="control-label" >Discount In</label></div>
										<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 control-group inputHolder">
											
											<div class="controls">
												<select name="discount_in" onchange="disTypeChange()" id="discount_in" class="form-control">
												   <option value="1">Percent</option>
												   <option value="2">Rs</option>
												</select>
											</div>
										</div>
										</div>
											<div class="row clearfix">
									    <div class="control-group inputHolder" id="sameDiscount">
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label"><label for="check" class="control-label" >Discount</label></div>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 control-group "><div class="controls" >
											   
												 <input type="text" onkeyup="applyDiscount()" id="applydis" name="discount"  style="width:80%;">
											
											</div></div>
										</div></div>
									   
                                </div>
                     	      
                                  <div class="row clearfix">
				                   <span class="card-inside-title">Payments :</span>
								   <hr style="margin:5px 0px 10px 0px;border-top: 1px solid #ece3e3;">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="taxable">Paid ? </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <input type="checkbox" onclick="paidAmount()" id="payment_status" name="payment_status" value="1">
                                        </div>
                                    </div>
									</div>
									 <div class="row clearfix">
									<div class="inputHolder" id="paymentInstallment">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">	<label for="check" class="control-label" >Payment</label></div>
											<div class="controls" >
											   <div class="input-prepend">
												 <span class="add-on">Rs</span><input value="0.00" type="text" id="first_installment" onblur="payAmount()" name="first_installment" >
												</div>
											</div>
										</div>
										</div>
										
										
										
									 <div class="row clearfix">
											 
										<div class="control-group inputHolder">
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label"><label for="check" class="control-label" >Date</label></div>
											<div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
												<input type="date" value="<?php echo date('Y-m-d'); ?>" name="payment_date" id="datepicker" class="date " style="width:80%">
											</div>
										</div>
				                     </div>
									 
									 
				                  
								<div class="row clearfix">
				                   <span class="card-inside-title">Payment Method :</span>
								   <hr style="margin:5px 0px 10px 0px;border-top: 1px solid #ece3e3;">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="taxable">Mode </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <select name="payment_type" onchange="paymentType()" id="payment_type"  class="form-control">
												  <option value=""> --select mode--</option>
												  <option value="cash">Cash</option>
												  <option value="cheque">Cheque</option>
												  <option value="paytm">Paytm</option>
												  <option value="online">Online</option>
												  <option value="card">Card</option>
												</select>
                                        </div>
                                    </div>
									 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-5 form-control-label">
                                        <label for="taxable">Referance Code</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                           
											 <input type="text" id="reference_no" name="reference_no" >
                                        </div>
                                    </div>
								</div>
               
						</div>
							</div>
            </div>
                               
						
							</div>
							</div>
							  <div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="submitSlip" value="Submit">
									
								</div>
							</div>
									
						
									</form>
	
<script>
function checksku(id)
{
	
    var bookid = $('#bookId'+id).val();
    var sku = $('#sku'+id).val();

   
  $.ajax({
		type: "POST",
		url: "ajax.php",
		data: 'mode=checkbooksku&did=' + id + '&bookid='+bookid+'&sku=' + sku,
		cache: true,
		success: function(dat){
			
	       $("#ajxSearchResultSku" + id).html(dat);
		   $("#ajxSearchResultSku" + id).show();
		}  
		});
}


function selectSku(vl,id)
{
   $("#sku" + id).val(vl);
   $("#ajxSearchResultSku" + id).html('');
   $("#ajxSearchResultSku" + id).hide();
}

function SelDistributor(did)
{
if(did !='customer'){
$.getJSON('ajax.php?mode=distributorInvoice&id=' + did, function(data) {
 
        $('#to_name').val(data.toname);
        $('#to_email').val(data.toemail);
        $('#to_contact').val(data.tophone);
        $('#to_address').val(data.toaddress);
		
	$('#to_name').attr("readonly",true);
    $('#to_email').attr("readonly",true);
	$('#to_contact').attr("readonly",true);
	$('#to_address').attr("readonly",true);	
		
        
    });	
}else{

    $('#to_name').attr("readonly",true);
    $('#to_email').attr("readonly",false);
	$('#to_contact').attr("readonly",true);
	$('#to_address').attr("readonly",true);	
	
}	
}


function getCustomer(vl)
{
	 $.ajax({
		type: "POST",
		url: "ajax.php",
		data: 'mode=customerSearch&goal=' + vl,
		
		cache: true,
		success: function(dat){
	
		$("#customerList").html(dat);
		$("#customerList").show();
		}  
		});
}


function selectCus(cid,cname,cemail,cphone,cadd,cstt,c_gstno)
{
	if(cid!="new")
	{
	  $('#customerid').val(cid);
      $('#to_name').val(cname);
      $('#to_email').val(cemail);
      $('#to_contact').val(cphone);
      $('#to_address').val(cadd);
      $('#to_state').val(cstt);
      $('#to_gst_number').val(c_gstno);
	  
	  $('#to_name').attr("readonly",false);
      $('#to_email').attr("readonly",false);
	  $('#to_contact').attr("readonly",false);
	  $('#to_address').attr("readonly",false);	
	  
	  selState(cstt);
	}
	else
	{
	  $('#customerid').val(cid);
	  $('#to_name').attr("readonly",false);
	  $('#to_name').attr("placeholder","Add Customer Name here");
      $('#to_email').attr("readonly",false);
	  $('#to_email').attr("placeholder","Add Customer Email here");
	  $('#to_contact').attr("readonly",false);
	  $('#to_contact').attr("placeholder","Add Customer Contact here");
	  $('#to_address').attr("readonly",false);
	  $('#to_address').attr("placeholder","Add Customer Address here");
	}
	
	$("#customerList").hide();
    $("#customerList").html('');
		

 
}	


function searchBook(did)
{
   var vl=$('#bookname' + did).val();
   
   $.ajax({
		type: "POST",
		url: "ajax.php",
		data: 'mode=bookSearch&dvid='+did+'&goal=' + vl,
		
		cache: true,
		success: function(dat){
	
		$("#ajxSearchResult" + did).html(dat);
		$("#ajxSearchResult" + did).show();
		}  
		});
}

function InvoiceSetting(divid)
{
  
  switch(divid)
  {
    case "discount_setting":
	  
	  var vl=$('#discount_type').val();
	  
	  switch(vl)
	  {
	    case "0":
			$('#discount_setting').hide();
			$('#sameDiscount').hide();
			$('.DisYes').hide();
			$('.disValue').val('0');
			
			 $('.counterNumber').each(function() {
	  
				 var did=$(this).val();
				
				  var qty= $('#qty' + did).val();
				  var up= $('#unitprice' + did).val();
				  var dis= $('#discount' + did).val();
				  var disType= $('#discount_in').val();
				  
				  switch(disType)
				  {
					case "1":
					 var stdis=dis / 100;
					 var disamt= up * stdis;
					 var disamt= disamt.toFixed(2);
					break;
					
					case "2":
					  var disamt=dis;
					break;
				  }
				 
				  var prc = parseFloat(up) - parseFloat(disamt);
				  
				  var famt= parseFloat(prc) * qty;
		  
				  var famt= famt.toFixed(2);
				  
				  
				  $('#amount' + did).val(famt);
				  $('#totalamount' + did).html("Rs." + famt);

			  });
	         getAmount();
	  
		break;
		
		case "1":
		   $('#discount_setting').show();
		   $('#sameDiscount').show();
		   $('.DisYes').hide();
		   $('.disValue').val('0');
		   
		     $('.counterNumber').each(function() {
	  
				 var did=$(this).val();
				
				  var qty= $('#qty' + did).val();
				  var up= $('#unitprice' + did).val();
				  var dis= $('#discount' + did).val();
				  var disType= $('#discount_in').val();
				  
				  switch(disType)
				  {
					case "1":
					 var stdis=dis / 100;
					 var disamt= up * stdis;
					 var disamt= disamt.toFixed(2);
					break;
					
					case "2":
					  var disamt=dis;
					break;
				  }
				 
				  var prc = parseFloat(up) - parseFloat(disamt);
				  
				  var famt= parseFloat(prc) * qty;
		  
				  var famt= famt.toFixed(2);
				  
				  
				  $('#amount' + did).val(famt);
				  $('#totalamount' + did).html("Rs." + famt);

			  });
			  getAmount();
		break;
		
		case "2":
		  $('#discount_setting').show();
		  $('#sameDiscount').hide();
		  $('.DisYes').show();
		  $('.disValue').val('0');
		  
		    $('.counterNumber').each(function() {
	  
				 var did=$(this).val();
				
				  var qty= $('#qty' + did).val();
				  var up= $('#unitprice' + did).val();
				  var dis= $('#discount' + did).val();
				  var disType= $('#discount_in').val();
				  
				  switch(disType)
				  {
					case "1":
					 var stdis=dis / 100;
					 var disamt= up * stdis;
					 var disamt= disamt.toFixed(2);
					break;
					
					case "2":
					  var disamt=dis;
					break;
				  }
				 
				  var prc = parseFloat(up) - parseFloat(disamt);
				  
				  var famt= parseFloat(prc) * qty;
		  
				  var famt= famt.toFixed(2);
				  
				  
				  $('#amount' + did).val(famt);
				  $('#totalamount' + did).html("Rs." + famt);

			  });
			  getAmount();
		break;

	  }
	break;
	
	case "tax_setting":
	 
	 
	  var vl=$('#taxable').val();
	  
	  switch(vl)
	  {
	    case "0":
		
	      $('#' + divid).toggle();
	      $('.taxrate_tr').hide();
		  
		  var inv=$('#nontax_invoice_no').val(); 
		  $('#invoice_no').val(inv);
		  
		  getAmount();
		break;
		
		case "1":
		
		  $('#' + divid).toggle();
	      $('.taxrate_tr').show();
		  
		  var inv=$('#tax_invoice_no').val(); 
		  $('#invoice_no').val(inv); 
		  
		  getAmount();
		break;
	  }


  
	break;
  }

}

function paidAmount()
{
  
  $('#paymentInstallment').hide();
  var finalamount=$('#final_amount').val();
  //$('#first_installment').val(finalamount);
  getAmount();
}


function payAmount()
{
  var blncamt=$('#balance_due').val();
  var frstamt=$('#first_installment').val();
  
 blncamt = parseFloat(blncamt);
 frstamt = parseFloat(frstamt);

  if(frstamt > blncamt)
  {
    alert('Amount can not be more than balance amount');
  }
  else
  {
   getAmount();
  }
}


function disTypeChange()
{

$('.counterNumber').each(function() {
	  
				 var did=$(this).val();
				
				  var qty= $('#qty' + did).val();
				  var up= $('#unitprice' + did).val();
				  var dis= $('#discount' + did).val();
				  var disType= $('#discount_in').val();
				  
				  switch(disType)
				  {
					case "1":
					 var stdis=dis / 100;
					 var disamt= up * stdis;
					 var disamt= disamt.toFixed(2);
					break;
					
					case "2":
					  var disamt=dis;
					break;
				  }
				 
				  var prc = parseFloat(up) - parseFloat(disamt);
				  
				  var famt= parseFloat(prc) * qty;
		  
				  var famt= famt.toFixed(2);
				  
				  
				  $('#amount' + did).val(famt);
				  $('#totalamount' + did).html("Rs." + famt);

			  });
			  getAmount();
			  
			  
}


function applyDiscount()
{
		
   var amt=$('#applydis').val();
	
   $('.disValue').val(amt);
   
      $('.counterNumber').each(function() {
	  
	    var did=$(this).val();
		
		  var qty= $('#qty' + did).val();
		  var up= $('#unitprice' + did).val();
		  var dis= $('#discount' + did).val();
		  var disType= $('#discount_in').val();
		  
		  switch(disType)
		  {
			case "1":
			 var stdis=dis / 100;
			 var disamt= up * stdis;
			 var disamt= disamt.toFixed(2);
			break;
			
			case "2":
			  var disamt=dis;
			break;
		  }
		 
		  var prc = parseFloat(up) - parseFloat(disamt);
		  
		  var famt= parseFloat(prc) * qty;
  
		  var famt= famt.toFixed(2);
		  
		  
          $('#amount' + did).val(famt);
		  $('#totalamount' + did).html("Rs." + famt);

      });
	  getAmount(); 
}

function giveDiscount(did)
{
  var qty= $('#qty' + did).val();
  var up= $('#unitprice' + did).val();
  var dis= $('#discount' + did).val();
  var disType= $('#discount_in').val();
  
  switch(disType)
  {
    case "1":
	 var stdis=dis / 100;
     var disamt= up * stdis;
     var disamt= disamt.toFixed(2);
	break;
	
	case "2":
	  var disamt=dis;
	break;
  }

  var prc = parseFloat(up) - parseFloat(disamt);
  
  var famt= parseFloat(prc) * qty;
  
  var famt= famt.toFixed(2);
  
  $('#totalamount' + did).html("Rs." + famt);
  $('#amount' + did).val(famt);
  getAmount();
}


function add_row_tbl(stkst){

		var disType = $("#discount_type").val();
		
		switch(disType)
		{
		  case "0":
		    var disAmt="0";
			var stl="style='display:none'";
		  break;
		  
		  case "1":
		    var disAmt=$('#applydis').val();
			var stl="style='display:none'";
		  break;
		  
		  case "2":
		   var disAmt="0";
		   var stl="style='display:block'";
		  break;
		}
		
		
		
		counter = $("#counter").val();
		new_counter= parseInt(counter)+1;
		
		var newDiv = '<tr id="tr'+new_counter+'"><td><a  onclick="delete_row('+new_counter+')" style="cursor:pointer;border-radius:50%;padding:3px"><i class="material-icons">remove</i></a></td><td style="position:relative"><input type="text" onkeyup="searchBook('+new_counter+')" id="bookname'+new_counter+'" name="book_name[]" placeholder="Write Your Book Name Here" autocomplete="off" style="width: 90%;" required><input type="hidden" id="bookId'+new_counter+'" name="book_id[]" ><div class="AjaxResult" id="ajxSearchResult'+new_counter+'" style="display:none;position:absolute;z-index:9999;background: #2a2121;width: 100%;color: #fff;padding: 10px;height:400px;overflow-y:scroll;"></div></td>';
		
		
		if(stkst==1)
		{
		var newDiv = newDiv + '<td id="ajxSearchResultSku'+new_counter+'" class="price"  style="position:relative"></td>';
        }
		var newDiv  = newDiv + '<td ><input type="text" onkeyup="updateQty('+new_counter+')" required id="unitprice'+new_counter+'" name="unit_price[]" placeholder="Unit price" style="width: 80%;"></td><td><input type="text" value="1" onkeyup="updateQty('+new_counter+')"  id="qty'+new_counter+'" required name="qty[]" placeholder="Book Quantity" style="width: 80%;"></td><td class="DisYes"><input type="text" value="'+ disAmt +'" onkeyup="giveDiscount('+new_counter+')" id="discount'+new_counter+'" class="disValue" name="discountamount[]" placeholder="Discount" style="width: 80%;"></td><td class="total" id="totalamount'+new_counter+'"></td><input type="hidden" class="booktotalamount" value="0" id="amount'+new_counter+'" name="amount[]" ><input type="hidden" id="counterNo'+new_counter+'" value="'+new_counter+'" class="counterNumber" name="counterNumber[]" ></tr>';
		
		$("#tblrw").append(newDiv);
		$("#counter").val(new_counter);
	}
	
	function delete_row(id){
	
	    counter = $("#counter").val();
		new_counter= parseInt(counter)-1;
		if(new_counter==0)
		{
		  alert("You have to choose atleast one item to generate invoice");
		}
		else
		{
		  $("#counter").val(new_counter);
		  $('#tr'+id).remove();
		}
		getAmount();
	}
	

</script>
<?php include('common/footer.php'); ?>


<script>

function selectBook(bid,tit,prc,did,stk,stkst)
{
	if((stkst==1) && (stk==0))
	{
		alert('Out of Stock');
	}
	else
	{
  $('#bookId' + did).val(bid);
  $('#bookname' + did).val(tit);
  $('#unitprice' + did).val(prc);
  $('#totalamount' + did).html("Rs." + prc);
  $('#amount' + did).val(prc);
  $("#ajxSearchResult" + did).html('');
  $("#ajxSearchResult" + did).hide();
  $(".AjaxResult").hide();
 
   getAmount();
 
   var bookid = $('#bookId'+did).val();
    //var sku = $('#sku'+id).val();

   if(stkst==1)
   {
  $.ajax({
		type: "POST",
		url: "ajax.php",
		data: 'mode=checkbooksku&did=' + did + '&bookid='+bookid,
		cache: true,
		success: function(dat){
			
	       $("#ajxSearchResultSku" + did).html(dat);
		   $("#ajxSearchResultSku" + did).show();
		}  
		});
	  }
  }	
}	


function updateQty(did)
{
  var qty= $('#qty' + did).val();
  var up= $('#unitprice' + did).val();
  var dis= $('#discount' + did).val();
  var disType= $('#discount_in').val();
  
  
  switch(disType)
  {
    case "1":
	 var stdis=dis / 100;
     var disamt= up * stdis;
     var disamt= disamt.toFixed(2);
	break;
	
	case "2":
	  var disamt=dis;
	break;
  }
  
  var prc = parseFloat(up) - parseFloat(disamt);

  var famt= parseFloat(prc) * qty;
  
  var famt= famt.toFixed(2);
  
  
  $('#totalamount' + did).html("Rs." + famt);
  $('#amount' + did).val(famt);
  getAmount();
  
}
	
	function getAmount()
	{
	
	  var sum = 0;
      $('.booktotalamount').each(function() {
        sum += parseFloat($(this).val());
      });
	  
	   var tax_status=$('#taxable').val();
	   
	   switch(tax_status)
	   {
	     
		 case "0":
		 
		   var totalamt=sum;
		   var finalamt=totalamt;
		   $('.taxrate_tr').hide();
		   $('#Taxrate').html('0.00%');
		   $('#taxrate_amount').val('0');
		   var totalamt= totalamt.toFixed(2);
		   var finalamt= finalamt.toFixed(2);
		   
		 break;
		 
		 
		 case "1":
		 
		  var totalamt=sum;
		  $('.taxrate_tr').show();
		  var incexc=document.getElementById('inc_exc').checked;
		  
		   if(incexc==true)    //******* Inclusive ********//
		   {
		     var tx_rt=$('#tax_rate').val();
			 var st=tx_rt / 100;
			 var div_by= 1 + parseFloat(st);
					
			 var actual_amt=totalamt / div_by;
			 var actual_amt=actual_amt.toFixed(2);
             var tamt= actual_amt * st;
					
			 var tamt=tamt.toFixed(2);
			 
			 var totalamt=totalamt;
			 var finalamt=totalamt;
			 
			 var totalamt= totalamt.toFixed(2);
			 var finalamt= finalamt.toFixed(2);
			 
			 var txtext="Inc Rs." + tamt;
           
		   }
		   else                //******* Exclusive ********//
		   {
		     var tx_rt=$('#tax_rate').val();
		     var st=tx_rt / 100;
		     var tamt= totalamt * st;
		     var tamt= tamt.toFixed(2);
		 
			 var finalamt = parseFloat(totalamt) + parseFloat(tamt);
			 
			 var totalamt= totalamt.toFixed(2);
			 var finalamt= finalamt.toFixed(2);
			 
			 var txtext="+ Rs." + tamt;
			
		   }
		  
		  
		 break;
	  
	   }
	  
	  var paystatus=document.getElementById('payment_status').checked;
	   
	  if(paystatus==true)
	  {
	    //$('#first_installment').val(finalamt);
		$('#paymentInstallment').hide();
		var pay=finalamt;
	  }
	  else
	  {
	  	 var pay=$('#first_installment').val();
	     $('#paymentInstallment').show();
	  }
	  

	  var blncamt = parseFloat(finalamt) - parseFloat(pay);
	  var blncamt= blncamt.toFixed(2);
	  
	  $('#total_amount').val(totalamt);
	  $('#subtotal').html("Rs." + totalamt);
	  
	  $('#taxrate_amount').val(tamt);
	  $('#Taxrate').html(txtext);
	  
	  $('#final_amount').val(finalamt);
	  $('#finalamount_tr').html("Rs." + finalamt);
	  
	  $('#balance_due').val(blncamt);
	  $('#balanceamt_tr').html("Rs." + blncamt);
	}
	
	
function selState(vl)
{
  if(vl=="Uttar Pradesh")
  { 
    $('#cgst_sgst').show();
    var rt=$('#gstrate').val();
	$('#tax_rate').val(rt);
	$('#rateLabel').html("GST Rate");
  }
  else
  {
    $('#cgst_sgst').hide();
	var rt=$('#igstrate').val();
	$('#tax_rate').val(rt);
	$('#rateLabel').html("IGST Rate");
  }
  
   getAmount();
}

function validateItem()
{
   counter = $("#counter").val();
		if(counter==0)
		{
		  alert("You have to choose atleast one item to generate invoice");
		  return false;
		}
		else
		{
		  return true;
		}
}
function paymentType(){
		var Ptype = $('#payment_type').val(); 

		if(Ptype=='cash'){
			$('#reference_no').prop('disabled', true);;
		}else{
			$('#reference_no').prop('disabled', false);;
		}
	}
</script>
</body>
</html>