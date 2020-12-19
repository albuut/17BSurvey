<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Take Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Choose Survey</h2>
    </div>
    <form method="post" action="choose_survey.php">
        <div class="input-group">
            <?php echo display_error(); ?> 
            <label for="survey_name">Pick a Survey</label>
            <select name="survey_name">
            <?php
                $query = "SELECT name FROM anguyen_entity_question";
                $result = mysqli_query($db,$query);
                while($row = mysqli_fetch_array($result)){
                    echo '<option value="'.$row['name'].'">'.$row['name'].'</option>'; 
                }                
            ?>
            </select>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="home_btn">Exit</button>
            <button type="submit" class="btn" name="take_btn">Next</button>
        </div>
    </form>
</body>

