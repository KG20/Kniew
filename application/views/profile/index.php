<?php
	protectPage();
	$nongoprof = null; $prof = null;
	if($_SESSION['usertype'] == 3 ||  $_SESSION['usertype'] == 4 || $_SESSION['usertype'] == 5 ) { $nongoprof = 1; }
	if($_SESSION['usertype'] == 2 || $_SESSION['usertype'] == 3 ||  $_SESSION['usertype'] == 4 || $_SESSION['usertype'] == 5) { $prof = 1; }
?>

<div class="container-fluid" id="profilecontainer">
	<div class="row">
		<div class="tabbable tabs-left">

			<!-- MENU -->
	    <ul class="nav nav-tabs col-sm-3 displayinline" id="sidenav">
				<!-- CHANGEDNOV19 : removed subscription for time being -->
		    <!-- <?php //if($prof == 1 && $_SESSION['authuser'] == FALSE) {?>
		    	<li > <a href="#payment"  class ="nav-link" data-toggle="tab" >
		        <i class="fa fa-credit-card" aria-hidden="true"></i> Payment
		      </a></li>
		    <?php// } ?> -->

				<!-- CHANGEDNOV19 ADDED PAYMENT ACCOUNT, transactions, donations -->
				<?php if($prof == 1) {?>
				 <li> <a href="#addpaymentaccount"  class ="nav-link" data-toggle="tab" >
						<i class="fa fa-id-card" aria-hidden="true"></i> Receive Payments
				 </a></li>
				<?php } ?>

			 <li > <a href="#transactions"  class ="nav-link" data-toggle="tab" >
				 <span class="fa-stack">
					 <i class="fa fa-arrows-h fa-stack-2x"></i>
					 <i class="fa fa-credit-card fa-stack-1x"></i>
				</span> Message Transactions
       </a></li>

			 <li > <a href="#donations"  class ="nav-link" data-toggle="tab" >
				 <span class="fa-stack">
					 <i class="fa fa-heartbeat"></i>
				</span> Donations
       </a></li>

       <li > <a href="#bookedappointments"  class ="nav-link" data-toggle="tab" >
          <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Booked Appointments
       </a></li>

	      <?php if($nongoprof == 1) { ?>

          <li > <a href="#appointment"  class ="nav-link" data-toggle="tab" >
	          <i class="fa fa-calendar" aria-hidden="true"></i> Appointment Calendar
	       </a></li>

		    <?php
		    }
	      if(isadmin() === true)
	      {
	      ?>
				<div class="divider bsLinkColorBack"></div>

       <li> <a href="#authenticateprofessionals" class ="nav-link" data-toggle="tab">
          <i class="fa fa-check-square-o" aria-hidden="true"></i> Authenticate Professionals
       </a></li>

			 <li> <a href="#addarticle" class ="nav-link" data-toggle="tab">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add article
       </a></li>

       <li> <a href="#addfocus" class ="nav-link" data-toggle="tab">
          <i class="fa fa-filter" aria-hidden="true"></i> Add focus
       </a></li>

       <li> <a href="#sendemail" class ="nav-link" data-toggle="tab">
          <i class="fa fa-envelope" aria-hidden="true"></i> Send Email
       </a></li>
			 <div class="divider bsLinkColorBack"></div>

       <?php } ?>

        <li> <a href="#settings" class ="nav-link" data-toggle="tab">
          <i class="fa fa-cog" aria-hidden="true"></i> Settings
       </a></li>

        <li> <a href="#changepassword" class ="nav-link" data-toggle="tab">
          <i class="fa fa-asterisk" aria-hidden="true"></i> Change Password
       </a></li>
      </ul>

			<!-- CONTENT -->
	    <div class="tab-content  col-sm-8">

				<!-- CHANGEDNOV19 : removed subscription for time being -->
		    <!-- <?php //if($prof == 1 && $_SESSION['authuser'] == FALSE) { ?>
				 <div class="tab-pane" id="payment">
					 <?php //include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'billing.php'; ?>
				 </div>
				<?php //} ?> -->

				<!-- CHANGEDNOV19 ADDED PAYMENT ACCOUNT -->
				<?php if($prof == 1) { ?>
				<div class="tab-pane" id="addpaymentaccount">
					<?php
					if($profiledata['isauthentic'] == FALSE) isNotAuthenticMessage();
					else {
						if($profiledata['linkedaccountid'] == NULL)
						{
							echo "<h3>Add Payment Account</h3>";
							if($profiledata['onlinesession'] == false || $profiledata['onlinesession'] == null)
							{
								echo "<div class='error largetext margin10per'>";
								if($_SESSION['usertype'] == 2) echo "Please choose to accept online donations through settings and reload page.";
								else echo "Please choose to provide online consultation through settings and reload page.";
								echo "</div>";
							}
							else{
					?>

					<div class="row">
					 	<p class="col-xs-12">
							<?php
								if($_SESSION['usertype'] == 2) echo "Add account to payment gateway (Razorpay), to start receving donations from users.";
								else echo "Add account to payment gateway (Razorpay) to start receving payments from users for online sessions.";
							?>
						</p>
						<div class="col-xs-12 padding2per centertext"><button id="addRazorpayAccount" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addRazorpayAccountModal">Add <img class='height18 displayinline' alt='Razorpay' src="<?php echo BASE_PATH . DS. 'images' . DS. 'icons' .DS . 'razorpay.svg'; ?>" /> Account</button></div>
						<div class="row centertext margin2per">
							<h5 class="col-xs-12 boldtext textunderline">How does it work?</h5>
							<div class='col-xs-12 col-sm-4'>
								<p class="fullwidth steelbluetext"><i class="fa fa-id-card fa-5x" aria-hidden="true"></i></p>
								<p><b class="bluetext">Step 1</b> Enter Your Account details and get linked to <?php echo WEBNAME; ?>.</p>
							</div>
							<div class='col-xs-12 col-sm-4'>
								<?php if($_SESSION['usertype'] == 2) { ?>
									<p class="fullwidth steelbluetext"><i class="fa fa-credit-card fa-5x" aria-hidden="true"></i></p>
									<p><b class="bluetext">Step 2</b> Users decide how their donations.</p>
								<?php } else { ?>
									<p class="fullwidth steelbluetext"><i class="fa fa-comments-o fa-5x" aria-hidden="true"></i></p>
									<p><b class="bluetext">Step 2</b> Connect with users and dynamically determine cost depending on each case.</p>
							<?php } ?>
							</div>
							<div class='col-xs-12 col-sm-4'>
								<p class="fullwidth steelbluetext"><i class="fa fa-inr fa-5x" aria-hidden="true"></i></p>
								<p><b class="bluetext">Step 3</b> <?php if($_SESSION['usertype'] == 2) echo "Receive donations from users to your account."; else echo "Receive payment from user and solve their problems." ;?></p>
							</div>
						</div>
						<div class="row impinfo"><b>Please note:</b> We do not save any of your bank account information.</div>
					</div>
				 	<?php
					 	include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'addrazorpayaccount.php';
					}
					}
					else
					{
						$islive = $profiledata['linkedaccountdetails']['live'] ? 'and live' : '';
					?>
						<h3>Linked Account Details</h3>
						<div class="padding2per zigzagBack crossbackground roundcorners2per">
							<div class="row">
								<div class="col-xs-12 col-sm-3 boldtext">Name</div><div class="col-xs-12 col-sm-9">'<?php echo $profiledata['linkedaccountdetails']['name']; ?>'</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-3 boldtext">Business Name</div><div class="col-xs-12 col-sm-9">'<?php echo $profiledata['linkedaccountdetails']['account_details']['business_name']; ?>'</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-3 boldtext">Email</div><div class="col-xs-12 col-sm-9">'<?php echo $profiledata['linkedaccountdetails']['email']; ?>'</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-3 boldtext">Status</div><div class="col-xs-12 col-sm-9">'<?php echo $profiledata['linkedaccountdetails']['activation_details']['status'].$islive ; ?>'</div>
							</div>
						</div>
					<?php
						}
					}
					?>
				</div>
			 <?php }  ?>

			 <!-- TRANSACTIONS -->
				<div class="tab-pane" id="transactions">
					<?php if($prof == 1) {
						if($profiledata['isauthentic'] == FALSE)
						{
							echo '<div class="body margin2per"><h3 class="lightgreenbottomborder row">All payments received by you </h3>';
							isNotAuthenticMessage();
							echo "</div>";
						}
						else {?>
						<div id="paymentsRecieved" class="body margin2per">
							<h3 class="lightgreenbottomborder row">All payments received by you </h3>
							<p id="paymentsRecievedContainer"></p>
							<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
							<div class="row"><button type="button" class="btn btn-default col-xs-12" id="loadmorepaymentsreceived">Load more</button></div>
							<p class='enddiv marg2per'>No more payments made to you.</p>
						</div>
					<?php } } ?>
					<div id="paymentsMade" class="body margin2per">
						<h3 class="lightgreenbottomborder row">Payments made by you</h3>
						<p id="paymentsMadeContainer"></p>
						<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
						<div class="row"><button type="button" class="btn btn-default col-xs-12" id="loadmorepaymentsmade">Load more</button></div>
						<p class='enddiv marg2per'>No more payments made by you.</p>
					</div>
				</div>
			 <!-- DONATIONS -->
			 <div class="tab-pane" id="donations">
				 <?php if($prof == 1 && $_SESSION['usertype'] == 2) {
					 if($profiledata['isauthentic'] == FALSE)
					 {
						 echo '<div class="body margin2per"><h3 class="lightgreenbottomborder row">All Donations received by you </h3>';
						 isNotAuthenticMessage();
						 echo "</div>";
					 }
					 else {
					 ?>
					 <div id="donationsRecieved" class="body margin2per">
						 <h3 class="lightgreenbottomborder row">All donations received by you </h3>
						 <p id="donationsRecievedContainer"></p>
						 <span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
						 <div class="row"><button type="button" class="btn btn-default col-xs-12" id="loadmoredonationsreceived">Load more</button></div>
						 <p class='enddiv marg2per'>No more donations made to you.</p>
					 </div>
				 <?php } } ?>
				 <div id="donationsMade" class="body margin2per">
					 <h3 class="lightgreenbottomborder row">Donations made by you</h3>
					 <p id="donationsMadeContainer"></p>
					 <span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
					 <div class="row"><button type="button" class="btn btn-default col-xs-12" id="loadmoredonationsmade">Load more</button></div>
					 <p class='enddiv marg2per'>No more donations made by you.</p>
				 </div>
			 </div>

			 <!-- BOOKED APPOINTMENTS -->
			 <div class="tab-pane" id="bookedappointments">
				<h3>Appointment booked by you.. </h3>
				<p id="bookedappointmentscontainer"></p>
				<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
				<button type="button" class="btn btn-default col-xs-12" id="loadmorebooked">Load more</button>
				<p class='enddiv marg2per'>No more appointments with this account.</p>
			 </div>

				<!-- Appointment -->
				<?php if($nongoprof == 1)
					{
				?>

       	<div class="tab-pane" id="appointment">
         <?php
				 if($profiledata['isauthentic'] == FALSE) isNotAuthenticMessage();
					else {
				 if(isset($profiledata['appointmentsettingid']) && $profiledata['blockfutureappointment'] == false && $profiledata['sessionduration'] != NULL){

         	echo '<div id="appointmentCalendarContainer">
					<div id="appointmentCalendar" data-professionalid = "'.$_SESSION['id'].'" data-country = "'.trim($profiledata['country']).'"> </div>
					</div>';
					?>
					<div class="row legend">
						<i class="NAlabel fa fa-square col-xs-2"></i><p class="col-xs-10 smalltext">User's appointments booked with you.</p>
						<i class="WAlabel fa fa-square col-xs-2"></i><p class="col-xs-10 smalltext">User's Weekly appointments booked with you.</p>
						<i class="PHlabel fa fa-square col-xs-2"></i><p class="col-xs-10 smalltext">Your personal holidays, users won't be able to book on these time slots/dates (click and drag on the calendar to block these time). </p>
						<i class="NHlabel fa fa-square col-xs-2"></i><p class="col-xs-10 smalltext">National holidays</p>
						<p class="col-xs-12 smalltext">You can cancel any of these by clicking the cross on top, hover on it to know the details, click and drag to block time period.</p>
					</div>

					<?php
			    }
			    else echo "<div>Choose your appointment settings below, once you do so, the users will be able to book appointments with you</div>";
			    ?>

			    <div  class="container-fluid">
						<button id = "appointCollapseButton" class="btn btn-info col-xs-12" type="button" data-toggle="collapse" data-target="#appointmentSettings" aria-expanded="false" >
						  <i class="fa fa-cog" aria-hidden="true"></i> Appointment Settings
					  </button>
					</div>
					<?php
						$weeklyHolidays = explode(",", str_replace(array("{", "}"), "", $profiledata['weeklyholiday']));
					?>

					<div class="collapse" id="appointmentSettings">
						<form class="container-fluid " action=" " method="post" id="appointmentSetting" data-toggle="validator">
							<div class="form-group">
								<label for="duration">Duration of each appointment</label>
								<div>
									<input type="number" name="duration" id ="duration" class="form-control" min="5" value="<?php echo $profiledata['sessionduration']; ?>" required>
								</div>
							</div>

							<div class="form-group ">
								<label >Weekly holiday</label>
								 <div class="input-group">
									<div class="input-group-btn">
										<button tabindex="-1"  data-toggle="dropdown" class="btn btn-default col-xs-11 dropdown-toggle" type="button">Select Days</button>
										<button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
										<span class="caret"></span>
										</button>
										<ul role="menu" class="dropdown-menu fullwidth">

											<li><a href="#">
												<input type="checkbox" value="1" name="weeklyHoliday[]" <?php if (in_array(1,$weeklyHolidays)) echo 'checked'; ?>>
												<span class="lbl"> Monday</span>
											</a></li>
											<li><a href="#">
												<input type="checkbox" value="2" name="weeklyHoliday[]" <?php if (in_array(2,$weeklyHolidays)) echo 'checked'; ?>>
												<span class="lbl">Tuesday</span>
											</a></li>
											<li><a href="#">
												<input type="checkbox" value="3" name="weeklyHoliday[]" <?php if (in_array(3,$weeklyHolidays)) echo 'checked'; ?>>
												<span class="lbl">Wednesday</span>
											</a></li>
											<li><a href="#">
												<input type="checkbox" value="4" name="weeklyHoliday[]" <?php if (in_array(4,$weeklyHolidays)) echo 'checked'; ?>>
												<span class="lbl">Thursday</span>
											</a></li>
											<li><a href="#">
												<input type="checkbox" value="5" name="weeklyHoliday[]" <?php if (in_array(5,$weeklyHolidays)) echo 'checked'; ?>>
												<span class="lbl">Friday</span>
											</a></li>
											<li><a href="#">
												<input type="checkbox" value="6" name="weeklyHoliday[]" <?php if (in_array(6,$weeklyHolidays)) echo 'checked'; ?>>
												<span class="lbl">Saturday</span>
											</a></li>
											<li><a href="#">
												<input type="checkbox" value="0" name="weeklyHoliday[]" <?php if (in_array(0,$weeklyHolidays)) echo 'checked'; ?>>
												<span class="lbl">Sunday</span>
											</a></li>

										</ul>
									</div>
								</div>
							</div>

							<!-- CHANGEDNOV19 removing fee -->
							<!-- <div class="form-group">
								<label for="fee" >Appointment Fee</label>
								<div>
									<input type="number" name="fee" class="form-control" min=10 required value="<?php //echo $profiledata['cost']; ?>">
								</div>
							</div> -->

							<div class="form-group ">
								<label for="allowWeekly" >
								<input type="checkbox" value="1" id="weeklyAppointment" name="weeklyAppointment" <?php if ($profiledata['weeklyappointment']) echo 'checked'; ?>>Allow Weekly Appointment
								</label>
							</div>

							<div class="form-group " id="tillDate">
								<label for="maxdate">Users can book appointment from current day till</label>
								<select class="form-control" id="maxdate" name="maxdate" required>
									<option value="0.5" <?php if ($profiledata['maxdate'] == 0.5) echo 'selected'; ?>>15 Days</option>
									<option value="1" <?php if ($profiledata['maxdate'] == 1) echo 'selected '; ?>>1 Month</option>
									<option value="2" <?php if ($profiledata['maxdate'] == 2) echo 'selected '; ?>>2 Months</option>
									<option value="3" <?php if ($profiledata['maxdate'] == 3) echo 'selected '; ?>>3 Months</option>
									<option value="6" <?php if ($profiledata['maxdate'] == 6) echo 'selected '; ?>>6 Months</option>
									<option value = "12" <?php if ($profiledata['maxdate'] == 12) echo 'selected '; ?>>1 Year</option>
									<option value="0" <?php if ($profiledata['maxdate'] == 0) echo 'selected '; ?>>Never</option>
								</select>
							</div>

							<input type="hidden" name="professionalid" value="<?php echo $_SESSION['id']; ?>">
							<div class="form-group">
								<button id="appointmentSettingButton" type = "submit" name="appointmentSettingButton" class="btn btn-success col-xs-12" value="Submit">Save Settings</button>
							</div>
							<!--skip/delete system form-->
						</form>

						<div class="row" id="ASmodify">
							<?php if($profiledata['blockfutureappointment']){ ?>
							<div class = "col-md-6">
								<button type="button " id="unblockFutureAppointments" class = "btn btn-success blockAndDeleteAppoint "  data-professionalid = "<?php echo $_SESSION['id']; ?>"> Unblock appointment system </button>
								<div class="smalltext">All your data will be retrieved and users will be able to book appointments</div>
							</div>
							<?php }else{ ?>
							<div class = "col-md-6">
								<button type="button" id="blockFutureAppointments" class = "btn btn-warning blockAndDeleteAppoint"  data-professionalid = "<?php echo $_SESSION['id']; ?>"> Disable appointment system </button>
								<div class="smalltext">All your data will be safe but users will no longer be able to book appointments with you. However, already booked appointments will not be cancelled</div>
							</div>
								<?php }?>
							<div class = "col-md-6">
								<button type="button" id="deleteAppointSettingsData" class="btn  btn-danger blockAndDeleteAppoint"  data-professionalid = "<?php echo $_SESSION['id']; ?>"> Delete appointment system </button>
								<div class="smalltext">Your settings will remain the same, but all your appointments will be deleted and prevent user from booking appointments with you. </div>
							</div>
						</div>

					</div>
					<div id="appointerror" class="container-fluid"></div>
				<?php } //close else for isauthentic ?>
		    </div>

        <?php
	       	}
				  if(isadmin() === true)
				  {
			  ?>

				<!-- AUTHENTICATE PROFESSIONALS (FOR ADMIN) -->
				<div class="tab-pane" id="authenticateprofessionals">
					<!-- <h2>Authenticate Professionals</h2> -->
					<p>Verify professional's registeration id and the associated details. If verified, authenticate professionals.</p>
					<div class="row crossbackground padding5per">
						<div class="row carousel slide" id="getProfToBeAuthenticated" data-interval="false">
							<div class="carousel-inner"></div>
						  <a class="left carousel-control" href="#getProfToBeAuthenticated" data-slide="prev">‹</a>
						  <p class="loadericon ellipsis-anim textalignright"><span>.</span><span>.</span><span>.</span></p>
				      <a class="right carousel-control" id="moreauthenticateprof" href="#getProfToBeAuthenticated" data-slide="next">›</a>
						</div>
					</div>
				</div>

				<!-- ADD ARTICLE (FOR ADMIN) -->
		    <div class="tab-pane" id="addarticle">
			    <form name="addarticle" method="POST" id="addarticleform" action=" "  enctype="multipart/form-data" autocomplete="off">
				    <div class="form-group">
		          <label>Title </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-header"></span>
                </div>
                <input required type="text" name="title"  class="form-control" placeholder="Heading of the article"/>
              </div>
			      </div>

            <div class="form-group">
              <label>Article </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-pencil-square-o"></span>
                </div>
                <textarea name="story"  class="form-control story" rows = "10" placeholder="Add article.."></textarea>
              </div>
            </div>

            <div class="form-group">
              <label>Tags </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-filter"></span>
                </div>

                <select required multiple name="tags[]" class="form-control" id="tags" data-role="tagsinput">
                  <?php
                    foreach ($tags as $option)
                    {
                      if($option['type'] == 2 && $typeS == 0)
                      {
                        echo "<optgroup label = 'Social issues'>";
                        $typeS = 1;
                      }
                      if($option['type'] == 3 && $typeL == 0)
                      {
                        echo "</optgroup>";
                        echo "<optgroup label = 'Law'>";
                        $typeL = 1;
                      }
                      if($option['type'] == 4 && $typeM == 0)
                      {
                        echo "</optgroup>";
                        echo "<optgroup label = 'Medicine'>";
                        $typeM = 1;
                      }
                      echo "<option value = '" . $option['focus'] . ',' . $option['type'] . "'>" . $option['focus'] . "</option>";
                    }
                  ?>
                    </optgroup>
                </select>
              </div>
            	<p class="impinfo">Hold down ctrl and click to select multiple options</p>
            </div>

            <div class="form-group">
              <label>Author's Username or name </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-user"></span>
                </div>
                <input type="text" name="author"  class="form-control usernamesearch" placeholder="search for username" id="author" />
              </div>
              <div id="usernameresult" ></div>
            </div>

            <input type="hidden" name="authorid"  class="form-control" id="authorid" />

            <div class="form-group">
              <label>About author (not required if signed user) </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <span class="fa fa-info"></span>
                </div>
                <textarea name="aboutauthor"  class="form-control" placeholder="Tell us about the author..." id="aboutauthor" ></textarea>
              </div>
          	</div>

			      <div id="addarticleimage"> <?php include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'imageeditor.php'; ?></div>

            <div class="form-group">
             <input name="add" type="submit" id="add" value="Publish" class="btn btn-info">
			       <button class="btn btn-default" type ="button" id="canceladdarticle" >Cancel</button>
            </div>
			    </form>
	        <div id="addarticlecomplete"></div>
		    </div>

				<!-- ADD FOCUS (FOR ADMIN) -->

		    <div class="tab-pane" id="addfocus">
		      <form class="form" method="POST" autocomplete="off">
		        <p class="col-sm-12">Select type first.</p>
		        <input type="hidden" name="id" value="<?php echo $profiledata['id']; ?>">
		        <?php for ($i=0; $i < 5 ; $i++) { ?>
		        <div class="col-xs-12 addfocusrepeatdiv <?php if($i%2 == 0) echo 'whitesmokeBack'; ?>">
		         	<div class="form-group col-sm-3">
		         		<label>Select type</label>
		         		<select name="category[]" class="form-control addfocus_type" data-selectid="<?php echo $i;?>">
			         		<option></option>
		         			<option value="5">Chartered Accountants</option>
		         			<option value="3">Lawyers</option>
		         			<option value="4">Doctors</option>
		         			<option value="2">Non-profits</option>
		         			<option value="0">Articles</option>
		         		</select>
							</div>
							<div class="form-group col-sm-3">
								<label>Parent</label>
								<select name ="mainfocus[]" class="form-control addmainfocusbytype" data-selectid="<?php echo $i;?>">
									<option  value="">None</option>
								</select>
							</div>
							<div class="form-group col-sm-6">
							<label>Add Specialisation</label>
							<input type="text" name="focus[]" list="focuslist_<?php echo $i;?>" class="form-control">
							<datalist class="focuslist" id="focuslist_<?php echo $i;?>" data-selectid="<?php echo $i;?>">
							</datalist>
						</div>
						</div>
		        <?php } ?>
		        <div class="smalltext col-sm-12">If you want to add a new specialisation as parent, choose none as the parent specialisation.</div>
	         	<div class="form-group col-sm-12">
	            <input name="addfocussubmit" type="submit" id="addfocussubmit" value="Add Focus" class="col-sm-4 btn-lg btn-info pull-right">
	          </div>
		      </form>
		    </div>

				<!-- SEND EMAIL -->
		    <div class="tab-pane" id="sendemail">
					<form class="form" method="POST" autocomplete="off">
				    <div class="form-group">
			        <label>Send to</label>
	         		<select name="sendto" class="form-control" required>
	         			<option value="everybody" selected="true">Everybody</option>
	         			<option value="1">Users</option>
	         			<option value="professionals">Professionals</option>
	         			<option value="5">Chartered Accountants</option>
	         			<option value="3">Lawyers</option>
	         			<option value="4">Doctors</option>
	         			<option value="2">Non-profits</option>
	         		</select>
						</div>
						<div class="form-group">
			        <label>Subject </label>
		          <input required type="text" name="subject"  class="form-control" placeholder="Subject of the Email"/>
			      </div>
            <div class="form-group">
              <label>Content </label>
              <textarea name="content"  class="form-control story" rows = "20" placeholder="Add email body" required></textarea>
            </div>
			      <p class="impinfo">The system will automatically add salutations, Please add rest of the body and your details at the end (from).</p>
			      <div class="form-group">
			        <input name="sendemail" type="submit" value="Send Email" class="btn-lg pull-right btn-success">
						</div>
			    </form>
			    <div id="sendemailresult" class="col-xs-12"></div>
				</div>

			<?php }?>

				<!-- SETTINGS -->
		    <div class="tab-pane" id="settings">

		      <?php if($prof == 1){ ?>
				    <form class="form" method="POST"  id="profsettings"  enctype="multipart/form-data" autocomplete="off">

							<input type="hidden" id="profsettings_id" name="id" value="<?php echo $_SESSION['id']; ?>">
			        <input type="hidden" name="oldimage" value="<?php echo $profiledata['profilepic']; ?>">
					    <div class="row">
								<div class="col-sm-5" id="profilepic_prof">
									<button type="button" id="deleteprofpic" class="col-xs-1  btn-xs btn-default noborder xsmalltext">
					          <span class="fa-stack">
										  <i class="fa fa-file-image-o fa-stack-1x"></i>
										  <i class="fa fa-ban fa-stack-2x text-danger"></i>
										</span>
	             		</button>
		             <div class="col-xs-11"><?php $_GET['imgurl'] =  $profiledata['profilepic'];
			             include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'imageeditor.php'; ?>
		             </div>
								</div>

								<div class="col-sm-7">
									<div class= "form-group">
										<div class="col-xs-12">
		                  <label>Name* </label>
		                  <div class="input-group">
		                    <span class="input-group-addon">
		                      <span class="fa fa-user"></span>
		                    </span>
		                    <input required type="text" name="name" value="<?php echo $profiledata['name'];?>" class="form-control"/>
		                  </div>
		                </div>
									</div>

									<div class="form-group">
						        <div class="col-xs-12">
				              <label>Username* </label>
				              <div class="input-group">
			                  <div class="input-group-addon">
			                    <span class="fa fa-user"></span>
			                  </div>
			                  <input required type="text" name="username"  class="form-control" value="<?php echo $profiledata['username'];?>"  data-oldusername = "<?php echo $profiledata['username'];?>"/>
				              </div>
						        </div>
						      </div>

									<div class="form-group">
							      <div class="col-xs-12">
			                <label>Email*</label>
			                <div class="input-group">
			                  <span class="input-group-addon">
			                    <span class="fa fa-envelope"></span>
			                  </span>
			                  <input required type="email" name="email" class="form-control" value="<?php echo $profiledata['email'] ?>" data-oldemail = "<?php echo $profiledata['email'];?>"/>
			                </div>
			              </div>
									</div>

									<div class= "form-group">
										<div class="col-xs-12">
		                  <label>Practising Since* </label>
		                  <div class="input-group date">
		                    <span class="input-group-addon">
		                      <span class="fa fa-calendar"></span>
		                    </span>
		                    <input type="text" name="since" id="since" class="form-control" value="<?php if(!empty($profiledata['since'])) echo date_format(date_create($profiledata['since']),'d/m/Y');?>" placeholder="DD/MM/YYYY" required/>
												<!-- <input type="text" name="since" class="form-control" id="since" required /> -->
		                  </div>
		                </div>
									</div>

									<div class= "form-group">
										<div class="col-xs-12">
		                  <label>Phone Number </label>
		                  <div class="input-group">
		                    <span class="input-group-addon">
		                      <span class="fa fa-phone"></span>
		                    </span>
		                    <input type="tel" name="phone" class="form-control" placeholder="xxxxxxxxxx" value="<?php echo $profiledata['phone'];?>"/>
		                  </div>
	                	</div>
							    </div>

							    <?php
							    $employer = null;
							    if(!empty($profiledata['employername']))
						    	{
						    		$employer = $profiledata['employername'];
						    		$workatid = $profiledata['workat'];
						    	}
									else if(!empty($profiledata['workat']) && $profiledata['workat'] != '0') $employer = $profiledata['workat'];
									if($_SESSION['usertype'] != 5){
									?>

							    <div class= "form-group">
										<div class="col-xs-12">
	                  	<label>Work </label>
	                  	<div class="input-group">
		                    <span class="input-group-addon">
		                      <span class="fa fa-briefcase"></span>
		                    </span>
	                    	<input type="text" name="workatname" id="workatname" class="form-control" placeholder="Search for your employer..." list="workatlist" value="<?php echo $employer;?>"/>
	                    	<datalist id="workatlist"></datalist>
	                    	<input type="hidden" name="workatid" id="workatid" value="<?php if(!empty($workatid)) echo $workatid; ?>"/>
	                  	</div>
	                	</div>
									</div>
								<?php } if($_SESSION['usertype'] == 3 && $_SESSION['usertype'] == 4) { ?>
									<div class="form-group col-xs-12">
										<label for="isfirm" >
											<input type="checkbox" value="true" name="isfirm" <?php if($profiledata['workat'] == '0') echo 'checked'; ?>>
										 	This is an organisation itself.<a href="#" data-toggle="popover" title="" data-content="If you are making an account for your firm/organisation, tick this box. This will help people find you more efficiently, and your employees will be able to list you as their employer. " data-trigger="focus"><i class="fa fa-info-circle"></i></a>
										</label>
									</div>
									<?php } ?>
									<div class= "form-group col-xs-12">
		                <label>Fluent in*   <a href="#" data-toggle="popover" title="" data-content="Please only enter languages you can fluenty speak. Seprate each language by a comma. " data-trigger="focus"><i class="fa fa-info-circle"></i></a></label>
		                <div class="input-group">
		                  <span class="input-group-addon">
		                    <span class="fa fa-language"></span>
		                  </span>
		                  <input type="text" name="language" class="form-control percentagebarclass" placeholder="English, Hindi" required  value="<?php echo str_replace(array('{', '}'), '', $profiledata['language']);?>"/>
		                </div>
									</div>

									<!-- CHANGEDNOV19 : input to div cause once entered this cant be changed -->
									<div class= "form-group col-xs-12">
										<?php
											$verifyText;
											if($_SESSION['usertype'] == 2) $verifyText = 'Unique ID with NGO-DARPAN';
			                elseif($_SESSION['usertype'] == 3) $verifyText = 'Bar Council of India Registeration Number';
			                elseif($_SESSION['usertype'] == 4) $verifyText = 'Medical Council India, Registration number';
			                elseif($_SESSION['usertype'] ==5) $verifyText = 'ICAI member registeration number';
											echo "<b>".$verifyText."</b> : ". $profiledata['verificationid'];
				             if($profiledata['isauthentic'] !== true) {?>
											<button class="btn btn-sm xsmalltext" type="button" id="changeVerificationId"><i class="fa fa-pencil"></i> change</button>

										<?php } ?>

		                <!-- <div class="input-group">
		                  <span class="input-group-addon">
		                    <span class="fa fa-id-card"></span>
		                  </span>
		                  <input type="text" name="verificationid" class="form-control" placeholder=""  value="<?php// echo $profiledata['verificationid'];?>"/>
		                </div>-->
									</div>
								</div>
							</div>

							<div class="row">
								<div class="form-group col-xs-12 col-sm-4">
									<label for="isfree" >
										<input type="checkbox" value="true" name="isfree" <?php if($profiledata['isfree']) echo 'checked';?>>
										<?php
											if($_SESSION['usertype'] == 2) echo '<span class="isfreelabel">Provide free consultation <a href="#" data-toggle="popover" title="" data-content="Do you provide consultation to people in need? For example - legal advice." data-trigger="focus"><i class="fa fa-info-circle"></i></a></span>';
						          elseif($_SESSION['usertype'] == 3) echo '<span class="isfreelabel">Pro-bono <a href="#" data-toggle="popover" title="" data-content="Do you do pro-bono work?" data-trigger="focus"><i class="fa fa-info-circle"></i></a></span>';
						          elseif($_SESSION['usertype'] == 4) echo '<span class="isfreelabel">Free clinic/consultation</span>';
						          elseif($_SESSION['usertype'] ==5) echo '<span class="isfreelabel">Free consultation</span>';
					          ?>
									</label>
								</div>
								<div class="form-group col-xs-12 col-sm-4">
									<label for="onlinesession" >
										<input type="checkbox" value="true" name="onlinesession" <?php if($profiledata['onlinesession']) echo 'checked';?>>
										<?php
											if($_SESSION['usertype'] == 2) echo 'Do you accept online donations? <a href="#" data-toggle="popover" title="" data-content="If you choose not to select this option, users will NOT be able to donate to your account. " data-trigger="focus"><i class="fa fa-info-circle error"></i></a>';
											else echo 'Do you provide online counselling? <a href="#" data-toggle="popover" title="" data-content="If you choose not to select this option, users will NOT be able to message you. " data-trigger="focus"><i class="fa fa-info-circle error"></i></a>';
										?>
									</label>
								</div>
								<!-- </div> -->
								<div class="form-group col-xs-12" >
									<?php
										$jurisdiction = explode(',', str_replace(array('{','}','"', '\''), '', $profiledata['jurisdiction']));
										if($_SESSION['usertype'] == 2)
										{
											?>
											<div>
												<p>Level of support <a href="#" data-toggle="popover" title="" data-content="This specifies the extent of your support from where you are based." data-trigger="focus"><i class="fa fa-info-circle"></i></a></p>
												<input type="checkbox" value="City Wide" name="jurisdiction[]" <?php if(in_array('City Wide', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]" >City Wide </label>
												<input type="checkbox" value="State Wide" name="jurisdiction[]" <?php if(in_array('State Wide', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">State Wide </label>
												<input type="checkbox" value="Country Wide" name="jurisdiction[]" <?php if(in_array('Country Wide', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">Country Wide </label>
											</div>
											<?php
										}
		                elseif($_SESSION['usertype'] == 3)
		              	{
		              	?>
					            <div>
			                	<p>Appear in</p>
				                <input type="checkbox" value="District Court" name="jurisdiction[]" <?php if(in_array('District Court', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">District Court </label>
				                 <input type="checkbox" value="High Court" name="jurisdiction[]" <?php if(in_array('High Court', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">High Court </label>
				                <input type="checkbox" value="Supreme Court" name="jurisdiction[]"  <?php if(in_array('Supreme Court', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]" >Supreme Court </label>
				                 <input type="checkbox" value="Revenue Board" name="jurisdiction[]" <?php if(in_array('Revenue Board', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">Revenue Board </label>
				                  <input type="checkbox" value="Tax Board" name="jurisdiction[]" <?php if(in_array('Tax Board', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">Tax Board </label>
							        </div>
						      	<?php
							      }
						        elseif($_SESSION['usertype'] == 4)
						        {
						        ?>
		              		<div><p>Provide services at</p>
			              		<input type="checkbox" value="Hospital" name="jurisdiction[]" <?php if(in_array('Hospital', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">Hospital </label>
			              		<input type="checkbox" value="Clinic" name="jurisdiction[]" <?php if(in_array('Clinic', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">Clinic </label>
			              		<input type="checkbox" value="Home Visits" name="jurisdiction[]" <?php if(in_array('Home Visits', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">Home Visits </label>
											</div>
						        <?php
						        }
		                elseif($_SESSION['usertype'] ==5)
		              	{
		              	?>
		              		<div>
			                	<p>Level</p>
				                <input type="checkbox" value="Local" name="jurisdiction[]" <?php if(in_array('Local', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">Local </label>
				                 <input type="checkbox" value="State" name="jurisdiction[]" <?php if(in_array('State', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]">State </label>
				                <input type="checkbox" value="National" name="jurisdiction[]" <?php if(in_array('National', $jurisdiction)) echo 'checked' ?>><label for="jurisdiction[]" >National </label>
			                </div>
						        <?php
							      }
				          ?>

								</div>
							</div>

							<div class="row">

								<div class= "form-group fullwidth margin2per">
					          <label>About You </label>
					          <textarea name="about" class="form-control profAboutSetting" rows="20" placeholder="Please insert text here." id="prof_about" ><?php echo $profiledata['about'];?></textarea>
								</div>

								<div class="form-group">
									<div class="col-xs-12">
										<label>Specialisation*</label>
										<select id = "profsettingsMainfocus" name="mainfocus" class="form-control"  data-old = "<?php echo $profiledata['mainfocus'];?>" required data-type="<?php echo $_SESSION['usertype'];?>">
										</select>
									</div>
								</div>

								<div class="form-group">
									<div class="col-xs-12">
										<label>Other Focus(optional)</label>
										<select multiple id="profsettingsOtherfocus" name="otherfocus[]" class="form-control" data-old = "<?php echo $profiledata['otherfocus'];?>" data-type="<?php echo $_SESSION['usertype'];?>">
										</select>
										<p class="impinfo">Hold down ctrl and click to select multiple options</p>
									</div>
								</div>

								<?php
									$day = explode(",", str_replace(array("{", "}"), "", $profiledata['workday']));
									$break = explode(",", str_replace(array("{", "}"), "", $profiledata['breaktime']));
								?>

					      <div class="form-group  col-md-6">
									<label for="starttime" class="col-md-4">Work Timing*</label>
									<div class="col-md-8">
										<div class='input-group date' id='startTime1'>
											<input required type="text" name="workday[0]" id="starttime"  class="form-control" value="<?php echo date('H:m', strtotime($day[0])); ?>"/>
											<span class="input-group-addon">
									      <span class="fa fa-clock-o"></span>
									    </span>
								    </div>
										 to
										<div required class='input-group date' id='endTime1'>
										 <input type="text" name="workday[1]" id="endtime"  class="form-control" value="<?php   echo date('H:m', strtotime($day[1])); ?>">
										 <span class="input-group-addon">
								        <span class="fa fa-clock-o"></span>
								      </span>
								    </div>
									</div>
								</div>

								<div class="form-group  col-md-6">
									<label for="breakstarttime" class="col-md-4">Break Timing</label>
									<div class="col-md-8">
										<div class='input-group date' id='breakstartTime1'>
											<input type="text" name="breaktime[0]" id="breakstarttime"  class="form-control" value="<?php echo date('H:m', strtotime($break[0])); ?>">
											<span class="input-group-addon">
								        <span class="fa fa-clock-o"></span>
									    </span>
								    </div>
										 to
										<div class='input-group date' id='breakendTime1'>
											<input type="text" name="breaktime[1]" id="breakendtime"  class="form-control" value="<?php echo date('H:m', strtotime($break[1])); ?>">
											<span class="input-group-addon">
									      <span class="fa fa-clock-o"></span>
									    </span>
								    </div>
									</div>
								</div>

								<div class= "form-group col-xs-12">
									<div class="col-xs-12">
					          <label>Location* </label>
	                  <div class="input-group">
	                    <span class="input-group-addon">
	                      <span class="fa fa-map-marker"></span>
	                    </span>
	                    <input required type="text" name="formattedaddress" onFocus="geolocate()" class="form-control" placeholder="Search your address..." id="geolocateAddress" value="<?php echo $profiledata['formattedaddress'];?>"/>
	                    <span class="input-group-addon searchAddress" ><i class="fa fa-search" aria-hidden="true"></i></span>
	                  </div>
	                </div>
					        <p class="impinfo col-xs-12">*You can search in the address box above or click on the map to fill up the fields below, they <i>cannot be manually edited</i>. If you cannot find your address try a broad search and you can edit the address in the bar above to your preference later.</p>
	                <div class="col-xs-12">
			            	<div id = "googleMap" ></div>
	                </div>
								</div>

								<!-- CHANGEDNOV19 -->
								<div class= "form-group checkbox checkbox-success col-xs-12">
									<label>
						        <input type="checkbox" name="showcontactdetails" <?php if($profiledata['showcontactdetails'])  echo "checked"; ?> />
						        &nbsp; Show others your contact details on your profile page
						      </label>
								</div>

								<div class= "form-group checkbox checkbox-success col-xs-12">
									<label  >
		                <input type="checkbox" name="allowemail" value="TRUE" <?php if($profiledata['allowemail'])  echo "checked"; ?> />
		                Get updates sent to your inbox <a href="#" data-toggle="popover" title="" data-content="You will still receive important information about your profile." data-trigger="focus"><i class="fa fa-info-circle"></i></a>
	                </label>
								</div>

					      <div class= "form-group">
									<label>Recommend other professionals <a href="#" data-toggle="popover" title="" data-content="You can recommend another professional registered with Kniew, just search by Name or Username. Try recommending professional who complements your service. For example, if you are a Lawyer, try recommending a CA. You can recommend up to 3 professionals, separate each name using a comma." data-trigger="focus"><i class="fa fa-info-circle"></i></a></label>
							    <div class="input-group marginbottom0">
							      <span class="input-group-addon">
							        <span class="fa fa-users"></span>
							      </span>

							      <input type="text" name="recommendname" id="recommendname" class="form-control recommendname" placeholder="Search for other professionals..."/>
							      <!-- <datalist id="recommendlist"></datalist> -->
				            <?php
					            $recommendation = explode(',', str_replace(array('{','}','"', '\''), '', $profiledata['recommendation']));
				            ?>
				            <input type="hidden" name="recommendids[0]" id="recommendid0" value="<?php if(isset($recommendation[0])) echo $recommendation[0]; ?>">
				            <input type="hidden" name="recommendids[1]" id="recommendid1" value="<?php if(isset($recommendation[1])) echo $recommendation[1]; ?>">
				            <input type="hidden" name="recommendids[2]" id="recommendid2" value="<?php if(isset($recommendation[2])) echo $recommendation[2]; ?>">
							    </div>
							    <div id="recommendresult"></div>
									<p class="impinfo">(upto 3, separate by comma)</p>
								</div>

								<div class="form-group col-sm-12">
									<!-- <?php
										// if($_SESSION['authuser'] == TRUE)
										// {
									?>
									<button type="button" id="cancelsubscription" class="btn btn-sm" data-id="<?php echo $_SESSION['id']; ?>">Cancel subscription</button>
									<?php //} ?> -->
				          <input type="submit" value="Update!" class="col-sm-4 btn-lg btn-warning pull-right">
					      </div>
							</div>

						</form>
						<?php if($profiledata['verificationid'] !== true) {?>
							<div id="changeVerificationIdModal" class="modal fade" >
								<div  class="modal-dialog">
								 <div class="modal-content">
									 <div class="modal-header fail centertext">
										 <h3> Change <?php echo $verifyText; ?> </h3>
									 </div>

									 <form class="form" action="" method = "POST"  role="form" id="changeVerificationIdForm">
										 <div class="modal-body">
											 <div class="form-group">
												 <div class="input-group">
													 <div class="input-group-addon">
														 <span class="fa fa-check"></span>
													 </div>
													 <input required type="text" name="verificationid"  class="form-control" data-usertype="<?php echo $_SESSION['usertype']; ?>" value="<?php echo $profiledata['verificationid'];?>" />
												 </div>
											 </div>
										 </div>
										 <div class="modal-footer">
											 <input required type="submit" name="submitchange"  class="fullwidth btn-lg btn btn-danger fail btn-lg" value="Confirm Change" />
										 </div>
									 </form>
								 </div>
							 </div>
						 </div>
					 <?php } ?>
					<?php
						} else {
						$userdetails = json_decode($profiledata['userdetails']);
					?>
				    <form class="form" method="POST"  id="usersettings"  enctype="multipart/form-data">
		         	<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
		         	<input type="hidden" name="oldimage" value="<?php echo isset($userdetails->profilepic) ? $userdetails->profilepic :''; ?>">

							<div class="row">
								<div class="col-sm-5" id="profilepic_user">
									<button type="button" id="deleteuserpic" class="col-xs-1 btn-xs btn-default noborder xsmalltext">
				            <span class="fa-stack">
									  <i class="fa fa-file-image-o fa-stack-1x"></i>
									  <i class="fa fa-ban fa-stack-2x text-danger"></i>
										</span>
				          </button>
				          <div class="col-xs-11"><?php $_GET['imgurl'] =  isset($userdetails->profilepic) ? $userdetails->profilepic : '';
					        include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'imageeditor.php'; ?>	</div>
								</div>

								<div class="col-sm-7">

									<div class= "form-group">
										<div class="col-xs-12">
				              <label>Name </label>
				              <div class="input-group">
		                    <span class="input-group-addon">
		                      <span class="fa fa-user"></span>
		                    </span>
				                <input type="text" name="userdetails[name]" value="<?php echo isset($userdetails->name) ? $userdetails->name : '';?>" class="form-control"/>
				              </div>
				            </div>
									</div>

									<div class="form-group">
				            <div class="col-xs-12">
				              <label>Username* </label>
				              <div class="input-group">
			                  <div class="input-group-addon">
			                    <span class="fa fa-user"></span>
			                  </div>
			                  <input type="text" name="username"  class="form-control" value="<?php echo $profiledata['username'];?>" required data-oldusername = "<?php echo $profiledata['username'];?>"/>
				              </div>
				            </div>
					        </div>

					        <div class="form-group">
						        <div class="col-xs-12">
			                <label>Email*</label>
			                <div class="input-group">
		                    <span class="input-group-addon">
		                      <span class="fa fa-envelope"></span>
		                    </span>
		                    <input type="email" name="email" class="form-control" value="<?php echo $profiledata['email'] ?>" required data-oldemail = "<?php echo $profiledata['email'];?>"/>
			                </div>
			              </div>
									</div>
								</div>

								<div class= "form-group">
									<div class="col-xs-12">
		                <label>Birthday </label>
	                  <div class="input-group date">
	                    <span class="input-group-addon">
	                      <span class="fa fa-calendar"></span>
	                    </span>
	                    <input type="text" name="userdetails[dob]" class="form-control datepicker" value="<?php echo isset($userdetails->dob) ? $userdetails->dob : '';?>" placeholder="YYYY-MM-DD"/>
	                  </div>
		              </div>
								</div>
								<div class= "form-group">
									<div class="col-xs-12">
			              <label>Phone Number </label>
		                <div class="input-group">
	                    <span class="input-group-addon">
	                      <span class="fa fa-phone"></span>
	                    </span>
		                  <input type="tel" name="userdetails[phone]" class="form-control" placeholder="xxxxxxxxxx" value="<?php echo isset($userdetails->phone) ? $userdetails->phone : '';?>"/>
		                </div>
			            </div>
								</div>

								<div class= "form-group">
										<div class="col-xs-12">
				              <label>Occupation </label>
				              <div class="input-group">
		                    <span class="input-group-addon">
		                      <span class="fa fa-user"></span>
		                    </span>
		                    <input type="text" class="form-control" name="userdetails[occupation]" value="<?php echo isset($userdetails->occupation) ? $userdetails->occupation : '';?>" />
		                  </div>
				            </div>
									</div>

							</div>

							<div class="row">
								<div class= "form-group">
									<div class="col-xs-12">
	                  <label>About You </label>
	                  <div class="input-group">
	                    <span class="input-group-addon">
	                      <span class="fa fa-edit"></span>
	                    </span>
	                    <textarea name="userdetails[about]" class="form-control" rows="5" placeholder="Please insert text here."><?php echo isset($userdetails->about) ? $userdetails->about : '';?></textarea>
	                  </div>
	                </div>
								</div>

								<div class= "form-group checkbox checkbox-success col-xs-12">
									<label  >
			              <input type="checkbox" name="showcontactdetails"  value="<?php echo $profiledata['showcontactdetails'];?>" />
			              Allow other users to see your contact information.
		              </label>
								</div>

								<div class= "form-group checkbox checkbox-success col-xs-12">
									<label >
			              <input type="checkbox" name="userdetails[showlikedarticles]"  value="<?php echo $userdetails->showlikedarticles;?>" />
			               Allow other users to see articles liked by you.
		              </label>
								</div>

								<div class= "form-group checkbox checkbox-success col-xs-12">
									<label  >
			             	<input type="checkbox" name="allowemail" value="TRUE" <?php if($profiledata['allowemail'])  echo "checked"; ?> />
			              Get updates sent to your inbox <a href="#" data-toggle="popover" title="" data-content="You will still receive important information about your profile." data-trigger="focus"><i class="fa fa-info-circle"></i></a>
		              </label>
								</div>

								<div class="form-group col-sm-12">
			            <input  type="submit" value="Update!" class="col-sm-4 btn-lg btn-warning pull-right">
			          </div>
							</div>

						</form>

					<?php } ?>
		    </div>

				<!-- CHANGE PASSWORD -->
		    <div class="tab-pane" id="changepassword">
					<form class="form row" id="changepasswordform"  method="POST">
			      <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">

	          <div class="form-group">
	            <div class="col-xs-12">
	              <label>Old Password* </label>
	              <div class="input-group">
	                <div class="input-group-addon">
	                  <span class="fa fa-asterisk"></span>
	                </div>
	                <input required type="password" name="password" class="form-control passwordShow" placeholder="*******" id="oldpassword" data-username="<?php echo $_SESSION['username'] ?>"/>
	                <span class="input-group-addon passwordShowButton" ><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
	              </div>
	            </div>
	          </div>

						<div class="form-group">
	            <div class="col-xs-12">
	              <label>New Password* </label>
	              <div class="input-group">
	                <div class="input-group-addon">
	                  <span class="fa fa-asterisk"></span>
	                </div>
	                <input required type="password" name="newpassword" class="form-control passwordShow inputPassword " placeholder="*******" />
	                <span class="input-group-addon passwordShowButton" ><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
	              </div>

	            	<div class = "passwordStrengthContainer" >
	                <span id="passwordStrength"></span>
	                <p class="strengthBar"></p>
                </div>
	          	</div>
	          </div>

						<div class="form-group col-sm-12">
              <input type="submit" value="Change Password" class="col-sm-4 btn-lg btn-warning pull-right">
            </div>
			    </form>
		    </div>

	    </div>

	  </div>
	</div>
</div>
