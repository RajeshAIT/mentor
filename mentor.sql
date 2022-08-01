-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2022 at 01:34 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mentor`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_by` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `media_type_id` bigint(20) UNSIGNED NOT NULL,
  `media` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `answer_by`, `question_id`, `media_type_id`, `media`, `comments`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, '1656507193.mp4', 'goodddd', '2022-06-29 07:23:13', '2022-06-29 07:23:13'),
(3, 24, 2, 2, '1656507221.mp3', 'goodddd', '2022-06-29 07:23:41', '2022-06-29 07:23:41'),
(6, 23, 2, 2, '1657527417.mp3', 'good', '2022-07-11 02:46:57', '2022-07-11 02:46:57'),
(7, 34, 4, 2, '1657608753.jpg', 'test', '2022-07-12 01:22:34', '2022-07-12 01:22:34'),
(8, 35, 5, 2, '1657698379.jpg', 'test', '2022-07-13 02:16:19', '2022-07-13 02:16:19'),
(9, 37, 4, 2, '1658233745.jpg', 'test', '2022-07-19 06:59:05', '2022-07-19 06:59:05'),
(10, 40, 4, 2, '1658234101.jpg', 'test', '2022-07-19 07:05:01', '2022-07-19 07:05:01'),
(11, 40, 4, 2, '1658234176.jpg', 'test', '2022-07-19 07:06:16', '2022-07-19 07:06:16'),
(12, 41, 4, 2, '1658234285.jpg', 'test', '2022-07-19 07:08:05', '2022-07-19 07:08:05'),
(13, 41, 4, 2, '1658236152.jpg', 'test', '2022-07-19 07:39:12', '2022-07-19 07:39:12'),
(14, 41, 4, 2, '1658239530.jpg', 'test', '2022-07-19 08:35:30', '2022-07-19 08:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `job_title`, `created_at`, `updated_at`) VALUES
(1, 'surgeon(0)', NULL, NULL),
(2, 'surgeon(1)', NULL, NULL),
(3, 'surgeon(2)', NULL, NULL),
(4, 'surgeon(3)', NULL, NULL),
(5, 'test', '2022-07-06 03:03:12', '2022-07-06 03:03:12'),
(6, 'test ait', '2022-07-06 03:12:21', '2022-07-06 03:12:21'),
(7, 'test ait', '2022-07-06 03:12:44', '2022-07-06 03:12:44'),
(8, 'test ait', '2022-07-06 03:12:49', '2022-07-06 03:12:49'),
(9, 'test ait', '2022-07-06 03:13:13', '2022-07-06 03:13:13'),
(10, 'test new', '2022-07-06 03:18:58', '2022-07-06 03:18:58'),
(11, 'test ait new', '2022-07-06 07:17:36', '2022-07-06 07:17:36'),
(12, 'test ait new', '2022-07-06 08:35:57', '2022-07-06 08:35:57'),
(13, 'test ait', '2022-07-06 08:36:01', '2022-07-06 08:36:01'),
(14, 'test ait', '2022-07-06 22:44:07', '2022-07-06 22:44:07'),
(15, 'xvfdf', '2022-07-07 01:51:10', '2022-07-07 01:51:10'),
(16, 'xvfdf', '2022-07-07 05:16:29', '2022-07-07 05:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `company_name`, `logo`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 22, 'wtest', '1657263729.jpg', 'yt', 29, '2022-07-08 01:32:09', '2022-07-08 01:32:09'),
(2, 31, 'wtest', '1657269086.jpg', 'klmmjgg', 31, '2022-07-08 01:51:03', '2022-07-08 03:01:26'),
(3, 42, 'wtest', '1657265999.jpg', 'yt', 31, '2022-07-08 02:09:59', '2022-07-08 02:09:59'),
(4, 31, 'wtest', '1657267969.jpg', 'klmmjgg', 31, '2022-07-08 02:42:49', '2022-07-08 02:42:49'),
(5, 31, 'wtest', '1657268390.jpg', 'klmmjgg', 31, '2022-07-08 02:49:50', '2022-07-08 02:49:50'),
(6, 22, 'wtest', '1657269124.jpg', 'klmmjgg', 31, '2022-07-08 02:51:05', '2022-07-08 03:02:04'),
(7, 31, 'wtest', '1657269737.jpg', 'klmmjgghhhh', 31, '2022-07-08 02:51:09', '2022-07-08 03:12:17'),
(8, 30, 'test', '1657270024.jpg', 'klmmjgghhhhggg', 30, '2022-07-08 03:13:57', '2022-07-08 03:17:04'),
(9, 32, 'test', '1657280605.jpg', 'klmmjgghhhhggg', 32, '2022-07-08 06:13:25', '2022-07-08 06:13:25'),
(10, 36, 'test', '1657289142.jpg', 'klmmjgghhhhggg', 33, '2022-07-08 08:35:42', '2022-07-08 08:35:42'),
(11, 40, 'test', '1658232388.jpg', 'test', 40, '2022-07-19 06:35:34', '2022-07-19 06:36:28'),
(12, 42, 'test', '1658234246.jpg', 'test', 41, '2022-07-19 07:07:26', '2022-07-19 07:07:26'),
(13, 43, 'Test Company', '1658903398.jpg', 'yt', 44, '2022-07-27 00:59:58', '2022-07-27 00:59:58'),
(14, 44, 'dvfv', '1658999616.jpg', 'yt', 45, '2022-07-28 03:43:36', '2022-07-28 03:43:36'),
(15, 47, 'dvfv', '1659004472.jpg', 'yt', 47, '2022-07-28 05:04:32', '2022-07-28 05:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `company_mentor`
--

CREATE TABLE `company_mentor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_verifies`
--

CREATE TABLE `company_verifies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verify` tinyint(1) DEFAULT '0',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emotions`
--

CREATE TABLE `emotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emotion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emotions`
--

INSERT INTO `emotions` (`id`, `emotion`, `created_at`, `updated_at`) VALUES
(1, 'excited', NULL, NULL),
(2, 'happy', NULL, NULL),
(3, 'alert', NULL, NULL),
(4, 'nervous', NULL, NULL),
(5, 'curious', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mentor_id` bigint(20) UNSIGNED NOT NULL,
  `mentee_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `mentor_id`, `mentee_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 42, 45, '1', '2022-07-29 03:47:02', '2022-07-29 04:52:26'),
(2, 24, 45, '2', '2022-07-29 04:52:45', '2022-07-29 05:03:19'),
(3, 22, 45, '1', '2022-07-29 05:03:42', '2022-07-29 05:03:42'),
(4, 20, 45, '1', '2022-07-29 05:03:49', '2022-07-29 05:03:49'),
(6, 1, 45, '1', '2022-07-29 05:19:28', '2022-07-29 05:19:41');

-- --------------------------------------------------------

--
-- Table structure for table `invite_people`
--

CREATE TABLE `invite_people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invite_people`
--

INSERT INTO `invite_people` (`id`, `company_id`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 'shalinir.99@gmail.com', 0, '2022-07-27 02:40:46', '2022-07-27 02:40:46'),
(2, 13, 'shalinir.ait99@gmail.com', 1, '2022-07-27 02:41:07', '2022-07-28 03:45:47'),
(5, 14, 'krishna.ait99@gmail.com', 1, '2022-07-28 03:47:28', '2022-07-28 05:02:22'),
(6, 14, 'shalinir.ait99@gmail.com', 1, '2022-07-28 03:48:00', '2022-07-28 04:59:32'),
(7, 15, 'shalinir.ait99@gmail.com', 1, '2022-07-28 05:06:23', '2022-07-28 05:20:10'),
(8, 15, 'krishna.ait99@gmail.com', 1, '2022-07-28 05:20:40', '2022-07-28 05:21:05'),
(9, 15, 'krishnasrii.ait99@gmail.com', 1, '2022-07-28 05:21:47', '2022-07-28 05:22:22'),
(10, 15, 'krishnasri.ait99@gmail.com', 1, '2022-07-28 08:33:48', '2022-07-28 08:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `mediatypes`
--

CREATE TABLE `mediatypes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mediatypes`
--

INSERT INTO `mediatypes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Image', '2022-06-17 02:19:15', '2022-06-17 02:19:15'),
(2, 'Video', '2022-06-17 02:19:15', '2022-06-17 02:19:15'),
(3, 'Audio', '2022-06-17 02:19:15', '2022-06-17 02:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2022_05_31_070757_create_userrole_table', 1),
(10, '2022_05_31_071629_create_userprofile_table', 1),
(11, '2022_05_31_075248_alter_users_table', 1),
(12, '2022_06_01_103330_create_companies_table', 1),
(13, '2022_06_01_105650_create_company_mentor_table', 1),
(14, '2022_06_01_140002_create_post_table', 1),
(15, '2022_06_01_144230_create_media_type_table', 1),
(16, '2022_06_01_144421_create_post_type_table', 1),
(17, '2022_06_01_144631_create_post_media_table', 1),
(18, '2022_06_01_145923_create_question_table', 1),
(19, '2022_06_02_043429_rename_table', 1),
(20, '2022_06_07_100328_change_mediatype_table_name', 1),
(21, '2022_06_07_111341_add_user_id_to_companies_table', 1),
(22, '2022_06_08_042050_change_posttype_table_name', 1),
(23, '2022_06_08_053040_create_categories_table', 1),
(24, '2022_06_08_053138_create_emotions_table', 1),
(25, '2022_06_08_053201_create_question_associations_table', 1),
(26, '2022_06_08_054845_add_fcm_to_users_table', 1),
(27, '2022_06_08_063206_add_multiple_column_to_question', 1),
(28, '2022_06_08_064606_create_top_keywords_table', 1),
(29, '2022_06_08_080434_add_location_to_userprofile_table', 1),
(30, '2022_06_08_103550_add_disclaimer_to_users_table', 1),
(31, '2022_06_09_072711_create_answer_table', 1),
(32, '2022_06_14_111217_make_media_type_id_nullable_on_postmedia_table', 1),
(33, '2022_06_23_041200_create_companies_table', 2),
(34, '2022_06_23_041631_create_posts_table', 3),
(35, '2022_06_23_042031_create_userprofile_table', 4),
(36, '2022_06_23_111056_make_company_id_nullabe_on_posts_table', 5),
(37, '2022_06_17_153313_create_up_votes_table', 6),
(38, '2022_06_18_055437_create_reactions_table', 6),
(39, '2022_06_18_062156_create_user_reactions_table', 6),
(40, '2022_06_24_065125_rename_name_to_company_name_in_companies_table', 7),
(41, '2022_06_24_135657_add_soft_deletes_to_posts_table', 8),
(42, '2022_06_29_121627_add_media_type_id_to_answer_table', 9),
(43, '2022_06_30_130005_alter_disclaimer_as_nullable_on_users_table', 10),
(44, '2022_07_04_041307_add_media_thumbnail_on_postmedia_table', 11),
(45, '2022_07_05_125248_alter_companies_table', 12),
(46, '2022_07_07_053107_alter_location_as_nullable_in_userprofile_table', 13),
(47, '2022_07_14_132801_alter_table_company_verifies_add_verify', 14),
(48, '2022_07_15_080147_alter_table_company_verifies', 15),
(49, '2022_07_15_080721_alter_table_company_verifies', 16),
(50, '2022_07_18_083925_alter_company_verifies_table_add_user_id', 17),
(51, '2022_06_27_063628_create_company_verifies_table', 18),
(52, '2022_07_19_062537_create_company_verifies_table', 19),
(53, '2022_07_19_063403_alter_table_company_verifies', 20),
(54, '2022_07_19_064259_alter_company_verifies_table_add_user_id', 21),
(55, '2022_07_19_064502_alter_table_company_verifies_email', 22),
(56, '2022_07_19_065109_alter_table_company_verifies_email', 23),
(57, '2022_07_19_065414_alter_table_company_verifies_email', 24),
(58, '2022_07_19_070246_alter_table_company_verifies_email', 25),
(59, '2022_07_19_112604_create_ranking_lists_table', 26),
(60, '2022_07_21_115715_invite_peoples', 27),
(61, '2022_07_21_130826_invite_people', 28),
(62, '2022_07_22_053950_alter_invite_people_table_add_email', 29),
(63, '2022_07_22_054439_alter_invite_people_table_add_email', 30),
(64, '2022_07_28_081008_alter_password_resets_table', 31),
(65, '2022_07_28_084743_alter_users_table_add_token', 32),
(66, '2022_07_29_071058_create_follow_table', 33),
(67, '2022_07_29_074347_create_follows_table', 34);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('062420dbb4fa0e680cf2e165666593ae69c7b30769a9beec153cca6d092416d25f6df03e1fee7345', 45, 1, 'mentor', '[]', 0, '2022-07-28 00:12:18', '2022-07-28 00:12:18', '2023-07-28 05:42:18'),
('0712d740c0d12d352b9fb4dc21cefeaff6bc494daa09fe1c16f646c2bacffe8b02902f36998cb4b6', 45, 1, 'mentor', '[]', 0, '2022-07-27 05:03:27', '2022-07-27 05:03:27', '2023-07-27 10:33:27'),
('0838378b25b8b90c638f13f1bd273ab236041ed8b6634aa0b92365fa8c1f504292a77b1607c76eb7', 10, 1, 'mentor', '[]', 0, '2022-06-23 07:38:40', '2022-06-23 07:38:40', '2023-06-23 13:08:40'),
('0baa733106664ddc4edae17e361fc8d74503e631a02b6a535aed75cca00adffc4dd2225be21bfdee', 31, 1, 'mentor', '[]', 0, '2022-07-08 02:09:35', '2022-07-08 02:09:35', '2023-07-08 07:39:35'),
('0c397aa4e53055285fcb80d1f09a2041102ce81330e6f9d4a2266216f1c38cb93307fe664bedb463', 23, 1, 'mentor', '[]', 1, '2022-06-29 01:35:34', '2022-06-29 01:35:34', '2023-06-29 07:05:34'),
('0d7093fe78b47c1c63fe4003dcbfff031b1fe69ec9fefa93cd0caf85712f35407e8d070832622254', 30, 1, 'mentor', '[]', 0, '2022-07-08 02:10:31', '2022-07-08 02:10:31', '2023-07-08 07:40:31'),
('13550be7b3e4ef9841538014588b27e83fc1bc7c369104393e15271a5509baf548b1407eaf493693', 24, 1, 'mentor', '[]', 0, '2022-06-30 08:29:09', '2022-06-30 08:29:09', '2023-06-30 13:59:09'),
('155d06a29ac935e0d0673bf0f2f966fdb27956ad95db8f35c61ac3a335acfc395f22534e40a3df29', 9, 1, 'mentor', '[]', 0, '2022-06-22 23:09:11', '2022-06-22 23:09:11', '2023-06-23 04:39:11'),
('1d1cfb3bf10a4fde7b7b4e5db829d38ea9095b06888b0955d1d59e5cb55659ce611261b5802c3caf', 44, 1, 'mentor', '[]', 0, '2022-07-27 00:58:10', '2022-07-27 00:58:10', '2023-07-27 06:28:10'),
('1dbbbf78e5cd4f70a98b10dd6d4d09839bbc07461d844bdcdf464e5398eff265751a4526ba30b24a', 37, 1, 'mentor', '[]', 0, '2022-07-29 02:02:22', '2022-07-29 02:02:22', '2023-07-29 07:32:22'),
('21eb757d972af391af643c42b71adff75eabb378e40e325dc35774c5d850499cb6f7f46543309c9a', 4, 1, 'mentor', '[]', 0, '2022-06-18 05:34:50', '2022-06-18 05:34:50', '2023-06-18 11:04:50'),
('239b9d115e6a8dd6e3813a48a48389dff4d251082755af56c9cb0f58bf2bd630ba9c2e3346ac998f', 3, 1, 'mentor', '[]', 0, '2022-07-12 00:34:47', '2022-07-12 00:34:47', '2023-07-12 06:04:47'),
('2e3f816dce0375a966a7fea11f30f48672c602e350b7c437b2454e503119b17d2034f5157a77c977', 32, 1, 'mentor', '[]', 0, '2022-07-08 06:13:00', '2022-07-08 06:13:00', '2023-07-08 11:43:00'),
('2f5098984d487fffd76946488ceba659e6ef594c032675e33986848f1a12ad2e1b130603f08d77cb', 3, 1, 'mentor', '[]', 0, '2022-07-11 23:27:28', '2022-07-11 23:27:28', '2023-07-12 04:57:28'),
('353aef94b2dc1b609035a82148fdd8f8fd8eec4191bbd186692f64071eb3599513346bbc1c6c7bf3', 30, 1, 'mentor', '[]', 0, '2022-07-08 03:13:01', '2022-07-08 03:13:01', '2023-07-08 08:43:01'),
('35cdabff69e2d45b986ea4e92f95b4b8973cc2b6617e0590e52adc8e7b11b6f5780f66710dc716ed', 7, 1, 'mentor', '[]', 0, '2022-06-22 23:07:58', '2022-06-22 23:07:58', '2023-06-23 04:37:58'),
('35d63c74ffdeebbabf27aec83975ff3a8a170b80488e88ea8e6436b3e18e3d26cb29934d33345d97', 6, 1, 'mentor', '[]', 0, '2022-06-22 22:56:27', '2022-06-22 22:56:27', '2023-06-23 04:26:27'),
('366ae9688d3156ac973f1eb5284eed4703e0e1bac08c85cea5b5d64fb3ca327fba8bca467805fbbb', 22, 1, 'mentor', '[]', 0, '2022-06-28 23:55:19', '2022-06-28 23:55:19', '2023-06-29 05:25:19'),
('38c5664732a499fce4e29c15212bfd89e86246ab90e499f36688136ac9447ca427f0e5e1065b2ea0', 1, 1, 'mentor', '[]', 0, '2022-06-17 03:04:18', '2022-06-17 03:04:18', '2023-06-17 08:34:18'),
('395fb2fd35b030fa8d99a74d472d154299dfbc67f47b281df441658bcc3ae1f291a535001e30003b', 22, 1, 'mentor', '[]', 0, '2022-06-28 23:54:48', '2022-06-28 23:54:48', '2023-06-29 05:24:48'),
('3d16ecf7a4fd0fee978ea7a0e0b0b57ce1485f7c7bcae8415a61838f4eb2c2d26e4d572b87f8bc42', 30, 1, 'mentor', '[]', 0, '2022-07-08 01:43:55', '2022-07-08 01:43:55', '2023-07-08 07:13:55'),
('3efdd233a5c0d0439ee744c7e794dc2b5935310a651c4e35200af931bae056ece4138741c3cf3980', 1, 1, 'mentor', '[]', 0, '2022-06-17 03:44:21', '2022-06-17 03:44:21', '2023-06-17 09:14:21'),
('493ddb21b6dbc1f0ca0a86eee8cc6cf577bfc9f22d085875594f8aab160d752d5c042f7f0efc9ce7', 1, 1, 'mentor', '[]', 0, '2022-06-22 02:34:24', '2022-06-22 02:34:24', '2023-06-22 08:04:24'),
('4baea5fff434e0a867fd1545ffb164d9657ccc1992798f44e2b2e8c01fb249e17d1728581a800f6d', 24, 1, 'mentor', '[]', 0, '2022-07-02 01:05:27', '2022-07-02 01:05:27', '2023-07-02 06:35:27'),
('527115744d4b2f400a2133489e459ed48bcd144068b139cc00cbd25d1f8a5e7314f06cc5044b4ef0', 30, 1, 'mentor', '[]', 0, '2022-07-08 02:02:44', '2022-07-08 02:02:44', '2023-07-08 07:32:44'),
('52ddead5a1019ca2adb6f2810484bc08df2d506ce48b4e84de6efba7fb3c0817f9d31f5229ab88a6', 37, 1, 'mentor', '[]', 0, '2022-07-29 02:04:02', '2022-07-29 02:04:02', '2023-07-29 07:34:02'),
('5372db28489be147103369a5bcc1f1b1e33aa77d5d2dfa201feaa152fc270e858b0d9a995542e751', 3, 1, 'mentor', '[]', 0, '2022-06-17 06:56:37', '2022-06-17 06:56:37', '2023-06-17 12:26:37'),
('573d6dcc25d9b900f2af9ce1bdb69460a0de8f093acddb2ea84e46e038a6990f5dc3715c6b123c36', 47, 1, 'mentor', '[]', 0, '2022-07-28 05:04:15', '2022-07-28 05:04:15', '2023-07-28 10:34:15'),
('5fe2f728f1525410ccda7218c58902b01fa9936d1cb41b6ebbcc3ad40a21f46b3c865f2f794c9d9b', 42, 1, 'mentor', '[]', 0, '2022-07-20 08:15:03', '2022-07-20 08:15:03', '2023-07-20 13:45:03'),
('6380b9a89453aec3d0f484b54933d220443174051f720f5cf7f6acf423163d25d8b704595e43ca9b', 3, 1, 'mentor', '[]', 0, '2022-07-11 02:19:20', '2022-07-11 02:19:20', '2023-07-11 07:49:20'),
('651516d88a325b7b262be9c71194f0f6088393a2efd55f1b90ca65996934d84aad9ab963020ea752', 2, 1, 'mentor', '[]', 0, '2022-06-17 05:36:22', '2022-06-17 05:36:22', '2023-06-17 11:06:22'),
('6546a08bce51d0b2ae52412298d30806624f196968e72b681396d1cac086111c744675bdd09ab492', 34, 1, 'mentor', '[]', 0, '2022-07-12 02:35:23', '2022-07-12 02:35:23', '2023-07-12 08:05:23'),
('656cd3e652d9c817748b4dfced61ac33798dd9ee41136847a0e33d3df12c34eaeb26de5660692a63', 12, 1, 'mentor', '[]', 0, '2022-06-23 08:20:18', '2022-06-23 08:20:18', '2023-06-23 13:50:18'),
('698efbbbd98040c3098bfe454a750d787911d66ff0a02d20c07367ddcb6f11f5785e4f446d706077', 21, 1, 'mentor', '[]', 0, '2022-06-28 23:53:08', '2022-06-28 23:53:08', '2023-06-29 05:23:08'),
('69fd27dcc42543694198b955d2d46624da708fbeb548a1cee63331a9cecbfa07f06f6733cd29ec88', 23, 1, 'mentor', '[]', 1, '2022-06-29 00:31:16', '2022-06-29 00:31:16', '2023-06-29 06:01:16'),
('6b36959106bf4334a67e262230145bfcb7b604d3062289c53e9b3f03e20859dcb8c6352296ad7ff3', 24, 1, 'mentor', '[]', 0, '2022-07-01 06:28:59', '2022-07-01 06:28:59', '2023-07-01 11:58:59'),
('712f802e2f08c15d3acf196fc92c4cf0be6fb43fda2baac375489f15e8a18928fb9f59aa6b6b54cf', 24, 1, 'mentor', '[]', 0, '2022-06-29 08:39:37', '2022-06-29 08:39:37', '2023-06-29 14:09:37'),
('722faf195b1506dfbbc798c6ca954f01206f51904b4011d2d2904a59da8339f7ca5c5006fa98458d', 44, 1, 'mentor', '[]', 0, '2022-07-27 01:04:32', '2022-07-27 01:04:32', '2023-07-27 06:34:32'),
('7516f76b7a208c92e599cc8bf58c84a381efa1a878292f721aadcbb8a74bb26d9aa0247c0f3d5563', 33, 1, 'mentor', '[]', 0, '2022-07-10 22:53:18', '2022-07-10 22:53:18', '2023-07-11 04:23:18'),
('75303385c3ce6bff84f65cf0c56030896c27ea3a73047123872bb238a029ee884849b578e6a59f23', 30, 1, 'mentor', '[]', 0, '2022-07-07 08:13:15', '2022-07-07 08:13:15', '2023-07-07 13:43:15'),
('79fc202da4cffc6d0b7d0efef833a2f3de43b5bf2269e5417cceefc0cbad95de7a8960641ff193b8', 4, 1, 'mentor', '[]', 0, '2022-06-17 06:57:18', '2022-06-17 06:57:18', '2023-06-17 12:27:18'),
('7a351c4b5dcb7539fbdbb06d5549db563314df5d1a649970cac3b3026ca26478c294e52e270ccc9a', 24, 1, 'mentor', '[]', 0, '2022-07-01 00:11:36', '2022-07-01 00:11:36', '2023-07-01 05:41:36'),
('7a3cb97581d5efc0acd00b0089e2f3978f25ed049e3cdcb5daeb9ef49540442d6c8cc5f0695b73e8', 4, 1, 'mentor', '[]', 0, '2022-06-18 02:49:28', '2022-06-18 02:49:28', '2023-06-18 08:19:28'),
('7a49d88e97780ef335a97da2b6168332c34ab53c95fb4f79c452ffb0a144fa918c9db9097a00e0b5', 33, 1, 'mentor', '[]', 0, '2022-07-08 08:35:22', '2022-07-08 08:35:22', '2023-07-08 14:05:22'),
('7b39872a0944c286bb8d03b6462f01acb561ad6b267df136de95420c1b9c950d9fda3e26b02e9aee', 35, 1, 'mentor', '[]', 0, '2022-07-13 01:42:05', '2022-07-13 01:42:05', '2023-07-13 07:12:05'),
('7cb3340fc73bcfc538134667eafea4d0395d0421925857bdd298bdc82ab6ce5634fcb6d9d7a68117', 29, 1, 'mentor', '[]', 0, '2022-07-08 01:49:38', '2022-07-08 01:49:38', '2023-07-08 07:19:38'),
('816fb08d0c34f798d70cf01234e1721b2a3d4e2fdb922de9b10d40fa38d98711d3a67af351045a6c', 10, 1, 'mentor', '[]', 0, '2022-06-22 23:02:59', '2022-06-22 23:02:59', '2023-06-23 04:32:59'),
('81a1c1b7011f5eed8c7a88154b5c853842f26554f876ced6777b126f6e5708ca3953685253e9122e', 4, 1, 'mentor', '[]', 0, '2022-06-17 08:27:57', '2022-06-17 08:27:57', '2023-06-17 13:57:57'),
('8602ffeb1fe27e8bd290acbfd70049613a5cde8dff804387e267056608f6a840b1f1d658379c542b', 8, 1, 'mentor', '[]', 0, '2022-06-22 23:08:20', '2022-06-22 23:08:20', '2023-06-23 04:38:20'),
('89157e4aa43a6e20bca543adced86560cae5f936c8ce868e3fa11a0dbaa34b467a1d449d73b7a1a0', 8, 1, 'mentor', '[]', 0, '2022-06-23 07:49:09', '2022-06-23 07:49:09', '2023-06-23 13:19:09'),
('909b600f713c140b610ec7c4e50082e54348402717b174999e78be29ff60abedef91751bd44f68eb', 44, 1, 'mentor', '[]', 0, '2022-07-28 08:10:58', '2022-07-28 08:10:58', '2023-07-28 13:40:58'),
('96c1961652b658757680a4a5ba7919a824fa6555647c4a2c5a02f116aa002fc4353035ec649f038b', 34, 1, 'mentor', '[]', 0, '2022-07-12 01:18:12', '2022-07-12 01:18:12', '2023-07-12 06:48:12'),
('97113d79d1f429353c61c482fcdbc71cf8b836a89adf20f419f52bdc542c4db8da1e3c562427684f', 35, 1, 'mentor', '[]', 0, '2022-07-13 02:14:54', '2022-07-13 02:14:54', '2023-07-13 07:44:54'),
('9beb057294b58bd5fa3a0d51653e11f0361c4a741b995cd1b3ab19cb4326627bc4abfb00fe3cd8c8', 1, 1, 'mentor', '[]', 0, '2022-06-17 03:44:37', '2022-06-17 03:44:37', '2023-06-17 09:14:37'),
('9c35bff8f37d78ba414e98b0d5214df10e7acedbbfa435b9e3080132570099c88b270e64288bd319', 24, 1, 'mentor', '[]', 0, '2022-06-29 03:35:49', '2022-06-29 03:35:49', '2023-06-29 09:05:49'),
('9c83c968f3d881de3df4a22bf34453b7873cce77685deb20e921d6033aa2ac72f8433caefd95c908', 36, 1, 'mentor', '[]', 0, '2022-07-19 03:21:52', '2022-07-19 03:21:52', '2023-07-19 08:51:52'),
('a11a72d76b2d3bd648d8a59885516251b87e899da96e5c505f6da63e198a821955bf66389e463516', 35, 1, 'mentor', '[]', 0, '2022-07-17 22:45:41', '2022-07-17 22:45:41', '2023-07-18 04:15:41'),
('a8de997eadb330a6746ce67b71b20e7bdca88272bafc37e12732d25a68d85bd0d82544d2604f16ad', 29, 1, 'mentor', '[]', 0, '2022-07-07 05:34:35', '2022-07-07 05:34:35', '2023-07-07 11:04:35'),
('a8e1861b6b158a0abcc7014fef04227a297db5ba9865ac757bc0e193c34a3af1b03d51c066bd8a68', 45, 1, 'mentor', '[]', 0, '2022-07-28 03:42:45', '2022-07-28 03:42:45', '2023-07-28 09:12:45'),
('ab03ef8c6ee65a9ce4f52744315630f779259b4cd46964edcff8e5d96b26b0a70bacff169a6a315d', 24, 1, 'mentor', '[]', 0, '2022-06-30 22:40:00', '2022-06-30 22:40:00', '2023-07-01 04:10:00'),
('af9353ecbc79dd1d9de2a31216881f33c3c1ad9d6c5dd2a208c05f1de0b897071ffbd48411d7a452', 3, 1, 'mentor', '[]', 0, '2022-07-11 06:41:06', '2022-07-11 06:41:06', '2023-07-11 12:11:06'),
('afb2293578c15d0bd1230954dc7f42586251c4e80fb5c8ebcc830796d78a3f2dd5b8ede91f0acc61', 22, 1, 'mentor', '[]', 0, '2022-07-29 02:04:46', '2022-07-29 02:04:46', '2023-07-29 07:34:46'),
('b4a50a635f8f3fd80f260827c17ce2aa4b2cd6e2339e92595ec361f7ed8d49ba12d07eb183a08acf', 2, 1, 'mentor', '[]', 0, '2022-06-17 06:55:47', '2022-06-17 06:55:47', '2023-06-17 12:25:47'),
('b5e125cca141fe860da55157e91b4239d98321c6fb8a5c765b374ce2e49fb1818c8a42516d243da9', 36, 1, 'mentor', '[]', 0, '2022-07-19 06:33:55', '2022-07-19 06:33:55', '2023-07-19 12:03:55'),
('b7c887d09880dd62d9fc5d337887f8a3e0a60e52607e42ec2bb71eaddef5c7253e48ab0453c60116', 7, 1, 'mentor', '[]', 0, '2022-06-23 05:30:48', '2022-06-23 05:30:48', '2023-06-23 11:00:48'),
('b83bc298110679ac0f8eb282a348bd77bac7c1c5008aae5922a361d4fa7fb5e5615a3aa1d6dbc235', 29, 1, 'mentor', '[]', 0, '2022-07-07 08:11:50', '2022-07-07 08:11:50', '2023-07-07 13:41:50'),
('baa6a403ccbdfb4b33b83ad0a69d51efa0012210202b14ae50ab630db442a8202990b021af676b11', 29, 1, 'mentor', '[]', 0, '2022-07-08 01:52:08', '2022-07-08 01:52:08', '2023-07-08 07:22:08'),
('bbef5e11a2839a7c5d1c686e27b374807014d0f95bc15cb92bd457f5ce9abbc36f91f543154a13fe', 30, 1, 'mentor', '[]', 0, '2022-07-07 07:21:04', '2022-07-07 07:21:04', '2023-07-07 12:51:04'),
('bc8c3dd24aa3d4423100da2f7ef56ca4c6d5ff2a70ea7e2c7fe336c570a55f236f89d770854be304', 40, 1, 'mentor', '[]', 0, '2022-07-19 06:35:22', '2022-07-19 06:35:22', '2023-07-19 12:05:22'),
('c1c3487bd6768c833524b23e69b1c9d27fe8e36081abc31897a72f8f743b2cb811c2b6deac98d703', 23, 1, 'mentor', '[]', 0, '2022-06-29 00:54:14', '2022-06-29 00:54:14', '2023-06-29 06:24:14'),
('c67305dc402716ba0565591f523eb14195a36ce7bf5aea7bf1c836e4bb08f438176e1889b4213d71', 6, 1, 'mentor', '[]', 0, '2022-06-23 03:48:54', '2022-06-23 03:48:54', '2023-06-23 09:18:54'),
('cc3d92befcd4ac737722256a6b408e8480635982023ddd11cf0b0545e55f7e543cf6c911a1ec5281', 3, 1, 'mentor', '[]', 0, '2022-06-23 07:38:12', '2022-06-23 07:38:12', '2023-06-23 13:08:12'),
('d0d30bf92efe927343747e6d253ec43f94a1346ab5ab22c8fdd6567ccde3d84c1b13e4e2fd0552dd', 2, 1, 'mentor', '[]', 1, '2022-06-17 05:25:09', '2022-06-17 05:25:09', '2023-06-17 10:55:09'),
('d15f2e78ee264637ceb819c4ba6b0f7a8358197bac1a31e397b450e36ffc023adf8806eab61098cd', 34, 1, 'mentor', '[]', 0, '2022-07-12 23:41:37', '2022-07-12 23:41:37', '2023-07-13 05:11:37'),
('e4aa7a843dc085b592005d5efc253d6b4779c9c8fe1adb47874bdf0943376b6bf898cb6abb3d9540', 2, 1, 'mentor', '[]', 0, '2022-06-22 22:57:53', '2022-06-22 22:57:53', '2023-06-23 04:27:53'),
('e642d4bbfa5c4873253568016f12231570cc26481d4fb67ab8c7c3f3ccddc476db42256ed59fdf56', 42, 1, 'mentor', '[]', 0, '2022-07-27 00:35:24', '2022-07-27 00:35:24', '2023-07-27 06:05:24'),
('ea764e1e4d894379c8ab2f8c0186bfe676b539545a8a5b99663a6a9a460014c25db451b90c843fee', 6, 1, 'mentor', '[]', 0, '2022-06-23 05:18:57', '2022-06-23 05:18:57', '2023-06-23 10:48:57'),
('ece34089aef42f2621987f6fc250998b8262580c0733dc180e17dc962b7c39f6b93a07582c542062', 33, 1, 'mentor', '[]', 0, '2022-07-11 01:55:56', '2022-07-11 01:55:56', '2023-07-11 07:25:56'),
('eee8cea0323c4ee52b6f0025abbcefab2635ab075f21846eb613806c172b49835dbc74c6031f9398', 23, 1, 'mentor', '[]', 0, '2022-06-29 01:36:16', '2022-06-29 01:36:16', '2023-06-29 07:06:16'),
('f44846e620f7a003c8b7f4c9aaf485fd3ee25799abcde983310d699ae48974da42ab7effa92d7f77', 12, 1, 'mentor', '[]', 0, '2022-06-23 07:49:31', '2022-06-23 07:49:31', '2023-06-23 13:19:31'),
('f4b3539d4e3c23b65a4c3cec49bd287dd4684f1fc7ca63089e81faf7c8be6d4b2fa298173a526d9e', 21, 1, 'mentor', '[]', 1, '2022-06-28 23:52:26', '2022-06-28 23:52:26', '2023-06-29 05:22:26'),
('f4c57ff545b33d986fefb24573d9c8b82c8c9df4dac74ea0c52bced1638772373a8e384eb5aef40c', 23, 1, 'mentor', '[]', 0, '2022-06-28 23:55:48', '2022-06-28 23:55:48', '2023-06-29 05:25:48'),
('f504e45a3de9cb19267b004516186ce3577af0e9a1d352e0dd7a5b1b193dc803f534abb616abb6de', 29, 1, 'mentor', '[]', 0, '2022-07-07 23:47:05', '2022-07-07 23:47:05', '2023-07-08 05:17:05'),
('f54d060fac9f2c6f079287a60c559eb55eb84a1f5df522d0fe6d40438086db4bc852923c927fdce5', 41, 1, 'mentor', '[]', 0, '2022-07-19 07:07:08', '2022-07-19 07:07:08', '2023-07-19 12:37:08'),
('f74e6e765ce22f49339d8701843864abecdbc4415af4a92ebfd294b58ff6dd097bd8dafda5cbb492', 24, 1, 'mentor', '[]', 0, '2022-06-29 22:56:44', '2022-06-29 22:56:44', '2023-06-30 04:26:44'),
('fa6cae53a94e4c5d56a923cdae9644abfcc26fbe8e3ff759f24eecdd76f8c01ce1f0e56161a4d3d2', 29, 1, 'mentor', '[]', 0, '2022-07-08 02:01:53', '2022-07-08 02:01:53', '2023-07-08 07:31:53'),
('fa971652b1ee10b5eed29334c9532c2f9734042e25285b351c484999d433954622b17eb61ea6b97d', 45, 1, 'mentor', '[]', 0, '2022-07-27 05:04:02', '2022-07-27 05:04:02', '2023-07-27 10:34:02'),
('facd99b3de39b7e59e5ef43f401df4d92cbb17f8da33dbec91776437dee9417219dbf1ddbea2ad1d', 23, 1, 'mentor', '[]', 1, '2022-06-29 00:42:19', '2022-06-29 00:42:19', '2023-06-29 06:12:19'),
('ff5979202d18b73bdaa1cf28fdcd0d61882b98580b452bdd4219f16729e2d3adaf3b243df6e6574e', 1, 1, 'mentor', '[]', 0, '2022-06-23 07:37:35', '2022-06-23 07:37:35', '2023-06-23 13:07:35'),
('ffb4b35e3e8e6b6033cc59b481b9582b525a0da9abd6c37b1ba6b83a0bb2134c690ff78dac7574f9', 30, 1, 'mentor', '[]', 0, '2022-07-08 01:50:50', '2022-07-08 01:50:50', '2023-07-08 07:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'ftNuYM8Z3HO03RwDX067EyGpY7A4QPoY9uwTdv9O', NULL, 'http://localhost', 1, 0, 0, '2022-06-17 03:04:10', '2022-06-17 03:04:10'),
(2, NULL, 'Laravel Password Grant Client', 'Pg9wG4mKgU4neJtPi4u0rMZWGS1HL9QFzw7ImVqO', 'users', 'http://localhost', 0, 1, 0, '2022-06-17 03:04:10', '2022-06-17 03:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-06-17 03:04:10', '2022-06-17 03:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`, `updated_at`) VALUES
('shalinir.ait99@gmail.com', '$2y$10$KAcdzO7UrKE58caYRoueju7KxuHwtEWGFwszreAeGyhbi/NcvqmQi', '2022-07-29 05:25:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `postmedia`
--

CREATE TABLE `postmedia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `media_type_id` bigint(20) UNSIGNED NOT NULL,
  `media_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postmedia`
--

INSERT INTO `postmedia` (`id`, `post_id`, `media_type_id`, `media_url`, `media_thumbnail`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '1656925754.mp4', 's660646094.jpg', '2022-07-04 03:39:14', '2022-07-04 03:39:14'),
(2, 2, 3, '1656925768.mp3', 'audio.jpg', '2022-07-04 03:39:28', '2022-07-04 03:39:28'),
(3, 3, 1, '1656925777.jpg', '1656925777.jpg', '2022-07-04 03:39:37', '2022-07-04 03:39:37'),
(4, 5, 2, '1656926618.mp4', 's541062612.jpg', '2022-07-04 03:53:38', '2022-07-04 03:53:38'),
(5, 6, 2, '1656943416.mp4', 's718236826.jpg', '2022-07-04 08:33:36', '2022-07-04 08:33:36'),
(6, 7, 3, '1656943433.mp3', 'audio.jpg', '2022-07-04 08:33:53', '2022-07-04 08:33:53'),
(7, 8, 1, '1656943441.jpg', '1656943441.jpg', '2022-07-04 08:34:01', '2022-07-04 08:34:01'),
(8, 10, 1, '1657089011.jpg', '1657089011.jpg', '2022-07-06 01:00:11', '2022-07-06 01:00:11'),
(9, 11, 1, '1657170059.jpg', '1657170059.jpg', '2022-07-06 23:30:59', '2022-07-06 23:30:59'),
(10, 12, 1, '1657177037.jpg', '1657177037.jpg', '2022-07-07 01:27:17', '2022-07-07 01:27:17'),
(11, 14, 2, '1657194290.mp4', 's476376790.jpg', '2022-07-07 06:14:50', '2022-07-07 06:14:50'),
(12, 15, 2, '1657196891.mp4', 's901316326.jpg', '2022-07-07 06:58:11', '2022-07-07 06:58:11'),
(13, 16, 2, '1657198306.mp4', 's502494370.jpg', '2022-07-07 07:21:46', '2022-07-07 07:21:46'),
(14, 19, 2, '1657202313.mp4', 's545705100.jpg', '2022-07-07 08:28:33', '2022-07-07 08:28:33'),
(15, 20, 2, '1657202467.mp4', 's481524103.jpg', '2022-07-07 08:31:07', '2022-07-07 08:31:07'),
(16, 22, 2, '1657278793.mp4', 's700126077.jpg', '2022-07-08 05:43:13', '2022-07-08 05:43:13'),
(17, 23, 2, '1657280623.mp4', 's840115965.jpg', '2022-07-08 06:13:43', '2022-07-08 06:13:43'),
(18, 24, 2, '1657282990.mp4', 's136882654.jpg', '2022-07-08 06:53:10', '2022-07-08 06:53:10'),
(19, 25, 3, '1657283027.mp3', 'audio.jpg', '2022-07-08 06:53:47', '2022-07-08 06:53:47'),
(20, 26, 1, '1658232431.jpg', '1658232431.jpg', '2022-07-19 06:37:11', '2022-07-19 06:37:11'),
(21, 29, 1, '1658232634.jpg', '1658232634.jpg', '2022-07-19 06:40:34', '2022-07-19 06:40:34'),
(22, 30, 1, '1658232645.jpg', '1658232645.jpg', '2022-07-19 06:40:45', '2022-07-19 06:40:45'),
(23, 33, 1, '1658232930.jpg', '1658232930.jpg', '2022-07-19 06:45:30', '2022-07-19 06:45:30'),
(24, 33, 1, '1658232930.jpg', '1658232930.jpg', '2022-07-19 06:45:30', '2022-07-19 06:45:30'),
(25, 34, 1, '1658232951.jpg', '1658232951.jpg', '2022-07-19 06:45:51', '2022-07-19 06:45:51'),
(26, 34, 1, '1658232951.jpg', '1658232951.jpg', '2022-07-19 06:45:51', '2022-07-19 06:45:51'),
(27, 35, 1, '1658232996.jpg', '1658232996.jpg', '2022-07-19 06:46:36', '2022-07-19 06:46:36'),
(28, 36, 1, '1658233046.jpg', '1658233046.jpg', '2022-07-19 06:47:26', '2022-07-19 06:47:26'),
(29, 37, 1, '1658233154.jpg', '1658233154.jpg', '2022-07-19 06:49:14', '2022-07-19 06:49:14'),
(30, 38, 1, '1658233246.jpg', '1658233246.jpg', '2022-07-19 06:50:46', '2022-07-19 06:50:46'),
(31, 41, 1, '1658233417.jpg', '1658233417.jpg', '2022-07-19 06:53:37', '2022-07-19 06:53:37'),
(32, 42, 1, '1658234258.jpg', '1658234258.jpg', '2022-07-19 07:07:38', '2022-07-19 07:07:38'),
(33, 44, 2, '1658234513.mp4', 's382068514.jpg', '2022-07-19 07:11:54', '2022-07-19 07:11:54'),
(34, 45, 2, '1658239532.mp4', 's116095797.jpg', '2022-07-19 08:35:32', '2022-07-19 08:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted_by_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `post_type_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qualification` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_min` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_max` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `comment`, `posted_by_id`, `company_id`, `post_type_id`, `qualification`, `experience`, `salary_min`, `salary_max`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', 'test', 24, 11, '1', NULL, NULL, NULL, NULL, '2022-07-04 03:39:14', '2022-07-04 03:39:14', NULL),
(2, 'test', 'test', 24, 11, '1', NULL, NULL, NULL, NULL, '2022-07-04 03:39:28', '2022-07-04 03:39:28', NULL),
(3, 'test', 'test', 24, 11, '1', NULL, NULL, NULL, NULL, '2022-07-04 03:39:37', '2022-07-04 03:39:37', NULL),
(4, 'test', 'test', 24, 11, '2', 'BE', '1 year', '19k', '25k', '2022-07-04 03:40:21', '2022-07-04 03:40:21', NULL),
(5, 'test', 'test', 24, 11, '1', NULL, NULL, NULL, NULL, '2022-07-04 03:53:38', '2022-07-04 03:53:38', NULL),
(6, 'test', 'test', 24, 11, '1', NULL, NULL, NULL, NULL, '2022-07-04 08:33:36', '2022-07-04 08:33:36', NULL),
(7, 'test', 'test', 24, 11, '1', NULL, NULL, NULL, NULL, '2022-07-04 08:33:53', '2022-07-04 08:33:53', NULL),
(8, 'test', 'test', 24, 11, '1', NULL, NULL, NULL, NULL, '2022-07-04 08:34:01', '2022-07-04 08:34:01', NULL),
(9, 'wte', 'ghgh', 24, 8, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-06 00:59:49', '2022-07-06 00:59:49', NULL),
(10, 'wte', 'ghgh', 24, 8, '1', NULL, NULL, NULL, NULL, '2022-07-06 01:00:11', '2022-07-06 01:00:11', NULL),
(11, 'wte', 'ghgh', 24, 8, '1', NULL, NULL, NULL, NULL, '2022-07-06 23:30:59', '2022-07-06 23:30:59', NULL),
(12, 'wte', 'ghgh', 24, 8, '1', NULL, NULL, NULL, NULL, '2022-07-07 01:27:17', '2022-07-07 01:27:17', NULL),
(13, 'wte', 'ghgh', 29, 1, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-07 06:14:35', '2022-07-07 06:14:35', NULL),
(14, 'wte', 'ghgh', 29, 1, '1', NULL, NULL, NULL, NULL, '2022-07-07 06:14:50', '2022-07-07 06:14:50', NULL),
(15, 'wte', 'ghgh', 29, 1, '1', NULL, NULL, NULL, NULL, '2022-07-07 06:58:11', '2022-07-07 06:58:11', NULL),
(16, 'wte', 'ghgh', 30, 2, '1', NULL, NULL, NULL, NULL, '2022-07-07 07:21:46', '2022-07-07 07:21:46', NULL),
(17, 'wte', 'ghgh', 30, 2, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-07 07:21:58', '2022-07-07 07:21:58', NULL),
(18, 'wte', 'ghgh', 30, 2, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-07 08:28:21', '2022-07-07 08:28:21', NULL),
(19, 'wte', 'ghgh', 30, 6, '1', NULL, NULL, NULL, NULL, '2022-07-07 08:28:33', '2022-07-07 08:28:33', NULL),
(20, 'wte', 'ghgh', 30, 2, '1', NULL, NULL, NULL, NULL, '2022-07-07 08:31:07', '2022-07-07 08:31:07', NULL),
(21, 'wte', 'ghgh', 30, 6, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-07 08:31:18', '2022-07-07 08:31:18', NULL),
(22, 'wte', 'ghgh', 30, 8, '1', NULL, NULL, NULL, NULL, '2022-07-08 05:43:13', '2022-07-08 05:43:13', NULL),
(23, 'wte', 'ghgh', 32, 9, '1', NULL, NULL, NULL, NULL, '2022-07-08 06:13:43', '2022-07-08 06:13:43', NULL),
(24, 'wte', 'ghgh', 32, 9, '1', NULL, NULL, NULL, NULL, '2022-07-08 06:53:10', '2022-07-08 06:53:10', NULL),
(25, 'wte', 'ghgh', 32, 9, '1', NULL, NULL, NULL, NULL, '2022-07-08 06:53:47', '2022-07-08 06:53:47', NULL),
(26, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:37:11', '2022-07-19 06:37:11', NULL),
(27, 'wte', 'ghgh', 40, 11, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-19 06:38:26', '2022-07-19 06:38:26', NULL),
(28, 'wte', 'ghgh', 40, 11, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-19 06:39:11', '2022-07-19 06:39:11', NULL),
(29, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:40:34', '2022-07-19 06:40:34', NULL),
(30, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:40:45', '2022-07-19 06:40:45', NULL),
(33, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:45:30', '2022-07-19 06:45:30', NULL),
(34, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:45:51', '2022-07-19 06:45:51', NULL),
(35, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:46:36', '2022-07-19 06:46:36', NULL),
(36, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:47:26', '2022-07-19 06:47:26', NULL),
(37, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:49:14', '2022-07-19 06:49:14', NULL),
(38, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:50:46', '2022-07-19 06:50:46', NULL),
(39, 'wte', 'ghgh', 40, 11, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-19 06:51:19', '2022-07-19 06:51:19', NULL),
(40, 'wte', 'ghgh', 40, 11, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-19 06:53:02', '2022-07-19 06:53:02', NULL),
(41, 'wte', 'ghgh', 40, 11, '1', NULL, NULL, NULL, NULL, '2022-07-19 06:53:37', '2022-07-19 06:53:37', NULL),
(42, 'wte', 'ghgh', 41, 12, '1', NULL, NULL, NULL, NULL, '2022-07-19 07:07:38', '2022-07-19 07:07:38', NULL),
(43, 'wte', 'ghgh', 41, 12, '2', 'jmhj', '1 year', '10k', '20k', '2022-07-19 07:07:50', '2022-07-19 07:07:50', NULL),
(44, 'wte', 'ghgh', 41, 12, '1', NULL, NULL, NULL, NULL, '2022-07-19 07:11:54', '2022-07-19 07:11:54', NULL),
(45, 'wte', 'ghgh', 41, 12, '1', NULL, NULL, NULL, NULL, '2022-07-19 08:35:32', '2022-07-19 08:35:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posttypes`
--

CREATE TABLE `posttypes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posttypes`
--

INSERT INTO `posttypes` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Post', '2022-06-17 02:21:11', '2022-06-17 02:21:11'),
(2, 'Job', '2022-06-17 02:21:11', '2022-06-17 02:21:11');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `emotion_id` bigint(20) UNSIGNED NOT NULL,
  `question_association_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `question`, `created_by`, `created_at`, `updated_at`, `category_id`, `emotion_id`, `question_association_id`) VALUES
(1, 'what?', 3, '2022-05-19 07:44:49', '2022-05-19 07:44:49', 2, 3, 3),
(2, 'what?', 23, '2022-06-29 02:32:29', '2022-06-29 02:32:29', 1, 2, 2),
(3, 'what?', 23, '2022-06-29 08:40:33', '2022-06-29 08:40:33', 1, 2, 2),
(4, 'why?', 34, '2022-07-12 01:20:02', '2022-07-12 01:20:02', 1, 2, 2),
(5, 'hii', 35, '2022-07-13 02:15:33', '2022-07-13 02:15:33', 1, 2, 2),
(6, 'hlo', 42, '2022-07-20 08:17:20', '2022-07-20 08:17:20', 1, 2, 2),
(7, 'why?', 42, '2022-07-20 08:29:47', '2022-07-20 08:29:47', 1, 2, 2),
(8, 'Mentor?', 34, '2022-07-27 06:54:32', '2022-07-27 06:54:32', 1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `question_associations`
--

CREATE TABLE `question_associations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_association` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_associations`
--

INSERT INTO `question_associations` (`id`, `question_association`, `created_at`, `updated_at`) VALUES
(1, 'product', NULL, NULL),
(2, 'people', NULL, NULL),
(3, 'operations', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ranking_lists`
--

CREATE TABLE `ranking_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `points` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reasons` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ranking_lists`
--

INSERT INTO `ranking_lists` (`id`, `user_id`, `points`, `reasons`, `created_at`, `updated_at`) VALUES
(1, 41, '10', 'Registered', '2022-07-19 07:07:02', '2022-07-19 07:07:02'),
(2, 41, '25', 'Company', '2022-07-19 07:07:26', '2022-07-19 07:07:26'),
(3, 1, '5', 'Post', '2022-07-19 07:07:38', '2022-07-19 07:07:38'),
(4, 31, '10', 'Job_Post', '2022-07-19 07:07:50', '2022-07-19 07:07:50'),
(5, 26, '15', 'Answered', '2022-07-19 07:08:05', '2022-07-19 07:08:05'),
(6, 21, '15', 'Post', '2022-07-19 07:11:54', '2022-07-19 07:11:54'),
(7, 40, '15', 'Answered', '2022-07-19 07:39:12', '2022-07-19 07:39:12'),
(8, 41, '15', 'Answered', '2022-07-19 08:35:30', '2022-07-19 08:35:30'),
(9, 41, '5', 'Post', '2022-07-19 08:35:32', '2022-07-19 08:35:32'),
(10, 42, '10', 'Registered', '2022-07-20 08:09:16', '2022-07-20 08:09:16'),
(11, 42, '10', 'Question', '2022-07-20 08:17:20', '2022-07-20 08:17:20'),
(12, 43, '10', 'Registered', '2022-07-20 08:18:14', '2022-07-20 08:18:14'),
(13, 42, '10', 'Question', '2022-07-20 08:29:47', '2022-07-20 08:29:47'),
(14, 30, '15', 'Answered', NULL, NULL),
(32, 32, '10', 'Registered', NULL, NULL),
(33, 33, '25', 'Company', NULL, NULL),
(34, 44, '10', 'Registered', '2022-07-27 00:58:04', '2022-07-27 00:58:04'),
(35, 44, '25', 'Company', '2022-07-27 00:59:58', '2022-07-27 00:59:58'),
(36, 45, '10', 'Registered', '2022-07-27 05:03:19', '2022-07-27 05:03:19'),
(37, 34, '15', 'Question', '2022-07-27 06:54:32', '2022-07-27 06:54:32'),
(38, 45, '25', 'Company', '2022-07-28 03:43:36', '2022-07-28 03:43:36'),
(39, 46, '10', 'Registered', '2022-07-28 05:00:15', '2022-07-28 05:00:15'),
(40, 47, '10', 'Registered', '2022-07-28 05:03:22', '2022-07-28 05:03:22'),
(41, 47, '25', 'Company', '2022-07-28 05:04:32', '2022-07-28 05:04:32'),
(42, 48, '10', 'Registered', '2022-07-28 05:22:12', '2022-07-28 05:22:12'),
(43, 49, '10', 'Registered', '2022-07-28 08:34:18', '2022-07-28 08:34:18'),
(44, 50, '10', 'Registered', '2022-07-28 23:59:24', '2022-07-28 23:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reactions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `reactions`, `created_at`, `updated_at`) VALUES
(1, 'like', NULL, NULL),
(2, 'heart', NULL, NULL),
(3, 'smiley', NULL, NULL),
(4, 'clap', NULL, NULL),
(5, 'brilliant', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `top_keywords`
--

CREATE TABLE `top_keywords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `top_keywords`
--

INSERT INTO `top_keywords` (`id`, `keywords`, `created_at`, `updated_at`) VALUES
(1, 'product', NULL, NULL),
(2, 'surgeon', NULL, NULL),
(3, 'inspired', NULL, NULL),
(4, 'people', NULL, NULL),
(5, 'happy', NULL, NULL),
(6, 'nurse', NULL, NULL),
(7, 'curious', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `up_votes`
--

CREATE TABLE `up_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `upvote_by` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `up_votes`
--

INSERT INTO `up_votes` (`id`, `question_id`, `upvote_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 24, '1', '2022-07-28 00:11:29', '2022-07-28 00:11:29'),
(2, 1, 45, '1', '2022-07-28 00:12:33', '2022-07-28 00:12:33'),
(3, 2, 24, '1', '2022-07-28 00:13:08', '2022-07-28 00:13:08'),
(7, 2, 45, '1', '2022-07-28 00:14:05', '2022-07-28 00:14:05'),
(8, 2, 44, '1', '2022-07-28 00:15:12', '2022-07-28 00:15:12'),
(9, 3, 45, '1', '2022-07-29 01:52:07', '2022-07-29 01:52:07');

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `experience` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommandations` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`id`, `user_id`, `photo`, `title`, `about`, `experience`, `location`, `causes`, `recommandations`, `created_at`, `updated_at`) VALUES
(3, 22, '1654588925.jpg', 'tst', 'testnew', '2 years', 'cbe', NULL, NULL, '2022-06-23 07:37:52', '2022-06-23 07:37:52'),
(4, 3, '1656483635.jpg', 'test', 'test new', '1 year', 'Coimbatore', NULL, NULL, '2022-06-23 07:38:22', '2022-06-29 00:50:35'),
(9, 20, '1654588925.jpg', 'testtt', 'test neww', '2 years', 'Coimbatoreeee', NULL, NULL, '2022-06-23 07:50:54', '2022-06-28 06:38:38'),
(12, 18, '1656746754.jpg', 'teytwe', 'ererw', '2 years', 'cdedw', NULL, NULL, '2022-06-28 06:47:16', '2022-07-02 01:55:54'),
(14, 29, '1656487199.jpg', 'erert', 'rtrreeee', '1 year', 'Coimbatoreeee', NULL, NULL, '2022-06-28 08:32:42', '2022-06-29 01:49:59'),
(15, 23, '1656487380.jpg', 'fefew', 'efef', '2years', 'ddf', NULL, NULL, '2022-06-28 23:57:53', '2022-06-29 01:53:00'),
(16, 24, '1657608831.jpg', 'vbbg', 'vcbgb', '1', 'fgt', NULL, NULL, '2022-06-29 08:39:53', '2022-07-12 01:23:51'),
(17, 26, '1656749350.jpg', 'cvcv', 'gdfgf', 'gfhgj', 'gfhgfj', NULL, NULL, '2022-07-02 02:39:10', '2022-07-02 02:39:10'),
(18, 30, '1654588925.jpg', 'vbbg', 'vcbgb', '1 yaer', 'fgr', NULL, NULL, '2022-07-08 03:24:27', '2022-07-08 03:24:27'),
(19, 34, '1657608874.jpg', 'vbbg', 'vcbgb', '1', 'fgt', NULL, NULL, '2022-07-12 01:24:34', '2022-07-12 01:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `userrole`
--

CREATE TABLE `userrole` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userrole`
--

INSERT INTO `userrole` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Mentor', '2022-06-17 02:13:37', '2022-06-17 02:13:37'),
(2, 'Mentee', '2022-06-17 02:13:37', '2022-06-17 02:13:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userrole_id` bigint(20) UNSIGNED DEFAULT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonenumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fcm` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disclaimer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `userrole_id`, `firstname`, `lastname`, `phonenumber`, `fcm`, `disclaimer`, `token`, `is_verified`) VALUES
(1, NULL, 'shalini.ait@gmail.com', NULL, '$2y$10$rYcsgyzdIbATPc13K8wwTuxFbUTBI9yrkcO2FI0JipfA86DYHKSCC', NULL, '2022-06-23 01:55:04', '2022-06-23 07:37:35', 2, 'Shalini', 'Shalu', '9876543290', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', 'true', NULL, 0),
(3, NULL, 'shalinir@gmail.com', NULL, '$2y$10$5dNG/GR4qPxCgl/uFkTs..r.3XrvNNKc259YaO8SI1eBpdQ3iMyiO', NULL, '2022-06-23 01:56:17', '2022-07-12 00:34:48', 1, 'Shaliniii', 'shalu', '9876543209', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(9, NULL, 'shalinir.aitt99@gmail.com', NULL, '$2y$10$pyqhMRGvJ1ktdTG.YTOBieXv52PvwdJRX2/7dDNc3ml2wAUDHzsqC', NULL, '2022-06-23 06:50:42', '2022-06-28 06:38:38', 1, 'Shaliniii', 'sha', '9876543209', NULL, NULL, NULL, 0),
(18, NULL, 'ait12@gmail.com', NULL, '$2y$10$NlL4pfWcDt1GYt73KYwhE.x7gaar5Ne6YZjQRYmuyUpEJxxkQV24a', NULL, '2022-06-28 06:47:16', '2022-07-02 01:55:54', 1, 'testait', 'testn', '9876543209', NULL, NULL, NULL, 0),
(20, NULL, 'ait12345@gmail.com', NULL, '$2y$10$0knL/zz0vOSvPoDV6A8fK.4YkP2Jw57JDYgT0dNWJXwIndReMBUAW', NULL, '2022-06-28 08:32:42', '2022-06-29 01:49:59', 1, 'testt', 'ait', '9876543209', NULL, NULL, NULL, 0),
(21, NULL, 'testt.ait@gmail.com', NULL, '$2y$10$AcGLGbQ3VF5tO007w8lcdepxo6ahj25/ab4vGiT1M1okKFEs3FB/a', NULL, '2022-06-28 23:52:09', '2022-06-29 01:48:45', 1, 'Shalini', 'Shalu', '9876543201', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(22, NULL, 'shalini.r@aitechindia.com', NULL, '$2y$10$Q57EDw2CNIwMvbTTEHRquObAkakyIOy6Itwb9y7hcVpLkt2cFiamq', NULL, '2022-06-28 23:54:38', '2022-07-29 02:04:46', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(23, NULL, 'shalll.ait@gmail.com', NULL, '$2y$10$mj8QENE7PnMz8RQG1QZ1E.NU4kWxbE37Fbv6FwSTD4zzxZ7Pk2r7e', NULL, '2022-06-28 23:55:13', '2022-06-29 01:50:52', 2, 'Shalini', 'Shalu', '9876543288', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(24, NULL, 'shallu.ait@gmail.com', NULL, '$2y$10$q4gEicSq2weG/QP9MdfFH.revrfk4dOZ/89kBi2GMrJpoRdjDTDca', NULL, '2022-06-29 01:53:39', '2022-07-02 01:05:27', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(25, NULL, 'shalluuu.ait@gmail.com', NULL, '$2y$10$2UjQOUBiBkh4T2.CdFQ05eSdQ9WMr/B11skWBQZz8Qe8tqbfSn3ce', NULL, '2022-06-30 07:25:28', '2022-06-30 07:25:28', 1, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(26, NULL, 'shalini.aittttttt@gmail.com', NULL, '$2y$10$hM1F8xZ6XdsNbkS12BLN3.fXIui6DXIq8Q5Mz5yts5Td7zjvI5PEK', NULL, '2022-07-02 02:39:10', '2022-07-02 02:39:10', 2, 'fdxfg', 'ghfg', NULL, NULL, NULL, NULL, 0),
(27, NULL, 'testtt.ait@gmail.com', NULL, '$2y$10$/x8TdSiPDL8oC1QJhkKpz.zP60m6wDCIaYACNuFUtyB42zp.WKTgi', NULL, '2022-07-05 07:37:43', '2022-07-05 07:37:43', 1, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(28, NULL, 'testtttt.ait@gmail.com', NULL, '$2y$10$1YCl.xVyu.IuBLzlvPiNze6rhzHDAHURRd5H.P84kV67pLQHNp9b2', NULL, '2022-07-06 08:26:14', '2022-07-06 08:26:14', 1, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(29, NULL, 'test.ait.ait@gmail.com', NULL, '$2y$10$DoXyPil5ca86suw06nw3oOqqjFzOsXvo9qI6MEhmM3wIimUZ09Kq.', NULL, '2022-07-07 05:34:02', '2022-07-08 02:01:53', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(30, NULL, 'test.ait.aitech@gmail.com', NULL, '$2y$10$9MMzidQvNKTJz.WuxINO3.8KOU6gvGcFHCCf.LW.jTdnPSzDy7/96', NULL, '2022-07-07 07:20:56', '2022-07-08 03:13:01', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(31, NULL, 'test.ait.aitechindia@gmail.com', NULL, '$2y$10$sJPTWOdNlxTylxPFXiHV/OORXEPoR7Jz2/0ZJdn1ENjW3rAtG0lPC', NULL, '2022-07-08 02:09:26', '2022-07-08 02:09:35', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(32, NULL, 'test.ait.aitechindiaa@gmail.com', NULL, '$2y$10$TuqAAD4/X4VTj.fdXc6iXupIODwvhE1IhGMwlZMtZ6OFNeH7yP3ky', NULL, '2022-07-08 06:12:51', '2022-07-08 06:13:00', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(33, NULL, 'test.ait.aitechindiaaa@gmail.com', NULL, '$2y$10$ZYoe4OxWtvY.42TNdryJHOJIhGWAFLztX.fnOrgOjzdhBljMQqwom', NULL, '2022-07-08 08:35:16', '2022-07-11 01:55:56', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(34, NULL, 'test.aitechindia@gmail.com', NULL, '$2y$10$7n3uXq4dOhrzwtfvWGgP..Y6zka1wgE/PoVm0XZ8Lfebu9P4nJXQm', NULL, '2022-07-12 01:18:05', '2022-07-12 23:41:37', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(35, NULL, 'test.aitechiindia@gmail.com', NULL, '$2y$10$zksfub0YxlXOZJ2jbizFEugLGuBmrvRkwATFbBV42/YcTAl3KmS9W', NULL, '2022-07-13 01:41:59', '2022-07-17 22:45:41', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(36, NULL, 'test.aitechiindiaa@gmail.com', NULL, '$2y$10$AOo4AIhp76pe1Ye/KCGLduVkTTB7TAZU7b/h12DYKX9iEKUCgb1Ya', NULL, '2022-07-19 03:21:46', '2022-07-19 06:33:55', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(37, NULL, 'test.ait@gmail.com', NULL, '$2y$10$7Z4Fclb0YkfrxO6s5qgqsuk6B0QWtcvSPjEN7vClSXVCiG3t3pTU.', NULL, '2022-07-19 06:16:12', '2022-07-29 02:04:03', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(38, NULL, 'test.aitechiindiaaaa@gmail.com', NULL, '$2y$10$vCYSsyKBiuZretKJ.45VGujp9ILzd.O98WAK28KAt7FGE0vimdZHq', NULL, '2022-07-19 06:18:05', '2022-07-19 06:18:05', 1, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(39, NULL, 'test.aitechiindiaaaaa@gmail.com', NULL, '$2y$10$8TzrZI/t5bPl6bzWC.FQSu4FRBdIJ5kCVfpalUCNRFYA9QdC9oSK2', NULL, '2022-07-19 06:18:37', '2022-07-19 06:18:37', 1, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(40, NULL, 'test.aitechiindiaaaaaa@gmail.com', NULL, '$2y$10$gbkncewzUhzDz2ZB7R9cGuk0AuZ5MAbY0eE4nPgohwNeTZ6CDhVha', NULL, '2022-07-19 06:19:14', '2022-07-19 06:35:22', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(41, NULL, 'test.aitechiin@gmail.com', NULL, '$2y$10$O38kJuA24R9D5JWUFTiMOezidGHdCzs0VJC5l7vNgQ3iLYxP3PpWG', NULL, '2022-07-19 07:07:02', '2022-07-19 07:07:08', 1, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(42, NULL, 'test.aitechiinn@gmail.com', NULL, '$2y$10$MQWm2z9H0DmsO9m9zxj1b.Jo1WZfZpxb3Vm6CQVwNzWx9gniE2W9.', NULL, '2022-07-20 08:09:16', '2022-07-27 05:01:28', 2, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(43, NULL, 'test.aitechiinnn@gmail.com', NULL, '$2y$10$FTnALOy3PYTC9yY2ObSdKeceIWtMiglfNnFTXz.dGTseE7bp1XYvW', NULL, '2022-07-20 08:18:14', '2022-07-20 08:18:14', 2, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(44, NULL, 'shalinir.ait99@gmail.com', NULL, '$2y$10$poNcI0Vt2MJ2/mfwHZLcleQ1AwrPJTPgyFEtU/VgLLjM5YyM9dyTm', NULL, '2022-07-27 00:58:04', '2022-07-29 06:01:59', 2, 'Shalini', 'Shal', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, '', 1),
(45, NULL, 'test.aitechiinnndiaa@gmail.com', NULL, '$2y$10$UoLxowjhLUcmNiFwhpRw9e1Q8PbfnOTFnFfvwPUIgnIme8gfVcO/m', NULL, '2022-07-27 05:03:19', '2022-07-28 03:42:45', 2, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(46, NULL, 'krishna.ait99@gmail.com', NULL, '$2y$10$0gdQCY3tJEKPv26xqTfmH.GF673pK14xZgRKI2LH422U4bBrzgkva', NULL, '2022-07-28 05:00:15', '2022-07-28 05:00:15', 2, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(47, NULL, 'krishna.sri.ait99@gmail.com', NULL, '$2y$10$mErt.8L3kPApdrbaEWbJE.dF7Bw6F/fbXKS6hnIZzMOxi1tmebxwi', NULL, '2022-07-28 05:03:22', '2022-07-28 05:04:15', 2, 'Shalini', 'Shalu', NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz', NULL, NULL, 0),
(48, NULL, 'krishnasrii.ait99@gmail.com', NULL, '$2y$10$Loge.uSnd6oErixbCzpzr.7ArEz4FR/4NFoQe1GdugryLc.s.MFmW', NULL, '2022-07-28 05:22:12', '2022-07-28 05:22:12', 2, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(49, NULL, 'krishnasri.ait99@gmail.com', NULL, '$2y$10$VnIL/zvuBYu568Z4.o3zQOHccTYJ8t2zI7lVhkvdIEAA4ecQ.eigu', NULL, '2022-07-28 08:34:18', '2022-07-28 08:34:18', 2, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0),
(50, NULL, 'krishh.ait99@gmail.com', NULL, '$2y$10$Dpwfz1zBttcdBrCb1sbh0e2B.aWW6nUS9DAxsl43aUTD8C3UW2z/u', NULL, '2022-07-28 23:59:24', '2022-07-28 23:59:24', 2, 'Shalini', 'Shalu', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_reactions`
--

CREATE TABLE `user_reactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `reaction_id` bigint(20) UNSIGNED NOT NULL,
  `reaction_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_reactions`
--

INSERT INTO `user_reactions` (`id`, `answer_id`, `reaction_id`, `reaction_by`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 24, '2022-07-27 06:34:23', '2022-07-27 07:53:34'),
(2, 3, 5, 24, '2022-07-27 06:35:16', '2022-07-27 07:52:55'),
(4, 6, 5, 24, '2022-07-27 22:59:49', '2022-07-27 22:59:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_answer_by_foreign` (`answer_by`),
  ADD KEY `answer_question_id_foreign` (`question_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_created_by_foreign` (`created_by`);

--
-- Indexes for table `company_mentor`
--
ALTER TABLE `company_mentor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_mentor_company_id_foreign` (`company_id`),
  ADD KEY `company_mentor_user_id_foreign` (`user_id`),
  ADD KEY `company_mentor_added_by_foreign` (`added_by`);

--
-- Indexes for table `company_verifies`
--
ALTER TABLE `company_verifies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emotions`
--
ALTER TABLE `emotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follows_mentor_id_foreign` (`mentor_id`),
  ADD KEY `follows_mentee_id_foreign` (`mentee_id`);

--
-- Indexes for table `invite_people`
--
ALTER TABLE `invite_people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediatypes`
--
ALTER TABLE `mediatypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `postmedia`
--
ALTER TABLE `postmedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postmedia_post_id_foreign` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_posted_by_id_foreign` (`posted_by_id`),
  ADD KEY `posts_company_id_foreign` (`company_id`);

--
-- Indexes for table `posttypes`
--
ALTER TABLE `posttypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_created_by_foreign` (`created_by`),
  ADD KEY `question_category_id_foreign` (`category_id`),
  ADD KEY `question_emotion_id_foreign` (`emotion_id`),
  ADD KEY `question_question_association_id_foreign` (`question_association_id`);

--
-- Indexes for table `question_associations`
--
ALTER TABLE `question_associations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ranking_lists`
--
ALTER TABLE `ranking_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_keywords`
--
ALTER TABLE `top_keywords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `up_votes`
--
ALTER TABLE `up_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `up_votes_question_id_foreign` (`question_id`),
  ADD KEY `up_votes_upvote_by_foreign` (`upvote_by`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userprofile_user_id_foreign` (`user_id`);

--
-- Indexes for table `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_userrole_id_foreign` (`userrole_id`);

--
-- Indexes for table `user_reactions`
--
ALTER TABLE `user_reactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_reactions_answer_id_foreign` (`answer_id`),
  ADD KEY `user_reactions_reaction_id_foreign` (`reaction_id`),
  ADD KEY `user_reactions_reaction_by_foreign` (`reaction_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `company_mentor`
--
ALTER TABLE `company_mentor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_verifies`
--
ALTER TABLE `company_verifies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emotions`
--
ALTER TABLE `emotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invite_people`
--
ALTER TABLE `invite_people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mediatypes`
--
ALTER TABLE `mediatypes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `postmedia`
--
ALTER TABLE `postmedia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `posttypes`
--
ALTER TABLE `posttypes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `question_associations`
--
ALTER TABLE `question_associations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ranking_lists`
--
ALTER TABLE `ranking_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `top_keywords`
--
ALTER TABLE `top_keywords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `up_votes`
--
ALTER TABLE `up_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `userrole`
--
ALTER TABLE `userrole`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user_reactions`
--
ALTER TABLE `user_reactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_answer_by_foreign` FOREIGN KEY (`answer_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `answer_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_mentor`
--
ALTER TABLE `company_mentor`
  ADD CONSTRAINT `company_mentor_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `company_mentor_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `company_mentor_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_mentee_id_foreign` FOREIGN KEY (`mentee_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `follows_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `postmedia`
--
ALTER TABLE `postmedia`
  ADD CONSTRAINT `postmedia_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_posted_by_id_foreign` FOREIGN KEY (`posted_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `question_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `question_emotion_id_foreign` FOREIGN KEY (`emotion_id`) REFERENCES `emotions` (`id`),
  ADD CONSTRAINT `question_question_association_id_foreign` FOREIGN KEY (`question_association_id`) REFERENCES `question_associations` (`id`);

--
-- Constraints for table `up_votes`
--
ALTER TABLE `up_votes`
  ADD CONSTRAINT `up_votes_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `up_votes_upvote_by_foreign` FOREIGN KEY (`upvote_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `userprofile`
--
ALTER TABLE `userprofile`
  ADD CONSTRAINT `userprofile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_userrole_id_foreign` FOREIGN KEY (`userrole_id`) REFERENCES `userrole` (`id`);

--
-- Constraints for table `user_reactions`
--
ALTER TABLE `user_reactions`
  ADD CONSTRAINT `user_reactions_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`),
  ADD CONSTRAINT `user_reactions_reaction_by_foreign` FOREIGN KEY (`reaction_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_reactions_reaction_id_foreign` FOREIGN KEY (`reaction_id`) REFERENCES `reactions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
