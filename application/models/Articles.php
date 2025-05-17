<?php

class Articles extends Model {

	function __construct()
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_NUM;
		$this->_table = 'userall';
		parent::__construct();

	}

	public function searchTag($tag)
	{
		$query = "SELECT focus, type FROM ". DB_SCHEMA .".focus WHERE lower(focus) LIKE lower(:focus) LIMIT 30";
		$this->_bind = array(':focus' => '%' . $tag . '%' );
		$row = $this->custom($query);
		return $row;

	}

	//select articledetails->>'tags'
	// 	from website.article
	// where jsonb_array_regex_like(articledetails->'tags', '^" . $tag . ".*');

	public function getArticle($page, $perPage = 10, $tags = '', $search = '')
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$sql = 'SELECT articleid, id, articledetails , '.DB_SCHEMA.'.likes(article) FROM ' . DB_SCHEMA . '.article ';

		$where='';
		if(isset($tags) && $tags != '')
		{

			foreach ($tags as $key => $value)
			{
				$value = str_replace('_', '&', $value);
				$value = strtolower($value);
				$where .= 'articledetails::jsonb @> \'{"tags" : ["'.$value.'"]}\'::jsonb OR ';
			}
			$where = substr($where,0,-4);
			$where = '(' . $where . ')';
		}

		if(isset($search) && $search != '')
		{
			$search = strip_tags(trim($search));
			$search = str_replace(' ', ' | ', $search);
			if($where) $where .= ' AND ';
			$where .= " ((to_tsvector('english', articledetails->>'title') @@ to_tsquery('" . $search ."')) AND  (to_tsvector('english', articledetails->>'story') @@ to_tsquery('".$search."'))) ";

		}
		if(isset($where) && $where != ''){$where = ' WHERE ' . $where;}

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$query = $sql . $where . ' ORDER BY articleid desc OFFSET ' . $start . ' LIMIT ' . $perPage . '';

		$result = $this->custom($query);
		return $result;

	}

	public function getArticleById($articleid, $title)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = " SELECT
					a.articleid, a.articledetails, username, profilepic, about, website.likesdislikes(a)

					FROM ".DB_SCHEMA.".article as a

					LEFT JOIN(
					SELECT id, username as username, usertype, profilepic as profilepic, about as about FROM ".DB_SCHEMA.".professional UNION select id, username as username, usertype, USERDETAILS->>'profilepic' AS profilepic, userdetails->>'about' AS about FROM ".DB_SCHEMA.".usernormal
					) AS u ON (u.id = a.id)

					WHERE a.articleid = :articleid and lower(a.articledetails->>'title') = lower(:title)
					;";
		$this->_bind = array(':articleid' => $articleid, ':title' => $title);
		$result = $this->custom($query);
		return $result;


	}

	// public function allvotes($articleid)
	// {
	// 	$this->_fetchtype = PDO::FETCH_ASSOC;
	// 	$query = "SELECT COUNT(CASE WHEN isLike is true THEN 1 END) AS likes,
	// 				COUNT(CASE WHEN isLike is false THEN 0 END) AS dislikes FROM ".DB_SCHEMA.".articlelike where articleid = :articleid";
	// 	$this->_bind = array(':articleid' => $articleid);
	// 	$result = $this->custom($query);
	// 	return $result;
	// }

	public function hasVoted($id, $articleid)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$query = "SELECT isLike from " . DB_SCHEMA . ".articlelike WHERE articleid = :articleid AND id = :id";
		$this->_bind = array(":articleid" => $articleid, "id" => $id);
		$result = $this->custom($query);
		return $result;

	}

	public function updateVote($islike, $articleid, $id)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA . ".articlelike SET islike = :islike WHERE articleid = :articleid and id = :id";
		$this->_bind = array(':islike' => $islike, ':articleid' => $articleid, ':id' => $id);
		$result = $this->custom($query);

		return $result;
	}

	public function addVote($islike, $articleid, $id)
	{
		$this->_fetch = 0;
		$query = "INSERT INTO " . DB_SCHEMA . ".articlelike (islike, articleid, id) values (:islike, :articleid, :id);";
		$this->_bind = array(':islike' => $islike, ':articleid' => $articleid, ':id' => $id);
		$result = $this->custom($query);

		return $result;
	}

	public function getarticlecomments($articleid, $page = 0, $perPage = 10)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$start = ($page)*$perPage;
		if ($start<0) $start = 0;
		$query = " SELECT
					c.commentid, c.parentid, c.createdat, c.modifiedat, c.comment,c.createdbyadmin,  username, profilepic, usertype
					FROM ".DB_SCHEMA.".articlecomment as c
					JOIN(
					SELECT id, username as username, profilepic as profilepic,usertype as usertype FROM " . DB_SCHEMA .".professional UNION select id, username as username, USERDETAILS->>'profilepic' AS profilepic, usertype as usertype FROM ".DB_SCHEMA.".usernormal
					) AS u ON (u.id = c.id)
					WHERE c.articleid = :articleid OFFSET ".$start." LIMIT ".$perPage.";";
		$this->_bind = array(':articleid' => $articleid);
		$result = $this->custom($query);
		return $result;

	}


	public function setComment($commentData)
	{
		$this->_fetch = 0;

		$query = "INSERT INTO " . DB_SCHEMA . ".articlecomment (comment, id, createdat, modifiedat, parentid, articleid, createdbyadmin) VALUES (:comment, :id, :createdat, :modifiedat, :parentid, :articleid, :createdbyadmin)";
		$this->_bind = array(':comment' => $commentData['comment'],
					':id' => $commentData['id'],
					':createdat'=> $commentData['createdat'],
					':modifiedat' => $commentData['modifiedat'],
					':parentid' => ($commentData['parentid'] ? $commentData['parentid'] : NULL),
					':articleid' => $commentData['articleid'],
					':createdbyadmin' => $commentData['createdbyadmin']);
		$result = $this->custom($query);
		return $result;
	}

	public function modifyComment($commentData)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA . ".articlecomment SET comment = :comment, modifiedat = :modifiedat WHERE commentid = :commentid";
		$this->_bind = array(':comment' => $commentData['comment'], ':modifiedat' => $commentData['modifiedat'], ':commentid' => $commentData['commentid']);
		$result = $this->custom($query);
		return $result;
	}

	public function removeComment($commentid)
	{
		$this->_fetch = 0;
		$query = "DELETE FROM " . DB_SCHEMA . ".articlecomment WHERE commentid = :commentid ";
		$this->_bind = array(':commentid' => $commentid);
		$result = $this->custom($query);
		return $result;
	}


	public function updateArticle($data, $articleid, $oldimage, $fileTemp)
	{
		$this->_fetch = 0;
		if($fileTemp)
		{
			$data['filepath'] ='images'. DS. 'article' . DS . 'article_' .$articleid  . '.png';
			file_put_contents($data['filepath'], $fileTemp);
			unlink($oldimage);
		}
		$data['modifiedat'] = date('Y-m-d H:i:s');
		$query = "UPDATE " .DB_SCHEMA . ".article SET articledetails = articledetails || :articledetails WHERE articleid =:articleid";
		$this->_bind = array(':articleid' => $articleid, ':articledetails' => json_encode($data));
		$result = $this->custom($query);
		return $result;


	}

	public function deleteArticle($articleid)
	{
		$this->_fetch = 0;
		$query = "DELETE FROM " . DB_SCHEMA . ".article WHERE articleid = :articleid";
		$this->_bind = array(':articleid' => $articleid);
		$result = $this->custom($query);
		return $result;
	}

	public function getSimilar($page, $perPage = 4, $tags = '', $articleid)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$sql = 'SELECT articleid, articledetails->>\'title\' as title, articledetails->>\'filepath\' as filepath FROM ' . DB_SCHEMA . '.article ';

		$where='';
		if(isset($tags) && $tags != '')
		{

			foreach ($tags as $key => $value)
			{
				$value = str_replace('_', '&', $value);
				$value = strtolower($value);
				$where .= 'articledetails::jsonb @> \'{"tags" : ["'.$value.'"]}\'::jsonb OR ';
			}
			$where = substr($where,0,-4);
		}
		if(isset($where) && $where != ''){$where = ' (' . $where  .') AND ';}

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$query = $sql . ' WHERE ' . $where . '  articleid <> :articleid ORDER BY articleid desc OFFSET ' . $start . ' LIMIT ' . $perPage . '';
		$this->_bind = array(':articleid' => $articleid);
		$result = $this->custom($query);
		return $result;

	}

	public function getArticleByUserid($id, $page, $perPage = 5)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$query = "SELECT articleid, articledetails->>'title' as title, website.likes(article) FROM " . DB_SCHEMA . ".article where id = :id OFFSET " . $start . " LIMIT " . $perPage;
		$this->_bind = array(':id' => $id);
		$result = $this->custom($query);
		return $result;

	}

	public function getLikedByUserid($id, $page, $perPage = 10)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$query = "SELECT article.articleid, article.articledetails->>'title' as title FROM " . DB_SCHEMA . ".articlelike left join " . DB_SCHEMA . ".article on article.articleid = articlelike.articleid where (articlelike.id = :id AND islike = true) OFFSET " . $start . " LIMIT " . $perPage;
		$this->_bind = array(':id' => $id);
		$result = $this->custom($query);
		return $result;

	}

	public function removeDisplayPic($articleid)
	{
		$this->_fetch = 0;
		$query = "UPDATE ". DB_SCHEMA . ".article SET articledetails = articledetails || '{\"filepath\": \"\"}'::jsonb where articleid =:articleid";
		$this->_bind[':articleid'] = $articleid;
		$result = $this->custom($query);
		return $result;
	}







}

//SELECT articleid, id, articledetails FROM website.article WHERE lower(articledetails->'tags') ? Lower('Animal') ORDER BY articleid desc OFFSET 0 LIMIT 10;
//select articleid, id, jsonb_pretty(articledetails) from website.article where to_tsvector('simple', articledetails->>'tags') @@ to_tsquery('chre:* || anim:*');
// select articleid, id, jsonb_pretty(articledetails)
// from website.article where articledetails::jsonb @> '{"tags" :["Animal"]}'::jsonb  OR articledetails::jsonb @> '{"tags" :["Children Welfare"]}'::jsonb;
//SELECT articleid, id, articledetails FROM website.article WHERE  (articledetails::jsonb @> '{"tags" : ["Children Welfare"]}'::jsonb OR articledetails::jsonb @> '{"tags" : ["animal, 2"]}'::jsonb) AND (to_tsvector('english', articledetails->>'title') @@ to_tsquery('tit:*') OR  to_tsvector('english', articledetails->>'story') @@ to_tsquery('rok:*'))  ORDER BY articleid desc OFFSET 0 LIMIT 10

// CREATE FUNCTION likesdislikes(website.article)
// returns record as
// $func$
//    SELECT COUNT(CASE WHEN isLike is true THEN 1 END) AS likes,
//   COUNT(CASE WHEN isLike is false THEN 0 END) AS dislikes FROM articlelike where articleid = $1.articleid
// $func$ LANGUAGE SQL STABLE;



// CREATE or replace FUNCTION likesdislikes(IN _articleid bigint, out likes bigint, out dislikes bigint)
// as
// $func$
//   SELECT COUNT(CASE WHEN isLike is true THEN 1 END) AS likes,
//   COUNT(CASE WHEN isLike is false THEN 0 END) AS dislikes FROM articlelike where articleid = _articleid;

// $func$ LANGUAGE SQL STABLE;
