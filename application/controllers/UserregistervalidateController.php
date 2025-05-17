<?php

error_reporting(0);
// use Razorpay\Api\Api;

class UserregistervalidateController extends Controller
{
	function __construct($controller, $action)
	{
		$this->doNotRenderHeader = 1;
		$this->render = 0;

	}

	function beforeAction(){}


	public function checkemail()
	{
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$this->_mymodel = 'Getdata';
			parent::__construct(get_class($this), __FUNCTION__);
			$email = htmlspecialchars(strip_tags($_POST['email']));
			if($this->Getdata->emailExist($email) != 0)
			{
				echo json_encode('Sorry! \''. htmlspecialchars($email) . '\' is already in use!');
			}
			else echo "true";
		}
		else echo "false";
	}

	public function checkusername()
	{
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$this->_mymodel = 'Getdata';
			parent::__construct(get_class($this), __FUNCTION__);
			$username = htmlspecialchars(strip_tags($_POST['username']));

			if(preg_match("/^[0-9a-zA-Z_]{5,}$/", $username) == false)
	    {
	     echo json_encode('Username should contain only letters, number and underscore and should be atleast 5 characters.');
	    }
	    elseif ($this->Getdata->usernameExist($username) != 0)
	    {
	       echo json_encode('Sorry! \''. htmlspecialchars($username) . '\' is already in use!');
	    }
	    else echo "true";

		}
		else echo "false";
	}

	public function checkverificationid()
	{
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$this->_mymodel = 'Getdata';
			parent::__construct(get_class($this), __FUNCTION__);
			$verificationid = strip_tags($_POST['verificationid']);
			$custrole = (int)$_POST['custrole'];
			if($this->Getdata->verificationidForRoleExist($verificationid, $custrole) != 0)
			{
				echo json_encode('\''. $verificationid . '\' is already in use! You can have only one account per ID. If you think someone else is using your unique registered ID, please contact us as soon as possible.');
			}
			else echo "true";
		}
		else echo "false";
	}

	public function submitregisteruser()
	{

		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$this->_mymodel = 'Setdata';
			parent::__construct(get_class($this), __FUNCTION__);
			if(isset($_SESSION['code'])) $usercode = $_SESSION['code'];
			elseif(isset($_POST['code'])) $usercode = $_POST['code'];
			else
			{
				$usercode = md5( strtolower(htmlspecialchars(strip_tags($_POST['username']))) + microtime());
			}
			$registerData = array(
                   ':username' => htmlspecialchars(strip_tags(strtolower($_POST['username']))),
                   ':password' => htmlspecialchars(strip_tags($_POST['password'])),
                   ':email' => htmlspecialchars(strip_tags($_POST['email'])),
                   ':usercode' => $usercode
                  );
		    $result = $this->Setdata->registerUser($registerData);
				// CHANGEDNOV19
				if($result)
				{
					//go to mail chimp
					if($this->addToMailchimp($_POST) == 2)	$returndata['error'] ='Please check your mail and try again!';
					else $returndata['success'] = 'Registration Successful!';
					if(loggedin())
					{
						if(isset($_SESSION['sendMessagePending']))
						{
							$MessagesController = new MessagesController('messages', 'sendmessagefrombutton');
							$returndata= array_merge($returndata,$MessagesController->sendmessagefrombutton());
						}
						if(isset($_SESSION['donateOrderPending']))
						{
							$ProfessionalsController = new ProfessionalsController('professionals', 'createdonateorder');
							$returndata = array_merge($returndata, $ProfessionalsController->createdonateorder());
						}
					}

					echo json_encode($returndata);

				}
		    // print_r($result);

		}
		else echo "false";
	}


	public function submitregisterprofessional()
	{

		// CHANGEDNOV19 : POST TO FILTER INPUT, ADDED VALIDATION

		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$this->_mymodel = 'Setdata';
			parent::__construct(get_class($this), __FUNCTION__);


			// first validate
			$validation = new Valitron\Validator($_POST);
			$validation->rules([
				'required'=> ['custregrole', 'regspecialisation','email','username','language','about','password','name','verificationid','since','formattedAddress','starttime','endtime'],
				'email' => ['email'],
				'numeric'=>['phone'],
				'slug'=>['username'],
				'dateFormat'=>[['since','d/m/Y'],['starttime','h:i A'],['endtime','h:i A'],['breakstarttime','h:i A'],['breakendtime','h:i A']],
				'dateBefore' => [['since', date('Y-m-d', time())]],
				'lengthBetween' => [
			        ['username', 5, 50],
							['about', 200, 20000],
							['name', 3, 50]
			    ],
					'regex'=>[['name', '/^[A-Za-z]+(\s+[A-Za-z]+)*$/']],
					'notIn' => [
						['regspecialisation',['default']]
			    ],
					'lengthMin' => [
			      ['password', 5]
			    ],
					'in' => [
			      ['custregrole', [2, 3, 4, 5]]
			    ],
			]);
			$validation->rule('regex','language','/^[A-Za-z\s]+(\,+[A-Za-z\s]+)*$/')->message('Please enter valid language name, with commas in between. Special character not allowed'); //alphacomma
			// $validation->rule(function($field, $value, $params, $fields) {
			// 	$n = explode(',',$value);
		  //   return (sizeof($n) <= 3);
			// }, "recommendname")->message("Maximum 3 recommendation allowed");

			// $validation->rule(function($field,$value,$params,$fields){
			// 		if($value[0] != "")
			// 			if($value[0] == $value[1] || $value[0] == $value[2]) return false;
			// 		if($value[1] != "")
			// 			if($value[0] == $value[1] || $value[1] == $value[2]) return false;
			// 		if($value[2] != "")
			// 			if($value[2] == $value[1] || $value[0] == $value[2]) return false;
			// 		return true;
			// },'recommendids')->message("Please check your recommendations. Recommendation cannot be repeated");
			$validation->rule('notIn',['username','name'],  ['kniew', 'kniew.com', 'admin', 'adminstrator', 'administrator', 'user', 'lawyer', 'doctor', 'ngo', 'ca', 'charteredaccountant', 'chartered_accountant'])->message('Please enter a valid name, reserved words not allowed');
			// $validation->rule('requiredWith', 'duration', 'allowapointment')->rule(function($field, $value,$params,$fields)
			// {
			// 	if(isset($fields['allowappointment']) && $fields['allowappointment'] != null) return($value >= 5);
			// 	else return true;
			// },'duration')->message('Please enter appointment duration. Minimum of five minutes is required');
			$validation->rule(function($field,$value,$params,$fields){
				$custrole = $fields['custregrole'];
				$exp;
				if($custrole == 3 || $custrole == 2) $exp = '/^[a-zA-Z]{2}\/\\d{1,}\/\d{1,}$/';
				else if($custrole == 5) $exp = "/^\d{6}$/";
				else $exp = "/^.+$/";
				return preg_match($exp, $value);
				return true;
			},'verificationid')->message('Incorrect registration number, please make sure you check and add only registered number');

			$validation->labels(array(
			    'custregrole' => 'Profession',
			    'regspecialisation' => 'Specialisation',
					'regspecialisationother[]'=>'Other specialisation',
					'since' => 'Practising since',
					'verificationid' => 'ID',
					'about' => 'About you',
					'phone' => 'Phone Number ',
					'duration' => 'Appointment duration',
					'recommendids' => 'Registered user recommendation ',
					'formattedAddress' => 'Your work location '

			));
			if($validation->validate())
			{


				// email/username not exists --> this can be done by unique constraint of sql so not needed?

				$_POST['username'] = strtolower($_POST['username']);
				$_POST['language'] = explode(',', $_POST['language']);
				foreach ($_POST['language'] as $key => $value) {
					$_POST['language'][$key] = ucwords(strtolower(trim($value)));
				}
				$registerData = array();
				// $appointmentData = array();
				if(isset($_POST['image-data']) && $_POST['image-data'] != null)
				{
					  $img = $_POST['image-data'];
			      $img = str_replace('data:image/png;base64,', '', $img);
			      $img = str_replace(' ', '+', $img);
			      $fileTemp = base64_decode($img);
				}

				// $_POST['recommendation'] = $_POST['recommendids'];

				unset($_POST['image-data']);
				// unset($_POST['recommendname']);
				unset($_POST['registercustomersSubmit']);
				// unset($_POST['recommendids']);


				if(isset($_POST['isfirm']) && $_POST['isfirm'] == true)
				{
					$registerData[':workat'] = '0';
					unset($_POST['isfirm']);
					unset($_POST['workatid']);
					unset($_POST['workatname']);
				}
				elseif(!empty($_POST['workatid']))
				{
					$registerData[':workat'] = $_POST['workatid'];
					unset($_POST['isfirm']);
					unset($_POST['workatid']);
					unset($_POST['workatname']);
				}
				else
				{
					$registerData[':workat'] = $_POST['workatname'];
					unset($_POST['isfirm']);
					unset($_POST['workatid']);
					unset($_POST['workatname']);
				}


				foreach ($_POST as $key => $value)
				{


					if(is_array($value))
					{

						// if(strtolower($key) == 'weeklyholiday')
						// {
						// 	$appointmentData[':' . $key] = '{'.implode(",",array_filter($value, 'strlen')).'}';
						// }
						// else
						$registerData[':' . $key] = '{'.implode(",",array_filter($value, 'strlen')).'}';
					}
					else if($key == 'starttime')
					{
					  if($value) $registerData[':workday'] = '{' .htmlspecialchars(strip_tags($value));
					}
					elseif($key == 'endtime')
					{

					  if($value) $registerData[':workday'] = $registerData[':workday'] .', ' . htmlspecialchars(strip_tags($value)) . '}';
					}
					elseif($key == 'breakstarttime')
					{
						if($value) $registerData[':breaktime'] = '{' . htmlspecialchars(strip_tags($value));
						// else $resisterData[':breaktime'] =  null;

					}

					elseif($key == 'breakendtime')
					{
						if($value) $registerData[':breaktime'] = htmlspecialchars(strip_tags($registerData[':breaktime'])) . ', ' . $value . '}';
						// else $registerData[':breaktime'] = json_encode(array()::time[]);

					}

					// elseif($key == 'allowappointment')
					// {
					// 	if($value)
					// 	{
					//
					// 	}
					// 	else
					// 	{
					// 		$appointmentData[':blockfutureappointment'] = !$value;
					// 	}
					// }
					// elseif($key == 'fee' || $key == 'duration' || $key == 'maxdate' || strtolower($key) == 'weeklyappointment')
					// {
					// 	if($value)  $appointmentData[':' . $key ] = htmlspecialchars(strip_tags($value));
					// 	// if($key='weeklyAppointment')
					// 	// {
					// 	// 	if($value == 1) $appointmentData[':' . $key ] = (boolean)true;
					// 	// 	else $appointmentData[':' . $key ] = (boolean)false;
					// 	// }
					// }
					elseif($key == 'about')
					{
						$config = HTMLPurifier_Config::createDefault();
						$purifier = new HTMLPurifier($config);
						$about = $purifier->purify($value);
						if($value) $registerData[':' . $key ] = $about;
					}
					else
					{
						if($value) $registerData[':' . $key ] = htmlspecialchars(strip_tags($value));
					}

				}


				if($_SESSION['code']) $registerData[':usercode'] = $_SESSION['code'];
				else $registerData[':usercode'] =md5( strtolower(htmlentities(strip_tags($_POST['email']))) + microtime());


		    $result = $this->Setdata->registerProfessional($registerData, $fileTemp);
		    // print_r($result);
		    if($result)
				{
					//go to mail chimp
					if($this->addToMailchimp($_POST) == 2)	$returndata['error'] ='<p class="error">Please check your mail and try again!</p>';
					else $returndata['success'] = '<p class="greentext">Registration Successful!</p>';
					if(loggedin())
					{
						if(isset($_SESSION['sendMessagePending']))
						{
							$MessagesController = new MessagesController('messages', 'sendmessagefrombutton');
							$returndata['sendmessagefrombutton'] = $MessagesController->sendmessagefrombutton();
						}
						if(isset($_SESSION['donateOrderPending']))
						{
							$ProfessionalsController = new ProfessionalsController('professionals', 'createdonateorder');
							$returndata['createdonateorder'] = $ProfessionalsController->createdonateorder();
						}
					}

					echo json_encode($returndata);

				}
				else
				{
					$returndata['error'] = '<p class="greentext">Error occured, please check your data and try again.</p>';
					echo json_encode($returndata);
				}
			}
			else if($errors = $validation->errors())
			{
				$errorshtml = '<ul class="error listnone"><li>*';
				$errorshtml .= implode( '.</li><li>*', array_filter(array_map(function($e){
         return implode(".</li><li>*", array_filter($e));
			 }, $errors)));
				$errorshtml .= '.</li></ul>';
				$returndata['error'] = $errorshtml;
				echo json_encode($returndata);
			}

		}
		else echo "false";

	}


	function afterAction(){}

	public function addToMailchimp()
	{
		$this->render = 0;

		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$email = $_POST['cs_email'] ? $_POST['cs_email'] : $_POST['email'];
			if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
			{

				if(isset($_POST['registercustomersSubmit']) || isset($_POST['userregisterbtn']))
				{
					// member information
					$prof = isset($_POST['registercustomersSubmit']) ? true : false;
					if($_POST['custregrole'] == 2) $usertype = '842a6946ab';
					if($_POST['custregrole'] == 3) $usertype = '4f38a321ef';
					if($_POST['custregrole'] == 4) $usertype = '0d6271279f';
					if($_POST['custregrole'] == 5) $usertype = '192b038fd3';
					else { $usertype = '5a3003c193'; $prof =false;}
					$json = json_encode([
						'email_address' => $email,
			            'status' => 'subscribed',
			            "merge_fields"=>["CODE" => $_SESSION['code'],"NAME" =>$_POST['name'] ? $_POST['name'] : $_POST['username']] ,
			            'interests' => array($usertype => true,
							            	'ae207d1174' => $prof),
			        ]);

				}
				else
				{
					$_POST['code'] = md5( strtolower(htmlentities(strip_tags(trim($email)))) + microtime());
					$_SESSION['code'] = $_POST['code'];
					$json = json_encode([
			            'email_address' => $email,
			            'status' => 'subscribed',
			             "merge_fields"=>["CODE" => $_POST['code']],
			            'interests' => array('ae207d1174' => $_POST['isprofessional'] ? true : false),
			        ]);
				}
				$apiKey = MAILCHIMP_API_ID;
				$listID = MAILCHIMP_LIST_ID;


				// MailChimp API URL
		        $memberID = md5(strtolower($email));
		        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
		        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;




		        // send a HTTP POST request with curl
		        $ch = curl_init($url);
		        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		        $result = curl_exec($ch);
		        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		        curl_close($ch);

		        // // store the status message based on response code
		        if ($httpCode == 200) {
		            $msg = 1;
		        }
		        else
		        {
		            switch ($httpCode)
		            {
		                case 214:
		                    $msg = 1;
		                    break;
		                default:
		                    $msg = 0;
		                    break;
		            }
		        }
		        return array($msg, $_POST['code']);


			}
			else
			{
				return 2;
			}
		}
	}









}
