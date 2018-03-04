<?php

include 'dbconnection.php';

$email = $collectMySQLConnection -> real_escape_string($_POST['u_email']);
$fName = $collectMySQLConnection -> real_escape_string($_POST['u_fname']);
$lName = $collectMySQLConnection -> real_escape_string($_POST['u_lname']);
$password = $collectMySQLConnection -> real_escape_string($_POST['password']);
// $phone = $collectMySQLConnection -> real_escape_string($_POST['phone']);
// $address = $collectMySQLConnection -> real_escape_string($_POST['address']);
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
