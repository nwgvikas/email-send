-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 12, 2026 at 10:23 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `makesapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email_template_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('draft','scheduled','processing','completed','failed') NOT NULL DEFAULT 'draft',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `total_contacts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `success_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `failed_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `name`, `email_template_id`, `status`, `scheduled_at`, `sent_at`, `total_contacts`, `success_count`, `failed_count`, `created_at`, `updated_at`) VALUES
(1, 'NWG', 1, 'completed', '2026-05-11 13:20:00', '2026-05-11 12:00:19', 2, 2, 0, '2026-05-11 07:50:16', '2026-05-11 12:00:19'),
(2, 'MIG', 1, 'completed', '2026-05-11 17:30:00', '2026-05-12 02:14:39', 2, 2, 0, '2026-05-11 12:01:02', '2026-05-12 02:14:39'),
(3, 'Manaz Madi Bharucha', 2, 'completed', '2026-05-11 18:58:00', '2026-05-12 02:14:30', 2, 2, 0, '2026-05-11 13:28:16', '2026-05-12 02:14:30'),
(4, 'Manaz Madi Bharucha 2', 3, 'completed', '2026-05-11 20:12:00', '2026-05-12 02:14:06', 1, 1, 0, '2026-05-11 14:42:40', '2026-05-12 02:14:06'),
(5, 'Manaz Madi Bharucha 4', 3, 'processing', '2026-05-12 07:40:00', NULL, 2, 0, 0, '2026-05-12 02:10:26', '2026-05-12 02:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_contact`
--

CREATE TABLE `campaign_contact` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_contact`
--

INSERT INTO `campaign_contact` (`id`, `campaign_id`, `contact_id`, `status`, `error_message`, `processed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'sent', NULL, '2026-05-11 12:00:18', '2026-05-11 07:50:16', '2026-05-11 12:00:18'),
(2, 1, 1, 'sent', NULL, '2026-05-11 12:00:19', '2026-05-11 07:50:16', '2026-05-11 12:00:19'),
(3, 2, 2, 'sent', NULL, '2026-05-12 02:14:37', '2026-05-11 12:01:02', '2026-05-12 02:14:37'),
(4, 2, 1, 'sent', NULL, '2026-05-12 02:14:39', '2026-05-11 12:01:02', '2026-05-12 02:14:39'),
(5, 3, 2, 'sent', NULL, '2026-05-12 02:14:28', '2026-05-11 13:28:16', '2026-05-12 02:14:28'),
(6, 3, 1, 'sent', NULL, '2026-05-12 02:14:30', '2026-05-11 13:28:16', '2026-05-12 02:14:30'),
(7, 4, 1, 'sent', NULL, '2026-05-12 02:14:06', '2026-05-11 14:42:40', '2026-05-12 02:14:06'),
(8, 5, 2, 'pending', NULL, NULL, '2026-05-12 02:10:26', '2026-05-12 02:35:54'),
(9, 5, 1, 'pending', NULL, NULL, '2026-05-12 02:10:26', '2026-05-12 02:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_logs`
--

CREATE TABLE `campaign_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level` enum('info','error') NOT NULL DEFAULT 'info',
  `message` varchar(255) NOT NULL,
  `context` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`context`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaign_logs`
--

INSERT INTO `campaign_logs` (`id`, `campaign_id`, `contact_id`, `level`, `message`, `context`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 07:54:11', '2026-05-11 07:54:11'),
(2, 1, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 07:54:13', '2026-05-11 07:54:13'),
(3, 1, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 07:54:57', '2026-05-11 07:54:57'),
(4, 1, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 07:54:59', '2026-05-11 07:54:59'),
(5, 1, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 07:57:46', '2026-05-11 07:57:46'),
(6, 1, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 07:57:48', '2026-05-11 07:57:48'),
(7, 1, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 12:00:18', '2026-05-11 12:00:18'),
(8, 1, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 12:00:19', '2026-05-11 12:00:19'),
(9, 2, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 12:01:10', '2026-05-11 12:01:10'),
(10, 2, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 12:01:12', '2026-05-11 12:01:12'),
(11, 2, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 12:02:38', '2026-05-11 12:02:38'),
(12, 2, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 12:02:40', '2026-05-11 12:02:40'),
(13, 2, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 13:02:36', '2026-05-11 13:02:36'),
(14, 2, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 13:02:38', '2026-05-11 13:02:38'),
(15, 3, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 13:28:28', '2026-05-11 13:28:28'),
(16, 3, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 13:28:29', '2026-05-11 13:28:29'),
(17, 3, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 14:36:03', '2026-05-11 14:36:03'),
(18, 3, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 14:36:05', '2026-05-11 14:36:05'),
(19, 3, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-11 14:40:21', '2026-05-11 14:40:21'),
(20, 3, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 14:40:24', '2026-05-11 14:40:24'),
(21, 4, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-11 14:42:51', '2026-05-11 14:42:51'),
(22, 4, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-12 02:14:06', '2026-05-12 02:14:06'),
(23, 3, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-12 02:14:28', '2026-05-12 02:14:28'),
(24, 3, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-12 02:14:30', '2026-05-12 02:14:30'),
(25, 5, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-12 02:14:32', '2026-05-12 02:14:32'),
(26, 5, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-12 02:14:34', '2026-05-12 02:14:34'),
(27, 2, 2, 'info', 'Email sent successfully.', '{\"email\":\"vikasnwg@gmail.com\"}', '2026-05-12 02:14:37', '2026-05-12 02:14:37'),
(28, 2, 1, 'info', 'Email sent successfully.', '{\"email\":\"nwgvikas@gmail.com\"}', '2026-05-12 02:14:39', '2026-05-12 02:14:39');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `extra_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_fields`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `extra_fields`, `created_at`, `updated_at`) VALUES
(1, 'vikas', 'nwgvikas@gmail.com', NULL, '2026-05-11 07:33:05', '2026-05-11 07:33:05'),
(2, 'kumar', 'vikasnwg@gmail.com', NULL, '2026-05-11 07:42:58', '2026-05-11 07:42:58'),
(3, 'Raj', 'raj@example.com', '{\"company\":\"TechSoft\",\"city\":\"Kanpur\"}', '2026-05-11 13:31:48', '2026-05-11 14:46:34'),
(4, 'Verma', 'priya2@example.com', '{\"company\":\"CodeHub\",\"city\":\"Lucknow\"}', '2026-05-11 13:31:48', '2026-05-11 13:31:48'),
(5, 'Aman', 'aman@example.com', '{\"company\":\"WebNova\",\"city\":\"Delhi\"}', '2026-05-11 13:31:48', '2026-05-11 13:31:48'),
(6, 'Rahul Sharma', 'rahul@example.com', '{\"company\":\"TechSoft\",\"city\":\"Kanpur\"}', '2026-05-12 02:34:00', '2026-05-12 02:34:00'),
(7, 'Priya Verma', 'priya@example.com', '{\"company\":\"CodeHub\",\"city\":\"Lucknow\"}', '2026-05-12 02:34:00', '2026-05-12 02:34:00'),
(8, 'Amit Singh', 'amit@example.com', '{\"company\":\"WebNova\",\"city\":\"Delhi\"}', '2026-05-12 02:34:00', '2026-05-12 02:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `body`, `created_at`, `updated_at`) VALUES
(1, 'First email', 'HI {{name}} Welcome to company', '<p>Hello {{ $name }},</p><p>Welcome to our platform.</p><p>Your account has been created successfully.</p><p>Here are your account details:</p><p>Email: {{ $email }}</p><p>Thank you for joining us.</p><p>Regards,<br>Your Company Name</p>', '2026-05-11 07:38:28', '2026-05-11 07:38:28'),
(2, 'Manaz Madi Bharucha', 'Welcome {{name}}', '<p>Hello {{ name }},&nbsp;</p><p>Welcome to our platform. Your account has been created successfully. Here are your account details: Email: {{ email }} Thank you for joining us. Regards, Your Company Name</p>', '2026-05-11 13:27:29', '2026-05-11 13:27:29'),
(3, 'Manaz Madi Bharucha 2', 'Welcome to {{ name }}', '<p>Hello {{ name }},&nbsp;</p><p>Welcome to our platform. Your account has been created successfully.&nbsp;</p><p>Here are your account details: Email: {{ email }}&nbsp;</p><p>Thank you for joining us.&nbsp;</p><p>Regards, Your Company Name</p>', '2026-05-11 14:42:08', '2026-05-11 14:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(29, 'default', '{\"uuid\":\"fe73df98-38be-44a3-9dfa-5f6c01f46997\",\"displayName\":\"App\\\\Jobs\\\\SendCampaignEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendCampaignEmailJob\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendCampaignEmailJob\\\":2:{s:10:\\\"campaignId\\\";i:5;s:9:\\\"contactId\\\";i:2;}\",\"batchId\":null},\"createdAt\":1778573154,\"delay\":null}', 0, NULL, 1778573154, 1778573154),
(30, 'default', '{\"uuid\":\"ab61bf49-3d2c-443e-aaad-c286be2fa1f8\",\"displayName\":\"App\\\\Jobs\\\\SendCampaignEmailJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendCampaignEmailJob\",\"command\":\"O:29:\\\"App\\\\Jobs\\\\SendCampaignEmailJob\\\":2:{s:10:\\\"campaignId\\\";i:5;s:9:\\\"contactId\\\";i:1;}\",\"batchId\":null},\"createdAt\":1778573154,\"delay\":null}', 0, NULL, 1778573154, 1778573154);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_11_123000_create_contacts_table', 2),
(5, '2026_05_11_123100_create_email_templates_table', 2),
(6, '2026_05_11_123200_create_campaigns_table', 2),
(7, '2026_05_11_123300_create_campaign_contact_table', 2),
(8, '2026_05_11_123400_create_campaign_logs_table', 2),
(9, '2026_05_12_000000_create_site_settings_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('vikasnwg@gmail.com', '$2y$12$hcn5N1VbMc2bB/Se0DgCW.fN8.2aryYIHbFAL3gnDabROhlECxhYe', '2026-05-11 14:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `favicon_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `logo_path`, `favicon_path`, `created_at`, `updated_at`) VALUES
(1, 'Email Console', 'site/zgVCGOsz3ulU8DIzCVDnPBZ1WkJixPaRZ1QvOzsj.png', 'site/eAYvQ3iVs4w9rFBu1iW80LPhlUlqlfDcnIgWS11S.png', '2026-05-11 14:54:30', '2026-05-11 14:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$K41nd7ryz53.LP6hnBN0iOkJGvLEiC9vvNHiiYUQ04vI62xfx8YgS', NULL, '2026-05-11 07:16:53', '2026-05-11 07:16:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaigns_email_template_id_foreign` (`email_template_id`);

--
-- Indexes for table `campaign_contact`
--
ALTER TABLE `campaign_contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `campaign_contact_campaign_id_contact_id_unique` (`campaign_id`,`contact_id`),
  ADD KEY `campaign_contact_contact_id_foreign` (`contact_id`);

--
-- Indexes for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_logs_campaign_id_foreign` (`campaign_id`),
  ADD KEY `campaign_logs_contact_id_foreign` (`contact_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contacts_email_unique` (`email`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `campaign_contact`
--
ALTER TABLE `campaign_contact`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_email_template_id_foreign` FOREIGN KEY (`email_template_id`) REFERENCES `email_templates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `campaign_contact`
--
ALTER TABLE `campaign_contact`
  ADD CONSTRAINT `campaign_contact_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campaign_contact_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `campaign_logs`
--
ALTER TABLE `campaign_logs`
  ADD CONSTRAINT `campaign_logs_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campaign_logs_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
