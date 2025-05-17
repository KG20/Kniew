<?php
// error_reporting(0);
class ProfessionalsController extends Controller
{
	protected $usertypename;
	protected $username;
	function __construct($controller, $action)
	{

		$url = preg_replace('#/+#','/',$_GET['url']);
		$urlArray =  preg_split('@/@', strtolower($url), NULL, PREG_SPLIT_NO_EMPTY);

		if($action == 'lawyers' || $action == 'charteredaccountants' || $action == 'doctors' || $action == 'ngo')
		{
			if(!isset($urlArray[2])) $action = 'basictemplate';
			if(isset($urlArray[2]))
			{

					$this->username = htmlspecialchars(strip_tags(trim($urlArray[2])));
					$action = 'professional';

			}
		}


		if(isset($_GET['locale']))
		{
			$this->location = str_replace('_', ' ', strip_tags(trim($_GET['locale'])));
		}
		if(isset($_GET['focus']))
		{
			if(is_array($_GET['focus'])) $this->focus =  array_map(
							    function($str) {
							        return str_replace('_', ' ', $str);
							    },
							    $_GET['focus']
							);
			else $this->focus = $_GET['focus'];
		}


		parent::__construct($controller, $action);

	}

	public function index()
	{
		$this->set('metaTitle', 'Find professional - Name, location, specialisation, review | ' . WEBNAME);
		$this->set('metaDescription', 'Find top lawyer, Chartered accountants, NGOs and doctors effortlessly. Consult, book appointment, review professional, ask advice or connect with new clients.');
	}

	public function charteredaccountants()
	{
		if(!empty($_GET["page"]))
		{
			$this->render = 0;
		}



		if(isset($this->username))
		{
			$this->set('usertypename', 'Chartered Accountants');
			$this->set('usertype', 5);
			$this->set('professionalUsername', $this->username);
			$profDet = $this->Professionals->getProfessionalFromUsername($this->username);
			if(!empty($profDet))
			{
				$this->set('professionalDetails', $profDet);
				$this->set('metaTitle', $profDet['name'] . ' | Kniew');
				$this->set('metaDescription', substr(strip_tags($profDet['about']), 0, 150));
			}
			else
			{
				$this->render = 0;
				header('Location: ' . BASE_PATH . 'notice/pagedoesnotexists');


			}
		}
		else $this->getdatabytype(5);
	}

	public function lawyers()
	{
		if(!empty($_GET["page"]))
		{
			$this->render = 0;
		}

		if(isset($this->username))
		{
			$this->set('usertypename', 'Lawyers');
			$this->set('usertype', 3);
			$this->set('professionalUsername', $this->username);
			$profDet = $this->Professionals->getProfessionalFromUsername($this->username);
			if(!empty($profDet))
			{
				$this->set('professionalDetails', $profDet);
				$this->set('metaTitle', $profDet['name'] . ' | Kniew');
				$this->set('metaDescription', substr(strip_tags($profDet['about']), 0, 150));
			}
			else
			{
				$this->render = 0;
				header('Location: ' . BASE_PATH . 'notice/pagedoesnotexists');


			}
		}
		else $this->getdatabytype(3);


	}

	public function ngo()
	{
		if(!empty($_GET["page"]))
		{
			$this->render = 0;
		}

		if(isset($this->username))
		{
			$this->set('usertypename', 'NGO');
			$this->set('usertype', 2);
			$this->set('professionalUsername', $this->username);
			$profDet = $this->Professionals->getProfessionalFromUsername($this->username);
			if(!empty($profDet))
			{
				$this->set('professionalDetails', $profDet);
				$this->set('metaTitle', $profDet['name'] . ' | Kniew');
				$this->set('metaDescription', substr(strip_tags($profDet['about']), 0, 150));
			}
			else
			{
				$this->render = 0;
				header('Location: ' . BASE_PATH . 'notice/pagedoesnotexists');


			}
		}
		else $this->getdatabytype(2);

	}

	public function doctors()
	{
		if(!empty($_GET["page"]))
		{
			$this->render = 0;
		}


		if(isset($this->username))
		{
			$this->set('usertypename', 'Doctors');
			$this->set('usertype', 4);
			$this->set('professionalUsername', $this->username);
			$profDet = $this->Professionals->getProfessionalFromUsername($this->username);
			if(!empty($profDet))
			{
				$this->set('professionalDetails', $profDet);
				$this->set('metaTitle', $profDet['name'] . ' | Kniew');
				$this->set('metaDescription', substr(strip_tags($profDet['about']), 0, 150));
			}
			else
			{
				$this->render = 0;
				header('Location: ' . BASE_PATH . 'notice/pagedoesnotexists');


			}
		}
		else $this->getdatabytype(4);

	}


	public function getdatabytype($usertype)
	{
		if($usertype == 2) $usertypename = 'NGO';
		else if($usertype == 3) $usertypename = 'Lawyers';
		else if($usertype == 4) $usertypename = 'Doctors';
		else if($usertype == 5) $usertypename = 'Chartered Accountants';
		$this->set('usertype', $usertype);
		$this->set('usertypename', $usertypename);
		$location ='';
		$orderby = 'rate';
		$perPage = 10;
		$jurisdiction =[];
		$isfree = FALSE;
		$onlinesession = false;
		$language = [];
		$focus = [];
		$includesub = 1;
		$includeonlyfirm = 0;
		$name = '';
		$title ='';

		if($_POST)
		{
			$this->render = 0;
			if(!empty($_POST['formattedaddress'])) $location = htmlspecialchars(strip_tags(trim($_POST['formattedaddress'])));

			if(!empty($_POST['focus'])) $focus = $_POST['focus'];
			if(isset($_POST['order'])) $orderby = strip_tags($_POST['order']);
			if(isset($_POST['includesub'])) $includesub = $_POST['includesub'];
			if(isset($_POST['includeonlyfirm'])) $includeonlyfirm = $_POST['includeonlyfirm'];
			if(isset($_POST['jurisdiction'])) $jurisdiction =$_POST['jurisdiction'];
			if(isset($_POST['isfree'])) $isfree = $_POST['isfree'];
			if(isset($_POST['onlinesession'])) $onlinesession =$_POST['onlinesession'];
			if(isset($_POST['language'])) $language =$_POST['language'];
			if(isset($_POST['name'])) $name = $_POST['name'];
			if(isset($_POST['firstfocus'])) $title = ucwords($_POST['firstfocus']) . ' ';

		}
		elseif(isset($this->location) || isset($this->focus))
		{
			$location = !empty($this->location) ? trim($this->location) : '';
			$focus = !empty($this->focus) ? $this->focus : [];
			if(is_array($focus) && isset($focus[0])) $title = ucwords($focus[0]) . ' ';
			elseif(isset($focus[0]) && !is_array($focus))
			{
				$title = ucwords($focus) . ' ';
				$focus = explode(' ', $focus);
			}

		}
		else
		{
			if(defined('CITY')) $location .= CITY;
			if(defined('STATE')) $location  .= ' ' . STATE;
			if(defined('COUNTRY')) $location .= ' ' . COUNTRY;
			$location = trim($location);
		}

		$title .= ucwords($usertypename);
		if($location != '') $title .= ' in ' . $location . ' and many other locations';

		$this->set('metaTitle', $title . ' | Kniew');
		$this->set('metaDescription', 'Find and Connect with ' . $title . '. Search by name, location, specialisation, cost, language, jurisdiction and much more.');
		$this->set('location', $location);

		if(!empty($_GET["page"]))
		{
			$page = $_GET['page'];
			$this->render = 0;
			$result = $this->Professionals->getProfessional($usertype, $name, $location, $focus, $includesub,$includeonlyfirm, $jurisdiction, $isfree, $onlinesession, $language, $orderby, $page, $perPage);
			if(isset($result) && !empty($result))
			{
				$cardData = $this->cardHtml($result, $usertypename, $page);
				$cardData .=  '<input type="hidden" class="pagenum" value="' . $page . '" />';
				echo $cardData;
			}
			else echo false;

		}
		else
		{
			$page=1;
			$cardData = '';

			$result = $this->Professionals->getProfessional($usertype, $name, $location, $focus, $includesub,$includeonlyfirm, $jurisdiction, $isfree, $onlinesession, $language, $orderby, $page, $perPage);
			$cardData = '<h1 class="margin2per">'.$title.'</h1>';
			$cardData .= $this->cardHtml($result, $usertypename, $page);
			$cardData .=  '<input type="hidden" class="pagenum" value="' . $page . '" />';
			$this->set('cardData' , $cardData);
			if($_POST)
			{
				echo $cardData;
			}

		}

	}


	public function cardHtml($result, $usertypename, $page = NULL)
	{

		$usertypename = str_replace(' ', '', strtolower($usertypename));

		if(isset($result) && !empty($result))
		{
				$cardHtmlVar = '<div class ="pageloaded">';

			foreach ($result as $field => $data)
			{
				// $data  = array_walk($data, 'htmlspecialchars_decode');
				$about = strip_tags(preg_replace('#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#', '', html_entity_decode($data['about'])));

				$slide2 ='';
				$slide3 = '';

				$rate = ($data['rating'] != null) ? $data['rating'] : 0;
				$starempty = '<i class="fa fa-star-o fa-2x" aria-hidden="true" ></i> ';
				$starhalf = '<i class="fa fa-star-half-empty fa-2x" aria-hidden="true"></i> ';
				$starfull = '<i class="fa fa-star fa-2x" aria-hidden="true"></i> ';
				$ratenum = explode('.', $rate);
				$stars = str_repeat ( $starfull , $ratenum[0] );
				if(isset($ratenum[1]) && $ratenum[1] != 0)
				{
					$stars .= $starhalf;
					$stars .= str_repeat ( $starempty , (5-$ratenum[0]-1));
				}
				else
				{
					$stars .= str_repeat ( $starempty , (5-$rate));
				}



				$slide2 = '<p class= "item">
							<span class="stars">
							 ' . $stars . '
							 <span>' . $data['noofrating'] .
					    	'<i class="fa fa-users" aria-hidden="true"></i></span>
				    	</span></p>';
				if((isset($data['workday']) && $data['workday'] != null) | (isset($data['formattedaddress']) && $data['formattedaddress'] != null) )
				{
					$slide3 = '<p class= "item">';

					$day = explode(",", str_replace(array("{", "}"), "", $data['workday']));
					if(!empty($data['workday'])) $slide3 .= '<i class = "detailsLabel smallertext hidden-xs">Timing: </i>' .  date('H:ma', strtotime($day[0])) . " - " . date('H:ma', strtotime($day[1])) . '<br>';
					if($data['formattedaddress']) $slide3 .= '<i class = "detailsLabel smallertext hidden-xs">Address: </i> ' . ucwords($data['formattedaddress']);
					$slide3 .= '</p>' ;

				}

		    	// {

		  //   	$slide3 = '<p class= "item"><i></i>
				// 	    	<span class = "rating jDisabled" data-average = ' . $rate .' data-id="' . $data['id'] .'" ></span>

				// 	    	</p>';
		    	// }

				if($page > 1) $cardHtmlVar .= '<div class="lazyload"><!--';
				else $cardHtmlVar .= '<div>';

				$cardHtmlVar .= '<div class="col-xs-6 col-md-4  col-xl-2">
						    <div class="thumbnail">
						    <a href="'.BASE_PATH.'professionals/'. $usertypename .'/'. $data['username'] .'"><span class="thumbnaillink">'.$data['username'].'</span></a>';
						    if($data['profilepic']){
							  $cardHtmlVar .='<img src= "'. BASE_PATH .$data['profilepic'] .'" alt="'.$data['name'].'"/>';
							 } else {
								$cardHtmlVar .= '<div class=" imagecontainer"><i class="fa fa-user imagetext"></i></div>';
							 }
				 if($data['workat'] == '0')
				 {
					 $cardHtmlVar .= '<span class="bottomoverlay smalltext label label-success"><i class="fa fa-building-o" aria-hidden="true"></i></span>';
				 }
				 else
				 {
				 	$cardHtmlVar .= '<span class="bottomoverlay label smalltext transparenttext">label</span>';
				 }

				$cardHtmlVar .='
						      <div class="caption" >
						        <h3>' . $data['name'] . '</h3>
						        <div class="card-description carousel slide profCardCarousel"  id="profCardCarousel'.$data['id'].'">
									<div class="carousel-inner">
							        <p class= "item active">'.$about .'</p>' .
							        $slide2 . $slide3 .

						       '</div>
						       <a class="left carousel-control" href="#profCardCarousel'.$data['id'].'" data-slide="prev">‹</a>
						        <a class="right carousel-control" href="#profCardCarousel'.$data['id'].'" data-slide="next">›</a>
						       </div>
						        <p class="tags">'
						        .  str_replace(",", " <b>|</b> ", (preg_replace('/[^A-Za-z0-9,\']/', '', $data['allfocus']))) .

						     '</p>
						      </div>
						    </div>
						  </div>';
			    if($page > 1) $cardHtmlVar .= '--></div>';
			    else $cardHtmlVar .= '</div>';


			  }
			  $cardHtmlVar .= '</div>';
			  return $cardHtmlVar;
			}
			else
				return false;
	}


	public function getSpecialisation()
	{
		$this->render = 0;
		$type = $_POST['type'];
		$focusall = $this->Professionals->getFocusByType($type);
		$parentid = null;
		$hadchild = null;
		$length = count($focusall);
		echo '<div class="col-md-3">';
		foreach ($focusall as $key => $focus)
		{
			if($key%9  == 0 && $key != 0 && $key != ($length-1))
			{
				 echo '</div><div class="col-md-3">';
			}

			if($focus['childid'] != NULL)
			{
				if($parentid != $focus['mainid'])
				{
					$hadchild = 1;
					echo '<p class="childgroup">';
					echo ' <label class="checkbox parentfocus">
				            <input type="checkbox" name="focus[]" value="'.$focus['mainid'].'" > '.$focus['mainfocus'].'
				        </label>';
				}
				echo ' <label class="checkbox childfocus">
				            <input type="checkbox" name="focus[]" value="'.$focus['childid'].'" > '.$focus['childfocus'].'
				        </label>';
			}
			else
			{
				if($hadchild == 1)
				{
					$hadchild = 0;
					echo '</p>';
				}
				echo ' <label class="checkbox norelfocus">
				            <input type="checkbox" name="focus[]" value="'.$focus['mainid'].'" > '.$focus['mainfocus'].'
				        </label>';
			}

			$parentid = $focus['mainid'];

		}
		echo '</div>';

	}

	public function getlanguages()
	{
		$this->render =0;
		$languages = $this->Professionals->getDistinctLanguages();

		foreach ($languages as $key => $lang)
		{
			echo '<li class="checkbox"><label><input type="checkbox" name="language[]" value="'.ucwords($lang[0]).'"/>&nbsp;'.ucwords($lang[0]).'</label></li>';
		}

	}

	public function locationsearch()
	{
		$this->render = 0;
		$location = strip_tags(trim($_POST['formattedaddress']));

		$searchquery = $this->Professionals->searchLocation($location);
		if(empty($searchquery))
		{
			echo '<div class="show" align="left">

				<span class="name error">No Result found!</span> <br/>

			</div>';
		}
		else
		{
			foreach ($searchquery as $search)
			{
				echo '<div class="show">

					<span class="location">' . $search['formattedaddress'] . '</span></div>';

			}

		}
	}

	// public function areasearch()
	// {
	// 	$this->render = 0;
	// 	$area = strip_tags(trim($_POST['area']));

	// 	$searchquery = $this->Professionals->searchArea($area);
	// 	if(empty($searchquery))
	// 	{
	// 		echo '<div class="show" align="left">

	// 			<span class="name error">No Result found!</span> <br/>

	// 		</div>';
	// 	}
	// 	else
	// 	{
	// 		foreach ($searchquery as $search)
	// 		{
	// 			echo '<div class="show">

	// 				<span class="area">' . ucwords($search['sublocality']) . ', </span><span  class="city">
	// 				'. ucwords($search['city'] .', </span><span class="state">' . $search['state'] . ', </span><span class="country">' . $search['country']) . '</span></div>';

	// 		}

	// 	}
	// }

	// public function citysearch()
	// {
	// 	$this->render = 0;
	// 	$city = strip_tags(trim($_POST['city']));

	// 	$searchquery = $this->Professionals->searchCity($city);
	// 	if(empty($searchquery))
	// 	{
	// 		echo '<div class="show">

	// 			<span class="name error">No Result found!</span> <br/>

	// 		</div>';
	// 	}
	// 	else
	// 	{
	// 		foreach ($searchquery as $search)
	// 		{
	// 			echo '<div class="show">
	// 				<span class="city">' . ucwords($search['city']) . ', </span><span class="state">
	// 				' . ucwords($search['state'] . ', </span><span class="country">' . $search['country']) . '</span></div>';

	// 		}

	// 	}
	// }

	// public function statesearch()
	// {
	// 	$this->render = 0;
	// 	$state = strip_tags(trim($_POST['state']));

	// 	$searchquery = $this->Professionals->searchState($state);
	// 	if(empty($searchquery))
	// 	{
	// 		echo '<div class="show">

	// 			<span class="name error">No Result found!</span> <br/>

	// 		</div>';
	// 	}
	// 	else
	// 	{
	// 		foreach ($searchquery as $search)
	// 		{
	// 			echo '<div class="show">

	// 				<span class="state">' . ucwords($search['state']) . ', </span><span class="country">
	// 				'  . ucwords($search['country']) . '</span></div>';

	// 		}

	// 	}
	// }

	// public function countrysearch()
	// {
	// 	$this->render = 0;
	// 	$country = strip_tags(trim($_POST['country']));

	// 	$searchquery = $this->Professionals->searchCountry($country);
	// 	if(empty($searchquery))
	// 	{
	// 		echo '<div class="show">

	// 			<span class="name error">No Result found!</span> <br/>

	// 		</div>';
	// 	}
	// 	else
	// 	{
	// 		foreach ($searchquery as $search)
	// 		{
	// 			echo '<div class="show">

	// 				<span class="country">' . ucwords($search['country']) . '</span>
	// 				' . '</div>';

	// 		}

	// 	}
	// }





	public function getsimilarprof()
	{
		$this->render = 0;

		$page =1;
		if($_POST['page']) $page = $_POST['page'];

		$usertype = $_POST['usertype'];
		if($usertype == 2) $usertypename = 'NGO';
		else if($usertype == 3) $usertypename = 'Lawyers';
		else if($usertype == 4) $usertypename = 'Doctors';
		else if($usertype == 5) $usertypename = 'Chartered Accountants';
		$focus = $_POST['mainfocus'];
		$id = $_POST['professionalid'];
		if($_POST['location']) $location = trim(strip_tags($_POST['location']));

		// if($_POST['sublocality'] != NULL)
		// {
		// 	$location['sublocality'] =$_POST['sublocality'];
		// 	$location['city'] =$_POST['city'];
		// 	$location['state'] =$_POST['state'];
		// 	$location['country'] =$_POST['country'];
		// }
		// else if($_POST['city'])
		// {
		// 	$location['city'] =$_POST['city'];
		// 	$location['state'] =$_POST['state'];
		// 	$location['country'] =$_POST['country'];
		// }
		// else if($_POST['state'])
		// {
		// 	$location['state'] =$_POST['state'];
		// 	$location['country'] =$_POST['country'];
		// }
		// else if($_POST['country'])
		// {

		// 	$location['country'] =$_POST['country'];
		// }

		$mainfocus[0] = $focus;
		$otherfocus = json_decode($_POST['otherfocus']);
		if(!empty($otherfocus) && $otherfocus[0] != null)
		{
			$allfocus = array_merge($mainfocus, $otherfocus);
		}
		else $allfocus = $mainfocus;




		$getsimilar = $this->Professionals->getSimilar($page, 4, $usertype, $focus, $location, $id);

		$locationarray = explode(',', $location);

		while(empty($getsimilar) && (count($locationarray) > 1)){

			$locationarray = array_slice($locationarray, 1);
			$locationassemble = implode(' ', $locationarray);


			$getsimilar =$this->Professionals->getSimilar($page, 4, $usertype, $allfocus, $locationassemble, $id);


		}


	    if($getsimilar)
	    {
	    	echo '<div class ="item ';
		    if($page == 1) echo 'active';
		    echo' ">';


		    foreach ($getsimilar as $result) {
			    $result['username'] = html_entity_decode($result['username']);
			    $result['name'] = html_entity_decode($result['name']);


			    $username = urlencode($result['username']);

				echo '<div class="col-xs-6 col-sm-3 col-md-2  col-xl-2">
					    <div class="thumbnail">
					    <a href="'.BASE_PATH.'professionals/'.strtolower(str_replace(' ', '', $usertypename)).'/'.$username.'"><span class="thumbnaillink">'.$username.'</span></a>';
			    if($result['profilepic']) echo '<img src="' . BASE_PATH . $result['profilepic'] .'" alt="'.$result['name'].'" />';
			    else echo '<div class=" imagecontainer"><i class="fa fa-user imagetext"></i></div>';

					    echo ' <div class="caption">
					        <h3>' . $result['name']. '</h3>

					      </div>
					    </div>
					  </div>';
			}
			echo '</div>';
		}
		else
		{
			echo false;
		}


	}

	public function getsimilarother()
	{
		$this->render = 0;

		$page =1;
		if($_POST['page']) $page = $_POST['page'];
		$usertype = $_POST['usertype'];


		$focus = explode(' ', $_POST['mainfocus']);
		if($_POST['location']) $location = trim(strip_tags($_POST['location']));


		$getother = $this->Professionals->getOther($page, 4, $usertype, $focus, $location);


		$locationarray = explode(',', $location);

		while(empty($getother) && (count($locationarray) > 1)){

			$locationarray = array_slice($locationarray, 1);
			$locationassemble = implode(' ', $locationarray);

			$getother =$this->Professionals->getOther($page, 4, $usertype, $focus, $locationassemble);


		}


	    if($getother)
	    {

	    	echo '<div class ="item ';
		    if($page == 1) echo 'active';
		    echo' ">';


		    foreach ($getother as $result)
		    {
			    $result['username'] = html_entity_decode($result['username']);
			    $result['name'] = html_entity_decode($result['name']);
			    if($result['usertype'] == 2) $usertypename = 'NGO';
    			else if($result['usertype'] == 3) $usertypename = 'Lawyers';
    			else if($result['usertype'] == 4) $usertypename = 'Doctors';
    			else if($result['usertype'] == 5) $usertypename = 'Chartered Accountants';


			    $username = urlencode($result['username']);

				echo '<div class="col-xs-6 col-sm-3 col-md-2  col-xl-2">
					    <div class="thumbnail">
					    <a href="'.BASE_PATH.'professionals/'.strtolower(str_replace(' ', '', $usertypename)).'/'.$username.'"><span class="thumbnaillink">'.$username.'</span></a>';
			    if($result['profilepic']) echo '<img src="' . BASE_PATH . $result['profilepic'] .'" alt="'.$result['name'].'" />';
			    else echo '<div class=" imagecontainer"><i class="fa fa-user imagetext"></i></div>';

					    echo ' <div class="caption">
					        <h3>' . $result['name']. '
					        <p class = "xsmalltext">' . rtrim($usertypename, 's'). '</p></h3>

					      </div>
					    </div>
					  </div>';
			}
			echo '</div>';
		}
		else
		{
			echo false;
		}


	}


	public function percentagerating()
	{
		$this->render = 0;
		$id = $_POST['professionalid'];
		$total = $_POST['noofrating'];
		$resultarray = $this->Professionals->getRatingByRate($id);
		$result =[];
		foreach ($resultarray as $value)
		{
			$result[$value['rating']] = $value['countrating'];
		}
		$five = $this->getPercentage($total, $result[5]);
		$four = $this->getPercentage($total, $result[4]);
		$three = $this->getPercentage($total, $result[3]);
		$two = $this->getPercentage($total, $result[2]);
		$one = $this->getPercentage($total, $result[1]);



		echo '<div class="col-xs-1"><b>5</b></div>
		<div class="col-xs-11">
			<div class="progress">
				 <div class="progress-bar '.$this->getclassbywidth($five,5) .'" role="progressbar" aria-valuenow="'. $five .'" aria-valuemin="0" aria-valuemax="100" style = "width: '.$five .'%">
					      '.$five .'%
			    </div>

			</div>
		</div>

		<div class="col-xs-1"><b>4</b></div>
		<div class="col-xs-11">
			<div class="progress">
				 <div class="progress-bar '.$this->getclassbywidth($four, 4).'" role="progressbar" aria-valuenow="'.$four .'" aria-valuemin="0" aria-valuemax="100" style = "width:'.$four .'%">
					      '.$four .'%
			    </div>

			</div>
		</div>

		<div class="col-xs-1"><b>3</b></div>
		<div class="col-xs-11">
			<div class="progress">
				 <div class="progress-bar '.$this->getclassbywidth($three, 3).'" role="progressbar" aria-valuenow="'.$three .'" aria-valuemin="0" aria-valuemax="100" style = "width: '.$three .'%">
					      '.$three .'%
			    </div>

			</div>
		</div>

		<div class="col-xs-1"><b>2</b></div>
		<div class="col-xs-11">
			<div class="progress">
				 <div class="progress-bar '.$this->getclassbywidth($two, 2).'" role="progressbar" aria-valuenow="'.$two .'" aria-valuemin="0" aria-valuemax="100" style = "width:'.$two .'%">
					      '.$two .'%
			    </div>

			</div>
		</div>

		<div class="col-xs-1"><b>1</b></div>
		<div class="col-xs-11">
			<div class="progress">
				 <div class="progress-bar '. $this->getclassbywidth($one, 1) . '" role="progressbar" aria-valuenow="'.$one .'" aria-valuemin="0" aria-valuemax="100" style = "width:'.$one .'%">
					      '.$one .'%
			    </div>

			</div>
		</div>';
	}

	protected function getPercentage($total, $totalrates)
	{
		$scale = 1.0;
		if ( !empty($total) ) { $percent = ($totalrates * 100) / $total; }
		else { $percent = 0; }
		if ( $percent > 100 ) { $percent = 100; }
		return $percent;
	}

	protected function getclassbywidth($width, $type)
	{
		if($type >= 3)
		{
			if($width <= 10) return 'progress-bar-danger';
			else if($width >= 80) return 'progress-bar-success';
			else if($width <= 15) return 'progress-bar-warning';
			else return 'progress-bar-info';
		}
		else
		{
			if($width >= 85) return 'progress-bar-danger';
			else if($width <= 10) return 'progress-bar-success';
			else if($width >= 75) return 'progress-bar-warning';
			else return 'progress-bar-info';
		}
	}

	public function giverating()
	{
		$this->render =0;
		$result = $this->Professionals->insertRating($_POST['rate'], $_POST['idBox'], $_SESSION['id']);
		echo $result;

	}

	public function getcomments()
	{

		$this->render = 0;
		$username = $_SESSION['username'];
		$id = $_SESSION['id'];
		if($_POST)
		{
			$professionalid = filter_var(trim($_POST["professionalid"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
			$page = $_POST['page'];
			if(!$page) $page = 0;
			if($result = $this->Professionals->getprofcomments($professionalid, $id, $page))
			{

				foreach ($result as $key => $value)
				{

					if($value['profilepic'])
					{
						$result[$key]['profilepic'] = BASE_PATH . $value['profilepic'];
					}
					if($value['usertype'] == 2 || $value['usertype'] == 3 || $value['usertype'] == 4 || $value['usertype'] == 5)
					{
						$typename='';
						if($value['usertype'] == 3) { $typename = 'Lawyers'; $result[$key]['labelclass'] = 'label label-primary'; }
						elseif($value['usertype'] == 4) { $typename = 'Doctors'; $result[$key]['labelclass'] = 'label label-danger';}
						else if($value['usertype'] == 5) { $typename = 'Chartered Accountants'; $result[$key]['labelclass'] = 'label label-warning'; }
						else if($value['usertype'] == 2) { $typename = 'NGO'; $result[$key]['labelclass'] ='label label-success'; }

						$result[$key]['username'] = $value['username'];

						$result[$key]['profileURL'] = BASE_PATH . 'professionals/'. $typename . '/' . $value['username'];
					}
					else if($value['usertype'] == 1)
					{
						$result[$key]['profileURL'] = BASE_PATH . 'user/' . $value['username'];
					}
					if($value['username'] == $username)
					{
						$result[$key]['createdbycurrentuser'] = true;
					}
					else
					{
						$result[$key]['createdbycurrentuser'] = false;
					}

					if($value['count'] > 0)
					{
						$result[$key]['verifieduser'] = true;
					}
					else
					{
						$result[$key]['verifieduser'] = false;
					}

				}
				echo json_encode($result);
			}
		}
	}


	public function postcomment()
	{
		$this->render = 0;
		$username = $_SESSION['username'];
		$id = $_SESSION['id'];

		if($_POST)
		{
			$professionalid = filter_var(trim($_POST["professionalid"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
			$commentJSON = $_POST["commentJSON"];
			if($commentJSON['parentid'] != null  and $professionalid == $_SESSION['id'])
			{
				$commentJSON['createdbyprofessional'] = 1;

			}
			else $commentJSON['createdbyprofessional'] = null;
			$commentJSON['id'] = $id;
			$commentJSON['professionalid'] = $professionalid;
			$commentJSON['comment'] = htmlspecialchars(strip_tags(trim($commentJSON['comment'])));
			if($commentJSON['parentid'] == null) $result = $this->Professionals->setRatingComment($commentJSON);
			else $result = $this->Professionals->setReply($commentJSON);
			echo $result;
		}

	}


	public function putcomment()
	{
		$this->render = 0;
		$username = $_SESSION['username'];
		$id = $_SESSION['id'];
		if($_POST)
		{
			$professionalid = filter_var(trim($_POST["professionalid"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
			$commentPUT = $_POST['commentPUT'];
			$commentPUT['comment'] = htmlspecialchars(strip_tags(trim($commentPUT['comment'])));
			$commentPUT['professionalid'] = $professionalid;
			$commentPUT['modifiedat'] = date('Y-m-d\TH:i:s\Z' , $commentPUT['modified']/1000);
			if($commentPUT['parentid'] == null) $result = $this->Professionals->updateRatingComment($commentPUT);
			elseif($commentPUT['parentid'] != null) $result = $this->Professionals->updateReply($commentPUT);
			echo $result;
		}

	}

	public function deletecomment()
	{
		$this->render = 0;

		if($_POST)
		{
			$commentdel = $_POST['commentDel'];

			if($commentdel['parentid'] == null)  $result = $this->Professionals->removeRatingComment($commentdel['rateid']);
			elseif($commentdel['parentid'] != null) $result = $this->Professionals->removeReply($commentdel['rateid']);

		}

	}


	public function employees()
	{
		$this->render =0;
		if($_POST)
		{
			$id = $_POST['id'];
			$page = 1;
			if($_POST['page']) $page = $_POST["page"];
			if($_POST['perpage']) $perpage = $_POST['perpage']; else $perpage = 5;
			$usertypename = $_POST['usertypename'];

			$result = $this->Professionals->getEmployeesByName($id, $page, $perpage);

			if($result)
			{
				foreach ($result as $key => $value)
				{
					$rate = ($value['rate'] != null) ? $value['rate'] : 0;
					$starempty = '<i class="fa fa-star-o" aria-hidden="true" ></i> ';
					$starhalf = '<i class="fa fa-star-half-empty" aria-hidden="true"></i> ';
					$starfull = '<i class="fa fa-star" aria-hidden="true"></i> ';
					$ratenum = explode('.', $rate);
					$stars = str_repeat ( $starfull , $ratenum[0] );
					if(isset($ratenum[1]) && $ratenum[1] != 0)
					{
						$stars .= $starhalf;
						$stars .= str_repeat ( $starempty , (5-$ratenum[0]-1));
					}
					else
					{
						$stars .= str_repeat ( $starempty , (5-$rate));
					}


					echo "<li class='row'><div class='col-sm-5'>
						<a href=" .BASE_PATH."professionals/".strtolower(str_replace(' ', '', $usertypename))."/".$value['username']."> ";
					if(!empty($value['profilepic'])) echo "<p class='col-sm-3'><img class='circleimg' src='" . BASE_PATH . $value['profilepic'] . "' alt='".$value['name']."'/></p>";
					else echo "<p class='col-sm-3 centertext'><i class='fa fa-user fa-2x'></i></p>";
					echo "<p class='col-sm-9 text-xs-center text-sm-left'><b>" . ucfirst($value['name'])."</b></p>
						</a></div>
						<div class = 'col-sm-7'>
					<p class='col-sm-6 detailsLabel smallertext text-xs-center'>". ucwords($value['focus']). "</p>
					<p class='col-sm-6 text-xs-center text-sm-right textcolorlinkblue'>" . $stars ."</p></div>
					</li>";
				}
			}
			else echo false;

		}
	}


	public function getrecommended()
	{
		$this->render = 0;
		if($_POST)
		{
			$result  = $this->Professionals->recommended($_POST['id']);

			if(!empty($result))
			{
			    foreach ($result as $recommend)
    			{
    				if($recommend['usertype'] == 2) $usertypename = 'ngo';
    				else if($recommend['usertype'] == 3) $usertypename = 'lawyers';
    				else if($recommend['usertype'] == 4) $usertypename = 'doctors';
    				else if($recommend['usertype'] == 5) $usertypename = 'charteredaccountants';

    				$rate = ($recommend['rate'] != null) ? $recommend['rate'] : 0;
    				$starempty = '<i class="fa fa-star-o" aria-hidden="true" ></i> ';
    				$starhalf = '<i class="fa fa-star-half-empty" aria-hidden="true"></i> ';
    				$starfull = '<i class="fa fa-star" aria-hidden="true"></i> ';
    				$ratenum = explode('.', $rate);
    				$stars = str_repeat ( $starfull , $ratenum[0] );
    				if(isset($ratenum[1]) && $ratenum[1] != 0)
    				{
    					$stars .= $starhalf;
    					$stars .= str_repeat ( $starempty , (5-$ratenum[0]-1));
    				}
    				else
    				{
    					$stars .= str_repeat ( $starempty , (5-$rate));
    				}

    				echo "
    					<div class='col-xs-4 '>
    						<a href=" .BASE_PATH."professionals/".$usertypename."/".$recommend['username']."> ";
    					if(!empty($recommend['profilepic'])) echo "<p class='textaligncenter'><img class='circleimg' src='" . BASE_PATH . $recommend['profilepic'] . "' alt='".$recommend['name']."'/></p>";
    					else echo "<p class='fullwidth centertext'><i class='fa fa-user fa-2x'></i></p>";
    					echo "<p class=' textaligncenter'><b>" . ucfirst($recommend['name'])."</b></p>
    						</a>
    					<p class='textaligncenter textcolorlinkblue'>" . $stars ."</p>
    					</div>
    				";

    			}
			}
			else echo false;
		}
	}

	public function getrecommendedby()
	{
		$this->render = 0;
		if($_POST)
		{
			$this->render = 0;

			$page =1;
			if($_POST['page']) $page = $_POST['page'];
			$id = $_POST['id'];
			$perPage = 6;
			$result  = $this->Professionals->recommendedby($id, $page, $perPage);

			if(!empty($result))
			{
				echo '<div class ="item ';
		    if($page == 1) echo 'active';
		    echo' ">';
		    foreach ($result as $recommend)
  			{
  				if($recommend['usertype'] == 2) $usertypename = 'ngo';
  				else if($recommend['usertype'] == 3) $usertypename = 'lawyers';
  				else if($recommend['usertype'] == 4) $usertypename = 'doctors';
  				else if($recommend['usertype'] == 5) $usertypename = 'charteredaccountants';

  				$rate = ($recommend['rate'] != null) ? $recommend['rate'] : 0;
  				$starempty = '<i class="fa fa-star-o" aria-hidden="true" ></i> ';
  				$starhalf = '<i class="fa fa-star-half-empty" aria-hidden="true"></i> ';
  				$starfull = '<i class="fa fa-star" aria-hidden="true"></i> ';
  				$ratenum = explode('.', $rate);
  				$stars = str_repeat ( $starfull , $ratenum[0] );
  				if(isset($ratenum[1]) && $ratenum[1] != 0)
  				{
  					$stars .= $starhalf;
  					$stars .= str_repeat ( $starempty , (5-$ratenum[0]-1));
  				}
  				else
  				{
  					$stars .= str_repeat ( $starempty , (5-$rate));
  				}

  				echo "
  					<div class='col-sm-2 col-xs-4 marginbottom0'>
  						<a href=" .BASE_PATH."professionals/".$usertypename."/".$recommend['username']."> ";
  					if(!empty($recommend['profilepic'])) echo "<p class='textaligncenter'><img class='circleimg' src='" . BASE_PATH . $recommend['profilepic'] . "' alt='".$recommend['name']."'/></p>";
  					else echo "<p class='fullwidth centertext'><i class='fa fa-user fa-2x'></i></p>";
  					echo "<p class=' textaligncenter'><b>" . ucfirst($recommend['name'])."</b></p>
  						</a>
  					<p class='textaligncenter textcolorlinkblue'>" . $stars ."</p>
  					</div>
  				";

  			}
				echo "</div>";
			}
			else echo false;
		}
	}

	public function createdonateorder()
	{
		$this->render = 0;
		if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' && isset($_POST['donateamount']))
		{
			$filter_options = array(
					'options' => array( 'min_range' => 0)
			);
			$cost = filter_var( $_POST['donateamount'], FILTER_VALIDATE_INT ,$filter_options);
			$username = strip_tags($_POST['username']);


			if($cost != null)
			{
				$usernote = strip_tags($_POST['note']);
				$userid = (int)$_POST['userid'];
				$encryptkey = 'linkedaccountidFromForm_' . $userid;
				$linkedaccountid = Crypto::decrypt($_POST['lai'], $encryptkey , true);
				if(loggedin() == true)
				{
					$receipt =  $_SESSION['username'] . '_to_' . $username;

					$payment = new PaymentController('payment', 'createneworder');
					$order = $payment->createneworder($cost, $receipt,$username, $linkedaccountid, $usernote);

					if(array_key_exists('id',$order) && $order['id'] !== NULL)
					{
						if($returndata['donationid'] = $this->Professionals->createdonationorder($order['id'], $_SESSION['id'], $userid, $usernote))
						{
							$returndata['status'] = 'orderadded';
							$returndata['orderid'] = $order['id'];
							$returndata['loggedname'] = $_SESSION['name']? $_SESSION['name'] : $_SESSION['username'];
							$returndata['loggedemail'] = $_SESSION['email'];
							$returndata['paidto'] = $userid;
							echo json_encode($returndata);
						}
						else {
							$returndata['error'] = 'Please refersh the page and retry.';
							die(json_encode($returndata));
						}
					}
					else if (array_key_exists('error', $order) && $order['error'] !== NULL)
					{
						$returndata['error'] = $order['error']['description'];
						die(json_encode($returndata));
					}
					else {
						$returndata['error'] = 'Problems with Professional linked account, please contact us or the professional.';
					 die(json_encode($returndata));
					}
				}
				else
				{
					$_SESSION['donateOrderPending']['cost'] = $cost;
					$_SESSION['donateOrderPending']['username'] = $username;
					$_SESSION['donateOrderPending']['usernote'] = $usernote;
					$_SESSION['donateOrderPending']['userid'] = $userid;
					$_SESSION['donateOrderPending']['linkedaccountid'] = $linkedaccountid;
					$returndata['status'] = "loginfirst";
					die(json_encode($returndata));

				}
			}

		}
		else if (isset($_SESSION['donateOrderPending']) && loggedin())
		{
			$receipt = $_SESSION['username'] . '_to_' . $_SESSION['donateOrderPending']['username'];
			$payment = new PaymentController('payment', 'createneworder');
			$order = $payment->createneworder($_SESSION['donateOrderPending']['cost'], $receipt,$_SESSION['donateOrderPending']['username'],$_SESSION['donateOrderPending']['linkedaccountid'], $_SESSION['donateOrderPending']['usernote']);

			if(array_key_exists('id',$order) && $order['id'] !== NULL)
			{
				if($returndata['donationid'] = $this->Professionals->createdonationorder($order['id'], $_SESSION['id'], $_SESSION['donateOrderPending']['userid'], $_SESSION['donateOrderPending']['usernote']))
				{
					$returndata['status'] = 'orderadded';
					$returndata['orderid'] = $order['id'];
					$returndata['loggedname'] = $_SESSION['name']? $_SESSION['name'] : $_SESSION['username'];
					$returndata['loggedemail'] = $_SESSION['email'];
					$returndata['paidto'] = $_SESSION['donateOrderPending']['userid'];
					$returndata['success'] = 'donateOrderAfterLogin';
					unset($_SESSION['donateOrderPending']);

				}
				else {
					$returndata['error'] = 'Please refersh the page and retry.';
				}
			}
			else if (array_key_exists('error', $order) && $order['error'] !== NULL)
			{
				$returndata['error'] = $order['error']['description'];
			}
			else {
				$returndata['error'] = 'Problems with Professional linked account, please contact us or the professional.';
			}
			return $returndata;

		}
		else
		{
			$returndata['error'] = "Issue with Request, Please try again!";
			die(json_encode($returndata));
		}
	}





}
