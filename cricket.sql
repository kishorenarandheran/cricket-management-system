-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2018 at 04:25 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cricket`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `stadium` ()  NO SQL
select * from stadiums$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cricket_boards`
--

CREATE TABLE `cricket_boards` (
  `board_name` varchar(20) NOT NULL,
  `chairman` varchar(20) NOT NULL,
  `team` varchar(10) NOT NULL,
  `DOA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cricket_boards`
--

INSERT INTO `cricket_boards` (`board_name`, `chairman`, `team`, `DOA`) VALUES
('Andhra', 'kumar', 'srh', '2008-11-11'),
('Chennai', 'dev', 'csk', '2007-04-12'),
('Karnataka', 'ram', 'rcb', '2006-11-20'),
('Mumbai', 'krishna', 'mi', '2012-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('user', '123');
-- --------------------------------------------------------

--
-- Table structure for table `played_in`
--

CREATE TABLE `played_in` (
  `stadium_name` varchar(50) NOT NULL,
  `board_name` varchar(20) NOT NULL,
  `team` varchar(10) NOT NULL,
  `team1` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `team2` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `played_in`
--

INSERT INTO `played_in` (`stadium_name`, `board_name`, `team`, `team1`, `date`, `team2`) VALUES
('chidambaram', 'chennai', 'csk', 'csk', '2018-12-27', 'rcb'),
('M.Chinnaswamy Stadium', 'ksca', 'rcb', 'rcb', '2018-12-20', 'srh'),
('Rajiv Gandhi', 'Andhra', 'srh', 'srh', '2018-12-28', 'mi'),
('Wankhede', 'mumbai', 'mi', 'mi', '2018-12-26', 'csk');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `cap_no` decimal(4,0) NOT NULL,
  `age` decimal(2,0) NOT NULL,
  `dob` date NOT NULL,
  `runs` decimal(5,0) NOT NULL,
  `wickets` decimal(3,0) NOT NULL,
  `type` varchar(20) NOT NULL,
  `no_of_matches` decimal(3,0) NOT NULL,
  `rank` decimal(3,0) NOT NULL,
  `batting_best` varchar(10) NOT NULL,
  `bowling_best` varchar(10) NOT NULL,
  `playername` varchar(30) NOT NULL,
  `image` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`cap_no`, `age`, `dob`, `runs`, `wickets`, `type`, `no_of_matches`, `rank`, `batting_best`, `bowling_best`, `playername`, `image`, `name`) VALUES
('1', '32', '1975-05-01', '1200', '59', 'Allrounder', '98', '12', '77', '32/5', 'Vinay kumar R', 'img/vinay.jpg', 'srh'),
('3', '32', '1975-05-01', '1200', '59', 'Allrounder', '98', '13', '77', '32/5', 'Navdeep Saini', 'img/nav.jpg', 'rcb'),
('4', '34', '1978-01-01', '1203', '58', 'bowler', '98', '5', '95', '23/4', 'Mohammad Siraj', 'img/siraj.jpg', 'RCB'),
('5', '33', '1997-02-04', '3542', '22', 'batsman', '113', '19', '115*', '18/9', 'Suresh Raina', 'img/raina.jpeg', 'csk'),
('5', '29', '1985-11-14', '2565', '45', 'batsman', '54', '7', '75', '25/3', 'Kane williamson', 'img/kane.jpg', 'srh'),
('6', '19', '1976-01-09', '250', '7', 'Allrounder', '45', '19', '95', '22/2', 'Aiden Markam', 'img/markam.jpg', 'rcb'),
('7', '35', '1982-01-24', '3452', '24', 'batsman', '145', '5', '71*', '14/8', 'M S Dhoni', 'img/dhoni.jpg', 'csk'),
('8', '34', '1978-12-28', '1254', '95', 'Allrounder', '14', '8', '78', '22/3', 'Moeen ali', 'img/moeen.jpg', 'mi'),
('9', '33', '1946-12-08', '1258', '84', 'bowler', '85', '1', '55', '26/1', 'c gayle', 'img/gayle.jpg', 'rcb'),
('11', '35', '1978-07-08', '2512', '55', 'batsman', '85', '11', '88', '24/8', 'yuvaraj singh', 'img/yuvraj.jpg', 'srh'),
('12', '34', '1978-01-01', '1203', '58', 'bowler', '98', '18', '95', '23/4', 'Aaaron finch', 'img/finch.jpg', 'srh'),
('13', '26', '1978-06-04', '1256', '58', 'Allrounder', '44', '10', '42', '26/4', 'Axar Patel', 'img/axar.jpg', 'srh'),
('14', '26', '1985-11-06', '1298', '54', 'batsman', '89', '15', '65', '25/2', 'kl rahul', 'img/rahul.jpg', 'rcb'),
('15', '29', '1985-11-14', '2565', '45', 'allrounder', '54', '19', '75', '25/3', 'Yuvraj Singh', 'img/yuvraj.jpg', 'srh'),
('16', '26', '1995-06-24', '2800', '25', 'batsman', '84', '6', '85', '29/1', 'shikkar dhawan', 'img/dhawan.jpg', 'srh'),
('17', '32', '1976-02-28', '4007', '100', 'batsman', '141', '3', '133*', '18/2', 'AB De villiers', 'img/abdv.jpg', 'rcb'),
('18', '29', '1985-11-05', '4008', '125', 'batsman', '163', '2', '113*', '18/2', 'viratkohli', 'img/kholi.jpg', 'rcb'),
('19', '29', '1985-11-14', '2565', '45', 'batsman', '54', '8', '75', '25/3', 'david warner', 'img/warner.jpg', 'srh'),
('20', '29', '1986-06-05', '152', '75', 'bowler', '78', '3', '40', '25/4', 'Travis Head', 'img/head.jpg', 'rcb'),
('25', '36', '1985-04-03', '1524', '75', 'batsman', '78', '13', '98', '25/4', 'Harbajan Sigh', 'img/harbhajan.jpg', 'mi'),
('26', '24', '1982-01-06', '1245', '87', 'batsman', '44', '16', '58', '4/6', 'Jasprit Bumrah', 'img/bumrah.jpg', 'mi'),
('28', '22', '1975-01-08', '1789', '41', 'bowler', '45', '7', '40', '18/3', 'Hardhik Pandhya', 'img/hardik.jpg', 'mi'),
('29', '23', '1996-11-04', '2458', '50', 'bowler', '85', '6', '77', '17/2', 'Quinton de Kock', 'img/dekock.jpg', 'mi'),
('34', '35', '1999-11-04', '458', '20', 'Allrounder', '54', '15', '84', '19/3', 'kieren Pollard', 'img/pollard.jpg', 'mi'),
('45', '29', '1993-08-19', '125', '45', 'batsman', '144', '19', '88', '25/1', 'Rohit Sharma', 'img/rohit.jpg', 'mi'),
('55', '36', '1978-11-04', '254', '26', 'batsman', '102', '17', '29/4', '19/3', 'Watson', 'img/watson.jpg', 'csk'),
('58', '27', '1983-11-25', '2145', '28', 'batsman', '87', '12', '109', '28/6', 'Ajinkya Rahane', 'img/rahane.jpg', 'csk'),
('63', '26', '1978-06-04', '1256', '58', 'Allrounder', '44', '9', '42', '26/4', 'Dale Steyn', 'img/dale.jpg', 'srh'),
('64', '26', '1985-11-06', '1298', '54', 'batsman', '89', '14', '65', '25/2', 'Hashim Amla', 'img/hashim.jpg', 'rcb'),
('65', '26', '1978-04-06', '1254', '27', 'Allrounder', '77', '14', '85', '19/4', 'Lungi ngidi', 'img/lungi.jpg', 'csk'),
('66', '33', '1997-02-04', '3542', '22', 'allrounder', '113', '2', '115*', '18/9', 'Ishant Sharma', 'img/ishant.jpg', 'csk'),
('75', '26', '1997-05-26', '425', '24', 'Allrounder', '88', '20', '16', '20/4', 'Ambati Rayudu', 'img/rayudu.jpg', 'csk'),
('75', '19', '1976-01-09', '250', '7', 'Allrounder', '45', '20', '95', '22/2', 'Ravichandran Ashwin', 'img/ashwin.jpg', 'rcb'),
('81', '35', '1978-07-08', '2512', '55', 'batsman', '85', '10', '88', '24/8', 'Partiv Patel', 'img/part.jpg', 'srh'),
('82', '36', '1988-01-01', '125', '83', 'Allrounder', '44', '17', '56', '22/01', 'Kulwant Khejrolia', 'img/kk.jpg', 'rcb'),
('85', '19', '1986-11-03', '2546', '22', 'batsman', '90', '9', '18', '39/5', 'Karn Sharma', 'img/ks.jpg', 'csk'),
('86', '26', '1995-06-24', '2800', '25', 'allrounder', '84', '4', '85', '29/1', 'Ben Sokes', 'img/bs.jpg', 'srh'),
('87', '35', '1982-01-24', '3452', '24', 'allrounder', '145', '3', '71*', '14/8', 'Washington Sundar', 'img/ws.jpg', 'rcb'),
('90', '32', '1976-02-28', '4007', '100', 'allrounder', '141', '1', '133*', '18/2', 'Glenn Maxwell', 'img/maxi.jpeg', 'rcb'),
('92', '36', '1988-01-01', '125', '83', 'Allrounder', '44', '18', '56', '22/01', 'Morne Morkel', 'img/mm.jpg', 'rcb'),
('95', '19', '1995-03-14', '1298', '24', 'Allrounder', '91', '11', '17', '2/3', 'Faf du Plessis', 'img/faf.jpg', 'csk'),
('96', '28', '1992-11-04', '1998', '65', 'Allrounder', '85', '7', '25', '28/4', 'Mitchell Starc', 'img/ms.jpg', 'rcb'),
('97', '29', '0000-00-00', '214', '64', 'batsman', '56', '18', '98', '25/3', 'Manish Pandey', 'img/mp.jpeg', 'rcb'),
('98', '23', '1985-10-04', '2256', '78', 'bowler', '15', '2', '56', '20/3', 'Chahal', 'img/chahal.jpg', 'csk'),
('99', '29', '1978-11-07', '2245', '85', 'Allrounder', '20', '6', '85', '20/6', 'Umesh Yadav', 'img/um.jpg', 'srh');

--
-- Triggers `player`
--
DELIMITER $$
CREATE TRIGGER `update` BEFORE UPDATE ON `player` FOR EACH ROW BEGIN
IF (new.runs<old.runs) THEN SET new.runs=old.runs;
IF (new.wickets<old.wickets) THEN SET new.wickets=old.wickets;
END IF;
IF (new.no_of_matches<old.no_of_matches) THEN SET new.no_of_matches=old.no_of_matches;
END IF;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `team1` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `match_no` decimal(3,0) NOT NULL,
  `team2` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`team1`, `date`, `match_no`, `team2`) VALUES
('csk', '2018-12-27', '3', 'rcb'),
('mi', '2018-12-26', '2', 'csk'),
('mi', '2019-01-01', '5', 'csk'),
('RCB', '2018-12-20', '1', 'SRH'),
('SRH', '2018-12-28', '4', 'MI');

-- --------------------------------------------------------

--
-- Table structure for table `selected_for`
--

CREATE TABLE `selected_for` (
  `position` varchar(20) NOT NULL,
  `cap_no` decimal(4,0) NOT NULL,
  `name` varchar(30) NOT NULL,
  `team1` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `team2` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `selected_for`
--

INSERT INTO `selected_for` (`position`, `cap_no`, `name`, `team1`, `date`, `team2`) VALUES
('CAPTAIN', '17', 'rcb', 'rcb', '2018-12-20', 'srh'),
('VICE-CAPTAIN', '18', 'rcb', 'rcb', '2018-12-20', 'srh');

-- --------------------------------------------------------

--
-- Table structure for table `stadiums`
--

CREATE TABLE `stadiums` (
  `stadium_name` varchar(50) NOT NULL,
  `capacity` decimal(6,0) NOT NULL,
  `DOI` date NOT NULL,
  `board_name` varchar(20) NOT NULL,
  `team` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stadiums`
--

INSERT INTO `stadiums` (`stadium_name`, `capacity`, `DOI`, `board_name`, `team`) VALUES
('chidambaram', '84000', '1985-05-11', 'chennai', 'csk'),
('M.Chinnaswamy Stadium', '41000', '1996-11-20', 'ksca', 'rcb'),
('Rajiv Gandhi', '25000', '1974-12-28', 'andhra', 'srh'),
('Wankhede', '65000', '1976-11-25', 'mumbai', 'mi');

--
-- Triggers `stadiums`
--
DELIMITER $$
CREATE TRIGGER `default_date` BEFORE INSERT ON `stadiums` FOR EACH ROW set new.DOI=CURRENT_DATE()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `rank` decimal(5,0) NOT NULL,
  `rating` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`rank`, `rating`, `name`) VALUES
('3', 119, 'csk'),
('4', 116, 'mi'),
('2', 120, 'RCB'),
('1', 122, 'srh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`) ;

--
-- Indexes for table `cricket_boards`
--
ALTER TABLE `cricket_boards`
  ADD PRIMARY KEY (`board_name`,`team`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `played_in`
--
ALTER TABLE `played_in`
  ADD PRIMARY KEY (`stadium_name`,`board_name`,`team`,`team1`,`date`,`team2`),
  ADD KEY `team1` (`team1`,`date`,`team2`)  ON DELETE CASCADE;

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`cap_no`,`name`),
  ADD KEY `name` (`name`)  ON DELETE CASCADE;

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`team1`,`date`,`team2`)  ON DELETE CASCADE;

--
-- Indexes for table `selected_for`
--
ALTER TABLE `selected_for`
  ADD PRIMARY KEY (`cap_no`,`name`,`team1`,`date`,`team2`),
  ADD KEY `team1` (`team1`,`date`,`team2`)  ON DELETE CASCADE;

--
-- Indexes for table `stadiums`
--
ALTER TABLE `stadiums`
  ADD PRIMARY KEY (`stadium_name`,`board_name`,`team`),
  ADD KEY `board_name` (`board_name`,`team`)  ON DELETE CASCADE;

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `played_in`
--
ALTER TABLE `played_in`
  ADD CONSTRAINT `played_in_ibfk_1` FOREIGN KEY (`stadium_name`,`board_name`,`team`) REFERENCES `stadiums` (`stadium_name`, `board_name`, `team`),
  ADD CONSTRAINT `played_in_ibfk_2` FOREIGN KEY (`team1`,`date`,`team2`) REFERENCES `schedules` (`team1`, `date`, `team2`) ON DELETE CASCADE;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`name`) REFERENCES `team` (`name`) ON DELETE CASCADE;

--
-- Constraints for table `selected_for`
--
ALTER TABLE `selected_for`
  ADD CONSTRAINT `selected_for_ibfk_1` FOREIGN KEY (`cap_no`,`name`) REFERENCES `player` (`cap_no`, `name`),
  ADD CONSTRAINT `selected_for_ibfk_2` FOREIGN KEY (`team1`,`date`,`team2`) REFERENCES `schedules` (`team1`, `date`, `team2`) ON DELETE CASCADE;

--
-- Constraints for table `stadiums`
--
ALTER TABLE `stadiums`
  ADD CONSTRAINT `stadiums_ibfk_1` FOREIGN KEY (`board_name`,`team`) REFERENCES `cricket_boards` (`board_name`, `team`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
