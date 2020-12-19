<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Manage Survey</h2>
    </div>
    <form method="post" action="manage_survey.php">
        <div class="input-group">
            <?php echo display_error(); ?> 
            <label for="survey_name"><strong>Pick a Survey</strong></label>
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
            <button type="submit" class="btn" name="home_btn">Back</button>
            <button type="submit" class="btn" name="edit_btn">Edit</button>
            <button type="submit" class="btn" name="delete_survey_btn">Delete</button>
            <button type="submit" class="btn" name="result_btn">View Results</button>
        </div>
    </form>
</body>
</html>