-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 06 Juin 2013 à 09:45
-- Version du serveur: 5.1.36-community-log
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `db_jursta`
--

-- --------------------------------------------------------

--
-- Structure de la table `acte_agendacabin`
--

CREATE TABLE IF NOT EXISTS `acte_agendacabin` (
  `id_acteagendacabin` int(4) NOT NULL AUTO_INCREMENT,
  `num_acteregcabin` varchar(20) DEFAULT NULL,
  `nature_acteagendacabin` varchar(35) NOT NULL,
  `lien_acte` varchar(4) DEFAULT NULL,
  `id_agenda` int(4) DEFAULT NULL,
  `no_dectutel` int(11) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_acteagendacabin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `acte_agendacabin`
--

INSERT INTO `acte_agendacabin` (`id_acteagendacabin`, `num_acteregcabin`, `nature_acteagendacabin`, `lien_acte`, `id_agenda`, `no_dectutel`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(2, NULL, 'Convocation', NULL, 1, NULL, 11, '2013-04-05', 13);

-- --------------------------------------------------------

--
-- Structure de la table `acte_regcabin`
--

CREATE TABLE IF NOT EXISTS `acte_regcabin` (
  `id_acteregcabin` int(4) NOT NULL AUTO_INCREMENT,
  `num_acteregcabin` varchar(10) NOT NULL,
  `date_acteregcabin` date NOT NULL,
  `nature_acteregcabin` varchar(35) NOT NULL,
  `lien_acte` varchar(25) NOT NULL,
  `id_regcabin` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  `id_regjugenfant` int(11) NOT NULL,
  PRIMARY KEY (`id_acteregcabin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `acte_regcabin`
--

INSERT INTO `acte_regcabin` (`id_acteregcabin`, `num_acteregcabin`, `date_acteregcabin`, `nature_acteregcabin`, `lien_acte`, `id_regcabin`, `Id_admin`, `date_creation`, `id_juridiction`, `id_regjugenfant`) VALUES
(1, '08TR35', '2013-03-23', 'Convocation', '', 1, 11, '2013-03-23', 13, 0),
(2, '35SF', '2013-03-23', 'Requisitoire Introductif', '', 1, 11, '2013-03-23', 13, 0),
(3, 'FR687', '2013-03-23', 'Réquisitoire définitif aux fins de ', '', 1, 11, '2013-03-23', 13, 0),
(4, '12HG', '2013-03-23', 'Pv_difficulté', '', 1, 11, '2013-03-23', 13, 0),
(5, '354GH', '2013-03-23', 'Pv_audition témoin', '', 2, 11, '2013-03-23', 13, 0),
(6, '22fe', '2013-03-23', 'Pv_carrence', '', 6, 11, '2013-03-23', 13, 0),
(7, 'fsz345', '2013-03-23', 'Mandat de dépôt', '', 2, 11, '2013-03-23', 13, 0),
(8, '34hf', '2013-03-23', 'Mandat d''arrêt / amené', '', 3, 11, '2013-03-23', 13, 0),
(9, 'ghcd234', '2013-03-23', 'Requisitoire Introductif', '', 3, 11, '2013-03-23', 13, 0),
(10, '23F', '2013-03-23', 'Pv_difficulté', '', 3, 11, '2013-03-23', 13, 0),
(11, 'DSG', '2013-03-23', 'PV_police/gendarmerie', '', 3, 11, '2013-03-23', 13, 0),
(12, '23KS', '2013-03-26', 'Convocation', '', 2, 11, '2013-03-26', 13, 0),
(13, '45JG', '0000-00-00', 'Pv_interogatoire / 1ère comparution', '45JG', 2, 11, '2013-03-26', 13, 0),
(14, '3546', '0000-00-00', 'Convocation', '3546', 1, 11, '2013-04-05', 13, 0),
(15, '56457', '0000-00-00', 'Convocation', '56457', 1, 11, '2013-04-05', 13, 0),
(16, '54747', '0000-00-00', 'Convocation', '54747', 1, 11, '2013-04-05', 13, 0),
(17, 'hfyf', '0000-00-00', 'Convocation', 'hfyf', 1, 11, '2013-04-05', 13, 0),
(18, '4566', '0000-00-00', 'Convocation', '4566', 7, 11, '2013-04-05', 13, 0),
(19, '3532455', '0000-00-00', 'Requisitoire Introductif', '3532455', 7, 11, '2013-04-15', 13, 0),
(20, '5657I', '0000-00-00', 'Requisitoire Introductif', '5657I', 7, 11, '2013-04-15', 13, 0),
(21, 'rgrzhgzqqg', '0000-00-00', 'Convocation', 'rgrzhgzqqg', 8, 11, '2013-05-28', 13, 0),
(22, '24V', '2013-05-28', 'Convocation', '24V', 9, 11, '2013-05-28', 13, 0);

-- --------------------------------------------------------

--
-- Structure de la table `acte_repdectutel`
--

CREATE TABLE IF NOT EXISTS `acte_repdectutel` (
  `id_actetutel` int(4) NOT NULL AUTO_INCREMENT,
  `num_actetutel` varchar(10) NOT NULL,
  `date_actetutel` date NOT NULL,
  `nature_actetutel` varchar(35) NOT NULL,
  `lien_acte` varchar(25) DEFAULT NULL,
  `no_dectutel` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_actetutel`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `acte_repdectutel`
--

INSERT INTO `acte_repdectutel` (`id_actetutel`, `num_actetutel`, `date_actetutel`, `nature_actetutel`, `lien_acte`, `no_dectutel`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '35JY', '2026-05-13', 'Cuiratelle', NULL, 1, 11, '2013-05-26', 13),
(2, '56T', '2026-05-13', 'Garde Juridique', NULL, 1, 11, '2013-05-26', 13);

-- --------------------------------------------------------

--
-- Structure de la table `administrateurs`
--

CREATE TABLE IF NOT EXISTS `administrateurs` (
  `Id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nom_admin` varchar(30) NOT NULL DEFAULT '',
  `prenoms_admin` varchar(50) NOT NULL DEFAULT '',
  `email_admin` text NOT NULL,
  `sexe_admin` char(1) NOT NULL DEFAULT '',
  `datenais_admin` date NOT NULL DEFAULT '0000-00-00',
  `login_admin` varchar(25) NOT NULL DEFAULT '',
  `pwd_admin` varchar(25) NOT NULL DEFAULT '',
  `type_admin` varchar(50) NOT NULL DEFAULT '',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `ajouter_admin` int(1) NOT NULL DEFAULT '0',
  `modifier_admin` int(1) NOT NULL DEFAULT '0',
  `supprimer_admin` int(1) NOT NULL DEFAULT '0',
  `visualiser_admin` int(1) NOT NULL DEFAULT '0',
  `id_admincreation` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `fonction` varchar(25) NOT NULL,
  PRIMARY KEY (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `administrateurs`
--

INSERT INTO `administrateurs` (`Id_admin`, `nom_admin`, `prenoms_admin`, `email_admin`, `sexe_admin`, `datenais_admin`, `login_admin`, `pwd_admin`, `type_admin`, `id_juridiction`, `ajouter_admin`, `modifier_admin`, `supprimer_admin`, `visualiser_admin`, `id_admincreation`, `date_creation`, `fonction`) VALUES
(4, 'Juridiction', 'Ivoiriennes', 'info@jursta.com', 'M', '2011-03-06', 'Admin', 'jursta', 'Superviseur', 55, 1, 1, 1, 1, 0, '2011-03-06', ''),
(8, 'AGAH', 'Michel', 'agah@yahoo.fr', 'M', '0000-00-00', 'Agah', 'admin', 'Administrateur', 55, 0, 0, 0, 1, 4, '2011-05-11', ''),
(9, 'ANNO', 'JUSTIN', 'anno_justin@yahoo.fr', 'M', '0000-00-00', 'anno', 'anno', 'Administrateur', 14, 1, 1, 0, 1, 4, '2012-08-26', ''),
(10, 'anno', 'justin', 'anno_justin@yahoo.fr', 'M', '0000-00-00', 'justin', 'justin', 'Administrateur', 10, 1, 1, 1, 1, 4, '2013-01-08', ''),
(11, 'ANNO', 'KOUA JUSTIN', 'anno_justin@yahoo.fr', 'M', '0000-00-00', 'JUAN', 'corwin', 'Administrateur', 13, 1, 1, 1, 1, 4, '2013-01-09', '');

-- --------------------------------------------------------

--
-- Structure de la table `agenda_regcabin`
--

CREATE TABLE IF NOT EXISTS `agenda_regcabin` (
  `id_agenda` int(4) NOT NULL AUTO_INCREMENT,
  `date_agenda` date NOT NULL,
  `nodossier_agenda` varchar(7) NOT NULL,
  `nomprenom_agenda` varchar(150) NOT NULL,
  `heure_agenda` time NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_agenda`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `agenda_regcabin`
--

INSERT INTO `agenda_regcabin` (`id_agenda`, `date_agenda`, `nodossier_agenda`, `nomprenom_agenda`, `heure_agenda`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '0000-00-00', '54745', 'VTRHRH J ', '00:00:05', 11, '2013-04-05 12:17:51', 13);

-- --------------------------------------------------------

--
-- Structure de la table `annees`
--

CREATE TABLE IF NOT EXISTS `annees` (
  `annee` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`annee`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `annees`
--

INSERT INTO `annees` (`annee`) VALUES
(2000),
(2001),
(2002),
(2003),
(2004),
(2005),
(2006),
(2007),
(2008),
(2009),
(2010),
(2011);

-- --------------------------------------------------------

--
-- Structure de la table `categorie_affaire`
--

CREATE TABLE IF NOT EXISTS `categorie_affaire` (
  `id_categorieaffaire` int(11) NOT NULL DEFAULT '0',
  `lib_categorieaffaire` varchar(50) NOT NULL DEFAULT '',
  `justice_categorieaffaire` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_categorieaffaire`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categorie_affaire`
--

INSERT INTO `categorie_affaire` (`id_categorieaffaire`, `lib_categorieaffaire`, `justice_categorieaffaire`) VALUES
(1, 'Vols, recels, destructions', 'Penale'),
(2, 'Viol, Agression sexuelle', 'Penale'),
(3, 'Coups et blessures volontaires', 'Penale'),
(4, 'Affaires Civiles', 'Civile'),
(5, 'Affaires Commerciales', 'Civile'),
(6, 'Affaires Administratives', 'Civile'),
(7, 'Escroquerie, Abus de confiance', 'Penale'),
(8, 'Atteintes aux moeurs', 'Penale'),
(9, 'Circulation routière', 'Penale'),
(10, 'Affaires Sociales', 'Sociale'),
(11, 'Autres', 'Penale');

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

CREATE TABLE IF NOT EXISTS `commune` (
  `id_commune` char(50) NOT NULL DEFAULT '',
  `lib_commune` char(50) DEFAULT NULL,
  PRIMARY KEY (`id_commune`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commune`
--

INSERT INTO `commune` (`id_commune`, `lib_commune`) VALUES
('ABENGOUROU', 'ABENGOUROU'),
('ABIDJAN', 'ABIDJAN'),
('ABIE', 'ADZOPE'),
('ABOBO', 'ABIDJAN'),
('ABOISSO', 'ABOISSO'),
('ABONGOUA', 'ADZOPE'),
('ABOUDE', 'AGBOVILLE'),
('ADJAMENE', 'SAN-PEDRO'),
('ADZOPE', 'ADZOPE'),
('AFFOUMPO', 'AGBOVILLE'),
('AGBOVILLE', 'AGBOVILLE'),
('AHOUNGNANSSOU', 'TIEBISSOU'),
('AKOUPE ZEUDJI', 'ABIDJAN'),
('ALAHOU', 'TIEBISSOU'),
('ANANGUIE', 'AGBOVILLE'),
('ANGODA', 'TOUMODI'),
('ANNEPE', 'ADZOPE'),
('ASSIKOI', 'ADZOPE'),
('ATTIEGOUAKRO', 'YAMOUSSOUKRO'),
('ATTINGUIE', 'ABIDJAN'),
('ATTOBROU', 'AGBOVILLE'),
('ATTOPE', 'AGBOVILLE'),
('BACON', 'AKOUPE'),
('BANDIAHI', 'DALOA'),
('BAYOTA', 'GAGNOA'),
('BAZRA-NATTIS', 'VAVOUA'),
('BECEDI-BRIGNAN', 'ADZOPE'),
('BECOUEFIN', 'AKOUPE'),
('BELLEVILLE', 'DALOA'),
('BEOUMI', 'BOUEMI'),
('BIANKOUMA', 'BIANKOUMA'),
('BIASSO', 'ADZOPE'),
('BIEBY', 'ADZOPE'),
('BLA', 'DALOA'),
('BLE', 'DIDIEVI'),
('BOCANDA', 'BOCANDA'),
('BOGUEDIA', 'ISSIA'),
('BOLI', 'DIDIEVI'),
('BONDOUKOU', 'BONDOUKOU'),
('BONGOUANOU', 'BONGOUANOU'),
('BONIKRO', 'TOUMODI'),
('BONOUFLA', 'VAVOUA'),
('BOORO-BOROTOU', 'TOUBA'),
('BOUAFLE', 'BOUAFLE'),
('BOUAKE', 'ABIDJAN'),
('BOUDEPE', 'ADZOPE'),
('BOUGOUSSO', 'ODIENNE'),
('BOUNA', 'BOUNA'),
('BOUNDIALI', 'BOUNDIALI'),
('BROFODOUME', 'ABIDJAN'),
('BROMA', 'ISSIA'),
('CECHI', 'AGBOVILLE'),
('DABADOUGOU-MAFELE', 'ODIENNE'),
('DABAKALA', 'DABAKALA'),
('DABOU', 'DABOU'),
('DABOUYO', 'SASSANDRA'),
('DAHIEPA-KEHI', 'GAGNOA'),
('DAKPADOU', 'SASSANDRA'),
('DALOA', 'DALOA'),
('DANANE', 'DANANE'),
('DANANON', 'VAVOUA'),
('DANIA', 'VAVOUA'),
('DAPEOUA', 'SOUBRE'),
('DAPO-IBOKE', 'TABOU'),
('DEDEGBEU', 'DALOA'),
('DIASSON', 'ADZOPE'),
('DIGNAGO', 'GAGNOA'),
('DIMBOKRO', 'DIMBOKRO'),
('DIOMAN', 'TOUBA'),
('DIVO', 'DIVO'),
('DJAKPADJI', 'SAN-PEDRO'),
('DJAMANDIOKE', 'TABOU'),
('DJOUROUTOU', 'TABOU'),
('DOBA', 'SAN-PEDRO'),
('DOGBO', 'SAN-PEDRO'),
('DOH', 'TOUBA'),
('DOMANGBEU', 'DALOA'),
('DOUGROUPALEGNOA', 'GAGNOA'),
('DOUKOUYO', 'GAGNOA'),
('ELOKA', 'ABIDJAN'),
('FENGOLO', 'MANDINANI'),
('FEREMANDOUGOU', 'ODIENNE'),
('FERENTELA', 'TOUBA'),
('FERKESSEDOUGUO', 'FERKESSEDOUGOU'),
('FOUNGBESSO', 'TOUBA'),
('GABIADJI', 'SAN-PEDRO'),
('GADOUAN-ZAGORETA', 'DALOA'),
('GAGNOA', 'GAGNOA'),
('GALEBOUO', 'GAGNOA'),
('GBAZOA', 'SOUBRE'),
('GBELEBAN', 'ODIENNE'),
('GBONGAHA', 'MANDINANI'),
('GLIGBEUADJI', 'SAN-PEDRO'),
('GNAGBODOUGNOA', 'GAGNOA'),
('GNATO', 'TABOU'),
('GNEGROUBOUE', 'SASSANDRA'),
('GNOBOYO', 'SOUBRE'),
('GOGOGUHE', 'ISSIA'),
('GONATE', 'DALOA'),
('GOUEKAN', 'TOUBA'),
('GOUENZOU', 'MINIGNAN'),
('GRAND MORIE', 'AGBOVILLE'),
('GRAND YAPO', 'AGBOVILLE'),
('GRAND-AKOUDZIN', 'ADZOPE'),
('GRAND-BASSAM', 'GRAND-BASSAM'),
('GRIHIRI', 'SASSANDRA'),
('GROBONOU-DAN', 'SAN-PEDRO'),
('GUAPAHOUO', 'OUME'),
('GUESSABO', 'DALOA'),
('GUESSIGUIE', 'AGBOVILLE'),
('GUIGLO', 'GUIGLO'),
('IBOGUHE', 'ISSIA'),
('IBOKE', 'SAN-PEDRO'),
('IPOUADJI', 'SOUBRE'),
('ISSIA', 'ISSIA'),
('KATIOLA', 'KATIOLA'),
('KETRO-BASSAM', 'VAVOUA'),
('KIBOUO', 'DALOA'),
('KIMBIRILA-NORD', 'MINIGNAN'),
('KIMBIRILA-SUD', 'ODIENNE'),
('KOKOLOPOZO', 'SASSANDRA'),
('KONDROKO-DJASSANOU', 'DIDIEVI'),
('KOREAKINOU', 'SOUBRE'),
('KORHOGO', 'KORHOGO'),
('KOSSIHOUEM', 'ABIDJAN'),
('KOSSOU', 'YAMOUSSOUKRO'),
('KOUAMEFLA', 'OUME'),
('KOUEBO', 'TOUMODI'),
('KPEBO', 'DIDIEVI'),
('KPOTE', 'SAN-PEDRO'),
('LAHOUDA', 'OUME'),
('LAKOTA', 'LAKOTA'),
('LESSIRI', 'SOUBRE'),
('LILIYO', 'SOUBRE'),
('LOLOBO', 'YAMOUSSOUKRO'),
('LOMOKANKRO', 'TIEBISSOU'),
('LOUKOU-YAOKRO', 'TOUMODI'),
('LOVIGUIE', 'AGBOVILLE'),
('LUENOUFLA', 'DALOA'),
('M''BAHIAKRO', 'M''BAHIAKRO'),
('MABEHIRI 1', 'SOUBRE'),
('MABOUO', 'GAGNOA'),
('MAHANDIANA-SOKOURANI', 'MINIGNAN'),
('MAHANDOUGOU', 'TOUBA'),
('MAHINO', 'TABOU'),
('MAN', 'MAN'),
('MANDOUGOU', 'TOUBA'),
('MANKONO', 'MANKONO'),
('MASSALA-BARALA', 'TOUBA'),
('MENEKE', 'TABOU'),
('MIADZIN', 'ADZOPE'),
('MOAPE', 'ADZOPE'),
('MOLONOU', 'DIDIEVI'),
('MOROKINKRO', 'YAMOUSSOUKRO'),
('MORONOU', 'TOUMODI'),
('N''GBAN KASSE', 'DIDIEVI'),
('N''GOLOBLASSO', 'MANDINANI'),
('N''GUATTADOLIKRO', 'TIEBISSOU'),
('N''GUYAKRO', 'DIDIEVI'),
('NAFANA-SIENSO', 'ODIENNE'),
('NAHIO', 'ISSIA'),
('NAMANE', 'ISSIA'),
('NAMANOU', 'DALOA'),
('NIOKOSSO', 'TOUBA'),
('ODIENNE', 'ODIENNE'),
('OKROYOU', 'SOUBRE'),
('OLODIO', 'TABOU'),
('ORESS-KROBOU', 'AGBOVILLE'),
('OTTAWA', 'SOUBRE'),
('OUEOULO', 'SAN-PEDRO'),
('OUFFOUEDIEKRO', 'YAMOUSSOUKRO'),
('OUME', 'OUME'),
('OUPOYO', 'SOUBRE'),
('PARA', 'TABOU'),
('PAULY-BROUSSE', 'SASSANDRA'),
('PELEZI', 'VAVOUA'),
('PLATEAU', 'ABIDJAN'),
('PODOUE', 'TABOU'),
('PORT-BOUET', 'ABIDJAN'),
('PRANOI', 'TIEBISSOU'),
('RAVIART', 'DIDIEVI'),
('SABOUDOUGOU', 'TOUBA'),
('SAGO', 'SASSANDRA'),
('SAKOURALA-MAHOU', 'TOUBA'),
('SAN-PEDRO', 'SAN-PEDRO'),
('SASSANDRA', 'SASSANDRA'),
('SEGUELA', 'SEGUELA'),
('SEITIFLA', 'VAVOUA'),
('SERIHIO', 'GAGNOA'),
('SIANSOBA', 'MANDINANI'),
('SINFRA', 'SINFRA'),
('SOKORO', 'MINIGNAN'),
('SOKORODOUGOU', 'ODIENNE'),
('SOUBRE', 'SOUBRE'),
('SUBIAKRO', 'YAMOUSSOUKRO'),
('TABOU', 'TABOU'),
('TAKOREAGUI', 'SOUBRE'),
('TAPEGUIA', 'ISSIA'),
('TEHIRI', 'GAGNOA'),
('TEZIE', 'ISSIA'),
('TIASSALE', 'TIASSALE'),
('TIEBISSOU', 'TIEBISSOU'),
('TINGRELA', 'TINGRELA'),
('TONLA', 'OUME'),
('TOUBA', 'TOUBA'),
('TOUIH', 'SAN-PEDRO'),
('TOUMODI', 'TOUMODI'),
('TOUTOUBRE', 'GAGNOA'),
('WATE', 'SAN-PEDRO'),
('WONSEALY', 'SOUBRE'),
('YABAYO', 'SOUBRE'),
('YAKASSE-ME', 'ADZOPE'),
('YAKOLIDABOUO', 'SOUBRE'),
('YAKPABO-SAKASSOU', 'TIEBISSOU'),
('YAMOUSSOUKRO', 'YAMOUSSOUKRO'),
('YOOUREDOULA', 'VAVOUA'),
('YOPOHOUE', 'GAGNOA'),
('YOPOUGON', 'ABIDJAN'),
('ZAIBO', 'DALOA'),
('ZALIE-HOUAN', 'DALOA'),
('ZAMBAKRO', 'YAMOUSSOUKRO'),
('ZEBRA', 'DALOA'),
('ZOKOGUHE', 'DALOA'),
('ZOUKPANGBEU', 'DALOA'),
('ZUENOULA', 'ZUENOULA');

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE IF NOT EXISTS `departement` (
  `id_departement` int(11) NOT NULL DEFAULT '0',
  `lib_departement` char(50) DEFAULT NULL,
  PRIMARY KEY (`id_departement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `departement`
--

INSERT INTO `departement` (`id_departement`, `lib_departement`) VALUES
(1, 'MOYEN-COMOE'),
(2, 'LAGUNES'),
(3, 'SUD-COMOE'),
(4, 'AGNEBY'),
(5, 'AGNEBY'),
(6, 'AGNEBY'),
(7, '18 MONTAGNES'),
(8, 'VALLEE DU BANDAMA'),
(9, 'ZANZAN'),
(10, 'VALLEE DU BANDAMA'),
(11, 'MARAHOUE'),
(12, 'SAVANES'),
(13, 'VALLEE DU BANDAMA'),
(14, 'ZANZAN'),
(15, 'SAVANES'),
(16, 'VALLEE DU BANDAMA'),
(17, 'LAGUNES'),
(18, 'HAUT-SASSANDRA'),
(19, '18 MONTAGNES'),
(20, 'LACS'),
(21, 'VALLEE DU BANDAMA'),
(22, 'SUD-BADAMA'),
(23, 'SAVANES'),
(24, 'FROMAGER'),
(25, 'SUD-COMOE'),
(26, '18 MONTAGNES'),
(27, 'HAUT-SASSANDRA'),
(28, 'VALLEE DU BANDAMA'),
(29, 'SAVANES'),
(30, 'SUD-BADAMA'),
(31, '18 MONTAGNES'),
(32, 'DENGUELE'),
(33, 'WORODOUGOU'),
(34, 'VALLEE DU BANDAMA'),
(35, 'DENGUELE'),
(36, 'DENGUELE'),
(37, 'FROMAGER'),
(38, 'BAS-SASSANDRA'),
(39, 'BAS-SASSANDRA'),
(40, 'WORODOUGOU'),
(41, 'MARAHOUE'),
(42, 'BAS-SASSANDRA'),
(43, 'BAS-SASSANDRA'),
(44, 'LAGUNES'),
(45, 'LACS'),
(46, 'SAVANES'),
(47, 'BAFING'),
(48, 'LACS'),
(49, 'HAUT-SASSANDRA'),
(50, 'LACS'),
(51, 'HAUT-SASSANDRA');

-- --------------------------------------------------------

--
-- Structure de la table `dispositifs`
--

CREATE TABLE IF NOT EXISTS `dispositifs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libellé` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `dispositifs`
--

INSERT INTO `dispositifs` (`id`, `libellé`) VALUES
(1, 'Défaut'),
(2, 'Radiation'),
(3, 'Incompétence'),
(4, 'Contradictoire'),
(5, 'Autres');

-- --------------------------------------------------------

--
-- Structure de la table `juridiction`
--

CREATE TABLE IF NOT EXISTS `juridiction` (
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `lib_juridiction` char(100) DEFAULT NULL,
  `id_commune` char(50) DEFAULT NULL,
  `id_typejuridiction` int(11) DEFAULT NULL,
  `id_juridictiontutelle` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_juridiction`),
  KEY `id_commune` (`id_commune`),
  KEY `id_typejuridiction` (`id_typejuridiction`),
  KEY `annee` (`annee`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `juridiction`
--

INSERT INTO `juridiction` (`id_juridiction`, `lib_juridiction`, `id_commune`, `id_typejuridiction`, `id_juridictiontutelle`, `annee`) VALUES
(1, 'Cour suprème', 'PLATEAU', 1, 0, 1963),
(2, 'Cour d''appel ABIDJAN', 'PLATEAU', 2, 1, 1963),
(4, 'Cour d''appel BOUAKE DF', 'BOUAKE', 2, 1, 1968),
(5, 'TPI Abidjan Plateau', 'PLATEAU', 3, 2, 1968),
(6, 'TPI Yopougon', 'YOPOUGON', 3, 2, 1968),
(7, 'TPI Abobo', 'ABOBO', 3, 2, 1963),
(8, 'SD Agboville', 'AGBOVILLE', 4, 7, 1968),
(9, 'TPI Port-Bouet', 'PORT-BOUET', 3, 2, 1872),
(10, 'TPI Abengourou', 'ABENGOUROU', 3, 2, 0),
(11, 'SD Adzopé', 'ADZOPE', 4, 7, 0),
(12, 'SD Aboisso', 'ABOISSO', 4, 9, 0),
(13, 'SD Grand-Bassam', 'GRAND-BASSAM', 4, 9, 2000),
(14, 'SD Dabou', 'DABOU', 4, 6, 0),
(15, 'SD Tiassalé', 'TIASSALE', 4, 6, 0),
(16, 'Cour d''Appel DALOA', 'DALOA', 2, 1, 0),
(17, 'SD Bondoukou', 'BONDOUKOU', 4, 10, 0),
(18, 'SD Bouna', 'BOUNA', 4, 10, 0),
(19, 'TPI Bouaké', 'BOUAKE', 3, 4, 0),
(20, 'SD Béoumi', 'BEOUMI', 4, 19, 2009),
(21, 'SD Dabakala', 'DABAKALA', 4, 19, 0),
(22, 'SD Katiola', 'KATIOLA', 4, 19, 0),
(23, 'SD M''Bahiakro', 'M''BAHIAKRO', 4, 19, 0),
(24, 'SD Tiébissou', 'TIEBISSOU', 4, 19, 0),
(25, 'TPI Dimbokro', 'DIMBOKRO', 3, 4, 0),
(26, 'SD Bocanda', 'BOCANDA', 4, 25, 0),
(27, 'SD Bongouanou', 'BONGOUANOU', 4, 25, 0),
(28, 'SD Toumodi', 'TOUMODI', 4, 25, 0),
(29, 'SD Yamoussoukro', 'YAMOUSSOUKRO', 4, 25, 0),
(30, 'TPI Korhogo', 'KORHOGO', 3, 4, 1982),
(31, 'SD Boundiali', 'BOUNDIALI', 4, 30, 0),
(32, 'SD Ferkéssedougou', 'FERKESSEDOUGUO', 4, 30, 0),
(33, 'SD Tengrela', 'TINGRELA', 4, 30, 0),
(34, 'SD Odienné', 'ODIENNE', 4, 30, 0),
(35, 'TPI Daloa', 'DALOA', 3, 16, 1986),
(36, 'TPI Bouaflé', 'BOUAKE', 3, 16, 1998),
(37, 'SD Issia', 'ISSIA', 4, 35, 0),
(38, 'SD Sinfra', 'SINFRA', 4, 36, 0),
(39, 'SD Zuénoula', 'ZUENOULA', 4, 36, 0),
(40, 'TPI Gagnoa', 'GAGNOA', 3, 16, 0),
(41, 'SD Divo', 'DIVO', 4, 40, 0),
(42, 'SD Lakota', 'LAKOTA', 4, 40, 0),
(43, 'SD Oumé', 'OUME', 4, 40, 0),
(44, 'TPI Man', 'MAN', 3, 16, 0),
(45, 'SD Biankouma', 'BIANKOUMA', 4, 44, 0),
(46, 'SD Danané', 'DANANE', 4, 44, 0),
(47, 'SD Guiglo', 'GUIGLO', 4, 44, 0),
(48, 'SD Mankono', 'MANKONO', 4, 44, 0),
(49, 'SD Séguela', 'SEGUELA', 4, 44, 0),
(50, 'SD Touba', 'TOUBA', 4, 44, 0),
(51, 'TPI San-Pédro', 'SAN-PEDRO', 3, 16, 0),
(52, 'SD Sassandra', 'SASSANDRA', 4, 51, 0),
(53, 'SD Soubré', 'SOUBRE', 4, 51, 1980),
(54, 'SD Tabou', 'TABOU', 4, 51, 0),
(55, 'Membre de l''Inspection Général', 'PLATEAU', 5, 0, 2011);

-- --------------------------------------------------------

--
-- Structure de la table `penitentier`
--

CREATE TABLE IF NOT EXISTS `penitentier` (
  `id_penitentier` int(11) NOT NULL AUTO_INCREMENT,
  `lib_penitentier` varchar(50) NOT NULL DEFAULT '',
  `surface_dortoire` int(5) NOT NULL,
  `credit_alloue` varchar(15) DEFAULT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `id_departement` int(11) NOT NULL DEFAULT '0',
  `annee` int(11) NOT NULL DEFAULT '0',
  `id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_penitentier`),
  KEY `id_admin` (`id_admin`),
  KEY `id_departement` (`id_departement`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `annee` (`annee`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Contenu de la table `penitentier`
--

INSERT INTO `penitentier` (`id_penitentier`, `lib_penitentier`, `surface_dortoire`, `credit_alloue`, `id_juridiction`, `id_departement`, `annee`, `id_admin`, `date_creation`) VALUES
(1, 'ABENGOUROU', 1200, NULL, 10, 0, 0, 10, 0),
(2, 'ABIDJAN', 0, NULL, 0, 0, 0, 0, 0),
(3, 'ADZOPE', 0, NULL, 0, 0, 0, 0, 0),
(4, 'ABOISSO', 0, NULL, 0, 0, 0, 0, 0),
(5, 'AGBOVILLE', 0, NULL, 0, 0, 0, 0, 0),
(6, 'SAN-PEDRO', 0, NULL, 0, 0, 0, 0, 0),
(7, 'TIEBISSOU', 0, NULL, 0, 0, 0, 0, 0),
(8, 'TOUMODI', 0, NULL, 0, 0, 0, 0, 0),
(9, 'YAMOUSSOUKRO', 0, NULL, 0, 0, 0, 0, 0),
(10, 'AKOUPE', 0, NULL, 0, 0, 0, 0, 0),
(11, 'DALOA', 0, NULL, 0, 0, 0, 0, 0),
(12, 'GAGNOA', 0, NULL, 0, 0, 0, 0, 0),
(13, 'VAVOUA', 0, NULL, 0, 0, 0, 0, 0),
(14, 'BOUEMI', 0, NULL, 0, 0, 0, 0, 0),
(15, 'BIANKOUMA', 0, NULL, 0, 0, 0, 0, 0),
(16, 'DIDIEVI', 0, NULL, 0, 0, 0, 0, 0),
(17, 'BOCANDA', 0, NULL, 0, 0, 0, 0, 0),
(18, 'ISSIA', 0, NULL, 0, 0, 0, 0, 0),
(19, 'BONDOUKOU', 0, NULL, 0, 0, 0, 0, 0),
(20, 'BONGOUANOU', 0, NULL, 0, 0, 0, 0, 0),
(21, 'TOUBA', 0, NULL, 0, 0, 0, 0, 0),
(22, 'BOUAFLE', 0, NULL, 0, 0, 0, 0, 0),
(23, 'BOUAKE', 0, NULL, 0, 0, 0, 0, 0),
(24, 'ODIENNE', 0, NULL, 0, 0, 0, 0, 0),
(25, 'BOUNA', 0, NULL, 0, 0, 0, 0, 0),
(26, 'BOUNDIALI', 0, NULL, 0, 0, 0, 0, 0),
(27, 'DABAKALA', 0, NULL, 0, 0, 0, 0, 0),
(28, 'DABOU', 1000, NULL, 14, 0, 0, 9, 0),
(29, 'SASSANDRA', 0, NULL, 0, 0, 0, 0, 0),
(30, 'DANANE', 0, NULL, 0, 0, 0, 0, 0),
(31, 'SOUBRE', 0, NULL, 0, 0, 0, 0, 0),
(32, 'TABOU', 0, NULL, 0, 0, 0, 0, 0),
(33, 'DIMBOKRO', 0, NULL, 0, 0, 0, 0, 0),
(34, 'TOUBA', 0, NULL, 0, 0, 0, 0, 0),
(35, 'DIVO', 0, NULL, 0, 0, 0, 0, 0),
(36, 'TABOU', 0, NULL, 0, 0, 0, 0, 0),
(37, 'MANDINANI', 0, NULL, 0, 0, 0, 0, 0),
(38, 'FERKESSEDOUGOU', 0, NULL, 0, 0, 0, 0, 0),
(39, 'MINIGNAN', 0, NULL, 0, 0, 0, 0, 0),
(40, 'GRAND-BASSAM', 200, NULL, 13, 0, 0, 11, 0);

-- --------------------------------------------------------

--
-- Structure de la table `plum_civil`
--

CREATE TABLE IF NOT EXISTS `plum_civil` (
  `id_plumcivil` int(11) NOT NULL AUTO_INCREMENT,
  `presi_plumcivil` varchar(50) NOT NULL DEFAULT '',
  `greffier_plumcivil` varchar(50) NOT NULL,
  `accesseurs_plumcivil` varchar(50) DEFAULT '',
  `Substitut_PlumCivil` varchar(50) DEFAULT 'n/a',
  `observ_plumcivil` text,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `date_modif` date NOT NULL,
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumcivil`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `plum_civil`
--

INSERT INTO `plum_civil` (`id_plumcivil`, `presi_plumcivil`, `greffier_plumcivil`, `accesseurs_plumcivil`, `Substitut_PlumCivil`, `observ_plumcivil`, `Id_admin`, `date_creation`, `date_modif`, `no_rolegeneral`, `id_juridiction`) VALUES
(2, '4444', '444', '444', '0', '444', 2, '0000-00-00', '0000-00-00', 1, 42),
(4, 'XXXXXXXX', 'XXXXX', 'XXXXXXX', '0', 'XXXXXXXXXXXXXXX', 11, '2013-01-16', '0000-00-00', 8, 14),
(5, 'XXXXX', 'XXXX', 'XXXX', '0', 'XXXXXX', 11, '2013-01-16', '0000-00-00', 5, 14),
(7, 'TOURE', 'CISSE', 'DIBY', 'n/a', 'RAS2', 0, '2013-01-29', '2013-01-29', 12, 13),
(8, 'YAO', 'KONE', 'SORO', 'KOUADIO', 'RAS', 11, '2013-05-28', '0000-00-00', 17, 13);

-- --------------------------------------------------------

--
-- Structure de la table `plum_penale`
--

CREATE TABLE IF NOT EXISTS `plum_penale` (
  `id_plumpenale` int(11) NOT NULL AUTO_INCREMENT,
  `dataudience_plumpenale` date NOT NULL DEFAULT '0000-00-00',
  `presi_plumpenale` varchar(50) NOT NULL DEFAULT '',
  `greffier_plumpenale` varchar(50) NOT NULL DEFAULT '',
  `accesseurs_plumpenale` varchar(50) NOT NULL DEFAULT '',
  `observ_plumpenale` text,
  `id_noms` varchar(5) NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `no_regplaintes` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumpenale`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_regplaintes` (`no_regplaintes`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `plum_penale`
--

INSERT INTO `plum_penale` (`id_plumpenale`, `dataudience_plumpenale`, `presi_plumpenale`, `greffier_plumpenale`, `accesseurs_plumpenale`, `observ_plumpenale`, `id_noms`, `Id_admin`, `date_creation`, `no_regplaintes`, `id_juridiction`) VALUES
(3, '0000-00-00', '444', '444', '444', '444', '0', 2, '0000-00-00', 444, 2),
(5, '2012-01-01', 'XXXXXXX', 'XXXXXXX', 'XXXXXX', 'XXXXXXX', '0', 11, '2013-01-15', 4, 14),
(14, '2013-05-27', 'jytktkj', 'tyjtykt', 'ytkktk', 'tyktykty', '1', 11, '2013-05-27', 1, 13),
(15, '2013-05-27', 'EY5K5EYI', '5E7I56I', 'E56I569I', 'I56EOI57OI7O', '1', 11, '2013-05-27', 1, 13),
(16, '2013-05-28', 'CCVZDV', 'FEBRGBR', 'GRBHRB', 'NB5NBTN', '5', 11, '2013-05-28', 3, 13),
(17, '2013-06-04', 'CSDGSD', 'DSGFSDG', 'DSGVSGDG', 'DSGDSGDS', '9', 11, '2013-06-04', 7, 13);

-- --------------------------------------------------------

--
-- Structure de la table `plum_regenfant`
--

CREATE TABLE IF NOT EXISTS `plum_regenfant` (
  `id_plumenfant` int(11) NOT NULL AUTO_INCREMENT,
  `dataudience_plumenfant` date NOT NULL,
  `presi_plumenfant` varchar(50) NOT NULL DEFAULT '',
  `greffier_plumenfant` varchar(50) NOT NULL,
  `accesseurs_plumenfant` varchar(50) DEFAULT NULL,
  `Substitut_Plumenfant` varchar(50) DEFAULT 'n/a',
  `observ_plumenfant` text,
  `id_noms` varchar(5) NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `date_modif` date NOT NULL,
  `no_regplaintes` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumenfant`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_rolegeneral` (`no_regplaintes`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `plum_regenfant`
--

INSERT INTO `plum_regenfant` (`id_plumenfant`, `dataudience_plumenfant`, `presi_plumenfant`, `greffier_plumenfant`, `accesseurs_plumenfant`, `Substitut_Plumenfant`, `observ_plumenfant`, `id_noms`, `Id_admin`, `date_creation`, `date_modif`, `no_regplaintes`, `id_juridiction`) VALUES
(1, '2013-05-27', '(y(y("', '''-u-u', '''-u(iu', 'n/a', 'u-ièi', '1', 11, '2013-05-27', '0000-00-00', 1, 13);

-- --------------------------------------------------------

--
-- Structure de la table `plum_social`
--

CREATE TABLE IF NOT EXISTS `plum_social` (
  `id_plumsociale` int(11) NOT NULL AUTO_INCREMENT,
  `presi_plumsociale` varchar(50) NOT NULL DEFAULT '',
  `greffier_plumsociale` varchar(50) NOT NULL DEFAULT '',
  `accesseurs_plumsociale` varchar(50) NOT NULL DEFAULT '',
  `observ_plumsociale` text,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `date_modif` date DEFAULT NULL,
  `no_rgsocial` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumsociale`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_rgsocial` (`no_rgsocial`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `plum_social`
--

INSERT INTO `plum_social` (`id_plumsociale`, `presi_plumsociale`, `greffier_plumsociale`, `accesseurs_plumsociale`, `observ_plumsociale`, `Id_admin`, `date_creation`, `date_modif`, `no_rgsocial`, `id_juridiction`) VALUES
(1, 'dghbgteb', 'rnryjnn', 'yrnjryjnrj', 'gihgvkjhvjhfj', 0, '2013-04-03', NULL, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `plum_tutelle`
--

CREATE TABLE IF NOT EXISTS `plum_tutelle` (
  `id_plumtutel` int(11) NOT NULL AUTO_INCREMENT,
  `presi_plumtutel` varchar(50) NOT NULL DEFAULT '',
  `greffier_plumtutel` varchar(50) NOT NULL,
  `accesseurs_plumtutel` varchar(50) DEFAULT NULL,
  `Substitut_Plumtutel` varchar(50) DEFAULT 'n/a',
  `observ_plumtutel` text,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `date_modif` date NOT NULL,
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumtutel`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `plum_tutelle`
--

INSERT INTO `plum_tutelle` (`id_plumtutel`, `presi_plumtutel`, `greffier_plumtutel`, `accesseurs_plumtutel`, `Substitut_Plumtutel`, `observ_plumtutel`, `Id_admin`, `date_creation`, `date_modif`, `no_rolegeneral`, `id_juridiction`) VALUES
(1, 'THJTRJ?', 'RUJTFJTU', NULL, NULL, 'koffi', 0, '0000-00-00', '2013-04-05', 12, 13);

-- --------------------------------------------------------

--
-- Structure de la table `rcr_international`
--

CREATE TABLE IF NOT EXISTS `rcr_international` (
  `no_rcr` int(4) NOT NULL AUTO_INCREMENT,
  `noordre_rcr` varchar(7) NOT NULL DEFAULT '',
  `date_rcr` date NOT NULL DEFAULT '0000-00-00',
  `destinataire_rcr` text NOT NULL,
  `objet_rcr` text NOT NULL,
  `etat_rcr` varchar(6) NOT NULL,
  `observation_rcr` text,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`no_rcr`),
  UNIQUE KEY `noordre_rcrinterne` (`noordre_rcr`),
  KEY `Id_admin` (`Id_admin`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `rcr_national`
--

CREATE TABLE IF NOT EXISTS `rcr_national` (
  `no_rcrnational` int(4) NOT NULL AUTO_INCREMENT,
  `noordre_rcrnational` varchar(7) NOT NULL DEFAULT '',
  `date_rcrnational` date NOT NULL DEFAULT '0000-00-00',
  `destinataire_rcrnational` text NOT NULL,
  `objet_rcrnational` text NOT NULL,
  `etat_rcrnational` varchar(7) NOT NULL,
  `observation_rcrnational` text,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`no_rcrnational`),
  UNIQUE KEY `noordre_rcrexterne` (`noordre_rcrnational`),
  KEY `Id_admin` (`Id_admin`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE IF NOT EXISTS `region` (
  `id_region` char(50) NOT NULL DEFAULT '',
  `id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id_region`),
  KEY `id_admin` (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reg_alphabdet`
--

CREATE TABLE IF NOT EXISTS `reg_alphabdet` (
  `no_regalphabdet` int(5) NOT NULL AUTO_INCREMENT,
  `asphys_regalphabdet` text NOT NULL,
  `sexe_regalphabdet` text NOT NULL,
  `moidat_regalphabdet` text NOT NULL,
  `nomdet_regalphabdet` text NOT NULL,
  `no_ecrou` int(11) NOT NULL DEFAULT '0',
  `datentre_regalphabdet` date NOT NULL DEFAULT '0000-00-00',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regalphabdet`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`),
  KEY `noecrou` (`no_ecrou`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_alphabdet`
--

INSERT INTO `reg_alphabdet` (`no_regalphabdet`, `asphys_regalphabdet`, `sexe_regalphabdet`, `moidat_regalphabdet`, `nomdet_regalphabdet`, `no_ecrou`, `datentre_regalphabdet`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '444', '444', '4444', '4444', 44, '0000-00-00', 44, '0000-00-00 00:00:00', 4);

-- --------------------------------------------------------

--
-- Structure de la table `reg_cabin`
--

CREATE TABLE IF NOT EXISTS `reg_cabin` (
  `id_regcabin` int(11) NOT NULL AUTO_INCREMENT,
  `numodre_regcabin` varchar(7) NOT NULL,
  `datefait` date NOT NULL,
  `daterequisitoire` date NOT NULL,
  `datordcloture` date NOT NULL,
  `decisionord` varchar(50) NOT NULL,
  `observation` text NOT NULL,
  `no_repjugementcorr` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_regcabin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `reg_cabin`
--

INSERT INTO `reg_cabin` (`id_regcabin`, `numodre_regcabin`, `datefait`, `daterequisitoire`, `datordcloture`, `decisionord`, `observation`, `no_repjugementcorr`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, 'RI01/13', '2013-03-12', '2013-03-13', '2013-03-14', 'GDSGSDQGSDG', 'SGDGSDGSD', 1, 11, '2013-03-23 00:00:00', 13),
(2, 'RI02/13', '2013-03-23', '2013-03-23', '2013-03-23', 'TJJJTUJ', 'JU7UJ6IK67J', 1, 11, '2013-03-23 13:07:26', 13),
(3, 'RI03/13', '2013-03-23', '2013-03-23', '2013-03-23', 'EHTHTRHTR', 'GTEGEGHTRGT', 1, 11, '2013-03-23 13:10:54', 13),
(7, 'RI04/13', '2013-04-03', '2013-04-03', '2013-04-03', 'bvjgbgihg', 'hgviuhyv', 6, 11, '2013-04-03 18:01:46', 13),
(9, 'RI05/13', '2013-05-28', '0000-00-00', '0000-00-00', 'zfrehrh', 'hjtyjytj', 11, 11, '2013-05-28 12:47:20', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_ccm`
--

CREATE TABLE IF NOT EXISTS `reg_ccm` (
  `id_rccm` int(11) NOT NULL AUTO_INCREMENT,
  `noformalite_rccm` varchar(20) NOT NULL,
  `date_rccm` date NOT NULL,
  `numentreprise_rccm` varchar(20) NOT NULL,
  `nomexploitant_rccm` varchar(60) NOT NULL,
  `datnais_rccm` date DEFAULT NULL,
  `lieunais_rccm` varchar(50) DEFAULT NULL,
  `nationalite_rccm` varchar(50) DEFAULT NULL,
  `domicil_rccm` text,
  `objet_rccm` text,
  `nomdeclarant_rccm` varchar(50) DEFAULT NULL,
  `qualite_rccm` varchar(50) DEFAULT NULL,
  `surete_rccm` text,
  `Id_admin` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_rccm`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_ccm`
--

INSERT INTO `reg_ccm` (`id_rccm`, `noformalite_rccm`, `date_rccm`, `numentreprise_rccm`, `nomexploitant_rccm`, `datnais_rccm`, `lieunais_rccm`, `nationalite_rccm`, `domicil_rccm`, `objet_rccm`, `nomdeclarant_rccm`, `qualite_rccm`, `surete_rccm`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '7656', '2013-04-19', '446546', 'FNXSFHFX', '2013-04-03', 'DGHDTH', 'DTRYUTDYD', 'KFYITJD', 'DJDDETUTDEJ', 'TUETU', 'ZUUZ', 'UEU', 11, '2013-04-19', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_civilopposition`
--

CREATE TABLE IF NOT EXISTS `reg_civilopposition` (
  `id_civilopp` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_civilopp` varchar(7) NOT NULL,
  `datejour` date NOT NULL,
  `datejugdefaut` date DEFAULT NULL,
  `datesignification` date DEFAULT NULL,
  `newdataudience` date DEFAULT NULL,
  `signature` varchar(15) DEFAULT NULL,
  `no_repjugementsupp` int(11) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modif` datetime DEFAULT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_civilopp`),
  UNIQUE KEY `noordre_socialopp` (`noordre_civilopp`),
  UNIQUE KEY `noordre_socialopp_2` (`noordre_civilopp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_civilopposition`
--

INSERT INTO `reg_civilopposition` (`id_civilopp`, `noordre_civilopp`, `datejour`, `datejugdefaut`, `datesignification`, `newdataudience`, `signature`, `no_repjugementsupp`, `Id_admin`, `date_creation`, `date_modif`, `id_juridiction`) VALUES
(1, '454', '0000-00-00', '2013-04-01', '2013-04-02', '2013-04-11', 'KKB', 7, 11, '2013-02-26 14:04:26', '2013-04-05 07:34:58', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_consignations`
--

CREATE TABLE IF NOT EXISTS `reg_consignations` (
  `no_regconsign` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_regconsign` varchar(25) NOT NULL DEFAULT '',
  `date_regconsign` date NOT NULL DEFAULT '0000-00-00',
  `montant_regconsign` decimal(10,0) DEFAULT '0',
  `decision_regconsign` text,
  `somareclam_regconsign` decimal(10,0) DEFAULT '0',
  `somarestit_regconsign` decimal(10,0) DEFAULT '0',
  `liquidation_regconsign` varchar(25) DEFAULT '',
  `observation_regconsign` varchar(25) DEFAULT '',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regconsign`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_consignations`
--

INSERT INTO `reg_consignations` (`no_regconsign`, `noordre_regconsign`, `date_regconsign`, `montant_regconsign`, `decision_regconsign`, `somareclam_regconsign`, `somarestit_regconsign`, `liquidation_regconsign`, `observation_regconsign`, `Id_admin`, `date_creation`, `no_rolegeneral`, `id_juridiction`) VALUES
(1, '4534', '2013-04-02', NULL, 'En cours', NULL, NULL, NULL, NULL, 11, '2013-04-02 09:29:05', 13, 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_controlnum`
--

CREATE TABLE IF NOT EXISTS `reg_controlnum` (
  `no_regcontrolnum` int(11) NOT NULL AUTO_INCREMENT,
  `professiondet_ecrou` varchar(50) NOT NULL,
  `domicildet_ecrou` varchar(50) NOT NULL,
  `nationalite_ecrou` varchar(50) NOT NULL,
  `tailledet_ecrou` varchar(5) NOT NULL,
  `frontdet_ecrou` varchar(15) NOT NULL,
  `nezdet_ecrou` varchar(10) NOT NULL,
  `bouchedet_ecrou` varchar(15) NOT NULL,
  `teintdet_ecrou` varchar(6) NOT NULL,
  `signepartdet_ecrou` varchar(50) NOT NULL,
  `noordre_regcontrolnum` int(11) NOT NULL DEFAULT '0',
  `datnaisdet_ecrou` date NOT NULL,
  `lieunaisdet_ecrou` varchar(50) NOT NULL,
  `peredet_ecrou` varchar(50) NOT NULL,
  `meredet_ecrou` varchar(50) NOT NULL,
  `sexe_regcontrolnum` text NOT NULL,
  `date_regcontrolnum` date NOT NULL DEFAULT '0000-00-00',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_regmandat` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regcontrolnum`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_juridiction_2` (`id_juridiction`),
  KEY `no_regmandat` (`no_regmandat`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reg_controlnum`
--

INSERT INTO `reg_controlnum` (`no_regcontrolnum`, `professiondet_ecrou`, `domicildet_ecrou`, `nationalite_ecrou`, `tailledet_ecrou`, `frontdet_ecrou`, `nezdet_ecrou`, `bouchedet_ecrou`, `teintdet_ecrou`, `signepartdet_ecrou`, `noordre_regcontrolnum`, `datnaisdet_ecrou`, `lieunaisdet_ecrou`, `peredet_ecrou`, `meredet_ecrou`, `sexe_regcontrolnum`, `date_regcontrolnum`, `Id_admin`, `date_creation`, `no_regmandat`, `id_juridiction`) VALUES
(2, '', '', '', '', '', '', '', '', '', 54675875, '0000-00-00', '', '', '', 'Masculin', '2013-04-08', 11, '2013-04-08 11:02:56', 2, 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_controlnum2`
--

CREATE TABLE IF NOT EXISTS `reg_controlnum2` (
  `no_regcontrolnum` int(11) NOT NULL AUTO_INCREMENT,
  `rhyer` int(11) NOT NULL,
  `teuytuh` varchar(23) NOT NULL,
  `test` varchar(2) NOT NULL,
  `noordre_regcontrolnum` int(11) NOT NULL DEFAULT '0',
  `sexe_regcontrolnum` text NOT NULL,
  `date_regcontrolnum` date NOT NULL DEFAULT '0000-00-00',
  `nom_regcontrolnum` text NOT NULL,
  `procureur_regcontrolnum` text NOT NULL,
  `naturdelit_regcontrolnum` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_regmandat` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `rz` int(11) NOT NULL,
  `rg` int(11) NOT NULL,
  PRIMARY KEY (`no_regcontrolnum`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_juridiction_2` (`id_juridiction`),
  KEY `no_regmandat` (`no_regmandat`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `reg_deces`
--

CREATE TABLE IF NOT EXISTS `reg_deces` (
  `id_regdeces` int(11) NOT NULL AUTO_INCREMENT,
  `numodre_regdeces` varchar(7) NOT NULL,
  `date_regdeces` date NOT NULL,
  `lieu_regdeces` varchar(50) NOT NULL,
  `details_regdeces` text NOT NULL,
  `suite_regdeces` varchar(35) NOT NULL,
  `observation_regdeces` text NOT NULL,
  `no_ecrou` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_regdeces`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_deces`
--

INSERT INTO `reg_deces` (`id_regdeces`, `numodre_regdeces`, `date_regdeces`, `lieu_regdeces`, `details_regdeces`, `suite_regdeces`, `observation_regdeces`, `no_ecrou`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '001/13', '2013-04-08', 'Cellule', 'maladie', 'Corps remis aux parents', 'ras', 3, 11, '2013-04-08 13:49:51', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_ecrou`
--

CREATE TABLE IF NOT EXISTS `reg_ecrou` (
  `no_ecrou` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_ecrou` varchar(25) NOT NULL DEFAULT '',
  `datenter_ecrou` date NOT NULL DEFAULT '0000-00-00',
  `prolongdet_ecrou` varchar(50) DEFAULT NULL,
  `decisionjudic_ecrou` varchar(50) DEFAULT NULL,
  `type_voiederecours` text,
  `datedebutpeine_ecrou` date DEFAULT NULL,
  `dateexpirpeine_ecrou` date DEFAULT NULL,
  `datsortidet_ecrou` date DEFAULT NULL,
  `motifssortidet_ecrou` date DEFAULT NULL,
  `observation_ecrou` text,
  `no_regmandat` int(11) NOT NULL DEFAULT '0',
  `no_regcontrolnum` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`no_ecrou`),
  KEY `no_regmandat` (`no_regmandat`),
  KEY `no_regcontrolnum` (`no_regcontrolnum`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reg_ecrou`
--

INSERT INTO `reg_ecrou` (`no_ecrou`, `noordre_ecrou`, `datenter_ecrou`, `prolongdet_ecrou`, `decisionjudic_ecrou`, `type_voiederecours`, `datedebutpeine_ecrou`, `dateexpirpeine_ecrou`, `datsortidet_ecrou`, `motifssortidet_ecrou`, `observation_ecrou`, `no_regmandat`, `no_regcontrolnum`, `id_juridiction`, `Id_admin`, `date_creation`) VALUES
(1, '35465', '2013-05-28', 'gfnfgnf', 'gfnfgnfn', NULL, '2013-05-21', '2013-05-22', NULL, NULL, 'fgnrdjhrjnhr', 2, 2, 13, 11, '2013-05-28'),
(2, 'gsd', '2013-05-30', 'rt', 'rtqzetze', NULL, NULL, NULL, NULL, NULL, 'ezqtzet', 2, 2, 13, 11, '2013-05-30');

-- --------------------------------------------------------

--
-- Structure de la table `reg_evasion`
--

CREATE TABLE IF NOT EXISTS `reg_evasion` (
  `id_regevasion` int(11) NOT NULL AUTO_INCREMENT,
  `numordre_regevasion` varchar(10) NOT NULL,
  `datevasion_regevasion` date NOT NULL,
  `lieuevasion_regevasion` varchar(50) DEFAULT NULL,
  `circonstance_regevasion` varchar(100) DEFAULT NULL,
  `dateretour_regevasion` date DEFAULT NULL,
  `lieureintegration_regevasion` varchar(50) DEFAULT NULL,
  `obs_regevasion` text,
  `Id_admin` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  `no_ecrou` int(11) NOT NULL,
  PRIMARY KEY (`id_regevasion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `reg_evasion`
--

INSERT INTO `reg_evasion` (`id_regevasion`, `numordre_regevasion`, `datevasion_regevasion`, `lieuevasion_regevasion`, `circonstance_regevasion`, `dateretour_regevasion`, `lieureintegration_regevasion`, `obs_regevasion`, `Id_admin`, `date_creation`, `id_juridiction`, `no_ecrou`) VALUES
(1, '001/13', '2013-04-09', 'MACA', 'lors d''une émeute', '2013-04-11', 'MACA', 'RAS', 11, '2013-04-09', 13, 3),
(2, '002/13', '2013-04-09', 'MACA', 'TEHEETEH', '2013-04-26', 'MACA', 'RAS', 11, '2013-04-09', 13, 3),
(3, '003/13', '2013-04-09', 'TPI YOPOUGON', 'INCONNUE', '2013-04-25', 'MACA', 'RAS', 11, '2013-04-09', 13, 3);

-- --------------------------------------------------------

--
-- Structure de la table `reg_execpeine`
--

CREATE TABLE IF NOT EXISTS `reg_execpeine` (
  `id_execpeine` int(11) NOT NULL AUTO_INCREMENT,
  `nodordre_execpeine` varchar(25) NOT NULL,
  `peine_execpeine` varchar(100) NOT NULL,
  `naturedelit_execpeine` varchar(50) NOT NULL,
  `situation_execpeine` varchar(8) DEFAULT NULL,
  `datemdpot_execpeine` date DEFAULT NULL,
  `datgrosse_execpeine` date DEFAULT NULL,
  `dateperson_execpeine` date DEFAULT NULL,
  `datetrxprison_execpeine` date DEFAULT NULL,
  `datetrxtresor_execpeine` date DEFAULT NULL,
  `datetrxcasier` date DEFAULT NULL,
  `datenvoipolice` date DEFAULT NULL,
  `datarrestation` date DEFAULT NULL,
  `sursisarrestation` varchar(50) DEFAULT NULL,
  `sursiaexecution` varchar(50) DEFAULT NULL,
  `causesretard` text,
  `datexpirpeine` date DEFAULT NULL,
  `observation` text,
  `no_repjugementcorr` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_execpeine`),
  UNIQUE KEY `nodordre_execpeine` (`nodordre_execpeine`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `reg_execpeine`
--

INSERT INTO `reg_execpeine` (`id_execpeine`, `nodordre_execpeine`, `peine_execpeine`, `naturedelit_execpeine`, `situation_execpeine`, `datemdpot_execpeine`, `datgrosse_execpeine`, `dateperson_execpeine`, `datetrxprison_execpeine`, `datetrxtresor_execpeine`, `datetrxcasier`, `datenvoipolice`, `datarrestation`, `sursisarrestation`, `sursiaexecution`, `causesretard`, `datexpirpeine`, `observation`, `no_repjugementcorr`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(2, '23df', 'yjhtyjtj', '', NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 11, '2013-03-27', 13),
(3, '43GFRF', 'NG?F?G', '', NULL, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 11, '2013-03-27', 13),
(5, '986986K', 'LKJGHKG', '', 'LJHGOIUH', '2013-05-27', '2013-05-16', '2013-05-15', '2013-05-15', '2013-05-15', '2013-05-22', '2013-05-16', '2013-05-22', 'MKHIKH', '?BLJB', 'LKNMLKNH', '2013-05-22', 'LKHNLIHKJ', 9, 11, '2013-05-27', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_jugenfant`
--

CREATE TABLE IF NOT EXISTS `reg_jugenfant` (
  `id_regjugenfant` int(11) NOT NULL AUTO_INCREMENT,
  `numodre_regjugenfant` varchar(7) NOT NULL,
  `datefait` date NOT NULL,
  `daterequisitoire` date NOT NULL,
  `datordcloture` date NOT NULL,
  `decisionord` varchar(50) NOT NULL,
  `observation` text NOT NULL,
  `no_regplaintes` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_regjugenfant`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_jugenfant`
--

INSERT INTO `reg_jugenfant` (`id_regjugenfant`, `numodre_regjugenfant`, `datefait`, `daterequisitoire`, `datordcloture`, `decisionord`, `observation`, `no_regplaintes`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, 'RE01/13', '2013-05-27', '2013-05-21', '0000-00-00', 'erurur', 'eururu', 1, 11, '2013-05-27 17:07:50', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_levecrou`
--

CREATE TABLE IF NOT EXISTS `reg_levecrou` (
  `id_reglevecrou` int(11) NOT NULL AUTO_INCREMENT,
  `motif_reglevecrou` varchar(50) NOT NULL,
  `origine_reglevecrou` varchar(50) NOT NULL,
  `datedepart_reglevecrou` date NOT NULL,
  `dateretour_reglevecrou` date NOT NULL,
  `destination_reglevecrou` varchar(50) NOT NULL,
  `noordre_ecrou` varchar(25) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`id_reglevecrou`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `reg_libcond`
--

CREATE TABLE IF NOT EXISTS `reg_libcond` (
  `id_reglibcond` int(11) NOT NULL AUTO_INCREMENT,
  `numordre_reglibcond` varchar(7) NOT NULL,
  `date_libcond` date NOT NULL,
  `ref_reglibcond` text NOT NULL,
  `obs_reglibcond` text,
  `no_ecrou` int(11) NOT NULL,
  `signature_greffier` text,
  `signature_chef` text,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_reglibcond`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_libcond`
--

INSERT INTO `reg_libcond` (`id_reglibcond`, `numordre_reglibcond`, `date_libcond`, `ref_reglibcond`, `obs_reglibcond`, `no_ecrou`, `signature_greffier`, `signature_chef`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '001/13', '0000-00-00', 'EFDAYEFFIUHYF', 'DBFGBFG', 3, NULL, NULL, 11, '2013-04-09 07:14:00', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_mandat`
--

CREATE TABLE IF NOT EXISTS `reg_mandat` (
  `no_regmandat` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_regmandat` text NOT NULL,
  `date_regmandat` date NOT NULL DEFAULT '0000-00-00',
  `nom_regmandat` text NOT NULL,
  `magistra_regmandat` text NOT NULL,
  `infraction_regmandat` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type_regmandat` text NOT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regmandat`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reg_mandat`
--

INSERT INTO `reg_mandat` (`no_regmandat`, `noordre_regmandat`, `date_regmandat`, `nom_regmandat`, `magistra_regmandat`, `infraction_regmandat`, `Id_admin`, `date_creation`, `type_regmandat`, `id_juridiction`) VALUES
(1, '44', '0000-00-00', '444', '444', '444', 44, '0000-00-00 00:00:00', '444', 44),
(2, '12367', '2013-04-08', 'ANNO KOUA JUSTIN', 'Juge Yao', 'fhnbdhthtt', 11, '2013-04-08 10:55:40', 'Mandat de depot', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_mdepot`
--

CREATE TABLE IF NOT EXISTS `reg_mdepot` (
  `no_regmdepot` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_regmdepot` int(11) NOT NULL DEFAULT '0',
  `date_regmdepot` date NOT NULL DEFAULT '0000-00-00',
  `nom_regmdepot` text NOT NULL,
  `magistra_regmdepot` text NOT NULL,
  `infraction_regmdepot` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regmdepot`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_mdepot`
--

INSERT INTO `reg_mdepot` (`no_regmdepot`, `noordre_regmdepot`, `date_regmdepot`, `nom_regmdepot`, `magistra_regmdepot`, `infraction_regmdepot`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, 44, '0000-00-00', '444', '444', '444', 44, '0000-00-00 00:00:00', 44);

-- --------------------------------------------------------

--
-- Structure de la table `reg_objdep`
--

CREATE TABLE IF NOT EXISTS `reg_objdep` (
  `no_regobjdep` int(11) NOT NULL AUTO_INCREMENT,
  `datemd_regobjdep` date NOT NULL DEFAULT '0000-00-00',
  `nom_regobjdep` text NOT NULL,
  `som_regobjdep` varchar(15) NOT NULL DEFAULT '',
  `objet_redobjdep` text NOT NULL,
  `observ_regobjdep` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regobjdep`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_objdep`
--

INSERT INTO `reg_objdep` (`no_regobjdep`, `datemd_regobjdep`, `nom_regobjdep`, `som_regobjdep`, `objet_redobjdep`, `observ_regobjdep`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '0000-00-00', '444', '444', '444', '444', 444, '0000-00-00 00:00:00', 444);

-- --------------------------------------------------------

--
-- Structure de la table `reg_ordrendu`
--

CREATE TABLE IF NOT EXISTS `reg_ordrendu` (
  `id_ordrendu` int(11) NOT NULL AUTO_INCREMENT,
  `nordre_ordrendu` varchar(8) NOT NULL,
  `date_ordrendu` date NOT NULL,
  `nomprenom_prevenu` varchar(50) NOT NULL,
  `nomprenom_pcivil` varchar(50) NOT NULL,
  `nature_ordrendu` varchar(100) NOT NULL,
  `observation_ordrendu` text NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_ordrendu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `reg_piece`
--

CREATE TABLE IF NOT EXISTS `reg_piece` (
  `id_regpiece` int(11) NOT NULL AUTO_INCREMENT,
  `nordre_regpiece` varchar(15) NOT NULL,
  `autorigine` varchar(25) NOT NULL,
  `Nopv` varchar(15) NOT NULL,
  `datepv` date NOT NULL,
  `nomprevenus` text NOT NULL,
  `naturescelle` varchar(150) NOT NULL,
  `lieuconserv` varchar(12) NOT NULL,
  `nojugdecision` varchar(25) DEFAULT NULL,
  `nordestruction` varchar(25) DEFAULT NULL,
  `nordremise` varchar(25) DEFAULT NULL,
  `daterestitution` date DEFAULT NULL,
  `nocni` varchar(15) DEFAULT NULL,
  `emargement` varchar(15) DEFAULT NULL,
  `observation` text,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_regpiece`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `reg_piece`
--

INSERT INTO `reg_piece` (`id_regpiece`, `nordre_regpiece`, `autorigine`, `Nopv`, `datepv`, `nomprevenus`, `naturescelle`, `lieuconserv`, `nojugdecision`, `nordestruction`, `nordremise`, `daterestitution`, `nocni`, `emargement`, `observation`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(4, 'DG', 'Police', 'RGRG55', '2013-06-04', '53HERH', 'FEBEBEBRB', 'Magasin', '35', '25F', '45F', '2013-06-12', '3ETRF3523', 'ETETG', 'DGE', 11, '2013-06-04 15:19:55', 13),
(3, '565', 'Police', '556', '2013-04-04', 'ANNO', ' YJDJ', 'Coffre-fort', '566', '536', 'B6', '0000-00-00', 'N5BY', 'ANNO JUSTIN', 'TRNEU', 11, '2013-04-04 09:40:02', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_plaintes`
--

CREATE TABLE IF NOT EXISTS `reg_plaintes` (
  `no_regplaintes` int(11) NOT NULL AUTO_INCREMENT,
  `nodordre_plaintes` varchar(25) DEFAULT NULL,
  `Pautosaisi_plaintes` varchar(25) DEFAULT NULL,
  `Red_plaintes` varchar(30) DEFAULT NULL,
  `NomPreDomInculpes_plaintes` text,
  `dateparquet_plaintes` date DEFAULT NULL,
  `NatInfraction_plaintes` text,
  `suite_plaintes` varchar(30) DEFAULT NULL,
  `MotifClass_plaintes` text,
  `observations_plaintes` text,
  `Id_admin` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `DatInfraction_plaintes` date DEFAULT NULL,
  `LieuInfraction_plaintes` varchar(50) DEFAULT NULL,
  `id_categorieaffaire` int(11) DEFAULT NULL,
  `PVdat_plaintes` date DEFAULT NULL,
  `naturesuite_plaintes` varchar(25) DEFAULT NULL,
  `typepv_plaintes` varchar(50) DEFAULT NULL,
  `naturecrimes_plaintes` varchar(25) DEFAULT NULL,
  `procedureautreparquet_plaintes` int(1) DEFAULT NULL,
  `typesaisine_plaintes` varchar(25) DEFAULT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regplaintes`),
  KEY `Id_admin` (`Id_admin`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_categorieaffaire` (`id_categorieaffaire`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reg_plaintes`
--

INSERT INTO `reg_plaintes` (`no_regplaintes`, `nodordre_plaintes`, `Pautosaisi_plaintes`, `Red_plaintes`, `NomPreDomInculpes_plaintes`, `dateparquet_plaintes`, `NatInfraction_plaintes`, `suite_plaintes`, `MotifClass_plaintes`, `observations_plaintes`, `Id_admin`, `date_creation`, `DatInfraction_plaintes`, `LieuInfraction_plaintes`, `id_categorieaffaire`, `PVdat_plaintes`, `naturesuite_plaintes`, `typepv_plaintes`, `naturecrimes_plaintes`, `procedureautreparquet_plaintes`, `typesaisine_plaintes`, `id_juridiction`) VALUES
(2, '444', '444', '444', '444', '2011-05-10', '444', '444', '444', '444', 44, '2011-05-10 18:44:09', '2011-05-10', '444', 444, '2011-05-10', '444', '444', '444', 444, '444', 44);

-- --------------------------------------------------------

--
-- Structure de la table `reg_plaintes_desc`
--

CREATE TABLE IF NOT EXISTS `reg_plaintes_desc` (
  `no_regplaintes` int(11) NOT NULL AUTO_INCREMENT,
  `nodordre_plaintes` varchar(25) DEFAULT NULL,
  `Pautosaisi_plaintes` varchar(25) DEFAULT NULL,
  `Red_plaintes` varchar(30) DEFAULT NULL,
  `dateparquet_plaintes` date DEFAULT NULL,
  `suite_plaintes` varchar(30) DEFAULT NULL,
  `MotifClass_plaintes` text,
  `observations_plaintes` text,
  `Id_admin` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `DatInfraction_plaintes` date DEFAULT NULL,
  `LieuInfraction_plaintes` varchar(50) DEFAULT NULL,
  `id_categorieaffaire` int(11) DEFAULT NULL,
  `PVdat_plaintes` date DEFAULT NULL,
  `naturesuite_plaintes` varchar(25) DEFAULT NULL,
  `typepv_plaintes` varchar(50) DEFAULT NULL,
  `naturecrimes_plaintes` varchar(25) DEFAULT NULL,
  `procedureautreparquet_plaintes` int(1) DEFAULT NULL,
  `typesaisine_plaintes` varchar(25) DEFAULT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `cles_pivot` varchar(100) NOT NULL,
  PRIMARY KEY (`no_regplaintes`),
  KEY `Id_admin` (`Id_admin`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_categorieaffaire` (`id_categorieaffaire`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `reg_plaintes_desc`
--

INSERT INTO `reg_plaintes_desc` (`no_regplaintes`, `nodordre_plaintes`, `Pautosaisi_plaintes`, `Red_plaintes`, `dateparquet_plaintes`, `suite_plaintes`, `MotifClass_plaintes`, `observations_plaintes`, `Id_admin`, `date_creation`, `DatInfraction_plaintes`, `LieuInfraction_plaintes`, `id_categorieaffaire`, `PVdat_plaintes`, `naturesuite_plaintes`, `typepv_plaintes`, `naturecrimes_plaintes`, `procedureautreparquet_plaintes`, `typesaisine_plaintes`, `id_juridiction`, `cles_pivot`) VALUES
(1, '1245/13', 'Police', 'ANNO', '0000-00-00', 'Juge d''intruction', NULL, 'RAS', 11, '2013-02-26 00:09:46', '0000-00-00', 'ABIDJAN', 1, '0000-00-00', 'Poursuivable', '1', 'Constatée', 0, NULL, 13, '1245/13-2013-02-26'),
(3, '1567/13', 'Police', 'ANNO ', '2013-02-18', 'Tribunal correctionnel', NULL, 'RAS', 11, '2013-02-26 12:42:48', '2013-02-17', 'MAN', 3, '2013-02-17', 'Poursuivable', '1', 'Poursuivis', 0, NULL, 13, '1567/13-2013-02-26'),
(6, 'RHK', 'Eaux et Forêts', 'TEHJEJTU', '2013-05-22', 'Tribunal correctionnel', 'DGJTEJ', 'YIRYIYD', 11, '2013-05-27 18:01:04', '2013-05-09', 'JTYZJSIYI', 1, '2013-05-23', 'Non Poursuivable', '1', 'Poursuivis', 0, NULL, 13, 'RHK-2013-05-27 18:01:04'),
(7, '1278/13', 'Gendarmerie', 'YAO JULES', '2013-05-28', 'Tribunal correctionnel', NULL, 'ras', 11, '2013-05-28 15:27:05', '2013-05-22', 'Adjamé', 2, '2013-05-28', 'Poursuivable', '1', 'Poursuivis', 0, NULL, 13, '1278/13-2013-05-28 15:27:05');

-- --------------------------------------------------------

--
-- Structure de la table `reg_plaintes_noms`
--

CREATE TABLE IF NOT EXISTS `reg_plaintes_noms` (
  `id_noms` int(5) NOT NULL AUTO_INCREMENT,
  `NomPreDomInculpes_plaintes` text,
  `Domicile` varchar(50) DEFAULT NULL,
  `age` varchar(6) DEFAULT NULL,
  `NatInfraction_plaintes` text,
  `cles_pivot` varchar(100) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_noms`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `reg_plaintes_noms`
--

INSERT INTO `reg_plaintes_noms` (`id_noms`, `NomPreDomInculpes_plaintes`, `Domicile`, `age`, `NatInfraction_plaintes`, `cles_pivot`, `Id_admin`, `id_juridiction`) VALUES
(1, 'yao yves', 'Adjamé', '26', 'vols agravés', '1245/13-2013-02-26', 11, 13),
(2, 'KGI£YUGTIUYGHTI', NULL, NULL, 'JBKUGIUG', '1278/13-2013-02-26 00:15:04', 0, 0),
(3, 'KHJGFUYFUYF', NULL, NULL, 'HGJHFVJHYGV', '1278/13-2013-02-26 00:15:04', 0, 0),
(4, 'KJGI£YGU', NULL, NULL, 'HJGIUYG', '1278/13-2013-02-26 00:15:04', 0, 0),
(5, 'YVES ARMAND', NULL, NULL, 'VOLS', '1567/13-2013-02-26', 11, 13),
(6, 'AKA BERNARD', NULL, NULL, 'VOLS', '1567/13-2013-02-26', 11, 13),
(7, 'YAO KONAN', NULL, NULL, 'RECIDIVE', '1567/13-2013-02-26', 11, 13),
(8, 'TEDJTJ', 'TJRYKRJY', '26', 'GJRYIUR6', 'RHK-2013-05-27 18:01:04', 11, 13),
(9, 'konan yves', 'ABOBO', '28', 'Viols', '1278/13-2013-05-28 15:27:05', 1278, 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_scelle`
--

CREATE TABLE IF NOT EXISTS `reg_scelle` (
  `no_regscel` int(11) NOT NULL AUTO_INCREMENT,
  `nodordre_regscel` varchar(25) NOT NULL DEFAULT '',
  `datedepo_regscel` date NOT NULL DEFAULT '0000-00-00',
  `nomdeposant_regscel` text NOT NULL,
  `objetdepo_regscel` text NOT NULL,
  `observation_regscel` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `nodordre_regscel` (`nodordre_regscel`),
  UNIQUE KEY `no_regscel` (`no_regscel`),
  KEY `Id_admin` (`Id_admin`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `reg_scelle`
--

INSERT INTO `reg_scelle` (`no_regscel`, `nodordre_regscel`, `datedepo_regscel`, `nomdeposant_regscel`, `objetdepo_regscel`, `observation_regscel`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(2, '4588', '2013-05-17', 'YIYIIYI', 'YITYIIYI', 'IYTIYTIT', 11, '2013-05-17 06:57:20', 13),
(1, '665636', '2011-05-10', 'hghghhgnhbg', 'ghghghhghghg', 'hghghhghghghg', 6, '2011-05-10 04:21:41', 54),
(3, 'GDEVSDG', '2013-06-04', 'DGVSDVG', 'DSBVSDBVDS', 'DSVSDVDSV', 11, '2013-06-04 15:20:50', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_socialappel`
--

CREATE TABLE IF NOT EXISTS `reg_socialappel` (
  `id_socialappel` int(11) NOT NULL AUTO_INCREMENT,
  `no_socialappel` varchar(7) NOT NULL,
  `datejour` date NOT NULL,
  `datejugement` date NOT NULL,
  `Signature` varchar(15) DEFAULT NULL,
  `no_decision` int(11) DEFAULT NULL,
  `no_repjugementsupp` int(11) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modif` datetime NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_socialappel`),
  UNIQUE KEY `no_socialappel` (`no_socialappel`),
  UNIQUE KEY `no_socialappel_2` (`no_socialappel`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reg_socialappel`
--

INSERT INTO `reg_socialappel` (`id_socialappel`, `no_socialappel`, `datejour`, `datejugement`, `Signature`, `no_decision`, `no_repjugementsupp`, `Id_admin`, `date_creation`, `date_modif`, `id_juridiction`) VALUES
(1, '1212/13', '0000-00-00', '2013-02-12', 'JUAN', 3, NULL, 11, '2013-02-25 00:39:56', '2013-02-25 00:39:56', 13),
(2, '3467', '2013-04-02', '0000-00-00', 'HNBVKJH', NULL, 7, 11, '2013-04-02 14:53:14', '0000-00-00 00:00:00', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_socialopposition`
--

CREATE TABLE IF NOT EXISTS `reg_socialopposition` (
  `id_socialopp` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_socialopp` varchar(7) NOT NULL,
  `datejour` date NOT NULL,
  `datejugdefaut` date DEFAULT NULL,
  `datesignification` date DEFAULT NULL,
  `newdataudience` date DEFAULT NULL,
  `signature` varchar(15) DEFAULT NULL,
  `no_decision` int(11) DEFAULT NULL,
  `no_repjugementsupp` int(11) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modif` datetime DEFAULT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_socialopp`),
  UNIQUE KEY `noordre_socialopp` (`noordre_socialopp`),
  UNIQUE KEY `noordre_socialopp_2` (`noordre_socialopp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reg_socialopposition`
--

INSERT INTO `reg_socialopposition` (`id_socialopp`, `noordre_socialopp`, `datejour`, `datejugdefaut`, `datesignification`, `newdataudience`, `signature`, `no_decision`, `no_repjugementsupp`, `Id_admin`, `date_creation`, `date_modif`, `id_juridiction`) VALUES
(1, '1567/13', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 'ANNO', 0, 0, 11, '2013-02-18 16:13:59', '0000-00-00 00:00:00', 13),
(2, '1346/13', '2013-02-21', '2013-04-25', '2013-04-24', '2013-04-27', 'ANNO', 3, 0, 11, '2013-02-18 10:50:30', '2013-04-05 07:34:31', 13);

-- --------------------------------------------------------

--
-- Structure de la table `reg_suiviepc`
--

CREATE TABLE IF NOT EXISTS `reg_suiviepc` (
  `no_suiviepc` int(11) NOT NULL AUTO_INCREMENT,
  `no_dordresuiviepc` varchar(25) NOT NULL DEFAULT '',
  `autdorigine_suiviepc` text NOT NULL,
  `nodatepv_suiviepc` varchar(25) NOT NULL DEFAULT '',
  `prevenus_suiviepc` text NOT NULL,
  `naturescelle_suiviepc` text NOT NULL,
  `magasinlieuconserv_suiviepc` text NOT NULL,
  `coffrefortlieuconserv_suiviepc` text NOT NULL,
  `nojugedecision_suiviepc` varchar(25) NOT NULL DEFAULT '',
  `noordonancedestruct_suiviepc` varchar(25) NOT NULL DEFAULT '',
  `noordonanceremisedom_suiviepc` varchar(25) NOT NULL DEFAULT '',
  `daterestitution_suivepc` date NOT NULL DEFAULT '0000-00-00',
  `nocnicsrestitution_suiviepc` varchar(25) NOT NULL DEFAULT '',
  `emargementrestitution_suiviepc` varchar(30) NOT NULL DEFAULT '',
  `observation_suiviepc` text NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_suiviepc`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_suiviepc`
--

INSERT INTO `reg_suiviepc` (`no_suiviepc`, `no_dordresuiviepc`, `autdorigine_suiviepc`, `nodatepv_suiviepc`, `prevenus_suiviepc`, `naturescelle_suiviepc`, `magasinlieuconserv_suiviepc`, `coffrefortlieuconserv_suiviepc`, `nojugedecision_suiviepc`, `noordonancedestruct_suiviepc`, `noordonanceremisedom_suiviepc`, `daterestitution_suivepc`, `nocnicsrestitution_suiviepc`, `emargementrestitution_suiviepc`, `observation_suiviepc`, `date_creation`, `Id_admin`, `id_juridiction`) VALUES
(1, '444', '444', '444', '444', '444', '444', '444', '444', '444', '444', '0000-00-00', '444', '444', '444', '0000-00-00 00:00:00', 44, 44);

-- --------------------------------------------------------

--
-- Structure de la table `reg_transfert`
--

CREATE TABLE IF NOT EXISTS `reg_transfert` (
  `id_regtransfert` int(11) NOT NULL AUTO_INCREMENT,
  `numordre_regtransfert` varchar(7) NOT NULL,
  `date_regtransfert` date NOT NULL,
  `motif_regtransfert` varchar(50) NOT NULL,
  `destination_regtransfert` varchar(50) NOT NULL,
  `chef_regtransfert` varchar(100) NOT NULL,
  `obs_regtransfert` text NOT NULL,
  `no_ecrou` int(11) NOT NULL,
  `Id_admin` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `id_juridiction` int(11) NOT NULL,
  PRIMARY KEY (`id_regtransfert`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `reg_vrad`
--

CREATE TABLE IF NOT EXISTS `reg_vrad` (
  `no_regvrad` int(5) NOT NULL AUTO_INCREMENT,
  `noodre_regvrad` int(5) NOT NULL DEFAULT '0',
  `nomdet_regvrad` text NOT NULL,
  `datmd_regvrad` date NOT NULL DEFAULT '0000-00-00',
  `datjug_regvrad` date NOT NULL DEFAULT '0000-00-00',
  `datdemande_regvrad` date NOT NULL DEFAULT '0000-00-00',
  `peine_regvrad` text NOT NULL,
  `delit_regvrad` text NOT NULL,
  `parquet_regvrad` text NOT NULL,
  `nobatetcel_regvrad` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regvrad`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_vrad`
--

INSERT INTO `reg_vrad` (`no_regvrad`, `noodre_regvrad`, `nomdet_regvrad`, `datmd_regvrad`, `datjug_regvrad`, `datdemande_regvrad`, `peine_regvrad`, `delit_regvrad`, `parquet_regvrad`, `nobatetcel_regvrad`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, 44, '444', '0000-00-00', '0000-00-00', '0000-00-00', '444', '4444', '444', '444', 44, 444, 44);

-- --------------------------------------------------------

--
-- Structure de la table `reg_vrlc`
--

CREATE TABLE IF NOT EXISTS `reg_vrlc` (
  `no_regvrlc` int(5) NOT NULL AUTO_INCREMENT,
  `noordre_regvrlc` int(5) NOT NULL DEFAULT '0',
  `nomdet_regvrlc` text NOT NULL,
  `datmd_regvrlc` date NOT NULL DEFAULT '0000-00-00',
  `delit_regvrlc` text NOT NULL,
  `peine_regvrlc` text NOT NULL,
  `observ_regvrlc` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regvrlc`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_vrlc`
--

INSERT INTO `reg_vrlc` (`no_regvrlc`, `noordre_regvrlc`, `nomdet_regvrlc`, `datmd_regvrlc`, `delit_regvrlc`, `peine_regvrlc`, `observ_regvrlc`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, 444, '444', '0000-00-00', '4444', '444', '444', 44, 444, 44);

-- --------------------------------------------------------

--
-- Structure de la table `reg_vrmlp`
--

CREATE TABLE IF NOT EXISTS `reg_vrmlp` (
  `no_regvrmlp` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_regvrmlp` int(5) NOT NULL DEFAULT '0',
  `datdemand_regvrmlp` date NOT NULL DEFAULT '0000-00-00',
  `nomdet_regvrmlp` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regvrmlp`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_vrmlp`
--

INSERT INTO `reg_vrmlp` (`no_regvrmlp`, `noordre_regvrmlp`, `datdemand_regvrmlp`, `nomdet_regvrmlp`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, 44, '0000-00-00', '44', 44, '0000-00-00 00:00:00', 44);

-- --------------------------------------------------------

--
-- Structure de la table `rep_actesacc`
--

CREATE TABLE IF NOT EXISTS `rep_actesacc` (
  `no_repactesacc` int(11) NOT NULL AUTO_INCREMENT,
  `nodordre_acc` varchar(25) NOT NULL DEFAULT '',
  `date_acc` date NOT NULL DEFAULT '0000-00-00',
  `nomparties_acc` varchar(40) NOT NULL DEFAULT '',
  `designationacte_acc` varchar(35) NOT NULL DEFAULT '',
  `lien_fich` varchar(4) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `section_rolegeneral` varchar(15) NOT NULL DEFAULT '',
  `id_categorieaffaire` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_repactesacc`),
  UNIQUE KEY `nodordre_acc` (`nodordre_acc`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_categorieaffaire` (`id_categorieaffaire`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `rep_actesacc`
--

INSERT INTO `rep_actesacc` (`no_repactesacc`, `nodordre_acc`, `date_acc`, `nomparties_acc`, `designationacte_acc`, `lien_fich`, `Id_admin`, `date_creation`, `section_rolegeneral`, `id_categorieaffaire`, `id_juridiction`) VALUES
(1, '66888', '2011-05-10', '25', 'Attestation du plumitif', NULL, 6, '2011-05-10 04:04:17', '', 4, 54),
(2, '2034/13', '0000-00-00', 'YVES NOAJULES KONAN', 'Attestation du plumitif', NULL, 11, '2013-05-27 19:56:37', '', 5, 13);

-- --------------------------------------------------------

--
-- Structure de la table `rep_actesnot`
--

CREATE TABLE IF NOT EXISTS `rep_actesnot` (
  `no_repactesnot` int(11) NOT NULL AUTO_INCREMENT,
  `dateaudience_repactesnot` date NOT NULL DEFAULT '0000-00-00',
  `noordre_repactesnot` varchar(25) NOT NULL DEFAULT '',
  `demandeur_repactesnot` varchar(25) NOT NULL DEFAULT '',
  `requerant_repactesnot` varchar(25) NOT NULL DEFAULT '',
  `natdossier_repactesnot` varchar(25) NOT NULL DEFAULT '',
  `lien_fich` varchar(4) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_categorieaffaire` int(11) NOT NULL DEFAULT '0',
  `section_rolegeneral` int(15) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_repactesnot`),
  UNIQUE KEY `noordre_repactesnot` (`noordre_repactesnot`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_categorieaffaire` (`id_categorieaffaire`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `rep_actesnot`
--

INSERT INTO `rep_actesnot` (`no_repactesnot`, `dateaudience_repactesnot`, `noordre_repactesnot`, `demandeur_repactesnot`, `requerant_repactesnot`, `natdossier_repactesnot`, `lien_fich`, `Id_admin`, `date_creation`, `id_categorieaffaire`, `section_rolegeneral`, `id_juridiction`) VALUES
(1, '2011-05-10', '01545', 'jhggjhgjhg', 'fhgf gf', 'gfggfgfg gfgfgf', NULL, 6, '2011-05-10 03:54:45', 5, 0, 54),
(2, '2013-04-02', '65656', 'VJ ', 'DFTF', 'YJJB', NULL, 11, '2013-04-02 11:31:41', 4, 0, 13),
(3, '2013-04-03', '5656', 'JHFJHG', 'JHJHF', 'JHFJHF', NULL, 11, '2013-04-02 11:46:20', 4, 0, 13);

-- --------------------------------------------------------

--
-- Structure de la table `rep_decision`
--

CREATE TABLE IF NOT EXISTS `rep_decision` (
  `no_decision` int(11) NOT NULL AUTO_INCREMENT,
  `nodec_decision` varchar(10) NOT NULL,
  `grefier` varchar(25) DEFAULT NULL,
  `dispositif_decision` varchar(20) DEFAULT NULL,
  `observation_decision` text,
  `statut_decision` varchar(8) NOT NULL,
  `signature_greffier` text,
  `signature_president` text,
  `date_modif` date NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rgsocial` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_decision`),
  UNIQUE KEY `nodec_decision` (`nodec_decision`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `rep_decision`
--

INSERT INTO `rep_decision` (`no_decision`, `nodec_decision`, `grefier`, `dispositif_decision`, `observation_decision`, `statut_decision`, `signature_greffier`, `signature_president`, `date_modif`, `Id_admin`, `date_creation`, `no_rgsocial`, `id_juridiction`) VALUES
(3, '1235/13', 'ANNO', 'Defaut', 'RAS', '', 'Approuvée par ANNO KOUA JUSTIN le : 2013-02-18 09:56:32', 'Approuvée par ANNO KOUA JUSTIN le : 18/02/2013 à : 10:50:30', '2013-02-18', 11, '2013-02-18 10:50:30', 10, 13),
(4, '35FBV', 'BGBS', 'Contradictoire', 'ETHGETGBEHTB', 'Acceptée', NULL, NULL, '0000-00-00', 11, '2013-05-28 12:48:11', 10, 13),
(5, 'vbng', 'gjytj', 'Defaut', 'jytjtyjyt', 'Acceptée', NULL, NULL, '0000-00-00', 11, '2013-05-28 12:53:39', 10, 13);

-- --------------------------------------------------------

--
-- Structure de la table `rep_decisiontutel`
--

CREATE TABLE IF NOT EXISTS `rep_decisiontutel` (
  `no_dectutel` int(11) NOT NULL AUTO_INCREMENT,
  `nodec_dectutel` varchar(10) NOT NULL,
  `date_dectutel` date NOT NULL,
  `grefier` varchar(25) DEFAULT NULL,
  `lien_dectutel` text,
  `decision_dectutel` varchar(30) NOT NULL,
  `observation_dectutel` text NOT NULL,
  `signature_greffier` text,
  `signature_president` text,
  `date_modif` date DEFAULT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_dectutel`),
  UNIQUE KEY `nodec_decision` (`nodec_dectutel`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `rep_decisiontutel`
--

INSERT INTO `rep_decisiontutel` (`no_dectutel`, `nodec_dectutel`, `date_dectutel`, `grefier`, `lien_dectutel`, `decision_dectutel`, `observation_dectutel`, `signature_greffier`, `signature_president`, `date_modif`, `Id_admin`, `date_creation`, `no_rolegeneral`, `id_juridiction`) VALUES
(1, '356', '0000-00-00', NULL, NULL, 'Radie', '-u-''u''--è''', NULL, 'Approuvée par ANNO KOUA JUSTIN le : 26/05/2013 à : 10:26:12', '2013-05-26', 11, '2013-01-16 09:51:47', 12, 13);

-- --------------------------------------------------------

--
-- Structure de la table `rep_jugementcorr`
--

CREATE TABLE IF NOT EXISTS `rep_jugementcorr` (
  `no_repjugementcorr` int(11) NOT NULL AUTO_INCREMENT,
  `nojugement_repjugementcorr` varchar(25) NOT NULL DEFAULT '',
  `datejugement_repjugementcorr` date NOT NULL DEFAULT '0000-00-00',
  `no_regplaintes` int(11) NOT NULL DEFAULT '0',
  `naturedecision_repjugementcorr` text NOT NULL,
  `decisiontribunal_repjugementcorr` text NOT NULL,
  `id_noms` varchar(5) NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `nomsprevenu_repjugementcorr` text NOT NULL,
  `infraction_repjugementcorr` text NOT NULL,
  PRIMARY KEY (`no_repjugementcorr`),
  UNIQUE KEY `nojugement_repjugementcorr` (`nojugement_repjugementcorr`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_regplaintes` (`no_regplaintes`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `rep_jugementcorr`
--

INSERT INTO `rep_jugementcorr` (`no_repjugementcorr`, `nojugement_repjugementcorr`, `datejugement_repjugementcorr`, `no_regplaintes`, `naturedecision_repjugementcorr`, `decisiontribunal_repjugementcorr`, `id_noms`, `Id_admin`, `date_creation`, `id_juridiction`, `nomsprevenu_repjugementcorr`, `infraction_repjugementcorr`) VALUES
(7, 'ty574', '2013-05-27', 6, 'Public', 'JHTJTJ', '8', 11, '2013-05-27 18:25:59', 13, '', ''),
(9, '346HFH', '2013-05-27', 1, 'Public', 'RTYUREUH', '1', 11, '2013-05-27 18:50:10', 13, '', ''),
(11, 'kljhljb', '2013-05-27', 3, 'Public', 'ljgoujguj', '5', 11, '2013-05-27 19:06:23', 13, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `rep_jugementsupp`
--

CREATE TABLE IF NOT EXISTS `rep_jugementsupp` (
  `no_repjugementsupp` int(11) NOT NULL AUTO_INCREMENT,
  `nojugement_repjugementsupp` varchar(25) NOT NULL,
  `dispositif_repjugementsupp` text NOT NULL,
  `observation_repjugementsupp` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `statut_jugementsupp` varchar(15) NOT NULL DEFAULT '',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `decision_repjugementsupp` varchar(25) NOT NULL,
  `signature_greffier` varchar(60) NOT NULL,
  `signature_president` varchar(60) NOT NULL,
  `date_modif` date NOT NULL,
  PRIMARY KEY (`no_repjugementsupp`),
  UNIQUE KEY `nojugement_repjugementsupp` (`nojugement_repjugementsupp`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `rep_jugementsupp`
--

INSERT INTO `rep_jugementsupp` (`no_repjugementsupp`, `nojugement_repjugementsupp`, `dispositif_repjugementsupp`, `observation_repjugementsupp`, `Id_admin`, `date_creation`, `no_rolegeneral`, `statut_jugementsupp`, `id_juridiction`, `decision_repjugementsupp`, `signature_greffier`, `signature_president`, `date_modif`) VALUES
(1, ' 	012458', 'Incompetence', 'nhjhjkhj', 6, '2011-05-10 03:53:38', 1, 'Acceptée', 54, '', '', '', '0000-00-00'),
(2, '123456J', 'Contradictoire', 'RAS', 8, '2011-05-11 18:32:53', 4, 'Acceptée', 14, '', '', '', '0000-00-00'),
(3, '12345J', 'Contradictoire', 'XXXXXXXXX', 11, '2013-01-15 18:31:22', 7, 'Acceptée', 14, '', '', '', '0000-00-00'),
(6, '001/13', 'Contradictoire', 'RAS', 0, '2013-05-27 00:00:00', 12, 'Acceptée', 0, 'Fondé', '', '', '2013-02-25'),
(7, '1246/13', 'Contradictoire', 'RAS', 0, '0000-00-00 00:00:00', 13, 'Acceptée', 13, 'Fondé', 'Approuvée par ANNO KOUA JUSTIN le : 2013-02-26 14:04:26', 'Approuvée par ANNO KOUA JUSTIN le : 2013-05-16 16:14:27', '2013-05-16'),
(8, '1276', 'Défaut', 'KJGGHKJHG', 11, '0000-00-00 00:00:00', 12, 'Acceptée', 13, 'Partiellement Fondé', 'Approuvée par ANNO KOUA JUSTIN le : 2013-04-02 14:45:24', 'Approuvée par ANNO KOUA JUSTIN le : 2013-05-16 16:18:02', '2013-05-16'),
(9, '13098', 'Défaut', 'LJHLJHJKN', 11, '2013-05-27 19:53:37', 16, 'Acceptée', 13, 'Fondé', 'Approuvée par ANNO KOUA JUSTIN le : 2013-05-27 19:53:37', '', '0000-00-00'),
(10, '000002', 'Défaut', 'KH?GVUYFGUYF', 11, '0000-00-00 00:00:00', 16, 'Acceptée', 13, 'Mal Fondé', 'Approuvée par ANNO KOUA JUSTIN le : 2013-05-27 19:54:19', 'Approuvée par ANNO KOUA JUSTIN le : 2013-05-27 19:55:09', '2013-05-27'),
(11, '56FDB', 'Incompétence', 'DBDFHG', 11, '2013-05-28 10:14:08', 15, 'Acceptée', 13, 'Mal Fondé', 'Approuvée par ANNO KOUA JUSTIN le : 2013-05-28 10:14:08', '', '0000-00-00'),
(12, '2013/11', 'Contradictoire', 'RAS', 11, '2013-05-28 17:31:18', 17, 'Acceptée', 13, 'Fondé', 'Approuvée par ANNO KOUA JUSTIN le : 2013-05-28 17:31:18', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `rep_ordpresi`
--

CREATE TABLE IF NOT EXISTS `rep_ordpresi` (
  `no_ordonnance` int(11) NOT NULL AUTO_INCREMENT,
  `noordonnace_ordonnance` varchar(25) NOT NULL DEFAULT '',
  `dispositif_ordonnance` text NOT NULL,
  `observation_ordonnance` text NOT NULL,
  `lien_fich` varchar(4) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_ordonnance`),
  UNIQUE KEY `noordonnace_ordonnance` (`noordonnace_ordonnance`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `rep_ordpresi`
--

INSERT INTO `rep_ordpresi` (`no_ordonnance`, `noordonnace_ordonnance`, `dispositif_ordonnance`, `observation_ordonnance`, `lien_fich`, `Id_admin`, `date_creation`, `no_rolegeneral`, `id_juridiction`) VALUES
(1, '548454', 'Radiation', 'kjhkjhjjhhj', NULL, 6, '2011-05-10 03:54:14', 1, 54),
(2, '123456O', 'Contradictoire', 'RAS', NULL, 8, '2011-05-11 18:35:01', 4, 14),
(3, '466', 'Radiation', 'U5N', NULL, 11, '2013-04-02 10:48:57', 13, 13);

-- --------------------------------------------------------

--
-- Structure de la table `rg_social`
--

CREATE TABLE IF NOT EXISTS `rg_social` (
  `no_rgsocial` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_rgsocial` varchar(7) NOT NULL,
  `date_rgsocial` date NOT NULL DEFAULT '0000-00-00',
  `demandeur_rgsocial` text NOT NULL,
  `defendeur_rgsocial` text NOT NULL,
  `objet_rgsocial` text NOT NULL,
  `observation_rgsocial` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateaudience_rgsocial` date NOT NULL DEFAULT '0000-00-00',
  `id_categorieaffaire` int(11) NOT NULL DEFAULT '0',
  `chambre_rgsocial` varchar(3) NOT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_rgsocial`),
  UNIQUE KEY `noordre_rolegeneral` (`noordre_rgsocial`),
  UNIQUE KEY `noordre_rgsocial` (`noordre_rgsocial`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_categorieaffaire` (`id_categorieaffaire`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `rg_social`
--

INSERT INTO `rg_social` (`no_rgsocial`, `noordre_rgsocial`, `date_rgsocial`, `demandeur_rgsocial`, `defendeur_rgsocial`, `objet_rgsocial`, `observation_rgsocial`, `Id_admin`, `date_creation`, `dateaudience_rgsocial`, `id_categorieaffaire`, `chambre_rgsocial`, `id_juridiction`) VALUES
(1, '154545', '2011-05-10', 'jkjnjkhjkhj', 'hjhgjhgjhhgh', 'hgvgvhgvhgv vfffffffffffffffffffffff', 'gfhgffdfg gjgjghgh', 6, '2011-05-10 13:43:53', '0011-05-10', 10, '', 54),
(3, 'jhjhjhj', '2011-05-10', 'jhjhjhjhjh', 'jhjhjhjhjh', 'jjhjhjhjhjh', 'hghghghghghg', 6, '2011-05-10 13:28:52', '2011-05-10', 10, '', 54),
(4, 'fdfgfgf', '2011-05-10', 'gfgfgfgfgfgf', 'gfgfgfggfgf', 'gfgfggfgf', 'hhghghghhghg', 6, '2011-05-10 13:29:47', '2011-05-10', 10, '', 54),
(5, 'ggfgfgf', '2011-05-10', 'vgfggfgf', 'gfggfgfgfgf', 'gfgfgfgfgfgffg', 'gfgfgfgfgfgfgf', 6, '2011-05-10 13:32:03', '2011-05-10', 10, '', 54),
(6, '12345', '2013-01-09', 'ANNO', 'KOUA', 'XXXXXX', 'XXXXXXX', 10, '2013-01-09 09:30:46', '0000-00-00', 10, '', 12),
(7, '12345S', '2013-01-15', 'XXXXXXX', 'XXXXXXX', 'XXXXXXX', 'XXXXXXXXX', 11, '2013-01-15 20:19:29', '2013-01-16', 10, '', 14),
(9, '12346S', '2013-01-15', 'XXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXXXX', 'XXXXXXXXXXXXXX', 'XXXXXXXXXXXXXXXXXX', 11, '2013-01-15 20:21:33', '2013-01-16', 10, '', 14),
(10, '1234', '2013-04-03', 'HIH', 'T5ET', 'TTE', 'DYT', 11, '2013-04-03 11:01:45', '2013-04-18', 10, 'CS4', 13),
(11, '75875', '2013-04-08', 'GKUGJHFV', 'MJGIUGLYUF', 'OUGMOUIGIUG', 'OUGIUGT', 4, '2013-04-08 17:07:55', '2013-04-08', 10, 'CS1', 55),
(12, '58758+7', '2013-04-08', 'UGIUGF', 'OIUGMUG', 'IOUGMUOG', 'UGTIUGT', 4, '2013-04-08 17:10:41', '2013-04-03', 10, 'CS1', 55),
(13, 'T765476', '2013-04-08', 'IUGTI£Y', 'UYFTY', 'YTFDTET', 'UYGU£TUYHG', 11, '2013-04-08 17:15:09', '2013-04-08', 10, 'CS1', 13);

-- --------------------------------------------------------

--
-- Structure de la table `role_general`
--

CREATE TABLE IF NOT EXISTS `role_general` (
  `no_rolegeneral` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_rolegeneral` varchar(25) NOT NULL DEFAULT '',
  `date_rolegeneral` date NOT NULL DEFAULT '0000-00-00',
  `demandeur_rolegeneral` text NOT NULL,
  `defendeur_rolegeneral` text NOT NULL,
  `objet_rolegeneral` text NOT NULL,
  `observation_rolegeneral` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateaudience_rolegeneral` date NOT NULL DEFAULT '0000-00-00',
  `section_rolegeneral` varchar(15) NOT NULL DEFAULT '',
  `id_categorieaffaire` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_rolegeneral`),
  UNIQUE KEY `noordre_rolegeneral` (`noordre_rolegeneral`),
  UNIQUE KEY `noordre_rolegeneral_2` (`noordre_rolegeneral`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_categorieaffaire` (`id_categorieaffaire`),
  KEY `Id_admin` (`Id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `role_general`
--

INSERT INTO `role_general` (`no_rolegeneral`, `noordre_rolegeneral`, `date_rolegeneral`, `demandeur_rolegeneral`, `defendeur_rolegeneral`, `objet_rolegeneral`, `observation_rolegeneral`, `Id_admin`, `date_creation`, `dateaudience_rolegeneral`, `section_rolegeneral`, `id_categorieaffaire`, `id_juridiction`) VALUES
(1, '012458', '2011-05-01', 'Anno Justin', 'AKE Arico', 'Déclaration de vol', 'Néant', 6, '2011-05-09 15:37:54', '2011-05-09', '', 4, 54),
(3, '66665', '2011-05-10', 'hjyytyuyt y ty', 'yytytyut uuyyu', 'uyuuyuyuyuy', 'hghghhn, nghhhgh', 6, '2011-05-10 04:51:31', '2011-05-10', '', 0, 54),
(4, '123456', '2011-05-11', 'KAH PATRICE', 'KOFFI MARC', 'LICENCIEMENT ABUSIF', 'RAS', 8, '2011-05-11 18:23:50', '2011-05-20', '', 4, 14),
(5, '123457', '2011-05-11', 'MAMADOU', 'DIALLO', 'CONCURRENCE DELOYALE', 'RAS', 8, '2011-05-11 18:24:50', '2011-05-20', '', 5, 14),
(7, '123458', '2013-01-15', 'KOFFI JACQUES', 'TUO YVES', 'XXXXXXXX', 'XXXXXXX', 11, '2013-01-15 18:28:50', '2013-01-16', '', 4, 14),
(12, '1245/13', '2013-01-16', 'KOUADIO YVES', 'COULIBALY YVES', 'DEMANDE DE DOMMAGE ET INTERET', 'RAS', 11, '2013-01-16 09:51:47', '2013-01-20', '', 4, 13);

-- --------------------------------------------------------

--
-- Structure de la table `t14_membreordre`
--

CREATE TABLE IF NOT EXISTS `t14_membreordre` (
  `T14_CODE` int(11) NOT NULL DEFAULT '0',
  `T14_DESIGNATION` char(50) DEFAULT NULL,
  `T14_ABREVIATION` char(10) DEFAULT NULL,
  PRIMARY KEY (`T14_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t30_fs`
--

CREATE TABLE IF NOT EXISTS `t30_fs` (
  `T30_NUMERO` bigint(20) NOT NULL AUTO_INCREMENT,
  `T30_DATE` datetime DEFAULT NULL,
  `T06_ANNEE` int(11) DEFAULT NULL,
  `T30_MOIS` decimal(10,0) DEFAULT NULL,
  `T30_NBCHAMBRE` decimal(10,0) DEFAULT NULL,
  `T30_NBCHBSPEFAMILLE` decimal(10,0) DEFAULT NULL,
  `T30_NBCHBSPETRAV` decimal(10,0) DEFAULT NULL,
  `T30_NOMSOURCE` varchar(100) DEFAULT NULL,
  `T30_SOURCECONTACT` varchar(30) DEFAULT NULL,
  `T05_CODE` int(11) DEFAULT NULL,
  `T30_NBJI` decimal(10,0) DEFAULT NULL,
  `T30_TRIM` decimal(10,0) DEFAULT NULL,
  `T30_SEM` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`T30_NUMERO`),
  UNIQUE KEY `NONCLUSTERED` (`T30_NUMERO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t31_dfsp`
--

CREATE TABLE IF NOT EXISTS `t31_dfsp` (
  `T31_NUMERO` int(11) NOT NULL AUTO_INCREMENT,
  `T30_NUMERO` bigint(20) DEFAULT NULL,
  `T34_CODE` int(11) DEFAULT NULL,
  `T31_B0_CST_DELCRIM` decimal(10,0) DEFAULT NULL,
  `T31_B0_CST_DELCRIM_EL` decimal(10,0) DEFAULT NULL,
  `T31_B1_PVPLDEN_PV` decimal(10,0) DEFAULT NULL,
  `T31_B1_PV_AUTEURINCONNU` decimal(10,0) DEFAULT NULL,
  `T31_B1_PV_CRIME` decimal(10,0) DEFAULT NULL,
  `T31_B1_PV_DELIT` decimal(10,0) DEFAULT NULL,
  `T31_B1_PV_CONTRAV_INFRACT` decimal(10,0) DEFAULT NULL,
  `T31_B1_AUTRES` decimal(10,0) DEFAULT NULL,
  `T31_B1_PROV_AUTREPARQ` decimal(10,0) DEFAULT NULL,
  `T31_B2_AFF_NON_POURSUIV` decimal(10,0) DEFAULT NULL,
  `T31_B2_AFF_POURSUIV_AP` decimal(10,0) DEFAULT NULL,
  `T31_B2_AP_TJI` decimal(10,0) DEFAULT NULL,
  `T31_B2_AP_TJE` decimal(10,0) DEFAULT NULL,
  `T31_B2_AP_TTC` decimal(10,0) DEFAULT NULL,
  `T31_B2_PROC_ALTER` decimal(10,0) DEFAULT NULL,
  `T31_B2_PROC_CSS` decimal(10,0) DEFAULT NULL,
  `T31_B3_JUGEINST` decimal(10,0) DEFAULT NULL,
  `T31_B3_NOUVELLEAFF` decimal(10,0) DEFAULT NULL,
  `T31_B3_AFFTERMINEE_AT` decimal(10,0) DEFAULT NULL,
  `T31_B3_AT_DUREEMOYTTEAFF` double DEFAULT NULL,
  `T31_B3_AT_DUREEMOY_CRIME` double DEFAULT NULL,
  `T31_B3_AT_DUREEMOYDELIT` double DEFAULT NULL,
  `T31_B3_AT_PERSOMISEEXAMEN` decimal(10,0) DEFAULT NULL,
  `T31_B3_AT_MESURE_DP` decimal(10,0) DEFAULT NULL,
  `T31_B3_DUREEMO_DP_PMD` float DEFAULT NULL,
  `T31_B4_CONDAPRESAPRESDP_CADP` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_CRIME` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_CRIME_DM_1AN` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_CRIME_DM_1_2AN` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_CRIME_DM_2_3AN` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_CRIME_DM_3AN_P` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_CRIME_DM_MOIS` float DEFAULT NULL,
  `T31_B4_CADP_DELIT` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_1_2MOIS` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_2_4MOIS` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_4_8MOIS` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_8_1AN` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_1_2AN` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_2_3AN` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_3AN_P` decimal(10,0) DEFAULT NULL,
  `T31_B4_CADP_DELIT_DM_MOIS` float DEFAULT NULL,
  `T31_B5_MINEURS` decimal(10,0) DEFAULT NULL,
  `T31_B5_MAJEURS` decimal(10,0) DEFAULT NULL,
  `Id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`T31_NUMERO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t35_personneljuridicion`
--

CREATE TABLE IF NOT EXISTS `t35_personneljuridicion` (
  `T35_NUMERO` decimal(20,0) NOT NULL DEFAULT '0',
  `T35_EFFIDEAL` decimal(10,0) DEFAULT NULL,
  `T35_EFFACTUEL` decimal(10,0) DEFAULT NULL,
  `T35_DEPEFF_CR` decimal(10,0) DEFAULT NULL,
  `T35_DEPEFF_CT` decimal(10,0) DEFAULT NULL,
  `T30_NUMERO` decimal(19,0) DEFAULT NULL,
  `T14_CODE` decimal(10,0) DEFAULT NULL,
  UNIQUE KEY `NONCLUSTERED` (`T35_NUMERO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t36_dfscc`
--

CREATE TABLE IF NOT EXISTS `t36_dfscc` (
  `T36_NUMERO` int(11) NOT NULL AUTO_INCREMENT,
  `T30_NUMERO` bigint(20) DEFAULT NULL,
  `T36_NBENROLES` decimal(10,0) DEFAULT NULL,
  `T36_JR_CONTRA` decimal(10,0) DEFAULT NULL,
  `T36_JR_DEF` decimal(10,0) DEFAULT NULL,
  `T36_JR_ACCDEM` decimal(10,0) DEFAULT NULL,
  `T36_JR_REJET` decimal(10,0) DEFAULT NULL,
  `T36_JR_INCOMP` decimal(10,0) DEFAULT NULL,
  `T36_JR_RADIATION` decimal(10,0) DEFAULT NULL,
  `T36_DUREEMOY` float DEFAULT NULL,
  `T36_RAJ` decimal(10,0) DEFAULT NULL,
  `T34_CODE` decimal(10,0) DEFAULT NULL,
  `T36_NBACT` decimal(10,0) DEFAULT NULL,
  `T36_NBAFFPREC` decimal(10,0) DEFAULT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`T36_NUMERO`),
  UNIQUE KEY `NONCLUSTERED` (`T36_NUMERO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `type_juridiction`
--

CREATE TABLE IF NOT EXISTS `type_juridiction` (
  `id_typejuridiction` int(11) NOT NULL DEFAULT '0',
  `lib_typejuridiction` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_typejuridiction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `type_juridiction`
--

INSERT INTO `type_juridiction` (`id_typejuridiction`, `lib_typejuridiction`) VALUES
(1, 'Cour Supreme'),
(2, 'Cours d''appel'),
(3, 'Tribunaux de Première Instance'),
(4, 'SECTIONS DETACHEES'),
(5, 'Inspection Général');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE IF NOT EXISTS `ville` (
  `id_ville` int(11) NOT NULL DEFAULT '0',
  `lib_ville` varchar(50) NOT NULL DEFAULT '',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_ville`),
  KEY `id_juridiction` (`id_juridiction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `administrateurs` (`Id_admin`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
