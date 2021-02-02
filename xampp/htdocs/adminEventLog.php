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

<!-- action is set dynamically: adminEventLog.php OR photoCrop.php -->
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
function showList() {
	document.getElementById('command').value='COMMAND_SHOW_LIST';
	document.getElementById('searchText').value=document.getElementById('searchTextItem').value;
	document.getElementById('refreshPage').action='adminEventLog.php';
	document.getElementById('refreshPage').submit();
}
</script>	

  <?php
	$showListFlag=false;
    if($_POST['command']=='COMMAND_SHOW_LIST'){
		$showListFlag = true;
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
	          <div class="panel-heading">DZIENNIK ZDARZEŃ</div>
			  <div class="panel-body">

				  <div class="table-responsive">          
					  <table class="table table-hover">
						<thead>
						  <tr>
							<th>Użykownik</th>
							<th>Zdarzenie</th>
							<th>Kiedy</th>
						  </tr>
						</thead>
						<tbody>

							<?php

							// ----------------------- rendering table ----------------------------
							if ($showListFlag) {
								
								$st = $_POST['searchText'];
								
								$searchWhere="";
								
								if (!empty($st)) {
								 	$st = "%$st%";
									$searchWhere=" and (Action like :st or User like :st) ";
								}
								
								$result = "
								SELECT User
									  ,Action
									  ,CreatedDate
								FROM EventLog
								where  0=0  ".$searchWhere." 
								ORDER BY CreatedDate desc";
								//ORDER BY if(revision_date='0000-00-00 00:00:00','9999-00-00 00:00:00',revision_date) desc
								$stmt = $conn->prepare($result);
								$stmt->bindParam(':st', $st);
								try{ $stmt->execute(); }
									catch(PDOException $e){ die('An error occured: '.$e); };
								$arr_A = $stmt->fetchAll();


								for ($i = 0; $i <= count($arr_A)-1; $i++) {
								 echo '<tr class="Active">
										<td>'.$arr_A[$i]['User'].'</td>
										<td>'.$arr_A[$i]['Action'].'</td>
										<td>'.$arr_A[$i]['CreatedDate'].'</td>
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