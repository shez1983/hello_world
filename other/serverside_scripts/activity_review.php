<?php
	// assessment_id, schedule_activities_id, schedule_id & activity_id
   
   //TODO: remember that each sch_act can have multiple assessment! as they can retake!
   if ( isset($_POST['assessment_id']) ){
      $assessment_id = secure($_POST['assessment_id'],"integer");
      
      $stmt = $db->prepare("
         SELECT count(*) as questions_attempted, sum(correct) as correct FROM assessment_questions
         WHERE assessment_id = :assessment_id
      ");
      $stmt->execute( array(  ':assessment_id' => $assessment_id, )  );
    
   } elseif ( isset($_POST['schedule_activities_id']) ) {
      $schedule_activities_id = secure($_POST['schedule_activities_id'],"integer");
      
      $stmt = $db->prepare("
         SELECT count(*) as questions_attempted, sum(correct) as correct FROM assessment_questions aq
         INNER JOIN assessment s
         ON s.assessment_id = aq.ssessment_id
         WHERE a.schedule_activity_id = :schedule_activity_id         
      ");
      $stmt->execute( array(  ':schedule_activity_id' => $schedule_activities_id, )  );
      
   } elseif ( isset($_POST['schedule_id']) && isset($_POST['activity_id'])) {
      $schedule_id = secure($_POST['schedule_id'],"integer");
      $activity_id = secure($_POST['activity_id'],"integer");
      
      $stmt = $db->prepare("
         SELECT count(*) as questions_attempted, sum(correct) as correct
         FROM assessment_questions aq
         INNER JOIN assessment s
         ON s.assessment_id = aq.ssessment_id
         INNER JOIN schedule_activities sa
         ON sa.id = a.schedule_activity_id
         WHERE sa.schedule_id = :schedule_id
         AND sa.activity_id = :activity_id
      ");
      $stmt->execute( array(  ':schedule_id' => $schedule_id, ':activity_id' => $activity_id )  );
   } else {
      $return['error'] = "Something went wrong!";
      log_error();
   }
   
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   $return['total_questions']       = "";
   $return['questions_attempted']   = $row['questions_attempted'];
   $return['correct_answers']       = $row['correct'];
   $return['score']                 = $row['correct']/$total_questions*100;
   
   return json_encode($return);

?>