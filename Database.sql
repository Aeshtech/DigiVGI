-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2021 at 09:51 AM
-- Server version: 8.0.25
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digivgi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `gender` varchar(12) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `course` varchar(50) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'admin',
  `isactive` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `phone`, `gender`, `email`, `course`, `branch`, `password`, `photo`, `user_type`, `isactive`) VALUES
(1, 'Admin', '7011716560', 'Male', 'admin@gmail.com', 'B.Tech', 'CSE', '$2y$10$oYcCVOoD4vcQuyB46YjjBOkFV5bZdr91eBjBkDlUP1fnZZSQ5nz8S', 'uploads_admin/1637435917.jpg', 'admin', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `assignfaculty`
--

CREATE TABLE `assignfaculty` (
  `id` int NOT NULL,
  `course` varchar(20) NOT NULL,
  `branch` varchar(20) NOT NULL,
  `semester` int NOT NULL,
  `section` varchar(10) NOT NULL,
  `facultyname` varchar(50) NOT NULL,
  `facultyid` varchar(50) NOT NULL,
  `subjectname` varchar(50) NOT NULL,
  `subjectcode` varchar(20) NOT NULL,
  `cpermit` varchar(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `assignfaculty`
--

INSERT INTO `assignfaculty` (`id`, `course`, `branch`, `semester`, `section`, `facultyname`, `facultyid`, `subjectname`, `subjectcode`, `cpermit`, `date`) VALUES
(1, 'B.Tech', 'CSE', 7, 'A', 'krishna', 'krishna@gmail.com', 'Artificial Intelligence', 'KCS-701', 'Yes', '2021-11-21 12:41:50'),
(2, 'B.Tech', 'CSE', 7, 'A', 'krishna', 'krishna@gmail.com', 'Mobile computing', 'KCS-702', 'Yes', '2021-11-21 12:43:05'),
(3, 'B.Tech', 'CSE', 7, 'A', 'krishna', 'krishna@gmail.com', 'Rural area Development', 'KCS-703', 'Yes', '2021-11-21 12:44:00'),
(4, 'B.Tech', 'CSE', 7, 'A', 'krishna', 'krishna@gmail.com', 'Renewal Energy Resources', 'KCS-704', 'Yes', '2021-11-21 12:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int NOT NULL,
  `status` varchar(20) NOT NULL,
  `roll_no` varchar(20) NOT NULL,
  `student_name` varchar(30) NOT NULL,
  `date` varchar(20) NOT NULL,
  `modified_date` varchar(20) DEFAULT NULL,
  `subject_name` varchar(30) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `course` varchar(20) NOT NULL,
  `branch` varchar(30) NOT NULL,
  `semester` int NOT NULL,
  `section` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `status`, `roll_no`, `student_name`, `date`, `modified_date`, `subject_name`, `subject_code`, `course`, `branch`, `semester`, `section`) VALUES
(1, 'Present', '1809610015', 'Ashish', '2021-11-11', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(2, 'Present', '1809610016', 'Anjali', '2021-11-11', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(3, 'Present', '1809610017', 'Shraddhanjali', '2021-11-11', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(4, 'Present', '1809610018', 'Rupal', '2021-11-11', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(5, 'Absent', '1809610019', 'Ravishankar', '2021-11-11', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(6, 'Present', '1809610020', 'Ramanand', '2021-11-11', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(7, 'Absent', '1809610021', 'Tanu', '2021-11-11', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(8, 'Present', '1809610015', 'Ashish', '2021-11-21', '21-11-21', 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(9, 'Present', '1809610016', 'Anjali', '2021-11-21', '21-11-21', 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(10, 'Present', '1809610017', 'Shraddhanjali', '2021-11-21', '21-11-21', 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(11, 'Present', '1809610018', 'Rupal', '2021-11-21', '21-11-21', 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(12, 'Absent', '1809610019', 'Ravishankar', '2021-11-21', '21-11-21', 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(13, 'Present', '1809610020', 'Ramanand', '2021-11-21', '21-11-21', 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(14, 'Present', '1809610021', 'Tanu', '2021-11-21', '21-11-21', 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(15, 'Present', '1809610015', 'Ashish', '2021-11-12', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(16, 'Present', '1809610016', 'Anjali', '2021-11-12', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(17, 'Absent', '1809610017', 'Shraddhanjali', '2021-11-12', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(18, 'Present', '1809610018', 'Rupal', '2021-11-12', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(19, 'Present', '1809610019', 'Ravishankar', '2021-11-12', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(20, 'Present', '1809610020', 'Ramanand', '2021-11-12', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(21, 'Present', '1809610021', 'Tanu', '2021-11-12', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(22, 'Present', '1809610015', 'Ashish', '2021-11-13', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(23, 'Present', '1809610016', 'Anjali', '2021-11-13', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(24, 'Present', '1809610017', 'Shraddhanjali', '2021-11-13', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(25, 'Absent', '1809610018', 'Rupal', '2021-11-13', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(26, 'Present', '1809610019', 'Ravishankar', '2021-11-13', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(27, 'Absent', '1809610020', 'Ramanand', '2021-11-13', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(28, 'Present', '1809610021', 'Tanu', '2021-11-13', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(29, 'Present', '1809610015', 'Ashish', '2021-11-14', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(30, 'Present', '1809610016', 'Anjali', '2021-11-14', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(31, 'Present', '1809610017', 'Shraddhanjali', '2021-11-14', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(32, 'Present', '1809610018', 'Rupal', '2021-11-14', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(33, 'Present', '1809610019', 'Ravishankar', '2021-11-14', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(34, 'Present', '1809610020', 'Ramanand', '2021-11-14', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(35, 'Present', '1809610021', 'Tanu', '2021-11-14', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(36, 'Present', '1809610015', 'Ashish', '2021-11-15', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(37, 'Absent', '1809610016', 'Anjali', '2021-11-15', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(38, 'Present', '1809610017', 'Shraddhanjali', '2021-11-15', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(39, 'Present', '1809610018', 'Rupal', '2021-11-15', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(40, 'Present', '1809610019', 'Ravishankar', '2021-11-15', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(41, 'Present', '1809610020', 'Ramanand', '2021-11-15', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(42, 'Present', '1809610021', 'Tanu', '2021-11-15', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(43, 'Present', '1809610015', 'Ashish', '2021-11-17', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(44, 'Present', '1809610016', 'Anjali', '2021-11-17', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(45, 'Present', '1809610017', 'Shraddhanjali', '2021-11-17', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(46, 'Present', '1809610018', 'Rupal', '2021-11-17', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(47, 'Present', '1809610019', 'Ravishankar', '2021-11-17', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(48, 'Absent', '1809610020', 'Ramanand', '2021-11-17', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(49, 'Absent', '1809610021', 'Tanu', '2021-11-17', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(50, 'Present', '1809610015', 'Ashish', '2021-11-19', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(51, 'Present', '1809610016', 'Anjali', '2021-11-19', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(52, 'Absent', '1809610017', 'Shraddhanjali', '2021-11-19', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(53, 'Absent', '1809610018', 'Rupal', '2021-11-19', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(54, 'Present', '1809610019', 'Ravishankar', '2021-11-19', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(55, 'Present', '1809610020', 'Ramanand', '2021-11-19', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(56, 'Present', '1809610021', 'Tanu', '2021-11-19', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(57, 'Absent', '1809610015', 'Ashish', '2021-11-20', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(58, 'Absent', '1809610016', 'Anjali', '2021-11-20', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(59, 'Absent', '1809610017', 'Shraddhanjali', '2021-11-20', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(60, 'Absent', '1809610018', 'Rupal', '2021-11-20', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(61, 'Absent', '1809610019', 'Ravishankar', '2021-11-20', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(62, 'Absent', '1809610020', 'Ramanand', '2021-11-20', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A'),
(63, 'Absent', '1809610021', 'Tanu', '2021-11-20', NULL, 'Artificial Intelligence', 'KCS-701', 'B.Tech', 'CSE', 7, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `director`
--

CREATE TABLE `director` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `isactive` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `director`
--

INSERT INTO `director` (`id`, `name`, `email`, `phone`, `photo`, `password`, `user_type`, `isactive`) VALUES
(1, 'Director', 'director@gmail.com', '7011716560', 'dir_uploads/1637435576.jpg', '$2y$10$oYcCVOoD4vcQuyB46YjjBOkFV5bZdr91eBjBkDlUP1fnZZSQ5nz8S', 'director', '');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `gender` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'faculty',
  `isactive` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `phone`, `gender`, `email`, `password`, `photo`, `user_type`, `isactive`) VALUES
(1, 'Krishna', '7011716560', 'Male', 'krishna@gmail.com', '$2y$10$oYcCVOoD4vcQuyB46YjjBOkFV5bZdr91eBjBkDlUP1fnZZSQ5nz8S', 'uploads_faculty/1637435778.jpg', 'faculty', '');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_temp`
--

CREATE TABLE `password_reset_temp` (
  `id` int NOT NULL,
  `email` varchar(30) NOT NULL,
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `expDate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int NOT NULL,
  `registration` varchar(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `course` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `branch` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `semester` int NOT NULL,
  `section` varchar(1) NOT NULL,
  `email` varchar(30) NOT NULL,
  `parentEmail` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'student',
  `isactive` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `registration`, `name`, `phone`, `course`, `branch`, `semester`, `section`, `email`, `parentEmail`, `gender`, `password`, `photo`, `user_type`, `isactive`) VALUES
(1, '1809610015', 'Ashish', '7011716560', 'B.Tech', 'CSE', 7, 'A', 'dev.aeshtech@gmail.com', 'dev.aeshtech@gmail.com', 'male', '$2y$10$/9lHH43Trzw6NptW825kQegnNysW3pCTNn1ATwwomcYYhihZrINPO', 'uploads2/1637437536.png', 'student', ''),
(2, '1809610016', 'Anjali', '7011716561', 'B.Tech', 'CSE', 7, 'A', 'anjali@gmail.com', 'anjali@gmail.com', 'female', '$2y$10$JhFGIYmRhOCy9.nItRnOI.yZs8hA0BSr8d3Sthr4szcUpWHHxxBoC', 'uploads2/1637437363.jpg', 'student', ''),
(3, '1809610017', 'Shraddhanjali', '7011716562', 'B.Tech', 'CSE', 7, 'A', 'shraddhanjali@gmail.com', 'shraddhanjali@gmail.com', 'female', '$2y$10$ADhlVAHazSpUZVmyM7jk2up0ahijAMz8CGggXcpdyENJ2gi0NTbai', 'uploads2/1637479115.jpg', 'student', ''),
(4, '1809610018', 'Rupal', '7011716563', 'B.Tech', 'CSE', 7, 'A', 'rupal@gmail.com', 'rupal@gmail.com', 'female', '$2y$10$pR9AEhj5sT0u/5XEWe8s4edzWA5ZZhR41UKzCCeGCH.USpLKWYxDK', 'uploads2/1637479185.jpg', 'student', ''),
(5, '1809610019', 'Ravishankar', '7011716564', 'B.Tech', 'CSE', 7, 'A', 'ravishankar@gmail.com', 'ravishankar@gmail.com', 'male', '$2y$10$X2.ZLT7xr6KssGWieGFCOuoe2xc.shl1P5CXL0P6Nj3oWy7CNII62', 'uploads2/1637479234.jpg', 'student', ''),
(6, '1809610020', 'Ramanand', '7011716565', 'B.Tech', 'CSE', 7, 'A', 'ramanand@gmail.com', 'ramanand@gmail.com', 'male', '$2y$10$quLZAuqtQGFG.ESIdgMB4.6MIPL79BYhL0809FfPhlYCaeNbf75kO', 'uploads2/1637479359.jpg', 'student', ''),
(8, '1809610021', 'Tanu', '7011716566', 'B.Tech', 'CSE', 7, 'A', 'tanu@gmail.com', 'tanu@gmail.com', 'female', '$2y$10$Eqtox/YIRcUmeLfE71xG6e2ezphH1zFHGjV9.FVNpcxW4f2FYP6OG', 'uploads2/1637479517.jpg', 'student', '');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int NOT NULL,
  `course` varchar(20) NOT NULL,
  `semester` int NOT NULL,
  `section` varchar(20) NOT NULL,
  `subjectname` varchar(100) NOT NULL,
  `subjectcode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignfaculty`
--
ALTER TABLE `assignfaculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_temp`
--
ALTER TABLE `password_reset_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `registration` (`registration`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignfaculty`
--
ALTER TABLE `assignfaculty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `director`
--
ALTER TABLE `director`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_reset_temp`
--
ALTER TABLE `password_reset_temp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
