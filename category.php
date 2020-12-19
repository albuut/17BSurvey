<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Categories</h2>
    </div>
    <form method="post" action="category.php">
        <?php echo display_error(); ?>
        <div class="checkbox-group">
            <?php
                $query = "SELECT name FROM anguyen_entity_category ORDER BY name";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                $count = 0;
                while($row = mysqli_fetch_array($result)){
                    echo '<input type = "checkbox" name = "categories[]" value="'.$row['name'].'">';
                    echo '<label for="categories[]">'.$row['name'].'</label><br>';                    
                }               
            ?>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="home_btn">Exit</button>
            <button type="submit" class="btn" name="categories_button">Next</button>
        </div>
    </form>
</body>