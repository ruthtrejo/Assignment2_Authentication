<?php
session_start();

require_once "database_connections/connect_database.php";
//Connect to the cssrvlab01 database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();
$_SESSION['logged_in'] = false;
$_SESSION['users_name'] = "";

if ( !empty($_POST) ){
    if( isset($_POST['submit']) ){

        //Store Clients credentials and prevent SQL Injections
        $input_username = stripslashes($_POST['uname']);
        $input_password = mysqli_real_escape_string($_POST['pswd']);

        //Select the username if found in database
        $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$input_username'");

        $count = mysqli_num_rows($result);
        $row = $result -> fetch_array(MYSQLI_ASSOC);

        //VERIFY PASSWORD FROM USER
        if( $count == 1 ){
            if( password_verify($input_password, $row['password']) ){
                if( $row['user_type'] == 'user' ){
                    $_SESSION['users_name'] = $input_username;
                    header("Location: user.php");
                }
                else if( $row['user_type'] == 'admin' ) {
                    $_SESSION['users_name'] = $input_username;
                    header("Location: admin.php");
                }
            }
        }else{
            echo "username or password is incorrect";
        }


    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Importing Style Sheet for mainpage -->
    <link rel="stylesheet" href="style/main_style.css">
    <title>Sign in</title>
</head>
<body>

    <!-- SHOW SIGN IN FORM BLOCK -->
    <form class="modal-content animate" action="" method="post">

        <div class="container">
            <h1 style="text-align:center;">Log In</h1>
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="pswd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pswd" required>

            <button type="submit">Login</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="location.href='mainpage.php'" class="cancelbtn">Cancel</button>
        </div>
    </form>

</body>
</html>

