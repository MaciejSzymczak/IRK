<?php
##### User Functions #####

function user_exists($username) {
    global $conn;
	if (!valid_username($username)) {
        return false;
    }
	$stmt = $conn->prepare("SELECT loginid FROM login WHERE username = :username LIMIT 1");
	$stmt->execute(['username' => $username]);
	return ( $stmt->rowCount() > 0 );
}

function activationUserExists($uid, $actcode) {
    global $conn;
	$stmt = $conn->prepare("select activated from login where loginid = :uid and actcode = :actcode and activated = 0  limit 1");
	$stmt->execute(['uid' => $uid, 'actcode' => $actcode]);
	return ( $stmt->rowCount() > 0 );
}

function activateUserAndChangePassword($uid, $actcode,$newpassword,$newpassword2){
	global $seed, $conn;
    if (!activationUserExists($uid, $actcode)) {
        return 'Użytkownik nie istnieje';
    }
    if (! valid_password($newpassword) ) {
        return 'Hasło nie spełnia wymogów bezpieczeństwa';
    }
    if ($newpassword != $newpassword2){
        return 'Powtórz dwa razy to samo hasło';
    }
	$stmt = $conn->prepare("update login set password = :password, usosPassword = :usosPassword  where loginid = :uid and actcode = :actcode and activated = 0");
    if ($stmt->execute(['password' => sha1($newpassword.$seed), 'usosPassword' => md5($newpassword), 'uid' => $uid, 'actcode' => $actcode])) {
		if (!activateUser($uid, $actcode)) {
			return 'Aktywacja nie powiodła się';
		} else {
			return 'OK';
		}
    } else {
		return 'Błąd wewnętrzny';
	}
    return 'Błąd wewnętrzny 2';
}

function activateUser($uid, $actcode) {
    global $conn;
	$stmt = $conn->prepare("select activated from login where loginid = :uid and actcode = :actcode and activated = 0  limit 1");
	$stmt->execute(['uid' => $uid, 'actcode' => $actcode]);
    if ($stmt->rowCount() != 1) return false;
	$stmt = $conn->prepare("update login set activated = '1'  where loginid = :uid and actcode = :actcode");
	return $stmt->execute(['uid' => $uid, 'actcode' => $actcode]);
}

function registerNewUser($email, $stop_stud) {
    global $seed, $conn;
    if (!valid_username($email)) {
		return 'Nieprawidłowa nazwa użytkownika';
    }
    if (!valid_email($email)) {
		return 'Nieprawidłowy email';
    }
    if (user_exists($email)) {
		return 'Taki użytkownik już istnieje';
    }
	
	//dummy password. Real password will be created in next step
	$password = generate_code(10);
	
    $code = generate_code(20);
	$ip = getenv('REMOTE_ADDR'); $ip .= ' | '.$_SERVER['HTTP_USER_AGENT'];
    
	$stmt = $conn->prepare("insert into login (username,password,email,actcode,ip,usosPassword,stop_stud,PrivacyAgreement) value (:email, :password, :email, :actcode, :ip, :usosPassword, :stop_stud, CURDATE())");
	if ( $stmt->execute([	  'email' => $email
							, 'password' => sha1($password . $seed)
							, 'actcode' => $code
							, 'ip' => $ip
							, 'usosPassword' => md5($password)
							, 'stop_stud' => $stop_stud
						]) ) 
	{
		if (sendActivationEmail($conn->lastInsertId(), $email, $code)) {
			return 'OK';
        } else {
			return 'Błąd wewnętrzny: sendActivationEmail';
        }
    }
	return  'Błąd wewnętrzny: SQL';
}

function lostPassword($email) {
    global $seed, $conn;
    if (!valid_username($email) || !user_exists($email) || !valid_email($email)) {
        return false;
    }
	$stmt = $conn->prepare("select loginid from login where username = ? limit 1");
	$stmt->execute([$email]);
    if ($stmt->rowCount() != 1) return false;
    $newpass = generate_code(8);
	$stmt = $conn->prepare("update login set password = :password, usosPassword = :usosPassword where username = :username");
    if ($stmt->execute(['password' => sha1($newpass.$seed), 'usosPassword' => md5($newpass), 'username' => $email])) {
		return sendLostPasswordEmail($email, $newpass); 
    }
	return false;
}

function generateSecurityCode ($day) {
	// add x days to date
	$sendSecurityCodeOn=Date('y:m:d', strtotime("+".$day." days"));
	$securityCode = str_pad(rand(1,999999), 6, '0', STR_PAD_LEFT);
	//update current user
	//send email
}

?>