<?php

class Profile extends Model
{

	function __construct()
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_NUM;
		$this->_table = 'userall';
		parent::__construct();

	}


	public function searchUsername($username)
	{
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT id, username, name, USERDETAILS->>'name' as name1 FROM ONLY " . DB_SCHEMA . ".userall NATURAL FULL JOIN ".DB_SCHEMA.".professional NATURAL FULL JOIN ".DB_SCHEMA.".usernormal WHERE lower(username) LIKE lower(:x) OR lower(name) LIKE lower(:x) OR lower(USERDETAILS->>'name') LIKE lower(:x) LIMIT 10"; //change to union??
		$this->_bind = array(':x' => '%' . $username . '%' );
		$row = $this->custom($query);
		return $row;
	}


	public function addArticle($detailsinput, $fileTemp)
	{
		$this->_fetch = 0;
		$details['filepath'] =  'images' .DS. 'article'. DS . substr(md5(time()),0, 10) . '.png';
		file_put_contents(($details['filepath']), $fileTemp);
		$details['title'] = htmlspecialchars(str_replace('&', 'and',strip_tags(trim($detailsinput['title']))));
		$details['story'] = htmlentities(trim($detailsinput['story']));
		$details['name'] = htmlentities(trim($detailsinput['author']));
		$details['about'] = htmlentities(trim($detailsinput['aboutauthor']));
		if($detailsinput['authorid']) $authorid = strip_tags(trim($detailsinput['authorid'])); else $authorid = NULL;
		foreach ($detailsinput['tags'] as $key => $value)
		{
			$details['tags'][$key] = strtolower($value);
		}
		$details['createdat'] = date('Y-m-d H:i:s');
		$query = 'INSERT INTO '.DB_SCHEMA.'.article (id, articledetails) VALUES (:id, :articledetails)';
		$this->_bind = array(':id' => $authorid, ':articledetails' => json_encode($details));
		$result =$this->custom($query);
		return $result;

	}


	public function getProfDataById($id)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT a.appointmentsettingid, a.sessionduration, a.weeklyholiday, a.maxdate, a.cost, a.weeklyappointment, a.blockfutureappointment, p.username, p.password, p.email, p.name, p.profilepic, p.since, p.about, p.phone,  p.formattedaddress, p.mainfocus, p.otherfocus, p.workday,p.breaktime, p.allowemail,p.showcontactdetails, p.workat, p.verificationid, p.language, p.isfree, p.jurisdiction, p.onlinesession, p.recommendation, p.linkedaccountid, p.isauthentic, employer.name as employername  FROM " . DB_SCHEMA . ".professional as p LEFT JOIN " . DB_SCHEMA .".appointmentsetting as a ON a.professionalid = p.id left join ". DB_SCHEMA .".professional as employer on p.workat = employer.id::varchar WHERE p.id = :id";
		$this->_bind = array(':id' => $id);
		$result = $this->custom($query);


		return $result;
	}

	public function getUserDataById($id)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$query = "SELECT id, password, username, email, userdetails, allowemail, showcontactdetails FROM " . DB_SCHEMA . ".usernormal WHERE id = :id;";
		$this->_bind[':id'] = $id;
		$result = $this->custom($query);

		return $result;
	}


	public function upsertAppointmentSetting()
	{
		$this->_fetch = 0;

		$_POST['weeklyHoliday'] = '{' . implode(",", $_POST['weeklyHoliday']) . '}';

		$query = 'INSERT INTO '.DB_SCHEMA.'.appointmentsetting (sessionduration, weeklyholiday, maxdate, cost, weeklyappointment, professionalid)
					VALUES (:sessionduration, :weeklyholiday, :maxdate, :cost, :weeklyappointment, :professionalid)
					ON CONFLICT (professionalid) DO UPDATE
					  SET sessionduration = excluded.sessionduration,
					      weeklyholiday = excluded.weeklyholiday,
					      maxdate = excluded.maxdate,
					      cost = excluded.cost,
					      weeklyappointment = excluded.weeklyappointment,
					      blockfutureappointment = excluded.blockfutureappointment;';
		$this->_bind = array(':sessionduration' => $_POST['duration'],
							 ':weeklyholiday'   => $_POST['weeklyHoliday'],
							 ':maxdate'         => $_POST['maxdate'],
							 ':cost'            => $_POST['fee'],
							 ':weeklyappointment'=> $_POST['weeklyAppointment'],
							 ':professionalid' => $_POST['professionalid']
							 );
		$result = $this->custom($query);
		return $result;
	}

	public function unblockFutureAppointmentSetting($professionalid)
	{
		$this->_fetch = 0;
		$query = 'UPDATE '.DB_SCHEMA.'.appointmentsetting SET blockFutureAppointment = FALSE where professionalid = :professionalid';
		$this->_bind = array(':professionalid' => $professionalid);
		$result = $this->custom($query);
		return $result;
	}

	public function blockFutureAppointmentSetting($professionalid)
	{
		$this->_fetch = 0;
		$query = 'UPDATE '.DB_SCHEMA.'.appointmentsetting SET blockFutureAppointment = TRUE where professionalid = :professionalid';
		$this->_bind = array(':professionalid' => $professionalid);
		$result = $this->custom($query);
		return $result;
	}

	public function deleteAppointmentsByProfessionalid($professionalid)
	{
		$this->_fetch = 0;
		$query1 = 'UPDATE '.DB_SCHEMA.'.appointmentsetting SET blockFutureAppointment = TRUE where professionalid = :professionalid;';
	    $this->_bind = array(':professionalid' => $professionalid);
	    $result1 = $this->custom($query1);

		$query2 =' DELETE FROM ' . DB_SCHEMA . '.appointment WHERE professionalid = :professionalid;';
	    $this->_bind = array(':professionalid' => $professionalid);
	    $result2 = $this->custom($query2);

		return ($result1 && $result2);
	}

	public function getallfocus($type)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT focusid, focus, parentid FROM " . DB_SCHEMA . ".focus ";
		if($type !== null && $type !== 'null')
		{
			$query .= " WHERE type = :type  ";
			$this->_bind = array(':type' => $type);
		}
		$query .= " ORDER BY parentid;";

		$result = $this->custom($query);
		return $result;
	}

	public function addfocustodb()
	{
		$this->_fetch = 0;
		$this->_bind =[];
		$field ='';

		for($key=0; $key<5; $key++)
		{

			if($_POST['category'][$key] != '' && trim($_POST['focus'][$key]) != '')
			{
				$field .= " (:focus".$key.", :parentid".$key.", :type" . $key."), ";
				$this->_bind[":focus".$key] = ucwords(strtolower(trim($_POST['focus'][$key])));
				$this->_bind[":parentid".$key] = ($_POST['mainfocus'][$key]  ? (int)$_POST['mainfocus'][$key]: NULL);
				$this->_bind[":type".$key] = $_POST['category'][$key];
			}
		}


		if($field != '')
		{
			$field= substr($field, 0, -2);

			$query = "INSERT INTO ".DB_SCHEMA.".focus (focus, parentid, type) VALUES " .$field;
			$result = $this->custom($query);
			return $result;
		}
		else return 0;

	}

	public function getRecommendations($ids)
	{
		$query = "SELECT name from " . DB_SCHEMA . ".professional where id = :id0 ";
		$this->_bind = array(':id0' => $ids[0]);
		if($ids[1])
		{
			$query .= "OR id = :id1 ";
			$this->_bind[':id1'] = $ids[1];
		}
		if($ids[2])
		{
			$query .= "OR id = :id2 ";
			$this->_bind[':id2'] = $ids[2];
		}
		$result = $this->custom($query);
		return $result;

	}

	public function updateProfessional()
	{
		$this->_fetch = 0;
		if(isset($_POST['image-data']) && $_POST['image-data'] != null)
		{
			  $img = $_POST['image-data'];
		      $img = str_replace('data:image/png;base64,', '', $img);
		      $img = str_replace(' ', '+', $img);
		      $fileTemp = base64_decode($img);
		}
		if($fileTemp)
		{
			$_POST['profilepic'] ='images'. DS. 'profile' . DS .  'profilepic_'.$_POST['id']  . '.png';
			file_put_contents($_POST['profilepic'], $fileTemp);
			unlink($_POST['oldimage']);
		}
		unset($_POST['image-data']);
		unset($_POST['oldimage']);
		unset($_POST['recommendname']);
		$_POST['recommendation'] = $_POST['recommendids'];
		unset($_POST['recommendids']);
		$_POST['language'] = explode(',', $_POST['language']);
		if(!empty($_POST['since'])) $_POST['since'] = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['since']))); else unset($_POST['since']);

		if(isset($_POST['isfirm']) && $_POST['isfirm'] == true)
			{
				$_POST['workat'] = '0';
				unset($_POST['isfirm']);
				unset($_POST['workatid']);
				unset($_POST['workatname']);
			}
			elseif(!empty($_POST['workatid']))
			{
				$_POST['workat'] = $_POST['workatid'];
				unset($_POST['isfirm']);
				unset($_POST['workatid']);
				unset($_POST['workatname']);
			}
			else
			{
				$_POST['workat'] = $_POST['workatname'];
				unset($_POST['isfirm']);
				unset($_POST['workatid']);
				unset($_POST['workatname']);
			}


		$queryfield = '';
		foreach ($_POST as $key => $value)
		{
			if($key != 'id')
			{
				$queryfield .= ' ' . $key . ' = :'. $key . ', ';
				if($key == 'about')
					$this->_bind[':' . $key] = htmlspecialchars(trim($value));
				else
				{
					if(is_array($value) && !empty($value))
					$this->_bind[':' . $key] = '{'.implode(",",array_filter($value, 'strlen')).'}';
					else
					$this->_bind[':' . $key] = strip_tags(htmlspecialchars(trim($value)));

				}
			}
		}
		if(!isset($_POST['allowemail']))
		{
			$this->_bind[':allowemail'] = 'FALSE';
			$queryfield .= ' allowemail = :allowemail, ';
		}


		$queryfield = substr($queryfield, 0, -2);
		$query = "UPDATE ". DB_SCHEMA . ".professional SET " . $queryfield . " where id = :id";

		$this->_bind[':id'] = $_POST['id'];

		$result = $this->custom($query);
		return $result;
	}

	public function updateUsernormal()
	{
		$this->_fetch = 0;

		if(isset($_POST['image-data']) && $_POST['image-data'] != null)
		{
			  $img = $_POST['image-data'];
		      $img = str_replace('data:image/png;base64,', '', $img);
		      $img = str_replace(' ', '+', $img);
		      $fileTemp = base64_decode($img);
		}
		if($fileTemp)
		{
			$_POST['userdetails']['profilepic'] =  'images'. DS. 'profile' . DS . 'profilepic_'.$_POST['id'] . '.png';
			file_put_contents($_POST['userdetails']['profilepic'], $fileTemp);
			unlink($_POST['oldimage']);
		}
		unset($_POST['image-data']);
		unset($_POST['oldimage']);

		$query = "UPDATE ". DB_SCHEMA . ".usernormal SET email = :email, username = :username, userdetails = :userdetails, allowemail = :allowemail where id = :id";

		$this->_bind = array(':id' => (int)$_POST['id'],
							':username' => 	strip_tags(htmlspecialchars(trim($_POST['username']))),
							':email' => strip_tags(htmlspecialchars(trim($_POST['email']))),
							':userdetails' => json_encode($_POST['userdetails']),
							':allowemail' => ($_POST['allowemail'] ? strip_tags(htmlspecialchars(trim($_POST['allowemail']))) : 'FALSE')
							);

		$result = $this->custom($query);
		return $result;
	}

	public function modifypassword($id, $password)
	{
		$this->_fetch = 0;
		$password = password_hash($password, PASSWORD_BCRYPT);

		$query = "UPDATE ".DB_SCHEMA. ".userall SET password = :password WHERE id = :id";
		$this->_bind = array(':id' => $id, ':password' => $password);
		$result = $this->custom($query);
		return $result;
	}

	public function getPaymentsMade($page, $perPage)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		$query = "SELECT DISTINCT ON(t.threadid) t.threadid, m.messageid, closedby, closedon, paymentid, recipientid, id as userid, username,usertype from ".DB_SCHEMA.".messagethread t LEFT JOIN ".DB_SCHEMA.".message m ON m.threadid = t.threadid LEFT JOIN userall u on u.id = recipientid where paidby = :paidby ORDER BY t.threadid DESC,messageid ASC, closedon DESC NULLS FIRST OFFSET ". $start . " LIMIT " . $perPage;
		$this->_bind[':paidby'] = $_SESSION['id'];
		$result = $this->custom($query);
		return $result;
	}

	public function getPaymentsReceived($page, $perPage)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		$query = "SELECT DISTINCT ON(t.threadid) t.threadid, m.messageid, closedby, closedon,  orderid, paymentid,paidby , username, usertype from ".DB_SCHEMA.".messagethread t LEFT JOIN ".DB_SCHEMA.".message m ON m.threadid = t.threadid LEFT JOIN userall u on u.id = paidby  where paidby IS NOT NULL AND paidby <> recipientid AND recipientid = :recipientid ORDER BY t.threadid DESC,messageid ASC, closedon desc NULLS FIRST OFFSET ". $start . " LIMIT " . $perPage;
		$this->_bind[':recipientid'] = $_SESSION['id'];
		$result = $this->custom($query);
		return $result;
	}

	public function getDonationsMade($page, $perPage)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		$query = "SELECT donationid, paidto, orderid, d.paymentid, note, username, name from ".DB_SCHEMA.".donation d LEFT JOIN professional p ON paidto = id where paidby =:paidby ORDER BY donationid  DESC  OFFSET ". $start . " LIMIT " . $perPage;
		$this->_bind[':paidby'] = $_SESSION['id'];
		$result = $this->custom($query);
		return $result;
	}

	public function getDonationsReceived($page, $perPage)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		$query = "SELECT donationid, paidby, orderid,paymentid, note, username, usertype from ".DB_SCHEMA.".donation d LEFT JOIN userall a ON paidby = id where paidto =:paidto ORDER BY donationid  DESC  OFFSET ". $start . " LIMIT " . $perPage;
		$this->_bind[':paidto'] = $_SESSION['id'];
		$result = $this->custom($query);
		return $result;
	}

	public function getAppointmentByEmail($email, $page)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$perPage = 10;

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		$query = "SELECT a.appointmentid, a.name as user , a.phone, a.appointmentdatetime, a.appointmenttype, a.appointmentend, p.name as professional, p.username, p.usertype from " . DB_SCHEMA .".appointment as a inner join ".DB_SCHEMA.".professional as p on professionalid = id where a.email = :email and (appointmenttype = 'weeklyappointment' or appointmenttype = 'normalappointment') ORDER BY appointmentdatetime desc OFFSET ". $start . " LIMIT " . $perPage;
		$this->_bind[':email'] = $email;
		$result = $this->custom($query);
		return $result;
	}

	public function getAppointmentById($page)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$perPage = 10;

		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;

		$query = "SELECT a.appointmentid, a.name as user , a.phone, a.appointmentdatetime, a.appointmenttype, a.appointmentend, a.email as appointemail, p.name as professional, p.username, p.usertype from " . DB_SCHEMA .".appointment as a inner join ".DB_SCHEMA.".professional as p on professionalid = id where id = :id and (appointmenttype = 'weeklyappointment' or appointmenttype = 'normalappointment') ORDER BY appointmentdatetime desc OFFSET ". $start . " LIMIT " . $perPage;
		$this->_bind[':id'] = $_SESSION['id'];
		$result = $this->custom($query);
		return $result;
	}


	public function getUsernameEmailByType($type)
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		if($type == 'everybody')
		{
			$query = "SELECT username, email FROM " . DB_SCHEMA . ".userall WHERE allowemail = TRUE";
		}
		elseif($type == 1)
		{
			$query = "SELECT username, email FROM " . DB_SCHEMA . ".usernormal WHERE allowemail = TRUE";
		}
		elseif($type == 'professionals')
		{
			$query = "SELECT username, email FROM " . DB_SCHEMA . ".professional WHERE allowemail = TRUE";
		}
		else
		{
			$query = "SELECT username, email FROM " . DB_SCHEMA . ".professional WHERE allowemail = TRUE and usertype = :usertype";
			$this->_bind[':usertype'] = (int)$type;
		}
		$result = $this->custom($query);
		return $result;
	}

	public function removeProfPic($id)
	{
		$this->_fetch = 0;
		$query = "UPDATE ". DB_SCHEMA . ".professional SET profilepic = NULL where id = :id";
		$this->_bind[':id'] = $id;
		$result = $this->custom($query);
		if($result) $_SESSION['profilepic'] = '';
		return $result;
	}

	public function removeUserPic($id)
	{
		$this->_fetch = 0;
		$query = "UPDATE ". DB_SCHEMA . ".usernormal SET userdetails = userdetails || '{\"profilepic\": \"\"}'::jsonb where id =:id";
		$this->_bind[':id'] = $id;
		$result = $this->custom($query);
		if($result) $_SESSION['profilepic'] = '';
		return $result;
	}

	public function deleteappointmentbyuser($appointmentid, $type, $appointmentdatetime, $reason)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "DELETE FROM ".DB_SCHEMA.".appointment  WHERE appointmentid = :appointmentid returning (select email from ".DB_SCHEMA.".professional as p where p.id  = appointment.professionalid)";
		$this->_bind = array(':appointmentid'=>$appointmentid);
		$result = $this->custom($query);
		if($reason != '' && $reason != null) $reasonemail= '<p></p><p>Reason for cancellation:<b> ' . ucfirst($reason) .'</b></p><p></p>';
				else $reasonemail ='';
		if($result['email'])
		{
			$send = new sendEmail();
			if($type == 'normalappointment')
			{
				$send->email($result['email'], 'Cancellation of appointment', "<p>Appointment with you on</p><p><b>" . $appointmentdatetime."</b></p><p>with ".$_SESSION['email']." has been <i>cancelled</i> by them.</p>".$reasonemail."<p>p> We apologise for any inconvience caused.</p><p></p><p></p> <p>--".DB_SCHEMA."</p>");
			}
			elseif($appointmenttype =='weeklyappointment')
			{

				$send->email($result['email'], 'Cancellation of appointment', "<p>We regret to inform you that ".$_SESSION['email']." has cancelled appointment with you, from</p><p><b>" . $appointmentdatetime."</b></p><p>to <b>perceivable future</b>.</p>".$reasonemail."<p> We apologise for any inconvience caused.</p><p></p> <p>--".DB_SCHEMA."</p>");
			}
			return true;
		}
	}

	public function modifyweeklyappointmentbyuser($appointmentid, $appointmentdatetime, $reason)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$addweek = strtotime($_POST['appointmentdatetime'] . '+ 1 week');
		$newdate = date('Y-m-d H:i:s', $addweek);
		$query = "UPDATE ".DB_SCHEMA.".appointment SET appointmentdatetime = :appointmentdatetime WHERE appointmentid = :appointmentid returning (select email from ".DB_SCHEMA.".professional as p where p.id  = appointment.professionalid)";
		$this->_bind = array(':appointmentdatetime' => $newdate,
							  ':appointmentid'      => $appointmentid);
		$result = $this->custom($query);
		if($reason != '' && $reason != null) $reasonemail= '<p></p><p>Reason for cancellation:<b> ' . ucfirst($reason) .'</b></p><p></p>';
				else $reasonemail ='';
		if($result['email'])
		{
			$send = new sendEmail();
			$send->email($result['email'], 'Cancellation of appointment', "<p>We regret to inform you that ".$_SESSION['email']." has cancelled appointment with you, on</p><p><b>" . $appointmentdatetime."</b></p><p>Appointment will resume from <b>".$newdate."</b>.</p>".$reasonemail."<p> We apologise for any inconvience caused.</p><p></p> <p>--".DB_SCHEMA."</p>");
			return true;
		}

	}

	public function updateverificationid($verificationid)
	{
		$this->_fetch = 0;
		$query = "UPDATE ".DB_SCHEMA.".professional SET verificationid = :verificationid, isauthentic = NULL where id = :id; "; //and isauthentic IS NOT TRUE
		$this->_bind = array(
			':verificationid' => $verificationid,
			':id' => $_SESSION['id']
		);
		$result = $this->custom($query);
		return $result;
	}

	public function getNullAuthenticatedProf($page, $perPage = 10)
	{
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$start = ($page-1)*$perPage;
		if ($start<0) $start = 0;
		$query = "SELECT id,username, email,name, usertype, profilepic, since, about, phone, formattedaddress, verificationid, jurisdiction,mf.focus as mainfocus,array_agg(othfo.focus) as otherfocus from ".DB_SCHEMA.".professional LEFT JOIN ".DB_SCHEMA.".focus mf ON mf.focusid = mainfocus LEFT JOIN ".DB_SCHEMA.".focus othfo ON othfo.focusid = any(otherfocus) where isauthentic IS NULL group by id,username, email,name, usertype, profilepic, since, about, phone, formattedaddress, mainfocus, otherfocus, verificationid, jurisdiction, mf.focus ORDER BY id DESC OFFSET ". $start . " LIMIT " . $perPage;
		$result = $this->custom($query);
		return $result;
	}

	public function SetAuthenticateProfessionalTrue($professionalid)
	{
		$this->_fetch = fetch;
		$query = 'UPDATE '.DB_SCHEMA.'.professional SET isauthentic = TRUE where id = :professionalid returning isauthentic;';
    $this->_bind = array(':professionalid' => $professionalid);
    $result = $this->custom($query);
		return $result;
	}

	public function SetAuthenticateProfessionalFalse($professionalid)
	{
		$this->_fetch = fetch;
		$query = 'UPDATE '.DB_SCHEMA.'.professional SET isauthentic = False where id = :professionalid returning isauthentic;';
    $this->_bind = array(':professionalid' => $professionalid);
    $result = $this->custom($query);
		return $result;
	}


}
