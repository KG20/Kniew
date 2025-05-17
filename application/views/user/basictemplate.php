<div class="container-fluid whitesmokeBack" id="userDetails">
<div class="container">

<?php
	if(isset($details['userdetails']) && !empty($details['userdetails']))
	{
		$information = json_decode($details['userdetails']);
	}

?>

	<div class="row userinfo crossbackground">
		<div class="col-sm-3 ">
			<div class="imgdiv">
				<?php
					if($information->profilepic) {
						if (substr( $information->profilepic, 0, 4 ) === "http") {
							$profilepic = $information->profilepic;
						}
						else $profilepic = BASE_PATH .$information->profilepic;
				?>
				   	<img src="<?php echo $profilepic;?>" alt="<?php echo $information->name; ?>" />
				<?php
					}
					else
					{
				?>
					<div class=" imagecontainer"><i class="fa fa-user imagetext"></i></div>
				<?php } ?>
			</div>
			<h1><?php if(isset($information->name) && $information->name != '') echo $information->name; else echo $username;?> </h1>
			<p class="xsmalltext"><i>Member since</i> <?php echo date('d F Y', strtotime($details['joiningdate'])); ?> </p>
		</div>
		<div class="col-sm-9 whitetransparent">

		<?php
			if((isset($details['userdetails']) && !empty($details['userdetails'])) && (isset($information->dob) || isset($information->occupation) || isset($information->about) || isset($information->showcontactdetails) ) )
			{

				if(isset($information->dob) && $information->dob != null){ echo "<h2>Born on</h2> <p>" . date('d F Y', strtotime($information->dob)) . "</p>";}


				if(isset($information->occupation) && $information->occupation != null) echo "<h2>Occupation</h2>
						<p>".$information->occupation."</p>";

				if(isset($information->about) && $information->about != null) echo "<h2>About</h2>
						<p>".$information->about."</p>";

				if(isset($details['showcontactdetails']) && $details['showcontactdetails'] == true)
					echo "<h2>Contact</h2>
							<p>".$information->address."<br>
							  ".$details['email'] . "<br>
							  ".$information->phone . "</p>";


			}
			else{
			?>

			<div class="nouserdetails">No information about this user is available.</div>

			<?php
			}
		?>


		</div>

	</div>

	<div class="row whiteBack" id="articleby">
		<h1>Articles by <?php if(isset($information->name) && $information->name != '') echo $information->name; else echo $username; ?></h1>
		<ul id="articlebycall" data-articlebyid="<?php echo $details['id']; ?>" data-perpage='10'></ul>
		<span class="loader ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
		<button class="btn btn-default" id="loadmorearticleby">Load More</button>
	</div>

	<?php if((loggedin() == true && $_SESSION['id'] == $details['id']) || $information->showlikedarticles == true ){ ?>

	<div class="row whiteBack" id="likedArticles">
		<h1>Liked Articles</h1>
		<ul id="likedbycall" data-likedbyid="<?php echo $details['id']; ?>"></ul>
		<span class="loader ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
		<button class="btn btn-default" id="loadmoreliked">Load More</button>

	</div>
	<?php } ?>


</div>
</div>
