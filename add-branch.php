<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['submit']))
{
	$date=date('Y-m-d H:i:s');
    $name=Input::get('name');
	$add=nl2br(Input::get('address'));
	$email=Input::get('email');
	$number=Input::get('number');
	$website=Input::get('website');
	$gst=Input::get('gst_number');
	$cin_number=Input::get('cin_number');
	$cgst_rate=Input::get('cgst_rate');
	$sgst_rate=Input::get('sgst_rate');
	$igst_rate=Input::get('igst_rate');
	$invoice_paper_size=Input::get('invoice_paper_size');
	$invoice_heading_font_size=Input::get('invoice_heading_font_size');
	$invoice_font_size=Input::get('invoice_font_size');
	$stock_setting=Input::get('stock_setting');
	
	
	$image=$_FILES['image']['name'];
	$tmpimg=$_FILES['image']['tmp_name'];
	$size=$_FILES['image']['size'];
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["image"]["name"]);
	$extension = end($temp);
	
	
	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();
	$branch_id=$find_who_row->branch_id;		
	$added_by=$find_who_row->id;		
	
    if((!empty($name)) && (!empty($add)) && (!empty($email)) && (!empty($number)) && (!empty($invoice_paper_size)) && (!empty($invoice_heading_font_size)) && (!empty($invoice_font_size)) && (!empty($gst)))
	{		
		if($image)
			{
				if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/png") || ($_FILES["image"]["type"] == "image/pjpeg")) 
		           {
					   $logo_old=$find_who_row->logo;		
	
						$url = $_FILES["image"]["name"]; 
						
						$random=rand(0,9898989);
						$time=time();
						$randName=$time.$random;
						$url=explode('.',$url);
						$ext=end($url);
						$file=$randName.".".$ext;
						
						$durl = "logo/".$file;
					   
						$up=DB::getInstance()->insert('branches',$tmpimg,$durl,array('name' => $name, 'address' => $add, 'email' => $email, 'number'=> $number, 'website' => $website,'logo'=> $file,'invoice_heading_font_size' => $invoice_heading_font_size, 'invoice_font_size' => $invoice_font_size,'invoice_paper_size' => $invoice_paper_size, 'gst_number' => $gst, 'cgst_rate' => $cgst_rate, 'sgst_rate' => $sgst_rate,  'igst_rate' => $igst_rate, 'cin_number' => $cin_number,'added_on' => $date,'added_by' => $added_by,'branch_type' => 2,'stock_setting' => $stock_setting));
						
						
						$_SESSION['msg']="Branch Added Successfully";
								?>
										<script>window.location='branches.php';</script>
								<?php
					 }
				 else
					 {
						$_SESSION['err']="File Invalid Try Again";
					 }
			}
		else
			{
				        $find_who=DB::getInstance()->get('branches',array('branch_type','=',1));
						$find_who_row=$find_who->first();
						$logo=$find_who_row->logo;	
						
						$up=DB::getInstance()->insertwithoutimage('branches',array('name' => $name, 'address' => $add, 'email' => $email, 'number'=> $number, 'website' => $website, 'logo' => $logo,'invoice_heading_font_size' => $invoice_heading_font_size, 'invoice_font_size' => $invoice_font_size,'invoice_paper_size' => $invoice_paper_size, 'gst_number' => $gst, 'cgst_rate' => $cgst_rate, 'sgst_rate' => $sgst_rate,  'igst_rate' => $igst_rate, 'cin_number' => $cin_number,'added_on' => $date,'added_by' => $added_by,'branch_type' => 2,'stock_setting' => $stock_setting));
					
						$_SESSION['msg']="Branch Added Successfully";
									?>
										<script>window.location='branches.php';</script>
										
									<?php
			}
    }
	else
	{
		$_SESSION['err']="All Fields are required";
	}
}





if(isset($_REQUEST['update']))
{

	$date=date('Y-m-d H:i:s');
    $id=Input::get('id');
    $name=Input::get('name');
	$add=nl2br(Input::get('address'));
	$email=Input::get('email');
	$number=Input::get('number');
	$website=Input::get('website');
	$gst=Input::get('gst_number');
	$cin_number=Input::get('cin_number');
	$cgst_rate=Input::get('cgst_rate');
	$sgst_rate=Input::get('sgst_rate');
	$igst_rate=Input::get('igst_rate');
	$invoice_paper_size=Input::get('invoice_paper_size');
	$invoice_heading_font_size=Input::get('invoice_heading_font_size');
	$invoice_font_size=Input::get('invoice_font_size');
	$stock_setting=Input::get('stock_setting');
	
	
	$image=$_FILES['image']['name'];
	$tmpimg=$_FILES['image']['tmp_name'];
	$size=$_FILES['image']['size'];
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["image"]["name"]);
	$extension = end($temp);
	
	
	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();
	$branch_id=$find_who_row->branch_id;		
	$added_by=$find_who_row->id;		
	
    if((!empty($name)) && (!empty($add)) && (!empty($email)) && (!empty($number)) && (!empty($invoice_paper_size)) && (!empty($invoice_heading_font_size)) && (!empty($invoice_font_size)) && (!empty($gst)))
	{		
		if($image)
			{
				if (($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/png") || ($_FILES["image"]["type"] == "image/pjpeg")) 
		           {
					   $logo_old=$find_who_row->logo;		
	
						$url = $_FILES["image"]["name"]; 
						
						$random=rand(0,9898989);
						$time=time();
						$randName=$time.$random;
						$url=explode('.',$url);
						$ext=end($url);
						$file=$randName.".".$ext;
						
						$durl = "logo/".$file;
					   
						$up=DB::getInstance()->update('branches','id',$id,$tmpimg,$durl,array('name' => $name, 'address' => $add, 'email' => $email, 'number'=> $number, 'website' => $website,'logo'=> $file,'invoice_heading_font_size' => $invoice_heading_font_size, 'invoice_font_size' => $invoice_font_size,'invoice_paper_size' => $invoice_paper_size, 'gst_number' => $gst, 'cgst_rate' => $cgst_rate, 'sgst_rate' => $sgst_rate,  'igst_rate' => $igst_rate, 'cin_number' => $cin_number,'updated_on' => $date,'updated_by' => $added_by,'branch_type' => 2,'stock_setting' => $stock_setting));
						
						
						$_SESSION['msg']="Branch Added Successfully";
								?>
										<script>window.location='branches.php';</script>
								<?php
					 }
				 else
					 {
						$_SESSION['err']="File Invalid Try Again";
					 }
			}
		else
			{
						$up=DB::getInstance()->updatewithoutimage('branches','id',$id,array('name' => $name, 'address' => $add, 'email' => $email, 'number'=> $number, 'website' => $website,'invoice_heading_font_size' => $invoice_heading_font_size, 'invoice_font_size' => $invoice_font_size,'invoice_paper_size' => $invoice_paper_size, 'gst_number' => $gst, 'cgst_rate' => $cgst_rate, 'sgst_rate' => $sgst_rate,  'igst_rate' => $igst_rate, 'cin_number' => $cin_number,'updated_on' => $date,'updated_by' => $added_by,'branch_type' => 2,'stock_setting' => $stock_setting));
					
						$_SESSION['msg']="Branch Added Successfully";
									?>
										<script>window.location='branches.php';</script>
										
									<?php
			}
    }
	else
	{
		$_SESSION['err']="All Fields are required";
	}
}


?>
<div class="block-header">
                <ol class="breadcrumb breadcrumb-bg-teal align-right">
                                <li><a href="javascript:void(0);"><i class="material-icons">home</i> Home</a></li>
                                <li><a href="javascript:history.back()">Back</a></li>
                               
                            </ol>
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
	if(isset($_REQUEST['mode']))
	{
	$mode=$_REQUEST['mode'];
	switch($mode)
	{
	case "edit":
	
	$id=base64_decode($_REQUEST['id']);
	$del=DB::getInstance()->get('branches',array('id','=',$id));
    $branchData_Row=$del->first();
	
	?>
	 <div class="card">
                        <div class="header">
                            <h2>
                               Update Branch
                            </h2>
                            
                        </div>
                        <div class="body">
						<h3>Basic Details</h3>
						<form method="post" action="" enctype="multipart/form-data">
						<div class="row clearfix">
						<input type="hidden" value="<?php echo $id; ?>" name="id">
						<div class="col-sm-4">
								<label for="name">Compnay Name:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="name"  name="name" class="form-control" value="<?php echo $branchData_Row->name; ?>">
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-4">
								<label for="email">Email Id:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="email"  name="email" class="form-control" value="<?php echo $branchData_Row->email; ?>">
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-4">
								<label for="number">Number:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="number"  name="number" class="form-control" value="<?php echo $branchData_Row->number; ?>">
                                    </div>
                                </div>
								
								</div>
								</div>
								<div class="row clearfix">
								
								<div class="col-sm-4">
								<label for="website">Website:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="website"  name="website" class="form-control" value="<?php echo $branchData_Row->website; ?>">
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-4">
								<label for="address">Address:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                       <textarea rows="2" cols="5" id="address"  name="address" class="form-control" ><?php echo strip_tags($branchData_Row->address); ?></textarea>
                                    </div>
                                </div>
								
								</div>
								
								<div class="col-sm-4">
								<label for="logo">Logo:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                      
										<input type="file" name="image" id="form-field-1" class="form-control"  value="<?php echo $branchData_Row->logo;?>"/>
									   
                                    </div>
                                </div>
								
								</div>
								</div>
								<div class="row clearfix">
								<div class="col-sm-4">
								 <img src="<?php echo $base_url?>logo/<?php echo $branchData_Row->logo;?>" style="width:70%;">
								</div>
								<div class="col-sm-4">
								<label for="gst_number">GST Number:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                      
										<input type="text" name="gst_number" id="gst_number" class="form-control"  value="<?php echo $branchData_Row->gst_number; ?>"/>
									   
                                    </div>
                                </div>
								
								</div>
								
								<div class="col-sm-4">
								<label for="cin_number">CIN Number:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                      
										<input type="text" name="cin_number" id="cin_number" class="form-control"  value="<?php echo $branchData_Row->cin_number; ?>"/>
									   
                                    </div>
                                </div>
								
								</div>
								</div>
								<div class="row clearfix">
								<div class="col-sm-4">
								<label for="cgst_rate">CGST Rate:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                      
										<input type="text" name="cgst_rate" id="cgst_rate" class="form-control"  value="<?php echo $branchData_Row->cgst_rate; ?>"/>
									   
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-4">
								<label for="sgst_rate">SGST Rate:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                      
										<input type="text" name="sgst_rate" id="sgst_rate" class="form-control"  value="<?php echo $branchData_Row->sgst_rate; ?>"/>
									   
                                    </div>
                                </div>
								
								</div>
								
								<div class="col-sm-4">
								<label for="igst_rate">IGST Rate:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                      
										<input type="text" name="igst_rate" id="igst_rate" class="form-control"  value="<?php echo $branchData_Row->igst_rate; ?>"/>
									   
                                    </div>
                                </div>
								
								</div>
								</div>
								<div class="row clearfix">
								<div class="col-sm-4">
								<label for="cin_number">CIN Number:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                      
										<input type="text" name="cin_number" id="cin_number" class="form-control"  value="<?php echo $branchData_Row->cin_number; ?>"/>
									   
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-4">
								<?php
													$paperSize=$branchData_Row->invoice_paper_size;
													
													?>
								<label for="cin_number">Invoice Paper Size::</label>
								
									 
									 <select name="invoice_paper_size" class="form-control show-tick"  required>
										      <option>Select Paper Size</option>
										       <option value="A4-L" <?php if($paperSize=="A4-L") { echo "selected"; } ?> >A4-L</option>
											   <option value="A5-L" <?php if($paperSize=="A5-L") { echo "selected"; } ?>>A5-L</option>
											   <option value="A3-L" <?php if($paperSize=="A3-L") { echo "selected"; } ?>>A3-L</option>
											   <option value="Legal" <?php if($paperSize=="Legal") { echo "selected"; } ?> >Legal</option>
											   <option value="Letter" <?php if($paperSize=="Letter") { echo "selected"; } ?> >Letter</option>
											   <option value="Executive" <?php if($paperSize=="Executive") { echo "selected"; } ?> >Executive</option>
											   <option value="Royal" <?php if($paperSize=="Royal") { echo "selected"; } ?> >Royal</option>
											  
											   
										</select>
									
								</div>
								
								<div class="col-sm-4">
								<?php
								$invoice_heading_font_size=$branchData_Row->invoice_heading_font_size;
								?>
								<label for="invoice_heading_font_size">Invoice Heading Font Size :</label>
								
									 
									 <select name="invoice_heading_font_size" class="form-control show-tick"  required>
										      <option>Select Font Size</option>
										
										<?php 
										for($f=10;$f<=20;$f++)
										{
											$ft=$f."pts";
										?>
											   <option value="<?php echo $ft; ?>" <?php if($invoice_heading_font_size==$ft) { echo "selected"; } ?> ><?php echo $ft ?></option>
											  
											  <?php
		                                      }
											  ?>
											  
											   
										</select>
									
								</div>
								</div>
								<div class="row clearfix">
								<div class="col-sm-4">
								<?php
													$invoice_font_size=$branchData_Row->invoice_font_size; 
													?>
								<label for="invoice_font_size">Invoice  Font Size :</label>
								
									 
									 <select name="invoice_font_size" class="form-control show-tick"  required>
										      <option>Select Font Size</option>
										
										<?php 
										for($fb=8;$fb<=20;$fb++)
										{
											$fbt=$fb."pts";
										?>
											   <option value="<?php echo $fbt; ?>" <?php if($invoice_font_size==$fbt) { echo "selected"; } ?> ><?php echo $fbt ?></option>
											  
											  <?php
		                                      }
											  ?>
											  
											   
										</select>
									
								</div>
								<div class="col-sm-4">
								<?php
								     $stock_setting=$branchData_Row->stock_setting;
								    ?>
								<label  for="form-field-1">Stock Needed ? :</label>
								<select name="stock_setting" class="form-control show-tick" required>
									 
										      <option value="0"  <?php if($stock_setting=="0") { echo "selected"; } ?>>No</option>
										      <option value="1"  <?php if($stock_setting=="1") { echo "selected"; } ?>>Yes</option>
										
									
									</select>
								</div>
								<div class="col-sm-4">
								<?php
								$invoice_heading_font_size=$branchData_Row->invoice_heading_font_size;
								?>
								<?php
													$invoice_font_size=$branchData_Row->invoice_font_size; 
													?>
													<label class="control-label" for="form-field-1">Invoice Font Size: </label>
		                             <div class="controls">
									 
									 	<select name="invoice_font_size" class="form-control show-tick" required>
										      <option>Select Font Size</option>
										
										<?php 
										for($fb=8;$fb<=20;$fb++)
										{
											$fbt=$fb."pts";
										?>
											   <option value="<?php echo $fbt; ?>" <?php if($invoice_font_size==$fbt) { echo "selected"; } ?> ><?php echo $fbt ?></option>
											  
											  <?php
		                                      }
											  ?>
											   
										</select>
									</div>
								</div>
								</div>
								<div class="row clearfix">
<div class="col-sm-4">
<input type="submit" class="btn btn-green3 btn-success" name="update" value="Update Branch">
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

$GetData=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$rowData=$GetData->first();
$branch_id=$rowData->branch_id;
							
$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
$branchData_Row=$branchData->first();
$CompanyName=$branchData_Row->name;
	
?>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<div class="card">
                        <div class="header">
                            <h2>
                               Add Branch
                            </h2>
                            
                        </div>
                        <div class="body">
<form method="post" action="" enctype="multipart/form-data">
<div class="col-sm-6">
								<label for="company_name">Compnay Name:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="company_name"  name="name" class="form-control" value="<?php echo $CompanyName; ?>">
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-6">
								<label for="email_id">Email Id:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="email_id"  name="email" class="form-control" value="<?php echo $branchData_Row->email; ?>" >
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-6">
								<label for="number">Number:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="number"  name="number" class="form-control" value="<?php echo $branchData_Row->number; ?>">
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-6">
								<label for="website">Website:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="number"  name="website" class="form-control" value="<?php echo $branchData_Row->website; ?>">
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-6">
								<label for="address">Address:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea id="tinymce" id="address"  name="address" class="form-control" ><?php echo $branchData_Row->address; ?></textarea>
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-4">
								<label for="image">Logo:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" id="image"  name="image" class="form-control" value="<?php echo $branchData_Row->logo;?>">
									
                                    </div>
                                </div>
								
								</div>
								<div class="col-sm-4">
									<img src="<?php echo $base_url?>logo/<?php echo $branchData_Row->logo;?>" style="width:70%;">
								</div>
								<div class="col-sm-12">
								<h3>Business Details</h3>
								</div>
			<div class="col-sm-4">
			<label for="gst">GST Number:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="gst"  name="gst_number" class="form-control" value="<?php echo $branchData_Row->gst_number; ?>">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-4">
			<label for="cin">CIN Number:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="cin"  name="cin_number" class="form-control" value="<?php echo $branchData_Row->cin_number; ?>">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-4">
			<label for="cgst">CGST Rate :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="cgst"  name="cgst_rate" class="form-control" value="<?php echo $branchData_Row->cgst_rate; ?>">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-4">
			<label for="sgst">SGST Rate :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="sgst"  name="sgst_rate" class="form-control" value="<?php echo $branchData_Row->sgst_rate; ?>">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-4">
			<label for="igst">IGST Rate :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="igst"  name="igst_rate" class="form-control" value="<?php echo $branchData_Row->igst_rate; ?>">
                                    </div>
                                </div>
			</div>
			<div class="col-sm-4">
			<?php
													$paperSize=$branchData_Row->invoice_paper_size;
													
													?>
													
													<label for="form-field-1">Invoice Paper Size: </label>
		                            
									 <select class="form-control show-tick" name="invoice_paper_size" data-live-search="true" required>
										      <option>Select Paper Size</option>
										       <option value="A4-L" <?php if($paperSize=="A4-L") { echo "selected"; } ?> >A4-L</option>
											   <option value="A5-L" <?php if($paperSize=="A5-L") { echo "selected"; } ?>>A5-L</option>
											   <option value="A3-L" <?php if($paperSize=="A3-L") { echo "selected"; } ?>>A3-L</option>
											   <option value="Legal" <?php if($paperSize=="Legal") { echo "selected"; } ?> >Legal</option>
											   <option value="Letter" <?php if($paperSize=="Letter") { echo "selected"; } ?> >Letter</option>
											   <option value="Executive" <?php if($paperSize=="Executive") { echo "selected"; } ?> >Executive</option>
											   <option value="Royal" <?php if($paperSize=="Royal") { echo "selected"; } ?> >Royal</option>
											  
											   
										</select>
									             
			</div>
			<div class="col-sm-4">
			<?php
								$invoice_heading_font_size=$branchData_Row->invoice_heading_font_size;
								?>
			<label for="form-field-1"> Invoice Heading Font Size :</label>
			<?php
													$invoice_font_size=$branchData_Row->invoice_font_size; 
													?>
			 <select name="invoice_heading_font_size" class="form-control show-tick"  required>
										      <option>Select Font Size</option>
										
										<?php 
										for($f=10;$f<=20;$f++)
										{
											$ft=$f."pts";
										?>
											   <option value="<?php echo $ft; ?>" <?php if($invoice_heading_font_size==$ft) { echo "selected"; } ?> ><?php echo $ft ?></option>
											  
											  <?php
		                                      }
											  ?>
											   
										</select>
			</div>
			<div class="col-sm-4">
			
									<label for="form-field-1">Invoice Font Size: </label>
								
													<select name="invoice_font_size" class="form-control show-tick"  required>
										      <option>Select Font Size</option>
										
										<?php 
										for($fb=8;$fb<=20;$fb++)
										{
											$fbt=$fb."pts";
										?>
											   <option value="<?php echo $fbt; ?>" <?php if($invoice_font_size==$fbt) { echo "selected"; } ?> ><?php echo $fbt ?></option>
											  
											  <?php
		                                      }
											  ?>
											   
										</select>
			</div>
			<div class="col-sm-4">
			<?php
								     $stock_setting=$branchData_Row->stock_setting;
								    ?>
			<label for="form-field-1">Stock Needed ? :</label>
		                        
									 <select name="stock_setting" class="form-control show-tick"  required>
									 
										      <option value="0"  <?php if($stock_setting=="0") { echo "selected"; } ?>>No</option>
										      <option value="1"  <?php if($stock_setting=="1") { echo "selected"; } ?>>Yes</option>
										
									
										</select>
										
			</div>
			<div class="col-sm-4">
			<input type="submit" class="btn btn-green3" name="submit" value="Save Branch">
			</div>
			
									<div class="hjmspan12">
									<div class="">
													<label class=""> Invoice Heading Font Size :</label>
		                            
									                </div>
													
													
													
													<label class="control-label" for="form-field-1">Invoice Font Size: </label>
		                           
									                </div>
									                


													
									
									<input type="submit" class="btn btn-green3" name="submit" value="Save Branch">

			
			
</form>
	</div>
</div>	
</div>				
			
<?php

}	?>
	


<script>

function SelProType(vl)
{
if(vl==2)
{
	var ctId=$('#catId').val();
	
	 $.ajax({
		type: "POST",
		url: "ajax.php",
		data: 'mode=proType&catId=' + ctId,
		cache: true,
		success: function(dat){
			
	       $("#AjaxResult" ).html(dat);
		}  
		});
   }
   else
   {
	   $("#AjaxResult" ).html('');
   }
}
</script>
 <!-- TinyMCE -->
  <!-- Ckeditor -->
    <script src="assets/plugins/ckeditor/ckeditor.js"></script>
    <script src="assets/plugins/tinymce/tinymce.js"></script>
	<script src="assets/js/pages/forms/editors.js"></script>
<?php include('common/footer.php'); ?>
