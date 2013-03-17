<?php
    session_start();
	include_once('../dbconn.php');
	include_once('../functions.php');
    
    $activity_id        = $_GET['activity_id'];
    $assessment_id      = $_GET['assessment_id'];
    $total_questions    = $_GET['total_questions'] - 1; //-1 because the foreach below will have index at 0
        
    //find out activity details
    $stmt = $db->prepare("
        Select q.question_id, question, answer_id, answer
        FROM questions q
        INNER JOIN answers a
        on a.question_id = q.question_id
        INNER JOIN activity_questions aq
        on aq.question_id = q.question_id
        where activity_id = :activity_id
    ");
    
    $stmt->execute( array(  ':activity_id' => $activity_id  )  );
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $questions = array();
    foreach ($rows as $row){
        $questions[$row['question_id']]['question'] = $row['question'];
        $questions[$row['question_id']]['answer'][$row['answer_id']] = $row['answer'];
    }
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

<?php
$i = 0;
$j = 1;
foreach( $questions as $question_id => $details ) :
    $unique_id = "question_$i";
?>

    <div data-role="page" id="<?= $unique_id;?>" data-theme="e">
	
        <div data-role="header"  data-theme="e">
            <h1>Question <?= $j;?> </h1>
        </div>
        <div data-role="content" data-theme="e">    
            
            <form id="<?= $unique_id; ?>">
                <fieldset data-role="controlgroup">
                    <legend><?= $details['question']; ?></legend>
                    
                    <?php
                        $z = 0;
                        foreach ($details['answer'] as $id => $answer ) { ?>
                            <input name="<?= $unique_id; ?>" id="radio-choice-<?= $z; ?>" value="<?= $id; ?>" type="radio">
                            <label for="radio-choice-<?= $z; ?>"><?= $answer; ?></label> 
                        <?
                        $z++;
                        }
                    ?>
                </fieldset>
                <?php
                    if ( $i == $total_questions ) {
                        echo "<a href='#question_$j' data-role='button' data-inline='true' data-theme='e' data-mini='true'>Review</a>";
                    } else {
                        echo "<a href='#question_$j' data-role='button' data-inline='true' data-theme='e' data-mini='true'>Next</a>";
                    }
                ?>
            </form>
        </div>
        <div data-role="footer" data-theme="e">
        	<h4>App Name &copy; 2013</h4>
        </div>
</div>

<?php
    $i++; $j++;
    endforeach;
?>

</body>
</html>
