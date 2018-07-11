<?php
	session_start();
	if (!isset($_SESSION['ID']))
		{
			header('Location: ../index.php');
		}
	if (isset($_GET['odjava']))
	{
		unset($_SESSION['ID']);
		session_destroy();
		header('Location: ../index.php');
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
<div class="contenti">

<a href="profil.php">
<div class="button">
<img src="../img/profil.jpg"></img>
<p align="center" >Profil</p>
</div></a>

<a href="aukcije.php">
<div class="button">
<img src="../img/aukcije.jpg"></img>
<p align="center" >Aukcije</p>
</div></a>

<a href="mojeAukcije.php">
<div class="button">
<img src="../img/maukcije.jpg"></img>
<p align="center" >Moje aukcije</p>
</div></a>

<a href="dodajAukciju.php">
<div class="button">
<img src="../img/dodajAukciju.jpg"></img>
<p align="center" >Napravi aukciju</p>
</div></a>

<a href="istorijaAukcija.php">
<div class="button">
<img src="../img/iaukcija.jpg"></img>
<p align="center" >Istorija aukcija</p>
</div></a>

<a href="istorijaPonuda.php">
<div class="button">
<img src="../img/ponude.jpg"></img>
<p align="center" >Istorija ponuda</p>
</div></a>
</div>
</div>
</div>
</body>
</html>