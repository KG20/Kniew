<div class="container">

<?php 
	loggedinRedirect(); 
	
?>


	<form action="" method="post" class="form col-sm-6" id="recoverform">

	 <div class="form-group">			                
	      <label>Please enter your email address </label> 
	      <div class="input-group">
	          <div class="input-group-addon">
	            <span class="fa fa-envelope"></span> 
	          </div>
	          <input required type="email" name="email"  class="form-control" placeholder="janedoe@website.com"/>
	      </div>			                
	  </div>

	  <div class="form-group">			                
	         <input required type="submit" name="submit" value="Recover Password" class="form-control btn btn-success" />
	  </div>

	  <?php 
	  if(isset($_GET['success']) === true && empty($_GET['success']) === true)
		echo '<p class="alert alert-success">Thanks, please check your email for details.</p>';
		if(isset($_GET['error']) === true && empty($_GET['error']) === true)
		echo "<p class='alert alert-danger'>Error! Please make sure you have entered the correct email or please try again. </p>";
	?>


	</form>

</div>

