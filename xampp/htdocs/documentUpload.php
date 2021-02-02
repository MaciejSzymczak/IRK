<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php
    if($_POST['command']=='COMMAND_DISPLAY_ERROR'){
		echo '<div class="alert alert-warning"><strong>Błąd! </strong>'.$_POST['errorMessage'].'</div>';
	}

	$username=$_SESSION['username'];
	$pesel = $conn->query("SELECT Pesel FROM kandydat_dane_osobowe WHERE username = '$username'")->fetch()[0];

	$isApprovedFlag = $conn->query("SELECT count(1) FROM documents WHERE username = '$username' and revision_comments='Zaakceptowane'")->fetch()[0];
	
    if($_POST['command']=='COMMAND_UPLOAD_PICTURE'){
		$data_godz=date("Y-m-d H:i:s");

		$mysqlfiletype = $_FILES['userfile']['type'];
		$mysqlfilename = $_FILES['userfile']['name'];
		$filesize = $_FILES['userfile']['size'];

		$as_email = $conn->query("SELECT email FROM login WHERE username = '$username'")->fetch()[0];
		$as_pesel = $conn->query("SELECT pesel FROM documents WHERE username = '$username'")->fetch()[0];
		//print $mysqlfiletype.' | '.$mysqlfilename.' | '.$filesize.' | '.$as_email.' | '.$pesel.' | '.$as_pesel.'<br>';


		if( is_uploaded_file( $_FILES['userfile']['tmp_name'] ) )
		{
		  $strUploadDir =  'D:/xampp2/htdocs_data/documents/' .$pesel.'.pdf';
		  if( move_uploaded_file( $_FILES['userfile']['tmp_name'], $strUploadDir ) )
		  {
			echo '<div class="alert alert-success"><strong>Plik przesłano. </strong>';
			if ($as_pesel==$pesel)
			{
				//fconnection();
				$zapytanie = "UPDATE documents
					SET revision_comments=null, revision_date=null, typ = :typ, nazwa = :nazwa, rozmiar = :rozmiar, email = :email, data_godz = :data_godz
					WHERE username = :username";
				$stmt = $conn->prepare($zapytanie);
				try{
					$stmt->execute(['username' => $username, 'typ' => $mysqlfiletype, 'nazwa' => $mysqlfilename, 'rozmiar' => $filesize, 'email' => $as_email, 'data_godz' => $data_godz]); 
				} catch(PDOException $e){ die('Błąd wykonania wysłania pliku: '.$e); };
			}
			 else
			{
				$zapytanie="INSERT INTO documents (username,Id,typ,nazwa,rozmiar,pesel,email,data_godz)
					VALUES (:username,'',:typ,:nazwa,:rozmiar,:pesel,:email,:data_godz)";
				$stmt = $conn->prepare($zapytanie);
				try{ 
					$stmt->execute(['username' => $username, 'typ' => $mysqlfiletype, 'nazwa' => $mysqlfilename, 'rozmiar' => $filesize, 'pesel' => $pesel, 'email' => $as_email, 'data_godz' => $data_godz]); 
				} catch(PDOException $e){ die('Błąd wykonania wysłania pliku: '.$e); };
			}
		  }
		  else
		  {
			echo '<div class="alert alert-error"><strong>Błąd!</strong>Nie powiodło się przesłanie pliku na serwer IRK WAT!</div>';
		  }
		}
		else
		{
		  echo '<div class="alert alert-error"><strong>Błąd!</strong>Wystąpił błąd podczas wysyłania pliku na serwer IRK WAT!';
		  echo 'Nazwa pliku:' . $_FILES[ 'userfile' ][ 'tmp_name' ] . "type" .$mysqlfiletype. "name" .$mysqlfilename. "size" .$filesize ;
		  echo '</div>';
		  
		}
	}
?>

<div class="row">
  
  <div class="col-sm-6">
	<div class="panel panel-default">
	          <div class="panel-heading">PRZESŁANE ŚWIADECTWO DOJRZAŁOŚCI</div>
			  <div class="panel-body">

				<center>
					<?php
    			    //show document
					$path = 'D:/xampp2/htdocs_data/documents/' .$pesel. '.pdf';
					if (file_exists ($path)) {
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						//$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
						//echo '<img style="height:633; width:492;" id="result-img" src="'.$base64.'">';										
						$base64 = 'data:application/pdf;base64,' . base64_encode($data);						
						echo '<object data="'.$base64.'" type="application/pdf"  width="492" height="633"></object>';
					} else {
						$data = file_get_contents('D:/xampp2/htdocs/documents/exampleDocument.pdf');
						//$base64 = 'data:image/pdf;base64,' . base64_encode($data);
						//echo '<img style="height:633; width:492;" id="result-img" src="'.$base64.'">';
						$base64 = 'data:application/pdf;base64,' . base64_encode($data);						
						echo '<object data="'.$base64.'" type="application/pdf"  width="492" height="633"></object>';
					}
					?>
				</center>		  

			  			   
			  </div>
	</div>	
  </div>

  <div class="col-sm-6">
	<div class="alert alert-success" <?php if ($isApprovedFlag==0) { echo ' style="display: none;" '; }  ?> role="alert">
		<p>Plik został już zaakceptowany. Przesyłanie nie jest już dostępne.</p>
		<p></p>
		<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
	</div>
	<div class="panel panel-default" <?php if ($isApprovedFlag!=0) { echo ' style="display: none;" '; }  ?> >
	          <div class="panel-heading">WYMAGANIA NA SKAN ŚWIADECTWA DOJRZAŁOŚCI</div>
			  <div class="panel-body">
				<ul>
				  <li>Ma być jeden plik (jedno lub wielostronicowy) w formacie pdf.</li>
				  <li>Plik musi być wyraźny</li>
				</ul>	

				<form id="formUploadFile" enctype="multipart/form-data" action="documentUpload.php" method="POST">
				  <br/>
				  <input type="hidden" name='command' value="COMMAND_UPLOAD_PICTURE"/>
				  <!--input type="hidden" name="MAX_FILE_SIZE" value="2621440" /-->
				  <input type="button" class="btn btn-success btn-lg" value="Prześlij plik pdf" onclick="document.getElementById('file').click();" />
				  <script>
				    function validateFileAndUpload () {
                        var fileUploader = document.getElementById('file');
                        var filePath = fileUploader.value;
						var extension = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();	
						//if (fileUploader.files[0].size<20000) {
						//  document.getElementById('errorMessage').value="Rozmiar skanu nie może być mniejszy niż 20KB";
						//  document.getElementById('displayError').submit();
						//  return;
						//}
						if (fileUploader.files[0].size>2621440*10) {
						  document.getElementById('errorMessage').value="Rozmiar skanu nie może być większy niż 25MB";
						  document.getElementById('displayError').submit();
						  return;
						}
                        if (!"pdf".includes(extension)) {
						  document.getElementById('errorMessage').value="Skan musi być w formacie .pdf";
						  document.getElementById('displayError').submit();
						  return;
						}				
   						document.getElementById('formUploadFile').submit();							
					}
				  </script>
				  <input id="file" name="userfile" style="display:none;" type="file" onchange="validateFileAndUpload();" />
				  <!--input class="btn btn-success btn-lg" type="submit" style="display:none;" value="Wyślij"/-->
				  <input class="btn btn-info btn-lg" value="Powrót" onclick="self.location.href=('./index.php')" type="button"/>
				</form>			

				<form id="displayError" action="documentUpload.php" method="POST">
				  <input type="hidden" name='command' value="COMMAND_DISPLAY_ERROR"/>
				  <input type="hidden" id="errorMessage" name='errorMessage' value=""/>
				</form>				
			  </div>
	</div>
  </div>  
  
</div>
	
<?php require_once "footer.php"; ?>
