<?php

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
		
	} else {
		//error
	}
	
	$date = isset( $_POST['date'] ) ? $_POST['date'] : "CURDATE()" ;

	$stmt = $db->prepare("
			SELECT sa.id schedule_activities_id, a.activity_id, a.category, a.subject, at.type, IFNULL( sa.time_limit, a.time_limit ) time_limit, IFNULL( sa.level, a.level ) level, sa.status, sa.time_started
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
		
		echo "No lesson Today or Teacher hasn't added any activity!";
		
        /*
         *{
"2":{"activity_id":"2","status":"finished","subject":"Algebra","type":"Starter","time_limit":"00:10:00","level":"22",
"schedule_activities_id":"2"
,"time_started":null},

*/
        
	} else {
		$return .= '<ul data-role="listview" data-count-theme="c" data-inset="true">';
		foreach ( $rows as $activity ) {
			
			if ( $activity['status'] == "closed" ) {
				$status = 'Cant View';	
			} elseif ( $activity['status'] == "open" ) {
				$status = '<a href="http://education.shehzadazram.co.uk/jquery/phone_app/pages/activity_start.php?scheduled_activity_id='.$activity['status'].
                    '&activity_id='.$activity['activity_id'].'">Start</a>';	
			} else {
				$status = '<a href="http://education.shehzadazram.co.uk/jquery/phone_app/test.php?id=test">View Score</a>';
			}
			
			$return.= '<li>'.
                        $activity['type'].'
						<span class="ui-li-count">'.$status.'</span>
					</li>';
		}
		$return .= '</ul>';
		echo $return;
	}
	
	
?>