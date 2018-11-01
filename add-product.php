<?php 
include('common/header.php');
include('common/sidebar.php');


if(isset($_REQUEST['submit']))
{
$date=date('Y-m-d H:i:s');

$catId=Input::get('catId');
$proName=Input::get('proName');
$setMrp=Input::get('setMrp');

$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$find_who_row=$find_who->first();
$upby=$find_who_row->id;

if((!empty($catId)) || ($catId!="") || (!empty($proName)) || ($proName!="") || (!empty($setMrp)) || ($setMrp!=""))
{
	$in=DB::getInstance()->insert('products',$tmp= null,$path= null,array('category_id' => $catId,'title' => $proName,'set_mrp' => $setMrp,'uploaded_by' => $upby, 'uploaded_on' => $date,'status' => 1));
	
	$LastId=DB::getInstance()->lastinsert();
	
	$cyear=date('Y');
	
	$productId="pro".$cyear."/00".$LastId;
	
	$up=DB::getInstance()->updatewithoutimage('products','id',$LastId,array('product_id' => $productId));
	
	$_SESSION['msg']="Product Added Successfully";
  ?>
<script>window.location='product.php'</script>
<?php
}
else
{
  $_SESSION['err']="All fields are required";
}
}





if(isset($_REQUEST['update']))
{
$date=date('Y-m-d H:i:s');
$id=Input::get('id');


$catId=Input::get('catId');
$proName=Input::get('proName');
$setMrp=Input::get('setMrp');

$find_who=DB::getInstance()->get('admin',array('username','=',$_SESSION['username']));
$find_who_row=$find_who->first();
$upby=$find_who_row->id;


if((!empty($catId)) || ($catId!="") || (!empty($proName)) || ($proName!="") || (!empty($setMrp)) || ($setMrp!=""))
{
$up=DB::getInstance()->updatewithoutimage('products','id',$id,array('category_id' => $catId,'title' => $proName,'set_mrp' => $setMrp, 'updated_by' => $upby,'updated_on' => $date,'status' => 1));
$_SESSION['msg']="Updated Successfully";
?>
<script>window.location='product.php'</script>
<?php
}
else
{
	$_SESSION['err']="All fields are required";
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
							</div><?php
							
							} ?>
							
			<?php
						if(isset($_SESSION['err']))
						{ ?>
						    <div class="alert alert-block alert-error text-error">
								<a class="close" data-dismiss="alert" href="#">X</a>
  								<?php echo $_SESSION['err'];?>
							</div><?php
							
							} ?>
							
							</div>
							 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">					
			
			<?php
	if(isset($_REQUEST['mode']))
	{
	$mode=$_REQUEST['mode'];
	switch($mode)
	{
	case "edit":
	$id=base64_decode($_REQUEST['id']);
	$del=DB::getInstance()->get('products',array('id','=',$id));
	$categoryId=$del->first()->category_id;
	
	?>
	<div class="card">
                        <div class="header">
                            <h2>
                               Update Product
                            </h2>
                            
                        </div>
                        <div class="body">
				<form method="post" action="" enctype="multipart/form-data">
				
	<div class="row clearfix">
<input type="hidden" name="id" value="<?php echo $id ?>">
						
								<div class="col-sm-6">
<label for="grid12">Category</label>
                                <div class="form-group">
                                    <div class="form-line">
									<select name="catId" class="form-control" required>
										   <option>Select Category</option>
										   <?php
										   $category=DB::getInstance()->getmultiple('categories',array('status' => 1));
										   foreach($category->results() as $rt)
										   {
											   $catId=$rt->id;
											   ?>
											   <option value="<?php echo $rt->id; ?>" <?php if($categoryId==$catId) { echo "selected"; } ?>><?php echo $rt->title; ?></option>
											   <?php
										   }
										   ?>
										</select>
                                        
                                    </div>
                                </div>	
</div>
<div class="col-sm-6">
<?php
									  $id=base64_decode($_REQUEST['id']);
	                                  $del=DB::getInstance()->get('products',array('id','=',$id));
									?>
<label for="productname">Product Name :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="productname"   name="proName" class="form-control"  value="<?php echo $del->first()->title; ?>">
                                    </div>
                                </div>	
</div>	
<div class="col-sm-6">
<?php
									  $id=base64_decode($_REQUEST['id']);
	                                  $del=DB::getInstance()->get('products',array('id','=',$id));
									?>
<label for="productprice">Product Price :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="productprice"   name="setMrp" class="form-control"  value="<?php echo $del->first()->set_mrp; ?>">
                                    </div>
                                </div>	
</div>								<div class="col-sm-6 align-right">
									<input type="submit" class="btn btn-green3 btn-success" name="update" value="Update">	
									</div>
									

									</form>
									
								
							</div>
						
						</div></div>

<?php
break;

}
		}
else
{

?>

<div class="card">

                        <div class="header">
                            <h2>
                               Add Product
                            </h2>
                            
                        </div>
                        <div class="body">
	
										<form method="post" action="" enctype="multipart/form-data">
										<div class="row clearfix">
							<div class="col-sm-6">
<label for="grid12">Enter Sub Category :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        
										<select name="catId" class="form-control" required>
										   <option>Select Category</option>
										   <?php
										   $category=DB::getInstance()->getmultiple('categories',array('status' => 1));
										   foreach($category->results() as $rt)
										   {
											   $catId=$rt->id;
											   ?>
											   <option value="<?php echo $rt->id; ?>"><?php echo $rt->title; ?></option>
											   <?php
										   }
										   ?>
										</select>
                                    </div>
                                </div>	
</div>
<div class="col-sm-6">
<label for="productname">Product Name :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="productname"  name="proName" class="form-control" placeholder="Enter Product Name" >
                                    </div>
                                </div>	
</div>
<div class="col-sm-6">
<label for="productprice">Product Price :</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="productprice"  name="setMrp" class="form-control" placeholder="Enter Product Price" >
                                    </div>
                                </div>	
</div>
<div class="col-sm-12">
									<input type="submit" class="btn btn-green3 btn-success" name="submit" value="Submit">
									
								</div>

									</form>
									</div>
								
							</div>
						
						</div>

<?php

}	?>

<?php include('common/footer.php'); ?>
