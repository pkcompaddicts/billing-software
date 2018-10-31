<?php
require_once('core/init.php'); 

session_start(); 

$whereadded_by='';
$nowhereadded_by="";
$whereuploaded_by="";
$nowhereuploaded_by="";
$nodisplay=""; 
if($_SESSION['login_type']!='4')
{
    $username=$_SESSION['record_user'];  
    $getuser=DB::getInstance()->query("select id from admin where username='$username'")->first();
    $userid=$getuser->id; 
    $whereadded_by="Where added_by='$userid' ";
    $nowhereadded_by="and added_by='$userid'"; 
    $whereuploaded_by="Where uploaded_by='$userid' ";
    $nowhereuploaded_by="and uploaded_by='$userid'";
    $nodisplay="display:none";
}


$mode= $_REQUEST['mode']; 

switch($mode)
{
case "defaultMode":


     $rangeType = $_REQUEST['rangeType'];
	
	switch($rangeType)
	{
		case "1":
			$year = $_REQUEST['year'];
	        $month = $_REQUEST['month'];
			
			if((!empty($year)) && ($year!="00"))
			{
			   $qry1="AND year(invoice_date)='$year'";
			}
			else 
			{
				$qry1="";
			}

			if((!empty($month)) && ($month!="00"))
			{
			   $qry2="AND month(invoice_date)='$month'";
			}
			else 
			{
				$qry2="";
			}
	
		break;
		
		case "2":
		
		    $from_date = $_REQUEST['from_date'];
	        $to_date = $_REQUEST['to_date'];
			
			if((!empty($from_date)) && ($from_date!="") && (!empty($to_date)) && ($to_date!=""))
			{
			   $qry1="AND (`invoice_date` BETWEEN '$from_date' AND '$to_date')";
			}
			else if((!empty($from_date)) && ($from_date!="") && (empty($to_date)) && ($to_date==""))
			{
				$qry1="AND (`invoice_date`='$from_date' OR `invoice_date` > '$from_date')";
			}
			else if((empty($from_date)) && ($from_date=="") && (!empty($to_date)) && ($to_date!=""))
			{
				$qry1="AND (`invoice_date`='$to_date' OR `invoice_date` < '$to_date')";
			}
			else 
			{
				$qry1="";
			}
			
			$qry2="";
			
		break;
	}

	$userId = $_REQUEST['user'];
	$taxType = $_REQUEST['taxType'];
	
	

	if(($userId!="0"))
	{
	   
	     $qry3="AND distributor_id='$userId'";

	}
    else 
    {
    	$qry3="";
    }
	
	if(($taxType!=""))
	{
	   $ex_tx=explode(',',$taxType);
	   $countEx=count($ex_tx);
	   
	   if($countEx>1)
	   {
	      $qry4="AND (taxable='1' OR taxable='0')";
	   }
	   else
	   {
	     $txType=$ex_tx[0];
	     $qry4="AND taxable='$txType'";
	   }
      
	}
    else 
    {
    	$qry4="";
    }


	$del=DB::getInstance()->query("SELECT * FROM `offline_store_invoice` WHERE invoice_date!='' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by");
    $count=$del->ount();
	if($count!=0) 
	{
	   $reportQuery="SELECT * FROM `offline_store_invoice` WHERE invoice_date!='' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by";
	   $_SESSION['reportQuery']=$reportQuery;
	 ?>
	
	 	<div class="btn-group dropdown pull-left" style="margin-bottom:14px">
						  		<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#" style="background: #333;">
						    		Download Report
						    		<span class="caret"></span>
						  		</a>
						  		<ul class="dropdown-menu custom">
						  			<li>
						  				<a href="report-pdf.php" target="_blank">PDF</a>
						  				<a href="report-excel.php" target="_blank">Excel</a>
						  			</li>
						  		</ul>
	   </div>
							
		<table class='table table-striped table-bordered'>
											<thead>
												<tr>
												<th style="padding-left:4px;padding-right:4px">Sl NO.</th>
											    <th style="padding-left:4px;padding-right:4px"><b>Invoice No</b></th>
                                                <th style="padding-left:4px;padding-right:4px"><b>Customer</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Total Quantity</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Final Amount</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Invoice Date</b></th>
												<th style="padding-left:4px;padding-right:4px"><b></b></th>
											
												</tr>
											</thead>
											<tbody>
								<?php 
								
								 $per_page = 10;  
								            $del=DB::getInstance()->query("SELECT * FROM `offline_store_invoice` WHERE invoice_date!='' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by ");
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

											
								$del=DB::getInstance()->query("SELECT * FROM `offline_store_invoice` WHERE invoice_date!='' $qry1 $qry2 $qry3 $qry4  $nowhereadded_by ORDER by id DESC LIMIT $start,$per_page");
											$sl=0;
											foreach($del->results() as $rt)
											{
											$sl++;
										      $paymentStatus=$rt->payment_status;
											  switch($paymentStatus)
											  {
												  case "0":
												    $status='<a class="label label-important">Unpaid</a>';
												  break;
												  
												  case "1":
												   $status='<a class="label label-success">Paid</a>';
												  break;
											  }
											?>
											
											<tr>
												<td style="padding-left:4px;padding-right:4px" ><?php echo $sl; ?></td>
										        <td style="padding-left:4px;padding-right:4px"><?php echo $rt->invoice_no;?> </td>
			                                    <td style="padding-left:4px;padding-right:4px"><?php echo $rt->to_name;?> </td>									
												<td style="padding-left:4px;padding-right:4px"><?php echo $rt->total_qty;?> </td>
												<td style="padding-left:4px;padding-right:4px">Rs. <?php echo $rt->final_amount;?> </td>
                                                <td style="padding-left:4px;padding-right:4px"><?php echo date('F j,Y',strtotime($rt->invoice_date)); ?></td>
                                                <td style="padding-left:4px;padding-right:4px"><?php echo $status;?> </td>
                                            </tr>
											<?php
											 } 
											 ?>		
												
											</tbody>
										</table>
										<?php
										  // $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
										  $page="0";
										   $reload='onclick="getPagination('.$tpages.','.$page.')"';
									
											echo '<div class="pagination"><ul>';
											if ($total_pages > 1) {
												echo DB::getInstance()->paginateAjax($reload, $show_page, $total_pages);
											}
											echo "</ul></div>";

?>
<script>

function getPagination(tp,pg)
{
    var userId=$('#userNameId').val();
    var dtType = $("input[name='dateRange']:checked").val();
    
	switch(dtType)
	{
		case "1":
		
		   var selY=$('#selYear').val();
           var selM=$('#selMonth').val();
		   
		   var urlString ='year=' + selY + '&month=' + selM;
		   
		break;
		
		case "2":
		
		   var selfDate=$('#fromDate').val();
           var seltDate=$('#toDate').val();
		   
		   var urlString ='from_date=' + selfDate + '&to_date=' + seltDate;
		   
		break;
	}

	
	var txtype = [];
			
    $.each($("input[name='inv_type']:checked"), function(){            
       txtype.push($(this).val());
    });
			
    var tx_type=txtype.join(","); //************ Party Name Ends *****************//
    
	if(tx_type=="")
	{
	 var tx_type="1,0";
	  
	}

	 $("#ReportResult" ).html('<p style="text-align:center"><img src="img/throbber.gif"></p>');
	 
	$.ajax({
		type: "POST",
		url: "ajax-report.php",
		data: 'mode=defaultMode&tpages='+ tp +'&page=' + pg + '&rangeType=' + dtType + '&' + urlString + '&user=' + userId +'&taxType=' + tx_type,
		cache: true,
		success: function(dat){
			
	       $("#ReportResult" ).html(dat);
		}  
		});
  
}
</script>


<?php											
	
	}
	else
	{
	  ?>
	   <h3 style="text-align:center">No Record Found</h3>
	  <?php
	}


    break; 

case "getCustomer":
  die("getconsumer"); 
$goal=$_REQUEST['vl'];
$tbl=$_REQUEST['tbl'];
$val=strtolower($goal);

$del=DB::getInstance()->query("SELECT id,name FROM $tbl where (lower(email) LIKE '%$val%') OR (lower(name) LIKE '%$val%') OR (lower(contact) LIKE '%$val%')");
$count=$del->ount();
if($count!=0)
{
	?>
	<style>

#search-result
{
	background: #333;
    position: absolute;
    width: 70%;
    color: #fff;
	left:27%;
}
#search-result:before
{
    content: '';
    display: block;
    width: 0;
    height: 0;
    border-color: rgba(204,204,204,0);
    border-left: 7.5px solid transparent;
    border-right: 7.5px solid transparent;
    border-bottom: 7px solid #333;
    margin-top: -7px;
    margin-left: 50%;
}

</style>

<div id="search-result">
	<?php
foreach($del->results() as $row)
{
	$id=$row->id;
	$name=$row->name;

	?>
	  <p style="cursor:pointer; margin-top: 7px;padding:0px 9px" onclick="selectCus('<?php echo $id; ?>','<?php echo $name; ?>')"><?php echo $name; ?></p>
	<?php
}
?>
</div>
<?php
}
else
{
	?>
	  <p>User Not Found</p>
	<?php
}

break;


case "expenseReport":
  
  $rangeType = $_REQUEST['rangeType'];
  $pMode = $_REQUEST['pMode'];
  $expense_type = $_REQUEST['expense_type'];
  
  switch($rangeType)
	{
		case "1":
			$year = $_REQUEST['year'];
	        $month = $_REQUEST['month'];
			
			if((!empty($year)) && ($year!="00"))
			{
			   $qry1="AND year(payment_date)='$year'";
			}
			else 
			{
				$qry1="";
			}

			if((!empty($month)) && ($month!="00"))
			{
			   $qry2="AND month(payment_date)='$month'";
			}
			else 
			{
				$qry2="";
			}
	
		break;
		
		case "2":
		
		    $from_date = $_REQUEST['from_date'];
	        $to_date = $_REQUEST['to_date'];
			
			if((!empty($from_date)) && ($from_date!="") && (!empty($to_date)) && ($to_date!=""))
			{
			   $qry1="AND (`payment_date` BETWEEN '$from_date' AND '$to_date')";
			}
			else if((!empty($from_date)) && ($from_date!="") && (empty($to_date)) && ($to_date==""))
			{
				$qry1="AND (`payment_date`='$from_date' OR `invoice_date` > '$from_date')";
			}
			else if((empty($from_date)) && ($from_date=="") && (!empty($to_date)) && ($to_date!=""))
			{
				$qry1="AND (`payment_date`='$to_date' OR `invoice_date` < '$to_date')";
			}
			else 
			{
				$qry1="";
			}
			
			$qry2="";
			
		break;
	}
	
	if($pMode!='')
	{
	  $qry3=" AND payment_mode='$pMode'";
	}
	else
	{
	 $qry3="";
	}
	
	if($expense_type!=0)
	{
	  $qry4=" AND entry_type='$expense_type'";
	}
	else
	{
	 $qry4="";
	}
	
	$del=DB::getInstance()->query("SELECT * FROM `expense_income` WHERE id!='0' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by ");
    $count=$del->ount();
	if($count!=0)
	{
	   $reportQuery="SELECT * FROM `expense_income` WHERE id!='0' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by ";
	   $conditionreportQuery="SELECT * FROM `expense_income` WHERE id!='0' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by ";
	   $_SESSION['reportQuery']=$reportQuery;
	   
	   ?>
   <form action="" method="POST">

													
					
						<br/>
	 	<div class="btn-group dropdown pull-left" style="margin-bottom:14px">
						  		<a class="btn btn-inverse dropdown-toggle" data-toggle="dropdown" href="#" style="background: #333;">
						    		Download Report
						    		<span class="caret"></span>
						  		</a>
						  		<ul class="dropdown-menu custom">
						  			<li>
						  				<a href="expense-report-pdf.php" target="_blank">PDF</a>
						  				<a href="expense-report-excel.php" target="_blank">Excel</a>
						  			</li>
						  		</ul>
	   </div>
	   
	   <?php
	   
	   $delTot=DB::getInstance()->query("SELECT SUM(amount) as tot_amount FROM `expense_income` WHERE id!='0' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by ");
      $totAmt=$delTot->first()->tot_amount;
	
    
  
	   ?>
	   	<div class="pull-right" style="margin-bottom:14px">
		    <b>Total Amount : </b> Rs. <?php echo $totAmt; ?> 
	   </div>
					
		<table class='table table-striped table-bordered'>
											<thead>
												<tr>
												<th>#</th>
												<th>Type</th>
												<th>Branch</th>
												<th>Category</th>
												<th>Given By</th>
												<th>Received By</th>
												<th>Amount</th>
												<th>Paid On</th>
												<th>Payment</th>
												<th>Remarks</th>
											
												</tr>
											</thead>
											<tbody>
								<?php 
								
								 $per_page = 10;  
								            $del=DB::getInstance()->query("SELECT * FROM `expense_income` WHERE id!='0' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by ");
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

										
								$del=DB::getInstance()->query("SELECT * FROM `expense_income` WHERE id!='0' $qry1 $qry2 $qry3 $qry4 $nowhereadded_by ORDER by id DESC LIMIT $start,$per_page");
											$sl=0;
											foreach($del->results() as $row)
											{
											  $sl++;
										     $branchId=$row->branch_id;
											   $entry_type=$row->entry_type;
											  
											   $branch_name=DB::getInstance()->query("SELECT * FROM `branches` where `id`='$branchId'");
											   $branch_name_row=$branch_name->first();
											   $BranchName=$branch_name_row->name;
											   $BranchAddress=$branch_name_row->address;
											   
										       $catid=$row->category_id;
											   $cate=DB::getInstance()->getmultiple('expense_category',array('id' => $catid));
											   
											   switch($entry_type)
											   {
												   case "1":
												     $entryType="Debit";
												   break;
												   
												   case "2":
												    $entryType="Credit";
												   break;
											   }
											?>
												<tr>
												<td><?php echo $sl;?></td>
										        <td><?php echo $entryType;?></td>
										        <td><?php echo $BranchName;?> , <?php echo $BranchAddress;?> </td>
										        <td><?php echo $cate->first()->title;?></td>
										        <td>
												  <b>Name : </b> <?php echo $row->given_by_name;?>
												  <?php
												  if($row->given_by_email!="")
												  {
													  ?>
												   <br/><b>Email : </b> <?php echo $row->given_by_email;?>
													  <?php
												  }
												   if($row->given_by_contact!="")
												  {
													  ?>
												   <br/><b>Contact : </b> <?php echo $row->given_by_contact;?>
													  <?php
												  }
												  ?>
												</td>
												<td>
												  <b>Name : </b> <?php echo $row->received_by_name;?>
												  <?php
												  if($row->received_by_email!="")
												  {
													  ?>
												   <br/><b>Email : </b> <?php echo $row->received_by_email;?>
													  <?php
												  }
												   if($row->received_by_contact!="")
												  {
													  ?>
												   <br/><b>Contact : </b> <?php echo $row->received_by_contact;?>
													  <?php
												  }
												  ?>
												</td>
										        <td>Rs. <?php echo $row->amount;?></td>
												<td><?php echo date('F j,Y',strtotime($row->payment_date)); ?></td>
												<td>
												<?php
												$payment_mode=$row->payment_mode;
												
												switch($payment_mode)
												{
													case "1":  //**** Cash
													
													    ?>
														 <b>Payment Mode : </b> Cash
														<?php
														
													break;
													
													case "2":  //**** Cheque
													
													    ?>
														 <b>Payment Mode : </b> Cheque<br/>
														 <b>Cheque No. : </b> <?php echo $row->cheque_reference_no; ?><br/>
														 <b>Cheque Date : </b> <?php echo date('F j,Y',strtotime($row->cheque_date)); ?><br/>
														 <b>Bank Name : </b> <?php echo $row->bank_name; ?><br/>
														 <b>Bank Branch : </b> <?php echo $row->bank_branch; ?>
														<?php
														
													break;
													
													case "3":  //**** Others
													   ?>
														 <b>Payment Mode : </b> Others<br/>
														 <b>Reference No. : </b> <?php echo $row->cheque_reference_no; ?>
														<?php
													break;
												}
												?>
												</td>
											    <td><?php 
												  if($row->remarks!="")
												  {
													echo $row->remarks;  
												  }
												  else
												  {
													  echo "----";
												  }	
												  ?>
												</td>
											
												</tr>
											<?php
											 } 
											 ?>		
												
											</tbody>
										</table>
										
										</form>
										<?php
										  // $reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages;
										  $page="0";
										   $reload='onclick="getPagination('.$tpages.','.$page.')"';
									
											echo '<div class="pagination"><ul>';
											if ($total_pages > 1) {
												echo DB::getInstance()->paginateAjax($reload, $show_page, $total_pages);
											}
											echo "</ul></div>";

?>
<script>

function getPagination(tp,pg)
{
      var dtType =  $("input[name='dateRange']:checked").val();
    var expdtType =  $("input[name='expdateRange']:checked").val();

    var mode   =  $('#payment_type').val();
    var etyp   =  $('#expense_type').val();
    /*var package = $('#package').val();*/

	switch(dtType)
	{
		case "1":
		
		   var selY=$('#selYear').val();
           var selM=$('#selMonth').val();
		   
		   var urlString ='year=' + selY + '&month=' + selM;
		   
		break;
		
		case "2":
		
		   var selfDate=$('#fromDate').val();
           var seltDate=$('#toDate').val();
		   
		   var urlString ='from_date=' + selfDate + '&to_date=' + seltDate;
		   
		break;
	}
	
	switch(expdtType)
	{
		case "1":
		
		   var expselY=$('#expselYear').val();
           var expselM=$('#expselMonth').val();
		   
		   var expurlString ='expyear=' + expselY + '&expmonth=' + expselM;
		   
		break;
		
		case "2":
		
		   var expselfDate=$('#expfromDate').val();
           var expseltDate=$('#exptoDate').val();
		   
		   var expurlString ='expfrom_date=' + expselfDate + '&expto_date=' + expseltDate;
		   
		break;
	}

	 $("#ReportResult" ).html('<p style="text-align:center"><img src="img/throbber.gif"></p>');
	 
	$.ajax({
		type: "POST",
		url: "ajax-report.php",
		data: 'mode=expenseReport&tpages='+ tp +'&rangeType=' + dtType + '&' + urlString + '&exprangeType=' + expdtType + '&' + expurlString + '&pMode=' + mode + '&expense_type=' + etyp,
		cache: true,
		success: function(dat){
			alert(dat); 
	       $("#ReportResult" ).html(dat);
		}  
		});
  
}
</script>

<?php
	
	}
	else
	{
	  ?>
	   <h3 style="text-align:center">No Record Found</h3>
	  <?php
	}
	
break;

 }

 ?>