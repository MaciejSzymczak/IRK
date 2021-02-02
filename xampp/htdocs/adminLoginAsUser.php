<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php 
$stmt = $conn->prepare("SELECT isAdmin FROM login WHERE username=:username");
$stmt->execute(['username' => $_SESSION['username']]);
$isAdmin = $stmt->fetch()[0];


if ($isAdmin!='+') {
	 echo '<div class="alert alert-danger" role="alert">
			  <strong>Och!</strong> Ten formularz jest dostępny tylko dla Administratora.
			</div>';
	 require_once "footer.php";
	 exit();
}

?>

<!-- action is set dynamically: adminLoginAsUser.php OR photoCrop.php -->
<form id="refreshPage" action="" method="POST">
  <input type="hidden" id="command" name='command' value="<to be set>"/>
  <input type="hidden" id="message" name='message' value="<to be set>"/>
  <input type="hidden" id="searchText" name='searchText' value="<to be set>"/>
  <input type="hidden" id="caller" name='caller' value="<to be set>"/>
  <input type="hidden" id="recordId" name='recordId' value="<to be set>"/>
  <input type="hidden" id="loginid" name='loginid' value="<to be set>"/>
  <input type="hidden" id="username" name='username' value="<to be set>"/>
  <input type="hidden" id="fname" name='fname' value="<to be set>"/>
  <input type="hidden" id="lname" name='lname' value="<to be set>"/>
</form>


<script>
function goToRecordClick(loginid, username, fname, lname) {
	document.getElementById('command').value='COMMAND_GO_TO_RECORD';
	document.getElementById('loginid').value=loginid;
	document.getElementById('username').value=username;
	document.getElementById('fname').value=fname;
	document.getElementById('lname').value=lname;
	document.getElementById('refreshPage').action='adminLoginAsUser.php';
	document.getElementById('refreshPage').submit();
}
</script>	

<script>
function showList() {
	document.getElementById('command').value='COMMAND_SHOW_LIST';
	document.getElementById('searchText').value=document.getElementById('searchTextItem').value;
	document.getElementById('refreshPage').action='adminLoginAsUser.php';
	document.getElementById('refreshPage').submit();
}
</script>	

  <?php

	$showListFlag=false;
    if(isset($_POST['command']) && $_POST['command']=='COMMAND_SHOW_LIST'){
		$showListFlag = true;
	}

	if(isset($_POST['command']) && $_POST['command']=='COMMAND_GO_TO_RECORD'){
		adminLoginAs(
			$_POST['loginid']
		  , $_POST['username']
		  , $_POST['fname']
		  , $_POST['lname']
		  , 'Tryb administratora: Jesteś zalogowany jako kandydat '.$_POST['username'].' '.$_POST['fname'].' ' .$_POST['lname']
		);
		echo '<div class="alert alert-danger" role="alert">
			  Jesteś teraz zalogowany jako kandydat '.$_POST['username'].' '.$_POST['fname'].' ' .$_POST['lname'].'<br/>Zmiana danych tylko za zgodą kandydata.
			</div>';
		echo '<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=(&quot;./index.php&quot;);"> Kontynuuj</button>';
		require_once "footer.php";	
		exit();
	}
  ?>

<div class="row">	
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-group row">
				<div class="col-xs-6">
					<div class="input-group">
						  <input class="form-control" id="searchTextItem" type="text" placeholder="Szukaj..">
						  <div class="input-group-btn">
							<button id="RunSearch" type="button" class="btn btn-default glyphicon glyphicon-search" onclick="showList();"> Szukaj</button>
						  </div>
					</div>
				</div>
				<div class="col-xs-2">
					<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
				</div>
			</div>
		</div>	
	</div>
</div>

<script>
	document.getElementById("searchTextItem").focus();

	var input = document.getElementById("searchTextItem");

	// Execute a function when the user releases a key on the keyboard
	input.addEventListener("keyup", function(event) {
	  // Number 13 is the "Enter" key on the keyboard
	  if (event.keyCode === 13) {
		// Cancel the default action, if needed
		event.preventDefault();
		// Trigger the button element with a click
		document.getElementById("RunSearch").click();
	  }
	});
</script>  

<!--  LIST RECORDS  -->
<div class="row" 	<?php if (!$showListFlag) { echo ' style="display: none;" '; }  ?> >

	<div class="panel panel-default">
	          <div class="panel-heading">LISTA KANDYDATÓW</div>
			  <div class="panel-body">

				  <div class="table-responsive">          
					  <table class="table table-hover">
						<thead>
						  <tr>
							<th>Nazwa</th>
							<th>Pesel</th>
							<th>Imie</th>
							<th>Nazwisko</th>
							<th>Email</th>
							<th>Liczba logowań</th>
							<th>Id kandydata</th>
							<th>Zaloguj się</br>jako ten kandydat</th>
						  </tr>
						</thead>
						<tbody>

							<?php

							// ----------------------- rendering table ----------------------------
							if ($showListFlag) {
								
								$st = $_POST['searchText'];
								
								$searchWhere="";
								if (!empty($st)) {
								 	$searchWhere=" and (pesel like :st or nazwisko like :st or imie like :st or email like :st or login.username like :st or login.Id_Kandydata like :st) ";
								}
																	       
								$query = "
								SELECT loginid
									  ,login.username
									  ,email
									  ,ile_login
									  ,pesel
									  ,imie
									  ,nazwisko
									  ,stop_stud
									  ,data_godz
									  ,ip
									  ,PrivacyAgreement
									  ,isAdmin
									  ,login.Id_Kandydata
								FROM login
								   , kandydat_dane_osobowe
								where   kandydat_dane_osobowe.Id_Kandydata = login.Id_Kandydata and isAdmin != '+' ".$searchWhere." 
								ORDER BY nazwisko desc
								limit 30000";
								//ORDER BY if(revision_date='0000-00-00 00:00:00','9999-00-00 00:00:00',revision_date) desc
								$stmt = $conn->prepare($query);
								try{ $stmt->execute(['st' => '%'.$st.'%']); }
									catch(PDOException $e){ die('An error occured: '.$e); };
								$arr_A = $stmt->fetchAll();
								
								for ($i = 0; $i <= count($arr_A)-1; $i++) {
								 echo '<tr class="Active">
										<td>'.$arr_A[$i]['username'].'</td>
										<td>'.$arr_A[$i]['pesel'].'</td>
										<td>'.$arr_A[$i]['imie'].'</td>
										<td>'.$arr_A[$i]['nazwisko'].'</td>
										<td>'.$arr_A[$i]['email'].'</td>
										<td>'.$arr_A[$i]['ile_login'].'</td>
										<td>'.$arr_A[$i]['Id_Kandydata'].'</td>
										<td><button type="button" class="btn btn-info" 
										onclick="goToRecordClick(&quot;'.$arr_A[$i]['loginid'].'&quot;,&quot;'.$arr_A[$i]['username'].'&quot;,&quot;'.$arr_A[$i]['imie'].'&quot;,&quot;'.$arr_A[$i]['nazwisko'].'&quot;);"><span class="glyphicon glyphicon-log-in"></button></td>
									   </tr>';
								}
							}
							?>

						</tbody>
					  </table>
				   </div>
			  </div>
	</div>

</div>


<?php require_once "footer.php"; ?>