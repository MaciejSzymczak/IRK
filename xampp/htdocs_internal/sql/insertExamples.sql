-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 16 Gru 2012, 01:01
-- Wersja serwera: 5.1.37
-- Wersja PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8 */;

--
-- Baza danych: `irk`
--

--
-- Zrzut danych tabeli `kandydat_dane_adresowe`
--

INSERT INTO `kandydat_dane_adresowe` (`ID_Adres_Kandydata`, `Id_Kandydata`, `Kod_pocztowy_meld`, `Poczta_meld`, `Miejscowosc_meld`, `Ulica_meld`, `Nr_domu_meld`, `Nr_lokalu_meld`, `Id_wku`, `Id_wojewodztwa_meld`, `Kod_pocztowy`, `Poczta`, `Miejscowosc`, `Ulica`, `Nr_domu`, `Nr_lokalu`, `Nr_telefonu`, `Adres_mail`, `Tel_kom`, `ID_rodzaj_miejscowosci`, `ID_zrodel_informacji`, `Nazwa_JW`, `kod_pocz_JW`, `Miejscowosc_JW`, `Ulica_JW`, `NrTel_JW`, `Id_zrodla_utrzymania`, `data_aktualizacji_adr`, `Uzytkownik_aktualizacja_adr`, `kod_kraju_zamieszkania`, `kod_kraju_korespondencji`) VALUES
(1, 1, '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', 'rekrutacja@wat.edu.pl', '', 0, NULL, '', '', '', '', '', 0, '2012-02-29', 'Internet', 'PL', 'PL'),
(2, 2, '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', 'karolheleniak@gmail.com', '', 0, NULL, '', '', '', '', '', 0, '2012-02-29', 'Internet', 'PL', 'PL'),
(3, 3, NULL, 'Warszawa', 'Warszawa', '', NULL, NULL, NULL, 11, NULL, 'Warszawa', 'Warszawa', '', NULL, NULL, NULL, 'rekrutacja@wat.edu.pl', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-02-29', 'kheleniak', 'PL', 'PL'),
(4, 4, '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', 'sowinski@konto.pl', '', 0, NULL, '', '', '', '', NULL, 0, '2012-12-16', 'Internet', 'PL', 'PL'),
(5, 5, '', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', 'sowinski@konto.pl', '', 0, NULL, '', '', '', '', NULL, 0, '2012-12-16', 'Internet', 'PL', 'PL');

--
-- Zrzut danych tabeli `kandydat_dane_osobowe`
--

INSERT INTO `kandydat_dane_osobowe` (`username`,`Id_Kandydata`, `Nazwisko`, `Imie`, `Imie2`, `Imie_ojca`, `Imie_matki`, `data_urodzenia`, `Miejsce_urodzenia`, `Plec`, `Nazwisko_rodowe`, `Pesel`, `Nip`, `Numer_dowodu`, `ID_obywatelstwa`, `LP`, `Rodzaj_studiow`, `ID_rodz_matury`, `Rok_Ukonczenia_Szkoly`, `Uwagi`, `aprobata_wynikow`, `data_aprobata_wynikow`, `uzytkownik_aprobata_wynikow`, `data_wprowadzenia`, `uzytkownik_wprowadzenia`, `internet`, `Nr_swiad_matura`, `data_wystawienia_matura`, `Miejscowosc_wystawienia_matura`, `Nazwa_szkoly`, `id_komisji_okregowej`, `JezykAngMatura`, `Student_wat`, `Nr_albumu`, `Aktualiz_osobowe`, `data_ostatniej_aktualizacji`, `Uzytkownik_aktualiz_osobowe`, `konto_bankowe`, `kwota_oplaty`, `konto_ogolne_kwota`, `data_oplaty`, `uzytkownik_oplaty`, `uwagi_oplaty`, `data_zmiany_oplaty`) VALUES
('rekrutacja1@wat.edu.pl',1, 'Aaa', 'Aa', '', '', '', NULL, '', 'M', NULL, '50010100072', NULL, NULL, 0, NULL, 1, 2, 2012, NULL, NULL, NULL, NULL, '2012-02-29', 'Internet', '1', '', NULL, '', '', 0, '---', 0, 0, NULL, '2012-07-04', 'Internet', '50124069600350005001010007', 0, 0, NULL, NULL, NULL, NULL),
('rekrutacja2@wat.edu.pl',2, 'A', 'A', '', '', '', '0000-00-00', '', 'M', NULL, '53110204299', NULL, NULL, 0, NULL, 2, 2, 2012, NULL, NULL, NULL, NULL, '2012-02-29', 'Internet', '1', '', '0000-00-00', '', '', 1, '---', 0, 0, NULL, '2012-12-15', 'Internet', '73124069600350005311020429', 0, 0, NULL, NULL, NULL, NULL),
('rekrutacja3@wat.edu.pl',3, 'A', 'A', 'A', 'A', 'A', '1950-01-01', 'A', 'K', NULL, '50010100065', NULL, NULL, 1, NULL, 2, 2, 2012, NULL, '0', NULL, NULL, '2012-02-29', 'kheleniak', '0', NULL, NULL, NULL, NULL, NULL, '---', NULL, NULL, NULL, '2012-02-29', 'kheleniak', NULL, NULL, NULL, NULL, 'kheleniak', NULL, '2012-02-29'),
('rekrutacja4@wat.edu.pl',4, 'Piêæ', 'Adam', 'Android', 'Adam', '', '1955-05-05', 'Warszawa', NULL, NULL, '55050500055', NULL, NULL, 1, NULL, 2, 0, 0, NULL, NULL, NULL, NULL, '2012-12-16', 'Internet', '1', '', '0000-00-00', '', '', 0, '---', 0, 0, NULL, '2012-12-16', 'Internet', '25124069600350005505050005', 0, 0, NULL, NULL, NULL, NULL),
('rekrutacja5@wat.edu.pl',5, 'Szeœæ', 'Adam', 'Ios', 'Adam', 'Ewa', '1966-06-06', 'Warszawa', NULL, NULL, '66060600066', NULL, NULL, 1, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, '2012-12-16', 'Internet', '1', '', '0000-00-00', '', '', 0, '---', 0, 0, NULL, '2012-12-16', 'Internet', NULL, 0, 0, NULL, NULL, NULL, NULL);

--
-- Zrzut danych tabeli `kandydat_kierunki_wybrane_punkty_rankingowe`
--

INSERT INTO `kandydat_kierunki_wybrane_punkty_rankingowe` (`ID_tabeli_wydzialow`, `ID_kandydata`, `ID_kier_1_dzienne`, `ID_kier_2_dzienne`, `ID_kier_3_dzienne`, `ID_kier_1_dz_wojskowe`, `ID_kier_2_dz_wojskowe`, `ID_kier_3_dz_wojskowe`, `ID_kier_1_niestac`, `ID_kier_2_niestac`, `ID_kier_3_niestac`, `ID_kier_II_dzienne`, `ID_specjaln_1_dzienne`, `ID_specjaln_2_dzienne`, `ID_specjaln_3_dzienne`, `ID_kier_II_niestac`, `ID_specjaln_1_niestac`, `ID_specjaln_2_niestac`, `ID_specjaln_3_niestac`, `ID_kier_II_dz_wojskowe`, `ID_specjaln_1_dz_wojskowe`, `ID_specjaln_2_dz_wojskowe`, `ID_specjaln_3_dz_wojskowe`, `Data_aktualizacji_kierunkow`, `Uzytkownik_kierunkow`) VALUES
(1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-07-04 10:05:26', 'Internet'),
(2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-12-15 21:33:06', 'Internet'),
(3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-02-29 12:12:10', 'kheleniak'),
(4, 4, 39, 1, 4, NULL, NULL, NULL, 8, 43, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-12-16 00:53:40', 'Internet'),
(5, 5, 42, 10, 32, NULL, NULL, NULL, 14, 18, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2012-12-16 00:56:48', 'Internet');

--
-- Zrzut danych tabeli `login`
--

INSERT INTO `login` (`loginid`, `username`, `password`, `email`, `actcode`, `disabled`, `activated`, `id_Kandydata`, `ile_login`, `dok`, `stop_stud`, `data_godz`, `ip`) VALUES
(1, 'rekrutacja1@wat.edu.pl', '01a94f5ba8b078c73dbf957d336b2a664a9509a0', 'rekrutacja1@wat.edu.pl', 'LDBDmcPJzklQPGklPZQ9', 0, 1, 1, 20, 1, 7, '2012-02-29 11:46:20', '10.1.126.122 | Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.46 Safari/535.11'),
(2, 'rekrutacja2@wat.edu.pl', '01a94f5ba8b078c73dbf957d336b2a664a9509a0', 'rekrutacja2@wat.edu.pl', 'JsLcp1Nqdx2XBM1JJ45K', 0, 1, 2, 31, 1, 6, '2012-02-29 11:47:53', '10.1.126.122 | Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.46 Safari/535.11'),
(3, 'rekrutacja3@wat.edu.pl', 'bfd0b7bc1034b2b96f925ba701a04ed9dd7efba8', 'rekrutacja3@wat.edu.pl', '', 0, 1, 3, 2, 0, 6, '2012-02-29 12:12:10', NULL),
(4, 'rekrutacja4@wat.edu.pl', '01a94f5ba8b078c73dbf957d336b2a664a9509a0', 'rekrutacja4@wat.edu.pl', 'Wb6UWnTC7BGgZDpbSYR1', 0, 1, 4, 2, 1, 6, '2012-12-16 00:40:17', '78.30.121.202 | Mozilla/5.0 (Linux; U; Android 3.2.2; pl-pl; XOOM 2 ME Build/1.6.0_281.4-MZ608) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safa'),
(5, 'rekrutacja5@wat.edu.pl', '01a94f5ba8b078c73dbf957d336b2a664a9509a0', 'rekrutacja5@wat.edu.pl', 'gq2AnPUgrcYEhUqFg2k9', 0, 1, 5, 2, 1, 7, '2012-12-16 00:43:14', '78.30.121.202 | Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3');

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
