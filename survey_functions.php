<?php
//Connect to a database
session_start();
$db = mysqli_connect('209.129.8.7', 'RCCCSCCIS17B', '4921449288', 'RCCCSCCIS17B');

//Variable Declaration
$survey_name = "";
$cat = array();
$num_questions = "";
$question = array();
$errors = array();


if(isset($_POST['survey_info_btn'])){
    survey_set();
}
if(isset($_POST['categories_button'])){
    categories_set();
}
if(isset($_POST['result_btn'])){
    global $errors;
    if(!empty($_POST['survey_name'])){
        $survey = $_POST['survey_name'];
        $_SESSION['view_survey_name'] = $survey;
        header('location: view_survey.php');
    }else{
        array_push($errors,"No available survey");
    }
}
if(isset($_POST['view_new_btn'])){
    global $errors;
    if(!empty($_POST['user_answer'])){
        $_SESSION['view'] = $_POST['user_answer'];
    }else{
        array_push($errors, "No available results");
    }
}
if(isset($_POST['back_view_btn'])){
    unset($_SESSION['view']);
    header('location: manage_survey.php');
}
if(isset($_POST['delete_survey_btn'])){
    global $errors;
    if(!empty($_POST['survey_name'])){
        $_SESSION['delete_survey_name'] = $_POST['survey_name'];
        header('location: delete_survey.php');
    }else{
        array_push($errors,"No available survey");
    }
        
}
if(isset($_POST['confirm_delete_btn'])){
    global $errors, $db; 
    $confirm = $_POST['confirm'];
    if(strtolower($confirm) == "confirm"){
        $survey_name = $_SESSION['delete_survey_name'];
        $query_delete = "SELECT * FROM anguyen_entity_question WHERE name='$survey_name'";
        $result_delete = mysqli_query($db,$query_delete);
        $delete_data = mysqli_fetch_assoc($result_delete);
        $delete_id = $delete_data['question_id'];
        
        $delete_question = "DELETE FROM anguyen_entity_question WHERE question_id='$delete_id'";
        $delete_question_answer = "DELETE FROM anguyen_xref_question_answer WHERE question_id='$delete_id'";
        $delete_question_category = "DELETE FROM anguyen_xref_question_category WHERE question_id='$delete_id'";
        $delete_question_user = "DELETE from anguyen_xref_question_user WHERE question_id='$delete_id'";
        
        $get_answer_id = "SELECT * FROM anguyen_xref_question_answer WHERE question_id='$delete_id'";        
        $result_answer_id = mysqli_query($db,$get_answer_id);
        echo mysqli_error($db);
        
        while($row = mysqli_fetch_array($result_answer_id)){
            $answer_id = $row['answer_id'];
            $query_delete_answer_user = "DELETE FROM anguyen_xref_answer_user WHERE answer_id='$answer_id'";
            mysqli_query($db,$query_delete_answer_user);
            $query_delete_answer_entity = "DELETE FROM anguyen_entity_answer WHERE answer_id='$answer_id'";
            mysqli_query($db,$query_delete_answer_entity);
        }
                
        mysqli_query($db,$delete_question);
        mysqli_query($db,$delete_question_answer);
        mysqli_query($db,$delete_question_category);
        mysqli_query($db,$delete_question_user);
        array_push($errors,mysqli_error($db));
        
        //unset($_SESSION['delete_survey_name']);
        //header('location: manage_survey.php');
    }else{
        array_push($errors,"Please input confirm properly down below to delete.");
    }
}
if(isset($_POST['edit_categories_button'])){
    global $db;
    $question_data = $_SESSION['question_data'];
    $question_id = $question_data['question_id'];
    
    
    if(empty($_POST['categories'])){
        array_push($errors,"A category is required");
    }else{
        $new_categories = $_POST['categories'];
        $delete = "DELETE FROM anguyen_xref_question_category WHERE question_id='$question_id'";
        mysqli_query($db, $delete);
        foreach ($new_categories as $cat) {
            $query1 = "SELECT category_id FROM anguyen_entity_category WHERE name='$cat'";
            $result = mysqli_query($db, $query1);
            $row = $result->fetch_array()['category_id'] ?? '';
            $query2 = "INSERT INTO `anguyen_xref_question_category`(`question_id`,`category_id`) VALUES('$question_id','$row')";
            mysqli_query($db, $query2);
        }
        unset($_SESSION['categories']);
        header('location: edit_survey.php');
    }
}
if(isset($_POST['fill_question_button'])){
    questions_set();
}
if(isset($_POST['home_btn'])){
    header('location: index.php');
}
if (isset($_POST["take_btn"])) {
    global $db, $errors; 
    //$_SESSION['survey_name'] = $survey_name;
    if(!empty($_POST['survey_name'])){
        $survey_name = $_POST['survey_name']; 
        $query_name = "SELECT * FROM anguyen_entity_question WHERE name='$survey_name'";
        $result_name = mysqli_query($db, $query_name);
        $data_name = mysqli_fetch_assoc($result_name);
        $survey_id = $data_name['question_id'];

        $query_question_answer = "SELECT * FROM anguyen_xref_question_answer WHERE question_id ='$survey_id'";
        $result_question_answer = mysqli_query($db, $query_question_answer);


        $user = $_SESSION['user'];
        $user_id = $user['id_user'];

        $count = 0;

        if (mysqli_num_rows($result_question_answer) != 0) {
            while ($row = mysqli_fetch_array($result_question_answer)) {
                $answer_id = $row['answer_id'];
                $query_answer_user = "SELECT * FROM anguyen_xref_answer_user WHERE answer_id='$answer_id' AND user_id ='$user_id'";
                $result_unique = mysqli_query($db, $query_answer_user);
                if (mysqli_num_rows($result_unique) == 0) {
                    $_SESSION['survey_name'] = $survey_name;
                    header('location: take_survey.php');
                } else {
                    if ($count == 0) {
                        array_push($errors, "You've already taken this survey");
                        $count++;
                    }
                }
            }
        } else {
            $_SESSION['survey_name'] = $survey_name;
            header('location: take_survey.php');
        }
    }else{
        array_push($errors,"No available survey");
    }
    
    
}
if (isset($_POST["add_btn"])){
    global $errors;
    if($_SESSION['num_question'] >= 10){
        array_push($errors,"Max amount of questions is 10");
    }else{
        $_SESSION['num_question']++;
    }
}
if (isset($_POST["remove_btn"])){
    global $errors;
    if($_SESSION['num_question'] <= 1){
        array_push($errors,"Minimum amount of questions is 1");
    }else{
        $_SESSION['num_question']--;
    }
}
if( isset($_POST["edit_categories_btn"])){
    header('location: edit_categories.php');
}
if (isset($_POST["edit_btn"])) {
    global $db,$errors;
    if(!empty($_POST['survey_name'])){
        $survey_name = $_POST['survey_name'];
        $query_question = "SELECT * FROM anguyen_entity_question WHERE name = '$survey_name'";
        $result_question = mysqli_query($db, $query_question);
        $query_data = mysqli_fetch_assoc($result_question);
        $question_id = $query_data['question_id'];

        $query_xref = "SELECT * FROM anguyen_xref_question_answer WHERE question_id ='$question_id'";
        $result_xref = mysqli_query($db, $query_xref);

        if (mysqli_num_rows($result_xref) != 0) {
            array_push($errors, "Someone has already submitted an answer, unable to edit.");
        }

        if (count($errors) == 0) {
            $_SESSION['question_data'] = $query_data;
            $_SESSION['count'] = "first";
            $_SESSION['num_question'];
            header('location: edit_survey.php');
        }
    }else{
        array_push($errors,"No available survey");
    }   
    
}
if(isset($_POST["edit_setting_btn"])){    
    global $db,$errors;
    $survey_name_edit = $_POST['survey_name_edit'];
    $q = $_POST['q'];
    $question_data = $_SESSION['question_data'];
    $num = $_SESSION['num_question'];
    $question_id = $question_data['question_id'];
    $count = 1;
    
    $query_check_name = "SELECT * FROM anguyen_entity_question where name='$survey_name_edit";
    $result_check_name = mysqli_query($db,$query_check_name);
    if(mysqli_num_rows($result_check_name) == 0){
        $update_name = "UPDATE `anguyen_entity_question` SET name='$survey_name_edit' WHERE question_id='$question_id'";
        mysqli_query($db,$update_name);
    }else{
        push_array($errors,"Survey Name is already taken");
    }
    foreach ($q as $quest) {
        $update = "UPDATE anguyen_entity_question SET q".$count."='$quest' WHERE question_id='$question_id'";
        mysqli_query($db,$update);
        $count++;
    }
    for($x = $num + 1; $x <= 10; $x++){
        $empty = "";
        $update_delete = "UPDATE anguyen_entity_question SET q".$x."='$empty' WHERE question_id='$question_id'";
        echo $x."<br>";
        mysqli_query($db,$update_delete);
    }
    unset($_SESSION['question_data']);
    unset($_SESSION['num_question']);
    header('location: manage_survey.php');
    
}
if (isset($_POST["answer_btn"])) {
    global $db;
    $a = $_POST['q'];
    $query = "INSERT into `anguyen_entity_answer`(`a1`) VALUES ('')";
    mysqli_query($db,$query);
    $answer_id = mysqli_insert_id($db);
    $count = 1;
    foreach($a as $answer){
        $update = "UPDATE anguyen_entity_answer SET a".$count."='$answer' WHERE answer_id='$answer_id'";
        mysqli_query($db,$update);
        $count++;
    }
    $user = $_SESSION['user'];
    $user_id = $user['id_user'];
    $query_xref = "INSERT into `anguyen_xref_answer_user`(`answer_id`,`user_id`) VALUES ('$answer_id','$user_id')";
    mysqli_query($db,$query_xref);
    $question_id = $_SESSION['question_id'];
    echo $_SESSION['question_id'];
    $query_xref_question = "INSERT into `anguyen_xref_question_answer`(`question_id`,`answer_id`) VALUES('$question_id','$answer_id')";
    mysqli_query($db,$query_xref_question);
    
    unset($_SESSION['survey_name']);
    unset($_SESSION['question_id']);
    $_SESSION['success'] = "Survey Successfully Submitted";
    header('location: index.php');
    
}
function survey_set(){
    global $db, $errors, $survey_name, $num_questions, $question;
    $survey_name = e($_POST['survey_name']);
    $num_questions = $_POST['num_questions'];
    if(empty($survey_name)){
        array_push($errors,"Survey name is required");
    }
    $query = "SELECT * FROM anguyen_entity_question WHERE name='$survey_name'";
    $dupeName = mysqli_query($db,$query);
    if(mysqli_num_rows($dupeName) != 0 && !empty($survey_name)){
        array_push($errors,"Survey name is taken");
    }
    if($num_questions == 0){
         array_push($errors, "Number of questions is required");
    }
    if(count($errors) == 0){
        $_SESSION['create_survey_name'] = $survey_name;
        $_SESSION['create_num_question'] = $num_questions;
        for($i = 0; $i < 10; $i++){
            array_push($question,"");
        }
        $_SESSION['create_fill_question'] = $question;
        header('location: category.php');        
    }    
}
function categories_set(){
    global $errors,$cat;
    if(empty($_POST['categories'])){
        array_push($errors,"A category is required");
    }else{
        $category = $_POST['categories'];
        foreach($category as $categories){
            array_push($cat,$categories);
        }
        $_SESSION['create_category'] = $cat;
        header('location: fill_question.php');
    }
}
function questions_set(){
    global $db, $errors;
    $count = 1;
    $q = $_POST['q'];
    foreach($q as $quest){
        if(empty($quest)){
            array_push($errors,"Question ".$count." is empty");
        }
        $count++;
    }    
    if(count($errors) == 0){
        $survey_name =  $_SESSION['create_survey_name'];
        $categories = $_SESSION['create_category'];
        $user = $_SESSION['user'];
        $user_id = $user['id_user'];
        $count = 1;
        $query0 = "INSERT INTO `anguyen_entity_question`(`name`) VALUES('$survey_name')";
        mysqli_query($db, $query0);
        $quest_id = mysqli_insert_id($db);
        foreach($q as $quest){
            $update = "UPDATE `anguyen_entity_question` SET q".$count."='$quest' WHERE question_id='$quest_id'";
            if(mysqli_query($db,$update)){
                
            }else{
                echo mysqli_error($db);
            }
            $count++;            
        }
        foreach($categories as $cat){
            $query1 = "SELECT category_id FROM anguyen_entity_category WHERE name='$cat'";
            $result = mysqli_query($db, $query1);
            $row = $result->fetch_array()['category_id'] ?? '';
            
            $query2 = "INSERT INTO `anguyen_xref_question_category`(`question_id`,`category_id`) VALUES('$quest_id','$row')";
            mysqli_query($db, $query2);
        }
        $query3 = "INSERT INTO `anguyen_xref_question_user`(`question_id`,`user_id`) VALUES('$quest_id','$user_id')";
        mysqli_query($db,$query3);
        unset($_SESSION['create_survey_name']);
        unset($_SESSION['create_num_questions']);
        unset($_SESSION['create_fill_question']);
        unset($_SESSION['create_category']);
        $_SESSION['success'] = "Survey Successfully Created";
        header('location: index.php');
    }else{
        $_SESSION['create_fill_question'] = $q;
    }
}
function e($val){
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}
function display_error() {
    global $errors;
    if (count($errors) > 0){
	echo '<div class="error">';
        foreach ($errors as $error){
            echo $error .'<br>';
	}
	echo '</div>';
    }
}