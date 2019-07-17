# Stores the status of users - enum:
CREATE TABLE IF NOT EXISTS `status` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores the user types -  enum: mentee, mentor, premium mentor
CREATE TABLE IF NOT EXISTS `user_type` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores the details of users both mentors and mentees
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `sex` VARCHAR(10) NOT NULL,
  `institution` VARCHAR(100) NOT NULL,
  `user_type_id` INT(255) NOT NULL,
  `team_id` INT(255) NOT NULL,
  `status_id` INT(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores the details of the mentors
CREATE TABLE IF NOT EXISTS `mentors` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL
);

# Stores the teams created by mentors
CREATE TABLE IF NOT EXISTS `teams` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `created_by` INT(255) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores the projects created by mentors
CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `type` VARCHAR(255) NOT NULL, # enum: INDIVIDUAL, TEAM
  `type_id` INT(255) NOT NULL,
  `undertaken_by` INT(255) NOT NULL,
  `has_image` INT(50) NOT NULL,
  `has_video` INT(50) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores the tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `undertaken_by` INT(255) NOT NULL,
  `has_image` INT(255) NOT NULL,
  `has_video` INT(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores the reports on tasks or projects
CREATE TABLE IF NOT EXISTS `reports` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `entity_type` VARCHAR(255) NOT NULL, # enum: TASK , PROJECT
  `entity_type_id` INT(255) NOT NULL,
  `has_image` INT(50) NOT NULL,
  `has_video` INT(50) NOT NULL,
  `submitted_by` INT(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores images for projects, tasks and reports
CREATE TABLE IF NOT EXISTS `images` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `entity_type` VARCHAR(255) NOT NULL, # enum: PROJECT, TASK, REPORT
  `entity_type_id` INT(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

# Stores videos for projects, tasks, and reports
CREATE TABLE IF NOT EXISTS `videos` (
  `id` INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` VARCHAR(255) NOT NULL, # enum: PROJECT, TASK, REPORT,
  `type_id` INT(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `modified_at` DATETIME NOT NULL
);

