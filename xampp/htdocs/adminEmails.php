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

<form id="refreshPage" action="adminEmails.php" method="POST">
  <input type="hidden" id="command" name='command' value="<to be set>"/>
</form>

<div class="row">

	<?php
		//if (empty($_POST['command'])) {
			
			$AllCnt = $conn->query("SELECT count(1) from mailkonta")->fetch()[0];
			$leftCnt = $conn->query("SELECT count(1) from mailkonta where sent_date='0000-00-00 00:00:00'")->fetch()[0];
			
			if ($AllCnt==0) $styleNotFound=''; else $styleNotFound=' style="display: none;" ';
			if ($AllCnt>0 && $leftCnt==$AllCnt) $styleButtonStart=''; else $styleButtonStart=' style="display: none;" ';
			if ($AllCnt>0 && $leftCnt<$AllCnt) $styleGuage=""; else $styleGuage=' style="display: none;" ';
			if ($_POST['command']=='COMMAND_CONTINUE') {
				//running the process asynchronically
			    pclose(popen("start /B D:/xampp2/htdocs_internal/adminMassEmail.bat", "r")); 				
				$styleButtonStart=' style="display: none;" ';
				$styleGuage="width: 400px; height: 240px;";
			}
			$styleOver = ' style="display: none;" ';
			if ($AllCnt>0 && $leftCnt==0) {
				$styleButtonStart=' style="display: none;" ';
				$styleGuage=' style="display: none;" ';
				$styleOver = '';
			}
		//}	
	?>

	<div <?php echo $styleNotFound; ?> >
		<div class="alert alert-info" role="alert">
			<strong>Och!</strong> Nie znaleziono emaili do wysłania. Użyj Aplikacji Access w celu wygenerowania listy emailingowej (tabela mailkonta).
		</div>	
		<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
	 </div>


	 <div class="panel panel-default" <?php echo $styleButtonStart; ?> >
			  <div class="panel-heading">DYSTRYBUCJA EMAILI<p>Liczba emaili do wysłania: <?php echo $leftCnt;?></p></div>
			  <div class="panel-body">
				<button type="button" class="btn btn-success glyphicon glyphicon-ok" onclick="document.getElementById('command').value='COMMAND_CONTINUE'; document.getElementById('refreshPage').submit();"> Kontynuuj</button>		
				<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Anuluj</button>						
			  </div>
	</div>	
	
	<div class="panel panel-default" <?php echo $styleGuage; ?> >
			  <div class="panel-heading">Emaile są właśnie wysyłane</div>
			  <div class="panel-body">
				<p>Odczekaj kilka minut by mieć pewność, że wszystkie emaile zostały wysłane.</p>
				<p>Po wysłaniu wszystkich emaili otrzymasz powiadomienie o zakończeniu wysyłki.</p>
				<center><div id="chart_div"  style='width: 400px; height: 240px;'></div></center>
				<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>						
			  </div>
	</div>	
	
	<div <?php echo $styleOver; ?> >
		<div class="alert alert-info" role="alert">
			<strong>Wszystkie emaile zostały wysłane!</strong> W lokalizacji d:/backup znajduje się log z wysyłki.
			<p>Aby wysłać emaile ponownie, skasuj zawartość tabeli mailkonta i użyj Aplikacji Access w celu wygenerowania listy emailingowej.</p>
		</div>	
		<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Powrót</button>
	 </div>
	
	   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	   <script type="text/javascript">
		  google.charts.load('current', {'packages':['gauge']});
		  google.charts.setOnLoadCallback(drawChart);

		  function drawChart() {

			var data = google.visualization.arrayToDataTable([
			  ['Label', 'Value'],
			  ['Pozostało', <?php echo $leftCnt; ?>]
			]); 

			var options = {
			  width: 800, height: 240,
			  //redFrom: 90, redTo: 100,
			  //yellowFrom:75, yellowTo: 90,
			  min:1, max: <?php echo $AllCnt; ?>,
			  minorTicks: 10
			};

			var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
			chart.draw(data, options);
			data.setValue(0, 1, <?php echo $leftCnt; ?> );
			chart.draw(data, options);
			
			setTimeout(function () {
			  self.location.href="./adminEmails.php"; 
		}, 10000);
		  }
		</script>

	
</div>

<?php require_once "footer.php"; ?>



