<?php
if($urlArray[2] == 400) error_page_html('Bad request!', 'broken_page');
else if($urlArray[2] == 401) error_page_html('Unauthorized access.', 'secure_page');
else if($urlArray[2] == 403) error_page_html('Access to this page is forbidden.', 'secure_page');
else if($urlArray[2] == 404) error_page_html('Page not found!', 'not_found');
else if($urlArray[2] == 500) error_page_html('Internal server error!', 'broken_page');
else if($urlArray[2] == 503) error_page_html('Service unavailable!', 'broken_page');
else error_page_html('Error!', 'logo_vertical_name');



function error_page_html($message, $icon = 'logo_vertical_name')
{
	?>
		<div class="container-fluid crossbackground min100vh">
		<div class="row">
			<h3 class="xxlarge centertext margin2per padding2per"><i><b class="xxlargetext">Sorry!</b> <span class="xlargetext"><?php echo $message; ?></span></i></h3>

			<div class="col-sm-5 col-md-5">
				<!-- <div> -->
				<!-- <img class="fullwidth" src="<?php //echo BASE_PATH . 'images\icons\\'.$icon.'.svg';?>"></div> -->
				<svg  class="error_icon" >
				  <use xlink:href="#<?php echo $icon; ?>"></use>
				</svg>
				<?php if($icon != 'logo_vertical_name')echo '<div class="centertext xxlargetext">Kniew</div>';?>
			</div>
			<div class="col-sm-7 col-md-5">


				<p class="margin5per">
					<form role="search" method="POST" action="<?php echo BASE_PATH . 'search'; ?>" autocomplete="off">
						<div class="form-group has-success">
						<div class="input-group input-group-lg">
							<input name="searchbarinput" type="text" id="showSearchTerm" class="form-control" placeholder="Enter name, title or specialisation."/>
							<span class="input-group-btn">
								<button type="reset" class="btn btn-danger">
									<span class="fa fa-remove">
										<span class="sr-only">Close</span>
									</span>
								</button>

								<button type="submit" class="btn btn-success">
									<span class="fa fa-search"> Search</span>
								</button>
							</span>
						</div>
						</div>
						<div id ="searchwebresult">
							<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
						</div>
					</form>

					<div class="margin5per centertext">

						<p><a href="<?php echo BASE_PATH;?>">Home page</a></p>
						<p><a href="<?php echo BASE_PATH .'professionals/charteredaccountants';?>">Find a Chartered Accountants</a></p>
						<p><a href="<?php echo BASE_PATH .'professionals/lawyers';?>">Find a Lawyers</a></p>
						<p><a href="<?php echo BASE_PATH . 'professionals/doctors';?>">Find a Doctor</a></p>
						<p><a href="<?php echo BASE_PATH . 'professionals/ngo';?>">Volunteer</a></p>
						<p><a href="<?php echo BASE_PATH .'articles';?>">Articles</a></p>
						<p><a href="<?php echo BASE_PATH . 'about';?>">About</a></p>
						<p><a href="<?php echo BASE_PATH .'contact';?>">Contact</a></p>

					</div>

					<p class="centertext">
							<button class="signin loginpop btn btn-default btn-lg" role="button" tabindex="0" href=" "> <b>Sign In</b> </button>
							<button class="signup registerpop btn btn-primary btn-lg"  role="button" tabindex="0" href=" "> <b> Sign Up! </b> </button>
					</p>
					<?php include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'loginmodal.php'; ?>

				</p>
			</div>
		</div>
		</div>
	<?php
}
?>
