-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 25. jan 2022 ob 15.07
-- Različica strežnika: 10.4.21-MariaDB
-- Različica PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `mydb`
--

-- --------------------------------------------------------

--
-- Struktura tabele `prevozi`
--

CREATE TABLE `prevozi` (
  `idprevozi` int(11) NOT NULL,
  `znamka` varchar(100) NOT NULL,
  `barva` varchar(100) NOT NULL,
  `iz` varchar(100) DEFAULT NULL,
  `v` varchar(100) DEFAULT NULL,
  `prostor` int(11) DEFAULT NULL,
  `cas` datetime DEFAULT NULL,
  `uporabnik_uporabnikid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `prevozi`
--

INSERT INTO `prevozi` (`idprevozi`, `znamka`, `barva`, `iz`, `v`, `prostor`, `cas`, `uporabnik_uporabnikid`) VALUES
(6, 'Audi', 'Črna', 'LJ-Center', 'Stožice', 1, '2022-01-20 21:35:00', 1),
(7, 'Renault', 'Bela', 'Bežigrad', 'Vič', 2, '2021-11-18 14:34:00', 1),
(8, 'BMW', 'Siva', 'Mercator, Dunajska cesta, Ljubljana, Slovenija', 'BTC City, Hala A, Ljubljana, Slovenija', 1, '2022-01-20 19:54:00', 1),
(9, 'test', 'test', 'Testenova ulica, Mengeš, Slovenija', 'Testenine in Slaščice Safet Amza s.p., Bohinjčeva ulica, Ljubljana, Slovenija', 121, '2022-01-29 20:11:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabele `rezervacije`
--

CREATE TABLE `rezervacije` (
  `idrezervacije` int(11) NOT NULL,
  `znamka` varchar(100) DEFAULT NULL,
  `barva` varchar(100) DEFAULT NULL,
  `iz` varchar(100) DEFAULT NULL,
  `v` varchar(100) DEFAULT NULL,
  `cas` datetime DEFAULT NULL,
  `uporabnik_uporabnikid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `rezervacije`
--

INSERT INTO `rezervacije` (`idrezervacije`, `znamka`, `barva`, `iz`, `v`, `cas`, `uporabnik_uporabnikid`) VALUES
(1, 'Toyota', 'Modra', 'Rožna dolina', 'FRI', '2022-01-17 12:40:34', 1),
(2, 'Chevrolet', 'Bela', 'FRI', 'Bežigrad', '2021-12-04 16:04:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabele `uporabnik`
--

CREATE TABLE `uporabnik` (
  `uporabnikid` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `uporabnik`
--

INSERT INTO `uporabnik` (`uporabnikid`, `username`, `email`, `password`) VALUES
(1, 'zan', 'zan.korenkern@gmail.com', '202cb962ac59075b964b07152d234b70'),
(2, 'test', 'test@test.com', '202cb962ac59075b964b07152d234b70');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `prevozi`
--
ALTER TABLE `prevozi`
  ADD PRIMARY KEY (`idprevozi`),
  ADD KEY `fk_prevozi_uporabnik_idx` (`uporabnik_uporabnikid`);

--
-- Indeksi tabele `rezervacije`
--
ALTER TABLE `rezervacije`
  ADD PRIMARY KEY (`idrezervacije`),
  ADD KEY `fk_rezervacije_uporabnik1_idx` (`uporabnik_uporabnikid`);

--
-- Indeksi tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  ADD PRIMARY KEY (`uporabnikid`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `prevozi`
--
ALTER TABLE `prevozi`
  MODIFY `idprevozi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT tabele `rezervacije`
--
ALTER TABLE `rezervacije`
  MODIFY `idrezervacije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT tabele `uporabnik`
--
ALTER TABLE `uporabnik`
  MODIFY `uporabnikid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `prevozi`
--
ALTER TABLE `prevozi`
  ADD CONSTRAINT `fk_prevozi_uporabnik` FOREIGN KEY (`uporabnik_uporabnikid`) REFERENCES `uporabnik` (`uporabnikid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omejitve za tabelo `rezervacije`
--
ALTER TABLE `rezervacije`
  ADD CONSTRAINT `fk_rezervacije_uporabnik1` FOREIGN KEY (`uporabnik_uporabnikid`) REFERENCES `uporabnik` (`uporabnikid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
