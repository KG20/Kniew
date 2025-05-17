<div class="container-fluid card-row crossbackground">
	<div id ="recentPageViews" class="container"></div>
	<div class="container">

		<div class="container">
			<button type= "button" class="btn btn-default" id="filtertoggle"><i class="fa fa-sliders" aria-hidden="true"></i> Filter</button>
			<form id = "filterProfessionals" name="filterprofessionals" method="POST" action="" autocomplete="off" class="row" data-usertypename = "<?php echo strtolower(str_replace(' ', '', $usertypename)); ?>">
				<ul id="displaytabs" role="tablist">
					<!-- <div class="col-xs-6"> -->
			        <li class="col-xs-6 active" id = "locationtab" >
			        <a  href="#locationProfessionals" data-toggle="tab">Location, Sort &amp; Others</a>
			        </li>
			        <!-- </div> -->
			        <!-- <div class="col-xs-6"> -->
			        <li class="col-xs-6" id= "focustab"  >
			        <a  href="#focusProfessionals" data-toggle="tab">Specialisation</a>
			        </li>
			        <!-- </div> -->
		        </ul>
		        <div id ="tabcontent">
				<div class="col-xs-12 col-md-3 padding2per active" id="locationProfessionals">

					<div class="form-group">
						<label>Name</label>
						<div class="input-group">
							<span class="input-group-addon">
		                      <span class="fa fa-user"></span>
		                    </span>
							<input type="text" name="name" class="form-control" placeholder="Search by name..." />
						</div>
					</div>

					<div class="form-group">
						<label>Location</label>
						<div class="input-group">
							<span class="input-group-addon">
		                      <span class="fa fa-map-marker"></span>
		                    </span>
							<input type="text" name="formattedaddress" id="searchlocation" class="form-control searchlocation" placeholder="Search location..." value = "<?php echo $location; ?>" />
						</div>
						<p id="searchlocationresult"></p>

					</div>

					<div class="form-group">
						<label>Sort by</label>
						<select class="form-control" name="order">
							<!-- <option value="" disabled  ><i class="fa fa-sort" aria-hidden="true"></i>Sort By</option> -->
							<option value="rate" selected>Ratings</option>
							<option value="id">Newest added</option>
							<option value="since">Experience</option>
						</select>
					</div>
					<div class="form-group">
						<label for="isfree" >
						<input type="checkbox" value="true" name="isfree">
						<?php if($usertype == 2) echo '<span class="isfreelabel">Provide consultation</span>';
              elseif($usertype == 3) echo '<span class="isfreelabel">Pro-bono</span>';
              elseif($usertype == 4) echo '<span class="isfreelabel">Free clinic/consultation</span>';
              elseif($usertype ==5) echo '<span class="isfreelabel">Free consultation</span>';
             ?>
						</label>
					</div>
					<div class="form-group">
						<label for="onlinesession" >
						<input type="checkbox" value="true" name="onlinesession">
						Provides online counselling?
						</label>
					</div>
					<div class="form-group" >
						<?php
							if($usertype == 2)
							{
								?>
								<div><p><b>Level of support</b></p>
									<p><input type="checkbox" value="City Wide" name="jurisdiction[]"><label for="jurisdiction[]">City Wide </label></p>
									<p><input type="checkbox" value="State Wide" name="jurisdiction[]"><label for="jurisdiction[]">State Wide </label></p>
									<p><input type="checkbox" value="Country Wide" name="jurisdiction[]"><label for="jurisdiction[]">Country Wide </label></p>
								</div>
								<?php
							}
			                elseif($usertype == 3)
		                	{
		                		?>
		                		<div>
				                	<p><b>Appear in</b></p>
					                <p><input type="checkbox" value="District Court" name="jurisdiction[]"><label for="jurisdiction[]">District Court </label></p>
					                <p><input type="checkbox" value="High Court" name="jurisdiction[]"><label for="jurisdiction[]">High Court </label></p>
					                <p><input type="checkbox" value="Supreme Court" name="jurisdiction[]"><label for="jurisdiction[]">Supreme Court </label></p>
					                <p><input type="checkbox" value="Revenue Board" name="jurisdiction[]"><label for="jurisdiction[]">Revenue Board </label></p>
					                <p><input type="checkbox" value="Tax Board" name="jurisdiction[]"><label for="jurisdiction[]">Tax Board </label></p>
				                </div>
			                <?php
				            }
			                elseif($usertype == 4)
			                	{
			                		?>

			                		<div><p>Provides services at</p>
				                		<p><input type="checkbox" value="Hospital" name="jurisdiction[]"><label for="jurisdiction[]">Hospital </label></p>
				                		<p><input type="checkbox" value="Clinic" name="jurisdiction[]" ><label for="jurisdiction[]">Clinic </label></p>
				                		<p><input type="checkbox" value="Home Visits" name="jurisdiction[]"><label for="jurisdiction[]">Home Visits </label></p>
			                		</div>
			                		<?php
			                	}
			                elseif($usertype ==5)
			                {
	                		?>
		                		<div>
				                	<p><b>Level</b></p>
					                <p><input type="checkbox" value="Local" name="jurisdiction[]"><label for="jurisdiction[]">Local </label></p>
					                <p><input type="checkbox" value="State" name="jurisdiction[]"><label for="jurisdiction[]">State </label></p>
					                <p><input type="checkbox" value="National" name="jurisdiction[]"><label for="jurisdiction[]">National </label></p>
				                </div>
			                <?php
				            }
		                 ?>

					</div>
					<div class="form-group">
						 <div  id="languageFilter">
					        <button type="button" class="btn btn-default  dropdown-toggle form-control" data-toggle="dropdown"><i class="fa fa-language"></i> Languages <i class="fa fa-caret-down"></i></button>
					        <ul role="menu" class="dropdown-menu fullwidth">
					        	<p class="loader"><i class= "fa fa-spinner fa-pulse fa-2x "></i></p>
					        </ul>
				        </div>
					</div>
				</div>

				<div class="col-xs-12 col-md-9 " id="focusProfessionals" data-focustype = "<?php echo $usertype; ?>">
					<div class="row"><p class ="loader"> <i class= "fa fa-spinner fa-pulse fa-2x"></i></p></div>
					<label class="checkbox-inline" id="includesubcontainer">
            <input type="checkbox" name="includesub" value="1"   checked> Include all specialisation.
	        </label>
	        <p></p>
					<?php if($usertype == 3 || $usertype == 4){ ?>
	        <label class="checkbox-inline" id="includeonlyfirmcontainer">
            <input type="checkbox" name="includeonlyfirm" value="1"  > Include organisations only.
	        </label>
				<?php } ?>
				</div>
				</div>
				<div class="col-xs-12">
					<div class="form-group">
						<div class="input-group fullwidth">
							<input type="submit" name="filterprofessionalsSubmit" value="Filter" class="btn btn-info btn-lg fullwidth">
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="row">


			<div id="professionalcards">

			<?php echo $cardData; ?>

			</div>
			<button class="btn btn-default col-xs-12 loadmore">Load More</button>
		</div>
	</div>

	<span id="loadericon">
		<i class="fa fa-spinner fa-pulse fa-fw fa-5x"></i><span class="sr-only">Loading...</span>
		<p>Good things comes to those, who wait!</p>
	</span>
	<div class='endresult col-xs-12'> End of result, try reducing filter or expanding your search to nearby areas!</div>
</div>
