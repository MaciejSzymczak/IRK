<?php
 require_once "header.php";
 
 function show_loginform($disabled = false)
 {
 	global $conn;
 	
 	$LoginDisabledFlag = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'LoginDisabledFlag'")->fetch()[0];
 	$LoginDisabledHint = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'LoginDisabledHint'")->fetch()[0];
 
 	if ($LoginDisabledHint!='') {
 		echo '<div class="alert alert-info">'.$LoginDisabledHint;
 		if ($LoginDisabledFlag=='+') {
 			echo '<p/><p/><a href="./adminLogin.php" style="padding: 0px" type="button" class="btn btn-link btn-sm">Logowanie dla administratora systemu</a>';
 		}
 		echo '</div>';
 	}
 		
 	if ($LoginDisabledFlag=='+') {
 		require_once "footer.php";
 		exit();
 	}
 		
     echo '<div class="panel panel-default">
 	          <div class="panel-heading">LOGOWANIE</div>
 			  <div class="panel-body">
 			    <form class="form-horizontal" name="login-form" id="login-form" method="post" action="./index.php">
 				  <div class="form-group">
 					<label title="Username" class="control-label col-sm-2" for="username">LOGIN:</label>
 					<div class="col-sm-10">
 					<input tabindex="1" accesskey="u"  type="text" class="form-control" maxlength="255" id="username" placeholder="Twój email" name="username">
 					</div>
 				  </div>
 				  <div class="form-group">
 					<label title="Password" class="control-label col-sm-2" for="password">HASŁO:</label>
 					<div class="col-sm-10">
 					<input tabindex="2" accesskey="p" type="password" class="form-control" id="password" maxlength="255" placeholder="Twoje hasło" name="password">
 					</div>
 				  </div>
 				  <div class="form-group">
 					<label title="" class="control-label col-sm-2" for=""></label>
 					<div class="col-sm-10">
 					<!-- not working
 					<a onclick="javascript: document.getElementById(&quot;cmdlogin&quot;).form.submit();" tabindex="3" accesskey="l"  name="cmdlogin2" class="btn btn-primary btn-lg">
 						  <span class="glyphicon glyphicon-log-in"></span>&nbsp;Zaloguj się
 						</a> -->
 					<input tabindex="3" accesskey="l" type="submit" id="cmdlogin" name="cmdlogin" class="btn btn-primary btn-lg" value="Zaloguj się" ';
     if ($disabled == true)
     {
         echo 'disabled="disabled"';
     }
     echo ' /></div></div></form></div></div>'; 
 
 
 	// ====================== NEW ACCOUNT =======================================================	
 	$CreateAccount1Visible = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Visible'")->fetch()[0];
 	$CreateAccount1Button  = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Button'")->fetch()[0];
 	$CreateAccount1Hint    = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Hint'")->fetch()[0];
 	$CreateAccount2Visible = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Visible'")->fetch()[0];
 	$CreateAccount2Button  = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Button'")->fetch()[0];
 	$CreateAccount2Hint    = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Hint'")->fetch()[0];
 
 	//if (($_POST[sc2_rejw] =='T') or ($_POST[sw1_rejm] =='T') or ($_POST[sc1_rejm] =='T')){	
 	if ($CreateAccount1Visible=='+' or $CreateAccount2Visible=='+') {
 		echo '<div class="panel panel-default"><div class="panel-heading">REJESTRACJA</div><div class="panel-body">';
 	}
 
 	if  ($CreateAccount1Visible=='+' and $CreateAccount2Visible=='+'){echo 'Wybierz poziom studiów.';}
 	//if  ((($_POST[sw1_rejm] =='T') or ($_POST[sc1_rejm] =='T')) and ($_POST[sc2_rejw] =='T')){echo 'Wybierz poziom studiów.';}
 
 	// Rejestracja Wojskowe lub Cywilne I stopnia
 	//if  (($_POST[sw1_rejm] =='T') or ($_POST[sc1_rejm] =='T')){
 	if  ($CreateAccount1Visible=='+'){
 		echo '<div class="row">
 				<div class="col-sm-3 text-center">
 					<form style="width: 280px;" method="post" action="privacyPolicy.php">
 					  <input type="hidden" name="B1" value="STUDIA I STOPNIA"/>
 					  <button style="width: 280px;" name="N1" type="submit" class="btn btn-primary">'.$CreateAccount1Button.'</button>
 					</form>
 				</div>
 				<div class="col-sm-9">
 				<p>'.$CreateAccount1Hint.'</p>
 				</div>
 			  </div>';
 	}
 
 	// rejestracja Cywilne II stopnia
 	//if  ($_POST[sc2_rejw] =='T'){
 	if  ($CreateAccount2Visible=='+'){
 		 echo '<div class="row">
 				<div class="col-sm-3 text-center">
 					<form style="width: 280px;" method="post" action="privacyPolicy.php">
 					  <input type="hidden" name="B1" value="STUDIA II STOPNIA"/>
 					  <button style="width: 280px;" name="N1" type="submit" class="btn btn-primary">'.$CreateAccount2Button.'</button>
 					</form>
 				</div>
 				<div class="col-sm-9">
 				<p>'.$CreateAccount2Hint.'</p>
 				</div>
 			  </div>';
 	}
 
 	if ($CreateAccount1Visible=='+' or $CreateAccount2Visible=='+') {
 	//if (($_POST[sc2_rejw] =='T') or ($_POST[sw1_rejm] =='T') or ($_POST[sc1_rejm] =='T')){
 	echo '</div></div>';}
 
 	// ====================== PASSWORD RECOVERY =======================================================
 
 	echo '<div class="panel panel-default">
 			<div class="panel-heading">ODZYSKIWANIE HASŁA</div>
 			<div class="panel-body">
 				  <div class="row">
 					<div class="col-sm-3 text-center">
 						<a href="./lostpassword.php" class="btn btn-link" role="button" title="Jeżeli utracono hasło, żądaj wygenerowania nowego.">ODZYSKIWANIE HASŁA</a>
 					</div>
 					<div class="col-sm-9">
 					<p>Kliknij, jeżeli zapomniałaś/zapomniałeś hasła</p>
 					</div>
 				  </div>
 				  <!--
 				  Obsolete screenshots in guide, temporarily disabled in 2018.06.21				  
 				  <div class="row">
 					<div class="col-sm-3 text-center">
 						<a href="./info/index.html" class="btn btn-link" role="button" title="INFORMACJE">INFORMACJA</a>
 					</div>
 					<div class="col-sm-9">
 					<p>Krótka informacja na temat systemu rejestracji kandydatów</p>
 					</div>
 				  </div>
 				  -->
 			</div>
 		</div>';
 
 } 

 function display_chart() {
	 
	global $conn; //DAYOFYEAR
	$cntK = $conn->query(
	     "SELECT count(1) cnt
			FROM login
			   , kandydat_dane_osobowe 
			where login.id_kandydata=kandydat_dane_osobowe.id_kandydata 
			  and login.id_kandydata > 10
			  and plec = 'K'"
	)->fetch()[0];
	$cntM = $conn->query(
	     "SELECT count(1) cnt
			FROM login
			   , kandydat_dane_osobowe 
			where login.id_kandydata=kandydat_dane_osobowe.id_kandydata 
			  and login.id_kandydata > 10
			  and plec = 'M'"
	)->fetch()[0];
	?>
    </div>
    <div class='col-sm-6'>
	  <p>WSZYSTKIE REJESTRACJE<p>
	  <div class="table-responsive">
	  <table class="table table-hover">
	  <tr><td>Kobiety</td><td><?php echo $cntK; ?></td></tr>
	  <tr><td>Mężczyźni</td><td><?php echo $cntM; ?></td></tr>
	  </table>
	  </div>
	  <p><p>
	  <div id='chart_div' style='width: 400px; height: 400px;'></div>
	  
	   <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
	   <script type='text/javascript'>
			google.charts.load('current', {packages: ['corechart', 'bar']});
			google.charts.setOnLoadCallback(drawBasic);

			function drawBasic() {

				  var data = google.visualization.arrayToDataTable([
					['', 'Kobiety', 'Mężczyźni', { role: 'annotation' } ],
					<?php
					global $conn; //DAYOFYEAR
						$query = "
						SELECT count(1) cnt
								, DATE(data_godz) day
								, plec 
							FROM login
							   , kandydat_dane_osobowe 
							where login.id_kandydata=kandydat_dane_osobowe.id_kandydata 
							  and login.id_kandydata > 10
						 group by DATE(data_godz)
								, plec 
						 order by DATE(data_godz), plec";
						$stmt = $conn->prepare($query);
						try{ 
							$stmt->execute(['st' => $st]); 
						}
						catch(PDOException $e){ 
							die('An error occured: '.$e); echo 'An error occured: '.$e; 
						};
						$arr_A = $stmt->fetchAll();
						
						$cntK=0;
						$cntM=0;
						$currentDay='';
						for ($i = 0; $i <= count($arr_A)-1; $i++) {
							if ($currentDay=='') $currentDay = $arr_A[$i]['day'];
							if ( $arr_A[$i]['day'] != $currentDay ) {
								echo "['".$currentDay."', ".$cntK.", ".$cntM.",   ''],";
								$currentDay = $arr_A[$i]['day'];
								$cntK=0;
								$cntM=0;
							}
							if ($arr_A[$i]['plec']=='K') $cntK = $arr_A[$i]['cnt'];
							if ($arr_A[$i]['plec']=='M') $cntM = $arr_A[$i]['cnt'];
						}
						echo "['".$currentDay."', ".$cntK.", ".$cntM.",   ''],";
					?>
				  ]);

				  var options = {
					title: 'Nowe rejestracje dzień po dniu',
					//chartArea: {width: '100%'},
					legend: { position: 'top', maxLines: 3 },
					hAxis: {
					  title: 'Nowe rejestracje',
					  minValue: 0
					},
					//height: 400,
					vAxis: {
					  title: 'Czas (dni roku)'
					},  isStacked: true
				  };

				  var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

				  chart.draw(data, options);
				  //data.setValue(0, 1, 50 );
				  //chart.draw(data, options);
				}	
		  
		</script>	  
	  
	</div>
	</div>
	<?php	 
 }

 
 function show_userbox() {
	 
	echo " 
	<div class='row'>
    <div class='col-sm-6'>
	";
	 
	global $conn;
	
	$u = $_SESSION['username'];
	$uid = $_SESSION['loginid'];
	$pesel = $conn->query("SELECT Pesel FROM kandydat_dane_osobowe WHERE username = '$u'")->fetch()[0];


	$stmt = $conn->prepare("SELECT * FROM login WHERE username=:username");
	$stmt->execute(['username' => $u]);
	$_POST = $stmt->fetch();

	$stmt2 = $conn->prepare("select count(*) from kwalifikacje where AcceptedForStudies='Y' and pesel=:pesel");
	$stmt2->execute(['pesel' => $pesel]);
	$Accepted = $stmt2->fetch()[0]=='0'?0:1;

	$stmt3 = $conn->prepare("select count(*) from kwalifikacje where AcceptedForStudies='C' and pesel=:pesel");
	$stmt3->execute(['pesel' => $pesel]);
	$AcceptedForStudies = $stmt3->fetch()[0]=='0'?0:1;



	$_SESSION['STUDY_DEGREE'] = ($_POST['stop_stud']=='7' ? '1' : '2');
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
	// ------------------ special menu for system administrator --------------------------------
	$isAdmin=$_POST['isAdmin'];
	if ($isAdmin=='+') {
		
		if (!isset($_POST['PasswordExpireOn']) ||  $_POST['PasswordExpireOn']<=Date('Y-m-d') ) {
		  $_SESSION['forcePasswordChange'] = 'True';
		  header('Location: changepassword.php');
		  exit();
		} else {
		  $_SESSION['forcePasswordChange'] = 'False';
		}

	   echo "<div id='userbox'>
	   <p>JESTEŚ ZALOGOWANY JAKO ADMINISTRATOR</p> 
	   <table class='table table-hover'>
		<tr><td onclick=\"window.location='./adminPhotoApprovals.php'\"><h6 style='margin:0'>ZATWIERDZANIE ZDJĘĆ</h6></td></tr>
		<tr><td onclick=\"window.location='./adminPhotoExport.php'\"><h6 style='margin:0'>EKSPORT ZDJĘĆ</h6></td></tr>
		<tr><td onclick=\"window.location='./adminDocumentApprovals.php'\"><h6 style='margin:0'>ZATWIERDZANIE ŚWIADECTW DOJRZAŁOŚCI</h6></td></tr>
		<tr><td onclick=\"window.location='./adminDocumentExport.php'\"><h6 style='margin:0'>EKSPORT ŚWIADECTW DOJRZAŁOŚCI</h6></td></tr>
		<tr><td onclick=\"window.location='./adminEmails.php'\"><h6 style='margin:0'>DYSTRYBUCJA EMAILI</h6></td></tr>	
		<tr><td onclick=\"window.location='./adminProgramSettings.php'\"><h6 style='margin:0'>USTAWIENIA</h6></td></tr>
		<tr><td onclick=\"window.location='./adminLoginAsUser.php'\"><h6 style='margin:0'>ZALOGUJ SIĘ JAKO KANDYDAT</h6></td></tr>
		<tr><td onclick=\"window.location='./adminEventLog.php'\"><h6 style='margin:0'>DZIENNIK ZDARZEŃ</h6></td></tr>
		<tr><td onclick=\"window.location='./adminMassActivation.php'\"><h6 style='margin:0'>MASOWA AKTYWACJA KONT UŻYTKOWNIKÓW</h6></td></tr>
		<tr><td onclick=\"window.location='./adminDB.php'\"><h6 style='margin:0'>ADMINISTRACJA BAZĄ DANYCH</h6></td></tr>	
		<tr><td onclick=\"window.location='./changepassword.php'\"><h6 style='margin:0'>ZMIANA HASŁA</h6></td></tr>
		<tr><td onclick=\"window.location='./logout.php'\"><h6 style='margin:0'>WYJŚCIE</h6></td></tr>
	   </table>
	   </div>";
	   display_chart();
	  return;	
	}

	// -----------------------------------------------------------------------------------------

	$dok13 = $_POST['id_Kandydata'];
	
	$Degree1DisableApplication = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'Degree1DisableApplication'")->fetch()[0];
	$Degree2DisableApplication = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'Degree2DisableApplication'")->fetch()[0];
	$SendingDocs = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'SendingDocs'")->fetch()[0];

   echo "<div id='userbox'>
   Witaj!<br></br> 
   <ul>";

    if ($Accepted) {
        echo "<div class='alert alert-success'>Zaakceptowano Twoją kandydaturę, gratulujemy!</div>";
	}

	if  ($_SESSION['STUDY_DEGREE'] =='1' && $AcceptedForStudies && $SendingDocs=='+'){
	    if ($_POST['ile_login']>1) echo "<li><a href='./documentUpload.php'>PRZESYŁANIE SKANU ŚWIADECTWA DOJRZAŁOŚCI</a></li>";
	 }

	//STUDY_DEGREE 2
	if  (($_SESSION['STUDY_DEGREE'] =='2') and (!$Degree2DisableApplication=='+')){
	   echo "<li><a href='./qform.php'>PODANIE-ANKIETA</a></li>";
	   if ($_POST['ile_login']>1) echo "<li><a href='./wssks2.php'>WYBÓR SYSTEMU STUDIÓW I KIERUNKU</a></li>";
	 }
	 
	 if  ($_SESSION['STUDY_DEGREE'] =='2'){
	  if ($_POST['ile_login']>1) echo "<li><a href='./qformView2.php'>PRZEGLĄDANIE ANKIETY</a></li>";
	  if ($_POST['ile_login']>1) echo "<li><a href='./photoUpload.php'>PRZESŁANIE ZDJĘCIA</a></li>";
	}

	//STUDY_DEGREE 1
	if  (($_SESSION['STUDY_DEGREE'] =='1') and (!$Degree1DisableApplication=='+')){
	    echo "<li><a href='./qform.php'>PODANIE-ANKIETA</a></li>";
		if ($_POST['ile_login']>1) echo "<li><a href='./qformView.php'>PRZEGLĄDANIE ANKIETY</a></li>";
		if ($_POST['ile_login']>1) echo "<li><a href='./photoUpload.php'>PRZESŁANIE ZDJĘCIA</a></li>";
		if ($_POST['ile_login']>1) echo "<li><a href='./qwyniki_matura.php'>PRZESŁANIE WYNIKÓW ZE ŚWIADECTWA DOJRZAŁOŚCI</a></li>";
	 }

	if  (($_SESSION['STUDY_DEGREE'] =='1') and ($Degree1DisableApplication=='+')){
	    if ($_POST['ile_login']>1) echo "<li><a href='./qformView.php'>PRZEGLĄDANIE ANKIETY</a></li>";
		if ($_POST['ile_login']>1) echo "<li><a href='./photoUpload.php'>PRZESŁANIE ZDJĘCIA</a></li>";
	 }

    //STUDY_DEGREE BOTH
   if ($_POST['ile_login']>1) echo "<li><a href='./qkontoB.php'>NUMER KONTA BANKOWEGO</a></li>";
   if ($_POST['ile_login']>1) echo "<li><a href='./qinfo.php'>INFORMACJE DLA KANDYDATA</a></li>";
   echo "<li><a href='./changepassword.php'>ZMIANA HASŁA</a></li>
	<li><a href='./logout.php'>WYJŚCIE</a></li>
   </ul>
   </div>";	 
      
}

 if (!isLoggedIn())
 {
     if (isset($_POST['cmdlogin']))
     {
         if (checkLogin($_POST['username'], $_POST['password'])=='true')
         {
             show_userbox();
         } else
         {
 			echo "<font color='red'>";
             echo "Dane do logowania są niewłaściwe    [";
             echo "<font color='black'>";
			 echo checkLogin($_POST['username'], $_POST['password']).']';
             show_loginform();
         }
     } else
     {
        show_loginform();
     }
 } else
 {
     show_userbox();
 }

 require_once "footer.php";
?>