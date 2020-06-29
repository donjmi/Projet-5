-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Version du serveur :  10.4.8-MariaDB
-- Version de PHP :  7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- -----------------------------------------------------
-- Schema blog
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS blog ;

-- -----------------------------------------------------
-- Schema blog
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS blog DEFAULT CHARACTER SET utf8 ;
USE blog ;

-- --------------------------------------------------------

--
-- Structure de la table articles
--

CREATE TABLE articles (
  id tinyint(3) UNSIGNED NOT NULL,
  title varchar(250) NOT NULL,
  slug varchar(255) NOT NULL,
  content longtext NOT NULL,
  date_creation datetime DEFAULT NULL,
  url_images text DEFAULT NULL,
  update_article date NOT NULL,
  user_id smallint(11) NOT NULL,
  posted tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table articles
--

INSERT INTO articles (id, title, slug, content, date_creation, url_images, update_article, user_id, posted) VALUES
(4, 'Arrow : Stargirl', 'Une nouvelle héroïne DC Comics rejoint l’Arrowverse.', 'Le nouveau cross-over de l’Arrowverse va-t-il accueillir une toute nouvelle recrue dans l&#38;#38;#38;#39;univers connecté DC Comics ? Nos confrères du site Business Insider révèlent en effet que l’héroïne Stargirl fera une apparition dans l’épisode spécial intitulé Crisis on Infinite Earths ; si l’héroïne ne devrait apparaître qu’au détour d’une simple scène, cette courte introduction préfigure toutefois de quelques mois le lancement de sa propre série, tout d&#38;#38;#38;#39;abord sur la plate-forme DC Universe puis sur la chaîne CW aux Etats-Unis.  Incarnée par Brec Bassinger (Bella et les Bulldogs), Stargirl est un super-héroïne aux pouvoirs cosmiques, dont l’alter-ego est une jeune lycéenne vivant dans l’ombre de son beau-père (Luke Wilson), lui-même ancien side-kick de Starman (Joel McHale), le célèbre héros de la Société de justice d&#38;#38;#38;#39;Amérique. Et bien que ses aventures soient parties intégrantes de l’Arrowverse, il semblerait toutefois que l’action du show se déroulera dans un tout autre univers que celui des séries Supergirl, Flash, Batwoman etc.  Les trois premières parties de Crisis on Infinite Earths seront diffusées aux Etats-Unis les 8, 9 et 10 décembre prochains suivies un mois plus tard - le 14 janvier 2020 - d’un double-épisode final.  L&#38;#38;#38;#39;ultime saison d&#38;#38;#38;#39;Arrow est diffusée chez nous en exclusivité sur Netflix :', '2020-05-24 20:45:18', 'http://fr.web.img3.acsta.net/r_640_360/newsv7/19/11/22/09/51/5705967.jpg', '2020-06-22', 1, 1),
(5, 'The Baker  the Beauty ', 'Un trailer pour la nouvelle comédie romantique d’ABC qui débarque en avril', 'Amour, célébrités et pâtisserie. Voilà ce qui est au programme de The Baker and The Beauty, la nouvelle comédie romantique de la chaine américaine ABC et adaptation de la série israélienne éponyme. Cette dernière se dévoile à l’aide d’une bande-annonce avant son arrivée sur le petit écran, annoncée pour le 13 avril 2020.  Plus précisément, The Baker and The Beauty s’intéresse à Daniel Garcia (Victor Rasuk), un boulanger de classe moyenne et fils d’immigrés cubains qui fait tout pour aider ses parents et ses frères et sœurs. Lorsqu’une soirée à Miami en compagnie de sa petite-amie tourne à la rupture, Daniel fait la connaissance de Noa Hamilton (Nathalie Kelley), star internationale.  Alors que les deux développent une relation, la vie de Daniel se retrouve sous le feu des projecteurs, avec tous les avantages et inconvénients que cela implique.', '2020-05-24 18:08:06', 'https://www.nouveautes-tele.com/wp-content/uploads/2020/01/baker-beauty.jpg', '2020-06-21', 1, 1),
(6, 'Hunters', 'Des groupes de chasseurs de nazis, dans l\'Amérique des années 1970, sont en quête de justice et assoiffés de vengeance', 'Des groupes de chasseurs de nazis, dans l&#39;Amérique des années 1970, sont en quête de justice et assoiffés de vengeance.Ils vont traquer et tuer des centaines de nazis qui, avec l&#39;aide du gouvernement américain, ont échappé aux forces de l&#39;ordre et ont réussi à se fondre dans la société.Personnages principaux :    Al Pacino (VF : José Luccioni) : Meyer Offerman    Logan Lerman (VF : Nathanel Alimi) : Jonah Heidelbaum    Kate Mulvany (VF : Cathy Diraison) : Soeur Harriet / Rebecca Crowtser    Tiffany Boone : Roxy Jones   Carol Kane : Mindy Markowitz    Saul Rubinek (VF : Paul Borne) : Murray Markowitz    Josh Radnor (VF : Xavier Béja) : Lonny Flash  Louis Ozawa Changchien : Joe Torrance   Jerrika Hinton (VF : Virginie Emane) : Millie Morris   Greg Austin : Travis Leich   Dylan Baker (VF : Pierre Tessier) : Biff Simpson    Lena Olin : Le Colonel / Eva Braun', '2019-06-29 22:05:01', 'http://fr.web.img4.acsta.net/c_216_288/pictures/20/01/06/09/11/1833037.jpg', '2020-06-27', 1, 1),
(7, 'The Originals - Saison 2', 'Niklaus Mikaelson retourne à la Nouvelle-Orléans pour détrôner l\'un de ses anciens protégés, Marcel, qui règne sur la ville', 'Niklaus Mikaelson retourne à la Nouvelle-Orléans pour détrôner l\'un de ses anciens protégés, Marcel, qui règne sur la ville qu\'il a créée en son absence. Klaus est également surpris de voir que Marcel est toujours en vie alors qu\'il le pensait mort lors de l\'incendie en 1919 qui a brulé la ville entière. À son retour, Klaus s\'aperçoit que beaucoup de choses ont changé : les sorcières n\'ont plus le droit de pratiquer de la magie, les loups-garous ont été exclus de la ville et les vampires règnent à présent en maîtres. Il apprend également qu\'un enfant a été conçu à la suite d\'une aventure qu\'il a eue avec Hayley Marshall, une louve-garou.\r\nMon Avis : Cette saison est sous le signe de la famille. En effet, on savait déjà que le père Michaelson était de retour grâce (ou à cause) de Davina. Cette seconde saison confirme également le retour de la mère des Originels. Rappelons que cette femme est une sorcière et qu\'elle promène son esprit d\' un corps à un autre. Avec elle, on retrouve deux autres frères Miachaelson ramenés à la vie dans le corps de sorciers. Et je ne parle pas de la tante et de la soeur disparue des années avant leur transformation en vampires (voire même avant la naissance de certains). Bref, la famille Michaelson est le centre des problèmes pour cette saison.\r\nJe ne sais pas quoi penser de cette saison. En soit, elle était sympa mais il y a un petit truc qui m\'a gêné. J\'avoue que je ne saurais pas dire quoi. Peut être le fait que tout tourne autour de la famille Michaelson. Bon, cela a toujours été le cas mais là, c\'est plus flagrant puisqu\'ils sont tous au coeur de l\'intrigue. Entre le père qui veut tuer Klaus, la mère qui veut réunir ses enfants, la soeur qui réapparaît très fraîche, des années après sa prétendue mort et la tante tarée qui revendique le premier né de chaque génération Michaelson. Bref, c\'est le bazar.Honnêtement, je pense que c\'était trop. Que l\'on soit centré sur la famille ne me pose pas de problème. Mais, c\'était trop d\\\'intrigues pour une seule saison. ', '2019-06-29 22:06:00', 'https://resize.over-blog.com/400x400-ct.jpg?https://img.over-blog-kiwi.com/1/93/60/21/20200219/ob_a4112d_385654-the-originals-saison-2-un-nouve.jpg#width=623&height=362', '0000-00-00', 2, 1),
(8, 'Katy Keene sur CW avec Lucy Hale et Ashleigh Murray', 'C’est le spin off de Riverdale et Chilling Adventures Of Sabrina. C’est l’histoire d’une lycéenne intelligente qui a tout pour devenir une super détective.', 'Katy Keene est une série télévisée américaine développée par Roberto Aguirre-Sacasa et Michael Grassi, diffusée depuis le 6 février 20201 sur le réseau The CW et en simultané sur W Network2 au Canada.\r\n\r\nLa série est basée sur les personnages de l\'éditeur Archie Comics, principalement sur ceux des publications centrées sur Katy Keene et Josie et les Pussycats. Elle se déroule dans un univers partagé comprenant plusieurs séries mettant en scène des personnages d\'Archie Comics et démarré avec la série télévisée Riverdale, dans laquelle les personnages de Josie McCoy et Katy Keene ont été introduits3. \r\n\r\nSynopsis:\r\nC’est le spin off de Riverdale et Chilling Adventures Of Sabrina.\r\nC’est l’histoire d’une lycéenne intelligente qui a tout pour devenir une super détective. Elle tente de résoudre le mystère d’une maison hantée avec George et Bess ses amis.\r\n\r\nActeurs principaux:\r\n    Lucy Hale : Katy Keene\r\n    Ashleigh Murray : Josephine « Josie » McCoy\r\n    Katherine LaNasa : Gloria Grandbilt\r\n    Julia Chan (en) : Pepper Smith\r\n    Jonny Beauchamp : Jorge Lopez / Ginger Lopez\r\n    Lucien Laviscount : Alexander Cabot III\r\n    Zane Holtz : K.O Kelly\r\n    Camille Hyde : Alexandra Cabot', '2019-06-29 22:07:01', 'https://www.nouveautes-tele.com/wp-content/uploads/2019/05/katykeene.jpg', '0000-00-00', 2, 1),
(9, 'MINDHUNTER (SAISON 1 ET 2)', 'Nous sommes en 1977. Deux agents du FBI associés à une psychologue tentent de comprendre comment fonctionnent les plus grands criminels de leur époque. C’est la genèse du BAU.', 'Mindhunter est une série télévisée américaine créée par Joe Penhall, produite par David Fincher et Charlize Theron, qui est diffusée sur Netflix à partir du 13 octobre 20171. Elle s&#39;inspire des livres Mindhunter : Dans la tête d’un profileur et Le tueur en face de moi (parution française en novembre 2019) écrits par John E. Douglas2 et Mark Olshaker, éditions Michel Lafon. Avant même la diffusion de sa première saison, la série a été renouvelée pour une seconde saison3. Synopsis :Nous sommes en 1977. Deux agents du FBI associés à une psychologue tentent de comprendre comment fonctionnent les plus grands criminels de leur époque. C’est la genèse du BAU.John Reese, ancien militaire devenu agent de la CIA est porté disparu et présumé mort. Mais voilà qu’il vient d’être engagé par Harold Finch, un informaticien milliardaire, pour assurer de mystérieuses missions : chaque jour ils reçoivent un numéro de sécurité sociale, ils doivent découvrir à qui il appartient et protéger cette personne. Seulement voilà : ils ne savent pas si cette personne sera la victime ou si elle est le criminel…Acteurs principaux :    Jonathan Groff (VF : Marc Arnaud) : Holden Ford, agent spécial du FBI    Holt McCallany (VF : Thierry Hancisse) : Bill Tench, agent spécial du FBI    Anna Torv (VF : Odile Cohen) : Wendy Carr, psychologue et universitaire    Stacey Roca (en) (VF : Vanina Pradier) : Nancy Tench, épouse de Bill Tench (saison 2, récurrente saison 1)    Joe Tuttle (VF : Jean-Christophe Dollé) : Greg Smith, agent spécial du FBI (saison 2, récurrent saison 1)    Albert Jones (VF : Frantz Confiac) : Jim Barney (saison 2, invité saison 1)    Michael Cerveris (VF : Christian Gonon) : Ted Gunn (saison 2)    Lauren Glazier (en) (VF : Karine Texier) : Kay Manz (saison 2)    Sierra McClain (en) (VF : Déborah Claude) : Tanya Clifton (saison 2)    June Carryl (VF : Viginie Emane) : Camille Bell (saison 2)', '2019-09-28 17:33:02', 'http://img.over-blog-kiwi.com/2/86/87/34/20191015/ob_75a69e_index.jpg#width=194&height=259', '2020-05-24', 1, 1),
(10, 'The Mandalorian', 'L\'univers de Star Wars se déroule dans une galaxie qui est le théâtre d\'affrontements entre les Chevaliers Jedi et les Seigneurs noirs des Sith', 'L\'univers de Star Wars se déroule dans une galaxie qui est le théâtre d\'affrontements entre les Chevaliers Jedi et les Seigneurs noirs des Sith, personnes sensibles à la Force, un champ énergétique mystérieux leur procurant des pouvoirs psychiques. \r\nLes Jedi maîtrisent le côté lumineux de la Force, pouvoir bénéfique et défensif, pour maintenir la paix dans la galaxie. Les Sith utilisent le côté obscur, pouvoir nuisible et destructeur, pour leurs usages personnels et pour dominer la galaxie3.\r\nAprès la chute de l\'Empire et la fondation de la Nouvelle République, le métier de chasseur de primes ne paie plus. Le Mandalorien, surnommé Mando, connu pour être un des plus redoutables chasseurs de primes, accepte un contrat non officiel. s\'agit pour lui, moyennant une prime élevée, de retrouver et de ramener à ses commanditaires un être vivant de 50 ans. En cours de mission, Mando découvre que, malgré son âge c\'est un bébé ou un enfant de la même espèce que Yoda (espèce dont la durée de vie est de plusieurs siècles). \r\nIl découvre aussi que sa cible maîtrise déjà la Force. Après avoir rempli son contrat auprès d\'un vieil homme portant une insigne de l\'Empire entouré de nombreux Stormtroopers, et touché la prime, le Mandalorien se ravise, et revient sauver l\'Enfant. Il doit ensuite prendre la fuite avec lui, poursuivi par tout ce que la galaxie compte de chasseurs de primes lancés à leurs trousses…\'', '2019-10-01 21:26:21', 'https://fr.web.img5.acsta.net/c_216_288/pictures/19/10/29/09/05/3954913.jpg', '0000-00-00', 1, 1),
(29, 'tyoyoyoyo', 'Yyooyoyoyoyo', 'rtrtrt ttttttttttttttttttt', '2020-05-24 21:55:34', '', '2020-06-19', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table comments
--

CREATE TABLE comments (
  id int(11) NOT NULL,
  posts_id tinyint(3) UNSIGNED NOT NULL,
  user_id tinyint(4) NOT NULL,
  comment text NOT NULL,
  date_comment datetime NOT NULL,
  validate tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table comments
--

INSERT INTO comments (id, posts_id, user_id, comment, date_comment, validate) VALUES
(1, 10, 1, 'voici un commentaire', '2020-03-31 00:17:51', 1),
(12, 4, 2, 'c\'est bien', '2020-04-03 12:44:49', 1),
(14, 10, 2, 'pascal', '2020-04-06 16:02:14', 1),
(36, 10, 2, 'encore moi', '2020-04-18 19:53:34', 1),
(76, 10, 1, 'test', '2020-05-11 02:10:58', 0),
(103, 8, 1, 'yep', '2020-06-27 00:27:19', 0);

-- --------------------------------------------------------

--
-- Structure de la table users
--

CREATE TABLE users (
  id tinyint(4) NOT NULL,
  pseudo varchar(80) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  role varchar(55) NOT NULL DEFAULT 'modo',
  token varchar(255) NOT NULL,
  validate int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table users
--

INSERT INTO users (id, pseudo, email, password, role, token, validate) VALUES
(1, 'Administrator', 'ad@min.fr', '$2y$10$cy6Pb/E.rL8d4n4KDNJFAu9/.WKwKGysVAKrApvhjdARMwHp98x1C', 'admin', '', 1),
(2, 'teddy', 'ted@teddy.fr', '$2y$10$A4dvJ3C5woHP3ZwS1DmuMOLL6gYVwGES2b228u9Tdye8tDMXkuFui', 'admin', '', 1),
(3, 'changeTo', '2jordan@nike.fr', '$2y$10$CzmBq0QAgcG8PPPTARAuRO1F2PF/PJDZP8jGxkyqT/aPpvwXv4xrK', 'member', '', 1),
(4, 'jordanM', 'jordan@nike.fr', '$2y$10$RmUnmJIGtA1bCM3blygzH.dEaJWKTBpN7ZHvkp8zY3hURqUWTsHEi', 'member', '', 0),
(7, 'Sabine77', '1@1.fr', '$2y$10$dnFfaYukhr4ZN2FV5eQRUeln3nVWng0FYs1Jv8DGn7Se0i0vhV/Se', 'member', '', 1),
(21, 'jimmy2', 'jldonne@gmail.com', '$2y$10$JfT8GxD69WBTGtwR7Q1gFugLZM99EZDIl7ujaVw0QvxLn9PofJ3dq', 'member', '', 1),
(22, 'ment@r', 'men@tor.fr', '$2y$10$1JUO0BHAJJtojM5/Prb70.sfl233Zi1QhGWY4Tj7HpIV7CxL9rNz2', 'admin', '', 1),
(23, 'donjmi', 'j.lavidange@ville-pantin.fr', '$2y$10$eOWIN.u4Sh44ezRphlM9r.7mhXqgW3.OLNden3RiXsqIt2Lx2vFvq', 'member', '54LdS6GaytY3WSZ', 0),
(24, 'jimmy', 'familleldonne@gmail.com', '$2y$10$rnNEqOGw7D1sXnq3rX5WJOfJdIvTKqPkaoktZX1gwWpek0Ns2nHna', 'member', '', 1),
(25, 'Sabine', 'ellivud@gmail.com', '$2y$10$/PD4RGiNX0UptNRMR0yL/uMMk6lwXAEPr0jwwoALFUgB5bi1e02vG', 'member', '', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table articles
--
ALTER TABLE articles
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY id (id);

--
-- Index pour la table comments
--
ALTER TABLE comments
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY id (id),
  ADD KEY posts_id (posts_id),
  ADD KEY fk_comments_users (user_id);

--
-- Index pour la table users
--
ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY id (id,email);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table articles
--
ALTER TABLE articles
  MODIFY id tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table comments
--
ALTER TABLE comments
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT pour la table users
--
ALTER TABLE users
  MODIFY id tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table comments
--
ALTER TABLE comments
  ADD CONSTRAINT fk_comment_Article FOREIGN KEY (posts_id) REFERENCES articles (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT fk_comments_users FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
