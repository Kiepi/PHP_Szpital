-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 02 Gru 2020, 14:43
-- Wersja serwera: 10.5.8-MariaDB-1:10.5.8+maria~bionic
-- Wersja PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `e14_szpital`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `diagnozy`
--

CREATE TABLE `diagnozy` (
  `id_diagnozy` int(11) NOT NULL,
  `diagnoza` longtext COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `diagnozy`
--

INSERT INTO `diagnozy` (`id_diagnozy`, `diagnoza`) VALUES
(1, 'Arytmia serca.'),
(2, 'Nadczyność tarczycy.'),
(3, 'Wybity palec.'),
(4, 'Alergia na czekoladę.'),
(5, 'Złamana noga');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `historiaPD`
--

CREATE TABLE `historiaPD` (
  `id_relacji` int(11) NOT NULL,
  `id_diagnozy` int(11) NOT NULL,
  `id_pacjenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `historiaPD`
--

INSERT INTO `historiaPD` (`id_relacji`, `id_diagnozy`, `id_pacjenta`) VALUES
(2, 5, 1),
(3, 3, 1),
(4, 3, 1),
(5, 5, 6),
(6, 3, 1),
(7, 4, 1),
(8, 2, 1),
(9, 5, 6),
(10, 4, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekarze`
--

CREATE TABLE `lekarze` (
  `id_lekarza` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `lekarze`
--

INSERT INTO `lekarze` (`id_lekarza`, `login`, `haslo`, `imie`, `nazwisko`) VALUES
(1, 'l_1', 'qwerty', 'Jan', 'Kowalski'),
(2, 'l_2', 'qwerty', 'Filip', 'Zawadzki'),
(3, 'l_3', 'qwerty', 'Marian', 'Frąckowiak'),
(4, 'l_4', 'qwerty', 'Wojtek', 'Mańkowski'),
(5, 'l_5', 'qwerty', 'Ebenezer', 'Konieczny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pacjenci`
--

CREATE TABLE `pacjenci` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `pesel` bigint(11) NOT NULL,
  `id_lekarza` int(11) NOT NULL,
  `data_przyjecia` date NOT NULL,
  `data_wypisu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pacjenci`
--

INSERT INTO `pacjenci` (`id`, `login`, `haslo`, `imie`, `nazwisko`, `pesel`, `id_lekarza`, `data_przyjecia`, `data_wypisu`) VALUES
(1, 'p_1', 'ytrewq', 'Adam', 'Kowalewski', 12345678901, 1, '2020-09-10', '0000-00-00'),
(2, 'p_2', 'ytrewq', 'Rafał', 'Kołodziej', 12345678901, 1, '2020-09-10', '2020-10-22'),
(3, 'p_3', 'ytrewq', 'Jędrzej', 'Szymczak', 12345678901, 1, '2020-09-10', '2020-10-22'),
(4, 'p_4', 'ytrewq', 'Lucjan', 'Dąbrowski', 12345678901, 1, '2020-09-10', '2020-10-22'),
(5, 'p_5', 'ytrewq', 'Emil', 'Tomaszewski', 12345678901, 1, '2020-09-10', '2020-10-22'),
(6, 'p_6', 'ytrewq', 'Cezary', 'Kowalewski', 12345678901, 1, '2020-09-10', '0000-00-00'),
(7, 'p_7', 'ytrewq', 'Bartłomiej', 'Kowalczyk', 98765432123, 2, '2020-02-07', '2020-03-22'),
(8, 'p_8', 'ytrewq', 'Mikołaj', 'Szymczak', 98765432122, 2, '2020-02-07', '2020-03-22'),
(9, 'p_9', 'ytrewq', 'Emilia', 'Głowacka', 98764532122, 2, '2020-02-07', '2020-03-22'),
(10, 'p_10', 'ytrewq', 'Nikola', 'Adamska', 98765432121, 2, '2020-02-07', '2020-03-22'),
(11, 'p_11', 'ytrewq', 'Oktawian', 'Mazurkiewicz', 98765432120, 2, '2020-02-07', '2020-03-22'),
(12, 'p_12', 'ytrewq', 'Remigiusz', 'Górski', 98765432129, 2, '2020-02-07', '2020-03-22'),
(13, 'p_13', 'ytrewq', 'Adam', 'Włodarczyk', 98765432128, 3, '2020-10-15', '0000-00-00'),
(14, 'p_14', 'ytrewq', 'Henryk', 'Kucharski', 98765432127, 3, '2017-12-07', '2018-01-02'),
(15, 'p_15', 'ytrewq', 'Eryk', 'Zalewski', 98765432126, 3, '2017-12-07', '2018-01-02'),
(16, 'p_16', 'ytrewq', 'Izabela', 'Krajewska', 98734432126, 3, '2017-12-07', '2018-01-02'),
(17, 'p_17', 'ytrewq', 'Milena', 'Sikorska', 98765432125, 3, '2017-12-07', '2018-01-02'),
(18, 'p_18', 'ytrewq', 'Kamil', 'Górecki', 98765432124, 3, '2020-10-25', '0000-00-00'),
(19, 'p_19', 'ytrewq', 'Łukasz', 'Przybylski', 98765432123, 4, '2019-02-07', '2019-03-22'),
(20, 'p_20', 'ytrewq', 'Borys', 'Bąk', 98765432122, 4, '2019-02-07', '2019-03-22'),
(21, 'p_21', 'ytrewq', 'Miłosz', 'Kubiak', 98765432121, 4, '2019-02-07', '2019-03-22'),
(22, 'p_22', 'ytrewq', 'Józef', 'Krupa', 98765432125, 4, '2019-02-07', '2019-03-22'),
(23, 'p_23', 'ytrewq', 'Florian', 'Rutkowski', 98724321212, 4, '2019-02-07', '2019-03-22'),
(24, 'p_24', 'ytrewq', 'Miron', 'Jasiński', 98763543212, 4, '2019-02-07', '2019-03-22'),
(25, 'p_25', 'ytrewq', 'Paweł', 'Mróz', 98765432121, 5, '2020-05-07', '2020-08-17'),
(26, 'p_26', 'ytrewq', 'Zbigniew', 'Szymczak', 98765432122, 5, '2020-05-07', '2020-08-17'),
(27, 'p_27', 'ytrewq', 'Konstanty', 'Brzeziński', 98765432123, 5, '2020-09-13', '0000-00-00'),
(28, 'p_28', 'ytrewq', 'Gniewomir', 'Wójcik', 98765432124, 5, '2020-05-07', '2020-08-17'),
(29, 'p_29', 'ytrewq', 'Jolanta', 'Zakrzewska', 98765432125, 5, '2020-05-07', '2020-08-17'),
(30, 'p_30', 'ytrewq', 'Krystian', 'Kowalczyk', 98765432126, 5, '2020-05-07', '2020-08-17');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przekaz`
--

CREATE TABLE `przekaz` (
  `przekaz_id_pacjenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `przekaz`
--

INSERT INTO `przekaz` (`przekaz_id_pacjenta`) VALUES
(1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `relacjePD`
--

CREATE TABLE `relacjePD` (
  `id_relacji` int(11) NOT NULL,
  `id_diagnozy` int(11) NOT NULL,
  `id_pacjenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `relacjePD`
--

INSERT INTO `relacjePD` (`id_relacji`, `id_diagnozy`, `id_pacjenta`) VALUES
(2, 2, 2),
(3, 3, 3),
(5, 5, 5),
(6, 1, 6),
(7, 2, 7),
(8, 3, 8),
(9, 4, 9),
(10, 5, 10),
(11, 1, 11),
(12, 2, 12),
(13, 3, 13),
(14, 4, 14),
(15, 5, 15),
(16, 1, 16),
(17, 2, 17),
(18, 3, 18),
(19, 4, 19),
(20, 5, 20),
(21, 1, 21),
(22, 2, 22),
(23, 3, 23),
(24, 4, 24),
(25, 5, 25),
(26, 1, 26),
(27, 2, 27),
(28, 3, 28),
(29, 4, 29),
(30, 5, 30),
(38, 4, 4),
(39, 2, 4),
(59, 3, 1),
(61, 5, 1),
(62, 2, 6),
(64, 5, 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `diagnozy`
--
ALTER TABLE `diagnozy`
  ADD PRIMARY KEY (`id_diagnozy`);

--
-- Indeksy dla tabeli `historiaPD`
--
ALTER TABLE `historiaPD`
  ADD PRIMARY KEY (`id_relacji`);

--
-- Indeksy dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  ADD PRIMARY KEY (`id_lekarza`),
  ADD KEY `id_lekarza` (`id_lekarza`);

--
-- Indeksy dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lekarza` (`id_lekarza`);

--
-- Indeksy dla tabeli `relacjePD`
--
ALTER TABLE `relacjePD`
  ADD PRIMARY KEY (`id_relacji`),
  ADD KEY `id_diagnozy` (`id_diagnozy`),
  ADD KEY `id_pacjenta` (`id_pacjenta`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `diagnozy`
--
ALTER TABLE `diagnozy`
  MODIFY `id_diagnozy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `historiaPD`
--
ALTER TABLE `historiaPD`
  MODIFY `id_relacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  MODIFY `id_lekarza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `relacjePD`
--
ALTER TABLE `relacjePD`
  MODIFY `id_relacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  ADD CONSTRAINT `pacjenci_ibfk_2` FOREIGN KEY (`id_lekarza`) REFERENCES `lekarze` (`id_lekarza`);

--
-- Ograniczenia dla tabeli `relacjePD`
--
ALTER TABLE `relacjePD`
  ADD CONSTRAINT `relacjePD_ibfk_1` FOREIGN KEY (`id_diagnozy`) REFERENCES `diagnozy` (`id_diagnozy`),
  ADD CONSTRAINT `relacjePD_ibfk_2` FOREIGN KEY (`id_pacjenta`) REFERENCES `pacjenci` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
