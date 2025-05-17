<?php
// 	use MatthiasMullie\Minify; ////this takes more time only use it to make combined minify
// 	// require_once './images/icons/combine.svg';
// 	$css1 = ROOT . DS . 'public' . DS . 'css' . DS . 'bootstrap-datetimepicker.css';
// 	$css2 = ROOT . DS . 'public' . DS . 'css' . DS . 'jquery-comments.css';
// 	$css3 = ROOT . DS . 'public' . DS . 'css' . DS . 'fullcalendar.css';
// 	$css4 = ROOT . DS . 'public' . DS . 'css' . DS . 'jquery-ui.min.css';
// 	$css5 = ROOT . DS . 'public' . DS . 'css' . DS . 'jRating.jquery.css';
// 	$css6 = ROOT . DS . 'public' . DS . 'css' . DS . 'jquery.steps.css';
// 	$cssN = ROOT . DS . 'public' . DS . 'css' . DS . 'general.css';

// 	$minifierCss = new Minify\CSS($css1, $css2, $css3, $css4, $css5, $css6, $cssN);
// 	$mc_result = $minifierCss->minify(ROOT . DS . 'public' . DS . 'css' . DS . 'combined.min.css');
// 	// file_put_contents(ROOT . DS . 'public' . DS . 'css' .'combined.min.css', $mc_result);

// 	$js1 = ROOT . DS . 'public' . DS . 'js' . DS . 'jquery.validate.min.js';
// 	$js2 = ROOT . DS . 'public' . DS . 'js' . DS . 'jquery.lazyload-any.js';
// 	$js3 = ROOT . DS . 'public' . DS . 'js' . DS . 'jquery.steps.js';
// 	$js4 = ROOT . DS . 'public' . DS . 'js' . DS . 'jquery.cropit.js';
// 	$js5 = ROOT . DS . 'public' . DS . 'js' . DS . 'moment.min.js';
// 	$js6 = ROOT . DS . 'public' . DS . 'js' . DS . 'bootstrap-datetimepicker.js';
// 	$js7 = ROOT . DS . 'public' . DS . 'js' . DS . 'jquery-comments.min.js';
// 	$js8 = ROOT . DS . 'public' . DS . 'js' . DS . 'jRating.jquery.min.js';
// 	$js9 = ROOT . DS . 'public' . DS . 'js' . DS . 'jquery-ui.js';
// 	$js10 = ROOT . DS . 'public' . DS . 'js' . DS . 'fullcalendar.min.js';
// 	$js11 = ROOT . DS . 'public' . DS . 'js' . DS . 'jquery.ba-throttle-debounce.js';
// 	$jsN = ROOT . DS . 'public' . DS . 'js' . DS . 'general.js';

// 	$minifierJs = new Minify\JS($js1, $js2, $js3, $js4, $js5, $js6, $js7, $js8, $js9, $js10, $js11, $jsN);
// 	$mj_result = $minifierJs->minify(ROOT . DS . 'public' . DS . 'js' . DS . 'combined.min.js');
// 	// file_put_contents(ROOT . DS . 'public' . DS . 'css' .'combined.min.js', $mj_result);

//  CSRF Counter-measure //CHANGEDNOV19: different token method
	if (empty($_SESSION['state'])) {
	    if (function_exists('mcrypt_create_iv')) {
	        $_SESSION['state'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
	    } else {
	        $_SESSION['state'] = bin2hex(openssl_random_pseudo_bytes(32));
	    }
	}
	// $length = 32;
	// $token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length); //uniqid() only adds up to 29 bits of entropy, md5() doesn't add entropy, it just mixes it deterministically
	// $token = md5(uniqid(rand(), TRUE));
	// $_SESSION['state'] = $token;


	$websiteName = 'Kniew';
	// $websiteURL = "http://$_SERVER[HTTP_HOST]/";
	// $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$pagename = '';
	$urlArray ='';
	if(!empty($_GET['url']))
	{
	    $urlArray = preg_split('@/@', routeURL($_GET['url']), NULL, PREG_SPLIT_NO_EMPTY);
	    $pagename = $urlArray[sizeof($urlArray)-1];
	}
    if(!$pagename)
    {
    	$pagename = 'Find CA, Lawyers, Doctors, NGOs';
    }
    $pagename = urldecode(urldecode(str_replace('_', ' ', $pagename)));
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-US">


	<head>
		<title><?php if(isset($metaTitle) && $metaTitle != '') echo  $metaTitle; else echo $pagename . ' | Kniew';?></title>

		<meta content="text/html" charset="utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="description" content="<?php if(isset($metaDescription) && $metaDescription != '') echo  $metaDescription; else echo 'Find information, appointment and reviews of top lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs near you.';?>">
		<meta name="keywords" content="Find Lawyers, CA, Doctors, NGOs. Connect with New Clients. ">
		<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW"> <!-- or follow??-->
		<meta property="og:url"           content="https://www.kniew.com/" />
		<meta property="og:type"          content="website" />
		<meta property="og:title"         content="Find CA, Lawyers, Doctors, NGOs | Kniew" />
		<meta property="og:description"   content="Find information, appointment and reviews of top lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs near you." />
		<meta property="og:image"         content="<?php echo BASE_PATH;?>favicon.svg" />

		<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_PATH;?>favicon.ico">

		<!-- CHANGEDNOV19 : removed integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" to avoid cors error -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="bogus"/>

		<!-- CHANGEDNOV19 : separate stylesheets instead of one and change general  to combined.min -->
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>css/bootstrap-datetimepicker.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>css/jquery-comments.css">
		<link rel='stylesheet' href='<?php echo BASE_PATH;?>css/fullcalendar.css' />
		<link rel='stylesheet' href='<?php echo BASE_PATH;?>css/jquery-ui.min.css' />
	    <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>css/jRating.jquery.css">
			<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>css/jquery.steps.css">
		<?php
			print_r($html->includeCSS('general', 'media="bogus"'));
		?>





		<!-- <script>
		    if(!window.jQuery){
		      var script = document.createElement('script');
		      script.src = '/js/jquery-3.1.1.min.js';
		      document.head.appendChild(script);
		    }
		 //    (function($){
			// 		//bootstrap css fail
			// 		var $boot  = $('<div id="bootstrapCssTest" class="hidden"></div>').appendTo('body');
			// 		if ($boot.is(':visible')) {
			// 	        $("head").append('<link rel="stylesheet" href="/css/bootstrap-3.3.7.min.css">');
			// 	      }
			// 	     //fontawesome css fail
			//         var $span = $('<span class="fa" style="display:none"></span>').appendTo('body');
			//         if ($span.css('fontFamily') !== 'FontAwesome' ) {
			//             // Fallback Link
			//             $('head').append('<link href="/css/font-awesome-4.7.0.min.css" rel="stylesheet">');
			//         }
			//         $span.remove();
			// })(jQuery);
		 </script> -->

		 <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120794938-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-120794938-1');
        </script>




	</head>
	<body>

		<?php include_once(ROOT . DS . 'public' . DS. 'images' . DS . 'icons' . DS . 'combine.svg'); ?>
