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

<!----------------------- page ---------------------------->
<form id="refreshPage" action="adminMassActivation.php" method="POST">
  <input type="hidden" id="command" name='command' value="<to be set>"/>
</form>

<div class="row">

	<?php	
		$leftCnt = $conn->query("SELECT count(1) FROM login WHERE password='0' and activated=0 and actcode='0' and dok=0 and email != ''")->fetch()[0];
		if ($_POST['command']=='COMMAND_CONTINUE') {
			$styleNotFound = $HIDE;
			$styleFound    = $HIDE; 
			$listRecords   = $SHOW;
			$actionPerformed=$SHOW; 
		} else {
			if ($leftCnt==0) {
				$styleNotFound  =$SHOW; 
				$styleFound     =$HIDE; 
				$listRecords    =$HIDE; 
				$actionPerformed=$HIDE; 
			} else {
				$styleNotFound  =$HIDE; 
				$styleFound     =$SHOW; 
				$listRecords    =$SHOW; 
				$actionPerformed=$HIDE; 
			}			
		}
	?>

	<div <?php echo $styleNotFound; ?> >
		<div class="alert alert-info" role="alert">
			<strong>Och!</strong> Nie znaleziono kont do aktywowania (tabela login gdzie hasło=0 i aktywowano=0 i actcode=0 i dok=0 i email nie pusty). Użyj Aplikacji Access w celu wygenerowania kont.
		</div>	
		<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
	 </div>

	 <div class="panel panel-default" <?php echo $styleFound; ?> >
		<div class="panel-heading">MASOWA AKTYWACJA KONT UŻYTKOWNIKÓW<p>Liczba kont do aktywowania: <?php echo $leftCnt;?></p></div>
		<div class="panel-body">
			<p>Aktywowanych jest każdorazowo max. 10 kont użytkowników. Aby aktywować więcej, niż 10 kont użytkowników, należy powtórzyć czynność wielokrotnie.</p>
			<button type="button" class="btn btn-success glyphicon glyphicon-ok" onclick="document.getElementById('command').value='COMMAND_CONTINUE'; document.getElementById('refreshPage').submit();"> Kontynuuj</button>		
			<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Anuluj</button>						
		</div>
	</div>	

	 <div class="panel panel-default" <?php echo $actionPerformed; ?> >
		<div class="panel-heading">AKTYWOWANO KONTA UŻYTKOWNIKÓW</div>
		<div class="panel-body">
			<p>Linki aktywacyjne zostały wysłane do użytkowników.</p>
			<p>Pamiętaj, że IRK nie prosi o akceptację RODO, akceptacja musi zostać wykonana poza systemem.</p>
			<p>Aktywowanych jest każdorazowo max. 10 kont użytkowników. Aby aktywować więcej, niż 10 kont użytkowników, należy powtórzyć czynność wielokrotnie.</p>
			<button type="button" class="btn btn-success glyphicon glyphicon-ok" onclick="self.location.href=('./adminMassActivation.php');"> OK</button>		
		</div>
	</div>	
</div>

<!--  LIST RECORDS  -->
<div class="row" <?php echo $listRecords; ?> >

	<div class="panel panel-default">
	  <div class="panel-heading">LISTA KONT</div>
	  <div class="panel-body">

		  <div class="table-responsive">          
			  <table class="table table-hover">
				<thead>
				  <tr>
					<th>Użykownik</th>
					<th>Email</th>
					<th>Stopnień studiów</th>
				  </tr>
				</thead>
				<tbody>

				<?php
				// ----------------------- rendering table ----------------------------

				$result = "
				SELECT username
					  ,email
					  ,stop_stud
					  ,loginid
					  ,actcode
				FROM login
				where  password='0' and activated=0 and actcode='0' and dok=0 and email != ''
				ORDER BY data_godz, username
				limit 10";
				try{ $arr_A = $conn->query($result)->fetchAll(); }
					catch(PDOException $e){ die('An error occured: '.$e); };

				for ($i = 0; $i <= count($arr_A)-1; $i++) {
				 if ($_POST['command']=='COMMAND_CONTINUE') {
					$asUsername = $arr_A[$i]['username'];
					$asloginid = $arr_A[$i]['loginid'];
					$asemail = $arr_A[$i]['email'];
					$asactcode = generate_code(20);
					$update = "UPDATE login SET actcode= :actcode, activated=0 WHERE username = :username";
					$stmt = $conn->prepare($update);
					try{ $stmt->execute(['actcode' => $asactcode, 'username' => $asUsername]); }
						catch(PDOException $e){ die('An error occured: '.$e); };
					sendActivationEmail($asloginid, $asemail, $asactcode);
				 }
				 echo '<tr class="Active">
						<td>'.$arr_A[$i]['username'].'</td>
						<td>'.$arr_A[$i]['email'].'</td>
						<td>'.$arr_A[$i]['stop_stud'].'</td>
					   </tr>';
				}
				?>

				</tbody>
			  </table>
		   </div>
	  </div>
	</div>

</div>	
<!--  LIST RECORDS  -->

<?php require_once "footer.php"; ?>



