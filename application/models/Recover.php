<?php

/**
* 
*/
class Recover extends Model
{
	
	function recoverpassword($email)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$email = htmlspecialchars(strip_tags($email));
		$generatedPassword = substr(md5(rand(999, 999999)), 0, 8);
		$password = password_hash($generatedPassword, PASSWORD_BCRYPT);

		$query = "UPDATE  " . DB_SCHEMA . ".userall SET password = :password WHERE lower(email) = lower(:email) RETURNING username;";
		$this->_bind = array(':email' => $email, ':password' => $password);
		$result = $this->custom($query);

		if(isset($result) && !empty($result))
		{
			$send = new sendEmail();
			$send->email($email, 'Password Recovery for your account on '.WEBNAME.' ', 
					 "<p>Hello ".$result['username'].",</p>
							<p></p>
							<p>Your account details and new randomly generated password is:.</p>
							<div style='margin: 5%; padding: 2%; background:whitesmoke; border-radius:2%;'>
								<p><b width = '20%'>Username: </b>" . $result['username'] ."</p>
								<p><b width = '20%'>Email: </b>" . $email."</p>
							    <p><b width = '20%'>Password: </b>".$generatedPassword."</p></div>
							   <p>You can nw log in with the details above, and change your password in settings.</p>
							    <p></p> <p>--".WEBNAME."</p>");
			return 1;
		}
		else return 0;
	}
}