<div id = 'wrapper' class='marginbottom2per'>
<?php if(defined('CITY')) $autolocation = CITY . ' '; else $autolocation = ' ';
			if(defined('STATE')) $autolocation .= STATE . ' '; else $autolocation = ' ';
			if(defined('COUNTRY')) $autolocation .= COUNTRY; else $autolocation =' '; ?>
	<div id="sidebar-wrapper" class="crossbackground">
		<form id = "filterall" name="filterall" method="POST" autocomplete="off">

		<ul class="sidebar-nav">
			<li > <a href="#" data-toggle="collapse" data-target="#drop1">Category<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
				<ul id="drop1" class="collapse form-group" data-parent="#sideNavParent1">
					<li class="radio"><label><input type="radio" name="category" value="null" checked>All</label></li>
					<li class="radio"><label><input type="radio" name="category" value="5">Chartered Accountants</label></li>
					<li class="radio"><label><input type="radio" name="category" value="3">Lawyers</label></li>
					<li class="radio"><label><input type="radio" name="category" value="4">Doctors</label></li>
					<li class="radio"><label><input type="radio" name="category" value="2">Non-profits</label></li>
					<li class="radio"><label><input type="radio" name="category" value="0">Articles</label></li>
					<li class="radio"><label><input type="radio" name="category" value="1">Users</label></li>
				</ul>
			</li>
			<li class="form-group">
				<div class="input-group">
					<input type="text" name="location" class="form-control" placeholder="Search location...." role="search" value = "<?php echo ((isset($_POST['location'])) ? htmlentities($_POST['location']) : $autolocation); ?>">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default">
							<span class="fa fa-search">	</span>
						</button>
					</span>
				</div>
			</li>

			<li> <a href="#" data-toggle="collapse" data-target="#searchfocus">Filter<i class="fa fa-chevron-right" aria-hidden="true"></i></a>
				<ul id="searchfocus" class="collapse form-group" data-parent="#sideNavParent2">
					<span class="loadericon ellipsis-anim"><span>.</span><span>.</span><span>.</span></span>
				</ul>
			</li>

		</ul>



		</form>
	</div>

	<div id="page-content-wrapper">
		<a href="#" class="btn btn-default" id="menu-toggle"><i class="fa fa-sliders" aria-hidden="true"></i></a>
		<div class="container-fluid">
		    <div class="row">
			     <div class="col-lg-12" id="searchresultcards">
			     	<?php echo $searchcards;?>
			     </div>
			     <button class="btn btn-default col-xs-12 loadmore">Load More</button>

	        </div>

	        <span id="searchloadericon" class="col-lg-12">
				<i class="fa fa-spinner fa-pulse fa-fw fa-5x"></i><span class="sr-only">Loading...</span>
				<p>Good things comes to those, who wait!</p>
			</span>
			<div class="row paddingbottom10per"><div class='endresult col-xs-12'><i class="fa fa-search fa-3x col-xs-2"></i><p class="col-xs-10">End of Results! Please check spelling of the words or reduce search term for a broder search, or reduce the number of filter</p></div></div>

		</div>

	</div>


</div>
