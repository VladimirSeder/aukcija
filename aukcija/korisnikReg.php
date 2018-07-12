<?php
	session_start();
	require_once('funkcijep.php');
	require_once('conn.php');
	if (isset($_POST['btnRegist'])) {
	$_SESSION['txtEmail'] = $_POST['txtEmail'];
	$_SESSION['txtSifra'] = $_POST['txtSifra'];
    $_SESSION['txtIme'] = $_POST['txtIme'];
	$_SESSION['txtPrezime'] = $_POST['txtPrezime'];	
	$_SESSION['txtAdresa'] = $_POST['txtAdresa'];
	$_SESSION['txtTelefon'] = $_POST['txtTelefon'];
	$_SESSION['txtOdgovor'] = $_POST['txtOdgovor'];
	}
	$rezultatSnimanja = '';
	$con = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
    if (isset($_POST['btnRegist']))
	{
		$registruj = array('email_korisnika' => mysqli_real_escape_string($con, $_POST['txtEmail']), 'sifra_korisnika' => mysqli_real_escape_string($con, $_POST['txtSifra']), 'ime_korisnika' => mysqli_real_escape_string($con, $_POST['txtIme']), 'prezime_korisnika' => mysqli_real_escape_string($con, $_POST['txtPrezime']), 'adresa_korisnika' => mysqli_real_escape_string($con, $_POST['txtAdresa']), 'telefon_korisnika' => mysqli_real_escape_string($con, $_POST['txtTelefon']), 'profilna_slika' => mysqli_real_escape_string($con, $_POST['pslika']), 'pitanje' => mysqli_real_escape_string($con, $_POST['txtPitanje']), 'odgovor' => mysqli_real_escape_string($con, $_POST['txtOdgovor']));
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

    $target_path = "images/".$imagename;
	$_SESSION['prof_slika'] = $target_path;
	
		if(move_uploaded_file($temp_name, $target_path)) {
		if ((!empty($_POST["txtEmail"])&&(filter_var($_POST["txtEmail"], FILTER_VALIDATE_EMAIL)))&&(!empty($_POST["txtSifra"])&&(strlen($_POST["txtSifra"]) > '6'))&&(!empty($_POST["txtIme"]))&&(!empty($_POST["txtPrezime"]))&&(!empty($_POST["txtAdresa"]))&&(!empty($_POST["txtTelefon"]))&&(!empty($_POST["txtPitanje"]))&&(!empty($_POST["txtOdgovor"])))
			{
			if($_POST["txtEmail"] == $emailcheck["email_korisnika"])
				{
				$emailErr = "Email vec postoji";
				}
		else{
		$registruj['sifra_korisnika'] = password_hash($registruj['sifra_korisnika'], PASSWORD_DEFAULT);
		$registruj['odgovor'] = password_hash($registruj['odgovor'], PASSWORD_DEFAULT);
		$query_upload='INSERT into korisnik (email_korisnika, sifra_korisnika, ime_korisnika, prezime_korisnika, adresa_korisnika, telefon_korisnika, profilna_slika, pitanje, odgovor)' .
		'VALUES ("'. $registruj['email_korisnika'] .'", "'. $registruj['sifra_korisnika'] .'", "'. $registruj['ime_korisnika'] .'", "'. $registruj['prezime_korisnika'] .'", "'. $registruj['adresa_korisnika'] . '", "'. $registruj['telefon_korisnika'] . '", "'. $target_path . '", "'. $registruj['pitanje'] . '", "'. $registruj['odgovor'] . '")';
		$rezultatSnimanja = 'Korisnik je dodat u bazu<br />';
		$_SESSION['txtEmail'] = $_SESSION['txtSifra'] = $_SESSION['txtIme'] = $_SESSION['txtPrezime'] = $_SESSION['txtAdresa'] = $_SESSION['txtTelefon'] = $_SESSION['prof_slika'] = $_SESSION['txtOdgovor']= "";

		mysqli_query($con, $query_upload) or die("error in $query_upload == ----> ".mysqli_error($con)); 
		}
			}
			else
			{
				mysqli_close($con);
			}
		}
	}
	else if (empty($_FILES["uploadedimage"]["name"]))
		{
		if ((!empty($_POST["txtEmail"])&&(filter_var($_POST["txtEmail"], FILTER_VALIDATE_EMAIL)))&&(!empty($_POST["txtSifra"])&&(strlen($_POST["txtSifra"]) > '6'))&&(!empty($_POST["txtIme"]))&&(!empty($_POST["txtPrezime"]))&&(!empty($_POST["txtAdresa"]))&&(!empty($_POST["txtTelefon"]))&&(!empty($_POST["txtPitanje"]))&&(!empty($_POST["txtOdgovor"])))
			{
			if($_POST["txtEmail"] == $emailcheck["email_korisnika"])
		{
		$emailErr = "Email vec postoji";
		}	
	else{	
		$registruj['sifra_korisnika'] = password_hash($registruj['sifra_korisnika'], PASSWORD_DEFAULT);
		$registruj['odgovor'] = password_hash($registruj['odgovor'], PASSWORD_DEFAULT);
		$query_upload='INSERT into korisnik (email_korisnika, sifra_korisnika, ime_korisnika, prezime_korisnika, adresa_korisnika, telefon_korisnika, pitanje, odgovor)' .
		'VALUES ("'. $registruj['email_korisnika'] .'", "'. $registruj['sifra_korisnika'] .'", "'. $registruj['ime_korisnika'] .'", "'. $registruj['prezime_korisnika'] .'","'. $registruj['adresa_korisnika'] . '","'. $registruj['telefon_korisnika'] . '", "'. $registruj['pitanje'] . '", "'. $registruj['odgovor'] . '")';

    mysqli_query($con, $query_upload) or die("error in $query_upload == ----> ".mysqli_error($con)); 
    $rezultatSnimanja = 'Korisnik je dodat u bazu<br />';
	$_SESSION['txtEmail'] = $_SESSION['txtSifra'] = $_SESSION['txtIme'] = $_SESSION['txtPrezime'] = $_SESSION['txtAdresa'] = $_SESSION['txtTelefon'] = $_SESSION['prof_slika'] = $_SESSION['txtOdgovor']="";
			}
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
  <link rel="stylesheet" href="css/style.css">
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
	$sifraErr = $imeErr = $prezimeErr = $adresaErr =$telefonErr = $slikaErr =  $odgovorErr = "";
	$email = $sifra = $ime = $prezime = $adresa =$telefon = $slika = $odgovor = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
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
	if (empty($_POST["txtIme"])) {
    $imeErr = "Ime je obavezno";
	} else {
    $ime = test_input($_POST["txtIme"]);
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
	if (empty($_POST["txtOdgovor"])) {
    $odgovorErr = "Odgovor je obavezan";
	} else {
    $odgovor = test_input($_POST["txtOdgovor"]);
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
	<form action="korisnikReg.php" enctype="multipart/form-data" method="post">
	<br><br>
	<h3>Registracija korisnika</h3>
	<?php
	if (isset($_POST['btnRegist']))
	{
		echo('<p style="text-align: center;">');
		echo($rezultatSnimanja);
		echo('</p>');
	}
	?>
			<br>
			<label>Email:  </label><span class="error"> <?php echo $emailErr;?></span>
            <input type="text" class="form-control" placeholder="email" value="<?php echo isset($_SESSION['txtEmail']) ? $_SESSION['txtEmail'] : ''; ?>" name="txtEmail">
			<br>
			<label>Sifra:  </label><span class="error"> <?php echo $sifraErr;?></span>
            <input type="password" class="form-control" placeholder="sifra" value="<?php echo isset($_SESSION['txtSifra']) ? $_SESSION['txtSifra'] : ''; ?>" name="txtSifra">
			<br>
			<label>Ime:  </label><span class="error"> <?php echo $imeErr;?></span>
            <input type="text" class="form-control" placeholder="unesite ime" value="<?php echo isset($_SESSION['txtIme']) ? $_SESSION['txtIme'] : ''; ?>" name="txtIme">
			<br>
			<label>Prezime:  </label><span class="error"> <?php echo $prezimeErr;?></span>
            <input type="text" class="form-control" placeholder="unesite prezime" value="<?php echo isset($_SESSION['txtPrezime']) ? $_SESSION['txtPrezime'] : ''; ?>" name="txtPrezime">
			<br>
			<label>Adresa:  </label><span class="error"> <?php echo $adresaErr;?></span>
            <input type="text" class="form-control" placeholder="unesite vasu adresu" value="<?php echo isset($_SESSION['txtAdresa']) ? $_SESSION['txtAdresa'] : ''; ?>" name="txtAdresa">
			<br>
			<label>Telefon:  </label><span class="error"> <?php echo $telefonErr;?></span>
            <input type="text" class="form-control" placeholder="unesite telefon" value="<?php echo isset($_SESSION['txtTelefon']) ? $_SESSION['txtTelefon'] : ''; ?>" name="txtTelefon">						
			<br>
			<label>Profilna slika:</label><br>
			<input type="hidden" value="<?php echo isset($_SESSION['prof_slika']) ? $_SESSION['prof_slika'] : ''; ?>" name="pslika">
			<input name="uploadedimage" class="form-control" class="btn btn-default" type="file"><span class="error"> <?php echo $slikaErr;?></span>
            <br>
			<label>Sigurnosno pitanje:  </label> (sluzi za resetovanje sifre)<br>
			<select name="txtPitanje" class="form-control" id="txtPitanje">
						<option selected="selected">Koja je tvoja omiljena knjiga?</option>
                        <option>Model tvog prvog automobila?</option>
                        <option>Ime kucnog ljubimca?</option>
                        <option>Omiljeni lik iz filma?</option>
            </select>
			<br>		  
			<label>Odgovor:  </label><span class="error"> <?php echo $odgovorErr;?></span><br>
            <input type="password" class="form-control" placeholder="unesite odgovor" value="<?php echo isset($_SESSION['txtOdgovor']) ? $_SESSION['txtOdgovor'] : ''; ?>" name="txtOdgovor">
			<br>
			<input type="submit" name="btnRegist" class="form-control" value="Pošalji"/>
			</form>		
            </div>
		</div>
	</div>
</div>
</body>
</html>