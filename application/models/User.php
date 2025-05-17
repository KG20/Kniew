<?php

/**
*
*/
class User extends Model
{

	function __construct()
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$this->_table = 'usernormal';
		parent::__construct();
	}

	public function userFromUsername($username)
	{

		$query = "SELECT id, email, joiningdate, showcontactdetails, userdetails FROM ".DB_SCHEMA.".usernormal WHERE lower(username) = lower(:username)";
		$this->_bind = array(':username' => $username);
		$result = $this->custom($query);
		return $result;

	}
}
