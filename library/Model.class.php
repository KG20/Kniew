<?php
class Model extends SQLQuery {
	protected $_model;

	function __construct() {

		$this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$this->_limit = PAGINATE_LIMIT;
		$this->_model = get_class($this);
		if(!isset($this->_table))
		{
			$this->_table = strtolower($this->_model);
		}
		if (!isset($this->abstract)) {
			$this->_describe();
		}
	}

	function __destruct() {
	}
}
