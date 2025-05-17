<?php

	define('DS', DIRECTORY_SEPARATOR);
	define('ROOT', dirname(dirname(__FILE__)));


		if(isset($_GET['url'])) $url = $_GET['url'];

	require_once(ROOT . DS . 'library' . DS . 'bootstrap.php');


//purposely not included the closing ? > This is to avoid injection of any extra whitespaces in our output.
