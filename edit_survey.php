<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">                                    
<body>
    <div class="header">
	<h2>Edit Survey</h2>
    </div>
    <form method="post" action="edit_survey.php">
        <div class="input-group">
            <?php echo display_error(); ?> 
            <?php                
                $survey_data = $_SESSION['question_data'];
                $survey_name = $survey_data['name'];
                $query0 = "SELECT * FROM anguyen_entity_question WHERE name='".$survey_name."'";
                $result_question = mysqli_query($db,$query0);
                $question_data = mysqli_fetch_array($result_question);
                
                $question_id = $question_data['question_id'];
                $query1 = "SELECT * FROM anguyen_xref_question_user WHERE question_id='".$question_id."'";
                $result_user = mysqli_query($db,$query1);
                $xref_data = mysqli_fetch_array($result_user);
                
                $user_id = $xref_data['user_id'];
                $query2 = "SELECT username FROM anguyen_entity_user WHERE id_user='".$user_id."'";
                $result_name = mysqli_query($db,$query2);
                $user_data = mysqli_fetch_array($result_name);
                
                if(isset($_SESSION['count'])){                    
                    $count = 0;
                    for($x = 1; $x <= 10; $x++){                    
                        if(!empty($question_data['q'.$x])){
                            $count++;
                        }
                    }                    
                    $_SESSION['num_question'] = $count;
                    unset($_SESSION['count']);
                }
                
                                
                echo "<label><strong>Survey Name </strong></label>";
                echo '<input type = "text" name = "survey_name_edit" value="'.$question_data['name'].'"';
                $num = $_SESSION['num_question'];
                for($x = 1; $x <= $num; $x++){                    
                    echo "<label><strong>Question ".$x."</strong></label>";
                    echo '<input type = "text" name="q[]" value="'.$question_data['q'.$x].'">';                    
                }          
            ?>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="home_btn">Exit</button>
            <button type="submit" class="btn" name="add_btn">Add Question</button>
            <button type="submit" class="btn" name="remove_btn">Remove Question</button>
            <button type="submit" class="btn" name="edit_categories_btn">Edit Categories</button>
            <button type="submit" class="btn" name="edit_setting_btn">Submit</button>
        </div>
    </form>
</body>