<?php include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'loginmodal.php'; ?>
<div class="container-fluid paddingZero">
	<div class="textaligncenter xxlargetext" id="landlogocontainer">
		<svg id="landlogo">
			<use xlink:href="#logo_full"></use>
		</svg>
	</div>
	<div id="landdiv" class="container-fluid ">
		<div class="col-xs-12 textaligncenter paddingtop5per allheadings">
			<h1 class="mainhead">Tired of waiting for clients to come to your doorsteps?</h1>
			<!-- <h5 class="subhead">Online Consultation | Appointments | Chartered Accountants | Lawyers | Doctors | NGOs</h5> -->
			<!-- <h6 class="description ">Even in these uncertain times connect with new clients. Don't let COVID-19, limitation of location or lack of advertising limit your potential.  <?php //echo WEBNAME;?> can help you connect with new clients through messages, make online appointments and grow your customer base.</h6> -->
			<h5 class="description">Connect with new clients and donors anywhere across the globe in an <i>easy</i> and <i>affordable</i> way. Leave the <i>hassle</i> of expensive advertising behind. From the safety of your own home <i>without any additional cost</i>, increase your clientele and manage appointments.</h5>
			<!-- <span>For Chartered Accountants, Lawyers, Ngos and Doctors</span> -->
		</div>
		<div class="col-xs-12 textaligncenter buttonscontainer">
			<?php if(loggedin()) { ?>
				<p class="marginZero">
					<a role="button" class=" btn btn-lg breakspace"  id="landSignUp" tabindex="0" href="<?php echo BASE_PATH; ?>messages"> <i class="fa fa-envelope"></i> Go to Messages  </a>
					<div class="textaligncenter paddingtop2per">
						<a class="textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/charteredaccountants">Chartered Accountants</a> <p class="visible-xs"></p>
						<a class="textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/lawyers">Lawyers</a> <p class="visible-xs"></p>
						<a class="textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/doctors">Doctors</a> <p class="visible-xs"></p>
						<a class=" textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/ngo">NGOs</a> <p class="visible-xs"></p>
					</div>
				</p>
			<?php } else { ?>
			<p class="marginZero">
				<a role="button" class=" btn btn-lg" id="landSignUp"  tabindex="0" href="<?php echo BASE_PATH; ?>registerasprofessional"> Connect with New Clients - Join Now!  </a>
			</p>
			<p class="marginZero">
				<button class="btn btn-link btn-sm signup registerpop">
					Find & Connect with Professionals - Join Now!
				</button>
			</p>
			<p class="marginZero greytext xsmalltext">Free account for life. No Charges, No credit card required.</p>
			<?php } ?>

		</div>
		<div class="row pull-right textalignright carouselinfo paddingbottom1per">
			<div class="col-xs-12 carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<span class="item active">New to your Profession?</span>
					<span class="item">Competiting with growing professionals?</span>
					<span class="item">'Word of mouth' not cutting it?</span>
					<span class="item">Reach and connect with clients!</span>
					<span class="item">Increased income with online consultation!</span>
					<span class="item">Get peer recommendations.</span>
					<span class="item boldtext">Join <?php echo WEBNAME;?>.</span>
					<span class="item">New in the City?</span>
					<span class="item">Starting a business?</span>
					<span class="item">Don't Know who to trust?</span>
					<span class="item">Don't Know where to look?</span>
					<span class="item">Find Doctors!</span>
					<span class="item">Find Lawyers!</span>
					<span class="item">Find CAs!</span>
					<span class="item">Find NGOs!</span>
					<span class="item">Rate and review your experience.</span>
					<span class="item boldtext">Join <?php echo WEBNAME;?>.</span>
				</div>
			</div>
		</div>
		<div class="graphicmask crossbackground row"></div>
	</div>
	<div id="landbullets" class="container-fluid paddingZero">
		<ul class="list-inline centertext webfeatures marginZero">
			<li class="col-xs-12 col-sm-3">
				<p><i class="fa fa-comments-o fa-3x" aria-hidden="true"></i></p>
				<p class="description">Online Consultation</p>
			</li>
			<li class="col-xs-12 col-sm-3">
				<p><i class="fa fa-calendar-check-o fa-3x" aria-hidden="true"></i></p>
				<p  class="description">Book & Manage Appointments</p>
			</li>
			<li class="col-xs-12 col-sm-3">
				<p><i class="fa fa-search fa-3x" aria-hidden="true"></i></p>
				<p  class="description">Find Lawyers, CAs, Doctors, NGOs.</p>
			</li>
			<li class="col-xs-12 col-sm-3">
				<p><i class="fa fa-pencil-square-o  fa-3x" aria-hidden="true"></i></p>
				<p class="description">Expert Advice, Articles, Rate &amp; Review <span class="pull-right fa fa-caret-down steelbluetext largetext boldtext"></span></p>
			</li>
		</ul>
	</div>
	<div class="container-fluid paddingZero">
		<ul class="nav nav-tabs textaligncenter xsmalltext crossbackground landtabs">
      <li class="active width20per"><a href="#ca" data-toggle="tab"><i class="fa fa-calculator fa-2x" aria-hidden="true"></i>
			<p><span class="hidden-xs">Chartered Accountant</span><span class="visible-xs">CA</span></p></a></li>
			<li class="width20per"><a href="#lawyer" data-toggle="tab"><i class="fa fa-gavel fa-2x" aria-hidden="true"></i>
			<p>Lawyer</p></a></li>
			<li class="width20per"><a href="#doctor" data-toggle="tab"><i class="fa fa-stethoscope fa-2x" aria-hidden="true"></i>
			<p>Doctor</p></a></li>
			<li class="width20per"><a href="#ngo" data-toggle="tab"><i class="fa fa-heartbeat fa-2x" aria-hidden="true"></i>
			<p>NGO</p></a></li>
			<li class="width20per"><a href="#user" data-toggle="tab"><i class="fa fa-user fa-2x" aria-hidden="true"></i>
			<p>User</p></a></li>
		</ul>
		<div class="tab-content contentcontainer">
		<?php
			$roles = array('ca','lawyer','doctor','ngo','user');
			$data['ca'] = $data['lawyer'] = $data['doctor'] = array(
				array('heading' => 'Provide Online Consultation', 'details' => 'Provide consultation through online messaging system at your leisure. Connect with clients anywhere in the world.'),
				array('heading' => 'Dynamic consultation fees', 'details' => 'Decide consultation fee after talking to user and as per use case.'),
				array('heading' => 'Manage your appointments', 'details' => 'Allows user to book appointment with you. Manage all your appointments. Block holidays, personal days or days when you are too busy to allow more appointments.'),
				array('heading' => 'Share your thoughts', 'details' => 'Share your brilliant mind with the world by writing articles. Impart wisdom and connect with more users.'),
				array('heading' => 'Peer Recommendations', 'details' => 'Recommend and get recommendations from colleagues and friends to boost your profile.'),
				array('heading' => 'Increased Visibilty', 'details' => 'Users can search you by name, location, specialisation and experience.'),
			);
			$data['ngo'] = array(
				array('heading' => 'Receive Donations', 'details' => 'Receive online donations from users from anywhere in the world.', 'screenshot'=> 'ss_ngo_transcations.png'),
				array('heading' => 'Receive Dynamic Donations', 'details' => 'A lot of people want to donate but not everyone can donate the same amount of money. You can recieve different amount of donations from donors as per their capabilities.', 'screenshot'=>'ss_ngo_donate.png'),
				array('heading' => 'Increased Visibilty', 'details' => 'Users can search you by name, location, your mission and the years you have dedicated in making society better.','screenshot'=>'ss_ngo_filter.png'),
				array('heading' => 'Build Trust', 'details' => 'Help users trust you and remove any doubt by adding your NGO Darpan identifier and get user ratings and reviews.','screenshot'=>'ss_ngo_review.png'),
				array('heading' => 'Share your thoughts', 'details' => 'Spread awareness about your cause. Share your brilliant mind with the world by writing articles. Impart wisdom and connect with more users.', 'screenshot'=>'ss_ngo_articles.png'),
				array('heading' => 'Peer Recommendations', 'details' => 'Recommend and get recommendations from colleagues and friends to boost your profile.','screenshot'=>'ss_ngo_recommend.png'),
			);
			$data['user'] = array(
				array('heading' => 'Online Consultation', 'details' => 'Contact professionals, and ask them about your issue. Don\'t pay until you have discussed outline of your issue and got a roadmap to your issue.', 'screenshot'=>'ss_user_msg.png'),
				array('heading' => 'Book Appointments', 'details' => 'Your time is precious; don\'t waste it in a waiting room. Book appointment with best professionals near you. Check for the next available appointment.','screenshot'=>'ss_user_appointment.png'),
				array('heading' => 'Donate to NGO reliably', 'details' => 'Donate to reliable NGOs as much as you like. Verify NGO Darpan identifier and read ratings and reviews by other users.','screenshot'=>'ss_ngo_donate.png'),
				array('heading' => 'Articles by Professionals', 'details' => 'Expand your knowledge. Find informative articles. Get to know about the professional\'s way of thinking.', 'screenshot'=>'ss_user_articles.png'),
				array('heading' => 'Rate & Review', 'details' => 'Review professionals and share your experience and grievances. Help other users.','screenshot'=>'ss_user_review.png'),
				array('heading' => 'Find Top CAs, Lawyers, Doctors & NGO', 'details' => 'Find professionals by name, location, specialisation, experience and rating.', 'screenshot'=> 'ss_ca_filter.png'),
			);
			foreach ($roles as $key => $role) {
				$addclass = '';
				if($key == 0) $addclass = ' active in ';
				echo '<div class="tab-pane fade container-fluid  '.$addclass.' " id="'.$role.'">';

				if($role == 'ca' || $role == 'lawyer' || $role == 'doctor')
					$screenshots =array(
						'ss_'.$role.'_msg.png',
						'ss_'.$role.'_fee.png',
						'ss_'.$role.'_appointment.png',
					 	'ss_'.$role.'_articles.png',
					 	'ss_'.$role.'_recommend.png',
						'ss_'.$role.'_filter.png'
					);

				$lastback = '';

				$len = sizeof($data[$role]) + 1; //added one so as to add video

				for ($i=0; $i < $len ; $i++) {
					$backgroundclass = '';
					$pullrightodd = '';
					$posclass ='';
					if($role == 'ca' || $role == 'lawyer' || $role == 'doctor') $data[$role][$i] = array_merge($data[$role][$i], ['screenshot'=>$screenshots[$i]]);

					if($i % 2 != 0)
					{
						$backgroundclass = ' alternativeback ';
						$pullrightodd = ' pull-right ';
					}
					else
					{
						if($i == $len -1)	$lastback = ' alternativeback ';
					}

					echo '<div class="lazyload"><!--<div class=" row '.$backgroundclass.' padding2per positionRelative">';
					if($i == $len-1)
					{
						echo '<div class="col-sm-12 col-md-7 '.$pullrightodd.'">';
						echo '<div class="embed-responsive embed-responsive-1by1 min50vh handcursor roundcorners10per"><iframe id="songVideo" class="video_round embed-responsive-item" src="';
						if($role == 'user') echo 'https://www.youtube.com/embed/mu_L2eErJg8'; else echo 'https://www.youtube.com/embed/v5kBAo_VJGU';
						echo '?rel=0&amp;autoplay=1&mute=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>';
						echo '</div><div class="col-sm-12 col-md-5 textaligncenter text-sm-justify paddingtop5per'.$posclass.'">Watch a fun little video about '.WEBNAME.'.</div>';
					}
					else {
						echo '<div class="col-sm-12 col-md-7 '.$pullrightodd.'">
						<img class="fullwidth" src="images/'.$data[$role][$i]['screenshot'].'" alt="'.$data[$role][$i]['heading'].'"/></div>
						<div class="col-sm-12 col-md-5 textaligncenter text-sm-justify paddingtop5per'.$posclass.'">
							<h3>'.$data[$role][$i]['heading'].'</h3>
							<h6>'.$data[$role][$i]['details'].'</h6>
						</div>';
					}
					echo '</div>--></div>';
				}

				echo '<div class=" row '.$lastback.' padding2per positionRelative lightbluebottomborder">
					<div class="col-xs-12 textaligncenter buttonscontainer">';

				if(loggedin())
				{
					echo '
						<p class="marginZero">
							<a role="button" class=" btn btn-lg btn-warning breakspace"  tabindex="0" href="'. BASE_PATH.'messages"><i class="fa fa-envelope"></i> Go to Messages</a>
						</p>';
				}
				else {
					echo '
						<p class="marginZero">
							<a role="button" class=" btn btn-lg btn-warning breakspace"  tabindex="0" href="'. BASE_PATH .'registerasprofessional"> Connect with New Clients - Join Now!  </a>
						</p>
						<p class="marginZero">
							<button class="btn btn-link btn-sm signup registerpop ">
								Find & Connect with Professionals - Sign up!
							</button>
						</p>
						<p class="marginZero greytext xsmalltext">Free account for life. No Charges, No credit card required.</p>';
					}
					echo'
					</div>
					<div class="textaligncenter paddingtop2per col-xs-12">
						<a class=" textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/charteredaccountants">Chartered Accountants</a> <p class="visible-xs"></p>
						<a class=" textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/lawyers">Lawyers</a> <p class="visible-xs"></p>
						<a class=" textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/doctors">Doctors</a> <p class="visible-xs"></p>
						<a class="textaligncenter padding2per textunderline" href="'.BASE_PATH. 'professionals/ngo">NGOs</a> <p class="visible-xs"></p>
					</div>
				</div>';
				echo '</div>';

			}



		?>

	 </div>
	</div>
</div>
