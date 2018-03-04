<?php

include '../dbconnection.php';
include '../addUser.php';

//edit the value of information within the square brackets
$weight = $collectMySQLConnection -> real_escape_string($_POST['weight']);

$query = "INSERT INTO User_Transaction(ITEM_ID, DATE_ADDED, FIRST_NAME, LAST_NAME, RECIPIENT_NAME, EMAIL, PHONE, USER_ADDRESS, DEST_ADDRESS, WEIGHT, HEIGHT, WIDTH) VALUES
	('" . $uniqueID . "','','','','','','','','','" .$weight . "','','');";

$insert = $collectMySQLConnection -> query($query);

if (!$insert) {
  die("Couldn't enter data: ".$collectMySQLConnection->error);
}

echo "Data Insertion Successful";


?>
