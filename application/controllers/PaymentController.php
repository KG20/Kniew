<?php
error_reporting(0);
use Razorpay\Api\Api;

class PaymentController extends Controller
{
	function __construct($controller, $action)
	{
		$this->render = 0;
		protectPage();
		parent::__construct($controller, $action);

	}



	public function payfromrporder()
	{
		$returndata =[];
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			// validation
			$orderid;

			if(isset($_POST['threadid'])) $threadid = (int)$_POST['threadid'];
			else if(isset($_POST['donationid']))
			{
				$donationid = (int)$_POST['donationid'];
				$paidto = (int)$_POST['paidto'];
			}

			//check sent orderid and returned is Same
			if(trim(strip_tags($_POST['sentorderid'])) == trim(strip_tags($_POST['returnorderid'])))
			{
				$orderid = filter_var($_POST['returnorderid'], FILTER_SANITIZE_STRING);
			}
			else
			{
				$returndata['error'] = 'Problems with message sent. Please make sure you are paying for right data';
				die(json_encode($returndata));
			}
			$signature = filter_var($_POST['signature'], FILTER_SANITIZE_STRING);
			$paymentid = filter_var($_POST['paymentid'], FILTER_SANITIZE_STRING);


			//authenticate payment
			$api = new Api(RAZORPAY_API_ID, RAZORPAY_API_SECRET);

			try
    {
        $attributes  = array(
					'razorpay_signature'  => $signature,
					'razorpay_payment_id'  =>  $paymentid,
					'razorpay_order_id' => $orderid
				);
        $api->utility->verifyPaymentSignature($attributes);
        $success = true;
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $returndata['error'] = 'Razorpay Error : ' . $e->getMessage();
				die(json_encode($returndata));
    }

			// if authenicated save paymentid and paidby to database and return true else return false
			if($success === true)
			{
				$order  = $api->order->fetch($orderid);
				$payment = $api->payment->fetch($paymentid);
				try
				{
					$payment->capture(array('amount' => $order['amount'], 'currency' => 'INR'));
					$captured = true;
				}
				catch(RazorpayException $e)
		    {
		        $success = false;
		        $returndata['error'] = 'Razorpay Error : ' . $e->getMessage();
						die(json_encode($returndata));
		    }

				if($captured == true)
				{
					if(isset($threadid))
					{
						if($this->Payment->paidForMessage($threadid, $orderid, $paymentid) == $paymentid)
						{
							$returndata['success'] = 'Payment Successful';
							echo json_encode($returndata);
						}
						else
						{
							$returndata['error'] = 'Server error! Something went wrong. Please make sure you are using the right credentials.';
							echo json_encode($returndata);
						}
					}
					else if(isset($donationid))
					{
						if($this->Payment->paidForDonation($donationid, $orderid, $paymentid,$paidto) == $paymentid)
						{
							$returndata['success'] = 'Payment Successful';
							echo json_encode($returndata);
						}
						else
						{
							$returndata['error'] = 'Server error! Something went wrong. Please make sure you are using the right credentials.';
							echo json_encode($returndata);
						}
					}
				}
				else
				{
					$returndata['error'] = 'Problem with capturing payment. payment not authenticated Please try again.';
					die(json_encode($returndata));
				}
			}
			else
			{
				$returndata['error'] = 'Payment failed! Please make sure you are using a secure channel and inputing the right data.';
				die(json_encode($returndata));
			}


		}
		else
		{
			$returndata['error'] = 'Please check your request.';
			die(json_encode($returndata));
		}

	}



	public function createneworder($cost, $receipt,$username, $linkedaccountid, $usernote ='', $percentagekeep = 5)
	{
		 //NOTE: the percentage Kniew keeps for itself, 2.25% +gst OF TOTAL WILL BE KEPT BY RP, and taken from the cut SO DECIDE PERCENTAGE ACC.
		$transfercost = ($cost) * (100-$percentagekeep); //removing 100 cause multiple cost by 100(to convert in paise and then divide by 100 for % )
		// create order
		// echo "receipt = " . $receipt . "<br/> amount = ". $cost*100 . "<br/>account = " . $_SESSION['linkedaccountid']. "<br/>amount = " . $transfercost;
		//
		// $api = new Api(RAZORPAY_API_ID, RAZORPAY_API_SECRET);
		// $order  = $api->order->create(array(
		// 					'receipt' => $receipt,
		// 					'amount' => $cost*100,
		// 					'currency' => 'INR',
		// 					'transfers' => array(
		// 							'account' => $_SESSION['linkedaccountid'],
		// 							'amount' => $transfercost,
		// 							'currency' => 'INR',
		// 					)
		// 					)); // Creates order
		// return $order['id'];

		$notesarray = array('professional' => $_SESSION['username'], 'user' => $username);
		if($usernote != '') $notesarray['usernote'] = $usernote;

		if(strlen($receipt) > 40) $receipt = substr($receipt, 0, 40);

		$data = array (
			'receipt' => (string)$receipt,
		  'amount' => $cost*100,
		  'currency' => 'INR',
		  // 'payment_capture' => 1,
		  'transfers' =>
		  array (
		    0 =>
		    array (
		      'account' => $linkedaccountid,
		      'amount' => $transfercost,
		      'currency' => 'INR',
					'notes'=> $notesarray
		    ),
		  ),
		);
		// Get cURL resource
		$curl = curl_init();
		$header = ['Content-type: application/json'];

		// Set some options - we are passing in a useragent too here
		// <YOUR_KEY_ID>:<YOUR_KEY_SECRET>
		curl_setopt_array($curl, [
				CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
				CURLOPT_POST => 1,
				CURLOPT_HTTPHEADER => $header,
				CURLOPT_POSTFIELDS => json_encode($data),
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_USERPWD => RAZORPAY_API_ID.':'.RAZORPAY_API_SECRET,
		]);
		// curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

		// Send the request & save response to $resp
		$response = curl_exec($curl);
		$resparray = json_decode($response, TRUE);
		// Close request to clear up some resources
		curl_close($curl);
		return $resparray;

	}

	public function razorpaygetbypaymentid($paymentid)
	{
		$api = new Api(RAZORPAY_API_ID, RAZORPAY_API_SECRET);
		if($paymentid)
		{
			$payment = $api->payment->fetch($paymentid);
			return $payment;
		}
		else return NULL;
	}
	public function razorpaygettransfer($paymentid)
	{
		if($paymentid != NULL)
		{
			//fetch acc id from sesssion id from database
			//call api to fetch details
			$curl = curl_init();
			// $header = ['Content-type: application/json'];
			curl_setopt_array($curl, [
					CURLOPT_URL => 'https://api.razorpay.com/v1/payments/'.$paymentid.'/transfers',
					CURLOPT_USERPWD => RAZORPAY_API_ID.':'.RAZORPAY_API_SECRET,
					CURLOPT_RETURNTRANSFER => true,   // return web page
					CURLOPT_HEADER         => false,  // don't return headers
					CURLOPT_FOLLOWLOCATION => true,   // follow redirects
					CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
					CURLOPT_ENCODING       => "",     // handle compressed
					CURLOPT_USERAGENT      => "test", // name of client
					CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
					// CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
					// CURLOPT_TIMEOUT        => 120,    // time-out on response
			]);
			$returndata = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($returndata, TRUE);
			return $result;
		}
		else return NULL;
	}

	public function razorpaygetbyorderid($orderid)
	{
		if($orderid != NULL)
		{
			//fetch acc id from sesssion id from database
			//call api to fetch details
			$curl = curl_init();
			// $header = ['Content-type: application/json'];
			curl_setopt_array($curl, [
					CURLOPT_URL => 'https://api.razorpay.com/v1/orders/' . $orderid,
					CURLOPT_USERPWD => RAZORPAY_API_ID.':'.RAZORPAY_API_SECRET,
					CURLOPT_RETURNTRANSFER => true,   // return web page
					CURLOPT_HEADER         => false,  // don't return headers
					CURLOPT_FOLLOWLOCATION => true,   // follow redirects
					CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
					CURLOPT_ENCODING       => "",     // handle compressed
					CURLOPT_USERAGENT      => "test", // name of client
					CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
					// CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
					// CURLOPT_TIMEOUT        => 120,    // time-out on response
			]);
			$returndata = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($returndata, TRUE);
			return $result;
		}
		else return NULL;
	}

	public function addrazorpayaccount()
	{
		if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$tnc;
			if(isset($_POST['tnc_accepted']) && $_POST['tnc_accepted'] == TRUE) $tnc = TRUE; else $tnc = FALSE;
			$postdata = [
			 "name"=>$_SESSION['name'],
			 "email"=>$_SESSION['email'],
			 "tnc_accepted"=> $tnc,
			 "account_details"=>[
					"business_name"=>strip_tags(htmlspecialchars($_POST['business_name'])),
					"business_type"=>strip_tags(htmlspecialchars($_POST['business_type'])),
			 ],
			 "bank_account"=>[
					"ifsc_code"=>strip_tags(htmlspecialchars($_POST['ifsc_code'])),
					"beneficiary_name"=>strip_tags(htmlspecialchars($_POST['beneficiary_name'])),
					"account_number"=>strip_tags(htmlspecialchars($_POST['account_number'])),
			 ]
			];
			// Get cURL resource
			$curl = curl_init();
			$header = ['Content-type: application/json'];

			// Set some options - we are passing in a useragent too here
			// <YOUR_KEY_ID>:<YOUR_KEY_SECRET>
			curl_setopt_array($curl, [
			    CURLOPT_URL => 'https://api.razorpay.com/v1/beta/accounts',
					CURLOPT_POST => 1,
					CURLOPT_HTTPHEADER => $header,
					CURLOPT_POSTFIELDS => json_encode($postdata),
					CURLOPT_RETURNTRANSFER => TRUE,
					CURLOPT_USERPWD => RAZORPAY_API_ID.':'.RAZORPAY_API_SECRET,
			]);
			// curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

			// Send the request & save response to $resp
			$response = curl_exec($curl);
			$resparray = json_decode($response, TRUE);
			// Close request to clear up some resources
			curl_close($curl);

			if(isset($resparray['error'])) echo $response;
			elseif(isset($resparray['id']))
			{
				$islive = $resparray['live'] ? 'and live' : '';
				$data['accountdetails'] = '<h3>Linked Account Details</h3><div class="padding2per zigzagBack crossbackground roundcorners2per">
								<div class="row"><div class="col-xs-12 col-sm-3 boldtext">Name</div><div class="col-xs-12 col-sm-9">'.$resparray['name'].'</div></div>
								<div class="row"><div class="col-xs-12 col-sm-3 boldtext">Business Name</div><div class="col-xs-12 col-sm-9">'.$resparray['account_details']['business_name'].'</div></div>
								<div class="row"><div class="col-xs-12 col-sm-3 boldtext">Email</div><div class="col-xs-12 col-sm-9">'.$resparray['email'].'</div></div>
								<div class="row"><div class="col-xs-12 col-sm-3 boldtext">Status</div><div class="col-xs-12 col-sm-9">'.$resparray['activation_details']['status'].$islive .'</div></div>
								</div>';
				// save to data base $resp['id'] // accountid acc_Eau7rEiWNCOqC1
				if($this->Payment->addRPAccountId($resparray['id']))
				{
					$_SESSION['linkedaccountid'] = $resparray['id'];
					$data['successfull'] ='Your account had be added to razorpay and linked to ' . WEBNAME .'. You can start accepting payments now!';
					echo json_encode($data);
				}

			}
		}
		else
		{
			http_response_code(405); die();
		}


	}

	public function razorpaybyaccountid($accountid)
	{
		//fetch acc id from sesssion id from database
		//call api to fetch details
		$curl = curl_init();
		// $header = ['Content-type: application/json'];
		curl_setopt_array($curl, [
		    CURLOPT_URL => 'https://api.razorpay.com/v1/beta/accounts/' . $accountid,
				CURLOPT_USERPWD => RAZORPAY_API_ID.':'.RAZORPAY_API_SECRET,
				CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        // CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        // CURLOPT_TIMEOUT        => 120,    // time-out on response
		]);
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}

	public function razorpaypayment()
	{
		if($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['id'] == (int)$_POST['id'])
		{
			// $id = (int)$_POST['id'];
			$id = $_SESSION['id'];
			$returndata['key'] = RAZORPAY_API_ID;
			if($returndata['subscriptionid'] = $this->Payment->getpaymentid($id))
			{
				echo json_encode($returndata);
			}
			else
			{
				$subscriptionarray =array('plan_id' => 'plan_AQ0uW1ATFgu2S2', 'customer_notify' => 1, 'total_count' => 10);
				if($_POST['expires'] > date('U')) $subscriptionarray['start_at'] = $_POST['expires'];
				$api = new Api($returndata['key'], RAZORPAY_API_SECRET);
				$subscription  = $api->subscription->create($subscriptionarray);
				$returndata['subscriptionid'] = $subscription['id'];
				if($returndata['subscriptionid'])
				{

					if($this->Payment->insertpaymentid($id, $returndata['subscriptionid']))
						echo json_encode($returndata);
				}
			}
		}
	}



	public function authenticateuser()
	{

		// $id = (int)$_POST['id'];
		$id = $_SESSION['id'];
		$expectedSignature = hash_hmac('sha256', $_POST['paymentid'] . '|' . $this->Payment->getpaymentid($id), RAZORPAY_API_SECRET);
		if($expectedSignature == $_POST['signature'])
		{
			$this->Payment->userauthenticationfromid($id);
			$_SESSION['userauth'] = TRUE;
		}
		else
		{
			$this->Payment->userdeauthenticationfromid($id);
			$_SESSION['userauth'] = FALSE;
		}
	}


	public function razorpaysubwebhooks()
	{
	    $payload = file_get_contents('php://input');
		$data = json_decode($payload, true);
// 		$api = new Api(RAZORPAY_API_ID, RAZORPAY_API_SECRET);
// 		$expected_signature = hash_hmac('sha256', $data, 'zXPS{%GLK%i.c76e');

		if(!empty($data))
		{
		  //  if($api->utility->verifyWebhookSignature($payload, $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'], 'zXPS{%GLK%i.c76e'))
    // 		{
        		$email = new sendEmail();
        		$subscriptionid = $data['payload']['subscription']['entity']['id'];
        		$customeremail = $this->Payment->getemailfromsub($subscriptionid);
        		if($data['event'] == 'subscription.activated')
        		{
        			$this->Payment->userauthentication($subscriptionid);
                    // $_SESSION['userauth'] = TRUE;
        			$email->email($customeremail, 'You are subscribed to '.WEBNAME.'!', 'Congratulations! You are now subscribed to '.WEBNAME.'. To unlock full potential, write and share articles!');

        		}
        		else if($data['event'] == 'subscription.charged')
        		{
        			//
        		}
        		else if($data['event'] == 'subscription.pending')
        		{
        			$email->email($customeremail, 'Charge to your card failed, Razorpay will try again!', 'We are unable to charge your card, if it is due to card error please update your details! Please add another payment method on <a href="'.BASE_PATH.'profile#payment">'.WEBNAME.'</a> or on the link provided in Razorpay email.');
        		}
        		else if($data['event'] == 'subscription.halted')
        		{
        			$this->Payment->userdeauthentication($subscriptionid);
        // 			$_SESSION['userauth'] = FALSE;
        			$email->email($customeremail, 'Your subscription to '.WEBNAME.' has been cancelled!', 'We are unable to charge your card and hence, the service has been deactivated! Please add another payment method on <a href="'.BASE_PATH.'profile#payment">'.WEBNAME.'</a> or on the link provided in Razorpay email.');
        		}
        		else if($data['event'] == 'subscription.cancelled')
        		{
        			$this->Payment->userdeauthentication($subscriptionid);
        // 			$_SESSION['userauth'] = FALSE;
        			$email->email($customeremail, 'Your subscription to '.WEBNAME.' has been cancelled!', 'We are sorry to see you go! Please let us know why you decided to do so by leaving a <a href="'.BASE_PATH.'contact#feedback">feedback</a>.');
        		}
        		else if($data['event'] == 'subscription.completed')
        		{
        			$this->Payment->userdeauthentication($subscriptionid);
        // 			$_SESSION['userauth'] = FALSE;

        			$email->email($customeremail, 'Your subscription to '.WEBNAME.' has been completed!', 'The maximum duration of subscription has run out, thank you for being with us for so long. Please continue using our services by adding a payment  on <a href="'.BASE_PATH.'profile#payment">'.WEBNAME.'</a> or on the link provided in Razorpay email.');
        		}
    // 		}
		}
	}

	// public function fetchrazorpay()
	// {
	// 	$api = new Api(RAZORPAY_API_ID, RAZORPAY_API_SECRET);
	// 	$id = (int)$_POST['id'];
	// 	$subscription  = $api->subscription->fetch($this->Payment->getpaymentid($id));
	// 	print_r($subscription);
	// 	print_r($api->customer->fetch($subscription['customer_id']));
	// }

	public function cancelrazorpay()
	{
		$api = new Api(RAZORPAY_API_ID, RAZORPAY_API_SECRET);
		// $id = (int)$_POST['id'];
		$id = $_SESSION['id'];
		if($subscriptionid = $this->Payment->getpaymentid($id)) $subscription  = $api->subscription->fetch($subscriptionid)->cancel();
		if($subscription['id'])
		{
			echo $this->Payment->userdeauthentication($subscription['id']);
			$_SESSION['userauth'] = FALSE;
			$email = new sendEmail();
			$email->email($_SESSION['email'], 'Your subscription to '.WEBNAME.' has been cancelled!', 'We are sorry to see you go! Please leave a <a href="'.BASE_PATH.'contact#feedback">feedback</a>');

		}

	}

}
