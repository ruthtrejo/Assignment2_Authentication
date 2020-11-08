<?php

require_once "database_connections/connect_database.php";
require_once "database_connections/clean_input.php";

//instantiate clean input
$cleanse = new Sanitizer();

//Connect to the cssrvlab01 database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();


//Clients credentials

//First Name
$input_firstName = $cleanse->cleanInput($_POST["fName"]);
//Last Name
$input_lastName  = $cleanse->cleanInput($_POST["lName"]);
//username
$input_username  = $cleanse->cleanInput($_POST["uname"]);
//password
$input_password  = $cleanse->cleanInput($_POST["pswd"]);
//role
$input_userRole  = $cleanse->cleanInput($_POST["userRole"]);
//Hashed password using PHP Salt
$hashed_password = password_hash('$input_password', PASSWORD_DEFAULT);

$submitBtn = $_POST["submit"];

//Check if the button was submitted
if( isset($submitBtn) ){
    //Attempt insertion into query
    $sql = "INSERT INTO user (firstname, lastname, username, password, acct_creation, last_login, user_type)
VALUES ('$input_firstName','$input_lastName','$input_username','$hashed_password', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP,'$input_userRole')";

    if( mysqli_query($conn,$sql) ){
        echo "The user <b>" . $input_firstName . "</b> was successfully inserted into the database.";
    } else{
        echo "<b>ERROR: </b> Was not able to execute $sql --- " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Importing Style Sheet for mainpage -->
    <link rel="stylesheet" href="style/main_style.css">
    <title>Register Users</title>
</head>
<body>
<!-- SHOW SIGN IN FORM BLOCK -->
<form class="modal-content animate" action="insert_users.php" method="post">

    <div class="container">
        <h1 style="text-align:center;">REGISTER USERS INTO THE DATABASE</h1>
        <label for="fName"><b>First Name</b></label>
        <input type="text" placeholder="Enter First Name" id="fName" name="fName" required>

        <label for="lName"><b>Last Name</b></label>
        <input type="text" placeholder="Enter Last Name" id="lName" name="lName" required>

        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" id="uname" name="uname" required>

        <label for="pswd"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" id="pswd" name="pswd" required>

        <!-- CLIENT SELECTION WHETHER BE ADMIN OR USER-->
        <label for="userRole"><b>Select Users Role in the System</b></label>
        <select class="w3-select w3-border" name="userRole">
            <option selected disabled>Role for Access</option>
            <option value="admin">Administrator</option>
            <option value="user">User</option>
        </select> <br/>

        <button type="submit" name="submit">Register User</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="location.href='admin.php'" class="cancelbtn">Cancel</button>
    </div>
</form>

</body>
</html>