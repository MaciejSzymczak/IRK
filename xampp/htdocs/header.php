<?php
//https://stackoverflow.com/questions/5106313/redirecting-from-http-to-https-with-php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

session_start();
error_reporting(0);
ini_set('display_errors', 'Off');

//Uncomment two lines below to see detailed error message. Use it in dev env. 
//error_reporting(E_ALL );
//ini_set('display_errors', 'On'); 

require_once ('db_connect.inc.php');

require_once("mail.functions.inc.php");
require_once("user.functions.inc.php");
require_once("display.functions.inc.php");
require_once("login.functions.inc.php");
require_once("validation.functions.inc.php");

function generate_code($length = 10)
{

    if ($length <= 0)
    {
        return false;
    }

    $code = "";
    $chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    srand((double)microtime() * 1000000);
    for ($i = 0; $i < $length; $i++)
    {
        $code = $code . substr($chars, rand() % strlen($chars), 1);
    }
    return $code;

}

function mysql_fetch_full_result_array($result)
{
	$table_result=array();
	$r=0;

	while($row = mysql_fetch_assoc($result)){
		$arr_row=array();
		$c=0;
		while ($c < mysql_num_fields($result)) {
			$col = mysql_fetch_field($result, $c);
			$arr_row[$col -> name] = $row[$col -> name];
			$c++;
		}
		$table_result[$r] = $arr_row;
		$r++;
	}
	return $table_result;
}


$domain = "wat-irk.wat.edu.pl";

$SHOW = '';
$HIDE = ' style="display: none;" ';

?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <title>Internetowa Rejestracja Kandydatów do WAT</title>
  <!--meta charset="utf-8"-->
  <meta content="text/html; charset=UTF-8" http-equiv="content-type">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
  <!-- Bootstrap Date-Picker Plugin from https://uxsolutions.github.io/bootstrap-datepicker-->
  <script type="text/javascript" src="/bootstrap-datepicker-1.6.4-dist/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="/bootstrap-datepicker-1.6.4-dist/css/bootstrap-datepicker3.css"/>
  
  
  <!--script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script-->
  <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/-->
  
  <!--link href="images/as.ico" rel="shortcut icon" /-->
  <meta content="Adam Sowinski" name="author">
  <meta content="UAMA Wawa2008" name="description">
  <!-- https://developers.google.com/web/tools/chrome-devtools/javascript/disable  -->
  <noscript>
	   INTERNETOWA REJESTRACJA KANDYDAT&Oacute;W NA STUDIA<br/>
	   Ups, wygląda na to, że uruchamianie kodu javascript zostało zablokowane.<br/>
	   Dla poprawnego działania serwisu konieczne jest uruchomienie kodu javascript. 
	   <style>div { display:none; }</style>
  </noscript>
</head>
<body>
<div class="container">
<div class="page-header">
<div class="row text-center">
  <div class="col-sm-2"><a href="//www.wat.edu.pl/"><img style="width: 150px; height: 88px;" alt="" src="images/watLogo.jpg"></a></div>
  <?php if (isset($_SESSION['alertMessage'])) {  ?>
  <div class="col-sm-10" style="background-color:black; color:white" ><?php echo $_SESSION['alertMessage']; ?></div>  
  <?php }  ?>
  <div class="col-sm-10"><h3>INTERNETOWA REJESTRACJA KANDYDAT&Oacute;W NA STUDIA</h3></div>
</div>
</div>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">

	
<?php
if (isLoggedIn())
{

	echo '<br/>';
	//https://stackoverflow.com/questions/520237/how-do-i-expire-a-php-session-after-30-minutes
	if (!isset($_SESSION['LAST_ACTIVITY'])) {
		session_unset();   
		session_destroy(); 
		echo '<script> 
			alert("Twoja sesja wygasła, musisz zalogować się ponownie");
            window.location.href = "https://'.$_SERVER['HTTP_HOST'].'"
        </script></body>';
		exit();
	}
	
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
		// last request was more than 30 minutes ago
		//echo '<div class="alert alert-primary" role="alert">Twoja sesja wygasła, zaloguj się ponownie</div>';
		session_unset();   
		session_destroy(); 
		echo '<script> 
			alert("Twoja sesja wygasła, musisz zalogować się ponownie");
            window.location.href = "https://'.$_SERVER['HTTP_HOST'].'"
        </script></body>';
		exit();
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

	//sessions longer that 4 hours are not permitted
	if (!isset($_SESSION['CREATED'])) {
		$_SESSION['CREATED'] = time();
	} else if (time() - $_SESSION['CREATED'] > 3600*4) {
		// session started more than 4h ago
		session_unset();   
		session_destroy(); 
		echo '<script> 
			alert("Twoja sesja wygasła, musisz zalogować się ponownie");
            window.location.href = "https://'.$_SERVER['HTTP_HOST'].'"
        </script></body>';
		exit();
	}

	//avoid attacks on sessions like session fixation:
	//if (!isset($_SESSION['CREATED'])) {
	//	$_SESSION['CREATED'] = time();
	//} else if (time() - $_SESSION['CREATED'] > 1800) {
	//	// session started more than 30 minutes ago
	//	session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
	//	$_SESSION['CREATED'] = time();  // update creation time
	//}
	
	
}
?>