<?php require_once "header.php"; ?>

<?php
    if (!isset($_POST['caller'])) { die('caller is required parameter'); }
    if (!isset($_POST['recordId'])) { die('recordId is required parameter'); }
	
	$caller = $_POST['caller'];
	$recordId = $_POST['recordId'];
	
    if($_POST['command']=='COMMAND_SAVE_CROPPED_PICTURE'){
        $data = $_POST['imagebase64'];

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

		$fileName = 'D:/xampp2/htdocs_data/' .$_POST['recordId']. '.jpg';
        file_put_contents($fileName, $data);
		
		//reset revision comments
		$data_godz=date("Y-m-d H:i:s");
		$pesel=$_POST['recordId'];
		$zapytanie = "UPDATE zdjecia
		SET revision_comments=null, revision_date=null, data_godz = '".$data_godz."'
		WHERE pesel = $pesel";
		$stmt = $conn->prepare($zapytanie);
		try{ $stmt->execute(); }
			catch(PDOException $e){ die('An error occured: '.$e); };
    }
?>

<link rel="stylesheet" type="text/css" href="croppie.css">
<script type="text/javascript" src="croppie.js"></script>
<style type="text/css">
#page {
background: #FFF;
padding: 20px;
margin: 20px;
}

#demo-basic {
width: 246px;
height: 316px;
}
</style>

<script>
//492 * 633
var basic;
window.onload=function(){

	$(function() {
	  basic = $('#demo-basic').croppie({
		viewport: {
		  width: 172, 
		  height: 221
		}
		,enableOrientation: true
		,enableZoom: true
	  });
	  basic.croppie('bind', {
		//url: 'me2.jpg'		
		//url: 'data:image/png;base64,...
		<?php
			//display photo
			$path = 'D:/xampp2/htdocs_data/' . $recordId . '.jpg';
			if (file_exists ($path)) {
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				echo "url: '".$base64."'";										
			}
		?>		
		//,points: [77, 469, 280, 739]
	  });
	});

	$('.upload-result').on('click', function (ev) {
			basic.croppie('result', {
				type: 'canvas',
				size: 'original'
			}).then(function (resp) {
				$('#imagebase64').val(resp);
                $('#form').submit();
			});
		});
}

</script>
  
  
	<div class="panel panel-default">
	  <div class="panel-heading">KADROWANIE ZDJĘCIA</div>
	  <div class="panel-body">

	  <div class="col-sm-8">
		<center>
		<div id="page">
		  <div id="demo-basic"></div>
		</div>
		</center>		   
  </div>   
  
  <div class="col-sm-4">
		<p><button class="upload-result btn btn-success btn-lg">Kadruj i zapisz zmiany</button></p>
		<form id="gotoAdminPhotoApprovals" action="adminPhotoApprovals.php" method="POST">
		  <input type="hidden" name='command' value="COMMAND_GO_TO_RECORD"/> 
		  <input type="hidden" name='recordId' value="<?php echo $recordId; ?>"/>
		</form>		
		<script>
			function goBack() {
				if ("<?php echo $caller; ?>"=="adminPhotoApprovals") {
					document.getElementById('gotoAdminPhotoApprovals').submit();
				} else {
					self.location.href='./photoUpload.php';
				}
			}
		</script>
		<input class="btn btn-info btn-lg" value="Powrót"  onclick="goBack();"  type="button"/>
		  <form id="form" action="photoCrop.php" method="POST">
			 <input type="hidden" id="imagebase64" name="imagebase64"/>
			 <input type="hidden" id="recordId" name='recordId' value="<?php echo $recordId; ?>"/>
			 <input type="hidden" id="caller" name='caller' value="<?php echo $caller; ?>"/>
			 <input type="hidden" name='command' value="COMMAND_SAVE_CROPPED_PICTURE"/>
		  </form>
  </div>   

	  </div>
	</div>
  
<?php
require_once "footer.php";
?>
