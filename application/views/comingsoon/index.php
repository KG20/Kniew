 <div id="temp_container">
	<div class="container-fluid temp_top  marginZero paddingZero greyBack">
		<div class="row margin2per">
			<div class="col-xs-6">
				<svg class="temp_logo"><use xlink:href="#logo_full"></use></svg>
			</div>

			<div class="col-xs-6 righttext whitetext">
				<!-- <a href='<?php //echo BASE_PATH; ?>articles' class="sneakpeak">Get a Sneak Preview! <i class="fa fa-arrow-right" aria-hidden="true"></i></a> -->
			</div>
		</div>

		<div class="row whitetext margin2per">
			<?php if($isprofession == 1){ ?>
				<h1 class="col-xs-12 carousel slide" data-ride ="carousel">
					<div class="carousel-inner">
						<span class="item active">New to your Profession?</span>
						<span class="item">Competiting with growing professionals?</span>
						<span class="item">'Word of mouth' not cutting it?</span>
						<span class="item">Reach and connect with clients for Your Profession at <?php echo WEBNAME;?>!</span>
					</div>
				</h1>
				<p class="smalltext greytext col-sm-6">Increase your visibilty, make yourself easier to find, get professional recommendations, connect with users, and much more..</p>
			<?php } else {?>
				<h1 class="col-xs-12 carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<span class="item active">New in the City?</span>
						<span class="item">Starting a startup?</span>
						<span class="item">Don't Know who to trust?</span>
						<span class="item">Don't Know where to look?</span>
						<span class="item">Find Doctors!</span>
						<span class="item">Find Lawyers!</span>
						<span class="item">Find CAs!</span>
						<span class="item">Find NGOs!</span>
					</div>
				</h1>
				<p class="smalltext greytext col-sm-6">Find Chartered Accountants, Lawyers, Doctors and NGOs, Get professional advice, book appointments, review and much more..</p>
			<?php } ?>
		</div>

		<div class="row bino_container cloudcontainer  marginZero paddingZero">


			<div class="col-xs-6 marginZero paddingZero">
					<div class="embed-responsive embed-responsive-1by1  circle"><iframe id="songVideo" class="video_round embed-responsive-item" src="<?php   if($isprofession == 1) echo 'https://www.youtube.com/embed/v5kBAo_VJGU'; else echo 'https://www.youtube.com/embed/mu_L2eErJg8'; ?>?rel=0&amp;autoplay=1&mute=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>
			</div>
			<div class="col-xs-6 marginZero paddingZero">
				<!-- <?php //if($isprofession == 1){ ?>
					<a class="btn cs_cta" href="<?php //echo BASE_PATH; ?>registerasprofessional">GET <span class="largertext"><b>INSIDER ACCESS!</b></span><i class="fa fa-arrow-right" aria-hidden="true"></i>-->
					<!-- <p class="smallertext bluetext">*Offer for Limited Time Only!</p> -->
					<!-- <div class="starburst starburst_multipoint" id="cs_starburst"><span>LIMITED TIME FREE 1 YEAR SUBSCRIPTION!</span></div> -->
					<!-- </a> -->

				<!-- <?php //} else {?> -->
					<!-- <a class="registerpop btn cs_cta signup largertext"  role="button" tabindex="0" href=" "> <b>GET INSIDER ACCESS!</b> </a> -->
					<!-- href="<?php //if($isprofession == 1) echo BASE_PATH .'refer_a_friend/profession'; else echo BASE_PATH .'refer_a_friend'; ?>"> -->
				<!--<?php //} ?> -->
					<form action="<?php echo BASE_PATH . 'referafriend'; ?>" method="POST"  id="comingsoon_form" name="comingsoon_form" class="cs_cta">

					    <div class="form-group">
						    <label for="cs_email">Email </label>
					        <input type="email" name="cs_email" tabindex="-1" value="" placeholder="youremail@gmail.com" id="cs_email" required="" class="form-control input-lg">
				        </div>
				        <input type="hidden" name="code" tabindex="-1" value="" id="code">
				        <input type="checkbox" name="isprofessional" tabindex="-1" <?php if($isprofession == 1) echo "checked"; ?> id="isprofessional" class="hidden">

						<button type="submit" class="btn btn-danger btn-block pull-right" name="cs_submit">GET INSIDE <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
						<p class="error smalltext"></p>
					</form>
			</div>

			<div class="cloud x1"></div>
			<div class="cloud x2"></div>
			<div class="cloud x3"></div>
			<div class="cloud x4"></div>
			<div class="cloud x5"></div>

		</div>



	<!-- 	<div class="row bino_container">
			<div class="col-xs-6">
				<div class="circle bino1 embed-responsive embed-responsive-1by1 songVideoCont cloudcontainer">
					<iframe id="songVideo" class="video_round embed-responsive-item" src="https://youtu.be/v5kBAo_VJGU?rel=0&amp;autoplay=1&cc_load_policy=1" allowfullscreen></iframe>
					<div class="cloud x1"></div>
			<div class="cloud x2"></div>
			<div class="cloud x3"></div>
			<div class="cloud x4"></div>
			<div class="cloud x5"></div>
				</div>

			</div>
			<div class="col-xs-6">
				<div class="circle bino2 cloudcontainer">
				<a class="btn cs_cta" href="<?php //echo BASE_PATH; ?>registerasprofessional">FREE 1 Year <span class="largertext"><b>NOW!</b></span><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
				<div class="cloud x1"></div>
			<div class="cloud x2"></div>
			<div class="cloud x3"></div>
			<div class="cloud x4"></div>
			<div class="cloud x5"></div>
				</div>

			</div>

		</div> -->


	</div>

	<div class="container-fluid crossbackground footer" id="temp_bottom">
		<div class="row" >
			<?php if($isprofession == 1){ ?>
				<ul class="list-inline centertext whitetextshadow bulletadv">
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-search fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Increase Visibilty</p>
							<p class="smalltext">Let users find you with ease, go beyond word of mouth to get new customers.</p>
						</div>
					</li>
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-check fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Get Recommendations</p>
							<p class="smalltext">Get recommendations from your other professionals to increase your trustworthyness.</p>
						</div>
					</li>
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-calendar-check-o fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Manage Appointments</p>
							<p class="smalltext">Let users book appointments with you, manage your schedule easily.</p>
						</div>
					</li>
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-comments-o fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Connect with users</p>
							<p class="smalltext">Write articles and respond to comments. Connect to users outside your locality, to get wider customer base.</p>
						</div>
					</li>
				</ul>
			<?php } else {?>
				<ul class="list-inline centertext whitetextshadow bulletadv">
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-search fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Find Professionals</p>
							<p class="smalltext">Find Lawyers, CAs, Doctors, NGOs according to specialisation, locality, fees and rating.</p>
						</div>
					</li>
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-check fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Expert Advice</p>
							<p class="smalltext">Read articles from experts from the field, explore database.</p>
						</div>
					</li>
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-calendar-check-o fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Book Appointments</p>
							<p class="smalltext">Book appointments online, view the next available appointment.</p>
						</div>
					</li>
					<li class="col-md-3 col-xs-12 padding2per">
						<i class="fa fa-commenting-o fa-5x col-xs-3 col-md-12" aria-hidden="true"></i>
						<div class="col-xs-9 col-md-12">
							<p class="xlargetext">Rate &amp; Review</p>
							<p class="smalltext">Read reviews before booking appointments and share your experience with others after.</p>
						</div>
					</li>
				</ul>
			<?php } ?>
		</div>
	</div>


<!-- <?php	//if(loggedin() == false){
   //include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'loginmodal.php';
// } ?> -->


</div>
