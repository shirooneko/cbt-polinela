-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Jan 2024 pada 16.20
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbt-polinela`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_akademik`
--

CREATE TABLE `tb_akademik` (
  `id_akademik` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` longtext NOT NULL,
  `foto` longtext NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('OFF','ON') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_akademik`
--

INSERT INTO `tb_akademik` (`id_akademik`, `nama`, `username`, `password`, `foto`, `role`, `status`) VALUES
(2, 'akademik', 'akademik@polinela.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '1702776888_20d445469a497d0abdac.jpg', 'akademik', 'OFF');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_dosen`
--

CREATE TABLE `tb_dosen` (
  `id_dosen` int(11) NOT NULL,
  `nip` longtext DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `email` longtext DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `foto` longtext DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('ON','OFF') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_dosen`
--

INSERT INTO `tb_dosen` (`id_dosen`, `nip`, `nama`, `email`, `password`, `foto`, `role`, `status`) VALUES
(29, '29', 'azizi syafa asadel', 'azizi@jkt.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '29.jpg', 'dosen', 'OFF'),
(39, '312312', 'Fiony Alveria Tantri', 'fiony@jkt.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '312312.jpg', 'dosen', 'OFF');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_exam`
--

CREATE TABLE `tb_exam` (
  `id_exam` int(11) NOT NULL,
  `nama_exam` varchar(50) NOT NULL,
  `id_matkul` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_sesi` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(10) NOT NULL,
  `tgl_exam` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_exam`
--

INSERT INTO `tb_exam` (`id_exam`, `nama_exam`, `id_matkul`, `id_kelas`, `id_sesi`, `start_time`, `end_time`, `status`, `tgl_exam`) VALUES
(36, 'Accusantium qui sit', 18, 7, 14, '21:05:00', '04:01:00', 'expired', '1983-12-01'),
(37, 'Qui non non dignissi', 18, 7, 13, '05:19:00', '09:53:00', 'expired', '2024-01-08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_exam_results`
--

CREATE TABLE `tb_exam_results` (
  `id` int(11) NOT NULL,
  `id_mahasiswa` int(11) DEFAULT NULL,
  `id_exam` int(11) DEFAULT NULL,
  `total_score` int(11) DEFAULT NULL,
  `answered_questions` varchar(255) DEFAULT NULL,
  `correct_answers` varchar(255) DEFAULT NULL,
  `incorrect_answers` varchar(255) DEFAULT NULL,
  `unanswered_questions` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `student_answers` longtext NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_exam_results`
--

INSERT INTO `tb_exam_results` (`id`, `id_mahasiswa`, `id_exam`, `total_score`, `answered_questions`, `correct_answers`, `incorrect_answers`, `unanswered_questions`, `start_time`, `end_time`, `student_answers`, `status`) VALUES
(87, 3453, 37, 10, '2', '2', '0', '18', '0000-00-00 00:00:00', '2024-01-08 05:47:27', '[{\"id_question\":\"180\",\"selected_answer\":\"A\"},{\"id_question\":\"186\",\"selected_answer\":\"A\"}]', 'submitted');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(2, 'Ekonomi dan Bisnis'),
(4, 'Teknik Informatikaa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `semester` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `nama`, `semester`, `id_prodi`) VALUES
(6, 'MI 5A', 5, 1),
(7, 'MI 5B', 5, 1),
(8, 'MI 5C', 5, 1),
(9, 'PW 5B', 5, 3),
(10, 'AGP 5A', 5, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mahasiswa`
--

CREATE TABLE `tb_mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `npm` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `sex` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `angkatan` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('OFF','ON') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_mahasiswa`
--

INSERT INTO `tb_mahasiswa` (`id_mahasiswa`, `foto`, `npm`, `nama`, `sex`, `tempat_lahir`, `tgl_lahir`, `angkatan`, `id_jurusan`, `id_prodi`, `email`, `id_kelas`, `password`, `role`, `status`) VALUES
(3453, '1703261123_24897cbc60cfece39cc1.jpg', '21753058', 'Muhammad Apriyansyahh', '', 'Suban', '2003-04-27', 2021, 2, 1, '21753058@student.com', 7, '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'OFF'),
(3454, '1704369313_d2747a31d5c67987d7db.png', '21753072', 'Yoga Fradana', 'Laki-laki', 'Ntah Brata', '2003-04-28', 2021, 2, 1, '21753072@student.com', 7, '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'OFF'),
(3455, 'profile.png', '21753065', 'Kadek Indri Wedayani', 'Perempuan', 'Way Kambas', '2003-04-29', 2021, 2, 1, '21753062@student.com', 7, '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'OFF');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_matkul`
--

CREATE TABLE `tb_matkul` (
  `id_matkul` int(11) NOT NULL,
  `kode_matkul` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `thn_ajaran` varchar(50) NOT NULL,
  `id_dosen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_matkul`
--

INSERT INTO `tb_matkul` (`id_matkul`, `kode_matkul`, `nama`, `semester`, `thn_ajaran`, `id_dosen`) VALUES
(18, 'PMI 1511', 'Keamanan Sistem Informasi Manajemen Informatika 5B', 'Ganjil', '2023/2024', 29),
(19, 'PMS', 'Filsafat dan ketenangan', 'Ganjil', '2023/2024', 39);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_prodi`
--

CREATE TABLE `tb_prodi` (
  `id_prodi` int(11) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_prodi`
--

INSERT INTO `tb_prodi` (`id_prodi`, `nama_prodi`, `id_jurusan`) VALUES
(1, 'D3 Manajemen Informatika', 4),
(3, 'D3 Perjalanan Wisata', 2),
(4, 'D4 Agribisnis Pangan', 2),
(5, 'D4 Akuntansi Bisnis Digital', 2),
(6, 'D3 Hortkultura', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_question`
--

CREATE TABLE `tb_question` (
  `id_question` int(11) NOT NULL,
  `id_exam` int(11) NOT NULL,
  `soal` varchar(255) NOT NULL,
  `correct_answer` varchar(100) NOT NULL,
  `nilai` float NOT NULL,
  `pilihan` longtext NOT NULL,
  `nomor_soal` int(11) NOT NULL,
  `gambar_soal` longtext DEFAULT NULL,
  `gambar_pilihan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_question`
--

INSERT INTO `tb_question` (`id_question`, `id_exam`, `soal`, `correct_answer`, `nilai`, `pilihan`, `nomor_soal`, `gambar_soal`, `gambar_pilihan`) VALUES
(171, 37, 'Itaque delectus lor', 'D', 5, '{\"A\":\"Pariatur Ea deserun\",\"B\":\"Mollit ducimus haru\",\"C\":\"Velit officia except\",\"D\":\"Pariatur Et delenit\"}', 1, NULL, NULL),
(172, 37, 'What is the primary goal of information security?', 'A', 5, '{\"A\":\"To protect information from unauthorized access\",\"B\":\"To make information readily available\",\"C\":\"To slow down information access\",\"D\":\"To encrypt all information\"}', 2, NULL, NULL),
(173, 37, 'What does CIA stand for in information security?', 'A', 5, '{\"A\":\"Confidentiality, Integrity, and Availability\",\"B\":\"Computer Information Agency\",\"C\":\"Classified Information Access\",\"D\":\"Common Internet Application\"}', 3, NULL, NULL),
(174, 37, 'What is the first step in the risk management process?', 'C', 5, '{\"A\":\"Risk assessment\",\"B\":\"Risk mitigation\",\"C\":\"Risk identification\",\"D\":\"Risk acceptance\"}', 4, NULL, NULL),
(175, 37, 'Which of the following is an example of a security vulnerability?', 'A', 5, '{\"A\":\"Weak password policy\",\"B\":\"Regular software updates\",\"C\":\"Firewall configuration\",\"D\":\"Data backup\"}', 5, NULL, NULL),
(176, 37, 'What is the purpose of encryption in information security?', 'A', 5, '{\"A\":\"To protect data from unauthorized access\",\"B\":\"To slow down data access\",\"C\":\"To make data easily readable\",\"D\":\"To share data with anyone\"}', 6, NULL, NULL),
(177, 37, 'What is a firewall in the context of information security?', 'A', 5, '{\"A\":\"A network security device\",\"B\":\"An antivirus software\",\"C\":\"A hardware component\",\"D\":\"A backup system\"}', 7, NULL, NULL),
(178, 37, 'What is social engineering in the context of security?', 'A', 5, '{\"A\":\"Manipulating individuals to divulge confidential information\",\"B\":\"Creating strong passwords\",\"C\":\"Installing antivirus software\",\"D\":\"Encrypting data\"}', 8, NULL, NULL),
(179, 37, 'What is the purpose of access control in information security?', 'A', 5, '{\"A\":\"To restrict unauthorized access to data and resources\",\"B\":\"To make data easily accessible\",\"C\":\"To slow down data access\",\"D\":\"To encrypt all data\"}', 9, NULL, NULL),
(180, 37, 'What is a data breach?', 'A', 5, '{\"A\":\"Unauthorized access, disclosure, or acquisition of sensitive data\",\"B\":\"Regular data backup\",\"C\":\"Data encryption\",\"D\":\"Data storage\"}', 10, NULL, NULL),
(181, 37, 'What is the primary role of an information security manager?', 'A', 5, '{\"A\":\"To oversee and manage an organization\'s information security program\",\"B\":\"To develop software applications\",\"C\":\"To provide customer support\",\"D\":\"To design hardware components\"}', 11, NULL, NULL),
(182, 37, 'What is the purpose of a security policy?', 'A', 5, '{\"A\":\"To provide guidelines and rules for protecting an organization\'s information\",\"B\":\"To create complex passwords\",\"C\":\"To install antivirus software\",\"D\":\"To encrypt data\"}', 12, NULL, NULL),
(183, 37, 'What is the concept of least privilege in access control?', 'A', 5, '{\"A\":\"Giving individuals the minimum level of access necessary to perform their job functions\",\"B\":\"Giving individuals unlimited access\",\"C\":\"Restricting all access\",\"D\":\"Providing full access to everyone\"}', 13, NULL, NULL),
(184, 37, 'What is a security audit?', 'A', 5, '{\"A\":\"A systematic evaluation of an organization\'s information security policies and practices\",\"B\":\"Regular data backups\",\"C\":\"Data encryption\",\"D\":\"Network monitoring\"}', 14, NULL, NULL),
(185, 37, 'What is the purpose of a security incident response plan?', 'A', 5, '{\"A\":\"To outline the steps to take in the event of a security incident\",\"B\":\"To create strong passwords\",\"C\":\"To install antivirus software\",\"D\":\"To encrypt data\"}', 15, NULL, NULL),
(186, 37, 'What is the difference between a virus and malware?', 'A', 5, '{\"A\":\"Malware is a broader category that includes viruses\",\"B\":\"Malware is a hardware component\",\"C\":\" Viruses are a type of malware\",\"D\":\"5Viruses are software programs\"}', 16, NULL, NULL),
(187, 37, 'What is two-factor authentication (2FA)?', 'A', 5, '{\"A\":\"A security process in which a user provides two different authentication factors to verify their identity\",\"B\":\"Using the same password for multiple accounts\",\"C\":\"Using a single authentication factor\",\"D\":\"Using biometric authentication only\"}', 17, NULL, NULL),
(188, 37, 'What is the purpose of a security awareness program?', 'A', 5, '{\"A\":\"To educate employees and users about security best practices\",\"B\":\"To create complex passwords\",\"C\":\"To install antivirus software\",\"D\":\"To encrypt data\"}', 18, NULL, NULL),
(189, 37, 'What is encryption key management?', 'A', 5, '{\"A\":\"The process of generating, distributing, storing, and revoking encryption keys\",\"B\":\"The process of updating antivirus software\",\"C\":\"The process of monitoring network traffic\",\"D\":\"The process of data backup\"}', 19, NULL, NULL),
(190, 37, 'What is a security token?', 'A', 5, '{\"A\":\"A physical device or mobile app used in two-factor authentication\",\"B\":\"An email address and password\",\"C\":\"An antivirus software\",\"D\":\"An encryption key\"}', 20, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sesi`
--

CREATE TABLE `tb_sesi` (
  `id_sesi` int(11) NOT NULL,
  `nama_sesi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sesi`
--

INSERT INTO `tb_sesi` (`id_sesi`, `nama_sesi`) VALUES
(12, 'QUIZ'),
(13, 'UTS'),
(14, 'UAS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_thnajaran`
--

CREATE TABLE `tb_thnajaran` (
  `id_thnAjaran` int(11) NOT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `status` enum('aktif','nonaktif','-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_thnajaran`
--

INSERT INTO `tb_thnajaran` (`id_thnAjaran`, `tahun_ajaran`, `status`) VALUES
(1, '2023/2024', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('ON','OFF') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `foto`, `nama`, `username`, `password`, `role`, `status`) VALUES
(7, '1703253560_f56256ed502d251ab572.png', 'administrator', 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'administrator', 'ON');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_akademik`
--
ALTER TABLE `tb_akademik`
  ADD PRIMARY KEY (`id_akademik`);

--
-- Indeks untuk tabel `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indeks untuk tabel `tb_exam`
--
ALTER TABLE `tb_exam`
  ADD PRIMARY KEY (`id_exam`);

--
-- Indeks untuk tabel `tb_exam_results`
--
ALTER TABLE `tb_exam_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_exam` (`id_exam`);

--
-- Indeks untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_prodi` (`id_prodi`);

--
-- Indeks untuk tabel `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD KEY `id_prodi` (`id_prodi`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `tb_matkul`
--
ALTER TABLE `tb_matkul`
  ADD PRIMARY KEY (`id_matkul`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- Indeks untuk tabel `tb_prodi`
--
ALTER TABLE `tb_prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `tb_question`
--
ALTER TABLE `tb_question`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_exam` (`id_exam`);

--
-- Indeks untuk tabel `tb_sesi`
--
ALTER TABLE `tb_sesi`
  ADD PRIMARY KEY (`id_sesi`);

--
-- Indeks untuk tabel `tb_thnajaran`
--
ALTER TABLE `tb_thnajaran`
  ADD PRIMARY KEY (`id_thnAjaran`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_akademik`
--
ALTER TABLE `tb_akademik`
  MODIFY `id_akademik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_dosen`
--
ALTER TABLE `tb_dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tb_exam`
--
ALTER TABLE `tb_exam`
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `tb_exam_results`
--
ALTER TABLE `tb_exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3465;

--
-- AUTO_INCREMENT untuk tabel `tb_matkul`
--
ALTER TABLE `tb_matkul`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_prodi`
--
ALTER TABLE `tb_prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_question`
--
ALTER TABLE `tb_question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT untuk tabel `tb_sesi`
--
ALTER TABLE `tb_sesi`
  MODIFY `id_sesi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_thnajaran`
--
ALTER TABLE `tb_thnajaran`
  MODIFY `id_thnAjaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_exam_results`
--
ALTER TABLE `tb_exam_results`
  ADD CONSTRAINT `tb_exam_results_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `tb_mahasiswa` (`id_mahasiswa`),
  ADD CONSTRAINT `tb_exam_results_ibfk_2` FOREIGN KEY (`id_exam`) REFERENCES `tb_exam` (`id_exam`);

--
-- Ketidakleluasaan untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `tb_kelas_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `tb_prodi` (`id_prodi`);

--
-- Ketidakleluasaan untuk tabel `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD CONSTRAINT `tb_mahasiswa_ibfk_1` FOREIGN KEY (`id_prodi`) REFERENCES `tb_prodi` (`id_prodi`),
  ADD CONSTRAINT `tb_mahasiswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`);

--
-- Ketidakleluasaan untuk tabel `tb_matkul`
--
ALTER TABLE `tb_matkul`
  ADD CONSTRAINT `tb_matkul_ibfk_1` FOREIGN KEY (`id_dosen`) REFERENCES `tb_dosen` (`id_dosen`);

--
-- Ketidakleluasaan untuk tabel `tb_prodi`
--
ALTER TABLE `tb_prodi`
  ADD CONSTRAINT `tb_prodi_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id_jurusan`);

--
-- Ketidakleluasaan untuk tabel `tb_question`
--
ALTER TABLE `tb_question`
  ADD CONSTRAINT `tb_question_ibfk_1` FOREIGN KEY (`id_exam`) REFERENCES `tb_exam` (`id_exam`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
