<?php

/** Configuration Variables **/

define ('DEVELOPMENT_ENVIRONMENT',true); //CHANGEDNOV19: FALSE TO TRUE

define('DB_NAME', 'kniewcom_dbpgsql');
define('DB_USER', 'kniewcom');
define('DB_PASSWORD', 'zXPS{%GLK%i.c76e');
define('DB_HOST', 'localhost');
define('DB_SCHEMA', 'website');
//// CHANGEDNOV19 : BASE PATH FROM WEBNAME TO LOCAL HOST
// define('BASE_PATH','https://www.kniew.com/');
// define('WEBNAME', "Kniew");
define('BASE_PATH','http://kniew/');
define('WEBNAME', "Kniew");

define('INFO_EMAIL', 'info@kniew.com');
define('CONTACT_EMAIL', 'contact@kniew.com');
define('UPDATES_EMAIL', 'updates@kniew.com');
define('AUTHENTICATE_EMAIL', 'authenticateprofessionals@kniew.com');

define('TWITTER_PROFILE', 'https://twitter.com/Kniew1');
define('FACEBOOK_PAGE', 'https://www.facebook.com/contact.kniew');
define('LINKEDIN_PROFILE', 'www.linkedin.com/in/kniew');
define('GOOGLE_PLUS_PROFILE', 'https://plus.google.com/u/0/110859172759916580754');
define('INSTAGRAM_PROFILE', 'https://www.instagram.com/contact.kniew/');
define('LOGO', BASE_PATH . 'images/icons/logo.svg');

define('fetchAll','fetchAll');
define('fetch','fetch');



define('PAGINATE_LIMIT', '5');
define('FACEBOOK_APP_ID', '2068863420019543');
define('FACEBOOK_APP_SECRET', 'ed26af1456270642ffbeb40f60712602');

#CHANGEDNOV19
define('RAZORPAY_API_ID', 'rzp_test_gVACVZbZaHcD8D');
define('RAZORPAY_API_SECRET', 'J2Ag0wNv8K78IDLsra831oo8');


define('MAILCHIMP_API_ID', 'f978aaf306ef480a319292500579c74d-us18');
define('MAILCHIMP_LIST_ID', '88e061c494');

define('client_id', '570827482982-stc0mn0tk2ed16lmqbb11sag5badvnlc.apps.googleusercontent.com');
define('client_secret', '-7ZX2eXh0VMge9ie8d7-hgam');


//old krutigoyal
// define('client_id', '207218996928-tg766c3kf4qqgl9n9j0v6oeqr42q3min.apps.googleusercontent.com');
// define('client_secret', 'aLk6ppMaSmx_Z_IhH5NwcQU5');
define('redirect_uri', BASE_PATH);
