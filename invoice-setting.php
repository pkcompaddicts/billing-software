<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['updateProfile']))		
{
	$signatory_name=Input::get('signatory_name');
	$gst=Input::get('gst_number');
	$cin_number=Input::get('cin_number');
	$cgst_rate=Input::get('cgst_rate');
	$sgst_rate=Input::get('sgst_rate');
	$igst_rate=Input::get('igst_rate');
	$invoice_paper_size=Input::get('invoice_paper_size');
	$invoice_heading_font_size=Input::get('invoice_heading_font_size');
	$invoice_font_size=Input::get('invoice_font_size');
	$stock_setting=Input::get('stock_setting');

	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();
	$rowId=$find_who_row->id;		
	$branch_id=$find_who_row->branch_id;		
	
    if((!empty($invoice_paper_size)) && (!empty($invoice_heading_font_size)) && (!empty($invoice_font_size)) && (!empty($signatory_name)) && (!empty($gst)))
	{		
  		   $up=DB::getInstance()->updatewithoutimage('branches','id',$branch_id,array('invoice_heading_font_size' => $invoice_heading_font_size, 'invoice_font_size' => $invoice_font_size,'invoice_paper_size' => $invoice_paper_size, 'gst_number' => $gst, 'cgst_rate' => $cgst_rate, 'sgst_rate' => $sgst_rate,  'igst_rate' => $igst_rate, 'cin_number' => $cin_number,'stock_setting' => $stock_setting));
		   
		   
		    $up=DB::getInstance()->updatewithoutimage('admin','id',$rowId,array('signatory_name' => $signatory_name));
			
			
						$_SESSION['msg']="Profile Updated Successfully";
									?>
										<script>window.location='invoice-setting.php';</script>
										
									<?php
    }
	else
	{
		$_SESSION['err']="All Fields are required";
	}
}
								
								
$del=DB::getInstance()->getmultiple('admin',array('login_type' => 4));
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<?php
									if(isset($_SESSION['msg']))
									{ ?>
									 <div class="alert alert-block alert-success text-solve">
										<a class="close" data-dismiss="alert" href="#">X</a>
											<?php echo $_SESSION['msg'];?>
									</div>
									<?php} ?>
									<?php
									if(isset($_SESSION['err']))
									{ ?>
										 <div class="alert alert-block alert-error text-error">
											<a class="close" data-dismiss="alert" href="#">X</a>
											<?php echo $_SESSION['err'];?>
										 </div>
									<?php } ?>
						</div>
							
				
			<div class="row-fluid">
		
		<?php
		if((isset($_REQUEST['mode'])) && ($_REQUEST['mode']=="edit"))
		{
            $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
			$find_who_row=$find_who->first();
            $loginType=$find_who_row->login_type;
            $branch_id=$find_who_row->branch_id;

			$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
			$branchData_Row=$branchData->first();

		?>
			<div class="span6">
					<div class="box">
						<div class="box-head tabs">
							<h3>Update Profile</h3>
							
						</div>
						<div class="box-content box-nomargin">
						<div class="box-content">
						
									
								
							<div class="tab-content">
									<div class="tab-pane active" id="basic">
										<form method="post" action="" enctype="multipart/form-data">
							
								
												<div class="control-group">
													<label class="control-label" for="form-field-1">Signatory Name:</label>
														 <div class="controls">
															<input type="text" name="signatory_name" id="form-field-1"  value="<?php echo $find_who_row->signatory_name;?>"  style="width:90%"/>
														</div>
									                </div>
													
												
													<div class="control-group">
													<label class="control-label" for="form-field-1"> GST Number :</label>
														 <div class="controls">
															<input type="text" name="gst_number" id="form-field-1"  <?php if($loginType==2) { ?> readonly <?php } ?> value="<?php echo $branchData_Row->gst_number;?>" style="width:90%"/>
														</div>
									                </div>
													
													<div class="control-group">
													<label class="control-label" for="form-field-1"> CIN Number :</label>
														 <div class="controls">
															<input type="text" name="cin_number" id="form-field-1" <?php if($loginType==2) { ?> readonly <?php } ?> value="<?php echo $branchData_Row->cin_number;?>" style="width:90%"/>
														</div>
									                </div>
													
													<div class="control-group">
													<label class="control-label" for="form-field-1"> CGST Rate:</label>
													   <div class="controls has-feedback">
													 
															<div class="input-append">
															  <input type="text" name="cgst_rate" id="form-field-1" <?php if($loginType==2) { ?> readonly <?php } ?> value="<?php echo $branchData_Row->cgst_rate;?>" style="width:90%"/><span class="add-on">%</span>
															</div>
				  
													     </div>
									                </div>
													
													
													<div class="control-group">
													<label class="control-label" for="form-field-1"> SGST Rate :</label>
														 <div class="controls">
														 
																<div class="input-append">
																   <input type="text" name="sgst_rate" id="form-field-1" <?php if($loginType==2) { ?> readonly <?php } ?> value="<?php echo $branchData_Row->sgst_rate;?>" style="width:90%"/><span class="add-on">%</span>
																</div>
																
															
														</div>
									                </div>
													
													
													<div class="control-group">
													 <label class="control-label" for="form-field-1"> IGST Rate :</label>
													 <div class="controls">
														 
																<div class="input-append">
																  	<input type="text" name="igst_rate" id="form-field-1"  <?php if($loginType==2) { ?> readonly <?php } ?> value="<?php echo $branchData_Row->igst_rate;?>" style="width:90%"/><span class="add-on">%</span>
																</div>
																
															
														</div>
													 </div>
													
													<?php
													$paperSize=$branchData_Row->invoice_paper_size;
													?>
													<div class="control-group">
													<label class="control-label" for="form-field-1">Invoice Paper Size:</label>
		                             <div class="controls">
										<select name="invoice_paper_size" class="span8 input-square" required>
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
									                </div>
								
								
								                   <?php
													$invoice_heading_font_size=$branchData_Row->invoice_heading_font_size;
													?>
													<div class="control-group">
													<label class="control-label" for="form-field-1">Invoice Heading Font Size:</label>
		                             <div class="controls">
										<select name="invoice_heading_font_size" class="span8 input-square" required>
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
													
													
													  <?php
													$invoice_font_size=$branchData_Row->invoice_font_size;
													?>
													<div class="control-group">
													<label class="control-label" for="form-field-1">Invoice Font Size:</label>
		                             <div class="controls">
										<select name="invoice_font_size" class="span8 input-square" required>
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
													
													
										<?php
											$stock_setting=$branchData_Row->stock_setting;
										?>
													<div class="control-group">
													<label class="control-label" for="form-field-1">Stock Needed ? :</label>
														 <div class="controls">
															<select name="stock_setting" class="span8 input-square" required>
														 
																  <option value="0"  <?php if($stock_setting=="0") { echo "selected"; } ?>>No</option>
																  <option value="1"  <?php if($stock_setting=="1") { echo "selected"; } ?>>Yes</option>
															
														
															</select>
														</div>
									                </div>
													
													
									<div class="control-group">
									<div class="controls">
									<input type="submit" class="btn btn-green3 pull-right" name="updateProfile" value="Submit">
									</div>
									</div>
									</form>
									</div>
								
							</div>
						
						</div>
					</div>
				</div>
			</div>
			
			<?php
			}
			else
			{
				
				$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
				$find_who_row=$find_who->first();
				$login_type=$find_who_row->login_type;
				$branch_id=$find_who_row->branch_id;

				$branchData=DB::getInstance()->get('branches',array('id','=',$branch_id));
				$branchData_Row=$branchData->first();
					
			?>
			<div class="span12">
				<div class="box">
					<div class="box-head">
						<h3>Your Profile</h3>
					</div>
					<div class="box-content">
					<a href="change-password.php" class="btn btn-mini btn-green3 pull-right" style="margin-left: 10px;">Change Password</a>
					
					<a href="invoice-setting.php?mode=edit" class="btn btn-mini btn-red3 pull-right">Update Setting</a>
					
						<div class="cl">
							<div class="pull-left">
								
								<img src="<?php echo $baseurl; ?>logo/<?php echo $branchData->first()->logo; ?>" alt="<?php echo $branchData->first()->name; ?>" style="width:150px">
							</div>
							<div class="details pull-left userprofile">
								<table class="table table-striped table-detail">
									<tbody>
									
									<tr>
										<th>Signatory Name: </th>
										<td><?php echo $find_who_row->signatory_name; ?></td>
									</tr>

									<?php
									$gst_number=$branchData->first()->gst_number;
									if($gst_number!="")
									{
										$gst_number=$gst_number;
									}
									else
									{
										$gst_number="---";
									}
									?>
									<tr>
										<th>GST Number: </th>
										<td><?php echo $gst_number; ?></td>
									</tr>
									
									<?php
									$cgst_rate=$branchData->first()->cgst_rate;
									if($cgst_rate!="")
									{
										$cgst_rate=$cgst_rate."%";
									}
									else
									{
										$cgst_rate="---";
									}
									?>
									<tr>
										<th>CGST Rate: </th>
										<td><?php echo $cgst_rate; ?></td>
									</tr>
									
									<?php
									$sgst_rate=$branchData->first()->sgst_rate;
									if($sgst_rate!="")
									{
										$sgst_rate=$sgst_rate."%";
									}
									else
									{
										$sgst_rate="---";
									}
									?>
									<tr>
										<th>SGST Rate: </th>
										<td><?php echo $sgst_rate; ?></td>
									</tr>
									
									<?php
									$igst_rate=$branchData->first()->igst_rate;
									if($igst_rate!="")
									{
										$igst_rate=$igst_rate."%";
									}
									else
									{
										$igst_rate="---";
									}
									?>
									<tr>
										<th>IGST Rate: </th>
										<td><?php echo $igst_rate; ?></td>
									</tr>
									
									<?php
									$cin_number=$branchData->first()->cin_number;
									if($cin_number!="")
									{
										$cin_number=$cin_number;
									}
									else
									{
										$cin_number="---";
									}
									?>
									<tr>
										<th>CIN Number: </th>
										<td><?php echo $cin_number; ?></td>
									</tr>
								
								    <tr>
										<th>Invoice Paper Size: </th>
										<td><?php echo $branchData->first()->invoice_paper_size; ?></td>
									</tr>
								
								    <tr>
										<th>Invoice Heading Font Size: </th>
										<td><?php echo $branchData->first()->invoice_heading_font_size; ?></td>
									</tr>
									
									<tr>
										<th>Invoice Font Size: </th>
										<td><?php echo $branchData->first()->invoice_font_size; ?></td>
									</tr>
									
									<?php
									$stock_setting=$branchData->first()->stock_setting;
									if($stock_setting=="0")
									{
										$stockSetting="No";
									}
									else
									{
										$stockSetting="Yes";
									}
									?>
									
									<tr>
										<th>Stock Needed ? : </th>
										<td><?php echo $stockSetting; ?></td>
									</tr>
								
								</tbody></table>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			
			<?php
			}
			?>
		</div>
	</div>
</div>	


<?php include('common/footer.php'); ?>