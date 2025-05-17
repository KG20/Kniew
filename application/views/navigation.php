<?php
	if(loggedin() == true)
	{
    if($_SESSION['usertype'] == 1) $typenameurl = 'user';
    elseif($_SESSION['usertype'] == 2) $typenameurl = 'professionals/ngo';
    elseif($_SESSION['usertype'] == 3) $typenameurl = 'professionals/lawyers';
    elseif($_SESSION['usertype'] == 4) $typenameurl = 'professionals/doctors';
    elseif($_SESSION['usertype'] == 5) $typenameurl = 'professionals/charteredaccountants';
    else $typenameurl = 'user';
	}
?>
<nav id='menu' class="navbar navbar-default " role="navigation">

	<div class="navbar-header navbar-header-center">

		<button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target="#navbar-collapse-1" id="navbar-toggle-change-icon">
	   <div id="navbar-hamburger">
        <p class="sr-only">Toggle Navigation</p>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </button>

        <button type="button" class="hidden-lg searchbutton pull-right btn" data-target="#searchBar">
			<span class="fa fa-times"></span>
			<span class="sr-only">Search</span>
		</button>
		<ul class="nav navbar-brand ">
				<li><a href="<?php echo BASE_PATH; ?>" id="logo_container">
					<!-- <img class="d-inline-block align-top" id="logo" src="<?php //echo BASE_PATH;?>images/logo.svg" > -->
				<svg  id="logo" >
				<use xlink:href="#logo_full"></use>
			</svg>
				</a></li>
		</ul>

		<?php if(loggedin() == false) { ?>
		  <a role="button" class="hidden-lg navbrightest  btn pull-right"  tabindex="0" href="<?php echo BASE_PATH; ?>registerasprofessional"> <b>Connect with<br/>New Clients NOW!</b> </a>
    	<!--<div class="starburst starburst_multipoint nav_starburst">LIMITED TIME OFFER!</div>-->

		<?php }
		else {
			?>
			<p class="pull-right positionRelative smallscreenright">
			<a class="pull-right hidden-lg btn navimgcont" href="<?php echo BASE_PATH .  $typenameurl .'/' . $_SESSION['username']; ?>" role="button">
				<?php	if(empty($_SESSION['profilepic']) === false){?>
		      <img src="<?php echo  BASE_PATH .$_SESSION['profilepic'];?>" />
				<?php } else { ?>
					<i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
				<?php } ?>
			</a>
			<a class="pull-right hidden-lg navmessages" href='<?php echo BASE_PATH; ?>messages'>
				<i class="fa fa-envelope" aria-hidden="true"></i>
			</a>
		</p>
		<?php }?>




	</div>

	<div class="collapse navbar-collapse" id="navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li class="nav-item"><a class="nav-link navstarter"  href='<?php echo BASE_PATH; ?>'><i class="fa fa-home"> </i><span class="toggletext "> Home</span></a></li>
			<li class="nav-item"><a class="nav-link" href='<?php echo BASE_PATH; ?>professionals/charteredaccountants'>Find a CA</a></li>
			<li class="nav-item"><a class="nav-link" href='<?php echo BASE_PATH; ?>professionals/lawyers'>Find a Lawyer</a></li>
			<li class="nav-item"><a class="nav-link" href='<?php echo BASE_PATH; ?>professionals/doctors'>Find a Doctor</a></li>
		    <li class="nav-item"><a class="nav-link" href='<?php echo BASE_PATH; ?>professionals/ngo'>Find a NGO</a></li>
			<li class="nav-item"><a class="nav-link"  href='<?php echo BASE_PATH; ?>articles'>Articles</a></li>
			<!-- <li class="nav-item"><a class="nav-link"  href='<?php //echo BASE_PATH; ?>/advice'>Ask Experts</a></li> -->
		</ul>

		<ul class="nav navbar-nav navbar-right" id="logininnav">
			<li role="separator" class="divider hidden-lg"></li>
			<li class="visible-lg">
				<button type="button"  data-target="#searchBar" class="searchbutton">
					<span class="fa fa-times"></span>
				</button>
			</li>

			<?php


			    if(loggedin() === true)
			    {
			    	if($_SESSION['usertype'] != 1 && $_SESSION['usertype'] != 2)
			    	{
			    		?>
				    		<li class="nav-item">
						    	<a class="nav-link" href='<?php echo BASE_PATH; ?>profile#appointment'>
							    	<i class="fa fa-calendar " aria-hidden="true">
								    	<span class="toggletext"> Appointment Calendar</span>
							    	</i>
						    	</a>
					    	</li>
			    		<?php
			    	}
			    	?>

						<!-- <li class="nav-item">
							<a class="nav-link" href=' '>
							<i class="fa fa-bell" aria-hidden="true"></i>
							<span class="toggletext ">Notifications</span>
							</a>
						</li> -->

						<li class="nav-item">
							<a class="nav-link" href='<?php echo BASE_PATH; ?>profile#bookedappointments'>
							<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
							<span class="toggletext ">Booked Appointments</span>
							</a>
						</li>

						<li class="nav-item navmessages">
							<a class="nav-link" href='<?php echo BASE_PATH; ?>messages'>
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<span class="toggletext ">Messages</span>
							</a>
						</li>




			        <li class="nav-item dropdown ">
					       <?php
			        	    if(empty($_SESSION['profilepic']) === false)
							{
								?>
								<a  class="nav-link dropdown-toggle disabled navimgcont" data-toggle="dropdown" href="<?php echo BASE_PATH .  $typenameurl .'/' . $_SESSION['username']; ?>" role="button">
			            <img src="<?php echo  BASE_PATH .$_SESSION['profilepic'];?>" />
			            <i class="fa fa-caret-down hidden-xs hidden-md hidden-sm" aria-hidden="true"></i>
	            <?php
			        }
	            else
	            {
		            ?>
		            <a  class="nav-link dropdown-toggle disabled" data-toggle="dropdown" href="<?php echo BASE_PATH .  $typenameurl .'/' . $_SESSION['username']; ?>" role="button">
		            	<span class='fa fa-user' aria-hidden='true'></span><i class='fa fa-caret-down hidden-xs hidden-md hidden-sm' aria-hidden='true'></i>
	            	<?php
	            }
		            ?>
	            <span class="toggletext "><?php echo $_SESSION['username']; ?></span>
            </a>


		               <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">

		                   <!-- <li>
					            <a tabindex='-1'  href="<?php //echo BASE_PATH; ?>referafriend">
						            <i class="fa fa-share-square-o" aria-hidden="true"></i>
						            Track your references
					            </a>
				            </li> -->
				             <?php if($_SESSION['usertype'] != 1) {?>
				            <li>
					            <a tabindex='-1'  href="<?php echo BASE_PATH; ?>Payment">
						            <i class="fa fa-money" aria-hidden="true"></i>
						            Add Payment method
					            </a>
				            </li>
				            <?php } ?>

				            <li class="visible-lg">
					            <a tabindex='-1'  href="<?php echo BASE_PATH  .$typenameurl.'/' . $_SESSION['username']; ?>">
						            <i class="fa fa-user" aria-hidden="true"></i>
						            <?php echo $_SESSION['username']; ?>
					            </a>
				            </li>

				            <li class="visible-lg">
						    	<a class="nav-link" href='<?php echo BASE_PATH; ?>profile#bookedappointments'>
							    	<i class="fa fa-calendar-check-o " aria-hidden="true">
								    	<span> Booked Appointments</span>
							    	</i>
						    	</a>
					    	</li>

				            <?php if($_SESSION['usertype'] != 1 && $_SESSION['usertype'] != 2)
					    	{
					    		?>
						    		<li class="visible-lg">
								    	<a class="nav-link" href='<?php echo BASE_PATH; ?>profile#appointment'>
									    	<i class="fa fa-calendar " aria-hidden="true">
										    	<span> Appointment Calendar</span>
									    	</i>
								    	</a>
							    	</li>
					    		<?php
					    	}
					    	?>

				            <li>
					            <a tabindex='-1'  href="<?php echo BASE_PATH; ?>profile#settings">
						            <i class="fa fa-cog" aria-hidden="true"></i>
						            Settings
					            </a>
				            </li>
							<?php if($_SESSION['usertype'] != 1){ ?>
										<li>
											<a tabindex='-1'  href="<?php echo BASE_PATH; ?>profile#addpaymentaccount">
												<i class="fa fa-id-card" aria-hidden="true"></i>
												Recieve Payments
											</a>
										</li>
							<?php } ?>

				            <li>
					            <a tabindex='-1'  href="<?php echo BASE_PATH; ?>profile#changepassword">
						            <i class="fa fa-asterisk" aria-hidden="true"></i>
						            Change Password
					            </a>
				            </li>

				            <?php
								if($_SESSION['access'] == 1){
							?>
							<li class="divider"></li>

				            <li>
					            <a tabindex='-1'  href="<?php echo BASE_PATH; ?>profile#addArticle">
						            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
						            Add Article
					            </a>
				            </li>


							<li class="divider"></li>

				            <li>
					            <a tabindex='-1'  href="<?php echo BASE_PATH; ?>profile#addfocus">
						            <i class="fa fa-filter" aria-hidden="true"></i>
						            Add Focus
					            </a>
				            </li>
				            <li class="divider"></li>

				            <li>
					            <a tabindex='-1'  href="<?php echo BASE_PATH; ?>profile#sendemail">
						            <i class="fa fa-envelope" aria-hidden="true"></i>
						            Send Email
					            </a>
				            </li>
				            <?
					        }
			            if($_SESSION['usertype'] != 1 && $_SESSION['usertype'] != 2)
			            	{
			            		?>
				            <li class=" visible-lg divider"></li>

				            <li  class="visible-lg">
					            <a tabindex='-1'  href="<?php echo BASE_PATH; ?>profile#appointment">
						            <i class="fa fa-calendar" aria-hidden="true"></i>
						            Appointment Calendar
					            </a>
				            </li>
				            <?php }
				            $get= ''; if($_GET['url']) $get = $_GET['url'];
				            ?>

							<li class="divider"></li>
				            <li>
					            <a tabindex='-1'  href="<?php echo BASE_PATH.'logout&prevurl=' . $get ; ?>">
						            <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
						            Log Out
					            </a>
				            </li>

				         </ul>
		        	</li>
			        	<?php

			    }
			    else
			    {

	    	?>
		    	<li class="nav-item"><a class="signin nav-link loginpop" role="button" tabindex="0" href=" "> <b>Sign in</b> </a></li>
		    	<li class="nav-item"><a class="signup nav-link registerpop navbright"  role="button" tabindex="0" href=" "> <b> Sign up </b> </a></li>
		    	<li class="nav-item"><a class="nav-link navbrightest" role="button" tabindex="0" href="<?php echo BASE_PATH; ?>registerasprofessional">Connect with New Clients Now!</a></li>
		    	<!--<div class="starburst starburst_multipoint nav_starburst">LIMITED TIME OFFER!</div>-->


			<?php }?>

		</ul>
	</div>

	<form class="navbar-form row" role="search" id="searchBar" method="POST" action="<?php echo BASE_PATH . 'search'; ?>" autocomplete="off">
		<div class="input-group">
			<input name="searchbarinput" type="text" id="showSearchTerm" class="form-control" placeholder="Enter name, title or specialisation."/>
			<span class="input-group-btn">
				<button type="reset" class="btn btn-default">
					<span class="fa fa-remove">
						<span class="sr-only">Close</span>
					</span>
				</button>
				<button type="submit" class="btn btn-default">
					<span class="fa fa-search">
						<span class="visible-lg">Search</span>
					</span>
				</button>
			</span>
		</div>
		<div id ="searchwebresult">
			<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
		</div>
	</form>

</nav>
