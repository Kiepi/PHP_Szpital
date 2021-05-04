<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<html lang="pl">

<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Szpital | Panel</title>
<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari,latin-ext" rel="stylesheet">
<head>

<body>

<div id="pojemnik">

	<div id="banner">
	IV Okręgowy Szpital Chorób Zakaźnych
	</div>
	
	<div id="lewy">
	
	<?php 
	echo "<div id='witaj'>";
	echo "<b>Konto " . $_SESSION['kto_to'] . "a</b></br>";
	echo "Witaj! " . $_SESSION["imie"] . " " . $_SESSION["nazwisko"] . "</br>";
	echo "</div>";
	echo "<div id='srodek'><a href='logout.php'><div id='wyloguj'>Wyloguj się</div></a></div>"; 
	?>
	
	</div>
	
	<div id="border"></div>
	
	<div id="prawy">
	
		<?php
			$jaki_pacjent;
			
			if ($_SESSION['kto_to'] == "Pacjent")
			{
				$id_pacjenta_sesja = $_SESSION['id_pacjenta_sesja'];
				require "connect.php";
				
				$rezultat = $polaczenie->query("SELECT diagnozy.diagnoza,pacjenci.id,diagnozy.id_diagnozy,relacjePD.id_diagnozy,relacjePD.id_pacjenta FROM pacjenci,diagnozy,relacjePD WHERE pacjenci.id = $id_pacjenta_sesja AND diagnozy.id_diagnozy = relacjePD.id_diagnozy AND relacjePD.id_pacjenta = pacjenci.id ORDER BY relacjePD.id_relacji DESC");
				
				echo "<div id='dane_pacjenta'>";
				echo "<b>Imię:</b> " . $_SESSION["imie"] . "</br>";
				echo "<b>Nazwisko:</b> " . $_SESSION["nazwisko"] . "</br>";
				echo "<b>Pesel:</b> " . $_SESSION["pesel"] . "</br>";
				echo "<b>Diagnoza/y:</b>";
				echo "<div id='tekst_diagnoza'>";
				while($wszystkie_diagnozy_sesja = $rezultat->fetch_assoc())
				{
					echo $wszystkie_diagnozy_sesja["diagnoza"] . "</br>";
				}
				echo "</div>";
				echo "<b>Lekarz prowadzący:</b> " . $_SESSION["imie_lekarza"] . " " . $_SESSION["nazwisko_lekarza"] . "</br>";
				echo "<b>Data przyjęcia:</b> " . $_SESSION["data_przyjecia"] . "</br>";
				if($_SESSION["data_wypisu"] == "0000-00-00")
				{
					echo "<b>Data wypisu:</b> Wciąż jesteś w szpitalu";
				}
				else
				{
					echo "<b>Data wypisu:</b> " . $_SESSION["data_wypisu"];
				}
				echo "</div>";
			}
			else if ($_SESSION['kto_to'] == "Lekarz")
			{
				$id_lekarza = $_SESSION["id_lekarza"];
				require "connect.php";
				
				$rezultat = $polaczenie->query("SELECT pacjenci.id,pacjenci.imie,pacjenci.nazwisko FROM pacjenci,lekarze WHERE pacjenci.id_lekarza = lekarze.id_lekarza AND pacjenci.id_lekarza = $id_lekarza");
				
				echo "<form method='post'>";
				echo "<select id='select_lekarz' name='jaki_pacjent'>";
				echo "<option value='0' disabled>Rozwiń listę</option>";
				while($wiersz = $rezultat->fetch_assoc())
				{
					echo "<option value='" . $wiersz['id'] . "'>" . $wiersz["imie"]. " " . $wiersz["nazwisko"] . "</option>";
				}
				$polaczenie->close();
				echo "</select>";
				
				echo "<input type='submit' name='wyswietl_pacjenta' id='lekarz_panel_input' value='Wybierz pacjenta'>";
				echo "<input type='submit' name='wroc' id='lekarz_panel_input' value='Wróć'>";
				echo "</form>";
				
				$jaki_pacjent = $_POST['jaki_pacjent'];
				
				if(isset($_POST['wyswietl_pacjenta']))
				{
					require "connect.php";
					
					$rezultat = $polaczenie->query("SELECT * FROM pacjenci WHERE pacjenci.id=$jaki_pacjent");
					$rezultat2 = $polaczenie->query("SELECT pacjenci.id_lekarza,lekarze.* FROM pacjenci,lekarze WHERE pacjenci.id_lekarza = lekarze.id_lekarza AND pacjenci.id_lekarza = $id_lekarza");
					$rezultat3 = $polaczenie->query("SELECT diagnozy.diagnoza,pacjenci.id,diagnozy.id_diagnozy,relacjePD.id_diagnozy,relacjePD.id_pacjenta,relacjePD.id_relacji FROM pacjenci,diagnozy,relacjePD WHERE pacjenci.id=$jaki_pacjent AND diagnozy.id_diagnozy = relacjePD.id_diagnozy AND relacjePD.id_pacjenta = pacjenci.id ORDER BY relacjePD.id_relacji DESC");
					$rezultat4 = $polaczenie->query("SELECT diagnozy.id_diagnozy,pacjenci.id,relacjePD.id_pacjenta FROM diagnozy,pacjenci,relacjePD WHERE pacjenci.id=$jaki_pacjent AND diagnozy.id_diagnozy = relacjePD.id_diagnozy AND relacjePD.id_pacjenta = pacjenci.id ORDER BY relacjePD.id_relacji DESC");
					
					echo "<div id='dane_pacjenta'>";
					
					echo "<form method='post'>";
					while($wiersz = $rezultat->fetch_assoc() AND $wiersz2 = $rezultat2->fetch_assoc())
					{
						echo "<b>Imię pacjenta:</b> " . $wiersz["imie"] . "</br>";
						echo "<b>Nazwisko pacjenta:</b> " . $wiersz["nazwisko"] . "</br>";
						echo "<b>Pesel pacjenta:</b> " . $wiersz["pesel"] . "</br>";
						echo "<b>Numer diagnozy pacjenta:</b> ";
						while($id_wszyskitkich_diagnoz = $rezultat4->fetch_assoc())
						{
							echo $id_wszyskitkich_diagnoz["id_diagnozy"] . ", ";
						}
						echo "</br>";
						echo "<div id='diagnoza_info'>";
						echo "<b>Diagnoza pacjenta:</b>";
						echo "<input type='submit' name='dodaj' value='Dodaj'>";
						echo "<input type='submit' name='usun' value='Usuń'>";
						echo "</div>";
						echo "<div id='tekst_diagnoza'>";
						while($wszystkie_diagnozy = $rezultat3->fetch_assoc())
						{
							echo $wszystkie_diagnozy["diagnoza"] . "</br>";
						}
						echo "</div>";
						echo "<b>Lekarz prowadzący:</b> " . $wiersz2["imie"] . " " . $wiersz2["nazwisko"] . "</br>";
						echo "<b>Data przyjęcia:</b> " . $wiersz["data_przyjecia"] . "</br>";
						if($wiersz["data_wypisu"] == "0000-00-00")
						{
							echo "<b>Data wypisu:</b> Pacjent wciąż jest w szpitalu";
						}
						else
						{
							echo "<b>Data wypisu:</b> " . $wiersz["data_wypisu"];
						}
					}
					$polaczenie->close();
					echo "</form>";
					
					echo "</div>";
					
				}

				require "connect.php";
				$przekaz = $polaczenie->query("UPDATE przekaz SET przekaz_id_pacjenta='$jaki_pacjent'");
				
				if(isset($_POST['dodaj']))
				{
					require "connect.php";
					$wypis_DB = $polaczenie->query("SELECT * FROM przekaz");
					while($wypisZbazy = $wypis_DB ->fetch_assoc())
					{
						$jaki_pacjent = $wypisZbazy['przekaz_id_pacjenta'];
					}
					$pacjent_div = $polaczenie->query("SELECT pacjenci.imie,pacjenci.nazwisko FROM pacjenci WHERE pacjenci.id ='".$jaki_pacjent."'");
					while($i_m_pacjent = $pacjent_div ->fetch_assoc())
					{
						$pacjent_imie = $i_m_pacjent['imie'];
						$pacjent_nazwisko = $i_m_pacjent['nazwisko'];
					}
					
					$unikatowa_lista_diagnoz_z_DB = $polaczenie->query("SELECT relacjePD.id_pacjenta,relacjePD.id_diagnozy FROM relacjePD WHERE relacjePD.id_pacjenta='".$jaki_pacjent."'");
					
					echo "<div id='div_style' style='color:green; font-weight:bold;'>Dodawanie diagnozy</div>";
					echo "<div id='div_style' style='margin-top:10px;'>Pacjent: <span style='font-style:italic;'>".$pacjent_imie." ".$pacjent_nazwisko."</span></div>";
					
					echo "<div>";
					
					$dl = $unikatowa_lista_diagnoz_z_DB->num_rows;
					$j = 1;
					$posiadane_id = '';
					while($posiadane_diagnozy = $unikatowa_lista_diagnoz_z_DB->fetch_assoc())
					{
						$posiadane_id .= $posiadane_diagnozy["id_diagnozy"];
						
						if ($j<$dl)
						{
							$posiadane_id .= ",";
						}
						$j++;
					}

					$lista_diagnoz_z_DB = $polaczenie->query("SELECT * FROM diagnozy WHERE id_diagnozy NOT IN (" . $posiadane_id . ")");
					
					echo "<form method='post'>";
					echo "<select style='float:left;' id='select_lekarz' name='id_wybranej_diagnozy'>";
					echo "<option value='0' disabled>Lista mozliwych diognoz</option>";

					while($wszystkie_diagnozy = $lista_diagnoz_z_DB->fetch_assoc())
					{
						$wszystkie_id = $wszystkie_diagnozy["id_diagnozy"];
						$wszystkie_d = $wszystkie_diagnozy["diagnoza"];
						
						echo "<option value='" . $wszystkie_id . "'>" . $wszystkie_d . "</option>";
					}
					
					$polaczenie->close();
					echo "<select>";
					
					echo "<input style='float:left;' type='submit' name='dodaj_diagnoze' id='lekarz_panel_input' value='Zatwierdź'>";
					echo "</form>";
					
					echo "</div>";
				}
				
				$id_wybranej_diagnozy = $_POST["id_wybranej_diagnozy"];
				
				if(isset($_POST['dodaj_diagnoze']))
				{
					require "connect.php";
					$wypis_DB = $polaczenie->query("SELECT * FROM przekaz");
					while($wypisZbazy = $wypis_DB ->fetch_assoc())
					{
						$jaki_pacjent = $wypisZbazy['przekaz_id_pacjenta'];
					}
					$wypisZbazy = $polaczenie->query("SELECT * FROM diagnozy,pacjenci WHERE diagnozy.id_diagnozy = '".$id_wybranej_diagnozy."' AND pacjenci.id = '".$jaki_pacjent."'");
					while($dla_kogo = $wypisZbazy ->fetch_assoc())
					{
						$dodawanie_diagnozy_do_DB = $polaczenie->query("INSERT INTO relacjePD(id_relacji, id_diagnozy, id_pacjenta) VALUES (NULL, '$id_wybranej_diagnozy', '$jaki_pacjent')");
						echo "<div style='margin-left:5px;color:green;'>Dodano diagnozę: <span style='color:#595959'>" . $dla_kogo['diagnoza'] . "</span></div><div style='margin-left:5px;'>Dla pacjenta: <span style='color:#595959'>" . $dla_kogo['imie'] . " " . $dla_kogo['nazwisko'] . "</span></div>";
					}
				}
				
				if(isset($_POST['usun']))
				{
					require "connect.php";
					$wypis_DB = $polaczenie->query("SELECT * FROM przekaz");
					while($wypisZbazy = $wypis_DB ->fetch_assoc())
					{
						$jaki_pacjent = $wypisZbazy['przekaz_id_pacjenta'];
					}
					$pacjent_div = $polaczenie->query("SELECT pacjenci.imie,pacjenci.nazwisko FROM pacjenci WHERE pacjenci.id ='".$jaki_pacjent."'");
					while($i_m_pacjent = $pacjent_div ->fetch_assoc())
					{
						$pacjent_imie = $i_m_pacjent['imie'];
						$pacjent_nazwisko = $i_m_pacjent['nazwisko'];
					}
					echo "<div id='div_style' style='color:red; font-weight:bold;'>Usuwanie diagnozy</div>";
					echo "<div id='div_style' style='margin-top:10px;'>Pacjent: <span style='font-style:italic;'>".$pacjent_imie." ".$pacjent_nazwisko."</span></div>";
					
					echo "<div>";
					
					echo "<form method='post'>";
					echo "<select style='float:left;' id='select_lekarz' name='id_wybranej_diagnozy'>";
					echo "<option value='0' disabled>Lista mozliwych diognoz</option>";
					$lista_diagnoz_do_usuniecia = $polaczenie->query("SELECT DISTINCT * FROM diagnozy,relacjePD WHERE relacjePD.id_pacjenta='".$jaki_pacjent."' AND diagnozy.id_diagnozy = relacjePD.id_diagnozy");
					while($mozliwe_diagnozy_usun = $lista_diagnoz_do_usuniecia->fetch_assoc())
					{
						echo "<option value='" . $mozliwe_diagnozy_usun["id_diagnozy"] . "'>" . $mozliwe_diagnozy_usun["diagnoza"] . "</option>";
					}
					$polaczenie->close();
					echo "<select>";
					
					echo "<input style='float:left;' type='submit' name='usun_diagnoze' id='lekarz_panel_input' value='Zatwierdź'>";
					echo "</form>";
					
					echo "</div>";
				}
				
				if(isset($_POST['usun_diagnoze']))
				{
					require "connect.php";
					$wypis_DB = $polaczenie->query("SELECT * FROM przekaz");
					while($wypisZbazy = $wypis_DB ->fetch_assoc())
					{
						$jaki_pacjent = $wypisZbazy['przekaz_id_pacjenta'];
					}
					$wypisZbazy = $polaczenie->query("SELECT * FROM diagnozy,pacjenci WHERE diagnozy.id_diagnozy = '".$id_wybranej_diagnozy."' AND pacjenci.id = '".$jaki_pacjent."'");
					while($dla_kogo = $wypisZbazy ->fetch_assoc())
					{
					echo "<div style='margin-left:5px;color:red;'>Usunięto diagnozę: <span style='color:#595959'>" . $dla_kogo['diagnoza'] . "</span></div><div style='margin-left:5px;'>Dla pacjenta: <span style='color:#595959'>" . $dla_kogo['imie'] . " " . $dla_kogo['nazwisko'] . "</span></div>";
					$dodawanie_diagnozy_historii = $polaczenie->query("INSERT INTO historiaPD(id_relacji, id_diagnozy, id_pacjenta) VALUES (NULL, '".$id_wybranej_diagnozy."', '".$jaki_pacjent."')");
					$usuwanie_diagnozy_z_DB = $polaczenie->query("DELETE FROM relacjePD WHERE relacjePD.id_diagnozy = '".$id_wybranej_diagnozy."' AND relacjePD.id_pacjenta = '".$jaki_pacjent."'");
					}
				}
				
			}
			echo "<div id='logo_style'>";
			echo "<img src='logo-e14.png' alt='logo'>";
			echo "</div>";
		?>
	
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