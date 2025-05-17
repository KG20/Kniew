<?php
		error_reporting(0);

class RegisterasprofessionalController extends Controller
{

	function __construct($controller, $action)
	{
		if($action == 'index')
		{
			$this->doNotRenderHeader = 1;
			$this->_mymodel = 'Setdata';
		}
		else
		{
			$this->render = 0;
			$this->_mymodel = 'Getdata';
		}

		parent::__construct($controller, $action);
	}
	function index(){
		$this->set('metaTitle', 'Connect with New Clients - Register as Professional | ' . WEBNAME);
		$this->set('metaDescription', 'Reach and connect with clients for your Law practice,  Chartered Acountancy, NGO or Medical practice by signing up with us now! Limited time FREE registeration.');

	}

	function getworkat()
	{
		$this->render = 0;
		if(isset($_GET['type']))
		{
			$type =  htmlentities(strip_tags($_GET['type']));
			$worknames = $this->Getdata->workByType($type);
			$returnHtml = '';
			foreach ($worknames as $workat)
			{
				$returnHtml .= '<option data-value="' . $workat['id'] . '" value="' . $workat['name'] . '">' . $workat['name'] . ' ('. ucwords($workat['formattedaddress']) . ')</option>';
			}
			echo $returnHtml;
		}
	}

	function recommend()
	{
		$this->render = 0;
		$recommendname = strip_tags(trim($_POST['recommendname']));

		$searchquery = $this->Getdata->searchRecommend($recommendname);
		if(empty($searchquery))
		{
			echo '<div class="show" align="left">

				<span class="name error">No User found!</span> <br/>

			</div>';
		}
		else
		{
			foreach ($searchquery as $search)
			{
				echo '<div class="show">

					<span class="name">' . $search['name'] . '</span> ';

				echo "<p class ='italicstext smalltext'>(".$search['username']." | ".ucfirst($search['formattedaddress']).")</p>";
				echo '<p class="id hidden">'.$search['id'].'</p>

				</div>';
			}

		}
	}

	function getAllFocus()
	{
		$this->render = 0;
		$Professionals = new Professionals();
		$focusAllHtml = array();
		$focusall = $Professionals->getAllFocus();
		$parentid = null;

		if($focusall)
		{
			foreach ($focusall as $key => $focus)
			{
				$arraykey = 'type_' . $focus['type'];
				if($focus['childid'] != NULL)
				{
					if($parentid != $focus['mainid'])
					{
						$focusAllHtml[$arraykey] .= ' <option class="parentfocus" value="'.$focus['mainid'].'">
					            '. $focus['mainfocus'].'
					        </option>';
					}
					$focusAllHtml[$arraykey] .= ' <option class="childfocus" value="'.$focus['childid'].'">
					             '.$focus['childfocus'].'
					        </option>';
				}
				else
				{

					$focusAllHtml[$arraykey] .= ' <option value="'.$focus['mainid'].'">
					            '.$focus['mainfocus'].'
					        </option>';
				}
				$parentid = $focus['mainid'];
			}
			echo json_encode($focusAllHtml);
		}



	}

	function getfocus()
	{
		if(isset($_GET['type']))
		{
			$this->render = 0;
			$type =  htmlentities(strip_tags($_GET['type']));
			$Professionals = new Professionals();
			$focusall = $Professionals->getFocusByType($type);
			$parentid = null;

			foreach ($focusall as $key => $focus)
			{
				if($focus['childid'] != NULL)
				{
					if($parentid != $focus['mainid'])
					{

						echo ' <option class="parentfocus" value="'.$focus['mainid'].'">
					            '. $focus['mainfocus'].'
					        </option>';
					}
					echo ' <option class="childfocus" value="'.$focus['childid'].'">
					             '.$focus['childfocus'].'
					        </option>';
				}
				else
				{

					echo ' <option value="'.$focus['mainid'].'">
					            '.$focus['mainfocus'].'
					        </option>';
				}
				$parentid = $focus['mainid'];

			}

		}
		else
		{
			echo '<option value = "default"> Something went wrong! Please select any other option and then reselect your occupation! </option>';
		}
	}


}
