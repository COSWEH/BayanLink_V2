-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 10:01 PM
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
-- Database: `bayanlink_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_about_mission`
--

CREATE TABLE `tbl_about_mission` (
  `about_mission_id` int(22) NOT NULL,
  `about_us` text NOT NULL,
  `our_mission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_about_mission`
--

INSERT INTO `tbl_about_mission` (`about_mission_id`, `about_us`, `our_mission`) VALUES
(1, 'BayanLink is a SaaS platform that connects communities and boosts local engagement. We simplify communication between residents, businesses, and leaders with easy-to-use tools, keeping everyone informed and involved. Join us in building a more connected community.', 'At BayanLink, our mission is to strengthen community communication and connections. We offer innovative solutions that enable seamless interaction among residents and stakeholders, aiming to enhance civic engagement and support community growth. We\'re committed to making every neighborhood a connected, thriving place where everyone has a voice.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `contact_id` int(22) NOT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_location` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`contact_id`, `contact_number`, `contact_email`, `contact_location`) VALUES
(17, '+639182609219', 'bayanlink.connects@gmail.com', 'Brgy. Malapit, San Isidro, Nueva Ecija'),
(18, '+639286690296', 'sanisidro@gmail.com', 'Brgy. Poblacion, San Isidro, Nueva Ecija'),
(23, '+639875715334', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faqs`
--

CREATE TABLE `tbl_faqs` (
  `faq_id` int(22) NOT NULL,
  `faq_question` text NOT NULL,
  `faq_answer` text NOT NULL,
  `faq_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_faqs`
--

INSERT INTO `tbl_faqs` (`faq_id`, `faq_question`, `faq_answer`, `faq_created_at`) VALUES
(1, 'Who will verify users that will be allowed with certain features within the app?', 'The verification of users for accessing certain features within the app will be managed by the system administrators. They will review user requests and validate their eligibility based on predefined criteria. This ensures that only authorized users gain access to specialized features.', '2024-08-26 09:59:09'),
(2, 'Who will check and accept the requests made for information gathering?', 'Requests for information gathering will be reviewed and accepted by designated information officers or administrators. They will assess the validity and relevance of each request before granting access to the requested information.', '2024-08-26 10:01:09'),
(3, 'Who will limit access to certain information?', 'Access to certain sensitive or restricted information will be managed by system administrators and security officers. They will configure access controls based on user roles, permissions, and security policies to ensure that only authorized individuals can view or manipulate sensitive data.', '2024-08-26 10:01:32'),
(14, 'How do I reset my password?', 'Click on the \"Forgot Password\" link on the login page, enter your email address, and follow the instructions sent to your inbox to reset your password.', '2024-09-01 11:00:28'),
(15, 'How can I update my profile information?', 'Log in to your account, go to the \"Profile\" section, and click on \"Edit Profile.\" Update your information and click \"Save Changes\" to apply the updates.', '2024-09-01 11:00:28'),
(16, 'What should I do if I encounter an error while submitting a form?', 'Ensure all required fields are filled out correctly. If the issue persists, clear your browser cache and try again. If the problem continues, contact our support team for assistance.', '2024-09-01 11:00:28'),
(17, 'What is the refund policy?', 'Our refund policy allows for a full refund within 30 days of purchase. Please contact our support team for more details.', '2024-09-01 11:05:37'),
(18, 'How can I contact customer support?', 'You can reach our customer support team via email at support@example.com or call us at (123) 456-7890.', '2024-09-01 11:05:37'),
(19, 'Where can I find the user manual?', 'The user manual can be found on our website under the Support section or directly at www.example.com/manual.', '2024-09-01 11:05:37'),
(20, 'Do you offer international shipping?', 'Yes, we offer international shipping. Shipping rates and delivery times vary depending on the destination.', '2024-09-01 11:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_home`
--

CREATE TABLE `tbl_home` (
  `home_id` int(22) NOT NULL,
  `home_title` text NOT NULL,
  `home_subtitleOne` text NOT NULL,
  `home_subtitleTwo` text NOT NULL,
  `home_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_home`
--

INSERT INTO `tbl_home` (`home_id`, `home_title`, `home_subtitleOne`, `home_subtitleTwo`, `home_img`) VALUES
(2, 'Welcome to BayanLink', 'At Bayanlink, we connect communities and simplify access to essential services. Our platform provides direct access to official information, streamlines document requests, and enhances civic engagement.', 'Explore our features to see how we make your experience more efficient and engaging.', 'img1.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `log_id` int(22) NOT NULL,
  `log_desc` varchar(255) NOT NULL,
  `log_date` datetime NOT NULL,
  `user_id` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `notify_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(55) DEFAULT NULL,
  `notify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posts`
--

CREATE TABLE `tbl_posts` (
  `post_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `post_brgy` varchar(55) NOT NULL,
  `post_content` text NOT NULL,
  `post_img` text NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requests`
--

CREATE TABLE `tbl_requests` (
  `req_id` int(22) NOT NULL,
  `user_id` int(22) NOT NULL,
  `req_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `req_eSignature` text NOT NULL,
  `req_typeOfDoc` varchar(75) NOT NULL,
  `req_valid_id` text NOT NULL,
  `req_status` varchar(25) NOT NULL,
  `req_reasons` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `services_id` int(22) NOT NULL,
  `services_title` text NOT NULL,
  `services_desc` text NOT NULL,
  `services_created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`services_id`, `services_title`, `services_desc`, `services_created_at`) VALUES
(2, 'Document Requesting And Tracking', 'Easily request and track documents with our streamlined process.', '2024-09-01 12:00:00'),
(3, 'Enhanced Civic Engagement', 'Engage with your community more effectively through our platform.', '2024-09-01 11:00:00'),
(4, 'Communication Channels', 'Access various communication channels for better interaction.', '2024-09-01 10:00:00'),
(5, 'Personalized User Experience', 'Enjoy a personalized experience tailored to your preferences.', '2024-09-01 09:00:00'),
(6, 'Accessibility and Convenience', 'Experience enhanced accessibility and convenience across the platform.', '2024-09-01 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_terms_conditions`
--

CREATE TABLE `tbl_terms_conditions` (
  `tm_id` int(22) NOT NULL,
  `tm_title` varchar(100) NOT NULL,
  `tm_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_terms_conditions`
--

INSERT INTO `tbl_terms_conditions` (`tm_id`, `tm_title`, `tm_content`) VALUES
(1, 'Introduction', 'Bayanlink is a software as a service (saas) platform designed to facilitate communication and engagement within communities. By accessing or using our services, you agree to comply with and be bound by these terms and conditions.'),
(2, 'Use of the Platform', 'BayanLink grants you a limited, non-exclusive, non-transferable license to access and use the platform for your community engagement needs, subject to these terms. You agree not to misuse the platform, including but not limited to attempting to gain unauthorized access to our systems or engaging in any activity that disrupts or harms the platform.'),
(3, 'User Responsibilities', 'You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You agree to provide accurate and complete information when creating your account and to update your information as necessary.'),
(4, 'Privacy and Data Protection', 'We take your privacy seriously. Our Privacy Policy outlines how we collect, use, and protect your personal information. By using BayanLink, you consent to the practices described in our Privacy Policy.'),
(5, 'Subscription and Payment', 'Access to certain features of BayanLink may require a subscription. By subscribing, you agree to pay the applicable fees as described on our pricing page. Payments are non-refundable, except as required by law.'),
(6, 'Termination', 'We reserve the right to suspend or terminate your access to BayanLink at any time, with or without cause, including if you violate these Terms and Conditions. Upon termination, your right to use the platform will immediately cease.'),
(7, 'Changes to the Terms', 'We may update these Terms and Conditions from time to time. If we make significant changes, we will notify you by email or through a notice on the platform. Your continued use of BayanLink after any changes indicates your acceptance of the new terms.'),
(8, 'Contact Us', 'If you have any questions or concerns about these Terms and Conditions, please contact us.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_typedoc`
--

CREATE TABLE `tbl_typedoc` (
  `id` int(22) NOT NULL,
  `docType` varchar(55) NOT NULL,
  `doc_template` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_typedoc`
--

INSERT INTO `tbl_typedoc` (`id`, `docType`, `doc_template`) VALUES
(11, 'Barangay Clearance', 'brgy_clearance.pdf'),
(12, 'Barangay Indigency', 'brgy_indigencyy.pdf'),
(13, 'Barangay Residency', 'brgy_residency.pdf'),
(14, 'Job Seeker', 'job_seeker.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_useracc`
--

CREATE TABLE `tbl_useracc` (
  `user_id` int(11) NOT NULL,
  `fromSanIsidro` varchar(5) NOT NULL,
  `user_brgy` varchar(55) NOT NULL,
  `user_fname` varchar(55) NOT NULL,
  `user_mname` varchar(55) NOT NULL,
  `user_lname` varchar(55) NOT NULL,
  `user_gender` varchar(55) NOT NULL,
  `user_contactNum` varchar(55) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `user_age` int(22) NOT NULL,
  `placeOfBirth` varchar(55) NOT NULL,
  `civilStatus` varchar(55) NOT NULL,
  `user_city` varchar(55) NOT NULL,
  `user_purok` varchar(55) NOT NULL,
  `user_email` varchar(55) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(55) NOT NULL,
  `user_create_at` datetime DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_useracc`
--

INSERT INTO `tbl_useracc` (`user_id`, `fromSanIsidro`, `user_brgy`, `user_fname`, `user_mname`, `user_lname`, `user_gender`, `user_contactNum`, `dateOfBirth`, `user_age`, `placeOfBirth`, `civilStatus`, `user_city`, `user_purok`, `user_email`, `username`, `password`, `role_id`, `user_create_at`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Yes', 'Malapit', 'Paolo', 'Marvel', 'Ramos', 'Male', '09876543212', '2002-04-29', 22, 'San Isidro, Nueva Ecija', 'Single', 'San Isidro', 'Purok 2', 'qwerty123@gmail.com', 'Qwerty123', '$2y$10$ulORW5LZ1bhPitfMf16P8OCxXOj2W6ZSg4r2ctiG/BCHssNYIMw6m', 1, '2024-08-30 17:52:50', NULL, NULL),
(2, 'Yes', 'Malapit', 'Pao', 'Pao', 'Pao', 'Male', '09876543212', '2001-04-28', 23, 'San Isidro, Nueva Ecija', 'Single', 'San Isidro', 'Purok 2', 'pao@gmail.com', 'pao', '$2y$10$4nvFdzqFRpdgrcDpLOupQ.ZFCPA4Bagey4Ota1PX5gNCk3sjjUhGC', 0, '2024-08-30 17:54:44', NULL, NULL),
(3, 'Yes', 'Malapit', 'Zxc', 'Zxc', 'Zxc', 'Female', '09876543212', '2004-01-01', 20, 'San Isidro', 'Single', 'San Isidro', 'Purok 2', 'zxc@gmail.com', 'Qwerty123', '$2y$10$hYs6kcCtafVx1Gg7SaFtje2QBGhaa6VbS6Egj74aO0VaL1FzHNp7y', 1, '2024-08-30 21:07:05', NULL, NULL),
(4, 'Yes', 'Malapit', 'Tiktalk', 'Tiktalk', 'Tiktalk', 'Male', '09876543212', '2007-12-31', 16, 'San Isidro, Nueva Ecija', 'Single', 'San Isidro', 'Purok 2', 'tiktalkcompany6969@gmail.com', 'tiktalk', '$2y$10$SqnNyGjWhjv/ZOiH0xJ/XesGMF0UvuShU54bMnTIVIkHcvzY8Lw1m', 0, '2024-08-31 15:58:18', NULL, NULL),
(5, 'Yes', 'Malapit', 'Admin', 'Admin', 'Admin', 'Male', '09876543212', '1985-12-12', 38, 'San Isidro, Nueva Ecija', 'Married', 'San Isidro', 'Purok 2', 'admin@gmail.com', 'admin123', '$2y$10$UO478AZvC84E/gvG/L9zd.hONFYVHwbtz1.7ATL7KpptBfq7efpGi', 2, '2024-08-31 17:13:37', NULL, NULL),
(10, 'Yes', 'Poblacion', 'Qqqqq', 'Qqqqq', 'Qqqqq', 'Male', '09876543212', '2001-01-01', 23, 'San Isidro, Nueva Ecija', 'Single', 'San Isidro', 'Purok 1', 'qqqqq@gmail.com', 'qqqqq', '$2y$10$kBEWADlwrLYKowAInb4AAu/gvCRtIHuEodmGxUHND.jZSIaDMugFe', 0, '2024-09-15 20:44:27', NULL, NULL),
(11, 'Yes', 'Alua', 'John', 'A.', 'Doe', 'Male', '09123456781', '1995-06-01', 29, 'San Isidro', 'Single', 'San Isidro', 'Purok 1', 'john.doe1@example.com', 'john.doe1', '$2y$10$NE0i8x2o6lpALC9C8tTLUunqJPAQh2afgezfqSzdTW7xDumaw7yCu', 0, '2024-09-26 19:36:46', NULL, NULL),
(12, 'Yes', 'Calaba', 'Jane', 'B.', 'Smith', 'Female', '09123456782', '1993-04-22', 31, 'San Isidro', 'Married', 'San Isidro', 'Purok 2', 'jane.smith@example.com', 'jane.smith', '$2y$10$BvbUM4WdpQjPS6H1cKzze.lImQC.SzyjZOaQypFIe6lbU5l4dqy26', 0, '2024-09-26 19:36:46', NULL, NULL),
(13, 'Yes', 'Mangga', 'Alex', 'C.', 'Johnson', 'Male', '09123456783', '1989-07-13', 35, 'San Isidro', 'Single', 'San Isidro', 'Purok 3', 'alex.johnson@example.com', 'alex.johnson', '$2y$10$Jbnxk.AsHXZET1buA614t.fwFVY476G1PO45l3FqFAlcsd5iaWKZG', 0, '2024-09-26 19:36:46', NULL, NULL),
(14, 'Yes', 'Poblacion', 'Emily', 'D.', 'Davis', 'Female', '09123456784', '1998-09-05', 26, 'San Isidro', 'Married', 'San Isidro', 'Purok 4', 'emily.davis@example.com', 'emily.davis', '$2y$10$619wW2UXcrdQ.SDjiBy7v.kPj8nN2vZpqkMH.pAgpIM3mHr1jKI5m', 0, '2024-09-26 19:36:46', NULL, NULL),
(15, 'Yes', 'Pulo', 'Michael', 'E.', 'Wilson', 'Male', '09123456785', '1992-12-30', 32, 'San Isidro', 'Single', 'San Isidro', 'Purok 5', 'michael.wilson@example.com', 'michael.wilson', '$2y$10$e0JkfF3...', 0, '2024-09-26 19:36:46', NULL, NULL),
(16, 'Yes', 'Tabon', 'Sarah', 'F.', 'Miller', 'Female', '09123456786', '1991-03-17', 33, 'San Isidro', 'Married', 'San Isidro', 'Purok 6', 'sarah.miller@example.com', 'sarah.miller', '$2y$10$1VQwQzLqZ9RXReoLVFRfJ.AiIXHQsaO3caN9t9Obgma5Ordfkja/i', 0, '2024-09-26 19:36:46', NULL, NULL),
(17, 'Yes', 'San Roque', 'David', 'G.', 'Brown', 'Male', '09123456787', '1997-11-24', 27, 'San Isidro', 'Single', 'San Isidro', 'Purok 7', 'david.brown@example.com', 'david.brown', '$2y$10$cLvGM2J0xTj0ZQYP8Zh2UOTXceoAWSLm.FB7c9wHlPx8tGmTRvlzy', 0, '2024-09-26 19:36:46', NULL, NULL),
(18, 'Yes', 'Sto. Cristo', 'Olivia', 'H.', 'Clark', 'Female', '09123456788', '1996-05-10', 28, 'San Isidro', 'Married', 'San Isidro', 'Purok 8', 'olivia.clark@example.com', 'olivia.clark', '$2y$10$fqRH3v1Hp0vHSflQabV5muswWCP25hGB1w.KbA278yxdWN9wFL2/.', 0, '2024-09-26 19:36:46', NULL, NULL),
(19, 'Yes', 'Calaba', 'Ethan', 'I.', 'Martinez', 'Male', '09123456789', '1988-02-14', 36, 'San Isidro', 'Single', 'San Isidro', 'Purok 9', 'ethan.martinez@example.com', 'ethan.martinez', '$2y$10$fSPJ/mkmai9wog6x6smgIO6BVUeqKEEFqWC1ZqtvpLHBhQUEApN3e', 0, '2024-09-26 19:36:46', NULL, NULL),
(20, 'Yes', 'Alua', 'Isabella', 'J.', 'Lopez', 'Female', '09123456780', '1994-08-20', 30, 'San Isidro', 'Married', 'San Isidro', 'Purok 10', 'isabella.lopez@example.com', 'isabella.lopez', '$2y$10$C90WbBZru7q5PD4HCrr25uuncWx1jOO7wgi.vpgQl0dBqhoNegvKu', 0, '2024-09-26 19:36:46', NULL, NULL),
(21, 'Yes', 'Calaba', 'Liam', 'K.', 'Young', 'Male', '09123456790', '1987-04-15', 37, 'San Isidro', 'Single', 'San Isidro', 'Purok 1', 'liam.young@example.com', 'liam.young', '$2y$10$Z34Zy1ermWLgZzzu2a.cY.PrsOyuUB6K.sD5Fksw5b6kSD55HxBOC', 0, '2024-09-26 20:57:54', NULL, NULL),
(22, 'Yes', 'Mangga', 'Emma', 'L.', 'Hall', 'Female', '09123456791', '1990-10-30', 34, 'San Isidro', 'Married', 'San Isidro', 'Purok 2', 'emma.hall@example.com', 'emma.hall', '$2y$10$g.uIN.jzv/Be1SMtqEfcNeIpnv1p7NfE8xdjKEGqkcocBPZ6XIkqy', 0, '2024-09-26 20:57:54', NULL, NULL),
(23, 'Yes', 'Poblacion', 'Noah', 'M.', 'King', 'Male', '09123456792', '1995-02-07', 29, 'San Isidro', 'Single', 'San Isidro', 'Purok 3', 'noah.king@example.com', 'noah.king', '$2y$10$0Km6c6ZIF5QeVY96ZWZp9.QLk7UOYgXoNpQimiy/px5cFfDHd1GLu', 0, '2024-09-26 20:57:54', NULL, NULL),
(24, 'Yes', 'Pulo', 'Sophia', 'N.', 'Wright', 'Female', '09123456793', '1988-06-12', 36, 'San Isidro', 'Married', 'San Isidro', 'Purok 4', 'sophia.wright@example.com', 'sophia.wright', '$2y$10$jMgr9EsyMY.PO88L7cMNa.hrXCpvhAUYQ1O3wXGPAt4hy/vZIuAru', 0, '2024-09-26 20:57:54', NULL, NULL),
(25, 'Yes', 'Tabon', 'James', 'O.', 'Hill', 'Male', '09123456794', '1985-09-21', 39, 'San Isidro', 'Single', 'San Isidro', 'Purok 5', 'james.hill@example.com', 'james.hill', '$2y$10$jvmk9.nfA435Yf98Dhc14.8WY3zaO3aVQW5KYVWVdhhhy/8kMjXQ6', 0, '2024-09-26 20:57:54', NULL, NULL),
(26, 'Yes', 'San Roque', 'Ava', 'P.', 'Green', 'Female', '09123456795', '1992-01-18', 32, 'San Isidro', 'Married', 'San Isidro', 'Purok 6', 'ava.green@example.com', 'ava.green', '$2y$10$rbogefNZ1LB2Zv5u5UeXIODtuyix469oDBNkXGmU7YuzvDJQPN/x2', 0, '2024-09-26 20:57:54', NULL, NULL),
(27, 'Yes', 'Sto. Cristo', 'Lucas', 'Q.', 'Scott', 'Male', '09123456796', '1993-11-01', 31, 'San Isidro', 'Single', 'San Isidro', 'Purok 7', 'lucas.scott@example.com', 'lucas.scott', '$2y$10$UJN3TmnUD1.44sgA8AQWd.2trAeFOmqEOwduZz0eBUZkFtWkVKDhW', 0, '2024-09-26 20:57:54', NULL, NULL),
(28, 'Yes', 'Alua', 'Mia', 'R.', 'Adams', 'Female', '09123456797', '1996-03-25', 28, 'San Isidro', 'Married', 'San Isidro', 'Purok 8', 'mia.adams@example.com', 'mia.adams', '$2y$10$a9LWPw8coTpnAOswgWlak.Vu0YEFEzm8Exv3ghtUbBmupzdWUM1x6', 0, '2024-09-26 20:57:54', NULL, NULL),
(29, 'Yes', 'Calaba', 'Henry', 'S.', 'Baker', 'Male', '09123456798', '1994-05-09', 30, 'San Isidro', 'Single', 'San Isidro', 'Purok 9', 'henry.baker@example.com', 'henry.baker', '$2y$10$Viog0RFe/zWSvFSMlS4KdOpckOpqUJBoeEE5zmc/CaRMQeUeK4Xfm', 0, '2024-09-26 20:57:54', NULL, NULL),
(30, 'Yes', 'Mangga', 'Amelia', 'T.', 'Nelson', 'Female', '09123456799', '1989-08-13', 35, 'San Isidro', 'Married', 'San Isidro', 'Purok 10', 'amelia.nelson@example.com', 'amelia.nelson', '$2y$10$vNAS2WzfLWzS/XC6zPIT8e4CahPW8a.6o3AHSkQTKUpVPkyrnBxMu', 0, '2024-09-26 20:57:54', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_about_mission`
--
ALTER TABLE `tbl_about_mission`
  ADD PRIMARY KEY (`about_mission_id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `tbl_faqs`
--
ALTER TABLE `tbl_faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_home`
--
ALTER TABLE `tbl_home`
  ADD PRIMARY KEY (`home_id`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`notify_id`);

--
-- Indexes for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`services_id`);

--
-- Indexes for table `tbl_terms_conditions`
--
ALTER TABLE `tbl_terms_conditions`
  ADD PRIMARY KEY (`tm_id`);

--
-- Indexes for table `tbl_typedoc`
--
ALTER TABLE `tbl_typedoc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `docType` (`docType`);

--
-- Indexes for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_about_mission`
--
ALTER TABLE `tbl_about_mission`
  MODIFY `about_mission_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `contact_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_faqs`
--
ALTER TABLE `tbl_faqs`
  MODIFY `faq_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_home`
--
ALTER TABLE `tbl_home`
  MODIFY `home_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `log_id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notify_id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_posts`
--
ALTER TABLE `tbl_posts`
  MODIFY `post_id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_requests`
--
ALTER TABLE `tbl_requests`
  MODIFY `req_id` int(22) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `services_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_terms_conditions`
--
ALTER TABLE `tbl_terms_conditions`
  MODIFY `tm_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_typedoc`
--
ALTER TABLE `tbl_typedoc`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_useracc`
--
ALTER TABLE `tbl_useracc`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
