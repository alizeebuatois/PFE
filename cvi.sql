-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 17 Février 2015 à 17:27
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cvi`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
`activity_id` int(11) NOT NULL,
  `activity_label_fr` varchar(50) NOT NULL,
  `activity_label_en` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `activity`
--

INSERT INTO `activity` (`activity_id`, `activity_label_fr`, `activity_label_en`) VALUES
(1, 'travail', 'work'),
(2, 'toursime', 'tourism'),
(4, 'croisière', 'cruise'),
(5, 'plongée', 'diving'),
(6, 'chasse', 'hunting'),
(7, 'altitude (>3000m)', 'altitude (>3000m)'),
(8, 'aventure', 'adventure'),
(9, 'humanitaire', 'humanitarian'),
(10, 'santé', 'health'),
(11, 'pèlerinage', 'pilgrimage'),
(12, 'expatrié', 'expatriate'),
(13, 'famille', 'family');

-- --------------------------------------------------------

--
-- Structure de la table `allergy`
--

CREATE TABLE IF NOT EXISTS `allergy` (
`allergy_id` int(11) NOT NULL,
  `allergy_label_fr` varchar(50) NOT NULL,
  `allergy_label_en` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `allergy`
--

INSERT INTO `allergy` (`allergy_id`, `allergy_label_fr`, `allergy_label_en`) VALUES
(1, 'Oeuf', 'Egg'),
(2, 'Médicament', 'Pill'),
(3, 'Autre', 'Other');

-- --------------------------------------------------------

--
-- Structure de la table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
`appointment_id` int(11) NOT NULL,
  `appointment_start` datetime NOT NULL,
  `appointment_end` datetime NOT NULL,
  `appointment_doctor_key` varchar(10) NOT NULL,
  `appointment_departure` date NOT NULL,
  `appointment_return` date DEFAULT NULL,
  `appointment_feedback` varchar(500) DEFAULT NULL,
  `appointment_done` int(1) NOT NULL DEFAULT '0',
  `appointment_user_key` varchar(10) NOT NULL,
  `appointment_creator_user_key` varchar(10) NOT NULL,
  `appointment_creation` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Contenu de la table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `appointment_start`, `appointment_end`, `appointment_doctor_key`, `appointment_departure`, `appointment_return`, `appointment_feedback`, `appointment_done`, `appointment_user_key`, `appointment_creator_user_key`, `appointment_creation`) VALUES
(4, '2015-01-15 08:45:00', '2015-01-15 09:15:00', 'D1ARzZJqsi', '2015-03-13', '2015-05-09', NULL, 0, 'UbJOwUMdfi', 'UbJOwUMdfi', '0000-00-00 00:00:00'),
(22, '2015-02-05 10:45:00', '2015-02-05 11:05:00', 'D1ARzZJqsi', '2015-05-14', '2015-05-28', NULL, 0, 'UbJOwUMdfi', 'UbJOwUMdfi', '0000-00-00 00:00:00'),
(23, '2015-03-19 09:45:00', '2015-03-19 10:15:00', 'D1ARzZJqsi', '2015-05-07', '2015-06-12', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(24, '2015-03-05 09:45:00', '2015-03-05 10:15:00', 'D1ARzZJqsi', '2015-06-12', '2015-07-10', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(25, '2015-02-11 09:45:00', '2015-02-11 10:00:00', 'DZYLbabebx', '2015-03-17', '2015-03-26', NULL, 1, 'UbJOwUMdfi', 'U6WRywMAcL', '0000-00-00 00:00:00'),
(26, '2015-02-11 09:45:00', '2015-02-11 10:00:00', 'DZYLbabebx', '2015-03-17', '2015-03-26', NULL, 0, 'UbJOwUMdfi', 'U6WRywMAcL', '0000-00-00 00:00:00'),
(27, '2015-03-12 10:35:00', '2015-03-12 10:50:00', 'DQl6HcQoqr', '2015-05-14', '2015-05-27', NULL, 0, 'UbJOwUMdfi', 'U6WRywMAcL', '0000-00-00 00:00:00'),
(28, '2015-07-15 10:45:00', '2015-07-15 11:00:00', 'DZYLbabebx', '2015-08-27', '2015-09-10', NULL, 0, 'UbJOwUMdfi', 'U6WRywMAcL', '0000-00-00 00:00:00'),
(29, '2015-02-11 11:00:00', '2015-02-11 11:30:00', 'DZYLbabebx', '2015-05-14', '2015-06-11', NULL, 1, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(30, '2015-02-12 08:45:00', '2015-02-12 09:05:00', 'D1ARzZJqsi', '2015-05-21', '2015-05-30', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(31, '2015-02-12 08:45:00', '2015-02-12 09:05:00', 'D1ARzZJqsi', '2015-05-21', '2015-05-30', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(32, '2015-02-12 08:45:00', '2015-02-12 09:05:00', 'D1ARzZJqsi', '2015-05-21', '2015-05-30', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(33, '2015-02-12 11:05:00', '2015-02-12 11:25:00', 'D1ARzZJqsi', '2015-05-20', '2015-06-13', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(34, '2015-02-12 10:05:00', '2015-02-12 10:35:00', 'D1ARzZJqsi', '2015-05-07', '2015-06-18', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(35, '2015-02-12 10:05:00', '2015-02-12 10:35:00', 'D1ARzZJqsi', '2015-05-07', '2015-06-18', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(36, '2015-02-12 10:05:00', '2015-02-12 10:35:00', 'D1ARzZJqsi', '2015-05-07', '2015-06-18', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(37, '2015-04-09 09:45:00', '2015-04-09 10:05:00', 'D1ARzZJqsi', '2015-05-22', '2015-06-11', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00'),
(38, '2015-02-18 11:45:00', '2015-02-18 12:15:00', 'DZYLbabebx', '2015-05-15', '2015-06-12', NULL, 0, 'UbJOwUMdfi', 'UFD00c3wl4', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `appointmentActivity`
--

CREATE TABLE IF NOT EXISTS `appointmentActivity` (
  `appointment_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `appointmentActivity`
--

INSERT INTO `appointmentActivity` (`appointment_id`, `activity_id`) VALUES
(4, 2),
(12, 2),
(13, 2),
(22, 2),
(22, 11),
(23, 6),
(23, 7),
(24, 2),
(24, 6),
(25, 6),
(26, 1),
(26, 6),
(27, 4),
(27, 7),
(28, 2),
(28, 4),
(28, 5),
(28, 8),
(29, 6),
(29, 7),
(29, 11),
(30, 6),
(31, 6),
(32, 5),
(32, 6),
(33, 6),
(33, 12),
(34, 5),
(35, 5),
(36, 5),
(36, 12),
(37, 2),
(37, 7),
(38, 4),
(38, 6),
(39, 1),
(40, 6),
(41, 5),
(42, 2),
(43, 6),
(44, 6),
(45, 6),
(46, 6),
(47, 6),
(48, 5),
(49, 5),
(50, 6),
(51, 6),
(52, 6),
(52, 11),
(53, 6),
(53, 11),
(54, 5);

-- --------------------------------------------------------

--
-- Structure de la table `appointmentCountry`
--

CREATE TABLE IF NOT EXISTS `appointmentCountry` (
  `appointment_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `appointmentCountry`
--

INSERT INTO `appointmentCountry` (`appointment_id`, `country_id`) VALUES
(4, 8),
(12, 88),
(13, 88),
(22, 3),
(22, 84),
(23, 4),
(23, 15),
(24, 5),
(24, 6),
(25, 6),
(25, 58),
(26, 8),
(26, 58),
(27, 3),
(27, 84),
(28, 4),
(28, 188),
(29, 6),
(29, 250),
(30, 4),
(30, 6),
(31, 6),
(31, 58),
(32, 6),
(32, 99),
(33, 4),
(33, 7),
(34, 7),
(34, 84),
(35, 5),
(35, 7),
(36, 7),
(36, 8),
(37, 4),
(37, 6),
(38, 4),
(38, 7),
(39, 2),
(40, 7),
(41, 3),
(42, 85),
(43, 144),
(44, 7),
(45, 4),
(46, 7),
(47, 4),
(48, 8),
(49, 8),
(50, 144),
(51, 4),
(52, 5),
(53, 5),
(54, 4);

-- --------------------------------------------------------

--
-- Structure de la table `appointmentCustomer`
--

CREATE TABLE IF NOT EXISTS `appointmentCustomer` (
  `appointment_id` int(11) NOT NULL,
  `customer_key` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `appointmentCustomer`
--

INSERT INTO `appointmentCustomer` (`appointment_id`, `customer_key`) VALUES
(22, 'CHqzAtlyYI'),
(22, 'CmSUGWZvnv'),
(23, 'CmSUGWZvnv'),
(24, 'CHqzAtlyYI'),
(24, 'CmSUGWZvnv'),
(25, 'CHqzAtlyYI'),
(26, 'CHqzAtlyYI'),
(27, 'CmSUGWZvnv'),
(28, 'CHqzAtlyYI'),
(29, 'CmSUGWZvnv'),
(30, 'CHqzAtlyYI'),
(30, 'CmSUGWZvnv'),
(31, 'CHqzAtlyYI'),
(31, 'CmSUGWZvnv'),
(32, 'CHqzAtlyYI'),
(32, 'CmSUGWZvnv'),
(33, 'CHqzAtlyYI'),
(33, 'CmSUGWZvnv'),
(34, 'CHqzAtlyYI'),
(34, 'CmSUGWZvnv'),
(35, 'CHqzAtlyYI'),
(35, 'CmSUGWZvnv'),
(36, 'CHqzAtlyYI'),
(36, 'CmSUGWZvnv'),
(37, 'CHqzAtlyYI'),
(37, 'CmSUGWZvnv'),
(38, 'CHqzAtlyYI'),
(38, 'CmSUGWZvnv');

-- --------------------------------------------------------

--
-- Structure de la table `appointmentHosting`
--

CREATE TABLE IF NOT EXISTS `appointmentHosting` (
  `appointment_id` int(11) NOT NULL,
  `hosting_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `appointmentHosting`
--

INSERT INTO `appointmentHosting` (`appointment_id`, `hosting_id`) VALUES
(4, 1),
(12, 5),
(13, 5),
(22, 4),
(22, 5),
(23, 4),
(23, 5),
(24, 2),
(24, 4),
(25, 4),
(26, 2),
(26, 4),
(27, 2),
(27, 4),
(28, 3),
(28, 4),
(29, 4),
(29, 5),
(30, 2),
(30, 5),
(31, 4),
(31, 5),
(32, 2),
(32, 5),
(33, 1),
(33, 5),
(34, 2),
(34, 5),
(35, 2),
(36, 1),
(36, 2),
(37, 2),
(37, 6),
(38, 2),
(38, 4),
(39, 1),
(40, 5),
(41, 5),
(42, 5),
(43, 5),
(44, 1),
(45, 5),
(46, 5),
(47, 5),
(48, 4),
(49, 1),
(50, 4),
(51, 4),
(52, 4),
(52, 5),
(53, 2),
(53, 4),
(53, 5),
(54, 4);

-- --------------------------------------------------------

--
-- Structure de la table `chronicDisease`
--

CREATE TABLE IF NOT EXISTS `chronicDisease` (
`chronicDisease_id` int(11) NOT NULL,
  `chronicDisease_label_fr` varchar(50) NOT NULL,
  `chronicDisease_label_en` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `chronicDisease`
--

INSERT INTO `chronicDisease` (`chronicDisease_id`, `chronicDisease_label_fr`, `chronicDisease_label_en`) VALUES
(1, 'Déficit immunitaire', 'Immunity deficit'),
(2, 'Cancer', 'Cancer'),
(3, 'Maladie cardio-vasculaire', 'Cardio-vascular disease'),
(4, 'Maladie respiratoire', 'Breathing'),
(5, 'Maladie neurologique', 'Neurological disease'),
(6, 'Diabète', 'Diabete'),
(7, 'Dépression', 'Depression'),
(8, 'Splénectomie', 'Splenectomy'),
(9, 'Maladie du thymus', 'Thymus disease'),
(10, 'Myasthénie', 'Myasthenia'),
(11, 'Thrombose', 'Thrombosis'),
(12, 'Autre', 'Other');

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
`country_id` int(11) NOT NULL,
  `country_type` set('WORLD_TOUR','COUNTRY','CONTINENT','DOM-TOM') CHARACTER SET latin1 NOT NULL,
  `country_label_fr` varchar(50) NOT NULL,
  `country_label_en` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

--
-- Contenu de la table `country`
--

INSERT INTO `country` (`country_id`, `country_type`, `country_label_fr`, `country_label_en`) VALUES
(1, 'WORLD_TOUR', 'Tour du monde', 'World tour'),
(2, 'CONTINENT', 'Amérique du Nord', 'North America'),
(3, 'CONTINENT', 'Amérique du Sud', 'South America'),
(4, 'CONTINENT', 'Asie', 'Asia'),
(5, 'CONTINENT', 'Europe', 'Europe'),
(6, 'CONTINENT', 'Afrique', 'Africa'),
(7, 'CONTINENT', 'Océanie', 'Oceania'),
(8, 'CONTINENT', 'Antarctique', 'Antarctica'),
(9, 'COUNTRY', 'Afghanistan', 'Afghanistan'),
(10, 'COUNTRY', 'Albanie', 'Albania'),
(11, 'COUNTRY', 'Antarctique', 'Antarctica'),
(12, 'COUNTRY', 'Algérie', 'Algeria'),
(13, 'COUNTRY', 'Samoa Américaines', 'American Samoa'),
(14, 'COUNTRY', 'Andorre', 'Andorra'),
(15, 'COUNTRY', 'Angola', 'Angola'),
(16, 'COUNTRY', 'Antigua-et-Barbuda', 'Antigua and Barbuda'),
(17, 'COUNTRY', 'Azerbaïdjan', 'Azerbaijan'),
(18, 'COUNTRY', 'Argentine', 'Argentina'),
(19, 'COUNTRY', 'Australie', 'Australia'),
(20, 'COUNTRY', 'Autriche', 'Austria'),
(21, 'COUNTRY', 'Bahamas', 'Bahamas'),
(22, 'COUNTRY', 'Bahreïn', 'Bahrain'),
(23, 'COUNTRY', 'Bangladesh', 'Bangladesh'),
(24, 'COUNTRY', 'Arménie', 'Armenia'),
(25, 'COUNTRY', 'Barbade', 'Barbados'),
(26, 'COUNTRY', 'Belgique', 'Belgium'),
(27, 'COUNTRY', 'Bermudes', 'Bermuda'),
(28, 'COUNTRY', 'Bhoutan', 'Bhutan'),
(29, 'COUNTRY', 'Bolivie', 'Bolivia'),
(30, 'COUNTRY', 'Bosnie-Herzégovine', 'Bosnia and Herzegovina'),
(31, 'COUNTRY', 'Botswana', 'Botswana'),
(32, 'COUNTRY', 'Île Bouvet', 'Bouvet Island'),
(33, 'COUNTRY', 'Brésil', 'Brazil'),
(34, 'COUNTRY', 'Belize', 'Belize'),
(35, 'COUNTRY', 'Territoire Britannique de l''Océan Indien', 'British Indian Ocean Territory'),
(36, 'COUNTRY', 'Îles Salomon', 'Solomon Islands'),
(37, 'COUNTRY', 'Îles Vierges Britanniques', 'British Virgin Islands'),
(38, 'COUNTRY', 'Brunéi Darussalam', 'Brunei Darussalam'),
(39, 'COUNTRY', 'Bulgarie', 'Bulgaria'),
(40, 'COUNTRY', 'Myanmar', 'Myanmar'),
(41, 'COUNTRY', 'Burundi', 'Burundi'),
(42, 'COUNTRY', 'Bélarus', 'Belarus'),
(43, 'COUNTRY', 'Cambodge', 'Cambodia'),
(44, 'COUNTRY', 'Cameroun', 'Cameroon'),
(45, 'COUNTRY', 'Canada', 'Canada'),
(46, 'COUNTRY', 'Cap-vert', 'Cape Verde'),
(47, 'COUNTRY', 'Îles Caïmanes', 'Cayman Islands'),
(48, 'COUNTRY', 'République Centrafricaine', 'Central African'),
(49, 'COUNTRY', 'Sri Lanka', 'Sri Lanka'),
(50, 'COUNTRY', 'Tchad', 'Chad'),
(51, 'COUNTRY', 'Chili', 'Chile'),
(52, 'COUNTRY', 'Chine', 'China'),
(53, 'COUNTRY', 'Taïwan', 'Taiwan'),
(54, 'COUNTRY', 'Île Christmas', 'Christmas Island'),
(55, 'COUNTRY', 'Îles Cocos (Keeling)', 'Cocos (Keeling) Islands'),
(56, 'COUNTRY', 'Colombie', 'Colombia'),
(57, 'COUNTRY', 'Comores', 'Comoros'),
(58, 'DOM-TOM', 'Mayotte', 'Mayotte'),
(59, 'COUNTRY', 'République du Congo', 'Republic of the Congo'),
(60, 'COUNTRY', 'République Démocratique du Congo', 'The Democratic Republic Of The Congo'),
(61, 'COUNTRY', 'Îles Cook', 'Cook Islands'),
(62, 'COUNTRY', 'Costa Rica', 'Costa Rica'),
(63, 'COUNTRY', 'Croatie', 'Croatia'),
(64, 'COUNTRY', 'Cuba', 'Cuba'),
(65, 'COUNTRY', 'Chypre', 'Cyprus'),
(66, 'COUNTRY', 'République Tchèque', 'Czech Republic'),
(67, 'COUNTRY', 'Bénin', 'Benin'),
(68, 'COUNTRY', 'Danemark', 'Denmark'),
(69, 'COUNTRY', 'Dominique', 'Dominica'),
(70, 'COUNTRY', 'République Dominicaine', 'Dominican Republic'),
(71, 'COUNTRY', 'Équateur', 'Ecuador'),
(72, 'COUNTRY', 'El Salvador', 'El Salvador'),
(73, 'COUNTRY', 'Guinée Équatoriale', 'Equatorial Guinea'),
(74, 'COUNTRY', 'Éthiopie', 'Ethiopia'),
(75, 'COUNTRY', 'Érythrée', 'Eritrea'),
(76, 'COUNTRY', 'Estonie', 'Estonia'),
(77, 'COUNTRY', 'Îles Féroé', 'Faroe Islands'),
(78, 'COUNTRY', 'Îles (malvinas) Falkland', 'Falkland Islands'),
(79, 'COUNTRY', 'Géorgie du Sud et les Îles Sandwich du Sud', 'South Georgia and the South Sandwich Islands'),
(80, 'COUNTRY', 'Fidji', 'Fiji'),
(81, 'COUNTRY', 'Finlande', 'Finland'),
(82, 'COUNTRY', 'Îles Åland', 'Åland Islands'),
(83, 'COUNTRY', 'France', 'France'),
(84, 'DOM-TOM', 'Guyane Française', 'French Guiana'),
(85, 'DOM-TOM', 'Polynésie Française', 'French Polynesia'),
(86, 'DOM-TOM', 'Terres Australes Françaises', 'French Southern Territories'),
(87, 'COUNTRY', 'Djibouti', 'Djibouti'),
(88, 'COUNTRY', 'Gabon', 'Gabon'),
(89, 'COUNTRY', 'Géorgie', 'Georgia'),
(90, 'COUNTRY', 'Gambie', 'Gambia'),
(91, 'COUNTRY', 'Territoire Palestinien Occupé', 'Occupied Palestinian Territory'),
(92, 'COUNTRY', 'Allemagne', 'Germany'),
(93, 'COUNTRY', 'Ghana', 'Ghana'),
(94, 'COUNTRY', 'Gibraltar', 'Gibraltar'),
(95, 'COUNTRY', 'Kiribati', 'Kiribati'),
(96, 'COUNTRY', 'Grèce', 'Greece'),
(97, 'COUNTRY', 'Groenland', 'Greenland'),
(98, 'COUNTRY', 'Grenade', 'Grenada'),
(99, 'DOM-TOM', 'Guadeloupe', 'Guadeloupe'),
(100, 'COUNTRY', 'Guam', 'Guam'),
(101, 'COUNTRY', 'Guatemala', 'Guatemala'),
(102, 'COUNTRY', 'Guinée', 'Guinea'),
(103, 'COUNTRY', 'Guyana', 'Guyana'),
(104, 'COUNTRY', 'Haïti', 'Haiti'),
(105, 'COUNTRY', 'Îles Heard et Mcdonald', 'Heard Island and McDonald Islands'),
(106, 'COUNTRY', 'Saint-Siège (état de la Cité du Vatican)', 'Vatican City State'),
(107, 'COUNTRY', 'Honduras', 'Honduras'),
(108, 'COUNTRY', 'Hong-Kong', 'Hong Kong'),
(109, 'COUNTRY', 'Hongrie', 'Hungary'),
(110, 'COUNTRY', 'Islande', 'Iceland'),
(111, 'COUNTRY', 'Inde', 'India'),
(112, 'COUNTRY', 'Indonésie', 'Indonesia'),
(113, 'COUNTRY', 'République Islamique d''Iran', 'Islamic Republic of Iran'),
(114, 'COUNTRY', 'Iraq', 'Iraq'),
(115, 'COUNTRY', 'Irlande', 'Ireland'),
(116, 'COUNTRY', 'Israël', 'Israel'),
(117, 'COUNTRY', 'Italie', 'Italy'),
(118, 'COUNTRY', 'Côte d''Ivoire', 'Côte d''Ivoire'),
(119, 'COUNTRY', 'Jamaïque', 'Jamaica'),
(120, 'COUNTRY', 'Japon', 'Japan'),
(121, 'COUNTRY', 'Kazakhstan', 'Kazakhstan'),
(122, 'COUNTRY', 'Jordanie', 'Jordan'),
(123, 'COUNTRY', 'Kenya', 'Kenya'),
(124, 'COUNTRY', 'République Populaire Démocratique de Corée', 'Democratic People''s Republic of Korea'),
(125, 'COUNTRY', 'République de Corée', 'Republic of Korea'),
(126, 'COUNTRY', 'Koweït', 'Kuwait'),
(127, 'COUNTRY', 'Kirghizistan', 'Kyrgyzstan'),
(128, 'COUNTRY', 'République Démocratique Populaire Lao', 'Lao People''s Democratic Republic'),
(129, 'COUNTRY', 'Liban', 'Lebanon'),
(130, 'COUNTRY', 'Lesotho', 'Lesotho'),
(131, 'COUNTRY', 'Lettonie', 'Latvia'),
(132, 'COUNTRY', 'Libéria', 'Liberia'),
(133, 'COUNTRY', 'Jamahiriya Arabe Libyenne', 'Libyan Arab Jamahiriya'),
(134, 'COUNTRY', 'Liechtenstein', 'Liechtenstein'),
(135, 'COUNTRY', 'Lituanie', 'Lithuania'),
(136, 'COUNTRY', 'Luxembourg', 'Luxembourg'),
(137, 'COUNTRY', 'Macao', 'Macao'),
(138, 'COUNTRY', 'Madagascar', 'Madagascar'),
(139, 'COUNTRY', 'Malawi', 'Malawi'),
(140, 'COUNTRY', 'Malaisie', 'Malaysia'),
(141, 'COUNTRY', 'Maldives', 'Maldives'),
(142, 'COUNTRY', 'Mali', 'Mali'),
(143, 'COUNTRY', 'Malte', 'Malta'),
(144, 'DOM-TOM', 'Martinique', 'Martinique'),
(145, 'COUNTRY', 'Mauritanie', 'Mauritania'),
(146, 'COUNTRY', 'Maurice', 'Mauritius'),
(147, 'COUNTRY', 'Mexique', 'Mexico'),
(148, 'COUNTRY', 'Monaco', 'Monaco'),
(149, 'COUNTRY', 'Mongolie', 'Mongolia'),
(150, 'COUNTRY', 'République de Moldova', 'Republic of Moldova'),
(151, 'COUNTRY', 'Montserrat', 'Montserrat'),
(152, 'COUNTRY', 'Maroc', 'Morocco'),
(153, 'COUNTRY', 'Mozambique', 'Mozambique'),
(154, 'COUNTRY', 'Oman', 'Oman'),
(155, 'COUNTRY', 'Namibie', 'Namibia'),
(156, 'COUNTRY', 'Nauru', 'Nauru'),
(157, 'COUNTRY', 'Népal', 'Nepal'),
(158, 'COUNTRY', 'Pays-Bas', 'Netherlands'),
(159, 'COUNTRY', 'Antilles Néerlandaises', 'Netherlands Antilles'),
(160, 'COUNTRY', 'Aruba', 'Aruba'),
(161, 'DOM-TOM', 'Nouvelle-Calédonie', 'New Caledonia'),
(162, 'COUNTRY', 'Vanuatu', 'Vanuatu'),
(163, 'COUNTRY', 'Nouvelle-Zélande', 'New Zealand'),
(164, 'COUNTRY', 'Nicaragua', 'Nicaragua'),
(165, 'COUNTRY', 'Niger', 'Niger'),
(166, 'COUNTRY', 'Nigéria', 'Nigeria'),
(167, 'COUNTRY', 'Niué', 'Niue'),
(168, 'COUNTRY', 'Île Norfolk', 'Norfolk Island'),
(169, 'COUNTRY', 'Norvège', 'Norway'),
(170, 'COUNTRY', 'Îles Mariannes du Nord', 'Northern Mariana Islands'),
(171, 'COUNTRY', 'Îles Mineures Éloignées des États-Unis', 'United States Minor Outlying Islands'),
(172, 'COUNTRY', 'États Fédérés de Micronésie', 'Federated States of Micronesia'),
(173, 'COUNTRY', 'Îles Marshall', 'Marshall Islands'),
(174, 'COUNTRY', 'Palaos', 'Palau'),
(175, 'COUNTRY', 'Pakistan', 'Pakistan'),
(176, 'COUNTRY', 'Panama', 'Panama'),
(177, 'COUNTRY', 'Papouasie-Nouvelle-Guinée', 'Papua New Guinea'),
(178, 'COUNTRY', 'Paraguay', 'Paraguay'),
(179, 'COUNTRY', 'Pérou', 'Peru'),
(180, 'COUNTRY', 'Philippines', 'Philippines'),
(181, 'COUNTRY', 'Pitcairn', 'Pitcairn'),
(182, 'COUNTRY', 'Pologne', 'Poland'),
(183, 'COUNTRY', 'Portugal', 'Portugal'),
(184, 'COUNTRY', 'Guinée-Bissau', 'Guinea-Bissau'),
(185, 'COUNTRY', 'Timor-Leste', 'Timor-Leste'),
(186, 'COUNTRY', 'Porto Rico', 'Puerto Rico'),
(187, 'COUNTRY', 'Qatar', 'Qatar'),
(188, 'DOM-TOM', 'Réunion', 'Réunion'),
(189, 'COUNTRY', 'Roumanie', 'Romania'),
(190, 'COUNTRY', 'Fédération de Russie', 'Russian Federation'),
(191, 'COUNTRY', 'Rwanda', 'Rwanda'),
(192, 'COUNTRY', 'Sainte-Hélène', 'Saint Helena'),
(193, 'COUNTRY', 'Saint-Kitts-et-Nevis', 'Saint Kitts and Nevis'),
(194, 'COUNTRY', 'Anguilla', 'Anguilla'),
(195, 'COUNTRY', 'Sainte-Lucie', 'Saint Lucia'),
(196, 'DOM-TOM', 'Saint-Pierre-et-Miquelon', 'Saint-Pierre and Miquelon'),
(197, 'COUNTRY', 'Saint-Vincent-et-les Grenadines', 'Saint Vincent and the Grenadines'),
(198, 'COUNTRY', 'Saint-Marin', 'San Marino'),
(199, 'COUNTRY', 'Sao Tomé-et-Principe', 'Sao Tome and Principe'),
(200, 'COUNTRY', 'Arabie Saoudite', 'Saudi Arabia'),
(201, 'COUNTRY', 'Sénégal', 'Senegal'),
(202, 'COUNTRY', 'Seychelles', 'Seychelles'),
(203, 'COUNTRY', 'Sierra Leone', 'Sierra Leone'),
(204, 'COUNTRY', 'Singapour', 'Singapore'),
(205, 'COUNTRY', 'Slovaquie', 'Slovakia'),
(206, 'COUNTRY', 'Viet Nam', 'Vietnam'),
(207, 'COUNTRY', 'Slovénie', 'Slovenia'),
(208, 'COUNTRY', 'Somalie', 'Somalia'),
(209, 'COUNTRY', 'Afrique du Sud', 'South Africa'),
(210, 'COUNTRY', 'Zimbabwe', 'Zimbabwe'),
(211, 'COUNTRY', 'Espagne', 'Spain'),
(212, 'COUNTRY', 'Sahara Occidental', 'Western Sahara'),
(213, 'COUNTRY', 'Soudan', 'Sudan'),
(214, 'COUNTRY', 'Suriname', 'Suriname'),
(215, 'COUNTRY', 'Svalbard etÎle Jan Mayen', 'Svalbard and Jan Mayen'),
(216, 'COUNTRY', 'Swaziland', 'Swaziland'),
(217, 'COUNTRY', 'Suède', 'Sweden'),
(218, 'COUNTRY', 'Suisse', 'Switzerland'),
(219, 'COUNTRY', 'République Arabe Syrienne', 'Syrian Arab Republic'),
(220, 'COUNTRY', 'Tadjikistan', 'Tajikistan'),
(221, 'COUNTRY', 'Thaïlande', 'Thailand'),
(222, 'COUNTRY', 'Togo', 'Togo'),
(223, 'COUNTRY', 'Tokelau', 'Tokelau'),
(224, 'COUNTRY', 'Tonga', 'Tonga'),
(225, 'COUNTRY', 'Trinité-et-Tobago', 'Trinidad and Tobago'),
(226, 'COUNTRY', 'Émirats Arabes Unis', 'United Arab Emirates'),
(227, 'COUNTRY', 'Tunisie', 'Tunisia'),
(228, 'COUNTRY', 'Turquie', 'Turkey'),
(229, 'COUNTRY', 'Turkménistan', 'Turkmenistan'),
(230, 'COUNTRY', 'Îles Turks et Caïques', 'Turks and Caicos Islands'),
(231, 'COUNTRY', 'Tuvalu', 'Tuvalu'),
(232, 'COUNTRY', 'Ouganda', 'Uganda'),
(233, 'COUNTRY', 'Ukraine', 'Ukraine'),
(234, 'COUNTRY', 'L''ex-République Yougoslave de Macédoine', 'The Former Yugoslav Republic of Macedonia'),
(235, 'COUNTRY', 'Égypte', 'Egypt'),
(236, 'COUNTRY', 'Royaume-Uni', 'United Kingdom'),
(237, 'COUNTRY', 'Île de Man', 'Isle of Man'),
(238, 'COUNTRY', 'République-Unie de Tanzanie', 'United Republic Of Tanzania'),
(239, 'COUNTRY', 'États-Unis', 'United States'),
(240, 'COUNTRY', 'Îles Vierges des États-Unis', 'U.S. Virgin Islands'),
(241, 'COUNTRY', 'Burkina Faso', 'Burkina Faso'),
(242, 'COUNTRY', 'Uruguay', 'Uruguay'),
(243, 'COUNTRY', 'Ouzbékistan', 'Uzbekistan'),
(244, 'COUNTRY', 'Venezuela', 'Venezuela'),
(245, 'DOM-TOM', 'Wallis et Futuna', 'Wallis and Futuna'),
(246, 'COUNTRY', 'Samoa', 'Samoa'),
(247, 'COUNTRY', 'Yémen', 'Yemen'),
(248, 'COUNTRY', 'Serbie-et-Monténégro', 'Serbia and Montenegro'),
(249, 'COUNTRY', 'Zambie', 'Zambia'),
(250, 'DOM-TOM', 'Saint-Martin', 'Collectivity of Saint Martin'),
(251, 'DOM-TOM', 'Saint-Barthélemy', 'Saint Barthélemy');

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
`customer_id` int(11) NOT NULL,
  `customer_title` varchar(5) NOT NULL,
  `customer_firstname` varchar(30) NOT NULL,
  `customer_lastname` varchar(30) NOT NULL,
  `customer_birthdate` date NOT NULL,
  `customer_age` int(11) DEFAULT NULL,
  `customer_birthcity` varchar(50) DEFAULT NULL,
  `customer_birth_country_id` int(11) DEFAULT NULL,
  `customer_weight` int(11) DEFAULT NULL,
  `customer_sex` set('M','F') NOT NULL,
  `customer_numsecu` varchar(15) DEFAULT NULL,
  `customer_bloodgroup` varchar(3) DEFAULT NULL,
  `customer_doctor_id` int(11) DEFAULT NULL,
  `customer_medicalInfo_id` int(11) DEFAULT NULL,
  `customer_medicalRecord_id` int(11) DEFAULT NULL,
  `customer_key` varchar(10) NOT NULL,
  `customer_user_key` varchar(10) NOT NULL,
  `customer_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_title`, `customer_firstname`, `customer_lastname`, `customer_birthdate`, `customer_age`, `customer_birthcity`, `customer_birth_country_id`, `customer_weight`, `customer_sex`, `customer_numsecu`, `customer_bloodgroup`, `customer_doctor_id`, `customer_medicalInfo_id`, `customer_medicalRecord_id`, `customer_key`, `customer_user_key`, `customer_creation`) VALUES
(8, 'Mlle.', 'Alizée', 'Buatois', '1992-04-07', 0, 'Tours', 83, 0, 'F', NULL, NULL, NULL, 1, 1, 'CmSUGWZvnv', 'UbJOwUMdfi', '2014-10-25 17:20:35'),
(9, 'M.', 'Maxime', 'Facomprez', '2007-03-03', 0, 'Tours', 83, 0, 'M', '', '', NULL, NULL, NULL, 'CHqzAtlyYI', 'UbJOwUMdfi', '2015-01-15 07:46:10'),
(12, 'Mme.', 'Loreen', 'Lambin', '2015-01-06', 0, NULL, NULL, 0, 'F', NULL, '', NULL, NULL, NULL, 'Cvdin7S0we', 'UXhMcMKJIR', '2015-01-29 15:31:39');

-- --------------------------------------------------------

--
-- Structure de la table `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
`doctor_id` int(11) NOT NULL,
  `doctor_title` varchar(5) NOT NULL,
  `doctor_firstname` varchar(30) NOT NULL,
  `doctor_lastname` varchar(30) NOT NULL,
  `doctor_birthdate` date DEFAULT NULL,
  `doctor_birthcity` varchar(50) DEFAULT NULL,
  `doctor_birth_country_id` int(11) DEFAULT NULL,
  `doctor_timetable` text,
  `doctor_type` tinyint(4) NOT NULL,
  `doctor_key` varchar(10) NOT NULL,
  `doctor_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `doctor_title`, `doctor_firstname`, `doctor_lastname`, `doctor_birthdate`, `doctor_birthcity`, `doctor_birth_country_id`, `doctor_timetable`, `doctor_type`, `doctor_key`, `doctor_creation`) VALUES
(1, 'Dr.', 'Zoha', 'Maakaroun', '1985-06-04', NULL, 0, '[{"am":["10:00","13:00"],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["09:30","12:30"],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]}]', 2, 'DZYLbabebx', '2014-03-20 15:18:06'),
(2, 'Dr.', 'Adnan', 'Hamed', '1970-10-06', 'Tours', 83, '[{"am":["08:30","13:00"],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["10:00","12:00"],"pm":["13:00","15:30"]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]}]', 2, 'DLHhpil26u', '2014-03-20 17:15:17'),
(3, 'Dr.', 'Alain', 'Pouliquen', NULL, NULL, NULL, '[{"am":["",""],"pm":["13:00","15:00"]},{"am":["08:30","13:00"],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["08:30","13:00"],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]}]', 2, 'D1ARzZJqsi', '2014-03-20 17:17:53'),
(4, 'Dr.', 'Antoine', 'Guillon', '1979-06-08', NULL, NULL, '[{"am":["",""],"pm":["",""]},{"am":["09:00","12:30"],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]}]', 2, 'DYwGoRuovD', '2014-03-20 17:21:17'),
(5, 'Pr.', 'Jacques', 'Chandenier', NULL, NULL, NULL, '[{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["14:00","16:30"]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]}]', 2, 'DjhYE1Dxa1', '2014-03-20 17:24:52'),
(6, 'Mme.', 'Interne', 'Mimi', '1979-03-13', 'Tours', 83, '[{"am":["10:00","13:00"],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]},{"am":["09:30","12:15"],"pm":["",""]},{"am":["",""],"pm":["13:30","16:00"]},{"am":["",""],"pm":["",""]},{"am":["",""],"pm":["",""]}]', 1, 'DQl6HcQoqr', '2014-03-20 17:29:08'),
(7, 'Mme.', 'Chantal', 'Auzemery', NULL, NULL, NULL, NULL, 0, 'DspmgOSucM', '2014-03-21 12:21:35');

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `document_id` int(11) NOT NULL,
  `document_name` varchar(50) NOT NULL,
  `document_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dparameters`
--

CREATE TABLE IF NOT EXISTS `dparameters` (
`dparameters_id` int(11) NOT NULL,
  `dparameters_hospital_phone_number` text NOT NULL,
  `dparameters_hospital_finess` text NOT NULL,
  `dparameters_center_phone_number` text NOT NULL,
  `dparameters_center_fax` text NOT NULL,
  `dparameters_head_service` text NOT NULL,
  `dparameters_adeli_head_service` text NOT NULL,
  `dparameters_doctors` text NOT NULL,
  `dparameters_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `dparameters`
--

INSERT INTO `dparameters` (`dparameters_id`, `dparameters_hospital_phone_number`, `dparameters_hospital_finess`, `dparameters_center_phone_number`, `dparameters_center_fax`, `dparameters_head_service`, `dparameters_adeli_head_service`, `dparameters_doctors`, `dparameters_creation`) VALUES
(1, '02 47 47 47 47', '37 0 000 481', '02.47.47.38.49', '02.47.47.97.10', 'Professeur Louis BERNARD', '371055591', 'Pr J. CHANDENIER, Dr G. GRAS,  Dr L. GUILLON , Dr A. HAMED , Dr Z. MAAKAROUN-VERMESSE,  Dr A. POULIQUEN,', '2015-02-17 16:18:58');

-- --------------------------------------------------------

--
-- Structure de la table `generalVaccin`
--

CREATE TABLE IF NOT EXISTS `generalVaccin` (
`generalVaccin_id` int(11) NOT NULL,
  `generalVaccin_label` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `generalVaccin`
--

INSERT INTO `generalVaccin` (`generalVaccin_id`, `generalVaccin_label`) VALUES
(1, 'DTP'),
(2, 'Coqueluche'),
(3, 'Hépatite A'),
(4, 'Hépatite B'),
(5, 'ROR'),
(6, 'Pneumocoque'),
(7, 'BCG'),
(8, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `hosting`
--

CREATE TABLE IF NOT EXISTS `hosting` (
`hosting_id` int(11) NOT NULL,
  `hosting_label_fr` varchar(50) NOT NULL,
  `hosting_label_en` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `hosting`
--

INSERT INTO `hosting` (`hosting_id`, `hosting_label_fr`, `hosting_label_en`) VALUES
(1, 'bivouac', 'bivouac'),
(2, 'famille', 'family'),
(3, 'habitant', 'inhabitant'),
(4, 'hôtel', 'hotel'),
(5, 'location', 'renting'),
(6, 'camping', 'camping');

-- --------------------------------------------------------

--
-- Structure de la table `immunosuppressive`
--

CREATE TABLE IF NOT EXISTS `immunosuppressive` (
`immunosuppressive_id` int(11) NOT NULL,
  `immunosuppressive_label_fr` varchar(50) NOT NULL,
  `immunosuppressive_label_en` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `immunosuppressive`
--

INSERT INTO `immunosuppressive` (`immunosuppressive_id`, `immunosuppressive_label_fr`, `immunosuppressive_label_en`) VALUES
(1, 'Corticoïde', 'Corticosteroid'),
(2, 'Chimiothérapie', 'Chemotherapy'),
(3, 'Radiothérapie', 'Radiotherapy'),
(4, 'Autre', 'Other');

-- --------------------------------------------------------

--
-- Structure de la table `medicalInfo`
--

CREATE TABLE IF NOT EXISTS `medicalInfo` (
`medicalInfo_id` int(11) NOT NULL,
  `medicalInfoPregnancy_id` int(11) DEFAULT NULL,
  `medicalInfo_recentIntervention` varchar(500) DEFAULT NULL,
  `medicalInfo_repatriationInsurance` set('Y','N') DEFAULT NULL,
  `medicalInfo_previousVaccinReaction` varchar(500) DEFAULT NULL,
  `medicalInfo_diseaseRecentFever` varchar(500) DEFAULT NULL,
  `medicalInfo_allergies` text,
  `medicalInfo_chronicDiseases` text,
  `medicalInfo_immunosuppressiveTreatments` text,
  `medicalInfo_currentTreatment` varchar(500) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `medicalInfo`
--

INSERT INTO `medicalInfo` (`medicalInfo_id`, `medicalInfoPregnancy_id`, `medicalInfo_recentIntervention`, `medicalInfo_repatriationInsurance`, `medicalInfo_previousVaccinReaction`, `medicalInfo_diseaseRecentFever`, `medicalInfo_allergies`, `medicalInfo_chronicDiseases`, `medicalInfo_immunosuppressiveTreatments`, `medicalInfo_currentTreatment`) VALUES
(1, 1, NULL, NULL, NULL, NULL, '[{"id":2,"comment":"bob"}]', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `medicalInfoPregnancy`
--

CREATE TABLE IF NOT EXISTS `medicalInfoPregnancy` (
`medicalInfoPregnancy_id` int(11) NOT NULL,
  `medicalInfoPregnancy_state` set('Y','N','P','M') NOT NULL,
  `medicalInfoPregnancy_contraception` varchar(25) DEFAULT NULL,
  `medicalInfoPregnancy_breastFeeding` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `medicalInfoPregnancy`
--

INSERT INTO `medicalInfoPregnancy` (`medicalInfoPregnancy_id`, `medicalInfoPregnancy_state`, `medicalInfoPregnancy_contraception`, `medicalInfoPregnancy_breastFeeding`) VALUES
(1, 'N', 'N', 0);

-- --------------------------------------------------------

--
-- Structure de la table `medicalRecord`
--

CREATE TABLE IF NOT EXISTS `medicalRecord` (
`medicalRecord_id` int(11) NOT NULL,
  `medicalRecord_yellowFever` text,
  `medicalRecord_stamaril` text,
  `medicalRecord_previousVaccinations` text,
  `medicalRecord_vaccinations` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `medicalRecord`
--

INSERT INTO `medicalRecord` (`medicalRecord_id`, `medicalRecord_yellowFever`, `medicalRecord_stamaril`, `medicalRecord_previousVaccinations`, `medicalRecord_vaccinations`) VALUES
(1, NULL, '[{"date":"2015-02-10","lot":""}]', '[{"id":"5","date":"2015-02-10","comment":"essai"}]', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `parameters`
--

CREATE TABLE IF NOT EXISTS `parameters` (
`parameters_id` int(11) NOT NULL,
  `parameters_isLongTripFrom` int(11) NOT NULL,
  `parameters_appointmentNbMaxCustomer` int(11) NOT NULL,
  `parameters_appointment1Pduration` int(11) NOT NULL,
  `parameters_appointmentLongTripMinDuration` int(11) NOT NULL,
  `parameters_appointmentNPdurationPP` int(11) NOT NULL,
  `parameters_appointmentEmergencySlotDuration` int(11) NOT NULL,
  `parameters_appointmentNbRoom` int(11) NOT NULL,
  `parameters_emailContact` varchar(255) NOT NULL,
  `parameters_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `parameters`
--

INSERT INTO `parameters` (`parameters_id`, `parameters_isLongTripFrom`, `parameters_appointmentNbMaxCustomer`, `parameters_appointment1Pduration`, `parameters_appointmentLongTripMinDuration`, `parameters_appointmentNPdurationPP`, `parameters_appointmentEmergencySlotDuration`, `parameters_appointmentNbRoom`, `parameters_emailContact`, `parameters_creation`) VALUES
(1, 1, 28, 5, 15, 30, 10, 15, '2', '2015-02-17 14:22:19');

-- --------------------------------------------------------

--
-- Structure de la table `partnership`
--

CREATE TABLE IF NOT EXISTS `partnership` (
  `partnership_a_user_key` varchar(10) NOT NULL,
  `partnership_b_user_key` varchar(10) NOT NULL,
  `partnership_creator_user_key` varchar(10) NOT NULL,
  `partnership_ack` tinyint(1) NOT NULL,
  `partnership_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL,
  `user_login` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_password` varchar(40) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_address1` varchar(255) DEFAULT NULL,
  `user_address2` varchar(255) DEFAULT NULL,
  `user_postalcode` varchar(5) DEFAULT NULL,
  `user_city` varchar(50) DEFAULT NULL,
  `user_country_id` int(11) DEFAULT NULL,
  `user_phone` varchar(15) DEFAULT NULL,
  `user_default_customer_key` varchar(10) NOT NULL,
  `user_right` tinyint(4) NOT NULL,
  `user_actif` tinyint(1) NOT NULL,
  `user_key` varchar(10) NOT NULL,
  `user_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lastConnection` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_login`, `user_password`, `user_email`, `user_address1`, `user_address2`, `user_postalcode`, `user_city`, `user_country_id`, `user_phone`, `user_default_customer_key`, `user_right`, `user_actif`, `user_key`, `user_creation`, `user_lastConnection`) VALUES
(1, 'zmaakaroun', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'zmaakaroun@cvi.fr', '', '', '', '', 0, NULL, 'DZYLbabebx', 3, 1, 'UFD00c3wl4', '2014-03-20 15:14:49', '2015-02-17 08:30:19'),
(2, 'ahamed', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'ahamed@cvi.fr', '', '', '', '', 0, NULL, 'DLHhpil26u', 1, 1, 'UN00IbBFNg', '2014-03-20 17:15:17', '2014-05-01 17:57:20'),
(3, 'apouliquen', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', '', '', '', '', 0, '', 'D1ARzZJqsi', 1, 1, 'UxuUIWsx06', '2014-03-20 17:17:53', '2014-04-17 14:29:01'),
(4, 'aguillon', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', '2 boulevard Tonnellé', '', '37300', 'Tours', 83, NULL, 'DYwGoRuovD', 1, 1, 'UDNPi9mB2h', '2014-03-20 17:21:17', '2015-01-28 16:52:43'),
(5, 'jchandenier', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', '', '', '', '', 0, NULL, 'DjhYE1Dxa1', 1, 1, 'UEO89h6osO', '2014-03-20 17:24:52', NULL),
(6, 'infirmiere', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'contact@cvi.fr', 'CHRU Bretonneau', '', '', 'Tours', 0, NULL, 'DQl6HcQoqr', 1, 1, 'U3xv6MOFKy', '2014-03-20 17:29:08', '2014-04-23 16:25:29'),
(7, 'cauzemery', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '', '', '', '', '', 0, NULL, 'DspmgOSucM', 2, 1, 'U6WRywMAcL', '2014-03-21 12:21:35', '2015-01-29 13:55:53'),
(8, 'alibua0704', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'buatois.alizee@gmail.com', '131 rue Victor Hugo', '', '37000', 'Tours', 83, NULL, 'CmSUGWZvnv', 0, 1, 'UbJOwUMdfi', '2014-10-25 17:20:35', '2015-02-12 08:19:19'),
(44, 'lorlam0601', '4c128dcba6f941de4ee9ec2ab8f1b18adcbfd8bf', '', NULL, NULL, NULL, NULL, NULL, '', 'Cvdin7S0we', 0, 1, 'UXhMcMKJIR', '2015-01-29 15:31:39', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `userPasswordRequest`
--

CREATE TABLE IF NOT EXISTS `userPasswordRequest` (
  `user_key` varchar(10) NOT NULL,
  `userPasswordRequest_hash` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user_auto_login`
--

CREATE TABLE IF NOT EXISTS `user_auto_login` (
`user_auto_login_id` int(11) NOT NULL,
  `user_auto_login_user_key` varchar(10) NOT NULL,
  `user_auto_login_hash` varchar(32) NOT NULL,
  `user_auto_login_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `vaccin`
--

CREATE TABLE IF NOT EXISTS `vaccin` (
`vaccin_id` int(11) NOT NULL,
  `vaccin_label` varchar(50) NOT NULL,
  `vaccin_price` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Contenu de la table `vaccin`
--

INSERT INTO `vaccin` (`vaccin_id`, `vaccin_label`, `vaccin_price`) VALUES
(1, 'Revaxis', 0),
(2, 'DTPolio', 0),
(3, 'Boostrix tétra', 0),
(4, 'Engérix B10', 0),
(5, 'Engérix B20', 0),
(6, 'Havrix 720', 0),
(7, 'Havrix 1440', 0),
(8, 'Twinrix enfant', 0),
(9, 'Twinrix adulte', 0),
(10, 'Thypherix', 0),
(11, 'TYAVAX', 0),
(12, 'PRIORIX', 0),
(13, 'Méningocoque AC', 0),
(14, 'Mencevax', 0),
(15, 'Menveo', 0),
(16, 'Rabique Pasteur', 0),
(17, 'Ixiaro', 0),
(18, 'Ticovac enfant', 0),
(19, 'Encepur adulte', 0),
(20, 'Spirolept', 0),
(21, 'Grippe', 0),
(49, 'test2', 3.6);

-- --------------------------------------------------------

--
-- Structure de la table `vaccinGeneralVaccin`
--

CREATE TABLE IF NOT EXISTS `vaccinGeneralVaccin` (
  `vaccin_id` int(11) NOT NULL,
  `generalVaccin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vaccinGeneralVaccin`
--

INSERT INTO `vaccinGeneralVaccin` (`vaccin_id`, `generalVaccin_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 1),
(10, 2),
(11, 3),
(12, 4),
(13, 6),
(14, 6),
(15, 7),
(16, 8),
(17, 1),
(18, 2),
(19, 3),
(20, 4),
(21, 5),
(49, 4);

-- --------------------------------------------------------

--
-- Structure de la table `yellowFever`
--

CREATE TABLE IF NOT EXISTS `yellowFever` (
`yellowFever_id` int(11) NOT NULL,
  `yellowFever_label` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `yellowFever`
--

INSERT INTO `yellowFever` (`yellowFever_id`, `yellowFever_label`) VALUES
(1, 'Vacciné(e) (&lt; 10 ans)'),
(2, 'Vacciné(e) (&gt; 10 ans)'),
(3, 'Accord réclamé'),
(4, 'Certificat de Contre-indication'),
(5, 'Sérologie');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `activity`
--
ALTER TABLE `activity`
 ADD PRIMARY KEY (`activity_id`);

--
-- Index pour la table `allergy`
--
ALTER TABLE `allergy`
 ADD PRIMARY KEY (`allergy_id`);

--
-- Index pour la table `appointment`
--
ALTER TABLE `appointment`
 ADD PRIMARY KEY (`appointment_id`);

--
-- Index pour la table `appointmentActivity`
--
ALTER TABLE `appointmentActivity`
 ADD PRIMARY KEY (`appointment_id`,`activity_id`);

--
-- Index pour la table `appointmentCountry`
--
ALTER TABLE `appointmentCountry`
 ADD PRIMARY KEY (`appointment_id`,`country_id`);

--
-- Index pour la table `appointmentCustomer`
--
ALTER TABLE `appointmentCustomer`
 ADD PRIMARY KEY (`appointment_id`,`customer_key`);

--
-- Index pour la table `appointmentHosting`
--
ALTER TABLE `appointmentHosting`
 ADD PRIMARY KEY (`appointment_id`,`hosting_id`);

--
-- Index pour la table `chronicDisease`
--
ALTER TABLE `chronicDisease`
 ADD PRIMARY KEY (`chronicDisease_id`);

--
-- Index pour la table `country`
--
ALTER TABLE `country`
 ADD PRIMARY KEY (`country_id`);

--
-- Index pour la table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`customer_id`);

--
-- Index pour la table `doctor`
--
ALTER TABLE `doctor`
 ADD PRIMARY KEY (`doctor_id`);

--
-- Index pour la table `document`
--
ALTER TABLE `document`
 ADD PRIMARY KEY (`document_id`);

--
-- Index pour la table `dparameters`
--
ALTER TABLE `dparameters`
 ADD PRIMARY KEY (`dparameters_id`);

--
-- Index pour la table `generalVaccin`
--
ALTER TABLE `generalVaccin`
 ADD PRIMARY KEY (`generalVaccin_id`);

--
-- Index pour la table `hosting`
--
ALTER TABLE `hosting`
 ADD PRIMARY KEY (`hosting_id`);

--
-- Index pour la table `immunosuppressive`
--
ALTER TABLE `immunosuppressive`
 ADD PRIMARY KEY (`immunosuppressive_id`);

--
-- Index pour la table `medicalInfo`
--
ALTER TABLE `medicalInfo`
 ADD PRIMARY KEY (`medicalInfo_id`);

--
-- Index pour la table `medicalInfoPregnancy`
--
ALTER TABLE `medicalInfoPregnancy`
 ADD PRIMARY KEY (`medicalInfoPregnancy_id`);

--
-- Index pour la table `medicalRecord`
--
ALTER TABLE `medicalRecord`
 ADD PRIMARY KEY (`medicalRecord_id`);

--
-- Index pour la table `parameters`
--
ALTER TABLE `parameters`
 ADD PRIMARY KEY (`parameters_id`);

--
-- Index pour la table `partnership`
--
ALTER TABLE `partnership`
 ADD PRIMARY KEY (`partnership_a_user_key`,`partnership_b_user_key`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `userPasswordRequest`
--
ALTER TABLE `userPasswordRequest`
 ADD PRIMARY KEY (`user_key`);

--
-- Index pour la table `user_auto_login`
--
ALTER TABLE `user_auto_login`
 ADD PRIMARY KEY (`user_auto_login_id`);

--
-- Index pour la table `vaccin`
--
ALTER TABLE `vaccin`
 ADD PRIMARY KEY (`vaccin_id`);

--
-- Index pour la table `vaccinGeneralVaccin`
--
ALTER TABLE `vaccinGeneralVaccin`
 ADD PRIMARY KEY (`vaccin_id`,`generalVaccin_id`);

--
-- Index pour la table `yellowFever`
--
ALTER TABLE `yellowFever`
 ADD PRIMARY KEY (`yellowFever_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `activity`
--
ALTER TABLE `activity`
MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `allergy`
--
ALTER TABLE `allergy`
MODIFY `allergy_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `appointment`
--
ALTER TABLE `appointment`
MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `chronicDisease`
--
ALTER TABLE `chronicDisease`
MODIFY `chronicDisease_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `country`
--
ALTER TABLE `country`
MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=252;
--
-- AUTO_INCREMENT pour la table `customer`
--
ALTER TABLE `customer`
MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `doctor`
--
ALTER TABLE `doctor`
MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `dparameters`
--
ALTER TABLE `dparameters`
MODIFY `dparameters_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `generalVaccin`
--
ALTER TABLE `generalVaccin`
MODIFY `generalVaccin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `hosting`
--
ALTER TABLE `hosting`
MODIFY `hosting_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `immunosuppressive`
--
ALTER TABLE `immunosuppressive`
MODIFY `immunosuppressive_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `medicalInfo`
--
ALTER TABLE `medicalInfo`
MODIFY `medicalInfo_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `medicalInfoPregnancy`
--
ALTER TABLE `medicalInfoPregnancy`
MODIFY `medicalInfoPregnancy_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `medicalRecord`
--
ALTER TABLE `medicalRecord`
MODIFY `medicalRecord_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `parameters`
--
ALTER TABLE `parameters`
MODIFY `parameters_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT pour la table `user_auto_login`
--
ALTER TABLE `user_auto_login`
MODIFY `user_auto_login_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `vaccin`
--
ALTER TABLE `vaccin`
MODIFY `vaccin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT pour la table `yellowFever`
--
ALTER TABLE `yellowFever`
MODIFY `yellowFever_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
