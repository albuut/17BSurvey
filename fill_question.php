<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Fill Questions</h2>
    </div>
    <form method="post" action="fill_question.php">
        <?php echo display_error(); ?>
        <div class="input-group">
            <?php
                $n = $_SESSION['create_num_question'];
                $question = $_SESSION['create_fill_question'];
                for($x = 0; $x < $n; $x++){
                    $num = $x + 1;
                    echo '<label>Question '.$num.'</label>';
                    echo '<input type = "text" name="q[]" value="'.$question[$x].'">';
                }
            ?>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="home_btn">Exit</button>
            <button type="submit" class="btn" name="fill_question_button">Next</button>
        </div>
    </form>
</body>
