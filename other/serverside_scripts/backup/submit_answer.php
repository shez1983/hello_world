<?php
    
    print_r ($_POST);
    $answer_id      = secure($_POST['answer_id']);
    $question_id    = secure($_POST['question_id']);
    $solution_id    = secure($_POST['solution_id']);
    $assessment_id  = secure($_POST['assessment_id']);
    $correct        = secure($_POST['correct']);
    
		
		$stmt = $db->prepare("
            INSERT INTO assessment_questions
                (assessment_id, question_id, answer_id, correct )
            VALUES (:assessment_id, :question_id, :answer_id, :correct)
            ON DUPLICATE KEY UPDATE answer_id = :answer_id, correct = :correct
		");
		
		$affected_rows = $stmt->execute(
			array(
				':assessment_id' => $assessment_id, 
				':question_id'   => $question_id,
				':answer_id'     => $answer_id, 
				':correct'       => $correct,                
			)
		);
		
        if ( $affected_rows == 0 ) {
            echo "ERROR";
        }
?>