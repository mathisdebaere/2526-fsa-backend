CREATE DATABASE zilverenschakel;
USE zilverenschakel;

-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysqldb
-- Gegenereerd op: 06 jun 2026 om 23:42
-- Serverversie: 8.4.9
-- PHP-versie: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel-project`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `municipality` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `house_number` int UNSIGNED DEFAULT NULL,
  `bus` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `advisors`
--

CREATE TABLE `advisors` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `advisors`
--

INSERT INTO `advisors` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-06-06 23:30:09', '2026-06-06 23:30:09');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('introduction','assistance') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time DEFAULT NULL,
  `location` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('planned','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planned',
  `volunteer_id` bigint UNSIGNED DEFAULT NULL,
  `advisor_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `help_request_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `appointment_notes`
--
-- Fout bij lezen van tabelstructuur van tabel laravel-project.appointment_notes: #1146 - Tabel &#039;laravel-project.appointment_notes&#039; bestaat niet
-- Fout bij het lezen van gegevens voor tabel laravel-project.appointment_notes: #1064 - Er is iets fout in de gebruikte syntax bij &#039;FROM `laravel-project`.`appointment_notes`&#039; in regel 1

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `availabilities`
--

CREATE TABLE `availabilities` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_of_day` enum('morning','afternoon','evening') COLLATE utf8mb4_unicode_ci NOT NULL,
  `volunteer_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `availabilities`
--

INSERT INTO `availabilities` (`id`, `date`, `time_of_day`, `volunteer_id`, `created_at`, `updated_at`) VALUES
(1, '2026-06-18', 'afternoon', 2, '2026-06-06 23:31:30', '2026-06-06 23:31:30');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clients`
--

CREATE TABLE `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `personal_description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('seeking help','not seeking') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'seeking help',
  `membership_active` tinyint(1) NOT NULL DEFAULT '0',
  `background_notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `clients`
--

INSERT INTO `clients` (`id`, `personal_description`, `status`, `membership_active`, `background_notes`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Ik ben Joris en ik geef backend vakskes op Odisee', 'seeking help', 1, NULL, 2, '2026-06-06 23:30:09', '2026-06-06 23:30:09'),
(2, 'Ik ben Bart en ik geef frontend vakskes op Odisee', 'seeking help', 1, NULL, 3, '2026-06-06 23:30:10', '2026-06-06 23:30:10');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `client_favorite_volunteers`
--

CREATE TABLE `client_favorite_volunteers` (
  `id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `volunteer_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `help_requests`
--

CREATE TABLE `help_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `extra_notes` text COLLATE utf8mb4_unicode_ci,
  `region` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `status` enum('open','matched','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `help_request_category_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `volunteer_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `help_requests`
--

INSERT INTO `help_requests` (`id`, `extra_notes`, `region`, `date`, `time`, `status`, `help_request_category_id`, `client_id`, `created_at`, `updated_at`, `volunteer_id`) VALUES
(1, 'Hulp nodig bij computerinstellingen.', 'Gent', '2026-06-09', '14:00:00', 'open', 1, 1, '2026-06-06 23:30:19', '2026-06-06 23:30:19', NULL),
(2, 'Begeleiding naar afspraak.', 'Gent', '2026-06-11', '10:00:00', 'open', 2, 1, '2026-06-06 23:30:19', '2026-06-06 23:30:19', NULL),
(3, 'Probleem met smartphone.', 'Brugge', '2026-06-13', '09:30:00', 'open', 1, 2, '2026-06-06 23:30:19', '2026-06-06 23:30:19', NULL),
(4, 'Hulp bij administratie.', 'Brugge', '2026-06-16', '15:00:00', 'open', 3, 2, '2026-06-06 23:30:19', '2026-06-06 23:30:19', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `help_request_categories`
--

CREATE TABLE `help_request_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `help_request_categories`
--

INSERT INTO `help_request_categories` (`id`, `name`, `description`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Vervoer', NULL, 'car', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(2, 'Boodschappen', NULL, 'shopping-cart', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(3, 'Gezelschap', NULL, 'users', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(4, 'Samen op stap', NULL, 'walking', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(5, 'Zorg voor huisdieren', NULL, 'paw', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(6, 'Hulp bij administratie', NULL, 'file-text', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(7, 'Klein tuinonderhoud', NULL, 'scissors', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(8, 'Kleine klusjes in huis', NULL, 'tool', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(9, 'Licht huishoudelijk werk', NULL, 'home', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(10, 'Koken', NULL, 'coffee', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(11, 'Oppas', NULL, 'heart', '2026-06-06 23:30:08', '2026-06-06 23:30:08'),
(12, 'Andere', NULL, 'more-horizontal', '2026-06-06 23:30:08', '2026-06-06 23:30:08');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `intakes`
--

CREATE TABLE `intakes` (
  `id` bigint UNSIGNED NOT NULL,
  `document_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','scheduled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `user_id` bigint UNSIGNED NOT NULL,
  `advisor_id` bigint UNSIGNED DEFAULT NULL,
  `appointment_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_10_140742_create_personal_access_tokens_table', 1),
(5, '2026_05_11_000001_create_addresses_table', 1),
(6, '2026_05_11_000002_create_clients_table', 1),
(7, '2026_05_11_000003_create_volunteers_table', 1),
(8, '2026_05_11_000004_create_advisors_table', 1),
(9, '2026_05_11_000005_create_help_request_categories_table', 1),
(10, '2026_05_11_000006_create_help_requests_table', 1),
(11, '2026_05_11_000007_create_appointments_table', 1),
(12, '2026_05_11_000009_create_intakes_table', 1),
(13, '2026_05_11_000010_create_availabilities_table', 1),
(14, '2026_05_11_000011_create_subscriptions_table', 1),
(15, '2026_05_11_000012_add_municipality_to_addresses_table', 1),
(16, '2026_05_11_000013_add_background_notes_to_clients_table', 1),
(17, '2026_05_29_000001_add_fields_to_help_requests_table', 1),
(18, '2026_05_29_000002_update_subscriptions_table', 1),
(19, '2026_05_29_000003_add_notes_to_intakes_table', 1),
(20, '2026_05_29_000004_create_volunteer_reviews_table', 1),
(21, '2026_05_31_000001_create_client_favorite_volunteers_table', 1),
(22, '2026_06_03_000001_create_volunteer_help_request_category_table', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', 'af7138afa151d86f3fc6fc511c9ef841856053c45eb19826fb8641952973cf47', '[\"*\"]', '2026-06-06 23:40:20', NULL, '2026-06-06 23:30:31', '2026-06-06 23:40:20'),
(2, 'App\\Models\\User', 5, 'auth_token', '67993fde615e38d618c2465beec3929a8fabdfe3a24e1271cd07655aac0db7cd', '[\"*\"]', '2026-06-06 23:40:24', NULL, '2026-06-06 23:31:09', '2026-06-06 23:40:24'),
(3, 'App\\Models\\User', 3, 'auth_token', '441e4ab5e90c761a864a3f4ac9348e8912adfec5bfec4d7d72e32bc82c9d2d09', '[\"*\"]', '2026-06-06 23:40:30', NULL, '2026-06-06 23:32:04', '2026-06-06 23:40:30');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `amount` decimal(6,2) NOT NULL DEFAULT '5.00',
  `paid_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','active','cancelled','expired') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `start_date`, `end_date`, `amount`, `paid_at`, `status`, `client_id`, `created_at`, `updated_at`) VALUES
(1, '2026-06-12', '2026-06-21', 5.00, '2026-06-06 23:32:20', 'active', 2, '2026-06-06 23:32:19', '2026-06-06 23:32:20');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('volunteer','client','advisor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `privacy_agreement` tinyint(1) NOT NULL DEFAULT '0',
  `privacy_agreement_timestamp` datetime DEFAULT NULL,
  `account_status` enum('waiting_for_interview','verified') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting_for_interview',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `date_of_birth`, `email`, `password`, `phone`, `profile_photo_url`, `role`, `privacy_agreement`, `privacy_agreement_timestamp`, `account_status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tine', 'Vandamme', NULL, 'tine@zilverenschakel.be', '$2y$12$ktb.bmMADBjiVJONDr95nuuMI//fU1lfpf72JrSvBxk1agaa0Bz9e', NULL, NULL, 'advisor', 1, NULL, 'verified', NULL, '2026-06-06 23:30:09', '2026-06-06 23:30:09'),
(2, 'Joris', 'Maervoet', NULL, 'joris@example.com', '$2y$12$dUKGaZU.B7CN8jAwRypBIuLePTTg9fD5RuWrGikyqNxBa35hFx1Fa', NULL, NULL, 'client', 1, NULL, 'verified', NULL, '2026-06-06 23:30:09', '2026-06-06 23:30:09'),
(3, 'Bart', 'Delrue', NULL, 'bart@example.com', '$2y$12$xHHjv2xpBioFbbMbPLD2TO2hxKnu780hd2x2RYwu/6BsmP3JYlt.u', NULL, NULL, 'client', 1, NULL, 'verified', NULL, '2026-06-06 23:30:10', '2026-06-06 23:30:10'),
(4, 'Mathis', 'De Baere', NULL, 'mathis@example.com', '$2y$12$V6LYxc7rVDkRfaXxHmKPVubc7rs9xWcXf1Er3sARV7n/EZziNaSpq', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:10', '2026-06-06 23:30:10'),
(5, 'Mattias', 'De Gaere', NULL, 'mattias@example.com', '$2y$12$PmK.bqrzrm7lm0Ipm2GjueGRzdsKzNB.SZOcA6C.nyuLxM9jkl4bO', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:11', '2026-06-06 23:30:11'),
(6, 'Smurf', '1', NULL, 'smurf1@example.com', '$2y$12$UKbOtI/7jMzzvBbDVyfhYuC1i9maEvi25GbXbEIQOzYUC.FDUewK2', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:11', '2026-06-06 23:30:11'),
(7, 'Smurf', '2', NULL, 'smurf2@example.com', '$2y$12$VrJWwkywQfnXUV0frXSQnOc33H9Oh.VMf92x1kWWu75Yp3Hwh7ZQa', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:12', '2026-06-06 23:30:12'),
(8, 'Smurf', '3', NULL, 'smurf3@example.com', '$2y$12$47dbezI7bbpayPuQU/9z0eFespkZup8Hx9/SytS7WRNncPEYVb88K', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:12', '2026-06-06 23:30:12'),
(9, 'Smurf', '4', NULL, 'smurf4@example.com', '$2y$12$iQNVtA7lm8a5ve.US7fPDueZ/dAWPmM64jxnFIr7/vMB5qQlrKqSm', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:13', '2026-06-06 23:30:13'),
(10, 'Smurf', '5', NULL, 'smurf5@example.com', '$2y$12$E0quEcl43wEJc2aQZrOyqeDvYRjuMiAppACcSszVkSnXty7WKgIlq', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:13', '2026-06-06 23:30:13'),
(11, 'Smurf', '6', NULL, 'smurf6@example.com', '$2y$12$2T4Q1isGHOGb1B7GmTp6Guoj0jgAtPSVwFxQIkn4YpufJV7as9hQ2', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:14', '2026-06-06 23:30:14'),
(12, 'Smurf', '7', NULL, 'smurf7@example.com', '$2y$12$F5qy8I6LY2wQVnVYGqNLhu/WZuA1t99e0yOgH0SNxQ4AsPKHuPxyq', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:14', '2026-06-06 23:30:14'),
(13, 'Smurf', '8', NULL, 'smurf8@example.com', '$2y$12$iQ7JkAWX9Ga0L6H8.AnE8u9fYXkMg6hmrjGvPVqIRMK6AJJcvyDnG', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(14, 'Smurf', '9', NULL, 'smurf9@example.com', '$2y$12$Enwd2Hcd9SZYoKJtadom0upCgkdw2tGc8iuNjQZunxQbw48MVuPSy', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(15, 'Smurf', '10', NULL, 'smurf10@example.com', '$2y$12$DebQ9mcMvwKr0bC58QkiVesA5KRY3jjYzLTiP6gAqRfalUckFtm1a', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(16, 'Smurf', '11', NULL, 'smurf11@example.com', '$2y$12$R9nY3Y5Wei9fAtNKRq0tqux9JrHYDxbDoziK2FzPkZ26u/om0uaeW', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(17, 'Smurf', '12', NULL, 'smurf12@example.com', '$2y$12$wPHBZGOtU7JLbqN.MN1U9uYoarAjsUjY5dCtiZR1143mCGO9ZJwLe', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(18, 'Smurf', '13', NULL, 'smurf13@example.com', '$2y$12$Vdb8yNVA11c7G3JwbcEcP.xIrwi2OPMAyyj02iNRHAZ/vioQwCzUK', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:16', '2026-06-06 23:30:16'),
(19, 'Smurf', '14', NULL, 'smurf14@example.com', '$2y$12$zJPSHFABEbAqBkFWea7vQeBlMJmQDGoJo9F5yEfsiViBfpAzubKB.', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:16', '2026-06-06 23:30:16'),
(20, 'Smurf', '15', NULL, 'smurf15@example.com', '$2y$12$szTRgFLqv//npbEq.sDDQ.0GY/DtddjX7MAbKPxld9tdlLPnyzvIe', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:17', '2026-06-06 23:30:17'),
(21, 'Smurf', '16', NULL, 'smurf16@example.com', '$2y$12$4SdsjtQ96HQH./OQcMw61.abS3O8o.cHaK0zbKgiIVT2kvQVZ3ZvS', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:17', '2026-06-06 23:30:17'),
(22, 'Smurf', '17', NULL, 'smurf17@example.com', '$2y$12$7J/OA9xt2Ofio.4jKG/WY.uH6UCCUVbl0k6.GIlQicDJTwkN1bMg6', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:18', '2026-06-06 23:30:18'),
(23, 'Smurf', '18', NULL, 'smurf18@example.com', '$2y$12$JTIrP0qC.jz7CGsLhm6nV.PAz6dRT.yc5MV.X30VFKY2GxPaIN/ga', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:18', '2026-06-06 23:30:18'),
(24, 'Smurf', '19', NULL, 'smurf19@example.com', '$2y$12$t3AO5xZGTIcJEcdkJq6u3O2qqHrH7DD9kSlze4PsuxO4U0LG30b42', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:19', '2026-06-06 23:30:19'),
(25, 'Smurf', '20', NULL, 'smurf20@example.com', '$2y$12$uiz0LoTqKTZFVMgc/yG5Oejep/z9LJ/Qq.li2K72lSTUY0HDEMREi', NULL, NULL, 'volunteer', 1, NULL, 'verified', NULL, '2026-06-06 23:30:19', '2026-06-06 23:30:19');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `volunteers`
--

CREATE TABLE `volunteers` (
  `id` bigint UNSIGNED NOT NULL,
  `personal_description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `volunteers`
--

INSERT INTO `volunteers` (`id`, `personal_description`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Vrijwilliger', 4, '2026-06-06 23:30:10', '2026-06-06 23:30:10'),
(2, 'Vrijwilliger', 5, '2026-06-06 23:30:11', '2026-06-06 23:30:11'),
(3, 'Smurf vrijwilliger 1', 6, '2026-06-06 23:30:11', '2026-06-06 23:30:11'),
(4, 'Smurf vrijwilliger 2', 7, '2026-06-06 23:30:12', '2026-06-06 23:30:12'),
(5, 'Smurf vrijwilliger 3', 8, '2026-06-06 23:30:12', '2026-06-06 23:30:12'),
(6, 'Smurf vrijwilliger 4', 9, '2026-06-06 23:30:13', '2026-06-06 23:30:13'),
(7, 'Smurf vrijwilliger 5', 10, '2026-06-06 23:30:13', '2026-06-06 23:30:13'),
(8, 'Smurf vrijwilliger 6', 11, '2026-06-06 23:30:14', '2026-06-06 23:30:14'),
(9, 'Smurf vrijwilliger 7', 12, '2026-06-06 23:30:14', '2026-06-06 23:30:14'),
(10, 'Smurf vrijwilliger 8', 13, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(11, 'Smurf vrijwilliger 9', 14, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(12, 'Smurf vrijwilliger 10', 15, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(13, 'Smurf vrijwilliger 11', 16, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(14, 'Smurf vrijwilliger 12', 17, '2026-06-06 23:30:15', '2026-06-06 23:30:15'),
(15, 'Smurf vrijwilliger 13', 18, '2026-06-06 23:30:16', '2026-06-06 23:30:16'),
(16, 'Smurf vrijwilliger 14', 19, '2026-06-06 23:30:16', '2026-06-06 23:30:16'),
(17, 'Smurf vrijwilliger 15', 20, '2026-06-06 23:30:17', '2026-06-06 23:30:17'),
(18, 'Smurf vrijwilliger 16', 21, '2026-06-06 23:30:17', '2026-06-06 23:30:17'),
(19, 'Smurf vrijwilliger 17', 22, '2026-06-06 23:30:18', '2026-06-06 23:30:18'),
(20, 'Smurf vrijwilliger 18', 23, '2026-06-06 23:30:18', '2026-06-06 23:30:18'),
(21, 'Smurf vrijwilliger 19', 24, '2026-06-06 23:30:19', '2026-06-06 23:30:19'),
(22, 'Smurf vrijwilliger 20', 25, '2026-06-06 23:30:19', '2026-06-06 23:30:19');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `volunteer_help_request_category`
--

CREATE TABLE `volunteer_help_request_category` (
  `volunteer_id` bigint UNSIGNED NOT NULL,
  `help_request_category_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `volunteer_help_request_category`
--

INSERT INTO `volunteer_help_request_category` (`volunteer_id`, `help_request_category_id`) VALUES
(2, 3),
(2, 6),
(2, 9);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `volunteer_reviews`
--

CREATE TABLE `volunteer_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `volunteer_id` bigint UNSIGNED NOT NULL,
  `client_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexen voor tabel `advisors`
--
ALTER TABLE `advisors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advisors_user_id_foreign` (`user_id`);

--
-- Indexen voor tabel `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_volunteer_id_foreign` (`volunteer_id`),
  ADD KEY `appointments_advisor_id_foreign` (`advisor_id`),
  ADD KEY `appointments_client_id_foreign` (`client_id`),
  ADD KEY `appointments_help_request_id_foreign` (`help_request_id`);

--
-- Indexen voor tabel `availabilities`
--
ALTER TABLE `availabilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `availabilities_volunteer_id_foreign` (`volunteer_id`);

--
-- Indexen voor tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexen voor tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexen voor tabel `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`);

--
-- Indexen voor tabel `client_favorite_volunteers`
--
ALTER TABLE `client_favorite_volunteers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_favorite_volunteers_client_id_volunteer_id_unique` (`client_id`,`volunteer_id`),
  ADD KEY `client_favorite_volunteers_volunteer_id_foreign` (`volunteer_id`);

--
-- Indexen voor tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexen voor tabel `help_requests`
--
ALTER TABLE `help_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `help_requests_help_request_category_id_foreign` (`help_request_category_id`),
  ADD KEY `help_requests_client_id_foreign` (`client_id`),
  ADD KEY `help_requests_volunteer_id_foreign` (`volunteer_id`);

--
-- Indexen voor tabel `help_request_categories`
--
ALTER TABLE `help_request_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `intakes`
--
ALTER TABLE `intakes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `intakes_user_id_foreign` (`user_id`),
  ADD KEY `intakes_advisor_id_foreign` (`advisor_id`),
  ADD KEY `intakes_appointment_id_foreign` (`appointment_id`);

--
-- Indexen voor tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexen voor tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexen voor tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexen voor tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexen voor tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_client_id_foreign` (`client_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexen voor tabel `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volunteers_user_id_foreign` (`user_id`);

--
-- Indexen voor tabel `volunteer_help_request_category`
--
ALTER TABLE `volunteer_help_request_category`
  ADD PRIMARY KEY (`volunteer_id`,`help_request_category_id`),
  ADD KEY `volunteer_help_request_category_help_request_category_id_foreign` (`help_request_category_id`);

--
-- Indexen voor tabel `volunteer_reviews`
--
ALTER TABLE `volunteer_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volunteer_reviews_appointment_id_foreign` (`appointment_id`),
  ADD KEY `volunteer_reviews_volunteer_id_foreign` (`volunteer_id`),
  ADD KEY `volunteer_reviews_client_id_foreign` (`client_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `advisors`
--
ALTER TABLE `advisors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `client_favorite_volunteers`
--
ALTER TABLE `client_favorite_volunteers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `help_requests`
--
ALTER TABLE `help_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `help_request_categories`
--
ALTER TABLE `help_request_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `intakes`
--
ALTER TABLE `intakes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT voor een tabel `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `volunteer_reviews`
--
ALTER TABLE `volunteer_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `advisors`
--
ALTER TABLE `advisors`
  ADD CONSTRAINT `advisors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_advisor_id_foreign` FOREIGN KEY (`advisor_id`) REFERENCES `advisors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_help_request_id_foreign` FOREIGN KEY (`help_request_id`) REFERENCES `help_requests` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `availabilities`
--
ALTER TABLE `availabilities`
  ADD CONSTRAINT `availabilities_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `client_favorite_volunteers`
--
ALTER TABLE `client_favorite_volunteers`
  ADD CONSTRAINT `client_favorite_volunteers_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `client_favorite_volunteers_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `help_requests`
--
ALTER TABLE `help_requests`
  ADD CONSTRAINT `help_requests_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `help_requests_help_request_category_id_foreign` FOREIGN KEY (`help_request_category_id`) REFERENCES `help_request_categories` (`id`),
  ADD CONSTRAINT `help_requests_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `intakes`
--
ALTER TABLE `intakes`
  ADD CONSTRAINT `intakes_advisor_id_foreign` FOREIGN KEY (`advisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `intakes_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `intakes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `volunteers`
--
ALTER TABLE `volunteers`
  ADD CONSTRAINT `volunteers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `volunteer_help_request_category`
--
ALTER TABLE `volunteer_help_request_category`
  ADD CONSTRAINT `volunteer_help_request_category_help_request_category_id_foreign` FOREIGN KEY (`help_request_category_id`) REFERENCES `help_request_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_help_request_category_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `volunteer_reviews`
--
ALTER TABLE `volunteer_reviews`
  ADD CONSTRAINT `volunteer_reviews_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_reviews_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_reviews_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
