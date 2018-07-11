<?php
	session_start();
	require_once('../conn.php');
	require_once('funkcijep.php');
	if (!isset($_SESSION['ID']))
	{
		header('Location: ../index.php');
	}
	else{
	$idKorisnika = $_SESSION['ID'];
	}
	
	if (isset($_POST['btnRegist'])) {
	$_SESSION['txtNaziv'] = $_POST['txtNaziv'];
	$_SESSION['txtOpis'] = $_POST['txtOpis'];
    $_SESSION['txtPocCena'] = $_POST['txtPocCena'];
	$_SESSION['txtNacinPlacanja'] = $_POST['txtNacinPlacanja'];	
	$_SESSION['txtNacinIsporuke'] = $_POST['txtNacinIsporuke'];

	$_SESSION['txtVremeIsteka'] = $_POST['txtVremeIsteka'];

	}
	$rezultatSnimanja = '';
	$con = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
    if (isset($_POST['btnRegist']))
	{
		$registruj = array('naziv_predmeta' => mysqli_real_escape_string($con, $_POST['txtNaziv']), 'opis_predmeta' => mysqli_real_escape_string($con, $_POST['txtOpis']), 'pocetna_cena' => mysqli_real_escape_string($con, $_POST['txtPocCena']), 'nacin_placanja' => mysqli_real_escape_string($con, $_POST['txtNacinPlacanja']), 'nacin_isporuke' => mysqli_real_escape_string($con, $_POST['txtNacinIsporuke']), 'slika_predmeta' => mysqli_real_escape_string($con, $_POST['pslika']), 'vreme_isteka' => mysqli_real_escape_string($con, $_POST['txtVremeIsteka']));

	}

	if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$emailErr = "";
  
	if (!empty($_FILES["uploadedimage"]["name"])) {

    $file_name=$_FILES["uploadedimage"]["name"];

    $temp_name=$_FILES["uploadedimage"]["tmp_name"];

    $imgtype=$_FILES["uploadedimage"]["type"];

    $ext= GetImageExtension($imgtype);

    $imagename=date("d-m-Y")."-".time().$ext;

    $target_path = "../images/".$imagename;
	$img_path = "images/".$imagename;
	$_SESSION['prof_slika'] = $img_path;
	
		if(move_uploaded_file($temp_name, $target_path)) {

		if ((!empty($_POST["txtNaziv"]))&&(!empty($_POST["txtOpis"]))&&(!empty($_POST["txtPocCena"]))&&(is_numeric($_POST["txtPocCena"]))&&(!empty($_POST["txtNacinPlacanja"]))&&(!empty($_POST["txtNacinIsporuke"]))&&(!empty($_POST["txtVremeIsteka"]))&&(is_numeric($_POST["txtVremeIsteka"]))/*&&(!empty($_POST["uploadedimage"]))*/)
			{


		$query_upload='INSERT into predmet (id_korisnika_sk, naziv_predmeta, opis_predmeta, pocetna_cena, nacin_placanja, nacin_isporuke, slika_predmeta, vreme_postavljanja, vreme_isteka, trenutna_cena)' .
		'VALUES ("'. $idKorisnika .'", "'. $registruj['naziv_predmeta'] .'", "'. $registruj['opis_predmeta'] .'", "'. $registruj['pocetna_cena'] .'", "'. $registruj['nacin_placanja'] .'", "'. $registruj['nacin_isporuke'] . '", "'. $img_path . '", "'. time() . '", "'. vremeIsteka() . '", "'. $registruj['pocetna_cena'] .'")';
		$rezultatSnimanja = 'Aukcija je uspesno zapoceta<br />';
		$_SESSION['txtNaziv'] = $_SESSION['txtOpis'] = $_SESSION['txtPocCena'] = $_SESSION['txtNacinPlacanja'] = $_SESSION['txtNacinIsporuke'] = $_SESSION['prof_slika'] = $_SESSION['txtVremePostavljanja'] = $_SESSION['txtVremeIsteka'] = "";

		mysqli_query($con, $query_upload) or die("error in $query_upload == ----> ".mysqli_error($con)); 

			}
			else
			{
				mysqli_close($con);
			}
		}
	}
	else if (empty($_FILES["uploadedimage"]["name"]))
		{

		if ((!empty($_POST["txtNaziv"]))&&(!empty($_POST["txtOpis"]))&&(!empty($_POST["txtPocCena"]))&&(is_numeric($_POST["txtPocCena"]))&&(!empty($_POST["txtNacinPlacanja"]))&&(!empty($_POST["txtNacinIsporuke"]))&&(!empty($_POST["txtVremeIsteka"]))&&(is_numeric($_POST["txtVremeIsteka"]))/*&&(!empty($_POST["uploadedimage"]))*/)
			{
			

		$query_upload='INSERT into predmet (id_korisnika_sk, naziv_predmeta, opis_predmeta, pocetna_cena, nacin_placanja, nacin_isporuke, vreme_postavljanja, vreme_isteka, trenutna_cena)' .
		'VALUES ("'. $idKorisnika .'", "'. $registruj['naziv_predmeta'] .'", "'. $registruj['opis_predmeta'] .'", "'. $registruj['pocetna_cena'] .'", "'. $registruj['nacin_placanja'] .'", "'. $registruj['nacin_isporuke'] . '", "'. time()  . '", "'. vremeIsteka() . '", "'. $registruj['pocetna_cena'] .'")';
		
		
		

    mysqli_query($con, $query_upload) or die("error in $query_upload == ----> ".mysqli_error($con)); 
    $rezultatSnimanja = 'Aukcija je uspesno zapoceta<br />';
			$_SESSION['txtNaziv'] = $_SESSION['txtOpis'] = $_SESSION['txtPocCena'] = $_SESSION['txtNacinPlacanja'] = $_SESSION['txtNacinIsporuke'] = $_SESSION['prof_slika'] = $_SESSION['txtVremePostavljanja'] = $_SESSION['txtVremeIsteka'] = "";

		
		}
	}
	else{
		exit("Error While uploading image on the server");
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Aukcija.net</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
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
<?php
	$nazivErr = $opisErr = $pocCenaErr = $nacinPlacanjaErr = $nacinIsporukeErr = $slikaErr = $vremePostavljanjaErr = $vremeIstekaErr = "";
	$naziv = $opis = $pocCena = $nacinPlacanja = $nacinIsporuke = $slika = $vremePostavljanja = $vremeIsteka = "";


	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
	if (empty($_POST["txtNaziv"])) {
    $nazivErr = "Naziv je obavezan";
	} 	
	else {
    $naziv = test_input($_POST["txtNaziv"]);
	}
	if (empty($_POST["txtOpis"])) {
    $opisErr = "Opis je obavezan";
	} 
	else {
    $opis = test_input($_POST["txtOpis"]);
	}
	
	if (empty($_POST["txtPocCena"])) {
    $pocCenaErr = "Pocetna cena je obavezna";}
	else if (!is_numeric($_POST["txtPocCena"])){
	$pocCenaErr = "Pocetna cena mora biti broj";
	} else {
    $pocCena = test_input($_POST["txtPocCena"]);
	}
		
	
	if (empty($_POST["txtNacinPlacanja"])) {
    $nacinPlacanjaErr = "Nacin placanja je obavezan";
	} else {
    $nacinPlacanja = test_input($_POST["txtNacinPlacanja"]);
	}	
	if (empty($_POST["txtNacinIsporuke"])) {
    $nacinIsporukeErr = "Nacin isporuke je obavezan";
	} else {
    $nacinIsporuke = test_input($_POST["txtNacinIsporuke"]);
	}
if (!empty($_POST["uploadedimage"])) {
    $slika = test_input($_POST["uploadedimage"]);
	}
	else {
    $slika = test_input($_POST["pslika"]);
	}

	if (empty($_POST["txtVremeIsteka"])) {
    $vremeIstekaErr = "Vreme isteka je obavezno";}
	else if (!is_numeric($_POST["txtVremeIsteka"])){
	$vremeIstekaErr = "Vreme trajanja mora biti broj";
	} else {
    $vremeIsteka = test_input($_POST["txtVremeIsteka"]);
	}

  }
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
?>
<div class="content">
<div class="content2">
<div class="form-group">
	<form action="dodajAukciju.php" enctype="multipart/form-data" method="post">
	<br><br>
	<h3>Dodavanje aukcije</h3>
	<?php
	if (isset($_POST['btnRegist']))
	{
		echo('<p style="text-align: center;">');
		echo($rezultatSnimanja);
		echo('</p>');
	}
	?>
			<br>
			<label>Naziv predmeta:  </label><span class="error"> <?php echo $nazivErr;?></span>
            <input type="text" class="form-control" placeholder="Naziv premeta" value="<?php echo isset($_SESSION['txtNaziv']) ? $_SESSION['txtNaziv'] : ''; ?>" name="txtNaziv">
			<br>
			<label>Opis predmeta:  </label><span class="error"><?php echo $opisErr;?></span>
			<textarea rows="4" cols="50" class="form-control" placeholder="unesite opis predmeta" name="txtOpis"><?php echo isset($_SESSION['txtOpis']) ? $_SESSION['txtOpis'] : ''; ?></textarea>
			<br>
			<label>Pocetna cena:  </label><span class="error"> <?php echo $pocCenaErr;?></span>
            <input type="text" class="form-control" placeholder="unesite pocetnu cenu" value="<?php echo isset($_SESSION['txtPocCena']) ? $_SESSION['txtPocCena'] : ''; ?>" name="txtPocCena">
			<br>
			<label>Nacin placanja:  </label><span class="error"> <?php echo $nacinPlacanjaErr;?></span>
            <input type="text" class="form-control" placeholder="unesite nacin placanja" value="<?php echo isset($_SESSION['txtNacinPlacanja']) ? $_SESSION['txtNacinPlacanja'] : ''; ?>" name="txtNacinPlacanja">
			<br>
			<label>Nacin isporuke:  </label><span class="error"> <?php echo $nacinIsporukeErr;?></span>
            <input type="text" class="form-control" placeholder="unesite nacin isporuke" value="<?php echo isset($_SESSION['txtNacinIsporuke']) ? $_SESSION['txtNacinIsporuke'] : ''; ?>" name="txtNacinIsporuke">
			<br>
			<label>Slika predmeta:</label><br><?php //echo isset($_SESSION['prof_slika']) ? $_SESSION['prof_slika'] : ''; ?>
			<input type="hidden" value="<?php echo isset($_SESSION['prof_slika']) ? $_SESSION['prof_slika'] : ''; ?>" name="pslika">
			<input name="uploadedimage" class="form-control" class="btn btn-default" type="file"><span class="error"> <?php echo $slikaErr;?></span>

			

			<br>
			<label>Trajanje aukcije u danima:  </label><span class="error"> <?php echo $vremeIstekaErr;?></span>
            <input type="text" class="form-control" placeholder="unesite trajanje aukcije" value="<?php echo isset($_SESSION['txtVremeIsteka']) ? $_SESSION['txtVremeIsteka'] : ''; ?>" name="txtVremeIsteka">
			<br>
			<input type="submit" name="btnRegist" class="form-control" value="Pošalji"/>
			</form>		
            </div>
		</div>
	</div>
</div>
</body>
</html>