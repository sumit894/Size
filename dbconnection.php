<?php
//======================================================================
// DATABASE LOGIN INFO
//======================================================================
// Local Database Connection Details:
$local_host = "localhost";
$local_username = "root";
$local_password = "root";
$local_databaseName = "mysql";

//Production Database Connection Details:

$remote_host = "us-cdbr-iron-east-05.cleardb.net";
$remote_username = "bd445f531625cd";
$remote_password = "b4c69f52";
$remote_databaseName = "heroku_3f2891efd6626a1";

//======================================================================
// DATABASE CONNECTION
// To use this connection on other php files add "include 'dbconnection.php';" to the top of the page.
//======================================================================
$possibleLocalhosts = array('127.0.0.1', "::1", "localhost"); // Any host name that isn't your production host.
$activeDatabaseConnection = 'DB Connection Not Set';
$collectMySQLConnection=null;
if(in_array($_SERVER['REMOTE_ADDR'], $possibleLocalhosts)) // If our REMOTE_ADDR is in our possibleLocalhosts, it means we're running this code locally. Do this:
{
	// Open a connection with our local database
	$collectMySQLConnection = mysqli_connect($local_host, $local_username, $local_password, $local_databaseName);
	if (!$collectMySQLConnection) {
    die('Could not connect: ' . mysql_error());
}
	// Set our activeDatabaseConnection variable to help with debugging
	$activeDatabaseConnection = "Local DB";
}
else // If our REMOTE_ADDR wasn't a localhost, we must be working remotely, from our production environment.
{
	// Open a connection with our production database
	$collectMySQLConnection = mysqli_connect($remote_host, $remote_username, $remote_password, $remote_databaseName);
	// Set our activeDatabaseConnection variable to help with debugging
	$activeDatabaseConnection = "Remote DB";
}
//======================================================================
// DATABASE SCHEMA
//======================================================================
// Following the sample row below, this array should contain any database commands necessary for your database setup.
$dbSchema = array();

$dbSchema['Create User_Transaction Table'] =
"CREATE TABLE User_Transaction (
	ITEM_ID VARCHAR (225) NOT NULL ,
	DATE_ADDED TIMESTAMP,
	FIRST_NAME VARCHAR (225),
	LAST_NAME VARCHAR (225),
	RECIPIENT_NAME VARCHAR (225),
	EMAIL VARCHAR (225),
	PHONE VARCHAR (15),
	USER_ADDRESS VARCHAR (225),
	DEST_ADDRESS VARCHAR (225),
	WEIGHT VARCHAR(225),
	HEIGHT VARCHAR(225),
	WIDTH VARCHAR(225),
	PRIMARY KEY (ITEM_ID)
);";

$dbSchema['Create User_Profile Table'] =
"CREATE TABLE User_Profile (
	EMAIL VARCHAR (225) NOT NULL,
	FIRST_NAME VARCHAR (225),
	LAST_NAME VARCHAR (225),
	PHONE VARCHAR (15),
	USER_ADDRESS VARCHAR (225),
	PRIMARY KEY (EMAIL)
);";


$dbSchema['Insert into User_Transaction'] =
"INSERT INTO User_Transaction(ITEM_ID, DATE_ADDED, FIRST_NAME, LAST_NAME, RECIPIENT_NAME, EMAIL, PHONE, USER_ADDRESS, DEST_ADDRESS, WEIGHT, HEIGHT, WIDTH) VALUES
	('j2b4k235b23kb23k5b2k','2017-05-01','Ovi','Grig','CPoonPoon','o.grigorescu@hotmail.com','9055723422','21 McCurdy Road, Guelph, ON','444 TaShi road, Beijing, China','11.1234','12','11');";

$dbSchema['Insert into User_Profile'] =
"INSERT INTO User_Profile(EMAIL, FIRST_NAME, LAST_NAME, PHONE, USER_ADDRESS) VALUES
	('o.grigorescu@hotmail.com','Ovi','Grig','9055723422','21 McCurdy Road, Guelph, ON');";


/*
$dbSchema['Create Images Table'] =
"CREATE TABLE IMAGES (
	ITEM_ID VARCHAR (225) NOT NULL ,
	DATE_ADDED TIMESTAMP,
	PRIMARY KEY (ITEM_ID)
);";

$dbSchema['Create Weight Table'] =
"CREATE TABLE WEIGHT (
	ITEM_ID VARCHAR (225) NOT NULL ,
	WEIGHT VARCHAR(1000000),
	PRIMARY KEY (ITEM_ID)
);";

$dbSchema['Create Dimensions Table'] =
"CREATE TABLE DIMENSIONS (
	ITEM_ID VARCHAR (225) NOT NULL ,
	LENGTH VARCHAR(1000000),
	WIDTH VARCHAR(1000000),
	PRIMARY KEY (ITEM_ID)
);";

$dbSchema['Insert into Images'] =
"INSERT INTO IMAGES(ITEM_ID, DATE_ADDED) VALUES
	('000000','2017-05-01');";

$dbSchema['Insert into Weight'] =
	"INSERT INTO WEIGHT(ITEM_ID, WEIGHT) VALUES
		('000000','180');";

$dbSchema['Insert into Dimensions'] =
		"INSERT INTO DIMENSIONS(ITEM_ID, LENGTH, WIDTH) VALUES
				('000000','10','10');";

*/


//======================================================================
// DEPLOY/UPDATE/RESET DATABASE WIZARD
// To access the wizard, visit dbconnection.php?setup-db in your browser.
//======================================================================

if (isset($_GET['setup-db']))
{
?>
	<h1>Database Configuration Options (Active Database: <?php echo $activeDatabaseConnection ?>)</h1>
	<form method="GET" action="?setup-db">
	<button type="submit" name="wipeAndResetDB" value="wipeAndResetDB">Delete all Data & Re-Intilize with Schema</button>
	</form>

	<h2>Database Schema</h2>
	<table width="100%" border="1px" cellpadding="5" cellspacing="0">
		<tr>
			<td>Task</td>
			<td>SQL Code</td>
		</tr>
		<?php
		foreach ($dbSchema as $task => $sqlCode) {
			echo "<tr><td>" . $task . "</td><td><pre>" . $sqlCode . "</pre></td></tr>";
		}
		?>
	</table>
<?php
}

if (isset($_GET['wipeAndResetDB'])) // Only enter this if our URL contains a "wipeAndResetDB" parameter
{
	echo '<h1>Database Configuration Options (Active Database: ' . $activeDatabaseConnection . ')</h1>';

	// Wipe all tables in database (code modified from http://stackoverflow.com/a/3493398):
	$collectMySQLConnection->query('SET foreign_key_checks = 0');
	if ($result = $collectMySQLConnection->query("SHOW TABLES"))
	{
	    while($row = $result->fetch_array(MYSQLI_NUM))
	    {
	        $collectMySQLConnection->query('DROP TABLE IF EXISTS '.$row[0]);
	    }
	}
	$collectMySQLConnection->query('SET foreign_key_checks = 1');
	echo '</br>Successfully wiped/deleted/droped everything in database.</br>';

	// Execute each of the commands in the $dbSchema array.
	foreach ($dbSchema as $task => $sqlCode) {
		if (mysqli_query($collectMySQLConnection, $sqlCode)) {
			echo '</br>Success: ' . $task . '</br>';
		} else {
			echo '</br>Error: ' . $task . ' | ' . mysqli_error($collectMySQLConnection) . '</br>';
		}
	}

	echo '</br> All dbSchema tasks have been completed.';
}

?>
