<div id="loginModal" class="modal fade" >
  <div id="modal" class="modal-dialog">
	   <div class="modal-content">
       <!-- CHANGEDNOV19 : If not asking users to pay -->
			<!-- <div class="ribbon ribbon-top-right"><span>FREE professional account upto 2 years!</span></div> -->


		    <ul class="nav nav-tabs modal-header">
		        <li class="active" id = "signinnav"><a href="#signintab" data-toggle="tab">Login</a></li>
		        <li id= "signupnav"><a href="#signuptab" data-toggle="tab">Sign Up</a></li>
	        </ul>

	        <div class="modal-body">

		        <div class="tab-content container-fluid">
			        <div class="tab-pane fade   row" id="signintab">
		            <button type="button" class="close" data-dismiss="modal">&times;</button>
		            <form action=" " method = "post"  role="form" id="logform" >

		              <div class="form-group">
		                <div class="col-sm-12">
		                  <label>Username/Email </label>
		                  <div class="input-group">
		                      <div class="input-group-addon">
		                        <span class="fa fa-user"></span>
		                      </div>
		                      <input type="text" name="username"  class="form-control" placeholder="Username or email" /><!--class="form-control"??-->
		                  </div>
		                </div>
		              </div>

		              <div class="form-group">
		                <div class="col-sm-12">
		                  <label>Password </label>
		                  <div class="input-group">
		                    <div class="input-group-addon">
		                      <span class="fa fa-asterisk"></span>
		                    </div>
		                    <input type="password" name="password" class="form-control passwordShow" placeholder="Password" />
		                    <span class="input-group-addon passwordShowButton"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
		                  </div>
		                </div>
		                <div class="col-sm-12">
		                  <a href="<?php echo BASE_PATH . 'recover';?>">Forgot password</a>
		                </div>
		              </div>


		              <div class="form-group">
		                <div class="col-sm-12">
		                  <input type="submit" id="loginbtn" name="loginbtn" value="SIGN IN" class="btn btn-success"/>
		                </div>
		              </div>

		            </form>
		          </div>

			          <div class="tab-pane fade active in row" id="signuptab">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			            <form action=" " method = "post"  role="form" id="userregisterform">

			              <div class="form-group">
			                <div class="col-sm-12">
			                  <label>Email </label>
			                  <div class="input-group">
			                    <div class="input-group-addon">
			                      <span class="fa fa-envelope"></span>
			                    </div>
			                    <input type="email" name="email" class="form-control emailRegister" placeholder="janedoe@example.com" id= "emailRegister"/>
			                  </div>
			                </div>
			              </div>

			              <div class="form-group">
			                <div class="col-sm-12">
			                  <label>Username </label>
			                  <div class="input-group">
			                      <div class="input-group-addon">
			                        <span class="fa fa-user"></span>
			                      </div>
			                      <input type="text" name="username"  class="form-control usernameRegister" placeholder="janedoe" id="usernameRegister"/><!--class="form-control"??-->
			                  </div>
			                </div>
			              </div>

			              <div class="form-group">
			                <div class="col-sm-12">
			                  <label>Password </label>
			                  <div class="input-group">
			                    <div class="input-group-addon">
			                      <span class="fa fa-asterisk"></span>
			                    </div>
			                    <input type="password" name="password" class="form-control passwordShow inputPassword" placeholder="*********" />
			                    <span class="input-group-addon passwordShowButton"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
			                  </div>
			                  <div class="floatrightpadtop">
			                    <span id="passwordStrength"></span>
			                    <p class="strengthBar"></p>
			                  </div>
			                </div>
			              </div>



			              <div class="form-group">
			                <div class="col-sm-12">
			                  <input type="submit" id="userregisterbtn" name="userregisterbtn" value="SIGN UP!" class="btn btn-success"/>
			                </div>
			              </div>
			              <div class="col-sm-12">
			                <a href="<?php echo BASE_PATH; ?>registerasprofessional" class="btn registerModalButton fullwidth">Connect with New Clients NOW! <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
			              </div>

			            </form>

			          </div>

			          <div class="modal-footer">
				          <!-- <div class="col-sm-12"> <div class="centerBold"> OR </div> </div> -->

			              <div class="social-buttons col-sm-12">

			                  <div class="centerauto">

			                    <div class="row">
			                    <!-- btn facebooklogin signinnav <i class="fa fa-facebook" aria-hidden="true" ></i>btn googlelogin-->
			                    <div class="fb-login-button col-sm-6 " data-scope="public_profile, email,user_about_me,user_birthday, user_location"   data-size="large" data-show-faces="false" data-auto-logout-link="false" onlogin="checkLoginState()" data-button-type="login_with" data-row-max="1"></div>
			                    <button type="button" id="signinButton" class="btn googlesignin col-sm-6"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign in with Google</button>
			                  </div>
			                  </div>
			              </div>
			          </div>

		        </div>
	        </div>
	   </div>
   </div>
</div>
