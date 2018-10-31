<?php 
include('common/header.php');
include('common/sidebar.php');

if(isset($_REQUEST['submit']))
{
   $name=$_REQUEST['name'];
   $email=$_REQUEST['email'];
   $contact=$_REQUEST['contact'];
   $enquiry_date=$_REQUEST['enquiry_date'];
   $enquiry_received_from=$_REQUEST['enquiry_received_from'];
   $message=$_REQUEST['message'];
   $current_status=$_REQUEST['current_status'];
   if($current_status!="1") 
   {
     $next_follow_up_date="0000-00-00";
   }
   else
   {
    $next_follow_up_date=$_REQUEST['next_follow_up_date'];
   }
   
   
   
   if((empty($name)) || (empty($email)) || (empty($contact)) || (empty($enquiry_date)) || (empty($enquiry_received_from)) || (empty($message)) || (empty($current_status)))
   {
     $_SESSION['err']="All fields are required";
   }
   else
   {
  
    $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
    $find_who_row=$find_who->first();
    $added_by=$find_who_row->id;
  
    $date=date('Y-m-d H:i:s');

    $in=DB::getInstance()->insert('enquiry',null,null,array('name' => $name,'email' => $email,'contact' => $contact,'enquiry_date' => $enquiry_date,'enquiry_received_from' => $enquiry_received_from,'current_status' => $current_status,'message' => $message,'current_next_followup_date' => $next_follow_up_date,'added_on' => $date,'added_by' => $added_by));
	
	if($current_status==1)
	{
	  $LastId=DB::getInstance()->lastinsert();
	  $up=DB::getInstance()->insert('enquiry_follow_ups',null,null,array('enquiry_id' => $LastId,'message' => $message,'next_follow_up_date' => $next_follow_up_date,'added_on' => $date,'added_by' => $added_by,'status' => $current_status));
	}
   
   
   $_SESSION['msg']="Enquiry added successfully";
   ?>
   <script>window.location='enquiry.php'</script>
   <?php
   }
}




if(isset($_REQUEST['update']))
{
   $rowid=$_REQUEST['rowid'];
   $name=$_REQUEST['name'];
   $email=$_REQUEST['email'];
   $contact=$_REQUEST['contact'];
   $enquiry_date=$_REQUEST['enquiry_date'];
   $enquiry_received_from=$_REQUEST['enquiry_received_from'];
   $message=$_REQUEST['message'];
  
   
   
   if((empty($name)) || (empty($email)) || (empty($contact)) || (empty($enquiry_date)) || (empty($enquiry_received_from)) || (empty($message)))
   {
     $_SESSION['err']="All fields are required";
   }
   else
   {
  
    $find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
    $find_who_row=$find_who->first();
    $added_by=$find_who_row->id;
  
    $date=date('Y-m-d H:i:s');

    $in=DB::getInstance()->updatewithoutimage('enquiry','id',$rowid,array('name' => $name,'email' => $email,'contact' => $contact,'enquiry_date' => $enquiry_date,'enquiry_received_from' => $enquiry_received_from,'message' => $message,'updated_on' => $date,'updated_by' => $added_by));
	
	
   $_SESSION['msg']="Enquiry updated successfully";
   ?>
   <script>window.location='enquiry.php'</script>
   <?php
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
							
								 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
			
				<?php
	if((isset($_REQUEST['mode'])) && ($_REQUEST['mode']=='edit'))
   {
	$id=base64_decode($_REQUEST['id']);
	$getData=DB::getInstance()->get('enquiry',array('id','=',$id));
?>
		<div class="card">

                        <div class="header">
                            <h2>
                               Update Enquiry
                            </h2>
                            
                        </div>
                        <div class="body">
	
						<form method="post" action="" enctype="multipart/form-data">
						
						<div class="row clearfix">
						 <input type="hidden" name="rowid" value="<?php echo $getData->first()->id; ?>">
							<div class="col-sm-4">
                                <label for="grid12">Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="name" value="<?php echo $getData->first()->name; ?>" name="name" required class="form-control" placeholder="Enter name">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Email :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="email" value="<?php echo $getData->first()->email; ?>"  name="email" class="form-control" placeholder="Enter Email " required>
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Contact :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  id="contact" value="<?php echo $getData->first()->contact; ?>"  required name="contact" class="form-control" placeholder="Enter Contact">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Enquiry Received From:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" value="<?php echo $getData->first()->enquiry_received_from; ?>"   id="enquiry_received_from" name="enquiry_received_from" required class="form-control" placeholder="(e.g Just Dial,Advertisment etc)" >
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Enquiry On</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="enquiry_date" value="<?php echo $getData->first()->enquiry_date; ?>" name="enquiry_date" class="form-control" placeholder="Enquiry on">
                                    </div>
                                </div>	
                            </div>
							<!--<div class="col-sm-4">
                                <label for="grid12"> Status :</label>
                                <div class="form-group">
                                     <div class="controls">
										<select name="current_status" onchange="selStatus()" id="current_status"  class="span8 input-square" required>
										  <option value=""> --select Status--</option>
										  <option value="1">Follow Up</option>
										  <option value="2">Converted</option>
										  <option value="3">Not Interested</option>
										</select>
									</div> 
                                </div>	
                            </div>-->
							
							<div class="col-sm-6">
                                <label for="grid12">Remarks :</label>
                                <div class="form-group">
                                   <div class="form-line">
                                        <textarea name="message" id="message"  placeholder="Enter remarks.. " class="form-control"><?php echo $getData->first()->message; ?></textarea>
                                   </div>
                                </div>	
                            </div>
							<!--<div class="col-sm-3 next-date" style="margin-left:0px; display:none; " >
								<label for="grid12">Next Follow Up Date :</label>
								<div class="form-group">
									<div class="form-line">
										<input type="date" id="next_follow_up_date"  name="next_follow_up_date" class="form-control" placeholder="Next Follow Up Date">
									</div>
								</div>	
							</div>-->
							
                           <div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="update" value="update">
						   </div>

									</form>
									</div>
								
							</div>
						
						</div>
					
		
		<?php
}
else
{
?>

<div class="card">

                        <div class="header">
                            <h2>
                               Add Enquiry
                            </h2>
                            
                        </div>
                        <div class="body">
	
						<form method="post" action="" enctype="multipart/form-data">
						<div class="row clearfix">
							<div class="col-sm-4">
                                <label for="grid12">Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="name"  name="name" required class="form-control" placeholder="Enter name">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Email :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="email"  name="email" class="form-control" placeholder="Enter Email ">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Contact :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  id="contact"  name="contact" class="form-control" placeholder="Enter Contact">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Enquiry Received From:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text"  id="enquiry_received_from" name="enquiry_received_from" required class="form-control" placeholder="(e.g Just Dial,Advertisment etc)">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Enquiry On</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" id="enquiry_date" name="enquiry_date" class="form-control" placeholder="Enquiry on">
                                    </div>
                                </div>	
                            </div>
							<div class="col-sm-4">
                                <label for="grid12">Received By COntact *:</label>
                                <div class="form-group">
                                     <div class="controls">
										<select name="current_status" onchange="selStatus()" id="current_status"  class="span8 input-square" required>
										  <option value=""> --select Status--</option>
										  <option value="1">Follow Up</option>
										  <option value="2">Converted</option>
										  <option value="3">Not Interested</option>
										</select>
									</div> 
                                </div>	
                            </div>
							
							<div class="col-sm-6">
                                <label for="grid12">Remarks :</label>
                                <div class="form-group">
                                   <div class="form-line">
                                        <textarea name="message" id="message"  placeholder="Enter remarks.. " class="form-control"></textarea>
                                   </div>
                                </div>	
                            </div>
							<div class="col-sm-3 next-date" style="margin-left:0px; display:none; " >
								<label for="grid12">Next Follow Up Date :</label>
								<div class="form-group">
									<div class="form-line">
										<input type="date" id="next_follow_up_date"  name="next_follow_up_date" class="form-control" placeholder="Next Follow Up Date">
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
           function selStatus()
			{
			  var vl=$('#current_status').val();
			  if(vl=="1")
			  {
			   $('.next-date').show();
			  }
			  else
			  {
			     $('.next-date').hide();
			  }
			}
</script>

<?php include('common/footer.php'); ?>
