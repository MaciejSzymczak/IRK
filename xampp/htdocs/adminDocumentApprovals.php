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

<!-- action is set dynamically: adminDocumentApprovals.php OR photoCrop.php -->
<form id="refreshPage" action="" method="POST">
  <input type="hidden" id="command" name='command' value="<to be set>"/>
  <input type="hidden" id="message" name='message' value="<to be set>"/>
  <input type="hidden" id="searchText" name='searchText' value="<to be set>"/>
  <input type="hidden" id="caller" name='caller' value="<to be set>"/>
  <input type="hidden" id="recordId" name='recordId' value="<to be set>"/>
</form>

<script>
function goToRecordClick(m) {
	document.getElementById('command').value='COMMAND_GO_TO_RECORD';
	document.getElementById('recordId').value=m;
	document.getElementById('refreshPage').action='adminDocumentApprovals.php';
	document.getElementById('refreshPage').submit();
}
</script>	

<script>
function showList() {
	document.getElementById('command').value='COMMAND_SHOW_LIST';
	document.getElementById('searchText').value=document.getElementById('searchTextItem').value;
	document.getElementById('refreshPage').action='adminDocumentApprovals.php';
	document.getElementById('refreshPage').submit();
}
</script>	

<div class="row">	
	<div class="panel panel-default" >
		<div class="panel-body" >
			<div class="form-group row" style = "margin: 0 !important;">
				<div class="col-xs-6">
					<div class="input-group">
						  <input class="form-control" id="searchTextItem" type="text" placeholder="Szukaj..">
						  <div class="input-group-btn">
							<button type="button" class="btn btn-default glyphicon glyphicon-search" onclick="showList();"> Szukaj</button>
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

<?php

if($_POST['command']=='COMMAND_APPROVER_ACTION'){
	$sql = "update documents set revision_date=NOW(), revision_comments = :revision_comments where pesel = :pesel ";
	$stmt = $conn->prepare($sql);
	try{ $stmt->execute(['revision_comments' => $_POST['message'], 'pesel' => $_POST['recordId']]); }
		catch(PDOException $e){ die('An error occured: '.$e); };
	echo '<div class="alert alert-info" role="alert">
			  <strong>Wykonane! </strong> Wybrano czynność: <strong>' .$_POST['message']. '</strong> na rekordzie ' .$_POST['recordId'].
		  '&nbsp;&nbsp;<button type="button" class="btn btn-danger" onclick="goToRecordClick(&quot;'.$_POST['recordId'].'&quot;);"><span class="glyphicon glyphicon-pencil"></button></div>';
}

if($_POST['command']=='COMMAND_APPROVER_ACTION' || empty($_POST['command']) ){
	$currentRecordId = $conn->query("SELECT pesel from documents where revision_comments='' order by data_godz limit 1")->fetch()[0];
	$leftCnt = $conn->query("SELECT count(1) from documents where revision_comments=''")->fetch()[0];
	if (empty($currentRecordId)) { 
		echo '<div class="alert alert-info" role="alert">
				  Wszystkie dokumenty zostały przejrzane
			  </div>'; 
	}	
}

$showListFlag=false;
if($_POST['command']=='COMMAND_SHOW_LIST'){
	$showListFlag = true;
	$currentRecordId = '';
}

if($_POST['command']=='COMMAND_GO_TO_RECORD'){
	$currentRecordId = $_POST['recordId'];
}

$isCompletedFlag = 0;
if (!empty($currentRecordId)) {
	$isCompletedFlag = $conn->query("SELECT count(1) FROM documents WHERE pesel = $currentRecordId and completion_date!='0000-00-00 00:00:00'")->fetch()[0];
}
?>

<div class="row" <?php if (empty($currentRecordId)) { echo ' style="display: none;" '; }  ?> >
	<div class="panel panel-default"  <?php if (empty($currentRecordId)) { echo ' style="display: none;" '; }  ?> >
	  <div class="panel-heading">PESEL <?php echo $currentRecordId;?>: ZATWIERDZANIE SKANÓW ŚWIADECTW DOJRZAŁOŚCI<p>Pozostało do zatwierdzenia: <?php echo $leftCnt;?></p></div>
	  <div class="panel-body">

		<div class="alert alert-success" <?php if ($isCompletedFlag==0) { echo ' style="display: none;" '; }  ?> role="alert">
			<p>Zdjęcie zostało już zaakceptowane i przesłane</p>
			<p></p>
			<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
		</div>			  
		
		
<div class="row" <?php if (empty($currentRecordId)) { echo ' style="display: none;" '; }  ?> >
	<div class="col-sm-6">
	
		<div class="table-responsive">          
		  <table class="table table-hover">
			<thead>
			  <tr>
				<th>Przedmiot</th>
				<th>Podst.</th>
				<th>Rozsz.</th>
				<th>Pis.</th>
				<th>Ust.</th>
				<th>Dwujęz.</th>
			  </tr>
			</thead>
			<tbody>

			<?php
			// ----------------------- rendering table ----------------------------		
				$query = "
					SELECT slownik_przedmiotow_maturalnych.Nazwa
							,Wynik_podstawowy 
							,Wynik_rozszerzony
							,Wynik_pisemny 
							,Wynik_ustny
							,Klasa_dwujezyczna 
					FROM kandydat_wyniki_maturalne
					   , slownik_przedmiotow_maturalnych
					WHERE Id_przedmiotu_matur = ID_przedmiotu and pesel = ?
					order by seq";
				$stmt = $conn->prepare($query);
				try{ $stmt->execute([$currentRecordId]); }
					catch(PDOException $e){ die('An error occured: '.$e); };
				$arr_A = $stmt->fetchAll();
											
				for ($i = 0; $i <= count($arr_A)-1; $i++) {
				 echo '<tr class="Active">
						<td>'.$arr_A[$i]['Nazwa'].'</td>
						<td>'.$arr_A[$i]['Wynik_podstawowy'].'</td>
						<td>'.$arr_A[$i]['Wynik_rozszerzony'].'</td>
						<td>'.$arr_A[$i]['Wynik_pisemny'].'</td>
						<td>'.$arr_A[$i]['Wynik_ustny'].'</td>
						<td>'.$arr_A[$i]['Klasa_dwujezyczna'].'</td>
					   </tr>';
				}
			?>

			</tbody>
		  </table>
		</div>	
		
		<div class="btn-group-vertical center-block" <?php if ($isCompletedFlag!=0) { echo ' style="display: none;" '; }  ?> >
			<script>
				function setApproverAction(m) {
					document.getElementById('command').value='COMMAND_APPROVER_ACTION';
					document.getElementById('message').value=m;
					document.getElementById('recordId').value='<?php echo $currentRecordId; ?>';
					document.getElementById('refreshPage').action='adminDocumentApprovals.php';
					document.getElementById('refreshPage').submit();
				}
			</script>
			<button type="button" class="btn btn-success" onclick="setApproverAction('Zaakceptowane');" >
				<span class="glyphicon glyphicon-ok">Akceptuję ten dokument
			</button>
			<button type="button" class="btn btn-danger" onclick="setApproverAction('Plik jest uszkodzony');">
				<span class="glyphicon glyphicon-remove">Plik jest uszkodzony
			</button>
			<button type="button" class="btn btn-danger" onclick="setApproverAction('Dokument nie zawiera skanu świadectwa dojrzałości');">
				<span class="glyphicon glyphicon-remove">Dokument nie zawiera skanu świadectwa dojrzałości
			</button>
			<button type="button" class="btn btn-default" onclick="setApproverAction('');">
				Wyczyść komentarz
			</button>
			<br/>
		</div>			
	
	</div>
	<div class="col-sm-6">
		<?php
		//show picture
		$path = 'D:/xampp2/htdocs_data/documents/' .$currentRecordId. '.pdf';
		if (file_exists ($path)) {
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			//$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			//echo '<img style="height:633px; width:492px;" id="result-img" src="'.$base64.'">';			
			$base64 = 'data:application/pdf;base64,' . base64_encode($data);						
			echo '<object data="'.$base64.'" type="application/pdf"  width="900" height="700"></object>';					
		} else {
			echo '*** No document ***';										
		}
		?>
	</div>

</div>
		
	  </div>
	</div>	
</div>	


<!--  LIST RECORDS  -->
<div class="row" 	<?php if (!$showListFlag) { echo ' style="display: none;" '; }  ?> >

	<div class="panel panel-default">
	          <div class="panel-heading">LISTA DOKUMENTÓW</div>
			  <div class="panel-body">

				  <div class="table-responsive">          
					  <table class="table table-hover">
						<thead>
						  <tr>
							<th>#</th>
							<!--th>Typ</th-->
							<!--th>Nazwa</th-->
							<!--th>Rozmiar</th-->
							<th>Pesel</th>
							<!--th>Email</th-->
							<th>Imie</th>
							<th>Nazwisko</th>
							<th>Zaktualizowano</th>
							<th>Przeglądający: Komentarz</th>
							<th>Przeglądający: Data</th>
							<th>Eksport</th>
							<th>Edycja</th>
						  </tr>
						</thead>
						<tbody>

							<?php

							// ----------------------- rendering table ----------------------------
							if ($showListFlag) {

								$searchWhere="";
								$st = $_POST['searchText'];
								if (!empty($st)) {
								 	$st = "%$st%";
									$searchWhere=" and (documents.pesel like :st or nazwisko like :st or imie like :st or revision_comments like :st ) ";
								}
								
								$result = "
								SELECT Id
									  ,typ
									  ,nazwa
									  ,rozmiar
									  ,documents.pesel
									  ,documents.email
									  ,imie
									  ,nazwisko
									  ,data_godz
									  ,revision_comments
									  ,revision_date 
									  ,completion_date
								FROM documents
								   , kandydat_dane_osobowe
								where   kandydat_dane_osobowe.pesel = documents.pesel ".$searchWhere." 
								ORDER BY revision_date desc
								limit 300";
								//ORDER BY if(revision_date='0000-00-00 00:00:00','9999-00-00 00:00:00',revision_date) desc
								$stmt = $conn->prepare($result);
								$stmt->bindParam(':st', $st);
								try{ $stmt->execute(); }
									catch(PDOException $e){ die('An error occured: '.$e); };
								$arr_A = $stmt->fetchAll();


								for ($i = 0; $i <= count($arr_A)-1; $i++) {
								 echo '<tr class="Active">
										<td>'.$arr_A[$i]['Id'].'</td>
										<!--td>'.$arr_A[$i]['typ'].'</td-->
										<!--td>'.$arr_A[$i]['nazwa'].'</td-->
										<!--td>'.$arr_A[$i]['rozmiar'].'</td-->
										<td>'.$arr_A[$i]['pesel'].'</td>
										<!--td>'.$arr_A[$i]['email'].'</td-->
										<td>'.$arr_A[$i]['imie'].'</td>
										<td>'.$arr_A[$i]['nazwisko'].'</td>
										<td>'.$arr_A[$i]['data_godz'].'</td>
										<td>'.$arr_A[$i]['revision_comments'].'</td>
										<td>'.$arr_A[$i]['revision_date'].'</td>
										<td>'.$arr_A[$i]['completion_date'].'</td>
										<td><button type="button" class="btn btn-info" onclick="goToRecordClick(&quot;'.$arr_A[$i]['pesel'].'&quot;);"><span class="glyphicon glyphicon-pencil"></button></td>
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