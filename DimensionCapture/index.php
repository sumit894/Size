<?php

include '../dbconnection.php';
include '../addUser.php';



$uniqueID = shell_exec('Collect/UniqueID.py ' . $email);

// $query ="INSERT INTO User_Profile(EMAIL, FIRST_NAME, LAST_NAME, PHONE, USER_ADDRESS) VALUES
//   ('" . $email . "','" .$fName . "','" .$lName . "','" .$$phone . "','" .$address . "');" ;

$query ="INSERT INTO User_Profile(EMAIL, FIRST_NAME, LAST_NAME, PASSWORD) VALUES
    ('" . $email . "','" .$fName . "','" .$lName . "','" .$$phone . "','" .$password . "');" ;

$insert = $collectMySQLConnection -> query($query);

if (!$insert) {
  die("Couldn't enter data: ".$collectMySQLConnection->error);
}

header("Location: mainPage.php");


?>
