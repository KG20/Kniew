<div class="container-fluid">
	<div class="row centertext padding2per">Thank you for interest in <b>KNIEW</b></div>
</div>
<div class="container-fluid crossbackground zigzagBack paddingtop2per paddingbottom5per">

  <div class="row paddingbottom5per">

		<div class="col-xs-4">
			<!-- <svg  class="fullwidth">
			  <use xlink:href="#logo_shortest"></use>
			</svg> -->
     <div class="magnifyGlass"><span>Your Search is over!</span></div>
		</div>

    <?php
        if(isset($_SESSION['code']))
         $url_remain = 'comingsoon/reference/' . $_SESSION['code'];
        else if(isset($_POST['code']))
        $url_remain = 'comingsoon/reference/' . $_POST['code'];
       else $url_remain = '';
       $sharedescription = 'Check out this site to find professionals!';
       $share = 'Check out @kniew';
    ?>

		<div class="col-xs-8 paddingtop2per">
			<h3 class="centertext steelbluetext">DON'T LEAVE YOUR FRIENDS BEHIND!</h3>
			<h1 class="centertext  textshadowblack">INVITE FRIENDS &amp; EARN FREE SUBSCRIPTION!</h1>
			<p class="centertext smalltext greytext">Share your unique link via email, Facebook and Twitter and get upto 2 YEARS of FREE subscription for every friend that joins Kniew!</p>
      <div class="form-group">
        <div class="input-group">
          <input class="copyfrom form-control" type="text" value="<?php if($url_remain != '') echo BASE_PATH.$url_remain;?> ">
          <div class="input-group-btn">
            <button type="button" class="copyfrombutton btn ">Copy</button>
          </div>
        </div>
      </div>
      <div class="row margin2per">

        <ul class="list-inline center-block centertext xlargetext">
          <li>
            <a class="facebook customer share" href="https://www.facebook.com/dialog/feed?app_id=<?php echo FACEBOOK_APP_ID;?>&redirect_uri=<?php echo BASE_PATH;?> &link=<?php echo BASE_PATH . $url_remain;?>&picture=<?php echo LOGO;?>&caption=<?php echo urlencode($share);?> &description=<?php echo urlencode($sharedescription);?>" title="Share on facebook | Kniew" target="_blank"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>

            <!-- <div class="fb-share-button" data-href="<?php //echo BASE_PATH . $url_remain; ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php //echo parse_url(BASE_PATH . $url_remain); ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a></div> -->

          </li>
          <li>
            <a class="twitter customer share" href="https://twitter.com/share?url=<?php echo BASE_PATH . $url_remain;?>&amp;text=<?php echo $share; ?>&amp;<?php if(TWITTER_PROFILE != ''){?>via=<?php echo TWITTER_PROFILE;}?>&amp;hashtags=<?php echo $hashtags; ?>" title="Share on Twitter | Kniew" target="_blank"><i class="fa fa-twitter-square fa-2x" aria-hidden="true"></i></a>
          </li>

          <li>
            <a class="linkedin customer share" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo BASE_PATH . $url_remain ;?>&title=<?php echo $share; ?>" title="Share on LinkedIn | Kniew" target="_blank"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
          </li>

        </ul>
      </div>

		</div>
  </div>
  <div class="row">
    <div class="col-xs-2 ">
      <p class="smalltext textalignright">Friend's Joined</p>
      <p class="divider"></p>
      <p class="smalltext textalignright">Free Subscription</p>

    </div>

    <div class="col-xs-8 ">
      <div>
        <p class="col-xs-3"><span class="circlegrey centertext">0</span></p>
        <p class="col-xs-3"><span class="circlegrey ">5</span></p>
        <p class="col-xs-3"><span class="circlegrey ">10</span></p>
        <p class="col-xs-3 textalignright"><span class="circlegrey ">25</span></p>
      </div>
      <div class="progress col-xs-12">
        <div class="progress-bar" role="progressbar" style="width: <?php echo ($references/25) * 100 . '%'; ?>;" aria-valuenow=" <?php echo ($references/25) * 100; ?>" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div >
        <span class="col-xs-3">6 months</span>
        <span class="col-xs-3">1 Year</span>
        <span class="col-xs-3">1.5 Years</span>
        <span class="col-xs-3 textalignright">2 Years!</span>
      </div>
    </div>

    <div class="col-xs-12 error">
      *Register and login to track how many of your friends joined.
    </div>

  </div>



</div>
<?php  if(!loggedin()) {?>
<div class="container-fluid min100vh" id="referforms">

  <ul class="nav nav-tabs row crossbackground zigzagBack ">
      <li id = "user_refer" class="col-xs-6"><a href="#user_refer_tab" data-toggle="tab">FREE<br class="visible-xs"> Sign<br class="visible-xs"> Up!</a></li>
      <li class="active col-xs-6" id= "professional_refer"><a href="#professional_refer_tab" data-toggle="tab">Reach and connect with clients for Your PROFESSION for Free!</a></li>
  </ul>
  <div class="tab-content margin2per container">
       <div class="tab-pane fade row" id="user_refer_tab">
        <form action=" " method = "post"  role="form" id="userregisterform">
            <div class="form-group">
              <div class="col-sm-12">
                <label>Email </label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <span class="fa fa-envelope"></span>
                  </div>
                  <input type="email" name="email" class="form-control emailRegister" placeholder="janedoe@example.com" id= "emailRegister" value="<?php if($_POST['cs_email']) echo $_POST['cs_email']; ?>"/>
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
                    <input type="text" name="username"  class="form-control usernameRegister" placeholder="janedoe" id="usernameRegister"/>
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
                <input type="submit" id="userregisterbtn" name="userregisterbtn" value="Get a Free Account!" class="btn btn-success"/>
              </div>
            </div>

          </form>
           <div class="row margin2per pull-right">
                          <!-- btn facebooklogin signinnav <i class="fa fa-facebook" aria-hidden="true" ></i>btn googlelogin-->
            <div class="fb-login-button col-xs-6" data-scope="public_profile, email,user_about_me,user_birthday, user_location"   data-size="large" data-show-faces="false" data-auto-logout-link="false" onlogin="checkLoginState()" data-button-type="login_with" data-row-max="1"></div>
            <button type="button" id="signinButton" class="btn googlesignin col-xs-6"><i class="fa fa-google-plus" aria-hidden="true"></i> Sign in with Google</button>
          </div>
       </div>
       <div class="tab-pane fade active in row" id="professional_refer_tab">

        <?php include ROOT . DS . 'application' . DS . 'views' .DS . 'registerasprofessional' . DS . 'index.php'; ?>

       </div>
   </div>


</div>
<?php }
else echo '<a href="' . BASE_PATH . 'articles" class="textalignright margintop2per pull-right">Get a Sneak Preview! <i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
if(isProfessional())
{
  include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'billing.php';
}
?>
