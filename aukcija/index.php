<!DOCTYPE html>
<html lang="en">
<head>
  <title>Aukcija.net</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
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
<div class="entry-content entry clr">
<div id="slider">
<figure>
<img src="img/b1.jpg">
<br>
<img src="img/b2.jpg">
<br>
<img src="img/b3.jpg">
<br>
<img src="img/b4.jpg">
<br>
<img src="img/b1.jpg">
<br>
</figure>
</div>
</div>
<br>
<h3 align="center">Aukcija.net je sajt za kupovinu i prodaju stvari putem aukcija.</h3> <br>
<h5 align="center">Aukcija.net vam pruža mogućnost da kupujete stvari učestvovanjem u online aukcijama, kao i da kreirate sopstvene aukcije u kojima mogu učestvovati ostali korisnici sajta.</h5>
<br>
<a href="aukcije.php">
<div class="button2">
<img src="img/oglasif.jpg"></img>
<p align="center" >Pogledajte aukcije</p>
</div></a>
<a href="korisnikReg.php">
<div class="button2">
<img src="img/reg.jpg"></img>
<p align="center" >Registrujte se</p>
</div></a>
</div>
</div>
</div>
</body>
</html>