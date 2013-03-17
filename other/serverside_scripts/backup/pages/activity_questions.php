<?php
ini_set('display_errors', 'On'); error_reporting(E_ALL | E_STRICT); 
    session_start();
	include_once('../dbconn.php');
	include_once('../functions.php');
    
    $activity_id        = $_GET['activity_id'];
    $assessment_id      = $_GET['assessment_id'];
    $total_rows         = $_GET['total_rows'];
    $start_row          = $_GET['start_row'];
        
    //find out activity details
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
    
    print_r ($rows);
    
    $questions = array();
    foreach ($rows as $row){
        $questions[$row['question_id']]['question'] = $row['question'];
        $questions[$row['question_id']]['solution_id'] = $row['solution_id'];
        $questions[$row['question_id']]['answer'][$row['answer_id']] = $row['answer'];
    }
    
    if ( ($start_row + 4) >= $total_rows ) {
        $start_row = "END";
    } else {
        $start_row = $start_row + 4;
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
    $(document).bind('pageinit',function(){
        var assessment = "<?= $assessment_id ;?>";
        var answer = "";
        var question = "";
        var solution = "";
        
         $("a").live("click", function(){
           
           //check if any of the checkbox was checked.
           if (!$("input:checked").val()) {
                alert('Please select a checkbox');
                return false;
            } else {
                alert("22");
                var answer = $("input:checked").val();
                var question = $("input:checked").attr("name").match(/[\d]+$/)[0];
                var solution = $("input[name=solution_id]").val();
                var correct = 0;
                
                if ( answer == solution ){
                    correct = 1;
                }
                
                var url = "http://education.shehzadazram.co.uk/jquery/phone_app/connect.php"; 
                
                //alert ("answer_id:" + answer_id + "<br/> question_id:" + question_id + "solution_id: "+solution_id+" assessment_id:" + assessment_id)
                $.post(url,{
                    'answer_id':answer,
                    'question_id':question,
                    'solution_id':solution,
                    'assessment_id':assessment,
                    'correct':correct,
                    method:'submit_answer'
                }, function(data){
                    if ( data ) {
                        alert(data);   
                    }
                });
            }
            
        });
    });
</script>


</head>

<body>

<?php
foreach( $questions as $question_id => $details ) :
    $unique_id = "question_$question_id";
?>

    <div data-role="page" id="<?= $unique_id;?>" data-theme="e">
	
        <div data-role="header"  data-theme="e">
            <h1>Question <?= $details['question']; ?></h1>
        </div>
        <div data-role="content" data-theme="e">     
            
            <form id="<?= $unique_id; ?>">
                <input type="hidden" name="solution_id" value="<?= $details['solution_id']; ?>" />
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
                    if ( $start_row == "END" ) {
                        echo '<a href="activity_review.php?activity_id='.$activity_id.'&assessment_id='.$assessment_id.'&total_rows='.$total_rows.'&start_row='.$start_row.'" data-role="button" data-inline="true" data-theme="e" data-mini="true">Review</a>';
                    } else {
                        echo '<a href="activity_questions.php?activity_id='.$activity_id.'&assessment_id='.$assessment_id.'&total_rows='.$total_rows.'&start_row='.$start_row.'" data-role="button" data-inline="true" data-theme="e" data-mini="true">Next</a>';

                    }
                ?>
            </form>
        </div>
        <div data-role="footer" data-theme="e">
        	<h4>App Name &copy; 2013</h4>
        </div>
</div>

<?php
    endforeach;
?>

</body>
</html>
