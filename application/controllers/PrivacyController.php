<?php

class PrivacyController extends Controller
{
	function __construct($controller, $action)
	{
		$this->nomodel = 1;
		parent::__construct($controller, $action);

	}


	public function index()
	{
		$this->set('metaTitle', 'Privacy Policy');

	}
}