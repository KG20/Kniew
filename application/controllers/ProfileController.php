<?php
// error_reporting(0);
class ProfileController extends Controller
{

	public function index()
	{
		$get = new Getdata();

		$tags = $get->getAllTags();
		$this->set('tags', $tags);
		$this->set('metaTitle', 'Edit your profile | Kniew');
		$this->set('metaDescription', 'Edit your profile data, check and manage appointments.');

		if(loggedin() == true && isProfessional() == true)
		{
			$prof = $this->Profile->getProfDataById($_SESSION['id']);
			if($prof['linkedaccountid'] != NULL)
			{
				$payment = new PaymentController('payment', 'razorpaybyaccountid');
				$prof['linkedaccountdetails'] = json_decode($payment->razorpaybyaccountid($prof['linkedaccountid']), true);
			}
			$this->set('profiledata', $prof);

		}
		else if(loggedin() == true && isUsernormal() == 1)
		{
			$user = $this->Profile->getUserDataById($_SESSION['id']);
			$this->set('profiledata', $user);
		}
	}

	public function saveappointmentsettings()
	{
		$this->render = 0;

		if($_POST)
		{

			$success = $this->Profile->upsertAppointmentSetting($_POST);
			echo $success;
		}
	}

	public function unblockfutureappointment()
	{
		$this->render = 0;
		if($_POST['professionalid'])
		{
			$professionalid = $_POST['professionalid'];
			$success = $this->Profile->unblockFutureAppointmentSetting($professionalid);
			echo $success;
		}
	}

	public function blockfutureappointments()
	{
		$this->render = 0;
		if($_POST['professionalid'])
		{
			$professionalid = $_POST['professionalid'];
			$success = $this->Profile->blockFutureAppointmentSetting($professionalid);
			echo $success;
		}
	}

	public function deleteappointmentsystem()
	{
		$this->render = 0;
		if($_POST['professionalid'])
		{
			$professionalid = $_POST['professionalid'];
			$success = $this->Profile->deleteAppointmentsByProfessionalid($professionalid);
			echo $success;
		}
	}

	// public function setting()
	// {
	// 	$_POST['starttime'] = date("H:i:s", strtotime($_POST['starttime']));
	// 	$_POST['endtime'] = date("H:i:s", strtotime($_POST['endtime']));
	// 	$_POST['breakstarttime'] = date("H:i:s", strtotime($_POST['breakstarttime']));
	// 	$_POST['breakendtime'] = date("H:i:s", strtotime($_POST['breakendtime']));
	// }



	public function addarticletitlevalidate()
	{
		$this->render = 0;
		if($_POST['title'])
		{
			$get = new Getdata();

			$title = htmlspecialchars(htmlentities(strip_tags(trim($_POST['title']))));
			if($get->titleExist($title)==true)
			{
				echo json_encode("Sorry! Article with the same title exists! Please choose another article.");
			}
			else echo "true";


		}
		else echo json_encode('Please enter a heading.');
	}

	public 	function usernamevalidate()
	{
		$this->render = 0;

		if($_POST)
		{
			$get = new Getdata();

			$username = htmlentities(strip_tags($_POST['author']));

			if($get->usernameExist($username))
			{
					echo "true";
			}
			else
			{
				echo json_encode("Username does not exists, Please enter a valid username.");
			}

		}
		else
		{
			echo "false";
		}

	}

	public function usernamesearch()
	{
		$this->render = 0;
		$username = strip_tags(trim($_POST['username']));

		$searchquery = $this->Profile->searchUsername($username);
		if(empty($searchquery))
		{
			echo '<div class="show" align="left">

				<span class="name error">No Result found!</span> <br/>

			</div>';
		}
		else
		{
			foreach ($searchquery as $search)
			{
				$name = ($search['name']) ? $search['name'] : $search['name1'];
				echo '<div class="show">

					<span class="name">' . $search['username'] . '</span> ';

				if($name) echo "<i>(".$name.")</i>";
				echo '<p style="visibility: hidden;" class="id">'.$search['id'].'</p>

				</div>';
			}

		}
	}


	public function addarticleform()
	{
		error_reporting(E_ALL);
		$this->render = 0;
		$img = $_POST['image-data'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $result = $this->Profile->addArticle($_POST, $data);
        if($result)
        {
        	echo json_encode(TRUE);
        }
        else echo json_encode(FALSE);
	}

	public function addfocus()
	{
		$this->render = 0;
		if($_POST)
		{
			$type = $_POST['type'];
			$selectid = $_POST['selectid'];
			$result = $this->Profile-> getallfocus($type);

			$allfocus ='';
			$mainfocus='<option value="">None</option>';

			foreach ($result as $key => $focus)
			{
				if($focus['parentid'] == NULL)
				{
					$mainfocus .= '<option value="'.$focus['focusid'].'">'.$focus['focus'].'</option>';
				}

				$allfocus .= '<option value="'.$focus['focus'].'">';
			}

			echo json_encode(array("allfocus" => $allfocus, "mainfocus" => $mainfocus));
		}

	}

	public function addfocusform()
	{
		$this->render =0;
		$result = $this->Profile->addfocustodb($_POST);
		echo $result;

	}

	public function checkusername()
	{
		$this->render =0;
		if($_POST)
		{
			$username = htmlspecialchars(strip_tags($_POST['username']));
			$oldusername = htmlspecialchars(strip_tags($_POST['oldusername']));
			$get = new Getdata();

			if(preg_match("/^[0-9a-zA-Z_]{5,}$/", $username) == false)
		    {
		     echo json_encode('Username should contain only letters, number and underscore.');
		    }
		    elseif((strtolower(trim($username)) != strtolower(trim($oldusername))) && ($get->usernameExist($username) != 0))
		    {

		       echo json_encode('Sorry! \''. $username . '\' is already in use!');
		    }
		    else echo "true";

		}
		else echo "false";
	}

	public function checkemail()
	{
		$this->render =0;
		if($_POST)
		{
			$email = htmlspecialchars(strip_tags($_POST['email']));
			$oldemail = htmlspecialchars(strip_tags($_POST['oldemail']));
			$get = new Getdata();


			if((strtolower(trim($email)) != strtolower(trim($oldemail))) && ($get->emailExist($email) != 0))
			{

				echo json_encode('Sorry! \''. htmlspecialchars($email) . '\' is already in use!');

			}
			else echo "true";
		}
		else echo "false";
	}

	public function getrecommendname()
	{

		$this->render = 0;
		$result = $this->Profile->getRecommendations($_POST);
		if(count(array_filter($result, 'is_array')) == 2)
			$name = implode(', ', array_map(function ($entry) {
					  return $entry[0];
					}, $result));
		else
			$name = implode(',', $result[0]);

		echo $name;

	}


	public function updateprofprofile()
	{
		$this->render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$validation = new Valitron\Validator($_POST);
			$validation->rules([
				'required'=> ['mainfocus','email','username','language','about','name','since','formattedaddress'],
				'email' => ['email'],
				'numeric'=>['phone'],
				'slug'=>['username'],
				'dateFormat'=>[['since','d/m/Y']],
				'dateBefore' => [['since', date('Y-m-d', time())]],
				'lengthBetween' => [
			        ['username', 5, 50],
							['about', 200, 20000],
							['name', 3, 50]
			    ],
					'regex'=>[['name', '/^[A-Za-z]+(\s+[A-Za-z]+)*$/']],
					'notIn' => [
						['profsettingsMainfocus',['default']]
			    ],
			]);
			$validation->rule('regex','language','/^[A-Za-z\s]+(\,+[A-Za-z\s]+)*$/')->message('Please enter valid language name, with commas in between. Special character not allowed'); //alphacomma
			$validation->rule(function($field, $value, $params, $fields) {
				$n = explode(',',$value);
		    return (sizeof($n) <= 3);
			}, "recommendname")->message("Maximum 3 recommendation allowed");

			$validation->rule(function($field,$value,$params,$fields){
					if($value[0] != "")
						if($value[0] == $value[1] || $value[0] == $value[2] || $value[0] == $_SESSION['id']) return false;
					if($value[1] != "")
						if($value[0] == $value[1] || $value[1] == $value[2] || $value[1] == $_SESSION['id']) return false;
					if($value[2] != "")
						if($value[2] == $value[1] || $value[0] == $value[2] || $value[2] == $_SESSION['id']) return false;
					return true;
			},'recommendids')->message("Please check your recommendations. Recommendation cannot be repeated. You cannot recommend yourself");

			$validation->rule('notIn',['username','name'],  ['kniew', 'kniew.com', 'admin', 'adminstrator', 'administrator', 'user', 'lawyer', 'doctor', 'ngo', 'ca', 'charteredaccountant', 'chartered_accountant'])->message('Please enter a valid name, reserved words not allowed');


			$validation->labels(array(
			    'mainfocus' => 'Specialisation',
					'otherfocus[]'=>'Other specialisation',
					'since' => 'Practising since',
					'about' => 'About you',
					'phone' => 'Phone Number ',
					'recommendids' => 'Registered user recommendation ',
					'formattedAddress' => 'Your work location '
			));
			if($validation->validate())
			{
				$config = HTMLPurifier_Config::createDefault();
				$purifier = new HTMLPurifier($config);
				$about = $purifier->purify($_POST['about']);
				// $about = htmlspecialchars($about_purified);
				$_POST['about'] = $about;
				$result = $this->Profile->updateProfessional($_POST);
				if(!empty($result))
				{
					session_start();
					$_SESSION['username'] = $_POST['username'];
					if(isset($_POST['profilepic'])) $_SESSION['profilepic'] = $_POST['profilepic'];
					$_SESSION['email'] = $_POST['email'];
					$returndata['result'] = '<p class="profresult greentext">Data Updated Successfuly!</p>';
				}
				else
				{
					$returndata['result'] = '<p class="profresult greentext">Error occured, please check your data and try again.</p>';
				}
			}
			else {
				$errors = $validation->errors();
				$errorshtml = '<ul class="profresult error listnone"><li>*';
				$errorshtml .= implode( '.</li><li>*', array_filter(array_map(function($e){
         return implode(".</li><li>*", array_filter($e));
			 	}, $errors)));
				$errorshtml .= '.</li></ul>';
				$returndata['result'] = $errorshtml;

			}
		}
		else
		{
			$returndata['result'] = "<p class='profresult error'>Problem with request. Please try again.";
		}
		echo json_encode($returndata);
	}
	public function updateuserprofile()
	{
		$this->render = 0;
		$result = $this->Profile->updateUsernormal($_POST);
		if(!empty($result))
		{
			session_start();
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['profilepic'] = $_POST['userdetails']['profilepic'];
			$_SESSION['email'] = $_POST['email'];
		}
		echo $result;
	}

	public function changepassword()
	{
		$this->render = 0;
		$password = htmlspecialchars(strip_tags($_POST['newpassword']));
		$id = (int)(strip_tags($_POST['id']));
		$result = $this->Profile->modifypassword($id, $password);
		echo $result;
	}

	public function paymentsmade()
	{
		$this->render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$page = $_POST['page'] ? $_POST['page'] : 1;
			$perPage = 10;
			$returnHtml = '';


			$result = $this->Profile->getPaymentsMade($page, $perPage);
			if(!empty($result))
			{
				if($page == 1) $returnHtml = '
					<div class="row lightgreyback boldtext padding2per centertext">
						<div class="col-xs-4">Paid to</div>
						<div class="col-xs-4">Amount</div>
						<div class="col-xs-4">Status</div>
					</div>
				';
				$payment = new PaymentController('payment');
				foreach ($result as $key => $transaction)
				{
					$userurl;
					$userlink;
					$paymentdetails;
					$paymenthtml;
					$closedhtml;

					//USER LINK
					if($transaction['usertype'] == 1)
					{
						$userurl = BASE_PATH . 'user/' . $transaction['username'];
					}
					else if($transaction['usertype'] == 2 || $transaction['usertype'] == 3 || $transaction['usertype'] == 4 || $transaction['usertype'] == 5)
					{
						$typename='';
						if($transaction['usertype'] == 3) { $typename = 'Lawyers';}
						elseif($transaction['usertype'] == 4) { $typename = 'Doctors';}
						else if($transaction['usertype'] == 5) { $typename = 'charteredaccountants';}
						else if($transaction['usertype'] == 2) { $typename = 'NGO';}
						$userurl = BASE_PATH . 'professionals/'. $typename . '/' . $transaction['username'];
					}
					$userlink = "<a href='" .$userurl."'> ".$transaction['username']."</a>";

					if($transaction['paymentid'])
					{
						$paymentdetails = $payment->razorpaygetbypaymentid($transaction['paymentid']);
						$captured = $paymentdetails['captured'] ? 'captured' : 'not captured';
						$paymenthtml = '<p><i class="fa fa-inr smallertext" aria-hidden="true"></i> '.($paymentdetails['amount']/100).'</p><p class="xsmalltext greytext">Paid on '.date('d/m/Y', $paymentdetails['created_at']).', '.$captured.'.</p>';
					}
					else $paymenthtml = "<b>not paid</b>";
					if($transaction['closedby'] != NULL)
					{
						$closedon = new DateTime($transaction['closedon']);

						if($transaction['closedby'] == $_SESSION['id'])
						{
							$closedhtml = '<p><span class="label label-danger">closed</span></p><p class="xsmalltext greytext">Closed by you on '. $closedon->format('d/m/Y').'.</p>';
						}
						else if($transaction['closedby'] == $transaction['userid'])
						{
							$closedhtml = '<p><span class="label label-danger">closed</span></p><p class="xsmalltext greytext">Closed by '.$username.' on '.$closedon->format('d/m/Y').'.</p>';
						}
						else
						{
							$closedhtml = '<p><span class="label label-danger">closed</span></p><p class="xsmalltext greytext">Closed on '.$closedon->format('d/m/Y').'.</p>';
						}
					}
					else
					{
						$closedhtml ='<p> <span class="label label-success">Open</span></p>';

					}

					$returnHtml .= '
						<div class="row padding2per whitesmokeBack lightgreybottomborder centertext">
							<div class="col-xs-4">'.$userlink.'</div>
							<div class="col-xs-4">'.$paymenthtml.'</div>
							<div class="col-xs-4">'.$closedhtml.'</div>
						</div>
					';

				}
				echo $returnHtml;
			}
			else echo 0;
		}
		else  echo '<div class="error">Error in request sent! Please try again!</div>';
	}

	public function paymentsrecieved()
	{
		$this->render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$page = $_POST['page'] ? $_POST['page'] : 1;
			$perPage = 10;
			$returnHtml = '';

			$result = $this->Profile->getPaymentsReceived($page, $perPage);
			if(!empty($result))
			{
				if($page == 1) $returnHtml = '
					<div class="row lightgreyback boldtext padding2per centertext">
						<div class="col-xs-4">Paid to</div>
						<div class="col-xs-4">Amount</div>
						<div class="col-xs-4">Status</div>
					</div>
				';
				$payment = new PaymentController('payment');
				foreach ($result as $key => $transaction)
				{
					$userurl;
					$userlink;
					$transferdetails;
					$paymentdetails;
					$transferhtml;
					$closedhtml;

					//USER LINK
					if($transaction['usertype'] == 1)
					{
						$userurl = BASE_PATH . 'user/' . $transaction['username'];
					}
					else if($transaction['usertype'] == 2 || $transaction['usertype'] == 3 || $transaction['usertype'] == 4 || $transaction['usertype'] == 5)
					{
						$typename='';
						if($transaction['usertype'] == 3) { $typename = 'Lawyers';}
						elseif($transaction['usertype'] == 4) { $typename = 'Doctors';}
						else if($transaction['usertype'] == 5) { $typename = 'charteredaccountants';}
						else if($transaction['usertype'] == 2) { $typename = 'NGO';}
						$userurl = BASE_PATH . 'professionals/'. $typename . '/' . $transaction['username'];
					}
					$userlink = "<a href='" .$userurl."'> ".$transaction['username']."</a>";

					if($transaction['paymentid'])
					{
						$paymentdetails = $payment->razorpaygetbypaymentid($transaction['paymentid']);
						$captured = $paymentdetails['captured'] ? 'captured' : 'not captured';

						$transferdetails = $payment->razorpaygettransfer($transaction['paymentid']);
						$transferhtml = '<p><i class="fa fa-inr smallertext " aria-hidden="true"></i> '.($transferdetails['items'][0]['amount']/100).'</p><span class="xsmalltext greytext"><b>Total</b> <i class="fa fa-inr smallertext" aria-hidden="true"></i> '.($paymentdetails['amount']/100).',<br/><b>Razorpay Fee</b> <i class="fa fa-inr smallertext" aria-hidden="true"></i> '.($paymentdetails['fee']/100).'.<br/>Paid on '.date('d/m/Y', $transferdetails['items'][0]['created_at']).', '.$captured.'.<br/>Processed on '.date('d/m/Y', $transferdetails['items'][0]['processed_at']).'.</span>';
					}
					else $transferhtml = "<b>not paid</b>";
					if($transaction['closedby'] != NULL)
					{
						$closedon = new DateTime($transaction['closedon']);

						if($transaction['closedby'] == $_SESSION['id'])
						{
							$closedhtml = '<p><span class="label label-danger">closed</span></p><p class="xsmalltext greytext">Closed by you on '. $closedon->format('d/m/Y').'.</p>';
						}
						else if($transaction['closedby'] == $transaction['userid'])
						{
							$closedhtml = '<p><span class="label label-danger">closed</span></p><p class="xsmalltext greytext">Closed by '.$username.' on '.$closedon->format('d/m/Y').'.</p>';
						}
						else
						{
							$closedhtml = '<p><span class="label label-danger">closed</span></p><p class="xsmalltext greytext">Closed on '.$closedon->format('d/m/Y').'.</p>';
						}
					}
					else
					{
						$closedhtml ='<p> <span class="label label-success">Open</span></p>';

					}

					$returnHtml .= '
						<div class="row padding2per whitesmokeBack lightgreybottomborder centertext">
							<div class="col-xs-4">'.$userlink.'</div>
							<div class="col-xs-4">'.$transferhtml.'</div>
							<div class="col-xs-4">'.$closedhtml.'</div>
						</div>
					';

				}
				echo $returnHtml;
			}
			else echo 0;
		}
		else echo '<div class="error">Error in request sent! Please try again!</div>';
	}

	public function donationsmade()
	{
		$this->render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$page = $_POST['page'] ? $_POST['page'] : 1;
			$perPage = 10;
			$returnHtml = '';


			$result = $this->Profile->getDonationsMade($page, $perPage);
			if(!empty($result))
			{
				$loggedname = $_SESSION['name'] ? $_SESSION['name'] : $_SESSION['username'];
				if($page == 1) $returnHtml = '
					<div class="row lightgreyback boldtext padding2per centertext">
						<div class="col-xs-4">Donated to</div>
						<div class="col-xs-4">Message</div>
						<div class="col-xs-4">Status</div>
					</div>
				';
				$payment = new PaymentController('payment');
				foreach ($result as $key => $transaction)
				{
					$userlink;
					$paymentdetails;
					$paymenthtml;
					$closedhtml;

					$userlink = "<a href='" .BASE_PATH."/NGO/.".$transaction['username']."'> ".$transaction['username']."</a>";

					if($transaction['paymentid'])
					{
						$paymentdetails = $payment->razorpaygetbypaymentid($transaction['paymentid']);
						$captured = $paymentdetails['captured'] ? 'captured' : 'not captured';
						$paymenthtml = '<p><i class="fa fa-inr smallertext" aria-hidden="true"></i> '.($paymentdetails['amount']/100).'</p><p class="xsmalltext greytext">Paid on '.date('d/m/Y', $paymentdetails['created_at']).', '.$captured.'.</p>';
					}
					else
					{
						$orderhtml = '';
						if($transaction['orderid'])
						{
							$paymentdetails = $payment->razorpaygetbyorderid($transaction['orderid']);
							// echo "<pre>"; print_r($paymentdetails); echo "</pre>";
							$orderhtml = '<p class="xsmalltext greytext"><i class="fa fa-inr smallertext " aria-hidden="true"></i> '.($paymentdetails['amount']/100).', '.date('d/m/Y', $paymentdetails['created_at']).', '.$paymentdetails['status']. '</p>';
						}
						$paymenthtml = "<button id='pendingdonation' class='btn btn-danger btn-xs normalwhitespace xsmalltext' data-loggedname='".$loggedname."' data-loggedemail='".$_SESSION['email']."' data-orderid='".$transaction['orderid']."' data-donationid='".$transaction['donationid']."' data-paidto='".$transaction['paidto']."'><i class='fa fa-heart hidden-xs'></i> Donate Now</button>".$orderhtml;
					}

					$note = $transaction['note'] ? $transaction['note'] : '-';


					$returnHtml .= '
						<div class="row padding2per whitesmokeBack lightgreybottomborder centertext">
							<div class="col-xs-4">'.$userlink.'</div>
							<div class="col-xs-4 textalignjustify">'.$note.'</div>
							<div class="col-xs-4">'.$paymenthtml.'</div>
						</div>
					';

				}
				echo $returnHtml;
			}
			else echo 0;
		}
		else  echo '<div class="error">Error in request sent! Please try again!</div>';
	}

	public function donationsrecieved()
	{
		$this->render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$page = $_POST['page'] ? $_POST['page'] : 1;
			$perPage = 10;
			$returnHtml = '';

			$result = $this->Profile->getDonationsReceived($page, $perPage);
			if(!empty($result))
			{
				if($page == 1) $returnHtml = '
					<div class="row lightgreyback boldtext padding2per centertext">
						<div class="col-xs-4">Donated By</div>
						<div class="col-xs-4">Message</div>
						<div class="col-xs-4">Status</div>
					</div>
				';
				$payment = new PaymentController('payment');
				foreach ($result as $key => $transaction)
				{
					$userurl;
					$userlink;
					$transferdetails;
					$paymentdetails;
					$transferhtml;
					$closedhtml;

					//USER LINK
					if($transaction['usertype'] == 1)
					{
						$userurl = BASE_PATH . 'user/' . $transaction['username'];
					}
					else if($transaction['usertype'] == 2 || $transaction['usertype'] == 3 || $transaction['usertype'] == 4 || $transaction['usertype'] == 5)
					{
						$typename='';
						if($transaction['usertype'] == 3) { $typename = 'Lawyers';}
						elseif($transaction['usertype'] == 4) { $typename = 'Doctors';}
						else if($transaction['usertype'] == 5) { $typename = 'charteredaccountants';}
						else if($transaction['usertype'] == 2) { $typename = 'NGO';}
						$userurl = BASE_PATH . 'professionals/'. $typename . '/' . $transaction['username'];
					}
					$userlink = "<a href='" .$userurl."'> ".$transaction['username']."</a>";

					if($transaction['paymentid'])
					{
						$paymentdetails = $payment->razorpaygetbypaymentid($transaction['paymentid']);
						$captured = $paymentdetails['captured'] ? 'captured' : 'not captured';

						$transferdetails = $payment->razorpaygettransfer($transaction['paymentid']);
						$transferhtml = '<p><i class="fa fa-inr smallertext " aria-hidden="true"></i> '.($transferdetails['items'][0]['amount']/100).'</p><span class="xsmalltext greytext"><b>Total</b> <i class="fa fa-inr smallertext" aria-hidden="true"></i> '.($paymentdetails['amount']/100).',<br/><b>Razorpay Fee</b> <i class="fa fa-inr smallertext" aria-hidden="true"></i> '.($paymentdetails['fee']/100).'.<br/>Paid on '.date('d/m/Y', $transferdetails['items'][0]['created_at']).', '.$captured.'.<br/>Processed on '.date('d/m/Y', $transferdetails['items'][0]['processed_at']).'.</span>';
					}
					else if($transaction['orderid'])
					{
						$paymentdetails = $payment->razorpaygetbyorderid($transaction['orderid']);
						$transferhtml = '<p class="error"><i class="fa fa-inr smallertext " aria-hidden="true"></i> '.($paymentdetails['amount']/100).'</p><p  class="xsmalltext greytext">'.date('d/m/Y', $paymentdetails['created_at']).', '.$paymentdetails['status'].', not paid.</p>';

					}
					else $transferhtml = "<b>not paid</b>";

					$note = $transaction['note'] ? $transaction['note'] : '-';


					$returnHtml .= '
						<div class="row padding2per whitesmokeBack lightgreybottomborder centertext">
							<div class="col-xs-4">'.$userlink.'</div>
							<div class="col-xs-4 textalignjustify">'.$note.'</div>
							<div class="col-xs-4">'.$transferhtml.'</div>
						</div>
					';

				}
				echo $returnHtml;
			}
			else echo 0;
		}
		else echo '<div class="error">Error in request sent! Please try again!</div>';
	}

	public function bookedappointments()
	{
		$this->render = 0;
		$page = $_POST['page'] ? $_POST['page'] : 1;
		$result = $this->Profile->getAppointmentByID($page);
		$returnHtml = '';

		if(!empty($result))
		{
			foreach ($result as $key => $appointment)
			{
				if($appointment['usertype'] == 5) $type = 'charteredaccountants';
				else if($appointment['usertype'] == 4) $type = 'doctors';
				else if($appointment['usertype'] == 3) $type = 'lawyers';
				else if($appointment['usertype'] == 2) $type = 'ngo';

				$returnHtml .= '<div class ="thumbnail row">
								<h3 class="col-sm-12">'. $appointment['professional'] . '</h3>
								<div class="col-sm-8">
								<p class="smalltext greytext">' . $appointment['user'] . '<br/>' . $appointment['appointemail'];
				if(!empty($appointment['phone']))	$returnHtml .= ' (' . $appointment['phone'] .') ';
				$returnHtml .= '<br/>';
				if($appointment['appointmenttype'] == 'normalappointment')
				{
					$returnHtml .= 'On ' . date('F d, Y h:i A', strtotime($appointment['appointmentdatetime']));
					$returnHtml .= '</p></div> <div class="col-sm-4">';
					if(strtotime($appointment['appointmentdatetime']) > strtotime(date("Y-m-d H:i:s"))) $returnHtml .=	'<button class="btn btn-danger col-sm-5 cancelappointment" data-appointmentid="'.$appointment['appointmentid'] .'" data-appointmenttype="'.$appointment['appointmenttype'].'" data-appointmentdatetime="'.$appointment['appointmentdatetime'].'">Cancel</button>';
					else $returnHtml .=  '<button class="btn btn-secondary disabled col-sm-5" aria-disabled="true" disabled>Cancel</button>';
				}
				else if($appointment['appointmenttype'] = 'weeklyappointment')
				{
					$returnHtml .= 'From ' .date('F d, Y', strtotime($appointment['appointmentdatetime'])).' till ' . date('F d, Y', strtotime($appointment['appointmentend'])) . ' every ' . date('l', strtotime($appointment['appointmentdatetime'])) . ' at ' . date('h:i A', strtotime($appointment['appointmentdatetime']));
					$returnHtml .= '</p></div> <div class="col-sm-4">';
					if(strtotime($appointment['appointmentend']) > strtotime(date("Y-m-d H:i:s"))) $returnHtml .=	'<button class="btn btn-danger col-sm-5 cancelappointment" data-appointmentid="'.$appointment['appointmentid'] .'" data-appointmenttype="'.$appointment['appointmenttype'].'" data-appointmentdatetime="'.$appointment['appointmentdatetime'].'">Cancel</button>';
					else $returnHtml .=  '<button class="btn btn-secondary disabled col-sm-5" aria-disabled="true" disabled>Cancel</button>';
				}

				$returnHtml .= '<a class="btn btn-success col-sm-6" href="' .
								BASE_PATH . 'professionals/' . $type . '/' . $appointment['username'] .
								'"> Book another</a></div>
								</div>';
			}
			echo $returnHtml;
		}
		else echo 0;


	}

	public function cancelappointmentbyuser()
	{
		$this->render = 0;
		if($_POST)
		{
			$appointmentid = $_POST['appointmentid'];
			$type= $_POST['type'];
			$appointmentdatetime = $_POST['appointmentdatetime'];
			$reason = filter_var($_POST['reason'], FILTER_SANITIZE_STRING);
			$result = $this->Profile->deleteappointmentbyuser($appointmentid, $type, $appointmentdatetime, $reason);
			echo $result;
		}
	}

	public function cancelsingleweeklybyuser()
	{
		$this->render = 0;
		if($_POST)
		{
			$appointmentid = $_POST['appointmentid'];
			$appointmentdatetime = $_POST['appointmentdatetime'];
			$reason = filter_var($_POST['reason'], FILTER_SANITIZE_STRING);
			$result = $this->Profile->modifyweeklyappointmentbyuser($appointmentid, $appointmentdatetime, $reason);
			echo $result;
		}
	}

	public function sendemail()
	{
		$this->render = 0;
		$type = $_POST['sendto'];
		$users = $this->Profile->getUsernameEmailByType($type);

		$send = new sendEmail();
		if(!empty($users))
		{
			foreach ($users as $key => $user)
			{
				$send->email($user['email'], strip_tags($_POST['subject']), "<p>Hello " . $user['username']. ", </p><p></p><p></p><p>" . $_POST['content'] . "</p><p></p><p></p>");
			}
			echo 1;

		}
	}

	public function deleteprofpic()
	{
		$this->render = 0;
		$id = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);
		echo $this->Profile->removeProfPic($id);
	}

	public function deleteuserpic()
	{
		$this->render = 0;
		$id = filter_var($_SESSION['id'], FILTER_VALIDATE_INT);
		echo $this->Profile->removeUserPic($id);
	}

	public function changeVerificationId()
	{
		$this->render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' && $_POST['verificationid'] != null)
		{
			$isvalid;
			$exp;
			$returnmessage =[];
			$returnmessage['status'] = 0;

			if($_SESSION['usertype'] == 3 || $_SESSION['usertype'] == 2) $exp = '/^[a-zA-Z]{2}\/\\d{1,}\/\d{1,}$/';
			else if($_SESSION['usertype'] == 5) $exp = "/^\d{6}$/";
			else $exp = "/^.+$/";

			if(preg_match($exp, $_POST['verificationid']))
			{
				$verificationid = strtoupper(htmlspecialchars(strip_tags($_POST['verificationid'])));
				if($this->Profile->updateverificationid($verificationid))
				{
					$returnmessage['msg'] = "Successfully changed! Please reload to see change.";
					$returnmessage['status'] = 1;
				}
				else $returnmessage['msg'] = "Something went wrong! Please try again.";
			}
			else {
				$returnmessage['msg'] = 'Incorrect registration number, please make sure you check and add only registered number';
			}
			echo json_encode($returnmessage);

		}
	}

	public function getauthenticateprof()
	{
		$this->render = 0;
		$returnHtml = '';
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' && isadmin() == true)
		{
			$page = (int)$_POST['page'];
			$nullAuthenticatedProf = $this->Profile->getNullAuthenticatedProf($page, (int)$_POST['perPage']);
			if(!empty($nullAuthenticatedProf))
			{
				$isactive = '';
				if($page == 1) $isactive = ' active ';

				foreach ($nullAuthenticatedProf as $key => $prof)
				{
					$img ='';
					$verifyText = '';
					$linktoprof = '';
					$encryptkey = 'idFromAuthenticateProfessional_' . $prof['email'] ;
					$id = Crypto::encrypt($prof['id'], $encryptkey, TRUE);


					if(!empty($prof['profilepic'])) $img='<img src="'.BASE_PATH .$prof['profilepic'].'" alt="'.$prof['name'].'" />';
					else $img= '<div class=" imagecontainer"><i class="fa fa-user imagetext"></i></div>';

					if($prof['usertype'] == 2)
					{
						$linktoprof  = '<a class="xsmalltext" href="'.BASE_PATH . 'professionals/ngo/' . $prof['username'] .'" target = "_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Open Profile</span></i></a>';
						$verifyText = '<b>Unique ID with NGO-DARPAN</b><p class="largetext"><span id="verificationid">'. $prof['verificationid'] . '</span> <a id="toVerifySite" href="http://ngodarpan.gov.in/index.php/search/" target="_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Verify on NGO Darpan</span></i></a></p>';
					}
					else if($prof['usertype'] == 3)
					{
						$linktoprof  = '<a class="xsmalltext" href="'.BASE_PATH . 'professionals/lawyers/' . $prof['username'] .'" target = "_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Open Profile</span></i></a>';
						$verifyText ='<b>Bar Council of India Registeration Number</b><p class="largetext"><span id="verificationid">'. $prof['verificationid'] . '</span><a id="stateBCI" href="#"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Verify on State Bar Council Site</span></i></a></p> ';
					}
					else if($prof['usertype'] == 4)
					{
						$linktoprof  = '<a class="xsmalltext" href="'.BASE_PATH . 'professionals/doctors/' . $prof['username'] .'" target = "_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Open Profile</span></i></a>';
						$verifyText ='<b>Medical Council India, Registration number</b> <p class="largetext"><span id="verificationid">'. $prof['verificationid'] . '</span> <a id="toVerifySite" href="https://www.mciindia.org/CMS/information-desk/indian-medical-register" target="_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true"><span class="tooltip">Verify on Indian Medical Register</span></i></a></p>';
					}
					else if($prof['usertype'] == 5)
					{
						$linktoprof  = '<a class="xsmalltext" href="'.BASE_PATH . 'professionals/charteredaccountants/' . $prof['username'] .'" target = "_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Open Profile</span></i></a>';
						$verifyText ='<b>ICAI member registeration number</b><p class="largetext"><span id="verificationid">'. $prof['verificationid'] . '</span> <a id="toVerifySite" href="https://www.icai.org/traceamember.html" target="_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true"><span class="tooltip">Verify on ICAI website</span></i></a></p>';
					}

					if($key == 0)$returnHtml .= '<div class=" item '.$isactive.'"><div>';
					else $returnHtml .= '<div class="item"><div class="lazyload"><!--';
					$returnHtml .= '
						<div class="whiteTransBack roundcorners5per padding2per row">
						<div class="col-xs-12 centertext">'.$verifyText.'</div>
						<div class="col-xs-12 col-sm-4 imgdiv">'.$img.'</div>
						<div class="col-xs-12 col-sm-8 detailsdiv">
							<div class="lightgreenbottomborder"><h3 class="displayinline limegreentext">'.$prof['name'].'</h3> '.$linktoprof.'</div>
							<p class="xsmalltext"><i>Since</i> '. date('d F Y', strtotime($prof['since'])).' </p>
							<div class="row"><p class="detailsLabel smallertext col-xs-4">Phone</p><p class="col-xs-8"> ';
					$returnHtml .= $prof['phone'] ? $prof['phone'] : '-';
					$returnHtml .= '</p></div>
							<div class="row"><p class="detailsLabel smallertext col-xs-4">Email</p><p class="col-xs-8">'.$prof['email'].'</p></div>
							<div class="row"><p class="detailsLabel smallertext col-xs-4">Main Specialisation</p><p class="col-xs-8">'.$prof['mainfocus'].'</p></div>
							';

							if($prof['otherfocus'] != null && $prof['otherfocus'] != 'NULL' && $prof['otherfocus'] != '{}' && $prof['otherfocus'] != '{null}' && $prof['otherfocus'] != '{NULL}' && !empty($prof['otherfocus']))
							{
								$returnHtml .='<div class="row"><p class="detailsLabel smallertext col-xs-4">Other specialisation </p><p class="col-xs-8">'. str_replace(array('\'', '"', '{', '}'), " ", $prof['otherfocus']).'</p></div>';
							}
					$returnHtml .= '
							<div class="row"><p  class="detailsLabel smallertext col-xs-4">Jurisdiction</p><p class="col-xs-8"> '.str_replace(array('\'', '"', '{', '}'), "", $prof['jurisdiction']).'</p></div>
							<div class="row"><p  class="detailsLabel smallertext col-xs-4">Address</p><p class="col-xs-8"> '.ucwords(htmlspecialchars_decode($prof['formattedaddress'])).'</p></div>
							<div class="row"><p class="col-xs-12"><button class="btn btn-primary btn-xs clarifyDetails" data-email="'.$prof['email'].'" data-name="'.$prof['name'].'">Clarify Details <i class="fa fa-paper-plane"></i></button></p></div>
						</div>';
					$returnHtml .= '
						<div class="col-xs-12">
							<h5 class="lightgreybottomborder boldtext">About</h5>
							<div class="smallerabout">'.html_entity_decode(htmlspecialchars_decode($prof['about'], ENT_QUOTES)).'</div>
						</div>
						<div class="row"><button data-id="'.$id.'" data-name="'.$prof['name'].'" data-email="'.$prof['email'].'" class="btn btn-info cadetblueBack col-xs-12 submitauthprof"><i class="fa fa-square-check-o"></i>Authenticate Professional</button></div>
						<div class="row margintop1per"><button data-id="'.$id.'" data-name="'.$prof['name'].'" data-email="'.$prof['email'].'" class="btn btn-danger fail col-xs-12 submitunauthorizeprof"><i class="fa fa-square-check-o"></i>Unauthorize Professional</button></div>
						';


					$returnHtml .='</div>';
					if($key == 0) $returnHtml .= '</div></div>';
					else $returnHtml .= '--></div></div>';
				}

				if($page == 1)
				{
					include(ROOT . DS . 'application' . DS . 'views' . DS . 'widgets'.DS . 'barcouncillink.php');
					$sendEmailTitle = '<h3>Ask for Any further explaination from Professional</h3>';
					$addToSubject = 'Authentication Pending, futher clarification required : ';
					$subjectPlaceholder = 'Eg - education details';
					$emailLabel = 'Please ask any further clarification required from user';
					$sendEmailModalId = 'clarifyDetailsEmailForm';
					$addToEmail = '
						<div class="lineheight2 textalignjustify">
							<p>Hello <span id="addNameDynamically"></span>,</p>
							<p>Thank you for choosing  '.WEBNAME.'. We strive to provide our users with best and authenticated professionals. On further analysis of your profile we need some clarification required to authenticate your profile. Please provide details (if possible, in bullet points) for the following query.</p>
						</div>';
					$addToImpinfo = ' Please just add the clarification needed.';
					include(ROOT . DS . 'application' . DS . 'views' . DS . 'widgets'.DS . 'sendemailmodal.php');
				}

				echo $returnHtml;
			}
		}
	}

	public function clarifydetailssend()
	{
		$this->render = 0;
		$returndata= array();
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$validation = new Valitron\Validator($_POST);
			$validation->rules([
				'required'=> ['subject','content'],
				'lengthMin' => [
					['subject', 5],
					['content', 10],
				],
				'regex' =>[['subject', '/^[A-Za-z]+(\s+[A-Za-z]+)*$/']]
			]);
			$validation->rule('required', 'sendto')->message('User\'s email cannot be retrieved');
			$validation->rule('required', 'name')->message('User\'s name cannot be retrieved');
			$validation->rule('email', 'sendto')->message('User\'s email not in correct format');
			$validation->rule('regex', 'name', '/^[A-Za-z]+(\s+[A-Za-z]+)*$/')->message('Incorrect user\'s name');
			if($validation->validate())
			{

				$emailcontent = '
					<p>Hello '.$_POST['name'].',</p>
					<p></p>
					<p>Thank you for choosing  '.WEBNAME.'. We strive to provide our users with best and authenticated professionals. On further analysis of your profile we need some clarification required to authenticate your profile. Please provide details (if possible, in bullet points) for the following query.</p>
				  <p></p><p>' . strip_tags(nl2br($_POST['content'])) . '</p><p></p><p>--'.WEBNAME.'</p>';
					$send =new sendEmail();
					if($send->email($_POST['sendto'], strip_tags($_POST['subject']), $emailcontent, AUTHENTICATE_EMAIL)) $returndata['success'] = 'Email Sent!';
					else $returndata['error'] = '<b class="error"> Problem sending!</b>';
					$returndata['success'] = 'Sending....';
			}
			else if($errors = $validation->errors())
			{
				$errorshtml = '<ul class="error listnone"><li>*';
				$errorshtml .= implode( '.</li><li>*', array_filter(array_map(function($e){
         return implode(".</li><li>*", array_filter($e));
			 }, $errors)));
				$errorshtml .= '.</li></ul>';
				$returndata['error'] = $errorshtml;
			}

		}
		else
		{
			$returndata['error'] = '<span class="error">*Form submission not secure.</span>';
		}

		echo json_encode($returndata);


	}

	public function confirmauthenticateprofessional()
	{
		$this->render = 0;
		$returndata= array();
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' && strtolower($_POST['confirmauthenticate']  == 'confirm'))
		{
			//check if logged in adminstrator
			if(isadmin())
			{
				//decrypt id
				$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
				$encryptkey = 'idFromAuthenticateProfessional_' . $email ;
				$professionalid =	Crypto::decrypt($_POST['id'], $encryptkey , true);
				if($this->Profile->SetAuthenticateProfessionalTrue((int)$professionalid))
				{
					$send =new sendEmail();
					$content = '<p>Hello '.$name.',</p><p></p><p>Your account has now been authenticated. You can now add a payment account by going to settings, and start connecting to and receiving payments from users.</p>
				  <p></p><p>Happy to serve. Don\'t hesistate to contact us with any queries.</p><p></p><p>--'.WEBNAME.'</p>';
					$send->email($email, "Congrats! Account authenticated! Connect with users NOW! ", $content, UPDATES_EMAIL);
					$returndata['success'] = '<div class="whiteTransBack positionAbsolute0Top100Size"><div class="stamp greenstamp">Aunthenticated<div></div>';
				}
				else $returndata['error'] = 'Issue with the server! Please try again later.';
			}
			else
			{
				$returndata['error'] = "Unauthorized Access";
			}
		}
		else
		{
			$returndata['error']='Insecure Data sent to server';
		}
		echo json_encode($returndata);
	}

	public function confirmunauthorizeprofessional()
	{
		$this->render = 0;
		$returndata= array();
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' && strtolower($_POST['confirmunauthorize']  == 'reject'))
		{
			//check if logged in adminstrator
			if(isadmin() && !empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['id']) && !empty($_POST['reason']) )
			{
				//decrypt id
				$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
				$reason = ucfirst(filter_var($_POST['reason'], FILTER_SANITIZE_STRING));
				$encryptkey = 'idFromAuthenticateProfessional_' . $email ;
				$professionalid =	Crypto::decrypt($_POST['id'], $encryptkey , true);
				if($this->Profile->SetAuthenticateProfessionalFalse((int)$professionalid))
				{
					$send =new sendEmail();
					$content = '<p>Hello '.$name.',</p><p></p><p>Your account has now been unauthorized. You cannot connect to users and your profile will no longer be searchable by users. Your account has not been authenticated because:</p>
					<p></p><p><b>'.$reason.'</b></p>
				  <p></p><p>Please go to your settings and verify and rectify your details. If you think there has been a mistake please feel free to contact us.</p><p></p><p>--'.WEBNAME.'</p>';
					$send->email($email, "Account not authenticated! Please verify details. ", $content, UPDATES_EMAIL);
					$returndata['success'] = '<div class="whiteTransBack positionAbsolute0Top100Size"><div class="stamp redstamp">Unauthorized<div></div>';
				}
				else $returndata['error'] = 'Issue with the server! Please try again later.';
			}
			else
			{
				$returndata['error'] = "Unauthorized Access or Missing Data!";
			}
		}
		else
		{
			$returndata['error']='Insecure Data sent to server';
		}
		echo json_encode($returndata);
	}
}
