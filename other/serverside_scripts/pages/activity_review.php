<?php
ini_set('display_errors', 'On'); error_reporting(E_ALL | E_STRICT); 
    session_start();
	include_once('../dbconn.php');
	include_once('../functions.php');
    
    $total_questions    = $_GET['total_rows']/4;
    $assessment_id      = $_GET['assessment_id'];
    $activity_id        = $_GET['activity_id'];
    
    //UPDATE ASSESSMENT TABLE WITH RESULT
    
    $stmt = $db->prepare("
        SELECT count(*) as questions_attempted, sum(correct) as correct FROM assessment_questions
        WHERE assessment_id = :assessment_id
    ");
    
    $stmt->execute( array(  ':assessment_id' => $assessment_id, )  );
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

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


</script>


</head>

<body>

<div data-role="page" id="" data-theme="e">
	
        <div data-role="header"  data-theme="e">
            <h1></h1>
        </div>
        
        <div data-role="content" data-theme="e">     
            <table data-role="table" data-theme="e">
                <tbody>
                    <tr>
                        <th data-priority="2">Total Questions:</th>
                        <td><?= $total_questions ?></td>
                    </tr>
                    
                    <tr>
                        <th data-priority="1">Questions Attempted:</th>
                        <td><?= $row['questions_attempted'] ?></td>
                    </tr>
         
                    <tr>
                        <th data-priority="3">No of Correct Answers:</th>
                        <td><?= $row['correct'] ?></td>
                    </tr>
                    
                    <tr>
                        <th data-priority="6">Result:</th>
                        <td><?= $row['correct']/$total_questions*100 ?></td>
                    </tr>
                </tbody>
            </table>
            
            <a href="#menu" data-role="button" data-inline="true" data-theme="e" data-mini="true">MENU</a>

        </div>
        <div data-role="footer" data-theme="e">
        	<h4>App Name &copy; 2013</h4>
        </div>
</div>
</body>
</html>
