<?php

/**
* 
*/
class UserController extends Controller
{
	protected $username;
	function __construct($controller, $action)
	{
		if($action == 'index')
		{
			$this->render = 0;
			header('Location: ' . BASE_PATH . 'notice/pagedoesnotexists');
		}
		else
		{

			$this->username = htmlspecialchars(strip_tags(trim($action)));

			$action = 'basictemplate';



			parent::__construct($controller, $action);
			$this->basictemplate();


		}
	}
	
	public function index(){}


	public function basictemplate()
	{

		if(isset($this->username))
		{
			$this->set('username', $this->username);
			$Details = $this->User->userFromUsername($this->username);

			if(!empty($Details))
			{
				$this->set('details', $Details);
				$this->set('metaTitle', json_decode($Details['userdetails'])->name . ' | Kniew');
				$this->set('metaDescription', substr(strip_tags(json_decode($Details['userdetails'])->about), 0, 150));
			}
			else
			{
				$this->render = 0;
				header('Location: ' . BASE_PATH . 'notice/error/404');


			}
		}
	}
}