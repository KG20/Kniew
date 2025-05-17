<div id="messagesModal" class="modal fade" >
	<div class="modal-dialog" >
		<div class="modal-content">
		<!-- <p class ="loader"> <i class= "fa fa-spinner fa-pulse fa-3x"></i></p> -->
			<form id="sendmessageForm" action="#" method="post"  data-loggedin="<?php echo loggedin(); ?>">

				<?php
					$recipientid;
					$recipientemail;
					$recipientusername;
					if(isset($professionalDetails['id'])) $recipientid = $professionalDetails['id']; else if(isset($userid)) $recipientid = $userid;
					if(isset($professionalDetails['email'])) $recipientemail = $professionalDetails['email']; else if(isset($useremail)) $recipientemail = $useremail;
					if(isset($professionalDetails['username'])) $recipientusername = $professionalDetails['username']; else if(isset($username)) $recipientusername = $username;
					$encryptkey = 'emailFromMsgModal_' . $recipientid;
					$encryptemail =	Crypto::encrypt($recipientemail, $encryptkey , true);
				?>
				<input type="hidden" name="professionalid" value="<?php echo $recipientid; ?>"/>
				<input type="hidden" name="professionalemail" value="<?php echo $encryptemail; ?>"/>
				<input type="hidden" name="professionalusername" value="<?php echo $recipientusername; ?>"/>

				<h3 class="modal-header">Ask <?php if(isset($professionalDetails['name'])) echo $professionalDetails['name']; else if(isset($username)) echo strip_tags($username);?></h3>

					<div class="modal-body">
						<div class="form-group row">
							<div class="input-group col-xs-12">
                <label class="boldtext" for="messageSubject">Please give details about your issue.</label>
								<input id="messageSubject" type="text"  name="messageSubject" class="form-control" required placeholder="The heading of your issue.."/>
							</div>

							<div class="input-group col-xs-12">
                <label class="boldtext" for="messageDetails">Please give details about your issue.</label>
								<textarea id="messageDetails" rows="6"  name="messageDetails" class="form-control" required placeholder="<?php
									if(isset($usertype))
									{
										if($usertype == 3) echo "Please tell a little about yourself or your profession. Describe in specific detail the nature of your issue and the type of legal counsel you are looking for..";
										elseif($usertype == 4) echo "Please tell a little about yourself (like your age and gender might be relevant). List symptoms and issues faced by you.";
										elseif($usertype == 5) echo "Describe your profession/business. If you are looking advice on a particular matter, please give details about the said matter.";
									}
									else echo "Please describe in details your problem";
									?>">
								</textarea>
							</div>

							<input type="submit" id="sendmessagebtn" name="sendmessagebtn" value="Ask for timeline and quote. Send Message!" class="btn btn-success col-xs-12 margintop2per"/>

						</div>
							<div></div>
						</div>
			</form>
		</div>
	</div>
</div>
