<?php
// error_reporting(0);
class MessagesController extends Controller
{
	protected $allmessageperpage;
	protected $singlemessageperpage;

	function __construct($controller, $action)
	{
		$this->render =0;
		$this->doNotRenderFooter = 1;
		protectPage();
		parent::__construct($controller, $action);
		$this->_allmessageperpage =20;
		$this->_singlemessageperpage = 20;
	}

	public function index()
	{
		$this->render =1;
		$this->set('metaTitle', 'Messages | Kniew');
		$this->set('metaDescription', 'Find all your conversations in one place.');
		$page = 1;
		if($_SESSION['isauthentic'] !== FALSE)
		{
			$allmessages = $this->Messages->getallmessages((int)$_SESSION['id'],$page, $this->_allmessageperpage);
			$this->set('messagesize', sizeof($allmessages));
			$this->set('numberofmessages', $this->_allmessageperpage);
			$this->set('initialresult', $this->allmessageshtml($allmessages, $page));
		}
	}

	public function loadmoremessages()
	{
		if($_POST['page'])
		{
			$page = $_POST['page'];
			$allmessages = $this->Messages->getallmessages((int)$_SESSION['id'],$page, $this->_allmessageperpage);
			echo $this->allmessageshtml($allmessages, $page);
		}
		else echo false;

	}

	public function allmessageshtml($allmessages, $page)
	{
		$messagepage = ' ';
		foreach ($allmessages as $key => $messagerow)
		{
			$usertype = (int)$messagerow['usertype'];
			$username = htmlspecialchars($messagerow['username']);
			$paid[$key] = '';
			$closed[$key] ='';

			if($messagerow['profilepic'])
			{
				$picurl[$key] = BASE_PATH. htmlspecialchars($messagerow['profilepic']);
			}
			else
			{
				$picurl[$key] = BASE_PATH .'images/icons/logo.png';
			}
			if($usertype == 2 || $usertype == 3 || $usertype == 4 || $usertype == 5)
			{
				$typename='';
				if($usertype == 3) { $typename = 'Lawyers';}
				elseif($usertype == 4) { $typename = 'Doctors';}
				else if($usertype == 5) { $typename = 'CharteredAccountants';}
				else if($usertype == 2) { $typename = 'NGO';}
				$profileurl[$key] = BASE_PATH . 'professionals/'. $typename . '/' . $username;
			}
			else if($usertype == 1)
			{
				$profileurl[$key] = BASE_PATH . 'user/' . $username;
			}
			$isunread[$key]='';
			if($messagerow['type'] == 'in')
			{
				if($messagerow['recipientread'] == true)
				{
					$messagestatusclass[$key] = ' greytext ';
				}
				else
				{
					$messagestatusclass[$key] = ' boldtext whitesmokeBack ';
					$isunread[$key] = "<input type='hidden' name ='isunread' value='true' />";
				}
				$createdat[$key] = date('d F Y', strtotime($messagerow['createdat']));
				if($messagerow['recipientread'] == true) $messagestatus[$key] = '<i class="fa fa-check-circle" aria-hidden="true"></i> Seen '. $createdat[$key];
				else $messagestatus[$key] = $createdat[$key];

			}
			elseif($messagerow['type'] == 'out')
			{
					$messagestatusclass[$key] = ' greytext ';
					$createdat[$key] = date('d F Y', strtotime($messagerow['createdat']));
						$messagestatus[$key] = '<i class="fa fa-paper-plane-o" aria-hidden="true"></i> Sent '.$createdat[$key];

			}
			if($messagerow['paidby'] != NULL) $paid[$key] = ' <span class="label label-success pull-right">Paid</span>';
			if($messagerow['closedon'] != NULL) $closed[$key] = ' <span class="label label-danger pull-right marginleft1px">Closed</span>';

			$encryptkey[$key] = 'emailFromAllMessages_' . $messagerow['threadid'] ;
			$email[$key] = Crypto::encrypt($messagerow['email'], $encryptkey[$key], TRUE);


			$messagepage .= "<div class='col-xs-12 messagerow lightgreybottomborder paddingtop2per paddingleftzero paddingrightzero".$messagestatusclass[$key]."' data-messagedivkey = '".$key."' id = 'messagerow_".$key."' data-threadid = ".$messagerow['threadid'].">
											<div class='col-xs-4 col-sm-2'>
												<img src='".$picurl[$key]."' alt='". $username. "' class='messageimg' />
												<p class='centertext boldtext textcaptial'><a href='" .$profileurl[$key]."'> ".$username."</a></p>
											</div>
											<div class='col-xs-8 col-sm-10'>
												<div class='messagepreview'><p class='displaysubject'>".$messagerow['subject']."</p>".strip_tags(htmlspecialchars_decode($messagerow['messagetext']))."</div>
												<p class='messagestatus'>".$messagestatus[$key]. $closed[$key]. $paid[$key]."</p>
											</div>
											<input type='hidden' name ='threadid' value='".(int)$messagerow['threadid']."' />
											<input type='hidden' name ='picurl' value='".$picurl[$key]."' />
											<input type='hidden' name ='username' value='".$username."' />
											<input type='hidden' name ='profileurl' value='".$profileurl[$key]."' />
											<input type='hidden' name ='userid' value='".$messagerow['userid']."' />
											<input type='hidden' name ='useremail' value='".$email[$key]."' />
											".$isunread[$key]."
										</div>";
		}

		return $messagepage;
	}

	public function opensinglemessage()
	{
		if($_POST)
		{
				// VARIABLES
				$threadid = (int)$_POST['threadid'];
				$page = (int)$_POST['page'];
				$userid = (int)$_POST['userid'];
				$username = strip_tags($_POST['username']);
				$useremail = strip_tags($_POST['useremail']);
				$getparent['getparent'] = (int)$_POST['getparent'];
				$getparent['getparentpage'] = (int)$_POST['getparentpage'];
				$getparent['lastmessageid'] = (int)$_POST['lastmessageid'];
				$getparent['parenttoget'] = (int)$_POST['parenttoget'];
				$singlemessagepage = '';
				// $lastparent ='';
				$sizeofmessages;
				$afterparent = 0;
				$isunread = $_POST['isunread'] ? $_POST['isunread'] : FALSE;
				$refreshid = $_POST['refreshid'] ? (int)$_POST['refreshid'] : NULL;
				// $refresh = $_POST['refresh'] ? $_POST['refresh'] : FALSE;
				$intialusers = '';


				//USER LINK
				if($_SESSION['usertype'] == 2 || $_SESSION['usertype'] == 3 || $_SESSION['usertype'] == 4 || $_SESSION['usertype'] == 5)
				{
					$typename='';
					if($_SESSION['usertype'] == 3) { $typename = 'Lawyers';}
					elseif($_SESSION['usertype'] == 4) { $typename = 'Doctors';}
					else if($_SESSION['usertype'] == 5) { $typename = 'CharteredAccountants';}
					else if($_SESSION['usertype'] == 2) { $typename = 'NGO';}
					$sessionprofileurl = BASE_PATH . 'professionals/'. $typename . '/' . $_SESSION['username'];
				}
				else if($_SESSION['usertype'] == 1)
				{
					$sessionprofileurl = BASE_PATH . 'user/' . $_SESSION['username'];
				}

				if($_SESSION['profilepic'])
			{
				$picurl = BASE_PATH. htmlspecialchars($_SESSION['profilepic']);
			}
			else
			{
				$picurl = BASE_PATH .'images/icons/logo.png';
			}

				$userlink = "<img src='".strip_tags($_POST['picurl'])."' alt='". $username . "' class='messageimg' />
				<p class='centertext boldtext textcaptial'><a href='" .$_POST['profileurl']."'> ".$username."</a></p>";
				$sessionlink = "<img src='".$picurl."' alt='". $_SESSION['username']. "' class='messageimg' />
				<p class='centertext boldtext textcaptial'><a href='" .$sessionprofileurl."'> ".$_SESSION['username']."</a></p>";

				// ADD TO PAGE COUNT (If call to parent before)
				// if($getparent['getparentpage'])
				// {
					$getparentpagelast = $getparent['getparentpage'] ? $getparent['getparentpage']-1 : 0;
					$afterparentname = 'addtopagecount_'.$getparentpagelast;
					if($_POST[$afterparentname]) $afterparent = $_POST[$afterparentname];
				// }

			  //GET MESSAGES
				$getmessage = $this->Messages->getthreadmessages($threadid, $userid, $getparent, $page,$this->_singlemessageperpage, $afterparent,$isunread , $refreshid);
				if(empty($getmessage))
				{
					if($refreshid != null) return 0;
					else
					{
						$errors["error"] = "<p class='error margin10per largetext'>Error Occured! Please refresh page and try again. Try signing out and back in. Thank you for your patience.</p>";
						echo json_encode($errors);
					}
				}
				else
				{
					$returnsinglemessage = [];
					if($getmessage[0]['messageid'] != NULL)
					{
						$returnsinglemessage['messagestatus'] = 'ok';
						$sizeofmessages = sizeof($getmessage);

						//loop through message to build html
						for ($key = 0; $key < $sizeofmessages; $key++ )
						{
							//VARIABLES
							$picturealignclass[$key] = '';
							$datealign[$key] ='';
							$linktoparent[$key] = '';
							$linktoprevparent[$key] = '';
							$attachmentbutton[$key] = '';

							//CLASS AND DATA BASED ON SENDER OR RECIPIENT
							if($getmessage[$key]['recipientid'] == $_SESSION['id'])
							{
									$messagealignclass[$key] = ' floatleft ';
									$createdat[$key] = date('d M Y, h:m', strtotime($getmessage[$key]['createdat']));
									$messagestatus[$key] = $createdat[$key];
									$whichuser[$key] = $userlink;
							}
							elseif($getmessage[$key]['senderid'] == $_SESSION['id'])
							{
								$messagealignclass[$key] = ' floatright textalignright ';
								$picturealignclass[$key] = ' pull-right ';
								// $datealign[$key] = ' textalignright ';
								$createdat[$key] = date('d F Y, h:m', strtotime($getmessage[$key]['createdat']));
								$whichuser[$key] = $sessionlink;

								if ($page == 1 && $key == 0)
								{
									if($getmessage[$key]['recipientread'] == true)
									{
										$messagestatus[$key] = '<i class="fa fa-check-circle" aria-hidden="true"></i> seen on '. $createdat[$key];
									}
									else
									{
										$messagestatus[$key]='Sent on ' . $createdat[$key];
									}
								}
								else
								{
									$createdat[$key] = date('d F Y, h:m', strtotime($getmessage[$key]['createdat']));
									$messagestatus[$key] = $createdat[$key];
								}
							}

							//Details of last parent, and link to parent if not sequencial for last
							if($key == $sizeofmessages-1)
							{
								// $lastparent = "<input type='hidden' name ='lastparentid_".$page."' value='".  ."' /><input type='hidden' name ='lastparenttext_".$page."' value='". htmlspecialchars($getmessage[$key]['parentmessagetext']) ."' />";
								$returnsinglemessage['lastparentid'] = (int)$getmessage[$key]['parentmessageid'];
								$returnsinglemessage['lastparenttext'] = htmlspecialchars($getmessage[$key]['parentmessagetext']);
							}
							else if($getmessage[$key]['parentmessageid'] != $getmessage[$key+1]['messageid'])
							{
								$linktoparent[$key] = "<div class='linktoparent alert alert-warning' data-parenttoget='".(int)$getmessage[$key]['parentmessageid']."' data-lastmessageid='".$getmessage[$sizeofmessages-1]['messageid']."' data-pageno='".$page."'><span class='boldtext'><i class='fa fa-reply' aria-hidden='true'></i> reference to </span> ".htmlspecialchars_decode($getmessage[$key]['parentmessagetext'])."</div>";
							}

							//when new seq on data, link to parent if not seq
							if ($key == 0 && $page != 1)
							{
								// if($page == null)
								// {
								// 	$lastpageparentid = 'lastparentid_0';
								// 	$lastpageparenttext = 'lastparenttext_0';
								// }
								// else
								// {
								// 	$lastpageparentid = 'lastparentid_' . ($page-1);
								// 	$lastpageparenttext = 'lastparenttext_' . ($page-1);
								// }
								if($refreshid != null && $getmessage[$key]['parentmessageid'] != $refreshid)
								{
									$linktoparent[$key] = "<div class='linktoparent alert alert-warning' data-parenttoget='".(int)$getmessage[$key]['parentmessageid']."' ><span class='boldtext'><i class='fa fa-reply' aria-hidden='true'></i> reference to </span>".htmlspecialchars_decode($_POST['lastmessagetext'])."</div>";
								}
								else if($refreshid == null && $getmessage[$key]['messageid'] != $_POST['lastparentid'])
								$linktoprevparent[$key] = "<div class='linktoparent alert alert-warning' data-parenttoget='".(int)$getmessage[$key]['parentmessageid']."' data-lastmessageid='".$getmessage[$sizeofmessages-1]['messageid']."' data-pageno='".$page."'><span class='boldtext'><i class='fa fa-reply' aria-hidden='true'></i> reference to </span>".htmlspecialchars_decode($_POST['lastparenttext'])."</div>";
							}
							if(isset($getmessage[$key]['attachmentname']) && $getmessage[$key]['attachmentname'] != '')
							{
								$aname = strip_tags(htmlspecialchars_decode($getmessage[$key]['attachmentname']));
								$attachmentbutton[$key] = "<form id='getmyattachmentform' class='floatright' name='getmyattachmentform'  action='/messages/downloadattachment' method='post' target='_blank'>
																								<input type='hidden' name='mid' value='".(int)$getmessage[$key]['messageid']."'/>
																								<input type='hidden' name='aname' value='".$aname."'/>
																								<button type='submit' class='btn btn-default xsmalltext' id='getmyattachment'> <i class='fa fa-download' aria-hidden='true'> </i> ". $aname. "</button>
																								</form>";
							}

							//HTML DATA
							$presentmessage = $linktoparent[$key] . "<div class='col-xs-12 singlemessagerow lightgreybottomborder paddingtop2per paddingleftzero paddingrightzero paddingbottom1per".$messagealignclass[$key]."' data-messagedivkey = '".$key."' id = 'singlemessagerow_".$key."' data-messageid='".(int)$getmessage[$key]['messageid']."' data-pageno = '".$page."'>
															<div class='col-xs-4 col-sm-1 ". $picturealignclass[$key] ."'>
															".$whichuser[$key]."
															</div>
															<div class='col-xs-8 col-sm-11'>
																<div class='message'>".htmlspecialchars_decode($getmessage[$key]['messagetext'])."</div>
																<p class='xsmalltext greytext'>".$messagestatus[$key]."</p>
																".$attachmentbutton[$key]."
															</div>
															<div class='col-xs-12 refertothisdiv'>
																<button id='refertothismessage' class='btn btn-default xsmalltext pull-right'><i class='fa fa-reply' aria-hidden='true'></i></button>
															</div>

														</div>" . $linktoprevparent[$key];
							$singlemessagepage = $presentmessage . $singlemessagepage;

						}

						//display more or end of result
						if($sizeofmessages < $this->_singlemessageperpage && $getparent['getparent'] == false)
						{
							if($page != 1 && $refreshid == null)
								$singlemessagepage = "<p class='col-xs-12 endresult displayblock'>---- end of messages ----</p>" . $singlemessagepage;
						}
					  else $singlemessagepage = '<button type="button" class="btn btn-default col-xs-12" id="loadmoresinglemessages" data-pageno = '.$page.'>Load older messages</button>' .$singlemessagepage;

						//Link to user (only req in page 1 because same throughout)
						if($page == 1) $singlemessagepage .= "<input type='hidden' name ='threadid' value='".$threadid."' />
															<input type='hidden' name ='picurl' value='".$_POST['picurl']."' />
															<input type='hidden' name ='username' value='".$username."' />
															<input type='hidden' name ='profileurl' value='".$_POST['profileurl']."' />
															<input type='hidden' name ='userid' value='".(int)$_POST['userid']."' />
															<input type='hidden' name ='useremail' value='".$useremail."' />
															<input type='hidden' name='initialsender' value='".(int)$getmessage[$sizeofmessages-1]['senderid']."'/>
															<input type='hidden' name='initialrecipient' value='".$getmessage[$sizeofmessages-1]['recipientid']."'/>";


						//Link to parent of first message of new sequence
						// $singlemessagepage .= $lastparent;
					}



					if($page == 1 || $refreshid != null)
					{
						if($refreshid != NULL)
						{
							if($getmessage[0]['messageid'] != NULL) $totalsizeofmessages = $sizeofmessages + (int)$_POST['noofmessages']; //size of visible message + refresh query
							else $totalsizeofmessages = (int)$_POST['noofmessages'];
						}
						else
						{
							$totalsizeofmessages = $sizeofmessages;
						}

						// When link to parent is clicked add number of messages to offset of sql
						if($getparent['getparent'] == true)
						{
							$addtopage;
							if($afterparent != 0)  $addtopage = $sizeofmessages + $afterparent;
							else $addtopage = $sizeofmessages;
							$singlemessagepage .= "<input type='hidden' name ='addtopagecount_".$getparent['getparentpage']."' value='".$addtopage."' />";
						}
						if($getmessage[0]['paidby'] == NULL)
						{
							$returnsinglemessage['messagestatus'] = 'unpaid'; //just for safety in case some problem with following conditions

							// NOTE: MAY BE: here condition to check which if prof and if both are resort to this?
							if($_SESSION['id'] == $getmessage[$sizeofmessages-1]['senderid'] || $_SESSION['id'] == (int)$_POST['initialsender'])
							{
								if($getmessage[0]['orderid'] != null)
								{
									if($totalsizeofmessages < 2)
									{
										$returnsinglemessage['messagestatus'] = 'initial_unpaid_user';
										$returnsinglemessage['unpaiduser'] = '<div class="col-xs-12 unpaiduser">Your query has been recieved. Please allow professional to respond.</div>';
									}
									else
									{
										$payBtnDisplay = '';
										$numbertext = '';
										// send with message showing
										if($totalsizeofmessages < 10)
										{
											$returnsinglemessage['messagestatus'] = 'initial_payoption_user';
											$payBtnDisplay = 'initialpayuser';
											$numbertext = '<div class="col-xs-12 redtext boldtext">* You are allowed a total of 10 messages between you, until a payment. Till now you have exchanged a total of <b>'.$sizeofmessages.'</b> messages.</div>';
										}
										else
										{
											$returnsinglemessage['messagestatus'] = 'exceed_unpaid_user';
											$payBtnDisplay = 'exceedpayuser';
											$numbertext = '<div class="col-xs-12 error boldtext">You have exceeded the number of messages you can send before payment. Please make a payment before continuation.</div>';
										}

										$name = $_SESSION['name'] ? $_SESSION['name'] : $_SESSION['username'];

										$returnsinglemessage['unpaidpaymentform'] = '
											<div class="col-xs-12 '.$payBtnDisplay.'">
												<div class="hidden-xs col-sm-3"></div>
												<div class="col-sm-6">
													<button class="btn btn-success btn-lg " id="payForMessageRpBtn" data-email= "'. $_SESSION['email'] .'" data-name ="'.$name.'" data-ordid = "'.$getmessage[0]['orderid'].'" data-threadid ="'.$threadid.'">Pay through RazorPay!</button>
												</div>
												<div class="hidden-xs col-sm-3"></div>
												'.$numbertext.'
											</div>';

									}
								}
								else
								{
									$displayclass = '';
									if($totalsizeofmessages < 10)
									{
										$returnsinglemessage['messagestatus'] ='noorderuser';
										$displayclass = 'noorderuserhtml';
									}
									else
									{
										$returnsinglemessage['messagestatus'] = 'exceednoorderuser';
										$displayclass ='exceednoorderuserhtml';
									}
									$returnsinglemessage['noorderuserhtml'] = '<div class="col-xs-12 '.$displayclass.' padding2per largetext">The professional has not yet responded. Please wait for a response from professional.</div>';
								}
							}
							else
							{
								if( $_SESSION['usertype'] != 1) //added this cond so user cant have the payment option
								{
									if($getmessage[0]['orderid'] == null)
									{

										$returnsinglemessage['messagestatus'] = 'initial_unpaid_prof';
										// if professional payment account id
										if($_SESSION['linkedaccountid'] == NULL)
										{
											ob_start();                      // start capturing output
											include(ROOT . DS . 'application' . DS . 'views' . DS . 'widgets'.DS . 'addrazorpayaccount.php');   // execute the file
											$returnsinglemessage['accountmodal'] = ob_get_contents();    // get the contents from the buffer
											ob_end_clean();
											$returnsinglemessage['unpaidprofform'] = '<div class="col-xs-12 unpaidprofform">
																																	<h5 class="centertext">Add Account Information</h5>
																																	<p class="centertext">You need to add account information first so that the user can pay you.</p>
																																	<div class="col-xs-12 padding2per centertext"><button id="addRazorpayAccount" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addRazorpayAccountModal">Add <img class="height18 displayinline" alt="Razorpay" src="'. BASE_PATH . DS. 'images' . DS. 'icons' .DS . 'razorpay.svg" /> Account</button></div>
																																	<div class="centertext impinfo">*<b>Please note:</b> We do not save any of your bank account information. You can also do so from <a href="'.BASE_PATH.'profile#addpaymentaccount">Profile</a> page.</div>
																																</div>';


										}
										else
										{
											//little about how you gonna tackle the issue, time frame, money (if not added account?)
											$returnsinglemessage['unpaidprofform'] = '<div class="col-xs-12 unpaidprofform">
																																<form class="form row" action="" method = "POST"  role="form" id="initialMessageProfForm">
																																<div class="form-group-sm col-xs-12">
																																	<label>Please give a roadmap of how you will solve the issue. </label>
																																	<div class="input-group">
																																			<div class="input-group-addon">
																																				<span class="fa fa-road"></span>
																																			</div>
																																			<textarea required name="message"  class="form-control" rows="5" placeholder="Explain a little about how are you going to tackle the issue"></textarea>
																																	</div>
																																</div>
																																<div class="form-group-sm col-xs-12 col-sm-6">
																									                <label>Approximate Time Frame</label>
																									                <div class="input-group">
																									                    <div class="input-group-addon">
																									                      <span class="fa fa-calendar"></span>
																									                    </div>
																									                    <input required type="text" name="timeframe"  class="form-control" placeholder="Eg: 10 days or immediately"/>
																									                </div>
																									              </div>
																																<div class="form-group-sm col-xs-12 col-sm-6">
																									                <label>Cost of consultation (in INR)* <a href="#" data-toggle="popover" title="" data-content="A total 5% of this amount will be deducted from this amount, which includes Payment Gateways Convience Fee (2.25% + GST for Razorpay). " data-trigger="focus"><i class="fa fa-info-circle smalltext"></i></a></label>
																									                <div class="input-group">
																									                    <div class="input-group-addon">
																									                      <span class="fa fa-inr"></span>
																									                    </div>
																									                    <input required type="number" name="cost"  required class="form-control" placeholder="1000"/>
																									                </div>
																									              </div>
																																<div class="form-group-sm col-xs-12 margintop1per">
																									                <input required type="submit" name="initialformsubmit"  class="form-control btn btn-primary" value="Send Message" />
																											          </div>
																																</form>
																																</div>';
										}
									}
									else
									{
										$returnsinglemessage['messagestatus'] = 'exceed_unpaid_prof';
										$returnsinglemessage['unpaidmsgprof'] = '<div class="col-xs-12 unpaidmsgprof padding2per largetext">The user has not paid yet and the amount of messages allowed before non-payment has exceeded.</div>';

									}
								}
							}

						}

						if($getmessage[0]['closedby'] != NULL)
						{
							$returnsinglemessage['messagestatus'] = 'closed'; //just for safety in case issue wih following conditions
							$closedon = strtotime($getmessage[0]['closedon']);
							if(($getmessage[0]['closedby'] != $getmessage[0]['paidby'])  && ($closedon > strtotime('-7 day')))
							{
								//
								$whichuser;

								if($getmessage[0]['closedby'] == $_SESSION['id'] ) $whichuser = $_SESSION['username'];
								else $whichlink = $username;
								$returnsinglemessage['messagestatus'] = 'closedgrace';
								$returnsinglemessage['closedbygrace'] = '<div class="col-xs-12 closedbygrace">The messaging session has been closed by <b>'.$whichuser.'</b>. Messages closes on <b>'.date("d F Y, g:i A", $closedon) .'</b>. Please resolve any issues left before then.</div>';

							}
							else
							{

								$whichlink;
								$includesendmessageform = '';

								if($getmessage[0]['paidby'] != $getmessage[0]['closedby'] && $getmessage[0]['paidby'] == $_SESSION['id'])
								{
									ob_start();                      // start capturing output
									include(ROOT . DS . 'application' . DS . 'views' . DS . 'professionals'.DS . 'messagesmodal.php');   // execute the file
									$messagemodal = ob_get_contents();    // get the contents from the buffer
									ob_end_clean();
									$singlemessagepage .= $messagemodal;
									$includesendmessageform = '<button class="btn btn-info form-control"  data-toggle="modal" data-target="#messagesModal">Start a new message session!</button>';
								}

								$returnsinglemessage['messagestatus'] = 'closed';
								if($getmessage[0]['closedby'] == $_SESSION['id'] ) $whichlink = $sessionlink;
								else $whichlink = $userlink;
								$returnsinglemessage['closedbyhtml'] = '<div class="col-xs-12 closedbyhtml padding2per"><div class="col-xs-12 col-sm-6  text-xs-center text-sm-right paddingrightzero">The messaging session has been closed by </div><div class="col-xs-12 col-sm-2 float-xs-center float-sm-left text-xs-center text-sm-left "> '.$whichlink.'</div>'.$includesendmessageform.'</div>';
							}
						}

					}
					$returnsinglemessage['singlemessagedata'] = $singlemessagepage;

					if($refreshid != NULL) $returnsinglemessage['noofunreadmessages'] = $getmessage[0]['noofunreadmessages'];

					echo json_encode($returnsinglemessage);
				}
		}
	}

	public function downloadattachment()
	{
		$this->render = 0;
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$returnmsg =[];
			$messageid = (int)$_POST['mid'];
			$attachmentname = trim(htmlspecialchars(strip_tags($_POST['aname'])));
			$attachment = $this->Messages->getattachment($messageid, $attachmentname);
			if(intval($attachment['attachmentid']))
			{
				$fileext = $attachment['attachmentextension'];

				$filepath = 'E:'. DS. 'upload' . DS . 'attachment' .DS.$attachment['attachmentid'] . '.' . $fileext; //CHANGEDNOV19 : CHANGE PATH TO FILE
				$allowedext = array(
											"bmp" => "image/bmp",
											"gif" => "image/gif",
											"jpg" => "image/jpg",
											"jpeg" => "image/jpeg",
											 "png" => "image/png",
											 "odp" => "application/vnd.oasis.opendocument.presentation",
											 "pps" => " application/vnd.ms-powerpoint",
											 "ppt" => "application/vnd.ms-powerpoint",
											 "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
											 "ods" => "application/vnd.oasis.opendocument.spreadsheet",
											 "xls" => "application/vnd.ms-excel",
											 "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
											 "doc" => "application/msword",
											 "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
											 "odt" => "application/vnd.oasis.opendocument.text",
											 "pdf" => "application/pdf",
											 "rtf" => "application/rtf",
											 "txt" => "text/plain"
										 );
				$mimedefault = "application/octet-stream";
				$mimetype = isset($allowedext[$fileext])? $allowedext[$fileext] : $mimedefault;

				if(is_file($filepath))
				{
					header('Content-Description: File Transfer');
					header('Pragma: no-cache');
			    header('Content-Transfer-Encoding: binary');
			    header('Content-type: ' . $mimetype);
			    header('Content-Length: ' . filesize($filepath));
			    header('Content-Disposition: attachment; filename="' . $attachmentname . '"');
			    header('Expires: 0'); //already expired
			    header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0');
					ob_flush();
			    flush();
			    readfile($filepath);
					exit();
				}
				else
				{
					echo '<p class="error">File does not exist. Please try again or reupload the file.</p>';
					header("HTTP/1.0 404 Not Found");
					exit;
				}
			}
			else
			{
				echo '<p class="error">Please check you are authorised to view the file!</p>';
				header('HTTP/1.1 403 Forbidden');
				exit;
			}
		}
		else
		{
			echo '<p class="error">Issue in request, please try again!</p>';
			header("HTTP/1.0 400 Bad Request");
			exit;

		}
	}

	public function closemessage()
	{
		$this->render = 0;
		$returnclosed;

		if($_SERVER["REQUEST_METHOD"] == "POST" && strtolower($_POST['confirmdelete']  == 'close'))
		{
			$threadid = (int)$_POST['threadid'];
			$return  = $this->Messages->closemessagebyuser($threadid);
			if((intval($return['paidby']) || $return['paidby'] === NULL) && isset($return['paidby']))
			{
				if($_SESSION['id'] == $return['paidby'])
				{
					$returnclosed['messagestatus'] = 'closed';
					$returnclosed['closedbyhtml'] = '<div class="col-xs-12 closedbyhtml padding2per centertext largetext">The messaging session has been closed by <b>You!</b> <p>You can go back to messages or check out other <a href="'.BASE_PATH.'" class="textunderline">professionals</a>.</p></div>';
				}
				else
				{
					$returnclosed['messagestatus'] = 'closedgrace';
					$returnclosed['closedbygrace'] = '<div class="col-xs-12 closedbygrace">The messaging session has been closed by <b>You</b>. Messages closes in <b>7 days</b>, to give user time to resolve any pending issues.</div>';
				}
			}
			else
			{
				$returnclosed['messagestatus'] = 'error';
				$returnclosed['errorhtml'] = 'Error occured! Please refresh and try again.';
			}
		}
		else
		{
			$returnclosed['messagestatus'] = 'error';
			$returnclosed['errorhtml'] = 'Error occured! Please refresh and try again.';
		}
		echo json_encode($returnclosed);


	}


	public function sendmessagefrombutton()
	{

			$this->render=0;
			if(isset($_POST['messageDetails']))
			{
				if(loggedin())
				{

					$professionalid = (int)$_POST["professionalid"];
					$professionalusername = preg_replace('/[^A-Za-z0-9]/', '', strip_tags($_POST['username']));
					$messagetext = htmlspecialchars(strip_tags($_POST['messageDetails']));
					$subject = htmlspecialchars(strip_tags($_POST['messageSubject']));
					$encryptkey = 'emailFromMsgModal_' . $professionalid;
					$professionalemail =	Crypto::decrypt($_POST['professionalemail'], $encryptkey , true);
					echo $this->Messages->sendmessagefromprofpage($messagetext, $subject, $_SESSION['id'], $professionalid, $professionalemail, $professionalusername);

				}
				else
				{
					$_SESSION['sendMessagePending']['professionalid'] = (int)$_POST['professionid'];
					$_SESSION['sendMessagePending']['professionalemail'] = $_POST['professionalemail'];
					$_SESSION['sendMessagePending']['messageDetails'] = htmlspecialchars(strip_tags($_POST['messageDetails']));
					$_SESSION['sendMessagePending']['messageSubject'] = htmlspecialchars(strip_tags($_POST['messageSubject']));
					echo "loginfirst";
				}
			}
			else if (isset($_SESSION['sendMessagePending']) && loggedin())
			{
				$professionalid = $_SESSION['sendMessagePending']["professionalid"];
				$professionalemail = $_SESSION['sendMessagePending']["professionalemail"];
				$messagetext = $_SESSION['sendMessagePending']['messageDetails'];
				$subject = $_SESSION['sendMessagePending']['messageSubject'];
				$result = $this->Messages->sendmessagefromprofpage($messagetext,$subject, $_SESSION['id'], $professionalid, $professionalemail);
				if($result)
				{
					unset($_SESSION['sendMessagePending']);
					return 'Message sent!';
				}
			}
			else echo false;
	}

	public function sendmessage()
	{

		$this->render=0;
		if(!empty($_POST['state']))
		{
			$errors = [];

	    if (verifycsrf())
			{
				$filename = $_FILES['attachment']['name'];
				$filetmp = $_FILES['attachment']['tmp_name'];
				$filetype = $_FILES['attachment']['type'];
				$filesize = $_FILES['attachment']['size'];

				if (isset($_FILES['attachment']) && $filesize !== 0  && $filetmp !== '')
				{
					$fileext = pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION);
					$finfo = finfo_open( FILEINFO_MIME_TYPE );
					$mtype = finfo_file( $finfo, $filetmp );
					finfo_close( $finfo );
					if (is_uploaded_file($filetmp))
					{
	        		// $extensions = ['bmp','gif','jpg','jpeg','png','odp','pps','ppt','pptx','ods','xls','xlsx','doc','docx','odt','pdf','rtf','txt'];
							$allowedext = array(
														"bmp" => "image/bmp",
														"gif" => "image/gif",
														"jpg" => "image/jpg",
                            "jpeg" => "image/jpeg",
														 "png" => "image/png",
														 "odp" => "application/vnd.oasis.opendocument.presentation",
														 "pps" => " application/vnd.ms-powerpoint",
														 "ppt" => "application/vnd.ms-powerpoint",
														 "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
														 "ods" => "application/vnd.oasis.opendocument.spreadsheet",
														 "xls" => "application/vnd.ms-excel",
														 "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
														 "doc" => "application/msword",
														 "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
														 "odt" => "application/vnd.oasis.opendocument.text",
														 "pdf" => "application/pdf",
														 "rtf" => "application/rtf",
														 "txt" => "text/plain"
													 );



	            if (!array_key_exists(strtolower($fileext), $allowedext)) {
	                $errors['error'][] = 'Extension not allowed';
	            }

							if(!in_array($mtype, $allowedext))
							{
								$errors['error'][] = 'File type not allowed';
							}

	            if ($filesize > 1048576)
							{
	                $errors['error'][] = 'File size exceeds limit';
	            }

							// if($mtype != $filetype) $errors['error'][] = 'Please check file type and compatible data and then upload';
							//this giving error for even correct types of file
						}
						else $errors['error'][] = 'Please use the upload button to add a file.';
        }

				if(trim($_POST['inputmessagetext'])=='') $errors['error'][] = 'Please input text';

				if(loggedin() && empty($errors))
				{
					$senderid = $_SESSION["id"];
					$recipientid = (int)$_POST["userid"];
					$threadid = (int)$_POST["threadid"];
					$parentid = (int)$_POST["parentid"];
					$parenttext = htmlspecialchars($_POST['parenttext']);
					$config = HTMLPurifier_Config::createDefault();
					$config->set('Attr.AllowedFrameTargets', array('_blank'));
					$config->set('HTML.Allowed', 'a[href|target],strong,b,em,i,div,p,table,tbody,tr,td');
					$purifier = new HTMLPurifier($config);
					$messagetext_purified = $purifier->purify($_POST['inputmessagetext']);
					$messagetext = htmlspecialchars($messagetext_purified);
					$attachmentname = htmlspecialchars(preg_replace('/[^\w._]/','',strip_tags($filename)));
					$attachmentname = (strlen($attachmentname) > 30) ?  (substr($attachmentname, 0, (29-strlen($attachmentname))).'.'.$fileext) : $attachmentname;
					$encryptkey = 'emailFromAllMessages_' . $threadid;
					$email = Crypto::decrypt($_POST['useremail'], $encryptkey , true);
					$username = preg_replace('/[^A-Za-z0-9]/', '', strip_tags($_POST['username']));

					if(isset($_FILES) && $filesize !== 0  && $filetmp !== '')
					{

							if ($_FILES["attachment"]["error"] == UPLOAD_ERR_OK)
							{
									$attachment = $filetmp;
							}
							else
							{
								$errors['error'][] = 'Problem with file upload, please check file extenstion, size and network and try again';
				        die(json_encode($errors));
							}
					}

					$returnsendmessage = $this->Messages->sendmessage($senderid, $recipientid, $threadid, $parentid, $messagetext, $attachment, $attachmentname, $fileext, $email,$username);

					if(array_filter($returnsendmessage, 'intval'))
					{
						if($_SESSION['usertype'] == 2 || $_SESSION['usertype'] == 3 || $_SESSION['usertype'] == 4 || $_SESSION['usertype'] == 5)
						{
							$typename='';
							if($_SESSION['usertype'] == 3) { $typename = 'Lawyers';}
							elseif($_SESSION['usertype'] == 4) { $typename = 'Doctors';}
							else if($_SESSION['usertype'] == 5) { $typename = 'CharteredAccountants';}
							else if($_SESSION['usertype'] == 2) { $typename = 'NGO';}
							$sessionprofileurl = BASE_PATH . 'professionals/'. $typename . '/' . $_SESSION['username'];
						}
						else if($_SESSION['usertype'] == 1)
						{
							$sessionprofileurl = BASE_PATH . 'user/' . $_SESSION['username'];
						}

						if($_SESSION['profilepic'])
						{
							$picurl = BASE_PATH. htmlspecialchars($_SESSION['profilepic']);
						}
						else
						{
							$picurl = BASE_PATH .'images/icons/logo.png';
						}

						$returnsendmessage['sessionlink'] = "<img src='".$picurl."' alt='". $_SESSION['username']. "' class='messageimg' />	<p class='centertext boldtext textcaptial'><a href='" .$sessionprofileurl."'> ".$_SESSION['username']."</a></p>";
						$returnsendmessage['messagetext'] = $messagetext_purified;
						if($attachmentname != '') $returnsendmessage['attachmentform'] = "<form id='getmyattachmentform' class='floatright' name='getmyattachmentform'  action='/messages/downloadattachment' method='post' target='_blank'>
																						<input type='hidden' name='mid' value='".(int)$returnsendmessage['messageid']."'/>
																						<input type='hidden' name='aname' value='".$attachmentname."'/>
																						<button type='submit' class='btn btn-default xsmalltext' id='getmyattachment'> <i class='fa fa-download' aria-hidden='true'> </i> ". $attachmentname. "</button>
																						</form>";
						$returnsinglemessage['lastparentid'] = $parentid;
						$returnsinglemessage['lastparenttext'] = $parenttext;

						echo json_encode($returnsendmessage);
					}
					else
					{
						$errors['error'][] = 'Problem sending message. Please check your data and credentials. Make sure you have paid and that the messaging thread is not closed. Refresh and try again.';
						die(json_encode($errors));
					}
				}
				else
				{
					die(json_encode($errors));
				}
			}
			else
			{
				$errors['error'][] = 'Problem sending message. Authentication failed! Please refresh/log in again.';
				die(json_encode($errors));
			}


		}
		else echo false;
	}

	public function initialprofmessage()
	{
		$this->_render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$returndata = [];
			if(!empty($_POST['message']) && !empty($_POST['timeframe']) && !empty($_POST['cost']))
			{
				$filter_options = array(
				    'options' => array( 'min_range' => 0)
				);
				$cost = filter_var( $_POST['cost'], FILTER_VALIDATE_INT ,$filter_options);
				if(isset($cost) && $cost != NULL)
				{
					$message = strip_tags($_POST['message']);
					$timeframe = strip_tags($_POST['timeframe']);
					$finalmessage = '<div><h6 class="boldtext">Road map to your problem</h6><div>'.$message.'</div><h6 class="boldtext">Timeframe for completion</h6><div>'.$timeframe.'</div></div>';
					$threadid = (int)$_POST['threadid'];
					$recipientid = (int)$_POST['userid'];
					$parentid = (int)$_POST['parentid'];
					$username = preg_replace('/[^A-Za-z0-9]/', '', strip_tags($_POST['username']));
					$encryptkey = 'emailFromAllMessages_' . $threadid;
					$email = Crypto::decrypt($_POST['useremail'], $encryptkey , true);

					$payment = new PaymentController('payment', 'createneworder');
					$order = $payment->createneworder($cost, $threadid, $username, $_SESSION['linkedaccountid']);

					// send message to database, along with orderid
					if(array_key_exists('id',$order) && $order['id'] !== NULL)
					{
						if($returndata['messageid'] = $this->Messages->sendinitialprofmessage($order['id'], $threadid,$_SESSION['id'], $recipientid, $parentid, $finalmessage, $email, $username))
						{
							$returndata['sessionlink'] = "<img src='".BASE_PATH.$_SESSION['profilepic']."' alt='". $_SESSION['username']. "' class='messageimg' />
							<p class='centertext boldtext textcaptial'><a href='" .$sessionprofileurl."'> ".$_SESSION['username']."</a></p>";
							$returndata['messagetext'] = $finalmessage;
							echo json_encode($returndata);
						}
						else {
							$returndata['error'] = 'Please refersh the page and retry.';
							die(json_encode($returndata));
						}
					}
					else if (array_key_exists('error', $order) && $order['error'] !== NULL)
					{
						$returndata['error'] = $order['error']['description'];
						die(json_encode($returndata));
					}
					else {
						$returndata['error'] = 'Problems with your linked account, please make sure you have added the right information or contact us.';
					 die(json_encode($returndata));
					}


				}
				else
				{
					$returndata['error'] = 'Please enter a valid price!';
					die(json_encode($returndata));
				}
			}
			else
			{
				$returndata['error'] = 'All fields are mandatory. Please fill in all the fields.';
				die(json_encode($errors));
			}
		}
		else
		{
			http_response_code(405); die();
		}
	}

	public function getupdate()
	{
		$this->_render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
		{
			$_POST['page'] = null;
			if($_POST['what'] == 'getOnlyMessageCount')
			{
				$noofunreadmessages = $this->Messages->noofunreadmessages();
				echo json_encode($noofunreadmessages);
			}
			elseif ($_POST['what'] == 'getSingleMessage')
			{
				echo $this->opensinglemessage();
			}
			elseif ($_POST['what'] == 'getAllMessage')
			{
				$refreshtimeinsec = (int)$_POST['refreshtimeinsec'];
				$allmessages = $this->Messages->getallmessages((int)$_SESSION['id'],NULL, NULL, TRUE, $refreshtimeinsec);
				if($allmessages[0]['messageid'] != null)
				{
					$returndata['allmessageshtml'] = $this->allmessageshtml($allmessages, $page);
					$returndata['allthreadids'] = array_column($allmessages, 'threadid');
				}
				$returndata['noofunreadmessages'] = $allmessages[0]['noofunreadmessages'];
				echo json_encode($returndata);
			}
		}
	}
}
