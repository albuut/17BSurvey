<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Create Survey</h2>
    </div>
    <form method="post" action="survey_setting.php">
        <?php echo display_error(); ?>
        <div class="input-group">
            <label>Survey Name</label>
            <input type="text" name="survey_name" value="<?php echo $survey_name; ?>">	
        </div>
        <div class="input-group">
            <label>Number of Questions</label>
                <input type="number" name="num_questions" step="1" min="1" max="10" value="<?php echo $num_questions; ?>">                    
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="home_btn">Exit</button>
            <button type="submit" class="btn" name="survey_info_btn">Next</button>
        </div>
    </form>
</body>
</html>