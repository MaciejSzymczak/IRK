<?php require_once "header.php"; ?> 
 
<?php 

if (isset($_POST['LoginAttempt'])) {
	$checkLoginMessage = checkLogin($_POST['username'], $_POST['password']);
	if (checkLogin($_POST['username'], $_POST['password'])=='true') {
		
		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp	
		
		$stmt = $conn->prepare("SELECT isAdmin FROM login WHERE username=:username");
		$stmt->execute(['username' => $_POST['username']]);
		$isAdmin = $stmt->fetch()[0];

		if ($isAdmin!='+') {
			 unset($_SESSION['loginid']);
			 unset($_SESSION['username']);
			 session_destroy();		
		}
		
		echo '<script> self.location.href=("./index.php"); </script>';
	} else {
		echo '<div class="alert alert-warning">
				<strong>Nieudane logowanie!</strong> Sprawdź nazwę użytkownika i hasło i spróbuj ponownie. ('.$checkLoginMessage.')
			 </div>';
	}	
}

?> 

 <div class="panel panel-default">
	<div class="panel-heading">LOGOWANIE DLA ADMINISTRATORA SYSTEMU</div>
	<div class="panel-body">
		<form class="form-horizontal" name="login-form" id="login-form" method="post" action="./adminLogin.php">
		  <div class="form-group">
			<label title="Username" class="control-label col-sm-2" for="username">LOGIN:</label>
			<div class="col-sm-10">
			<input tabindex="1" accesskey="u"  type="text" class="form-control" maxlength="100" id="username" name="username">
			</div>
		  </div>
		  <div class="form-group">
			<label title="Password" class="control-label col-sm-2" for="password">HASŁO:</label>
			<div class="col-sm-10">
			<input tabindex="2" accesskey="p" type="password" class="form-control" id="password" maxlength="100" name="password">
			</div>
		  </div>
		  <div class="form-group">
			<label title="" class="control-label col-sm-2" for=""></label>
			<div class="col-sm-10">
			<input tabindex="3" accesskey="l" type="submit" id="cmdlogin" name="cmdlogin" class="btn btn-primary btn-lg" value="Zaloguj się"/>
			<a href="./lostpassword.php" class="btn btn-link" role="button" title="Kliknij w ten link aby otrzymać emailem nowe hasło">ODZYSKIWANIE HASŁA</a>
			</div>
		  </div>
		  <input type="hidden" name="LoginAttempt" value="Yes"/>
		</form>
	</div>
</div>
 
<?php require_once "footer.php"; ?>