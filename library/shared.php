<?php

	/** Check if environment is development and display errors **/

	function setReporting()
	{
		if (DEVELOPMENT_ENVIRONMENT == true)
		{
		    error_reporting(E_ALL);
		    ini_set('display_errors','On');
		}
		else
		{
		    error_reporting(E_ALL);
		    ini_set('display_errors','Off');
		    ini_set('log_errors', 'On');
		    ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
		}
	}

	function setCookieParameters( $samesitecookie = "Lax", $httponly = 0, $onlycookie = 1, $securecookie = 0)
	{
		// **PREVENTING SESSION HIJACKING**
		// Prevents javascript XSS attacks aimed to steal the session ID
		ini_set('session.cookie_httponly', $httponly);

		// **PREVENTING SESSION FIXATION**
		// Session ID cannot be passed through URLs
		ini_set('session.use_only_cookies', $onlycookie);

		// Uses a secure connection (HTTPS) if possible
		ini_set('session.cookie_secure', $securecookie);
		// ini_set('session.cookie_samesite', 2);//notavailable
	}



	/** Check for Magic Quotes and remove them **/

	function stripSlashesDeep($value)
	{
	    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	    return $value;
	}

	function removeMagicQuotes()
	{
		if ( get_magic_quotes_gpc() )
		{
		    $_GET    = stripSlashesDeep($_GET   );
		    $_POST   = stripSlashesDeep($_POST  );
		    $_COOKIE = stripSlashesDeep($_COOKIE);
		}
	}

	/** Check register globals and remove them **/

	function unregisterGlobals()
	{
	    if (ini_get('register_globals'))
	    {
	        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');

	        foreach ($array as $value)
	        {
	            foreach ($GLOBALS[$value] as $key => $var)
	            {
	                if ($var === $GLOBALS[$key])
	                {
	                    unset($GLOBALS[$key]);
	                }
	            }
	        }
	    }
	}

	/** Secondary Call Function **/

	function performAction($controller,$action,$queryString = null,$render = 0)
	{

		$controllerName = ucfirst($controller).'Controller';
		$dispatch = new $controllerName($controller,$action);
		$dispatch->render = $render;
		return call_user_func_array(array($dispatch,$action),$queryString);
	}

	/** Routing **/

	function routeURL($url)
	{
		global $routing;

		foreach ( $routing as $pattern => $result ) {
	            if ( preg_match( $pattern, $url ) ) {
					return preg_replace( $pattern, $result, $url );
				}

		}
		return ($url);
	}


	/** Main Call Function **/

	function callHook()
	{
	    global $url;
	    global $default;

	    $queryString = array();
	    if (!isset($url))
	    {
			$controller = $default['controller'];
			$action = $default['action'];
			}
			else
			{
				$url = routeURL($url);
				#CHANGEDNOV19 : logic for &
				if(strpos($url, '&'))
				{
					$isamp = explode('&', $url);
					$url=$isamp[0];
					$queryString = $isamp[1];
				}

				$url = preg_replace('#/+#','/',$url);

			    $urlArray = array();
			    $urlArray =  preg_split('@/@', strtolower($url), NULL, PREG_SPLIT_NO_EMPTY);

			    $controller = $urlArray[0];
			    array_shift($urlArray);

			    if (isset($urlArray[0]))
			    {
					$action = $urlArray[0];
					array_shift($urlArray);
				}
				else
				{
					$action = 'index'; // Default Action
				}

				#CHANGEDNOV19 added isset

		    if(isset($urlArray)) $queryString = $urlArray;


		}

		// ////////////////////COMING SOON LOGIC -- REMOVE LATER////

		// if(in_array($controller, array('professionals','search')))
		// {
		// 	//'about','activateaccount','registerasprofessional','articles','notice','comingsoon','contact','logout','sendEmail','user','userloginvalidate','userregistervalidate', 'profile'
		// 	if($controller == 'professionals')
		// 	{
		// 		header('Location: ' . BASE_PATH . 'comingsoon' . DS . 'profession');
		// 		exit();
		// 	}
		// 	else
		// 	{
		// 		header('Location: ' . BASE_PATH . 'comingsoon');
		// 		exit();
		// 	}
		// }
		// else
		// {
		// 	$controller = $controller; $action = $action;
		// }
    //
		///////////////////////////////////////////////////////////

	    $controllerName = ucfirst($controller).'Controller';
	    if(class_exists($controllerName))
	    {

		    if ((int)method_exists($controllerName, $action) || $controller == 'user')
		    {
		    	$dispatch = new $controllerName($controller,$action);
				// call_user_func_array(array($dispatch,"beforeAction"),$queryString);
				call_user_func_array(array($dispatch,$action),$queryString);
				// call_user_func_array(array($dispatch,"afterAction"),$queryString);
				}
				else
				{
					nopage();
				}

	    }
	    else
	    {
	    	nopage();
	    }





	}

	// /** Autoload any classes that are required **/ not needed cuz of composer

	// function __autoload($className)
	// {
	//     if (file_exists(ROOT . DS . "library" . DS . $className . ".class.php"))
	//     {
	//         require_once(ROOT . DS . "library" . DS . $className . ".class.php");
	//     }
	//     else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . $className . '.php'))
	//     {
	//         require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . $className . '.php');
	//     }
	//     else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php'))
	//     {
	//         require_once(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php');
	//     }
	//     else
	//     {
	//         /* Error Generation Code Here */
	//     }
	// }

	function getIp()
	{

		 if( isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];

		 if (!empty($_SERVER['HTTP_CLIENT_IP']))
		 {

			 $ip = $_SERVER['HTTP_CLIENT_IP'];

		 }
		 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		 {

			 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

		 }
		 return $ip;
	}


	/**get timezone details**/

	function setTimezone()
	{
	   ini_set('allow_url_fopen','1');
		$pageContent = @file_get_contents('http://ip-api.com/json/' . getIP()); //suppress the warning by putting an error control operator (i.e. @) in front of the call to file_get_contents(): $content = @file_get_contents($site);
		$parsedJson  = json_decode($pageContent);

		if(isset($parsedJson->timezone) && $parsedJson->timezone != NULL)
		{
			date_default_timezone_set($parsedJson->timezone);
			define("TIMEZONE", $parsedJson->timezone);

			if($parsedJson->country)
			{
				define('COUNTRY', $parsedJson->country);
				if( $parsedJson->regionName)
				{
					define('STATE', $parsedJson->regionName);
					if($parsedJson->city)
					{
						define('CITY', $parsedJson->city);
					}
				}

			}
			else
			{
				define('COUNTRY', 'India');

			}
		}
		else
		{
			date_default_timezone_set('Asia/Kolkata');
			define("TIMEZONE", 'Asia/Kolkata');
			define('COUNTRY', 'India');
		}
	}

	function loggedin()
	{

		return (isset($_SESSION['id']));
	}

	function verifycsrf()
	{
		// check if a session is started and a token is transmitted, if not return an error
		if(!isset($_SESSION['state'])) {
			return false;
	    }

		// check if the form is sent with token in it
		if(!isset($_POST['state'])) {
			return false;
	    }

		// compare the tokens against each other if they are still the same
		if (!hash_equals($_SESSION['state'], $_POST['state'])) {
			return false;
	    }

		return true;
	}

	function nopage()
	{
		header('Location: ' . BASE_PATH . 'notice/error/404');
		exit();
	}



	function protectPage(){
		if (loggedin() == false){
			$url = $_GET['url'];
			header('Location: ' . BASE_PATH . 'notice/membersonly&prevurl=' . $url);
			exit();
		}
	}


	function isAdmin(){
		if(isset($_SESSION['access']))
		return (($_SESSION['access'] == 1) ? true : false);
	}


	function isNotAuthenticMessage()
	{
		if($_SESSION['isauthentic'] === FALSE)
		{
			echo "<div class='padding5per largetext error'>You are not allowed this action as you are not authenticated. If you think this is a mistake, please make sure you have entered correct details by going to <a href='". BASE_PATH ."profile#settings'>Settings</a> or <a href='". BASE_PATH ."contact'>Contact Us</a></div>";
		}
		elseif($_SESSION['isauthentic'] === NULL)
		{
			echo "<div class='padding5per largetext '>Your account is under review, please give us some time to evaluate your profile. If you have any futher question, feel free to  <a href='". BASE_PATH ."contact'>Contact Us</a>. If you have made a mistake in your sign up form, don't worry, you can change your details by going to <a href='". BASE_PATH ."profile#settings'>Settings</a>.</div>";
		}
	}

	function adminProtectPage(){
		if (isAdmin() == false){
			header("HTTP/1.1 401 Unauthorized");
			exit();
		}
	}

	function isProfessional()
	{
		return(($_SESSION['usertype'] == 2 || $_SESSION['usertype'] == 3 || $_SESSION['usertype'] == 4 || $_SESSION['usertype'] == 5) ? true : false);
	}

	function isUsernormal()
	{
		return (($_SESSION['usertype'] == 1) ? true : false);
	}

	function loggedinRedirect(){
		if(loggedin() == true)
		{
			if($_SESSION['usertype'] == 1) $type = 'user/';
			elseif($_SESSION['usertype'] == 2) $type = 'professionals/ngo/';
			elseif ($_SESSION['usertype'] == 3) $type = 'professionals/lawyers/';
			elseif ($_SESSION['usertype'] == 4) $type = 'professionals/doctors/';
			elseif ($_SESSION['usertype'] == 5) $type = 'professionals/charteredaccountants/';
			echo "<h5>You are logged in as <a href='" . BASE_PATH . $type . $_SESSION['username'] ."'>" . $_SESSION['username'] . "</a>. <a href='" . BASE_PATH. "logout'>Log out</a> to register as a new user!</h5>";
			include(ROOT . 'application/views/footer.php');
			exit();

		}
	}

	function timeAgo($time){
		$estimate_time = time() - strtotime($time);

	    if( $estimate_time < 1 )
	    {
	        return 'a second ago';
	    }

	    $condition = array(
	                12 * 30 * 24 * 60 * 60  =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	    );

	    foreach( $condition as $secs => $str )
	    {
	        $d = $estimate_time / $secs;

	        if( $d >= 1 )
	        {
	            $r = round( $d );
	            return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
	        }
	    }
	}


	/** GZip Output **/

	function addToSitemap($url)
	{

		$sitemap = simplexml_load_string(file_get_contents(ROOT . DS . 'public' . DS . 'sitemap.xml'));


		$myNewUri = $sitemap->addChild("url");
		$myNewUri->addChild("loc", $url);
		$myNewUri->addChild("lastmod", date("Y-m-d"));
		$myNewUri->addChild("changefreq", "daily");
		$sitemap->asXml(ROOT . DS . 'public' . DS . 'sitemap.xml');

	}

	function gzipOutput()
	{
	    $ua = $_SERVER['HTTP_USER_AGENT'];

	    if (0 !== strpos($ua, 'Mozilla/4.0 (compatible); MSIE ') || false !== strpos($ua, 'Opera'))
	    {
	        return false;
	    }

	    $version = (float)substr($ua, 30);
	    return (
	        $version < 6
	        || ($version == 6  && false === strpos($ua, 'SV1'))
	    );
	}

	/** Get Required Files **/
	require_once(ROOT . DS . 'vendor' . DS . 'autoload.php');

	gzipOutput() || ob_start("ob_gzhandler");

	setReporting();
	removeMagicQuotes();
	unregisterGlobals();
	session_start();

	setTimezone();


	$cache =new Cache();
	$inflect = new Inflection();
	$loggedin = loggedin();


	callHook();




?>
