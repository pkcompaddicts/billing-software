</div>
			</section>
	
<script>


function sessionMessage()
{
	  $.ajax({
		  type: "POST",
		  url: "ajax.php",
		  data: 'mode=SessionDestroy',
		  cache: true,
		  success: function(){
		  }  
		  });
}

setTimeout(
  function() 
  {
	sessionMessage();
  }, 1000);

</script>

   <?php include('common/js.php')?>
</body>
</html>