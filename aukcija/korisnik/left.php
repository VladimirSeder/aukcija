<div class="left2">
<h3 align="center" >Dobrodošli</h3>
		<p align="center" >
        <?php 
		if (!isset($_SESSION)) 
		{
		session_start();  
		}
		echo $_SESSION['Name'];
		?>
        </p>
</div>
