<?php
require_once('core/init.php'); 
$mode= $_REQUEST['mode'];
switch($mode)
{
case "Printing":
	$page = $_REQUEST['page'];
	$vt = DB::getInstance()->get('other_charges',array('value_type','=','7'));
	$gcost = $vt->first();
	$amt = $gcost->amount;
	$tamnt = $amt*$page;
?>
<input type="text" id="amt" name="amount" class="span8 input-square" placeholder="Total Amount" value="<?php echo $tamnt ?>"required>
<?php
break;



case "distributorInvoice":

$did=$_REQUEST['id'];

$vt = DB::getInstance()->get('distributor',array('id','=',$did));
$row = $vt->first();


$data['toname']=$row->name;
$data['toemail']=$row->email;
$data['tophone']=$row->mobile;
$data['toaddress']=$row->address;
echo json_encode($data);

break;



case "bookSearch":

$dvid=$_REQUEST['dvid'];
$goal=$_REQUEST['goal'];
$val=strtolower($goal);

$del=DB::getInstance()->query("SELECT id,title,set_mrp,stock_quantity FROM products where `set_mrp`!='0' and lower(title) LIKE '%$val%'");
foreach($del->results() as $row)
{
    $title=$row->title;
    $stock_quantity=$row->stock_quantity;
    $tit=str_replace("'","",$title);
	
	if($stock_quantity<0)
	{
		$stock_quantity=0;
	}
	?>
	  <p style="customer:pointer" onclick="selectBook('<?php echo $row->id; ?>','<?php echo $tit; ?>','<?php echo $row->set_mrp; ?>','<?php echo $dvid; ?>','<?php echo $stock_quantity; ?>')" ><?php echo $row->title; ?></p>
	<?php
}


break;


case "customerSearch":

$goal=$_REQUEST['goal'];
$val=strtolower($goal);

$del=DB::getInstance()->query("SELECT id,name,email,address,contact,state,gst_number FROM users where lower(contact) LIKE '%$val%'");
$count=$del->ount();
if($count!=0)
{
foreach($del->results() as $row)
{
	$id=$row->id;
	$name=$row->name;
	$email=$row->email;
	$address=$row->address;
	$contact=$row->contact;
	$state=$row->state;
	$gst_number=$row->gst_number;
    
	$address=preg_replace( "/\r|\n/", "", $address );
	//$address = str_replace(",", "", $address);
	?>
	  <p style="cursor:pointer" onclick="selectCus('<?php echo $id; ?>','<?php echo $name; ?>','<?php echo $email; ?>','<?php echo $contact; ?>','<?php echo strip_tags($address); ?>','<?php echo $state; ?>','<?php echo $gst_number; ?>')" ><?php echo $name; ?></p>
	<?php
}
}
else
{
	?>
	  <p onclick="selectCus('new','0','0','0','0','0','0')" style="cursor:pointer">New Customer .Click Here to Add Him/Her</p>
	<?php
}

break;



case "checkbooksku":
 $bookid = $_REQUEST['bookid'];
 $sku = $_REQUEST['sku'];
 $did = $_REQUEST['did'];

 ?>
 <select name="sku<?php echo $did; ?>[]" id="sku<?php echo $did; ?>" multiple class="form-control">
 <?php
$del=DB::getInstance()->query("SELECT skuid FROM product_stock_skuid where `productid`='$bookid' and `sold_status`='0'");
foreach($del->results() as $row)
{
	?>
	  <option value="<?php echo $row->skuid; ?>"><?php echo $row->skuid; ?></option>
	<?php
}
?>
</select>
<?php	
break;

case "SessionDestroy":

unset($_SESSION['msg']);
unset($_SESSION['err']);

break;


case "proType":

$catId=$_REQUEST['catId'];

?>


	<div class="control-group">
										<label for="select5" class="control-label">Select Products In Package</label>
										<div class="controls">
											<select name="itemId[]" onchange="getCalPrice()" id="select5" class='cho span8 proList' multiple>
												<option value="">Select products</option>
												<?php
												$pro=DB::getInstance()->getmultiple('products',array('category_id' => $catId),null);
												foreach($pro->results() as $row)
												{
													?>
													  <option id="<?php echo $row->set_mrp; ?>" value="<?php echo $row->id; ?>_<?php echo $row->set_mrp; ?>"><?php echo $row->title; ?></option>
													<?php
												}
												?>
											
											</select>
										</div>
	</div>
	
	
	<div class="control-group">
										<label for="select5" class="control-label">Duration</label>
										<div class="controls">
											<select name="duration" class='span8'>
												<option value="">Select Duration</option>
												<option value="Monthly">Monthly</option>
												<option value="Yearly">Yearly</option>
												<option value="Quarterly">Quarterly</option>
												
											</select>
										</div>
	</div>

	<div class="control-group">
										<label for="select5" class="control-label">Calculated price</label>
										<div class="controls">
											<input type="text" id="calculated_price" value="0" name="calculated_price" class="span8 input-square" placeholder="Enter Product Name" readonly>
										</div>
	</div>
	
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

<script>

function getCalPrice()
{
	 $a=$('.proList option:selected');
     var sum = 0;
    for($i=0;$i<$a.length;$i++){
        var vl=$('.proList option:selected:eq('+$i+')').val();
        var res = vl.split("_");
		 sum += parseFloat(res[1]);
		
		
    }
	$('#calculated_price').val(sum);
	$('#setMrp').val(sum);

}


</script>
<?php

break;

 }

 ?>