SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `candidatures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `regime_inscription` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sexe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dossier_etrange` tinyint(1) NOT NULL,
  `nationalite` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codePostal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filiere` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_dernier_diplome` date DEFAULT NULL,
  `commentaire_gestionnaire` longtext COLLATE utf8_unicode_ci NOT NULL,
  `annee_convoitee` int(11) NOT NULL,
  `complet` tinyint(1) NOT NULL,
  `project_id_redmine` int(11) NOT NULL,
  `etat_id` int(10) unsigned NOT NULL,
  `utilisateur_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `candidatures_etat_id_foreign` (`etat_id`),
  KEY `candidatures_utilisateur_id_foreign` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `date_debut_periode` date DEFAULT NULL,
  `date_fin_periode` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

INSERT INTO `configurations` (`id`, `libelle`, `active`, `date_debut_periode`, `date_fin_periode`) VALUES
(1, 'sendMailsToGestionnaires', 1, '2015-01-01', '2015-12-31');

CREATE TABLE IF NOT EXISTS `correspondances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `iduser` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filiere_resp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `annee_resp` int(11) NOT NULL,
  `utilisateur_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `correspondances_utilisateur_id_foreign` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `diplomes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `annee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etablissement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diplome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `moyenne_annee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mention` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` int(11) NOT NULL,
  `candidature_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `diplomes_candidature_id_foreign` (`candidature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `etats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `etats` (`id`, `libelle`) VALUES
(1, 'Brouillon'),
(2, 'Envoyée'),
(3, 'Validée'),
(4, 'A revoir'),
(5, 'Refusée');

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_20_072335_createEtats', 1),
('2014_10_20_091827_createConfigurations', 1),
('2014_10_20_091827_createRoles', 1),
('2014_10_20_091807_createUtilisateurs', 2),
('2015_01_06_184500_createCorrespondance', 3),
('2014_10_15_113723_createCandidatures', 4),
('2014_10_17_110901_createPieces', 5),
('2014_10_27_130324_createDiplome', 5),
('2014_10_27_130400_createStage', 5);

CREATE TABLE IF NOT EXISTS `pieces` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `candidature_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pieces_candidature_id_foreign` (`candidature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

INSERT INTO `roles` (`id`, `libelle`) VALUES
(1, 'Etudiant'),
(2, 'Gestionnaire'),
(3, 'Administrateur');

CREATE TABLE IF NOT EXISTS `stages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `travail_effectue` longtext COLLATE utf8_unicode_ci NOT NULL,
  `numero` int(11) NOT NULL,
  `candidature_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stages_candidature_id_foreign` (`candidature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_tmp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(4) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `utilisateurs_role_id_foreign` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

INSERT INTO `utilisateurs` (`id`, `password`, `password_tmp`, `code`, `remember_token`, `active`, `email`, `role_id`, `created_at`, `updated_at`) VALUES
(1, '$2y$10$f6T1yi.zjh7gELUONKbkmuC7/ZBvJgxAJMd6aEJ5CuPLIvdYo2/X.', '', '', '', 1, 'admin@admin.fr', 3, '2015-01-17 12:49:19', '2015-01-17 12:49:19');


ALTER TABLE `candidatures`
  ADD CONSTRAINT `candidatures_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `candidatures_etat_id_foreign` FOREIGN KEY (`etat_id`) REFERENCES `etats` (`id`);

ALTER TABLE `correspondances`
  ADD CONSTRAINT `correspondances_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);

ALTER TABLE `diplomes`
  ADD CONSTRAINT `diplomes_candidature_id_foreign` FOREIGN KEY (`candidature_id`) REFERENCES `candidatures` (`id`);

ALTER TABLE `pieces`
  ADD CONSTRAINT `pieces_candidature_id_foreign` FOREIGN KEY (`candidature_id`) REFERENCES `candidatures` (`id`);

ALTER TABLE `stages`
  ADD CONSTRAINT `stages_candidature_id_foreign` FOREIGN KEY (`candidature_id`) REFERENCES `candidatures` (`id`);

ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
