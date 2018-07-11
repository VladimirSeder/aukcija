<?php
if (isset($_GET['odjava']))
	{
		unset($_SESSION['ID']);
		session_destroy();
		header('Location: ../index.php');
	}
?>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>	  
	  <a class="navbar-brand" href="index.php">Pocetna</a>	  
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">       
        <li><a href="profil.php">Profil</a></li>
        <li><a href="aukcije.php">Aukcije</a></li>
		 <li><a href="mojeAukcije.php">Moje aukcije</a></li>
		<li><a href="dodajAukciju.php">Dodaj aukciju</a></li>
		<li><a href="istorijaAukcija.php">Istorija aukcija</a></li>
		<li><a href="istorijaPonuda.php">Istorija ponuda</a></li>
		<li><a href="?odjava=true">Odjavi se</a></li>
      </ul>
    </div>
  </div>
</nav>