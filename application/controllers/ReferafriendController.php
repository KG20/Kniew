<?php
// error_reporting(0);


class ReferafriendController extends Controller
{

	function __construct($controller, $action)
	{
		// $this->nomodel = 1;
		parent::__construct($controller, $action);

	}


	public function index()
	{
		$this->doNotRenderHeader = 1;
		$this->doNotRenderFooter = 1;
		$this->set('metaTitle', 'Refer a Friend | Kniew');
		$this->set('metaDescription', 'Refer a friend and get upto 1 year of free subscription. Reach clients for your law practice, medical practice, NGOs and chartered accountancy.');
		if(loggedin())
		{
			$ref = $this->Referafriend->getreferences();
			$this->set('references', $ref);
		}


	}
}
