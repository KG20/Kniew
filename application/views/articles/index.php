
<div class="container-fluid card-row crossbackground">

	<div class="container">
		<div class="row-fluid">
			<form name="searcharticle" method="POST" id="searcharticle" action="" autocomplete="off">
              <div class="input-group">
                  <input type="text" name="searcharticleinput" id="searcharticleinput" class="form-control" placeholder="Search for tags or articles" value = "<?php echo ((isset($_POST['searcharticleinput'])) ? htmlentities($_POST['searcharticleinput']) : ''); ?>" />
                  <span class="input-group-btn">
                    <button type="submit" id="searcharticlesubmit" class="btn btn-search">
						<i class="fa fa-search"></i>
					</button>
				  </span>

                </div>
          </form>
          <div id="tagsearchresult"></div>
          <div class="keytolabel">
	          Key: <span class="label label-success">Social issues</span> <span class="label label-primary">Law</span> <span class="label label-danger">Medicine</span> <span class="label label-warning">Chartered Accountancy</span> <span class="label label-default">General topics</span>
          </div>
		</div>
		<div id ="recentPageViews" class="container"></div>

         <div class="row-fluid tagsget">
         <?php
         if(isset($_GET['tags'])) {
	        foreach ($_GET['tags'] as $tagfull)
		   {

		   	$tag = array_map('trim', explode(',', $tagfull));
		   	$tag[0] = $tag[0] ? $tag[0] : $tagfull;
		   	$tag[0] = str_replace('_', '&', $tag[0]);
		   	$tag[0] = ucwords($tag[0]);
		   	$tagurl = $tagremove = str_replace('&', '_', $tagfull);

	   		if($tag[1] == 2) $tagclass = 'label-success';
		   	elseif($tag[1] == 3) $tagclass = 'label-primary';
		   	elseif($tag[1] == 4) $tagclass = 'label-danger';
		   	elseif($tag[1] == 5) $tagclass = 'label-warning';
		   	else $tagclass = 'label-default';

		   	if($_GET['tags'])
	   		{

	   			if(array_search($tagurl, $_GET['tags']))
				{
					$get =[];
	   				foreach ($_GET['tags'] as $key => $value) {
	   					$get[$key] = urlencode(urlencode($value));
	   				}
					$tagurl =  '&tags[]=' . implode('&tags[]=', $get);
					// else $tagurl = '$tags[]=' . $get;
				}
		   		else
	   			{
	   				$get =[];
	   				foreach ($_GET['tags'] as $key => $value) {
	   					$get[$key] = urlencode(urlencode($value));
	   				}
	   				// print_r($get);
	   				$tagurl = '&tags[]=' . implode('&tags[]=', $get) . '&tags[]=' . urlencode(urlencode($tagurl));
	   				// else  $tagurl = '&tags[]=' . $get . '&tags[]=' . urlencode(urlencode($tagurl));
	   			}
	   		}
		   	else $tagurl = '&tags[]=' . urlencode(urlencode($tagurl));
		   	$tagsremove= '&tags[]=' . urlencode(urlencode($tagremove));
	   		$tagremove = str_replace($tagsremove, '', $tagurl);

			echo '<span class="label '.$tagclass.'" role ="button">
					 <a href="'.BASE_PATH . 'articles'. $tagurl .'" role="button">'. $tag[0] .'</a>
					<a href="'.BASE_PATH . 'articles'. $tagremove .'" role="button"><i class="remove fa fa-close"></i></a>
					 </span>';
		   }
		}
         ?>

         </div>

		<div class="row-fluid" id="lazyaddarticle">
<?php
echo '<div class ="pageloaded">';
foreach ($article as $field => $value) {

	$details = json_decode($value['articledetails']);
	$details->title = ucfirst(html_entity_decode($details->title));
	$details->story = strip_tags(html_entity_decode($details->story));//striping tags because in cards/thumnails dont want to show different paras
	$title = urlencode(urlencode(str_replace(' ', '_', $details->title)));


//first 10 normal loading
	  echo '<div><div class="col-sm-6 col-md-4  col-xl-2">

	    <div class="thumbnail">
	    <a href="'.BASE_PATH.'articles/title/'.$value['articleid'].'/'.$title.'"><span class="thumbnaillink">'.$details->title.'</span></a>';

	    if($details->filepath) {
		  echo '<img src="' . BASE_PATH .$details->filepath .'" />';
		  }
		  else
			echo' <div class=" imagecontainer"><i class="fa fa-pencil imagetext"></i></div>';
			echo '<i class="bottomoverlay xsmalltext label label-success">' . $value['likes'] .'</i>';


	      echo '<div class="caption">
	        <h3>' . $details->title . '
	        </h3>
	        <p class="card-description">'.$details->story.'</p>
	        <p class ="tags">';
	  foreach ($details->tags as $tagfull)
	   {

	   	$tag = array_map('trim', explode(',', $tagfull));
	   	$tag[0] = $tag[0] ? $tag[0] : $tagfull;
	   	$tag[0] = ucwords($tag[0]);
	   	$tagurl = str_replace('&', '_', $tagfull);

   		if($tag[1] == 2) $tagclass = 'label-success';
	   	elseif($tag[1] == 3) $tagclass = 'label-primary';
	   	elseif($tag[1] == 4) $tagclass = 'label-danger';
	   	elseif($tag[1] == 5) $tagclass = 'label-warning';
	   	else $tagclass = 'label-default';

	   	if($_GET['tags'])
   		{

   			if(array_search($tagurl, $_GET['tags']))
			{
				$get =[];
   				foreach ($_GET['tags'] as $key => $value) {
   					$get[$key] = urlencode(urlencode($value));
   				}
				$tagurl =  '&tags[]=' . implode('&tags[]=', $get);
				// else $tagurl = '$tags[]=' . $get;
			}
	   		else
   			{
   				$get =[];
   				foreach ($_GET['tags'] as $key => $value) {
   					$get[$key] = urlencode(urlencode($value));
   				}
   				// print_r($get);
   				$tagurl = '&tags[]=' . implode('&tags[]=', $get) . '&tags[]=' . urlencode(urlencode($tagurl));
   				// else  $tagurl = '&tags[]=' . $get . '&tags[]=' . urlencode(urlencode($tagurl));
   			}
   		}
	   	else $tagurl = '&tags[]=' . urlencode(urlencode($tagurl));


		echo ' <a href="'.BASE_PATH . 'articles'. $tagurl .'" class="label '.$tagclass.'" role="button">'. $tag[0] .'</a>';
	   }
	    echo '</p>
	      </div>
	    </div>
	  </div></div>';


  }
	echo '</div><input type="hidden" class="pagenum" value="1" />';

  ?>



		</div>

	</div>
	<span id="loadericon">
		<i class="fa fa-spinner fa-pulse fa-fw fa-5x"></i><span class="sr-only">Loading...</span>
		<p>Good things comes to those, who wait!</i></p>
	</span>
	<div class='endresult col-xs-12'> End of result, try reducing number of tags! Publish your article here, NOW!</div>

</div>
