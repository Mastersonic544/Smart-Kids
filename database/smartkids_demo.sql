-- SmartKids Demo Data for Direct Import (phpMyAdmin)
-- This file contains a sample of 5 children, their parents, and classroom assignments.

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Insert Parent Users
INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(101, 'Amine Trabelsi', 'amine.trabelsi@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(102, 'Hichem Ben Ali', 'hichem.benali@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(103, 'Sami Gharbi', 'sami.gharbi@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(104, 'Youssef Jlassi', 'youssef.jlassi@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(105, 'Mourad Mansour', 'mourad.mansour@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- 2. Insert Classroom Levels (if not already present)
INSERT INTO `classrooms` (`id`, `nom`, `niveau`, `capacite`, `created_at`, `updated_at`) VALUES
(1, 'Pépinière A', 'pépinière', 20, NOW(), NOW()),
(2, 'Petite Section B', 'petite_section', 20, NOW(), NOW()),
(3, 'Moyenne Section C', 'moyenne_section', 20, NOW(), NOW());

-- 3. Insert Children
INSERT INTO `children` (`id`, `nom`, `prenom`, `date_naissance`, `allergies`, `parent_id`, `classroom_id`, `created_at`, `updated_at`) VALUES
(1, 'Trabelsi', 'Ahmed', '2021-05-15', NULL, 101, 1, NOW(), NOW()),
(2, 'Ben Ali', 'Sarra', '2020-11-20', 'Lait', 102, 2, NOW(), NOW()),
(3, 'Gharbi', 'Yassine', '2021-02-10', NULL, 103, 1, NOW(), NOW()),
(4, 'Jlassi', 'Nour', '2019-08-05', 'Arachides', 104, 3, NOW(), NOW()),
(5, 'Mansour', 'Omar', '2020-12-30', NULL, 105, 2, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
