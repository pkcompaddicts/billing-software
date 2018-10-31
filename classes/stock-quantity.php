<?php 
session_start();
include('common/header_book.php');
include('common/sidebar_book.php');
if(isset($_REQUEST['submit']))
{
	$msg="";
$id=Input::get('id');
$stock=Input::get('stock_quantity');


$date=date('Y-m-d');
		  $up=DB::getInstance()->update('books','id',$id,$tmp= null,$path= null,array('stock_quantity' => $stock));
		 if($stock==0 || $stock=="")
			{
			$msg="Quantity can not be zero";
			}
		if((!isset($msg)) || ($msg==""))
		{
		?>
		<script>window.location='manage-books.php'</script>
		<?php
		}
		else
		{
		$id=Input::get('id');
		$id=base64_encode($id);
		
		
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
<link rel="stylesheet" href="css/uniform.default.css">


	<div class="content">
	
	
	
	<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<div class="box-head tabs">
							<h3>Update Stock Quantity</h3>
							
						</div>
						<div class="box-content box-nomargin">
						<div class="box-content">
						<?php
						if(isset($_REQUEST['err']))
						{
						?>
						<div class="alert alert-block alert-danger">
								<a class="close" data-dismiss="alert" href="#">Close</a>
  								<h4 class="alert-heading"></h4>
  								<?php echo $_REQUEST['err'];?>
							</div>
							<?php
							
							}
							?>
							
					
									
								
							
										<form method="post" name="myForm" action="" enctype="multipart/form-data" >
										
										<input type="hidden" name="id" value="<?php echo $id ?>">
							
				
									<div class="control-group">
										<label for="grid12" class="control-label">Stock Quantity</label>
										<div class="controls">
										<input type="number" min="0" name="stock_quantity" id="grid12" value="<?php echo $stock ?>" class="span8 input-square">
										
											
										</div>
									</div>
									
										
										
									
									
									
									
									<div class="control-group">
									<div class="controls">
									<input type="submit" class="btn btn-primary" name="submit" value="Update">
									<a href="manage-books.php"><input type="button" class='btn btn-primary'  value="Cancel"></a>
									</div>
									</div>
									
									
									</form>
									</div>
								
							</div>
						
						</div>
					</div>
				</div>
			</div>	
		
	
<?php

 include('common/footer.php'); ?>