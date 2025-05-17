<div id="foot" class= "container-fluid">
	<div class="row fullwidth">
	<?php $get= ''; if($_GET['url']) $get = $_GET['url'];?>

		<!-- <div class="hidden-xs col-sm-2"></div> -->
		<div class="col-xs-12 col-sm-3 hidden-xs">
			<ul>
				<li> <a href="<?php echo BASE_PATH; ?>">Home</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>professionals/charteredaccountants">Chartered Accountants</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>professionals/lawyers">Lawyers</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>professionals/doctors">Doctors</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>professionals/ngo">NGOs</a> </li>
			</ul>
		</div>

		<div class = "col-xs-12 col-sm-6" id="foot01">

				<p class="centertext "> <b><?php echo "@" .date('Y') . ' ' . WEBNAME; ?></b> </p>

				<ul class="list-inline center-block centertext ">
				  <li>
				    <a class="facebook customer share" href="https://www.facebook.com/dialog/feed?app_id=<?php echo FACEBOOK_APP_ID;?>&redirect_uri=<?php echo BASE_PATH;?> &link=<?php echo BASE_PATH;?>&picture=<?php echo LOGO;?>&caption=<?php echo urlencode($share);?> &description=<?php echo urlencode($sharedescription);?>" title="Share on facebook | Kniew" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>

				    <!-- <div class="fb-share-button" data-href="<?php //echo BASE_PATH . $url_remain; ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php //echo parse_url(BASE_PATH . $url_remain); ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a></div> -->

				  </li>
				  <li>
				    <a class="twitter customer share" href="https://twitter.com/share?url=<?php echo BASE_PATH ;?>&amp;text=<?php echo $share; ?>&amp;<?php if(TWITTER_PROFILE != ''){?>via=<?php echo TWITTER_PROFILE;}?>&amp;hashtags=<?php echo $hashtags; ?>" title="Share on Twitter | Kniew" target="_blank"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
				  </li>
				  <li>
				    <a class="google_plus customer share" href="https://plus.google.com/share?url=<?php echo BASE_PATH ;?>" title="Share on Google Plus | Kniew" target="_blank"><i class="fa fa-google-plus-square fa-2x" aria-hidden="true"></i></a>
				  </li>
				  <li>
				    <a class="linkedin customer share" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo BASE_PATH;?>&title=<?php echo $share; ?>" title="Share on LinkedIn | Kniew" target="_blank"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
				  </li>
				  <li>
				  	<a class="instagram customer share" href="<?php echo INSTAGRAM_PROFILE;?>" title="View on Instagram | Kniew" target="_blank"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
				  </li>
				</ul>
		</div>
		<div class="col-xs-12 col-sm-3 loggedin">
			<ul class = "text-xs-center text-sm-right ">
				<li> <a class="visible-xs" href="<?php echo BASE_PATH; ?>">Home</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>about">About</a> </li>
				<li> <a class="visible-xs" href="<?php echo BASE_PATH; ?>professionals/charteredaccountants">Chartered Accountants</a> </li>
				<li> <a class="visible-xs" href="<?php echo BASE_PATH; ?>professionals/lawyers">Lawyers</a> </li>
				<li> <a class="visible-xs" href="<?php echo BASE_PATH; ?>professionals/doctors">Doctors</a> </li>
				<li> <a class="visible-xs" href="<?php echo BASE_PATH; ?>professionals/ngo">NGOs</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>contact">Contact Us</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>privacy">Privacy Policy</a> </li>
				<li> <a href="<?php echo BASE_PATH; ?>termsandconditions">TOS</a> </li>
				<li> <?php if(loggedin() === true){ ?> </li>
				<li> <a href="<?php echo BASE_PATH; ?>settings">Settings</a> </li>
				<li> <a href= "<?php  echo BASE_PATH.'logout&prevurl=' . $get ; ?>">Log out</a> </li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>

<?php include('foot.php');?>
