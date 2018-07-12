<?php
require_once('../conn.php');

	function GetImageExtension($imagetype)

     {
       if(empty($imagetype)) return false;

       switch($imagetype)
       {

           case 'image/bmp': return '.bmp';

           case 'image/gif': return '.gif';

           case 'image/jpeg': return '.jpg';

           case 'image/png': return '.png';
		   
		   case 'image/docx': return '.docx';

           default: return false;

       }
     }
	 function vremeIsteka()
	 {
		 $vp = time();
		 $brojdana = $_POST["txtVremeIsteka"];
		 $vi = $vp + ($brojdana * 86400);

		 return $vi;
	 }
	 	
	function ucitajKorisnika()
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
		if ($link)
		{
				$upit = 'SELECT id_korisnika, ime_korisnika, email_korisnika, sifra_korisnika, prezime_korisnika, adresa_korisnika, telefon_korisnika, profilna_slika
				FROM korisnik
				';
				$rezultat = mysqli_query($link,$upit);
				if ($rezultat === false)
				{
					$rezultat = 'Došlo je do greške prilikom čitanja podataka iz baze.<br />';
					$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
				}
		mysqli_close($link);
		}
		else
		{
			$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
		}
		return $rezultat;
	}
	
	function ucitajAukciju()
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
		if ($link)
		{
				$tv = time();
				$upit = 'SELECT id_predmeta, id_korisnika_sk, naziv_predmeta, opis_predmeta, pocetna_cena, nacin_placanja, nacin_isporuke, slika_predmeta, vreme_postavljanja, vreme_isteka, trenutna_cena
				FROM predmet WHERE vreme_isteka > ' . $tv . ' ORDER BY id_predmeta DESC;';

				$rezultat = mysqli_query($link,$upit);
				if ($rezultat === false)
				{
					$rezultat = 'Došlo je do greške prilikom čitanja podataka iz baze.<br />';
					$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
				}
		mysqli_close($link);
		}
		else
		{
			$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
		}
		return $rezultat;
	}
		
	function ucitajSAukciju()
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
		if ($link)
		{
				$tv = time();

				$upit = 'SELECT id_predmeta, id_korisnika_sk, naziv_predmeta, opis_predmeta, pocetna_cena, nacin_placanja, nacin_isporuke, slika_predmeta, vreme_postavljanja, vreme_isteka, trenutna_cena
				FROM predmet ORDER BY id_predmeta DESC;';
				$rezultat = mysqli_query($link,$upit);
				if ($rezultat === false)
				{
					$rezultat = 'Došlo je do greške prilikom čitanja podataka iz baze.<br />';
					$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
				}
		mysqli_close($link);
		}
		else
		{
			$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
		}
		return $rezultat;
	}
	
	function ucitajMojeAukcije()
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
		if ($link)
		{
				$tv = time();
				$upit = "SELECT id_predmeta, id_korisnika_sk, naziv_predmeta, opis_predmeta, pocetna_cena, nacin_placanja, nacin_isporuke, slika_predmeta, vreme_postavljanja, vreme_isteka, trenutna_cena
				FROM predmet WHERE vreme_isteka > " . $tv . " AND id_korisnika_sk = " . $_SESSION['ID'] .  " ORDER BY id_predmeta DESC;";
				$rezultat = mysqli_query($link,$upit);
				if ($rezultat === false)
				{
					$rezultat = 'Došlo je do greške prilikom čitanja podataka iz baze.<br />';
					$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
				}
		mysqli_close($link);
		}
		else
		{
			$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
		}
		return $rezultat;
	}

	function ucitajPonude()
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
		if ($link)
		{
				$upit = "SELECT * FROM ponuda
				INNER JOIN predmet
				ON ponuda.id_predmeta_sk=predmet.id_predmeta
				INNER JOIN korisnik 
				ON ponuda.id_korisnika_sk=korisnik.id_korisnika 
				WHERE ponuda.id_predmeta_sk = ".$_SESSION['aukcija'].  " ORDER BY id_ponude DESC LIMIT 5;";
				$rezultat = mysqli_query($link,$upit);
				if ($rezultat === false)
				{
					$rezultat = 'Došlo je do greške prilikom čitanja podataka iz baze.<br />';
					$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
				}
		mysqli_close($link);
		}
		else
		{
			$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
		}
		return $rezultat;
	}
	function ucitajMojePonude()
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
		if ($link)
		{
				$upit = "SELECT ponuda.id_ponude, ponuda.id_predmeta_sk, ponuda.id_korisnika_sk, ponuda.vrednost_ponude, ponuda.vreme_ponude, korisnik.id_korisnika, predmet.id_predmeta, predmet.naziv_predmeta, predmet.pocetna_cena, predmet.trenutna_cena, predmet.vreme_isteka		
				FROM ponuda
				INNER JOIN predmet
				ON ponuda.id_predmeta_sk=predmet.id_predmeta
				INNER JOIN korisnik 
				ON ponuda.id_korisnika_sk=korisnik.id_korisnika WHERE ponuda.id_korisnika_sk = ".$_SESSION['ID'].  " ORDER BY ponuda.id_ponude DESC ;";


				$rezultat = mysqli_query($link,$upit);
				if ($rezultat === false)
				{
					$rezultat = 'Došlo je do greške prilikom čitanja podataka iz baze.<br />';
					$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
				}
		mysqli_close($link);
		}
		else
		{
			$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
		}
		return $rezultat;
	}

	function obrisiAukciju($izn_sifra)
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		if (!empty($izn_sifra))
		{
			$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
			if ($link)
			{
			
					$upit = 'DELETE FROM predmet WHERE id_predmeta ='. $izn_sifra .';';
					$upit2 = 'DELETE FROM ponuda WHERE id_predmeta_sk ='. $izn_sifra .';';
					$rezultat = mysqli_query($link, $upit);
					$rezultat2 = mysqli_query($link, $upit2);
					if ($rezultat === false)
					{
						$rezultat = 'Došlo je do greške prilikom brisanja podataka iz baze.<br />';
						$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
					}
			}
			else
			{
				$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
			}
		}

		header('Location: mojeAukcije.php');
		return $rezultat;
	}
	
	function obrisiPonudu($izn_sifra,$sifrap)
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		if (!empty($izn_sifra))
		{
			$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
			if ($link)
			{
					$upitd = 'DELETE FROM ponuda WHERE id_ponude ='. $izn_sifra .';';
					$rezultatd = mysqli_query($link, $upitd);
					
					$upit = 'SELECT max(vrednost_ponude) FROM `ponuda` WHERE id_predmeta_sk ='. $sifrap .';';
					$upitpc = 'SELECT pocetna_cena FROM `predmet` WHERE id_predmeta ='. $sifrap .';';
					$rezultatpc = mysqli_query($link, $upitpc);
					$redpc = mysqli_fetch_array($rezultatpc);		
					$rezultat = mysqli_query($link, $upit);
					$red = mysqli_fetch_array($rezultat);
					
					if ($red['max(vrednost_ponude)'] == null)
					{
						$upit2='UPDATE predmet SET trenutna_cena = "' . $redpc['pocetna_cena'] .'" WHERE id_predmeta = "'.$sifrap.'"';
						$rezultat2 = mysqli_query($link, $upit2);
					}					
					else 
					{
						$upit3='UPDATE predmet SET trenutna_cena = "' . $red['max(vrednost_ponude)'] .'" WHERE id_predmeta = "'.$sifrap.'"';
						$rezultat3 = mysqli_query($link, $upit3);
					}
					
					if ($rezultatd === false)
					{
						$rezultatd = 'Došlo je do greške prilikom brisanja podataka iz baze.<br />';
						$rezultatd .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
					}
			}
			else
			{
				$rezultatd = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
			}
		}

		header('Location: istorijaPonuda.php');
		return $rezultatd;
	}
	
	function obrisiKorisnika($izn_sifra)
	{
		global $hostname;
		global $dbusername;
		global $dbpassword;
		global $database;
		$rezultat = false;
		if (!empty($izn_sifra))
		{
			$link = mysqli_connect($hostname,$dbusername,$dbpassword,$database);
			if ($link)
			{
					$sql = 'select profilna_slika from korisnik where id_korisnika='. $izn_sifra .';';
					$result = mysqli_query($link,$sql);

					$row = mysqli_fetch_array($result);
					$name1 = $row['profilna_slika'];
					unlink('../'. $name1. '');
					$upit = 'DELETE FROM korisnik WHERE id_korisnika ='. $izn_sifra .';';
					$rezultat = mysqli_query($link, $upit);
					if ($rezultat === false)
					{
						$rezultat = 'Došlo je do greške prilikom brisanja podataka iz baze.<br />';
						$rezultat .=  mysqli_errno($link) . ': ' . mysqli_error($link) . '<br />';
					}
			}
			else
			{
				$rezultat = 'Konekcija sa bazom podataka se ne može uspostaviti.<br />';
			}
		}
		unset($_SESSION['ID']);
		session_destroy();
		header('Location: ../index.php');
		return $rezultat;
	}
	
?>