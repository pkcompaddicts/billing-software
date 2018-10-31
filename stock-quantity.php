<?php 
include('common/header.php');
include('common/sidebar.php');

if(isset($_REQUEST['submit']))
{
$msg="";
$id=Input::get('id');
$stock=Input::get('stock_quantity');


$getBook=DB::getInstance()->query("SELECT * FROM products WHERE `id`='$id'");
$frow=$getBook->first();
$uploaded_by=$frow->uploaded_by;
$remainingstock=$frow->stock_quantity;


$bookStock=DB::getInstance()->query("SELECT * FROM product_stock_skuid WHERE `productid`='$id'");
$bookCount=$bookStock->ount();
if($bookCount==0)
{
	$lastSerialNo="0";
}
else
{
	$bookStock=DB::getInstance()->query("SELECT * FROM product_stock_skuid WHERE `productid`='$id' ORDER BY id DESC LIMIT 1");
	$stockrow=$bookStock->first();
	$skuid=$stockrow->skuid;
	$skuid_ex=explode('-',$skuid);
	$exsku=end($skuid_ex);
	$last=substr($exsku, 2);
	$lastSerialNo = $last;
}

if($stock!=0 || $stock!="")
{
	
	$find_who=DB::getInstance()->query("SELECT * from `admin` where `username`='".$_SESSION['username']."'");
    $find_who_row=$find_who->first();
	

	$date=date('Y-m-d H:i:s');
	$added_by=$find_who_row->id;

	
	for($a=1;$a<=$stock;$a++)
	{
	   $b=$lastSerialNo + $a;
       $NewSkuId=$AuthorName.$id."-00".$b;
	 
	   
	   $in=DB::getInstance()->insert('product_stock_skuid',null,null,array('productid' => $id,'skuid' => $NewSkuId,'added_on' => $date,'added_by' => $added_by));
	}
	
	$finalstock = $remainingstock + $stock;
	
	$up=DB::getInstance()->update('products','id',$id,$tmp= null,$path= null,array('stock_quantity' => $finalstock));
	
	?>
		<script>window.location='product.php'</script>
	<?php
}
else
{
	$id=Input::get('id');
	$id=base64_encode($id);
	$msg="Quantity can not be zero";	
?>
	<script>window.location='stock-quantity.php?id=<?php echo $id ?>&err=<?php echo $msg ?>'</script>
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
							<div class="card">

                        <div class="header">
                            <h2>
                               Update Stock Quantity
                            </h2>
                            
                        </div>
                        <div class="body">
	
											<form method="post" name="myForm" action="" enctype="multipart/form-data" >
										<div class="row clearfix">
							<div class="col-sm-6">
							<?php $id=base64_decode($_REQUEST['id']);?>
								<input type="hidden" name="id" value="<?php echo $id ?>">
<label for="grid12">Stock Quantity :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" min="0" name="stock_quantity" class="form-control" <?php echo $stock ?>>
                                    </div>
                                </div>	
</div>
<div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="submit" value="Update">
									
								</div>

									</form>
									</div>
								
							</div>
						
						</div>
		
	
<?php

 include('common/footer.php'); ?>