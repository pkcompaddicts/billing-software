<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['submit']))
{
	$date=date('Y-m-d H:i:s');
    $to = $_POST['to_members'];
	
	$n_temp = $_POST['to_numbers'];
	$number = explode(',',$n_temp);
	$sms = $_POST['message'];
	
	$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
	$find_who_row=$find_who->first();
	$branch_id=$find_who_row->branch_id;		
	$added_by=$find_who_row->id;	
	
	if(((!empty($sms)) || ($sms!="")) && ((!empty($to)) || ($to!="") || (count($number)!=0)))
	{
		for($i = 0;$i < count($to);$i++){
				$n = $to[$i];
				$find_user=DB::getInstance()->get('users',array('id','=',$n));
				$rt=$find_user->first();
				$contact=$rt->contact;
				
				$in=DB::getInstance()->insert('messages',null,null,array('user_id' => $n, 'sms' => $sms, 'number'=> $contact, 'added_on' => $date,'added_by'=> $added_by));
							
			    $to_open='http://nimbusit.co.in/api/swsend.asp?username=t1compaddicts&password=1234567&sender=COMPAD&sendto='.$contact.'&message='.urlencode($sms);
                $stat = file_get_contents($to_open);
			}
			
			
		  for($j = 0;$j < count($number);$j++){
				$contact = $number[$j];
				
				$in=DB::getInstance()->insert('messages',null,null,array('sms' => $sms, 'number'=> $contact, 'added_on' => $date,'added_by'=> $added_by));
				
                $to_open='http://nimbusit.co.in/api/swsend.asp?username=t1compaddicts&password=1234567&sender=COMPAD&sendto='.$contact.'&message='.urlencode($sms);
                $stat = file_get_contents($to_open);
			}
			
			$_SESSION['msg']="SMS sent successfully";
			?>
			<script>window.location='sms.php'</script>
			<?php
	}
	else
	{
	  $_SESSION['err']="Message and number both are required";
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
                   <div class="card">
                        <div class="header">
                            <h2> Send Sms </h2>
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
							<div class="col-sm-offset-3 col-sm-6">
                                <label for="grid12">Members </label>
                                <div class="form-group">
		                             <div class="controls">
										<select name="to_members[]"  class="span8 input-square form-control" multiple >
										     <option value="">Select Some Option </option>
											  <?php
										$de=DB::getInstance()->query("select * from users ORDER by id DESC");
										foreach($de->results() as $row)
										{
										?>
										       <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?> ( <?php echo $row->contact; ?> )</option>
										   <?php } ?>
											  
											   
										</select>
									</div> 
                                </div>	
                            </div>
							
							<div class="col-sm-offset-3 col-sm-6">
                                <label for="grid12"> Other Contact Number</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="to_numbers"  name="to_numbers" class="form-control" placeholder="Please Write Your Contact Number separated by comma (,)" >
                                    </div>
                                </div>	
                            </div>
							
							<div class="col-sm-offset-3 col-sm-6">
                                <label for="grid12">Your Message :</label>
                                <div class="form-group">
                                   <div class="form-line">
                                        <textarea name="message" id="message"  placeholder="Enter Message.. " class="form-control"></textarea>
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
				

			
			

	


<?php include('common/footer.php'); ?>
