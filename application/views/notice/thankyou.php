<div class="container paddingbottom10per">
<?php if($redirect = 'profession_register') {

	if($type == 2)
	{
		$url_remain = 'registerasprofessional';
		$share = 'Get donors and volunteers! Reach and connect with clients for your NGO! Register with Kniew NOW!';
		$hashtags ='Kniew, NGO, SocialWork, PromoteNGO, Donors, volunteers, help';
		$sharedescription = 'Reach and connect with clients for your NGO by listing on Kniew. Help more people. Find new donors and volunteers. Share your thoughts and increase your popularity.';
	}
	else if($type == 3)
	{
		$url_remain = 'registerasprofessional';
		$share = 'Get new Clients! Reach and connect with clients for your law practice! Register with Kniew NOW!';
		$hashtags ='Kniew, lawyer, lawFirm, PromoteLaw, legal ';
		$sharedescription = 'Reach and connect with clients for your Law Practice by listing on Kniew. Find new clients and build a trusting relationship with the community. Share your thoughts and increase your popularity.';
	}
	else if($type == 4)
	{
		$url_remain = 'registerasprofessional';
		$share = 'Help new patients find you easily! Reach and connect with clients for your Medical practice! Register with Kniew NOW!';
		$hashtags ='Kniew, medicine, doctor, hospital, clinic, PromoteClinic';
		$sharedescription = 'Reach and connect with clients for your Medical Practice by listing on Kniew. Help new patients and build a trusting relationship with the community. Share your thoughts and increase your reach.';

	}
	else if($type == 5)
	{
		$url_remain = 'registerasprofessional';
		$share = 'Get new Clients! Reach and connect with clients for your accountancy practice! Register with Kniew NOW!';
		$hashtags ='Kniew, accountancy, CA, charteredAccountant';
		$sharedescription = 'Reach and connect with clients for your CA Practice by listing on Kniew. Find new clients and build a trusting relationship with the community. Share your thoughts and increase your popularity.';
	}
	else
	{
		$url_remain = '';
		$share = 'Find lawyers, doctors, chartered accountants and NGOs with ease. Filter by name, location and specialisation. Sign up with Kniew NOW!';
		$hashtags ='findLawyer, findCA, findNGO, findDoctor, review, rate, Kniew';
		$sharedescription = 'Find information, appointment and reviews of top lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs near you. Get information from top experts and join in the discussion.';
		$type = NULL;

	}

?>



<?php } ?>

<div class="row">
	<h1 class="xxlargetext boldtext centertext">Thank you for choosing Kniew.</h1>
</div>
<div class="row">
	<p class="centertext"> Please <b>share</b> with your collegues, friends and family </p>

	<ul class="list-inline center-block centertext xlargetext">
	  <li>
	    <a class="facebook customer share" href="https://www.facebook.com/dialog/feed?app_id=<?php echo FACEBOOK_APP_ID;?>&redirect_uri=<?php echo BASE_PATH;?> &link=<?php echo BASE_PATH . $url_remain;?>&picture=<?php echo LOGO;?>&caption=<?php echo urlencode($share);?> &description=<?php echo urlencode($sharedescription);?>" title="Share on facebook | Kniew" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>

	    <!-- <div class="fb-share-button" data-href="<?php //echo BASE_PATH . $url_remain; ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php //echo parse_url(BASE_PATH . $url_remain); ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a></div> -->

	  </li>
	  <li>
	    <a class="twitter customer share" href="https://twitter.com/share?url=<?php echo BASE_PATH . $url_remain;?>&amp;text=<?php echo $share; ?>&amp;<?php if(TWITTER_PROFILE != ''){?>via=<?php echo TWITTER_PROFILE;}?>&amp;hashtags=<?php echo $hashtags; ?>" title="Share on Twitter | Kniew" target="_blank"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
	  </li>
	  <li>
	    <a class="google_plus customer share" href="https://plus.google.com/share?url=<?php echo BASE_PATH . $url_remain;?>" title="Share on Google Plus | Kniew" target="_blank"><i class="fa fa-google-plus-square fa-2x" aria-hidden="true"></i></a>
	  </li>
	  <li>
	    <a class="linkedin customer share" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo BASE_PATH . $url_remain ;?>&title=<?php echo $share; ?>" title="Share on LinkedIn | Kniew" target="_blank"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
	  </li>
	  <li>
	  	<a class="instagram customer share" href="<?php echo INSTAGRAM_PROFILE;?>" title="View on Instagram | Kniew" target="_blank"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
	  </li>
	</ul>
</div>

<div class="row">
	<div class="col-sm-4">
	<div class="thumbnail roundcorners5per">
	    <a href="<?php echo BASE_PATH.'articles';?>"><span class="thumbnaillink"></span></a>
		<img src="<?php echo BASE_PATH . '/images/feather_pen.jpg';?>" alt="Feather Pen" class="img-responsive roundcorners5per">
		<div class="caption centertext boldtext bottomtextonimg fullwidth whitetextshadow">
			<p class="xxlargetext">Share your thoughts with the community. Write an article.</p>
			<?php if($type != null) echo '<p class="smalltext">This helps in increasing your presence on the website and more consumers notice you.</p>';  ?>

		</div>
	</div>
	</div>

	<?php if(loggedin() == true) {?>
	<div class="col-sm-4">
	<div class="thumbnail roundcorners5per">
	    <a href="<?php echo BASE_PATH.'profile#settings';?>"><span class="thumbnaillink"></span></a>
		<img src="<?php echo BASE_PATH . '/images/erase.jpg';?>" alt="Edit profile" class="img-responsive roundcorners5per">
		<div class="caption centertext boldtext bottomtextonimg fullwidth whitetextshadow">
			<p class="xxlargetext">Make changes to your profile.</p>
		</div>
	</div>
	</div>
	<?php } ?>

	<?php if($type != 2){ ?>
	<div class="col-sm-4">
	<div class="thumbnail roundcorners5per">
	    <a href="<?php echo BASE_PATH.'professionals/ngo';?>"><span class="thumbnaillink"></span></a>
		<img src="<?php echo BASE_PATH . '/images/ngo.jpg';?>" alt="ngos" class="img-responsive roundcorners5per">
		<div class="caption centertext boldtext bottomtextonimg fullwidth whitetextshadow">
			<p class="xxlargetext">Find NGOs!</p>
		</div>
	</div>
	</div>
	<?php } ?>

	<?php if($type != 3){ ?>
	<div class="col-sm-4">
	<div class="thumbnail roundcorners5per">
	    <a href="<?php echo BASE_PATH.'professionals/lawyers';?>"><span class="thumbnaillink"></span></a>
		<img src="<?php echo BASE_PATH . '/images/law.jpg';?>" alt="ngos" class="img-responsive roundcorners5per">
		<div class="caption centertext boldtext bottomtextonimg fullwidth whitetextshadow">
			<p class="xxlargetext">Find Lawyers!</p>
		</div>
	</div>
	</div>
	<?php } ?>

	<?php if($type != 4){ ?>
	<div class="col-sm-4">
	<div class="thumbnail roundcorners5per">
	    <a href="<?php echo BASE_PATH.'professionals/doctors';?>"><span class="thumbnaillink"></span></a>
		<img src="<?php echo BASE_PATH . '/images/doc.jpg';?>" alt="ngos" class="img-responsive roundcorners5per">
		<div class="caption centertext boldtext bottomtextonimg  fullwidth whitetextshadow">
			<p class="xxlargetext">Find Doctors!</p>
		</div>
	</div>
	</div>
	<?php } ?>

	<?php if($type != 5){ ?>
	<div class="col-sm-4">
	<div class="thumbnail roundcorners5per">
	    <a href="<?php echo BASE_PATH.'professionals/charteredaccountants';?>"><span class="thumbnaillink"></span></a>
		<img src="<?php echo BASE_PATH . '/images/ca.jpg';?>" alt="ngos" class="img-responsive roundcorners5per">
		<div class="caption centertext boldtext bottomtextonimg fullwidth whitetextshadow">
			<p class="xxlargetext">Find Chartered Accountants!</p>
		</div>
	</div>
	</div>
	<?php } ?>

	<div class="col-sm-4">
	<div class="thumbnail roundcorners5per">
	    <a href="<?php echo BASE_PATH;?>"><span class="thumbnaillink"></span></a>
		<img src="<?php echo BASE_PATH . '/images/home.jpg';?>" alt="ngos" class="img-responsive roundcorners5per">
		<div class="caption centertext boldtext bottomtextonimg  fullwidth whitetextshadow">
			<p class="xxlargetext">Home!</p>
		</div>
	</div>
	</div>

</div>



</div>
