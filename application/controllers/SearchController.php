<?php

// error_reporting(0);
/**
*
*/
class SearchController extends Controller
{

	public function index()
	{
		$this->set('metaTitle', 'Search for professionals, users and articles | Kniew');
		$this->set('metaDescription', 'Search for Lawyers, Law firms, Chartered Accountants, NGOs, Doctors, Clinics, hospitals and articles by name, specialisation, rating and location.');

		if(count($_POST) > 1)
		{
			$this->render = 0;
		}
		if($_POST && strlen(trim($_POST['searchbarinput'])) >= 3)
		{
			$search = strip_tags(trim($_POST['searchbarinput']));
			$search = str_replace(' ', ' & ', $search);
			$location = strip_tags(trim( preg_replace('/[^a-zA-Z]+/', ' ', $_POST['location'])));
			$type = (int)$_POST['category'];
			if(isset($_POST['focus'])) $focus = implode(' ', $_POST['focus']);


			$fields = 'id, title, focus, type, username, location';

			if(isset($_GET["page"]))
			{
				$this->render = 0;
				$page = $_GET["page"];
				$result = $this->Search->searchall($fields, $search, $location, $type, $focus, $page);
				if(isset($result) && !empty($result) )
				{
					$searchcards = $this->searchHtml($result);
					$searchcards .=  '<input type="hidden" class="pagenum" value="' . $page . '" />';
					echo $searchcards;
				}
				else echo false;

			}
			else
			{
				$page = 1;
				$result = $this->Search->searchall($fields, $search, $location, $type, $focus, $page);
				$searchcards = $this->searchHtml($result);
				$searchcards .=  '<input type="hidden" class="pagenum" value="' . $page . '" />';
				$this->set('searchcards', $searchcards);
				if($_POST['byajax'] == true)
				{
					$this->render = 0;
					echo ($searchcards);

				}
			}
		}

		if(isset($_GET["page"]))
		{
			$this->render = 0;
		}
	}

	public function searchHtml($result)
	{
		if(!empty($result))
		{
			$htmldata = '<div class ="pageloaded">';
			foreach ($result as $key => $searchresult)
			{
				if($searchresult['type'] == 0)
				{
					$searchresult['focus'] = preg_replace('/[^a-zA-Z,]+/', '', $searchresult['focus']);
					$title = urlencode(urlencode(str_replace(' ', '_', $searchresult['title'])));
					$url = BASE_PATH . 'articles/title/' . $searchresult['id'] . '/' . $title;
					$typename = 'Article';
				}
				elseif ($searchresult['type'] == 1) {$typename = 'User'; $url = BASE_PATH . 'user/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 2)
					{$typename = 'Non-profit'; $url = BASE_PATH . 'professionals/ngo/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 3)
					{ $typename = 'Lawyer'; $url = BASE_PATH . 'professionals/lawyers/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 4)
					{ $typename = 'Doctor'; $url = BASE_PATH . 'professionals/doctors/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 5)
					{$typename = 'Chartered Account'; $url = BASE_PATH . 'professionals/charteredaccountants/' . urlencode($searchresult['username']);}
				if($searchresult['type'] != 1)
				{
					$searchresult['focus'] = preg_replace('/,+/', '<b> | </b>', $searchresult['focus']);
				}

				 $htmldata .=  '<div class="lazyload"><!--
					    <div class="thumbnail searchthumbnail">
					    <a href="'.$url.'"><span class="thumbnaillink">'.($searchresult['title'] ? ucwords($searchresult['title']) : $searchresult['username']).'</span></a>
					    <h3 class="title">'.($searchresult['title'] ? ucwords($searchresult['title']) : $searchresult['username']).' </h3>';
			    if(!empty($searchresult['location']))
						$htmldata .= '<p class="detailsLabel "><i class="fa fa-map-marker"></i> ' . $searchresult['location'] .'</p>';

				$htmldata .=' <p class="detailsLabel smalltext">' . $searchresult['focus'] . '</p> <p class="detailsLabel xsmalltext">';
					    if($searchresult['type'] == 0) $htmldata .= "Article by " . $searchresult['username'];
						else $htmldata .= $searchresult['username'] . ' (' . $typename . ')' ;

				$htmldata .=   '</p>
					  </div>--></div>';
			}
			$htmldata .= "</div>";
			return $htmldata;
		}

	}


	public function searchinput()
	{
		$this->render = 0;
		if(strlen(count($_POST['searchbarinput'])) >= 3)
		{

			$search = strip_tags(trim($_POST['searchbarinput']));
			$search = str_replace(' ', ' & ', $search);
			$location = strip_tags(trim( preg_replace('/[^a-zA-Z]+/', ' ', $_POST['location'])));
			$type = (int)$_POST['category'];
			$focus = implode(' ', $_POST['focus']);
		}
		if(!isset($_POST['location']))
		{
			if(defined('CITY')) $location = CITY . ' '; else $location = ' ';
			if(defined('STATE')) $location .= STATE . ' '; else $location = ' ';
			if(defined('COUNTRY')) $location .= COUNTRY; else $location =' ';
		}
		$fields = ' id, title, username, type ';


		$searchquery = $this->Search->searchall($fields, $search, $location, $type, $focus, 1, 10);
		$htmlresponse = '';
		if(empty($searchquery))
		{
			$htmlresponse = '<div class="show" align="left">

				<span class="error">No Result found!</span> <br/>

			</div>';
		}
		else
		{
			foreach ($searchquery as $searchresult)
			{
				$typename ='';
				if($searchresult['type'] == 0)
				{
					$title = urlencode(urlencode(str_replace(' ', '_', $searchresult['title'])));
					$url = BASE_PATH . 'articles/title/' . $searchresult['id'] . '/' . $title;
					$typename = 'Article';
				}
				elseif ($searchresult['type'] == 1) {$typename = 'User'; $url = BASE_PATH . 'user/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 2)
					{$typename = 'Non-profit'; $url = BASE_PATH . 'professionals/ngo/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 3)
					{ $typename = 'Lawyer'; $url = BASE_PATH . 'professionals/lawyers/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 4)
					{ $typename = 'Doctor'; $url = BASE_PATH . 'professionals/doctors/' . urlencode($searchresult['username']);}
				elseif ($searchresult['type'] == 5)
					{$typename = 'Chartered Account'; $url = BASE_PATH . 'professionals/charteredaccountants/' . urlencode($searchresult['username']);}


				$htmlresponse .= '<a href = "'. $url .'" class="show">

					<h2>' . ($searchresult['title'] ? ucwords($searchresult['title']) : $searchresult['username']) . ' </h2>
					<p  class="detailsLabel xsmalltext">' ;
					if($searchresult['type'] == 0) $htmlresponse .= "Article by " . $searchresult['username'];
					else $htmlresponse .= $searchresult['username'] . ' (' . $typename . ')' ;
					$htmlresponse .= '</p>';

			}

		}
		echo $htmlresponse;

	}


	public function getspecialisation()
	{
		$this->render = 0;
		$type = null;
		if($_POST['type']) $type = $_POST['type'];
		$prof = new Professionals();
		if($type == 0) $type == null;

		$focusall = $prof->getFocusByType($type);
		$parentid = null;
		$hadchild = null;

		foreach ($focusall as $key => $focus)
		{

			if($focus['childid'] != NULL)
			{
				if($parentid != $focus['mainid'])
				{
					$hadchild = 1;
					echo '<p class="childgroup">';
					echo ' <label class="checkbox parentfocus">
				            <input type="checkbox" name="focus[]" value="'.$focus['mainfocus'].'" > '.$focus['mainfocus'].'
				        </label>';
				}
				echo ' <label class="checkbox childfocus">
				            <input type="checkbox" name="focus[]" value="'.$focus['childfocus'].'" > '.$focus['childfocus'].'
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
				            <input type="checkbox" name="focus[]" value="'.$focus['mainfocus'].'" > '.$focus['mainfocus'].'
				        </label>';
			}

			$parentid = $focus['mainid'];

		}
	}




}














// DROP MATERIALIZED VIEW SEARCH_INDEX;
// CREATE MATERIALIZED VIEW search_index AS
// SELECT article.articleid as id, article.articledetails->>'title'as title, article.articledetails->>'tags' as focus, 0 as type, userall.username as username, null as location,
// setweight(to_tsvector('english', coalesce(article.articledetails->>'title','')), 'A') || setweight(to_tsvector('english', coalesce(article.articledetails->>'story','')), 'D') ||
// setweight(to_tsvector('english', userall.username), 'C') ||
// setweight(to_tsvector('english', coalesce(string_agg(article.articledetails->>'tags', ' '))), 'B') as document
// from website.article join website.userall on article.id = userall.id group by article.articleid, userall.id

// UNION

// SELECT professional.id as id, professional.name as title, array_to_string(array_agg(focus.focus), ' , ') as focus, professional.usertype as type, professional.username as username, professional.formattedaddress as location,
// setweight(to_tsvector('english', coalesce(professional.name,'')), 'A') || setweight(to_tsvector('english', coalesce(professional.about,'')), 'D') ||
// setweight(to_tsvector('english', coalesce(professional.formattedaddress,'')), 'B')  ||
// setweight(to_tsvector('english', professional.username), 'C') ||
// setweight(to_tsvector('english', coalesce(string_agg(focus.focus, ' '))), 'B') as document
// FROM website.professional left JOIN website.focus on (focus.focusid = mainfocus or focus.focusid = any(otherfocus)) GROUP BY PROFESSIONAL.ID

// UNION

// SELECT usernormal.id as id, usernormal.userdetails->>'name' as title, NULL as focus, usernormal.usertype as type, usernormal.username as username, usernormal.userdetails->>'address' as location,
// setweight(to_tsvector('english', coalesce(usernormal.username,'')), 'B') ||
// setweight(to_tsvector('english', coalesce(usernormal.userdetails->>'name','')), 'C') ||
// setweight(to_tsvector('english', coalesce(usernormal.userdetails->>'address','')), 'B') as document
// FROM website.usernormal GROUP BY usernormal.id
// ;
