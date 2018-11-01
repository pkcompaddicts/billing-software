<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['submit']))
{
$date=date('Y-m-d H:i:s');

$branch_id=Input::get('branchId');
$entry_type=Input::get('entry_type');
$category_id=Input::get('catId');
$given_by_name=Input::get('given_by_name');
$given_by_email=Input::get('given_by_email');
$given_by_contact=Input::get('given_by_contact');
$received_by_name=Input::get('received_by_name');
$received_by_email=Input::get('received_by_email');
$received_by_contact=Input::get('received_by_contact');
$amount=Input::get('amount');
$payment_date=Input::get('payment_date');
$payment_mode=Input::get('payment_mode');
$remarks=Input::get('remarks');

$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$find_who_row=$find_who->first();
$upby=$find_who_row->id;

if((!empty($branch_id)) || ($branch_id!="") || (!empty($entry_type)) || ($entry_type!="") || (!empty($category_id)) || ($category_id!="") || (!empty($given_by_name)) || ($given_by_name!="") || (!empty($received_by_name)) || ($received_by_name!="") || (!empty($amount)) || ($amount!="") || (!empty($payment_date)) || ($payment_date!="") || (!empty($payment_mode)) || ($payment_mode!=""))
{
	switch($payment_mode)
	{
		case "1":
		  
		  $inArray=array('branch_id' => $branch_id,'entry_type' => $entry_type,'category_id' => $category_id,'given_by_name' => $given_by_name,'given_by_email' => $given_by_email,'given_by_contact' => $given_by_contact,'received_by_name' => $received_by_name,'received_by_email' => $received_by_email,'received_by_contact' => $received_by_contact,'amount' => $amount,'payment_date' => $payment_date,'payment_mode' => $payment_mode,'remarks' => $remarks,'added_by' => $upby, 'added_on' => $date);
		  
		break;
		
		case "2":
		  
		  $cheque_reference_no=Input::get('cheque_no');
		  $cheque_date=Input::get('cheque_date');
		  $bank_name=Input::get('bank_name');
		  $bank_branch=Input::get('bank_branch');
		  
		  if((!empty($cheque_reference_no)) || ($cheque_reference_no!="") || (!empty($cheque_date)) || ($cheque_date!="") || (!empty($bank_name)) || ($bank_name!="") || (!empty($bank_branch)) || ($bank_branch!=""))
		  {
				$inArray=array('branch_id' => $branch_id,'entry_type' => $entry_type,'category_id' => $category_id,'given_by_name' => $given_by_name,'given_by_email' => $given_by_email,'given_by_contact' => $given_by_contact,'received_by_name' => $received_by_name,'received_by_email' => $received_by_email,'received_by_contact' => $received_by_contact,'amount' => $amount,'payment_date' => $payment_date,'payment_mode' => $payment_mode,'cheque_reference_no' => $cheque_reference_no,'cheque_date' => $cheque_date,'bank_name' => $bank_name,'bank_branch' => $bank_branch,'remarks' => $remarks,'added_by' => $upby, 'added_on' => $date);
				$err="0";
		  }
		  else
		  {
				$err="1";
		  }

		break;
		
		
		case "3":
		  
		   $cheque_reference_no=Input::get('reference_no');
		   
		  if((!empty($cheque_reference_no)) || ($cheque_reference_no!=""))
		  {
			    $inArray=array('branch_id' => $branch_id,'entry_type' => $entry_type,'category_id' => $category_id,'given_by_name' => $given_by_name,'given_by_email' => $given_by_email,'given_by_contact' => $given_by_contact,'received_by_name' => $received_by_name,'received_by_email' => $received_by_email,'received_by_contact' => $received_by_contact,'amount' => $amount,'payment_date' => $payment_date,'payment_mode' => $payment_mode,'cheque_reference_no' => $cheque_reference_no,'remarks' => $remarks,'added_by' => $upby, 'added_on' => $date);
				$err="0";
		  }
		  else
		  {
				$err="2";
		  }

		break;
		
	}
	
	if($err==1)
	{
		$_SESSION['err']="Cheque Details are required";
	}
	else if($err==2)
	{
		$_SESSION['err']="Reference Number is required";
	}
	else
	{
		$in=DB::getInstance()->insert('expense_income',$tmp= null,$path= null,$inArray);
		$_SESSION['msg']="Added Successfully";
		  ?>
		<script>window.location='expense.php'</script>
		<?php
	}
}
else
{
  $_SESSION['err']="Fields marked with * are required";
}
}





if(isset($_REQUEST['update']))
{
$date=date('Y-m-d H:i:s');
$id=Input::get('id');


$branch_id=Input::get('branchId');
$entry_type=Input::get('entry_type');
$category_id=Input::get('catId');
$given_by_name=Input::get('given_by_name');
$given_by_email=Input::get('given_by_email');
$given_by_contact=Input::get('given_by_contact');
$received_by_name=Input::get('received_by_name');
$received_by_email=Input::get('received_by_email');
$received_by_contact=Input::get('received_by_contact');
$amount=Input::get('amount');
$payment_date=Input::get('payment_date');
$payment_mode=Input::get('payment_mode');
$remarks=Input::get('remarks');

$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$find_who_row=$find_who->first();
$upby=$find_who_row->id;

if((!empty($branch_id)) || ($branch_id!="") || (!empty($entry_type)) || ($entry_type!="") || (!empty($category_id)) || ($category_id!="") || (!empty($given_by_name)) || ($given_by_name!="") || (!empty($received_by_name)) || ($received_by_name!="") || (!empty($amount)) || ($amount!="") || (!empty($payment_date)) || ($payment_date!="") || (!empty($payment_mode)) || ($payment_mode!=""))
{
	switch($payment_mode)
	{
		case "1":
		  
		  $inArray=array('branch_id' => $branch_id,'entry_type' => $entry_type,'category_id' => $category_id,'given_by_name' => $given_by_name,'given_by_email' => $given_by_email,'given_by_contact' => $given_by_contact,'received_by_name' => $received_by_name,'received_by_email' => $received_by_email,'received_by_contact' => $received_by_contact,'amount' => $amount,'payment_date' => $payment_date,'payment_mode' => $payment_mode,'cheque_reference_no' => '','cheque_date' => '0000-00-00','bank_name' => '','bank_branch' => '','remarks' => $remarks,'updated_by' => $upby, 'updated_on' => $date);
		  
		break;
		
		case "2":
		  
		  $cheque_reference_no=Input::get('cheque_no');
		  $cheque_date=Input::get('cheque_date');
		  $bank_name=Input::get('bank_name');
		  $bank_branch=Input::get('bank_branch');
		  
		  if((!empty($cheque_reference_no)) || ($cheque_reference_no!="") || (!empty($cheque_date)) || ($cheque_date!="") || (!empty($bank_name)) || ($bank_name!="") || (!empty($bank_branch)) || ($bank_branch!=""))
		  {
				$inArray=array('branch_id' => $branch_id,'entry_type' => $entry_type,'category_id' => $category_id,'given_by_name' => $given_by_name,'given_by_email' => $given_by_email,'given_by_contact' => $given_by_contact,'received_by_name' => $received_by_name,'received_by_email' => $received_by_email,'received_by_contact' => $received_by_contact,'amount' => $amount,'payment_date' => $payment_date,'payment_mode' => $payment_mode,'cheque_reference_no' => $cheque_reference_no,'cheque_date' => $cheque_date,'bank_name' => $bank_name,'bank_branch' => $bank_branch,'remarks' => $remarks,'updated_by' => $upby, 'updated_on' => $date);
				$err="0";
		  }
		  else
		  {
				$err="1";
		  }

		break;
		
		
		case "3":
		  
		   $cheque_reference_no=Input::get('reference_no');
		   
		  if((!empty($cheque_reference_no)) || ($cheque_reference_no!=""))
		  {
			    $inArray=array('branch_id' => $branch_id,'entry_type' => $entry_type,'category_id' => $category_id,'given_by_name' => $given_by_name,'given_by_email' => $given_by_email,'given_by_contact' => $given_by_contact,'received_by_name' => $received_by_name,'received_by_email' => $received_by_email,'received_by_contact' => $received_by_contact,'amount' => $amount,'payment_date' => $payment_date,'payment_mode' => $payment_mode,'cheque_reference_no' => $cheque_reference_no,'cheque_date' => '0000-00-00','bank_name' => '','bank_branch' => '','remarks' => $remarks,'updated_by' => $upby, 'updated_on' => $date);
				$err="0";
		  }
		  else
		  {
				$err="2";
		  }

		break;
		
	}
	
	if($err==1)
	{
		$_SESSION['err']="Cheque Details are required";
	}
	else if($err==2)
	{
		$_SESSION['err']="Reference Number is required";
	}
	else
	{
		$in=DB::getInstance()->updatewithoutimage('expense_income','id',$id,$inArray);
		$_SESSION['msg']="Updated Successfully";
		  ?>
		<script>window.location='expense.php'</script>
		<?php
	}
}
else
{
  $_SESSION['err']="Fields marked with * are required";
}

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
							
								 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
			
				<?php
	if(isset($_REQUEST['mode']))
	{
	$mode=$_REQUEST['mode'];
	switch($mode)
	{
	case "edit":
	$id=base64_decode($_REQUEST['id']);
	$del=DB::getInstance()->get('expense_income',array('id','=',$id));
	$categoryId=$del->first()->category_id;
	$branchId=$del->first()->branch_id;
	$entry_type=$del->first()->entry_type;
	$payment_mode=$del->first()->payment_mode;
	?>
		<div class="card">

                        <div class="header">
                            <h2>
                               Update Expence
                            </h2>
                            
                        </div>
                        <div class="body">
	
										<form method="post" action="" enctype="multipart/form-data">
										<div class="row clearfix">
										<input type="hidden" name="id" value="<?php echo $id ?>">
										 
									  <?php
									 $loginType=$find_who_row->login_type;
									 if($loginType!=4)
									 {
										 $disabled="disabled"; 
									 }
									 else
									 {
										  $disabled="";
									 }
									 ?>
							<div class="col-sm-4">
                                <label for="grid12">Branch   <span style="color:red">*</span>:</label>
                                <div class="form-group">
		                             <div class="controls">
										<select name="branchId" id="branchId" class="span8 input-square" required <?php echo $disabled; ?> >
										      <option value="" >Select Branch</option>
											  <?php
										   $branch=DB::getInstance()->getmultiple('branches',array('status' => 1));
										   foreach($branch->results() as $rt)
										   {
											   $braId=$rt->id;
											   ?>
											   <option value="<?php echo $rt->id; ?>" <?php if($branchId==$braId){ echo "selected"; } ?>><?php echo $rt->name; ?>,<?php echo $rt->address; ?></option>
											   <?php
										   }
										   ?>
											  
											   
										</select>
									</div> 
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Type <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="controls">
										<select name="entry_type" id="entry_type" class="span8 input-square" required>
										   <option value="">Select Type</option>
										   <option value="1" <?php if($entry_type==1) { echo "selected"; } ?>>Debit</option>
										   <option value="2" <?php if($entry_type==2) { echo "selected"; } ?>>Credit</option>
										</select>
									</div> 
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Expence Category <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="controls">
										<select  name="catId" id="catId"  class="span8 input-square" required>
										      <option value="" >Select Category</option>
											  <option value="">Select Category</option>
										   <?php
										   $category=DB::getInstance()->getmultiple('expense_category',array('status' => 1));
										   foreach($category->results() as $rt)
										   {
											   $catId=$rt->id;
											   ?>
										       <option value="<?php echo $rt->id; ?>" <?php if($categoryId==$catId) { echo "selected"; } ?>><?php echo $rt->title; ?></option>
										   <?php } ?>
											  
											   
										</select>
									</div> 
                                </div>	
                            </div>
							<?php
									$del=DB::getInstance()->get('expense_income',array('id','=',$id));
									?>
							<div class="col-sm-4">
                                <label for="grid12">Given By Name <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="given_by_name" value="<?php echo $del->first()->given_by_name; ?>" name="given_by_name" class="form-control" placeholder="Enter Given By name">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Given By Email :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="given_by_email" value="<?php echo $del->first()->given_by_email; ?>"  name="given_by_email" class="form-control" placeholder="Enter Given By Email ">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Given By Contact :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  id="given_by_contact" value="<?php echo $del->first()->given_by_contact; ?>"  name="given_by_contact" class="form-control" placeholder="Enter given By Contact">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Received By Name <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  id="received_by_name" value="<?php echo $del->first()->received_by_name; ?>" name="received_by_name" class="form-control" placeholder="Enter Received By name">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Received By Email *:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="received_by_email" value="<?php echo $del->first()->received_by_email; ?>" name="received_by_email" class="form-control" placeholder="Enter Received By Email ">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Received By COntact *:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="received_by_contact" value="<?php echo $del->first()->received_by_contact; ?>" name="received_by_contact" class="form-control" placeholder="Enter Received By Contact ">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Amount <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  name="amount" value="<?php echo $del->first()->amount; ?>" id="amount"  class="form-control" placeholder="Enter  Amount">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Payment date <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="payment_date" value="<?php echo $del->first()->payment_date; ?>"  name="payment_date" class="form-control" placeholder="Enter Expence Category">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Payment Mode <span style="color:red">*</span> :</label>
                                <div class="form-group">
                                    <div class="controls">
										<select name="payment_mode" id="payment_mode" onchange="selectMode(this.value)" class="span8 input-square" required>
										    <option value="">Select Payment Mode</option>
										   <option value="1" <?php if($payment_mode==1) { echo "selected"; } ?>>Cash</option>
										   <option value="2" <?php if($payment_mode==2) { echo "selected"; } ?>>Cheque</option>
										   <option value="3" <?php if($payment_mode==3) { echo "selected"; } ?>>Other</option>
										</select>
									</div> 
                                </div>	
                            </div>
							
							<?php
									switch($payment_mode)
									{
										case "1":
										  $style="none";
										  $style1="none";
										break;
										
										case "2":
										  $style="block";
										  $style1="none";										
										break;
										
										case "3":
										  $style="none";
										  $style1="block";										
										break;
									}
									?>
							<!--  Display None Stsrt-->
							<div class="col-sm-12 col-md-12 " id="chequeData"  style="margin-left:0px; display:<?php echo $style; ?>; ">
							    <div class="row">
									   <div class="col-sm-3">
										<label for="grid12">Cheque Number <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="text" id="cheque_no" value="<?php echo $del->first()->cheque_reference_no; ?>" name="cheque_no" class="form-control" placeholder="Enter Cheque Number ">
											</div>
										</div>	
									</div>
									<div class="col-sm-3">
										<label for="grid12">Cheque Date <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="date" id="cheque_date"  value="<?php echo $del->first()->cheque_date; ?>" name="cheque_date" class="form-control" placeholder="Choose Cheque date">
											</div>
										</div>	
									</div>
									<div class="col-sm-3">
										<label for="grid12">Bank Name <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="t" id="bank_name" value="<?php echo $del->first()->bank_name; ?>" name="bank_name" class="form-control" placeholder="Enter Bank Name">
											</div>
										</div>	
									</div>
									<div class="col-sm-3">
										<label for="grid12"> Bank Branch <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="text" id="bank_branch" value="<?php echo $del->first()->bank_branch; ?>" name="bank_branch" class="form-control" placeholder="Enter Bank Name">
											</div>
										</div>	
									</div>
								</div>	
							</div>
							<div class="col-sm-12 col-md-12 " id="otherData"  style="margin-left:0px; display:<?php echo $style1; ?>; ">
							    <div class="row">
								   <div class="col-sm-4">
										<label for="grid12">Reference Number <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="text" id="reference_no" value="<?php echo $del->first()->cheque_reference_no; ?>" name="reference_no" class="form-control" placeholder="Enter referance Number ">
											</div>
										</div>	
									</div>
								</div>
							</div>
									
									
							<!--   END OF DISPLAY NONE -->
							<div class="col-sm-6">
                                <label for="grid12">Remarks :</label>
                                <div class="form-group">
                                   <div class="form-line">
                                        <textarea name="remarks" id="remarks"  placeholder="Enter remarks.. " class="form-control"><?php echo $del->first()->remarks; ?></textarea>
                                   </div>
                                </div>	
                            </div>
							
                           <div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="submit" value="Submit">
						   </div>

									</form>
									</div>
								
							</div>
						
						</div>
					
		
		<?php
break;

}
		}
else
{

?>

<div class="card">

                        <div class="header">
                            <h2>
                               Add Expence
                            </h2>
                            
                        </div>
                        <div class="body">
	
										<form method="post" action="" enctype="multipart/form-data">
										<div class="row clearfix">
										
										 
									 <?php
									 $loginType=$find_who_row->login_type;
									 if($loginType!=4)
									 {
										 $disabled="disabled";
										 $branchId=$find_who_row->branch_id;
									 }
									 else
									 {
										  $disabled="";
									 }
									 ?>
							<div class="col-sm-4">
                                <label for="grid12">Branch <span style="color:red">*</span>:</label>
                                <div class="form-group">
		                             <div class="controls">
										<select name="branchId" id="branchId" class="span8 input-square" required <?php echo $disabled; ?> >
										      <option value="" >Select Branch</option>
											   <?php
										   $branch=DB::getInstance()->getmultiple('branches',array('status' => 1));
										   foreach($branch->results() as $rt)
										   {
											   $braId=$rt->id;
											   ?>
										       <option value="<?php echo $rt->id; ?>" <?php if(($loginType!=4) && ($branchId==$braId)){ echo "selected"; } ?> ><?php echo $rt->name; ?>,<?php echo $rt->address; ?></option>
										   <?php } ?>
											  
											   
										</select>
									</div> 
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Type <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="controls">
										<select name="entry_type" id="entry_type" class="span8 input-square" required>
										   <option value="">Select Type</option>
										   <option value="1">Debit</option>
										   <option value="2">Credit</option>
										</select>
									</div> 
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Expence Category <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="controls">
										<select  name="catId" id="catId"  class="span8 input-square" required>
										      <option value="" >Select Category</option>
											  <option value="">Select Category</option>
										   <?php
										   $category=DB::getInstance()->getmultiple('expense_category',array('status' => 1));
										   foreach($category->results() as $rt)
										   {
											   $catId=$rt->id;
											   ?>
										       <option value="<?php echo $rt->id; ?>" ><?php echo $rt->title; ?></option>
										   <?php } ?>
											  
											   
										</select>
									</div> 
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Given By Name <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="given_by_name"  name="given_by_name" class="form-control" placeholder="Enter Given By name">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Given By Email :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="given_by_email"  name="given_by_email" class="form-control" placeholder="Enter Given By Email ">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Given By Contact :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  id="given_by_contact"  name="given_by_contact" class="form-control" placeholder="Enter given By Contact">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Received By Name <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  id="received_by_name" name="received_by_name" class="form-control" placeholder="Enter Received By name">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Received By Email *:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="received_by_email" name="received_by_email" class="form-control" placeholder="Enter Received By Email ">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Received By COntact *:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="received_by_contact" name="received_by_contact" class="form-control" placeholder="Enter Received By Contact ">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Amount <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  name="amount" id="amount"  class="form-control" placeholder="Enter  Amount">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Payment date <span style="color:red">*</span>:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="payment_date"  name="payment_date" class="form-control" placeholder="Enter Expence Category">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Payment Mode <span style="color:red">*</span> :</label>
                                <div class="form-group">
                                    <div class="controls">
										<select name="payment_mode" id="payment_mode" onchange="selectMode(this.value)" class="span8 input-square" required>
										    <option value="">Select Payment Mode</option>
										   <option value="1">Cash</option>
										   <option value="2">Cheque</option>
										   <option value="3">Other</option>
										</select>
									</div> 
                                </div>	
                            </div>
							
							
							<!--  Display None Stsrt-->
							<div class="col-sm-12 col-md-12 " id="chequeData"  style="margin-left:0px; display:none; ">
							    <div class="row">
									   <div class="col-sm-3">
										<label for="grid12">Cheque Number <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="text" id="cheque_no"  name="cheque_no" class="form-control" placeholder="Enter Cheque Number ">
											</div>
										</div>	
									</div>
									<div class="col-sm-3">
										<label for="grid12">Cheque Date <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="date" id="cheque_date"  name="cheque_date" class="form-control" placeholder="Choose Cheque date">
											</div>
										</div>	
									</div>
									<div class="col-sm-3">
										<label for="grid12">Bank Name <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="t" id="bank_name"  name="bank_name" class="form-control" placeholder="Enter Bank Name">
											</div>
										</div>	
									</div>
									<div class="col-sm-3">
										<label for="grid12"> Bank Branch <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="text" id="bank_branch"  name="bank_branch" class="form-control" placeholder="Enter Bank Name">
											</div>
										</div>	
									</div>
								</div>	
							</div>
							<div class="col-sm-12 col-md-12 " id="otherData"  style="margin-left:0px; display:none; ">
							    <div class="row">
								   <div class="col-sm-4">
										<label for="grid12">Reference Number <span style="color:red">*</span>:</label>
										<div class="form-group">
											<div class="form-line">
												<input type="text" id="reference_no"  name="reference_no" class="form-control" placeholder="Enter referance Number ">
											</div>
										</div>	
									</div>
								</div>
							</div>
									
									
							<!--   END OF DISPLAY NONE -->
							<div class="col-sm-6">
                                <label for="grid12">Remarks :</label>
                                <div class="form-group">
                                   <div class="form-line">
                                        <textarea name="remarks" id="remarks"  placeholder="Enter remarks.. " class="form-control"></textarea>
                                   </div>
                                </div>	
                            </div>
							
                           <div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="submit" value="Submit">
						   </div>

									</form>
									</div>
								
							</div>
						
						</div>
				

			
			
<?php

}	?>
	
<script>
function selectMode(vl)
{
	switch(vl)
	{
		case "1":  //**** Cash
		
		  $('#chequeData').hide();
		  $('#otherData').hide();
		  
		  $('#cheque_no').prop('required',false);
		  $('#cheque_date').prop('required',false);
		  $('#bank_name').prop('required',false);
		  $('#bank_branch').prop('required',false);
		  $('#reference_no').prop('required',false);
		  
		break;
		
		case "2": //**** Cheque
		
		  $('#chequeData').show();
		  $('#otherData').hide();	
		  
		  $('#cheque_no').prop('required',true);
		  $('#cheque_date').prop('required',true);
		  $('#bank_name').prop('required',true);
		  $('#bank_branch').prop('required',true);
		  $('#reference_no').prop('required',false);
		  
		break;
		
		case "3": //**** Other
		
		  $('#chequeData').hide();
		  $('#otherData').show();	
		  
		  $('#cheque_no').prop('required',false);
		  $('#cheque_date').prop('required',false);
		  $('#bank_name').prop('required',false);
		  $('#bank_branch').prop('required',false);
		  $('#reference_no').prop('required',true);
		  
		break;
   }
}
</script>

<?php include('common/footer.php'); ?>
