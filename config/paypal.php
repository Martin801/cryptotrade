<?php
return [
/** set your paypal credential **/
'client_id' =>'AQq9Pt-Tp1qP6IR4M863MPIOibCdSjuDYB50r1K48ZSSm_fOyO8ftiig_5t2pv7WPeiYpoZaa7Pq1l82',
'secret' => 'EBDRRUW0VsDxuvKNXYeQBr6KQXlpjaFBOiPgMqw-9SXVXhs7kfzBSlVn7wSw0ZKFaW_puJh0mOe4KFSp',
/**
* SDK configuration
*/
'settings' => array(
/**
* Available option 'sandbox' or 'live'
*/
'mode' => 'sandbox',
/**
* Specify the max request time in seconds
*/
'http.ConnectionTimeOut' => 1000,
/**
* Whether want to log to a file
*/
'log.LogEnabled' => true,
/**
* Specify the file that want to write on
*/
'log.FileName' => storage_path() . '/logs/paypal.log',
/**
* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
*
* Logging is most verbose in the 'FINE' level and decreases as you
* proceed towards ERROR
*/
'log.LogLevel' => 'FINE'
),
];
