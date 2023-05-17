<?php

$con = mysqli_init(); 
mysqli_real_connect($con, "cosc4353-group25.mysql.database.azure.com", "adminUser", "COSC4353GROUP25UH23!", "db");
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: '.mysqli_connect_error());
}

?>