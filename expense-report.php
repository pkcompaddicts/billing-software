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
									
<div >
<div class="row clearfix">

		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                           <h2>
                               Expense Reports
								<!-- <a class="btn btn-xs btn-success pull-right" href="generate-invoice.php"> Generate New Slip</a>
                            </h2>-->
							</div>
                        <div class="body">
						<form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
										<div class="row clearfix">
										<div class="col-sm-6">
										<h2 class="header">Date Range</h2>
															
															<div class="col-sm-1" style="margin-right: 0px;">
															   <label class="radio">
															   <input type="radio" value="1" onclick="selDateType(this.value)" name="dateRange" class='uniform' id="radio1" checked></label>
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
															<div class="col-sm-10" >
															<label for="expense_type" >Expense Type</label>
																<select class="span12 input-square form-control" name="expense_type" id="expense_type">
																    <option value="0">Select Type</option>
																    <option value="1">Debit</option>
																    <option value="2">Credit</option>
																</select>
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
												   <div class="col-sm-10">
															<label for="userName" >Mode of Payment</label>
															<div class="form-group">
                                                            <select class="span8 form-control" name="payment_type" id="payment_type">
															    <option value="">-- Select Mode --</option>
																<option value="1"> Cash </option>
																<option value="2"> Cheque</option>
																<option value="3"> Other</option>
															</select>
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
    var dtType =  $("input[name='dateRange']:checked").val();
    var expdtType =  $("input[name='expdateRange']:checked").val();

    var mode   =  $('#payment_type').val();
    var etyp   =  $('#expense_type').val();
    /*var package = $('#package').val();*/
     //alert(mode+'---'+expdtType+'----'+mode+'---'+etyp); 
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
	
	//alert(expselfDate+'---'+expseltDate+'--'+expurlString); 

	 $("#ReportResult" ).html('<p style="text-align:center"><img src="img/throbber.gif"></p>');
	 
	$.ajax({
		type: "POST",
		url: "ajax-report.php",
		data: 'mode=expenseReport&rangeType=' + dtType + '&' + urlString + '&exprangeType=' + expdtType + '&' + expurlString + '&pMode=' + mode + '&expense_type=' + etyp,
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


function selectCus(cid,cname)
{
    $('#userName').val(cname);
    $('#userNameId').val(cid);
	
	$("#customerList").hide();
    $("#customerList").html('');
		

 
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
