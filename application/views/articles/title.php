<div class="container-fluid">
	<div class="row">
	<?php 
		if(empty($articlebytitle) || empty($articlebytitle['articleid']))
		{
			echo "<div class='noarticle'>Article does not exists, please go to the articles page to search for another article or check the link for errors. </div>";
		}
		else
		{
		$details = json_decode($articlebytitle['articledetails']);
		$details->title = ucfirst(htmlspecialchars_decode($details->title));
	?>
		<div class="col-md-1"></div>
		<div class="col-md-10 articledisplay" id="articlecontainer">
			
			<div class="row">
				<h1 class="col-xs-12 pagetitle"><?php echo $details->title; ?> </h1>
				<p class = 'createdarticle col-xs-10'> 
					<?php if(!empty($articlebytitle['username'])){ ?>
						<span><a href="<?php echo BASE_PATH . 'user/' . $articlebytitle['username'];?>"><?php echo $articlebytitle['username']; ?></a></span><br>
					<?php } else { ?>
					<span><?php echo $details->name; ?></span><br>
					<?php } ?>
					<i><?php if($details->modifiedat) echo $details->modifiedat; else echo $details->createdat; ?> </i>
				</p>
				<?php
					if(isAdmin() === true)
					{
						?>

						<div class="col-xs-2">
							<button class="btn btn-default pull-right" id ="articleedit"><i class="fa fa-pencil"></i></button>
							<button class="btn btn-default pull-right" id="articledelete"><i class="fa fa-times"></i></button>						
						</div>

						<?php
					} 
				?>
				<div class="col-xs-12 imgdiv">
					<?php if(!empty($details->filepath)) { ?>
					   <img class ="displayimage row" src="<?php echo BASE_PATH . $details->filepath; ?>" alt="<?php echo $details->title; ?>"/>			    
					<?php } ?>	
				</div>
			</div>
			<div class="displaystory row">
				<?php echo html_entity_decode($details->story); ?>
			</div>

			<?php 
				$likesdislikes = explode(',', str_replace(array('(',')'), '', $articlebytitle['likesdislikes']));
			?>

			<div class="row">
				<div class="col-sm-2 col-sm-push-10">
					<div class="voting_wrapper" id = "<?php echo $articlebytitle['articleid']; ?>" data-logged = "<?php if(loggedin()) echo true; else echo false; ?>">
						<div class="voting_btn col-xs-6">
				            <div class="up_button"><i class="fa fa-thumbs-up fa-2x <?php if($votedAlready['islike'] == true) echo 'voted'; ?>"></i>&nbsp;</div>
				            <span class="up_votes"><?php echo $likesdislikes[0]; ?></span>
				        </div>
						<div class="voting_btn col-xs-6 ">
				            <div class="down_button"><i class="fa fa-thumbs-down fa-2x  <?php if(isset($votedAlready['islike']) && $votedAlready['islike'] == false) echo 'voted';?>"></i>&nbsp;</div>
				            <span class="down_votes"><?php echo $likesdislikes[1]; ?></span>
				        </div>
					<div id="vote_result" class="error"></div>

			        </div>
				</div>

				<ul class="list-inline col-sm-10 sharecontainer col-sm-pull-2">
				  <li>
				    <a class="facebook customer share" href="https://www.facebook.com/dialog/share?app_id=1821389461445993&href=<?php echo BASE_PATH . $GLOBALS['url'] ;?>" title="Share on Facebook" target="_blank"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
				  </li>
				  <li>
				    <a class="twitter customer share" href="https://twitter.com/share?url=&amp;text=<?php echo $details->title; ?>&amp;hashtags=<?php echo WEBNAME; ?>" title="Share on Twitter" target="_blank"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
				  </li>
				  <li>
				    <a class="google_plus customer share" href="https://plus.google.com/share?url=<?php echo BASE_PATH . $GLOBALS['url'] ;?>" title="Share on Google Plus" target="_blank"><i class="fa fa-google-plus fa-2x" aria-hidden="true"></i></a>
				  </li>
				  <li>
				    <a class="linkedin customer share" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo BASE_PATH . $GLOBALS['url'] ;?>&title=<?php echo $details->title; ?>" title="Share on LinkedIn" target="_blank"><i class="fa fa-linkedin fa-2x" aria-hidden="true"></i></a>
				  </li>
				</ul>
			</div>
			<div class="articletag row">
				<?php
					foreach ($details->tags as $tagfull)
					{
						error_reporting(0);
						$tag = array_map('trim', explode(',', $tagfull));
					   	$tag[0] = $tag[0] ? $tag[0] : $tagfull;
					   	$tag[0] = ucwords($tag[0]);
					   	$tagurl = str_replace('&', '_', $tagfull);

				   		if($tag[1] == 2) $tagclass = 'label-success';
					   	elseif($tag[1] == 3) $tagclass = 'label-primary';
					   	elseif($tag[1] == 4) $tagclass = 'label-danger';
					   	elseif($tag[1] == 5) $tagclass = 'label-warning';
					   	else $tagclass = 'label-default';

					   	$tagurl = '&tags[]=' . urlencode($tagurl);


						echo ' <a href="'.BASE_PATH . 'articles'. $tagurl .'" class="label '.$tagclass.'" role="button">'. $tag[0] .'</a>';
										
					}
				?>
			</div>

		</div>
		<?php
			if(isAdmin() === true)
			{
				?>
		<div class="col-md-10 articledetails">
			<form id="articledeleteform" method="post" class="form" name="articledeleteform">
				<p>Are you sure you want to delete this article? Once deleted, it cannot be recovered.</p>
				<input type="hidden" name="articleid" value="<?php echo $articlebytitle['articleid']; ?>">
				<input type="submit" name="deletesubmit" id="deletesubmit" class="btn btn-danger form-input" value="Delete Article"/>
				<div id="deletearticlecomplete"></div>
			</form>

			<form name="articleeditform" method="POST" id="articleeditform" action=" "  enctype="multipart/form-data" autocomplete="off" data-articleid= "<?php echo $articlebytitle['articleid']; ?>" data-title="<?php echo $details->title; ?>">

					<h1 class="row"><input required type="text" name="title"  class="form-control" value="<?php echo $details->title; ?>"> </h1>
					 <input type="hidden" name="oldtitle" value="<?php echo $details->title; ?>">
					 <div id="editarticleimg">

					 <?php 
						 $_GET['imgurl'] = $details->filepath;
						 include ROOT . DS . 'application' . DS . 'views' .DS . 'widgets' . DS . 'imageeditor.php'; 
						 ?>
					 </div>
					 <button type="button" id="deletearticlepic" class="margin2per btn-xs btn-danger noborder xsmalltext" data-articleid="<?php echo $articlebytitle['articleid']; ?>">Remove display picture</button>

					 <input type="hidden" name="oldimageurl" value="<?php echo $details->filepath; ?>">

					<div class="row">
						<textarea name="story"  class="form-control story" rows = "10"><?php echo html_entity_decode($details->story); ?></textarea>

					</div>
					<input type="hidden" name="articleid" value="<?php echo $articlebytitle['articleid']; ?>">

					<div class="row">	                	                     
		                <input name="add" type="submit" id="submiteditarticle" value="Edit" class="btn btn-info col-sm-4">
		  
						<button class="btn btn-default col-sm-4" type ="button" id="canceleditarticle" >Cancel</button>			             			                
		            </div>
				    <div id="editarticlecomplete"></div>


			</form>


		</div>
		<?php } ?>
		<div class="col-md-1"></div>		
	</div>



	<div class="row crossbackground  authordetails">
		<div class="col-sm-2">
			<?php if($articlebytitle['profilepic']) {?> <img class="authorimage" src="<?php echo BASE_PATH . $articlebytitle['profilepic'];?>">
			<?php } else { ?> <i class="fa fa-user authorimage"></i> <?php } ?>
		</div>
		<div class="col-sm-10 authorabout">
			<?php 
			
			if($articlebytitle['usertype'] == 1) $urlusertype = 'user/';
			else if($articlebytitle['usertype'] == 2) $urlusertype = 'professionals/ngo/';
			else if($articlebytitle['usertype'] == 3) $urlusertype = 'professionals/lawyers/';
			else if($articlebytitle['usertype'] == 4) $urlusertype = 'professionals/doctors/';
			else if($articlebytitle['usertype'] == 5) $urlusertype = 'professionals/charteredaccountants/';
			
			if(!empty($articlebytitle['username'])){ ?>
					<span><a href="<?php echo BASE_PATH . $urlusertype . $articlebytitle['username'];?>"><?php echo $articlebytitle['username']; ?></a></span><br>
				<?php } else { ?>
				<span><?php echo $details->name; ?></span><br>
				<?php } ?>
			<p> <?php if($details->about) echo $details->about;
						else if($articlebytitle['about']) echo $articlebytitle['about'];
						else echo "Mysterious user... click on the link above, to find out more details!"; ?></p>
			
		</div>

	</div>

	<div class="row carousel slide" id="getSimilarArticles" data-tags = '<?php echo json_encode($details->tags); ?>' data-articleid = '<?php echo $articlebytitle["articleid"];?>'>
		<div class="carousel-inner"></div>
		 <a class="left carousel-control" href="#getSimilarArticles" data-slide="prev">‹</a>
			<i class="loadericon fa fa-spinner fa-spin fa-2x"></i>

        <a class="right carousel-control" id="moresimilar" href="#getSimilarArticles" data-slide="next">›</a>
	</div>

	<div class="row articlecomments" rel="nofollow">
		<?php 
			if(loggedin() === true) 
			{ 
				?>
				<div id="comments-container" class="loggedin" data-articleid = "<?php echo $articlebytitle['articleid']; ?>" data-profilepic = "<?php if($_SESSION['profilepic']) echo BASE_PATH . $_SESSION['profilepic']; ?>"></div>
				<?php
			}
			else
			{
		?>
				<div id="comments-container" data-articleid = "<?php echo $articlebytitle['articleid']; ?>"></div>
		<?php 
			}
		?>
		<button type="button" class="btn btn-default col-xs-12" id="loadmorearticlecomments">Load more comments</button>
		<p class='enddiv'>End of comments</p>

<?php } ?>
	</div>
</div>
