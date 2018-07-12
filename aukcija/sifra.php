<?php
	session_start();
	require_once('conn.php');
	$resetErr="";
	if (isset($_POST['button2'])) {
		$_SESSION['txtEmail2'] = $_POST['txtEmail'];	

$con = mysqli_connect($hostname,$dbusername,$dbpassword,$database);

if(empty($_POST['txtEmail']) || empty($_POST['txtOdgovor']))
{
	$resetErr = "Unesite email i odgovor";
}
else
{
	$Email = mysqli_real_escape_string($con, $_POST['txtEmail']);
	$Odgovor = mysqli_real_escape_string($con, $_POST['txtOdgovor']);
	$query = "SELECT * FROM korisnik WHERE email_korisnika = '".$Email."'";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
			if(password_verify($Odgovor, $row["odgovor"]))
			{
				$_SESSION['ID']=$row['id_korisnika'];
$_SESSION['Name']=$row['ime_korisnika'];
$_SESSION['email']=$row['email_korisnika'];
$_SESSION['txtEmail2'] = "";
header("location:korisnik/index.php");
			}
			else
			{
				$resetErr = "Pogresan odgovor";
			}
		}
	}
	else
	{
		$resetErr = "Nepostojeci email";
	}	
}
mysqli_close($con);
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
  <link rel="stylesheet" href="css/style.css"></script>
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
<div class="content2">
<form id="form2" method="post" action="sifra.php">
<br>			
			<label>Email:  </label>
            <input type="text" class="form-control" placeholder="email" value="<?php echo isset($_SESSION['txtEmail2']) ? $_SESSION['txtEmail2'] : ''; ?>" name="txtEmail">
			<br>
			<label>Sigurnosno pitanje:  </label>
            <select name="cmbQue" class="form-control" id="cmbQue">
						<option selected="selected">Koja je tvoja omiljena knjiga?</option>
                        <option>Model tvog prvog automobila?</option>
                        <option>Ime kucnog ljubimca?</option>
                        <option>Omiljeni lik iz filma?</option>
            </select>
			<br>
			<label>Odgovor:  </label>
            <input type="password" class="form-control" placeholder="unesite odgovor" name="txtOdgovor">
			<br>	<span><?php echo $resetErr.'<br>';?></span>		
			<input type="submit" name="button2" class="form-control" value="Pošalji"/>
</form>
</div>
</div>
</div>
</body>
</html>