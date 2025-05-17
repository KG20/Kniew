<?php


class LogoutController
{

	function __construct()
	{
		session_start();

		if (isset($_SESSION['gpid']))
		{
			unset($_SESSION['access_token']);
			session_destroy();
		    header('Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
		}

		session_destroy();
		#CHANGEDNOV19 : logic for &
		if(!isset($_GET['prevurl']) && strpos($_GET['url'], '&prevurl'))
		{
			$isamp = explode('&prevurl=', $_GET['url']);
			$_GET['prevurl'] = $isamp[1];
		}
		else  header('Location:' . BASE_PATH);
		
		if($_GET['prevurl'] && $_GET['prevurl'] != 'logout') header('Location:' . BASE_PATH . $_GET['prevurl']);
		else  header('Location:' . BASE_PATH);
	}
	function index(){}
}


?>
