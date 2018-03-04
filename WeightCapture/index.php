<?php

	include("../dbconnection.php");

  $sql = "SELECT WEIGHT FROM User_Transaction";
  $result = $collectMySQLConnection->query($sql);

  echo "Weight <br>";

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "weight: " . $row["WEIGHT"]. " <br>";
      }
  } else {
      echo "0 results";
  }
?>
