-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Bulan Mei 2024 pada 06.19
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drone_flight_check`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `formName` varchar(255) NOT NULL,
  `formType` varchar(20) NOT NULL,
  `updatedBy` varchar(255) NOT NULL,
  `updatedDate` datetime NOT NULL,
  `formData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `form`
--

INSERT INTO `form` (`id`, `formName`, `formType`, `updatedBy`, `updatedDate`, `formData`) VALUES
(1, 'test1', 'assessment', 'juantdefrin', '2002-04-09 00:00:00', '{\"question1\":{\"question\":\"pertanyaan form 1\",\"type\":\"text\",\"option\":[],\"required\":true},\"question2\":{\"question\":\"pertanyaan form 2\",\"type\":\"checklist\",\"option\":[\"checklist1\",\"checklist2\",\"checklist3\"],\"required\":true},\"question3\":{\"question\":\"pertanyaan form 3\",\"type\":\"multiple\",\"option\":[\"multiple1\",\"multiple2\",\"multiple3\"],\"required\":true},\"question4\":{\"question\":\"pertanyaan form 4\",\"type\":\"longtext\",\"option\":[],\"required\":true}}'),
(2, 'test2', 'pre', 'juantdefrin', '2002-04-09 00:00:00', '{\"question1\":{\"question\":\"pertanyaan form 1\",\"type\":\"text\",\"option\":[],\"required\":true},\"question2\":{\"question\":\"pertanyaan form 2\",\"type\":\"checklist\",\"option\":[\"checklist1\",\"checklist2\",\"checklist3\"],\"required\":true},\"question3\":{\"question\":\"pertanyaan form 3\",\"type\":\"multiple\",\"option\":[\"multiple1\",\"multiple2\",\"multiple3\"],\"required\":true},\"question4\":{\"question\":\"pertanyaan form 4\",\"type\":\"longtext\",\"option\":[],\"required\":true}}'),
(3, 'test3', 'post', 'juantdefrin', '2002-04-09 00:00:00', '{\"question1\":{\"question\":\"pertanyaan form 1\",\"type\":\"text\",\"option\":[],\"required\":true},\"question2\":{\"question\":\"pertanyaan form 2\",\"type\":\"checklist\",\"option\":[\"checklist1\",\"checklist2\",\"checklist3\"],\"required\":true},\"question3\":{\"question\":\"pertanyaan form 3\",\"type\":\"multiple\",\"option\":[\"multiple1\",\"multiple2\",\"multiple3\"],\"required\":true},\"question4\":{\"question\":\"pertanyaan form 4\",\"type\":\"longtext\",\"option\":[],\"required\":true}}'),
(27, 'New Form Assessment Example', 'assessment', 'juantdefrin', '2024-05-08 22:43:15', '{\"question1\":{\"question\":\"Multiple Example\",\"type\":\"multiple\",\"option\":[\"multiple1\",\"multiple2\",\"multiple3\"],\"required\":true},\"question2\":{\"question\":\"Checklist Example\",\"type\":\"checklist\",\"option\":[\"checklist1\",\"checklist2\",\"checklist3\"],\"required\":false},\"question3\":{\"question\":\"Dropdown Example\",\"type\":\"dropdown\",\"option\":[\"dropdown1\",\"dropdown2\",\"dropdown3\"],\"required\":true},\"question4\":{\"question\":\"test text\",\"type\":\"text\",\"option\":[],\"required\":true}}'),
(32, 'New Form Post', 'post', 'juantdefrin', '2024-05-08 19:39:29', '{\"question1\":{\"question\":\"Is mission success?\",\"type\":\"dropdown\",\"option\":[\"Yes\",\"No\"],\"required\":true}}'),
(34, '', 'assessment', 'juantdefrin', '2024-05-15 11:16:14', '{\"question1\":{\"question\":\"\",\"type\":\"dropdown\",\"option\":[\"Right Engine\",\"test test test\"],\"required\":true}}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `submission`
--

CREATE TABLE `submission` (
  `id` int(11) NOT NULL,
  `submissionName` varchar(255) NOT NULL,
  `templateId` int(11) NOT NULL,
  `submittedBy` varchar(255) NOT NULL,
  `submittedDate` datetime NOT NULL,
  `formData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`formData`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `submission`
--

INSERT INTO `submission` (`id`, `submissionName`, `templateId`, `submittedBy`, `submittedDate`, `formData`) VALUES
(1, 'Keliling Binus', 1, 'juantdefrin', '2024-04-09 00:00:00', '[{\"type\":\"assessment\",\"answer\":[{\"questionName\":\"apa cuaca hari ini?\",\"answer\":\"cerah\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"apakah antena sudah terpasang dengan baik?\",\"answer\":\"iya\",\"dataChanged\":\"2024/05/13 11:02:02\"}]},{\"type\":\"pre\",\"answer\":[{\"flightNum\":1,\"data\":[{\"questionName\":\"apakah kamera sudah dibersihkan?\",\"answer\":\"belum\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"apakah kamera sudah di setting?\",\"answer\":\"belum\",\"dataChanged\":\"2024/05/13 11:02:02\"}]},{\"flightNum\":2,\"data\":[{\"questionName\":\"apakah kamera sudah dibersihkan?\",\"answer\":\"sudah\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"apakah kamera sudah di setting?\",\"answer\":\"sudah\",\"dataChanged\":\"2024/05/13 11:02:02\"}]}]},{\"type\":\"post\",\"answer\":[{\"flightNum\":1,\"data\":[{\"questionName\":\"waktu landing\",\"answer\":\"12.00\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"baterai pada drone\",\"answer\":\"49%\",\"dataChanged\":\"2024/05/13 11:02:02\"}]},{\"flightNum\":2,\"data\":[{\"questionName\":\"waktu landing\",\"answer\":\"14.00\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"baterai pada drone\",\"answer\":\"22%\",\"dataChanged\":\"2024/05/13 11:02:02\"}]}]}]'),
(2, 'Keliling Jakarta', 1, 'juantdefrin', '0000-00-00 00:00:00', '[{\"type\":\"assessment\",\"answer\":[{\"questionName\":\"apa cuaca hari ini?\",\"answer\":\"cerah\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"apakah antena sudah terpasang dengan baik?\",\"answer\":\"iya\",\"dataChanged\":\"2024/05/13 11:02:02\"}]},{\"type\":\"pre\",\"answer\":[{\"flightNum\":1,\"data\":[{\"questionName\":\"apakah kamera sudah dibersihkan?\",\"answer\":\"belum\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"apakah kamera sudah di setting?\",\"answer\":\"belum\",\"dataChanged\":\"2024/05/13 11:02:02\"}]},{\"flightNum\":2,\"data\":[{\"questionName\":\"apakah kamera sudah dibersihkan?\",\"answer\":\"sudah\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"apakah kamera sudah di setting?\",\"answer\":\"sudah\",\"dataChanged\":\"2024/05/13 11:02:02\"}]}]},{\"type\":\"post\",\"answer\":[{\"flightNum\":1,\"data\":[{\"questionName\":\"waktu landing\",\"answer\":\"12.00\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"baterai pada drone\",\"answer\":\"49%\",\"dataChanged\":\"2024/05/13 11:02:02\"}]},{\"flightNum\":2,\"data\":[{\"questionName\":\"waktu landing\",\"answer\":\"14.00\",\"dataChanged\":\"2024/05/13 11:02:02\"},{\"questionName\":\"baterai pada drone\",\"answer\":\"22%\",\"dataChanged\":\"2024/05/13 11:02:02\"}]}]}]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `template`
--

CREATE TABLE `template` (
  `id` int(11) NOT NULL,
  `templateName` varchar(255) NOT NULL,
  `assessmentId` int(11) NOT NULL,
  `preId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `updatedBy` varchar(255) NOT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `template`
--

INSERT INTO `template` (`id`, `templateName`, `assessmentId`, `preId`, `postId`, `updatedBy`, `updatedDate`) VALUES
(1, 'template_test_1', 1, 2, 3, 'juantdefrin', '2024-04-25 14:23:42'),
(2, 'tes template 2', 1, 2, 32, 'juantdefrin', '2024-05-10 23:39:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `email`, `password`) VALUES
('juantdefrin', 'jtdefrin33@gmail.com', 'bc547750b92797f955b36112cc9bdd5cddf7d0862151d03a167ada8995aa24a9ad24610b36a68bc02da24141ee51670aea13ed6469099a4453f335cb239db5da');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `form`
--
ALTER TABLE `form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `submission`
--
ALTER TABLE `submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
