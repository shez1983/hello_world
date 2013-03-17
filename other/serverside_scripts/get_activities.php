<?php

//activity_id, total_questions, question_no				returns ONE question & possible answers
	//case 'get_activity_questions':	include_once('get_activity_questions.php'); 		break;

	include_once('dbconn.php');
	include_once('functions.php');

	$user_id = $_SESSION['user_id'];
	$where = "";
	
	if ( isset($_POST['date']) ){
		
		$date = secure( $_POST['date'], "date" );
		$where = "s.class_date = '$date'";
		
	} else if ( isset ($_POST['schedule_id'])) {
		
		$schedule_id = secure( $_POST['schedule_id'], "integer" );
		$where = "s.schedule_id = '$schedule_id'";
		
	} else if ( isset ( $_POST['activity_id'] ) ) {
		
		$activity_id = secure( $_POST['activity_id'], "integer" );
		$where = "a.activity_id = '$activity_id'";
		
	} else if ( isset ( $_POST['schedule_activity_id'] ) ) {
        
        $schedule_activity_id = secure( $_POST['schedule_activity_id'], "integer" );
		$where = "sa.id = '$schedule_activity_id'";
		
	} else {
        //error
    }
	
	$date = isset( $_POST['date'] ) ? $_POST['date'] : "CURDATE()" ;

	$stmt = $db->prepare("
			SELECT sa.id schedule_activities_id, a.activity_id, a.category, a.subject, at.type, IFNULL( sa.time_limit, a.time_limit ) time_limit,
					 IFNULL( sa.level, a.level ) level, sa.status, sa.time_started
			FROM activities a
			INNER JOIN schedule_activities sa ON a.activity_id = sa.activity_id
			INNER JOIN activity_types at ON at.id = IFNULL( sa.type_id, a.type_id )
			INNER JOIN schedule s ON s.schedule_id = sa.schedule_id
			INNER JOIN class_timings ct ON ct.id = s.time_id
			INNER JOIN user_classes uc ON uc.class_id = ct.class_id
			WHERE uc.user_id = '2'
			AND $where
			ORDER BY at.id ASC
			LIMIT 0 , 30
	");
		/*array(
			':user_id' => '2', 
			':date' => '2013-02-04'
		)*/
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if( count($rows) == 0 ) {
		
		$return['error'] = "No lesson Today or Teacher hasn't added any activity!";
		
	} else {
		$activity_array = array();
		
		foreach ( $rows as $activity ) {
            $activity_array[$activity['activity_id']]['activity_id'] 			      = $activity['activity_id'];
            $activity_array[$activity['activity_id']]['category'] 			      = $activity['category'];
			$activity_array[$activity['activity_id']]['status'] 					  = $activity['status'];
			$activity_array[$activity['activity_id']]['subject'] 					  = $activity['subject'];
			$activity_array[$activity['activity_id']]['type'] 						  = $activity['type'];
			$activity_array[$activity['activity_id']]['time_limit'] 				  = $activity['time_limit'];
			$activity_array[$activity['activity_id']]['level'] 					  = $activity['level'];
			$activity_array[$activity['activity_id']]['schedule_activities_id'] = $activity['schedule_activities_id'];
			$activity_array[$activity['activity_id']]['time_started'] 			  = $activity['time_started'];
		}
		$return = $activity_array;
	}
	
	echo json_encode ( $return );
	
?>