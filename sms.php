<?php 
include('common/header.php');
include('common/sidebar.php');


?>

 <style>
  .pagination li{
	list-style-type: none;
    display: inline;
	padding:10px; 
    margin-left: 5px;
	
  }
  .pagination li a{
	  text-decoration:none; 
  }
 </style>
<?php
$date=date('Y-m-d');

if(isset($_REQUEST['mode']))
{
  $mode=$_REQUEST['mode'];
  
  switch($mode)
  {
    case "delete":
	  
	  $id=base64_decode($_REQUEST['id']);
	  $del=DB::getInstance()->delete('messages',array('id','=',$id));
	  
	  ?>
	    <script>window.location='sms.php?msg=SMS Deleted Successfully'</script>
     <?php
	 
	break;
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
							 <div class="card">
                        <div class="header">
                            <h2 class="col-lg-6">
                              SMS
                            </h2>
                          <div class="col-lg-6 align-right">  <a class="btn btn-green3 btn-info" href="send-sms.php">Send Sms</a></div>
                        </div>
                        <div class="body">
							 <form action="" method="POST">
							<!--<input type="submit" class="btn btn-primary" name="deleteselected" onclick="return confirm('YOU ARE GOING TO DELETE SELECTED ITEMS')"  value="Delete Selected Abstract">-->
									<div  style="/*overflow-x:scroll*/">
										<table class='table table-striped table-bordered'>
											<thead>
												<tr>
												<th >Sl NO.</th>
												<!--<th ><input type="checkbox" onclick="checkAll(this)"></th>-->
											    <th ><b>Name</b></th>
												<th ><b>Contact number</b></th>
												<th ><b>Message</b></th>
												<th ><b>Send On</b></th>
												<?php
												  
											$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
											$find_who_row=$find_who->first();	
											$login_type=$find_who_row->login_type;
											if($login_type==4)
											{
	
												  ?>
												<th ><b></b></th>
												<?php
											}
											?>
											
												</tr>
											</thead>
											<tbody>
								<?php 
										
										 $per_page = 10;  
								            $del=DB::getInstance()->query("select * from messages $whereadded_by  ORDER by id DESC");
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

											
								$del=DB::getInstance()->query("select * from messages $whereadded_by  ORDER by id DESC LIMIT $start,$per_page");
											$sl=0;
											foreach($del->results() as $rt)
											{
											$sl++;
											$uid=$rt->user_id;
										   
											if($uid==0)
											{
											  $name="---";
											}
											else
											{
											   $find_user=DB::getInstance()->get('users',array('id','=',$uid));
											  $rtu=$find_user->first();
											  $name=$rtu->name;
											
											}
											?>
												<tr>
												<td><?php echo $sl; ?></td>
										        <td ><?php echo $name;?> </td>
			                                    <td ><?php echo $rt->number;?> </td>									
                                                <td ><?php echo $rt->sms;?> </td>
											    <td ><?php echo date('F j,Y g:i a',strtotime($rt->added_on)); ?></td>
												<?php
												  
													$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
													$find_who_row=$find_who->first();	
													$login_type=$find_who_row->login_type;
													if($login_type==4)
													{
												  ?>
												<td>
                                                   <a href="sms.php?id=<?php echo base64_encode($rt->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS CATEGORY')">
												           <i class="material-icons">delete</i> 
													</a> 
												</td>
													<?php }?>
												
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
										
										
									</div>
								</form>
							 
							 </div>
							  </div>
							   </div>

			
			
			
			
		</div>	
	</div>
</div>	
<?php include('common/footer.php'); ?>