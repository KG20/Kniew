<?php
	error_reporting(E_ALL);
	/**
	* Controller class for default home page
	*/
	class ComingsoonController extends Controller
	{
		function __construct($controller, $action)
		{
			nopage();
			$this->nomodel = 1;
			parent::__construct($controller, 'index');
		}

		public function index()
		{
			$this->doNotRenderFooter = 1;
			$this->doNotRenderHeader = 1;
			$this->set('metaTitle', 'Find Chartered Accountant, Lawyer, Doctor, NGO | ' . WEBNAME);
			$this->set('metaDescription', 'Find information, appointment and reviews of top lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs near you. Reach clients for your practice.');
			$this->set('isprofession', 0);
		}

		public function profession()
		{
			$this->doNotRenderFooter = 1;
			$this->doNotRenderHeader = 1;
			$this->set('metaTitle', 'Reach clients for your Profession - CA, Lawyer, Doctor, NGO | ' . WEBNAME);
			$this->set('metaDescription', 'User reachability and connection platform for lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs. Let users find you easily.');
			$this->set('isprofession', 1);
			$urlarray = explode('/', $_GET['url']);
			$cookie_name = "kniew_reference";
			$cookie_value = $urlarray[3];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

		}

		public function reference()
		{
			$this->doNotRenderFooter = 1;
			$this->doNotRenderHeader = 1;
			$this->set('metaTitle', 'Find Chartered Accountant, Lawyer, Doctor, NGO | ' . WEBNAME);
			$this->set('metaDescription', 'Find information, appointment and reviews of top lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs near you. Reach clients for your practice.');
			$this->set('isprofession', 0);
			$urlarray = explode('/', $_GET['url']);
			$cookie_name = "kniew_reference";
			$cookie_value = $urlarray[2];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
		}


	}
