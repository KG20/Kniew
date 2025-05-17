<div class="container-fluid crossbackground min100vh">
	<div class="container margintop2per marginbottom2per">


		<div class="row ">

			<h1 class="col-xs-12 lightgreybottomborder">
				Who is it for?
			</h1>
			<div class="col-xs-12 col-sm-4 pull-right">
				<img class="fullwidth roundcorners2per" src="<?php echo BASE_PATH . 'images'. DS . 'search_spongebob.gif '; ?>" alt="Search for lawyers, doctors, chartered accountant and NGOs"/>
			</div>
			<div class="col-xs-12 col-sm-8 aboutcontainer">
				<ul class="listdisk listarrow padding5per lineheight2">
					<li>For students, newly employeed or any other people who just moved to new city.</li>
					<li>For businesses and startups who are looking for professional representation.</li>
					<li>For people who need help and support.</li>
					<li>For people who want to do good but don’t know where to start.</li>
					<li>For businesses looking to drive in new customers.</li>
					<li>For businesses looking to increase their online presence.</li>
					<li>For businesses looking for connection with new clients.</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<h1 class="col-xs-12 lightgreybottomborder">Inception of the Idea</h1>
			<div class="col-xs-12 aboutcontainer lineheight2">
				<p>
				At the root of every invention is the wish - <i>“I wish it was this way, so I could do that”</i>. Kniew is no different.
				</p>

				<p>
				Crime, crime, crime – it was all the newspaper was filled with, this made me wonder, if and how the victims could find the appropriate NGOs and/or lawyers to help them. I looked and looked for NGOs, so that I could volunteer, so that I can find NGOs, which help with particular cause. However, to my disappointment, even though I found loads of NGOs, I did not know which to trust, where to invest my time and money, especially to the cause I wanted.
				</p>

				<p>
				Another day, another time, in a new city, I fell sick. I was flabbergasted! I did not know which doctor to go to, which hospital or clinic could provide me with affordable and effective care? Thankfully, I had a relative in that town, who could help me, but for that I had to travel an hour every time I went to see the doctor. The same thing happened to my friend, years later, and unfortunately, she had no one to help her.
				</p>

				<p>
				This made me realize, even when we have someone in the city, they might know where should we go, or might not be aware of the new doctors with new technologies which have made their name in past few years; or simply, we might not be comfortable in telling them, such is the case with mental ailments or even counseling. It is in such cases where the aforementioned ‘word of mouth’ does no good.
				</p>
				<p>
				So, the wish – for a place where I can not only find this information in a collective and organized way but also, find testimonial from people who had interacted with these organizations. Kniew – a platform for knowledge (Kn-) and reviews (iew).
				</p>
			</div>
		</div>
		<div class="row">
			<h2 class="col-xs-12 lightgreybottomborder">Why choose <i>Kniew</i>?</h2>
			<div class="col-xs-12 aboutcontainer">
				<ul class="listdisk listsquare lineheight2">
					<li>Find professionals by their specialisation, location, rating and name.</li>
					<li>Seek advice through online messaging boards from professionals anywhere in the world.</li>
					<li>Compare professionals with others in same field.</li>
					<li>Find different kind of professionals for the same specialisation in one place. For example, find lawyer and charatered account for managing your taxes.</li>
					<li>Book appointments.</li>
					<li>Explore knowledge base with articles written from professionals and other users.</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<p class="centertext "> <b>Share my story!</b> </p>

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
	<div class="row marginbottom2per margintop2per">
		<div class="col-xs-12 col-sm-6"><a class="signup margin2per registerpop btn-lg btn-success float-sm-right text-sm-center"  role="button" tabindex="0" href=" "> <b> FREE <br class="hidden-xs"> Sign up! </b> </a></div>
    	<div class="col-sm-6 col-xs-12"><a class=" margin2per btn-lg btn-warning pull-left text-sm-center" role="button" tabindex="0" href="<?php echo BASE_PATH; ?>registerasprofessional"><b>Connect with <br class="hidden-xs">New Clients NOW!</b></a></div>
	</div>
</div>
