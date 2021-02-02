<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php
$username=$_SESSION['username'];
$isAdmin = $conn->query("SELECT isAdmin FROM login WHERE username='$username'")->fetch()[0];

if ($isAdmin!='+') {
	 echo '<div class="alert alert-danger" role="alert">
			  <strong>Och!</strong> Ten formularz jest dostępny tylko dla Administratora.
			</div>';
	 require_once "footer.php";
	 exit();
}

$DBBackupInProgress = file_exists('D:/xampp2/htdocs_internal/tmp/DBBackupInProgress.txt');
$ApacheCleanInProgress = file_exists('D:/xampp2/htdocs_internal/tmp/ApacheCleanInProgress.txt');
$DBCleanUpInProgress  = file_exists('D:/xampp2/htdocs_internal/tmp/DBCleanUpInProgress.txt');
?>

<form id="refreshPage" action="adminDB.php" method="POST">
  <input type="hidden" id="command" name='command' value="<to be set>"/>
</form>

<div class="row">

	<div class="panel panel-default" <?php if (empty($_POST['command']) && $DBBackupInProgress=='' && $ApacheCleanInProgress=='' && $DBCleanUpInProgress=='') {} else { echo ' style="display: none;" '; }  ?> >
			  <div class="panel-heading"><h3>Administracja bazą danych</h3></div>
			  
			
			<div class="panel-body">
				<div>
					<div class="alert alert-info">
						<h4>Kopia zapasowa</h4>Tworzy kopie zapasową bazy danych IRK: Dane + baza danych zdjęć. Pamiętaj aby kopię zapasową przechowywać na innym sewerze. Kopia zawiera wrażliwe dane personalne i musi być przechowywana zgodnie z procedurami RODO.
					</div>			
					<div class="alert alert-danger">
					<h4>Skasuj wszystko</h4> <strong>Strefa niezbezpieczna!</strong> Usuwa wszystkie dane z bazy danych IRK. Używaj tej funkcji po zakończeniu procesu rekrutacji. Przed usunięciem danych zaleca się uruchomienie funkcji kopia zapasowa.
					</div>
					<div class="alert alert-danger">
					<h4>(Opcjonalnie) Co jeszcze mogę zrobić?</h4> <strong>Strefa niezbezpieczna!</strong> Możesz usunąć także systemowe logi (pliki dziennika) serwera. Z logów serwera korzysta się nigdy, lub bardzo rzadko, jednak mogą one być pomocne w przypadku stwierdzenia włamania na serwer. Skasowanie logów serwera wymaga wykonania restartu serwera, dlatego czynnność ta może zostać wykonana tylko przez personel techniczny. Logi można usunąć za pomocą sktyptu D:\xampp2\htdocs_internal\adminApacheClean.bat
					</div>
				</div>
			  
			    <div class="btn-group btn-group-justified">
					<div class="btn-group">
						<button type="button" class="btn btn-success glyphicon glyphicon-floppy-save" onclick="document.getElementById('command').value='COMMAND_DBBACKUP'; document.getElementById('refreshPage').submit();"> Kopia zapasowa</button>		
					</div>
					<div class="btn-group">
					  <button type="button" class="btn btn-danger glyphicon glyphicon-remove" onclick="document.getElementById('command').value='COMMAND_CLEANUP'; document.getElementById('refreshPage').submit();"> Skasuj wszystko</button>		
					</div>
					<!--div class="btn-group">
					  <button type="button" class="btn btn-danger glyphicon glyphicon-remove" onclick="document.getElementById('command').value='COMMAND_APACHE'; document.getElementById('refreshPage').submit();"> Skasuj logi Apache</button>		
					</div-->
					<div class="btn-group">
					  <button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>						
					</div>
				</div>
			</div>	
	</div>

	<?php
		if ($_POST['command']=='COMMAND_DBBACKUP') {
			$myFileName = 'D:\xampp2\htdocs_internal\adminDBBackup.bat';
			pclose(popen("start /B ". $myFileName, "r"));
		}	
		if ($_POST['command']=='COMMAND_CLEANUP') {
			$myFileName = 'D:\xampp2\htdocs_internal\adminDBCleanUp.bat';
			pclose(popen("start /B ". $myFileName, "r"));
		}	
		if ($_POST['command']=='COMMAND_APACHE') {
			$myFileName = 'D:\xampp2\htdocs_internal\adminApacheClean.bat';
			pclose(popen("start /B ". $myFileName, "r"));
		}	
	?>
	<div class="panel panel-default" <?php if ($_POST['command']=='COMMAND_DBBACKUP' || $DBBackupInProgress=='1') {} else { echo ' style="display: none;" '; }  ?> >
			  <div class="panel-heading">Kopia bezpieczeństwa jest właśnie wykonywana</div>
			  <div class="panel-body">
				<p>Tworzony jest plik: <strong>D:\Backups\IRK_Backup_#dzisiejsza_data#.7z</strong></p>
				<p>Proszę zaczekać, aż zniknie ten komunikat. Jego zniknięcie oznacza, że czynność została pomyślnie wykonana.</p>
				<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>						
			  </div>
	</div>	
	<div class="panel panel-default" <?php if ($_POST['command']=='COMMAND_CLEANUP' || $DBCleanUpInProgress=='1') {} else { echo ' style="display: none;" '; }  ?> >
			  <div class="panel-heading">Kasowanie danych jest właśnie wykonywane</div>
			  <div class="panel-body">
				<p>Proszę zaczekać, aż zniknie ten komunikat. Jego zniknięcie oznacza, że czynność została pomyślnie wykonana.</p>
				<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>						
			  </div>
	</div>	
	<div class="panel panel-default" <?php if ($_POST['command']=='COMMAND_APACHE' || $ApacheCleanInProgress=='1') {} else { echo ' style="display: none;" '; }  ?> >
			  <div class="panel-heading">Logi systemowe Apache są właśnie usuwane</div>
			  <div class="panel-body">
				<p>Za chwilę pojawi się komunikat, że serwer jest niedostępny. Jest to całkowicie zgone z oczekiwaniami, ponieważ serwer musi zostać zrestarowany.</p>
				<p>Gdy tylko logi zostaną pomyślnie skasowane, aplikacja znowu będzie dostępna</p>
				<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>						
			  </div>
	</div>	
	
	<script type="text/javascript">
	  setTimeout(function () { self.location.href="./adminDB.php"; }, 10000);
    </script>	
	
	
</div>	
	

<?php require_once "footer.php"; ?>