<?php

include 'dbconnection.php';

$email = $sizeMySQLConnection -> real_escape_string($_POST['u_email']);
$fName = $sizeMySQLConnection -> real_escape_string($_POST['u_fname']);
$lName = $sizeMySQLConnection -> real_escape_string($_POST['u_lname']);
$password = $sizeMySQLConnection -> real_escape_string($_POST['password']);
// $phone = $sizeMySQLConnection -> real_escape_string($_POST['phone']);
// $address = $sizeMySQLConnection -> real_escape_string($_POST['address']);
$uniqueID = shell_exec('size/UniqueID.py ' . $email);

// $query ="INSERT INTO User_Profile(EMAIL, FIRST_NAME, LAST_NAME, PHONE, USER_ADDRESS) VALUES
//   ('" . $email . "','" .$fName . "','" .$lName . "','" .$$phone . "','" .$address . "');" ;

$query ="INSERT INTO User_Profile(EMAIL, FIRST_NAME, LAST_NAME, PASSWORD) VALUES
    ('" . $email . "','" .$fName . "','" .$lName . "','" .$$phone . "','" .$password . "');" ;

$insert = $sizeMySQLConnection -> query($query);

if (!$insert) {
  die("Couldn't enter data: ".$sizeMySQLConnection->error);
}

header("Location: mainPage.php");


?>
