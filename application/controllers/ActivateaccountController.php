<?php

class ActivateaccountController extends Controller
{
	function __construct($controller, $action)
	{
		$this->doNotRenderHeader = 1;	
		$this->render = 1;
		$this->_mymodel = 'Getdata';
		parent::__construct($controller, $action);

	}

	function beforeAction(){}

	function activate()
	{
		$this->set('metaTitle', 'Activate your account');

		if(isset($_GET['success']) === true && empty($_GET['success']) === true)
		{
		?>
			 <h2>Thanks, we have activated your account...</h2>
			 <p>You're free to <a href=<?php echo BASE_PATH; ?>>log in</a></p>
		<?php
		}
		elseif (isset($_GET['email'], $_GET['userCode']) === true)
		{
			$email     = trim($_GET['email']);
			$userCode = trim($_GET['userCode']);
			$activate = new Setdata();


			if($this->Getdata->emailExist($email) == false)
			{
				echo "<h2>Oops....</h2> Oops, something went wrong, and we couldn't find that email address!";
			}
			elseif($activate->activateUser($email, $userCode) == TRUE)
			{
				header('Location: activate&success');
				exit();
			}
			else
			{				
				echo "<h2>Oops....</h2> We had problems activating your account. Try logging in, if the problem persists, please contact us if the problem persists";

			}
		}
		else
		{
			echo "<h2>Oops....</h2> We had problems activating your account. Make sure you copied the link properly. Please contact us if the problem persists";
			exit();
		}
	}

	function afterAction(){}
}