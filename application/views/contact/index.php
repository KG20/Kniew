<div class="container-fluid whitesmokeBack">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-xs-12 col-sm-8">
			<form class="form margin2per" method="post" id="contactform" enctype="multipart/form-data">
				<h1>Contact Us</h1>
				<div class="form-group">
			 		<label>Regarding</label>
			 		<select id="contact_subject" name="subject" class="form-control">
			     		<option></option>
				 		<option value="article" selected>Submit an Article</option>
			 			<option value="report">Report a page (such as another user, professional, article or spam)</option>
			 			<option value="technical">Technical glich or issue with the site</option>
			 			<option value="feedback">Please provide your valuable feedback.</option>


			 		</select>
				</div>

				<div id="articlesubmission" class="whiteBack padding2per margin2per roundcorners5per">
					<!-- <?php //if(loggedin() == true) { ?> -->
					<div class="form-group">
						<label>Title*</label>
						<input type="text" name="title"  class="form-control" placeholder="Title of the article" required />
					</div>
					<div class="form-group">
						<label>Body*</label>
						<textarea class="form-control" name="emailbody" rows="20" required placeholder="Email body.  You can also add your article here."></textarea>
					</div>
					<div class="form-group">
						<label>Attach article</label>
						<input name="attachment" type="file" accept=".txt, .doc, .docx, .odt, .rtf, .wks, .wps, .wpd, .text" />
					</div>
					<div class="form-group">
						<label>Author's username/Name*</label>
						<input type="text" name="author"  class="form-control" placeholder="Username" value="<?php if(loggedin() == true) echo $_SESSION['username']; ?>" />
					</div>
					<div class="form-group">
						<label>About you (Only if you are not a member)</label>
						<textarea class="form-control" name="about" rows="10" placeholder="Tell us a little about yourself. (This information will be displayed with your article)."></textarea>
					</div>
					<div class="form-group">
						<input name="contactsubmit" type="submit" class="btn-lg btn-success pull-right" value="Send!" />
					</div>
					<!-- <?php //}else { ?>
					<div class="margin10per greytext">
						Please log in to submit an article.
					</div>
					<?php// } ?> -->

				</div>

				<div id="report" class="whiteBack padding2per margin2per roundcorners5per">
					<div class="form-group">
						<label>Name*</label>
						<input type="text" name="name"  required class="form-control" placeholder="John Doe" <?php if(loggedin() == true) { echo 'value = " ' . $_SESSION['username'] . '"'; } ?> />
					</div>
					<div class="form-group">
						<label>Email address*</label>
						<input type="email" name="email"  required class="form-control" placeholder="jane_doe@xxx.com" <?php if(loggedin() == true) { echo 'value = " ' . $_SESSION['email'] . '"'; } ?> />
					</div>
					<div class="form-group">
						<label>Link to the page*</label>
						<input type="url" name="link" required class="form-control" placeholder="Paste the link to the page you wish to report." />
					</div>
					<div class="form-group">
						<label>Complaint*</label>
						<textarea class="form-control" name="complaint" rows="10" required placeholder="Please explain the nature of your complaint."></textarea>
					</div>		
					<div class="form-group">
						<input name="contactsubmit" type="submit" class="btn-lg btn-success pull-right" value="Send!" />
					</div>			
				</div>

				<div id="feedback" class="whiteBack padding2per margin2per roundcorners5per">
					<div class="form-group">
						<label>Name*</label>
						<input type="text" name="feedbackname"  required class="form-control" placeholder="John Doe" <?php if(loggedin() == true) { echo 'value = " ' . $_SESSION['username'] . '"'; } ?> />
					</div>
					<div class="form-group">
						<label>Email address*</label>
						<input type="email" name="feedbackemail"  required class="form-control" placeholder="jane_doe@xxx.com" <?php if(loggedin() == true) { echo 'value = " ' . $_SESSION['email'] . '"'; } ?> />
					</div>
					
					<div class="form-group">
						<label>Feedback/Suggestion*</label>
						<textarea class="form-control" name="feedback" rows="10" required placeholder="Please give your feedback."></textarea>
					</div>		
					<div class="form-group">
						<input name="contactsubmit" type="submit" class="btn-lg btn-success pull-right" value="Send!" />
					</div>			
				</div>
			</form>
		</div>
		<div class="col-sm-2"></div>

	</div>	
</div>