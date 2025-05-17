<?php

	class NoticeController extends Controller
	{
		function __construct($controller, $action)
		{
			$this->nomodel = 1;
			parent::__construct($controller, $action);

		}

		public function membersonly()
		{
			$this->set('metaTitle', 'This page is restricted to registered users | ' . WEBNAME);
		}

		public function pagedoesnotexists(){
			$this->set('metaTitle', 'The page does not exists!');

		}

		public function error()
		{
			$this->set('metaTitle', 'Error! Please try again | ' . WEBNAME);
			$this->doNotRenderFooter = 1;
			$this->doNotRenderHeader = 1;
		}

		public function thankyou()
		{
			$this->set('metaTitle', 'Thank you for registering with us | ' . WEBNAME );
			$this->set('metaDescription', 'Find information, appointment and reviews of top lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs near you.');
			$redirect_array  = explode('/', $_GET['url']);
			$this->set('redirect', $redirect_array[2]);
			$this->set('type', $redirect_array[3]);
			

		}

		
	}