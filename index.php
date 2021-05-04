<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: panel.php');
		exit();
	}

?>
<html lang="pl">

<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Szpital</title>
<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari,latin-ext" rel="stylesheet">
<head>

<body>

<div id="pojemnik">

	<div id="banner">
	IV Okręgowy Szpital Chorób Zakaźnych
	</div>
	
	<div id="lewy">
	
	<div id="srodek">
		<form action="zaloguj.php" method="post">
		
			<select id="select_logowanie" name="kto_to">
				<option>Pacjent</option>
				<option>Lekarz</option>
			</select>
			
			<input type="text" placeholder="Login" name="login" required>
			<input type="password" placeholder="Hasło" name="haslo" required>
			<input type="submit" id="logowanie" value="Zloguj">
		
		</form>
	</div>
	
	<?php
	if(isset($_SESSION['blad']))	echo "<div id='blad'>" . $_SESSION['blad'] . "</div>";
    ?>
	
	</div>
	
	<div id="border"></div>
	
	<div id="prawy">
		<div style="margin-left: 5px;float:left;">
			Zaloguj się, aby otrzymać dostęp do danych.
		</div>
		<div id="logo_style">
		<img src="logo-e14.png" alt="logo">
		</div>
	</div>
	
	<div id="stopka">

	<div id="stopka-info">
	Adres<br>
	Warszawa 12-123<br>
	ul. Długa 123
	</div>
	
	<div id="stopka-info">
	Kontakt<br>
	tel: 123123123
	</div>
	
	<div id="stopka-info">
	Dyrektor Szpitala<br>
	Mariusz Jankowski
	</div>
	
	<div id="stopka-info">
	<img src="logo-e14.png" height="70px" width="134px" alt="logo">
	</div>

	</div>

</div>

</body>

</html>