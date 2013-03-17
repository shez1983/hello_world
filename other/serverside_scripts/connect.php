<?php

/* APP PAGES:
 *
 * index.html       - login -- done
 *                  - check_login -- done
 *                  - menu -- done
 *                  - todays-lesson -- done
 *                  - activity_review --
 *                  - questions & answers
 *                  - post_review
*/


session_start();
$allowed_methods = array (
	'login',
	'check_logged_in',
	'get_lesson_activities',
	'get_activity_questions',
	'submit_answer',
	'get_activity_review',

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
$method = $_POST['method'];
include_once('dbconn.php');
include_once('functions.php');

/*
 *	LOGIN
 *
 *	TODAYS LESSON
 *		get lesson activities ( including score i.e. 93% )
 *    get activity overview
 *    	e.g. 5 q, starter, time limit, level etc
 *		get activity Q&A
 *			be able to go back and forth the question
 *		activity review
 *			see a list of questions (q1, q2.. and be able to go to that question)
 *		get activity score (lesson activities)
 *
 *	be able to tag a friend so they get the same results (ie if done in group)
 *		should be limit of 2 or 3?
 *		
 *	 
 *	REPORTS
 *		report per subject
 *		report per month? forget this for now
 *
 *	SCHEDULE
 * 	get_time_table
 * 		link to past lessons (use get lesson activity)
 * 			show score of each activity
 * 			be able to re-do the test (may be!)
 * 			 m mmmmnhbbb n 
 * 		
 *	LOG OUT
 */

switch ( $method ) {
	
	//username & password  											returns error/message (json)
	case 'login':  						include_once('do_login.php'); 						break; //done
		
	//no params,														returns true/false	
	case 'check_logged_in':  		    include_once('check_login.php'); 					break; //done
		
	//date or schedule_id or activity_id or schedule_activity_id          returns a list of activities or ONE activity if activity_id is given!,
	//also student's score (if status is opened etc) not done that yet
	case 'get_lesson_activities':  	include_once('get_activities.php'); 				break; //done
	
	//activity_id, total_questions, question_no				returns ONE question & possible answers
	case 'get_activity_questions':	include_once('get_activity_questions.php'); 		break; //done
	
	//schedule_activity_id,
	
	// assessment_id, question_id, answer_id, correct			returns true/false
   case 'submit_answer':  				include_once('submit_answer.php'); 					break; //done
	
    // N/A   																returns N/A
   case 'logout':  						include_once('logout.php'); 							break; //done
		
	// assessment_id, schedule_activities_id, schedule_id & activity_id     returns: total_questions, questions_attempted, correct_answers, score
	case 'get_activity_review':		include_once('get_activity_review.php'); 			break; //
		
	// subject, (or none for all modules)..
	case 'get_report_per_module': 	include_once('get_report_per_module.php');		break;
		
	//N/A	returns timetable with clickable links
	case 'get_schedule':				"";		break;
        
    default:                            $return['error'] = "something went wrong" ; echo json_encode($return); break;    

	
};

?>