<?php

class Userloginvalidate extends Model
{
	function __construct()
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$this->_table = 'userall';
		parent::__construct();

	}

	public function dataByGoogle($profile)
	{
		$usernamemix = strtolower($profile['name']['givenName']) . strtolower($profile['name']['familyName']);
		$usernameinput = preg_replace("/[^a-z0-9_]+/i", "", $usernamemix);
		$genpassword = substr(md5(rand(999, 999999)), 0, 8);
		$password = password_hash($genpassword, PASSWORD_BCRYPT);
		$userdetailsarray = array(
									'name' => ($profile['name']['givenName'] . ' ' . $profile['name']['familyName']),
									'dob'  => date('Y-m-d', strtotime($profile['birthday'])),
									'about' => $profile['aboutMe'],
									'profilepic' => $profile['image']['url']
								);
		$userdetails = json_encode($userdetailsarray);

		$query = "SELECT * FROM ".DB_SCHEMA.".googleloging(:gpid::varchar, :email::varchar, :userdetails::jsonb, :usernameinput::varchar, :password::varchar)";
		$this->_bind = array(':gpid' => $profile['id'],
							':email' => $profile['emails'][0]['value'],
							':userdetails' => $userdetails,
							':usernameinput' => $usernameinput,
							':password' => $password
							);
		$result = $this->custom($query);
		return $result;

	}

	public function dataByFacebook($profile)
	{
		$usernamemix = strtolower($profile['first_name']) . strtolower($profile['last_name']);
		$usernameinput = preg_replace("/[^a-z0-9_]+/i", "", $usernamemix);
		$genpassword = substr(md5(rand(999, 999999)), 0, 8);
		$password = password_hash($genpassword, PASSWORD_BCRYPT);
		$userdetailsarray = array(
									'name' => ($profile['first_name'] . ' ' . $profile['last_name']),
									'dob'  => date('Y-m-d', strtotime($profile['birthday']->date)),
									'about' => $profile['about'],
									'profilepic' => ('http://graph.facebook.com/' . $profile['id'] . '/picture'),
									'address' => $profile['location']['name']
								);
		$userdetails = json_encode($userdetailsarray);

		$query = "SELECT * from ".DB_SCHEMA.".fbloging(:fbid::bigint, :email::varchar, :userdetails::jsonb, :usernameinput::varchar, :password::varchar)";
		$this->_bind = array(':fbid' => $profile['id'],
							':email' => $profile['email'],
							':userdetails' => $userdetails,
							':usernameinput' => $usernameinput,
							':password' => $password
							);
		$result = $this->custom($query);

		return $result;

	}



}



// CREATE FUNCTION googleloging(gpidvalue varchar, emailvalue varchar, userdetailsvalue jsonb, usernamevalue varchar, passwordvalue varchar)
// returns usernameid AS
// $$
// DECLARE result_record usernameid;
// BEGIN
//
// IF
// EXISTS (SELECT count(*) from userall where gpid = gpidvalue) then
// SELECT id, username INTO result_record.id, result_record.username from userall where gpid = gpidvalue;
//
// ELSEIF
// EXISTS (SELECT count(*) from userall where email = emailvalue AND gpid = null) then
// UPDATE userall SET gpid = gpidvalue where email = emailvalue RETURNING id, username INTO result_record.id, result_record.username;

// ELSE

// INSERT INTO usernormal (username, password, email, gpid, joiningdate, userdetails)
// VALUES ((select (usernamevalue || count(*)) from userall where username like (usernamevalue || '%')), passwordvalue, emailvalue, gpidvalue, now(), userdetailsvalue) RETURNING id, username INTO result_record.id, result_record.username;

// END IF;

// RETURN result_record;

// END;

// $$ LANGUAGE plpgsql;
// DECLARE result_record usernameid;
// BEGIN

// IF EXISTS (SELECT count(*) from userall where gpid = gpidvalue) then
// SELECT id, username INTO result_record.id, result_record.username from userall where gpid = gpidvalue;

// ELSEIF EXISTS (SELECT count(*) from userall where email = emailvalue AND gpid IS null) then
// UPDATE userall SET gpid = gpidvalue where lower(email) = lower(emailvalue) RETURNING id, username INTO result_record.id, result_record.username;

// ELSE

// INSERT INTO usernormal (username, password, email, gpid, joiningdate, userdetails)
// VALUES ((select (usernamevalue || count(*)) from userall where lower(username) like lower(usernamevalue || '%')), passwordvalue, emailvalue, gpidvalue, now(), userdetailsvalue) RETURNING id, username INTO result_record.id, result_record.username;

// END IF;

// RETURN result_record;

// END;

// DROP FUNCTION googleloging(varchar, varchar, jsonb, varchar,varchar);

// CREATE OR REPLACE FUNCTION googleloging(gpidvalue varchar, emailvalue varchar, userdetailsvalue jsonb, usernamevalue varchar, passwordvalue varchar) returns TABLE(returnid bigint, returnusername varchar) as
// $$
//
// BEGIN
//
// CASE WHEN (SELECT count(*) from website.userall where gpid = gpidvalue) then
// RETURN QUERY SELECT id, username from website.userall where gpid = gpidvalue;
//
// WHEN (SELECT count(*) from website.userall where email = emailvalue) then
// RETURN QUERY UPDATE website.userall SET gpid = gpidvalue where email = emailvalue RETURNING id, username;
//
// ELSE
//
// RETURN QUERY INSERT INTO website.usernormal (username, password, email, gpid, joiningdate, userdetails)
// VALUES ((select (usernamevalue || count(*)) from website.userall where username like (usernamevalue || '%')), passwordvalue, emailvalue, gpidvalue, now(), userdetailsvalue) RETURNING id, username ;
//
// END CASE;
//
//
//
//
//
// END;
// $$ LANGUAGE plpgsql;
