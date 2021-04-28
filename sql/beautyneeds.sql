-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2021 at 12:16 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beautyneeds`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pemesanan`
--

CREATE TABLE `detail_pemesanan` (
  `idPemesanan` varchar(5) NOT NULL,
  `idProduk` varchar(5) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pemesanan`
--

INSERT INTO `detail_pemesanan` (`idPemesanan`, `idProduk`, `jumlah`, `subtotal`) VALUES
('PE002', 'P0001', 2, 80000),
('PM2Vu', 'P0001', 1, 40000),
('PMTk7', 'P0004', 1, 65000),
('PMTk7', 'P0003', 1, 65000);

-- --------------------------------------------------------

--
-- Table structure for table `jenisbayar`
--

CREATE TABLE `jenisbayar` (
  `idJenisBayar` varchar(5) NOT NULL,
  `namajenisb` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenisbayar`
--

INSERT INTO `jenisbayar` (`idJenisBayar`, `namajenisb`) VALUES
('JB001', 'Cash On Delivery'),
('JB002', 'ATM Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `jenisproduk`
--

CREATE TABLE `jenisproduk` (
  `idJenisProduk` varchar(5) NOT NULL,
  `namaJenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenisproduk`
--

INSERT INTO `jenisproduk` (`idJenisProduk`, `namaJenis`) VALUES
('JP01', 'Skincare'),
('JP02', 'Makeup');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `idKaryawan` varchar(5) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`idKaryawan`, `nama`, `username`, `password`, `role`) VALUES
('K001', 'mawar', 'mawarsilveria', '$2y$10$SuAjVvNWfUX6SYfQNkBHCeqdgul.vJb/CTLkClTsqSAkUYqlmkeRq', 1),
('K002', 'vianka', 'viankatetiana', '$2y$10$SuAjVvNWfUX6SYfQNkBHCeqdgul.vJb/CTLkClTsqSAkUYqlmkeRq', 2),
('K003', 'Ferdi Setyono', 'ferdisetyono', '$2y$10$SuAjVvNWfUX6SYfQNkBHCeqdgul.vJb/CTLkClTsqSAkUYqlmkeRq', 1);

-- --------------------------------------------------------

--
-- Table structure for table `laba`
--

CREATE TABLE `laba` (
  `idLaba` varchar(5) NOT NULL,
  `idProduk` varchar(5) NOT NULL,
  `idKaryawan` varchar(5) NOT NULL,
  `tgl_laba` date NOT NULL,
  `jumlahLaba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laba`
--

INSERT INTO `laba` (`idLaba`, `idProduk`, `idKaryawan`, `tgl_laba`, `jumlahLaba`) VALUES
('L0001', 'P0001', 'K001', '2021-04-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `idPembayaran` varchar(5) NOT NULL,
  `tanggalBayar` date NOT NULL,
  `idJenisBayar` varchar(5) NOT NULL,
  `idKaryawan` varchar(5) NOT NULL,
  `tanggalTenggat` date NOT NULL,
  `bukti` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`idPembayaran`, `tanggalBayar`, `idJenisBayar`, `idKaryawan`, `tanggalTenggat`, `bukti`) VALUES
('PB001', '2021-03-30', 'JB002', 'K001', '2021-03-31', ''),
('PB002', '2021-03-22', 'JB001', 'K001', '2021-03-23', ''),
('PBLVN', '2021-04-26', 'JB002', 'K001', '0000-00-00', 'S__14811178.jpg'),
('PBnP3', '2021-04-26', 'JB001', 'K001', '0000-00-00', 'KTM_13011842712.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `idPemesanan` varchar(5) NOT NULL,
  `tgl_pemesanan` date NOT NULL,
  `total` int(11) NOT NULL,
  `idUser` varchar(5) NOT NULL,
  `idKaryawan` varchar(5) NOT NULL,
  `idPembayaran` varchar(5) NOT NULL,
  `statuspm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`idPemesanan`, `tgl_pemesanan`, `total`, `idUser`, `idKaryawan`, `idPembayaran`, `statuspm`) VALUES
('PE002', '2021-03-21', 80000, 'abcde', 'K001', 'PB002', 0),
('PM2Vu', '2021-04-26', 40000, 'USZDB', 'K001', 'PBnP3', 2),
('PMTk7', '2021-04-26', 130000, 'USZDB', 'K001', 'PBLVN', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pendapatansales`
--

CREATE TABLE `pendapatansales` (
  `idPendapatanS` varchar(5) NOT NULL,
  `idUser` varchar(5) NOT NULL,
  `idProduk` varchar(5) NOT NULL,
  `idKaryawan` varchar(5) NOT NULL,
  `jumlahPendapatan` int(11) NOT NULL,
  `statuspes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendapatansales`
--

INSERT INTO `pendapatansales` (`idPendapatanS`, `idUser`, `idProduk`, `idKaryawan`, `jumlahPendapatan`, `statuspes`) VALUES
('PS001', 'aaaaa', 'P0001', 'K001', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idProduk` varchar(5) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `warna` varchar(5) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `idJenisProduk` varchar(5) NOT NULL,
  `idKaryawan` varchar(5) NOT NULL,
  `idUser` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idProduk`, `nama`, `warna`, `harga`, `gambar`, `deskripsi`, `status`, `stok`, `idJenisProduk`, `idKaryawan`, `idUser`) VALUES
('P0001', 'Emina Sunscreen', 'putih', 40000, 'emina_ss.jpg', 'this is sunscreen', 1, 25, 'JP01', 'K001', 'aaaaa'),
('P0002', 'Wardah Facial Wash', 'putih', 32000, 'wardah_facialwash.jpg', 'facial wash creamy foam', 1, 50, 'JP01', 'K001', 'abcde'),
('P0003', 'Scarlett Brightly Ever After Serum', 'merah', 65000, 'scarlett_serum1.jpg', 'phyto whitening, gluthatione, vit c', 1, 100, 'JP01', 'K001', 'abcde'),
('P0004', 'Scarlett Acne Serum', 'unguu', 65000, 'scarlett_serum2.jpg', 'tea tree water, salicylic acid, liquorice', 1, 50, 'JP01', 'K001', 'abcde'),
('P0005', 'Emina Bright Stuff Loose Powder', 'pinkk', 18000, 'emina_powder1.jpg', 'Emina Bright stuff loose powder adalah bedak tabur untuk memberikan tampilan wajah yang cerah, smooth dan matte. Dilengkapi dengan micro smooth particle dan gliter yang menyatu dengan kulit agar terlihat cerah, natural-glowing dan sehat. Teksturnya ringan', 1, 50, 'JP02', 'K001', 'abcde'),
('P0006', 'Wardah Eyexpert Eyebrow Kit', 'black', 50400, 'wardah_eyeshadow1.jpg', 'Produk Wardah EyeXpert Eyebrow Kit ini merupakan produk terbaru dari seri EyeXpert. Produk ini terdiri dari dua warna eyebrow dan satu concealer, dilengkapi aplikator khusus untuk menghasilkan tampilan alis yang natural.  Memiliki dua pilihan warna yang n', 1, 50, 'JP02', 'K001', 'abcde'),
('P0007', 'Emina Cheeklit Cream Blush', 'pinkk', 25200, 'emina_cheeklit1.jpg', 'Cheek Lit Cream Blush adalah blush on dengan tekstur krim yang sangat mudah untuk diaplikasikan pada wajah !   Diformulasikan untuk memberikan rona alami dan tahan lama pada wajah cantikmu. Dengan teknologi color enhance, menghasilkan warna yang lembut.', 1, 75, 'JP02', 'K001', 'abcde'),
('P0008', 'Nuface Facial Mask Prominent Essence Bird Nest', 'orang', 31200, 'nuface_mask1.jpg', 'Masker wajah dengan cairan yang mengandung bahan baku terkemuka dari hewan eksotis yang telah terbuki manfaatnya bagi kecantikan kulit. Diformulasi dengan Bird Nest Extrac yang berfungsi untuk melembabkan dan mencegah penuaan dini pada kulit wajah. Juga m', 1, 20, 'JP01', 'K001', 'abcde'),
('P0009', 'SK-II Facial Treatment Cleansing Oil 250ml', 'putih', 701500, 'sk2_cleansingoil1.jpg', 'Facial Treatment Cleansing Oil 250ml', 1, 10, 'JP01', 'K001', 'abcde'),
('P0010', 'Whitelab Brightening Night Cream', 'putih', 95000, 'whitelab_acne1.jpg', 'niacinamide + collagen', 1, 5, 'JP01', 'K001', 'abcde'),
('UPPH8', 'test', 'qqqqq', 50000, 'default.png', 'asdasdsa', 0, 50, 'JP01', 'K001', 'abcde'),
('UPZAm', 'adasd', 'asdas', 132132132, 'default.png', 'adsad', 1, 50, 'JP01', 'K001', 'abcde');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` varchar(5) NOT NULL,
  `idKaryawan` varchar(5) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `noHp` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jenisKelamin` varchar(10) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `role` int(11) NOT NULL,
  `uniqueCode` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `idKaryawan`, `nama_user`, `email`, `username`, `password`, `noHp`, `alamat`, `jenisKelamin`, `foto`, `tgl_lahir`, `role`, `uniqueCode`, `status`) VALUES
('aaaaa', 'K001', 'Gisela Yunanda (Emina)', 'giselayunanda@gmail.com', 'giselayunanda', '$2y$10$SuAjVvNWfUX6SYfQNkBHCeqdgul.vJb/CTLkClTsqSAkUYqlmkeRq', '082117841949', 'Purwodadi', 'Perempuan', '', '2021-03-02', 1, 'eminamantap', 1),
('abcde', 'K001', 'Sarah Rahmawati', 'ersarahr@gmail.com', 'ersarahr', '$2y$10$SuAjVvNWfUX6SYfQNkBHCeqdgul.vJb/CTLkClTsqSAkUYqlmkeRq', '082117841949', 'Jalan Helikopter no 10 RT 02 RW 23', 'Perempuan', '', '2021-03-01', 1, 'wardahpunya', 1),
('asdsa', 'K001', 'siapaya', 'siapaya@gmail.com', 'siapaya', '$2y$10$SuAjVvNWfUX6SYfQNkBHCeqdgul.vJb/CTLkClTsqSAkUYqlmkeRq', '089898989898', 'dimana aku', 'Perempuan', '', '2021-04-01', 1, 'akucantikbet', 1),
('US0g1', 'K001', 'siapaaaa', 'siapaya@gmail.com', 'siapapun', '$2y$10$nNYjtqQrNfFri7PwokMTxOPruqQiPluIoptJEyxna9tnbT8eFml62', '0898989892222', 'asdasd', 'Wanita', 'default.jpg', '2021-04-12', 1, '', 1),
('USZDB', 'K001', 'hehehehe', 'hallo@gmail.com', 'halobandung', '$2y$10$8KjBQ5n3FHE2XsYXro62y.Vg78Cy1HHqFUTVJ02otS1QKaiSpdOki', '0811111111', 'asdasd', 'Wanita', 'default.jpg', '2021-04-21', 2, '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD KEY `idPemesanan` (`idPemesanan`),
  ADD KEY `idProduk` (`idProduk`);

--
-- Indexes for table `jenisbayar`
--
ALTER TABLE `jenisbayar`
  ADD PRIMARY KEY (`idJenisBayar`);

--
-- Indexes for table `jenisproduk`
--
ALTER TABLE `jenisproduk`
  ADD PRIMARY KEY (`idJenisProduk`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`idKaryawan`);

--
-- Indexes for table `laba`
--
ALTER TABLE `laba`
  ADD PRIMARY KEY (`idLaba`),
  ADD KEY `idProduk` (`idProduk`),
  ADD KEY `idKaryawan` (`idKaryawan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`idPembayaran`),
  ADD KEY `idJenisBayar` (`idJenisBayar`),
  ADD KEY `idKaryawan` (`idKaryawan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`idPemesanan`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idKaryawan` (`idKaryawan`),
  ADD KEY `idPembayaran` (`idPembayaran`);

--
-- Indexes for table `pendapatansales`
--
ALTER TABLE `pendapatansales`
  ADD PRIMARY KEY (`idPendapatanS`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idProduk` (`idProduk`),
  ADD KEY `idKaryawan` (`idKaryawan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idProduk`),
  ADD KEY `idJenisProduk` (`idJenisProduk`),
  ADD KEY `idKaryawan` (`idKaryawan`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `idKaryawan` (`idKaryawan`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pemesanan`
--
ALTER TABLE `detail_pemesanan`
  ADD CONSTRAINT `detail_pemesanan_ibfk_1` FOREIGN KEY (`idPemesanan`) REFERENCES `pemesanan` (`idPemesanan`),
  ADD CONSTRAINT `detail_pemesanan_ibfk_2` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`idProduk`);

--
-- Constraints for table `laba`
--
ALTER TABLE `laba`
  ADD CONSTRAINT `laba_ibfk_1` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`idProduk`),
  ADD CONSTRAINT `laba_ibfk_2` FOREIGN KEY (`idKaryawan`) REFERENCES `karyawan` (`idKaryawan`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`idJenisBayar`) REFERENCES `jenisbayar` (`idJenisBayar`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`idKaryawan`) REFERENCES `karyawan` (`idKaryawan`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `pemesanan_ibfk_3` FOREIGN KEY (`idKaryawan`) REFERENCES `karyawan` (`idKaryawan`),
  ADD CONSTRAINT `pemesanan_ibfk_4` FOREIGN KEY (`idPembayaran`) REFERENCES `pembayaran` (`idPembayaran`);

--
-- Constraints for table `pendapatansales`
--
ALTER TABLE `pendapatansales`
  ADD CONSTRAINT `pendapatansales_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `pendapatansales_ibfk_2` FOREIGN KEY (`idProduk`) REFERENCES `produk` (`idProduk`),
  ADD CONSTRAINT `pendapatansales_ibfk_3` FOREIGN KEY (`idKaryawan`) REFERENCES `karyawan` (`idKaryawan`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`idJenisProduk`) REFERENCES `jenisproduk` (`idJenisProduk`),
  ADD CONSTRAINT `produk_ibfk_3` FOREIGN KEY (`idKaryawan`) REFERENCES `karyawan` (`idKaryawan`),
  ADD CONSTRAINT `produk_ibfk_4` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idKaryawan`) REFERENCES `karyawan` (`idKaryawan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
