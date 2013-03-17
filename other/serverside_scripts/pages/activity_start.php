<?php
    ini_set('display_errors', 'On'); error_reporting(E_ALL | E_STRICT); 
    session_start();
	include_once('../dbconn.php');
	include_once('../functions.php');
    
    //$user_id = $_SESSION['user_id'];
    //$schedule_activity_id = $_GET['scheduled_activity_id'];
    //$activity_id = $_GET['activity_id'];
    
    //FOR TESTING
    
        
    $user_id = 2;
    $schedule_activity_id = 1;
    $activity_id = 1;
    
    //INSERT data into assessment table
    
    $stmt = $db->prepare("
        INSERT INTO assessment
            (student_id, date_attempted, schedule_activity_id )
        VALUES (:student_id, :date_attempted, :schedule_activity_id)
    ");
    
    $affected_rows = $stmt->execute(
        array(':student_id' => $user_id,
              ':date_attempted' => '2013-03-09 16:01:55',  //TODO change these back to dynamic
              ':schedule_activity_id' => $schedule_activity_id
        )
    );
    if ( $affected_rows == 1 ) {
        //proceed
        
        //store assessment_id
        $assessment_id = $db->lastInsertId();
        
        //find out activity details
        $stmt = $db->prepare("
			SELECT a.category, a.subject, at.type, IFNULL( sa.time_limit, a.time_limit ) time_limit, IFNULL( sa.level, a.level ) level,
                (
                    SELECT count(*)
                    FROM activity_questions
                    WHERE activity_id =1
                ) AS question_count
			FROM activities a
			INNER JOIN schedule_activities sa ON a.activity_id = sa.activity_id
            INNER JOIN activity_types at ON at.id = IFNULL( sa.type_id, a.type_id )
			WHERE sa.activity_id = :activity_id
			AND sa.id = :schedule_activity_id
			LIMIT 1
        ");
        
        $stmt->execute(
            array(  ':activity_id' => $activity_id,
                    ':schedule_activity_id' => $schedule_activity_id
            )
        );
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_rows = $row['question_count'] * 4; //TODO could be multiple choice or not...
        
    } else {
        //some error?
    }
 
 //find out how many questions & time limit/level for this activity
 
 //present a start button
 
 //start the time limit

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="../jquery-mobile/jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css">
<link href="../jquery-mobile/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css">
<script src="../jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="../jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>

<script>
///
</script>


</head>

<body>

<div data-role="page" id="app_login" data-theme="e">
	
    <div data-role="header"  data-theme="e">
    	<h1>Activity</h1>
  	</div>
  	
    <div data-role="content" data-theme="e">    
       <table data-role="table" data-theme="e">
            <tbody>
                <tr>
                    <th data-priority="2">Category:</th>
                    <td><?= $row['category'] ?></td>
                </tr>
                
                <tr>
                    <th data-priority="1">Subject:</th>
                    <td><?= $row['subject'] ?></td>
                </tr>
     
                <tr>
                    <th data-priority="3">Type:</th>
                    <td><?= $row['type'] ?></td>
                </tr>
                
                <tr>
                    <th data-priority="4">Time Limit:</th>
                    <td><?= $row['time_limit'] ?></td>
                </tr>
                
                <tr>
                    <th data-priority="5">Level:</th>
                    <td><?= $row['level'] ?></td>
                </tr>
                
                <tr>
                    <th data-priority="6">Total Questions:</th>
                    <td><?= $row['question_count'] ?></td>
                </tr>
            </tbody>
       </table>
       <a href="activity_questions.php?activity_id=<?= $activity_id; ?>&assessment_id=<?= $assessment_id;?>&total_rows=<?= $total_rows; ?>&start_row=0" data-role="button" data-inline="true" data-theme="e" data-mini="true">Start</a>
   	</div>
    
  	<div data-role="footer" data-theme="e">
    	<h4>App Name &copy; 2013</h4>
  	</div>
</div>

</body>
</html>
