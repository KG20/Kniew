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

	<div id="regLoading" class="floatright"><span class="ellipsis-anim"><span>Loading</span><span>.</span><span>.</span><span>.</span></span></div>



	<form  id="registercustomersteps" action = "" method="post"  class="row displaynone">

		<h3>Choose Your Profession</h3>
		<fieldset>
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
						<i class="fa  fa-balance-scale" aria-hidden="true"></i> <!-- fa-gavel fa-balance-scale fa-graduation-cap-->
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

		</fieldset>

		<h3>Account Details</h3>
		<fieldset>

			<!-- Image -->
			<div id="registerprofimage" class="col-xs-12 col-sm-3">
		    <?php include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'imageeditor.php'; ?>
		  </div>

			<div class="col-xs-12 col-sm-9">

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

				<p class="divider margintop5per marginbottom2per"></p>

				<!-- NAME -->
				<div class= "form-group">
					<!-- <div class="col-xs-12"> -->
	        <label>Name* </label>
	        <div class="input-group">
	          <span class="input-group-addon">
	            <span class="fa fa-user"></span>
	          </span>
	          <input type="text" name="name" class="form-control percentagebarclass nameRegister" placeholder="Jane Doe" required/>
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



			</div>
			<div class="row"><p class="requiredFields pull-right margin2per smalltext">*Required Fields</p></div>
		</fieldset>


		<h3>Professional Details</h3>
		<fieldset>


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

			<!-- verification -->
			<div class= "form-group col-sm-4" id="verification">
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


			<!-- Practising SINCE -->
			<div class= "form-group col-sm-4">
        <label>Practising Since* </label>
        <div class="input-group date">
          <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
          <input type="text" name="since" class="form-control  percentagebarclass" id="since" required />
        </div>
			</div>

			<!-- language -->
			<div class= "form-group col-sm-4">
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
			<div class="form-group col-xs-12" id="jurisdiction">
			</div>
			<div class="row"><p class="requiredFields pull-right margin2per smalltext">*Required Fields</p></div>
		</fieldset>

		<h3>About You</h3>
		<fieldset>
			<!-- ABOUT -->
			<!-- <div class="col-xs-11 col-sm-5 whiteTransBack margin2per padding2per roundcorners2per"> -->
				<div class= "form-group">
		      <label>About You*</label>
	        <textarea name="about" class="form-control profAbout" rows="20" placeholder="Please insert text here." required id="reg_about">
	          <h1 class="mceNonEditable"><b>Qualifications</b></h1>
	          <h2>Post-graduation</h2>
	          <h2>Graduation</h2>
	        </textarea>
				</div>
			<!-- </div> -->
			<div class="row"><p class="requiredFields pull-right margin2per smalltext">*Required Fields</p></div>
		</fieldset>

		<h3>Work Information</h3>
		<fieldset>

			<!-- location -->
			<div class="col-xs-12 col-sm-6">
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
			<div class="col-xs-12 col-sm-6">
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


			<!-- ORG -->
			<div class= "form-group col-sm-6">
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
			<!-- PHONE NUMER -->
			<div class= "form-group col-sm-6">
				<label>Phone Number </label>
				<div class="input-group">
					<span class="input-group-addon">
						<span class="fa fa-phone"></span>
					</span>
					<input type="tel" name="phone" class="form-control" placeholder="xxxxxxxxxx"/>
				</div>
			</div>

			<!-- VARIOUS QUESTIONS ABOUT FIRM -->
			<div class="row">
				<div class="form-group  col-sm-4 displaynone" id="isfirm">
				</div>

				<div class="form-group col-sm-4" id="isfree">
					<label for="isfree" >
					<input type="checkbox" value="true" name="isfree" >
					</label>
				</div>

				<div class="form-group col-sm-4" id="onlinesession">
					<label for="onlinesession" >
						<input type="checkbox" value="true" name="onlinesession"  checked>
						<span id="onlinesessiontext"></span>
					</label>
				</div>
				<!-- </div> -->

			</div>





				<div class="row"><p class="requiredFields pull-right margin2per smalltext">*Required Fields</p></div>
		</fieldset>

	</form>







</div>
