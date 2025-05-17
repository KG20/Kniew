<?php
/**
*
*/
class Setdata extends Model
{
	function __construct()
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_NUM;
		$this->_table = 'userall';
		parent::__construct();

	}

	public function registerUser($registerData)
	{
		$registerData[':password'] = password_hash($registerData[':password'], PASSWORD_BCRYPT);
		$query = 'INSERT INTO '.DB_SCHEMA.'.usernormal (username, password, email, usercode) VALUES (:username, :password, :email, :usercode) RETURNING id';
		$this->_bind = $registerData;
		$result = $this->custom($query);
		$id = $result[0][0];
		if($id)
		{
		   	addToSitemap(BASE_PATH . 'user/' . $registerData[':username']);

			$send = new sendEmail();
			$send->email($registerData[':email'], 'Activate your account', "<p>Hello".$registerData[':username'].",</p><p></p><p>Please confirm your email address:</p><p>" . BASE_PATH . "activateaccount/activate&email=" . $registerData[':email'] . "&userCode=".$registerData[':usercode']."</p><p></p><p>--".WEBNAME."</p>");
			$_SESSION['id'] = $id;
			$_SESSION['username'] =$registerData[':username'];
			$_SESSION['email'] =$registerData[':email'];
			$_SESSION['code'] =$registerData[':usercode'];
			$this->updatereference();

			return $_SESSION;
		}

	}

	public function registerProfessional($registerData, $fileTemp)
	{
		$registerData[':password'] = password_hash($registerData[':password'], PASSWORD_BCRYPT);
		if(!empty($registerData[':since'])) $registerData[':since'] = date('Y-m-d', strtotime(str_replace('/', '-', $registerData[':since'])));
		if($fileTemp)
		{
			$registerData[':profilepic'] = 'images'. DS. 'profile' . DS . substr(md5(time()),0, 10) . '.png';
		}


		$keys = implode(", ", array_keys($registerData));
		// $keysappoint = implode(", ", array_keys($appointmentData));

		$fields = str_replace(':', '', array_keys($registerData));
		$fields = str_replace('regspecialisationother,', '', $fields);
		$replacethese = array('custregrole', 'regspecialisation');
		$replacewith = array('usertype', 'mainfocus');
		$fields = str_replace($replacethese, $replacewith, $fields);
		$fields = str_replace('mainfocusother', 'otherfocus', $fields);
		$fields = implode(", ", $fields);

		// $fieldsappoint = str_replace(':', '', array_keys($appointmentData));
		// $replacetheseappoint = array('fee', 'duration');
		// $replacewithappoint = array('cost', 'sessionduration');
		// $fieldsappoint = str_replace($replacetheseappoint, $replacewithappoint, $fieldsappoint);
		// $fieldsappoint = implode(", ", $fieldsappoint);

		// $query = 'WITH new_professional AS
		// 			(INSERT INTO '.DB_SCHEMA.'.professional ('.$fields.') VALUES (' . $keys .') RETURNING id)
		// 			INSERT INTO '.DB_SCHEMA.'.appointmentsetting ('.$fieldsappoint.', professionalid) VALUES ('.$keysappoint.' , (select id from new_professional)) RETURNING professionalid';
		// $this->_bind = array_merge($registerData, $appointmentData);
		$query = 'INSERT INTO '.DB_SCHEMA.'.professional ('.$fields.') VALUES (' . $keys .') RETURNING id;';
		$this->_bind = $registerData;
		$result = $this->custom($query);
		// echo pg_result_error($result);
		$id = $result[0][0];

		if($id)
		{
			$_SESSION['id'] = $id;
			$_SESSION['username'] =$registerData[':username'];
			$_SESSION['email'] =$registerData[':email'];
			$_SESSION['usertype'] = $registerData[':custregrole'];
			$_SESSION['code'] =$registerData[':usercode'];
			$_SESSION['name'] = $registerData[':name'];

			$_SESSION['profilepic'] = $registerData[':profilepic'];
			$_SESSION['isauthentic'] = NULL;

			if($registerData[':custregrole'] == 2) $urlusertype = 'professionals/ngo/';
			else if($registerData[':custregrole'] == 3) $urlusertype = 'professionals/lawyers/';
			else if($registerData[':custregrole'] == 4) $urlusertype = 'professionals/doctors/';
			else if($registerData[':custregrole'] == 5) $urlusertype = 'professionals/charteredaccountants/';

			addToSitemap(BASE_PATH . $urlusertype . $registerData[':username']);



			$this->updatereference();


			if($fileTemp)
			{
				file_put_contents($registerData[':profilepic'], $fileTemp);
			}

			$send =new sendEmail();
			$send->email($registerData[':email'], 'Activate your account', "<p>Hello ".$registerData[':name'].",</p><p></p><p>Please confirm your email address:</p><p>" . BASE_PATH . "activateaccount/activate&email=" . $registerData[':email'] . "&userCode=".$registerData[':usercode']."</p><p></p><p>--".WEBNAME."</p>");

			return $_SESSION;
		}

	}

	public function activateUser($email, $userCode)
	{
		$this->_fetch = fetch;
		$query = 'UPDATE '.DB_SCHEMA.'.userall SET emailverified = true WHERE (email = :email AND usercode = :usercode) RETURNING emailverified';
		$this->_bind = array(':email' => $email, ':usercode' => $userCode);
		$result = $this->custom($query);

		return $result[0];
	}


	public function updatereference()
	{
		if(isset($_COOKIE['kniew_reference']))
		{
			$query_ref ="UPDATE " . DB_SCHEMA . ".userall set reference = reference + 1 where usercode = :usercode";
			$this->_bind = array(':usercode' => $_COOKIE['kniew_reference']);
			$result_ref = $this->custom($query_ref);
			return $result_ref;

		}
	}





}
