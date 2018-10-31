<?php 
include('common/header.php');
include('common/sidebar.php');

$fullmonthNames = Array("January" => "01", "February" => "02", "March" => "03", "April" => "04", "May" => "05", "June" => "06", "July" => "07", 
"August" => "08", "September" => "09", "October" => "10", "November" => "11", "December" => "12");

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
					
									
								
							<div >
<div class="row clearfix">

		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Reports
								<a class="btn btn-xs btn-success pull-right" href="generate-invoice.php"> Generate New Slip</a>
                            </h2>
							</div>
                        <div class="body">
						<form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
										<div class="row clearfix">
										<div class="col-sm-6">
										<h2 class="header">Date Range</h2>
															
															<div class="col-sm-1" style="margin-right: 0px;">
															   <label class="radio"><input type="radio" value="1" onclick="selDateType(this.value)" name="dateRange" class='uniform' id="radio1" checked></label>
															</div>
															
															<div class="col-sm-5" style="margin-left: 0px;">
															    <select name="year" id="selYear" for="radio1" class="span12 input-square" required>
																	<option value="00">Select Year</option>
																	<?php
																		$y=date('Y');
																		for($a='2016';$a<=$y;$a++)
																		{
																		 ?>
																		 <option value="<?php echo $a; ?>" <?php if($a==$y) { echo "selected"; }?>><?php echo $a; ?></option>
																		 <?php
																		}
																	?>
																</select>
															</div>
															
															<div class="col-sm-5" >
																<select name="month" id="selMonth" class="span12 input-square" required>
																	<option value="00">Select Month</option>
																	  <?php
																		foreach($fullmonthNames as $key => $value)
																		 {
																		  ?>
																			<option value="<?php echo $value; ?>"><?php echo $key; ?></option>
																		  <?php
																		 }
																	   ?>
																</select>
															</div>
															<div  style="display:none; ">
															
																<select  class="span12 input-square"  onchange="checkForUserType(this.value)" name="user_type" id="user_type_tbl">
																    <option selected value="users">Users</option>
																 </select>
															</div>
													  
														<div class="col-sm-offset-2 col-sm-10" >
														<label for="userName" >UserName</label>
															<div class="form-group">
                                                              <div class="form-line">
															  <input type="text" id="userName" name="userName" onKeyup="getCustomer()" class="form-control" placeholder="Enter User Name" >
																	
																	<input type="hidden" id="userNameId" name="userNameId" value="0" >
																	
																	<div id="customerList" style="position:relative">
																	
																	</div>
																 </div>
															</div>
														</div>
														
														<div class="col-sm-offset-2 col-sm-10 " >
														 <label for="min" >Pending Amount (Unpaid)</label>&nbsp; &nbsp;&nbsp;<input onchange="setPending()" type="checkbox" class="" name="amt_type" id="pending" checked value="0">
															 <div class="row">
															    <div class="col-sm-6">
																    <div class="form-group">
																	
																	  <div class="form-line">
																	  <input type="text" id="min" name="min" onKeyup="getCustomer()" class="form-control" placeholder="Min" >
																			
																	   </div>
																	</div>
																</div>
																<div class="col-sm-6">
																    <div class="form-group">
																	  <div class="form-line">
																	  <input type="text" id="max" name="max" onKeyup="getCustomer()" class="form-control" placeholder="Max" >
																			
																	   </div>
																	</div>
																</div>
															 </div>
														</div>
														
														<div class="col-sm-offset-2 col-sm-10" >
														 <label for="min" >Package Expire date Range</label>&nbsp; &nbsp;&nbsp;<input type="checkbox" value="1" onclick="selExpDateType(this.value)" name="expdateRange" class='' id="radiopk_1"  >
															 <div class="row">
															    <div class="col-sm-6">
																     <select name="year" id="expselYear" for="radio1" class="span12 input-square" required>
																	<option value="00">Select Year</option>
																	<?php
																		$cy=date('Y');
																	    $y="2016";
																		for($a=1;$a<=10;$a++)
																		{
																		 
																		 ?>
																		 <option value="<?php echo $y; ?>" <?php if($cy==$y) { echo "selected"; }?>><?php echo $y; ?></option>
																		 <?php
																		 $y++;
																		}
																	?>
																</select>
																</div>
																<div class="col-sm-6">
																   <select name="month" id="expselMonth" class="span12 input-square" required>
																	  <option value="00">Select Month</option>
																	  <?php
																		foreach($fullmonthNames as $key => $value)
																		 {
																		  ?>
																			<option value="<?php echo $value; ?>"><?php echo $key; ?></option>
																		  <?php
																		 }
																	   ?>
																</select>
																	
																</div>
															 </div>
														</div>
															
														
										</div>
										<div class="col-sm-6">
										<h2 class="header">Custom Range</h2>
										
															<div class="col-sm-2">
															   <label class="radio"><input type="radio" value="2" onclick="selDateType(this.value)" name="dateRange" class='uniform' id="radio2" ></label>
															</div>
															<div class="col-sm-5">
															
																<div class="form-group">
                                    <div class="form-line">
									 <input type="date" name="datepicker" id="fromDate" disabled class='form-control datepick span12' placeholder="From">
                                      
                                    </div>
                                </div>
															</div>
															<div class="col-sm-5">
															
																<div class="form-group">
                                    <div class="form-line">
									 <input type="date" name="datepicker" id="toDate" disabled class='form-control datepick span12' placeholder="To">
                                      
									   </div>
                                </div>
															</div>
															
														
													
													<div id="SelectReport">
													 <div class="col-sm-2">
													 </div>
												   <div class="col-sm-offset-2 col-sm-10">
														 <label for="payent_type" >Mode of Payment</label>
														<div class="form-group">
													     <select class="span8 form-control" name="payent_type" id="payent_type">
															<option value="">-- Select Mode --</option>
																<option value="cash"> Cash </option>
																<option value="cheque"> Cheque</option>
																<option value="paytm"> Paytm</option>
																<option value="online"> Online</option>
																<option value="card"> Card </option>
															</select>
														</div>
													</div>
													
											<div class="col-sm-offset-2 col-sm-10">
											<label for="paid" >Paid Amount</label>&nbsp; &nbsp;&nbsp;
                                           <input onchange="setPending()" type="checkbox" checked class="" name="amt_type" id="paid" value="1">
											</div>
											<div class="col-sm-offset-2 col-sm-10" >
														 <label for="" >Package Expire Custom Range</label>&nbsp; &nbsp;&nbsp;<input type="checkbox" value="2" onclick="selExpDateType(this.value)" name="expdateRange" class='' id="radiopk_2" >
															 <div class="row">
															    <div class="col-sm-6">
																<div class="form-group">
																	<div class="form-line">
																	 <input type="date" name="datepicker" id="toDate"  class='form-control datepick span12' placeholder="To">
																	  
																	   </div>
																</div>
																</div>
																<div class="col-sm-6">
																	<div class="form-group">
																		<div class="form-line">
																		 <input type="date" name="datepicker" id="toDate"  class='form-control datepick span12' placeholder="To">
																		  
																		   </div>
																	</div>
																</div>
															 </div>
														</div>
													
												</div>
										</div>
										</div>
							                 <div class="row clearfix">
												<div class="controls">
												<a class="btn btn-green3" onclick="GetReport()">Get Report</a>
												</div>
												</div>
											
									
											
									
												
												
									
									</form>
									<div class="row clearfix" id="ReportResult">
									
									
									</div>
						</div>
						</div>
						</div>


<script>

function GetReport()
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
		data: 'mode=defaultMode&rangeType=' + dtType + '&' + urlString + '&user=' + userId +'&taxType=' + tx_type,
		cache: true,
		success: function(dat){
			
	       $("#ReportResult" ).html(dat);
		}  
		});
  
}

function getCustomer()
{
  var usrnm = $('#userName').val();
 
 if(usrnm!="")
 {
  $.ajax({
		type: "POST",
		url: "ajax-report.php",
		data: 'mode=getCustomer&vl=' + usrnm,
		cache: true,
		success: function(dat){
	       $("#customerList").html(dat);
	       $("#customerList").show();
		}  
		});
   }
   else
   {
    	$("#customerList").hide();
        $("#customerList").html('');
        $('#userName').val('');
        $('#userNameId').val('0');
   }

}
function setPending(){
   var st = $('#pending').prop('checked');
   if (st) {
       $('#max').removeAttr("disabled");
       $('#min').removeAttr("disabled");
   }else{
       $('#max').attr('disabled',true);
       $('#min').attr('disabled',true);
   }
}

function selectCus(cid,cname)
{
    $('#userName').val(cname);
    $('#userNameId').val(cid);
	
	$("#customerList").hide();
    $("#customerList").html('');
		

 
}	
function selExpDateType(dtType)
{
  switch(dtType)
	{
		case "1":
		
		   $('#expselYear').attr('disabled',false);
		   $('#expselMonth').attr('disabled',false);
		   
		   $('#expfromDate').attr('disabled',true);
		   $('#exptoDate').attr('disabled',true);
           var t=document.getElementById('radiopk_1').checked;
		   if(t==true)
		   {
		    
		     document.getElementById('radiopk_2').checked=false;
		   }
          
		break;
		
		case "2":
		
		   $('#expselYear').attr('disabled',true);
		   $('#expselMonth').attr('disabled',true);
		   
		   $('#expfromDate').attr('disabled',false);
		   $('#exptoDate').attr('disabled',false);
		   var t=document.getElementById('radiopk_2').checked;
		   if(t==true)
		   {
		     document.getElementById('radiopk_1').checked=false;
		   }

		   
		break;
	}
}
function selDateType(dtType)
{
  switch(dtType)
	{
		case "1":
		
		   $('#selYear').attr('disabled',false);
		   $('#selMonth').attr('disabled',false);
		   
		   $('#fromDate').attr('disabled',true);
		   $('#toDate').attr('disabled',true);
          
		break;
		
		case "2":
		
		   $('#selYear').attr('disabled',true);
		   $('#selMonth').attr('disabled',true);
		   
		   $('#fromDate').attr('disabled',false);
		   $('#toDate').attr('disabled',false);
		   
		break;
	}
}
</script>

<?php include('common/footer.php'); ?>
