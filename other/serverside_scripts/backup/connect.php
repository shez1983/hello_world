<?php
session_start();
$allowed_methods = array (
	'login',
	'logged_in',
	'get_lesson',
    'submit_answer'
);

//ini_set('display_errors', 'On'); error_reporting(E_ALL | E_STRICT); 


//check if there is a post request
if ( !isset( $_POST ) ){

	echo "no post";
	exit();	

}

//check if valid method was given
if ( !isset( $_POST['method'] )  || 
	 !in_array($_POST['method'],$allowed_methods ) ) {
	
	echo "no method";
	exit();	
	
}


$method = strtolower($_POST['method']);

include_once('dbconn.php');
include_once('functions.php');

switch ( $method ) {
	
	case 'login':  
	
		include_once('do_login.php'); 
		break;
				   
	case 'logged_in':  
				
		include_once('check_login.php'); 
		break;  
		
	case 'get_lesson':  
				
		include_once('get_lesson.php'); 
		break;
    
    case 'submit_answer':  
				
		include_once('submit_answer.php'); 
		break;	
	
};

?>