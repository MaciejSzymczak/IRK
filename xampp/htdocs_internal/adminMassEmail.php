<?php
	function sendMail($emailto, $subject, $content, $from)
	{
		$header = "From: $from" . "\r\n";
		$header .= "Mime-Version: 1.0" . "\r\n";
		$header .= "Content-type: text/html; charset=UTF-8\r\n";
		//Content-Transfer-Encoding: 8bit\r\n
			 
		//$subject=iconv("windows-1250","UTF-8", $subject);
		$subject='=?UTF-8?B?'.base64_encode($subject).'?=';
		//$content=iconv("windows-1250","UTF-8", $content);

		if (mail($emailto, $subject, $content, $header))
		{
			return true;
		} else
		{
			return false;
		}
		return false;
	}

$senderEmail  = 'rekrutacja@wat.edu.pl';
$adminEmail = 'karol.heleniak@wat.edu.pl'; 
//$adminEmail = 'soft@home.pl'; 

set_time_limit(0);
$j=0;
// Powiadomienie o rozpoczęciu DYSTRYBUCJI MAIL'i
$today = 'dnia: '.date("Y.m.d").' godz: '.date("H:i:s");
$tresc1 = 
'<!doctype html>
<html>
<head>
  <meta http-equiv="content-type"
 content="text/html; charset=UTF-8">
  <title>ZdjViewId</title>
</head>
<body>
<span style="font-family: Arial;"></span><br>
<table
 style="width: 40%; text-align: left; margin-left: auto; margin-right: auto;"
 border="1" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td>
      <div style="text-align: center;"><big><big><big><big><span style="font-family: Estrangelo Edessa;"><br>
      </span></big></big><big style="font-family: Felix Titling;">POTWIERDZENIE<br>
      <br>
      <small><small><span style="color: rgb(255, 0, 0); font-weight: bold;">';
 $tresc2 = 'ROZPOCZĘCIA';
 $tresc3 = '</span> DYSTRYBUCJI</small></small></big> </big></big><big><big><big><span style="font-family: Estrangelo Edessa;"></span></big></big></big> <small><br>
      </small> </div>
      <div style="text-align: center;"><big><small><span style="font-family: Felix Titling;">MAILi Z  Informacjami dla  kandydatów</span></small><br>
      </big></div>
      <br>
      <br>
      <table style="font-family: Arial; width: 90%; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2" cellspacing="2">
        <tbody>
          <tr>
            <td style="text-align: center; font-weight: bold; width: 787px; background-color: rgb(204, 153, 51);"><small>';
$tresc4 = '</small></td>
          </tr>
        </tbody>
      </table>
      <br style="font-family: Arial;">
      <span style="font-family: Arial;"></span><span style="font-family: Arial;"><br>
      </span></td>
    </tr>
  </tbody>
</table>
<br>
</body>
</html>
';
$tresc =$tresc1.$tresc2.$tresc3.$today.$tresc4;
$naglowek = 'Powiadomienie o STARCIE dystrybucji emaili';
sendMail($adminEmail, $naglowek, $tresc, $senderEmail );

//------------Dystrybucja--------------
require "D:/xampp2/htdocs/db_connect.inc.php";
opendb("irk");
$info='';$i=0;
$fName="D:/xampp2/htdocs_data/email/"."DystrybMail_".date('d')."-".date('m')."-".date('Y')."_".date('h')."_".date('i')."_".date('s A').".txt";
$fh=fopen($fName,"w");
$arrTK="ListaMail wygenerowana dnia/godzina: ".date('d')."-".date('m')."-".date('Y h:i:s A'). PHP_EOL;
//$dataKomunikat = mysql_query("SELECT * FROM mailkomunikaty ORDER BY ID_mailkomunikaty ASC") or die(mysql_error());
$stmt = $conn->prepare("SELECT * FROM mailkomunikaty ORDER BY ID_mailkomunikaty ASC");
try{ $stmt->execute(); }
	catch(PDOException $e){ die('An error occured: '.$e); };
while($infoKomunikat = $stmt->fetch(PDO::FETCH_BOTH))
{
  $as11=$infoKomunikat['ID_mailKomunikaty'];$i=0;
  //$dataKonta = mysql_query("SELECT * FROM mailkonta WHERE ID_mailKomunikaty = $as11 and sent_date='0000-00-00 00:00:00' order by data_godz") or die(mysql_error());
  $dataKonta = $conn->prepare("SELECT * FROM mailkonta WHERE ID_mailKomunikaty = $as11 and sent_date='0000-00-00 00:00:00' order by data_godz");
	try{ $dataKonta->execute(); }
		catch(PDOException $e){ die('An error occured: '.$e); };
  while($infoKonta = $dataKonta->fetch(PDO::FETCH_BOTH))
   {   
       $i++;$j++;
	   // do the pause (120 seconds) after each 50 emails
	   if ($j % 50 == 0) sleep(120);
	   
       sendMail($infoKonta['email'], $infoKomunikat['naglowek'].' '.$infoKonta['osobistyNaglowek'], $infoKomunikat['tresc'].' '.$infoKonta['osobistaTresc'].' '.$infoKomunikat['zapas'].' '.$infoKonta['zapas'], $senderEmail );
	   $arrTK .= $i.' | '.$j.' | '.$infoKonta['email'].' | '.$senderEmail.' | '. date('d')."-".date('m')."-".date('Y h:i:s A'). PHP_EOL;
	   
		$sql = "update mailkonta set sent_date=NOW() where ID_mailKonta=".$infoKonta['ID_mailKonta'];
		$sql = $conn->prepare($sql);
		try{ $sql->execute(); }
			catch(PDOException $e){ die('An error occured: '.$e); };
	   
       // do ***not use echo. Echo somehow causes the process get interrupted when it is executed from the web page in separate thread via: pclose(popen("start /B D:/xampp2/htdocs_internal/adminMassEmail.bat", "r"));
       //echo '.';
   }
}
$arrTK = $arrTK.'Powyższy tekst jest w pliku '.$fName.' Godzina zakończenia: '.date('h:i:s A').'| KONIEC LISTY |';
//echo $arrTK;
fwrite($fh,$arrTK);

// ==================================   Powiadomienie o zakończeniu DYSTRYBUCJI MAIL'i
$tresc2 = 'ZAKOŃCZENIA';
$tresc5='
<br>
<div style="text-align: center; font-family: Arial;"><span
 style="font-weight: bold;">Proszę pamiętać o wyczyszczeniu
tabeli <span
 style="background-color: rgb(204, 153, 51); color: rgb(0, 0, 0);">
irkkis.mailkonta </span> po każdej dystrybucji.</span><span class="Apple-style-span"
 style="border-collapse: separate; color: rgb(0, 0, 0); font-size: 13px;"><span class="Apple-style-span" style="font-weight: bold; text-align: left;"></span></span></div> <br>';
$naglowek = 'Powiadomienie o ZAKOŃCZENIU dystrybucji '.'[ '.$j.' ]'.' emaili';
$today = 'dnia: '.date("Y.m.d").' godz: '.date("H:i:s");
$tresc =$tresc1.$tresc2.$tresc3.$today.$tresc4.$tresc5;
sendMail($adminEmail, $naglowek, $tresc, $senderEmail );
flush();
exit("<br>Zakończenie skryptu dystrybucji emaili");
?> 
