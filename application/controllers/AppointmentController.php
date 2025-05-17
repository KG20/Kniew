<?php 
error_reporting(0);

	class AppointmentController extends Controller
	{
		function __construct($controller, $action)
		{
			$this->render =0;
			parent::__construct($controller, $action);
		}

	
		public function getappointmentdata()
		{

			$this->render = 0;

			if($_POST)
			{
				$professionalid = $_POST['professionalid'];
				$eventnormal =[];
				$eventpersonal =[];
				$eventweekly = [];
				$result = $this->Appointment-> getappointment($professionalid);

				if(isset($result['normalappointment']) && !empty($result['normalappointment']))
				{
					$normalappointment = explode(',', $result['normalappointment']);

					foreach ($normalappointment as $key => $value) 
					{

						$valuearray = explode(' & ', $value);
					
						$eventnormal[$key]['start'] = date('Y-m-d H:i:s',strtotime($valuearray[0]));					
						$eventnormal[$key]['end'] = date('Y-m-d H:i:s',strtotime($valuearray[1]));

					}
				}
				else $eventnormal = NULL;

				if(isset($result['personalholiday']) && !empty($result['personalholiday']))
				{
					$personalholiday = explode(',', $result['personalholiday']);

					foreach ($personalholiday as $key => $value) 
					{

						$valuearray = explode(' & ', $value);					
						$eventpersonal[$key]['start'] = date('Y-m-d H:i:s',strtotime($valuearray[0]));					
						$eventpersonal[$key]['end'] = date('Y-m-d H:i:s',strtotime($valuearray[1]));

					}
				}
				else $eventpersonal = NULL;

				if(isset($result['weeklyappointment']) && !empty($result['weeklyappointment']))
				{
					$weeklyappointment = explode(',', $result['weeklyappointment']);

					foreach ($weeklyappointment as $key => $value) 
					{

						$valuearray = explode(' & ', $value);
					
						$eventweekly[$key]['start'] = date('Y-m-d H:i:s',strtotime($valuearray[0]));					
						$eventweekly[$key]['end'] = date('Y-m-d H:i:s',strtotime($valuearray[1]));

					}
				}
				else $eventweekly = NULL;

				$returnAppointData = array(
									'worktime' 		=> explode(',', str_replace(array('{', '}'), '',$result['workday'])),
									'breaktime'     =>explode(',', str_replace(array('{', '}'), '',$result['breaktime'])),
									'duration' 		=> $result['sessionduration'],
									'maxdate'		=> (float)$result['maxdate'],
									'weeklyHoliday' => explode(',', str_replace(array('{', '}'), '',$result['weeklyholiday'])),
									'normalAppointment'		=> $eventnormal,
									'personalHoliday' => $eventpersonal,
									'weeklyAppointment' => $eventweekly
									);
				echo json_encode($returnAppointData);
			}
			
		}

		public function getappointmentdatafc()
		{
			$this->render = 0;

			if($_POST)
			{
				$professionalid = $_POST['professionalid'];

				$result = $this->Appointment->getappointmentFC($professionalid) ;
				$duration = $result['sessionduration'];

				$eventnormal =[];
				$eventpersonal =[];
				$eventweekly = [];
				$weekCount =0;


				if(isset($result['normalappointment']) && !empty($result['normalappointment']))
				{
					$normalappointment = explode(',', $result['normalappointment']);
					foreach ($normalappointment as $key => $value) 
					{
						$valuearray = explode(' & ', $value);
						$eventnormal[$key]['id'] = $valuearray[0];
						$eventnormal[$key]['title'] = $valuearray[1];
						$eventnormal[$key]['start'] = date('Y-m-d H:i:s',strtotime($valuearray[2]));
						// $newtimestamp = strtotime($eventnormal[$key]['start'] . '+ ' . $duration .' minute');
						// $eventnormal[$key]['end'] = date('Y-m-d H:i:s', $newtimestamp);
						$eventnormal[$key]['end'] = strtotime($valuearray[3]);

					}
				}
				else $eventnormal = null;

				if(isset($result['personalholiday']) && !empty($result['personalholiday']))
				{
					$personalholiday = explode(',', $result['personalholiday']);

					foreach ($personalholiday as $key => $value) 
					{
						$valuearray = explode(' & ', $value);
						$eventpersonal[$key]['id'] = $valuearray[0];
						$eventpersonal[$key]['title'] = $valuearray[1];
						$eventpersonal[$key]['start'] = date('Y-m-d H:i:s',strtotime($valuearray[2]));					
						$eventpersonal[$key]['end'] = date('Y-m-d H:i:s',strtotime($valuearray[3]));

					}
				}
				else $eventpersonal = NULL;
					

				if(isset($result['weeklyappointment']) && $result['weeklyappointment'] != NULL)
				{
					$weeklyappointment = explode(',', $result['weeklyappointment']);

					foreach ($weeklyappointment as $key => $value) {
						$valuearray = explode(' & ', $value);

						$startDate =date('Y-m-d H:i:s',strtotime($valuearray[2]));
						$weeklyEnd = date('Y-m-d H:i:s',strtotime($valuearray[3]));

						while(strtotime($startDate) <= strtotime($weeklyEnd))
						{

							$eventweekly[$weekCount]['start']= $startDate;
							$newtimestamp = strtotime($startDate . '+ ' . $duration .' minute');
							$eventweekly[$weekCount]['end'] = date('Y-m-d H:i:s', $newtimestamp);
							
							$addweek = strtotime($startDate . '+ 1 week');
							$startDate = date('Y-m-d H:i:s', $addweek);

							
							$eventweekly[$weekCount]['id'] = $valuearray[0];
							$eventweekly[$weekCount]['title'] = $valuearray[1];


							$weekCount++;
						}

					}
				}
				else $eventweekly = null;


				$returnAppointData = array(
									'worktime' 		=> explode(',', str_replace(array('{', '}'), '',$result['workday'])),
									'breaktime'     => explode(',', str_replace(array('{', '}'), '',$result['breaktime'])),
									'duration' 		=> $duration,
									'maxdate'		=> (float)$result['maxdate'],
									'weeklyHoliday' => $result['weeklyholiday'],
									'normalAppointment'		=> json_encode($eventnormal),
									'personalHoliday' => json_encode($eventpersonal),
									'weeklyAppointment' => json_encode($eventweekly)
									);
				echo json_encode($returnAppointData);
			}
			
		}

		public function getdeletednationalholiday()
		{
			$this->render = 0;
			if($_POST)
			{
				$professionalid = $_POST['professionalid'];

				$returnDeletedHoliday = $this->Appointment-> getDeletedNationalHolidays($professionalid);
				echo json_encode($returnDeletedHoliday);
			}
		}

		//delete appointment or personal holiday or weekly appointment
		public function cancelappointment() 
		{
			$this->render = 0;
			if($_POST)
			{
				$appointmentid = $_POST['appointmentid'];
				$type= $_POST['appointmenttype'];
				$appointmentdatetime = $_POST['appointmentdatetime'];
				$name = $_POST['name'];
				$reason = filter_var($_POST['reason'], FILTER_SANITIZE_STRING);
				$result = $this->Appointment->cancelappointment($appointmentid, $type, $appointmentdatetime, $name, $reason);
				echo $result;
			}
		}

		//add personal holiday or national holiday(to be deleted later from list of google national holiday)
		public function addholiday()
		{
			$this->render = 0;
			if($_POST)
			{
				$result = $this->Appointment->addholidaybytype($_POST);
				echo $result;
			}
		}
		public function cancelsingleweekappointment()
		{
			$this->render =0;
			if($_POST)
			{
				$result = $this->Appointment->modifyweeklyappointment($_POST);
				echo $result;
			}
			
		}

		// public function appointmentexists()
		// {
		// 	$result = $this->Appointment->checkAppointmentDatetime($_POST);
		// 	if($result) echo json_encode("Please choose a different appointment time, this is already taken");
		// 	else echo "true";
		// }

		public function bookappointment()
		{

			if($appointmentData['weeklyAppointment'])
			{
			 $data['appointmenttype'] = 'weeklyappointment';
			 $data['appointmentend'] = $_POST['tillDate'];
			}
			else
			{
			 $data['appointmenttype'] = 'normalappointment';
			}

			$data['professionalname'] = htmlspecialchars(strip_tags($_POST['professionalname']));
			$data['name'] = htmlspecialchars(strip_tags($_POST['fullname']));
			$data['email'] = htmlspecialchars(strip_tags($_POST['contactEmail']));
			$data['phone'] = (int)(htmlspecialchars(strip_tags($_POST['contactNumber'])));
			$data['professionalid'] = (int)(htmlspecialchars(strip_tags($_POST['professionalid'])));
			$data['appointmentdatetime'] = $_POST['datetimepicker'];

			$result = $this->Appointment->saveAppointment($data);
			echo $result;

		}

	}