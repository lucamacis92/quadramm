-- phpMyAdmin SQL Dump
-- version 4.3.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2015 alle 10:08
-- Versione del server: 5.5.42
-- PHP Version: 5.6.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `LucaMacis`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Negozio`
--

CREATE TABLE `Negozio` (
  `ID` int(11) NOT NULL,
  `NomeNegozio` varchar(50) NOT NULL,
  `Descrizione` varchar(50) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Negozio`
--

INSERT INTO `Negozio` (`ID`, `NomeNegozio`, `Descrizione`, `User_ID`) VALUES
(1, 'nanana', 'papapa', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Negozio_has_Quadri`
--

CREATE TABLE `Negozio_has_Quadri` (
  `NegozioID` int(11) NOT NULL,
  `QuadroID` int(11) NOT NULL,
  `Prezzo` decimal(10,2) NOT NULL,
  `Qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Negozio_has_Quadri`
--

INSERT INTO `Negozio_has_Quadri` (`NegozioID`, `QuadroID`, `Prezzo`, `Qty`) VALUES
(1, 1, '99.00', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `Negozio_has_Quadri_has_Ordine`
--

CREATE TABLE `Negozio_has_Quadri_has_Ordine` (
  `OrdineID` int(11) NOT NULL,
  `NegozioID` int(11) NOT NULL,
  `QuadriID` int(11) NOT NULL,
  `Stato` int(11) NOT NULL,
  `Prezzo` decimal(10,2) NOT NULL,
  `Qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Negozio_has_Quadri_has_Ordine`
--

INSERT INTO `Negozio_has_Quadri_has_Ordine` (`OrdineID`, `NegozioID`, `QuadriID`, `Stato`, `Prezzo`, `Qty`) VALUES
(7, 1, 1, 1, '99.00', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Ordine`
--

CREATE TABLE `Ordine` (
  `ID` int(11) NOT NULL,
  `Data` varchar(50) NOT NULL,
  `Stato` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Ordine`
--

INSERT INTO `Ordine` (`ID`, `Data`, `Stato`, `User_ID`) VALUES
(7, '2015-04-12 04:11:46', 1, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `Quadri`
--

CREATE TABLE `Quadri` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Autore` varchar(50) NOT NULL,
  `Data` varchar(50) NOT NULL,
  `Dimensione` varchar(50) NOT NULL,
  `Tecnica` varchar(50) NOT NULL,
  `Corrente` varchar(50) NOT NULL,
  `Descrizione` varchar(50) NOT NULL,
  `Immagine` varchar(50) NOT NULL,
  `Tipologia` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Quadri`
--

INSERT INTO `Quadri` (`ID`, `Nome`, `Autore`, `Data`, `Dimensione`, `Tecnica`, `Corrente`, `Descrizione`, `Immagine`, `Tipologia`) VALUES
(1, 'quadro1', 'mario', '01/10/2015', '12434', 'jkhvhgch', 'jkhlgiu', 'khgcgfxfew', 'Marilyn.jpg', 'Medievale');

-- --------------------------------------------------------

--
-- Struttura della tabella `User`
--

CREATE TABLE `User` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Cognome` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Ruolo` int(11) NOT NULL,
  `Via` varchar(50) NOT NULL,
  `Civico` int(11) NOT NULL,
  `Citta` varchar(50) NOT NULL,
  `Cap` int(11) NOT NULL,
  `Credito` decimal(10,2) NOT NULL,
  `Provincia` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `User`
--

INSERT INTO `User` (`ID`, `Nome`, `Cognome`, `Username`, `Password`, `Email`, `Ruolo`, `Via`, `Civico`, `Citta`, `Cap`, `Credito`, `Provincia`) VALUES
(1, 'Luca', 'Macis', 'lucamacis', 'ff377aff39a9345a9cca803fb5c5c081', 'l@m.it', 1, 'la', 1, 'cagliari', 9100, '89.10', 'ca'),
(2, 'Pippo', 'Verdi', 'pippoverdi', '0c88028bf3aa6a6a143ed846f2be1ea4', 'pippo@verdi.it', 2, 'kgvhgc', 1, 'jjh', 9120, '11901.00', 'ug'),
(3, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 0, '', 0, '', 0, '0.00', ''),
(4, 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmai.com', 2, 'kgckhgc', 1, 'vsavsh', 9100, '20000.00', 'er');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Negozio`
--
ALTER TABLE `Negozio`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Negozio_has_Quadri`
--
ALTER TABLE `Negozio_has_Quadri`
  ADD PRIMARY KEY (`NegozioID`,`QuadroID`);

--
-- Indexes for table `Negozio_has_Quadri_has_Ordine`
--
ALTER TABLE `Negozio_has_Quadri_has_Ordine`
  ADD PRIMARY KEY (`OrdineID`,`NegozioID`);

--
-- Indexes for table `Ordine`
--
ALTER TABLE `Ordine`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Quadri`
--
ALTER TABLE `Quadri`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Negozio`
--
ALTER TABLE `Negozio`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Ordine`
--
ALTER TABLE `Ordine`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Quadri`
--
ALTER TABLE `Quadri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;