<?php

class TermsandconditionsController extends Controller
{
	function __construct($controller, $action)
	{
		$this->nomodel = 1;
		parent::__construct($controller, $action);

	}


	public function index(){
		$this->set('metaTitle', 'Terms and conditions');

	}
}