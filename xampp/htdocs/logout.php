<?php
session_start();

require "db_connect.inc.php";

$stmt = $conn->prepare('INSERT INTO eventlog (User, Action) VALUES (:user,:act)');

if (isset($_SESSION['adminUserName'])) {
	$Action = 'Wylogowanie jako:'.$_SESSION['username'];
	$User   = $_SESSION['adminUserName'];
	
	try{ $stmt->execute(['user' => $User, 'act' => $Action]); } 
	catch(PDOException $e){ die('An error occured: '.$e); };

	$_SESSION['loginid'] = $_SESSION['adminLoginId'];
	$_SESSION['username'] = $_SESSION['adminUserName'];
	unset($_SESSION['alertMessage']);	
	unset($_SESSION['adminUserName']);
	unset($_SESSION['adminLoginId']);
	
	header('Location: index.php');
	
} else {
	$Action = 'Wylogowanie:'.$_SESSION['username'];
	$User   = $_SESSION['username'];
	
	try{ $stmt->execute(['user' => $User, 'act' => $Action]); } 
	catch(PDOException $e){ die('An error occured: '.$e); };

	unset($_SESSION['loginid']);
	unset($_SESSION['username']);
	session_destroy();
	header('Location: index.php');
}

?>