<?php session_start(); ?>
<?php

require_once "database_connections/connect_database.php";
require_once "database_connections/clean_input.php";

//Connect to the cssrvlab01 database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();

if ($_SESSION["logged_in"] != true) {
    echo("Access denied!");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- IMPORT STYLE SHEET FOR MAINPAGE -->
    <link rel="stylesheet" href="style/main_style.css">
    <title>User</title>
</head>
<body>

<!-- Pink banner with title -->
<div class="bannerHeader header-color">
    <h1>Welcome <?php echo("{$_SESSION['users_name']}");?> ! </h1>
</div>

<!-- Navigation Bar -->
<ul>
    <li><a href="sign_out.php">Sign out</a></li>
    <li><a class="active" href="mainpage.php">Home</a></li>
</ul>

<div id="container">
    <div class="column">
        <p>Welcome! You can view your information below.</p>
    </div>
</div>


</body>
</html>
