<?php

function isLoggedIn()
{
    if (isset($_SESSION['loginid']) && isset($_SESSION['username']))
    {
        return true;
    } else
    {
        return false;
    }
    return false;
}

 function customLog($logMessage) {
	 error_log(date("Y-m-d H:i:s").' '.$_SESSION['username'].' '.$logMessage . PHP_EOL, 3, "D:/xampp2/php/logs/php_error_log/error.log");
 } 

 function checkAccess ($pagesFrom) {
	 
	customLog("checkAccess.start. pagesFrom:".$pagesFrom); 
	customLog('checkAccess HTTP_REFERER='.$_SERVER['HTTP_REFERER']); 
	customLog('checkAccess PHP_SELF='.$_SERVER['PHP_SELF']); 
	 
    $loginPage = 'index.php';
	//session must be initiated by login window
	if (!isLoggedIn()) {
		header('Location: '.$loginPage);
		customLog("checkAccess.exit1"); 
		exit();
	}
	
	if (!isset($_SERVER['HTTP_REFERER'])) {
		header('Location: '.$loginPage);
		customLog("checkAccess.exit2"); 
		exit();		
	}

	if (!empty($pagesFrom)) {
		$referer = basename($_SERVER['HTTP_REFERER']);

		if (strpos($pagesFrom.'#'.basename($_SERVER['PHP_SELF']), $referer) === false ) {
			//go to login page
			header('Location: '.$loginPage);
			customLog("checkAccess.exit3");
			exit();
		}
	}
	customLog("checkAccess.access granted"); 
}

function adminLoginAs($loginid, $username, $fname, $lname, $alertMessage)
{
	global $conn;	
	if ($alertMessage!='') {
		$_SESSION['adminUserName'] = $_SESSION['username'];
		$_SESSION['adminLoginId'] = $_SESSION['loginid'];
		$Action = 'Logowanie jako: '.$fname.' '.$lname.' '.$username;
		$User   = $_SESSION['username'];
		$_SESSION['alertMessage'] = $alertMessage;	
	} else {
		$Action = 'Logowanie: '.$username;
		$User   = $username;
		unset($_SESSION['alertMessage']);
	}	
	
	$stmt = $conn->prepare('INSERT INTO eventlog (User, Action) VALUES (:user,:act)');
	try{ $stmt->execute(['user' => $User, 'act' => $Action]); } 
	catch(PDOException $e){ die('An error occured: '.$e); };

	$_SESSION['loginid'] = $loginid;
	$_SESSION['username'] = $username;
}


function checkLogin($u, $p)
{
	global $conn, $seed;
		if (!valid_username($u) ) {
			return 'false:user not valid';
		}
		if (!user_exists($u)) {
			return 'false: user does not exist';
		}
		$query = sprintf("
			SELECT loginid
			FROM login
			WHERE
			username = :username AND password = :password
			AND disabled = 0 AND activated = 1;");
		$stmt = $conn->prepare($query);
		$stmt->execute(['username' => $u, 'password' => sha1($p . $seed)]);
		$result = $stmt->fetchAll();
		if (count($result) != 1)
		{
			//return 'false: sql failed for'.mysql_real_escape_string($u).':'.mysql_real_escape_string(sha1($p . $seed)).':'.$p;
			return 'false: invalid password?';
		} else
		{
			$row = $result[0];
			adminLoginAs ($row['loginid'], $u, '','',''	);
			return 'true';
		}
		return 'false5';
}


?>