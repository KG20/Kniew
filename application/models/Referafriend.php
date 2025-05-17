<?php

class Referafriend extends Model
{
	function __construct()
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$this->_table = 'userall';
		parent::__construct();

	}

	public function getreferences()
	{
		$id = $_SESSION['id'];
		$query = 'SELECT reference FROM '.DB_SCHEMA.'.userall WHERE id = :id';
		$this->_bind = array(':id' => $id);
		$row = $this->custom($query);
		return $row['reference'];

	}
}
