<?php
	session_start();
	require_once('../conn.php');
	require_once('funkcijep.php');
	if (!isset($_SESSION['ID']))
	{
		header('Location: ../index.php');
	}
	if (isset($_POST['btnEditprofil']))
	{
		$sesijaf = trim($_POST['txtid_sifra']);
		$_SESSION['profil'] = $sesijaf;
		header('Location: editProfil.php');
	}
	else if (isset($_POST['btnObrisiProfil']))
	{
		
		$rezultatBrisanja = obrisiKorisnika($_POST['txtid_sifra']);
		unset($_SESSION['ID']);
		session_destroy();
		header('Location: ../index.php');
	}
	$rezultatCitanja = ucitajKorisnika();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Aukcija.net</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script language="JavaScript" type="text/javascript"></script>
  <link rel="stylesheet" href="../css/style.css"></script>
  <script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Da li ste sigurni da zelite da obrisete profil?');
}
</script>
</head>
<body>
<?php 
include "header.php"
?>
<?php 
include "menu.php"
?>
<div class="glavni">
<div class="left">
<?php
include "left.php"
?>
</div>
<div class="content">
<?php
$ID=$_SESSION['ID'];
$con = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
$sql = "select * from korisnik where id_korisnika ='".$_SESSION['ID']."'  ";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result)
?>
<div class="box2" >
	<div class="content1">
	<div class="nf" >
	<?php	
	echo('<br><span class="ime"><h2>'. $row['ime_korisnika'] . '</h2><br>');
	echo('</div>	
	<div class="of" >');
	echo('<span class="prezime"><h2 id="hm">' . $row['prezime_korisnika'] . '</h2></span><br>');
	echo('<h4>Email</h4>');
	echo('<span class="telefon">' . str_replace(" qh ","<br>",$row['email_korisnika']) . '</span>');	
	echo('<h4>Adresa</h4>');
	echo('<span class="telefon">' . str_replace(" qh ","<br>",$row['adresa_korisnika']) . '</span>');
	echo('<h4>Telefon</h4>');
	echo('<span class="telefon">' . str_replace(" qh ","<br>",$row['telefon_korisnika']) . '</span>');	
	echo('</div>
	</div>
	<div class="content22">
	<div class="sf">');
	echo('<img src="../' . $row['profilna_slika'] . '">');
	echo('</div>
	<div class="kf" >');			
	echo('<form action="'. $_SERVER['PHP_SELF'] .'" method="post">');
	echo('<input type="hidden" name="txtid_sifra" value="'. $row['id_korisnika'] .'" />'); 
	echo('<input class="form-control2" id="dugme" type="submit" name="btnObrisiProfil" value="Obrisite profil" onclick="return checkDelete()"/>'); 
	echo('<input class="form-control2" id="dugme" type="submit" name="btnEditprofil" value="Izmenite profil" />');	
	echo('</form>');
	?>
	</div>
	</div>	
</div>
</div>
</div>
</body>
</html>