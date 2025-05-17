
<div class="notice container-fluid">
<?php if(loggedin() == false) { ?>

<div class="col-sm-5">
<svg  >
				  <use xlink:href="#secure_page"></use>
				</svg>
</div>
<div class="col-sm-7">
	<p>Please log in/register to access this page. </p>

<ul >
	<li class="row"><a class="signup btn btn-info registerpop col-sm-5"  role="button" tabindex="0" href=" "> <b> Sign up </b> </a></li>
	<li class="row"><a class="signin btn btn-default loginpop col-sm-5" role="button" tabindex="0" href=" "> <b>Sign in</b> </a></li>
</ul>
</div>
<?php }
	else{
		#CHANGEDNOV19 : logic for &
		if(!isset($_GET['prevurl']) && strpos($_GET['url'], '&prevurl'))
		{
			$isamp = explode('&prevurl=', $_GET['url']);
			$_GET['prevurl'] = $isamp[1];
		}
		if(isset($_GET['prevurl'])) header('Location: ' . BASE_PATH . $_GET['prevurl']);
		else header('Location: ' . BASE_PATH);
	}
?>

</div>
