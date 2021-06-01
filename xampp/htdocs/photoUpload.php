<?php require_once "header.php"; ?>
<?php checkAccess('#index.php#qform.php'); ?> 
<?php 
    if($_POST['command']=='COMMAND_DISPLAY_ERROR'){
		echo '<div class="alert alert-warning"><strong>Błąd! </strong>'.$_POST['errorMessage'].'</div>';
	}

	$username=$_SESSION['username'];
	$pesel = $conn->query("SELECT Pesel FROM kandydat_dane_osobowe WHERE username = '$username'")->fetch()[0];
	$isApprovedFlag = $conn->query("SELECT count(1) FROM zdjecia WHERE username = '$username' and revision_comments='Zaakceptowane'")->fetch()[0];
	
	
    if($_POST['command']=='COMMAND_UPLOAD_PICTURE'){
		$data_godz=date("Y-m-d H:i:s");

		$mysqlfiletype = $_FILES['userfile']['type'];
		$mysqlfilename = $_FILES['userfile']['name'];
		$filesize = $_FILES['userfile']['size'];

		$as_email = $conn->query("SELECT email FROM login WHERE username = '$username'")->fetch()[0];
		$as_pesel = $conn->query("SELECT pesel FROM zdjecia WHERE username = '$username'")->fetch()[0];
		//print $mysqlfiletype.' | '.$mysqlfilename.' | '.$filesize.' | '.$as_email.' | '.$pesel.' | '.$as_pesel.'<br>';


		if( is_uploaded_file( $_FILES['userfile']['tmp_name'] ) )
		{
		  $strUploadDir =  'D:/xampp2/htdocs_data/' .$pesel.'.jpg';
		  if( move_uploaded_file( $_FILES['userfile']['tmp_name'], $strUploadDir ) )
		  {
			echo '<div class="alert alert-success"><strong>Zdjęcie przesłano. </strong> Sprawdź, czy zdjęcie spełnia wymagania opisane <a target="_blank" href="https://obywatel.gov.pl/wyjazd-za-granice/zdjecie-do-dowodu-lub-paszportu">tutaj</a> a w razie potrzeby skadruj zdjęcie</div>';
			if ($as_pesel==$pesel)
			{
				//fconnection();
				$zapytanie = "UPDATE zdjecia
					SET revision_comments=null, revision_date=null, typ = :typ, nazwa = :nazwa, rozmiar = :rozmiar, email = :email, data_godz = :data_godz
					WHERE username = :username";
				$stmt = $conn->prepare($zapytanie);
				try{
					$stmt->execute(['username' => $username, 'typ' => $mysqlfiletype, 'nazwa' => $mysqlfilename, 'rozmiar' => $filesize, 'email' => $as_email, 'data_godz' => $data_godz]); 
				} catch(PDOException $e){ die('Błąd wykonania wysłania zdjęcia do bazy: '.$e); };
			}
			 else
			{
				//fconnection();
				$zapytanie="INSERT INTO zdjecia (username,Id,typ,nazwa,rozmiar,pesel,email,data_godz)
					VALUES (:username,'',:typ,:nazwa,:rozmiar,:pesel,:email,:data_godz)";
				$stmt = $conn->prepare($zapytanie);
				try{ 
					$stmt->execute(['username' => $username, 'typ' => $mysqlfiletype, 'nazwa' => $mysqlfilename, 'rozmiar' => $filesize, 'pesel' => $pesel, 'email' => $as_email, 'data_godz' => $data_godz]); 
				} catch(PDOException $e){ die('Błąd wykonania wysłania zdjęcia do bazy: '.$e); };
			}

		   //==

		  }
		  else
		  {
			echo '<div class="alert alert-error"><strong>Błąd!</strong>Nie powiodło się przesłanie zdjęcia na serwer IRK WAT!</div>';
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
	          <div class="panel-heading">PRZESŁANE ZDJĘCIE DO ELEKTRONICZNEJ <p>LEGITYMACJI STUDENCKIEJ (ELS)</p></div>
			  <div class="panel-body">

				<center>
					<?php
    			    //show picture
					$path = 'D:/xampp2/htdocs_data/' .$pesel. '.jpg';
					$disableCrop = '';
					if (file_exists ($path)) {
						$disableCrop = '';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$data = file_get_contents($path);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
						echo '<img style="height:633px; width:492px;" id="result-img" src="'.$base64.'">';										
					} else {
						$disableCrop = 'disabled';
						$data = file_get_contents('D:/xampp2/htdocs/example.png');
						$base64 = 'data:image/jpg;base64,' . base64_encode($data);
						echo '<img style="height:633px; width:492px;" id="result-img" src="'.$base64.'">';										
					}
					?>
				</center>		  

			  			   
			  </div>
	</div>	
  </div>

  <div class="col-sm-6">
	<div class="alert alert-success" <?php if ($isApprovedFlag==0) { echo ' style="display: none;" '; }  ?> role="alert">
		<p>Zdjęcie zostało już zaakceptowane. Przesyłanie i kadrowanie nie jest już dostępne.</p>
		<p></p>
		<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
	</div>
	<div class="panel panel-default" <?php if ($isApprovedFlag!=0) { echo ' style="display: none;" '; }  ?> >
	          <div class="panel-heading">WYMAGANIA NA ZDJĘCIE</div>
			  <div class="panel-body">
			   <p><a target="_blank" href="https://obywatel.gov.pl/wyjazd-za-granice/zdjecie-do-dowodu-lub-paszportu">Kliknij tutaj aby zobaczyć przykłady prawidłowych oraz nieprawidłowych zdjęć</a></p>
				<ul>
				  <li>Twarz powinna zajmować 2/3 powierzchni zdjęcia</li>
				  <li>Bez nakrycia głowy</li>
				  <li>Na jasnym tle</li>
				  <li>Zdjęcie wykonane w kolorze</li>
				  <li>Zachowanie równomiernego oświetlenia twarzy</li>
				  <li>Brak widocznych zagięć, stempli.</li>
				  
				  <br/>
				  <li>Zdjęcie w postaci elektronicznej w rozdzielczości co najmniej<strong> 300 dpi</strong></li>
				  <li>Maksymalny rozmiar pliku ze zdjęciem<strong> min.20KB max.2,5MB</strong></li>
				  <li>Wymagany jest format <strong>.jpg</strong>.</li>
				</ul>	

				<form id="formUploadFile" enctype="multipart/form-data" action="photoUpload.php" method="POST">
				  <br/>
				  <input type="hidden" name='command' value="COMMAND_UPLOAD_PICTURE"/>
				  <!--input type="hidden" name="MAX_FILE_SIZE" value="2621440" /-->
				  <input type="button" class="btn btn-success btn-lg" value="Prześlij plik jpg" onclick="document.getElementById('file').click();" />
				  <script>
				    function validateFileAndUpload () {
                        var fileUploader = document.getElementById('file');
                        var filePath = fileUploader.value;
						var extension = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();	
						if (fileUploader.files[0].size<20000) {
						  document.getElementById('errorMessage').value="Rozmiar zdjęcia nie może być mniejszy niż 20KB";
						  document.getElementById('displayError').submit();
						  return;
						}
						if (fileUploader.files[0].size>2621440) {
						  document.getElementById('errorMessage').value="Rozmiar zdjęcia nie może być większy niż 2.5MB";
						  document.getElementById('displayError').submit();
						  return;
						}
                        if (!"jpeg#jpg".includes(extension)) {
						  document.getElementById('errorMessage').value="Zdjęcie musi być w formacie .jpg";
						  document.getElementById('displayError').submit();
						  return;
						}				
   						document.getElementById('formUploadFile').submit();							
					}
				  </script>
				  <input id="file" name="userfile" style="display:none;" type="file" onchange="validateFileAndUpload();" />
				  <input type="button" class="btn btn-success btn-lg" value="Kadruj" onclick="document.getElementById('gotoPhotoCrop').submit();" <?php echo $disableCrop ?>/>
				  <!--input class="btn btn-success btn-lg" type="submit" style="display:none;" value="Wyślij"/-->
				  <input class="btn btn-info btn-lg" value="Powrót" onclick="self.location.href=('./index.php')" type="button"/>
				</form>

				<form id="gotoPhotoCrop" action="photoCrop.php" method="POST">
				  <input type="hidden" name='caller' value="photoUpload"/>
				  <input type="hidden" name='recordId' value="<?php echo $pesel; ?>"/> 
				</form>				

				<form id="displayError" action="photoUpload.php" method="POST">
				  <input type="hidden" name='command' value="COMMAND_DISPLAY_ERROR"/>
				  <input type="hidden" id="errorMessage" name='errorMessage' value=""/>
				</form>				
			  </div>
	</div>
  </div>  
  
</div>
	
<?php require_once "footer.php"; ?>
