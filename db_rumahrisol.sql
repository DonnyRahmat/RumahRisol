-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2020 at 03:36 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rumahrisol`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_barang`
--

CREATE TABLE `t_barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `ukuran` varchar(15) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_min` int(11) NOT NULL,
  `harga_beli` float NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_barang`
--

INSERT INTO `t_barang` (`id_barang`, `nama_barang`, `satuan`, `ukuran`, `stok`, `stok_min`, `harga_beli`, `id_user`) VALUES
(9, 'Yakult', 'Kg', '1', 92, 5, 2500, 1),
(19, 'Susu', 'Liter', '1', 2, 2, 14000, 1),
(14, 'Boba', 'Kg', '1', 3, 5, 12000, 1),
(21, 'Garam', 'Kg', '1', 1, 2, 11500, 1),
(22, 'Maizena', 'Kg', '1', 1, 2, 11500, 1),
(23, 'Garam 3', 'Kg', '1', 1, 2, 11500, 1),
(24, 'Gula', 'Kg', '1', 6, 3, 15000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_brg_klr`
--

CREATE TABLE `t_brg_klr` (
  `id_brgklr` varchar(30) NOT NULL,
  `tgl_brg_klr` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_brg_klr`
--

INSERT INTO `t_brg_klr` (`id_brgklr`, `tgl_brg_klr`, `id_user`) VALUES
('K-1', '2020-01-15 14:40:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_brg_msk`
--

CREATE TABLE `t_brg_msk` (
  `id_brgmsk` varchar(30) NOT NULL,
  `tgl_brg_msk` timestamp NULL DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_brg_msk`
--

INSERT INTO `t_brg_msk` (`id_brgmsk`, `tgl_brg_msk`, `id_user`) VALUES
('M-1', '2020-01-13 02:45:24', 1),
('M-2', '2020-01-13 02:46:23', 1),
('M-3', '2020-01-13 03:28:16', 1),
('M-4', '2020-01-15 12:49:18', 1),
('M-5', '2020-01-15 12:49:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_detil_brgklr`
--

CREATE TABLE `t_detil_brgklr` (
  `id_detil_brgklr` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_brgklr` varchar(30) DEFAULT NULL,
  `jml_brgklr` int(11) DEFAULT NULL,
  `harga_brgklr` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_detil_brgklr`
--

INSERT INTO `t_detil_brgklr` (`id_detil_brgklr`, `id_barang`, `id_brgklr`, `jml_brgklr`, `harga_brgklr`) VALUES
(1, 14, 'K-1', 3, 12000);

--
-- Triggers `t_detil_brgklr`
--
DELIMITER $$
CREATE TRIGGER `trig_klr_stok` AFTER INSERT ON `t_detil_brgklr` FOR EACH ROW BEGIN

	UPDATE t_barang SET stok=stok-NEW.jml_brgklr
	WHERE id_barang=NEW.id_barang;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_detil_brgmsk`
--

CREATE TABLE `t_detil_brgmsk` (
  `id_detil_brgmsk` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_brgmsk` varchar(30) DEFAULT NULL,
  `jml_brgmsk` int(11) NOT NULL,
  `harga_brgmsk` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_detil_brgmsk`
--

INSERT INTO `t_detil_brgmsk` (`id_detil_brgmsk`, `id_barang`, `id_brgmsk`, `jml_brgmsk`, `harga_brgmsk`) VALUES
(2, 19, 'M-1', 1, 14000),
(1, 9, 'M-1', 1, 2500),
(3, 9, 'M-2', 90, 2500),
(4, 0, 'M-2', 0, 0),
(5, 14, 'M-4', 5, 12000),
(6, 0, 'M-4', 0, 0),
(7, 24, 'M-5', 5, 15000),
(8, 0, 'M-5', 0, 0),
(9, 0, 'M-5', 0, 0);

--
-- Triggers `t_detil_brgmsk`
--
DELIMITER $$
CREATE TRIGGER `trig_del_when_null` AFTER DELETE ON `t_detil_brgmsk` FOR EACH ROW delete B from t_brg_msk B left join t_detil_brgmsk DB on b.id_brgmsk=db.id_brgmsk where db.id_brgmsk is null
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trig_ins_stok` AFTER INSERT ON `t_detil_brgmsk` FOR EACH ROW BEGIN

	UPDATE t_barang SET stok=stok+NEW.jml_brgmsk
	WHERE id_barang=NEW.id_barang;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `fc_ktp` varchar(50) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `role` int(2) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id_user`, `username`, `fullname`, `password`, `alamat`, `no_telp`, `tgl_lahir`, `fc_ktp`, `tgl_masuk`, `role`, `last_login`) VALUES
(1, 'admin', 'Moehammad Donny', '$2y$10$XJjaLAvRTpQZcTe/afOxT.ZBqQehR7rCYo2jn9z63y1mD0rYrt2jm', 'Cianjur', '0857', '1997-03-06', '', '2019-09-27', 1, '2019-10-02 10:24:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_barang`
--
ALTER TABLE `t_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `fk_brg_user` (`id_user`);

--
-- Indexes for table `t_brg_klr`
--
ALTER TABLE `t_brg_klr`
  ADD PRIMARY KEY (`id_brgklr`);

--
-- Indexes for table `t_brg_msk`
--
ALTER TABLE `t_brg_msk`
  ADD PRIMARY KEY (`id_brgmsk`),
  ADD KEY `fk_brgmsk_user` (`id_user`);

--
-- Indexes for table `t_detil_brgklr`
--
ALTER TABLE `t_detil_brgklr`
  ADD PRIMARY KEY (`id_detil_brgklr`);

--
-- Indexes for table `t_detil_brgmsk`
--
ALTER TABLE `t_detil_brgmsk`
  ADD PRIMARY KEY (`id_detil_brgmsk`),
  ADD KEY `fk_d_brgmsk` (`id_brgmsk`),
  ADD KEY `fk_d_idb` (`id_barang`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_barang`
--
ALTER TABLE `t_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `t_detil_brgklr`
--
ALTER TABLE `t_detil_brgklr`
  MODIFY `id_detil_brgklr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_detil_brgmsk`
--
ALTER TABLE `t_detil_brgmsk`
  MODIFY `id_detil_brgmsk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
