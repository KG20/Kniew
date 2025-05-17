<?php

/**
*
*/
class Professionals extends Model
{

	function __construct()
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$this->_table = 'userall';
		parent::__construct();

	}

	public function getProfessional($usertype, $name ='', $location='', $focus = [], $includesub = 1, $includeonlyfirm = 0, $jurisdiction =[], $isfree = false, $onlinesession =false, $language =[], $orderby ='rate', $page, $perPage = 10)
	{
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$joinquery = '';
		if(isset($focus) && is_int($focus[0])) $joinquery = '';
		if(isset($focus) && is_string($focus[0])) $joinquery = '';
		$sql = "SELECT id, username, name, profilepic, about, formattedaddress, workday, professional.rate as rating, professional.noofrating as noofrating, workat, array_agg(focus.focus) as allfocus FROM " . DB_SCHEMA . ".professional  LEFT JOIN ".DB_SCHEMA.".focus on  (focus.focusid = mainfocus or focus.focusid = any(otherfocus)) WHERE usertype = :usertype AND isauthentic IS NOT FALSE ";
		$this->_bind = array(':usertype' => (int)$usertype);
		$locate = '';
		$focusquery = '';
		$firmquery = '';
		$jurisdictionquery = '';
		$isfreequery ='';
		$onlinesessionquery = '';
		$languagequery = '';
		$namequery ='';

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		if($orderby == 'since') $arrange = 'ASC'; else $arrange = 'DESC';
		$orderby = 'professional.' . $orderby;

		if(isset($name) && $name != '')
		{
			$this->_bind[':name'] = '%' . strip_tags(strtolower(trim($name))) . '%';
			$namequery .= ' AND lower(name) LIKE :name ';
			// 'patti uttar' OPERATOR(website.<%) formattedaddress
		}

		if(isset($location) && $location != '')
		{
			$this->_bind[':location'] = $location;
			$locate = ' AND :location OPERATOR(website.<%) formattedaddress ';
			// 'patti uttar' OPERATOR(website.<%) formattedaddress
		}

		// if($locate != '')
		// {
		// 	$locate = substr($locate ,0,-4);
		// 	$locate = ' AND (' . $locate . ') ';
		// }
		if(isset($focus) && !empty($focus))
		{
			if(is_numeric($focus[0]))
			{
				if(isset($includesub) && $includesub == 1)
				{
					if(count($focus) > 1)
					{

						$focusquery = ' mainfocus IN ('.implode(', ',$focus).')  OR ARRAY['.implode(', ',$focus).']::BIGINT[] && otherfocus ';
					}
					else
					{
						$focusquery = ' mainfocus = :focus OR :focus = ANY(otherfocus) ';
						$this->_bind[':focus'] = (int)$focus[0];
					}

				}
				else
				{
					if(count($focus) > 1)
					{
						$focusquery = ' mainfocus IN ('.implode(', ',$focus).') ';
						// $this->_bind[':focus'] = implode(', ',$focus);
					}
					else
					{
						$focusquery = ' mainfocus = :focus ';
						$this->_bind[':focus'] = (int)$focus[0];
					}
				}
			}
			else
			{
				$newfunc = create_function('$value', 'return ucwords(trim($value));');
				$focus = array_map($newfunc, $focus);
				if(isset($includesub) && $includesub == 1)
				{

					$focusquery = " mainfocus = ANY(SELECT focusid from " .DB_SCHEMA .".focus where focus in ('".implode("', '",$focus)."')  OR otherfocus && (SELECT array_agg(focusid) from " .DB_SCHEMA .".focus where focus in ('".implode(", '",$focus)."'))) ";

				}
				else
				{
					$focusquery = ' mainfocus = ANY(SELECT focusid from ' .DB_SCHEMA .".focus where focus in ('".implode("', '",$focus)."')) ";
				}
			}


		}

		if(isset($includeonlyfirm) && $includeonlyfirm == 1)
		{
			$firmquery = " AND workat = '0' ";
		}

		if(isset($jurisdiction) && !empty($jurisdiction))
		{
			$jurisdictionquery = " AND ('{" . implode(', ', array_map('ucwords', $jurisdiction)) ."}' && jurisdiction) ";
		}

		if(isset($language) && !empty($language))
		{
			$languagequery = " AND ('{" . implode(', ', array_map('ucwords', $language)) ."}' && language) ";
		}

		if(isset($isfree) && $isfree == TRUE)
		{
			$isfreequery = " AND isfree = TRUE ";
		}

		if(isset($onlinesession) && $onlinesession == TRUE)
		{
			$onlinesessionquery = " AND onlinesession = TRUE ";
		}



		if($focusquery != '') $focusquery = ' AND (' .$focusquery. ') ';
		$query = $sql . $namequery . $locate . $focusquery . $firmquery . $jurisdictionquery . $isfreequery . $onlinesessionquery . $languagequery . ' GROUP BY professional.id ORDER BY ' . $orderby . ' ' . $arrange .' OFFSET ' . $start . ' LIMIT ' . $perPage . '';


		$result = $this->custom($query);

		return $result;

	}

	public function getAllFocus()
	{
		$query = "SELECT parent.type,parent.focusid AS mainid, child.focusid AS childid, parent.focus as mainfocus, child.focus As childfocus FROM  " . DB_SCHEMA. ".focus As parent LEFT  JOIN ".DB_SCHEMA.".focus As child  ON child.parentid = parent.focusid WHERE parent.parentid is NULL AND parent.type <> 0 order by type, mainfocus;";
		$result = $this->custom($query);
		return $result;
	}

	public function getFocusByType($type)
	{
		$query = "SELECT parent.focusid AS mainid, child.focusid AS childid, parent.focus as mainfocus, child.focus As childfocus FROM  " . DB_SCHEMA. ".focus As parent LEFT  JOIN ".DB_SCHEMA.".focus As child  ON child.parentid = parent.focusid WHERE parent.parentid is NULL ";
		if($type != null && $type != 'null' && $type !=0)
		{
			$query .= " and parent.type = :type  ";
			$this->_bind = array(':type' => $type);
		}
		$query .= " ORDER BY mainfocus;";

		$result = $this->custom($query);
		return $result;
	}

	public function getDistinctLanguages()
	{
		$this->_fetchtype = PDO::FETCH_NUM;
		$query = "SELECT DISTINCT lower(UNNEST(language::varchar[])) from ". DB_SCHEMA.".professional ORDER BY 1;";
		$result = $this->custom($query);
		return $result;

	}

	public function searchLocation($location)
	{
		$query = "SELECT formattedaddress FROM " . DB_SCHEMA . ".professional WHERE :location OPERATOR(".DB_SCHEMA.".<%) formattedaddress  LIMIT 10"; //change to union??
		$this->_bind = array(':location' => $location );
		$row = $this->custom($query);
		return $row;
	}

	// public function searchArea($area)
	// {
	// 	$query = "SELECT sublocality, city, state, country FROM " . DB_SCHEMA . ".professional WHERE lower(sublocality) LIKE lower(:x) LIMIT 10"; //change to union??
	// 	$this->_bind = array(':x' => '%' . $area . '%' );
	// 	$row = $this->custom($query);
	// 	return $row;
	// }

	// public function searchCity($city)
	// {
	// 	$query = "SELECT city, state, country FROM " . DB_SCHEMA . ".professional WHERE lower(city) LIKE lower(:x) LIMIT 10"; //change to union??
	// 	$this->_bind = array(':x' => '%' . $city . '%' );
	// 	$row = $this->custom($query);
	// 	return $row;
	// }
	// public function searchState($state)
	// {
	// 	$query = "SELECT state, country FROM " . DB_SCHEMA . ".professional WHERE lower(state) LIKE lower(:x) LIMIT 10"; //change to union??
	// 	$this->_bind = array(':x' => '%' . $state . '%' );
	// 	$row = $this->custom($query);
	// 	return $row;
	// }
	// public function searchCountry($country)
	// {
	// 	$query = "SELECT country FROM " . DB_SCHEMA . ".professional WHERE lower(country) LIKE lower(:x) LIMIT 10"; //change to union??
	// 	$this->_bind = array(':x' => '%' . $country . '%' );
	// 	$row = $this->custom($query);
	// 	return $row;
	// }


	//memberpage(professional)
	public function getProfessionalFromUsername($username)
	{
		$this->_fetch = fetch;
		$query = "SELECT professional.id, professional.authuser, professional.reference, professional.joiningdate , professional.emailverified, professional.email, professional.name, professional.profilepic, professional.since, professional.about,  professional.phone, professional.verificationid, professional.formattedaddress, professional.onlinesession,professional.showcontactdetails, professional.workday, professional.breaktime, professional.mainfocus as mf_id, professional.otherfocus as of_id, professional.rate as rating, professional.noofrating as noofrating, array_agg(o.focus) as otherfocus, m.focus as mainfocus, professional.workat, professional.linkedaccountid,professional.isauthentic, employer.name as employername, employer.username as employerusername, app.cost, app.sessionduration, app.weeklyholiday, app.blockfutureappointment,app.weeklyappointment FROM " . DB_SCHEMA . ".professional  LEFT JOIN ".DB_SCHEMA.".focus as o on  o.focusid = any(otherfocus) LEFT JOIN " . DB_SCHEMA .".focus as m on m.focusid = mainfocus LEFT JOIN ".DB_SCHEMA.".appointmentsetting as app ON professional.id = app.professionalid LEFT JOIN ". DB_SCHEMA .".professional as employer on professional.workat = employer.id::varchar WHERE lower(professional.username) = lower(:username) GROUP BY professional.id, m.focus,  app.cost, app.sessionduration, app.weeklyholiday, app.blockfutureappointment, app.weeklyappointment, employer.name, employer.username";
		$this->_bind = array(':username' => $username);
		$result = $this->custom($query);
		return $result;

	}

	public function recommended($id)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT b.username, b.profilepic, b.name, b.usertype, b.rate from ".DB_SCHEMA.".professional as a join ".DB_SCHEMA.".professional as b on b.id = any(a.recommendation) where  a.id = :id";
		$this->_bind = array(':id' => $id);
		$result = $this->custom($query);
		return $result;
	}

	public function recommendedby($id, $page, $perPage = 6)
	{
		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT id, username, profilepic, name, usertype, professional.rate from ".DB_SCHEMA.".professional where :id  = any(recommendation) OFFSET " . $start . " LIMIT " . $perPage . ";";
		$this->_bind = array(':id' => $id);
		$result = $this->custom($query);
		return $result;
	}




	public function getSimilar($page, $perPage= 4, $usertype, $focus, $location=null, $id)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$sql = 'SELECT username, name, profilepic FROM ' . DB_SCHEMA . '.professional WHERE usertype = :usertype  ';

		$where='';
		$this->_bind = array(':usertype' => $usertype);
		if(is_array($focus))
		{

			foreach ($focus as $key => $value)
			{

				if($key > 0) $where .= ' OR mainfocus = :focus'.$key.'  ';
				else $where .= ' mainfocus = :focus'.$key.'  ';
				$this->_bind[':focus'.$key] = $value;

			}
			$where = ' AND (' . $where . ')';
		}
		else
		{
			$where = ' AND mainfocus = :focus ';
			$this->_bind[':focus'] = $focus;
		}

		if($location != null && $location != '')
		{

			// foreach ($location as $key => $value)
			// {
				// $where .= ' ' . $key . ' = :' . $key . '  AND ';
				// $this->_bind[':' . $key] = $value;
				$where .= ' AND (:location OPERATOR(website.<%) formattedaddress) ';
				$this->_bind[':location'] = $location;
			// }

		}

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$query = $sql . $where . ' AND id <> :id ORDER BY id desc OFFSET ' . $start . ' LIMIT ' . $perPage . ';';
		$this->_bind[':id'] = $id;



		$result = $this->custom($query);
		return $result;

	}

	public function getOther($page, $perPage= 4, $usertype, $focus, $location=null)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$sql = 'SELECT username, name, profilepic, usertype FROM ' . DB_SCHEMA . '.professional JOIN ' . DB_SCHEMA . '.focus on mainfocus = focusid WHERE usertype <> :usertype  ';

		$where='';
		$this->_bind = array(':usertype' => $usertype);
		if(!empty($focus))
		{

			foreach ($focus as $key => $value)
			{

				$where .= " focus @@ to_tsquery('english' , :focus".$key.")  OR ";
				$this->_bind[':focus'.$key] = $value;

			}
			$where = substr($where,0,-3);
			$where = ' AND (' . $where . ')';
		}


		if($location != null && $location!='')
		{

			// foreach ($location as $key => $value)
			// {
				// $where .= ' ' . $key . ' = :' . $key . '  AND ';
				// $this->_bind[':' . $key] = $value;
				$where .= ' AND (:location OPERATOR(website.<%) formattedaddress) ';
				$this->_bind[':location'] = $location;
			// }


		}

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$query = $sql . $where . ' ORDER BY id desc OFFSET ' . $start . ' LIMIT ' . $perPage . ';';

		$result = $this->custom($query);
		return $result;

	}


	public function getRatingByRate($id)
	{
		$this->_fetch = fetchAll;
		$query = 'SELECT rating,
					(case when rating = 5 then count(*)
						  when rating = 4 then count(*)
						  when rating = 3 then count(*)
						  when rating = 2 then count(*)
					      when rating = 1 then count(*) else null end) as countrating
					from '.DB_SCHEMA.'.professionalrating where professionalid = :professionalid group by rating';
		$this->_bind = array(':professionalid' => (int)$id);

		$result = $this->custom($query);
		return $result;

	}


	public function insertRating($rate, $professionalid, $id)
	{
		$this->_fetch = 0;
		$query = 'INSERT INTO '.DB_SCHEMA.'.professionalrating (professionalid, id, rating, createdat)
					VALUES (:professionalid, :id, :rating, now())
					ON CONFLICT (professionalid, id) DO UPDATE
					  SET professionalid = excluded.professionalid,
					      id = excluded.id,
					      rating = excluded.rating,
					      modifiedat = excluded.createdat
					      ;';
        $this->_bind = array(':professionalid' => $professionalid,
					        	':id' => $id,
					        	'rating' => $rate);
        $result = $this->custom($query);
        return $result;

	}

	public function getprofcomments($professionalid, $id=null, $page = 0, $perPage = 10)
	{
		$start = ($page)*$perPage;
		if ($start<0) $start = 0;
		if($page == 0  && $id != null)
		{


		$query = "select * from (
					(select  professionalratingid as rateid, id, professionalid, rating, null as parentid, comment, createdat, modifiedat, null as createdbyprofessional from ".DB_SCHEMA.".professionalrating union all
					select  professionalratingreplyid as rateid, id, professionalid,null as rating, parentid, comment, createdat, modifiedat, createdbyprofessional from ".DB_SCHEMA.".professionalratingreply) as r
					inner join
					(SELECT id as userid, username as username, profilepic as profilepic,usertype as usertype, email FROM ".DB_SCHEMA.".professional UNION select id as userid, username as username, USERDETAILS->>'profilepic' AS profilepic, usertype as usertype, email FROM ".DB_SCHEMA.".usernormal) AS u ON (u.userid = r.id)
					)
					left join

					(select count(*), email as appointmentemail,professionalid, appointmentid FROM website.appointment group by email, professionalid, appointmentid) as ap on ap.appointmentemail = u.email and ap.professionalid = r.professionalid
					 where (r.id = :id AND r.professionalid = :professionalid) OR r.professionalid = :professionalid  ORDER BY (rateid, parentid) OFFSET ".$start." LIMIT ".$perPage.";";
		}
		else
		{
			$query = "SELECT * FROM " . DB_SCHEMA . ".profratereply(:professionalid) OFFSET ".$start." LIMIT ".$perPage.";";
		}
		$this->_bind = array(':professionalid' => $professionalid);
		if($page == 0  && $id != null) $this->_bind[':id'] = $id;
		$result = $this->custom($query);
		return $result;
	}


// CREATE or REPLACE FUNCTION profratereply(IN profid bigint)
//  returns setof ratecommentreply as
// $$

// SELECT * FROM

// (
// (select  professionalratingid as rateid, id, professionalid, rating, null as parentid, comment, createdat, modifiedat, null as createdbyprofessional from website.professionalrating

// union all

// select  professionalratingreplyid as rateid, id, professionalid,null as rating, parentid, comment, createdat, modifiedat, createdbyprofessional from website.professionalratingreply) as r


// inner join

// (SELECT id, username as username, profilepic as profilepic,usertype as usertype, email FROM website.professional UNION select id, username as username, userdetails->>'profilepic' AS profilepic, usertype as usertype, email FROM website.usernormal) AS u



//  ON (u.id = r.id)
// )
// left join

// (select count(*), email,professionalid FROM website.appointment group by email, professionalid) as ap on ap.email = u.email and ap.professionalid = r.professionalid


// where r.professionalid = profid
// $$

// LANGUAGE SQL;

	public function setRatingComment($commentData)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA . ".professionalrating SET comment = :comment, createdat = :createdat WHERE professionalid = :professionalid AND id = :id";
		$this->_bind = array(':comment' => $commentData['comment'], ':createdat' => $commentData['createdat'], 'professionalid' => $commentData['professionalid'], ':id' => $commentData['id']);
		$result = $this->custom($query);
		return $result;
	}

	public function updateRatingComment($commentData)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA . ".professionalrating SET comment = :comment, modifiedat = :modifiedat WHERE professionalratingid = :rateid";
		$this->_bind = array(':comment' => $commentData['comment'], ':modifiedat' => $commentData['modifiedat'], ':rateid' => $commentData['rateid']);
		$result = $this->custom($query);
		return $result;
	}


	public function setReply($commentData)
	{
		$this->_fetch = 0;

		$query = "INSERT INTO " . DB_SCHEMA . ".professionalratingreply (comment, id, createdat, modifiedat, parentid, professionalid, createdbyprofessional) VALUES (:comment, :id, :createdat, :modifiedat, :parentid, :professionalid, :createdbyprofessional)";
		$this->_bind = array(':comment' => $commentData['comment'],
					':id' => $commentData['id'],
					':createdat'=> $commentData['createdat'],
					':modifiedat' => $commentData['modifiedat'],
					':parentid' => $commentData['parentid'],
					':professionalid' => $commentData['professionalid'],
					':createdbyprofessional' => $commentData['createdbyprofessional']);
		$result = $this->custom($query);
		return $result;
	}

	public function updateReply($commentData)
	{
		$this->_fetch = 0;
		$query = "UPDATE " . DB_SCHEMA . ".professionalratingreply SET comment = :comment, modifiedat = :modifiedat WHERE professionalratingreplyid = :rateid";
		$this->_bind = array(':comment' => $commentData['comment'], ':modifiedat' => $commentData['modifiedat'], ':rateid' => $commentData['rateid']);
		$result = $this->custom($query);
		return $result;
	}

	public function removeRatingComment($rateid)
	{
		$this->_fetch = 0;
		$query = "DELETE FROM " . DB_SCHEMA . ".professionalrating WHERE professionalratingid = :rateid ";
		$this->_bind = array(':rateid' => $rateid);
		$result = $this->custom($query);
		return $result;
	}

	public function removeReply($rateid)
	{
		$this->_fetch = 0;
		$query = "DELETE FROM " . DB_SCHEMA . ".professionalratingreply WHERE professionalratingreplyid = :rateid ";
		$this->_bind = array(':rateid' => $rateid);
		$result = $this->custom($query);
		return $result;
	}

	public function getEmployeesByName($id, $page, $perpage)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype= PDO::FETCH_ASSOC;
		$start = ($page-1)*$perpage;
		if ($start<0) $start = 0;
		$query = "SELECT profilepic, username, name, focus, professional.rate from website.professional left join website.focus on mainfocus = focusid where workat = :id OFFSET ".$start." LIMIT ".$perpage.";";
		$this->_bind[':id'] = (string)$id;
		$result = $this->custom($query);
		return $result;
	}

	public function createdonationorder($orderid, $paidby, $paidto, $note)
	{
		$this->_fetch = fetch;
		$query = "INSERT INTO " . DB_SCHEMA . ".donation (paidby, paidto, orderid, note) VALUES (:paidby, :paidto, :orderid, :note) RETURNING donationid;" ;
		$this->_bind = array(
			":paidby" => $paidby,
			":paidto" => $paidto,
			":orderid"=>$orderid,
			":note" => $note,
		);
		$result = $this->custom($query);
		return $result["donationid"];
	}




}

// CREATE FUNCTION noofrating(website.professional)
//   RETURNS bigint AS
// $func$
//     SELECT count(*)
//     FROM   website.professionalrating as pr
//     WHERE  pr.professionalid = $1.id
// $func$ LANGUAGE SQL STABLE;

// CREATE or replace FUNCTION rate(website.professional)
//   RETURNS numeric AS
// $func$
//      SELECT CAST((sum(rating)/count(*)) as double precision)
//     FROM   website.professionalrating as pr
//     WHERE  pr.professionalid = $1.id

// $func$ LANGUAGE SQL STABLE;
