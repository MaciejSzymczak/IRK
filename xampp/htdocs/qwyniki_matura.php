<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php

	$username=$_SESSION['username'];
	$aspesel = $conn->query("SELECT Pesel FROM kandydat_dane_osobowe WHERE username = '$username'")->fetch()[0];

	// wm_old.php   wm_newF.php   wm_newS.php
	// 1-stara; 2-nowa; 3-poza RP i IB
	// sprawdzanie czy jest rodzaj matury i rok ukończenia


$stmt = $conn->prepare("SELECT ID_kandydata,ID_rodz_matury,Rok_Ukonczenia_Szkoly FROM kandydat_dane_osobowe WHERE username=:username");
try{ 
	$stmt->execute(['username' => $username]);
} catch(PDOException $e){ 
	die("Błąd: ".$e); 
};
if ($stmt->rowCount()) {
	$select = $stmt->fetch();
	$asid_k = $select['ID_kandydata'];
	$asid_rm = $select['ID_rodz_matury'];
} else {
	$asid_k = 'BRAK id kandydata';
	$asid_rm = 'BRAK rodzaju matury';
}

// ----------------------- Nie podano rodzaju matury ----------------------------
if (($asid_k=='BRAK id kandydata') || ($asid_rm=='BRAK rodzaju matury')) {
	 echo '<div class="alert alert-info" role="alert">
			  Przed wprowadzeniem wyników ze świadectwa podaj rodzaj matury w PODANIU-ANKIECIE.
			</div>';
	 echo '<p align="center"><button type="button" class="btn btn-success btn-lg" onclick="self.location.href=(\'./index.php\');"> Powrót</button></p>';
	 require_once "footer.php";
	 exit();
}

// ----------------------- Poza RP ----------------------------
if (($asid_rm=='3') || ($asid_rm=='4')) {
	 echo '<div class="alert alert-info" role="alert">
			  Legitymujesz się świadectwem dojrzałości IB lub POZA RP. 
			  Musisz je dostarczyć do uczelnianej komisji rekrutacyjnej, która dokona naliczenia punktów rankingowych
			</div>';	
	 echo '<p align="center"><button type="button" class="btn btn-success btn-lg" onclick="self.location.href=(\'./index.php\');"> Powrót</button></p>';
	 require_once "footer.php";
	 exit();
}


$olypmics = $conn->query("SELECT Id_Kandydata FROM kandydat_olimpiady WHERE username = '$username';")->rowCount() or $olypmics = "no_data";
$ssCert = $conn->query("SELECT ID_kandydata FROM kandydat_wyniki_maturalne WHERE username = '$username';")->rowCount() or $ssCert = "no_data";

$internalErrorFlag='Error'; 
if ((($olypmics=='no_data') and ($ssCert=='no_data')) 
	|| (($olypmics<>'no_data') and ($ssCert<>'no_data'))) $internalErrorFlag='OK';

if ($internalErrorFlag=='Error'){
	 echo '<div class="alert alert-danger" role="alert">
			  <strong>Och!</strong>Nie zapisano olimpiad i wyników do obu tabel jednocześnie. W jednej jest rekord w drugiej nie. 1:'.$olypmics.' 2:'.$ssCert.'
			</div>';
	 require_once "footer.php";
	 exit();
} 

$InsertUpdateFlag='';
if ($ssCert=='no_data') $InsertUpdateFlag='Insert';
if ($ssCert<>'no_data') $InsertUpdateFlag='Update';

if ($asid_rm =='2') include'wm_new.php';
if ($asid_rm =='1') include "wm_old.php";

?>

<?php require_once "footer.php"; ?>
