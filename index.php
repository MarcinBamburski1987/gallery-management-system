<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: glowna.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Interface</title>

    
    <meta name="author" content="Marcin">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

<body>
	
	<h1 style="text-align: center"> SYSTEM ZARZĄDZANIA GALERIĄ</h1>
        <br>
		
		<div id="zdjęcie" style="text-align: center">
        <img src="img/galeria1.jpg" style="width:304px;height:228px;">
        </div>
		
		<div id="logowanie" style="text-align: center">
				<form action="zaloguj.php" method="post">
				
					Login: <br /> <input type="text" name="login" /> <br />
					Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
					<input type="submit" value="Zaloguj się" />
				
				</form>
		</div>
        <br>
		
		<footer>
            <div class="row" >
                
					
					<hr>
                                        <center><p>Copyright &copy; Marcin Bamburski</p></center>
            </div>	
		</footer>	
	
			<?php
				if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
			?>

<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>