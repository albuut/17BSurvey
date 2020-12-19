<?php include('survey_functions.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Survey</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Edit Categories</h2>
    </div>
    <form method="post" action="edit_categories.php">
        <?php echo display_error(); ?>
        <div class="checkbox-group">
            <?php
                $survey_data = $_SESSION['question_data'];
                $survey_id = $survey_data['question_id'];
                $query_question_cat_id = "SELECT * from anguyen_xref_question_category where question_id='$survey_id'"; 
                $result_question_cat_id = mysqli_query($db, $query_question_cat_id);
                $cat_id = array();
                while($row = mysqli_fetch_array($result_question_cat_id)){
                    array_push($cat_id,$row['category_id']);
                }
                
                $query = "SELECT * FROM anguyen_entity_category ORDER BY name";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                    
                while($row = mysqli_fetch_array($result)){
                        if(in_array($row['category_id'],$cat_id)){
                            echo '<input type = "checkbox" name = "categories[]" value="'.$row['name'].'" checked>';
                            echo '<label for="categories[]">'.$row['name'].'</label><br>';
                        }else{
                            echo '<input type = "checkbox" name = "categories[]" value="'.$row['name'].'">';
                            echo '<label for="categories[]">'.$row['name'].'</label><br>';
                        }
                    
                }               
            ?>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="edit_categories_button">Submit</button>
        </div>
    </form>
</body>