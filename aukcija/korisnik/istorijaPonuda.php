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
	$rezultatCitanja = ucitajMojePonude();
	
	function ispisAukcije($red){
		
			
		
				echo('<div class="box1">');
				echo('<div class="lfl"><form action="'. $_SERVER['PHP_SELF'] .'" method="post">'); 
				echo('<input type="hidden" name="txtid_sifrao" value="'. $red['id_predmeta'] .'" />');

				echo('<span class="naslov"><h4>'. $red['naziv_predmeta'] . '</h4>');								
							
				echo('</div>');
				echo('<div class="lfs">'); 
				
	
							
				echo('<span class="trenutnaCena">Vreme: ' . date('d/m/Y H:i:s',$red['vreme_ponude']) .' </span><br>');
				echo('<span class="trenutnaCena">Cena: ' . $red['vrednost_ponude'] .' rsd </span><br>');	
				if($red['vrednost_ponude']==$red['trenutna_cena']&&$red['vreme_isteka']<time())
				{
					echo('<span class="trenutnaCena"><b>Pobednicka ponuda</b></span><br>');
				}
				else if($red['vreme_isteka']>time())
				{
					echo('<span class="trenutnaCena">Aukcija u toku</span><br>');
				}
				else
				{
					echo('<span class="trenutnaCena">Aukcija je zavrsena</span><br>');
				}
				echo('</div>');
				echo('<br><input class="form-control2" id="dugme" type="submit" name="btnOAukciji" value="otvori" /><br><br>');

				echo('</form></div>');
				echo('</br>');

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
<form method="post" action="istorijaPonuda.php?go">
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
	//if (is_resource($rezultatCitanja))
	//{
		$ukupnoPonuda = mysqli_num_rows($rezultatCitanja);
		if ($ukupnoPonuda > 0)
		{

	  			$id = "";
	  if(isset($_POST['submitsearch'])&&!empty($_POST['namesearch'])){ 
	  if(isset($_GET['go'])){ 
	  if(preg_match("/^[  0-9a-zA-Z]+/", mysqli_real_escape_string($db, $_POST['namesearch']))){ 
	  $name=$_POST['namesearch']; 

	  $db = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
$tv = time();
	  $sql = "SELECT ponuda.id_ponude, ponuda.id_predmeta_sk, ponuda.id_korisnika_sk, ponuda.vrednost_ponude, ponuda.vreme_ponude, korisnik.id_korisnika, predmet.id_predmeta, predmet.naziv_predmeta, predmet.trenutna_cena, predmet.vreme_isteka		
				FROM ponuda
				INNER JOIN predmet
				ON ponuda.id_predmeta_sk=predmet.id_predmeta
				INNER JOIN korisnik 
				ON ponuda.id_korisnika_sk=korisnik.id_korisnika WHERE ponuda.id_korisnika_sk = ".$_SESSION['ID'].  " AND naziv_predmeta LIKE '%" . $name .  "%' ORDER BY id_ponude DESC;";
	
	  $result=mysqli_query($db, $sql); 
	
	  $ukupnoOglasa2 = mysqli_num_rows($result);
	  echo('&nbsp;&nbsp;Istorija ponuda: <a href="istorijaPonuda.php" id="pp">ponisti pretragu</a><br />');
	  while ($red = mysqli_fetch_array($result))
			{
				ispisAukcije($red);
			
			}	   
	  } 
	  else{ 
	  echo  "<p>Please enter a search query</p> <a href='aukcije.php' id='pp'>ponisti pretragu</a>"; 
	  } 
	  } 
	  }
		
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			else {

				echo('&nbsp;&nbsp;Istorija ponuda:');
				
			while ($red = mysqli_fetch_array($rezultatCitanja))
			{
				ispisAukcije($red);
						
			}
		}
		}
	//}
	//else
	//{
		//echo($rezultatCitanja);
	//}
	?>
	</div>
</div>
</div>
</body>
</html>