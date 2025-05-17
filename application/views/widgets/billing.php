<div class="container-fluid">
<?php
	$joiningdate = new DateTime($_SESSION['joiningdate']);
	$nowdate = new DateTime(date("Y-m-d H:i:s"));
	$datediff = $joiningdate->diff($nowdate)->m + ($joiningdate->diff($nowdate)->y*12); // int(8)
	$months = 0;


	if($_SESSION['reference'] < 5 )
	{
		if(!($datediff < 6) &&  $_SESSION['authuser'] == FALSE)
		 $auth = FALSE;
		else  $auth = TRUE;
		$months = 6;

	}
	else if($_SESSION['reference'] >=5 && $_SESSION['reference'] < 10)
	{
		if(!($datediff < 12) &&  $_SESSION['authuser'] == FALSE) $auth = FALSE;
		else  $auth =TRUE;
		$months = 12;
	}
	else if($_SESSION['reference'] >= 10 && $_SESSION['reference'] < 25)
	{
		if(!($datediff < 18) &&  $_SESSION['authuser'] == FALSE) $auth = FALSE;
		else  $auth =TRUE;
		$months = 18;
	}
	else if($_SESSION['reference'] >= 25)
	{
		if(!($datediff < 24) &&  $_SESSION['authuser'] == FALSE) $auth = FALSE;
		else  $auth =TRUE;
		$months = 24;
	}
	else
	{
		$auth = $_SESSION['authuser'];
		$months = 0;
	}



	if($auth == FALSE)
	{
		echo "<p class='row alert alert-danger marginbottom0'><b>Warning!</b> Your account is not authenticated, users cannot view your profile. Please, add payment details to continue using </p>";
	}


		$joiningdate->modify('+' . $months.' months');
?>

	<div class="row">
		<div class="col-xs-12 margin2per">Your trial expires on <?php print_r($joiningdate->format('d F Y')); ?>. Please add payment details to ensure continued service.</div>
		<div class="col-sm-3"></div>
		<div class="col-sm-6 col-xs-12">
			<button class="btn btn-success btn-lg fullwidth" id="addsubscription" data-id="<?php echo $_SESSION['id']; ?>" data-expires="<?php echo $joiningdate->format('U');  ?>" data-email= "<?php echo $_SESSION['email']; ?>" data-name ="<?php echo $_SESSION['name']; ?>">Subscribe through RazorPay!</button>
		</div>
		<div class="col-sm-3"></div>
		<div class="error col-xs-12 margin2per smalltext">*A fee of Rs 5 is charged to carry on authentication, which will be refunded.</div>
		<div class="col-xs-12 impinfo">Please make sure that all the people referred by you, register before the trial expires, otherwise you will be charged normally. The trial period can only be availed in continuation. Sign out and back in to see the changes.</div>

	</div>




</div>
