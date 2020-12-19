<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Take Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">                                    
<body>
    <div class="header">
	<h2>Take Survey</h2>
    </div>
    <form method="post" action="take_survey.php">
        <div class="input-group">
            <?php
                $survey_name = $_SESSION['survey_name'];
                $query0 = "SELECT * FROM anguyen_entity_question WHERE name='".$survey_name."'";
                $result_question = mysqli_query($db,$query0);
                $question_data = mysqli_fetch_assoc($result_question);
                
                $question_id = $question_data['question_id'];
                $_SESSION['question_id'] = $question_id;
                
                $query1 = "SELECT * FROM anguyen_xref_question_user WHERE question_id='".$question_id."'";
                $result_user = mysqli_query($db,$query1);
                $xref_data = mysqli_fetch_assoc($result_user);
                
                $user_id = $xref_data['user_id'];
                $query2 = "SELECT username FROM anguyen_entity_user WHERE id_user='".$user_id."'";
                $result_name = mysqli_query($db,$query2);
                $user_data = mysqli_fetch_assoc($result_name);
                
                                
                echo "<label><strong>Survey Name: </strong>".$question_data['name']."</label>";
                echo "<label><strong>Author: </strong>".$user_data['username']."</label>";
                                
                for($x = 1; $x <= 10; $x++){                    
                    if(!empty($question_data['q'.$x])){
                        echo "<label><strong>".$question_data['q'.$x]."</strong></label>";
                        echo '<input type = "text" name="q[]">';
                    }
                }          
            ?>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="home_btn">Home</button>
            <button type="submit" class="btn" name="answer_btn">Submit</button>
        </div>
    </form>
</body>

