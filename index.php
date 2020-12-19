<?php
include('login_functions.php');
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="header">
            <h2>Home Page</h2>
        </div>
            <!-- notification message -->
            <form method="post" action="index.php">
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="error success" >
                        <h3>
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </h3>
                    </div>
                <?php endif ?>
                <div class="input-group">
                    <button type="submit" class="btn" name="choose_btn">Take Survey</button><br>
                    <?php
                        $user = $_SESSION['user'];
                        $user_type = $user['user_type'];
                        if($user_type == 'admin'){
                            echo '<button type="submit" class="btn" name="create_btn">Create Survey</button><br>';
                            echo '<button type="submit" class="btn" name="view_btn">View/Manage Survey Results</button><br>';
                            echo '<button type="submit" class="btn" name="manage_user_btn">Manage Users</button><br>';
                        }
                    ?>
                    <button type="submit" class="btn" name="manage_btn">Manage Account</button><br>
                    <button type="submit" class="btn" name="logout_btn">Logout</button><br>                
                </div>
            </form>
    </body>
</html>
