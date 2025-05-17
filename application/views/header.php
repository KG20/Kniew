<?php
include("head.php");
?>

<?php include('navigation.php');
if(loggedin() == false){
   include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'loginmodal.php';
 }

 if(loggedin() && isProfessional())
 {
   if($_SESSION['isauthentic'] === FALSE)
 	{
 		echo "<div class='container-fluid'><p class='row alert alert-danger marginbottom0'><b>Warning!</b> Your account is refuted and is unauthorized, users will not be able to contact you or view your full profile. Correct any incorrect details by going to your account settings. </p></div>";
 	}

//
// 	$joiningdate = new DateTime($_SESSION['joiningdate']);
// 	$nowdate = new DateTime(date("Y-m-d H:i:s"));
// 	$datediff = $joiningdate->diff($nowdate)->m + ($joiningdate->diff($nowdate)->y*12); // int(8)
//
// 	if($_SESSION['reference'] < 5 )
// 	{
// 		if(!($datediff < 6) &&  $_SESSION['authuser'] == FALSE) $auth = FALSE;
// 		else  $auth = TRUE;
// 	}
// 	else if($_SESSION['reference'] >=5 && $_SESSION['reference'] < 10)
// 	{
// 		if(!($datediff < 12) &&  $_SESSION['authuser'] == FALSE) $auth = FALSE;
// 		else  $auth =TRUE;
// 	}
// 	else if($_SESSION['reference'] >= 10 && $_SESSION['reference'] < 25)
// 	{
// 		if(!($datediff < 18) &&  $_SESSION['authuser'] == FALSE) $auth = FALSE;
// 		else  $auth =TRUE;
// 	}
// 	else if($_SESSION['reference'] >= 25)
// 	{
// 		if(!($datediff < 24) &&  $_SESSION['authuser'] == FALSE) $auth = FALSE;
// 		else  $auth =TRUE;
// 	}
// 	else $auth = $_SESSION['authuser'];
//
//

	// if($auth == FALSE)
	// {
	// 	echo "<div class='container-fluid'><p class='row alert alert-danger marginbottom0'><b>Warning!</b> Your account is not authenticated, users cannot view your profile. Please, add payment details to continue using </p></div>";
	// }
}

 ?>
