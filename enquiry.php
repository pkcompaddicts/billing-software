<?php 
include('common/header.php');
include('common/sidebar.php');

if(isset($_REQUEST['mode']))
{
$mode=$_REQUEST['mode'];
switch($mode)
{
case "delete":
$id=base64_decode($_REQUEST['id']);
$del=DB::getInstance()->delete('enquiry',array('id','=',$id));
$_SESSION['msg']='Deleted Successfully';  
?>
<script>window.location='enquiry.php'</script>
<?php
break;
}
}
if(isset($_REQUEST['deleteselected']))
{
$id=implode(',',$_REQUEST['ch']);
$fg=explode(',',$id);
$cnt=count($fg);
for($a=0;$a<$cnt;$a++)
{
$id=$fg[$a];
$del=DB::getInstance()->delete('enquiry',array('id','=',$id));
} 
$_SESSION['msg']="Selected Items Deleted Successfully";
?>
<script>window.location='enquiry.php'</script>
<?php
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
<div class="row clearfix">
           <form action="" method="POST">
		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        
                        <div class="body">
                          
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                   <input type="submit" class="btn btn-lg btn-block btn-danger " name="deleteselected" onclick="return confirm('YOU ARE GOING TO DELETE SELECTED ITEMS')"  value="Delete Selected">
                                </div>
                               
                                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <a href="add-enquiry.php" class="btn btn-lg btn-warning btn-block pull-right" >Add Enquiry</a>
                                </div>
                            </div>
                        
                    </div>
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
                    <div class="card">
                        <div class="header">
                            <h2>
                               Enquiries
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
												<tr>
												<th><input type="checkbox" onclick="checkAll(this)"></th>
												<th>Name</th>
												<th>Email</th>
												<th>Contact</th>
												<th>Enquiry From</th>
												<th>Message</th>
												<th>Enquiry Date</th>
												<th>Status</th>
												<th>Action</th>
												</tr>
											</thead>
											
											<tbody>
								<?php 
								            $per_page = 10;  
								            $del=DB::getInstance()->query("select * from enquiry $whereadded_by  ORDER by id DESC");
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

											$del=DB::getInstance()->query("select * from enquiry $whereadded_by  ORDER by id DESC LIMIT $start,$per_page");

											foreach($del->results() as $row)
											{
											  
											?>
												<tr>
												<td><input type="checkbox" value="<?php echo $row->id ;?>" name="ch[]"></td>
										        <td><?php echo $row->name;?> </td>
										        <td><?php echo $row->email;?></td>
										        <td><?php echo $row->contact;?></td>
										        <td><?php echo $row->enquiry_received_from;?></td>
										        <td><?php echo $row->message;?></td>
										        <td><?php echo date('F j,Y',strtotime($row->enquiry_date)); ?></td>
												
										        <td>
												 <?php 
															$status=$row->current_status;
															switch($status)
															{
															case "1":
															?>
															  <a class="label label-warning" style="font-weight:normal">Follow Up</a> <br/>
															  <b>Next Follow Up Date : </b> <?php echo date('F j,Y',strtotime($row->current_next_followup_date)); ?>
															<?php
															break;
															
															case "2":
															?>
															<a class="label label-success" style="font-weight:normal">Converted</a>
															<?php
															break;
															
															case "3":
															?>
															<a class="label label-important" style="font-weight:normal; color:skyblue; ">Not Interested</a>
															<?php
															break;
															
															}
													?>
													
												</td>
												 <td>
										
												    <a href="enquiry.php?id=<?php echo base64_encode($row->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS ENQUIRY')">
												        <img src="img/icons/fugue/cross.png" alt="">
													</a> 

													<a href="add-enquiry.php?mode=edit&id=<?php echo base64_encode($row->id);?>">
												        <img src="img/icons/fugue/pencil.png" alt="">
													</a> 

													<!--<?php
                                                    $rid=$row->id;
													$getFollow=DB::getInstance()->get('enquiry_follow_ups',array('enquiry_id','=',$rid));
                                                    $followCount=$getFollow->ount();
													if(($followCount!=0) || ($status==1))
													{
														?>

	                                                    <a href="follow-ups.php?enqid=<?php echo base64_encode($row->id);?>" class="label label-success">
													        Follow Ups
														</a> 

													  <?php
													}
													
													?>-->

												</td>
												</tr>
											    <?php
												} 
												?>		
												
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
                        </div>
                    </div>
					
                </div>
			
			</form>
</div>


<?php include('common/footer.php'); ?>
