<?php
error_reporting(0);


class UserloginvalidateController extends Controller
{
	function __construct($controller, $action)
	{
		$this->doNotRenderHeader = 1;
		$this->render = 0;
		$this->_mymodel = 'Getdata';
		parent::__construct($controller, $action);

	}


	function usernamevalidate()
	{

		if($_POST)
		{
			$username = htmlentities(strip_tags($_POST['username']));
			if(($id = $this->Getdata->idFromEmail($username)) || ($id = $this->Getdata->idFromUsername($username)))
			{
				if($this->Getdata->isIdOfProfessional($id))
				{
					$verify = $this->Getdata->verifyProfessional($id);
					if( $verify == TRUE || $verify > 0)
					{
						echo "true";
					}
					else
					{
						echo json_encode("Please verify your account, through the link in your email.");
					}
				}
				else
				{
					echo "true";
				}

			}
			else
			{
				echo json_encode("User does not exists!");
			}

		}
		else
		{
			echo "false";
		}

	}

	function passwordvalidate()
	{
		$username = htmlentities(strip_tags($_POST['username']));
		$password = htmlentities(strip_tags($_POST['password']));


		if($_POST)
		{
			if ($this->Getdata->passwordCorrect($username, $password) == TRUE)
		    {
		      echo "true";
		    }
		    else echo json_encode('Incorrect password!');
		}
		else echo "false";
	}

	function userlogin()
	{

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$type;
			$username = htmlentities(strip_tags($_POST['username']));
			if(strpos($username, '@') !== FALSE) $type = 'email';
			else $type = 'username';

			if($data = $this->Getdata->generalUserData($username, $type))
			{
				$_SESSION['id'] = $data['id'];
				$_SESSION['name'] = $data['nameprof'] ? $data['nameprof'] : $data['nameuser'];
				$_SESSION['usertype'] = $data['usertype'];
				$_SESSION['access'] = $data['access'];
				$_SESSION['code'] = $data['usercode'];
				$_SESSION['profilepic'] = $data['p1'] ? $data['p1'] : $data['p2'];
				$_SESSION['isauthentic'] = $data['isauthentic'];
				$_SESSION['reference'] = $data['reference'];
				$_SESSION['joiningdate'] = $data['joiningdate'];
				if($data['usertype'] != 1) $_SESSION['linkedaccountid'] = $data['linkedaccountid'];
				if($type == 'email')
				{
					$_SESSION['username'] = $data['username'];
					$_SESSION['email'] = $username;
				}
				elseif($type == 'username')
				{
					$_SESSION['email'] = $data['email'];
					$_SESSION['username'] = $username;
				}

				if(isset($_SESSION['donateOrderPending']))
				{
					$ProfessionalsController = new ProfessionalsController('professionals', 'createdonateorder');
					echo $ProfessionalsController->createdonateorder();
				}
				else if(isset($_SESSION['sendMessagePending']))
				{
					$MessagesController = new MessagesController('messages', 'sendmessagefrombutton');
					echo $MessagesController->sendmessagefrombutton();
				}
				else echo 1;
			}

			// if($data = $this->Getdata->generalFromEmail($username))
			// {
			// 	$_SESSION['id'] = $data['id'];
			// 	$_SESSION['username'] = $data['username'];
			// 	$_SESSION['name'] = $data['nameprof'] ? $data['nameprof'] : $data['nameuser'];
			// 	$_SESSION['usertype'] = $data['usertype'];
			// 	$_SESSION['access'] = $data['access'];
			// 	$_SESSION['code'] = $data['usercode'];
			// 	$_SESSION['profilepic'] = $data['p1'] ? $data['p1'] : $data['p2'];
			// 	$_SESSION['email'] = $username;
			// 	$_SESSION['authuser'] = $data['authuser'];
			// 	$_SESSION['reference'] = $data['reference'];
			// 	$_SESSION['joiningdate'] = $data['joiningdate'];
			// 	if(isset($_SESSION['sendMessagePending']))
			// 	{
			// 		$MessagesController = new MessagesController('messages', 'sendmessagefrombutton');
			// 		echo $MessagesController->sendmessagefrombutton();
			// 	}
			// 	else echo 1;
			// }
			// else if($data = $this->Getdata->generalFromUsername($username))
			// {
			// 	$_SESSION['id'] = $data['id'];
			// 	$_SESSION['username'] = $username;
			// 	$_SESSION['name'] = $data['nameprof'] ? $data['nameprof'] : $data['nameuser'];
			// 	$_SESSION['usertype'] = $data['usertype'];
			// 	$_SESSION['code'] = $data['usercode'];
			// 	$_SESSION['access'] = $data['access'];
			// 	$_SESSION['profilepic'] = $data['p1'] ? $data['p1'] : $data['p2'];
			// 	$_SESSION['email'] = $data['email'];
			// 	$_SESSION['authuser'] = $data['authuser'];
			// 	$_SESSION['reference'] = $data['reference'];
			// 	$_SESSION['joiningdate'] = $data['joiningdate'];
			// 	if(isset($_SESSION['sendMessagePending']))
			// 	{
			// 		$MessagesController = new MessagesController('messages', 'sendmessagefrombutton');
			// 		echo $MessagesController->sendmessagefrombutton();
			// 	}
			// 	else echo 1;
			//
			//
			// }



		}

	}

	public function googlesignin()
	{

		$this->render = 0;

		  $id_token = $_POST['id_token'];
	      $code = $_POST['code'];
	      $access_token = $_POST['access_token'];

	      $client = new Google_Client();
	      $client->setClientId(client_id);
	      $client->setClientSecret(client_secret);
	      $client->setRedirectUri(redirect_uri);
	      $client->setScopes(array(
	      "https://www.googleapis.com/auth/plus.login",
	      "https://www.googleapis.com/auth/userinfo.email",
	      "https://www.googleapis.com/auth/userinfo.profile",
	      "https://www.googleapis.com/auth/plus.me"
	      ));
	      $client->setApprovalPrompt('auto');
	      $client->setIncludeGrantedScopes(true);
	      $client->setAccessType('offline');
	      $client->authenticate($code);

	      $plus = new Google_Service_Plus($client);

	      if (isset($_POST['access_token']))
	      {
	       $client->setAccessToken($access_token);
	      }

	       if ($client->getAccessToken())
	      {

	        $profile = $plus->people->get('me');
	        $_SESSION['access_token'] = $client->getAccessToken();



	      if($profile)
	      {
	        $email = $profile['emails'][0]['value'];
	        $loginclass = new Userloginvalidate();
	        $result = $loginclass->dataByGoogle($profile);
		    $data = $this->Getdata->generalFromUsername($result['returnusername']);

	        $_SESSION['gpid'] = $profile['id'];
	        $_SESSION['id'] = $result['returnid'] ;
	        $_SESSION['username'] = $result['returnusername'];
	        $_SESSION['usertype'] = $data[0]['usertype'];
				$_SESSION['access'] = $data[0]['access'];
				$_SESSION['code'] = $data[0]['usercode'];
				$_SESSION['profilepic'] = isset($data[0]['p1']) ? $data[0]['p1'] : $data[0]['p2'];
				$this->Setdata->updatereference();
	        session_write_close();
					if(isset($_SESSION['sendMessagePending']))
					{
						$MessagesController = new MessagesController('messages', 'sendmessagefrombutton');
						$MessagesController->sendmessagefrombutton();
					}
					// if(isset($_SESSION['donateOrderPending']))
					// {
					// 	$ProfessionalsController = new ProfessionalsController('professionals', 'createdonateorder');
					// 	$ProfessionalsController->createdonateorder();
					// }

	        exit();

		  }
		}
	}

	public function facebooklogin()
	{
		$this->render = 0;
		$fb = new Facebook\Facebook([
	        'app_id' => FACEBOOK_APP_ID,
	        'app_secret' => FACEBOOK_APP_SECRET,
	        'default_graph_version' => 'v2.5',
	        'http_client_handler' => 'stream'
	    ]);

	    $helper = $fb->getJavaScriptHelper();
	    $permissions = ['email','about','birthday','email','first_name','last_name', 'location', 'link'];

	    try
	      {

	          if (isset($_SESSION['facebook_access_token']))
	          {
	            $accessToken = $_SESSION['facebook_access_token'];

	          }
	          else
	          {

	            $accessToken = $helper->getAccessToken();

	          }

	      }
	      catch(Facebook\Exceptions\FacebookResponseException $e)
	      {
	          // When Graph returns an error
	          echo 'Graph returned an error: ' . $e->getMessage();
	          exit;
	      }
	      catch(Facebook\Exceptions\FacebookSDKException $e)
	      {
	          // When validation fails or other local issues
	          echo 'Facebook SDK returned an error: ' . $e->getMessage();
	          exit;
	      }

	      if (isset($accessToken))
	      {
	         if (isset($_SESSION['facebook_access_token']))
	         {
	            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	          }
	          else
	          {
	            $_SESSION['facebook_access_token'] = (string) $accessToken;
	            $oAuth2Client = $fb->getOAuth2Client();
	            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
	            $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
	            $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	          }
	           $fbresult = $fb->get('/me?fields=id,email,about,birthday,first_name,last_name, location, link', $_SESSION['facebook_access_token']);
	           $graph = $fbresult->getGraphObject();
	           $profile = $graph->asArray();


		        $loginclass = new Userloginvalidate();
		        $result = $loginclass->dataByFacebook($profile);
		        $data = $this->Getdata->generalFromUsername($result['returnusername']);
		        $_SESSION['fbid'] = $profile['id'];
		        $_SESSION['id'] = $result['returnid'] ;
		        $_SESSION['username'] = $result['returnusername'];
		        $_SESSION['usertype'] = $data[0]['usertype'];
				$_SESSION['access'] = $data[0]['access'];
				$_SESSION['code'] = $data[0]['usercode'];

				$_SESSION['profilepic'] = isset($data[0]['p1']) ? $data[0]['p1'] : $data[0]['p2'];
				$this->Setdata->updatereference();
				if(isset($_SESSION['sendMessagePending']))
				{
					$MessagesController = new MessagesController('messages', 'sendmessagefrombutton');
					$MessagesController->sendmessagefrombutton();
				}
				// if(isset($_SESSION['donateOrderPending']))
				// {
				// 	$ProfessionalsController = new ProfessionalsController('professionals', 'createdonateorder');
				// 	$ProfessionalsController->createdonateorder();
				// }


	        header("Refresh: 10;url=" . BASE_PATH);
	        session_write_close();
	        exit();
	      }
	       else
	      {

	        echo "Please ensure that cookies are enabled, facebook sign in information is correct and that the website has the permission to access the website. Try deleting the cookies. If problem persists please contact us. <a href='".BASE_PATH."'> Take home. </a>";
	        exit();
	      }



	}







}
