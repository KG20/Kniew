<?php

class RecoverController extends Controller
{

	public function index()
	{
		$this->set('metaTitle', 'Recover Password | Kniew');
		if(isset($_GET['success']) === false && isset($_POST['email']) === true && empty($_POST['email']) === false)
		{
			$result = $this->Recover->recoverpassword($_POST['email']);
		
			if($result == 1)
			{
				header('Location: ' . BASE_PATH . 'recover&success');
			}
			else
			{
				header('Location: ' . BASE_PATH . 'recover&error');
			}

		}
	}
}