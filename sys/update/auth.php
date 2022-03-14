<?php

session_start();

include_once '../../database/evaseacdb.php';
$conn = open_database();

$user = $_POST["user"];
$pwd = $_POST["password"];

$query = "SELECT * FROM Usuario WHERE usuario = '$user' and password = '$pwd'";
$numRows = mysqli_num_rows(mysqli_query($conn, $query));

mysqli_close($conn);

unset($_SESSION["user"]);

if ($numRows == 1) {
    $_SESSION["user"] = $user;
    echo "true";
}
else {
    echo "false";
}

?>