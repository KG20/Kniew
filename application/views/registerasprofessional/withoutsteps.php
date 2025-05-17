<?php
	loggedinRedirect();
?>


<!-- <i class="fa fa-spinner fa-pulse" id="loadReg"></i> -->


<div  class="container-fluid regcontfluid crossbackground">

	<div class="row margin2per">
		<p id="progressStepMessage"></p>
		<div class="progress">
	    <div id="custRegProgressBar" class="progress-bar progress-bar-striped progress-bar-primary active" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
	    </div>
		</div>
	</div>




	<form  id="registercustomersteps" action = "" method="post" >
		<div class="row">

			<!-- PERSONAL INFORMATION -->
			<div class="col-xs-11 col-sm-5 whiteTransBack margin2per padding2per roundcorners2per">
				<!-- Image -->
				<div id="registerprofimage">
			    <?php include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'imageeditor.php'; ?>
			  </div>

				<!-- NAME -->
				<div class= "form-group">
					<!-- <div class="col-xs-12"> -->
	        <label>Name* </label>
	        <div class="input-group">
	          <span class="input-group-addon">
	            <span class="fa fa-user"></span>
	          </span>
	          <input type="text" name="name" class="form-control percentagebarclass" placeholder="Jane Doe" required/>
	        </div>
	      	<!-- </div> -->
				</div>

				<!-- Email -->
				<div class= "form-group">
					<!-- <div class="col-xs-12"> -->
	        <label>Email* </label>
	        <div class="input-group">
	          <span class="input-group-addon">
	            <span class="fa fa-envelope"></span>
	          </span>
	          <input type="email" name="email" class="form-control emailRegister percentagebarclass" placeholder="janedoe@example.com" value="<?php if($_POST['cs_email']) echo $_POST['cs_email']; ?>"/>
	        </div>
	        <!-- </div> -->
				</div>

				<!-- Username -->
				<div class="form-group">
	        <!-- <div class="col-xs-12"> -->
	        <label>Username* </label>
	        <div class="input-group">
	            <div class="input-group-addon">
	              <span class="fa fa-user"></span>
	            </div>
	            <input type="text" name="username"  class="form-control usernameRegister percentagebarclass" placeholder="jane_doe" />
	        </div>
	        <!-- </div> -->
	      </div>

				<!-- Password -->
	      <div class="form-group">
	        <!-- <div class="col-xs-12"> -->
	        <label>Password* </label>
	        <div class="input-group">
	          <div class="input-group-addon">
	            <span class="fa fa-asterisk"></span>
	          </div>
	          <input type="password" name="password" class="form-control passwordShow inputPassword percentagebarclass" placeholder="*******" />
	          <span class="input-group-addon passwordShowButton" ><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
	        </div>
	        <div class = "passwordStrengthContainer" >
	          <span id="passwordStrength"></span>
	          <p class="strengthBar"></p>
	        </div>
	        <!-- </div> -->
	      </div>

			</div>

			<!--PROFESSION RELATED THINGS  -->
			<div class="col-xs-11 col-sm-6 whiteTransBack margin2per padding2per roundcorners2per">
				<!-- <h2 class="lightgreybottomborder">Register As</h2> -->

				<!-- ROLE -->
				<div class= "form-group row">
					<div id="roleicons">
						<p><b>Please select one of the following</b></p>
						<label class="col-sm-3 col-xs-6">
							<input type="radio" name="custregrole" value="2" class="form-control percentagebarclass" />
							<i class="fa  fa-handshake-o" aria-hidden="true"></i>
							<!-- <img class = "fa fa-5x" src="./images/volunteericon.png"/> -->
							<p>Social Work</p>
						</label>
						<label class="col-sm-3 col-xs-6">
							<input type="radio" name="custregrole" value="3" class="form-control"/>
							<i class="fa  fa-graduation-cap" aria-hidden="true"></i> <!-- fa-gavel fa-balance-scale-->
							<p>Lawyer</p>
						</label>
						<label class="col-sm-3 col-xs-6">
							<input type="radio" name="custregrole" value="4" class="form-control"/>
							<i class="fa fa-user-md" aria-hidden="true"></i>
							<p>Doctor</p>
						</label>
						<label class="col-sm-3 col-xs-6">
							<input type="radio" name="custregrole" value="5" class="form-control"/>
							<i class="fa fa-money" aria-hidden="true"></i>
							<p>Chartered Accountant</p>
						</label>
					</div>
				</div>

				<!-- Specialisation -->
				<div class="form-group">
					<label>Specialisation*</label>
					<div>
					<select name="regspecialisation" class="form-control percentagebarclass" id="regspecialisation" required>
						<option value="default">Please select your occupation first</option>
					</select>
					</div>
					<!-- <input type="textbox" name="regspecialisationTextbox" id="regspecialisationTextbox" class="form-control"/> -->
				</div>

				<!-- OTHER FOCUS -->
				<div class="form-group">
					<label>Other Focus(optional)</label>
					<div>
					<select multiple name="regspecialisationother[]" class="form-control" id="regspecialisationother">
						<option value="default">Please select your occupation first</option>
					</select>
					</div>
					<p class="impinfo">Hold down ctrl and click to select multiple options</p>
				</div>

				<!-- Practising SINCE -->
				<div class= "form-group">
	        <label>Practising Since* </label>
	        <div class="input-group date">
	          <span class="input-group-addon">
	            <span class="fa fa-calendar"></span>
	          </span>
	          <input type="text" name="since" class="form-control  percentagebarclass" id="since" required />
	        </div>
				</div>

				<!-- language -->
				<div class= "form-group">
					<!-- <div class="col-xs-12"> -->
	        <label>Fluent in*   <a href="#" data-toggle="popover" title="" data-content="Please only enter languages you can fluenty speak. Seprate each language by a comma. " data-trigger="focus"><i class="fa fa-info-circle"></i></a></label>
	        <div class="input-group">
	          <span class="input-group-addon">
	            <span class="fa fa-language"></span>
	          </span>
	          <input type="text" name="language" class="form-control percentagebarclass" placeholder="English, Hindi" required/>
	        </div>
	        <!-- </div> -->
				</div>

				<!-- verification -->
				<div class= "form-group" id="verification">
					<!-- <div class="col-xs-12"> -->
	          <label></label>
	          <div class="input-group">
	            <span class="input-group-addon">
	              <span class="fa fa-id-card"></span>
	            </span>
	            <input type="text" name="verificationid" class="form-control" placeholder="" required/>
	          </div>
	        <!-- </div> -->
				</div>
			</div>

			<!-- TIME -->
			<div class="col-xs-11 col-sm-6 whiteTransBack margin2per padding2per roundcorners2per">
				<!-- <h3>Account</h3> -->

				<!-- WORK TIME -->
				<div class="form-group">
					<label for="starttime">Work Timing*</label>
					<div class='input-group date'>
						<input required type="text" name="starttime" id="starttime"  class="form-control percentagebarclass" >
						<span class="input-group-addon">
				      <i class="fa fa-clock-o" aria-hidden="true"></i>
				    </span>
			    </div>
					 to
					<div class='input-group date' >
						<input required type="text" name="endtime" id="endtime"  class="form-control percentagebarclass">
						<span class="input-group-addon">
				      <i class="fa fa-clock-o" aria-hidden="true"></i>
				    </span>
			    </div>
				</div>

				<!-- BREAK -->
				<div class="form-group">
					<label for="breakstarttime">Break Timing</label>
					<div class='input-group date'>
						<input type="text" name="breakstarttime" id="breakstarttime"  class="form-control" >
						<span class="input-group-addon">
				      <i class="fa fa-clock-o" aria-hidden="true"></i>
				    </span>
			    </div>
					to
					<div class='input-group date'>
						<input type="text" name="breakendtime" id="breakendtime"  class="form-control">
						<span class="input-group-addon">
				      <i class="fa fa-clock-o" aria-hidden="true"></i>
				    </span>
			    </div>
				</div>

			</div>

		</div>

		<div class="row">

			<!-- ABOUT -->
			<div class="col-xs-11 col-sm-5 whiteTransBack margin2per padding2per roundcorners2per">
				<div class= "form-group">
		      <label>About You*</label>
	        <textarea name="about" class="form-control profAbout" rows="20" placeholder="Please insert text here." required id="reg_about">
	          <h1 class="mceNonEditable"><b>Qualifications</b></h1>
	          <h2>Post-graduation</h2>
	          <h2>Graduation</h2>
	        </textarea>
				</div>
			</div>

			<!-- ABOUT ORG -->
			<div class="col-xs-11 col-sm-6 whiteTransBack margin2per padding2per roundcorners2per">

				<!-- ORG -->
				<div class= "form-group">
	        <label>Work </label>
	        <div class="input-group">
	          <span class="input-group-addon">
	            <span class="fa fa-briefcase"></span>
	          </span>
	          <input type="text" name="workatname" id="workatname" class="form-control" placeholder="Search for your employer..." list="workatlist"/>
	          <datalist id="workatlist"></datalist>
	          <input type="hidden" name="workatid" id="workatid">
	        </div>
				</div>

				<!-- VARIOUS QUESTIONS ABOUT FIRM -->
				<div class="row">
					<div class="form-group col-xs-12 col-sm-4" id="isfirm">
						<label for="isfirm" >
							<input type="checkbox" value="true" name="isfirm" >
						 	This is an organisation itself. <a href="#" data-toggle="popover" title="" data-content="If you are making an account for your firm/organisation, tick this box. This will help people find you more efficiently, and your employees will be able to list you as their employer. " data-trigger="focus"><i class="fa fa-info-circle"></i></a>
						</label>
					</div>

					<div class="form-group col-xs-12 col-sm-4" id="isfree">
						<label for="isfree" >
						<input type="checkbox" value="true" name="isfree" >
						</label>
					</div>

					<div class="form-group col-xs-12 col-sm-4" id="onlinesession">
						<label for="onlinesession" >
							<input type="checkbox" value="true" name="onlinesession"  checked>
							<span id="onlinesessiontext"></span>
						</label>
					</div>
					<!-- </div> -->
					<div class="form-group col-xs-12" id="jurisdiction">
					</div>
				</div>

				<!-- PHONE NUMER -->
				<div class= "form-group">
	        <label>Phone Number </label>
	        <div class="input-group">
	          <span class="input-group-addon">
	            <span class="fa fa-phone"></span>
	          </span>
	          <input type="tel" name="phone" class="form-control" placeholder="xxxxxxxxxx"/>
	        </div>
				</div>

				<!-- FEE -->
				<!-- <div class="form-group" id="appointmentfee">
					<label for="fee">Appointment Fee*</label>
					<div class="input-group">
		        <div class="input-group-addon">
		          <i class="fa fa-money"></i>
		        </div>
						<input type="number" name="fee" class="form-control percentagebarclass" min=10 required>
		      </div>
				</div> -->

				<!-- location -->
				<div class= "form-group">
		      <label>Location* </label>
		      <div class="input-group">
		        <span class="input-group-addon">
		          <span class="fa fa-map-marker"></span>
		        </span>
		        <input type="text" name="formattedAddress" onFocus="geolocate()" class="form-control percentagebarclass" placeholder="Search for your work place address..." required id="geolocateAddress"/>
		        <span class="input-group-addon searchAddress" ><i class="fa fa-search" aria-hidden="true"></i></span>
		      </div>
		    </div>
			  <div id = "googleMap" class="col-xs-12" ></div>

			</div>

		</div>
		<div class="row">
			<!-- Appointment -->
			<div class="col-xs-11 col-sm-5 whiteTransBack margin2per padding2per roundcorners2per" id="allowContainer">

				<div class= "form-group checkbox checkbox-success col-xs-12" id = "allowappointment">
					<label>
		          <input type="checkbox" name="allowappointment" value="true" />
		          &nbsp; Allow users to book appointments with you
		      </label>
				</div>

				<div class="allowapointment col-xs-12">
					<!-- Duration -->
					<div class="form-group ">
						<label for="duration">Duration of each appointment(minutes)*</label>
						<div class="input-group">
	            <div class="input-group-addon">
	              <i class="fa fa-clock-o"></i>
	            </div>
							<input type="number" name="duration" id ="duration" class="form-control" min="5" step="5" required >
						</div>
					</div>
					<!-- HOLIDAY -->
					<div class="form-group ">
						<label>Weekly holiday</label>
						<div class="input-group">
							<div class="input-group-btn dropup">
								<button tabindex="-1" class="btn btn-default col-xs-11" type="button">Select Days</button>
								<button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle col-xs-1" type="button">
									<span class="caret"></span>
								</button>
								<ul role="menu" class="dropdown-menu">
									<li><a href="#">
										<input type="checkbox" value="1" name="weeklyHoliday[]">
										<span class="lbl"> Monday</span>
									</a></li>
									<li><a href="#">
										<input type="checkbox" value="2" name="weeklyHoliday[]">
										<span class="lbl">Tuesday</span>
									</a></li>
									<li><a href="#">
										<input type="checkbox" value="3" name="weeklyHoliday[]">
										<span class="lbl">Wednesday</span>
									</a></li>
									<li><a href="#">
										<input type="checkbox" value="4" name="weeklyHoliday[]">
										<span class="lbl">Thursday</span>
									</a></li>
									<li><a href="#">
										<input type="checkbox" value="5" name="weeklyHoliday[]">
										<span class="lbl">Friday</span>
									</a></li>
									<li><a href="#">
										<input type="checkbox" value="6" name="weeklyHoliday[]">
										<span class="lbl">Saturday</span>
									</a></li>
									<li><a href="#">
										<input type="checkbox" value="0" name="weeklyHoliday[]" checked>
										<span class="lbl">Sunday</span>
									</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- Weekly	 -->
					<div class="form-group">
						<input type="checkbox" value="true" name="weeklyAppointment"  id ="weeklyAppointment">
						<label for="allowWeekly" >Allow Weekly Appointment  <a href="#" data-toggle="popover" data-trigger="focus" title="" data-content="This allows the user to have regular appointments with you, on the selected day and time every week, for a particular duration (set after selecting this)."><i class="fa fa-info-circle"></i></a> </label>
					</div>
					<!-- TILL DATE -->
					<div class="form-group" id="tillDate">
						<label for="maxdate">Users can book appointment from current day till <a href="#" data-toggle="popover" title="" data-content="This is the maximum date till which the user can book recurring appointment with you. For example, if first appointment is on Monday 1 April, and you select the maximum to be 15 days. You will have appointments with user on 1, 8 and 15th April, respectively. " data-trigger="focus"><i class="fa fa-info-circle"></i></a></label>
						<div class="input-group">
	            <div class="input-group-addon">
	              <i class="fa fa-calendar"></i>
	            </div>
							<select class="form-control" id="maxdate" name="maxdate" required>
								<option value="0.5">15 Days</option>
								<option value="1">1 Month</option>
								<option value="2">2 Months</option>
								<option value="3">3 Months</option>
								<option value="6">6 Months</option>
								<option value = "12">1 Year</option>
								<option value="0" default>No Limit</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<!-- RECOMMEND OTHERS -->
			<div class="col-xs-11 col-sm-5 whiteTransBack margin2per padding2per roundcorners2per" >
				<div class= "form-group marginZero">
					<label>Recommend other professionals <a href="#" data-toggle="popover" title="" data-content="You can recommend another professional registered with Kniew, just search by Name or Username. Try recommending professional who complements your service. For example, if you are a Lawyer, try recommending a CA. You can recommend up to 3 professionals, separate each name using a comma." data-trigger="focus"><i class="fa fa-info-circle"></i></a></label>
					<div class="input-group">
						<span class="input-group-addon">
							<span class="fa fa-users"></span>
						</span>
						<input type="text" name="recommendname" id="recommendname" class="form-control recommendname" placeholder="Search for other professionals..."/>
						<!-- <datalist id="recommendlist"></datalist> -->
						<input type="hidden" name="recommendids[0]" id="recommendid0">
						<input type="hidden" name="recommendids[1]" id="recommendid1">
						<input type="hidden" name="recommendids[2]" id="recommendid2">
					</div>
					<div id="recommendresult"></div>
					<p class="impinfo">(upto 3, separate by comma)</p>
				</div>
			</div>


			<!-- ALLOW EMAIL AND INFORMATION -->
			<div class="col-xs-11 col-sm-5 whiteTransBack margin2per padding2per roundcorners2per">
				<div class= "form-group checkbox checkbox-success" id = "showcontactdetails">
					<label>
		          <input type="checkbox" name="showcontactdetails" checked/>
		          &nbsp; Show others your contact details on your profile page
		      </label>
				</div>
				<div class= "form-group checkbox checkbox-success" id = "allowemail">
					<label>
		          <input type="checkbox" name="allowemail" checked/>
		          &nbsp; Get updates sent to your inbox <a href="#" data-toggle="popover" title="" data-content="You will still receive important information about your profile." data-trigger="focus"><i class="fa fa-info-circle"></i></a>
		      </label>
				</div>
			</div>



		</div>
		<div class="row"><p class="requiredFields pull-right margin2per smalltext">*Required Fields</p></div>

	 <!--  <div class="col-xs-12 col-sm-6" id="getLocateInfo">
	  	<div> <div class="form-group">
	    <label>Area (recommended)</label>
	     <input type="text" name="areaGoogle" id="sublocality_level_1" class="form-control" readonly />
	    </div> </div>
	    <div> <div class="form-group">
	    <label>City*</label>
	     <input type="text" name="cityGoogle" id="locality"  class="form-control" readonly required/>
	    </div> </div>
	    <div> <div class="form-group">
	    <label>State/Province*</label>
	     <input type="text" name="stateGoogle"  id="administrative_area_level_1" class="form-control" readonly required/>
	    </div> </div>
	    <div> <div class="form-group">
	    <label>Country*</label>
	     <input type="text" name="countryGoogle" id="country" class="form-control" readonly required/>
	    </div> </div>
	    <div class="form-group">
	    <label>Zipcode </label>
	     <input type="text" name="zipcodeGoogle" class="form-control" required/>
	    </div>
	  </div> -->

	  <div class="form-group  col-xs-12">
			<div id="regProfResult" class="col-sm-6"></div>
	    <input type="submit" name="registercustomersSubmit" class="btn btn-lg btn-warning pull-right xlarge boldtext" value="FREE SIGN UP! Connect with Clients!">
	  </div>


	</form>



</div>
