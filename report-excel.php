<?php
include('core/init.php');
$d=date('Y-m-d');
$t=time();
$fname="invoice-".$d."-".$t.".xls";
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="'.$fname.'"');
echo "
    <html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\">
    <html>
        <head><meta http-equiv=\"Content-type\" content=\"text/html;charset=utf-8\" /></head>
        <body>
";

echo "
    <table border='1'>
      <tr>
	  <th nowrap=\"nowrap\">Sl NO.</th>
        <th nowrap=\"nowrap\">Invoice No.</th>
        <th nowrap=\"nowrap\">Customer</th>

        <th nowrap=\"nowrap\">Total Quantity</th>
		<th nowrap=\"nowrap\">Final Amount</th>
      <th nowrap=\"nowrap\">Invoice Date</th>
      <th nowrap=\"nowrap\"></th>
																			
      </tr>";
	 $query=$_SESSION['reportQuery'];
	 $del=DB::getInstance()->query($query);
	 $sl=0;
	foreach($del->results() as $rt)
	{
		$sl++;
		$paymentStatus=$rt->payment_status;
		switch($paymentStatus)
		{
			case "0":
				$status='<div  style="color: #b94a48;font-weight:bold">Unpaid</div>';
			break;
												  
			case "1":
				$status='<div style="color: #468847;font-weight:bold">Paid</div>';
			break;
		}
		
	  echo "
  
      <tr>
        <td>".$sl."</td>
        <td>".$rt->invoice_no."</td>
        <td>".$rt->to_name."</td>
        <td>".$rt->total_qty."</td>
        <td>Rs. ".$rt->final_amount."</td>
        <td>".date('F j,Y',strtotime($rt->invoice_date))."</td>
        <td>".$status."</td>
      </tr>";
	  }
	  echo "
    </table>
";

echo "</body></html>";

?>