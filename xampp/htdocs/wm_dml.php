<?php
require_once "header.php";

// ----------------------- checking user permissions ----------------------------
if (!isLoggedIn() == true) {
	 echo '<div class="alert alert-danger" role="alert">
			  <strong>Och!</strong> Musisz sie zalogowac, by móc uzywac tej Aplikacji.
			</div>';
	 require_once "footer.php";
	 exit();
}

$username=$_SESSION['username'];

// ----------------------- $InsertUpdateFlag ----------------------------
$stmt = $conn->prepare("SELECT ID_kandydata FROM kandydat_wyniki_maturalne WHERE username = :username");
$stmt->execute(['username' => $username]);
$ssCert = ($stmt->rowCount()) ? $stmt->fetch()[0] : "no_data";

$InsertUpdateFlag='';
if ($ssCert=='no_data') $InsertUpdateFlag='Insert';
if ($ssCert<>'no_data') $InsertUpdateFlag='Update';

?>

<form id="myForm" action="<?php if ($InsertUpdateFlag == 'Insert') {echo 'wm_dml_insert.php';} else {echo 'wm_dml_update.php';}?>" method="post">
<?php
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    }
?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>

<?php require_once "footer.php"; ?>