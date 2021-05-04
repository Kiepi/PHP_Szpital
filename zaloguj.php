<?php
	$kto_to = $_POST['kto_to'];

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	
	else if($kto_to == "Pacjent")
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM pacjenci WHERE login='%s' AND haslo='%s'",
		mysqli_real_escape_string($polaczenie,$login),
		mysqli_real_escape_string($polaczenie,$haslo))))
		{
			$dl = $rezultat->num_rows;
			if($dl>0)
			{
				$rezultat2 = $polaczenie->query("SELECT * FROM pacjenci,diagnozy,lekarze,relacjePD WHERE diagnozy.id_diagnozy = relacjePD.id_diagnozy AND relacjePD.id_pacjenta = pacjenci.id AND lekarze.id_lekarza = pacjenci.id_lekarza");
				$_SESSION['zalogowany'] = true;
					
				$wiersz = $rezultat->fetch_assoc() AND $wiersz2 = $rezultat2->fetch_assoc();
				$_SESSION['id_pacjenta_sesja'] = $wiersz['id'];
				$_SESSION['imie'] = $wiersz['imie'];
				$_SESSION['nazwisko'] = $wiersz['nazwisko'];
				$_SESSION['pesel'] = $wiersz['pesel'];
				$_SESSION['id_diagnozy'] = $wiersz['id_diagnozy'];
				$_SESSION['diagnoza'] = $wiersz2['diagnoza'];
				$_SESSION["id_lekarza"] = $wiersz['id_lekarza'];
				$_SESSION["imie_lekarza"] = $wiersz2['imie'];
				$_SESSION["nazwisko_lekarza"] = $wiersz2['nazwisko'];
				$_SESSION['data_przyjecia'] = $wiersz['data_przyjecia'];
				$_SESSION['data_wypisu'] = $wiersz['data_wypisu'];
				$_SESSION['kto_to'] = $_POST['kto_to'];
					
				unset($_SESSION['blad']);
				$rezultat->free_result();
				header('Location: panel.php');
				
			} else {
				
				$_SESSION['blad'] = 'Nieprawidłowy login lub hasło!';
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	else if($kto_to == "Lekarz")
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM lekarze WHERE login='%s' AND haslo='%s'",
		mysqli_real_escape_string($polaczenie,$login),
		mysqli_real_escape_string($polaczenie,$haslo))))
		{
			$dl = $rezultat->num_rows;
			if($dl>0)
			{
				
				$_SESSION['zalogowany'] = true;
					
				$wiersz = $rezultat->fetch_assoc();
				$_SESSION['imie'] = $wiersz['imie'];
				$_SESSION['nazwisko'] = $wiersz['nazwisko'];
				$_SESSION['pesel'] = $wiersz['pesel'];
				$_SESSION['id_diagnozy'] = $wiersz['id_diagnozy'];
				$_SESSION['diagnoza'] = $wiersz['diagnoza'];
				$_SESSION["id_lekarza"] = $wiersz['id_lekarza'];
				$_SESSION['data_przyjecia'] = $wiersz['data_przyjecia'];
				$_SESSION['data_wypisu'] = $wiersz['data_wypisu'];
				$_SESSION['kto_to'] = $_POST['kto_to'];
					
				unset($_SESSION['blad']);
				$rezultat->free_result();
				header('Location: panel.php');
				
			} else {
				
				$_SESSION['blad'] = 'Nieprawidłowy login lub hasło!';
				header('Location: index.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>