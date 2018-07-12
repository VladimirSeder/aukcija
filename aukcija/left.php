<?php
if(!isset($_SESSION)) {
     session_start();
}
require_once('conn.php');
$loginErr="";
	if (isset($_POST['button'])) {
	$_SESSION['txtEmail'] = $_POST['txtEmail'];

	$con = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
	
if(empty($_POST['txtEmail']) || empty($_POST['txtPass']))
{
	$loginErr = "Unesite email i sifru";	
}
else
{
	$Email = mysqli_real_escape_string($con, $_POST['txtEmail']);
	$Password = mysqli_real_escape_string($con, $_POST['txtPass']);
	$query = "SELECT * FROM korisnik WHERE email_korisnika = '".$Email."'";
	$result = mysqli_query($con, $query);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
			if(password_verify($Password, $row["sifra_korisnika"]))
			{
				$_SESSION['ID']=$row['id_korisnika'];
$_SESSION['Name']=$row['ime_korisnika'];
$_SESSION['email']=$row['email_korisnika'];
$_SESSION['txtEmail'] = "";
header("location:korisnik/index.php");
			}
			else
			{
				$loginErr = "Pogresna sifra";
			}
		}
	}
	else
	{
		$loginErr = "Nepostojeci email";
	}
}

mysqli_close($con);

	}

?>
<div class="left2">
<div class="form-group">
<h3 align="center">Login</h3>
	<form name="form1" method="post" action="index.php">
		<br>
			<label>Email:  </label><span id="sprytextfield1"></span>
            <input type="text" class="form-control" placeholder="email" value="<?php echo isset($_SESSION['txtEmail']) ? $_SESSION['txtEmail'] : ''; ?>" name="txtEmail" id="txtEmail">
			<span class="textfieldRequiredMsg"></span>
			<br>
			<label>Šifra:  </label><span id="sprytextfield2"></span>
            <input type="password" class="form-control" placeholder="šifra" name="txtPass" id="txtPass">
			<span class="textfieldRequiredMsg"></span>
			
						  <br><br>
						  <input type="submit" name="button" id="button"  class="form-control"value="Login">
						  <br>
						  <span><?php echo $loginErr.'<br>';?></span>
						  
			<a href="sifra.php" align="center" >Zaboravljena šifra</a>

	 </form>
    </div>			  
</div>

