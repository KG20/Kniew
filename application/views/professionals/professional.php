<?php

$joiningdate = new DateTime($professionalDetails['joiningdate']);
// $nowdate = new DateTime(date("Y-m-d H:i:s"));
// $datediff = $joiningdate->diff($nowdate)->m + ($joiningdate->diff($nowdate)->y*12); // int(8)

// CHANGEDNOV19: cause not adding subscription?
// if($professionalDetails['reference'] < 5 )
// {
// 	if(!($datediff < 6) &&  $professionalDetails['authuser'] == FALSE) $auth = FALSE;
// 	else  $auth = TRUE;
// }
// else if($professionalDetails['reference'] >=5 && $professionalDetails['reference'] < 10)
// {
// 	if(!($datediff < 12) &&  $professionalDetails['authuser'] == FALSE) $auth = FALSE;
// 	else  $auth =TRUE;
// }
// else if($professionalDetails['reference'] >= 10 && $professionalDetails['reference'] < 25)
// {
// 	if(!($datediff < 18) &&  $professionalDetails['authuser'] == FALSE) $auth = FALSE;
// 	else  $auth =TRUE;
// }
// else if($professionalDetails['reference'] >= 25)
// {
// 	if(!($datediff < 24) &&  $professionalDetails['authuser'] == FALSE) $auth = FALSE;
// 	else  $auth =TRUE;
// }
// else $auth = $professionalDetails['authuser'];
//
// if($professionalDetails['emailverified'] == FALSE ||  $auth == FALSE )
// {
// 	echo "<p class='margin10per error'>The user is inactive.</p>";
// }
// else {
?>

<div class="container-fluid card-row whitesmokeBack" id="professionalDetails">
<div class="container">

	<div class="row">
		<div class="col-sm-3 col-xs-12 sidecol">
			<div class="col-xs-4 col-sm-12 imgdiv">
				<?php if(!empty($professionalDetails['profilepic'])) { ?>
				   <img src="<?php echo BASE_PATH .$professionalDetails['profilepic'];?>" alt="'<?php echo $professionalDetails['name'];?>' " />
				<?php } else { ?>
					<div class=" imagecontainer"><i class="fa fa-user imagetext"></i></div>
				<?php } ?>
			</div>

			<div class="col-xs-8 col-sm-12 detailsdiv">
				<h1 class="pagetitle"><?php echo $professionalDetails['name']; ?></h1>
				<p class="xsmalltext"><i>Since</i> <?php echo date('d F Y', strtotime($professionalDetails['since'])); ?> </p>
				<p class = 'rating jDisabled' data-average = "<?php echo ($professionalDetails['rating'] ? $professionalDetails['rating'] : 0); ?>" data-id="<?php echo $professionalDetails['id'];?>"></p><span class="smalltext"><?php echo $professionalDetails['rating'] . " (" . $professionalDetails['noofrating'] ."<i class='fa fa-users'></i>)"; ?></span>

				<?php
				if($usertype != 5){
					if(!empty($professionalDetails['employername']) && !empty($professionalDetails['employerusername'])) {?>
				<p class="detailsLabel smalltext">Work at</p> <p><?php echo '<a href="' . BASE_PATH . 'professionals/'. str_replace(' ', '', strtolower(trim($usertypename))) .'/' . $professionalDetails['employerusername'] . '">' .$professionalDetails['employername'] .'</a>'; ?></p>
				<?php } else if(!empty($professionalDetails['workat']) && $professionalDetails['workat'] != '0') {?>
				<p class="detailsLabel smalltext">Work at</p> <p><?php echo $professionalDetails['workat']; ?></p>
				<?php }} ?>

				<p class="detailsLabel smalltext">Main Specialisation</p> <p><?php echo $professionalDetails['mainfocus']; ?></p>
				<?php $includeappoint = 0;
				 if($professionalDetails['otherfocus'] != null && $professionalDetails['otherfocus'] != 'NULL' && $professionalDetails['otherfocus'] != '{}' && $professionalDetails['otherfocus'] != '{null}' && $professionalDetails['otherfocus'] != '{NULL}' && !empty($professionalDetails['otherfocus'])){ ?>
					<p><p class="detailsLabel smalltext">Other specialisation </p><?php echo str_replace(',', ' | ', str_replace(array('\'', '"', '{', '}'), "", $professionalDetails['otherfocus'])); ?> </p> <?php }?>
					<p>
						<?php
							echo "<p class='detailsLabel smalltext'>";
							$isauthentic = '';
							if($professionalDetails['isauthentic'] === TRUE) $isauthentic = '<i class="fa fa-check-circle greentext"></i> ';
							else if($professionalDetails['isauthentic'] === FALSE) $isauthentic = '<i class="fa fa-exclamation-triangle redtext"></i> ';
							if($usertype == 2) echo 'Unique ID with NGO-DARPAN <p>'.$isauthentic.'<span id="verificationid">'. $professionalDetails['verificationid'] . '</span> <a id="toVerifySite" href="http://ngodarpan.gov.in/index.php/search/" target="_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Verify on NGO Darpan</span></i></a></p>';
							elseif($usertype == 3) echo 'Bar Council of India Registeration Number <p>'.$isauthentic.'<span id="verificationid">'. $professionalDetails['verificationid'] . '</span><a id="stateBCI" href="#"><i class="fa fa-external-link positionRelative" aria-hidden="true" target="_blank"><span class="tooltip">Verify on State Bar Council Site</span></i></a></p> ';
							elseif($usertype == 4) echo 'Medical Council India, Registration number <p>'.$isauthentic.'<span id="verificationid">'. $professionalDetails['verificationid'] . '</span> <a id="toVerifySite" href="https://www.mciindia.org/CMS/information-desk/indian-medical-register" target="_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true"><span class="tooltip">Verify on Indian Medical Register</span></i></a></p>';
							elseif($usertype ==5) echo 'ICAI member registeration number <p>'.$isauthentic.'<span id="verificationid">'. $professionalDetails['verificationid'] . '</span> <a id="toVerifySite" href="https://www.icai.org/traceamember.html" target="_blank"><i class="fa fa-external-link positionRelative" aria-hidden="true"><span class="tooltip">Verify on ICAI website</span></i></a></p>';
							echo "</p>";
						?>
						<?php include(ROOT . DS . 'application' . DS . 'views' . DS . 'widgets'.DS . 'barcouncillink.php'); ?>

					</p>

				<?php
				//CHANGEDNOV19: added is authentic logic various places
				if($professionalDetails['isauthentic'] != FALSE) { //include null for appointment
					if($professionalDetails['blockfutureappointment'] == false && isset($professionalDetails['sessionduration']) && $professionalDetails['sessionduration'] != null)
					{
						if(loggedin() == true && $_SESSION['username'] == $professionalUsername) { //CHANGEDNOV19 Added 'e' in username
							echo '<a class="btn btn-info form-control" href="' . BASE_PATH . 'profile#appointment"><i class="fa fa-pencil-calendar"></i>Appointment calendar </a>';
							} else

						{
							echo '<button class="btn btn-info form-control"  data-toggle="modal" data-target="#appointModal">Book Appointment</button>';
							$includeappoint = 1;
						}
					} else if($usertype != 2) echo '<button disabled class="btn btn-default form-control noappointment">This user does not provide online booking.</button>';
				} //end isauthentic
				if($professionalDetails['isauthentic'] !== FALSE) { //isauthentic can message if null not if false

					// CHANGEDNOV19:Added BUTTON for messages and donations
					echo "<p></p>";

					if($usertype == 2)
					{
						if(loggedin() == true && $_SESSION['username'] == $professionalUsername)
						{
							if(isset($professionalDetails['onlinesession']) && $professionalDetails['linkedaccountid'] !== null) echo '<a class="btn btn-info form-control" href="' . BASE_PATH . 'profile#transactions"><i class="fa fa-credit-card"></i> Donations </a>';
							else echo '<a class="btn btn-success form-control" href="' . BASE_PATH . 'profile#addpaymentaccount"><i class="fa fa-id-card"></i> Add Linked Account</a>';
						}
						else
						{
							if(isset($professionalDetails['onlinesession']) && $professionalDetails['linkedaccountid'] !== null){
								$encryptkey = 'linkedaccountidFromForm_' . $professionalDetails['id'];
								$lai =	Crypto::encrypt($professionalDetails['linkedaccountid'], $encryptkey , true);
								echo '<div class="positionRelative" id="donateparent">
									<button class="btn btn-info form-control" id="donateButton"  ><i class="fa fa-heartbeat"></i> Donate</button>
								 	<form class="form" action="" method = "POST"  role="form" id="donateOrderForm" data-loggedin="'.loggedin() .'">
										<i class="fa fa-times-circle pull-right closeform" aria-hidden="true"></i>
										<div class="input-group fullwidth">
											<div class="input-group-addon">
												<span class="fa fa-inr"></span>
											</div>
											<input required type="number" name="donateamount" min="10"   required class="form-control" placeholder="1000"/>
											<div class="input-group-btn">
												<button required type="submit" name="donateOrderSubmit"  class="form-control btn btn-success">
													<i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										<textarea name="note"  class="form-control resizenone" rows="2" placeholder="Add note/message..."></textarea>
										<input type="hidden" name="username" value="'.$professionalUsername.'"/>
										<input type="hidden" name="userid" value="'.$professionalDetails['id'].'"/>
										<input type="hidden" name="lai" value="'.$lai.'"/>

									</form>
								</div>
								';
							}
							else {
								echo '<button disabled class="btn btn-default form-control nomessages">This user does not accept online donations.</button>';

							}
						}

					}
					else
					{
						if(loggedin() == true && $_SESSION['username'] == $professionalUsername) {

							if(isset($professionalDetails['onlinesession'])) 	echo '<a class="btn btn-info form-control" href="' . BASE_PATH . 'messages"><i class="fa fa-envelope"></i>Messages </a>';
							else echo '<a class="btn btn-success form-control" href="' . BASE_PATH . 'profile#settings"><i class="fa fa-check"></i> Accept online messages</a>';
						}
						else
						{
							if(isset($professionalDetails['onlinesession']))
							{
								echo '<button class="btn btn-info form-control"  data-toggle="modal" data-target="#messagesModal"><i class="fa fa-envelope"></i> Message</button>';
								$includemessages = 1;
							} else echo '<button disabled class="btn btn-default form-control nomessages">This user does not provide online consultation.</button>';

						}

						}
				} //close iauthentic for only false
				else echo '<button disabled class="btn btn-danger form-control error"><b>Authentication Refuted</b> <i class="fa fa-exclamation"></i></button>';
				?>
			</div>
		</div>
		<div class="col-sm-9 col-xs-12 maincol">

			<ul class="nav nav-pills nav-fill nav-justified">
			  <li class="nav-item">
			    <a class="nav-link active crossbackground" href="#profAbout">About</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link crossbackground" href="#contactinfo">Contact</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link crossbackground" href="#costtime">Timing</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link crossbackground" href="#articleby">Articles</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link crossbackground" href="#profrating">Rating &amp; Reviews</a>
			  </li>
			</ul>

			<div class="displaystory" id="profAbout">
				<?php echo html_entity_decode(htmlspecialchars_decode($professionalDetails['about'], ENT_QUOTES)); ?>
			</div>

		<?php if($professionalDetails['isauthentic'] !== FALSE) {?>
			<div id="contactinfo">
				<h1>Contact information</h1>
				<?php echo "<p>" . ucwords(htmlspecialchars_decode($professionalDetails['formattedaddress'])) . "</p>";
							if($professionalDetails['showcontactdetails'] == true)
							{
								echo "<p>" . $professionalDetails['email'] . "</p>";
								if($professionalDetails['phone']) echo "<p>" . $professionalDetails['phone'] . "</p>";
							}
				$locationarray = explode(',', $professionalDetails['formattedaddress']);
				$country = trim($locationarray[sizeof($locationarray) - 1]);
				?>
			</div>

			<div id="costtime" class="row">
				<h1>Timing</h1>
				<!-- removing fee option -->
				<!-- <p class="col-sm-4 detailsLabel">Cost</p> <p class="col-sm-8"><?php //echo $professionalDetails['cost']; if(strtolower($country) == 'india') echo ' Rs'; else echo ' $';?></p> -->

				<?php if($professionalDetails['sessionduration']) { ?>
				<p class="col-sm-4 detailsLabel">Session Duration</p> <p class="col-sm-8">
					<?php
					if($professionalDetails['sessionduration'] >= 60)
					{
						echo ($professionalDetails['sessionduration']/60) . "hour, " . ($professionalDetails['sessionduration']/60) . " minutes";
					}
					else
					{
						echo $professionalDetails['sessionduration'] . " minutes";
					}

					?>

				</p>
				<?php } ?>

				<?php if($professionalDetails['workday']) { ?>
				<p class="col-sm-4 detailsLabel">Timing</p> <p class="col-sm-8">
					<?php
					$day = explode(",", str_replace(array("{", "}"), "", $professionalDetails['workday']));
					echo date('H:ma', strtotime($day[0])) . " - " . date('H:ma', strtotime($day[1]));

					?>
				</p>
				<?php }
				if($professionalDetails['breaktime'])
					{
						$break = explode(",", str_replace(array("{", "}"), "", $professionalDetails['breaktime']));
						echo '<p class="col-sm-4 detailsLabel">Lunch</p> <p class="col-sm-8"> ' . date('H:ma', strtotime($break[0])) . " - " . date('H:ma', strtotime($break[1])) . '</p>';

					}
				?>

				<?php if($professionalDetails['weeklyholiday']) { ?>
				<p class="col-sm-4 detailsLabel">Weekly Holiday</p> <p class="col-sm-8">
					<?php
					$week = [];
					if($professionalDetails['weeklyholiday'] == 1) $week[] = 'Monday';
					if($professionalDetails['weeklyholiday'] == 2) $week[] = 'Tuesday';
					if($professionalDetails['weeklyholiday'] == 3) $week[] = 'Wednesday';
					if($professionalDetails['weeklyholiday'] == 4) $week[] = 'Thursday';
					if($professionalDetails['weeklyholiday'] == 5) $week[] = 'Friday';
					if($professionalDetails['weeklyholiday'] == 6) $week[] = 'Saturday';
					if($professionalDetails['weeklyholiday'] == 0) $week[] = 'Sunday';

					$Holiday = implode(', ', $week);
					echo $Holiday;
					?>
				</p>
				<?php } ?>

			</div>


			<?php if($professionalDetails['workat'] == '0' && $usertype != 5) { ?>
			<div id="employees">
				<h1>Employees</h1>
				<ul id="employeesbycall" data-id="<?php echo $professionalDetails['id']; ?>" data-usertypename="<?php echo $usertypename; ?>" class='container-fluid'></ul>
				<p class ="loader"> <i class= "fa fa-spinner fa-pulse fa-2x"></i></p>
				<button class="btn btn-default" id="loadmoreemployees">Load More</button>
			</div>
			<?php } ?>
			<div id="recommendedby" class="row">
				<h1 class="col-xs-12"><?php echo $professionalDetails['name'];?> is Recommended By</h1>
				<div class="row carousel slide" id="getRecommendedby" data-id="<?php echo $professionalDetails['id'];?>">
					<div class="carousel-inner"></div>
					 <a class="left carousel-control" href="#getRecommendedby" data-slide="prev">‹</a>
					 <span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
			     <a class="right carousel-control" id="morerecommended" href="#getRecommendedby" data-slide="next">›</a>
				</div>
			</div>
			<div id="articleby">
				<h1>Articles by <?php echo $professionalDetails['name']; ?></h1>
				<ul id="articlebycall" data-articlebyid="<?php echo $professionalDetails['id']; ?>"></ul>
				<p class ="loader"> <i class= "fa fa-spinner fa-pulse fa-2x"></i></p>
				<button class="btn btn-default" id="loadmorearticleby">Load More</button>
			</div>

			<div id="recommended" class="row" data-id="<?php echo $professionalDetails['id'];?>">
				<h1 class="col-xs-12">Professionals recommended by <?php echo $professionalDetails['name'];?></h1>
			</div>
		<?php } //close is authentic?>
		</div>
	</div>

<?php if($professionalDetails['isauthentic'] !== FALSE) {?>
	<h3 id="getSimilarHead">Other professionals that may be of interest to you..</h3>
	<div class="row carousel slide" id="getSimilarOther" data-mainfocus = '<?php echo $professionalDetails['mainfocus']; ?>'  data-usertype = "<?php echo $usertype; ?>" data-location = "<?php echo $professionalDetails['formattedaddress']; ?>">
		<div class="carousel-inner"></div>
		 <a class="left carousel-control" href="#getSimilarOther" data-slide="prev">‹</a>
			<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
        <a class="right carousel-control" id="moreother" href="#getSimilarOther" data-slide="next">›</a>
	</div>

	<h3 id="getOtherHead">Similar <?php echo ucwords($usertypename); ?>...</h3>
	<div class="row carousel slide" id="getSimilarProf" data-mainfocus = '<?php echo $professionalDetails['mf_id']; ?>' data-otherfocus = '<?php echo json_encode(explode(',', str_replace(array('{', '}'), '', $professionalDetails["of_id"]))); ?>' data-professionalid = '<?php echo $professionalDetails["id"];?>' data-usertype = "<?php echo $usertype; ?>" data-location = "<?php echo $professionalDetails['formattedaddress']; ?>">
		<div class="carousel-inner"></div>
		 <a class="left carousel-control" href="#getSimilarProf" data-slide="prev">‹</a>
			<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
        <a class="right carousel-control" id="moreprof" href="#getSimilarProf" data-slide="next">›</a>
	</div>
<?php } //isauthentic close ?>

</div>

<?php if($professionalDetails['isauthentic'] != FALSE) { //two equal to include null?>
<div class="container" id="profrating">

	<div class="row percentagecontainer" >
		<div class="col-sm-5">
			<div class="centerdiv">
			<h2 class="text15vw lightgreybottomborder"> <?php echo ($professionalDetails['rating'] ? $professionalDetails['rating'] : 0); ?> </h2>
			<div class = 'smallrating jDisabled' data-average = "<?php echo ($professionalDetails['rating'] ? $professionalDetails['rating'] : 0); ?>" data-id="<?php echo $professionalDetails['id'];?>">
			</div>
			<p>	<?php echo $professionalDetails['noofrating'];?><i class="fa fa-users" aria-hidden="true"></i></p>
			</div>
		</div>

		<div class="col-sm-7" id="percentageRating" data-professionalid="<?php echo $professionalDetails['id']; ?>" data-noofrating="<?php echo $professionalDetails['noofrating']; ?>">
			<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
		</div>
	</div>


</div>
<?php } //isauthentic close ?>

</div>

<?php if($professionalDetails['isauthentic'] != FALSE) { //two equal to include null?>
<div class="container-fluid ratingscontainer" rel="nofollow">
<?php if(loggedin() == true)
{ ?>
		<?php if($_SESSION['id'] != $professionalDetails['id']) { ?><div id="giverating"
			data-id="<?php echo $professionalDetails['id']; ?>"
			data-average="0"
		></div><?php } ?>
		<div id="RC-container"
		class="loggedin" data-isdiff = "<?php if($_SESSION['id'] != $professionalDetails['id']) { echo true; } else echo false;?>"
		data-professionalid = "<?php echo $professionalDetails['id']; ?>"
		data-profilepic = "<?php if($_SESSION['profilepic']) echo BASE_PATH . $_SESSION['profilepic']; ?>"
		 >

		</div>

<?php } else { ?>
		<div id="RC-container" data-professionalid = "<?php echo $professionalDetails['id']; ?>" ></div>
<?php
} ?>
	<button type="button" class="btn btn-default col-xs-12" id="loadmoreprofcomments">Load more comments</button>
		<p class='enddiv'>End of comments</p>
</div>


<?php
	if($includeappoint == 1) include 'appointModal.php';
	//CHANGEDNOV19: added messagesModal
	if($includemessages == 1) include 'messagesmodal.php';



}//isauthentic close
?>
