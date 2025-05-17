<!-- CHANGEDNOV19: REMOVED DUPLICATE -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> -->

<?php
	// CHANGEDNOV19 change general to combined.min
	print_r($html->includeCSS('general'));
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
<script type="text/javascript">
    window.jQuery || document.write('<script type="text/javascript" src="/js/jquery-3.1.1.min.js" ><\/script>');
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script>
	//jquery migrate fail
	if (typeof jQuery.migrateVersion == 'undefined')
	{
		var sNew = document.createElement("script");
		sNew.type ='text/javascript';
		sNew.src = "/js/jquery-migrate-3.0.0.min.js";
		sNew.async = true;
		document.body.appendChild(sNew);
	}
</script>
<!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
(function($){
					//bootstrap css fail
		var $boot  = $('<div id="bootstrapCssTest" class="hidden"></div>').appendTo('body');
		if ($boot.is(':visible')) {
	        $("head").prepend('<link rel="stylesheet" href="/css/bootstrap-3.3.7.min.css">');
	      }
	     //fontawesome css fail
        var $span = $('<span class="fa" style="display:none"></span>').appendTo('body');
        if ($span.css('fontFamily') !== 'FontAwesome' ) {
            // Fallback Link
            $('head').prepend('<link href="/css/font-awesome-4.7.0.min.css" rel="stylesheet">');
        }
        $span.remove();
})(jQuery);
//bootstrap js fail
	if(typeof($.fn.modal) === 'undefined')
	{
		document.write('<script src="/js/bootstrap-3.3.7.min.js" ><\/script>')
		// var sNew = document.createElement("script");
		// sNew.type ='text/javascript';
		// sNew.src = "/js/bootstrap-3.3.7.min.js";
		// sNew.async = true;

		// document.body.appendChild(sNew);
	}
</script>
<script type="text/javascript" src="https://apis.google.com/js/api.js" async defer></script> <!-- no fallback -->

<!-- CHANGEDNOV19: Added messages page for tinyMCE fetch, also tinyMCE changes -->
<?php
	if(isAdmin() === true || $urlArray[0] == 'registerasprofessional' || $urlArray[0] == 'referafriend' || ($urlArray[0] == 'profile' && isProfessional() == true) || $urlArray[0] == 'messages' || ($urlArray[0] == 'professionals' && $urlArray[1] == 'ngo')) {
		echo '<script type="text/javascript" src="https://cdn.tinymce.com/4/tinymce.min.js"></script>';
		echo '<script type="text/javascript">
				  window.tinymce || document.write(\'<script type="text/javascript" src="/js/tinymce.min.js"><\/script>\');
				</script>';
		print_r($html->includeJs('preventdelete.min'));
		echo '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>';

		}
// CHANGEDNOV19 instead of combine below js, unchange again
	// print_r($html->includeJs('combined.min', " defer"));
	?>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery.lazyload-any.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery.steps.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery.cropit.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery-comments.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jRating.jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/fullcalendar.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/jquery.ba-throttle-debounce.js"></script>
	<script type="text/javascript" src="<?php echo BASE_PATH;?>js/general.js"></script>

	<?php

	if($urlArray[0] == 'registerasprofessional' || $urlArray[0] == 'referafriend' || ($urlArray[0] == 'profile' && isProfessional() == true))
	{
		echo '<script type="text/javascript"  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK-L2785ywTxeMaZgJzdrLKXznnGtvhjM&libraries=places&callback=initialgooglemap" async defer></script>'; //no fallback
	}
?>


<!-- MODENIZER might be needed, in order to make code compatible with all the browsers.
	GOOGLE JSAPI might be needed, if need to add more than one js from google on multiple pages.
	FULLCALENDAR GCAL feature can be used later, if you want user to have access to there google calendar as well.  -->

</body>

</html>
