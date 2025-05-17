<?php
	// error_reporting(0);
	/**
	* Controller class for default home page
	*/
	class HomeController extends Controller
	{
// 		protected $location;
// 		protected $locatequery;

// 		public function __construct($controller, $action)
// 		{
// 			if(defined('CITY')) $this->location['city'] = CITY;
// 			if(defined('STATE')) $this->location['state'] = STATE;
// 			if(defined('COUNTRY')) $this->location['country'] = COUNTRY;

// 			$this->locatequery ='';

// 			if(isset($this->location['area']) && $this->location['area'] != '')
// 			{
// 				$this->_bind[':area'] = $this->location['area'];
// 				$this->locatequery .= ' lower(sublocality) = lower(:area) AND';
// 			}

// 			if(isset($this->location['city']) && $this->location['city'] != '')
// 			{
// 				$this->_bind[':city'] = $this->location['city'];
// 				$this->locatequery .= ' lower(city) = lower(:city) AND';
// 			}
// 			if(isset($this->location['state']) && $this->location['state'] != '')
// 			{
// 				$this->_bind[':state'] = $this->location['state'];
// 				$this->locatequery .= ' lower(state) = lower(:state) AND';
// 			}
// 			if(isset($this->location['country']) && $this->location['country'] != '')
// 			{
// 				$this->_bind[':country'] = $this->location['country'];
// 				$this->locatequery .= ' lower(country) = lower(:country) AND';
// 			}

// 			if($this->locatequery != '')
// 			{
// 				$this->locatequery = substr($this->locatequery ,0,-4);
// 				$this->locatequery = ' AND (' . $this->locatequery . ') ';
// 			}

// 			parent::__construct($controller, $action);
// 			$this->set('location', $this->location);
// 		}

	public function index()
	{
		$this->doNotRenderHeader = 1;
	}


		// public function recentviews()
		// {
		// 	$location = '';
		// 	if(defined('CITY')) $location .= CITY . ' ' ;
		// 	if(defined('STATE')) $location .= STATE . ' ' ;
		// 	if(defined('COUNTRY')) $location .= COUNTRY;
		//
		//
		//
		//
		// 	$resultarray = $this->Home->getAll(1, 6, $location);
		// 	$overarticle = $overlawyers = $overngo = $overca = $overdoctors = 0;
		// 	$articles = $lawyers =  $ca =  $ngo =  $doctors = '';
		// 	$this->set('metaTitle', 'Find Chartered Accountant, Lawyer, Doctor, NGO | ' . WEBNAME);
		// 	$this->set('metaDescription', 'Find information, appointment and reviews of top lawyers, firms, chartered accountants, doctors, clinics, hospitals and NGOs near you. Connect with clients.');
		//
		//
		// 	if(!empty($resultarray))
		// 	{
		//
		//
		// 		foreach ($resultarray as $key => $result)
		// 		{
		// 			if($result['type'] == 0)
		// 			{
		// 				if($overarticle == 0) { $articles = '<div class="item active">'; $overarticle =1; }
		// 				$url = 	BASE_PATH . 'articles/title/' .$result['identity'] . '/' . urlencode(urlencode(str_replace(' ', '_', html_entity_decode($result['title']))));
		// 				$tag = explode(',', $result['focus']);
		// 		    	$articles .= $this->carouselthumbnail($url, $result['displayimg'], $result['title'], $tag[0]);
		// 			}
		//
		// 			if($result['type'] == 2)
		// 			{
		// 				if($overngo == 0) { $ngo = '<div class="item active">'; $overngo = 1; }
		// 				$url = 	BASE_PATH  . 'professionals/ngo/' . urlencode($result['identity']);
		// 		    	$ngo .= $this->carouselthumbnail($url, $result['displayimg'], $result['title'], $result['focus']);
		// 			}
		//
		// 			if($result['type'] == 3)
		// 			{
		// 				if($overlawyers == 0) { $lawyers = '<div class="item active">'; $overlawyers = 1; }
		// 				$url = 	BASE_PATH  . 'professionals/lawyers/' . urlencode($result['identity']);
		// 		    	$lawyers .= $this->carouselthumbnail($url, $result['displayimg'], $result['title'], $result['focus']);
		// 			}
		//
		// 			if($result['type'] == 4)
		// 			{
		// 				if($overdoctors == 0) { $doctors = '<div class="item active">'; $overdoctors = 1; }
		// 				$url = 	BASE_PATH  . 'professionals/doctors/' . urlencode($result['identity']);
		// 		    	$doctors .= $this->carouselthumbnail($url, $result['displayimg'], $result['title'], $result['focus']);
		// 			}
		//
		// 			if($result['type'] == 5)
		// 			{
		// 				if($overca == 0) { $ca = '<div class="item active">'; $overca = 1; }
		// 				$url = 	BASE_PATH  . 'professionals/charteredaccountants/' . urlencode($result['identity']);
		// 		    	$ca .= $this->carouselthumbnail($url, $result['displayimg'], $result['title'], $result['focus']);
		// 			}
		//
		//
		// 		}
		// 	}
		// 	if($articles !== '') { $articles .= '</div> <input type="hidden" class="articlenum" value="1" />'; $this->set('articles', $articles);}
		// 	if($ngo !== '') { $ngo .= '</div> <input type="hidden" class="ngonum" value="1" />'; $this->set('ngo', $ngo);}
		// 	if($lawyers !== '') { $lawyers .= '</div> <input type="hidden" class="lawyernum" value="1" />'; $this->set('lawyers', $lawyers); }
		// 	if($doctors !== '') { $doctors .= '</div> <input type="hidden" class="doctornum" value="1" />'; $this->set('doctors', $doctors); }
		// 	if($ca !== '') { $ca .= '</div> <input type="hidden" class="canum" value="1" />'; $this->set('ca', $ca); }
		//
		//
		//
		// }

		public function latestarticles()
		{
			$this->render = 0;
			if($_POST['page']) $page = $_POST['page']; else $page = 1;

			$result = $this->Home->getlatestarticles($page);
			if($result)
			{
				$returnhtml = '<div class ="item ';
			    if($page == 1) $returnhtml .= 'active';
			    $returnhtml .= ' ">';

			    foreach ($result as $article) {
			    	$url = 	BASE_PATH . 'articles/title/' .$article['articleid'] . '/' . urlencode(urlencode(str_replace(' ', '_',  html_entity_decode($article['title']))));
			    	$tag = explode(',', $article['tag']);
			    	$returnhtml .= $this->carouselthumbnail($url, $article['displayimg'], $article['title'], $tag[0]);
			    }
			    $returnhtml .= '</div>';
			    $returnhtml .= '<input type="hidden" class="articlenum" value="' . $page . '" />';
			    echo $returnhtml;
			}

		}

		public function topprof()
		{
			$this->render = 0;
			if($_POST)
			{
				if($_POST['page']) $page = $_POST['page']; else $page = 1;
				$type = $_POST['type'];
				$url = '';

				if($type == 5)
				{
					$url = BASE_PATH . 'professionals/charteredaccountants/';
					$pageinput = '<input type="hidden" class="canum" value="' . $page . '" />';
				}
				else if($type == 4)
				{
					$url = BASE_PATH . 'professionals/doctors/';
					$pageinput = '<input type="hidden" class="doctornum" value="' . $page . '" />';
				}
				else if($type == 3)
				{
					$url = BASE_PATH . 'professionals/lawyers/';
					$pageinput = '<input type="hidden" class="lawyernum" value="' . $page . '" />';
				}
				if($type == 2)
				{
					$url = BASE_PATH . 'professionals/ngo/';
					$pageinput = '<input type="hidden" class="ngonum" value="' . $page . '" />';
				}

				$result = $this->Home->gettopbyrole($type, $page, 6, $this->locatequery, $this->_bind);
				if($result)
				{
					$returnhtml = '<div class ="item ';
				    if($page == 1) $returnhtml .= 'active';
				    $returnhtml .= ' ">';

				    foreach ($result as $prof)
				    {
				    	$url .= urlencode($prof['username']);
				    	$returnhtml .= $this->carouselthumbnail($url, $prof['profilepic'], $prof['name'], $prof['focus']);
				    }
				    $returnhtml .= '</div>';
				    $returnhtml .= $pageinput;
				    echo $returnhtml;
				}
			}

		}


		public function carouselthumbnail($carouselhref, $carouselpic, $carouseltitle, $focus)
		{

		    $carousel = '<div class="col-xs-6 col-sm-4 col-md-2  col-xl-2">
					    <div class="thumbnail">
					    <a href="'. $carouselhref .'"><span class="thumbnaillink">'.$carouseltitle.'</span></a>';

		    if($carouselpic) $carousel .= '<img src="' . BASE_PATH . $carouselpic .'" alt="'.$carouseltitle.' " />';
			else $carousel .= '<div class=" imagecontainer"><i class="fa fa-paint-brush imagetext"></i></div>';

			$carousel .= ' <div class="caption">
					        <h3>' . $carouseltitle. '</h3>
					        <p class="smalltext greytext lightgreytopborder centertext">' . $focus . '</p>

					      </div>
					    </div>
					  </div>
				  ';

		    return $carousel;
		}

	}
