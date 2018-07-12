<?php
	session_start();
	require_once('../conn.php');
	require_once('funkcijep.php');
	if (!isset($_SESSION['ID']))
	{
		header('Location: index.php');
	}
	
	if (isset($_POST['btnOAukciji']))
	{
		$sesijao = trim($_POST['txtid_sifrao']);
		$_SESSION['aukcija'] = $sesijao;
		header('Location: oAukciji.php');
	}
	$rezultatCitanja = ucitajSAukciju();
	
	function ispisAukcije($red){
		$tv = time();
		 $vi = $red['vreme_isteka'];
		 $pv = $vi - $tv;
		
		if($pv<1&&$red['id_korisnika_sk']==$_SESSION['ID']){
			
		echo('<div class="box1">');
				echo('<div class="lfl"><form action="'. $_SERVER['PHP_SELF'] .'" method="post">'); 
				echo('<input type="hidden" name="txtid_sifrao" value="'. $red['id_predmeta'] .'" />');
				echo('<span class="naslov"><h3>'. $red['naziv_predmeta'] . '</h3>');								
				echo('<span class="kropis">' . str_replace("/br","",substr($red['opis_predmeta'], 0, 330)) . '...</span></br>'); 								
				echo('</div>');
				echo('<div class="lfs">'); 
				echo('<br><input class="form-control2" id="dugme" type="submit" name="btnOAukciji" value="otvori" /><br><br>');
				echo('<span class="trenutnaCena">Zavrsena aukcija</span><br>');
				echo('<span class="trenutnaCena">Cena: ' . $red['trenutna_cena'] .' rsd </span><br>');							
				echo('</div>');
				echo('<div class="lfd"><img src="../' . $red['slika_predmeta'] . '"></div>');
				echo('</form></div>');
				echo('</br>');
		}
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
<div class="content">
<form method="post" action="istorijaAukcija.php?go">
    <div class="input-group">
      <input type="text" id="search1" name="namesearch" class="form-control" placeholder="pretraga">
      <div class="input-group-btn">
        <button class="btn btn-default" name="submitsearch" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </div>	  
    </div>
  </form>
<div class="lf">
	<?php
	$db = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
		$ukupnoOglasa = mysqli_num_rows($rezultatCitanja);
		if ($ukupnoOglasa > 0)
		{
			$id = "";
	  if(isset($_POST['submitsearch'])&&!empty($_POST['namesearch'])){ 
	  if(isset($_GET['go'])){ 
	  if(preg_match("/^[  0-9a-zA-Z]+/", mysqli_real_escape_string($db, $_POST['namesearch']))){ 
	  $name=$_POST['namesearch']; 

	  $db = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
$tv = time();
	  $sql="SELECT  id_predmeta, id_korisnika_sk, naziv_predmeta, opis_predmeta, slika_predmeta, vreme_isteka, trenutna_cena FROM predmet WHERE vreme_isteka < " . $tv . " AND id_korisnika_sk = " . $_SESSION['ID'] . " AND (naziv_predmeta LIKE '%" . $name .  "%' or opis_predmeta LIKE '%" . $name .  "%') ORDER BY id_predmeta DESC;"; 
	
	  $result=mysqli_query($db, $sql); 
	
	  $ukupnoOglasa2 = mysqli_num_rows($result);

	  echo('&nbsp;&nbsp;Istorija aukcija: <a href="istorijaAukcija.php" id="pp">ponisti pretragu</a><br />');
	  while ($red = mysqli_fetch_array($result))
			{
				ispisAukcije($red);				
			}	   
	  } 
	  else{ 
	  echo  "<p>Unesite rec za pretragu</p> <a href='aukcije.php' id='pp'>ponisti pretragu</a>"; 
	  } 
	  } 
	  } 			
			else {

				echo('&nbsp;&nbsp;Istorija aukcija:');
				
			while ($red = mysqli_fetch_array($rezultatCitanja))
			{
				ispisAukcije($red);
						
			}
			}
		}
	?>
	</div>
</div>
</div>
</body>
</html>