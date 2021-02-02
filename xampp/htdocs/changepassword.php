<?php require_once "header.php"; ?> 
<?php checkAccess('#index.php#adminLogin.php'); ?>  
<?php

function show_changepassword_form($forcePasswordChange){
	echo '<div class="panel panel-default"><div class="panel-heading">'.($forcePasswordChange?'OBOWIĄZKOWA ':'').'ZMIANA HASŁA</div><div class="panel-body">
	  <form class="form-horizontal" action="./changepassword.php" method="post">
	  <input type="hidden" value="'.$_SESSION['username'].'" name="username">
	  <div class="form-group">  
		<label class="control-label col-sm-2" for="oldpassword">HASŁO:</label>
		<div class="col-sm-10">
		<input type="password" class="form-control" id="oldpassword" maxlength="15" placeholder="minimum 8 znaków: duże, małe litery, cyfry, znaki specjalne" name="oldpassword">
		</div>  
	  </div>
	  <div class="form-group">
		<label class="control-label col-sm-2" for="password">NOWE HASŁO:</label>
		<div class="col-sm-10">
		<input type="password" class="form-control" id="password" maxlength="15" placeholder="minimum 8 znaków: duże, małe litery, cyfry, znaki specjalne" name="password">
		</div>  
	  </div>
	  <div class="form-group">
		<label class="control-label col-sm-2" for="password2">POWTÓRZ NOWE HASŁO:</label>
		<div class="col-sm-10">
		<input type="password" class="form-control" id="password2" maxlength="15" placeholder="minimum 8 znaków: duże, małe litery, cyfry, znaki specjalne" name="password2">
		</div>  	
	  </div>
	  <br>
	  <div class="form-group">
		<div class="control-label col-sm-2" ></div>
		<div class="col-sm-10">  
		<input class="btn btn-default" value="ANULUJ" onclick="self.location.href=(&#39;./logout.php&#39;)" type="button">
		<input class="btn btn-success" name="change"  type="submit" value="ZMIANA HASŁA">
		</div>
	  </div>
	</form></div></div>
	';
}

function changePassword($username,$currentpassword,$newpassword,$newpassword2){
	global $seed, $conn;
    if (!valid_username($username) || !user_exists($username) || !valid_password($newpassword) || ($newpassword != $newpassword2) || ($newpassword == $currentpassword)) {
        return false;
    }
    // we get the current password from the database
	$stmt = $conn->prepare("SELECT password FROM login WHERE username = :username LIMIT 1");
	$stmt->execute(['username' => $username]);
	$pwd = $stmt->fetch()[0];
    if ($pwd != sha1($currentpassword.$seed)){
        return false;
    }
	$stmt = $conn->prepare("update login set password = :password, usosPassword = :usosPassword, PasswordExpireOn = :PasswordExpireOn  where username = :username");
	return $stmt->execute(['password' => sha1($newpassword.$seed), 'usosPassword' => md5($newpassword), 'PasswordExpireOn' => Date('Y:m:d', strtotime("+30 days")), 'username' => $username]);
}

$forcePasswordChange = $_SESSION['forcePasswordChange']=='True';
if (isset($_POST['change']))
{
	if (changePassword(
		  $_POST['username']
		, $_POST['oldpassword']
		, $_POST['password'],
		  $_POST['password2']))
	{
	  echo "<div class='alert alert-success'>Twoje hasło zostało zamienione</div><br/><a href='./index.php'>Powrót do menu</a>";
	} else
	{
	 echo "<div class='alert alert-warning'>Hasło wpisane niepoprawnie. Nowe hasło musi się różnić od poprzedniego, musi mieć minimum 8 znaków, duże i małe litery i znaki specjalne. Spróbuj jeszcze raz</div>";
	 show_changepassword_form($forcePasswordChange);
	}

} else
{
	show_changepassword_form($forcePasswordChange);
}

require_once "footer.php";
?>