-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2016 at 11:12 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `meetrabbi`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) unsigned NOT NULL,
  `mentor_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `task` longtext COLLATE utf8_unicode_ci NOT NULL,
  `online_resource` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `followed_by` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL,
  `entity_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentees`
--

CREATE TABLE `mentees` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `institution` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `experience_level` int(11) NOT NULL,
  `is_a_student` int(11) NOT NULL,
  `organisation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentee_activities`
--

CREATE TABLE `mentee_activities` (
  `id` int(10) unsigned NOT NULL,
  `mentee_id` int(10) unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentee_interest_areas`
--

CREATE TABLE `mentee_interest_areas` (
  `id` int(10) unsigned NOT NULL,
  `mentee_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentee_programs`
--

CREATE TABLE `mentee_programs` (
  `id` int(10) unsigned NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `mentee_id` int(10) unsigned NOT NULL,
  `curriculum_id` int(10) unsigned NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentee_projects`
--

CREATE TABLE `mentee_projects` (
  `id` int(10) unsigned NOT NULL,
  `mentee_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentoring_objectives`
--

CREATE TABLE `mentoring_objectives` (
  `id` int(10) unsigned NOT NULL,
  `mentee_mentor_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentoring_requests`
--

CREATE TABLE `mentoring_requests` (
  `id` int(10) unsigned NOT NULL,
  `request_from` int(10) unsigned NOT NULL,
  `request_to` int(10) unsigned NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `relationship` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0 is for not yet accepted, 1 is for accepted',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentors`
--

CREATE TABLE `mentors` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `organisation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `office_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `current_position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `hours_per_week` int(11) NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `why_mentor` longtext COLLATE utf8_unicode_ci NOT NULL,
  `has_mentorship_experience` int(11) NOT NULL,
  `mentorship_experience_desc` longtext COLLATE utf8_unicode_ci NOT NULL,
  `video_url` text COLLATE utf8_unicode_ci NOT NULL,
  `website_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentors_expertise_areas`
--

CREATE TABLE `mentors_expertise_areas` (
  `id` int(10) unsigned NOT NULL,
  `mentor_id` int(10) unsigned NOT NULL,
  `expertise_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL,
  `years_of_experience` int(11) NOT NULL,
  `related_tags` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentors_mentees`
--

CREATE TABLE `mentors_mentees` (
  `id` int(10) unsigned NOT NULL,
  `mentor_id` int(10) unsigned NOT NULL,
  `mentee_id` int(10) unsigned NOT NULL,
  `mentoring_topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `mentoring_starts` datetime NOT NULL,
  `mentoring_ends` datetime NOT NULL,
  `contact_hours_per_week` int(11) NOT NULL,
  `contact_day` int(11) NOT NULL,
  `contact_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mentor_activities`
--

CREATE TABLE `mentor_activities` (
  `id` int(10) unsigned NOT NULL,
  `mentor_id` int(10) unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_09_19_071659_create_teams_table', 1),
('2015_09_19_071744_create_projects_table', 1),
('2015_09_19_071806_create_tasks_table', 1),
('2015_09_19_071817_create_reports_table', 1),
('2015_09_19_071836_create_images_table', 1),
('2015_09_19_071901_create_videos_table', 1),
('2015_09_19_074056_create_user_interests_table', 1),
('2015_09_26_130503_create_mentors_table', 1),
('2015_09_26_130519_create_mentees_table', 1),
('2015_09_26_141931_create_user_types_table', 1),
('2015_10_31_112237_add_columns_to_user_table', 2),
('2015_10_31_112257_add_columns_to_mentor_table', 2),
('2015_10_31_112303_add_columns_to_mentee_table', 3),
('2015_10_31_180635_create_area_of_interest_table', 3),
('2015_10_31_211905_create_mentor_area_of_expertise', 3),
('2015_11_02_203958_create_mentors_mentees', 4),
('2015_11_02_204029_create_mentee_activities', 4),
('2015_11_02_204043_create_mentor_activity_table', 4),
('2015_11_02_215355_create_mentoring_objective_table', 4),
('2015_11_07_204029_create_mentee_activities', 5),
('2015_11_07_204043_create_mentor_activity_table', 5),
('2015_11_26_200459_AddColumnToUserTable', 6),
('2015_12_23_190402_create_curriculum_table', 7),
('2015_12_23_200959_create_mentee_curriculum_table', 7),
('2015_12_23_201037_activities', 8),
('2015_12_23_201052_projects', 9),
('2015_12_23_201821_create_curriculum_activities_table', 9),
('2015_12_23_201946_create_mentee_projects_table', 10),
('2015_12_25_205818_add_foreign_keys_to_table', 11),
('2015_12_26_191046_create_follow_table', 12),
('2015_12_26_191058_create_mentoring_request_table', 12),
('2016_01_09_150121_add_constraints', 12),
('2016_01_09_151826_resources', 13),
('2016_01_09_155129_add_description_to_resource_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(10) unsigned NOT NULL,
  `mentor_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_activities`
--

CREATE TABLE `program_activities` (
  `id` int(10) unsigned NOT NULL,
  `program_id` int(10) unsigned NOT NULL,
  `curriculum_id` int(10) unsigned NOT NULL,
  `activity_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL,
  `mentor_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `background` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `online_resource` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) unsigned NOT NULL,
  `entity_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `has_image` int(11) NOT NULL,
  `has_video` int(11) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `resource_type_id` int(10) unsigned NOT NULL,
  `uri` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resource_types`
--

CREATE TABLE `resource_types` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `undertaken_by` int(11) NOT NULL,
  `has_image` int(11) NOT NULL,
  `has_video` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL,
  `created_by` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `default_mode` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `headline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `twitter_handle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `linkedin_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_a_mentor` int(10) NOT NULL DEFAULT '0' COMMENT '1 for true, 0 for false'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `status`, `default_mode`, `created_at`, `updated_at`, `about`, `headline`, `twitter_id`, `twitter_handle`, `facebook_id`, `facebook_name`, `linkedin_id`, `avatar_uri`, `deleted_at`, `provider`, `provider_id`, `name`, `is_a_mentor`) VALUES
(5, '', '', '', 'jideowosakin@gmail.com', '$2y$10$dV2tnEYInAJhmb1PYGHK/eaASJ7gDIae9fSXm1aC4uDGH27wlM11e', 'Mpk1OFsK5Z2HDV71epew2rmzNoAu48QCa6ejbM65jPrNwMGE1WHTxfZeZgvv', 1, 1, '2015-11-07 17:26:39', '2016-02-12 20:56:04', '', '', '', '', '', '', '1', 'https://media.licdn.com/mpr/mprx/0_tuG0AngbrX5PwAjm9mnAM3NbATd8ePmaYjslqi_QrB23D_yaBeNYs3NbPbBgI_D_ceV0K8cFMhsTmBf7R0FiJC9IphshmB4CR0Fp-_i6c37ukTiOBmlttcDcyv8rFB7Pty_1vAUrgp2', NULL, NULL, 'NNKY0VHuf9', 'Babajide Owosakin', 0),
(7, 'donMayor', 'Mayowa', 'Egbewunmi', 'mayowaegbewunmi@gmail.com', '$2y$10$m1HMrHUeIMobP4W1iNr6gOS2MEYuN71YcKEkWoWEQD/X4cMf03oQS', NULL, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, 0),
(9, '_jidesakin', '', '', NULL, '', 'lW6xgcoFKWYfEvRxuOPZf3uSpSwrSo2uVxKuysBQpyy4TO0Y6IGCm9GfHo2i', 0, 1, '2016-02-06 14:02:54', '2016-02-06 14:03:03', '', '', '', '', '', '', '', 'http://pbs.twimg.com/profile_images/652829397637025792/Z2a_EyFJ_normal.jpg', NULL, NULL, '344275421', 'Babajide Owosakin', 0),
(10, '', 'Babajide', 'Owosakin', 'jide@meetrabbi.com', '$2y$10$JdEPAMYcDYJF/0/Qa7wJdOENiyfqOrbfQzMCU8pxo7R4el7TLvsY6', 'szqTmklyoKeys45HzpgHkR9HVkVjc8YFk57P1xqH8PJCD8zcuOjLnTqf04hW', 0, 1, '2016-02-07 19:50:14', '2016-02-07 21:10:19', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(10) unsigned NOT NULL,
  `entity_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entity_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_mentor_id_foreign` (`mentor_id`),
  ADD KEY `activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follows_user_id_foreign` (`user_id`),
  ADD KEY `follows_followed_by_foreign` (`followed_by`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentees`
--
ALTER TABLE `mentees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentee_activities`
--
ALTER TABLE `mentee_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentee_activities_mentee_id_foreign` (`mentee_id`),
  ADD KEY `mentee_activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `mentee_interest_areas`
--
ALTER TABLE `mentee_interest_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentee_interest_areas_mentee_id_foreign` (`mentee_id`),
  ADD KEY `mentee_interest_areas_user_id_foreign` (`user_id`);

--
-- Indexes for table `mentee_programs`
--
ALTER TABLE `mentee_programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentee_curriculum_curriculum_id_foreign` (`curriculum_id`),
  ADD KEY `mentee_curriculum_user_id_foreign` (`user_id`) USING BTREE,
  ADD KEY `mentee_curriculum_mentee_id_foreign` (`mentee_id`) USING BTREE,
  ADD KEY `mentee_program_program_id_foreign` (`program_id`);

--
-- Indexes for table `mentee_projects`
--
ALTER TABLE `mentee_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentee_projects_mentee_id_foreign` (`mentee_id`),
  ADD KEY `mentee_projects_project_id_foreign` (`project_id`),
  ADD KEY `mentee_projects_user_id_foreign` (`user_id`);

--
-- Indexes for table `mentoring_objectives`
--
ALTER TABLE `mentoring_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentoring_objectives_mentee_mentor_id_foreign` (`mentee_mentor_id`);

--
-- Indexes for table `mentoring_requests`
--
ALTER TABLE `mentoring_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentoring_requests_request_from_foreign` (`request_from`),
  ADD KEY `mentoring_requests_request_to_foreign` (`request_to`);

--
-- Indexes for table `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentors_expertise_areas`
--
ALTER TABLE `mentors_expertise_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentors_expertise_areas_mentor_id_foreign` (`mentor_id`),
  ADD KEY `mentors_expertise_areas_user_id_foreign` (`user_id`);

--
-- Indexes for table `mentors_mentees`
--
ALTER TABLE `mentors_mentees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentors_mentees_mentor_id_foreign` (`mentor_id`),
  ADD KEY `mentors_mentees_mentee_id_foreign` (`mentee_id`);

--
-- Indexes for table `mentor_activities`
--
ALTER TABLE `mentor_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentor_activities_mentor_id_foreign` (`mentor_id`),
  ADD KEY `mentor_activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculums_mentor_id_foreign` (`mentor_id`),
  ADD KEY `curriculums_user_id_foreign` (`user_id`);

--
-- Indexes for table `program_activities`
--
ALTER TABLE `program_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculum_activities_curriculum_id_foreign` (`curriculum_id`),
  ADD KEY `curriculum_activities_activity_id_foreign` (`activity_id`),
  ADD KEY `program_activities_program_id_foreign` (`program_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_mentor_id_foreign` (`mentor_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resources_user_id_foreign` (`user_id`),
  ADD KEY `resources_resource_type_id_foreign` (`resource_type_id`);

--
-- Indexes for table `resource_types`
--
ALTER TABLE `resource_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resource_types_name_unique` (`name`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentees`
--
ALTER TABLE `mentees`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentee_activities`
--
ALTER TABLE `mentee_activities`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentee_interest_areas`
--
ALTER TABLE `mentee_interest_areas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentee_programs`
--
ALTER TABLE `mentee_programs`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentee_projects`
--
ALTER TABLE `mentee_projects`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentoring_objectives`
--
ALTER TABLE `mentoring_objectives`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentoring_requests`
--
ALTER TABLE `mentoring_requests`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentors`
--
ALTER TABLE `mentors`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentors_expertise_areas`
--
ALTER TABLE `mentors_expertise_areas`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentors_mentees`
--
ALTER TABLE `mentors_mentees`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mentor_activities`
--
ALTER TABLE `mentor_activities`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `program_activities`
--
ALTER TABLE `program_activities`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resource_types`
--
ALTER TABLE `resource_types`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_followed_by_foreign` FOREIGN KEY (`followed_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentee_activities`
--
ALTER TABLE `mentee_activities`
  ADD CONSTRAINT `mentee_activities_mentee_id_foreign` FOREIGN KEY (`mentee_id`) REFERENCES `mentees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentee_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentee_interest_areas`
--
ALTER TABLE `mentee_interest_areas`
  ADD CONSTRAINT `mentee_interest_areas_mentee_id_foreign` FOREIGN KEY (`mentee_id`) REFERENCES `mentees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentee_interest_areas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentee_programs`
--
ALTER TABLE `mentee_programs`
  ADD CONSTRAINT `mentee_curriculum_curriculum_id_foreign` FOREIGN KEY (`curriculum_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentee_curriculum_mentee_id_foreign` FOREIGN KEY (`mentee_id`) REFERENCES `mentees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentee_curriculum_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentee_program_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`);

--
-- Constraints for table `mentee_projects`
--
ALTER TABLE `mentee_projects`
  ADD CONSTRAINT `mentee_projects_mentee_id_foreign` FOREIGN KEY (`mentee_id`) REFERENCES `mentees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentee_projects_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentee_projects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentoring_objectives`
--
ALTER TABLE `mentoring_objectives`
  ADD CONSTRAINT `mentoring_objectives_mentee_mentor_id_foreign` FOREIGN KEY (`mentee_mentor_id`) REFERENCES `mentors_mentees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentoring_requests`
--
ALTER TABLE `mentoring_requests`
  ADD CONSTRAINT `mentoring_requests_request_from_foreign` FOREIGN KEY (`request_from`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentoring_requests_request_to_foreign` FOREIGN KEY (`request_to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentors_expertise_areas`
--
ALTER TABLE `mentors_expertise_areas`
  ADD CONSTRAINT `mentors_expertise_areas_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentors_expertise_areas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentors_mentees`
--
ALTER TABLE `mentors_mentees`
  ADD CONSTRAINT `mentors_mentees_mentee_id_foreign` FOREIGN KEY (`mentee_id`) REFERENCES `mentees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentors_mentees_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mentor_activities`
--
ALTER TABLE `mentor_activities`
  ADD CONSTRAINT `mentor_activities_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mentor_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `curriculums_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `curriculums_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_activities`
--
ALTER TABLE `program_activities`
  ADD CONSTRAINT `curriculum_activities_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `curriculum_activities_curriculum_id_foreign` FOREIGN KEY (`curriculum_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `program_activities_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_mentor_id_foreign` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_resource_type_id_foreign` FOREIGN KEY (`resource_type_id`) REFERENCES `resource_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resources_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
