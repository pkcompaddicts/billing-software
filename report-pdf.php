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
$logo="logo/".$logo;

$mpdf=new mPDF('utf-8', 'A4-L'); 


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

 $html ="";
 $html.=' <bookmark content="Start of the Document" />
               
			   <div style="width:100%;border-bottom:2px solid #000;padding-bottom:10px">
 
                  <div style="width:50%;float:left;font-size:'.$invoice_font_size.'"><img src="'.$logo.'" style="width:150px"><br/>'.$CompanyName.'</div>
 
               </div>';
			   
			   	$query=$_SESSION['reportQuery'];
            	$fr=$dbh->prepare("$query");
                $fr->execute();			
	            $Count=$fr->rowCount();
			   
			   if($Count!=0)
			   {
			       
			   $html.=' <table border="1" style="width:100%;border-spacing: 2px;border-color: grey;border: 1px solid #dddddd;border-collapse: separate;background-color: transparent;border-spacing: 0;display: table;">
			   	<thead style="display: table-header-group;vertical-align: middle;border-color: inherit;">
					<tr style="display: table-row; vertical-align: inherit;border-color: inherit;">
					
					<th style="font-weight:bold !important;text-shadow:0 0px 0 !important;background:#333 !important;color: #fff !important; border-color: #000 !important;padding: 4px;box-shadow: inset 0 0 0 1px #ffffff;text-align: center;vertical-align: bottom;">Sl NO.</th>
					<th style="padding: 4px;font-weight:bold !important;text-shadow:0 0px 0 !important;background:#333 !important;color: #fff !important; border-color: #000 !important;box-shadow: inset 0 0 0 1px #ffffff;text-align: center;    vertical-align: bottom;">Invoice No</th>
                    <th style="padding: 4px;font-weight:bold !important;text-shadow:0 0px 0 !important;background:#333 !important;color: #fff !important; border-color: #000 !important;box-shadow: inset 0 0 0 1px #ffffff;text-align: center;    vertical-align: bottom;">Customer</th>
					<th style="padding: 4px;font-weight:bold !important;text-shadow:0 0px 0 !important;background:#333 !important;color: #fff !important; border-color: #000 !important;box-shadow: inset 0 0 0 1px #ffffff;text-align: center;    vertical-align: bottom;">Total Quantity</th>
					<th style="padding: 4px;font-weight:bold !important;text-shadow:0 0px 0 !important;background:#333 !important;color: #fff !important; border-color: #000 !important;box-shadow: inset 0 0 0 1px #ffffff;text-align: center;    vertical-align: bottom;">Final Amount</th>
					<th style="padding: 4px;font-weight:bold !important;text-shadow:0 0px 0 !important;background:#333 !important;color: #fff !important; border-color: #000 !important;box-shadow: inset 0 0 0 1px #ffffff;text-align: center;    vertical-align: bottom;">Invoice Date</th>
					<th style="padding: 4px;font-weight:bold !important;text-shadow:0 0px 0 !important;background:#333 !important;color: #fff !important; border-color: #000 !important;box-shadow: inset 0 0 0 1px #ffffff;text-align: center;    vertical-align: bottom;"></th>
											
					</tr>
				</thead>
				<tbody style="display: table-row-group;vertical-align: middle;border-color: inherit;">';
				
				$query=$_SESSION['reportQuery'];
				$fr=$dbh->prepare("$query");
				$fr->execute();			
				foreach($fr->fetchAll() as $rt)
				{
				$sl++;
										      $paymentStatus=$rt['payment_status'];
											  switch($paymentStatus)
											  {
												  case "0":
												    $status='<div  style="color: #b94a48;font-weight:bold">Unpaid</div>';
												  break;
												  
												  case "1":
												   $status='<div style="color: #468847;font-weight:bold">Paid</div>';
												  break;
											  }
				 $html.=' <tr style="border-bottom:2px solid #333">
												<td style="padding: 8px;" align="center" >'.$sl.'</td>
										        <td style="padding: 8px;" align="center">'.$rt['invoice_no'].'</td>
			                                    <td style="padding: 8px;" align="center">'.$rt['to_name'].'</td>									
												<td style="padding: 8px;" align="center">'.$rt['total_qty'].'</td>
												<td style="padding: 8px;" align="center">Rs. '.$rt['final_amount'].'</td>
                                                <td style="padding: 8px;" align="center">'.date('F j,Y',strtotime($rt['invoice_date'])).'</td>
                                                <td style="padding: 8px;" align="center">'.$status.'</td>
                                            </tr>';
				}
					
				
 $html.=' </tbody>
			   
			   
			   </table>';
			   
			   }
			   else
			   {
			     $html.=' <p style="text-align:center">No Record Found</p>';
				
			   }
			  
 $html.=' </bookmark>';		   
						 
//echo $html;
//$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output();

?>
                            