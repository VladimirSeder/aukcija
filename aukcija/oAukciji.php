<?php
	session_start();
	require_once('conn.php');
	require_once('funkcijep.php');

	if (!isset($_SESSION['aukcija']))
	{
		header('Location: aukcije.php');
	}
	else if (isset($_SESSION['aukcija']))
	{
		$sesijao = $_SESSION['aukcija'];
	}
	$rezultatCitanja = ucitajAukciju();
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
	echo('<img src="' . $red['slika_predmeta'] . '">');

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

			}}//}	
	?>	
	</div>
	</div>
</div>
</div>
</div>
</body>
</html>