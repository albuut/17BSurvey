<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Delete</h2>
    </div>
    <form method="post" action="delete_survey.php">
        <div class="input-group">
            <?php echo display_error(); ?> 
            <label><strong>Enter confirm to delete survey "<?php echo $_SESSION['delete_survey_name'];?>"</strong></label>
            <input type="text" name ="confirm">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="home_btn">Exit</button>
            <button type="submit" class="btn" name="confirm_delete_btn">Delete</button>
        </div>
    </form>
</body>
</html>