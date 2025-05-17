<?php
use PHPMailer\PHPMailer\PHPMailer;
/**
*
*/
class sendEmail
{
	protected $m;

	function __construct()
	{
		// require_once(ROOT .'/vendor/phpmailer/phpmailer/PHPMailerAutoload.php');

		// $this->to = $to;
		// $this->subject = $subject;
		// $this->body = $body;
		$this->m = new PHPMailer();

	}

	public function email($to, $subject, $body, $from = CONTACT_EMAIL)
	{
		//mail($to, $subject, $body, 'From: ');

		$this->m->isSMTP();
		$this->m->SMTPAuth = true;
		//$this->m->SMTPDebug = 1;

		$this->m->Host = 'sg1-ss2.a2hosting.com';
		$this->m->Username = 'contact@kniew.com';
		$this->m->Password = 'Smile1407!';
		$this->m->SMTPSecure = 'ssl';
		$this->m->Port = 465;

		$this->m->From = $from;
		$this->m->FromName = WEBNAME;
		// $this->m->addReplyTo('reply@name.com','Reply address');
		// $this->m->addAddress();
		// $this->m->addCC();
		$this->m -> addBCC($to);

		//$this->m->addAttachment('images/logo.jpg', 'name');//delays

		$this->m->isHTML(true);
		$this->m->AddEmbeddedImage(BASE_PATH .'favicon.png', 'logo', 'Kniew Logo');

		$this->m->Subject = $subject;
		$this->m->Body = '<html><body style="min-height:50vh"><table width="100%"><tr height="20%" style="background:#94e7fb; text-align:center" align="center"><a style="color:black; text-decoration:none;" href="'.BASE_PATH.'"> <img  src="cid:logo" style="display:inline-block;"><h1 style="display:inline-block;">KNIEW</h1></tr><tr height="80%" style="min-height:80%; text-align: justify; " align="justify"><td style="padding:5%">' . $body . '</td></tr><tr height="20%" style="height:20%; background:#94e7fb; width:100%; position:absolute; bottom:0; padding:2%;"><p style="text-align:center;" align="center">@' .date('Y') . ' ' . WEBNAME. '</p></tr></table></body></html>';
		$this->m->AltBody = 'Please use  a different browser to view to this email or visit '.WEBNAME.'.com';

		if(!$this->m->send())
		{
			return false;
		}
		else return true;

	}

	public function userSendEmail($from, $subject, $body, $attachment = NULL)
	{
		$this->m->isSMTP();
		$this->m->SMTPAuth = true;

		$this->m->Host = 'smtp.gmail.com';
		$this->m->Username = 'kruti.goyal20@gmail.com';
		$this->m->Password = 'rmtzaxdparvgwkfc';
		$this->m->SMTPSecure = 'ssl';
		$this->m->Port = 465;

		$this->m->From = $from;
		$this->m->FromName = WEBNAME;
		// $this->m->addReplyTo('reply@name.com','Reply address');
		// $this->m->addAddress();
		// $this->m->addCC();
		$this->m -> addBCC('kruti.goyal20@gmail.com');

		if(isset($attachment) && !empty($attachment) && $attachment['error'] == UPLOAD_ERR_OK)
		{
		    $this->m->AddAttachment($attachment['tmp_name'],
                         $attachment['name']);
		}

		$this->m->isHTML(true);

		$this->m->Subject = $subject;
		$this->m->Body = $body;
		$this->m->AltBody = 'Please use  a different browser to view to this email or visit '.WEBNAME.'.com';
		if($this->m->send())
		{
			return 1;
		}
		else return 0;
	}
}
?>
