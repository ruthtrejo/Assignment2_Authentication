<?php
session_start();

require_once "database_connections/connect_database.php";
//Connect to the cssrvlab01 database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();
$_SESSION['logged_in'] = false;
$_SESSION['users_name'] = "";

echo "connected to database<br>";
if ( !empty($_POST) ){
    echo "checking that POSt is not empty<br>";
    if( isset($_POST['submit']) ){
        echo "checking the user submitted the button to submit<br>";
        //Store Clients credentials and prevent SQL Injections
        $input_username = stripslashes($_POST['uname']);
        $input_password = mysqli_real_escape_string($conn,$_POST['pswd']);

        //Select the username if found in database
        $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$input_username'");

        $count = mysqli_num_rows($result);
        $row = $result -> fetch_array(MYSQLI_ASSOC);

        echo "about to verify password<br>";
        echo "hash password: " . $row['password'] . "<br>";
        echo "users entered password: " . $input_password . "<br>";
        echo "the username is: " . $row['username'] . "<br>";
        //VERIFY PASSWORD FROM USER
        if( $count == 1 ){
            echo "count is 1 ---- now verifying password<br>";
            if( password_verify('$input_password', $row['password']) ){
                echo "password was verified <br>";
                //Edit TIMESTAMP for latest login
                $sql = "INSERT INTO user (last_login) VALUES (CURRENT_TIMESTAMP);";

                if( mysqli_query($conn,$sql) ){
                    echo "Successfully updates TIMESTAMP for latest login.";
                }

                /* Check whether the user is a regular user or an administrator */
                if( $row['user_type'] == 'user' ){
                    $_SESSION['users_name'] = $input_username;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['status'] = "User";
                    header("Location: user.php");
                }
                else if( $row['user_type'] == 'admin' ) {
                    $_SESSION['users_name'] = $input_username;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['status'] = "Administrator";
                    header("Location: admin.php");
                }
            }
        } else{
            header("Location: mainpage.php");
        }
        echo "never entered the password if statement";

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
            <button type="button" onclick="location.href='mainpage.php'" class="cancelbtn">Cancel</button>
        </div>
    </form>

</body>
</html>

