<?php
require_once "database_connections/connect_database.php";
require_once "database_connections/clean_input.php";


function _header(){
    print <<<HERE
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Importing Style Sheet for mainpage -->
    <link rel="stylesheet" href="style/main_style.css">
    <title>List of Users</title>
</head>
<body>
    <!-- Pink banner with title -->
    <div class="bannerHeader header-color">
        <h1>LIST OF USERS</h1>
    </div>

    <!-- Navigation Bar -->
    <ul>
        <li><a href="sign_out.php">Sign out</a></li>
        <li><a class="active" href="list_of_users">List of Users</a></li>
        <li><a href="insert_users.php">Register Users</a></li>
        <li><a href="admin.php">Home</a></li>
    </ul>
    
    <!-- TABLE THAT HAS DATABASE INFORMATION -->
    <table id="users">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Account Creation</th>
            <th>Last Log-in</th>
        </tr>
HERE;
}// end _header

function _footer(){
    print <<<HERE
    </table>
</body>
</html>
HERE;

}//end _footer

//Connect to the cssrvlab01 database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();


//Selecting all column information from user table in database
$query = "SELECT * FROM user";
$result = mysqli_query($conn,$query);

_header();

//Creates a loop to loop through results
while($row = mysqli_fetch_array($result)){
    //$row['index'] the index here is a field name
    echo "<tr><td>" . $row['firstname'] . "</td><td>" . $row['lastname'] . "</td><td>" . $row['acct_creation'] . "</td><td>" . $row['last_login'] . "</td><tr>";
}

_footer();

mysqli_close($conn); //Make sure to close out the database connection

?>
