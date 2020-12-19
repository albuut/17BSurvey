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
	<title>Manage User</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
	<h2>Delete</h2>
    </div>
    <form method="post" action="delete_user.php">
        <div class="input-group">
            <?php echo display_error(); ?> 
            <label><strong>Enter confirm to delete user "<?php echo $_SESSION['delete_username'];?>"</strong></label>
            <input type="text" name ="confirm">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="back_manage_btn">Exit</button>
            <button type="submit" class="btn" name="confirm_delete_btn">Delete</button>
        </div>
    </form>
</body>
</html>