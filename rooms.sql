-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Dez 2021 um 17:14
-- Server-Version: 10.4.17-MariaDB
-- PHP-Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `cpe22012021`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gruppen`
--

CREATE TABLE `gruppen` (
  `id` int(10) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `gruppen`
--

INSERT INTO `gruppen` (`id`, `name`) VALUES
(1, 'Büro'),
(2, 'Produktion'),
(3, 'Sanitär'),
(4, 'Erdgeschoß'),
(5, 'Obergeschoß');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `werte`
--

CREATE TABLE `werte` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `wert` float NOT NULL DEFAULT 20,
  `min_wert` float NOT NULL DEFAULT 10,
  `max_wert` float NOT NULL DEFAULT 40,
  `einheit` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '°C',
  `humidity` float NOT NULL DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `werte`
--

INSERT INTO `werte` (`id`, `name`, `wert`, `min_wert`, `max_wert`, `einheit`, `humidity`) VALUES
(1, 'Temp_Büro_1', 10.9, 10, 40, '°C', 72),
(2, 'Temp_Büro_2', 11.2, 10, 40, '°C', 28.8),
(3, 'Temp_Büro_3', 33.4, 10, 40, '°C', 65.8),
(4, 'Temp_Prod_1', 11.6, 10, 40, '°C', 58.2),
(5, 'Temp_Prod_2', 10, 10, 40, '°C', 19.6),
(6, 'Temp_Sani_1', 20, 10, 40, '°C', 37),
(7, 'Temp_Sani_2', 18.2, 10, 40, '°C', 35.9),
(8, 'ház', 32.9, 10, 40, '°C', 19.6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `werte_zu_gruppen`
--

CREATE TABLE `werte_zu_gruppen` (
  `wert_id` int(11) NOT NULL,
  `gruppe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `werte_zu_gruppen`
--

INSERT INTO `werte_zu_gruppen` (`wert_id`, `gruppe_id`) VALUES
(1, 1),
(1, 4),
(2, 1),
(2, 4),
(3, 1),
(4, 2),
(5, 2),
(6, 3),
(7, 3);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `gruppen`
--
ALTER TABLE `gruppen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `werte`
--
ALTER TABLE `werte`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `werte_zu_gruppen`
--
ALTER TABLE `werte_zu_gruppen`
  ADD PRIMARY KEY (`wert_id`,`gruppe_id`),
  ADD KEY `gruppe_id` (`gruppe_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `gruppen`
--
ALTER TABLE `gruppen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `werte`
--
ALTER TABLE `werte`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `werte_zu_gruppen`
--
ALTER TABLE `werte_zu_gruppen`
  ADD CONSTRAINT `werte_zu_gruppen_ibfk_1` FOREIGN KEY (`wert_id`) REFERENCES `werte` (`id`),
  ADD CONSTRAINT `werte_zu_gruppen_ibfk_2` FOREIGN KEY (`gruppe_id`) REFERENCES `gruppen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
