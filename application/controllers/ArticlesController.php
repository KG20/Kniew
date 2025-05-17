<?php
error_reporting(0);

class ArticlesController extends Controller
{

	public function index()
	{
		$this->set('metaTitle', 'Read articles about law, society, accountancy, medicine | Kniew');
		$this->set('metaDescription', 'Explore and search for articles related to law, society, accountancy and medicine. Submit your own article.');
		if(!empty($_GET["page"]))
		{
			$this->render = 0;
			$page = $_GET["page"];

			$result = $this->Articles-> getArticle($page, 20, $_GET['tags'], $_POST['searcharticleinput']);
			$this->getArticleHtml($result, $page);


		}
		else
		{
			$page = 1;
			$result = $this->Articles-> getArticle($page, 10, $_GET['tags'], $_POST['searcharticleinput']);
			$this->set('article', $result);

		}

	}

	public function getArticleHtml($result, $page =0)
	{
		if(isset($result) && !empty($result))
		{
			echo '<div class ="pageloaded">';

			foreach ($result as $field => $value) {
				$details = json_decode($value['articledetails']);
				$details->title = html_entity_decode($details->title);
				$details->story = strip_tags(html_entity_decode($details->story));
				$title = urlencode(urlencode(str_replace(' ', '_', $details->title)));



				  echo '<div class="lazyload"><!--<div class="col-sm-6 col-md-4  col-xl-2">
				    <div class="thumbnail">
				    <a href="'.BASE_PATH.'articles/title/'.$value['articleid'].'/'.$title.'"><span class="thumbnaillink">'.$details->title.'</span></a>
				    ';
				   if($details->filepath){
							  echo '<img src= "'. BASE_PATH .$details->filepath .'" alt="'.$details->title.'"/>';
							 } else {
								echo '<div class=" imagecontainer"><i class="fa fa-pencil imagetext"></i></div>';
							 }
				    echo '<i class="bottomoverlay xsmalltext label label-success">' . $value['likes'] .'</i>';




				     echo '<div class="caption">
				        <h3>' . $details->title . '</h3>
				        <p class="card-description">'.$details->story.'</p>
				        <p class ="tags">';
				        $this->gettags($details->tags);

				    echo '</p>
				      </div>
				    </div>
				  </div>--></div>';
				echo '<input type="hidden" class="pagenum" value="' . $page . '" />';


			  }
			  echo "</div>";
			}
			else
				echo null;
}

	public function tagsearch()
	{
		$this->render = 0;
		$tag = strip_tags(trim($_POST['tagsearch']));
		$searchquery = $this->Articles->searchTag($tag);
		if(empty($searchquery))
		{
			echo '<div class="show" align="left">

				<span class="name error">No tags found!</span> <br/>

			</div>';
		}
		else
		{
			echo '<div class="show">';

			$this->gettags($searchquery);


			echo	'<p>Click on the tag to select it.</p></div>';

		}
	}


	public function gettags($tagsarray)
	{
		$this->render = 0;
		foreach ($tagsarray as $tagfull)
	   {

	   	if (is_array($tagfull))
   		{
   			$tagresult = $tagfull[0] . ',' . $tagfull[1];
   			$tagurl = str_replace('&', '_', $tagresult);
   			$tag = $tagfull;
   		}
   		else
		{
			$tag = array_map('trim', explode(',', $tagfull));
		   	$tag[0] = $tag[0] ? $tag[0] : $tagfull;
		   	$tagurl = str_replace('&', '_', $tagfull);
	    }



   		if($tag[1] == 2) $tagclass = 'label-success';
	   	elseif($tag[1] == 3) $tagclass = 'label-primary';
	   	elseif($tag[1] == 4) $tagclass = 'label-danger';
	   	elseif($tag[1] == 5) $tagclass = 'label-warning';
	   	else $tagclass = 'label-default';

	   	if($_GET['tags'])
   		{

   			if(array_search($tagurl, $_GET['tags']))
			{
				$get =[];
   				foreach ($_GET['tags'] as $key => $value) {
   					$get[$key] = urlencode(urlencode($value));
   				}
				$tagurl =  '&tags[]=' . implode('&tags[]=', $get);
				// else $tagurl = '$tags[]=' . $get;
			}
	   		else
   			{
   				$get =[];
   				foreach ($_GET['tags'] as $key => $value) {
   					$get[$key] = urlencode(urlencode($value));
   				}
   				// print_r($get);
   				$tagurl = '&tags[]=' . implode('&tags[]=', $get) . '&tags[]=' . urlencode(urlencode($tagurl));
   				// else  $tagurl = '&tags[]=' . $get . '&tags[]=' . urlencode(urlencode($tagurl));
   			}
   		}
	   	else $tagurl = '&tags[]=' . urlencode(urlencode($tagurl));


	   	echo ' <a href="'.BASE_PATH . 'articles'. $tagurl .'" class="label '.$tagclass.'" role="button">'. $tag[0] .'</a>';
	   }

	}


	public function title()
	{
		$get = explode('/', $_GET['url']);

		if(!empty($get[2]) && !empty($get[3]))
		{
			$articleid= $get[2];
			$title = htmlspecialchars(str_replace(array('_','-'), ' ', strip_tags(trim($get[3]))));
			$article = $this->Articles->getArticleById($articleid, $title);
			$this->set('articlebytitle', $article);
			$this->votedAlready($article['articleid']);
			$this->set('metaDescription', substr(strip_tags(json_decode($article['articledetails'])->story), 0, 150));
		}
		else
		{
			nopage();
		}

	}

	public function likedislike()
	{
		$this->render = 0;
		if($_POST)
		{

			$votetype = trim($_POST["vote"]);
			$articleid = filter_var(trim($_POST["articleid"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

			switch ($votetype) {
				case 'up':
					$voted = $this->votedAlready($articleid);
					if(isset($voted['islike']))
					{
						if($voted['islike'] != 1)
						{
							$r = $this->Articles->updateVote(TRUE, $articleid, $_SESSION['id']);
							echo json_encode("Modified other");

						}
						else
						{
							echo json_encode("Already voted!");
						}

					}
					else
					{
						$r = $this->Articles->addVote(TRUE, $articleid, $_SESSION['id']);
						echo $r;
					}
					break;

				case 'down':
					$voted = $this->votedAlready($articleid);
					if(isset($voted['islike']))
					{
						if($voted['islike'] == 1)
						{
							$r = $this->Articles->updateVote(0, $articleid, $_SESSION['id']);
							echo json_encode("Modified other");

						}
						else
						{
							echo json_encode("Already voted!");
						}


					}
					else
					{
						$r = $this->Articles->addVote(0, $articleid, $_SESSION['id']);
						echo $r;
					}
					break;
				// case 'fetch':
				// 	$votes = $this->Articles->allvotes($articleid);
				// 	echo json_encode($votes);
				// 	break;
			}

		}

	}

	public function votedAlready($articleid)
	{
		if(isset($_SESSION['id']))
		{
			$voted = $this->Articles->hasVoted($_SESSION['id'], $articleid);
			$this->set('votedAlready', $voted);
			return $voted;
		}


	}


	public function getcomments()
	{
		$this->render = 0;
		$username = $_SESSION['username'];
		$id = $_SESSION['id'];
		if($_POST)
		{
			$articleid = filter_var(trim($_POST["articleid"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
			$page = $_POST['page'];
			if(!$page) $page = 0;
			if($result = $this->Articles->getarticlecomments($articleid, $page))
			{

				foreach ($result as $key => $value)
				{
					if($value['profilepic'])
					{
						$value['profilepic'] = BASE_PATH . $value['profilepic'];
					}
					if($value['usertype'] == 2 || $value['usertype'] == 3 || $value['usertype'] == 4 || $value['usertype'] == 5)
					{
						$typename='';
						if($value['usertype'] == 3) $typename = 'Lawyers';
						elseif($value['usertype'] == 4) $typename = 'Doctors';
						else if($value['usertype'] == 5) $typename = 'Chartered Accountants';
						else if($value['usertype'] == 2) $typename = 'ngo';

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
			$articleid = filter_var(trim($_POST["articleid"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
			$commentJSON = $_POST["commentJSON"];
			if(isAdmin($id)) $commentJSON['createdbyadmin'] = 1; else $commentJSON['createdbyadmin'] = null;
			$commentJSON['id'] = $id;
			$commentJSON['articleid'] = $articleid;
			$commentJSON['comment'] = htmlspecialchars(strip_tags(trim($commentJSON['comment'])));
			$result = $this->Articles->setComment($commentJSON);
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
			$articleid = filter_var(trim($_POST["articleid"]),FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
			$commentPUT = $_POST['commentPUT'];
			$commentPUT['comment'] = htmlspecialchars(strip_tags(trim($commentPUT['comment'])));
			$commentPUT['articleid'] = $articleid;
			$commentPUT['modifiedat'] = date('Y-m-d\TH:i:s\Z' , $commentPUT['modified']/1000);
			$result = $this->Articles->modifyComment($commentPUT);
			echo $result;

		}

	}

	public function deletecomment()
	{
		$this->render = 0;

		if($_POST)
		{
			$commentdel = $_POST['commentDel'];
			$result = $this->Articles->removeComment($commentdel['commentid']);
			echo $result;

		}

	}

	public function editarticletitlevalidate()
	{
		$this->render = 0;
		if($_POST)
		{
			$title = htmlspecialchars(strip_tags(trim($_POST['title'])));
			if($title != htmlspecialchars(strip_tags(trim($_POST['oldtitle']))))
			{
				$get = new Getdata();
				$result = $get->titleExist($title);
				if($result)
				{
					echo json_encode("The title already exists, please try another.");

				}
				else echo "true";
			}
			else echo "true";
		}


	}

	public function editarticleform()
	{

		$this->render = 0;

		if($_POST)
		{
			$title =  htmlspecialchars(strip_tags(trim($_POST['title'])));
			if($title !=  htmlspecialchars(strip_tags(trim($_POST['oldtitle']))))
			{
				$send['title'] = $title;

			}

			if(isset($_POST['image-data']) && $_POST['image-data'] != null)
			{
				$img = $_POST['image-data'];
			    $img = str_replace('data:image/png;base64,', '', $img);
			    $img = str_replace(' ', '+', $img);
			    $data = base64_decode($img);
			}

			$send['story'] = htmlentities(trim($_POST['story']));
			echo ($this->Articles->updateArticle($send, $_POST['articleid'], $_POST['oldimageurl'], $data));
		}

	}

	public function deletearticleform()
	{
		$this->render = 0;

		echo ($this->Articles->deleteArticle($_POST['articleid']));
	}

	public function getsimilararticles()
	{
		$this->render = 0;
		$tags = array_slice(json_decode($_POST['tags']), 0, 3);
		$page =1;
		if($_POST['page']) $page = $_POST['page'];
		$articleid = $_POST['articleid'];
		$getsimilar = $this->Articles->getSimilar($page, 4, $tags, $articleid);
		if(empty($getsimilar)){
			$tags2 = array_slice(json_decode($_POST['tags']), 3, 3);
			$getsimilar = $this->Articles->getSimilar($page, 4, $tags2, $articleid);

		}



	    if($getsimilar)
	    {
	    	echo '<div class ="item ';
		    if($page == 1) echo 'active';
		    echo' ">';


		    foreach ($getsimilar as $result) {
			    $result['title'] = html_entity_decode($result['title']);

			    $title = urlencode(urlencode(str_replace(' ', '-', $result['title'])));

				echo '<div class="col-xs-6 col-sm-3 col-md-2  col-xl-2">
					    <div class="thumbnail">
					    <a href="'.BASE_PATH.'articles/title/'.$result['articleid'].'/'.$title.'"><span class="thumbnaillink">'.$result['title'].'</span></a>';
			    if($result['filepath']){
							  echo '<img src= "'. BASE_PATH .$result['filepath'] .'" alt="'.$result['title'].'" />';
							 } else {
								echo '<div class=" imagecontainer"><i class="fa fa-pencil imagetext"></i></div>';
							 }

					echo '<div class="caption">
					        <h3>' . $result['title']. '</h3>

					      </div>
					    </div>
					  </div>';
			}
			echo '</div>';
		}
		else echo false;


	}


	// articles by user
	public function articleby()
	{
		$this->render = 0;
		if($_POST)
		{
			$id = $_POST['articleby'];
			$page = 1;
			if($_POST['page']) $page = $_POST["page"];
			if($_POST['perpage']) $perpage = $_POST['perpage']; else $perpage = 5;

			$result = $this->Articles->getArticleByUserid($id, $page, $perpage);

			if($result)
			{
				foreach ($result as $key => $value)
				{
					$title = html_entity_decode($value['title']);
					$titleurl = urlencode(urlencode(str_replace(' ', '-', $title)));
					echo "<li class='margin2per'><a href=" .BASE_PATH."articles/title/".$value['articleid']."/".$titleurl.">".ucfirst($title)."</a> <i class= ' xsmalltext badge '>" . $value['likes'] ."</i> </li>";
				}
			}
			else echo false;

		}

	}

	public function likedarticles()
	{
		$this->render = 0;
		if($_POST)
		{
			$id = $_POST['id'];
			$page = 1;
			if($_POST['page']) $page = $_POST["page"];
			if($_POST['perpage']) $perpage = $_POST['perpage']; else $perpage = 10;


			$result = $this->Articles->getLikedByUserid($id, $page, $perpage);

			if($result)
			{
				foreach ($result as $key => $value)
				{
					$title = html_entity_decode($value['title']);
					$titleurl = urlencode(urlencode(str_replace(' ', '-', $title)));
					echo "<li><a href=" .BASE_PATH."articles/title/".$value['articleid']."/".$titleurl.">".ucfirst($title)."</a></li>";
				}
			}
			else echo false;

		}

	}

	public function deletedisplaypic()
	{
		$this->render = 0;
		$articleid = filter_var($_POST['articleid'], FILTER_VALIDATE_INT);
		echo $this->Articles->removeDisplayPic($articleid);
	}






}
