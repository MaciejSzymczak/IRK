<?php
require_once "header.php";

 $showChangePassword =$HIDE;
 $showError = $HIDE;

 if (!isset($_POST['change'])) {
	$uid = (int)htmlentities(strip_tags($_GET['uid']));
	$actcode = htmlentities(strip_tags($_GET['actcode']));

	if (activationUserExists($uid, $actcode) == true) {
		$showChangePassword =$SHOW;
	} else {
		$showError = $SHOW;
	}
 } else {
	$uid = htmlentities(strip_tags($_POST['uid']));
	$actcode = htmlentities(strip_tags($_POST['actcode']));
	$returnMessage = activateUserAndChangePassword(
		  $uid
		, $actcode
		, $_POST['password']
		, $_POST['password2'] );
	if ( $returnMessage=='OK' ) {
		//redirection to RODO
		echo "<div class='alert alert-success'>Zrobione. Teraz możesz się zalogować.</div><br/><a href='./logout.php'>Kliknij, aby przejść do strony logowania</a>";
	}
	else {
		echo "<div class='alert alert-warning'>".$returnMessage."</div>";
		$showChangePassword =$SHOW;
	}
 }

?>

<div class="panel panel-default"  <?php echo $showChangePassword; ?> >
	<div class="panel-heading">AKTYWACJA KONTA W IRK WAT. Wprowadź swoje hasło.</div>
	<div class="panel-body">
		 <form class="form-horizontal" action="./activate.php" method="post">
		  <input type="hidden" value="<?php echo $uid; ?>" name="uid">
		  <input type="hidden" value="<?php echo $actcode; ?>" name="actcode">
		  <div class="form-group">
			<label class="control-label col-sm-2" for="password">HASŁO:</label>
			<div class="col-sm-10">
			<input type="password" class="form-control" id="password" maxlength="15" placeholder="minimum 8 znaków: duże, małe litery, cyfry, znaki specjalne" name="password">
			</div>  
		  </div>
		  <div class="form-group">
			<label class="control-label col-sm-2" for="password2">POWTÓRZ HASŁO:</label>
			<div class="col-sm-10">
			<input type="password" class="form-control" id="password2" maxlength="15" placeholder="minimum 8 znaków: duże, małe litery, cyfry, znaki specjalne" name="password2">
			</div>  	
		  </div>
		  <div class="form-group">
			<div class="control-label col-sm-2" ></div>
			<div class="col-sm-10">  
			<input class="btn btn-default" value="ANULUJ" onclick="self.location.href=(&#39;./index.php&#39;)" type="button">
			<input class="btn btn-primary" name="change" type="submit" value="DALEJ">
			</div>
		  </div>
		</form>
	</div>
</div>

<div class="alert alert-warning"  <?php echo $showError; ?> >
    Błąd aktywacji. Proszę spróbować skopiować link aktywujący i wkleić go w pole adresu przeglądarki, aktywować konto ponownie lub skontaktować się z <a href="mailto:rekrutacja@wat.edu.pl">administratorem IRK WAT</a><br />
	Link do aktywacji może być użyty tylko jeden raz.
</div>

<?php
require_once "footer.php";
?>


