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
?>

<form id="refreshPage" action="adminPhotoExport.php" method="POST">
  <input type="hidden" id="command" name='command' value="<to be set>"/>
</form>

<div class="row">

	<?php
		if (empty($_POST['command'])) {
			$leftCnt = $conn->query("SELECT count(1) from zdjecia where revision_comments='Zaakceptowane' and completion_date='0000-00-00 00:00:00' and pesel in (select pesel from kwalifikacje where komunikat like 'przyjęty%')")->fetch()[0];
		}	
	?>
	<div class="panel panel-default" <?php if (!empty($_POST['command']) || $leftCnt==0) { echo ' style="display: none;" '; }  ?> >
			  <div class="panel-heading">EKSPORT ZATWIERDZONYCH ZDJĘĆ<p>Liczba zdjęć do eksportu: <?php echo $leftCnt;?></p></div>
			  <div class="panel-body">
				<button type="button" class="btn btn-success glyphicon glyphicon-ok" onclick="document.getElementById('command').value='COMMAND_CONTINUE'; document.getElementById('refreshPage').submit();"> Kontynuuj</button>		
				<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Anuluj</button>						
			  </div>
	</div>	
	
	<div <?php if (!empty($_POST['command']) || $leftCnt!=0) { echo ' style="display: none;" '; } ?> >
		<div class="alert alert-danger" role="alert">
			<strong>Och!</strong> Nie znaleziono nowych, zatwierdzonych zdjęć do eksportu.
		</div>	
		<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
		<button type="button" class="btn btn-default glyphicon glyphicon-ok" onclick="document.getElementById('command').value='COMMAND_REPROCESS'; document.getElementById('refreshPage').submit();"> Eksportuj ponownie wszystkie</button>
	 </div>

	<?php
		if ($_POST['command']=='COMMAND_CONTINUE') {
			$data_godz=date("Y-m-d H:i:s");
			$folderName = str_replace(':','_',$data_godz);
			$folderName = str_replace(' ','_',$folderName);
			if (!mkdir('D:/xampp2/htdocs_data/'.$folderName, 0700, true)) {
				 echo '<div class="alert alert-danger" role="alert">
						  <strong>Och!</strong> Nie udało się utworzyć folderu '.$folderName.' Zgłoś problem administratorowi systemu
						</div>';
			}
			//--------------------------- copying ------------------------------------------------
			
			$result = "
			SELECT pesel
			FROM zdjecia
			where revision_comments='Zaakceptowane' and completion_date='0000-00-00 00:00:00' and pesel in (select pesel from kwalifikacje where komunikat like 'przyjęty%')";
			$stmt = $conn->prepare($result);
			try{ $stmt->execute(); }
				catch(PDOException $e){ die('An error occured: '.$e); };
			$arr_A = $stmt->fetchAll();

			$myFileName = 'D:/xampp2/htdocs_data/'.$folderName.'/'.'copyFiles.bat';
			$myfile =fopen($myFileName,"w") or die("Unable to open file!");			
			for ($i = 0; $i <= count($arr_A)-1; $i++) {
				$pathFrom = 'D:/xampp2/htdocs_data/' .$arr_A[$i][pesel]. '.jpg';
				$pathTo = 'D:/xampp2/htdocs_data/'.$folderName.'/'.$arr_A[$i][pesel]. '.jpg';
				$pathFrom = str_replace('/','\\',$pathFrom);
				$pathTo = str_replace('/','\\',$pathTo);

				$format = 'copy %s %s '. PHP_EOL;
				fwrite($myfile, sprintf($format, $pathFrom, $pathTo));
				//if (!copy($pathFrom, $pathTo)) {
				//	echo "Nie powiodło się skopiowanie pliku $pathFrom...<br/>";
				//}
			}			
			fclose($myfile);
			
			//------------- mark as completed ------------------
			$query = "
			   UPDATE zdjecia
				  SET completion_date = '".$data_godz."'
			    WHERE revision_comments='Zaakceptowane' and completion_date='0000-00-00 00:00:00' and pesel in (select pesel from kwalifikacje where komunikat like 'przyjęty%')";
			$stmt = $conn->prepare($query);
			try{ $stmt->execute(); }
				catch(PDOException $e){ die('An error occured: '.$e); };
			
			//running the process asynchronizally
			pclose(popen("start /B ". $myFileName, "r"));
		}	
	?>
	<div class="panel panel-default" <?php if ($_POST['command']=='COMMAND_CONTINUE') {} else { echo ' style="display: none;" '; }  ?> >
			  <div class="panel-heading">ZROBIONE</div>
			  <div class="panel-body">
				<p>Został utworzony folder: <?php echo $folderName;?></p>
				<p>Zdjęcia są właśnie kopiowane do tego folderu.</p>
				<p>Odczekaj kilka minut by mieć pewność, że wszystkie zdjęcia zostały skopiowane.</p>
				<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>						
			  </div>
	</div>	

	<?php
		if ($_POST['command']=='COMMAND_REPROCESS') {
			//------------- mark all as uncompleted ------------------
			$query = "
			   UPDATE zdjecia
				  SET completion_date = '0000-00-00 00:00:00'";
			$stmt = $conn->prepare($query);
			try{ $stmt->execute(); }
				catch(PDOException $e){ die('An error occured: '.$e); };
		}

	?>
	<div class="panel panel-default" <?php if ($_POST['command']=='COMMAND_REPROCESS') {} else { echo ' style="display: none;" '; }  ?> >
			  <div class="panel-heading">Ponowne eksportowanie wszystkich zdjęć</div>
			  <div class="panel-body">
				<p>Informacja na temat wcześniejszych eksportów zdjęć została usunięta, możesz teraz ponownie wyeksportować wszystkie zdjęcia!</p>
				<button type="button" class="btn btn-success glyphicon glyphicon-ok" onclick="document.getElementById('command').value='COMMAND_CONTINUE'; document.getElementById('refreshPage').submit();"> Kontynuuj</button>		
			  </div>
	</div>	
	
	
</div>

<?php require_once "footer.php"; ?>