<?php
	session_start();
	require_once('../conn.php');
	require_once('funkcijep.php');
	$rezultatCitanja = ucitajSAukciju();
	$rezultatCitanjaP = ucitajPonude();
	if (!isset($_SESSION['ID']))
	{
		header('Location: index.php');
	}
	if (!isset($_SESSION['aukcija']))
	{
		header('Location: aukcije.php');
	}
	else if (isset($_SESSION['aukcija']))
	{
		$sesijao = $_SESSION['aukcija'];
	}
	$rezultatSnimanja = '';
	$_SESSION['txtPonuda'] = "";
	header("Refresh:60");
	
	
	if (isset($_POST['btnPonuda'])) {
		$_SESSION['txtPonuda'] = $_POST['txtPonuda'];

	}
	$rezultatSnimanja = '';
	$con = mysqli_connect($hostname,$dbusername,$dbpassword,$database);

	
	
		
		

	
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
	$db = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
?>
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
<div class="box2" >
<div class="content1">
	<div class="nf" >
	<?php
	//if (is_resource($rezultatCitanja))
	//{
		while ($red = mysqli_fetch_array($rezultatCitanja))
		{
			if ($sesijao == $red['id_predmeta'])
			{	
	echo('<form action="'. $_SERVER['PHP_SELF'] .'" method="post">'); 

	echo('<span class="naslov"><h2>'. $red['naziv_predmeta'] . '</h2><br>');
	echo('</div>
	<br>
	<div class="of" >
	<h4>Opis oglasa</h4>');
	echo('<span class="opis">' . str_replace("/br","<br>",$red['opis_predmeta']) . '</span><br><br>');

	echo('</div>
	</div>
	<div class="content22">
	<div class="sf">');
	echo('<img src="../' . $red['slika_predmeta'] . '">');

	echo('</form>');
	echo('</div>
	<div class="kf" >');
	
	$tv = time();
		 $vi = $red['vreme_isteka'];
		 $pv = $vi - $tv;
		if ($pv < 1)
			 $pv = 0 . "s";
		 else if($pv < 60)
			  $pv = round ($pv) . "s";
		  else if($pv < 3600)
			  $pv = round ($pv/60) . "m";
		  else if($pv < 86400)
			  $pv = round ($pv/3600) . "h";
		  else
			  $pv = round ($pv/86400) . "d";
		  
		  echo('<span class="trenutnaCena">Nacin placanja: ' . $red['nacin_placanja'] .' rsd </span><br>');
		  echo('<span class="trenutnaCena">Nacin isporuke: ' . $red['nacin_isporuke'] .' rsd </span><br>');
		  
		  echo('<span class="trenutnaCena">Trenutna cena: ' . $red['trenutna_cena'] .' rsd </span><br>');				
				
				echo('<span class="trenutnaCena">Preostalo vreme: '. $pv  . '</span><br>');
				
				echo('<form action="oAukciji.php" enctype="multipart/form-data" method="post">');
				if($red['id_korisnika_sk']!=$_SESSION['ID']&&$pv>0){
				echo('<input type="text" class="form-control" placeholder="Unesite ponudu" name="txtPonuda">');
				echo('<input type="submit" name="btnPonuda" class="form-control" value="Pošalji"/></form>');
				}
				else if($red['id_korisnika_sk']==$_SESSION['ID']){
					
					$db = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
	//if (is_resource($rezultatCitanjaP))
	//{
		$ukupnoPonuda = mysqli_num_rows($rezultatCitanjaP);
		if ($ukupnoPonuda > 0&&$red['vreme_isteka']>$tv)
		{
			echo('<span>Najvise ponude:</span><ul>');
			while ($redP = mysqli_fetch_array($rezultatCitanjaP))
			{

				echo('<li>'. $redP['ime_korisnika'] .' '. $redP['prezime_korisnika'] .' '. $redP['vrednost_ponude'] .'</li>');
			}	
			echo('</ul>');
		}
		else if ($ukupnoPonuda > 0&&$red['vreme_isteka']<$tv)
		{
			
			$redP = mysqli_fetch_array($rezultatCitanjaP);
			echo('<span>Najvisa ponuda: '. $redP['vrednost_ponude'] .'rsd</span>');

				echo('<p>'. $redP['ime_korisnika'] .' '. $redP['prezime_korisnika'] .'<br>');
				echo('Adresa: '. $redP['adresa_korisnika'] .'<br>');
				echo('Telefon: '. $redP['telefon_korisnika'].'</p>');
				

		}
		else if ($ukupnoPonuda <1&&$red['vreme_isteka']<$tv){
			echo('<p>Aukcija se zavrsila bez ponuda</p>');
		}
		
	//}
	//else
	//{
		//echo($rezultatCitanja);
	//}
					
				}
				
				if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

			
			if($red['trenutna_cena'] > $_SESSION['txtPonuda'] && isset($_POST['btnPonuda'])){
			$rezultatSnimanja = 'Ponuda mora biti veca od trenutne cene<br />';
		}
	else if ((!empty($_POST["txtPonuda"])) && is_numeric($_POST["txtPonuda"]) && $red['vreme_isteka'] > time())
		{
			$query_upload='INSERT into ponuda (id_predmeta_sk, id_korisnika_sk, vrednost_ponude, vreme_ponude)' .
		'VALUES ("'. $_SESSION['aukcija'] .'", "'. $_SESSION['ID'] .'", "'. $_SESSION['txtPonuda'] .'", "'. time()  . '")';
		$query_upload2='UPDATE predmet SET trenutna_cena = "' . $_POST['txtPonuda'] .'" WHERE id_predmeta = "'.$_SESSION['aukcija'].'"';

		
		mysqli_query($con, $query_upload) or die("error in $query_upload == ----> ".mysqli_error($con)); 
		mysqli_query($con, $query_upload2) or die("error in $query_upload == ----> ".mysqli_error($con)); 
    $rezultatSnimanja = 'Ponuda je poslata<br />';
	$_SESSION['txtPonuda'] = "";
header("Refresh:2");
		
		}
				
				
				
				
				echo($rezultatSnimanja);

			}}//}	
			
	
	?>	
	</div>
	</div>
</div>
</div>
</div>
</body>
</html>