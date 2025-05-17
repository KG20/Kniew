<?php
// error_reporting(0);
class ContactController extends Controller
{
	public function index()
	{
		$this->set('metaTitle', 'Contact | Kniew');
		$this->set('metaDescription', 'Submit article, leave feedback, report issues to Kniew.');
	}

	public function sendemail()
	{
		$this->render = 0;
		if($_POST)
		{
			$type = $_POST['subject'];
			$attachment = null;

			if($type == 'article')
			{
				$username = filter_var((trim($_POST['author'])), FILTER_SANITIZE_STRING);
				$subject = 'Article submission by ' . $username . ': ' .  filter_var($_POST['title'], FILTER_SANITIZE_STRING);
				$body = '<div>
							<p> <h3> Title </h3>'.filter_var($_POST['title'], FILTER_SANITIZE_STRING).'</p>
							<p> <h3> Author\'s Username </h3>'.$username.'</p>
						</div><div></div><div></div><div><h2>Email by user</h2>' . nl2br(htmlspecialchars(stripslashes(trim($_POST['emailbody'])))) . '</div><div><h2>About user</h2>' . nl2br(htmlspecialchars(stripslashes(trim($_POST['about'])))) . '</div>';
				$attachment = $_FILES['attachment'];
				$useremail = filter_var($_SESSION['email'], FILTER_SANITIZE_STRING);
				$confirmsubject = 'Article submission to ' . WEBNAME . ' successful!';
				$confirmbody = '<p>Hello ' . $username .', </p><p></p><p></p>
								<p> Your article has been submitted successfully! </p><p></p>
								<p> Thank you for submitting your article with us. You will hear from us as soon as the screening process has been completed. </p><p></p>
								<p> Thank you for your patients, do continue to keep sending us relevant articles.</p><p></p><p></p>
								<p>Thanks,<br/>' . WEBNAME . '</p>';
			}
			elseif ($type == 'report' || $type == 'technical') 
			{
				if($type == 'report') $subject = 'Report of a page';
				elseif($type == 'technical') $subject = 'Technical issue';

				$useremail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
				$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

				$confirmsubject = 'Complaint received by ' . WEBNAME;
				$confirmbody = '<p> Hello ' . $name .',</p><p></p><p></p>
								<p>Thank you for your feedback! Your comments have been received. We\'ll take your suggestions into consideration with new updates.</p><p></p>
								<p>Thank you for using '. WEBNAME . '!</p>';

				$body = '<div>
							<p> <h3> User\'s name </h3>'. $name.'</p>
							<p> <h3> User\'s email </h3>'.$useremail.'</p>
							<p> <h3> Complaint\'s Page </h3>'.filter_var($_POST['link'], FILTER_SANITIZE_URL).'</p>
						</div><div></div><div></div><div><h2>Complaint</h2>' . nl2br(htmlspecialchars(stripslashes(trim($_POST['complaint'])))) . '</div>';
				
			}
			elseif ($type == 'feedback') 
			{
				$subject = 'Feedback';

				$useremail = filter_var($_POST['feedbackemail'], FILTER_SANITIZE_STRING);
				$name = filter_var($_POST['feedbackname'], FILTER_SANITIZE_STRING);

				$confirmsubject = 'Feedback received by ' . WEBNAME;
				$confirmbody = '<p> Hello ' . $name .',</p><p></p><p></p>
								<p>Thank you for your feedback! Your comments have been received. We\'ll take your suggestions into consideration with new updates. Please keep using '.WEBNAME.' and lookout for your suggestion. </p><p></p>
								<p>Thank you!</p>';

				$body = '<div>
							<p> <h3> User\'s name </h3>'. $name.'</p>
							<p> <h3> User\'s email </h3>'.$useremail.'</p>
						</div><div></div><div></div><div><h2>Feedback</h2>' . nl2br(htmlspecialchars(stripslashes(trim($_POST['feedback'])))) . '</div>';
				
			}

			$contactemail = new sendEmail();
			if($contactemail->userSendEmail($useremail, $subject, $body, $attachment))
			{
				$contactemail->email($useremail, $confirmsubject, $confirmbody);
				echo 1;
			}
			
		    
		}
	}

}
?>