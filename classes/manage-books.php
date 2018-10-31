<?php 
include('common/header_book.php');
include('common/sidebar_book.php');
$date=date('Y-m-d');

if(isset($_REQUEST['mode']))
{
$mode=$_REQUEST['mode'];
switch($mode)
{
case "delete":
$id=base64_decode($_REQUEST['id']);
$sel=DB::getInstance()->get('books',array('id','=',$id));
$bookid=$sel->first()->book_id;

$sel=DB::getInstance()->get('book_parent',array('book_id','=',$bookid));
$file=$sel->first()->file;
unlink('../../bookstore/readbooks/'.$file);


$del=DB::getInstance()->delete('books',array('id','=',$id));
$del=DB::getInstance()->delete('book_parent',array('book_id','=',$bookid));
$del=DB::getInstance()->delete('book_bg_pattern',array('book_id','=',$bookid));
?>
<script>window.location='manage-books.php'</script>
<?php
break;
case "activateforslider":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('main_slider_status','=',1));
$count=$get->ount();
if($count < 5)
{
$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('main_slider_status' => 1));
}
else
{
$msg="5 Books are already selected for slider";
}
break;
case "deactivateforslider":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('main_slider_status','=',1));
$count=$get->ount();
if($count < 2)
{
$msg="Atleast 1 Book should be on main slider";
}
else
{
$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('main_slider_status' => 0));
}
break;

case "activateforpromotion":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('promotional_status','=',1));
$count=$get->ount();
if($count < 6)
{
$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('promotional_status' => 1));
}
else
{
$msg="6 Books are already selected for Promotional Book";
}
break;
case "deactivateforpromotion":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('promotional_status','=',1));
$count=$get->ount();
if($count < 2)
{
$msg="Atleast 1 Book should selected for Promotional Book";
}
else
{
$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('promotional_status' => 0));
}
break;

case "activateforhomeslider":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('homepage_slider_status' => 0));

break;
case "deactivateforhomeslider":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('homepage_slider_status' => 1));

break;

case "active":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('status' => 1));

$msg="Activated Successfully";

break;
case "deactive":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('status' => 0));

$msg="Deactivated Successfully";
break;



case "isbn":
$id=base64_decode($_REQUEST['id']);
$date=date('Y-m-d');
$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('isbn_issued_status' => 1,'isbncert_issued_on' => $date));

$msg="ISBN Issued Successfully";

break;


case "isbnnot":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('isbn_issued_status' => 0,'isbncert_issued_on' => '0000-00-00'));

$msg="ISBN Issued Cancelled Successfully";

break;


case "certificate":
$id=base64_decode($_REQUEST['id']);
$date=date('Y-m-d');
$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('certificate_issued_status' => 1,'certificate_issued_on' => $date));

$msg="Certificate Issued Successfully";

break;


case "certificatenot":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('certificate_issued_status' => 0,'certificate_issued_on' => '0000-00-00'));

$msg="Certificate Issued Cancelled Successfully";

break;

case "outofstock":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('out_of_stock' => 1));

$msg="Out Of Stock Updated Successfully";

break;


case "instock":
$id=base64_decode($_REQUEST['id']);

$up=DB::getInstance()->update('books','id',$id,$tmpimg= null,$path= null,array('out_of_stock' => 0));

$msg="In Stock Updated Successfully";

break;


case "activateforbestseller":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('best_seller_status','=',1));
$count=$get->ount();

$up=DB::getInstance()->query('UPDATE `books` set `best_seller_status`=? where `id`=?',array(1,$id));


$msg="Successfully Updated for best seller";

break;
case "deactivateforbestseller":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('best_seller_status','=',1));
$count=$get->ount();

$up=DB::getInstance()->query('UPDATE `books` set `best_seller_status`=? where `id`=?',array(0,$id));

$msg="Successfully Removed from best seller";
break;

case "activateforrecentsold":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('recent_sold_status','=',1));
$count=$get->ount();

$up=DB::getInstance()->query('UPDATE `books` set `recent_sold_status`=? where `id`=?',array(1,$id));


$msg="Successfully Updated for recent sold";

break;
case "deactivateforrecentsold":
$id=base64_decode($_REQUEST['id']);
$get=DB::getInstance()->get('books',array('recent_sold_status','=',1));
$count=$get->ount();

$up=DB::getInstance()->query('UPDATE `books` set `recent_sold_status`=? where `id`=?',array(0,$id));

$msg="Successfully Removed from recent sold";
break;

}
}
if(isset($_REQUEST['deleteselected']))
{
$id=implode(',',$_REQUEST['ch']);
$fg=explode(',',$id);
$cnt=count($fg);
for($a=0;$a<$cnt;$a++)
{
$id=$fg[$a];
$sel=DB::getInstance()->get('books',array('id','=',$id));
$bookid=$sel->first()->book_id;

$sel=DB::getInstance()->get('book_parent',array('book_id','=',$bookid));
$file=$sel->first()->file;
unlink('../../bookstore/readbooks/'.$file);


$del=DB::getInstance()->delete('books',array('id','=',$id));
$del=DB::getInstance()->delete('book_parent',array('book_id','=',$bookid));
$del=DB::getInstance()->delete('book_bg_pattern',array('book_id','=',$bookid));
}
?>
<script>window.location='manage-books.php'</script>
<?php
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
							<h3>Books Steps</h3>
							
						</div>
						<div class="box-content box-nomargin">
						<div class="box-content">
						<?php
						if($msg!="")
						{
						?>
						<div class="alert alert-block alert-success">
								<a class="close" data-dismiss="alert" href="#">Close</a>
  								<h4 class="alert-heading">Congo!</h4>
  								<?php echo $msg;?>
							</div>
							<?php
							}
							?>
							
					
									
								
							<div >
							<form action="" method="POST">
							<input type="submit" class="btn btn-primary" name="deleteselected" onclick="return confirm('YOU ARE GOING TO DELETE SELECTED ITEMS')"  value="Delete Selected Abstract">
									<div  style="overflow-x:scroll">
										<table class='table table-striped dataTable table-bordered'>
											<thead>
												<tr>
												<th style="padding-left:4px;padding-right:4px">Sl NO.</th>
												<th style="padding-left:4px;padding-right:4px"><input type="checkbox" onclick="checkAll(this)"></th>
											    <th style="padding-left:4px;padding-right:4px"><b>Title</b></th>
 <th style="padding-left:4px;padding-right:4px">
<b>Author</b></th>
		
												<th style="padding-left:4px;padding-right:4px"><b>Uploaded On</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Stock Quantity</b></th>
											
												<th style="padding-left:4px;padding-right:4px"><b>Out Of Stock Status</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Action</b></th>
												<th style="padding-left:4px;padding-right:4px"><b>Other Actions</b></th>
												</tr>
											</thead>
											<tbody>
								<?php 
								$del=DB::getInstance()->query("select * from books ORDER by id DESC");
											$sl=0;
											foreach($del->results() as $rt)
											{
											$sl++;
										    $uid=$rt->uid;
											$aid=$rt->abstract_id;
											$bid=$rt->book_id;
											 $gid=$rt->genre;
											 
											 
											$abs=DB::getInstance()->get('abstract',array('id','=',$aid));
											$row=$abs->first();
											
											$bk=DB::getInstance()->get('book_parent',array('book_id','=',$bid));
											$con=$bk->first();
											
											
											$del=DB::getInstance()->get('accounts',array('id','=',$uid));
											$uploadedby=$del->first()->name;
											
											
											
											
											
											$delg=DB::getInstance()->get('categories',array('id','=',$gid));
											$cat=$delg->first()->child_cat;
											?>
												<tr>
												<td style="padding-left:4px;padding-right:4px" ><?php echo $sl; ?></td>
												<td style="padding-left:4px;padding-right:4px" ><input type="checkbox" value="<?php echo $rt->id ;?>" name="ch[]"> </td>
										        <td style="padding-left:4px;padding-right:4px"><?php echo $rt->title;?> </td>
			 <td style="padding-left:4px;padding-right:4px"><?php echo $rt->author;?> </td>									
													

<td style="padding-left:4px;padding-right:4px"><?php echo date('F j,Y',strtotime($rt->uploaded_on)); ?></td>
<td style="padding-left:4px;padding-right:4px"><?php echo $rt->stock_quantity;?> </td>
	
<td style="padding-left:4px;padding-right:4px">


<?php
$out_of_stock=$rt->out_of_stock;
switch($out_of_stock)
{
case "0":
?>
<a href="manage-books.php?id=<?php echo base64_encode($rt->id);?>&mode=outofstock" onclick="return confirm('You are going to mark it as out of stock?')"  class="label label-important" >
In Stock</a> 
<?php
break;
case "1":
?>
<a href="manage-books.php?id=<?php echo base64_encode($rt->id);?>&mode=instock" onclick="return confirm('You are going to marked it as in stock?')"  class="label label-success" >
Out Of Stock</a> 
<?php
break;
}
?>



</td>



<td style="padding-left:4px;padding-right:4px">
						
											
<a href="manage-books.php?id=<?php echo base64_encode($rt->id);?>&mode=delete" onclick="return confirm('YOU ARE GOING TO DELETE THIS BOOK')">
<img src="img/icons/fugue/cross.png" alt=""></a> 


<?php
$book_status=$rt->status;
switch($book_status)
{
case "0":
?>
<a href="manage-books.php?id=<?php echo base64_encode($rt->id);?>&mode=active" onclick="return confirm('Are You sure you want to activate this?')"  class="label label-important" >
Deactive</a> 
<?php
break;
case "1":
?>
<a href="manage-books.php?id=<?php echo base64_encode($rt->id);?>&mode=deactive" onclick="return confirm('Are You sure you want to deactivate this?')"  class="label label-success" >
Active</a> 
<?php
break;
}
?>



</td>



<td style="padding-left:4px;padding-right:4px">
						
	<select style="width: 130px;" onchange="up(this.value,'<?php echo base64_encode($rt->id);?>','<?php echo base64_encode($rt->book_id);?>')" >

<option value="" >Select Action</option>
<option value="view-ongoing-books-steps">View Details</option>
<option value="edit-details">Edit Details</option>
<option value="set-price-ongoing-books">Set Price on Channel Partners</option>
<option value="add-royality">Add Royality</option>
<option value="edit-meta-tag">Edit Meta-tags</option>
<option value="expenses">Expenses</option>
<option value="stock-quantity">Stock Quantity</option>
<?php
if($con->upload_type==1)
{
?>
<option value="edit-chapter">Edit Chapters</option>
<?php
}
?>


</select>

</td>

												</tr>
													<?php } ?>		
												
											</tbody>
										</table>
										
										
									</div>
								</form>
							</div>
						
						</div>
					</div>
				</div>
			</div>
			
			
			<script>
			function up(val,id, bid)
			{
			var url=val + '.php';
			if(val=='edit-chapter')
			{
			var id= bid;
			}
			
			window.location=url + '?id='+id;
			}
			</script>
			
			
		</div>	
	</div>
</div>	
<?php include('common/footer.php'); ?>