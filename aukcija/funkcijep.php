<?php
require_once('conn.php');

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
				$rezultat = mysqli_query($link, $upit);
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