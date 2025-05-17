<div id="appointModal" class="modal fade" >				  
	<div class="modal-dialog" >
		<div class="modal-content">
		<p class ="loader"> <i class= "fa fa-spinner fa-pulse fa-3x"></i></p>
			<form id="appointForm" action="#" method="post" data-country = "<?php echo trim($professionalDetails['country']);  ?>" >
				<input type="hidden" name="professionalname" value="<?php echo $professionalDetails['name']; ?>">

				<h3>Pick a date</h3>
					<div>

						<div class="form-group">
							<div  class='input-group date' id='datetimepicker'  data-starttime = "<?php echo date('H:ma', strtotime($day[0])); ?>" data-endtime = "<?php echo date('H:ma', strtotime($day[1])); ?>" data-breakstarttime = "<?php echo date('H:ma', strtotime($break[0])); ?>" data-breakendtime = "<?php echo date('H:ma', strtotime($break[1])); ?>" data-professionalid = "<?php echo $professionalDetails['id'];?>"  > 
									<input type='text' id="dtpi" name="datetimepicker" class="form-control" required/> 
							</div>	
							<div></div>
						</div>

						<?php if($professionalDetails['weeklyappointment'] == true) { ?>
						<div class="form-group">
							<div class="input-group">
								<label>
									<input type="checkbox" value="weeklyAppointment" name="weeklyAppointment" id = "weeklyAppointment">
									Opt for weekly appointment.
								</label>
							</div>
							<div></div>
						</div>
						<div class="form-group">
							<div class="input-group date form-inline" id="tillDate" >
									<label>Till (choose a date greater than the last date you want)</label>
									<input type="datetime" name="tillDate"  class="form-control" id="tilldateinput" required>	
							</div>
							<div></div>
						</div>
						<?php } ?> 
					</div>

				<h3>Details</h3>
					<div>
						<div class="form-group">
							<div class="input-group ">
							    <span class="input-group-addon"><i class="fa fa-user"></i></span>
							    <input  type="text" class="form-control" name="fullname" placeholder="Jane Doe" value= "<?php if(loggedin()) echo $_SESSION['username']; ?>"  id="fullname" required >
						    </div>
							<div></div>

						</div>

						<div class="form-group">
							<div class="input-group">
							    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
							    <input  type="text" id="contactNumber" class="form-control" name="contactNumber" placeholder="xxxxxxxxxx"  required>
						    </div>
						    <div></div>
						</div>

						<div class="form-group">
							<div class="input-group">
							    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							    <input  type="email" id="contactemail" class="form-control" name="contactEmail" placeholder="janedoe@xxx.com"  required>
						    </div>
						    <div></div>
						</div>
						<p class="smalltext">This information is needed in order to autheticate a genuine appointment request and given only to the professional you have booked an appointment with. We would not use any of information without your permission.</p>

					</div>
					<input type="hidden" name="professionalid" value="<?php echo $professionalDetails['id']; ?>">

				<!-- <h3>Payment option</h3>
					<div></div> -->
					<p id="appointmentError" ></p>

			</form>
		</div>
	</div>
</div>
