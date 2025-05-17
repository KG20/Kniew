window.___gcfg = {
	lang: 'en-US',
	parsetags: 'explicit' //Configure to initialize explicitly
};

var getUrl = window.location;
var baseUrl = getUrl.protocol + "//" + getUrl.host + "/";
// location.href.replace(/#.*/, "")
var currentpagearray = getUrl.pathname.replace(/(\&.*)|(#.*)|(\?.*)/, "").split("/");
var currentpage = currentpagearray[1];

function viewport()
{
	var e = window,
		a = 'inner';
	if (!('innerWidth' in window))
	{
		a = 'client';
		e = document.documentElement || document.body;
	}
	return {
		width: e[a + 'Width'],
		height: e[a + 'Height']
	};
}

function capitalizeFirstLetter(string)
{
	return string.charAt(0).toUpperCase() + string.slice(1);
}


function getcalendarId()
{
	var professionalcountry;
	if (document.getElementById('appointmentCalendar'))
	{
		professionalcountry = $('#appointmentCalendar').attr('data-country');
	}
	if (document.getElementById('appointForm'))
	{
		professionalcountry = $('#appointForm').attr('data-country');
	}
	var calendarIdArray = {
		Australia: "en.australian",
		Austria: "en.austrian",
		Brazil: "en.brazilian",
		Canada: "en.canadian",
		China: "en.china",
		Christian: "en.christian",
		Sweden: "en.danish",
		Norway: "en.danish",
		Denmark: "en.danish",
		Netherlands: "en.dutch",
		Finland: "en.finnish",
		France: "en.french",
		Germany: "en.german",
		Greece: "en.greek",
		"Hong Kong (C)": "en.hong_kong_c",
		"Hong Kong": "en.hong_kong",
		India: "en.indian",
		Indonesia: "en.indonesian",
		Iran: "en.iranian",
		Ireland: "en.irish",
		Islamic: "en.islamic",
		Italy: "en.italian",
		Japan: "en.japanese",
		Jewish: "en.jewish",
		Malaysia: "en.malaysia",
		Mexico: "en.mexican",
		"New Zealand": "en.new_zealand",
		Norway: "en.norwegian",
		Philippines: "en.philippines",
		Poland: "en.polish",
		Portugal: "en.portuguese",
		Russia: "en.russian",
		Singapore: "en.singapore",
		"South Africa": "en.sa",
		"South Korean": "en.south_korea",
		Spain: "en.spain",
		Swedish: "en.swedish",
		Taiwan: "en.taiwan",
		Thai: "en.thai",
		"United Kingdom": "en.uk",
		"United States": "en.usa",
		Vietnam: "en.vietnamese",
		アイルランドの祝日: "ja.irish",
		アメリカの祝日: "ja.usa",
		イギリスの祝日: "ja.uk",
		イスラム教の祝日: "ja.islamic",
		イタリアの祝日: "ja.italian",
		インドの祝日: "ja.indian",
		インドネシアの祝日: "ja.indonesian",
		オランダの祝日: "ja.dutch",
		オーストラリアの祝日: "ja.australian",
		オーストリアの祝日: "ja.austrian",
		カナダの祝日: "ja.canadian",
		キリスト教の祝日: "ja.christian",
		ギリシャの祝日: "ja.greek",
		シンガポールの祝日: "ja.singapore",
		スウェーデンの祝日: "ja.swedish",
		スペインの祝日: "ja.spain",
		タイの祝日: "ja.thai",
		デンマークの祝日: "ja.danish",
		ドイツの祝日: "ja.german",
		ニュージーランドの祝日: "ja.new_zealand",
		ノルウェイの祝日: "ja.norwegian",
		フィリピンの祝日: "ja.philippines",
		フィンランドの祝日: "ja.finnish",
		フランスの祝日: "ja.french",
		ブラジルの祝日: "ja.brazilian",
		ベトナムの祝日: "ja.vietnamese",
		ポルトガルの祝日: "ja.portuguese",
		ポーランドの祝日: "ja.polish",
		マレーシアの祝日: "ja.malaysia",
		メキシコの祝日: "ja.mexican",
		ユダヤ教の祝日: "ja.jewish",
		ロシアの祝日: "ja.russian",
		中国の祝日: "ja.china",
		韓国の祝日: "ja.south_korea",
		南アフリカの祝日: "ja.sa",
		台湾の祝日: "ja.taiwan",
		日本の祝日: "ja.japanese",
		"香港(C)の祝日": "ja.hong_kong_c",
		香港の祝日: "ja.hong_kong"
	};
	if (calendarIdArray.hasOwnProperty(professionalcountry))
	{
		return (calendarIdArray[professionalcountry]);
	}
	else
	{
		return "en.indian";
	}
}

var clientId = '570827482982-stc0mn0tk2ed16lmqbb11sag5badvnlc.apps.googleusercontent.com';
var scopes = 'https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/userinfo.email  https://www.googleapis.com/auth/plus.me';
var apiKey = 'AIzaSyCK-L2785ywTxeMaZgJzdrLKXznnGtvhjM' || calendar.opt('googleCalendarApiKey');
// var apiKey = 'AIzaSyAoJ5E1ZTSiPdFrnWJlkWE_yNJuwPuTL-Q' || calendar.opt('googleCalendarApiKey');
// var calendarUrl = 'https://www.googleapis.com/calendar/v3/calendars/en.' + professionalcountry
// + '%23holiday%40group.v.calendar.google.com/events?key=' + apiKey;

function start()
{
	gapi.load('auth2', function()
	{
		auth2 = gapi.auth2.init(
		{
			client_id: '207218996928-tg766c3kf4qqgl9n9j0v6oeqr42q3min.apps.googleusercontent.com',
			fetch_basic_profile: false,
			scope: scopes
		});
		gapi.client.setApiKey(apiKey);

		attachSignin(document.getElementById('signinButton'));
		if (document.getElementById('appointmentCalendar') || document.getElementById('datetimepicker'))
		{
			loadAppointmentCalendar();
		}

	});
}
//google sign in
function attachSignin(element)
{
	auth2.attachClickHandler(element,	{},
		function(googleUser)
		{

			var profile = googleUser.getBasicProfile();
			var id_token = googleUser.getAuthResponse().id_token;
			var access_token = googleUser.getAuthResponse().access_token;
			googleUser.grantOfflineAccess().then(function(resp)
			{
				var auth_code = resp.code;
				var xhr = new XMLHttpRequest();
				xhr.open('POST', baseUrl + 'Userloginvalidate/googlesignin');
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function()
				{
					location.reload();
				};
				xhr.send('id_token=' + id_token + '&access_token=' + access_token + "&code=" + auth_code);
			});

		}
		// , function(error) {
		// alert(JSON.stringify(error, undefined, 2));
		// }
	);
}

//fblogin
function statusChangeCallback(response)
{

	// for FB.getLoginStatus().
	if (response.status === 'connected')
	{
		// Logged into your app and Facebook.
		window.location.replace(baseUrl + 'Userloginvalidate/facebooklogin');
	}
	else if (response.status === 'not_authorized')
	{
		// The person is logged into Facebook, but not your app.
		alert("Please authorize the website to log in through facebook.");
	}
	else
	{
		// The person is not logged into Facebook, so we're not sure if
		// they are logged into this app or not.
		alert("Please log in to facebook to access member pages.");
	}
}

function checkLoginState()
{
	FB.getLoginStatus(function(response)
	{
		statusChangeCallback(response);
	});
}

window.fbAsyncInit = function()
{
	FB.init(
	{
		appId: '2068863420019543',
		xfbml: true,
		cookie: true,
		status: true,
		oauth: true,
		version: 'v3.0'
	});
	FB.AppEvents.logPageView();
};

(function(d, s, id)
{
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
	{
		return;
	}
	js = d.createElement(s);
	js.id = id;
	js.src = "https://connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

//share
(function($)
{

	$.fn.customerPopup = function(e, intWidth, intHeight, blnResize)
	{

		// Prevent default anchor event
		e.preventDefault();

		// Set values for window
		intWidth = intWidth || '500';
		intHeight = intHeight || '400';
		strResize = (blnResize ? 'yes' : 'no');

		// Set title and open popup with focus on it
		var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Share'),
			strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,
			objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
	}
}(jQuery));

$('.customer.share').on("click", function(e)
{
	$(this).customerPopup(e);
});

//appointment
function makeApiCall(callback)
{
	var nationalHolidays = [];
	var calendarid = getcalendarId();
	gapi.client.load('calendar', 'v3', function()
	{
		var request = gapi.client.calendar.events.list(
		{
			'calendarId': calendarid + '#holiday@group.v.calendar.google.com'
		});
		request.execute(function(resp)
		{
			for (var i = 0; i < resp.items.length; i++)
			{
				nationalHolidays[i] = {
					title: resp.items[i].summary,
					start: resp.items[i].start['date'],
					allDay: true,
					color: 'darkred',
					editable: false,
					className: "nationalHolidays"
				};
			}
			callback(nationalHolidays);
		});
	})
}

function resizeJquerySteps()
{
	$('.wizard .content').animate(
	{
		height: $('.body.current').outerHeight()
	}, 'slow');
}

function loadAppointmentCalendar()
{

	makeApiCall(function(nationalHolidays)
	{
		var deleteNationalHoliday;
		var fullCal = document.getElementById('appointmentCalendar');
		var DTP = document.getElementById('datetimepicker');
		if (fullCal || DTP)
		{
			if (fullCal)
			{
				var professionalid = $('#appointmentCalendar').attr('data-professionalid');
			}
			else if (DTP)
			{
				var professionalid = $('#datetimepicker').attr('data-professionalid');
			}

			jQuery.ajax(
			{
				type: "POST",
				url: baseUrl + 'appointment/getdeletednationalholiday',
				dataType: 'json',
				data:
				{
					professionalid: professionalid
				},

				success: function(resp)
				{
					if (resp.length != 0) deleteNationalHoliday = JSON.parse(resp);
					else deleteNationalHoliday = [];
				},
			}).done(function()
			{
				var holidayDates = [];
				for (var j = ((nationalHolidays.length) - 1); j > -1; j--)
				{
					for (var i = (deleteNationalHoliday.length - 1); i > -1; i--)
					{
						if ((nationalHolidays[j].title == deleteNationalHoliday[i].title) && (nationalHolidays[j].start == moment(deleteNationalHoliday[i].start).format("YYYY-MM-DD")))
						{
							nationalHolidays.splice(j, 1);
						}
						if (DTP)
						{
							holidayDates[j] = nationalHolidays[j]['start'];
						}
					}
				}

				if (fullCal)
				{
					$('#appointmentCalendar').fullCalendar('addEventSource', nationalHolidays);
				}
				else if (DTP)
				{
					var professionalid = $('#datetimepicker').attr('data-professionalid');
					var setupData = null;
					var setupObj = null;
					var appoint = [];
					var personal = [];
					var weeklyAppointment = [];
					var enabled = [];
					var disabledTime = [];
					var max = null;

					if (professionalid)
					{

						jQuery.ajax(
						{
							type: "POST",
							url: baseUrl + 'appointment/getappointmentdata',
							data:
							{
								professionalid: professionalid
							},

							success: function(resp)
							{
								setupData = resp;
								setupObj = JSON.parse(setupData);

								var h = setupObj.duration / 60 | 0,
									m = setupObj.duration % 60 | 0;

								if (setupObj.normalAppointment)
								{
									for (var i = 0; i < (setupObj.normalAppointment).length; i++)
									{
										var startappoint = moment(setupObj.normalAppointment[i].start).subtract(1, "minutes");
										var endappoint = moment(setupObj.normalAppointment[i].end).subtract(1, "minutes");
										appoint[i] = [startappoint, endappoint];
									}
								}

								if (setupObj.personalHoliday)
								{
									for (var i = 0; i < (setupObj.personalHoliday).length; i++)
									{
										var startHoliday = moment(setupObj.personalHoliday[i].start).subtract(1, "minutes");
										var endHoliday = moment(setupObj.personalHoliday[i].end).subtract(1, "minutes");
										personal[i] = [startHoliday, endHoliday];

									}
								}

								var weekcount = 0;

								if (setupObj.weeklyAppointment)
								{
									for (var i = 0; i < (setupObj.weeklyAppointment.length); i++)
									{
										var startweek = moment(setupObj.weeklyAppointment[i].start).subtract(1, "minutes");
										var endweek = moment(setupObj.weeklyAppointment[i].end);

										while (moment(startweek).isSameOrBefore(endweek))
										{
											startweekdur = moment(startweek).add(h, "hours").add(m, "minutes");
											weeklyAppointment[weekcount] = [startweek, startweekdur];
											var startweek = moment(startweek).add(1, "weeks");
											weekcount++;
										}

									}
								}

								disabledTime = (appoint.concat(personal)).concat(weeklyAppointment);

								if (setupObj.maxdate < 1)
								{
									var days = setupObj.maxdate * 30;
									max = moment().add(days, "days");
								}
								else
								{
									max = moment().add(setupObj.maxdate, "months");
								}
								var st = moment(setupObj.worktime[0], "hh:mm:ss").format("H");
								var et = moment(setupObj.worktime[1], "hh:mm:ss").format("H");
								var bst = moment(setupObj.breaktime[0], "hh:mm:ss").format("H");
								var bet = moment(setupObj.breaktime[1], "hh:mm:ss").format("H");

								st = parseInt(st);
								et = parseInt(et);
								bst = parseInt(bst);
								bet = parseInt(bet);

								var e = 0;
								while (st < bst)
								{
									enabled[e] = st;
									st++;
									e++;
								}
								while (bet < et)
								{
									enabled[e] = bet;
									bet++;
									e++;
								}

							}
						}).done(function()
						{

							var form = $("#appointForm").show();
							$('.loader').hide();

							form.steps(
							{
								headerTag: "h3",
								bodyTag: "div",
								transitionEffect: "slideLeft",
								onInit: function(event, currentIndex)
								{

									var dp = $('#datetimepicker').datetimepicker(
									{ //for each member page show accordingly
										inline: true,
										sideBySide: true,
										// collapse:false,
										format: 'DD/MM/YYYY HH:mm',
										locale: moment.locale(),
										minDate: moment(),
										keepInvalid: false,
										debug: true,
										// disabledDates: holidayDates,
										// enabledHours: enabled,
										// disabledTimeIntervals: disabledTime, //setupObj.personalHoliday],
										// daysOfWeekDisabled: setupObj.weeklyHoliday,
										stepping: setupObj.duration ? setupObj.duration : 15,
										// ignoreReadonly: true,
										showClear: true,
										showTodayButton: true,

										// maxDate: max,
										focusOnShow: true,
										useCurrent: false,
										// viewMode: 'months'
										// useStrict: true
										icons:
										{
											time: 'fa fa-clock-o',
											date: 'fa fa-calendar',
											up: 'fa fa-chevron-up',
											down: 'fa fa-chevron-down',
											previous: 'fa fa-chevron-left',
											next: 'fa fa-chevron-right',
											today: 'glyphicon glyphicon-screenshot',
											clear: 'fa fa-trash',
											close: 'fa fa-times'
										}

									});

									dp.data('DateTimePicker').enabledHours(enabled);
									dp.data('DateTimePicker').disabledDates(holidayDates);
									dp.data('DateTimePicker').disabledTimeIntervals(disabledTime);
									dp.data('DateTimePicker').daysOfWeekDisabled(setupObj.weeklyHoliday);
									dp.data('DateTimePicker').stepping(setupObj.duration);

									$('#weeklyAppointment').click(function()
									{
										$('#tillDate')[this.checked ? "show" : "hide"]();
										if ($('#weeklyAppointment').is(':checked'))
										{
											$('#tilldateinput').datetimepicker(
											{
												format: 'DD/MM/YYYY HH:mm',
												inline: true,
												sideBySide: true,
												debug: true,
												useCurrent: false,
												icons:
												{
													time: 'fa fa-clock-o',
													date: 'fa fa-calendar',
													up: 'fa fa-chevron-up',
													down: 'fa fa-chevron-down',
													previous: 'fa fa-chevron-left',
													next: 'fa fa-chevron-right',
													today: 'glyphicon glyphicon-screenshot',
													clear: 'fa fa-trash',
													close: 'fa fa-times'
												}
											});
											$('#tillDate').show();
											dp.on("dp.change", function(e)
											{
												$('#tilldateinput').data("DateTimePicker").minDate(e.date);
											});
											$("#tilldateinput").on("dp.change", function(e)
											{
												dp.data("DateTimePicker").maxDate(e.date);
											});

										}
										if ($('#weeklyAppointment').not(':checked'))
										{
											dp.data('DateTimePicker').maxDate(max);
										}

										resizeJquerySteps();
									});
									if ($('#weeklyAppointment').is(':checked'))
									{

										$('#tilldateinput').datetimepicker(
										{
											format: 'DD/MM/YYYY HH:mm',
											inline: true,
											sideBySide: true,
											debug: true,
											useCurrent: false,
											icons:
											{
												time: 'fa fa-clock-o',
												date: 'fa fa-calendar',
												up: 'fa fa-chevron-up',
												down: 'fa fa-chevron-down',
												previous: 'fa fa-chevron-left',
												next: 'fa fa-chevron-right',
												today: 'glyphicon glyphicon-screenshot',
												clear: 'fa fa-trash',
												close: 'fa fa-times'
											}
										});
										$('#tillDate').show();
										dp.on("dp.change", function(e)
										{
											$('#tilldateinput').data("DateTimePicker").minDate(e.date);
										});
										$("#tilldateinput").on("dp.change", function(e)
										{
											dp.data("DateTimePicker").maxDate(e.date);
										});
										resizeJquerySteps();
									}
									if ($('#weeklyAppointment').not(':checked'))
									{
										dp.data('DateTimePicker').maxDate(max);
									}

								},
								onStepChanging: function(event, currentIndex, newIndex)
								{
									resizeJquerySteps();

									var dtpinput = moment($("#dtpi").val(), 'DD/MM/YYYY hh:mm a');
									var starttime = moment($('#datetimepicker')[0].getAttribute('data-starttime'), "HH:mm:ss").format();
									var endtime = moment($('#datetimepicker')[0].getAttribute('data-endtime'), "HH:mm:ss").format();
									var breakstarttime = moment($('#datetimepicker')[0].getAttribute('data-breakstarttime'), "HH:mm:ss").format();
									var breakendtime = moment($('#datetimepicker')[0].getAttribute('data-breakendtime'), "HH:mm:ss").format();
									var startint = moment(dtpinput.format()).isBetween(moment(starttime).subtract(1, "minutes"), moment(breakstarttime).subtract(1, "minutes"));
									var endint = moment(dtpinput.format()).isBetween(moment(breakendtime).subtract(1, "minutes"), moment(endtime));

									var DH = [];
									var DM = [];
									$('#datetimepicker .hour.disabled').each(function()
									{
										DH.push($(this).text());
									});
									$('#datetimepicker .minute.disabled').each(function()
									{
										DM.push($(this).text());
									});

									if (newIndex === 1 && (($.inArray($('#datetimepicker .timepicker-hour').text(), DH) != -1) || ($.inArray($('#datetimepicker .timepicker-minute').text(), DM)) != -1))
									{
										alert("Please choose a valid time/date, this time already taken/blocked. Thank You!");
										return false;
									}

									// Allways allow previous action even if the current form is not valid!
									if (currentIndex > newIndex)
									{
										return true;
									}

									if (newIndex === 1 && moment(dtpinput.format()).isBetween(moment(), moment().add(1, 'hours')))
									{

										alert('You cannot select a time within 1 hour of the present moment! Please select another time.');
										return false;
									}

									if (newIndex === 1 && startint === true && endint === true)
									{

										alert('Please select a time between ' + moment(starttime).format("hh:mm a") + ' - ' + moment(breakstarttime).format("hh:mm a") + ' OR ' + moment(breakendtime).format("hh:mm a") + ' - ' + moment(endtime).format("hh:mm a") + '.');
										return false;
									}
									// Needed in some cases if the user went back (clean up)
									if (currentIndex < newIndex)
									{
										// To remove error styles
										form.find(".body:eq(" + newIndex + ") label.error").remove();
										form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
									}
									form.validate().settings.ignore = ":disabled,:hidden";
									return form.valid();
								},

								onFinishing: function(event, currentIndex)
								{
									// form.validate().settings.ignore = ":disabled";
									return form.valid();
								},
								onFinished: function(event, currentIndex)
								{
									var postdata = form.serializeArray();
									for (var item in postdata)
									{
										if (postdata[item].name == 'datetimepicker' || postdata[item].name == 'tillDate')
										{
											postdata[item].value = moment(postdata[item].value, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm:ss');
										}

									}

									// console.log(postdata);

									$.ajax(
									{
										type: "POST",
										url: baseUrl + 'appointment/bookappointment',
										data: postdata,
										success: function(response)
										{
											// $('#response').html(response);
											if (response == 1)
											{
												$('#appointModal').modal('hide');
												console.log('success');
												location.reload();
											}
											else
											{
												document.getElementById('appointmentError').text('');
												document.getElementById('appointmentError').innerHTML += '<p class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>ERROR!</strong> Please try again!</p>'
											}

										}
									});
								}

							}).validate(
							{
								errorPlacement: function errorPlacement(error, element)
								{
									error.appendTo(element.parent("div").next("div"));
								},
								rules:
								{
									fullname:
									{
										required: true,
										minlength: 3,

									},
									contactNumber:
									{
										required: true,
										minlength: 10,
										maxlength: 10,
										digits: true
									}

								}
							});

						});

					}

				}

			});
		}

	});

}

$('#appointmentCalendar').each(function()
{

	var professionalid = $(this).attr('data-professionalid');
	var setupData = null;
	if (professionalid)
	{
		jQuery.ajax(
		{
			type: "POST",
			url: baseUrl + 'appointment/getappointmentdatafc',
			data:
			{
				professionalid: professionalid
			},
			success: function(resp)
			{
				setupData = resp;
			}
		}).done(function()
		{

			var setupObj = JSON.parse(setupData);
			var breaktime = setupObj.breaktime;
			var days = ["0", "1", "2", "3", "4", "5", "6"];
			days = days.filter(function(el)
			{
				return !(setupObj.weeklyHoliday).includes(el);
			});
			var h = setupObj.duration / 60 | 0,
				m = setupObj.duration % 60 | 0;

			var appointmentCalendar = $('#appointmentCalendar').fullCalendar(
			{
				header:
				{
					left: 'title',
					center: 'agendaDay,agendaWeek,month,listDay',
					right: 'prev,next today'
				},
				//Display Options:

				editable: true,
				firstDay: 1, //1 for monday, 0 for sunday
				selectable: 'true',
				selectOverlap: function(event)
				{
					return event.rendering === 'background';
				},
				selectHelper: true,
				aspectRatio: 1,
				defaultView: 'month',
				timezone: 'local',
				axisFormat: 'h:mm',
				allDaySlot: true,
				noEventsMessage: "No appointments!",
				slotEventOverlap: false,
				displayEventTime: true, //This setting only applies to events that have times (allDay equal to false).
				//If set to true, time text will always be displayed on the event. If set to false, time text will never be displayed on the event.
				scrollTime: setupObj.worktime[0], //time from when the events are showed
				nowIndicator: true,
				lazyFetching: true,
				slotDuration: h + ':' + m + ':00',
				defaultTimedEventDuration: setupObj.duration,
				googleCalendarApiKey: 'AIzaSyAoJ5E1ZTSiPdFrnWJlkWE_yNJuwPuTL-Q',
				forceEventDuration: true,
				minTime: moment(moment(moment(setupObj.worktime[0], "HH:mm:ss").format()).subtract(1, "hours")).format("HH:mm"),
				maxTime: moment(moment(moment(setupObj.worktime[1], "HH:mm:ss").format()).add(1, "hours")).format("HH:mm"),
				eventLimit: true,
				views:
				{
					month:
					{ // name of view
						columnFormat: 'dddd',
						displayEventTime: true,
						// other view-specific options here
					},

					week:
					{
						columnFormat: 'ddd, D/M',
						displayEventTime: true,
						displayEventEnd: true,
						intervalStart: setupObj.worktime[0],
						intervalEnd: setupObj.worktime[1]

					},

					day:
					{
						displayEventTime: true,
						displayEventEnd: true,
						intervalStart: setupObj.worktime[0],
						intervalEnd: setupObj.worktime[1]

					},
					list:
					{
						displayEventTime: true,
						intervalStart: moment()
					}
				},
				//Cancel event
				selectHelper: true,
				eventSources: [

					// your event source
					{
						events: JSON.parse(setupObj.normalAppointment),
						color: 'lightblue',
						textColor: 'black',
						durationEditable: false,
						startEditable: false,
						resourceEditable: false,
						overlap: false,
						constraint: "businessHours",
						eventBorderColor: 'cyan',
						slotEventOverlap: false,
						editable: false,
						className: 'bookedAppointments'

					},
					{
						events: JSON.parse(setupObj.personalHoliday),
						color: 'pink',
						textColor: 'white',
						durationEditable: false,
						startEditable: false,
						resourceEditable: false,
						overlap: false,
						slotEventOverlap: false,
						editable: false,
						className: 'personalHoliday',

					},
					{
						events: JSON.parse(setupObj.weeklyAppointment),
						color: 'darkblue',
						textColor: 'white',
						durationEditable: false,
						startEditable: false,
						resourceEditable: false,
						overlap: false,
						slotEventOverlap: false,
						editable: false,
						className: 'weeklyAppointment',

					},
					// {
					//     googleCalendarId: 'en.indian#holiday@group.v.calendar.google.com',
					//     className: 'gcal-event', // an option!,
					//     color: 'grey',
					//     // allDayDefault:true,
					//     // rendering: 'background',
					//     // editable: true
					// }

				],
				events: [
					{
						id: 'break_hours',
						title: 'Break hour',
						start: setupObj.breaktime[0],
						end: setupObj.breaktime[1],
						rendering: 'background',
						color: 'lightgreen',
						dow: days,
						slotEventOverlap: false,
						editable: false,
						className: 'breakhours'
					},

				],
				businessHours:
				{
					dow: days, // days of week. an array of zero-based day of week integers (0=Sunday)
					start: setupObj.worktime[0],
					end: setupObj.worktime[1],
				},

				eventRender: function(event, element)
				{
					element
						.attr('title', event.title)
						.tooltip();
					if (event.rendering != 'background') element.append("<span class='closeon'>&times;</span>");
					element.find(".closeon").click(function()
					{
						if (event.source['className'] == 'bookedAppointments')
						{
							var cancelAppointConfirm = confirm("Are you sure you want to cancel the Appointment? Once cancellated a cancellation message will be send to the user and cannot be reinstated by you.");
							// var cancelAppointConfirm = confirm("Are you sure you want to cancel the Appointment? Once cancellated a cancellation message will be send to the user, and a fixed amount would be cut from your account, if the period of free cancellation has passed");

							if (cancelAppointConfirm == true)
							{
								var reason = prompt("Reason for cancellation?");
								jQuery.ajax(
								{
									url: baseUrl + 'appointment/cancelappointment',
									type: 'POST',
									data:
									{
										appointmentid: event.id,
										reason: reason,
										appointmenttype: 'normalappointment',
										appointmentdatetime: moment(event.start['_d']).format("DD/MMM/YYYY HH:mm"),
										name: event.title
									},
									success: function(response)
									{
										if (response == 1)
										{
											$('#appointmentCalendar').fullCalendar('removeEvents', event._id);
										}
									}
								});

							}

						}
						else if (event.className == 'nationalHolidays')
						{

							var deleteNationalHolidayConfirm = confirm('Are you sure, you want to delete this holiday from your account? After the holiday is deleted, users will be able to book appointments on this date.');
							if (deleteNationalHolidayConfirm == true)
							{
								jQuery.ajax(
								{
									url: baseUrl + 'appointment/addholiday',
									type: 'POST',
									data:
									{
										appointmentdatetime: moment(event.start['_d']).format("YYYY-MM-DD HH:mm:ss"),
										professionalid: professionalid,
										name: event.title,
										appointmenttype: 'nationalholiday'
									},
									success: function(response)
									{
										if (response == 1)
										{
											$('#appointmentCalendar').fullCalendar('removeEvents', event._id);
										}
									}
								});

							}
						}
						else if (event.source['className'] == 'personalHoliday')
						{
							var deletePersonalHolidayConfirm = confirm('Are you sure, you want to delete this holiday from your account? After the holiday is deleted, users will be able to book appointments on this date.');
							if (deletePersonalHolidayConfirm == true)
							{
								jQuery.ajax(
								{
									url: baseUrl + 'appointment/cancelappointment',
									type: 'POST',
									data:
									{
										appointmentid: event.id,
										appointmenttype: 'personalholiday',
										appointmentdatetime: moment(event.start['_d']).format("DD/MMM/YYYY HH:mm"),
										name: event.title
									},
									success: function(response)
									{
										if (response == 1)
										{
											$('#appointmentCalendar').fullCalendar('removeEvents', event._id);
										}
									}
								});

							}
						}
						else if (event.source['className'] == 'weeklyAppointment')
						{

							var dialog = $('<p>Are you sure?</p>').dialog(
							{

								buttons:
								{
									"Cancel this and all previous appointment, future appointments will be kept.": function()
									{
										var reason = prompt("Reason for cancellation?");

										jQuery.ajax(
										{
											url: baseUrl + 'appointment/cancelsingleweekappointment',
											type: 'POST',
											data:
											{
												appointmentid: event.id,
												reason: reason,
												appointmentdatetime: moment(event.start['_d']).format("YYYY-MM-DD HH:mm:ss"),
												name: event.title
											},
											success: function(response)
											{
												if (response == 1)
												{
													$('#appointmentCalendar').fullCalendar('removeEvents', event._id);
													dialog.dialog('close');
													location.reload();

												}
											}
										});
									},
									"Cancel all repeating appointments from this user, including future appointments": function()
									{
										var reason = prompt("Reason for cancellation?");

										jQuery.ajax(
										{
											url: baseUrl + 'appointment/cancelappointment',
											type: 'POST',
											data:
											{
												appointmentid: event.id,
												reason: reason,
												appointmenttype: 'weeklyappointment',
												appointmentdatetime: moment(event.start['_d']).format("DD/MMM/YYYY HH:mm"),
												name: event.title
											},
											success: function(response)
											{
												if (response == 1)
												{
													$('#appointmentCalendar').fullCalendar('removeEvents', event._id);
													dialog.dialog('close');

												}
											}
										});
									},
									"Do nothing": function()
									{
										dialog.dialog('close');
									}
								}
							});
						}
					});
				},
				select: function(start, end)
				{
					var start = moment(start._d).format("YYYY-MM-DD HH:mm:ss");
					var end = moment(end._d).format("YYYY-MM-DD HH:mm:ss");
					// var duration = moment.duration(end.diff(start)).asMinutes();
					var holidayTitle = prompt("Give a name to your personal holiday:");

					if (holidayTitle != null && holidayTitle != '')
					{
						jQuery.ajax(
						{
							url: baseUrl + 'appointment/addholiday',
							type: 'POST',
							data:
							{
								appointmentdatetime: start,
								professionalid: professionalid,
								name: holidayTitle,
								appointmentend: end,
								appointmenttype: 'personalholiday'
							},
							success: function(response)
							{
								if (response == 1)
								{
									$('#appointmentCalendar').fullCalendar('renderEvent',
									{
										title: holidayTitle,
										start: start,
										end: end,
										className: 'personalHoliday',
										color: 'darkblue',
										textColor: 'white'
									});
								}
							}

						});
					}
					// else
					// {
					//     alert('Holiday not added.');
					// }
				}
			});

		});
	}
});

$(document).on('click', '.cancelappointment', function()
{
	var a_id = $(this).data('appointmentid');
	var a_type = $(this).data('appointmenttype');
	var a_DT = $(this).data('appointmentdatetime');
	// var a_DT = 'Sun Nov 05 2017 19:38:58 GMT+0530';

	if (a_type == 'normalappointment')
	{
		if (confirm('Are you sure you want to cancel your appointment on ' + moment(a_DT).format('DD MMMM YYYY') + ' at ' + moment(a_DT).format('LT') + '?'))
		{
			var reason = prompt('Please tell us the reason of this cancellation?')
			$.ajax(
			{
				url: baseUrl + 'profile/cancelappointmentbyuser',
				type: 'POST',
				data:
				{
					appointmentid: a_id,
					reason: reason,
					type: a_type,
					appointmentdatetime: a_DT
				},
				success: function(response)
				{
					if (response == 1)
					{
						alert("Appointment deleted successfully!");
						dialog.dialog('close');
						location.reload();
					}
				}
			});

		}
	}
	else if (a_type = 'weeklyappointment')
	{
		var dayInNeed = moment(a_DT).day();
		if ((moment().day()) < dayInNeed)
		{
			var thisweek = moment().day(dayInNeed).format('DD MMMM YYYY ' + moment(a_DT).format('HH:mm'));
		}
		else
		{
			var thisweek = moment().add(1, 'weeks').day(dayInNeed).format('DD MMMM YYYY ' + moment(a_DT).format('HH:mm'));
		}

		var dialog = $('<p>Are you sure?</p>').dialog(
		{

			buttons: [
			{
				text: "Cancel appointment on " + thisweek + ", future appointments will be kept.",
				click: function()
				{
					var reason = prompt('Please tell us the reason of this cancellation?')
					$.ajax(
					{
						url: baseUrl + 'profile/cancelsingleweeklybyuser',
						type: 'POST',
						data:
						{
							appointmentid: a_id,
							reason: reason,
							appointmentdatetime: thisweek
						},
						success: function(response)
						{
							if (response == 1)
							{
								alert("Appointment deleted successfully!");
								dialog.dialog('close');
								location.reload();
							}
						}
					});
				}
			},
			{
				text: "Cancel all appointments with this professional.",
				click: function()
				{
					var reason = prompt('Please tell us the reason of this cancellation?')
					$.ajax(
					{
						url: baseUrl + 'profile/cancelappointmentbyuser',
						type: 'POST',
						data:
						{
							appointmentid: a_id,
							reason: reason,
							type: a_type,
							appointmentdatetime: thisweek
						},
						success: function(response)
						{
							if (response == 1)
							{
								alert("Appointment deleted successfully!");
								dialog.dialog('close');
								location.reload();
							}
						}
					});
				}
			},
			{
				text: "Do nothing",
				click: function()
				{
					dialog.dialog('close');
				}
			}]
		});
	}
});
$('body').on('focus', '#since', function(){
	$(this).datetimepicker(
	{
		format: 'DD/MM/YYYY',
		maxDate: moment(),
		viewMode: "years",
		icons:
		{
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'glyphicon glyphicon-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		}
	});
});

$('body').on('focus', '#starttime', function(){
	var $startTime1 = $(this);
	$startTime1.datetimepicker(
	{
		format: 'LT',
		stepping: 60,
		minDate: moment().startOf('day'),
		maxDate: moment().endOf('day'),
		defaultDate: moment("09:00 am", "LT"),
		icons:
		{
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'glyphicon glyphicon-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		}

	});
	$startTime1.on("dp.change", function(e)
	{
		$endTime1.data("DateTimePicker").minDate(e.date);
	});
});

$('body').on('focus','#endtime', function(){
	var $endTime1 = $(this);
	$endTime1.datetimepicker(
	{
		format: 'LT',
		useCurrent: false,
		stepping: 60,
		minDate: moment().startOf('day'),
		maxDate: moment().endOf('day'),
		defaultDate: moment("05:00 pm", "LT"),
		icons:
		{
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'glyphicon glyphicon-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		}

	});

	$endTime1.on("dp.change", function(e)
	{
		$startTime1.data("DateTimePicker").maxDate(e.date);
	});

	$endTime1.on("dp.show", function(e)
	{
		if (!$endTime1.data("DateTimePicker").date())
		{
			var defaultDate = $startTime1.data("DateTimePicker").date().add(1, 'hours');
			$endTime1.data("DateTimePicker").defaultDate(defaultDate);
		}
	});
});

$('body').on('focus','#breakstarttime',function(){
	var $breakstartTime1 = $(this);
	$breakstartTime1.datetimepicker(
	{
		format: 'LT',
		stepping: 60,
		minDate: moment().startOf('day'),
		maxDate: moment().endOf('day'),
		defaultDate: moment("01:00 pm", "LT"),
		icons:
		{
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'glyphicon glyphicon-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		}
	});
	$breakstartTime1.on("dp.change", function(e)
	{
		$breakendTime1.data("DateTimePicker").minDate(e.date);
	});
});

$('body').on('focus','#breakendtime', function(){

	var $breakendTime1 = $(this);
	$breakendTime1.datetimepicker(
	{
		format: 'LT',
		useCurrent: false,
		stepping: 60,
		minDate: moment().startOf('day'),
		maxDate: moment().endOf('day'),
		defaultDate: moment("02:00 pm", "LT"),
		icons:
		{
			time: 'fa fa-clock-o',
			date: 'fa fa-calendar',
			up: 'fa fa-chevron-up',
			down: 'fa fa-chevron-down',
			previous: 'fa fa-chevron-left',
			next: 'fa fa-chevron-right',
			today: 'glyphicon glyphicon-screenshot',
			clear: 'fa fa-trash',
			close: 'fa fa-times'
		}

	});

	$breakendTime1.on("dp.change", function(e)
	{
		$breakstartTime1.data("DateTimePicker").maxDate(e.date);
	});

	$breakendTime1.on("dp.show", function(e)
	{
		if (!$breakendTime1.data("DateTimePicker").date())
		{
			var defaultDate = $breakstartTime1.data("DateTimePicker").date().add(1, 'hours');
			$breakendTime1.data("DateTimePicker").defaultDate(defaultDate);
		}
	});
});

// var $startTime1 = $('#starttime');
// var $endTime1 = $('#endtime');
//
// $startTime1.datetimepicker(
// {
// 	format: 'LT',
// 	stepping: 60,
// 	minDate: moment().startOf('day'),
// 	maxDate: moment().endOf('day'),
// 	defaultDate: moment("09:00 am", "LT"),
// 	icons:
// 	{
// 		time: 'fa fa-clock-o',
// 		date: 'fa fa-calendar',
// 		up: 'fa fa-chevron-up',
// 		down: 'fa fa-chevron-down',
// 		previous: 'fa fa-chevron-left',
// 		next: 'fa fa-chevron-right',
// 		today: 'glyphicon glyphicon-screenshot',
// 		clear: 'fa fa-trash',
// 		close: 'fa fa-times'
// 	}
//
// });
//
// $endTime1.datetimepicker(
// {
// 	format: 'LT',
// 	useCurrent: false,
// 	stepping: 60,
// 	minDate: moment().startOf('day'),
// 	maxDate: moment().endOf('day'),
// 	defaultDate: moment("05:00 pm", "LT"),
// 	icons:
// 	{
// 		time: 'fa fa-clock-o',
// 		date: 'fa fa-calendar',
// 		up: 'fa fa-chevron-up',
// 		down: 'fa fa-chevron-down',
// 		previous: 'fa fa-chevron-left',
// 		next: 'fa fa-chevron-right',
// 		today: 'glyphicon glyphicon-screenshot',
// 		clear: 'fa fa-trash',
// 		close: 'fa fa-times'
// 	}
//
// });
//
// $startTime1.on("dp.change", function(e)
// {
// 	$endTime1.data("DateTimePicker").minDate(e.date);
// });
//
// $endTime1.on("dp.change", function(e)
// {
// 	$startTime1.data("DateTimePicker").maxDate(e.date);
// });
//
// $endTime1.on("dp.show", function(e)
// {
// 	if (!$endTime1.data("DateTimePicker").date())
// 	{
// 		var defaultDate = $startTime1.data("DateTimePicker").date().add(1, 'hours');
// 		$endTime1.data("DateTimePicker").defaultDate(defaultDate);
// 	}
// });
//
// $('.datepicker').datepicker();
//
// var $breakstartTime1 = $('#breakstarttime');
// var $breakendTime1 = $('#breakendtime');
//
// $breakstartTime1.datetimepicker(
// {
// 	format: 'LT',
// 	stepping: 60,
// 	minDate: moment().startOf('day'),
// 	maxDate: moment().endOf('day'),
// 	defaultDate: moment("01:00 pm", "LT"),
// 	icons:
// 	{
// 		time: 'fa fa-clock-o',
// 		date: 'fa fa-calendar',
// 		up: 'fa fa-chevron-up',
// 		down: 'fa fa-chevron-down',
// 		previous: 'fa fa-chevron-left',
// 		next: 'fa fa-chevron-right',
// 		today: 'glyphicon glyphicon-screenshot',
// 		clear: 'fa fa-trash',
// 		close: 'fa fa-times'
// 	}
// });
// $breakendTime1.datetimepicker(
// {
// 	format: 'LT',
// 	useCurrent: false,
// 	stepping: 60,
// 	minDate: moment().startOf('day'),
// 	maxDate: moment().endOf('day'),
// 	defaultDate: moment("02:00 pm", "LT"),
// 	icons:
// 	{
// 		time: 'fa fa-clock-o',
// 		date: 'fa fa-calendar',
// 		up: 'fa fa-chevron-up',
// 		down: 'fa fa-chevron-down',
// 		previous: 'fa fa-chevron-left',
// 		next: 'fa fa-chevron-right',
// 		today: 'glyphicon glyphicon-screenshot',
// 		clear: 'fa fa-trash',
// 		close: 'fa fa-times'
// 	}
//
// });
//
// $breakstartTime1.on("dp.change", function(e)
// {
// 	$breakendTime1.data("DateTimePicker").minDate(e.date);
// });
//
// $breakendTime1.on("dp.change", function(e)
// {
// 	$breakstartTime1.data("DateTimePicker").maxDate(e.date);
// });
//
// $breakendTime1.on("dp.show", function(e)
// {
// 	if (!$breakendTime1.data("DateTimePicker").date())
// 	{
// 		var defaultDate = $breakstartTime1.data("DateTimePicker").date().add(1, 'hours');
// 		$breakendTime1.data("DateTimePicker").defaultDate(defaultDate);
// 	}
// });

//---------------------MESSAGES---------------------------------------------

$('#sendmessageForm').submit(function(e)
{
	e.preventDefault();

	if (!$(this).data("loggedin"))
	{
		$('#messagesModal').modal("hide");
		$('#loginModal').modal("show");
	}

	$.ajax(
	{
		data: $(this).serialize(),
		type: 'POST',
		dataType: 'json',
		beforeSend: function()
		{
			$("#sendmessageForm :input").prop('readonly', true);
			// $("#sendmessageForm :textarea").prop('readonly', true);
		},
		url: baseUrl + 'messages/sendmessagefrombutton',
		success: function(data)
		{
			if (data == 1)
			{
				$('#messagesModal').modal("hide");
				$('<div title="Success"><p>Message Sent Successfully!</p></div>').dialog(
				{
					buttons:
					{
						Ok: function()
						{
							$(this).dialog("close");
						}
					}
				});
				setTimeout(function()
				{
					location.href = baseUrl + "messages"
				}, 5000);
			}
			else if (data != 'loginfirst')
			{
				alert('Error sending message, please go to your messages and check if message thread open or please try again.');
				$("#sendmessageForm :input").prop('readonly', false);
				// $("#sendmessageForm :textarea").prop('readonly', false);
			}

		},
		error: function(e)
		{
			// alert('Error sending message, please go to your messages and check if message thread open or please try again.');
			// $("#sendmessageForm :input").prop('readonly', false);
			// $("#sendmessageForm :textarea").prop('readonly', false);

		}
	});

});

// realtime- referesh in every few seconds..
// if loggedin
var everythingrefresh = null;
var allmessagerefresh = null;
var singlemessagerefresh = null;
var refreshInterval = 60000; // NOTE: refresh interval (1000ms = 1sec)
var singleclicktime = 0;
var backclicktime = 0;

if ($('#menu .navmessages').length > 0)
{
	getUpdatedData('getOnlyMessageCount');
	everythingrefresh = setInterval(function()
	{
		if (currentpage == 'messages')
		{
			// if($('#singlemessage:visible').length > 0) getUpdatedData('getSingleMessage');
			// else
			getUpdatedData('getAllMessage');
		}
		else
		{
			getUpdatedData('getOnlyMessageCount');
		}
	}, refreshInterval);
}

var prevmessagestatus = '';

function getUpdatedData(getwhat, otherdata = null)
{
	var senddata = {};
	if (getwhat == 'getSingleMessage')
	{
		senddata = otherdata;
		senddata['page'] = null;
		senddata['refreshid'] = $('#singlemessage .singlemessagerow').last().data('messageid');
		senddata['lastmessagetext'] = $('#loadsinglemessage .singlemessagerow .message').last().html();
		senddata['noofmessages'] = $('#loadsinglemessage .singlemessagerow').length;
		senddata['initialsender'] = $('#loadsinglemessage input[name="initialsender"]').val();
		senddata['initialrecipient'] = $('#loadsinglemessage input[name="initialrecipient"]').val();
	}
	if (getwhat == 'getAllMessage')
	{
		senddata['refreshtimeinsec'] = refreshInterval / 1000; //sending this because want this and sql compare interval to be same otherwise duplicate or no enty
	}
	senddata['what'] = getwhat;
	// ajax call to get the number of unread messages for a particular user
	$.ajax(
	{
		data: senddata,
		type: 'POST',
		dataType: 'json',
		url: baseUrl + 'messages/getupdate',
		success: function(returndata)
		{
			if ($('#menu .msgcount').length > 0) $('#menu .msgcount').text(returndata.noofunreadmessages);
			else $('#menu .navmessages i').append('<span class="badge msgcount">' + returndata.noofunreadmessages + '</span>');
			// if($(window).width() < 992){$('.navimgcont').append('<span class="badge msgcount">'+returndata.noofunreadmessages+'</span>');}

			if (returndata.hasOwnProperty('singlemessagedata'))
			{
				if (returndata.singlemessagedata != '')
				{
					$('#downtoendmessages').addClass('active');
					$('#loadsinglemessage').append(returndata.singlemessagedata);
				}
				if (prevmessagestatus != returndata.messagestatus && returndata.messagestatus != undefined)
				{
					$("#inputmessage .unpaiduser").remove();
					$("#inputmessage .unpaidprofform").remove();

					$("#inputmessage .initialpayuser").remove();
					$("#inputmessage .exceedpayuser").remove();

					$("#singlemessage .noorderuserhtml").remove();
					$("#singlemessage .exceednoorderuserhtml").remove();

					$("#inputmessage .unpaidprofform").remove();
					$("#inputmessage .unpaidmsgprof").remove();

					$("#inputmessage .closedbyhtml").remove();
					$("#singlemessage .closedbygrace").remove();

					if (returndata.messagestatus == 'ok')
					{
						$("#inputmessagebox :input").attr("disabled", false);
						$("#closemessage").attr("disabled", false);
						tinymce.activeEditor.setMode('design');
					}
					//if unpaid replace by relavant form
					else if (returndata.messagestatus == 'initial_unpaid_user')
					{
						$("#inputmessagebox :input").attr("disabled", true);
						$("#closemessage").attr("disabled", true);
						tinymce.activeEditor.setMode('readonly');
						var unpaiduser = $(returndata.unpaiduser).hide();
						unpaiduser.height($('#inputmessage').outerHeight());
						$('#inputmessage').append(unpaiduser);
						unpaiduser.animate(
						{
							width: "toggle"
						});
					}
					else if (returndata.messagestatus == 'initial_payoption_user')
					{
						$("#inputmessagebox :input").attr("disabled", false);
						$("#closemessage").attr("disabled", false);
						tinymce.activeEditor.setMode('design');
						var payform = $(returndata.unpaidpaymentform).hide();
						payform.css(
						{
							'bottom': $('#inputmessage').outerHeight()
						});
						$('#inputmessage').prepend(payform);
						payform.animate(
						{
							height: "toggle"
						});
					}
					else if (returndata.messagestatus == 'initial_unpaid_prof')
					{
						$("#inputmessagebox :input").attr("disabled", true);
						$("#closemessage").attr("disabled", false);
						tinymce.activeEditor.setMode('readonly');
						var unpaidprof = $(returndata.unpaidprofform);
						unpaidprof.css(
						{
							'min-height': $('#inputmessage').outerHeight()
						});
						$('#inputmessage').append(unpaidprof);
						$('body').append(returndata.accountmodal);
						$('[data-toggle="popover"]').popover();
					}
					else if (returndata.messagestatus == 'exceed_unpaid_user')
					{
						$("#inputmessagebox :input").attr("disabled", true);
						$("#closemessage").attr("disabled", true);
						tinymce.activeEditor.setMode('readonly');
						var payform = $(returndata.unpaidpaymentform);
						payform.css(
						{
							'min-height': $('#inputmessage').outerHeight()
						});
						$('#inputmessage').append(payform);
					}
					else if (returndata.messagestatus == 'exceed_unpaid_prof')
					{
						//disable form
						$("#inputmessagebox :input").attr("disabled", true);
						$("#closemessage").attr("disabled", true);
						tinymce.activeEditor.setMode('readonly');
						// $('#inputmessage').html('');
						var exceedprof = $(returndata.unpaidmsgprof).hide();
						exceedprof.height($('#inputmessage').outerHeight());
						$('#inputmessage').append(exceedprof);
						exceedprof.animate(
						{
							width: "toggle"
						});
						// singlemessageheight();
					}
					//if closed by prof and within grace period
					else if (returndata.messagestatus == 'closedgrace')
					{
						$("#inputmessagebox :input").attr("disabled", false);
						$("#closemessage").attr("disabled", true);
						tinymce.activeEditor.setMode('design');
						var closedgrace = $(returndata.closedbygrace).hide();
						closedgrace.css(
						{
							'bottom': $('#inputmessage').outerHeight()
						});
						closedgrace.insertBefore('#inputmessage');
						closedgrace.animate(
						{
							height: "toggle"
						});

					}
					//if closedby replace by closed by div
					else if (returndata.messagestatus == 'closed')
					{
						//disable form
						$("#inputmessagebox :input").attr("disabled", true);
						$("#closemessage").attr("disabled", true);
						tinymce.activeEditor.setMode('readonly');
						// $('#inputmessage').html('');
						var closedhtml = $(returndata.closedbyhtml).hide();
						closedhtml.height($('#inputmessage').outerHeight());
						$('#inputmessage').append(closedhtml);
						closedhtml.animate(
						{
							width: "toggle"
						});
						// singlemessageheight();
					}
					else if (returndata.messagestatus == 'noorderuser')
					{
						$("#inputmessagebox :input").attr("disabled", false);
						$("#closemessage").attr("disabled", false);
						tinymce.activeEditor.setMode('design');
						var noorderuserhtml = $(returndata.noorderuserhtml).hide();
						noorderuserhtml.css(
						{
							'bottom': $('#inputmessage').outerHeight()
						});
						noorderuserhtml.insertBefore('#inputmessage');
						noorderuserhtml.animate(
						{
							height: "toggle"
						});

					}
					else if (returndata.messagestatus == 'exceednoorderuser')
					{
						//disable form
						$("#inputmessagebox :input").attr("disabled", true);
						$("#closemessage").attr("disabled", true);
						tinymce.activeEditor.setMode('readonly');
						// $('#inputmessage').html('');
						var noorderuserhtml = $(returndata.noorderuserhtml).hide();
						noorderuserhtml.height($('#inputmessage').outerHeight());
						$('#inputmessage').append(noorderuserhtml);
						noorderuserhtml.animate(
						{
							width: "toggle"
						});
						// singlemessageheight();
					}
				}
				prevmessagestatus = returndata.messagestatus;

			}
			else if (returndata.hasOwnProperty('allmessageshtml'))
			{
				//find all message rows with data-threadid same as return data and remove them
				$.each(returndata.allthreadids, function(index, value)
				{
					$('#allmessages .messagerow[data-threadid="' + value + '"]').remove();
				});
				// var newmsg = $(returndata.allmessageshtml).hide();
				// $('#allmessages').prepend(newmsg);.
				// newmsg.show("slide", { direction: "left" }, 1000);
				$('#allmessages').prepend(returndata.allmessageshtml);
			}

		}

	});
}
$('#singlemessage #downtoendmessages').on('click', function()
{
	$(this).removeClass('active');
	$("#loadsinglemessage").scrollTop($("#loadsinglemessage")[0].scrollHeight);
});

var loadmoremessages = 2;

$('#loadmoremessages').on('click', function()
{
	if (loadmoremessages != 0) loadmoremessages++;
	loadallmessages();
});

function loadallmessages()
{
	$.ajax(
	{
		data:
		{
			page: loadmoremessages
		},
		type: 'POST',
		url: baseUrl + 'messages/loadmoremessages',
		beforeSend: function()
		{
			$('.loader').show();
			$('#loadmoremessages').hide();
		},
		complete: function()
		{
			$('.loader').hide();
			if (loadmoremessages == 0) $('#loadmoremessages').hide();
			else $('#loadmoremessages').show();

		},
		success: function(html)
		{
			if (html != false)
			{
				$("#allmessages").append(html);
			}
			else
			{
				$("#allmessages").append("<p class='endresult'>---- end of messages ----</p>");
				$('#allmessages .endresult').show();
				loadmoremessages = 0;

			}
		},

	});
}

//From single message to all message
$('#backtomessages').on('click', function()
{
	// time when back message is clicked
	var d = new Date();
	backclicktime = d.getTime();
	if (backclicktime - singleclicktime > refreshInterval)
	{
		// only if sufficient time is passed then do this.. otherwise too many calls and the loading will be too slow
		loadmoremessages = 1;
		$('#allmessages').empty();
		loadallmessages();
	}
	//clear singlemessage refresh timer and after a certain time refresh..
	clearInterval(singlemessagerefresh);
	allmessagerefresh = setInterval(function()
	{
		getUpdatedData('getAllMessage');
	}, refreshInterval);

	$('#allmessages').show();
	$('.allmessages').show();
	$('#singlemessage').hide('explode',
	{
		pieces: 25
	}, 600);
	$('#loadsinglemessage').empty();
	$('#loadmoresinglemessages').remove();
	$('#singlemessage .endresult').remove();
	loadmoresinglemessages = 1;
	getparentpage = 1;
	document.getElementById("inputmessagebox").reset();
	tinymce.activeEditor.setContent('');
	tinymce.activeEditor.undoManager.clear();

});

if ($('#inputmessagebox').length > 0)
{
	// insert message, editor
	tinymce.init(
	{
		selector: "#inputmessagetext",
		autofocus: "#inputmessagetext",
		theme: 'modern',
		toolbar_items_size: "small",
		forced_root_block: 'p',
		readonly: 1,
		valid_elements: 'a[href|target=_blank],strong/b,em/i,div,p,table',
		plugins: [
			'advlist autolink lists link',
			'table contextmenu paste preview'
		],
		browser_spellcheck: true,
		toolbar: 'undo redo paste | bold italic underline | bullist numlist | table | link attachment | preview',
		content_css: '//www.tinymce.com/css/codepen.min.css',
		menubar: false,
		statusbar: false,
		draggable_modal: false,
		entity_encoding: "named",
		verify_html: true,
		smart_paste: false,
		paste_auto_cleanup_on_paste: true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		paste_as_text: true,
		paste_word_valid_elements: "b,strong,i,em,a",
		paste_data_images: false,
		allow_conditional_comments: false,
		allow_html_in_named_anchor: false,
		allow_unsafe_link_target: false,
		invalid_styles: 'color, font-size, background, background-color, width,  th: width height,td:width Height',
		keep_styles: false,
		valid_styles:
		{
			'*': ' '
		},
		convert_fonts_to_spans: true,
		table_appearance_options: false,
		table_clone_elements: "strong,b,i,em,a,tr",
		table_advtab: false,
		table_cell_advtab: false,
		table_row_advtab: false,
		table_resize_bars: false,
		table_responsive_width: true,
		table_default_attributes:
		{
			class: 'lightgreyBorderTable'
		},
		formats:
		{
			bold:
			{
				inline: 'b'
			},
			italic:
			{
				inline: 'i'
			},
			underline:
			{
				inline: 'span',
				'classes': 'textunderline',
				exact: true
			},
			strikethrough:
			{
				inline: 'span',
				'classes': 'textstrikethrough'
			},
		},
		style_formats: [

			{
				title: 'Inline',
				items: [
				{
					title: 'Bold',
					icon: 'bold',
					format: 'bold'
				},
				{
					title: 'Italic',
					icon: 'italic',
					format: 'italic'
				},
				{
					title: 'Underline',
					icon: 'underline',
					format: 'underline'
				},
				{
					title: 'Strikethrough',
					icon: 'strikethrough',
					format: 'strikethrough'
				},
				{
					title: 'Superscript',
					icon: 'superscript',
					format: 'superscript'
				},
				{
					title: 'Subscript',
					icon: 'subscript',
					format: 'subscript'
				}, ]
			},
			{
				title: 'Blocks',
				items: [
				{
					title: 'Paragraph',
					format: 'p'
				},
				{
					title: 'Blockquote',
					format: 'blockquote'
				}]
			}
		],
		setup: function(editor)
		{ //hide toolbar outof focus
			editor.on('focus', function()
			{
				$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").show();
				if ($('#singlemessage .closedbygrace').length > 0) $('#singlemessage .closedbygrace').css(
				{
					'bottom': $('#inputmessage').outerHeight()
				});
				if ($('#singlemessage .initialpayuser').length > 0) $('#singlemessage .initialpayuser').css(
				{
					'bottom': $('#inputmessage').outerHeight()
				});
				if ($('#singlemessage .noorderuserhtml ').length > 0) $('#singlemessage .noorderuserhtml ').css(
				{
					'bottom': $('#inputmessage').outerHeight()
				});
			});
			editor.on('blur', function()
			{
				$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();
				if ($('#singlemessage .closedbygrace').length > 0) $('#singlemessage .closedbygrace').css(
				{
					'bottom': $('#inputmessage').outerHeight()
				});
				if ($('#singlemessage .initialpayuser').length > 0) $('#singlemessage .initialpayuser').css(
				{
					'bottom': $('#inputmessage').outerHeight()
				});
				if ($('#singlemessage .noorderuserhtml').length > 0) $('#singlemessage .noorderuserhtml').css(
				{
					'bottom': $('#inputmessage').outerHeight()
				});

			});
			editor.on("init", function()
			{
				$(this.contentAreaContainer.parentElement).find("div.mce-toolbar-grp").hide();
				document.getElementById("inputmessagebox").reset();
				tinymce.activeEditor.setContent('');
				tinymce.activeEditor.undoManager.clear();
				// if(typeof editor.getContent() == 'undefined' || editor.getContent() == '')
				$('#sendpersonalmessage').click(function()
				{
					if (typeof editor.getContent() == 'undefined' || editor.getContent() == '') $('#inputmessagebox div.mce-edit-area').css(
					{
						'border': 'thin outset red'
					});
				});
				// else $('#inputmessagebox div.mce-edit-area').css({'border' : ''});
			});
			editor.on('change', function()
			{
				tinymce.triggerSave();

				if (typeof editor.getContent() == 'undefined' || editor.getContent() == '') $('#sendpersonalmessage').click(function()
				{
					$('#inputmessagebox div.mce-edit-area').css(
					{
						'border': 'thin outset red'
					});
				});
				else $('#inputmessagebox div.mce-edit-area').css(
				{
					'border': ''
				});

			});
			editor.addButton('attachment',
			{
				icon: 'fa fa-upload',
				tooltip: 'Attach File/Image',
				onclick: function()
				{
					// var input = document.createElement('input');
					// input.setAttribute('type', 'file');
					// input.setAttribute('accept', 'image/gif, image/jpeg,image/jpg, image/png');
					// input.setAttribute('name', 'attachment');
					// input.setAttribute('id', 'inputmessageattachment');
					// input.setAttribute('class', 'col-xs-6');
					// document.getElementById("inputmessagebox").appendChild(input);
					var input = document.getElementById('inputmessageattachment');
					$(input).removeClass('hidden');
					$('#removeinputmessageattachment').removeClass('hidden');
					input.click();
					//validate for file input type
					$(input).on('change', function()
					{
						if (!$('#inputmessagebox').validate().element('#inputmessageattachment')) input.value = '';
						// $('#inputmessageattachment').val('');
						//   console.log(input);
						//    var filePath = input.value;
						//    var allowedExtensions = /(\.bmp|\.gif|\.ico|\.jpeg|\.jpg|\.png|\.odp|\.pps|\.ppt|\.pptx|\.ods|\.xlr|\.xls|\.xlsx|\.doc|\.docx|\.odt|\.pdf|\.rtf|\.txt)$/i;
						//    if(!allowedExtensions.exec(filePath)){
						//        // alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
						//        $("<div><p class='largetext'>Please only upload images or text files.</p><p id='errordetails' class='smalltext handcursor bluetext'>Valid file types <i class='fa fa-caret-down' aria-hidden='true'></i><p class='alert alert-warning displaynone' id='errorext'>.bmp, .gif, .ico, .jpeg, .jpg, .png, .odp, .pps, .ppt, .pptx, .ods, .xlr, .xls, .xlsx, .doc, .docx, .odt, .pdf, .rtf, .txt</p></p></div>").dialog({
						//              title: 'ERROR!',
						//              modal: true,
						//              open: function(){
						//                // var errortext = "";
						//               $(this).parent().find('.ui-dialog-title').prepend("<i class='fa fa-exclamation-triangle redtext xxlargetext' aria-hidden='true'> </i> ");
						//                $('#errordetails').click(function(){
						//                  $('#errorext').slideToggle('slow');
						//                });
						//              },
						//               buttons: {
						//                       "OK": function () {
						//                       $(this).dialog('close');
						//                   }
						//               }
						//            }).prev(".ui-widget-header").css({"background": "darkred", 'color': 'white', 'font-size':'x-large'});
						//        input.value = '';
						//        return false;
						//    }
					});
				}
			});

		}
	});
}

$(document).on('click', '#removeinputmessageattachment', function()
{
	var input = document.getElementById('inputmessageattachment');
	input.value = '';
	$(input).addClass('hidden');
	$('#removeinputmessageattachment').addClass('hidden');
	inputmessageformvalidator.resetForm();
});

function singlemessageheight(otherheights = 0)
{
	var navHeight = $('#menu').height();
	var smh = window.innerHeight - navHeight;
	$('#singlemessage').height(smh);
	$('#singlemessage').show('explode',
	{
		pieces: 25
	}, 600);

	var lsmh = smh - $('#inputmessage').outerHeight() - otherheights;
	$('#loadsinglemessage').height(lsmh);
}

var loadmoresinglemessages = 1;

$(document).on('click', '.messagerow', function()
{
	// time when the single message is opened:
	var d = new Date();
	singleclicktime = d.getTime()

	$('#allmessages').hide();
	$('.allmessages').hide();
	$('.endresult').hide();

	singlemessageheight();

	var key = $(this).data('messagedivkey');

	$('#messagerow_' + key).removeClass(" boldtext whitesmokeBack ");
	$('#messagerow_' + key).addClass("greytext");
	var named = document.getElementById("messagerow_" + key);
	var tags = named.getElementsByTagName("input");
	var messagedata = {};
	for (var i = 0, n = tags.length; i < n; i = i + 1)
	{
		messagedata[tags[i].name] = tags[i].value;
	}
	messagedata['page'] = loadmoresinglemessages;
	loadsinglemessages(messagedata);

	// clear all refersh....
	clearInterval(everythingrefresh);
	clearInterval(allmessagerefresh);

	// update single message at set interval...
	singlemessagerefresh = setInterval(function()
	{
		getUpdatedData('getSingleMessage', messagedata);
	}, refreshInterval);

});

// GET MESSAGES TILL PARENT MESSAGE WHEN LINK TO PARENT IS CLICKED (when non-sequencial)
var getparentpage = 1;
var gettingparent = 0;
$(document).on('click', '#singlemessage .linktoparent', function()
{
	gettingparent = 1;

	var messageids = [];
	$('#singlemessage .singlemessagerow').each(function()
	{
		messageids.push($(this).data("messageid"));
	});

	if (messageids.indexOf(($(this).data('parenttoget'))) > -1)
	{
		var parentelement = document.querySelectorAll("[data-messageid='" + $(this).data('parenttoget') + "']")[0];
		parentelement.scrollIntoView();
	}
	else
	{
		//no need to increase page for parent sql logic
		var named = document.getElementById("singlemessage");
		var tags = named.getElementsByTagName("input");
		var messagedata = {};
		for (var i = 0, n = tags.length; i < n; i = i + 1)
		{
			messagedata[tags[i].name] = tags[i].value;
		}
		messagedata['page'] = loadmoresinglemessages;
		messagedata['getparent'] = true;
		messagedata['getparentpage'] = getparentpage;
		$.extend(messagedata, $(this).data());
		loadsinglemessages(messagedata);
		getparentpage++;
	}

});

$(document).on('click', '#singlemessage #loadmoresinglemessages', function()
{
	// if(loadmoresinglemessages != 0) loadmoresinglemessages++;
	loadmoresinglemessages = $(this).data('pageno') + 1;
	var named = document.getElementById("singlemessage");
	var tags = named.getElementsByTagName("input");
	var messagedata = {};
	for (var i = 0, n = tags.length; i < n; i = i + 1)
	{
		messagedata[tags[i].name] = tags[i].value;
	}
	messagedata['page'] = loadmoresinglemessages;
	messagedata['getparentpage'] = getparentpage;

	loadsinglemessages(messagedata);

});

function loadsinglemessages(messagedata)
{
	// console.log(messagedata);
	$.ajax(
	{
		type: 'POST',
		data: messagedata,
		dataType: 'json',
		url: baseUrl + 'messages/opensinglemessage',
		beforeSend: function()
		{
			$('#loadmoresinglemessages').remove();
			if (messagedata['page'] == 1)
			{
				$("#loadsinglemessage").prepend('<p class ="thisloader loader"> <i class= "fa fa-spinner fa-pulse fa-2x"></i></p>');

				$("#inputmessage .unpaiduser").remove();
				$("#inputmessage .unpaidprofform").remove();

				$("#inputmessage .initialpayuser").remove();
				$("#inputmessage .exceedpayuser").remove();

				$("#singlemessage .noorderuserhtml").remove();
				$("#singlemessage .exceednoorderuserhtml").remove();

				$("#inputmessage .unpaidprofform").remove();
				$("#inputmessage .unpaidmsgprof").remove();

				$("#inputmessage .closedbyhtml").remove();
				$("#singlemessage .closedbygrace").remove();

			}
			else $("#loadsinglemessage").prepend('<p class ="thisloader lightgreytext paddingtop5per paddingleft50per"> <i class= "fa fa-circle-o-notch fa-spin fa-2x"></i></p>');
			$('#singlemessage .linktoparent').css(
			{
				"cursor": 'none'
			});

		},
		complete: function()
		{
			if (loadmoremessages == 0) $('#loadmoresinglemessages').remove();
			else $('#loadmoresinglemessages').show();
			$('#loadsinglemessage .thisloader').remove();
			$('#singlemessage .linktoparent').css(
			{
				"cursor": 'pointer'
			});

		},
		success: function(returndata)
		{
			var singlemessagediv = $("#loadsinglemessage");
			if (returndata.error)
			{
				singlemessagediv.prepend(returndata.error);
			}
			if (returndata.singlemessagedata != false)
			{
				singlemessagediv.prepend(returndata.singlemessagedata);

				if (gettingparent == 1)
				{
					singlemessagediv.scrollTop(0);
					gettingparent = 0;

				}
				else
				{
					var lastelement = document.getElementById('singlemessagerow_0');
					lastelement.scrollIntoView();
				}
				if (returndata.hasOwnProperty('lastparentid'))
				{
					if ($('#loadsinglemessage .lastparentid').length > 0)
						singlemessagediv.append("<input type='hidden' class='lastparentid' name ='lastparentid' value='" + returndata.lastparentid + "' /><input type='hidden' class='lastparenttext' name ='lastparenttext' value='" + returndata.lastparenttext + "' />");
					else
					{
						$('#loadsinglemessage .lastparentid').val(returndata.lastparentid);
						$('#loadsinglemessage .lastparenttext').val(returndata.lastparenttext);
					}
				}
			}
			if (messagedata['page'] == 1)
			{
				if (returndata.messagestatus == 'ok')
				{
					$("#inputmessagebox :input").attr("disabled", false);
					$("#closemessage").attr("disabled", false);
					tinymce.activeEditor.setMode('design');

				}
				//if unpaid replace by relavant form
				else if (returndata.messagestatus == 'initial_unpaid_user')
				{
					$("#inputmessagebox :input").attr("disabled", true);
					$("#closemessage").attr("disabled", true);
					tinymce.activeEditor.setMode('readonly');
					var unpaiduser = $(returndata.unpaiduser).hide();
					unpaiduser.height($('#inputmessage').outerHeight());
					$('#inputmessage').append(unpaiduser);
					unpaiduser.animate(
					{
						width: "toggle"
					});
				}
				else if (returndata.messagestatus == 'initial_payoption_user')
				{
					$("#inputmessagebox :input").attr("disabled", false);
					$("#closemessage").attr("disabled", false);
					tinymce.activeEditor.setMode('design');
					var payform = $(returndata.unpaidpaymentform).hide();
					payform.css(
					{
						'bottom': $('#inputmessage').outerHeight()
					});
					$('#inputmessage').prepend(payform);
					payform.animate(
					{
						height: "toggle"
					});
				}
				else if (returndata.messagestatus == 'initial_unpaid_prof')
				{
					$("#inputmessagebox :input").attr("disabled", true);
					$("#closemessage").attr("disabled", false);
					tinymce.activeEditor.setMode('readonly');
					var unpaidprof = $(returndata.unpaidprofform);
					unpaidprof.css(
					{
						'min-height': $('#inputmessage').outerHeight()
					});
					$('#inputmessage').append(unpaidprof);
					$('body').append(returndata.accountmodal);
					$('[data-toggle="popover"]').popover();
				}
				else if (returndata.messagestatus == 'exceed_unpaid_user')
				{
					$("#inputmessagebox :input").attr("disabled", true);
					$("#closemessage").attr("disabled", true);
					tinymce.activeEditor.setMode('readonly');
					var payform = $(returndata.unpaidpaymentform);
					payform.css(
					{
						'min-height': $('#inputmessage').outerHeight()
					});
					$('#inputmessage').append(payform);
				}
				else if (returndata.messagestatus == 'exceed_unpaid_prof')
				{
					//disable form
					$("#inputmessagebox :input").attr("disabled", true);
					$("#closemessage").attr("disabled", true);
					tinymce.activeEditor.setMode('readonly');
					// $('#inputmessage').html('');
					var exceedprof = $(returndata.unpaidmsgprof).hide();
					exceedprof.height($('#inputmessage').outerHeight());
					$('#inputmessage').append(exceedprof);
					exceedprof.animate(
					{
						width: "toggle"
					});
					// singlemessageheight();
				}
				//if closed by prof and within grace period
				else if (returndata.messagestatus == 'closedgrace')
				{
					$("#inputmessagebox :input").attr("disabled", false);
					$("#closemessage").attr("disabled", true);
					tinymce.activeEditor.setMode('design');
					var closedgrace = $(returndata.closedbygrace).hide();
					closedgrace.css(
					{
						'bottom': $('#inputmessage').outerHeight()
					});
					closedgrace.insertBefore('#inputmessage');
					closedgrace.animate(
					{
						height: "toggle"
					});

				}
				//if closedby replace by closed by div
				else if (returndata.messagestatus == 'closed')
				{
					//disable form
					$("#inputmessagebox :input").attr("disabled", true);
					$("#closemessage").attr("disabled", true);
					tinymce.activeEditor.setMode('readonly');
					// $('#inputmessage').html('');
					var closedhtml = $(returndata.closedbyhtml).hide();
					closedhtml.height($('#inputmessage').outerHeight());
					$('#inputmessage').append(closedhtml);
					closedhtml.animate(
					{
						width: "toggle"
					});
					// singlemessageheight();
				}
				else if (returndata.messagestatus == 'noorderuser')
				{
					$("#inputmessagebox :input").attr("disabled", false);
					$("#closemessage").attr("disabled", false);
					tinymce.activeEditor.setMode('design');
					var noorderuserhtml = $(returndata.noorderuserhtml).hide();
					noorderuserhtml.css(
					{
						'bottom': $('#inputmessage').outerHeight()
					});
					noorderuserhtml.insertBefore('#inputmessage');
					noorderuserhtml.animate(
					{
						height: "toggle"
					});

				}
				else if (returndata.messagestatus == 'exceednoorderuser')
				{
					//disable form
					$("#inputmessagebox :input").attr("disabled", true);
					$("#closemessage").attr("disabled", true);
					tinymce.activeEditor.setMode('readonly');
					// $('#inputmessage').html('');
					var noorderuserhtml = $(returndata.noorderuserhtml).hide();
					noorderuserhtml.height($('#inputmessage').outerHeight());
					$('#inputmessage').append(noorderuserhtml);
					noorderuserhtml.animate(
					{
						width: "toggle"
					});
					// singlemessageheight();
				}
				prevmessagestatus = returndata.messagestatus;
			}

			return true;

		},
		error: function(e)
		{
			console.log(e);
		}

	});
}

// close a message thread when completed conversion - from user side
$('#closemessage').on('click', function()
{
	$('#confirmmessagedelete').remove();
	var threadid = $(this).parent().siblings('#loadsinglemessage').find('input[name="threadid"]').val();
	$('<div id="confirmmessagedelete" title="Close Messaging Session"><h5>Are you sure you want to close this messaging session?</h5><p> This action is <span class="error">IRREVERSABLE</span> and you cannot message the other person unless a new messaging session is opened.</p><p><b>Please make sure the issue is resolved.</b></p><form class="form" autocomplete="off"><label><p>Please write "<b>close</b>" in the below, in order to confirm this action</p></label><input class="form-control" type="text" style="z-index:10000" name="confirmdelete"/></form></div>').dialog(
	{
		width: 'auto',
		height: 'auto',
		modal: true,
		open: function()
		{
			$(this).parent().find('.ui-dialog-title').prepend("<i class='fa fa-exclamation-triangle' aria-hidden='true'> </i> ");
			$(this).keypress(function(e)
			{
				if (e.keyCode == $.ui.keyCode.ENTER)
				{
					e.preventDefault();
					$(this).parent().find("button:eq(1)").trigger("click");
				}
			});
		},
		// focus: function() {
		//     $(this).on("keyup", function(e) {
		//         if (e.keyCode === 13) {
		//           e.preventDefault();
		//           console.log($(this).parent().find("button:eq(0)"));
		//
		//             $(this).parent().find("button:eq(0)").trigger("click");
		//             return false;
		//         }
		//     });
		// },
		buttons:
		{
			'OK': function()
			{
				var confirmdelete = $('#confirmmessagedelete input[name="confirmdelete"]').val().toLowerCase();
				if (confirmdelete === 'close')
				{

					$.ajax(
					{
						type: 'POST',
						data:
						{
							'confirmdelete': confirmdelete,
							'threadid': threadid
						},
						dataType: 'json',
						url: baseUrl + "messages/closemessage",
						success: function(returndata)
						{
							if (returndata)
							{
								if (returndata.messagestatus == 'closedgrace')
								{
									$("#inputmessagebox :input").attr("disabled", false);
									$("#closemessage").attr("disabled", true);
									tinymce.activeEditor.setMode('design');
									var closedgrace = $(returndata.closedbygrace).hide();
									closedgrace.css(
									{
										'bottom': $('#inputmessage').outerHeight()
									});
									closedgrace.insertBefore('#inputmessage');
									closedgrace.animate(
									{
										height: "toggle"
									});

								}
								//if closedby replace by closed by div
								else if (returndata.messagestatus == 'closed')
								{
									//disable form
									$("#inputmessagebox :input").attr("disabled", true);
									$("#closemessage").attr("disabled", true);
									tinymce.activeEditor.setMode('readonly');
									// $('#inputmessage').html('');
									var closedhtml = $(returndata.closedbyhtml).hide();
									closedhtml.height($('#inputmessage').outerHeight());
									$('#inputmessage').append(closedhtml);
									closedhtml.animate(
									{
										width: "toggle"
									});
									// singlemessageheight();
								}
								else if (returndata.messagestatus == 'error')
								{
									$('body').prepend('<div id = "flashcontainer" class="flashcontainer"><div class="fail flashmessage">' + returndata.errorhtml.join('<br>') + '</div></div>');
									$('.flashcontainer').css(
									{
										'top': $('#menu').height()
									});
									$('#flashcontainer').addClass('showing');
									setTimeout(function()
									{
										$('#flashcontainer').removeClass('showing');
									}, 5000);
								}
							}
						}
					});
				}
				else
				{
					alert('Wrong Value! Messages won\'t be closed.');
				}
				$(this).dialog('close');

			},
			'Cancel': function()
			{
				$(this).dialog('close');
			}
		}
	}).prev(".ui-widget-header").css(
	{
		"background": "darkred",
		'color': 'gold',
		'font-size': 'x-large'
	});

});

//get attachment on click of buttons -- it better not to use ajax?
//
// $(document).on('submit','#getmyattachmentform', function(e) {
//     e.preventDefault();
//     var formValue = $(this).serialize();
//   $.ajax({
//       type: 'POST',
//       data: formValue,
//       dataType: 'json',
//       url: baseUrl + 'messages/downloadattachment',
//       success: function(r)
//       {
//         console.log(r);
//
//       }
//     });
// });

//Send message in reference to the message clicked
$(document).on('click', '#singlemessage #refertothismessage', function()
{

	var texttoadd = $(this).parent().siblings().find('.message').html();
	var messageid = $(this).parent().parent().data('messageid');

	if ($('#inputmessage .refermessagepreview').length > 0) $('.refermessagepreview').remove();

	$('#inputmessage').prepend("<div class='refermessagepreview alert alert-info'><i class='fa fa-times' id='closerefermessagepreview'></i>" + texttoadd + "</div>");

	if ($('#referencemessageid').length > 0)
	{
		document.getElementById("referencemessageid").value = messageid;
		document.getElementById("referencemessagetext").value = texttoadd;
	}
	else
	{
		$('#inputmessagebox').append('<input type="hidden" id="referencemessageid" name="parentid" value=' + messageid + ' />');
		$('#inputmessagebox').append('<input type="hidden" id="referencemessagetext" name="parenttext" value="' + texttoadd + '" />');
	}
});
$(document).on('click', '#inputmessage #closerefermessagepreview', function()
{
	$('.refermessagepreview').remove();
	$('#referencemessageid').remove();
	$('#referencemessagetext').remove();
});

// $(document).on('change', '#inputmessagebox #inputmessageattachment', function(){
//   $('#inputmessagebox').validate().element('#inputmessageattachment');
//   $('#inputmessageattachment').val('');
// });

$(document).on('click', '#inputmessagebox #validextensions', function()
{
	// alert('(<li>bmp</li><li>gif</li><li>ico</li><li>jpe?g</li><li>png</li><li>odp</li><li>pps</li><li>ppt</li><li>pptx</li><li>ods</li><li>xlr</li><li>xls</li><li>xlsx</li><li>doc</li><li>docx</li><li>odt</li><li>pdf</li><li>rtf</li><li>txt</li>)');
	// <p class='largetext'>Please only upload images or text files.</p><p class='smalltext bluetext boldtext'>Valid file types <i class='fa fa-caret-down' aria-hidden='true'></i></p>
	$("<div class='body'><div class='row'><div class='col-xs-5'> <label for='listimages' class='boldtext'>Images</label><ul id='listimages' class='listdisk paddingleft20per'><li>bmp</li><li>gif</li><li>jpe?g</li><li>png</li></ul></div><div class='col-xs-6'><label for='listtext' class='boldtext'>Text files</label><ul id='listtext' class='listdisk paddingleft20per'><li>doc</li><li>docx</li><li>odt</li><li>pdf</li><li>rtf</li><li>txt</li></ul></div></div><div class='row'> <div class='col-xs-5'><label for='listppt' class='boldtext'>Presentation</label><ul id='listppt' class='listdisk paddingleft20per'>  <li>odp</li><li>pps</li><li>ppt</li><li>pptx</li></ul></div><div class='col-xs-6'><label for='listexcel' class='boldtext'>Spreadsheet</label>     <ul id='listexcel' class='listdisk paddingleft20per'><li>ods</li><li>xls</li><li>xlsx</li> </ul></div></div></div>").dialog(
	{
		title: 'Valid File Types',
		modal: true,
		open: function()
		{
			// var errortext = "";
			$(this).parent().find('.ui-dialog-title').prepend("<i class='fa fa-exclamation-triangle xxlargetext' aria-hidden='true'> </i> ");

		},
		buttons:
		{
			"OK": function()
			{
				$(this).dialog('close');
			}
		}
	}).prev(".ui-widget-header").css(
	{
		"background": "cornflowerblue",
		'color': 'white',
		'font-size': 'x-large'
	});
});

// send initial message from prof(message page)
$(document).on('submit', '#initialMessageProfForm', function(e)
{
	e.preventDefault();

	var inputmessage = $(this).serializeArray();

	if (!document.inputmessageform.parentid)
	{
		var messageids = [];
		$('#singlemessage .singlemessagerow').each(function()
		{
			messageids.push($(this).data("messageid"));
		});
		inputmessage.push(
		{
			name: 'parentid',
			value: messageids[messageids.length - 1]
		});
	}
	var named = $(this).parent().parent().parent();
	var tags = named.find("input");
	var messagedata = {};
	for (var i = 0, n = tags.length; i < n; i = i + 1)
	{
		messagedata[tags[i].name] = tags[i].value;
	}
	inputmessage.push(
	{
		name: 'threadid',
		value: messagedata['threadid']
	});
	inputmessage.push(
	{
		name: 'userid',
		value: messagedata['userid']
	});
	inputmessage.push(
	{
		name: 'username',
		value: messagedata['username']
	});
	inputmessage.push(
	{
		name: 'useremail',
		value: messagedata['useremail']
	});

	$.ajax(
	{
		type: 'POST',
		data: inputmessage,
		dataType: 'json',
		url: baseUrl + 'messages/initialprofmessage',
		beforeSend: function()
		{
			$("#initialMessageProfForm :input").prop('disabled', true);
			$("#initialMessageProfForm label:first").append('<span class ="thisloader xsmalltext greentext boldtext"> <i class= "fa fa-circle-o-notch fa-spin"></i> sending....</span>');
		},
		complete: function()
		{
			$("#initialMessageProfForm :input").prop('disabled', false);
			$('#initialMessageProfForm .thisloader').remove();
		},
		success: function(message)
		{

			if (message.hasOwnProperty('messageid') && message.messageid != null)
			{
				if ($('#inputmessage .refermessagepreview').length > 0) $('.refermessagepreview').remove();
				document.inputmessageform.reset();
				tinymce.activeEditor.setContent('');
				tinymce.activeEditor.undoManager.clear();

				$('body').prepend('<div id = "flashcontainer" class="flashcontainer"><div class="success flashmessage">SENT!</div></div>');
				$('.flashcontainer').css(
				{
					'top': $('#menu').height()
				});
				$('#flashcontainer').addClass('showing');
				setTimeout(function()
				{
					$('#flashcontainer').removeClass('showing');
				}, 1000);
				//add to present view, and for future replies
				var parentdiv = '';
				var nowdate = moment(new Date()).format("DD MMMM YYYY, HH:mm");
				if ($('#referencemessageid').length) parentdiv = "<div class='linktoparent alert alert-warning'><span class='boldtext'><i class='fa fa-reply' aria-hidden='true'></i> reference to </span>" + $('#referencemessagetext').val() + "</div>";

				$('#loadsinglemessage').append(parentdiv + "<div class='col-xs-12 singlemessagerow lightgreybottomborder paddingtop2per paddingleftzero paddingrightzero floatright marginbottom2per' id = 'singlemessagerow_0' data-messageid='" +
					message.messageid +
					"'><div class='col-xs-4 col-sm-1 pull-right'>" +
					message.sessionlink +
					" </div><div class='col-xs-8 col-sm-11'><div class='message'>" +
					message.messagetext +
					"</div><p class='xsmalltext greytext'>" +
					nowdate +
					"</p></div><div class='col-xs-12 refertothisdiv'><button id='refertothismessage' class='btn btn-default xsmalltext pull-right'><i class='fa fa-reply' aria-hidden='true'></i></button></div></div>");
				$('.unpaidprofform').remove();
				$("#inputmessagebox :input").attr("disabled", false);
				$("#closemessage").attr("disabled", false);
				tinymce.activeEditor.setMode('design');

			}
			else if (message.hasOwnProperty('error'))
			{
				$('body').prepend('<div id = "flashcontainer" class="flashcontainer"><div class="fail flashmessage">' + message.error + '</div></div>');
				$('.flashcontainer').css(
				{
					'top': $('#menu').height()
				});
				$('#flashcontainer').addClass('showing');
				setTimeout(function()
				{
					$('#flashcontainer').removeClass('showing');
				}, 5000);
				$("#initialMessageProfForm :input").prop('disabled', false);
				$("#initialMessageProfForm .thisloader").remove();
			}
			return true;
		},
		error: function(e)
		{
			$('body').prepend('<div id = "flashcontainer" class="flashcontainer"><div class="fail flashmessage">Error! Please check your account details (go to Profile) and try again. If error persists please contact us.</div></div>');
			$('.flashcontainer').css(
			{
				'top': $('#menu').height()
			});
			$('#flashcontainer').addClass('showing');
			setTimeout(function()
			{
				$('#flashcontainer').removeClass('showing');
			}, 5000);
		}

	});

});

//send message from message page
var inputmessageformvalidator = $('#inputmessagebox').submit(function(e)
{
	e.preventDefault();
}).validate(
{
	// errorPlacement: function errorPlacement(error, element) { error.appendTo(element.parent("div").parent("div")).css({"color" : "darkred"}); },
	ignore: ':hidden:not(textarea)',
	rules:
	{
		inputmessagetext:
		{
			required: true
		},
		attachment:
		{
			extension: "bmp|gif|jpe?g|png|odp|pps|ppt|pptx|ods|xls|xlsx|doc|docx|odt|pdf|rtf|txt",
			filesize: 1048576
		}
	},
	messages:
	{
		inputmessagetext: "",
		attachment:
		{
			extension: 'Please attach a image or text file with <button type="button" id= "validextensions" class="btn btn-link fontsizeinherit paddingZero">valid extension</button>.',
			filesize: "File size must be less than 1Mb."
		}
	},
	submitHandler: function(form)
	{
		var inputmessage = new FormData(form);

		if (!document.inputmessageform.parentid)
		{
			// var messageids = [];
			// var messagetexts =[];
			// $('#singlemessage .singlemessagerow').each(function () {
			//   messageids.push( $(this).data("messageid") );
			//   // messagetexts.push( $(this).getElementsByClassName('message') );
			// });
			// inputmessage[inputmessage.length]={name:'parentid',value: messageids[messageids.length - 1]};
			// inputmessage.append('parentid', messageids[messageids.length - 1]);
			// inputmessage.append('parenttext', messagetexts[messagetexts.length - 1]);
			inputmessage.append('parentid', $('#loadsinglemessage .singlemessagerow:last').data("messageid"));
			inputmessage.append('parenttext', $('#loadsinglemessage .singlemessagerow:last .message').html());
		}
		var named = $(form).parent().parent();
		var tags = named.find("input");
		// var messagedata = {};
		for (var i = 0, n = tags.length; i < n; i = i + 1)
		{
			// messagedata[tags[i].name] = tags[i].value;
			inputmessage.append(tags[i].name, tags[i].value);
		}
		// inputmessage[inputmessage.length] = {name: 'threadid',value:messagedata['threadid']};
		// inputmessage.append('threadid', messagedata['threadid']);
		// inputmessage[inputmessage.length] = {name:'userid',value:messagedata['userid']};
		// inputmessage.append('userid', messagedata['userid']);
		// inputmessage.append('useremail', messagedata['useremail']);
		console.log(inputmessage);

		$.ajax(
		{
			type: 'POST',
			data: inputmessage,
			dataType: 'json',
			processData: false,
			contentType: false,
			url: baseUrl + 'messages/sendmessage',
			beforeSend: function()
			{
				$("#inputmessagebox :input").prop('disabled', true);
				$("#inputmessagebox").append('<p class ="thisloader positionAbsolute xsmalltext"> <i class= "fa fa-circle-o-notch fa-spin"></i> sending....</p>');
			},
			complete: function()
			{
				$("#inputmessagebox :input").prop('disabled', false);
				$('#inputmessagebox .thisloader').remove();
			},
			success: function(message)
			{
				if (message.hasOwnProperty('messageid'))
				{
					if ($('#inputmessage .refermessagepreview').length > 0) $('.refermessagepreview').remove();
					document.inputmessageform.reset();
					tinymce.activeEditor.setContent('');
					tinymce.activeEditor.undoManager.clear();
					$('body').prepend('<div id = "flashcontainer" class="flashcontainer"><div class="success flashmessage">SENT!</div></div>');
					$('.flashcontainer').css(
					{
						'top': $('#menu').height()
					});
					$('#flashcontainer').addClass('showing');
					setTimeout(function()
					{
						$('#flashcontainer').removeClass('showing');
					}, 1000);
					//add to present view, and for future replies
					var parentdiv = '';
					var nowdate = moment(new Date()).format("DD MMMM YYYY, HH:mm");
					if ($('#referencemessageid').length) parentdiv = "<div class='linktoparent alert alert-warning'><span class='boldtext'><i class='fa fa-reply' aria-hidden='true'></i> reference to </span>" + $('#referencemessagetext').val() + "</div>";
					if (message.attachmentform == undefined) message.attachmentform = '';

					if ($('#loadsinglemessage .lastparentid').length > 0)
						singlemessagediv.append("<input type='hidden' class='lastparentid' name ='lastparentid' value='" + message.lastparentid + "' /><input type='hidden' class='lastparenttext' name ='lastparenttext' value='" + message.lastparenttext + "' />");
					else
					{
						$('#loadsinglemessage .lastparentid').val(message.lastparentid);
						$('#loadsinglemessage .lastparenttext').val(message.lastparenttext);
					}

					$('#loadsinglemessage').append(parentdiv + "<div class='col-xs-12 singlemessagerow lightgreybottomborder paddingtop2per paddingleftzero paddingrightzero floatright marginbottom2per textalignright' id = 'singlemessagerow_0' data-messageid='" +
						message.messageid +
						"'><div class='col-xs-4 col-sm-1 pull-right'>" +
						message.sessionlink +
						" </div><div class='col-xs-8 col-sm-11'><div class='message'>" +
						message.messagetext +
						"</div><p class='xsmalltext greytext'>" +
						nowdate +
						"</p>" +
						message.attachmentform +
						"</div><div class='col-xs-12 refertothisdiv'><button id='refertothismessage' class='btn btn-default xsmalltext pull-right'><i class='fa fa-reply' aria-hidden='true'></i></button></div></div>");
					$("#loadsinglemessage").scrollTop($("#loadsinglemessage")[0].scrollHeight);

				}
				else if (message.hasOwnProperty('error'))
				{
					$('body').prepend('<div id = "flashcontainer" class="flashcontainer"><div class="fail flashmessage">' + message.error.join('<br>') + '</div></div>');
					$('.flashcontainer').css(
					{
						'top': $('#menu').height()
					});
					$('#flashcontainer').addClass('showing');
					setTimeout(function()
					{
						$('#flashcontainer').removeClass('showing');
					}, 5000);
				}
				// return true;
			},
			error: function(e)
			{
				console.log(e);
			}

		});
	}

});

//recentlyvisited cookie

function setCookie(cname, cvalue, exdays)
{
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toGMTString();
	document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/;SameSite=Lax; ';//add secure at end
}

function getCookie(cname)
{
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++)
	{
		var c = ca[i].trim();
		if (c.indexOf(name) == 0)
			return c.substring(name.length, c.length);
	}
	return "";
}

function clearHistory(targetId)
{
	setCookie(getUrl.host + '_recently_viewed', "", -1);
	document.getElementById(targetId).innerHTML = "";
}

function checkHistory(targetId)
{
	var cname = getUrl.host + '_recently_viewed';
	var history = getCookie(cname);
	var htmlContent = '';
	var rolename = '';
	if ((currentpagearray[1] == 'professionals' && currentpagearray[2] && currentpagearray[3] && currentpagearray[3] != 'locale') || (currentpagearray[1] == 'articles' && currentpagearray[2] == 'title' && currentpagearray[3]))
	{
		var insert = true;
	}
	else var insert = false;


	if(currentpagearray[1] == 'articles') rolename =currentpagearray[1];
	else rolename = currentpagearray[2];

	if (history != '')
	{
		// var sp = history.toString().split(",");
		var sp = JSON.parse(history);
		if ($('#' + targetId).is(':visible')) var visible = 1;
		else var visible = 0;

		if(typeof sp[rolename] != 'undefined')
		{
			for (var i = sp[rolename].length - 1; i >= 0; i--)
			{
				if (visible === 1)
				{

					htmlContent += '<div class="col-xs-6 col-sm-4 col-md-2  col-xl-2"> <div class="thumbnail"><a href="' +
						sp[rolename][i].link + '"><span class="thumbnaillink"></span></a>' +
						decodeURIComponent(sp[rolename][i].picDiv) +
						' <div class="caption"> <h3>' +
						decodeURIComponent(sp[rolename][i].title) +
						'</h3> </div> </div> </div> ';
				}

				if (sp[rolename][i].link == document.URL)
				{
					insert = false;
				}
			}
			if (visible === 1) document.getElementById(targetId).innerHTML = '<h3 class="row">Recently viewed </h3><div class="row">' +
				htmlContent + '</div>';
		}



		if (insert)
		{
			if(typeof sp[rolename] == 'undefined') sp[rolename] = [];
			else if (sp[rolename].length == 12) sp[rolename].shift();

			sp[rolename].push(
			{
				title: encodeURIComponent($.trim(document.getElementsByClassName('pagetitle')[0].innerText)),
				link: $.trim(document.URL),
				picDiv: encodeURIComponent($.trim(document.getElementsByClassName('imgdiv')[0].innerHTML))

			});
			setCookie(cname, JSON.stringify(sp), 30);
		}

	}
	else
	{
		var stack ={};
		stack[rolename] = [];
		if (insert)
		{
			stack[rolename].push(
			{
				title: encodeURIComponent($.trim(document.getElementsByClassName('pagetitle')[0].innerText)),
				link: $.trim(document.URL),
				picDiv: encodeURIComponent($.trim(document.getElementsByClassName('imgdiv')[0].innerHTML))

			});

			setCookie(cname, JSON.stringify(stack), 30);

		}

	}
}

checkHistory("recentPageViews");

//lazyload

function load(img)
{
	img.fadeOut(0, function()
	{
		img.fadeIn(1000);
	});
}
$('.lazyload').lazyload(
{
	load: load
});

var rpId = "rzp_test_gVACVZbZaHcD8D";

function donatepayment(loggedname, loggedemail, orderid, donationid, paidto)
{
	// razorpay payment stuff

	var options = {
		"key": rpId,
		"order_id": orderid,
		"name": "Kniew Donation",
		"description": "Donate to charities...",
		"prefill":
		{
			"name": loggedname,
			"email": loggedemail,
		},
		"theme":
		{
			"color": "#59DAFB"
		},
		"handler": function(response)
		{
			if (response.razorpay_payment_id)
			{
				$.ajax(
				{
					type: 'post',
					data:
					{
						'sentorderid': orderid,
						'paidto': paidto,
						'paymentid': response.razorpay_payment_id,
						'signature': response.razorpay_signature,
						'returnorderid': response.razorpay_order_id,
						'donationid': donationid
					},
					dataType: 'json',
					url: baseUrl + 'payment/payfromrporder',
					success: function(data)
					{
						if (data.hasOwnProperty('success'))
						{
							alert(data.success);
							if ($('#donateOrderForm').data('loggedin') !== true) location.reload();
						}
						else
						{
							if (data.hasOwnProperty('error')) alert(data.error);
							else alert('Payment failed!');
							rzp1.open();
						}
					},
					error: function(resp)
					{
						if (resp.error.description != undefined) alert(resp.error.description);
						else alert('Something went wrong!');
					}
				});
			}
			else
			{
				alert("Please try again!");
			}
		}
	};

	var rzp1 = new Razorpay(options);
	rzp1.open();

}

$(document).ready(function()
{

	//validation methods

	$.validator.addMethod('maxMultipleSelect', function(value, element, param)
	{
		param = typeof param == 'int' ? param : 5;
		return this.optional(element) || (value.length <= param);

	}, jQuery.validator.messages.max);

	$.validator.addMethod("extension", function(value, element, param)
	{
		param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
		return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
	}, "Please enter a value with a valid extension.");

	$.validator.addMethod('filesize', function(value, element, param)
	{
		return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than {0}');

	$.validator.addMethod("alphaspace", function(value, element)
	{
		return this.optional(element) || /^[A-Za-z']+(\s+[A-Za-z']+)*$/.test(value);
	}, 'Please enter only letter, apostrophe and space. Spaces must be followed by letters.');

	$.validator.addMethod("valueNotEquals", function(value, element, arg)
	{
		return arg !== value;
	}, "Value must not be equal to default.");
	$.validator.addMethod("alphacomma", function(value, element)
	{
		return this.optional(element) || /^[A-Za-z\s]+(\,+[A-Za-z\s]+)*$/.test(value);
	}, 'Please enter only languages, separator by comma. Comma must be followed by a word.');
	$.validator.addMethod("inArray", function(value, element, param)
	{
		return !($.inArray(value, param) > -1);
	}, "Please enter a different value, this is not allowed.");
	$.validator.addMethod("alphanumeric", function(value, element)
	{
		return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
	}, "Please enter only alphanumeric characters");

	// LANDING PAGE
	if($('#landdiv').length > 0)
	{
		// var heightbefore = $('#landdiv').height();
		var logoheight = $('#landlogocontainer').outerHeight();
		var heightafter = $(window).height() - $('#landbullets').outerHeight()- logoheight;
		var padbutton = (heightafter - $('#landdiv .allheadings').outerHeight() - $('#landdiv .buttonscontainer').height() - $('#landdiv .carouselinfo').outerHeight())/2;
		// console.log("-------------------------");
		// console.log("window "+$(window).height());
		// console.log("bullist " + $('#landbullets').outerHeight());
		// console.log(logoheight);
		// console.log("after " + heightafter);
		// console.log("-------------------------");

		$('#landdiv').css({'min-height':heightafter});
		$('#landdiv .graphicmask').css({'min-height':heightafter});
		if(padbutton > 0) $('#landdiv .buttonscontainer').css({'padding-top': padbutton, 'padding-bottom': padbutton});


	}

	// payments made //transactions

	var paymentsMadePage = 1;
	if (document.getElementById('paymentsMade'))
	{
		loadPaymentsMade(paymentsMadePage);
	}
	$('#loadmorepaymentsmade').on('click', function()
	{
		paymentsMadePage++;
		if (paymentsMadePage > 0) loadPaymentsMade(paymentsMadePage);
	});

	function loadPaymentsMade(pageno)
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "profile/paymentsmade",
			data:
			{
				page: pageno
			},
			beforeSend: function()
			{
				$('#paymentsMade .loadericon').show();
			},
			complete: function()
			{
				$('#paymentsMade .loadericon').hide();
				if (paymentsMadePage == 0) $('#loadmorepaymentsmade').hide();
				else $('#loadmorepaymentsmade').show();

			},
			success: function(result)
			{
				if (result == 0 || result == null)
				{
					paymentsMadePage = 0;
					$('#paymentsMade .enddiv').show();
				}
				else
				{
					$('#paymentsMadeContainer').append(result);
				}
			}
		});
	}

	// payments received

	var paymentsRecievedPage = 1;
	if (document.getElementById('paymentsRecieved'))
	{
		loadPaymentsReceived(paymentsRecievedPage);
	}
	$('#loadmorepaymentsreceived').on('click', function()
	{
		paymentsRecievedPage++;
		if (paymentsRecievedPage > 0) loadPaymentsReceived(paymentsRecievedPage);
	});

	function loadPaymentsReceived(pageno)
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "profile/paymentsrecieved",
			data:
			{
				page: pageno
			},
			beforeSend: function()
			{
				$('#paymentsRecieved .loadericon').show();
			},
			complete: function()
			{
				$('#paymentsRecieved .loadericon').hide();
				if (paymentsRecievedPage == 0) $('#loadmorepaymentsreceived').hide();
				else $('#loadmorepaymentsreceived').show();

			},
			success: function(result)
			{
				if (result == 0 || result == null)
				{
					paymentsRecievedPage = 0;
					$('#paymentsRecieved .enddiv').show();
				}
				else
				{
					$('#paymentsRecievedContainer').append(result);
				}
			}
		});
	}

	// donations made

	var donationsMadePage = 1;
	if (document.getElementById('donationsMade'))
	{
		loadDonationsMade(donationsMadePage);
	}
	$('#loadmoredonationsmade').on('click', function()
	{
		donationsMadePage++;
		if (donationsMadePage > 0) loadDonationsMade(donationsMadePage);
	});

	function loadDonationsMade(pageno)
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "profile/donationsmade",
			data:
			{
				page: pageno
			},
			beforeSend: function()
			{
				$('#donationsMade .loadericon').show();
			},
			complete: function()
			{
				$('#donationsMade .loadericon').hide();
				if (donationsMadePage == 0) $('#loadmoredonationsmade').hide();
				else $('#loadmoredonationsmade').show();

			},
			success: function(result)
			{
				if (result == 0 || result == null)
				{
					donationsMadePage = 0;
					$('#donationsMade .enddiv').show();
				}
				else
				{
					$('#donationsMadeContainer').append(result);
				}
			}
		});
	}

	// donations received

	var donationsRecievedPage = 1;
	if (document.getElementById('donationsRecieved'))
	{
		loadDonationsReceived(donationsRecievedPage);
	}
	$('#loadmoredonationsreceived').on('click', function()
	{
		donationsRecievedPage++;
		if (donationsRecievedPage > 0) loadDonationsReceived(donationsRecievedPage);
	});

	function loadDonationsReceived(pageno)
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "profile/donationsrecieved",
			data:
			{
				page: pageno
			},
			beforeSend: function()
			{
				$('#donationsRecieved .loadericon').show();
			},
			complete: function()
			{
				$('#donationsRecieved .loadericon').hide();
				if (donationsRecievedPage == 0) $('#loadmoredonationsreceived').hide();
				else $('#loadmoredonationsreceived').show();

			},
			success: function(result)
			{
				if (result == 0 || result == null)
				{
					donationsRecievedPage = 0;
					$('#donationsRecieved .enddiv').show();
				}
				else
				{
					$('#donationsRecievedContainer').append(result);
				}
			}
		});
	}

	//booked
	var bookedpage = 1;

	if (document.getElementById('bookedappointments'))
	{
		loadbookedappointments(bookedpage);
	}
	$('#loadmorebooked').on('click', function()
	{
		bookedpage++;
		if (bookedpage > 0) loadbookedappointments(bookedpage);
	});

	function loadbookedappointments(pageno)
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "profile/bookedappointments",
			data:
			{
				page: pageno
			},
			timeout: 10000,
			cache: false,
			beforeSend: function()
			{
				$('#bookedappointments .loadericon').show();
			},
			complete: function()
			{
				$('#bookedappointments .loadericon').hide();
				if (bookedpage == 0) $('#loadmorebooked').hide();
				else $('#loadmorebooked').show();

			},
			success: function(result)
			{
				if (result == 0 || result == null)
				{
					bookedpage = 0;
					$('#bookedappointments .enddiv').show();
				}
				else
				{
					$('#bookedappointmentscontainer').append(result);
				}
			}
		});

	}

	// appointment

	$('#appointmentSetting').submit(function(e)
	{
		e.preventDefault();
		var formValue = $(this).serialize();
		// alert(formValue);

		$.ajax(
		{

			type: 'post',
			data: formValue,
			dataType: 'json',
			url: baseUrl + 'profile/saveappointmentsettings',
			success: function(success)
			{

				document.getElementById('appointerror').innerHTML += '<div class="alert alert-success fade-in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Your preference is now updated.</div>';

			},
			error: document.getElementById('appointerror').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Please try again, if the problem persists please contact us.</div>'

		});

	});

	$("#unblockFutureAppointments").on('click', function()
	{
		var professionalid = $('#unblockFutureAppointments')[0].getAttribute('data-professionalid');
		$.ajax(
		{
			url: baseUrl + 'profile/unblockfutureappointment',
			type: 'POST',
			data:
			{
				professionalid: professionalid
			},
			success: function(response)
			{
				if (response == 1)
				{
					document.getElementById('appointerror').innerHTML += '<div class="alert alert-success alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Your appointment system is now unblocked and ready to use.</div>';
					location.reload();
				}
				else
				{
					document.getElementById('appointerror').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Please try again, if the problem persists please contact us.</div>';

				}
			}
		});
	});

	$("#blockFutureAppointments").on('click', function()
	{
		var professionalid = $('#blockFutureAppointments')[0].getAttribute('data-professionalid');
		jQuery.ajax(
		{
			url: baseUrl + 'profile/blockfutureappointments',
			type: 'POST',
			data:
			{
				professionalid: professionalid
			},
			success: function(response)
			{
				if (response == 1)
				{
					document.getElementById('appointerror').innerHTML += '<div class="alert alert-success alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Your appointment system is now blocked.</div>';
					location.reload();
				}
				else
				{
					document.getElementById('appointerror').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Please try again, if the problem persists please contact us.</div>';

				}
			}
		});
	});

	$("#deleteAppointSettingsData").on('click', function()
	{
		var professionalid = $('#deleteAppointSettingsData')[0].getAttribute('data-professionalid');
		jQuery.ajax(
		{
			url: baseUrl + 'profile/deleteappointmentsystem',
			type: 'POST',
			data:
			{
				professionalid: professionalid
			},
			success: function(response)
			{
				if (response == 1)
				{
					document.getElementById('appointerror').innerHTML += '<div class="alert alert-success alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Your appointment system is now deleted, update settings again to create a new one.</div>';
					location.reload();
				}
				else
				{
					document.getElementById('appointerror').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Please try again, if the problem persists please contact us.</div>';

				}
			}
		});
	});
	$('#weeklyAppointment').click(function()
	{
		$('#tillDate')[this.checked ? "show" : "hide"]();
	});
	if ($('#weeklyAppointment').is(':checked'))
	{
		$('#tillDate').show();
	}

	//setting

	$('#usersettings').submit(function(e)
	{
		e.preventDefault();

	}).validate(
	{
		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div").parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			username:
			{
				required: true,
				minlength: 5,
				remote:
				{
					url: baseUrl + "profile/checkusername",
					type: "post",
					data:
					{
						oldusername: function()
						{
							return $('#usersettings input[name="username"]').attr('data-oldusername');
						}

					}
				}

			},
			email:
			{
				required: true,
				remote:
				{
					url: baseUrl + "profile/checkemail",
					type: "post",
					data:
					{
						oldemail: function()
						{
							return $('#usersettings input[name="email"]').attr('data-oldemail');
						}

					}
				}
			},
			name:
			{
				minlength: 3,
				alphaspace: true,
			},

			phone:
			{
				number: true
			}

		},
		submitHandler: function(form)
		{

			var imageData = $('#profilepic_user .image-editor').cropit('export');
			$('#profilepic_user .hidden-image-data').val(imageData);
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "profile/updateuserprofile",
				data: $(form).serialize(),
				timeout: 3000,
				success: function(data)
				{
					if (data == true)
					{
						$('#usersettings').append("<p class='alert alert-success'>Succesfuly updated your data! </p>")
					}

				}
			});
			return false;
		}

	});

	$('#deleteprofpic').on('click', function()
	{

		var deleteok = confirm('Are you sure you want to remove your profile picture?');
		if (deleteok)
		{
			$.ajax(
			{
				url: baseUrl + "profile/deleteprofpic",
				timeout: 3000,
				success: function(data)
				{
					if (data == true)
					{
						alert("Your profile picture has been removed. Please refresh to see the changes.");
						setTimeout(location.reload.bind(location), 2000);
					}
				}
			});

		}

	});

	$('#deleteuserpic').on('click', function()
	{

		var deleteok = confirm('Are you sure you want to remove your profile picture?');
		if (deleteok)
		{
			$.ajax(
			{
				url: baseUrl + "profile/deleteuserpic",
				timeout: 3000,
				success: function(data)
				{
					if (data == true)
					{

						alert("Your profile picture has been removed. Please refresh to see the changes.");
						setTimeout(location.reload.bind(location), 2000);
					}
				}
			});
		}

	});

	$('#deletearticlepic').on('click', function()
	{

		var deleteok = confirm('Are you sure you want to remove article\'s display picture?');
		if (deleteok)
		{
			$.ajax(
			{
				type: "POST",
				data:
				{
					articleid: $(this).attr('data-articleid')
				},
				url: baseUrl + "articles/deletedisplaypic",
				timeout: 3000,
				success: function(data)
				{
					if (data == true)
					{
						alert("Your profile picture has been removed. Please refresh to see the changes.");
						setTimeout(location.reload.bind(location), 2000);

					}
				}
			});
		}

	});

	// ------------------------index----------------------------------------------
	var latestarticleschange;
	$('#morelatestarticles').on('click', function()
	{
		var pagenum = parseInt($(".articlenum:last").val()) + 1;
		if (pagenum != latestarticleschange)
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "home/latestarticles",
				data:
				{
					page: pagenum
				},
				timeout: 10000,
				cache: false,
				beforeSend: function()
				{
					$('#latestarticles .loadericon').show();
				},
				complete: function()
				{
					$('#latestarticles .loadericon').hide();

				},
				success: function(result)
				{
					if (result != false)
					{
						$('#latestarticles .carousel-inner').append(result);
					}
				}
			});
		}
		latestarticleschange = pagenum;
	});

	var topngochange, toplawyerchange, topdoctorchange, topcachange;

	$('#moretopngo').on('click', function()
	{
		var pagenum = parseInt($(".ngonum:last").val()) + 1;
		if (pagenum != topngochange) getTopProf(pagenum, 2, '#topngo');
		topngochange = pagenum;
	});

	$('#moretoplawyer').on('click', function()
	{
		var pagenum = parseInt($(".lawyernum:last").val()) + 1;
		if (pagenum != toplawyerchange) getTopProf(pagenum, 3, '#toplawyer');
		toplawyerchange = pagenum;

	});

	$('#moretopdoctor').on('click', function()
	{
		var pagenum = parseInt($(".doctornum:last").val()) + 1;
		if (pagenum != topdoctorchange) getTopProf(pagenum, 4, '#topdoctor');
		topdoctorchange = pagenum;
	});

	$('#moretopca').on('click', function()
	{
		var pagenum = parseInt($(".canum:last").val()) + 1;
		if (pagenum != topcachange) getTopProf(pagenum, 5, '#topca');
		topcachange = pagenum;
	});

	function getTopProf(pagenum, type, div_id)
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "home/topprof",
			data:
			{
				page: pagenum,
				type: type
			},
			timeout: 10000,
			cache: false,
			beforeSend: function()
			{
				$(div_id + ' .loadericon').show();
			},
			complete: function()
			{
				$(div_id + ' .loadericon').hide();

			},
			success: function(result)
			{
				if (result != false)
				{
					$(div_id + ' .carousel-inner').append(result);
				}
			}
		});
	}

	// --------copy-----

	function copyToClipboard(element)
	{
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	}

	//-------------------article------------------

	$(window).scroll(cardload);
	cardload();

	var endresult = 0;

	function cardload()
	{
		var wt = $(window).scrollTop(); //* top of the window
		var wb = wt + $(window).height(); //* bottom of the window
		$(".pageloaded").each(function()
		{

			var ot = $(this).offset().top; //* top of object (i.e. advertising div)
			var ob = ot + $(this).height(); //* bottom of object

			if (!$(this).attr("loaded") && wb > $(this).height() && endresult == 0)
			{
				// if($(".pagenum:last").val() <= $(".rowcount").val())
				var pagenum = parseInt($(".pagenum:last").val()) + 1;

				if (currentpage == 'professionals' && pagenum <= 3) getprofessionals(getUrl + '&page=' + pagenum);
				else if (currentpage == 'professionals' && pagenum > 3) $('.loadmore').show();
				else if (currentpage == 'articles' && pagenum <= 3) getarticle(getUrl + '&page=' + pagenum);
				else if (currentpage == 'search' && pagenum <= 3) getsearchresult(getUrl + '&page=' + pagenum);
				else if (currentpage == 'search' && pagenum > 3) $('.loadmore').show();

				$(this).attr("loaded", true);
				// $('.lazyload').lazyload({load: load});
			}
		});
	}

	$(document).on('click', '#toVerifySite',function()
	{
		copyToClipboard($(this).siblings('#verificationid'));
		alert("Copied!");
	});

	$(document).on('click','#stateBCI', function(e)
	{
		e.preventDefault();
		copyToClipboard($(this).siblings('#verificationid'));
		$('body').prepend('<div id = "flashcontainer" class="flashcontainer"><div class="blackTransBack5 whitetext">Copied!</div></div>');
		$('.flashcontainer').css(
		{
			'top': $('#menu').height()
		});
		$('#flashcontainer').addClass('showing');
		setTimeout(function()
		{
			$('#flashcontainer').removeClass('showing');
		}, 2000);
		$('#stateBCILink').dialog(
		{
			height: 'auto',
			width: '300px',
			modal: true,
			resizable: false,
		});

	});

	$('.loadmore').on('click', function()
	{

		if (endresult == 0)
		{
			var pagenum = parseInt($(".pagenum:last").val()) + 1;
			if (currentpage == 'professionals') getprofessionals(getUrl + '&page=' + pagenum);
			if (currentpage == 'search') getsearchresult(getUrl + '&page=' + pagenum);

			$('.pageloaded').attr("loaded", true);

		}
	});

	var par = $('#getSimilarArticles');
	var similarpage = 1;
	// , latestarticlespage = 1, topngopage = 1, toplawyerspage = 1, topdoctorspage =1, topcapage = 1;
	var tags = par.attr('data-tags');
	var articleid = par.attr('data-articleid');
	if ($('#getSimilarArticles').is(':visible')) getsimilar();

	$('#moresimilar').on('click', function()
	{

		if (similarpage < 4)
		{
			++similarpage;
			getsimilar();
		}

	});

	function getsimilar()
	{

		$.ajax(
		{
			type: "POST",
			url: baseUrl + "articles/getsimilararticles",
			data:
			{
				tags: tags,
				page: similarpage,
				articleid: articleid
			},
			timeout: 10000,
			cache: false,
			complete: function()
			{
				$('.loadericon').hide();

			},
			success: function(result)
			{
				if (result == false)
				{

					similarpage = 100;

				}
				else
				{
					$('#getSimilarArticles .carousel-inner').append(result);
					$('#getSimilarArticles .carousel-control').show();
				}
			}
		});
	}

	function getarticle(url)
	{
		$.ajax(
		{
			url: url,
			type: "GET",
			beforeSend: function()
			{
				$('#loadericon').show();
			},
			complete: function()
			{
				$('#loadericon').hide();
			},
			success: function(data)
			{
				if (data == false || data == 'false')
				{
					endresult = 1;
					$('.endresult').show();
				}
				else if (data)
				{
					$("#lazyaddarticle").append(data);
					$('.lazyload').lazyload(
					{
						load: load
					});
				}

			},
			error: function() {}
		});
	}

	//----------------------------professional---------------------
	var similarProf = $('#getSimilarProf');
	var SPPage = 1;
	var similarOther = $('#getSimilarOther');
	var SOPage = 1;
	var recommendedby = $('#getRecommendedby');
	var recommendPage = 1;
	if ($('#getSimilarProf').is(':visible')) getSimilarProf();
	if ($('#getSimilarOther').is(':visible')) getSimilarOther();
	if ($('#professionalDetails #getRecommendedby').length > 0) getRecommendedby();

	$('#moreprof').on('click', function(e)
	{
		if (SPPage <= 3)
		{
			++SPPage;
			getSimilarProf();
		}
	});

	$('#moreother').on('click', function(e)
	{

		if (SOPage <= 3)
		{
			++SOPage;
			getSimilarOther();
		}
	});
	$('#morerecommended').on('click', function(e)
	{

		if (recommendPage != 0)
		{
			++recommendPage;
			getRecommendedby();
		}
	});

	function getSimilarProf()
	{

		$.ajax(
		{
			url: baseUrl + "professionals/getsimilarprof",
			type: "POST",
			data:
			{
				professionalid: similarProf.attr('data-professionalid'),
				page: SPPage,
				mainfocus: similarProf.attr('data-mainfocus'),
				otherfocus: similarProf.attr('data-otherfocus'),
				usertype: similarProf.attr('data-usertype'),
				location: similarProf.attr('data-location'),
			},
			// timeout: 10000,
			cache: false,

			complete: function()
			{
				$('#getSimilarProf .loadericon').hide();

			},
			success: function(result)
			{

				if (result == false)
				{
					SPPage = 100;
				}
				else
				{

					$('#getSimilarProf .carousel-inner').append(result);
					$('#getSimilarProf .carousel-control').show();
					$('#getSimilarHead').show();

				}

			}
		});

	}

	function getSimilarOther()
	{

		$.ajax(
		{
			url: baseUrl + "professionals/getsimilarother",
			type: "POST",
			data:
			{
				page: SPPage,
				mainfocus: similarOther.attr('data-mainfocus'),
				usertype: similarOther.attr('data-usertype'),
				location: similarOther.attr('data-location'),
			},
			// timeout: 10000,
			cache: false,

			complete: function()
			{
				$('#getSimilarOther .loadericon').hide();

			},
			success: function(result)
			{

				if (result == false)
				{
					SOPage = 100;
				}
				else
				{

					$('#getSimilarOther .carousel-inner').append(result);
					$('#getSimilarOther .carousel-control').show();
					$('#getOtherHead').show();

				}

			}
		});

	}
	function getRecommendedby()
	{

		$.ajax(
		{
			url: baseUrl + "professionals/getrecommendedby",
			type: "POST",
			data:
			{
				page: recommendPage,
				id: recommendedby.attr('data-id'),
			},
			// timeout: 10000,
			cache: false,

			complete: function()
			{
				$('#getRecommendedby .loadericon').hide();

			},
			success: function(result)
			{

				if (result == false)
				{
					recommendPage = 0;
				}
				else
				{

					$('#getRecommendedby .carousel-inner').append(result);
					$('#getRecommendedby .carousel-control').show();
					$('#recommendedby').show();

				}

			}
		});

	}

	function getprofessionals(url)
	{
		$.ajax(
		{
			url: url,
			type: "GET",
			beforeSend: function()
			{
				$('#professionalcards').append('<i class="ajaxloadericon fa fa-spinner fa-pulse fa-fw fa-2x"></i>');
			},
			complete: function()
			{
				$('#professionalcards .ajaxloadericon').remove();

			},
			success: function(data)
			{
				if (data == false)
				{
					endresult = 1;
					$('.loadmore').hide();
					$('.endresult').show();
				}
				else if (data)
				{
					$("#professionalcards").append(data);
					$('.lazyload').lazyload(
					{
						load: load
					});
				}

			},
			error: function() {}
		}).done(function()
		{
			$('.profCardCarousel').carousel(
			{
				interval: 3000
			});
		});
	}

	function getsearchresult(url)
	{
		$.ajax(
		{
			url: url,
			type: "GET",
			beforeSend: function()
			{
				$('#searchloadericon').show();
			},
			complete: function()
			{
				$('#searchloadericon').hide();

			},
			success: function(data)
			{
				if (data == false)
				{
					endresult = 1;
					$('.loadmore').hide();
					$('.endresult').show();
				}
				else if (data)
				{
					$("#searchresultcards").append(data);
					$('.lazyload').lazyload(
					{
						load: load
					});
				}

			},
			error: function() {}
		}).done(function()
		{
			$('.profCardCarousel').carousel(
			{
				interval: 3000
			});
		});
	}

	$('.profCardCarousel').carousel(
	{
		interval: 5000
	});

	function loadarticleby()
	{
		var data = {
			articleby: ($('#articlebycall').attr('data-articlebyid')),
			page: loadarticlebypage
		};
		if ($('#articlebycall').attr('data-perpage'))
		{
			data['perpage'] = ($('#articlebycall').attr('data-perpage'));
		}
		$.ajax(
		{
			type: "POST",
			data: data,
			url: baseUrl + "Articles/articleby",
			beforeSend: function()
			{
				$('.loader').show();
				$('#loadmorearticleby').hide();
			},
			complete: function()
			{
				$('.loader').hide();
				if (loadarticlebypage == 0) $('#loadmorearticleby').hide();
				else $('#loadmorearticleby').show();

			},
			success: function(html)
			{
				if (html != false)
				{
					$("#articlebycall").append(html);
					$('#articleby').show();
				}
				else
				{
					if (loadarticlebypage == 1) $("#articleby").remove();
					else $("#articlebycall").append('<p class="endresult">End of articles by this author.</p>');
					$('#articleby .endresult').show();
					loadarticlebypage = 0;

				}
			}
		});
	}

	function loademployees()
	{
		var data = {
			id: ($('#employeesbycall').attr('data-id')),
			usertypename: ($('#employeesbycall').attr('data-usertypename')),
			page: employeespage
		};
		$.ajax(
		{
			type: "POST",
			data: data,
			url: baseUrl + "professionals/employees",
			beforeSend: function()
			{
				$('.loader').show();
				$('#loadmoreemployees').hide();
			},
			complete: function()
			{
				$('.loader').hide();
				if (employeespage == 0) $('#loademployees').hide();
				else $('#loadmoreemployees').show();

			},
			success: function(html)
			{
				if (html != false)
				{
					$("#employeesbycall").append(html);
				}
				else
				{
					if (employeespage == 1) $("#employeesbycall").append('<p class="endresult">No employees registered with us.</p>');
					else $("#employeesbycall").append('<p class="endresult xsmalltext">--------------END------------</p>');
					$('#employees .endresult').show();
					employeespage = 0;
				}
			}
		});
	}

	var loadarticlebypage = 1,
		employeespage = 1;

	if ($('#professionalDetails #articleby').length > 0) loadarticleby();
	$('#loadmorearticleby').on('click', function()
	{
		if (loadarticlebypage != 0)
		{
			loadarticlebypage++;
			loadarticleby();
		}
	});
	if (document.getElementById('employees')) loademployees();
	$('#loadmoreemployees').on('click', function()
	{
		if (employeespage != 0)
		{
			employeespage++;
			loademployees();
		}
	});

	function loadliked()
	{
		$.ajax(
		{
			type: "POST",
			data:
			{
				id: ($('#likedbycall').attr('data-likedbyid')),
				page: loadlikedbypage
			},
			url: baseUrl + "Articles/likedarticles",
			beforeSend: function()
			{
				$('.loader').show();
				$('#loadmoreliked').hide();
			},
			complete: function()
			{
				$('.loader').hide();
				if (loadlikedbypage == 0) $('#loadmoreliked').hide();
				else $('#loadmoreliked').show();

			},
			success: function(html)
			{
				if (html != false)
				{
					$("#likedbycall").append(html);
				}
				else
				{
					if (loadlikedbypage == 1) $("#likedbycall").append('<p class="endresult">No liked article.</p>');
					else $("#likedbycall").append('<p class="endresult">End of articles by this author.</p>');
					$('.endresult').show();
					loadlikedbypage = 0;

				}
			}
		});
	}
	var loadlikedbypage = 1;
	if (document.getElementById('likedArticles')) loadliked();
	$('#loadmoreliked').on('click', function()
	{
		if (loadlikedbypage != 0)
		{
			loadlikedbypage++;
			loadliked();
		}
	});

	$('#filtertoggle').on('click', function()
	{
		// $('#filterProfessionals').toggle("slide", 1000);
		if ($('#filterProfessionals:visible').length)
			$('#filterProfessionals').slideUp();
		else
			$('#filterProfessionals').slideDown();
	});

	function loadfocusbytype()
	{
		$.ajax(
		{
			type: "POST",
			data:
			{
				type: ($('#focusProfessionals').attr('data-focustype'))
			},
			url: baseUrl + "Professionals/getspecialisation",
			beforeSend: function()
			{
				$('.loader').show();
				$('#includesubcontainer').hide();
				$('#includeonlyfirmcontainer').hide();

			},
			complete: function()
			{
				$('.loader').hide();
				$('#includesubcontainer').show();
				$('#includeonlyfirmcontainer').show();

			},
			success: function(html)
			{
				$("#focusProfessionals .row").append(html);
			}
		});

	}
	if (document.getElementById('focusProfessionals')) loadfocusbytype();

	function professionaltabs()
	{

		if ($(window).width() < 992)
		{
			$('#displaytabs').addClass('nav nav-tabs');
			$('#tabcontent').addClass('tab-content');
			$('#locationProfessionals').addClass('tab-pane fade  in');
			$('#focusProfessionals').addClass('tab-pane fade  in');

		}
		if ($(window).width() > 992)
		{
			$('#displaytabs').removeClass('nav nav-tabs');
			$('#tabcontent').removeClass('tab-content');
			$('#locationProfessionals').removeClass('tab-pane fade  in');
			$('#focusProfessionals').removeClass('tab-pane fade  in');

		}
	}
	professionaltabs();

	$(window).on('resize', function()
	{
		professionaltabs();
	});

	$('#percentageRating').each(function()
	{
		$.ajax(
		{
			type: "POST",
			data:
			{
				professionalid: $('#percentageRating').attr('data-professionalid'),
				noofrating: $('#percentageRating').attr('data-noofrating')
			},
			url: baseUrl + "professionals/percentagerating",
			beforeSend: function()
			{
				$('#percentageRating .loadericon').show();

			},
			complete: function()
			{
				$('#percentageRating .loadericon').hide();

			},
			success: function(html)
			{
				$("#percentageRating").append(html);
			}
		});
	});

	$.fn.extend(
	{
		donetyping: function(callback, timeout)
		{
			timeout = timeout || 1e3; // 1 second default timeout
			var timeoutReference,
				doneTyping = function(el)
				{
					if (!timeoutReference) return;
					timeoutReference = null;
					callback.call(el);
				};
			return this.each(function(i, el)
			{
				var $el = $(el);
				$el.is($('input')) && $el.on('keyup keypress paste', function(e)
				{
					// This catches the backspace button in chrome, but also prevents
					// the event from triggering too preemptively. Without this line,
					// using tab/shift+tab will make the focused element fire the callback.
					if (e.type == 'keyup' && e.keyCode != 8) return;

					// Check if timeout has been set. If it has, "reset" the clock and
					// start over again.
					if (timeoutReference) clearTimeout(timeoutReference);
					timeoutReference = setTimeout(function()
					{
						// if we made it here, our timeout has elapsed. Fire the
						// callback
						doneTyping(el);
					}, timeout);
				}).on('blur', function()
				{
					// If we can, fire the event since we're leaving the field
					doneTyping(el);
				});
			});
		}
	});

	$("#searcharticleinput").donetyping(function()
	{
		var tagsearch = $(this).val();
		if (tagsearch != "undefined") var dataString = 'tagsearch=' + tagsearch;
		var str = getUrl.pathname;
		var gettags;

		if (str.indexOf("&tags[]=") > 0)
		{
			gettags = '&' + str.substring(str.indexOf("&") + 1);
		}
		else gettags = '';

		if (dataString != '')
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "articles/tagsearch" + gettags,
				data: dataString,
				cache: false,
				success: function(html)
				{
					$("#tagsearchresult").html(html).show();
				}
			});
		}
		return false;
	});

	$("#searchlocation").donetyping(function()
	{
		var location = $(this).val();
		var dataString = 'formattedaddress=' + location;
		if (dataString != '')
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "professionals/locationsearch",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$("#searchlocationresult").html(html).show();
				}
			});
		}
		return false;
	});

	//  $("#searcharea").donetyping(function()
	// {
	//     var area = $(this).val();
	//     var dataString = 'area='+ area;
	//     if(dataString !='')
	//     {
	//         $.ajax({
	//         type: "POST",
	//         url: baseUrl +"professionals/areasearch",
	//         data: dataString,
	//         cache: false,
	//         success: function(html)
	//         {
	//             $("#searcharearesult").html(html).show();
	//         }
	//         });
	//     }return false;
	// });

	//  $("#searchcity").donetyping(function()
	// {
	//     var city = $(this).val();
	//     var dataString = 'city='+ city;
	//     if(dataString !='')
	//     {
	//         $.ajax({
	//         type: "POST",
	//         url: baseUrl +"professionals/citysearch",
	//         data: dataString,
	//         cache: false,
	//         success: function(html)
	//         {
	//             $("#searchcityresult").html(html).show();
	//         }
	//         });
	//     }return false;
	// });

	//  $("#searchstate").donetyping(function()
	// {
	//     var state = $(this).val();
	//     var dataString = 'state='+ state;
	//     if(dataString !='')
	//     {
	//         $.ajax({
	//         type: "POST",
	//         url: baseUrl +"professionals/statesearch",
	//         data: dataString,
	//         cache: false,
	//         success: function(html)
	//         {
	//             $("#searchstateresult").html(html).show();
	//         }
	//         });
	//     }return false;
	// });

	//  $("#searchcountry").donetyping(function()
	// {
	//     var country = $(this).val();
	//     var dataString = 'country='+ country;
	//     if(dataString !='')
	//     {
	//         $.ajax({
	//         type: "POST",
	//         url: baseUrl +"professionals/countrysearch",
	//         data: dataString,
	//         cache: false,
	//         success: function(html)
	//         {
	//             $("#searchcountryresult").html(html).show();
	//         }
	//         });
	//     }return false;
	// });

	// $("#searcharearesult").on("click",function(e){
	//     $('#searcharea').val('');
	//     $('#searchcity').val('');
	//     $('#searchstate').val('');
	//     $('#searchcountry').val('');

	//     if($(e.target).attr('class') == 'show')
	//     {
	//         var $clicked = $(e.target);
	//     }
	//     else
	//     {
	//         var $clicked = $(e.target).parent();
	//     }

	//     var area = $clicked.find('.area').text();
	//     var areadecoded = $("<span/>").html(area).text();
	//     var city = $clicked.find('.city').text();
	//     var citydecoded = $("<span/>").html(city).text();
	//     var state = $clicked.find('.state').text();
	//     var statedecoded = $("<span/>").html(state).text();
	//     var country = $clicked.find('.country').text();
	//     var countrydecoded = $("<span/>").html(country).text();

	//     if(areadecoded)
	//     {
	//         $('#searcharea').val(areadecoded.replace(/[, ]+/g, " ").trim());
	//         $('#searchcity').val(citydecoded.replace(/[, ]+/g, " ").trim());
	//         $('#searchstate').val(statedecoded.replace(/[, ]+/g, " ").trim());
	//         $('#searchcountry').val(countrydecoded.replace(/[, ]+/g, " ").trim());
	//     }
	//     else
	//     {
	//         $('#searcharea').val('');
	//         $('#searchcity').val('');
	//         $('#searchstate').val('');
	//         $('#searchcountry').val('');
	//     }

	// });

	// $("#searchcityresult").on("click",function(e){
	//     $('#searcharea').val('');
	//     $('#searchcity').val('');
	//     $('#searchstate').val('');
	//     $('#searchcountry').val('');

	//     if($(e.target).attr('class') == 'show')
	//     {
	//         var $clicked = $(e.target);
	//     }
	//     else
	//     {
	//         var $clicked = $(e.target).parent();
	//     }

	//     var city = $clicked.find('.city').text();
	//     var citydecoded = $("<span/>").html(city).text();
	//     var state = $clicked.find('.state').text();
	//     var statedecoded = $("<span/>").html(state).text();
	//     var country = $clicked.find('.country').text();
	//     var countrydecoded = $("<span/>").html(country).text();

	//     if(citydecoded)
	//     {
	//         $('#searchcity').val(citydecoded.replace(/[, ]+/g, " ").trim());
	//         $('#searchstate').val(statedecoded.replace(/[, ]+/g, " ").trim());
	//         $('#searchcountry').val(countrydecoded.replace(/[, ]+/g, " ").trim());
	//     }
	//     else
	//     {
	//         $('#searchcity').val('');
	//         $('#searchstate').val('');
	//         $('#searchcountry').val('');
	//     }

	// });

	// $("#searchstateresult").on("click",function(e){
	//     $('#searcharea').val('');
	//     $('#searchcity').val('');
	//     $('#searchstate').val('');
	//     $('#searchcountry').val('');

	//     if($(e.target).attr('class') == 'show')
	//     {
	//         var $clicked = $(e.target);
	//     }
	//     else
	//     {
	//         var $clicked = $(e.target).parent();
	//     }

	//     var state = $clicked.find('.state').text();
	//     var statedecoded = $("<span/>").html(state).text();
	//     var country = $clicked.find('.country').text();
	//     var countrydecoded = $("<span/>").html(country).text();

	//     if(statedecoded)
	//     {

	//         $('#searchstate').val(statedecoded.replace(/[, ]+/g, " ").trim());
	//         $('#searchcountry').val(countrydecoded.replace(/[, ]+/g, " ").trim());
	//     }
	//     else
	//     {

	//         $('#searchstate').val('');
	//         $('#searchcountry').val('');
	//     }

	// });

	// $("#searchcountryresult").on("click",function(e){
	//     $('#searcharea').val('');
	//     $('#searchcity').val('');
	//     $('#searchstate').val('');
	//     $('#searchcountry').val('');

	//     if($(e.target).attr('class') == 'show')
	//     {
	//         var $clicked = $(e.target);
	//     }
	//     else
	//     {
	//         var $clicked = $(e.target).parent();
	//     }

	//     var country = $clicked.find('.country').text();
	//     var countrydecoded = $("<span/>").html(country).text();

	//     if(countrydecoded)
	//     {

	//         $('#searchcountry').val(countrydecoded.replace(/[, ]+/g, " ").trim());
	//     }
	//     else
	//     {

	//         $('#searchcountry').val('');
	//     }

	// });

	$("#searchlocationresult").on("click", function(e)
	{

		$('#searchlocation').val('');

		if ($(e.target).attr('class') == 'show')
		{
			var $clicked = $(e.target);
		}
		else
		{
			var $clicked = $(e.target).parent();
		}

		var location = $clicked.find('.location').text();
		var locationdecoded = $("<span/>").html(location).text();

		if (locationdecoded)
		{

			$('#searchlocation').val(locationdecoded.trim());
		}
		else
		{

			$('#searchlocation').val('');
		}

	});
	$(document).on("click", function(e)
	{
		var $clicked = $(e.target);
		// if (! $clicked.hasClass(".searcharea")){
		//     $("#searcharearesult").fadeOut();
		// }
		// if (! $clicked.hasClass(".searchcity")){
		//     $("#searchcityresult").fadeOut();
		// }
		// if (! $clicked.hasClass(".searchstate")){
		//     $("#searchstateresult").fadeOut();
		// }
		if (!$clicked.hasClass(".searchlocation"))
		{
			$("#searchlocationresult").fadeOut();
		}
	});
	// $('#author').click(function(){
	//     jQuery("#usernameresult").fadeIn();
	// });

	if ($('#languageFilter').length > 0)
	{
		$.ajax(
		{
			url: baseUrl + 'professionals/getlanguages',
			beforeSend: function()
			{
				$('#languageFilter .loader').show();
			},
			complete: function()
			{
				$('#languageFilter .loader').hide();
			},
			success: function(data)
			{
				$('#languageFilter ul').html(data);
			}
		});

	}

	//   if(currentpage =='professionals' && getUrl.href.indexOf('focus'))
	//   {
	//   	var match = decodeURIComponent(getUrl.href).match(/[^=&?]+\s*=\s*[^&#]*/g);
	// var obj = [];

	// for ( var i = match.length; i--; )
	// {
	//   var spl = match[i].split("=");
	//   var name = spl[0].replace(/(\[.\])|(\[\])/g, "");
	//   var value = spl[1].replace(/(\+)|(_)/g, " ");

	//   obj[name] = obj[name] || [];
	//   obj[name].push(value);
	// }

	// console.log($('#focusProfessionals label'));

	//   }

	$('#filterProfessionals').submit(function(e)
	{
		e.preventDefault();

		var searchlocation = $('#searchlocation').val().trim();
		var firstfocus = $('#filterProfessionals input[name="focus[]"]:checked').parent().first().text().trim();
		var focusurl = '';
		$('#filterProfessionals input[name="focus[]"]:checked').each(function(index)
		{
			focusurl += '&focus[]=' + $(this).parent().text().trim().replace(/[\. ,:-]+/g, '_');
		});

		var title = firstfocus + ' ' + capitalizeFirstLetter($(this).attr('data-usertypename'));
		if (searchlocation) title += ' in ' + searchlocation;
		var link = baseUrl + 'professionals/' + $(this).attr('data-usertypename') + '&locale=' + searchlocation.replace(/[\. ,:-]+/g, '_') + focusurl;
		var FormData = $(this).serialize();
		FormData += '&firstfocus=' + firstfocus;
		$.ajax(
		{
			data: FormData,
			type: 'POST',
			url: baseUrl + 'professionals/' + $(this).attr('data-usertypename'),
			beforeSend: function()
			{
				$('#loadericon').show();
				$("#professionalcards").html('');
			},
			complete: function()
			{
				$('#loadericon').hide();
			},
			success: function(data)
			{
				window.history.pushState(data, title, link);
				if (data == false || data == 'false')
				{
					endresult = 1;
					$('.endresult').show();
				}
				else if (data)
				{
					$('#filterProfessionals').slideUp();
					$("#professionalcards").html(data);
					$('.lazyload').lazyload(
					{
						load: load
					});
				}
			}
		}).done(function()
		{
			$('.profCardCarousel').carousel(
			{
				interval: 3000
			});
		});
		return false;
	});

	$('#contact_subject').on('change', function()
	{
		if (this.value == 'article') $('#articlesubmission').show();
		else $('#articlesubmission').hide();
		if (this.value == 'report' || this.value == 'technical') $('#report').show();
		else $('#report').hide();
		if (this.value == 'feedback') $('#feedback').show();
		else $('#feedback').hide();

	});

	$('#contactform').submit(function(e)
	{
		e.preventDefault();
		$('#contactform').validate().settings.ignore = ":hidden";

	}).validate(
	{
		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			title:
			{
				required: true,
				minlength: 5,
				remote:
				{
					url: baseUrl + "profile/addarticletitlevalidate",
					type: "post"
				}
			},
			attachment:
			{
				extension: "txt|doc|docx|odt|rtf|wks|wps|wpd|text",
				filesize: 500000
			},

		},
		messages:
		{
			attachment:
			{
				extension: "Please attach a text file with valid extension (txt | doc | docx | odt | rtf | wks | wpd | text).",
				filesize: "File size must be less than 500kb."
			}
		},
		submitHandler: function(form)
		{
			var form_data = new FormData(form);

			$.ajax(
			{
				type: "POST",
				url: baseUrl + "contact/sendemail",
				data: form_data,
				processData: false,
				contentType: false,
				timeout: 3000,
				success: function()
				{
					$('#contactform').append("<p class='alert alert-success col-sm-12  alert-dismissable fade in'>Email sent successfully!</p>");

				},
				// error: function(){$('#contactform').append("<p class='alert alert-danger col-sm-12  alert-dismissable fade in'><b>Error!</b> Please try again.</p>");}
			});
			return false;
		}

	});

	// likedislike

	// $.each($('.voting_wrapper'), function(){
	//    var articleid = $(this).attr('id');
	//    post_data = {'articleid': articleid, 'vote':'fetch'}
	//    $.ajax({
	//        type: "POST",
	//        dataType: 'json',
	//        url: baseUrl +"articles/likedislike",
	//        data: post_data,
	//        success: function(response)
	//        {
	//            $('#'+articleid+' .up_votes').text(response[0].likes);
	//            $('#'+articleid+' .down_votes').text(response[0].dislikes);
	//        }
	//    });

	// });

	$(".voting_wrapper .voting_btn .fa").on('click', function(e)
	{

		var clicked_button = $(this).parent().attr('class');
		var articleid = $(this).parent().parent().parent().attr("id");
		var logged = $(this).parent().parent().parent().attr("data-logged");

		if (logged == true)
		{

			if (clicked_button === 'up_button')
			{

				post_data = {
					'articleid': articleid,
					'vote': 'up'
				};
				$.ajax(
				{
					type: "POST",
					dataType: 'json',
					url: baseUrl + "articles/likedislike",
					data: post_data,
					success: function(response)
					{
						var present = $('#' + articleid + ' .voting_btn .up_votes').text();
						$('#' + articleid + ' .voting_btn .up_votes').text(parseInt(present) + 1);
						if (response = "Modified other")
						{
							var other = $('#' + articleid + ' .voting_btn .down_votes').text();
							$('#' + articleid + ' .voting_btn .down_votes').text(parseInt(other) - 1);
						}
						$('#' + articleid + ' .down_button .fa').removeClass('voted');
						$('#' + articleid + ' .up_button .fa').addClass('voted');

					}
					// error: $('#vote_result').text("Error! Please, try again.")

				});

			}
			else if (clicked_button === 'down_button')
			{

				post_data = {
					'articleid': articleid,
					'vote': 'down'
				};
				$.ajax(
				{
					type: "POST",
					dataType: 'json',
					url: baseUrl + "articles/likedislike",
					data: post_data,
					success: function(response)
					{
						var present = $('#' + articleid + ' .voting_btn .down_votes').text();
						$('#' + articleid + ' .voting_btn .down_votes').text(parseInt(present) + 1);
						if (response = "Modified other")
						{
							var other = $('#' + articleid + ' .voting_btn .up_votes').text();
							$('#' + articleid + ' .voting_btn .up_votes').text(parseInt(other) - 1);
						}

						$('#' + articleid + ' .down_button .fa').addClass('voted');
						$('#' + articleid + ' .up_button .fa').removeClass('voted');

					}
					// error: $('#vote_result').text("Error! Please, try again.")
				});
			}
		}
		else
		{
			$('#vote_result').text("Please log in to vote.");
		}

	});

	// ARTICLE COMMENTS

	var loadcommentpage = 0;

	$('#comments-container').each(function()
	{
		var isLoggedIn = $(this).attr('class');
		var articleid = $(this).attr('data-articleid');
		var dp = $(this).attr('data-profilepic');

		$('#comments-container').comments(
		{
			profilePictureURL: dp,
			// roundProfilePictures: true,
			textareaRows: 1,
			enableAttachments: false,
			createdByCurrentUser: true,
			enableReplying: true,
			enableEditing: true,
			enableDeleting: true,
			enableUpvoting: false, //Later may want to convert this into true and conjure up a system for voting and tracking user who have voted already
			enableDeletingCommentWithReplies: true,
			textareaPlaceholderText: (isLoggedIn == 'loggedin') ? 'Leave a comment' : 'Please log in to comment',
			postCommentOnEnter: true,
			sendText: 'comment',
			saveText: 'Update',
			readOnly: (isLoggedIn == 'loggedin') ? false : true,
			fieldMappings:
			{
				id: 'commentid',
				parent: 'parentid',
				created: 'createdat',
				modified: 'modifiedat',
				content: 'comment',
				fullname: 'username',
				createdByAdmin: 'createdbyadmin',
				upvoteCount: 'upvotecount',
				userHasUpvoted: 'userhasupvoted',
				profilePictureURL: 'profilepic',
				profileURL: 'profileURL',
				createdByCurrentUser: 'createdbycurrentuser',

			},

			getComments: function(success, error)
			{
				var comment_get_data = {
					'articleid': articleid,
					'page': loadcommentpage
				};
				$.ajax(
				{
					type: 'post',
					url: baseUrl + 'articles/getcomments',
					data: comment_get_data,
					dataType: 'json',
					success: function(commentsArray)
					{

						success(commentsArray);
						$('#loadmorearticlecomments').show();
						$('.enddiv').hide();

					},
					error: function()
					{
						$('#loadmorearticlecomments').hide();
						$('.enddiv').show();
						$('#comments-container .spinner').hide();
					}
				});
			},
			postComment: function(commentJSON, success, error)
			{
				var comment_post_data = {
					'articleid': articleid,
					'commentJSON': commentJSON
				};
				$.ajax(
				{
					type: 'post',
					url: baseUrl + 'articles/postcomment',
					data: comment_post_data,
					dataType: 'json',
					success: function()
					{
						// alert(JSON.stringify(commentServer)),
						success(commentJSON)
					},
					error: error

				});
			},
			putComment: function(commentPUT, success, error)
			{
				var comment_put_data = {
					'articleid': articleid,
					'commentPUT': commentPUT
				};
				$.ajax(
				{
					type: 'post',
					url: baseUrl + 'articles/putcomment',
					data: comment_put_data,
					success: function()
					{
						success(commentPUT)
					},
					error: error

				});
			},
			deleteComment: function(commentDel, success, error)
			{
				var comment_del_data = {
					'articleid': articleid,
					'commentDel': commentDel
				};
				$.ajax(
				{
					type: 'post',
					url: baseUrl + 'articles/deletecomment',
					data: comment_del_data,
					success: success,
					error: error

				});
			},
			// upvoteComment: function(upvote, success, error) {
			//     alert(JSON.stringify(upvote));
			//     var comment_upvote = {'articleid':articleid, 'function':'upvoteComment', 'upvote' : upvote};
			//     $.ajax({
			//         type: 'post',
			//         url: ',
			//         data: comment_upvote,
			//         success: function() {
			//             success(upvote)
			//         },
			//         error: error

			//     });
			// },
		});
	});

	$('#loadmorearticlecomments').on('click', function(e)
	{
		e.preventDefault();
		loadcommentpage++;
		$.data($('#comments-container').get(0), 'comments').fetchNext();

	});

	if ($('#professionalDetails #recommended').length > 0)
	{

		$.ajax(
		{
			type: 'post',
			url: baseUrl + 'professionals/getrecommended',
			data:
			{
				'id': $('#recommended').attr('data-id')
			},
			success: function(data)
			{
				if (data != false)
				{
					$('#recommended').append(data);
					$('#recommended').show();
				}
			}
		});

	}

	$('#RC-container').each(function()
	{
		var isLoggedIn = $(this).attr('class');
		var professionalid = $(this).attr('data-professionalid');
		var dp = $(this).attr('data-profilepic');
		var isdiff = $(this).attr('data-isdiff');

		var mainrate = null;

		$("#giverating").jRating(
		{
			decimalLength: 1,
			rateMax: 5,
			length: 5,
			phpPath: baseUrl + 'professionals/giverating',
			step: true,
			showRateInfo: true,
			canRateAgain: true,
			nbRates: 5,
			bigStarsPath: baseUrl + 'css/icons/stars.png',
			onSuccess: function(element, rate)
			{
				mainrate = rate;
			}

		});

		$("#giverating").on('click', function()
		{
			$('#RC-container .commenting-field.main').find('.textarea').trigger('click');
		});

		$('#RC-container').comments(
		{
			profilePictureURL: dp,
			// roundProfilePictures: true,
			textareaRows: 1,
			// enableAttachments: false,
			createdByCurrentUser: true,
			enableReplying: true,
			enableEditing: true,
			enableDeleting: true,
			enableUpvoting: false,
			enableDeletingCommentWithReplies: true,
			textareaPlaceholderText: (isLoggedIn == 'loggedin') ? 'Leave a review.' : 'Please log in to rate',
			postCommentOnEnter: true,
			sendText: 'Rate & Review',
			replyText: 'Reply',
			saveText: 'Update',
			readOnly: (isLoggedIn == 'loggedin' && isdiff) ? false : true,
			fieldMappings:
			{
				id: 'rateid',
				parent: 'parentid',
				created: 'createdat',
				modified: 'modifiedat',
				content: 'comment',
				fullname: 'username',
				createdByAdmin: 'createdbyprofessional',
				upvoteCount: 'upvoteCount',
				profilePictureURL: 'profilepic',
				profileURL: 'profileURL',
				createdByCurrentUser: 'createdbycurrentuser',

			},
			getComments: function(success, error)
			{
				var comment_get_data = {
					'professionalid': professionalid,
					'page': loadcommentpage
				};
				$.ajax(
				{
					type: 'post',
					url: baseUrl + 'professionals/getcomments',
					data: comment_get_data,
					dataType: 'json',
					success: function(commentsArray)
					{

						success(commentsArray);

						for (var i = commentsArray.length - 1; i >= 0; i--)
						{
							if (commentsArray[i]['labelclass'])
								$('[data-id = ' + commentsArray[i]['rateid'] + '] .name:first a').addClass(commentsArray[i]['labelclass']).css(
								{
									'color': 'white'
								});

							if (commentsArray[i]['parentid'] == null)
							{

								if (commentsArray[i]['createdbycurrentuser'] == true)
								{
									// $.data($('#RC-container').readOnly(true));
									$('#giverating').remove();
									$('#RC-container .commenting-field.main').hide();
									$('.comment.by-current-user[data-id = ' + commentsArray[i]['rateid'] + ']').prependTo($('#RC-container #comment-list.main'));

									var starsAfter = "<p id = 'giverating_parent' data-average = '" + commentsArray[i]['rating'] + "' data-id ='" + professionalid + "'></p>";
									$('[data-id = ' + commentsArray[i]['rateid'] + '] .name:first').after(starsAfter);
									mainrate = commentsArray[i]['rating'];
								}
								else
								{
									var starsAfter = "<p class = 'smallrating jDisabled' data-average = '" + commentsArray[i]['rating'] + "' data-id ='" + professionalid + "'></p>";
									$('[data-id = ' + commentsArray[i]['rateid'] + '] .name:first').after(starsAfter);

								}
							}

							if (commentsArray[i]['createdbyprofessional'] === true)
							{

								$('[data-id = ' + commentsArray[i]['rateid'] + '] .name:first').append("  <i class='fa fa-certificate'></i>");
							}
							else if (commentsArray[i]['verifieduser'] === true)
							{
								$('[data-id = ' + commentsArray[i]['rateid'] + '] .name:first').append("  <i class='fa fa-check-circle'></i>");
							}
						}
						$(".smallrating").jRating(
						{
							decimalLength: 1,
							rateMax: 5,
							step: true,
							type: 'small',
							smallStarsPath: baseUrl + 'css/icons/small.png'

						});

						$("#giverating_parent").jRating(
						{
							decimalLength: 1,
							rateMax: 5,
							length: 5,
							phpPath: baseUrl + 'professionals/giverating',
							step: true,
							showRateInfo: true,
							canRateAgain: true,
							nbRates: 5,
							bigStarsPath: baseUrl + 'css/icons/stars.png',
							onSuccess: function(element, rate)
							{
								mainrate = rate;
							}

						});

						$('#loadmoreprofcomments').show();
						$('.enddiv').hide();

					},
					error: function()
					{
						$('#loadmoreprofcomments').hide();
						$('.enddiv').show();
						$('#RC-container .spinner').hide();
					}
				});
			},
			postComment: function(commentJSON, success, error)
			{
				console.log(commentJSON);

				if (commentJSON['parentid'] == null && mainrate == null)
				{
					$('#RC-container .commenting-field.main .error').remove();
					$('#RC-container .commenting-field.main').append("<p class='error'> Please give a rating first!</p>");
				}
				else
				{
					$('#RC-container .commenting-field.main .error').hide();
					$.ajax(
					{
						type: 'post',
						url: baseUrl + 'professionals/postcomment',
						data:
						{
							'professionalid': professionalid,
							'commentJSON': commentJSON
						},
						dataType: 'json',
						success: function()
						{
							success(commentJSON);
							if (commentJSON['parentid'] == null)
							{
								$('#giverating').remove();
								$('#RC-container .commenting-field.main').hide();
								var starsAfter = "<p id = 'giverating_post' data-average = '" + mainrate + "' data-id ='" + professionalid + "'></p>";
								$('[data-id = ' + commentJSON['rateid'] + '] .name').after(starsAfter);
							}
							$("#giverating_post").jRating(
							{
								decimalLength: 1,
								rateMax: 5,
								length: 5,
								phpPath: baseUrl + 'professionals/giverating',
								step: true,
								showRateInfo: true,
								canRateAgain: true,
								nbRates: 5,
								bigStarsPath: baseUrl + 'css/icons/stars.png',
								onSuccess: function(element, rate)
								{
									mainrate = rate;
								}

							});

						},

					});
				}
			},
			putComment: function(commentPUT, success, error)
			{
				var comment_put_data = {
					'professionalid': professionalid,
					'commentPUT': commentPUT
				};
				$.ajax(
				{
					type: 'post',
					url: baseUrl + 'professionals/putcomment',
					data: comment_put_data,
					success: function()
					{
						success(commentPUT)
						if (commentPUT['parentid'] == null)
						{
							var starsAfter = "<p id = 'giverating_modify' data-average = '" + mainrate + "' data-id ='" + professionalid + "'></p>";
							$('[data-id = ' + commentPUT['rateid'] + '] .name').after(starsAfter);
						}
						$("#giverating_modify").jRating(
						{
							decimalLength: 1,
							rateMax: 5,
							length: 5,
							phpPath: baseUrl + 'professionals/giverating',
							step: true,
							showRateInfo: true,
							canRateAgain: true,
							nbRates: 5,
							bigStarsPath: baseUrl + 'css/icons/stars.png',
							onSuccess: function(element, rate)
							{
								mainrate = rate;
							}

						});
					},
					error: error

				});
			},
			deleteComment: function(commentDel, success, error)
			{
				$.ajax(
				{
					type: 'post',
					url: baseUrl + 'professionals/deletecomment',
					data:
					{
						'commentDel': commentDel
					},
					success: function()
					{
						if (commentDel['parentid'] == null)
						{
							var x = '<div id="giverating_delete"  data-id="' + professionalid + '"data-average="0"></div>';
							$(x).prependTo($('#RC-container'));
							$('#RC-container .commenting-field.main').show();
							var starsAfter = "<p id = 'giverating' data-average = '" + mainrate + "' data-id ='" + professionalid + "'></p>";
							$('[data-id = ' + commentDel['rateid'] + '] .name').after(starsAfter);
						}
						$("#giverating_delete").jRating(
						{
							decimalLength: 1,
							rateMax: 5,
							length: 5,
							phpPath: baseUrl + 'professionals/giverating',
							step: true,
							showRateInfo: true,
							canRateAgain: true,
							nbRates: 5,
							bigStarsPath: baseUrl + 'css/icons/stars.png',
							onSuccess: function(element, rate)
							{
								mainrate = rate;
							}

						});
						success();

					},
					error: error

				});
			},

		});
		$('#loadmoreprofcomments').on('click', function(e)
		{
			e.preventDefault();
			loadcommentpage++;
			$.data($('#RC-container').get(0), 'comments').fetchNext();

		});

	});

	$(".rating").jRating(
	{
		decimalLength: 1,
		rateMax: 5,
		length: 5,
		step: true,
		nbRates: 5,
		bigStarsPath: baseUrl + 'css/icons/stars.png'
	});
	$(".smallrating").jRating(
	{
		decimalLength: 1,
		rateMax: 5,
		step: true,
		type: 'small',
		smallStarsPath: baseUrl + 'css/icons/small.png'

	});

	//height of the window, for footer to stay at bottom

	function autoHeight()
	{
		var h = $(window).height() - $('body').height();
		// console.log($(window).height()); console.log($('body').height()); console.log(h);
		if (h >= 0)
		{
			$('#foot').css(
			{
				'position': 'fixed'
			});

			$('.temp_top').css(
			{
				'height': $('.temp_top').height() + h
			});
		}

		if ($('#page-content-wrapper').is(':visible'))
		{

			var height = $(window).height() - $('#page-content-wrapper').height();
			if (height >= 0)
			{
				$('#foot').css(
				{
					'position': 'fixed'
				});
			}
			var navHeight = $('#menu').height();
			$('#sidebar-wrapper').css(
			{
				'top': navHeight
			});
			$('#page-content-wrapper').css(
			{
				'top': navHeight
			});

		}
	}
	window.onload = autoHeight();

	// NAVIGATION

	$('#menu.navbar .navbar-nav li a').each(function()
	{
		if ($(this).attr('href') == (baseUrl + currentpage) || $(this).attr('href') == '' || $(this).attr('href') == (baseUrl + currentpage + '/' + currentpagearray[2]))
			$(this).addClass("active");
	});

	// ------------------------------profile------------------------------------

	$('#profilecontainer .tabbable .nav-tabs a').each(function()
	{
		var idhash = window.location.hash;
		if ($(this).attr('href') == idhash)
		{
			$(this).parent().addClass("active");
			$(idhash).addClass('active');

		}
		else if (currentpage == 'profile' && idhash == '')
		{
			if ($('#payment').length > 0)
			{
				$('#payment').addClass('active');
				if ($(this).attr('href') == '#payment')
				{
					$(this).parent().addClass('active');
				}
			}
			else
			{
				$('#settings').addClass('active');
				if ($(this).attr('href') == '#settings')
				{
					$(this).parent().addClass('active');
				}
			}
		}
	});

	if (currentpage == 'contact' && window.location.hash != '')
	{
		$('#contact_subject').val(window.location.hash.substring(1));

	}

	$('.sidemenu li a').each(function()
	{
		if ($(this).attr('href') == getUrl.href || $(this).attr('href') == '')
			$(this).parent().addClass("active");
	});

	$('#navbar-collapse-1')
		.on('shown.bs.collapse', function()
		{
			$('#navbar-hamburger').addClass('open');
			$('#navbar-toggle-change-icon').addClass('animatetranform');
			//css({'transform' : 'scale(0.5)','left' :'190px'}); //width of navbar collapse is 200px as defined in css



		})
		.on('hidden.bs.collapse', function()
		{
			$('#navbar-hamburger').removeClass('open');
			$('#navbar-toggle-change-icon').removeClass('animatetranform');
			//.css({'transform' : 'scale(1)','left' : 0});
			// $('#navbar-toggle-change-icon').animate({
			//   transform: 'translateX(-190px) scale(1)'
			// });

		});

	if ($(window).width() < 1200)
	{
		$('#searchnav').removeClass("collapse");
		$('#searchnav').removeClass("navbar-collapse");
		$('#searchnav').removeClass("navbar-nav");
		$('#searchnav').addClass("navbar-header");
	}

	$("#menu-toggle").click(function(e)
	{
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
	$("#wrapper a[data-toggle=collapse]").click(function(e)
	{
		e.preventDefault();
	});

	// Remove Search if user Resets Form or hits Escape!
	$('#searchBar button[type="reset"]').on('keyup', function(event)
	{
		if (event.which == 27 && $('#searchBar').css('display') === 'block' ||
			$(event.currentTarget).attr('type') == 'reset')
		{
			if (currentpage != 'search')
				closeSearch();
		}
	});

	function searchfocusbytype()
	{

		$.ajax(
		{
			type: "POST",
			data:
			{
				type: $('#filterall input[name=category]:checked').val()
			},
			url: baseUrl + "search/getspecialisation",
			beforeSend: function()
			{
				$('.loadericon').show();
			},
			complete: function()
			{
				$('.loadericon').hide();

			},
			success: function(html)
			{
				$("#searchfocus").html(html);
			}
		});

	}
	if (document.getElementById('searchfocus')) searchfocusbytype();

	$('#filterall').submit(function()
	{

		submitsearchfilters();
		return false;
	});

	$("#showSearchTerm").donetyping(function()
	{
		$("#wrapper").addClass("toggled");

		if ($(this).val() != '' && ($.trim($(this).val())).length >= 3)
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "search/searchinput",
				data: ($('#searchBar, #filterall').serialize()),
				cache: false,
				beforeSend: function()
				{
					$('#searchBar .loadericon').show();
				},
				complete: function()
				{
					$('#searchBar .loadericon').hide();
				},
				success: function(html)
				{
					$("#searchwebresult").html(html).show();
				}
			});
		}

		return false;
	});

	jQuery(document).on("click", function(e)
	{
		var $clicked = $(e.target);
		if (!$clicked.is("#searchwebresult"))
		{
			jQuery("#searchwebresult").fadeOut();
		}
	});

	$(window).scroll(function(e)
	{
		var $scrolled = $(e.target);
		if (!$scrolled.is("#searchwebresult"))
		{
			jQuery("#searchwebresult").fadeOut();
		}
	});

	$('#filterall input[type=radio]').on('change', function()
	{
		searchfocusbytype();
		submitsearchfilters();
	});

	$('#filterall').on('change', 'input[type=checkbox]', function()
	{
		submitsearchfilters();
	});

	function closeSearch()
	{
		var $form = $('#searchBar .active')
		$form.find('input').val('');
		$('#searchBar').slideUp();
		// $('#sidebar-wrapper').css({'top' : '50px'});
		$('#searchBar button[type="reset"]').css(
		{
			'display': 'none'
		});
		$('.searchbutton span').removeClass('fa-times');
		$('.searchbutton span').addClass('fa-search');

	}
	if (currentpage == 'search')
	{
		$('#searchBar').show();
		$('.searchbutton span').removeClass('fa-search');
		$('.searchbutton span').addClass('fa-times');
		var $form = $('#searchBar').find('input').focus();

	}

	if (currentpage == 'messages') closeSearch();

	$(document).on('click', '.searchbutton', function(event)
	{

		var prevNavHeight = $('#menu').height();

		if ($('.searchbutton span').hasClass('fa-times'))
		{
			$('#searchBar').delay(500).slideUp(1000);
			$('#sidebar-wrapper').css(
			{
				'top': (prevNavHeight - 50) + 'px'
			});
			$('#page-content-wrapper').css(
			{
				'top': (prevNavHeight - 50) + 'px'
			});
			$('.searchbutton span').removeClass('fa-times');
			$('.searchbutton span').addClass('fa-search');

		}
		else if ($('.searchbutton span').hasClass('fa-search'))
		{
			$('#searchBar').css(
			{
				'display': 'block'
			});
			$('#searchBar').delay(500).slideDown();
			$('#sidebar-wrapper').css(
			{
				'top': (prevNavHeight + 50) + 'px'
			});
			$('#page-content-wrapper').css(
			{
				'top': (prevNavHeight - 50) + 'px'
			});
			$('.searchbutton span').removeClass('fa-search');
			$('.searchbutton span').addClass('fa-times');
			var $form = $('#searchBar').find('input').focus();

		}

	});

	// ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
	// if your form is ajax remember to call `closeSearch()` to close the search container
	$(document).on('click', '#searchBar button[type="submit"]', function(event)
	{
		if (currentpage == 'search') event.preventDefault();
		var $form = $(this).closest('form'),
			$input = $form.find('input');
		$('#showSearchTerm').text($input.val());

		// if(currentpage != 'search') window.location.href = baseUrl + "search";
		submitsearchfilters();
	});

	function submitsearchfilters()
	{
		if (($('#showSearchTerm').val()) != '' && ($.trim($('#showSearchTerm').val())).length >= 3)
		{

			$.ajax(
			{
				data: ($('#searchBar, #filterall').serialize()) + '&byajax=true',
				type: 'POST',
				url: baseUrl + 'search',
				beforeSend: function()
				{
					$('#searchloadericon').show();
					$("#searchresultcards").html('');
				},
				complete: function()
				{
					$('#searchloadericon').hide();
				},
				success: function(data)
				{
					if (data == false || data == 'false')
					{
						endresult = 1;
						$('.endresult').show();
					}
					else if (data)
					{
						$("#searchresultcards").html(data);
						$('.lazyload').lazyload(
						{
							load: load
						});
					}
				}
			});
		}
		else
		{
			$("#searchresultcards").html("<p class='merg2per'>Please enter a search term first.</p>");

		}
	}

	$('.dropdown-toggle').dropdown();

	if ($(window).width() > 1200)
	{
		$("#menu.navbar .navbar-nav .dropdown")
			.mouseover(function()
			{
				$('#menu.navbar .navbar-nav .dropdown .dropdown-menu', this).stop(true, true).fadeIn("fast");
				$(this).toggleClass('open');
				$('.dropdown-toggle i', this).toggleClass("fa fa-caret-up");
				$('.dropdown-toggle i', this).toggleClass("fa fa-caret-down");
			})
			.mouseout(function()
			{
				$('#menu.navbar .navbar-nav .dropdown .dropdown-menu', this).stop(true, true).fadeOut("fast");
				$(this).toggleClass('open');
				$('.dropdown-toggle i', this).toggleClass("fa fa-caret-up");
				$('.dropdown-toggle i', this).toggleClass("fa fa-caret-down");

			});
	}

	$(document).click(function(event)
	{
		var clickover = $(event.target);
		var _opened = $("#menu.navbar .navbar-collapse").hasClass("collapse in");
		if (_opened === true && !clickover.hasClass("navbar-toggle"))
		{
			$("button.navbar-toggle").click();
		}

	});

	$("button.navbar-toggle").click(function()
	{

		$(".navbar-collapse").animate(
		{

			width: "toggle"

		});

	});

	// $("#menu.navbar .navbar-nav .dropdown .dropdown-toggle").on('mouseover', function(){
	//     console.log("hey");
	//     $("#menu.navbar .navbar-nav .dropdown .dropdown-menu").css({'color' : 'black'});
	// });

	$(window).scroll(function()
	{
		//if you hard code, then use console
		//.log to determine when you want the
		//nav bar to stick.
		if ($(window).scrollTop() > 50)
		{

			if (currentpage != 'search')
			{
				$('#searchBar').slideUp('slow');
				$('#sidebar-wrapper').css(
				{
					'top': '50px'
				});
				$('.searchbutton span').removeClass('fa-times');
				$('.searchbutton span').addClass('fa-search');
			}
		}

		if (viewport().width < 1200)
		{
			$('#menu').addClass('navbar-fixed');
			if ($('#menu').length > 0) $('body').css(
			{
				'padding-top': '55px'
			});
		}
		if (viewport().width >= 1200)
		{
			$('body').css(
			{
				'padding-top': 0
			});
			if ($(window).scrollTop() > 50)
			{
				$('#menu').addClass('navbar-fixed');
				$(".navbar-header").removeClass('navbar-header-center');
				$('.navbar-brand').css(
				{
					'font-size': 0
				});
				if ($('#searchBar').is(':visible'))
					$('#sidebar-wrapper').css(
					{
						'top': '100px'
					});
				else $('#sidebar-wrapper').css(
				{
					'top': '50px'
				});
				$('#logo_container').html('<svg  id="logo_scroll" ><use xlink:href="#logo_shortest"></use></svg>');
				$('.navbar .signin').hide();
				$('#menu').css({'border-bottom':'none'});


			}

			if ($(window).scrollTop() <= 50)
			{
				$('#menu').css({'border-bottom':'1px inset var(--barstextactive)'});

				$('#menu').removeClass('navbar-fixed');
				$(".navbar-header").addClass('navbar-header-center');
				$('.navbar-brand').css(
				{
					'font-size': '200%'
				});
				$('#logo_container').html('<svg  id="logo" ><use xlink:href="#logo_full"></use></svg>');
				$('.navbar .signin').show("slide",
				{
					direction: "right"
				}, 500);

			}
		}
	});

	// SIGNIN/UP

	$(".loginpop").on('click', function(event)
	{
		event.preventDefault();
		$("#signupnav").removeClass("active");
		$("#signinnav").addClass("active");

		$("#signuptab").removeClass("active in");
		$("#signintab").addClass("active in");
		$("#loginModal").modal(
		{
			show: true
		});
	}); //show modal

	$(".registerpop").on('click', function(event)
	{
		event.preventDefault();

		$("#signinnav").removeClass("active");
		$("#signupnav").addClass("active");

		$("#signintab").removeClass("active in");
		$("#signuptab").addClass("active in");

		$("#loginModal").modal(
		{
			show: true
		});
	});

	$('#logform').submit(function(e)
	{
		e.preventDefault();

	}).validate(
	{
		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div").parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			username:
			{
				required: true,
				remote:
				{
					url: baseUrl + "userloginvalidate/usernamevalidate",
					type: "post"
				}

			},
			password:
			{
				required: true,
				remote:
				{
					url: baseUrl + "userloginvalidate/passwordvalidate",
					type: "post",
					data:
					{
						username: function()
						{
							return $('#logform :input[name="username"]').val();
						}
					}
				}
			},

		},
		submitHandler: function(form)
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "userloginvalidate/userlogin",
				data: $(form).serialize(),
				timeout: 3000,
				success: function(data)
				{
					if (typeof data.donationid !== 'undefined') donatepayment(data.loggedname, data.loggedemail, data.orderid, data.donationid, data.paidto);
					else if (data == 'Message sent!') setTimeout(function()
					{
						location.href = baseUrl + "messages"
					}, 2000);
					else if (data == 1) setTimeout(location.reload.bind(location), 2000);

				}
			});
			// return false;
		}

	});

	// $('#logform').valid();

	// -------------------------profile----------

	jQuery.validator.addMethod("notEqualTo", function(value, element, param)
	{
		return this.optional(element) || value != $(param).val();
	}, "Please enter a value different than the previous value.");

	$('#changepasswordform').submit(function(e)
	{
		e.preventDefault();

	}).validate(
	{
		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div").parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			password:
			{
				required: true,
				minlength: 5,
				remote:
				{
					url: baseUrl + "userloginvalidate/passwordvalidate",
					type: "post",
					data:
					{

						username: function()
						{
							return $('#oldpassword').attr('data-username');
						}
					}
				}
			},
			newpassword:
			{
				required: true,
				notEqualTo: '#oldpassword',
				minlength: 5
			}

		},
		messages:
		{
			notEqualTo: 'Password cannot be the same as previous password.'
		},
		submitHandler: function(form)
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "profile/changepassword",
				data: $(form).serialize(),
				timeout: 3000,
				success: function()
				{
					$(form).append("<p class='alert alert-success col-sm-12'>Password changed successfully!</p>");
				},
				error: function()
				{
					$(form).append("<p class='alert alert-danger col-sm-12'>Error! Please try again</p>");
				},
			});
			// return false;
		}

	});

	$('#userregisterform').submit(function(e)
	{
		e.preventDefault();

	}).validate(
	{
		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div").parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			email:
			{
				required: true,
				remote:
				{
					url: baseUrl + "userregistervalidate/checkemail",
					type: "post"
				}
			},
			username:
			{
				required: true,
				minlength: 3,
				remote:
				{
					url: baseUrl + "userregistervalidate/checkusername",
					type: "post"
				},
				maxlength: 50,
				inArray: ['kniew', 'kniew.com', 'admin', 'adminstrator', 'administrator', 'user', 'lawyer', 'doctor', 'ngo', 'ca', 'charteredaccountant', 'chartered_accountant']

			},
			password:
			{
				required: true,
				minlength: 5
			}

		},
		submitHandler: function(form)
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "userregistervalidate/submitregisteruser",
				data: $(form).serialize(),
				dataType: 'json',
				beforeSend: function()
				{
					$("#userregisterform :input").prop("disabled", true);
				},
				success: function(data)
				{
					if (data.hasOwnProperty('error')) $(data.error).dialog();
					else if (data.hasOwnProperty('donationid')) donatepayment(data.loggedname, data.loggedemail, data.orderid, data.donationid, data.paidto);
					else if (data.hasOwnProperty('success'))
					{
						$(data.success).dialog();
						location.reload();
					}

					//  $.ajax({
					//     type: "POST",
					//     url: baseUrl + 'userregistervalidate/addToMailchimp',
					//     data:  $(form).serialize(),
					//     dataType: 'json',
					//     // timeout: 3000,
					//     success: function(data)
					//     {
					//
					//     	if(data[0] == 1)
					//   		{
					//           // window.location.href = baseUrl + "referafriend/";
					//
					//   		}
					//     	else if(data[0] == 2) $('#userregisterform').append('<p class="error">Please check your email and try again.</p>');
					//     	else $('#userregisterform').append('<p class="error">Please try again.</p>');
					//
					//     },
					//     error:function(){ $('#userregisterform').append('<p class="error">Please try after sometime!</p>');}
					// });
				}
			});
			// return false;
		}
	});

	$(".passwordShowButton").on('mouseup', function()
	{
		$(".passwordShow").attr("type", "password");
		$('.fa-eye').removeClass().addClass('fa fa-eye-slash');

	});

	$('.passwordShowButton').on('mousedown', function()
	{
		$(".passwordShow").attr("type", "text");
		$('.fa-eye-slash').removeClass().addClass('fa fa-eye');
	});

	$('.usernameRegister').on('focus', function()
	{
		var email = $(".emailRegister").val();
		var extractEmail = email.substring(0, email.indexOf("@"));
		if (extractEmail && !this.value)
		{
			this.value = extractEmail;
		}

	});

	$('.inputPassword').on('keyup', function()
	{
		$('#passwordStrength').html(checkStrength($('.inputPassword').val()))
	});

	function checkStrength(password)
	{
		var strength = 0
		if (password.length < 6)
		{
			$('#passwordStrength').removeClass();
			$('#passwordStrength').addClass('short');
			$('.strengthBar').css(
			{
				"background": "#FF0000",
				"width": "25%",
				"height": "3px"
			});
			return 'Too short';
		}
		if (password.length > 7) strength += 1;

		// If password contains both lower and uppercase characters, increase strength value.
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;

		// If it has numbers and characters, increase strength value.
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1;

		// If it has one special character, increase strength value.
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;

		// If it has two special characters, increase strength value.
		if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;

		// Calculated strength value, we can return messages
		// If value is less than 2
		if (strength < 2)
		{
			$('#passwordStrength').removeClass();
			$('#passwordStrength').addClass('weak');
			$('.strengthBar').css(
			{
				"background": "orange",
				"width": "50%",
				"height": "3px"
			});
			return 'Weak';
		}
		else if (strength == 2)
		{
			$('#passwordStrength').removeClass();
			$('#passwordStrength').addClass('good');
			$('.strengthBar').css(
			{
				"background": "#2D98F3",
				"width": "75%",
				"height": "3px"
			});
			return 'Good';
		}
		else
		{
			$('#passwordStrength').removeClass();
			$('#passwordStrength').addClass('strong');
			$('.strengthBar').css(
			{
				"background": "limegreen",
				"width": "100%",
				"height": "3px"
			});
			return 'Strong';
		}
	}

	//CROP PIC editarticleimg

	// $("input.cropit-image-input").change(function () {
	// imagecropit();
	// });
	$('#addarticleimage .select-image-btn').on('click', function()
	{
		$("#addarticleimage #editpic").modal(
		{
			show: true
		});
		$('#addarticleimage .cropit-image-input').click();
	});
	$('#editarticleimg .select-image-btn').on('click', function()
	{
		$("#editarticleimg #editpic").modal(
		{
			show: true
		});
		$('#editarticleimg .cropit-image-input').click();
	});

	$('#profilepic_prof .select-image-btn').on('click', function()
	{
		$("#profilepic_prof #editpic").modal(
		{
			show: true
		});
		$('#profilepic_prof .cropit-image-input').click();
	});

	$('#profilepic_user .select-image-btn').on('click', function()
	{
		$("#profilepic_user #editpic").modal(
		{
			show: true
		});
		$('#profilepic_user .cropit-image-input').click();
	});

	$('#registerprofimage .select-image-btn').on('click', function()
	{
		$("#registerprofimage #editpic").modal(
		{
			show: true
		});
		$('#registerprofimage .cropit-image-input').click();
	});

	$('.image-editor').cropit(
	{
		exportZoom: 1,
		imageBackground: true,
		imageBackgroundBorderWidth: 20,
		imageState:
		{
			src: '',
		},
		allowDragNDrop: true,
		minZoom: "fill",
		maxZoom: 5,
		smallImage: 'allow'

	});

	$('.rotate-cw').click(function()
	{
		$('.image-editor').cropit('rotateCW');
	});

	$('.rotate-ccw').click(function()
	{
		$('.image-editor').cropit('rotateCCW');
	});

	// $('#uploadimg').submit(function()
	// {
	//   // Move cropped image data to hidden input

	// var imageData = $('.image-editor').cropit('export');
	// $('.hidden-image-data').val(imageData);

	//   // Print HTTP request params
	//   var formValue = $(this).serialize();
	//   // alert(formValue);

	//     $.ajax({

	//        type: 'post',
	//        data: formValue,
	//        url: 'http://localhost/website/upload.php',

	//        success: function(data){
	//         $('#result-data').text('New file in: images/profile/'+data);
	//         $('#crop').show();
	//         // alert("success?");
	//        }

	//   });
	//     $.modal.close();

	//   // Prevent the form from actually submitting
	//   return false;
	// });

	// --------for absolute element--
	function parentelementheight(parent, direction)
	{
		if (direction == 'inc')
		{
			var parentOffset = parent.offset();
			var bottom = 0;
			parent.find('*').each(function()
			{
				var elem = $(this);
				var elemOffset = elem.offset();
				var elemBottom = elemOffset.top + elem.outerHeight(true) - parentOffset.top;
				if (elemBottom > bottom)
				{
					bottom = elemBottom;
				}
			});

			parent.css('min-height', bottom);
		}
		else if (direction == 'dec')
		{
			parent.css('min-height', '');

		}
	}

	// --------PAYMENT -------------

	//CHANGEDNOV19 : added donate

	$('#donateButton').on('click', function()
	{
		$('#donateOrderForm').show("slide",
		{
			direction: "left"
		});
		//$('#donateButton').hide("slide", { direction: "left"  });
		// var parentheight = $('#donateparent').height();
		// var childheight = $('#donateOrderForm').height();
		// $('#donateparent').height(parentheight + childheight - 38);//12(for close) + 14 (button font) + 12 for padding = 38
		parentelementheight($('#donateparent'), 'inc');
	});
	$('#donateOrderForm .closeform').on('click', function()
	{
		$('#donateOrderForm').hide("slide",
		{
			direction: "left"
		});
		// $('#donateButton').show("slide", { direction: "left"  });
		// var parentheight = $('#donateparent').height();
		// var childheight = $('#donateOrderForm').height();
		// $('#donateparent').height(parentheight - childheight + 38);
		parentelementheight($('#donateparent'), 'dec');

	});

	$('body #donateOrderForm').validate(
	{
		errorPlacement: function(error, element)
		{
			$('#donateOrderForm').append(error);
			parentelementheight($('#donateparent'), 'inc');
		},
		rules:
		{
			donateamount:
			{
				required: true,
				digits: true,
				min: 10
			},
			note:
			{
				maxlength: 100
			}
		},
		messages:
		{
			donateamount: "Donation should be a valid number above 10 Rs.",
			note: "Please try to write a shorter note. Thank you for your kind words."

		},
		submitHandler: function(form)
		{
			$('#donateOrderForm').hide("slide",
			{
				direction: "left"
			});
			parentelementheight($('#donateparent'), 'dec');
			// if not logged in save values till logged in ? open modal form on modal success create order and open payment form..
			// var donateorderamount = form.donateamount;

			$.ajax(
			{
				data: $(form).serializeArray(),
				type: 'POST',
				dataType: 'json',
				url: baseUrl + 'professionals/createdonateorder',
				success: function(data)
				{
					if (data.status == 'orderadded')
					{
						//Razorpaypayment
						donatepayment(data.loggedname, data.loggedemail, data.orderid, data.donationid, data.paidto);
					}
					else if (data.status == 'loginfirst')
					{
						$('#loginModal').modal("show");

					}
					else if (data.hasOwnProperty('error'))
					{
						alert(data.error);
					}
					else
					{
						alert('Error sending message, please go to your messages and check if message thread open or please try again.');
					}

				},
				error: function(e)
				{
					// alert('Error sending message, please go to your messages and check if message thread open or please try again.');
				}
			});

		}

	});

	$(document).on('click', '#pendingdonation', function()
	{
		donatepayment($(this).data('loggedname'), $(this).data('loggedemail'), $(this).data('orderid'), $(this).data('donationid'), $(this).data('paidto'));
	});

	$(document).on('submit', '#createRPAccountForm', function(e)
	{
		e.preventDefault();
		if ($(this).find('input[name="threadid"]')) var threadid = $(this).find('input[name="threadid"]').val();
		$('#createRPAccountForm').validate(
		{
			errorPlacement: function(error, element)
			{
				error.insertAfter(element.parent());
			},
			rules:
			{
				business_name:
				{
					required: true,
					alphanumeric: true,
				},
				beneficiary_name:
				{
					required: true,
					alphaspace: true
				},
				ifsc_code:
				{
					required: true,
					alphanumeric: true
				},
				account_number:
				{
					required: true,
					alphanumeric: true
				}
			},
			submitHandler: function(form)
			{
				$.ajax(
				{
					type: "POST",
					url: baseUrl + 'payment/addrazorpayaccount',
					dataType: 'json',
					data: $(form).serialize(),
					success: function(data)
					{
						if (data.hasOwnProperty('successfull'))
						{
							$('#addRazorpayAccountModal').modal('hide');
							$('body').removeClass('modal-open');
							$('.modal-backdrop').remove();
							if (currentpage == 'profile')
							{
								$('#addpaymentaccount').empty();
								$('#addpaymentaccount').append(data.accountdetails);
							}
							else if (currentpage == 'messages')
							{
								$('#singlemessage .unpaidprofform').remove();
								$('#inputmessage').append('<div class="col-xs-12 unpaidprofform"> <form class="form row" action="" method = "POST"  role="form" id="initialMessageProfForm"> <div class="form-group-sm col-xs-12"> <label>Please give a roadmap of how you will solve the issue. </label> <div class="input-group"> <div class="input-group-addon"> <span class="fa fa-road"></span> </div> <textarea required name="message"  class="form-control" rows="5" placeholder="Explain a little about how are you going to tackle the issue"></textarea> </div> </div> <div class="form-group-sm col-xs-12 col-sm-6"> <label>Approximate Time Frame</label> <div class="input-group"> <div class="input-group-addon"> <span class="fa fa-calendar"></span> </div> <input required type="text" name="timeframe"  class="form-control" placeholder="Eg: 10 days or immediately"/> </div> </div> <div class="form-group-sm col-xs-12 col-sm-6"> <label>Cost of consultation (in INR)* <a href="#" data-toggle="popover" title="" data-content="A total 5% of this amount will be deducted from this amount, which includes Payment Gateways Convience Fee (2.25% + GST for Razorpay). " data-trigger="focus"><i class="fa fa-info-circle smalltext"></i></a></label> <div class="input-group"> <div class="input-group-addon"> <span class="fa fa-inr"></span> </div> <input required type="number" name="cost"  required class="form-control" placeholder="1000"/> </div> </div> <div class="form-group-sm col-xs-12 margintop1per"> <input required type="submit" name="initialformsubmit"  class="form-control btn btn-primary" value="Send Message" /> </div></form> </div>');
								$('[data-toggle="popover"]').popover();
							}
							$('<div title="Successfully Created Account" class="success xlargetext">' + data.successfull + '</div>').dialog();

						}
						else if (data.hasOwnProperty('error'))
						{
							$('#addRazorpayAccountModal').modal('hide');
							$('<div title="Request Failed!" class="fail xlargetext">' + data.error.description + '</div>').dialog();

						}
					}
				});
			}
		});
	});
	// CHANGEDNOV19:
	// fetch payment form from ORDER ID, and when user pays autheticate and get paymentid

	$(document).on('click', '#payForMessageRpBtn', function()
	{
		var sendname = $(this).attr('data-name');
		var sendemail = $(this).attr('data-email');
		var ordid = $(this).attr('data-ordid');
		var threadid = $(this).attr('data-threadid');
		var options = {
			"key": rpId,
			"order_id": ordid,
			"name": "Kniew Message Payment",
			"description": "Connecting with professionals...",
			"prefill":
			{
				"name": sendname,
				"email": sendemail,
			},
			"theme":
			{
				"color": "#59DAFB"
			},
			"handler": function(response)
			{
				if (response.razorpay_payment_id)
				{
					var paymentsuccessful;
					$.ajax(
					{
						type: 'post',
						beforeSend: function()
						{
							//disable payment button?
							$(this).prop("disabled", true);
						},
						complete: function()
						{
							//remove div if
							if (paymentsuccessful == 1)
							{
								//remove unpaid div
								$(this).parent().parent().remove();
							}
							else
							{
								//enable payment button
								$(this).prop("disabled", false);
							}
						},
						data:
						{
							'sentorderid': ordid,
							'paymentid': response.razorpay_payment_id,
							'signature': response.razorpay_signature,
							'returnorderid': response.razorpay_order_id,
							'threadid': threadid
						},
						dataType: 'json',
						url: baseUrl + 'payment/payfromrporder',
						success: function(data)
						{
							if (data.hasOwnProperty('success'))
							{
								alert(data.success);
								paymentsuccessful = 1;
								$("#inputmessagebox :input").attr("disabled", false);
								$("#closemessage").attr("disabled", false);
								tinymce.activeEditor.setMode('design');
								if ($('#inputmessage .initialpayuser').length > 0) $('#inputmessage .initialpayuser').remove();
								if ($('#inputmessage .exceedpayuser').length > 0) $('#inputmessage .initialpayuser').remove();
							}
							else
							{
								if (data.hasOwnProperty('error')) alert(data.error);
								else alert('Payment failed!');
								rzp1.open();
							}
						},
						error: function(resp)
						{
							if (resp.error.description != undefined) alert(resp.error.description);
							else alert('Something went wrong!');
						}
					});
				}
				else
				{
					alert("Please try again!");
				}
			}
		};

		var rzp1 = new Razorpay(options);
		rzp1.open();
	});

	$('#addsubscription').on('click', function()
	{
		$.ajax(
		{

			type: 'post',
			data:
			{
				'id': $('#addsubscription').attr('data-id'),
				'expires': $('#addsubscription').attr('data-expires')
			},
			dataType: 'json',
			url: baseUrl + 'payment/razorpaypayment',

			success: function(data)
			{
				var options = {
					"key": data['key'],
					"subscription_id": data['subscriptionid'],
					"name": "Kniew Payment",
					"description": "Reach and connect with clients for your profession...",
					"prefill":
					{
						"name": $('#addsubscription').attr('data-name'),
						"email": $('#addsubscription').attr('data-email'),
					},
					"theme":
					{
						"color": "#59DAFB"
					},
					"handler": function(response)
					{
						if (response.razorpay_payment_id)
						{
							$.ajax(
							{
								type: 'post',
								data:
								{
									'id': $('#addsubscription').attr('data-id'),
									'paymentid': response.razorpay_payment_id,
									'signature': response.razorpay_signature
								},
								url: baseUrl + 'payment/authenticateuser',
								success: function(data)
								{
									if (data == 1) alert("Payment Successful!");
									else rzp1.open();
								},
								error: function()
								{
									alert("Please try again!");
								}
							});
						}
						else
						{
							alert("Please try again!");
						}
					}
				};

				var rzp1 = new Razorpay(options);
				rzp1.open();
			}

		});
	});

	$('#cancelsubscription').on('click', function()
	{

		$.ajax(
		{
			type: 'post',
			data:
			{
				'id': $('#cancelsubscription').attr('data-id')
			},
			url: baseUrl + 'payment/cancelrazorpay',
			success: function(data)
			{
				if (data == 1) $('#profsettings').append('<p class="alert alert-danger">Your account has been deactivated, users will no longer be able to see your profile.</p>');
			},
			error: function() {}
		});
	});

	gapi.load('client', start);

});

$(document).ajaxComplete(function()
{

	// if(currentpage == 'professionals' && !currentpagearray[3])
	//     $("html, body").animate({ scrollTop: $(window).scrollTop() + 100 }, 2000);

	$('.parentfocus input').on('change', function()
	{

		if ($(this).prop('checked'))
		{
			$(this).parent().parent().find(':input').prop('checked', true);

		}
		else
		{
			$(this).parent().parent().find(':input').prop('checked', false);

		}
	});
});

// var getUrl = window.location;
// var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";
//GOOGLE MAP

function initialgooglemap()
{
	initAutocomplete();
	initMap();
}

var placeSearch, autocomplete;
// var componentForm = {
// // street_number: 'short_name',
// sublocality_level_1: 'long_name',
// locality: 'long_name',
// administrative_area_level_1: 'long_name',
// country: 'long_name',
// // postal_code: 'short_name'
// };
var map, marker, geocoder,
	initialLat = 28.6139391,
	initialLng = 77.20902120000005;

function initMap()
{
	var myCenter = new google.maps.LatLng(initialLat, initialLng);

	map = new google.maps.Map(document.getElementById('googleMap'),
	{
		center: myCenter,
		zoom: 6
	});

	if (!marker)
	{
		marker = new google.maps.Marker(
		{
			position: myCenter,
			map: map
		});
	}
	else marker.setMap(null);

	marker.setOptions(
	{
		position: myCenter,
		map: map
	});

	geocoder = new google.maps.Geocoder;

	google.maps.event.addListener(map, 'click', function(event)
	{

		if (!marker)
		{
			marker = new google.maps.Marker(
			{
				position: event.latLng,
				map: map
			});
		}
		else marker.setMap(null);

		marker.setOptions(
		{
			position: event.latLng,
			map: map
		});

		geocoder.geocode(
		{
			'latLng': event.latLng
		}, function(results, status)
		{
			if (status == google.maps.GeocoderStatus.OK)
			{
				if (results[1])
				{
					var address = results[1].formatted_address;
					$('#geolocateAddress').val(address);
					fillInAddress(results[1]);
				}
			}
		});
	});
}

function initAutocomplete()
{
	// Create the autocomplete object, restricting the search to geographical
	// location types.
	autocomplete = new google.maps.places.Autocomplete(
		/** @type {!HTMLInputElement} */
		(document.getElementById('geolocateAddress')),
		{
			types: ['geocode']
		});

	// When the user selects an address from the dropdown, populate the address
	// fields in the form.
	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress(geoadress)
{
	// Get the place details from the autocomplete object.
	geoadress = typeof geoadress === 'undefined' ? 0 : geoadress;
	var place = autocomplete.getPlace() || geoadress;

	if (place.geometry.viewport)
	{
		map.fitBounds(place.geometry.viewport);
	}
	else
	{
		map.setCenter(place.geometry.location);
		map.setZoom(17); // Why 17? Because it looks good.
	}
	if (!marker)
	{
		marker = new google.maps.Marker(
		{
			map: map,
			anchorPoint: new google.maps.Point(0, -29)
		});
	}
	else marker.setMap(null);
	marker.setOptions(
	{
		position: place.geometry.location,
		map: map
	});

	// for (var component in componentForm) {

	//   document.getElementById(component).value = '';
	//   // document.getElementById(component).disabled = false;
	// }

	// Get each component of the address from the place details
	// and fill the corresponding field on the form.
	// for (var i = 0; i < place.address_components.length; i++) {
	//   var addressType = place.address_components[i].types[0];
	//   if (componentForm[addressType]) {
	//     var val = place.address_components[i][componentForm[addressType]];
	//     document.getElementById(addressType).value = val;
	//   }
	// }
}

function geolocate()
{
	if (navigator.geolocation)
	{
		navigator.geolocation.getCurrentPosition(function(position)
		{
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			var circle = new google.maps.Circle(
			{
				center: geolocation,
				radius: position.coords.accuracy
			});
			autocomplete.setBounds(circle.getBounds());
		});
	}
}

if ($('.profAboutSetting').length > 0)
{
	tinymce.init(
	{
		selector: ".profAboutSetting",
		plugins: [
			'noneditable',
			'preventdelete wordcount',
			// 'advlist autolink lists link image charmap print preview anchor',
			// 'searchreplace visualblocks code ',
			'insertdatetime table contextmenu paste code'
		],
		toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		content_css: '//www.tinymce.com/css/codepen.min.css',
		menubar: 'edit format insert table',
		image_caption: true,
		image_title: true,
		image_description: false,
		entity_encoding: "named",
		verify_html: true,
		paste_auto_cleanup_on_paste: true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		paste_auto_cleanup_on_paste: true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		paste_as_text: true,
		paste_word_valid_elements: "b,strong,i,em,h2",
		allow_conditional_comments: false,
		allow_html_in_named_anchor: false,
		allow_unsafe_link_target: false,
		invalid_styles: 'color font-size background background-color ',
		keep_styles: false,
		height: 300,
		formats:
		{
			alignleft:
			{
				selector: '*',
				classes: 'textalignleft'
			},
			aligncenter:
			{
				selector: '*',
				classes: 'textaligncenter'
			},
			alignright:
			{
				selector: '*',
				classes: 'textalignright'
			},
			alignjustify:
			{
				selector: '*',
				classes: 'textalignjustify'
			},
			bold:
			{
				inline: 'b',
				'classes': 'boldtext'
			},
			italic:
			{
				inline: 'i',
				'classes': 'italicstext'
			},
			underline:
			{
				inline: 'span',
				'classes': 'textunderline',
				exact: true
			},
			strikethrough:
			{
				inline: 'span',
				'classes': 'textstrikethrough'
			},

		},
		style_formats: [
		{
			title: 'Headers',
			items: [
				// {title: 'Header 1', format: 'h1'},
				{
					title: 'Header 2',
					format: 'h2'
				},
				{
					title: 'Header 3',
					format: 'h3'
				},
				{
					title: 'Header 4',
					format: 'h4'
				},
				{
					title: 'Header 5',
					format: 'h5'
				},
				{
					title: 'Header 6',
					format: 'h6'
				}
			]
		},
		{
			title: 'Inline',
			items: [
			{
				title: 'Bold',
				icon: 'bold',
				format: 'bold'
			},
			{
				title: 'Italic',
				icon: 'italic',
				format: 'italic'
			},
			{
				title: 'Underline',
				icon: 'underline',
				format: 'underline'
			},
			{
				title: 'Strikethrough',
				icon: 'strikethrough',
				format: 'strikethrough'
			},
			{
				title: 'Superscript',
				icon: 'superscript',
				format: 'superscript'
			},
			{
				title: 'Subscript',
				icon: 'subscript',
				format: 'subscript'
			},
			{
				title: 'code',
				icon: 'code',
				format: 'code'
			}]
		},
		{
			title: 'Blocks',
			items: [
			{
				title: 'Paragraph',
				format: 'p'
			},
			{
				title: 'Blockquote',
				format: 'blockquote'
			}]
		},
		{
			title: 'Alignment',
			items: [
			{
				title: 'Left',
				icon: 'alignleft',
				format: 'alignleft'
			},
			{
				title: 'Center',
				icon: 'aligncenter',
				format: 'aligncenter'
			},
			{
				title: 'Right',
				icon: 'alignright',
				format: 'alignright'
			},
			{
				title: 'Justify',
				icon: 'alignjustify',
				format: 'alignjustify'
			}]
		}],

	});
}

// var registercustomersteps = $('#registercustomersteps').show();
// registercustomersteps.steps({
//     headerTag: "h3",
//     bodyTag: "div",
//     transitionEffect: "slideLeft",
//     enableAllSteps: true,
//     onInit: function(event, currentIndex) {
//         resizeJquerySteps();
// $('#progressStepMessage').html("Only " + (4-currentIndex) + " steps left, to own your own account and connecting with New Clients!");
//         $('#registercustomersteps').css({"display" : "block"});
//         $('#loadReg').css({"display" : "none"});
//         $(document).keypress(function(e){
//             if (e.which == 13){
//                  $('a[href$="#next"]').click();
//             }
//         });
//           // registercustomersteps.validate().settings.ignore = ":hidden";

//     },
//     onStepChanging: function (event, currentIndex, newIndex)
//     {
//         // Allways allow previous action even if the current form is not valid!
//         if (currentIndex > newIndex)
//         {
//             return true;
//         }
//         resizeJquerySteps();

//         $(document).keypress(function(e){
//             if (e.which == 13){
//                  $('a[href$="#next"]').click();
//             }
//         });

//         if(currentIndex == 1)
//         {

$('.copyfrombutton').on('click', function()
{
	var copyText = document.getElementsByClassName("copyfrom");
	console.log(copyText);
	copyText[0].select();
	document.execCommand("copy");
	alert("Copied!");
});

$('#comingsoon_form').submit(function(e)
{
	// e.preventDefault();
	if (!$(this).attr('mailchimpSuccess'))
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + 'userregistervalidate/addToMailchimp',
			data: $('#comingsoon_form').serializeArray(),
			dataType: 'json',
			// timeout: 3000,
			success: function(data)
			{

				if (data[0] == 1)
				{
					$('#comingsoon_form .error').html('');
					// return true;
					$('#comingsoon_form').attr('mailchimpSuccess', true);
					$('#comingsoon_form input[name=code]').val(data[1]);
					$('#comingsoon_form').submit();
				}
				else if (data[0] == 2) $('#comingsoon_form .error').html('Please check your email and try again.');
				else $('#comingsoon_form .error').html('Please try again.');

			},
			error: function()
			{
				$('#comingsoon_form .error').html('Please try after sometime!');
			}
		});
		return false;
	}
	else
	{
		return true;
	}

});

if ($('#registercustomersteps').length > 0)
{
	tinymce.init(
	{
		selector: ".profAbout",
		plugins: [
			'noneditable',
			'preventdelete wordcount',
			// 'advlist autolink lists link image charmap print preview anchor',
			// 'searchreplace visualblocks code ',
			'insertdatetime table contextmenu paste code'
		],
		toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		content_css: '//www.tinymce.com/css/codepen.min.css',
		menubar: 'edit format insert table',
		image_caption: true,
		image_title: true,
		image_description: false,
		entity_encoding: "named",
		paste_auto_cleanup_on_paste: true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		paste_as_text: true,
		paste_word_valid_elements: "b,strong,i,em,h2",
		verify_html: true,
		paste_auto_cleanup_on_paste: true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		allow_conditional_comments: false,
		allow_html_in_named_anchor: false,
		allow_unsafe_link_target: false,
		invalid_styles: 'color font-size background background-color ',
		keep_styles: false,
		height: 300,
		formats:
		{
			alignleft:
			{
				selector: '*',
				classes: 'textalignleft'
			},
			aligncenter:
			{
				selector: '*',
				classes: 'textaligncenter'
			},
			alignright:
			{
				selector: '*',
				classes: 'textalignright'
			},
			alignjustify:
			{
				selector: '*',
				classes: 'textalignjustify'
			},
			bold:
			{
				inline: 'b',
				'classes': 'boldtext'
			},
			italic:
			{
				inline: 'i',
				'classes': 'italicstext'
			},
			underline:
			{
				inline: 'span',
				'classes': 'textunderline',
				exact: true
			},
			strikethrough:
			{
				inline: 'span',
				'classes': 'textstrikethrough'
			},

		},
		style_formats: [
		{
			title: 'Headers',
			items: [
				// {title: 'Header 1', format: 'h1'},
				{
					title: 'Header 2',
					format: 'h2'
				},
				{
					title: 'Header 3',
					format: 'h3'
				},
				{
					title: 'Header 4',
					format: 'h4'
				},
				{
					title: 'Header 5',
					format: 'h5'
				},
				{
					title: 'Header 6',
					format: 'h6'
				}
			]
		},
		{
			title: 'Inline',
			items: [
			{
				title: 'Bold',
				icon: 'bold',
				format: 'bold'
			},
			{
				title: 'Italic',
				icon: 'italic',
				format: 'italic'
			},
			{
				title: 'Underline',
				icon: 'underline',
				format: 'underline'
			},
			{
				title: 'Strikethrough',
				icon: 'strikethrough',
				format: 'strikethrough'
			},
			{
				title: 'Superscript',
				icon: 'superscript',
				format: 'superscript'
			},
			{
				title: 'Subscript',
				icon: 'subscript',
				format: 'subscript'
			},
			{
				title: 'code',
				icon: 'code',
				format: 'code'
			}]
		},
		{
			title: 'Blocks',
			items: [
			{
				title: 'Paragraph',
				format: 'p'
			},
			{
				title: 'Blockquote',
				format: 'blockquote'
			}]
		},
		{
			title: 'Alignment',
			items: [
			{
				title: 'Left',
				icon: 'alignleft',
				format: 'alignleft'
			},
			{
				title: 'Center',
				icon: 'aligncenter',
				format: 'aligncenter'
			},
			{
				title: 'Right',
				icon: 'alignright',
				format: 'alignright'
			},
			{
				title: 'Justify',
				icon: 'alignjustify',
				format: 'alignjustify'
			}]
		}],

	});

	//         }

	//         if(currentIndex == 2)
	//         {
	// var content = tinyMCE.activeEditor.getContent(); // get the content
	// $('#reg_about').html(content);

	//         }

	//         // registercustomersteps.validate().settings.ignore = ":hidden";
	//         return registercustomersteps.valid();
	//     },
	//        onFinishing: function (event, currentIndex)
	//     {
	//         // registercustomersteps.validate().settings.ignore = ":hidden";
	//         return registercustomersteps.valid();
	//     },
	//     onStepChanged: function (event, currentIndex, priorIndex) {
	//         resizeJquerySteps();
	//         if(currentIndex ==1) { var step = " step"; } else {var step = " steps";}
	//         $('#progressStepMessage').html("Only " + (4-currentIndex) +  step +" left, to own your own account and connecting with New Clients!");

	//         if(currentIndex == 1)
	//         {


	//         }
	//         if(currentIndex == 3)
	//         {

	// $("#googleMap").css("height", $("#getLocateInfo").height());
	// google.maps.event.trigger(map, 'resize');
	// map.setZoom( map.getZoom() );
	//         }

	//         if(currentIndex == 2)
	//         {

	// $('.select-image-btn').on('click', function()
	// {
	// 	$("#editpic").modal(
	// 	{
	// 		show: true
	// 	});
	// 	$('.cropit-image-input').click();
	// });
	//
	// $('.image-editor').cropit(
	// {
	// 	exportZoom: 1,
	// 	// imageBackground: true,
	// 	// imageBackgroundBorderWidth: 20,
	// 	imageState:
	// 	{
	// 		src: '',
	// 	},
	// 	allowDragNDrop: true,
	// 	minZoom: 1,
	// 	maxZoom: 5,
	// 	smallImage: 'allow'
	//
	// });

	// $('.rotate-cw').click(function() {
	//   $('.image-editor').cropit('rotateCW');
	// });

	// $('.rotate-ccw').click(function() {
	//   $('.image-editor').cropit('rotateCCW');
	// });
}
//         }
//          registercustomersteps.validate().settings.ignore = ":hidden:not(#reg_about)";

//     },
//     onFinished: function (event, currentIndex)
//     {
//           // registercustomersteps.validate().settings.ignore = ":hidden";

//

//     }

// })

$.validator.addMethod("maxcommas", function(value, element, l)
{
	var n = value.split(",").length;
	return (n <= l);
}, "More than maximum values allowed.");
$.validator.addMethod(
	"regex",
	function(value, element, regexp)
	{
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},
	"Please check your input."
);

// $('#registercustomersteps').submit(function(e)
// {
// 	e.preventDefault();
// 	var content = tinyMCE.activeEditor.getContent(); // get the content
// 	$('#reg_about').html(content);
// })



var registercustomersteps = $('#registercustomersteps').show();
registercustomersteps.steps({
  headerTag: "h3",
  bodyTag: "fieldset",
  transitionEffect: "slideLeft",
  autoFocus: true,
  enableAllSteps: true,
	onInit: function(event, currentIndex) {
		$('#regLoading').remove();

  },
  onStepChanging: function (event, currentIndex, newIndex)
  {
    // Allways allow previous action even if the current form is not valid!
    if (currentIndex > newIndex)
    {
      return true;
    }
    // Needed in some cases if the user went back (clean up)
    if (currentIndex < newIndex)
    {
      // To remove error styles
      registercustomersteps.find(".body:eq(" + newIndex + ") label.error").remove();
      registercustomersteps.find(".body:eq(" + newIndex + ") .error").removeClass("error");
    }
    registercustomersteps.validate().settings.ignore = ":disabled,:hidden";

    if(currentIndex == 3)
    {

      var content = tinyMCE.activeEditor.getContent(); // get the content
      $('#reg_about').html(content);
      registercustomersteps.validate().settings.ignore = ":disabled,:hidden:not(#reg_about)";

    }
    resizeJquerySteps();
    return registercustomersteps.valid();
  },
  onStepChanged: function (event, currentIndex, priorIndex) {
    resizeJquerySteps();
    $('#wizard .content :input:enabled:visible:first').focus();
  },
  onFinishing: function (event, currentIndex)
  {
    registercustomersteps.validate().settings.ignore = ":disabled";
    return registercustomersteps.valid();
  },
  onFinished: function (event, currentIndex)
  {
    var imageData = $('#registerprofimage .image-editor').cropit('export');
    $('#registerprofimage .hidden-image-data').val(imageData);
    var workatvalue = $('#workatname').val();
    var workatid = $('#workatlist [value="' + workatvalue + '"]').data('value');
    $('#workatid').val(workatid);
    var postdata = registercustomersteps.serializeArray();

    $.ajax(
    {
      type: "POST",
      url: baseUrl + 'userregistervalidate/submitregisterprofessional',
      data: postdata,
      dataType: 'json',
      beforeSend: function()
      {
				$('#registercustomersteps:input').prop('disabled', true);
        $('.regcontfluid #regProfResult').html('');

      },
      success: function(data)
      {
        $('.regcontfluid #regProfResult').html('');
        if (data.hasOwnProperty('createdonateorder'))
        {
          var donate = data.createdonateorder;
          if (donate.hasOwnProperty('donationid')) donatepayment(donate.loggedname, donate.loggedemail, donate.orderid, donate.donationid, donate.paidto);
          else if (donate.hasOwnProperty('error')) alert(donate.error);
        }

        if (data.hasOwnProperty('success'))
        {

					$('<div id="afterRegProf" class="float-xs-center centertext"></div>').dialog(
					{
						title: "Choose next action..",
						dialogClass: "no-close",
						buttons: [
						{
							text: "Link your Account, to receive communication/donations and payments from users.",
							click: function()
							{
								window.location.replace(baseUrl + 'profile#addpaymentaccount');
							},
							icon: 'fa fa-credit-card',
							width: '100%',
							class: 'crossbackground lightgreenBack boldtext'
						},
						{
							text: "Enable appointment, so that users can make appointment with you.",
							click: function()
							{
								window.location.replace(baseUrl + 'profile#appointment');
							},
							icon: 'fa fa-calendar-check-o',
							width: '100%',
							class: 'crossbackground success'
						},
						{
							text: "Write and submit an article, to increase your visibility on Kniew.",
							click: function()
							{
								window.location.replace(baseUrl + 'contact');
							},
							icon: 'fa fa-pencil-square-o',
							width: '100%',
							class: 'crossbackground cadetblueBack'
						},
						{
							text: "Make changes to your Profile.",
							click: function()
							{
								window.location.replace(baseUrl + 'profile#settings');
							},
							icon: 'fa fa-user',
							width: '100%',
							class: 'crossbackground backSize20to10'
						},
						{
							text: "Search for other professionals.",
							click: function()
							{
								window.location.replace(baseUrl + 'professionals');
							},
							icon: 'fa fa-search',
							width: '100%',
							class: 'crossbackground backSize20to10'
						},
						{
							text: "Go to home.",
							click: function()
							{
								window.location.replace(baseUrl);
							},
							icon: 'fa fa-home',
							width: '100%',
							class: 'crossbackground backSize20to10'
						}]
					});
          $('.regcontfluid #regProfResult').html(data.success);

        }
        else $('.regcontfluid #regProfResult').html(data.error);

        // 	$.ajax({
        //     type: "POST",
        //     url: baseUrl + 'userregistervalidate/addToMailchimp',
        //     data:  postdata,
        //     dataType: 'json',
        //     // timeout: 3000,
        //     success: function(data)
        //     {
        //
        //     	if(data[0] == 1)
        //   		{
        //          // window.location.href = baseUrl + "notice/thankyou/profession_register/" + $('input[name=custregrole]').val();
        //           window.location.href = baseUrl + "referafriend/";
        //   		}
        //     	else if(data[0] == 2) $('#registercustomersteps').append('<p class="error">Please check your email and try again.</p>');
        //     	else $('#registercustomersteps').append('<p class="error">Please try again.</p>');
        //
        //     },
        //     error:function(){ $('#registercustomersteps').append('<p class="error">Please try after sometime!</p>');}
        // });

      }

    });
  }
}).validate(
{
	// ignore: ":hidden:not(#reg_about)", //":not(input[name='recommendids[0]']):not(input[name='recommendids[1]']):not(input[name='recommendids[2]'])",
	errorPlacement: function errorPlacement(error, element)
	{
		if (element[0].id == 'reg_about')
		{
			error.insertAfter('.mce-tinymce');
		}
		if (element.is(":radio"))
		{
			error.appendTo(element.parents('#roleicons'));
		}
		else error.appendTo(element.parent("div").parent("div"));
		resizeJquerySteps();
	},
	rules:
	{
		custregrole:
		{
			required: true,
		},
		email:
		{
			required: true,
			remote:
			{
				url: baseUrl + "userregistervalidate/checkemail",
				type: "post"
			}
		},
		username:
		{
			required: true,
			minlength: 5,
			maxlength: 50,
			remote:
			{
				url: baseUrl + "userregistervalidate/checkusername",
				type: "post"
			},
			inArray: ['kniew', 'kniew.com', 'admin', 'adminstrator', 'administrator', 'user', 'lawyer', 'doctor', 'ngo', 'ca', 'charteredaccountant', 'chartered_accountant']
		},
		'cropit-image-input':
		{
			extension: "gif|jpeg|png|jpg"
		},
		language:
		{
			required: true,
			alphacomma: true
		},
		about:
		{
			required: true,
			minlength: 200,
			maxlength: 20000
		},
		password:
		{
			required: true,
			minlength: 5
		},
		name:
		{
			required: true,
			minlength: 3,
			alphaspace: true,
			maxlength: 50,
			inArray: ['kniew', 'kniew.com', 'admin', 'adminstrator', 'administrator', 'user', 'lawyer', 'doctor', 'ngo', 'ca', 'charteredaccountant', 'chartered accountant']
		},
		phone:
		{
			number: true
		},
		regspecialisation:
		{
			required: true,
			valueNotEquals: 'default'
		},
		verificationid:
		{
			required: true,
			regex: function(element)
			{
				var custrole = $('#registercustomersteps input[name="custregrole"]:checked').val();
				if (custrole == 2 || custrole == 3) return "^[a-zA-Z]{2}\\/\\d{1,}\\/\\d{1,}$";
				else if (custrole == 5) return "^\\d{6}$";

			},
			remote:
			{
				url: baseUrl + "userregistervalidate/checkverificationid",
				type: "post",
				data:
				{
					custrole: function()
					{
						return $('#registercustomersteps input[name="custregrole"]:checked').val();
					}

				}
			}
		},
		// 'regspecialisationother[]':{
		// 	maxMultipleSelect: 5
		// },
		'jurisdiction[]':
		{
			required: true,
			minlength: 1
		},
		'recommendids[0]':
		{
			required: function(element)
			{
				var recommendnamearray = $("#recommendname").val().split(",");
				return recommendnamearray[0] != "";
			},
			notEqualTo: '#recommendid1,#recommendid2, #profsettings_id',
		},
		'recommendids[1]':
		{
			required: function(element)
			{
				var recommendnamearray = $("#recommendname").val().split(",");
				return (recommendnamearray[1] != "" && recommendnamearray[1] != undefined);
			},
			notEqualTo: '#recommendid0,#recommendid2, #profsettings_id'
		},
		'recommendids[2]':
		{
			required: function(element)
			{
				var recommendnamearray = $("#recommendname").val().split(",");
				return (recommendnamearray[2] != "" && recommendnamearray[2] != undefined);
			},
			notEqualTo: '#recommendid0,#recommendid1, #profsettings_id',
		},
		recommendname:
		{
			maxcommas: 3
		}
	},
	messages:
	{
		regspecialisation:
		{
			valueNotEquals: 'Please select your occupation first and then the specialisation.'
		},
		verificationid:
		{
			required: 'Registration/ID number is needed in order to verify authenticity.',
			regex: 'Please make sure that the registeration number is in correct format.'
		},
		about:
		{
			required: 'Please fill the about field. It reassures users about you.',
			minlength: 'Too short. Please describe yourself in more words.',
			maxlength: 'Too long. Please describe yourself in fewer words.',
		},
		recommendname:
		{
			maxcommas: 'You can only recommend upto three people registered with us.'
		},
		'recommendids[0]':
		{
			required: 'Please enter a valid name. The FIRST user you entered is not registered with us. Please wait for suggestions and click on one.',
			notEqualTo: 'Same first and second user. You cannot add the same user more than once. You cannot recommend yourself.',
		},
		'recommendids[1]':
		{
			required: 'Please enter a valid name. The SECOND user you entered is not registered with us. Please wait for suggestions and click on one.',
			notEqualTo: 'Same second and third user. You cannot add the same user more than once. You cannot recommend yourself.',
		},
		'recommendids[2]':
		{
			required: 'Please enter a valid name. The THIRD user you entered is not registered with us. Please wait for suggestions and click on one.',
			notEqualTo: 'Same first and third user. You cannot add the same user more than once. You cannot recommend yourself.',
		}
	},
	// submitHandler: function(form)
	// {
	// 	var imageData = $('#registerprofimage .image-editor').cropit('export');
	// 	$('#registerprofimage .hidden-image-data').val(imageData);
	// 	var workatvalue = $('#workatname').val();
	// 	var workatid = $('#workatlist [value="' + workatvalue + '"]').data('value');
	// 	$('#workatid').val(workatid);
	// 	var postdata = $('#registercustomersteps').serializeArray();
  //
	// 	$.ajax(
	// 	{
	// 		type: "POST",
	// 		url: baseUrl + 'userregistervalidate/submitregisterprofessional',
	// 		data: postdata,
	// 		dataType: 'json',
	// 		beforeSend: function()
	// 		{
	// 			$('.regcontfluid #regProfResult').html('');
  //
	// 		},
	// 		success: function(data)
	// 		{
	// 			$('.regcontfluid #regProfResult').html('');
	// 			if (data.hasOwnProperty('createdonateorder'))
	// 			{
	// 				var donate = data.createdonateorder;
	// 				if (donate.hasOwnProperty('donationid')) donatepayment(donate.loggedname, donate.loggedemail, donate.orderid, donate.donationid, donate.paidto);
	// 				else if (donate.hasOwnProperty('error')) alert(donate.error);
	// 			}
  //
	// 			if (data.hasOwnProperty('success'))
	// 			{
  //
	// 				$('<p class="float-xs-center"></p>').dialog(
	// 				{
	// 					dialogClass: "no-close",
	// 					buttons: [
	// 					{
	// 						text: "Link your Account, to receive communication and payments from users.",
	// 						click: function()
	// 						{
	// 							window.location.replace(baseUrl + 'profile#addpaymentaccount');
	// 						}
	// 					},
	// 					{
	// 						text: "Write and submit an article, to increase your visibility on Kniew.",
	// 						click: function()
	// 						{
	// 							window.location.replace(baseUrl + 'contact');
	// 						}
	// 					},
	// 					{
	// 						text: "Make changes to your Profile.",
	// 						click: function()
	// 						{
	// 							window.location.replace(baseUrl + 'profile#settings');
	// 						}
	// 					},
	// 					{
	// 						text: "Search for other professionals.",
	// 						click: function()
	// 						{
	// 							window.location.replace(baseUrl + 'professionals');
	// 						}
	// 					},
	// 					{
	// 						text: "Go to home.",
	// 						click: function()
	// 						{
	// 							window.location.replace(baseUrl);
	// 						}
	// 					}]
	// 				});
	// 				$('.regcontfluid #regProfResult').html(data.success);
  //
	// 			}
	// 			else $('.regcontfluid #regProfResult').html(data.error);
  //
	// 			// 	$.ajax({
	// 			//     type: "POST",
	// 			//     url: baseUrl + 'userregistervalidate/addToMailchimp',
	// 			//     data:  postdata,
	// 			//     dataType: 'json',
	// 			//     // timeout: 3000,
	// 			//     success: function(data)
	// 			//     {
	// 			//
	// 			//     	if(data[0] == 1)
	// 			//   		{
	// 			//          // window.location.href = baseUrl + "notice/thankyou/profession_register/" + $('input[name=custregrole]').val();
	// 			//           window.location.href = baseUrl + "referafriend/";
	// 			//   		}
	// 			//     	else if(data[0] == 2) $('#registercustomersteps').append('<p class="error">Please check your email and try again.</p>');
	// 			//     	else $('#registercustomersteps').append('<p class="error">Please try again.</p>');
	// 			//
	// 			//     },
	// 			//     error:function(){ $('#registercustomersteps').append('<p class="error">Please try after sometime!</p>');}
	// 			// });
  //
	// 		}
  //
	// 	});
	// 	// return false;
	// }
});

if ($("#custRegProgressBar").length)
{
	var progressInterval = setInterval(function()
	{
		var progress = $('#registercustomersteps .percentagebarclass.valid').length,
			total = $('#registercustomersteps .percentagebarclass').length;
		var width = Math.round(progress / total * 100);
		$('#custRegProgressBar').css(
		{
			"width": width + '%'
		});
		if (width > 0) $('#progressStepMessage').html(width + "% closer to owning your account and connecting to New Clients!");
	}, 200);
}

function resizeJquerySteps()
{
	$('.wizard .content').animate(
	{
		height: $('.body.current').outerHeight()
	}, 'slow');
}

if (document.getElementsByClassName('wizard').length > 0) $(window).resize($.debounce(250, resizeJquerySteps));

if ($('#profsettings').length > 0)
{
	var type = $('#profsettingsMainfocus').data('type');
	$.ajax(
	{
		url: baseUrl + 'registerasprofessional/getworkat&type=' + type,
		success: function(data)
		{
			$('#workatlist').empty();
			$('#workatlist').append(data);
		}
	});
}

var focusAllHtml = {};
if (currentpage == 'registerasprofessional')
{
	$.ajax(
	{
		url: baseUrl + 'registerasprofessional/getAllFocus',
		dataType: 'json',
		type: 'post',
		success: function(data)
		{
			focusAllHtml = data;
		}
	});
}

$("input[name='custregrole']").on('change', function()
{
	$('#registercustomersteps').valid();
	$('#regspecialisation').empty();
	$('#regspecialisationother').empty();
	$('.isfreelabel').empty();
	$('#verification label').empty();
	$('#jurisdiction').empty();

	if ($(this).is(':checked'))
	{
		var usertype = $(this).val();

		var arraykey = 'type_' + usertype;
		$('#regspecialisation').empty();
		$('#regspecialisationother').empty();
		if (focusAllHtml.hasOwnProperty(arraykey))
		{
			$('#regspecialisation').append(focusAllHtml[arraykey]);
			$('#regspecialisationother').append(focusAllHtml[arraykey]);
		}
		else
		{
			$('#regspecialisation').append('<option value = "default"> Something went wrong! Please select any other option and then reselect your occupation! </option>');
			$('#regspecialisationother').append('<option value = "default"> Something went wrong! Please select any other option and then reselect your occupation! </option>');
		}

		if (usertype == '2')
		{
			$('#isfree label').append('<span class="isfreelabel">Provide consultation <a href="#" data-toggle="popover" title="" data-content="Do you provide consultation to people in need? For example - legal advice." data-trigger="focus"><i class="fa fa-info-circle"></i></a></span>');
			$('#jurisdiction').append('<div ><p>Level of support <a href="#" data-toggle="popover" title="" data-content="This specifies the extent of your support from where you are based." data-trigger="focus"><i class="fa fa-info-circle"></i></a></p>' +
				'<input  type="checkbox" value="City Wide" name="jurisdiction[]"><label for="jurisdiction[]">City Wide </label> ' +
				'<input type="checkbox" value="State Wide" name="jurisdiction[]"><label for="jurisdiction[]">State Wide </label> ' +
				'<input type="checkbox" value="Country Wide" name="jurisdiction[]"><label for="jurisdiction[]">Country Wide </label></div>');
			$('#jurisdiction').show();
			$('#verification label').append("Unique ID with NGO-DARPAN*");
			$('#isfirm').hide();
		}
		else if (usertype == '3')
		{
			$('#isfree label').append('<span class="isfreelabel">Pro-bono <a href="#" data-toggle="popover" title="" data-content="Do you do pro-bono work?" data-trigger="focus"><i class="fa fa-info-circle"></i></a></span>');
			$('#jurisdiction').append('<div ><p>Appear in*</p>' +
				'<input type="checkbox" value="District Court" name="jurisdiction[]"><label for="jurisdiction[]">District Court</label> ' +
				'<input type="checkbox" value="High Court" name="jurisdiction[]"><label for="jurisdiction[]">High Court </label> ' +
				'<input type="checkbox" value="Supreme Court" name="jurisdiction[]"><label for="jurisdiction[]">Supreme Court</label> ' +
				'<input type="checkbox" value="Revenue Board" name="jurisdiction[]"><label for="jurisdiction[]">Revenue Board</label> ' +
				'<input type="checkbox" value="Tax Board" name="jurisdiction[]"><label for="jurisdiction[]">Tax Board</label></div>'
			);
			$('#jurisdiction').show();
			$('#verification label').append('Bar Council of India Registeration Number*');
			$('#isfirm').html('<label for="isfirm" ><input type="checkbox" value="true" name="isfirm" >	This is a firm. <a href="#" data-toggle="popover" title="" data-content="If you are making an account for your firm, tick this box. This will help people find you more efficiently, and your employees will be able to list you as their employer. " data-trigger="focus"><i class="fa fa-info-circle"></i></a>		</label>');
			$('#isfirm').show();
		}
		else if (usertype == '4')
		{
			$('#isfree label').append('<span class="isfreelabel">Free clinic/consultation</span>');
			$('#jurisdiction').append('<div ><p>Provide services at*</p>' +
				'<input type="checkbox" value="Hospital" name="jurisdiction[]"><label for="jurisdiction[]">Hospital</label> ' +
				'<input type="checkbox" value="Clinic" name="jurisdiction[]"><label for="jurisdiction[]">Clinic</label> ' +
				'<input type="checkbox" value="Home Visits" name="jurisdiction[]"><label for="jurisdiction[]">Home Visits</label></div>');
			$('#jurisdiction').show();
			$('#verification label').append('Medical Council India, Registration number*');
			$('#isfirm').html('<label for="isfirm" ><input type="checkbox" value="true" name="isfirm" >	This is a hospital. <a href="#" data-toggle="popover" title="" data-content="If you are making an account for your hospital, tick this box. This will help people find you more efficiently, and your employees will be able to list you as their employer. " data-trigger="focus"><i class="fa fa-info-circle"></i></a>		</label>');
			$('#isfirm').show();
		}
		else if (usertype == '5')
		{
			$('#isfree label').append('<span class="isfreelabel">Free consultation</span>');
			$('#jurisdiction').append('<div ><p>Level*</p>' +
				'<input  type="checkbox" value="Local" name="jurisdiction[]"><label for="jurisdiction[]">Local</label> ' +
				'<input type="checkbox" value="State" name="jurisdiction[]"><label for="jurisdiction[]">State</label> ' +
				'<input type="checkbox" value="National" name="jurisdiction[]"><label for="jurisdiction[]">National </label></div>'
			);
			$('#jurisdiction').show();
			$('#verification label').append('ICAI membership registeration number*');
			$('#isfirm').hide();
		}

		$('#isfree').show();
		$('#verification').show();

		$('[data-toggle="popover"]').popover();

		// $.ajax({
		//   url: baseUrl + 'registerasprofessional/getfocus&type=' + type,
		//   success: function(data) {
		//   	$('#regspecialisation').empty();
		// 		$('#regspecialisationother').empty();
		//     $('#regspecialisation').append(data);
		//     $('#regspecialisationother').append(data);
		//   }
		// });

		if (usertype == 3 || usertype == 4 || usertype == 5)
		{
			$('#appointmentfee').css(
			{
				'display': 'block'
			});
			$('#allowappointment').css(
			{
				'display': 'inline-block'
			});
			$('#allowContainer').css(
			{
				'display': 'inline-block'
			});
			$('#onlinesessiontext').html('Do you provide online counselling? <a href="#" data-toggle="popover" title="" data-content="If you choose not to select this option, users will NOT be able to message you. " data-trigger="focus"><i class="fa fa-info-circle error"></i></a>');
		}
		else
		{
			$('#appointmentfee').css(
			{
				'display': 'none'
			});
			$('#allowappointment').css(
			{
				'display': 'none'
			});
			$('#allowContainer').css(
			{
				'display': 'none'
			});
			$('#onlinesessiontext').html('Do you accept online donations? <a href="#" data-toggle="popover" title="" data-content="If you choose not to select this option, users will NOT be able to donate to your account. " data-trigger="focus"><i class="fa fa-info-circle error"></i></a>');

		}

		$.ajax(
		{
			url: baseUrl + 'registerasprofessional/getworkat&type=' + usertype,
			success: function(data)
			{
				$('#workatlist').empty();
				$('#workatlist').append(data);
			}

		});
	}
});

$("input[name='isfirm']").on('change', function()
{
	if ($(this).is(':checked'))
	{
		$('input[name="workatname"]').prop('disabled', true);
	}
	else
	{
		$('input[name="workatname"]').prop('disabled', false);
	}
	resizeJquerySteps();
});

$("input[name='allowappointment']").on('change', function()
{
	if ($(this).is(':checked'))
	{
		$('.allowapointment').css(
		{
			'display': 'inline-block'
		});
	}
	else
	{
		$('.allowapointment').css(
		{
			'display': 'none'
		});
	}
	resizeJquerySteps();
});

$('#weeklyAppointment').click(function()
{
	$('#tillDate')[this.checked ? "show" : "hide"]();
});

$(".passwordShowButton").on('mouseup', function()
{
	$(".passwordShow").attr("type", "password");
	$('.fa-eye').removeClass().addClass('fa fa-eye-slash');
});
$('.passwordShowButton').on('mousedown', function()
{
	$(".passwordShow").attr("type", "text");
	$('.fa-eye-slash').removeClass().addClass('fa fa-eye');
});

// $('.usernameRegister').on('focus', function()
// {
// 	var email = $(".emailRegister").val();
// 	var extractEmail = email.substring(0, email.indexOf("@"));
// 	if (extractEmail && !this.value)
// 	{
// 		this.value = extractEmail;
// 	}
// });
$('#registercustomersteps .emailRegister').on('blur', function() {
  var email = $(".emailRegister").val();
	var extractEmail = email.substring(0, email.indexOf("@"));
  if($('.usernameRegister').val() == '') $('.usernameRegister').val(extractEmail.replace(/[\.\-]/gi, '_').replace(/[^a-z0-9_]/gi, ''));
	if($('.nameRegister').val() == '') $('.nameRegister').val(extractEmail.replace(/[\.\-_]/gi, ' ').replace(/[^a-zA-Z\s]/gi, '').trim());
});
$('.inputPassword').on('keyup', function()
{
	$('#passwordStrength').html(checkStrength($('.inputPassword').val()));
});

function checkStrength(password)
{
	var strength = 0
	if (password.length < 6)
	{
		$('#passwordStrength').removeClass();
		$('#passwordStrength').addClass('short');
		$('.strengthBar').css(
		{
			"background": "#FF0000",
			"width": "25%",
			"height": "3px"
		});
		return 'Too short';
	}
	if (password.length > 7) strength += 1;

	// If password contains both lower and uppercase characters, increase strength value.
	if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;

	// If it has numbers and characters, increase strength value.
	if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1;

	// If it has one special character, increase strength value.
	if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;

	// If it has two special characters, increase strength value.
	if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;

	// Calculated strength value, we can return messages
	// If value is less than 2
	if (strength < 2)
	{
		$('#passwordStrength').removeClass();
		$('#passwordStrength').addClass('weak');
		$('.strengthBar').css(
		{
			"background": "orange",
			"width": "50%",
			"height": "3px"
		});
		return 'Weak';
	}
	else if (strength == 2)
	{
		$('#passwordStrength').removeClass();
		$('#passwordStrength').addClass('good');
		$('.strengthBar').css(
		{
			"background": "#2D98F3",
			"width": "75%",
			"height": "3px"
		});
		return 'Good';
	}
	else
	{
		$('#passwordStrength').removeClass();
		$('#passwordStrength').addClass('strong');
		$('.strengthBar').css(
		{
			"background": "limegreen",
			"width": "100%",
			"height": "3px"
		});
		return 'Strong';
	}
}
// var getUrl = window.location;
// var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";

$("#canceladdarticle").click(function()
{
	$('#addarticleform')[0].reset();
});

if ($('.story').length > 0)
{
	tinymce.init(
	{
		selector: ".story",
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace wordcount visualblocks code',
			'insertdatetime table contextmenu paste code emoticons '
		],
		browser_spellcheck: true,
		toolbar: 'insertfile undo redo| paste | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ',
		content_css: '//www.tinymce.com/css/codepen.min.css',
		content_style: "*{font-family : Comic Sans MS, cursive; line-height: 2;} .textalignjustify{text-align: justify!important;} .textalignleft{text-align: left!important;} .textaligncenter{text-align: center!important;}  .textalignright{text-align: right!important;} .boldtext{font-weight: bold!important;} .italicstext{font-style: italic!important;} .textunderline{text-decoration: underline!important;} .textstrikethrough{text-decoration: line-through!important;} .textsuperscript{vertical-align: super!important;} .textsubscript{vertical-align: sub!important;}",
		paste_auto_cleanup_on_paste: true,
		paste_remove_styles: true,
		paste_remove_styles_if_webkit: true,
		paste_strip_class_attributes: true,
		paste_as_text: true,
		inline_styles: false,
		paste_word_valid_elements: "b,strong,i,em,h2",
		image_caption: true,
		image_title: true,
		image_description: false,
		entity_encoding: "named",
		verify_html: true,
		allow_conditional_comments: false,
		allow_html_in_named_anchor: false,
		allow_unsafe_link_target: false,
		invalid_styles: 'color font-family font-size background background-color line-height text-align',
		keep_styles: false,
		height: 500,
		invalid_elements: 'h1',
		block_formats: 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre',
		formats:
		{
			alignleft:
			{
				selector: '*',
				classes: 'textalignleft'
			},
			aligncenter:
			{
				selector: '*',
				classes: 'textaligncenter'
			},
			alignright:
			{
				selector: '*',
				classes: 'textalignright'
			},
			alignjustify:
			{
				selector: '*',
				classes: 'textalignjustify'
			},
			bold:
			{
				inline: 'b',
				'classes': 'boldtext'
			},
			italic:
			{
				inline: 'i',
				'classes': 'italicstext'
			},
			underline:
			{
				inline: 'span',
				'classes': 'textunderline',
				exact: true
			},
			strikethrough:
			{
				inline: 'span',
				'classes': 'textstrikethrough'
			},

		},

		style_formats: [
		{
			title: 'Headers',
			items: [
				// {title: 'Header 1', format: 'h1'},
				{
					title: 'Header 2',
					format: 'h2'
				},
				{
					title: 'Header 3',
					format: 'h3'
				},
				{
					title: 'Header 4',
					format: 'h4'
				},
				{
					title: 'Header 5',
					format: 'h5'
				},
				{
					title: 'Header 6',
					format: 'h6'
				}
			]
		},
		{
			title: 'Inline',
			items: [
			{
				title: 'Bold',
				icon: 'bold',
				format: 'bold'
			},
			{
				title: 'Italic',
				icon: 'italic',
				format: 'italic'
			},
			{
				title: 'Underline',
				icon: 'underline',
				format: 'underline'
			},
			{
				title: 'Strikethrough',
				icon: 'strikethrough',
				format: 'strikethrough'
			},
			{
				title: 'Superscript',
				icon: 'superscript',
				format: 'superscript'
			},
			{
				title: 'Subscript',
				icon: 'subscript',
				format: 'subscript'
			},
			{
				title: 'code',
				icon: 'code',
				format: 'code'
			}]
		},
		{
			title: 'Blocks',
			items: [
			{
				title: 'Paragraph',
				format: 'p'
			},
			{
				title: 'Blockquote',
				format: 'blockquote'
			}]
		},
		{
			title: 'Alignment',
			items: [
			{
				title: 'Left',
				icon: 'alignleft',
				format: 'alignleft'
			},
			{
				title: 'Center',
				icon: 'aligncenter',
				format: 'aligncenter'
			},
			{
				title: 'Right',
				icon: 'alignright',
				format: 'alignright'
			},
			{
				title: 'Justify',
				icon: 'alignjustify',
				format: 'alignjustify'
			}]
		}],

	});
}

$(document).ready(function()
{

	$('[data-toggle="popover"]').popover();

	if ($('#profsettings').length > 0)
	{
		var type = ($('#profsettingsMainfocus').attr('data-type'));
		var mainfocus = ($('#profsettingsMainfocus').attr('data-old'));
		var otherfocus = ($('#profsettingsOtherfocus').attr('data-old'));

		// GET FOCUS
		$.ajax(
		{

			url: baseUrl + 'registerasprofessional/getfocus&type=' + type,
			success: function(html)
			{
				$("#profsettingsMainfocus").append(html);
				$("#profsettingsOtherfocus").append(html);

			}
		}).done(function()
		{
			$("#profsettingsMainfocus option[value='" + mainfocus + "']").attr("selected", "selected");
			for (var i = otherfocus.length; i--; i >= 0)
			{
				$("#profsettingsOtherfocus option[value='" + otherfocus[i] + "']").attr("selected", "selected");
			}
		});

	}

	$('#profsettings').submit(function(e)
	{
		e.preventDefault();
	}).validate(
	{
		ignore: ":hidden:not(#prof_about):not(input[name='recommendids[0]']):not(input[name='recommendids[1]']):not(input[name='recommendids[2]'])",
		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div").parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			username:
			{
				required: true,
				minlength: 5,
				remote:
				{
					url: baseUrl + "profile/checkusername",
					type: "post",
					data:
					{
						oldusername: function()
						{
							return $('#profsettings input[name="username"]').attr('data-oldusername');
						}

					}
				},
				inArray: ['kniew', 'kniew.com', 'admin', 'adminstrator', 'administrator', 'user', 'lawyer', 'doctor', 'ngo', 'ca', 'charteredaccountant', 'chartered_accountant']
			},
			email:
			{
				required: true,
				remote:
				{
					url: baseUrl + "profile/checkemail",
					type: "post",
					data:
					{
						oldemail: function()
						{
							return $('#profsettings input[name="email"]').attr('data-oldemail');
						}
					}
				}
			},
			'cropit-image-input':
			{
				extension: "gif|jpeg|png|jpg"
			},
			language:
			{
				required: true,
				alphacomma: true
			},
			about:
			{
				required: true,
				minlength: 200,
				maxlength: 20000
			},
			name:
			{
				required: true,
				minlength: 3,
				alphaspace: true,
				maxlength: 50,
				inArray: ['kniew', 'kniew.com', 'admin', 'adminstrator', 'administrator', 'user', 'lawyer', 'doctor', 'ngo', 'ca', 'charteredaccountant', 'chartered accountant']
			},
			phone:
			{
				number: true
			},
			profsettingsMainfocus:
			{
				required: true,
				valueNotEquals: 'default'
			},
			'jurisdiction[]':
			{
				required: true,
				minlength: 1
			},
			'recommendids[0]':
			{
				required: function(element)
				{
					var recommendnamearray = $("#recommendname").val().split(",");
					return recommendnamearray[0] != "";
				},
				notEqualTo: '#recommendid1,#recommendid2 #profsettings_id',
			},
			'recommendids[1]':
			{
				required: function(element)
				{
					var recommendnamearray = $("#recommendname").val().split(",");
					return (recommendnamearray[1] != "" && recommendnamearray[1] != undefined);
				},
				notEqualTo: '#recommendid2 , #recommendid0, #profsettings_id'
			},
			'recommendids[2]':
			{
				required: function(element)
				{
					var recommendnamearray = $("#recommendname").val().split(",");
					return (recommendnamearray[2] != "" && recommendnamearray[2] != undefined);
				},
				notEqualTo: '#recommendid0,#recommendid1, #profsettings_id',
			},
			recommendname:
			{
				maxcommas: 3
			}
		},
		messages:
		{
			profsettingsMainfocus:
			{
				valueNotEquals: 'Please select your occupation first and then the specialisation.'
			},
			about:
			{
				required: 'Please fill the about field. It reassures users about you.',
				minlength: 'Too short. Please describe yourself in more words.',
				maxlength: 'Too long. Please describe yourself in fewer words.',
			},
			recommendname:
			{
				maxcommas: 'You can only recommend upto three people registered with us.'
			},
			'recommendids[0]':
			{
				required: 'Please enter a valid name. The FIRST user you entered is not registered with us. Please wait for suggestions and click on one.',
				notEqualTo: 'Same first and second user. You cannot add the same user more than once. You cannot recommend yourself.',
			},
			'recommendids[1]':
			{
				required: 'Please enter a valid name. The SECOND user you entered is not registered with us. Please wait for suggestions and click on one.',
				notEqualTo: 'Same second and third user. You cannot add the same user more than once. You cannot recommend yourself.',
			},
			'recommendids[2]':
			{
				required: 'Please enter a valid name. The THIRD user you entered is not registered with us. Please wait for suggestions and click on one.',
				notEqualTo: 'Same first and third user. You cannot add the same user more than once. You cannot recommend yourself.',
			}
		},
		submitHandler: function(form)
		{
			var imageData = $('#profilepic_prof .image-editor').cropit('export');
			$('#profilepic_prof .hidden-image-data').val(imageData);
			var workatvalue = $('#workatname').val();
			var workatid = $('#workatlist [value="' + workatvalue + '"]').data('value');
			$('#workatid').val(workatid);
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "profile/updateprofprofile",
				data: $(form).serialize(),
				dataType: 'json',
				timeout: 3000,
				success: function(data)
				{
					if (data.hasOwnProperty('result'))
					{
						if ($('#profsettings .profresult').length > 0) $('#profsettings .profresult').remove();
						$('#profsettings').append(data.result);
					}

				}
			});
			return false;
		}
	});

	if ($('#profsettings').length > 0 && $('#recommendid0').val())
	{
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "profile/getrecommendname",
			data:
			{
				0: $('#recommendid0').val(),
				1: $('#recommendid1').val(),
				2: $('#recommendid2').val()
			},
			// timeout: 3000,
			success: function(data)
			{
				if (data)
				{
					$('#recommendname').val(data);
				}

			}
		});
	}

	$(document).on('click', '.clarifyDetails', function(){
		$('#clarifyDetailsEmailForm #emailSendTo').val($(this).data('email'));
		$('#clarifyDetailsEmailForm #nameSendTo').val($(this).data('name'));
		$('#addNameDynamically').html($(this).data('name'));
		$('#sendEmailModal').modal('show');
	});

	$(document).on('keypress', '#clarifyDetailsEmailForm #emailContent',function(){addBulletNewline(document.getElementById('emailContent'));});

	function addBulletNewline(elementById)
	{
		var key = window.event.keyCode;
    // If the user has pressed enter
    if (key === 13) {
      elementById.value = elementById.value + "\n \u2022";
      return false;
    }
    else {
        return true;
    }

	}

	$(document).on('submit', '#clarifyDetailsEmailForm', function(e){
		e.preventDefault();

		$.ajax(
		{
			type: "POST",
			url: baseUrl + "profile/clarifydetailssend",
			data:	$(this).serializeArray(),
			dataType: 'json',
			// timeout: 3000,
			beforeSend:function(){$('#clarifyDetailsEmailForm :input').prop('disabled', true);},
			complete:function(){$('#clarifyDetailsEmailForm :input').prop('disabled', false);},
			success: function(data)
			{
				if(data.hasOwnProperty('error'))
				{
					$('#sendEmailModal .errordiv').html(data.error);
				}
				else if (data.hasOwnProperty('success'))
				{
					alert(data.success);
					$('#sendEmailModal').modal('hide');
				}

			}
		});
	});

	$(document).on('click', '#getProfToBeAuthenticated .submitauthprof', function(){
		$('#confirmauthenticateprofessional').remove();
		var thisemail = $(this).data('email');
		var thisid = $(this).data('id');
		var thisname = $(this).data('name');
		var thisdiv = $(this).parents('.item');
		$('<div id="confirmauthenticateprofessional" title="Authenticate '+thisname+'"><h5>Are you sure you want to authenticate this professional?</h5><p> This action is <span class="error">IRREVERSABLE</span> and you cannot undo it. Once the professional is authenticated, they will remain so until they themselves change their verification id.</p><p><b>Please make sure that you have checked and verified all the details related to the professional.</b></p><form class="form" autocomplete="off"><label><p>Please write "<b>confirm</b>" in the below, in order to confirm this action</p></label><input class="form-control" type="text" style="z-index:10000" name="confirmauthenticate" required/></form></div>').dialog(
		{
			width: 'auto',
			height: 'auto',
			modal: true,
			open: function()
			{
				$(this).parent().find('.ui-dialog-title').prepend("<i class='fa fa-exclamation-triangle' aria-hidden='true'> </i> ");
				$(this).keypress(function(e)
				{
					if (e.keyCode == $.ui.keyCode.ENTER)
					{
						e.preventDefault();
						$(this).parent().find("button:eq(1)").trigger("click");
					}
				});
			},
			buttons:
			{
				'Confirm': function()
				{
					var confirmauthenticate = $('#confirmauthenticateprofessional input[name="confirmauthenticate"]').val().toLowerCase();
					if (confirmauthenticate === 'confirm')
					{

						$.ajax(
						{
							type: 'POST',
							data:
							{
								'confirmauthenticate': confirmauthenticate,
								'id': thisid,
								'email': thisemail,
								'name' : thisname
							},
							dataType: 'json',
							url: baseUrl + "profile/confirmauthenticateprofessional",
							success: function(returndata)
							{
								if(returndata.hasOwnProperty('error')) alert(returndata.error);
								else if(returndata.hasOwnProperty('success')) thisdiv.append(returndata.success);
								else alert('Server error!');

							},
							error: function(){alert("Issue with request or server error! Please try again!");}
						});
					}
					else
					{
						alert('Wrong Value! Professional won\'t be authenticated.');
					}
					$(this).dialog('close');

				},
				'Cancel': function()
				{
					$(this).dialog('close');
				}
			}
		}).prev(".ui-widget-header").css(
		{
			"background": "darkred",
			'color': 'gold',
			'font-size': 'x-large'
		});
	});

	$(document).on('click', '#getProfToBeAuthenticated .submitunauthorizeprof', function(){
		$('#confirmunauthorizeprofessional').remove();
		var thisemail = $(this).data('email');
		var thisid = $(this).data('id');
		var thisname = $(this).data('name');
		var thisdiv = $(this).parents('.item');
		$('<div id="confirmunauthorizeprofessional" title="Reject '+thisname+'"><h5>Are you sure you want to unauthorize this professional?</h5><p> This action is <span class="error">IRREVERSABLE</span> and you cannot undo it. Once the professional is rejected, they will remain so until they themselves change their verification id.</p><p><b>Please make sure that you have checked and verified all the details related to the professional.</b></p><form class="form" autocomplete="off"><label>Reason for rejection</label><input class="form-control" type="text" style="z-index:10000" name="reason" required/><label><p>Please write "<b>reject</b>" in the below, in order to confirm this action</p></label><input class="form-control" type="text" style="z-index:10000" name="confirmunauthorize" required/></form></div>').dialog(
		{
			width: 'auto',
			height: 'auto',
			modal: true,
			open: function()
			{
				$(this).parent().find('.ui-dialog-title').prepend("<i class='fa fa-exclamation-triangle' aria-hidden='true'> </i> ");
				$(this).keypress(function(e)
				{
					if (e.keyCode == $.ui.keyCode.ENTER)
					{
						e.preventDefault();
						$(this).parent().find("button:eq(1)").trigger("click");
					}
				});
			},
			buttons:
			{
				'Confirm': function()
				{
					var confirmunauthorize = $('#confirmunauthorizeprofessional input[name="confirmunauthorize"]').val().toLowerCase();
					if (confirmunauthorize === 'reject')
					{

						$.ajax(
						{
							type: 'POST',
							data:
							{
								'confirmunauthorize': confirmunauthorize,
								'id': thisid,
								'email': thisemail,
								'name' : thisname,
								'reason':  $('#confirmunauthorizeprofessional input[name="reason"]').val()
							},
							dataType: 'json',
							url: baseUrl + "profile/confirmunauthorizeprofessional",
							success: function(returndata)
							{
								if(returndata.hasOwnProperty('error')) alert(returndata.error);
								else if(returndata.hasOwnProperty('success')) thisdiv.append(returndata.success);
								else alert('Server error!');

							},
							error: function(){alert("Issue with request or server error! Please try again!");}
						});
					}
					else
					{
						alert('Wrong Value! Professional won\'t be rejected.');
					}
					$(this).dialog('close');

				},
				'Cancel': function()
				{
					$(this).dialog('close');
				}
			}
		}).prev(".ui-widget-header").css(
		{
			"background": "darkred",
			'color': 'gold',
			'font-size': 'x-large'
		});
	});

	$("#recommendname").donetyping(function()
	{
		var recommendname = $(this).val();
		var rnarray = recommendname.split(',');
		var firstcomma = recommendname.indexOf(',');
		var secondcomma = recommendname.lastIndexOf(',');
		var cursorpos = $(this)[0].selectionStart;
		if (rnarray.length <= 3)
		{
			if (firstcomma < 0 || cursorpos <= firstcomma) var dataString = 'recommendname=' + rnarray[0];
			else if ((cursorpos > firstcomma && firstcomma == secondcomma) || (firstcomma < cursorpos && cursorpos <= secondcomma)) var dataString = 'recommendname=' + rnarray[1];
			else if (cursorpos > secondcomma) var dataString = 'recommendname=' + rnarray[2];

			if (dataString != '')
			{
				$.ajax(
				{
					type: "POST",
					url: baseUrl + "registerasprofessional/recommend",
					data: dataString,
					cache: false,
					success: function(html)
					{
						$("#recommendresult").html(html).show();
					}
				});
			}
			return false;
		}
	});

	jQuery("#recommendresult").on("click", function(e)
	{

		// $('#recommendids').val('');
		var recommendname = $('#recommendname').val();
		// var namesarray = recommendname.split(',');
		// var l =namesarray.length;
		var firstcomma = recommendname.indexOf(',');
		var secondcomma = recommendname.lastIndexOf(',');
		var cursorpos = $('#recommendname')[0].selectionStart;

		$('#recommendname').val('');

		if ($(e.target).attr('class') == 'show')
		{
			var $clicked = $(e.target);
		}
		else
		{
			var $clicked = $(e.target).parent();
		}

		var $name = $clicked.find('.name').text();
		// var decoded = $("<span/>").html($name).text();
		var $id = $clicked.find('.id').html();
		// var iddecoded = $("<p/>").html($id).text();

		if ($id)
		{

			// namesarray.push($name);
			// if(l < 2) $('#recommendname').val(namesarray.toString() + ',');
			// else $('#recommendname').val(namesarray.toString());
			// $('#recommendid' + l).val($id);
			if (firstcomma < 0)
			{
				$('#recommendname').val($name + ',');
				$('#recommendid0').val($id);

			}
			else if (cursorpos <= firstcomma)
			{
				var final = recommendname.slice(0, firstcomma);
				$('#recommendname').val(recommendname.replace(final, $name));
				$('#recommendid0').val($id);
			}
			else if (cursorpos > firstcomma && firstcomma == secondcomma)
			{
				var final = recommendname.slice(firstcomma);
				$('#recommendname').val(recommendname.replace(final, ',' + $name + ','));
				$('#recommendid1').val($id);
			}
			else if (firstcomma < cursorpos && cursorpos <= secondcomma)
			{
				var final = recommendname.slice(firstcomma, secondcomma);
				$('#recommendname').val(recommendname.replace(final, ',' + $name));
				$('#recommendid1').val($id);
			}
			else if (cursorpos > secondcomma)
			{
				var final = recommendname.slice(secondcomma);
				$('#recommendname').val(recommendname.replace(final, ',' + $name));
				$('#recommendid2').val($id);
			}

		}
		else
		{
			// if(l < 2) $('#recommendname').val(namesarray.toString() + ',');
			// else $('#recommendname').val(namesarray.toString());
			// $('#recommendid' + l).val('');
			// $('#recommendid' + l).val($id);
			if (firstcomma < 0)
			{
				$('#recommendname').val(' ');
				$('#recommendid0').val('');
			}
			else if (cursorpos <= firstcomma)
			{
				var final = recommendname.slice(0, firstcomma);
				$('#recommendname').val(recommendname.replace(final, ' '));
				$('#recommendid0').val('');

			}
			else if (cursorpos > firstcomma && firstcomma == secondcomma)
			{
				var final = recommendname.slice(firstcomma);
				$('#recommendname').val(recommendname.replace(final, ',' + ' '));
				$('#recommendid1').val('');
			}
			else if (firstcomma < cursorpos && cursorpos <= secondcomma)
			{
				var final = recommendname.slice(firstcomma, secondcomma);
				$('#recommendname').val(recommendname.replace(final, ',' + ' '));
				$('#recommendid1').val();
			}
			else if (cursorpos > secondcomma)
			{
				var final = recommendname.slice(secondcomma);
				$('#recommendname').val(recommendname.replace(final, ',' + ' '));
				$('#recommendid2').val('');
			}
		}

	});
	jQuery(document).on("click", function(e)
	{
		var $clicked = $(e.target);
		if (!$clicked.hasClass("recommendname"))
		{
			jQuery("#recommendresult").fadeOut();
		}

	});

	// authenticate professionals
	var authenticateprof = $('#getProfToBeAuthenticated');
	var authenticateprofPage = 1;
	var authenticateprofPerPageCounter = 1;
	var authenticateprofPerPage = 10;
	if (authenticateprof.length > 0) getAuthenticateProf();

	$('#moreauthenticateprof').on('click', function(e)
	{
		++authenticateprofPerPageCounter;
		if (authenticateprofPage != 0 && authenticateprofPerPageCounter == authenticateprofPerPage)
		{
			authenticateprofPerPageCounter = 1;
			++authenticateprofPage;
			getAuthenticateProf();
		}
	});

	function getAuthenticateProf()
	{

		$.ajax(
		{
			url: baseUrl + "profile/getauthenticateprof",
			type: "POST",
			data:{page: authenticateprofPage, perPage: authenticateprofPerPage},
			complete: function(){
				$('#getProfToBeAuthenticated .loadericon').hide();

			},
			success: function(result)
			{
				if (result == false)
				{
					authenticateprofPage = 0;
					$('#getProfToBeAuthenticated .carousel-inner').append("<p class='item paddingtop25per paddingleft20per greytext'>No more Professionals to be authenticated</p>");
				}
				else
				{
					$('#getProfToBeAuthenticated .carousel-inner').append(result);
					$('#getProfToBeAuthenticated .carousel-control').show();
					$('.lazyload').lazyload(
					{
						load: load
					});
				}
			}
		});

	}

	$('.addfocus_type').on('change', function()
	{

		var valueselected = this.value;
		var selectid = $(this).attr('data-selectid');

		$.ajax(
		{
			data:
			{
				type: valueselected,
				selectid: selectid
			},
			type: 'POST',
			dataType: 'json',
			url: baseUrl + 'profile/addfocus',
			beforeSend: function()
			{
				$('.addmainfocusbytype [data-selectid=' + selectid + ']').html('');
			},
			success: function(data)
			{
				$('#addfocus .addmainfocusbytype[data-selectid="' + selectid + '"]').html(data.mainfocus);
				$('#addfocus .focuslist[data-selectid="' + selectid + '"]').html(data.allfocus);

			}
		});
	});

	$('#addfocus form').submit(function(e)
	{
		e.preventDefault();

		$.ajax(
		{
			data: $('#addfocus form').serialize(),
			type: 'POST',
			dataType: 'json',
			url: baseUrl + 'profile/addfocusform',
			success: function(data)
			{
				console.log(data);
				if (data == 1)
				{
					$('#addfocus').append('<p class="alert alert-success col-sm-12">Success! Focus area added.</p>');
				}
				else
				{
					$('#addfocus').append('<p class="alert alert-danger col-sm-12">Error! Please try again! Please make sure the value is not a duplicate.</p>')
				}

			},
			error: function()
			{
				$('#addfocus').append('<p class="alert alert-danger col-sm-12">Error! Please try again! Please make sure the value is not a duplicate.</p>')

			}
		});

	});

	// change changeVerificationId

	$('#changeVerificationId').on('click',function(){
		var dialog = $('<div class="fail padding2per "><h6>Your verification status will be reset. Are you sure you want to continue this action?</h6> If you have still not be approved please give us some time to verify details.</div>').dialog(
		{
			buttons:
			{
				"Yes, I am aware.": function()
				{
					dialog.dialog('close');
					$('#changeVerificationIdModal').modal('show');
				},
				"No, Thanks.": function()
				{
					dialog.dialog('close');
				}
			}
		});

	});

	$('#changeVerificationIdForm').validate({
		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent().parent());
		},
		rules:
		{
			verificationid:
			{
				required: true,
				regex: function(element)
				{
					var custrole = $('#changeVerificationIdForm input[name="verificationid"]').data('usertype');
					if (custrole == 2 || custrole == 3) return "^[a-zA-Z]{2}\\/\\d{1,}\\/\\d{1,}$";
					else if (custrole == 5) return "^\\d{6}$";

				}
			},
		},
		messages:
		{
			verificationid:
			{
				required: 'Registration/ID number is needed in order to verify authenticity.',
				regex: 'Please make sure that the registeration number is in correct format.'
			}
		},
		submitHandler: function(form)
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "profile/changeVerificationId",
				data: $(form).serialize(),
				dataType: 'json',
				timeout: 10000,
				beforeSend: function(){$("#changeVerificationIdForm :input").prop('disabled', true);},
				complete: function(){$("#changeVerificationIdForm :input").prop('disabled', false);},
				success: function(result)
				{

					if(result.status == 1)
					{
						$('#changeVerificationIdModal').modal('hide');
					}
					alert(result.msg);

				},
				error: function()
				{
					alert("Error! Something went wrong! Please try again");
				}
			});
		}
	});

	$.validator.setDefaults(
	{
		ignore: ''
	});

	$('#articledelete').on('click', function(e)
	{
		e.preventDefault();
		$('#articlecontainer').hide();
		$('#articledeleteform').show();
	});

	$('#articleedit').on('click', function(e)
	{
		e.preventDefault();
		$('#articlecontainer').hide();
		$('#articleeditform').show();
	});

	$('#canceleditarticle').on('click', function(e)
	{
		e.preventDefault();
		$('#articleeditform').hide();

		$('#articlecontainer').show();
	});

	$("#articledeleteform").submit(function(e)
	{
		e.preventDefault();
		$.ajax(
		{
			type: "POST",
			url: baseUrl + "articles/deletearticleform",
			data: $("#articledeleteform").serialize(),
			timeout: 10000,
			success: setTimeout(function(result)
			{
				if (result) document.getElementById('deletearticlecomplete').innerHTML += '<div class="alert alert-success fade-in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Your article has been deleted.</div>';
				else document.getElementById('deletearticlecomplete').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again, if the problem persists please contact us.</div>'

			}, 6000),

		});
	});

	$("#articleeditform").submit(function(e)
	{
		e.preventDefault();

	}).validate(
	{

		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent()).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			title:
			{
				required: true,
				minlength: 5,
				remote:
				{
					url: baseUrl + "articles/editarticletitlevalidate",
					data:
					{
						oldtitle: $('#articleeditform').attr('data-title')
					},
					type: "post"
				}
			},
			story:
			{
				required: true,
				minlength: 100
			},
			'cropit-image-input':
			{
				extension: "gif|jpeg|png|jpg"
			},
		},
		submitHandler: function(form)
		{

			var imageData = $('#editarticleimg .image-editor').cropit('export');
			$('#editarticleimg .hidden-image-data').val(imageData);

			$.ajax(
			{
				type: "POST",
				url: baseUrl + "articles/editarticleform",
				data: $(form).serialize(),
				timeout: 10000,
				success: function(result)
				{
					if (result) document.getElementById('editarticlecomplete').innerHTML += '<div class="alert alert-success fade-in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Your article has been submitted.</div>';
				},
				error: function()
				{
					document.getElementById('editarticlecomplete').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again, if the problem persists please contact us.</div>';
				}
			});

		}

	});

	$("#addarticleform").on('submit', function(e)
	{
		e.preventDefault();

	}).validate(
	{

		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div").parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			title:
			{
				required: true,
				minlength: 5,
				// maxlength: 55,
				// alphanumeric: true,
				remote:
				{
					url: baseUrl + "profile/addarticletitlevalidate",
					type: "post"
				}
			},
			story:
			{
				required: true,
				minlength: 100
			},
			'cropit-image-input':
			{
				required: true,
				extension: "gif|jpeg|png|jpg"
			},
			'tags[]':
			{
				required: true,
				maxMultipleSelect: 10

			},
			author:
			{
				required: true,
				maxlength: 100,
				// remote:{
				//     url: baseUrl + 'profile/usernamevalidate',
				//     type: "post"
				// }
			},
			authorid:
			{
				// required: true
			}

		},
		submitHandler: function(form)
		{

			var imageData = $('#addarticleimage .image-editor').cropit('export');
			$('#addarticleimage .hidden-image-data').val(imageData);

			$.ajax(
			{
				type: "POST",
				url: baseUrl + "profile/addarticleform",
				data: $(form).serialize(),
				timeout: 20000,
				success: function(result)
				{
					if (result) document.getElementById('addarticlecomplete').innerHTML += '<div class="alert alert-success fade-in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Your article has been submitted.</div>';
					else document.getElementById('addarticlecomplete').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again, if the problem persists please contact us. Please check if you have already submitted the article.</div>'

				},
				error: function()
				{
					document.getElementById('addarticlecomplete').innerHTML += '<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again, if the problem persists please contact us. Please check if you have already submitted the article.</div>'
				}

			});

		}

	});

	// $('#addarticleform').valid();

	$.fn.extend(
	{
		donetyping: function(callback, timeout)
		{
			timeout = timeout || 1e3; // 1 second default timeout
			var timeoutReference,
				doneTyping = function(el)
				{
					if (!timeoutReference) return;
					timeoutReference = null;
					callback.call(el);
				};
			return this.each(function(i, el)
			{
				var $el = $(el);
				$el.is($('input')) && $el.on('keyup keypress paste', function(e)
				{
					// This catches the backspace button in chrome, but also prevents
					// the event from triggering too preemptively. Without this line,
					// using tab/shift+tab will make the focused element fire the callback.
					if (e.type == 'keyup' && e.keyCode != 8) return;

					// Check if timeout has been set. If it has, "reset" the clock and
					// start over again.
					if (timeoutReference) clearTimeout(timeoutReference);
					timeoutReference = setTimeout(function()
					{
						// if we made it here, our timeout has elapsed. Fire the
						// callback
						doneTyping(el);
					}, timeout);
				}).on('blur', function()
				{
					// If we can, fire the event since we're leaving the field
					doneTyping(el);
				});
			});
		}
	});

	$("#sendemail form").on('submit', function(e)
	{
		e.preventDefault();

	}).validate(
	{

		errorPlacement: function errorPlacement(error, element)
		{
			error.appendTo(element.parent("div")).css(
			{
				"color": "darkred"
			});
		},
		rules:
		{
			content:
			{
				required: true,
				minlength: 100
			}
		},
		submitHandler: function(form)
		{

			$.ajax(
			{
				type: "POST",
				url: baseUrl + "profile/sendemail",
				data: $(form).serialize(),
				timeout: 10000,
				success: setTimeout(function(result)
				{
					if (result == 1) $('#sendemailresult').html('<div class="alert alert-success fade-in"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Sending Emails!</strong> You can now send another email or carry on exploring other features of the web.</div>');

				}, 6000),
				// error: function()
				// {
				//    $('#sendemailresult').html('<div class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again, if the problem persists please contact us.</div>');
				// }

			});

		}

	});

	$(".usernamesearch").donetyping(function()
	{
		var username = $(this).val();
		var dataString = 'username=' + username;
		if (dataString != '')
		{
			$.ajax(
			{
				type: "POST",
				url: baseUrl + "profile/usernamesearch",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$("#usernameresult").html(html).show();
				}
			});
		}
		return false;
	});

	jQuery("#usernameresult").on("click", function(e)
	{

		$('#author').val('');
		$('#authorid').val('');

		if ($(e.target).attr('class') == 'show')
		{
			var $clicked = $(e.target);
		}
		else
		{
			var $clicked = $(e.target).parent();
		}

		var $name = $clicked.find('.name').text();
		var decoded = $("<span/>").html($name).text();
		var $id = $clicked.find('.id').html();
		var iddecoded = $("<p/>").html($id).text();
		if (iddecoded)
		{
			$('#author').val(decoded);
			$('#authorid').val(iddecoded);
		}
		else
		{
			$('#author').val('');
			$('#authorid').val('');
		}

	});
	jQuery(document).on("click", function(e)
	{
		var $clicked = $(e.target);
		if (!$clicked.hasClass("usernamesearch"))
		{
			jQuery("#usernameresult").fadeOut();
		}
	});
	$('#author').click(function()
	{
		jQuery("#usernameresult").fadeIn();
	});

	if ($('#articleeditform').length > 0) $('#articleeditform').valid();

});
