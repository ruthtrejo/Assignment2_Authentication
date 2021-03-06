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
        $input_password = mysqli_real_escape_string($conn,$_POST['pswd']);

        //Select the username if found in database
        $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$input_username'");

        $count = mysqli_num_rows($result);
        $row = $result -> fetch_array(MYSQLI_ASSOC);

        //VERIFY PASSWORD FROM USER
        if( $count == 1 ){
            if( password_verify('$input_password', $row['password']) ){

                /* NOTE: Tried to update the last_login column but for
                   some reason acct_creation updates with it as well */
                //mysqli_query($conn,"UPDATE user SET last_login = now() WHERE username='$input_username'");

                /* Check whether the user is a regular user or an administrator */
                if( $row['user_type'] == 'user' ){
                    $_SESSION['users_name'] = $input_username;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['status'] = "User";
                    $_SESSION['firstName'] = $row['firstname'];
                    header("Location: user.php");
                }
                else if( $row['user_type'] == 'admin' ) {
                    $_SESSION['users_name'] = $input_username;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['status'] = "Administrator";
                    $_SESSION['firstName'] = $row['firstname'];
                    header("Location: admin.php");
                }
            }
        } else{
            //send user back to the login page and display error message
            header("Location: sign_out.php");
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

            <button id="submit" name="submit" type="submit">Login</button>

        </div>

        <div class="container" style="background-color:#f1f1f1">
            <!-- THE CANCEL BUTTON DESTORYS THE SESSION AND RETURNS THE USER TO THE MAIN PAGE -->
            <button type="button" onclick="location.href='sign_out.php'" class="cancelbtn">Cancel</button>
        </div>
    </form>



</body>
</html>

