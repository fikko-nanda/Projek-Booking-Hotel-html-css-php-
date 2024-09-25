-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2024 at 04:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `category` varchar(111) NOT NULL,
  `price` int(11) NOT NULL,
  `nama_users` varchar(111) NOT NULL,
  `email_users` varchar(113) NOT NULL,
  `no_kartus` varchar(15) NOT NULL,
  `no_atm` int(244) NOT NULL,
  `cvv` int(22) NOT NULL,
  `tanggal_kdl` varchar(233) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `category`, `price`, `nama_users`, `email_users`, `no_kartus`, `no_atm`, `cvv`, `tanggal_kdl`) VALUES
(44, 'Premium Rooms', 5000000, 'arif kurniawan', 'a@gmail.com', '0821352889', 123456781, 222, '12/03'),
(45, 'private Rooms', 10000000, 'fiko ', 'a@gmail.com', '08765433332', 12345678, 333, '12/03'),
(49, 'Standard  Rooms', 800000, 'muhammad anugrah putra', 'a@gmail.com', '08213456789', 12345678, 123, '01/24'),
(51, 'sultan Rooms', 50000000, 'Muhammad Hanif ', 'hanif@gmail.com', '087654333111', 12345678, 143, '01/22');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkin`
--

CREATE TABLE `checkin` (
  `id` int(11) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `dewasa` int(11) NOT NULL,
  `nama_users` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkin`
--

INSERT INTO `checkin` (`id`, `checkin`, `checkout`, `dewasa`, `nama_users`) VALUES
(96, '2024-06-15', '2024-06-29', 3, 'arif kurniawan'),
(104, '2024-07-19', '2024-07-20', 2, 'fiko'),
(105, '2024-07-11', '2024-07-14', 2, 'muhammad anugrah putra'),
(106, '2024-08-21', '2024-08-22', 1, 'Muhammad Hanif '),
(139, '2024-07-13', '2024-07-14', 2, 'Muhammad Hanif ');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `galeri_foto` varchar(255) NOT NULL,
  `nama_tempat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `galeri_foto`, `nama_tempat`) VALUES
(6, 'a1.jpg', 'taman '),
(7, 'pexels-kenzero14-21582331.jpg', 'tempat bermain 1'),
(8, 'r3.jpg', 'taman '),
(9, 'g2.jpg', 'Area Santai'),
(11, 'pexels-laura-paredis-1047081-26424740.jpg', 'Bar '),
(12, 'pexels-drone-photography-reality-1175062728-21714720.jpg', 'area 2'),
(13, 'g5.jpg', 'area 3'),
(14, 'g4.jpg', 'area 4'),
(15, 'pexels-donaldtong94-189296.jpg', 'area1');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(125) NOT NULL,
  `password` varchar(245) NOT NULL,
  `email` varchar(123) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '123', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `nama_pemilik` varchar(133) NOT NULL,
  `jml_bayar` decimal(10,2) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `metode_bayar` varchar(222) NOT NULL,
  `status_bayar` varchar(333) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `nama_pemilik`, `jml_bayar`, `tanggal_bayar`, `metode_bayar`, `status_bayar`) VALUES
(24, 'arif kurniawan', 5000000.00, '2024-06-15', 'kartu_kredit', 'Lunas'),
(51, 'fiko', 10000000.00, '2024-07-20', 'atm', 'Lunas'),
(52, 'muhammad anugrah putra', 800000.99, '2024-07-11', 'kartu_kredit', 'Lunas'),
(53, 'muhammad hanif', 5000000.00, '2024-08-22', 'paypal', 'Belum dikonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `category`, `price`, `image`) VALUES
(32, 'Standard ', 800000.00, '3.jpg'),
(34, 'Suporior ', 800000.00, 'g6.jpg'),
(35, 'Deluxe ', 1500000.00, 'home3.jpg'),
(38, 'Premium', 5000000.00, 'g3.jpg'),
(39, 'private', 10000000.00, 'home3.jpg'),
(41, 'sultan', 50000000.00, 'g10.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkin`
--
ALTER TABLE `checkin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
