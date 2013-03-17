<?php

	//activity_id, total_questions, question_no				returns ONE question & possible answers

	include_once('dbconn.php');
	include_once('functions.php');

	$user_id = $_SESSION['user_id'];
	$where = "";
	
	if ( isset ( $_POST['activity_id'] ) ) {
		
		$activity_id = secure( $_POST['activity_id'], "integer" );
		$where = "a.activity_id = '$activity_id'";
		
	} else {
		//error
	}
	
	$total_questions 	= secure ( $_POST['total_questions'],"integer") ;
	$question_no 		= isset ( $_POST['question_no'] ) ? secure( $_POST['question_no'], "integer") : 1 ;
	$start_row 			= $question_no * 4; //query below will return four rows

	//TODO control it so if start_row + 4 > total_questions.. error BUT at the moment app will control this... maybe..
	
	$stmt = $db->prepare("
			Select q.question_id, question, answer_id, answer, solution_id
        FROM questions q
        INNER JOIN answers a
        ON a.question_id = q.question_id
        INNER JOIN activity_questions aq
        ON aq.question_id = q.question_id
        WHERE activity_id = :activity_id
        ORDER BY q.question_id
        LIMIT $start_row, 4
	");

	$stmt->execute( array(  ':activity_id' => $activity_id,   )  );
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if( count($rows) == 0 ) {
		
		$return['error'] = "No questions";
		
	} else {
		
		$questions = array();
		foreach ($rows as $row){
			$questions[$row['question_id']]['question'] = $row['question'];
			$questions[$row['question_id']]['solution_id'] = $row['solution_id'];
			$questions[$row['question_id']]['answer'][$row['answer_id']] = $row['answer'];
		}
		$return = $questions;
	}
	
	echo json_encode ( $return );
	
?>