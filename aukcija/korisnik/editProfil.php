<?php
	session_start();
	require_once('../conn.php');
	require_once('funkcijep.php');
	if (!isset($_SESSION['ID']))
	{
		header('Location: ../index.php');
	}
	if (!isset($_SESSION['profil']))
	{
		header('Location: profil.php');
	}
	else if (isset($_SESSION['profil']))
	{
		$sesijaf = $_SESSION['profil'];
	}
	$rezultatCitanja = ucitajKorisnika();
	$rezultatSnimanja = '';
	$con = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
    if (isset($_POST['btnRegist']))
	{
		$registruj = array('ime_korisnika' => mysqli_real_escape_string($con, $_POST['txtIme']), 'email_korisnika' => mysqli_real_escape_string($con, $_POST['txtEmail']), 'sifra_korisnika' => mysqli_real_escape_string($con, $_POST['txtSifra']), 'prezime_korisnika' => mysqli_real_escape_string($con, $_POST['txtPrezime']), 'adresa_korisnika' => mysqli_real_escape_string($con, $_POST['txtAdresa']), 'telefon_korisnika' => mysqli_real_escape_string($con, $_POST['txtTelefon']), 'profilna_slika' => mysqli_real_escape_string($con, $_POST['pslika']));
		$emailquery = "SELECT email_korisnika FROM korisnik WHERE email_korisnika = '".$_POST['txtEmail']."'";
		$emailquery = mysqli_query($con, $emailquery);
		$emailcheck = mysqli_fetch_assoc($emailquery);
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

	if(move_uploaded_file($temp_name, $target_path)) {
	if ((!empty($_POST["txtIme"]))&&(!empty($_POST["txtEmail"])&&(filter_var($_POST["txtEmail"], FILTER_VALIDATE_EMAIL)))&&(!empty($_POST["txtSifra"])&&(strlen($_POST["txtSifra"]) > '6'))&&(!empty($_POST["txtPrezime"]))&&(!empty($_POST["txtAdresa"]))&&(!empty($_POST["txtTelefon"])))
		{
			if(($_POST["txtEmail"] == $emailcheck["email_korisnika"])&&($_POST["txtEmail"] != $_SESSION["email"]))
		{
			$emailErr = "Email vec postoji";
		}
	else{	
	if(strlen($_POST["txtSifra"]) < 45)
	{
		$registruj['sifra_korisnika'] = password_hash($registruj['sifra_korisnika'], PASSWORD_DEFAULT);
	}
		$query_upload='UPDATE korisnik SET ime_korisnika = "' . $registruj['ime_korisnika'] .'", email_korisnika = "' . $registruj['email_korisnika'] .'", sifra_korisnika = "' . $registruj['sifra_korisnika'] .'", prezime_korisnika ="'.$registruj['prezime_korisnika'].'", adresa_korisnika = "'.$registruj['adresa_korisnika'].'", telefon_korisnika = "'.$registruj['telefon_korisnika'].'", profilna_slika = "'.substr($target_path, 3).'" WHERE id_korisnika = "'.$sesijaf.'"';
	$_SESSION['email']=$registruj['email_korisnika'];
    mysqli_query($con, $query_upload) or die("error in $query_upload == ----> ".mysqli_error($con)); 
	$_SESSION['Name'] = $registruj['ime_korisnika'];
    $rezultatSnimanja = 'Korisnik je dodat u bazu<br />';
	header('Location: profil.php');
	}}
			else
			{
				$rezultatSnimanja = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
				mysqli_close($con);
			}
	}
}
else if (empty($_FILES["uploadedimage"]["name"]))
{
	if ((!empty($_POST["txtIme"]))&&(!empty($_POST["txtEmail"])&&(filter_var($_POST["txtEmail"], FILTER_VALIDATE_EMAIL)))&&(!empty($_POST["txtSifra"])&&(strlen($_POST["txtSifra"]) > '6'))&&(!empty($_POST["txtPrezime"]))&&(!empty($_POST["txtAdresa"]))&&(!empty($_POST["txtTelefon"])))
		{
			if(($_POST["txtEmail"] == $emailcheck["email_korisnika"])&&($_POST["txtEmail"] != $_SESSION["email"]))
		{
			$emailErr = "Email vec postoji";
		}
	else{	
	if(strlen($_POST["txtSifra"]) < 45)
	{
		$registruj['sifra_korisnika'] = password_hash($registruj['sifra_korisnika'], PASSWORD_DEFAULT);
	}
		$query_upload='UPDATE korisnik SET ime_korisnika = "' . $registruj['ime_korisnika'] .'", email_korisnika = "' . $registruj['email_korisnika'] .'", sifra_korisnika = "' . $registruj['sifra_korisnika'] .'", prezime_korisnika ="'.$registruj['prezime_korisnika'].'", adresa_korisnika = "'.$registruj['adresa_korisnika'].'", telefon_korisnika = "'.$registruj['telefon_korisnika'].'" WHERE id_korisnika = "'.$sesijaf.'"';
	$_SESSION['email']=$registruj['email_korisnika'];
    mysqli_query($con, $query_upload) or die("error in $query_upload == ----> ".mysqli_error($con)); 
	$_SESSION['Name'] = $registruj['ime_korisnika'];
    $rezultatSnimanja = 'Korisnik je dodat u bazu<br />';
	header('Location: profil.php');
		}
     }
}
else
{
   exit("Error While uploading image on the server");
}	
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
	$imeErr = $sifraErr = $prezimeErr = $adresaErr = $telefonErr = $slikaErr = "";
	$ime = $email = $sifra = $prezime = $adresa = $telefon = $slika = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
	if (empty($_POST["txtIme"])) {
    $imeErr = "Ime je obavezno";
	} else {
    $ime = test_input($_POST["txtIme"]);
	}	
	if (empty($_POST["txtEmail"])) {
	$emailErr = "Email je obavezan";
	} 
	else if (!filter_var($_POST["txtEmail"], FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Unesite validan email"; 
    }
	else {
    $email = test_input($_POST["txtEmail"]);
	}
	if (empty($_POST["txtSifra"])) {
	$sifraErr = "Sifra je obavezna";
	} 
	else if (strlen($_POST["txtSifra"]) < '7') {
    $sifraErr = "Sifra mora imati barem 7 karaktera";
    }
	else {
    $sifra = test_input($_POST["txtSifra"]);
	}	
	if (empty($_POST["txtPrezime"])) {
    $prezimeErr = "Prezime je obavezno";
	} else {
    $prezime = test_input($_POST["txtPrezime"]);
	}
	if (empty($_POST["txtAdresa"])) {
    $adresaErr = "Adresa je obavezna";
	} else {
    $adresa = test_input($_POST["txtAdresa"]);
	}
	if (empty($_POST["txtTelefon"])) {
    $telefonErr = "Telefon je obavezan";
	} else {
    $telefon = test_input($_POST["txtTelefon"]);
	}
	if (!empty($_POST["uploadedimage"])) {
    $slika = test_input($_POST["uploadedimage"]);
	}
	else {
    $slika = test_input($_POST["pslika"]);
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
	<form action="editProfil.php" enctype="multipart/form-data" method="post">
	
	<h3>Forma za editovanje profila</h3>
	<?php	
	if (isset($_POST['btnRegist']))
	{
		echo('<p style="text-align: center;">');
		echo($rezultatSnimanja);
		echo('</p>');
	}
	?>
	<?php
		while ($red = mysqli_fetch_array($rezultatCitanja))
		{
			if ($_SESSION['ID'] == $red['id_korisnika'])
			{
				?>
			<br>
			<label>Ime: </label><span class="error"> <?php echo $imeErr;?></span>
            <input type="text"  class="form-control" value="<?php echo $red['ime_korisnika'] ?>" placeholder="unesite ime" name="txtIme">
			<br>
			<label>Prezime: </label><span class="error"><?php echo $prezimeErr;?></span>
			<input type="text"  class="form-control" value="<?php echo $red['prezime_korisnika'] ?>" placeholder="unesite prezime" name="txtPrezime">
			<br>
			<label>Adresa: </label><span class="error"> <?php echo $adresaErr;?></span><br>
			<input type="text"  class="form-control" value="<?php echo $red['adresa_korisnika'] ?>" placeholder="unesite vasu adresu" name="txtAdresa">			
            <br>
			<label>Telefon: </label><span class="error"> <?php echo $telefonErr;?></span><br>
			<input type="text"  class="form-control" value="<?php echo $red['telefon_korisnika'] ?>" placeholder="unesite telefon" name="txtTelefon">			
			<br>
			<label>Profilna slika:</label><br>
			<img src="../<?php echo $red['profilna_slika'] ?>" id="lg">
			<input type="hidden" value="<?php echo $red['profilna_slika'] ?>" name="pslika">
			<input name="uploadedimage" class="form-control" type="file"><span class="error"><?php echo $slikaErr;?></span>
            <br>
			<label>Email: </label><span class="error"> <?php echo $emailErr;?></span>
            <input type="text"  class="form-control" value="<?php echo $red['email_korisnika'] ?>" placeholder="unesite email" name="txtEmail">
			<br>
			<label>Sifra: </label><span class="error"> <?php echo $sifraErr;?></span>
            <input type="password"  class="form-control" value="<?php echo $red['sifra_korisnika'] ?>" placeholder="unesite sifru" name="txtSifra">
			<br>
			<input type="submit" class="form-control" name="btnRegist"  value="Pošalji"/>
			</form>
			<?php }}	?>
			</div>
			</div>
		</div>
	</div>
</body>
</html>