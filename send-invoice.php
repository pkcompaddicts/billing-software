<?php 

session_start();

require_once('common/config.php'); 

include('pdfClass/mpdf.php');



$userLoggedIn=$_SESSION['username'];
$del=$dbh->prepare("SELECT * FROM `admin` where `username`='$userLoggedIn'");
$del->execute();
$row=$del->fetch();
$branch_id=$row['branch_id'];

$brachData=$dbh->prepare("SELECT * FROM `branches` where `id`='$branch_id'");
$brachData->execute();
$brachData_Row=$brachData->fetch();
$CompanyName=$brachData_Row['name'];
$logo=$brachData_Row['logo'];
$website=$brachData_Row['website'];
$invoice_paper_size=$brachData_Row['invoice_paper_size'];
$invoice_heading_font_size=$brachData_Row['invoice_heading_font_size'];
$invoice_font_size=$brachData_Row['invoice_font_size'];
$cgst_rate=$brachData_Row['cgst_rate'];
$sgst_rate=$brachData_Row['sgst_rate'];
$igst_rate=$brachData_Row['igst_rate'];
$logo="logo/".$logo;

$mpdf=new mPDF('utf-8', $invoice_paper_size); 


$mpdf->SetDisplayMode('fullpage');

$mpdf->SetWatermarkText($CompanyName);
$mpdf->SetWatermarkImage($logo, 0.10, 'F');
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->showWatermarkText = true;
$mpdf->showWatermarkImage = false;




$mpdf->defaultheaderfontsize = 10;	/* in pts */
$mpdf->defaultheaderfontstyle = B;	/* blank, B, I, or BI */
$mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

$mpdf->defaultfooterfontsize = 10;	/* in pts */
$mpdf->defaultfooterfontstyle = B;	/* blank, B, I, or BI */
$mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */
 
if($website!="")
{
	$mpdf->SetHeader($CompanyName.' || '.$website);
}
else
{
	$mpdf->SetHeader($CompanyName.' || {PAGENO}');
}


$mpdf->SetFooter($CompanyName.' | |{PAGENO}');	/* defines footer for Odd and Even Pages - placed at Outer margin */
$file=$logo;

$slip=base64_decode($_REQUEST['slip']); 

$del=$dbh->prepare("SELECT * FROM `offline_store_invoice` where `id`='$slip'");
$del->execute();
$row=$del->fetch();

$from_name=$row['from_name'];
$from_address=$row['from_address'];
$from_email=$row['from_email'];
$from_contact=$row['from_contact'];
$from_address=$row['from_address'];
$from_gst_number=$row['from_gst_number'];


$payment_status=$row['payment_status'];
$invoice_number=$row['invoice_no'];
$total_qty=$row['total_qty'];


switch($payment_status)
{
  case "0":
    $paymentstatus='<img src="img/unpaid-stamp.png" style="width:80px">';
  break;
  
  case "1":
      $paymentstatus='<img src="img/paid-stamp.png" style="width:80px">';
  break;
}	

	  
 $html ="";
 $html .= '<bookmark content="Start of the Document" />
 
  <div style="width:100%;">
    <p style="text-align:center;margin-top:-20px;width:100%"><h1 style="text-align:right;width:58%;float:left;font-size:'.$invoice_heading_font_size.'">Invoice </h1> <h1 style="width:40%;text-align:right">'.$paymentstatus.'</h1></p>
   
 <div style="width:100%;border-bottom:2px solid #000;padding-bottom:10px">
 
 <div style="width:50%;float:left;font-size:'.$invoice_font_size.'"><img src="'.$logo.'" style="width:150px"><br/>'.$from_name.'</div>
 
 
  
 <div style="width:50%;float:right;text-align:right;font-size:'.$invoice_font_size.'">

 <label><span>'.$from_address.'</span></label><br/>

  <label>GST No.: '.$from_gst_number.' </label>
 </div>
 
 </div>
 
 <div style="width:100%;">
 <div style="width:100%;border-bottom:2px solid #000;padding-bottom:10px;padding-top:10px;font-size:'.$invoice_font_size.'">
 
 <div style="width:50%;float:left;"> <b style="font-family:ind_hi_1_001;">'.$row['to_name'].' </b><br/>
  <label style="font-family:ind_hi_1_001;"> '.$row['to_address'].' , '.$row['to_state'].'</label><br/>
 <label style="font-family:ind_hi_1_001;">'.$row['to_email'].'</label><br/>
 <label style="font-family:ind_hi_1_001;">'.$row['to_contact'].'</label>';
 
 if($row['to_gst_number']!="")
 {
  $html.='<br/><label style="font-family:ind_hi_1_001;"><b>GST Number : </b>'.$row['to_gst_number'].'</label>';
 }
 
 $html.='</div>
 
 <div style="width:50%;float:right;text-align:right">
  <div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span>Invoice Number  : </span>  </div><div style="width:50%;float:right;text-align:left"> '.$invoice_number.' </div></div>
  <div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span>Total Quantity  : </span>  </div><div style="width:50%;float:right;text-align:left"> '.$total_qty.' </div></div>
 ';
 
$del=$dbh->prepare("SELECT * FROM `offline_store_invoice` where `id`='$slip'");
$del->execute();
$row=$del->fetch();
$taxable=$row['taxable'];
$tamt=$row['taxrate_amount'];
$added_by=$row['added_by'];
$discount_type=$row['discount_type'];

switch($taxable)
{
	
	case "0":
	
	     $final_amount=$row['final_amount'];
	     $html.='<div style="width:100%;text-align:right"><div style="width:40%;float:left;font-size:'.$invoice_font_size.'"> <span>Final Amount  : </span>  </div><div style="width:50%;float:right;text-align:left"> Rs. '.$final_amount.' </div></div>';
		 
	break;
	
	
	case "1":
	
	     $to_state=$row['to_state'];
	     $inclusive_exclusive=$row['inclusive_exclusive'];
	     $total_amount=$row['total_amount'];
	     $final_amount=$row['final_amount'];
		 
		 switch($inclusive_exclusive)
		 {
			 case "0":
			   $incexc="Exclusive";
			 break;
			 
			 case "1":
			  $incexc="Inclusive";
			 break;
		 }
		 
		 if($to_state=="Uttar Pradesh")
		 {
			 $TaxRateDiv='<div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span> CGST Rate  : </span>  </div><div style="width:50%;float:right;text-align:left">'.$cgst_rate.'% </div></div>
			 <div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span> SGST Rate  : </span>  </div><div style="width:50%;float:right;text-align:left">'.$sgst_rate.'% </div></div>
			 <div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span> GST Rate  : </span>  </div><div style="width:50%;float:right;text-align:left">'.$row['tax_rate'].'% (Rs. '.$tamt.') </div></div>';
			 
		 }
		 else if($to_state=="")
		 {
			 $TaxRateDiv='<div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span> GST Rate  : </span>  </div><div style="width:50%;float:right;text-align:left">'.$row['tax_rate'].'% (Rs. '.$tamt.') </div></div>';
		 }
		 else
		 {
			 $TaxRateDiv='<div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span> IGST Rate  : </span>  </div><div style="width:50%;float:right;text-align:left">'.$row['tax_rate'].'% (Rs. '.$tamt.') </div></div>';
		 }
		 
	     $html.='<div style="width:100%;text-align:right;font-size:'.$invoice_font_size.'"><div style="width:40%;float:left"> <span>Total Amount  : </span>  </div><div style="width:50%;float:right;text-align:left"> Rs. '.$total_amount.' </div></div>'.$TaxRateDiv.'
		  <div style="width:100%;text-align:right"><div style="width:40%;float:left"> <span>Final Value  : </span>  </div><div style="width:50%;float:right;text-align:left"> Rs. '.$final_amount.' </div></div>
		  ';
		 
	break;
}

												

												
 $html.=' <div style="width:100%;text-align:right;font-size:'.$invoice_font_size.'"><div style="width:40%;float:left"> <span>Invoice Date   : </span>  </div><div style="width:50%;float:right;text-align:left">'.date('F j,Y',strtotime($row['invoice_date'])).' </div></div>
 </div>
 
 </div>
 

</pagebreak>
 <div style="clear:both"></div>
 <div style="width:100%;margin-top:50px">
				<table style="border-top: 1px solid #e5e5e5;border: 1px solid #ddd;width: 100%;margin-bottom: 20px;background-color: transparent;border-spacing: 0;max-width: 100%;font-size:'.$invoice_font_size.'">
				 <thead style="border-color: inherit;">
				   <tr style="color: #707070;font-weight: normal;background: #FFF;display: table-row;vertical-align: inherit;border-color: inherit;">
					<th style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">#</th>
					<th style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Book Title</th>
					<th class="hidden-phone" style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Unit price</th>
					<th class="hidden-480" style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Quanity</th>';
					
if($discount_type!=0)
{
                  $html.='<th style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Discount</th>';
}	
					
					$html.='<th style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Total price</th>
				   </tr>
				  </thead>
				  <tbody style="border-color: inherit;font-size:22px !important;">';
				  
				  $slip=base64_decode($_REQUEST['slip']); 
				  $a=1;
				  $itemList=$dbh->prepare("SELECT * FROM `offline_store_product_details` WHERE `basic_tbl_id`='$slip'");
				  $itemList->execute();
				  foreach($itemList->fetchAll() as $rt)
				  {
					 
					$html.='<tr>
					 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;">'.$a.'</td>
					 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;">'.$rt['product_name'].'</td>
					  <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;">Rs. '.$rt['unit_price'].'</td>
					  <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;">'.$rt['quantity'].'</td>';
if($discount_type!=0)
{
        $disAmt=$rt['discount_amount'];
        
		if(($disAmt!="0") || ($disAmt!="0.00") || ($disAmt!=""))
		{
			$discount_in=$rt['discount_in'];
			
			switch($discount_in)
			{
				case "1":
				  $disAmount=$disAmt."%";
				break;
				
				case "2":
				  $disAmount="Rs.".$disAmt;
				break;
			}

		}
		else
		{
			$disAmount="No Discount";
		}
		
		$html.=' <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;">'.$disAmount.'</td>';
}

					 $html.='<td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;">'.$rt['final_amount'].'</td>
					 </tr>';
					  $a++;
				  }
		   $html.='<tbody>
			    </table>
		        </div>';

$slip=base64_decode($_REQUEST['slip']); 
$pac=$dbh->prepare("SELECT * FROM `offline_store_installment` where `basic_tbl_id`='$slip'");
$pac->execute();

	  $pac_count=$pac->rowCount();
if($pac_count!=0)
{	  
				$html.='<div style="clear:both"></div>
 <div style="width:100%;margin-top:16px">
 <p style="text-align:center;"><h2 style="text-align:center;font-size:'.$invoice_heading_font_size.'">Payment Installment Details</h2></p>
  	<table class="table table-striped table-bordered" style="border-top: 1px solid #e5e5e5;border: 1px solid #ddd;border-collapse: separate;width: 100%;margin-bottom: 20px;background-color: transparent;border-spacing: 0;max-width: 100%;font-size:'.$invoice_font_size.'">
	 <thead style="display: table-header-group;vertical-align: middle;border-color: inherit;border-collapse: separate;">
	   <tr style="color: #707070;font-weight: normal;background: #FFF;display: table-row;vertical-align: inherit;border-color: inherit;">
		<th style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Sl. No.</th>
		<th class="hidden-phone" style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Paid On</th>
		<th class="hidden-480" style="border-left: 1px solid #ddd;padding:4px;text-align: left;font-weight: bold;">Amount</th>
	   </tr>
	  </thead>
      <tbody style="display: table-row-group;vertical-align: middle;border-color: inherit;">';
	  $slip=base64_decode($_REQUEST['slip']); 
	  $pac=$dbh->prepare("SELECT * FROM `offline_store_installment` where `basic_tbl_id`='$slip' ORDER By id ASC");
	  $pac->execute();
	  $pac_count=$pac->rowCount();
	  foreach($pac->fetchAll() as $ro)
	  {
	  $amt=$ro['current_installment_amount'];
	  $amt=round($amt,2);
	  
	  $paid_on=$ro['paid_on'];
	  $paid_on=date('F j,Y',strtotime($paid_on));
	  
	     $html.='<tr>
		 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;">'.$a.'</td>
		 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;">'.$paid_on.'</td>
		 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;">Rs. '.$amt.'</td>
		 </tr>';
		 $a++;
	  }
	  
	   $pact=$dbh->prepare("SELECT SUM(current_installment_amount) as totalamt FROM `offline_store_installment` where `basic_tbl_id`='$slip' ORDER By id ASC");
	  $pact->execute();
	  $rpt=$pact->fetch();
	  $total_paid=$rpt['totalamt'];
	  $total_paid=round($total_paid,2);
	   $html.='<tr>
		 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;"></td>
		 <td style="border-left: 1px solid #ddd;padding:4px;vertical-align: top;border-top: 1px solid #ddd;font-weight:bold;text-align:right">Total Amount Paid</td>
		 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;">Rs. '.$total_paid.'</td>
		 </tr>';
		 
		 $pact=$dbh->prepare("SELECT * FROM `offline_store_invoice` where `id`='$slip'");
	    $pact->execute();
	    $rpt=$pact->fetch();
	    $remaining_amount=$rpt['remaining_amount'];
	    $payment_status=$rpt['payment_status'];
	     $remaining_amount=round($remaining_amount,2);
		 if($payment_status==1)
		 {
		   $remaining_amount='Nil';
		 }
		 else
		 {
		   $remaining_amount="Rs. ".$remaining_amount;
		 }
	   $html.='<tr>
		 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;font-family:ind_hi_1_001;"></td>
		 <td style="border-left: 1px solid #ddd;padding:4px;vertical-align: top;border-top: 1px solid #ddd;font-weight:bold;text-align:right">Remaining Amount</td>
		 <td style="border-left: 1px solid #ddd;padding:4px;text-align: left;vertical-align: top;border-top: 1px solid #ddd;">'.$remaining_amount.'</td>
		 </tr>';
		
	  $html.='</tbody>
	  </table>
	  </div>';
  }		
				
$sign_name=$dbh->prepare("SELECT * FROM `admin` where `id`='$added_by'");
$sign_name->execute();
$sign_name_row=$sign_name->fetch();
$branch_id=$sign_name_row['branch_id'];
$signature=$sign_name_row['signatory_name'];

$branch_name=$dbh->prepare("SELECT * FROM `branches` where `id`='$branch_id'");
$branch_name->execute();
$branch_name_row=$branch_name->fetch();
$CompanyName=$branch_name_row['name'];


$slip=base64_decode($_REQUEST['slip']); 
$del=$dbh->prepare("SELECT * FROM `offline_store_invoice` where `id`='$slip'");
$del->execute();
$row=$del->fetch();
$notes=$row['note'];
if($notes!="")
{
				$html.='<div style="width:100%;border-top:1px solid #000;padding-top:10px;padding-bottom:10px;font-size:'.$invoice_font_size.'">
 <b> Note: </b> '.$notes.'
  </div>';
  }
  
				 $html.='
  

			
<div style="width:100%;border-top:1px solid #000;padding-top:10px;padding-bottom:10px;font-size:'.$invoice_font_size.'">

   <div style="width:100%;float:right;text-align:right">
  <h4>'.$CompanyName.'</h4>
   <div style="height:25px"> '.$signature.'</div>
  <p><b>Authorised Signatory</b></p>
  </div>
  </div>

				</div>
		 </bookmark>';		 	  	   

						 

//echo $html;

//$mpdf=new mPDF();

$mpdf->WriteHTML($html);


$slip=base64_decode($_REQUEST['slip']); 


$userLoggedIn=$_SESSION['username'];
$del=$dbh->prepare("SELECT * FROM `admin` where `username`='$userLoggedIn'");
$del->execute();
$row=$del->fetch();
$branch_id=$row['branch_id'];

$brachData=$dbh->prepare("SELECT * FROM `branches` where `id`='$branch_id'");
$brachData->execute();
$brachData_Row=$brachData->fetch();
$CompanyName=$brachData_Row['name'];


$del=$dbh->prepare("SELECT * FROM `offline_store_invoice` where `id`='$slip'");
$del->execute();
$row=$del->fetch();
$total_qty=$row['total_qty'];
$final_amount=$row['final_amount'];
$payment_status=$row['payment_status'];
$email=$row['to_email'];
$authorname=$row['to_name'];
$invoice_number=$row['invoice_no'];

switch($payment_status)
{
  case "0":
    $paymentstatus='Unpaid';
  break;
  
  case "1":
      $paymentstatus='Paid';
  break;
}	


$host = $_SERVER['HTTP_HOST'];
preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
$domainName="{$matches[0]}";

$replymail="no-reply@".$domainName;

require_once('PHPMailer/class.phpmailer.php');

$mail  = new PHPMailer(); // defaults to using php "mail()"
$body = '<table rules="all" style="border:1px solid; border-color: #666;" cellpadding="10"><tr style="background: #ccc; border: 1px solid black; padding-top: 10px; padding-bottom:10px;"><th style="">Total Quantity</th><th>Final Amount</th><th>Status</th></tr>';
$body .= '<tr><td>'.$total_qty.'</td><td>Rs. '.$final_amount.'</td>';
$body .= '<td>'.$paymentstatus.'</td></tr>'; 
$body .= '</table>';
$body .= '<br></br>';
$body .= 'Please Find Attached Invoice Here';
$mail->AddReplyTo($replymail,$CompanyName);

$mail->SetFrom($replymail, $CompanyName);

$mail->AddReplyTo($replymail,$CompanyName);

$address = $email;
$mail->AddAddress($address, $authorname);

$mail->Subject    = 'Invoice  From ' .$CompanyName.' , Invoice NO - ' .$invoice_number.' - '.$status;

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);
 $emailAttachment = $mpdf->Output('Invoice-'.$invoice_number.'.pdf', 'S');
 $mail->AddStringAttachment($emailAttachment, 'Invoice-'.$invoice_number.'.pdf', 'base64', 'application/pdf');

if(!$mail->Send()) {
  $_SESSION["msg"] =  "Mailer Error: " . $mail->ErrorInfo;
  
} else {
  
  $_SESSION["msg"] = "Message sent!";
  
}
?>

<script>window.location='invoices.php'</script>


                            