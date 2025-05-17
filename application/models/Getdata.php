<?php
/**
*
*/
class Getdata extends Model
{
	function __construct()
	{
		$this->_fetch = 'fetchAll';
		$this->_fetchtype = PDO::FETCH_NUM;
		$this->_table = 'userall';
		parent::__construct();

	}

	public function generalUserData($identity, $type)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$wherecondition;
		$getwat;
		if($type == 'email')
		{
			$wherecondition = 'WHERE lower(email) = lower(:email);';
			$getwat = 'username';
			$this->_bind = array(':email' => $identity);
		}
		elseif($type == 'username')
		{
			$wherecondition = 'WHERE lower(username) = lower(:username);';
			$getwat = 'email';
			$this->_bind = array(':username' => $identity);
		}
		$query = 'SELECT id, isauthentic, joiningdate, reference, '.$getwat.', usertype, usercode, access, profilepic as p1, USERDETAILS->>"profilepic" as p2, name as nameprof, USERDETAILS->>"name" as nameuser, linkedaccountid FROM ONLY ' . DB_SCHEMA . '.userall NATURAL FULL JOIN '.DB_SCHEMA.'.professional NATURAL FULL JOIN '.DB_SCHEMA.'.USERNORMAL ' . $wherecondition;
		$row = $this->custom($query);
		return $row;

	}


	public function idFromUsername($username)
	{
		$query = 'SELECT id FROM '.DB_SCHEMA.'.userall WHERE lower(username) = lower(:username)';
		$this->_bind = array(':username' => $username);
		$row = $this->custom($query);
		return $row[0][0];

	}

	// public function generalFromUsername($username)
	// {
	// 	$this->_fetch = fetch;
	// 	$this->_fetchtype = PDO::FETCH_ASSOC;
	// 	$query = 'SELECT id, authuser, joiningdate, reference, usertype, access, usercode, email, profilepic as p1, USERDETAILS->>"profilepic" as p2 name as nameprof, USERDETAILS->>"name" as nameuser FROM ONLY ' . DB_SCHEMA . '.userall NATURAL FULL JOIN '.DB_SCHEMA.'.professional NATURAL FULL JOIN '.DB_SCHEMA.'.USERNORMAL WHERE lower(username) = lower(:username)';
	// 	$this->_bind = array(':username' => $username); //change to union??
	// 	$row = $this->custom($query);
	// 	return $row;
	//
	// }






	public function idFromEmail($email)
	{
		$query = 'SELECT id FROM '.DB_SCHEMA.'.userall WHERE lower(email) = lower(:email)';
		$this->_bind = array(':email' => $email);
		$row = $this->custom($query);
		return $row[0][0];

	}

	// public function generalFromEmail($email)
	// {
	// 	$this->_fetch = fetch;
	// 	$this->_fetchtype = PDO::FETCH_ASSOC;
	// 	$query = 'SELECT id, authuser, joiningdate, reference, username, usertype, usercode, access, profilepic as p1, USERDETAILS->>"profilepic" as p2, name as nameprof, USERDETAILS->>"name" as nameuser FROM ONLY ' . DB_SCHEMA . '.userall NATURAL FULL JOIN '.DB_SCHEMA.'.professional NATURAL FULL JOIN '.DB_SCHEMA.'.USERNORMAL WHERE lower(email) = lower(:email);';
	// 	$this->_bind = array(':email' => $email);
	// 	$row = $this->custom($query);
	// 	return $row;
	//
	// }

	public function usertypeFromID($id)
	{
		$query = 'SELECT usertype FROM '.DB_SCHEMA.'.userall WHERE id = :id';
		$this->_bind = array(':id' => $id);
		$row = $this->custom($query);
		return $row[0][0];
	}

	public function isIdOfProfessional($id)
	{
		$query = 'SELECT count(*) FROM '.DB_SCHEMA.'.professional WHERE id = :id';
		$this->_bind = array(':id' => $id);
		$row = $this->custom($query);
		return $row[0][0];
	}

	public function usernameFromID($id)
	{
		$query = 'SELECT username FROM '.DB_SCHEMA.'.userall WHERE id = :id';
		$row = $this->custom($query);
		return $row[0][0];
	}

	public function verifyProfessional($id)
	{
		$this->_fetch = fetch;
		$query = 'SELECT emailverified FROM '.DB_SCHEMA.'.professional WHERE id =:id';
		$this->_bind = array(':id' => $id);
		$result = $this->custom($query);
		$result = $result[0];
		return $result;

	}

	public function passwordCorrect($username, $password)
	{
		$query = 'SELECT password FROM '.DB_SCHEMA.'.userall WHERE lower(username) = lower(:username) OR lower(email) = lower(:username)';
		$this->_bind = array(':username' => $username);
		$passwordHash = $this->custom($query);
		if(password_verify($password, $passwordHash[0][0]))
		{

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	// public function getParentFocusByType($type)
	// {
	// 	$this->_fetchtype = PDO::FETCH_ASSOC;
	// 	$query = 'SELECT focusid, focus FROM ' . DB_SCHEMA . '.focus WHERE type = :type AND parentid IS NULL';
	// 	$this->_bind = array(':type' => $type);
	// 	$result = $this->custom($query);
	// 	return $result;
	// }

	// public function getChildrenFocusByType($type)
	// {
	// 	$this->_fetchtype = PDO::FETCH_ASSOC;
	// 	$query = 'SELECT focusid, focus, parentid FROM ' . DB_SCHEMA . '.focus WHERE type = :type AND parentid IS NOT NULL';
	// 	$this->_bind = array(':type' => $type);
	// 	$result = $this->custom($query);
	// 	return $result;
	// }

	//ABOVE TWO FUNCTIONS HAVE TO BE REPLACED BY THIS, SEE PROFESSIONALS FOR DETAILS;
// 	SELECT parent.focusid, child.focusid, parent.focus
//      , child.focus As subgroup
// FROM   website.focus As parent
//  LEFT
//   JOIN website.focus As child
//     ON child.parentid = parent.focusid


	public function emailExist($email)
	{
		$email = htmlspecialchars(strip_tags($email));
		$query = 'SELECT count(*) FROM '.DB_SCHEMA.'.userall WHERE lower(email) = lower(:email)';
		$this->_bind = array(':email' => $email);
		$row = $this->custom($query);
		return $row[0][0];

	}

	public function usernameExist($username)
	{
		$query = 'SELECT count(*) FROM '.DB_SCHEMA.'.userall WHERE lower(username) = lower(:username)';
		$this->_bind = array(':username' => $username);
		$row = $this->custom($query);
		return $row[0][0];
	}

	public function verificationidForRoleExist($verificationid, $custrole)
	{
		$query = 'SELECT count(*) FROM '.DB_SCHEMA.'.professional WHERE lower(verificationid) = lower(:verificationid) and usertype = :usertype';
		$this->_bind = array(':verificationid' => $verificationid, ':usertype'=>$custrole);
		$row = $this->custom($query);
		return $row[0][0];
	}

	public function titleExist($title) //isalso being used in article
	{
		$query = 'SELECT count(*) FROM '.DB_SCHEMA.'.article WHERE  lower(articledetails->>\'title\') = lower(:title)';
		$this->_bind = array(':title' => $title);
		$row = $this->custom($query);
		return $row[0][0];
	}

	public function getAllTags()
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = 'SELECT focusid, focus, type FROM ' . DB_SCHEMA  . '.focus ORDER BY type, focus ASC ';
		$result = $this->custom($query);
		return $result;

	}

	public function workByType($type)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = 'SELECT id, name, formattedaddress FROM ' . DB_SCHEMA  . '.professional WHERE usertype = :type AND workat = \'0\' ';
		$this->_bind[':type'] = (int)$type;
		$result = $this->custom($query);
		return $result;
	}

	public function searchRecommend($username)
	{
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$addquery = '';
		if(loggedin() == true) $addquery = ' AND id <> '. $_SESSION['id'];
		$query = "SELECT id, username, name, formattedaddress FROM " . DB_SCHEMA . ".professional WHERE lower(username) LIKE lower(:x) OR lower(name) LIKE lower(:x)  ".$addquery." LIMIT 10;";
		$this->_bind = array(':x' => '%' . $username . '%' );
		$row = $this->custom($query);
		return $row;
	}








}
