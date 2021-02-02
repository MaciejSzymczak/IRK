<?php
include "D:/xampp2/htdocs_secret/_db_settings.php";
$conn = null;

function opendb($mysql_db = "irk") {	// irk - default DB
	global $conn;
	$mysql_server = 
	$mysql_user = 
	$mysql_pass = null;
	get_db_access($mysql_server, $mysql_user, $mysql_pass);
	//@mysql_connect($mysql_server, $mysql_admin, $mysql_pass) or die('Brak połączenia z serwerem MySQL.');
	//@mysql_select_db($mysql_db) or die('Błąd wyboru bazy danych.');

	try {
		$conn = new PDO("mysql:host=$mysql_server;dbname=$mysql_db", $mysql_user, $mysql_pass);
		//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT ); // Default error mode
		//$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); // Will issue a standard PHP warning
	} catch(PDOException $e) {
		//echo 'ERROR: ' . $e->getMessage();
		$conn = null; 
		die('Błąd: Połączenie z bazą danych IRK nie powiodło się. Spróbuj jeszcze raz później lub przekaż informację administratorowi systemu.');
	}
}

opendb();

?>