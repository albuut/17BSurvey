<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>View Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>View Survey - <?php echo $_SESSION['view_survey_name']?></h2>
    </div>
    <form method="post" action="view_survey.php">
        <div class="input-group">
            <?php echo display_error(); ?> 
            <label for="user_answer"><strong>Pick an answer</strong></label>
            <select name="user_answer">
            <?php
                $name = $_SESSION['view_survey_name'];
                echo $name;
                $query_name = "SELECT * FROM anguyen_entity_question WHERE name='$name'";
                $result_name = mysqli_query($db,$query_name);
                $data_name = mysqli_fetch_assoc($result_name);
                $name_id = $data_name['question_id'];
                                
                $query_xref_question_answer = "SELECT * FROM anguyen_xref_question_answer WHERE question_id ='$name_id'";
                $result_answer = mysqli_query($db,$query_xref_question_answer);
                
                echo mysqli_num_rows($result_answer);
                while($row = mysqli_fetch_array($result_answer)){
                    $answer_id = $row['answer_id'];
                    $query_answer_user = "SELECT * FROM anguyen_xref_answer_user WHERE answer_id ='$answer_id'";
                    $result_answer_user = mysqli_query($db,$query_answer_user);
                    $user_answer_data = mysqli_fetch_assoc($result_answer_user);
                    $user_id = $user_answer_data['user_id'];
                    
                    $query_user = "SELECT * FROM anguyen_entity_user WHERE id_user ='$user_id'";
                    $result_user = mysqli_query($db,$query_user);
                    $user_data = mysqli_fetch_assoc($result_user);
                    $username = $user_data['username'];
                    
                    echo '<option value="'.$answer_id.'">'.$username.'</option>';
                }
            ?>
            </select>
            <?php 
                if(isset($_SESSION['view'])){
                    $answer_display_id = $_SESSION['view'];
                    $query_answer = "SELECT * FROM anguyen_entity_answer where answer_id='$answer_display_id'";
                    $query_answer_display = mysqli_query($db,$query_answer);
                    $answer_data = mysqli_fetch_assoc($query_answer_display);
                    for($x = 1; $x <= 10; $x++){
                        if(!empty($data_name["q".$x])){
                             echo "<label><strong>Question ".$x."</strong></label>";
                             echo "<label>".$data_name["q".$x]."</label>";
                             echo "<label><strong>Answer ".$x."</strong></label>";
                             echo "<label>".$answer_data["a".$x]."</label><br>";
                        }
                    }
                }
            ?>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="back_view_btn">Back</button>
            <button type="submit" class="btn" name="view_new_btn">View</button>
        </div>
    </form>
                   
</body>
</html>

