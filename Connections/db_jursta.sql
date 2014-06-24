-- phpMyAdmin SQL Dump
-- version 3.3.5
-- http://www.phpmyadmin.net
--
-- Serveur: 127.0.0.1
-- Généré le : Lun 27 Août 2012 à 23:23
-- Version du serveur: 5.1.49
-- Version de PHP: 5.3.3



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `db_jursta`
--

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
  PRIMARY KEY (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=10 ;

--
-- Contenu de la table `administrateurs`
--

INSERT INTO `administrateurs` (`Id_admin`, `nom_admin`, `prenoms_admin`, `email_admin`, `sexe_admin`, `datenais_admin`, `login_admin`, `pwd_admin`, `type_admin`, `id_juridiction`, `ajouter_admin`, `modifier_admin`, `supprimer_admin`, `visualiser_admin`, `id_admincreation`, `date_creation`) VALUES
(4, 'Juridiction', 'Ivoiriennes', 'info@jursta.com', 'M', '2011-03-06', 'Admin', 'jursta', 'Superviseur', 55, 1, 1, 1, 1, 0, '2011-03-06'),
(8, 'AGAH', 'Michel', 'agah@yahoo.fr', 'M', '1986-02-13', 'Agah', 'AGAH', 'Administrateur', 12, 0, 0, 0, 1, 4, '2011-05-11'),
(9, 'ANNO', 'JUSTIN', 'anno_justin@yahoo.fr', 'M', '1984-09-27', 'anno', 'ANNO', 'Administrateur', 12, 1, 1, 1, 1, 4, '2012-08-26');

-- --------------------------------------------------------

--
-- Structure de la table `annees`
--

CREATE TABLE IF NOT EXISTS `annees` (
  `annee` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`annee`)
) TYPE=InnoDB;

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
) TYPE=InnoDB;

--
-- Contenu de la table `categorie_affaire`
--

INSERT INTO `categorie_affaire` (`id_categorieaffaire`, `lib_categorieaffaire`, `justice_categorieaffaire`) VALUES
(1, 'Vols, recels, destructions', 'Penale'),
(2, 'Viol, Agression sexuelle', 'Penale'),
(3, 'Coups et blessures volontaires', 'Penale'),
(4, 'Affaire Civile', 'Civile'),
(5, 'Affaire Commerciale', 'Civile'),
(6, 'Affaires Administratives', 'Civile'),
(7, 'Escroquerie, Abus de confiance', 'Penale'),
(8, 'Atteintes aux moeurs', 'Penale'),
(9, 'Circulation routière', 'Penale'),
(10, 'Affaires Sociales', 'Sociale');

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

CREATE TABLE IF NOT EXISTS `commune` (
  `id_commune` char(50) NOT NULL DEFAULT '',
  `lib_commune` char(50) DEFAULT NULL,
  PRIMARY KEY (`id_commune`)
) TYPE=InnoDB;

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
) TYPE=InnoDB;

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
) TYPE=InnoDB;

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
(9, 'TPI Port-Bouet', '', 3, 2, 1872),
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
(30, 'TPI Korhogo', '', 3, 4, 1982),
(31, 'SD Boundiali', 'BOUNDIALI', 4, 30, 0),
(32, 'SD Ferkéssedougou', 'FERKESSEDOUGUO', 4, 30, 0),
(33, 'SD Tengrela', 'TINGRELA', 4, 30, 0),
(34, 'SD Odienné', 'ODIENNE', 4, 30, 0),
(35, 'TPI Daloa', '', 3, 16, 1986),
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
) TYPE=InnoDB AUTO_INCREMENT=1 ;

--
-- Contenu de la table `penitentier`
--


-- --------------------------------------------------------

--
-- Structure de la table `plum_civil`
--

CREATE TABLE IF NOT EXISTS `plum_civil` (
  `id_plumcivil` int(11) NOT NULL AUTO_INCREMENT,
  `presi_plumcivil` varchar(50) NOT NULL DEFAULT '',
  `greffier_plumcivil` varchar(50) NOT NULL DEFAULT '',
  `accesseurs_plumcivil` varchar(50) NOT NULL DEFAULT '',
  `observ_plumcivil` text,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumcivil`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `id_juridiction` (`id_juridiction`)
) TYPE=InnoDB  AUTO_INCREMENT=3 ;

--
-- Contenu de la table `plum_civil`
--

INSERT INTO `plum_civil` (`id_plumcivil`, `presi_plumcivil`, `greffier_plumcivil`, `accesseurs_plumcivil`, `observ_plumcivil`, `Id_admin`, `date_creation`, `no_rolegeneral`, `id_juridiction`) VALUES
(2, '4444', '444', '444', '444', 2, '0000-00-00', 1, 42);

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
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `no_regplaintes` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumpenale`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_regplaintes` (`no_regplaintes`),
  KEY `id_juridiction` (`id_juridiction`)
) TYPE=InnoDB  AUTO_INCREMENT=4 ;

--
-- Contenu de la table `plum_penale`
--

INSERT INTO `plum_penale` (`id_plumpenale`, `dataudience_plumpenale`, `presi_plumpenale`, `greffier_plumpenale`, `accesseurs_plumpenale`, `observ_plumpenale`, `Id_admin`, `date_creation`, `no_regplaintes`, `id_juridiction`) VALUES
(3, '0000-00-00', '444', '444', '444', '444', 2, '0000-00-00', 444, 2);

-- --------------------------------------------------------

--
-- Structure de la table `plum_social`
--

CREATE TABLE IF NOT EXISTS `plum_social` (
  `id_plumsociale` int(11) NOT NULL AUTO_INCREMENT,
  `dataudience_plumsociale` date NOT NULL DEFAULT '0000-00-00',
  `presi_plumsociale` varchar(50) NOT NULL DEFAULT '',
  `greffier_plumsociale` varchar(50) NOT NULL DEFAULT '',
  `accesseurs_plumsociale` varchar(50) NOT NULL DEFAULT '',
  `observ_plumsociale` text,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `no_rgsocial` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_plumsociale`),
  KEY `Id_admin` (`Id_admin`),
  KEY `no_rgsocial` (`no_rgsocial`),
  KEY `id_juridiction` (`id_juridiction`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

--
-- Contenu de la table `plum_social`
--


-- --------------------------------------------------------

--
-- Structure de la table `rcr_externe`
--

CREATE TABLE IF NOT EXISTS `rcr_externe` (
  `no_rcrexterne` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_rcrexterne` varchar(25) NOT NULL DEFAULT '',
  `datedepart_rcrexterne` date NOT NULL DEFAULT '0000-00-00',
  `destinataire_rcrexterne` text NOT NULL,
  `objet_rcrexterne` text NOT NULL,
  `observation_rcrexterne` text NOT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`no_rcrexterne`),
  UNIQUE KEY `noordre_rcrexterne` (`noordre_rcrexterne`),
  KEY `Id_admin` (`Id_admin`),
  KEY `id_juridiction` (`id_juridiction`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `rcr_externe`
--

INSERT INTO `rcr_externe` (`no_rcrexterne`, `noordre_rcrexterne`, `datedepart_rcrexterne`, `destinataire_rcrexterne`, `objet_rcrexterne`, `observation_rcrexterne`, `id_juridiction`, `Id_admin`, `date_creation`) VALUES
(1, '444', '0000-00-00', '4444', '444', '4444', 51, 4, '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `rcr_interne`
--

CREATE TABLE IF NOT EXISTS `rcr_interne` (
  `no_rcrinterne` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_rcrinterne` varchar(25) NOT NULL DEFAULT '',
  `daterecu_rcrinterne` date NOT NULL DEFAULT '0000-00-00',
  `destinataire_rcrinterne` text NOT NULL,
  `objet_rcrinterne` text NOT NULL,
  `observation_rcrinterne` text NOT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`no_rcrinterne`),
  UNIQUE KEY `noordre_rcrinterne` (`noordre_rcrinterne`),
  KEY `Id_admin` (`Id_admin`),
  KEY `id_juridiction` (`id_juridiction`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `rcr_interne`
--

INSERT INTO `rcr_interne` (`no_rcrinterne`, `noordre_rcrinterne`, `daterecu_rcrinterne`, `destinataire_rcrinterne`, `objet_rcrinterne`, `observation_rcrinterne`, `id_juridiction`, `Id_admin`, `date_creation`) VALUES
(1, '4444', '0000-00-00', '4444444', '444444', '444444', 33, 4, '0000-00-00');

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
) TYPE=InnoDB;

--
-- Contenu de la table `region`
--


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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_alphabdet`
--

INSERT INTO `reg_alphabdet` (`no_regalphabdet`, `asphys_regalphabdet`, `sexe_regalphabdet`, `moidat_regalphabdet`, `nomdet_regalphabdet`, `no_ecrou`, `datentre_regalphabdet`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '444', '444', '4444', '4444', 44, '0000-00-00', 44, '0000-00-00 00:00:00', 4);

-- --------------------------------------------------------

--
-- Structure de la table `reg_consignations`
--

CREATE TABLE IF NOT EXISTS `reg_consignations` (
  `no_regconsign` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_regconsign` varchar(25) NOT NULL DEFAULT '',
  `date_regconsign` date NOT NULL DEFAULT '0000-00-00',
  `montant_regconsign` decimal(10,0) NOT NULL DEFAULT '0',
  `decision_regconsign` text NOT NULL,
  `somareclam_regconsign` decimal(10,0) NOT NULL DEFAULT '0',
  `somarestit_regconsign` decimal(10,0) NOT NULL DEFAULT '0',
  `liquidation_regconsign` varchar(25) NOT NULL DEFAULT '',
  `observation_regconsign` varchar(25) NOT NULL DEFAULT '',
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_regconsign`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `Id_admin` (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_consignations`
--

INSERT INTO `reg_consignations` (`no_regconsign`, `noordre_regconsign`, `date_regconsign`, `montant_regconsign`, `decision_regconsign`, `somareclam_regconsign`, `somarestit_regconsign`, `liquidation_regconsign`, `observation_regconsign`, `Id_admin`, `date_creation`, `no_rolegeneral`, `id_juridiction`) VALUES
(1, '556566', '2011-05-15', 14255, 'Contradictoire', 4500, 13500, 'non', 'ras', 6, '2011-05-10 03:43:02', 1, 54);

-- --------------------------------------------------------

--
-- Structure de la table `reg_controlnum`
--

CREATE TABLE IF NOT EXISTS `reg_controlnum` (
  `no_regcontrolnum` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`no_regcontrolnum`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_juridiction_2` (`id_juridiction`),
  KEY `no_regmandat` (`no_regmandat`),
  KEY `Id_admin` (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_controlnum`
--

INSERT INTO `reg_controlnum` (`no_regcontrolnum`, `noordre_regcontrolnum`, `sexe_regcontrolnum`, `date_regcontrolnum`, `nom_regcontrolnum`, `procureur_regcontrolnum`, `naturdelit_regcontrolnum`, `Id_admin`, `date_creation`, `no_regmandat`, `id_juridiction`) VALUES
(1, 25, '444', '0000-00-00', '444', '444', '444', 4, '0000-00-00 00:00:00', 44, 44);

-- --------------------------------------------------------

--
-- Structure de la table `reg_ecrou`
--

CREATE TABLE IF NOT EXISTS `reg_ecrou` (
  `no_ecrou` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_ecrou` varchar(25) NOT NULL DEFAULT '',
  `datnaisdet_ecrou` date DEFAULT NULL,
  `lieunaisdet_ecrou` varchar(50) DEFAULT NULL,
  `peredet_ecrou` varchar(50) DEFAULT NULL,
  `meredet_ecrou` varchar(50) DEFAULT NULL,
  `professiondet_ecrou` varchar(50) DEFAULT NULL,
  `domicildet_ecrou` varchar(50) DEFAULT NULL,
  `tailledet_ecrou` varchar(5) DEFAULT NULL,
  `frontdet_ecrou` varchar(15) DEFAULT NULL,
  `nezdet_ecrou` varchar(10) DEFAULT NULL,
  `bouchedet_ecrou` varchar(15) DEFAULT NULL,
  `teintdet_ecrou` varchar(6) DEFAULT NULL,
  `signepartdet_ecrou` varchar(50) DEFAULT NULL,
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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_ecrou`
--

INSERT INTO `reg_ecrou` (`no_ecrou`, `noordre_ecrou`, `datnaisdet_ecrou`, `lieunaisdet_ecrou`, `peredet_ecrou`, `meredet_ecrou`, `professiondet_ecrou`, `domicildet_ecrou`, `tailledet_ecrou`, `frontdet_ecrou`, `nezdet_ecrou`, `bouchedet_ecrou`, `teintdet_ecrou`, `signepartdet_ecrou`, `datenter_ecrou`, `prolongdet_ecrou`, `decisionjudic_ecrou`, `type_voiederecours`, `datedebutpeine_ecrou`, `dateexpirpeine_ecrou`, `datsortidet_ecrou`, `motifssortidet_ecrou`, `observation_ecrou`, `no_regmandat`, `no_regcontrolnum`, `id_juridiction`, `Id_admin`, `date_creation`) VALUES
(1, '444', '2011-05-20', '444', '444', '444', '44', '44', '44', '44', '44', '44', '44', '44', '0000-00-00', '444', '44', '44', '2011-05-10', '2011-05-10', '2011-05-10', '2011-05-10', '444', 44, 44, 44, 44, '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `reg_execpeine`
--

CREATE TABLE IF NOT EXISTS `reg_execpeine` (
  `noscelles` int(11) NOT NULL AUTO_INCREMENT,
  `nodordre_scelle` varchar(25) NOT NULL DEFAULT '',
  `datedepot_scelle` date NOT NULL DEFAULT '0000-00-00',
  `Nomdeposant_scelle` text NOT NULL,
  `objetsdepose_scelle` text NOT NULL,
  `observation_scelle` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` date NOT NULL DEFAULT '0000-00-00',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`noscelles`),
  UNIQUE KEY `nodordre_scelle` (`nodordre_scelle`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `Id_admin` (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_execpeine`
--

INSERT INTO `reg_execpeine` (`noscelles`, `nodordre_scelle`, `datedepot_scelle`, `Nomdeposant_scelle`, `objetsdepose_scelle`, `observation_scelle`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '44', '0000-00-00', '444', '444', '444', 44, '0000-00-00', 44);

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_mandat`
--

INSERT INTO `reg_mandat` (`no_regmandat`, `noordre_regmandat`, `date_regmandat`, `nom_regmandat`, `magistra_regmandat`, `infraction_regmandat`, `Id_admin`, `date_creation`, `type_regmandat`, `id_juridiction`) VALUES
(1, '44', '0000-00-00', '444', '444', '444', 44, '0000-00-00 00:00:00', '444', 44);

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_objdep`
--

INSERT INTO `reg_objdep` (`no_regobjdep`, `datemd_regobjdep`, `nom_regobjdep`, `som_regobjdep`, `objet_redobjdep`, `observ_regobjdep`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '0000-00-00', '444', '444', '444', '444', 444, '0000-00-00 00:00:00', 444);

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
) TYPE=InnoDB  AUTO_INCREMENT=3 ;

--
-- Contenu de la table `reg_plaintes`
--

INSERT INTO `reg_plaintes` (`no_regplaintes`, `nodordre_plaintes`, `Pautosaisi_plaintes`, `Red_plaintes`, `NomPreDomInculpes_plaintes`, `dateparquet_plaintes`, `NatInfraction_plaintes`, `suite_plaintes`, `MotifClass_plaintes`, `observations_plaintes`, `Id_admin`, `date_creation`, `DatInfraction_plaintes`, `LieuInfraction_plaintes`, `id_categorieaffaire`, `PVdat_plaintes`, `naturesuite_plaintes`, `typepv_plaintes`, `naturecrimes_plaintes`, `procedureautreparquet_plaintes`, `typesaisine_plaintes`, `id_juridiction`) VALUES
(2, '444', '444', '444', '444', '2011-05-10', '444', '444', '444', '444', 44, '2011-05-10 18:44:09', '2011-05-10', '444', 444, '2011-05-10', '444', '444', '444', 444, '444', 44);

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_scelle`
--

INSERT INTO `reg_scelle` (`no_regscel`, `nodordre_regscel`, `datedepo_regscel`, `nomdeposant_regscel`, `objetdepo_regscel`, `observation_regscel`, `Id_admin`, `date_creation`, `id_juridiction`) VALUES
(1, '665636', '2011-05-10', 'hghghhgnhbg', 'ghghghhghghg', 'hghghhghghghg', 6, '2011-05-10 04:21:41', 54);

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `reg_suiviepc`
--

INSERT INTO `reg_suiviepc` (`no_suiviepc`, `no_dordresuiviepc`, `autdorigine_suiviepc`, `nodatepv_suiviepc`, `prevenus_suiviepc`, `naturescelle_suiviepc`, `magasinlieuconserv_suiviepc`, `coffrefortlieuconserv_suiviepc`, `nojugedecision_suiviepc`, `noordonancedestruct_suiviepc`, `noordonanceremisedom_suiviepc`, `daterestitution_suivepc`, `nocnicsrestitution_suiviepc`, `emargementrestitution_suiviepc`, `observation_suiviepc`, `date_creation`, `Id_admin`, `id_juridiction`) VALUES
(1, '444', '444', '444', '444', '444', '444', '444', '444', '444', '444', '0000-00-00', '444', '444', '444', '0000-00-00 00:00:00', 44, 44);

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `rep_actesacc`
--

INSERT INTO `rep_actesacc` (`no_repactesacc`, `nodordre_acc`, `date_acc`, `nomparties_acc`, `designationacte_acc`, `Id_admin`, `date_creation`, `section_rolegeneral`, `id_categorieaffaire`, `id_juridiction`) VALUES
(1, '66888', '2011-05-10', '25', 'Attestation du plumitif', 6, '2011-05-10 04:04:17', '', 4, 54);

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `rep_actesnot`
--

INSERT INTO `rep_actesnot` (`no_repactesnot`, `dateaudience_repactesnot`, `noordre_repactesnot`, `demandeur_repactesnot`, `requerant_repactesnot`, `natdossier_repactesnot`, `Id_admin`, `date_creation`, `id_categorieaffaire`, `section_rolegeneral`, `id_juridiction`) VALUES
(1, '2011-05-10', '01545', 'jhggjhgjhg', 'fhgf gf', 'gfggfgfg gfgfgf', 6, '2011-05-10 03:54:45', 5, 0, 54);

-- --------------------------------------------------------

--
-- Structure de la table `rep_decision`
--

CREATE TABLE IF NOT EXISTS `rep_decision` (
  `no_decision` int(11) NOT NULL AUTO_INCREMENT,
  `nodec_decision` varchar(25) NOT NULL DEFAULT '',
  `dispositif_decision` text NOT NULL,
  `observation_decision` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rgsocial` int(11) NOT NULL DEFAULT '0',
  `statut_decision` varchar(15) NOT NULL DEFAULT '',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_decision`),
  UNIQUE KEY `nojugement_repjugementsupp` (`nodec_decision`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `no_rgsocial` (`no_rgsocial`),
  KEY `Id_admin` (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `rep_decision`
--

INSERT INTO `rep_decision` (`no_decision`, `nodec_decision`, `dispositif_decision`, `observation_decision`, `Id_admin`, `date_creation`, `no_rgsocial`, `statut_decision`, `id_juridiction`) VALUES
(1, '444', '444', '444', 44, '0000-00-00 00:00:00', 44, '444', 44);

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
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Contenu de la table `rep_jugementcorr`
--

INSERT INTO `rep_jugementcorr` (`no_repjugementcorr`, `nojugement_repjugementcorr`, `datejugement_repjugementcorr`, `no_regplaintes`, `naturedecision_repjugementcorr`, `decisiontribunal_repjugementcorr`, `Id_admin`, `date_creation`, `id_juridiction`, `nomsprevenu_repjugementcorr`, `infraction_repjugementcorr`) VALUES
(1, 'hhjghjhj', '2011-05-10', 0, 'jhjhjhjh', 'jhjhjhjhjh', 6, '2011-05-10 04:30:04', 54, 'jhjhjhjhjh', 'jhjhjjhj');

-- --------------------------------------------------------

--
-- Structure de la table `rep_jugementsupp`
--

CREATE TABLE IF NOT EXISTS `rep_jugementsupp` (
  `no_repjugementsupp` int(11) NOT NULL AUTO_INCREMENT,
  `nojugement_repjugementsupp` varchar(25) NOT NULL DEFAULT '',
  `dispositif_repjugementsupp` text NOT NULL,
  `observation_repjugementsupp` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `statut_jugementsupp` varchar(15) NOT NULL DEFAULT '',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_repjugementsupp`),
  UNIQUE KEY `nojugement_repjugementsupp` (`nojugement_repjugementsupp`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `Id_admin` (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=3 ;

--
-- Contenu de la table `rep_jugementsupp`
--

INSERT INTO `rep_jugementsupp` (`no_repjugementsupp`, `nojugement_repjugementsupp`, `dispositif_repjugementsupp`, `observation_repjugementsupp`, `Id_admin`, `date_creation`, `no_rolegeneral`, `statut_jugementsupp`, `id_juridiction`) VALUES
(1, ' 	012458', 'Incompetence', 'nhjhjkhj', 6, '2011-05-10 03:53:38', 1, 'Acceptée', 54),
(2, '123456J', 'Contradictoire', 'RAS', 8, '2011-05-11 18:32:53', 4, 'Acceptée', 14);

-- --------------------------------------------------------

--
-- Structure de la table `rep_ordpresi`
--

CREATE TABLE IF NOT EXISTS `rep_ordpresi` (
  `no_ordonnance` int(11) NOT NULL AUTO_INCREMENT,
  `noordonnace_ordonnance` varchar(25) NOT NULL DEFAULT '',
  `dispositif_ordonnance` text NOT NULL,
  `observation_ordonnance` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `no_rolegeneral` int(11) NOT NULL DEFAULT '0',
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_ordonnance`),
  UNIQUE KEY `noordonnace_ordonnance` (`noordonnace_ordonnance`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `no_rolegeneral` (`no_rolegeneral`),
  KEY `Id_admin` (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=3 ;

--
-- Contenu de la table `rep_ordpresi`
--

INSERT INTO `rep_ordpresi` (`no_ordonnance`, `noordonnace_ordonnance`, `dispositif_ordonnance`, `observation_ordonnance`, `Id_admin`, `date_creation`, `no_rolegeneral`, `id_juridiction`) VALUES
(1, '548454', 'Radiation', 'kjhkjhjjhhj', 6, '2011-05-10 03:54:14', 1, 54),
(2, '123456O', 'Contradictoire', 'RAS', 8, '2011-05-11 18:35:01', 4, 14);

-- --------------------------------------------------------

--
-- Structure de la table `rg_social`
--

CREATE TABLE IF NOT EXISTS `rg_social` (
  `no_rgsocial` int(11) NOT NULL AUTO_INCREMENT,
  `noordre_rgsocial` varchar(25) NOT NULL DEFAULT '',
  `date_rgsocial` date NOT NULL DEFAULT '0000-00-00',
  `demandeur_rgsocial` text NOT NULL,
  `defendeur_rgsocial` text NOT NULL,
  `objet_rgsocial` text NOT NULL,
  `observation_rgsocial` text NOT NULL,
  `Id_admin` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateaudience_rgsocial` date NOT NULL DEFAULT '0000-00-00',
  `id_categorieaffaire` int(11) NOT NULL DEFAULT '0',
  `section_rgsocial` text NOT NULL,
  `id_juridiction` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`no_rgsocial`),
  UNIQUE KEY `noordre_rolegeneral` (`noordre_rgsocial`),
  KEY `id_juridiction` (`id_juridiction`),
  KEY `id_categorieaffaire` (`id_categorieaffaire`),
  KEY `Id_admin` (`Id_admin`)
) TYPE=InnoDB  AUTO_INCREMENT=6 ;

--
-- Contenu de la table `rg_social`
--

INSERT INTO `rg_social` (`no_rgsocial`, `noordre_rgsocial`, `date_rgsocial`, `demandeur_rgsocial`, `defendeur_rgsocial`, `objet_rgsocial`, `observation_rgsocial`, `Id_admin`, `date_creation`, `dateaudience_rgsocial`, `id_categorieaffaire`, `section_rgsocial`, `id_juridiction`) VALUES
(1, '154545', '2011-05-10', 'jkjnjkhjkhj', 'hjhgjhgjhhgh', 'hgvgvhgvhgv vfffffffffffffffffffffff', 'gfhgffdfg gjgjghgh', 6, '2011-05-10 13:43:53', '0011-05-10', 10, '', 54),
(3, 'jhjhjhjh', '2011-05-10', 'jhjhjhjhjh', 'jhjhjhjhjh', 'jjhjhjhjhjh', 'hghghghghghg', 6, '2011-05-10 13:28:52', '2011-05-10', 10, '', 54),
(4, 'fdfgfgfggf', '2011-05-10', 'gfgfgfgfgfgf', 'gfgfgfggfgf', 'gfgfggfgf', 'hhghghghhghg', 6, '2011-05-10 13:29:47', '2011-05-10', 10, '', 54),
(5, 'ggfgfgfg', '2011-05-10', 'vgfggfgf', 'gfggfgfgfgf', 'gfgfgfgfgfgffg', 'gfgfgfgfgfgfgf', 6, '2011-05-10 13:32:03', '2011-05-10', 10, '', 54);

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
) TYPE=InnoDB  AUTO_INCREMENT=6 ;

--
-- Contenu de la table `role_general`
--

INSERT INTO `role_general` (`no_rolegeneral`, `noordre_rolegeneral`, `date_rolegeneral`, `demandeur_rolegeneral`, `defendeur_rolegeneral`, `objet_rolegeneral`, `observation_rolegeneral`, `Id_admin`, `date_creation`, `dateaudience_rolegeneral`, `section_rolegeneral`, `id_categorieaffaire`, `id_juridiction`) VALUES
(1, '012458', '2011-05-09', 'Anno Justin', 'AKE Arico', 'Déclaration de vol', 'Néant', 6, '2011-05-09 15:37:54', '2011-05-09', '', 4, 54),
(3, '66665', '2011-05-10', 'hjyytyuyt y ty', 'yytytyut uuyyu', 'uyuuyuyuyuy', 'hghghhn, nghhhgh', 6, '2011-05-10 04:51:31', '2011-05-10', '', 0, 54),
(4, '123456', '2011-05-11', 'KAH PATRICE', 'KOFFI MARC', 'LICENCIEMENT ABUSIF', 'RAS', 8, '2011-05-11 18:23:50', '2011-05-20', '', 4, 14),
(5, '123457', '2011-05-11', 'MAMADOU', 'DIALLO', 'CONCURRENCE DELOYALE', 'RAS', 8, '2011-05-11 18:24:50', '2011-05-20', '', 5, 14);

-- --------------------------------------------------------

--
-- Structure de la table `t14_membreordre`
--

CREATE TABLE IF NOT EXISTS `t14_membreordre` (
  `T14_CODE` int(11) NOT NULL DEFAULT '0',
  `T14_DESIGNATION` char(50) DEFAULT NULL,
  `T14_ABREVIATION` char(10) DEFAULT NULL,
  PRIMARY KEY (`T14_CODE`)
) TYPE=InnoDB;

--
-- Contenu de la table `t14_membreordre`
--


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
) TYPE=InnoDB AUTO_INCREMENT=1 ;

--
-- Contenu de la table `t30_fs`
--


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
) TYPE=InnoDB AUTO_INCREMENT=1 ;

--
-- Contenu de la table `t31_dfsp`
--


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
) TYPE=InnoDB;

--
-- Contenu de la table `t35_personneljuridicion`
--


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
) TYPE=InnoDB AUTO_INCREMENT=1 ;

--
-- Contenu de la table `t36_dfscc`
--


-- --------------------------------------------------------

--
-- Structure de la table `type_juridiction`
--

CREATE TABLE IF NOT EXISTS `type_juridiction` (
  `id_typejuridiction` int(11) NOT NULL DEFAULT '0',
  `lib_typejuridiction` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_typejuridiction`)
) TYPE=InnoDB;

--
-- Contenu de la table `type_juridiction`
--

INSERT INTO `type_juridiction` (`id_typejuridiction`, `lib_typejuridiction`) VALUES
(1, 'Cour Supreme'),
(2, 'Cours d''appel'),
(3, 'Tribunaux de Première Instance'),
(4, 'Sections Détachées'),
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
) TYPE=InnoDB;

--
-- Contenu de la table `ville`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `administrateurs` (`Id_admin`);
