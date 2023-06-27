-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2023 at 09:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recepcion-utiles`
--

-- --------------------------------------------------------

--
-- Table structure for table `estudiantes`
--

CREATE TABLE `estudiantes` (
  `ID` int(11) NOT NULL,
  `NombreEstudiante` varchar(100) DEFAULT NULL,
  `GradoID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estudiantes`
--

INSERT INTO `estudiantes` (`ID`, `NombreEstudiante`, `GradoID`) VALUES
(3, 'Juan Perez', 7);

-- --------------------------------------------------------

--
-- Table structure for table `grados`
--

CREATE TABLE `grados` (
  `ID` int(11) NOT NULL,
  `Grado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grados`
--

INSERT INTO `grados` (`ID`, `Grado`) VALUES
(7, 'T-1'),
(8, 'P-2'),
(10, '1-1'),
(11, '1-2');

-- --------------------------------------------------------

--
-- Table structure for table `listadeutiles`
--

CREATE TABLE `listadeutiles` (
  `ID` int(11) NOT NULL,
  `GradoID` int(11) DEFAULT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listadeutiles`
--

INSERT INTO `listadeutiles` (`ID`, `GradoID`, `Nombre`, `Descripcion`, `Cantidad`) VALUES
(10, 7, 'Hojas carta', 'Resma de hojas carta', 2),
(11, 11, 'Hojas carta', 'Resma de hojas carta', 3);

-- --------------------------------------------------------

--
-- Table structure for table `utilesestudiante`
--

CREATE TABLE `utilesestudiante` (
  `ID` int(11) NOT NULL,
  `EstudianteID` int(11) DEFAULT NULL,
  `UtilID` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilesestudiante`
--

INSERT INTO `utilesestudiante` (`ID`, `EstudianteID`, `UtilID`, `Cantidad`, `Timestamp`) VALUES
(1, 3, 10, 1, '2023-06-27 19:46:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `GradoID` (`GradoID`);

--
-- Indexes for table `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `listadeutiles`
--
ALTER TABLE `listadeutiles`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `GradoID` (`GradoID`);

--
-- Indexes for table `utilesestudiante`
--
ALTER TABLE `utilesestudiante`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `EstudianteID` (`EstudianteID`),
  ADD KEY `UtilID` (`UtilID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grados`
--
ALTER TABLE `grados`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `listadeutiles`
--
ALTER TABLE `listadeutiles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `utilesestudiante`
--
ALTER TABLE `utilesestudiante`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`GradoID`) REFERENCES `grados` (`ID`);

--
-- Constraints for table `listadeutiles`
--
ALTER TABLE `listadeutiles`
  ADD CONSTRAINT `listadeutiles_ibfk_1` FOREIGN KEY (`GradoID`) REFERENCES `grados` (`ID`);

--
-- Constraints for table `utilesestudiante`
--
ALTER TABLE `utilesestudiante`
  ADD CONSTRAINT `utilesestudiante_ibfk_1` FOREIGN KEY (`EstudianteID`) REFERENCES `estudiantes` (`ID`),
  ADD CONSTRAINT `utilesestudiante_ibfk_2` FOREIGN KEY (`UtilID`) REFERENCES `listadeutiles` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
