<?php

class Appointment extends Model
{

	function __construct()
	{
		$this->_fetch = fetchAll;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$this->_table = 'appointment';
		parent::__construct();
	}


	public function getDeletedNationalHolidays($professionalid)
	{
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT name as title, appointmentdatetime as start FROM ".DB_SCHEMA.".appointment  WHERE professionalid = :professionalid AND appointmenttype = 'nationalholiday'";
		$this->_bind = array(':professionalid' => $professionalid);
		$result = $this->custom($query);
		return $result;
	}

	public function getappointment($professionalid)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT p.workday, p.breaktime, aps.sessionduration, aps.maxdate, aps.weeklyholiday,
				string_agg((case when a.appointmenttype = 'normalappointment' then (a.appointmentdatetime::text || ' & '||  a.appointmentend::text) else null end), ',') as normalappointment,
				string_agg((case when a.appointmenttype = 'weeklyappointment' then (a.appointmentdatetime::text || ' & '||  a.appointmentend::text) end),',') as weeklyappointment,
				string_agg((case when a.appointmenttype = 'personalholiday' then (a.appointmentdatetime::text || ' & '||  a.appointmentend::text) end),',') as personalholiday from " . DB_SCHEMA . ".appointmentsetting as aps full outer join ".DB_SCHEMA.".professional as p on p.id = aps.professionalid  left join ".DB_SCHEMA.".appointment as a on a.professionalid = aps.professionalid where p.id = :professionalid group by p.workday, p.breaktime, aps.sessionduration, aps.maxdate,aps.weeklyholiday";
		$this->_bind = array(':professionalid' => (int)$professionalid);
		$result = $this->custom($query);
		return $result;

// 		SELECT p.workday, p.breaktime, aps.sessionduration, aps.maxdate, aps.weeklyholiday
// a.appointmentdatetime where professionalid
// a.appointmentdatetime, ((appointmentend) where professionalid and appointmenttype = 'weeklyappointment'
// a.appointmentdatetime, ((appointmentend)) where professionalid and type =personalholiday

	}

	public function getappointmentFC($professionalid)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$query = "SELECT p.workday, p.breaktime, aps.sessionduration, aps.maxdate, aps.weeklyholiday,
				string_agg((case when a.appointmenttype = 'normalappointment' then (a.appointmentid || ' & ' || a.name || ' & ' || a.appointmentdatetime::text || ' & '||  NULLIF('',a.appointmentend::text))   end), ',') as normalappointment,
				string_agg((case when a.appointmenttype = 'weeklyappointment' then (a.appointmentid || ' & ' || a.name || ' & ' || a.appointmentdatetime::text || ' & '||  a.appointmentend::text) end),',') as weeklyappointment,
				string_agg((case when a.appointmenttype = 'personalholiday' then (a.appointmentid || ' & ' || a.name || ' & ' || a.appointmentdatetime::text || ' & '||  a.appointmentend::text) end),',') as personalholiday from " . DB_SCHEMA . ".appointmentsetting as aps left join ".DB_SCHEMA.".professional as p on p.id = aps.professionalid  left join ".DB_SCHEMA.".appointment as a on a.professionalid = aps.professionalid where aps.professionalid = :professionalid group by p.workday, p.breaktime, aps.sessionduration, aps.maxdate,aps.weeklyholiday";
		$this->_bind = array(':professionalid' => (int)$professionalid);
		$result = $this->custom($query);
		return $result;
	}

	public function cancelappointmentnormal($appointmentid, $appointmenttype, $appointmentdatetime, $name, $reason ='')
	{
		$this->_fetch = fetch;
		$query = "DELETE FROM ".DB_SCHEMA.".appointment  WHERE appointmentid = :appointmentid returning (select name from ".DB_SCHEMA.".professional as p where p.id  = appointment.professionalid), email";
		$this->_bind = array(':appointmentid'=>$appointmentid);
		$result = $this->custom($query);
		if($result['email'])
		{
			$send = new sendEmail();
			if($appointmenttype == 'normalappointment')
			{
				if($reason != '' && $reason != null) $reasonemail= '<p></p><p>Reason for cancellation:<b> ' . ucfirst($reason) .'</b></p><p></p>';
				else $reasonemail ='';
				$send->email($result['email'], 'Cancellation of appointment', "<p>Hello ".$name.",</p><p></p><p>We regret to inform you that, your appointment on</p><p><b>" . $appointmentdatetime."</b></p><p>with ".$result['name']." has been <i>cancelled</i> by them.</p>".$reasonemail."<p>Please contact ". $result['name'] ." for futher details. We apologise for any inconvience caused.</p><p></p> <p>--".WEBNAME."</p>");
			}
			elseif($appointmenttype == 'personalholiday')
			{
				$send->email($result['email'], 'Cancelled personal holiday', "<p>Hello ".$result['name'].",</p><p></p><p>You have cancelled your holiday on </p><p><b>" . $appointmentdatetime." : ".$name."</b></p><p>Users will now b able to book appointment with you on the same date/time again.</p><p></p> <p>--".DB_SCHEMA."</p>");
			}
			elseif($appointmenttype =='weeklyappointment')
			{
				if($reason != '' && $reason != null) $reasonemail= '<p></p><p>Reason for cancellation:<b> ' . ucfirst($reason) .'</b></p><p></p>';
				else $reasonemail ='';
				$send->email($result['email'], 'Cancellation of appointment', "<p>Hello ".$name.",</p><p></p><p>We regret to inform you that, your appointment with ".$result['name']." from</p><p><b>" . $appointmentdatetime."</b></p><p>to <b>perceivable future</b> has been <i>cancelled</i> by them.</p>".$reasonemail."<p>Please contact " . $result['name'] ." for futher details. We apologise for any inconvience caused.</p><p></p> <p>--".DB_SCHEMA."</p>");
			}
		return true;


		}

	}


	public function addholidaybytype()
	{
		$this->_fetch = fetch;
		if($appointmenttype == 'nationalholiday')
		{
			$oneday = strtotime($_POST['appointmentdatetime'] . '+ 1 day');
			$appointmentend = date('Y-m-d H:i:s', $oneday);
		}
		$query = "INSERT INTO ".DB_SCHEMA.".appointment (appointmentdatetime, name, appointmentend, professionalid, email, appointmenttype)  SELECT :appointmentdatetime, :name , :appointmentend, :professionalid, (select email from ".DB_SCHEMA.".professional as p where p.id  = :professionalid), :appointmenttype where NOT EXISTS (select 1 from ".DB_SCHEMA.".appointment where professionalid = :professionalid and appointmentdatetime = :appointmentdatetime) returning email";
		$this->_bind = array(':appointmentdatetime' => $_POST['appointmentdatetime'],
							  ':name'               => htmlspecialchars(strip_tags($_POST['name'])),
							  ':appointmentend'     => ($_POST['appointmentend'] ? $_POST['appointmentend'] : $appointmentend),
							  ':professionalid'     =>(int)$_POST['professionalid'],
							  'appointmenttype'     =>$_POST['appointmenttype']
							);
		$result = $this->custom($query);
		if($result['email'])
		{
			$send = new sendEmail();
			if($appointmenttype == 'personalholiday')
			{
				$send->email($result['email'], 'You just added a personal holiday', "<p>Hello ".$result['email'].",</p><p></p><pYou just added a personal holiday from</p><p><b>" . $_POST['appointmentdatetime']."</b> to <b>".$_POST['appointmentend']."</b>.</p><p>Users would not be able to book appointment with you, through this time duration.</p><p></p> <p>--".WEBNAME."</p>");
			}
			elseif($appointmenttype == 'nationalholiday')
			{
				$send->email($result['email'], 'Deleted national holiday', "<p>Hello ".$result['email'].",</p><p></p><p>You just deleted a national holiday on </p><p><b>" . $_POST['appointmentdatetime'].": ".$_POST['name']."</b></p><p>Users will now b able to book appointment with you on the this date from now.</p><p></p> <p>--".WEBNAME."</p>");
			}
			return true;
		}
	}

	public function modifyweeklyappointment()
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;
		$addweek = strtotime($_POST['appointmentdatetime'] . '+ 1 week');
		$appointmentdatetime = date('Y-m-d H:i:s', $addweek);

		$query = "UPDATE ".DB_SCHEMA.".appointment SET appointmentdatetime = :appointmentdatetime WHERE appointmentid = :appointmentid returning email";
		$this->_bind = array(':appointmentdatetime' => $appointmentdatetime,
							  ':appointmentid'      => $_POST['appointmentid']);
		$result = $this->custom($query);

		if($result['email'] = 'kruti.goyal20@gmail.com')
		{
			if($_POST['reason'] != '' && $_POST['reason'] != null) $reasonemail= '<p></p><p>Reason for cancellation:<b> ' . ucfirst($_POST['reason']) .'</b></p><p></p>';
			else $reasonemail = '';

			$send = new sendEmail();
			$send->email($result['email'], 'Cancellation of appointment', "<p>Hello ".$_POST['name'].",</p><p></p><p>We regret to inform you that, your appointment with ".$result['name']." on</p><p><b>" . $_POST['appointmentdatetime']."</b> <p>has been <i>cancelled </i> by ".$result['name'].".</p>".$reasonemail."<p>Please contact " . $result['name'] ." for futher details. We apologise for any inconvience caused.</p><p></p> <p>--".WEBNAME."</p>");
			return true;
		}
	}

	// public function checkAppointmentDatetime()
	// {
	// 	$this->_fetch = fetch;
	// 	$this->_fetchtype = PDO::FETCH_NUM;

	// 	$query ="SELECT appointmentid FROM " . DB_SCHEMA . ".appointment where appointmentdatetime = :datetimepicker and professionalid = :professionalid";
	// 	$this->_bind  = array(':datetimepicker' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_POST['datetimepicker']))),
	// 							':professionalid' => $_POST['professionalid'] );

	// 	$result = $this->custom($query);
	// 	return $result[0];


	// }

	public function saveAppointment($data)
	{
		$this->_fetch = fetch;
		$this->_fetchtype = PDO::FETCH_ASSOC;

		$query = "INSERT INTO ".DB_SCHEMA.".appointment (appointmentdatetime, name, appointmentend, professionalid, email, appointmenttype)  SELECT :appointmentdatetime, :name , :appointmentend, :professionalid, :email, :appointmenttype where NOT EXISTS (select 1 from ".DB_SCHEMA.".appointment where professionalid = :professionalid and appointmentdatetime = :appointmentdatetime) returning (SELECT email FROM ".DB_SCHEMA.".professional where id = :professionalid) as professionalemail";
		$this->_bind = array(':appointmentdatetime' => $data['appointmentdatetime'],
							  ':name'               => $data['name'],
							  ':appointmentend'     => ($data['appointmentend'] ? $data['appointmentend'] : null),
							  ':professionalid'     =>(int)$data['professionalid'],
							  'appointmenttype'     =>$data['appointmenttype'],
							  ':email'				=>$data['email']
							);
		$result = $this->custom($query);
		if($result['professionalemail'])
		{
			$send = new sendEmail();
			if($data['appointmenttype'] == 'normalappointment')
			{

				$send->email($data['email'], 'Confirmation of appointment',
					 "<p>Hello ".$data['name'].",</p><p></p><p>You booked a appointment on</p><p><b>" . $data['appointmentdatetime'] . " with " . $data['professionalname'] . "</b></p><p></p> <p>--".WEBNAME."</p><p></p><p></p><p style='color:grey; font-size:xsmall'>Please log in with the same email, in case you want to cancel your appointment.</p>");
				$send->email($result['professionalemail'], 'Appointment on ' . $data['appointmentdatetime'],
					 "<p>Hello ".$data['professionalname'].",</p>
							<p></p>
							<p>An user booked an appointment with you, with the following data.</p>
							<div style='margin: 5%; padding: 2%; background:lightgrey;'>
								<p><b width = '20%'>Name:</b>" . $data['name']."</p>
							    <p><b width = '20%'>Date & time:</b>".$data['appointmentdatetime']."</p>
							    <p><b width='20%'>Contact Number:</b>" .$data['phone'] ."</p>
							    <p><b width='20%'>Email</b>" . $data['email'] . "</p></div>
							    <p></p> <p>--".WEBNAME."</p>");
			}
			if($data['appointmenttype'] == 'weeklyappointment')
			{

				$send->email($data['email'], 'Confirmation of appointment',
					 "<p>Hello ".$data['name'].",</p><p></p><p>You booked a appointment on every ".date("l", $data['appointmentdatetime']) ." starting </p><p><b>" . $data['appointmentdatetime'] . " with " . $data['professionalname'] . "</b></p>
							and ending on or before ".$data['appointmentend']."<p></p> <p>--".WEBNAME."</p>sdsda@ss");
				$send->email($result['professionalemail'], 'Appointment on ' . $data['appointmentdatetime'],
					 "<p>Hello ".$data['professionalname'].",</p>
							<p></p>
							<p>An user booked weekly appointment with you, with the following data.</p>
							<div style='margin: 5%; padding: 2%; background:lightgrey;'>
								<p><b width = '20%'>Name:</b>" . $data['name']."</p>
								<p><b width = '20%'>On every:</b>" . date("l", $data['appointmentdatetime'])."</p>
							    <p><b width = '20%'>Starting:</b>".$data['appointmentdatetime']."</p>
							    <p><b width ='20%'>Ending:</b>" .$data['appointmentend'] ."</p>
							    <p><b width='20%'>Contact Number:</b>" .$data['phone'] ."</p>
							    <p><b width='20%'>Email</b>" . $data['email'] . "</p></div>
							    <p></p> <p>--".WEBNAME."</p>");
			}
			return 1;

		}



	}







}
