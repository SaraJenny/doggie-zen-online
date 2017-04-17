-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 13 mars 2016 kl 10:48
-- Serverversion: 10.0.17-MariaDB
-- PHP-version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `online`
--

DELIMITER $$
--
-- Funktioner
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getClassName` (`id` INT) RETURNS VARCHAR(50) CHARSET latin1 BEGIN
DECLARE name varchar(50);
SELECT className INTO name FROM class WHERE classId = id;
RETURN name;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellstruktur `class`
--

CREATE TABLE `class` (
  `classId` tinyint(5) NOT NULL,
  `className` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `class`
--

INSERT INTO `class` (`classId`, `className`) VALUES
(1, 'PeanutFUN'),
(2, 'K9 X-training'),
(3, 'Klick & trick'),
(4, 'FITBone'),
(5, 'Balanskurs'),
(6, 'Reaktiva hundar');

-- --------------------------------------------------------

--
-- Tabellstruktur `comment`
--

CREATE TABLE `comment` (
  `commentId` tinyint(100) NOT NULL,
  `userId` tinyint(5) NOT NULL,
  `content` text NOT NULL,
  `commentDate` datetime NOT NULL,
  `postId` tinyint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `comment`
--

INSERT INTO `comment` (`commentId`, `userId`, `content`, `commentDate`, `postId`) VALUES
(1, 2, 'Kommentar 1', '2015-05-15 01:05:23', 1),
(2, 1, 'Svar 1', '2015-05-16 08:12:54', 1),
(3, 1, 'Kommentar2', '2015-06-02 10:32:23', 4),
(4, 3, 'Kommentar3', '2016-01-22 19:45:03', 5),
(5, 1, 'Kommentar4', '2016-01-26 13:58:19', 10),
(6, 2, 'Kommentar5', '2016-02-12 11:23:44', 10),
(7, 1, 'Kommentar6', '2016-02-12 16:17:36', 10),
(8, 1, 'Kommentar7', '2016-02-12 17:32:48', 12),
(9, 2, 'Kommentar8', '2016-02-14 22:32:21', 5),
(10, 3, 'Svar på kommentar 7', '2016-02-15 09:56:28', 12),
(11, 1, 'Kommentar9', '2016-02-29 14:45:56', 14),
(12, 1, 'Kommentar10', '2016-03-01 15:15:34', 13),
(13, 1, 'Kommentar11', '2016-03-06 08:38:59', 15),
(14, 2, 'Svar på kommentar 11', '2016-03-06 23:12:54', 15),
(18, 10, 'En kommentar från Linda', '2016-03-10 10:12:34', 9),
(19, 4, 'Ytterligare en kommentar', '2016-03-10 14:00:49', 9),
(20, 4, 'Ytterligare en kommentar\n\nÃ„ven med mellanrum', '2016-03-10 14:01:01', 9),
(21, 4, 'En kommentar', '2016-03-10 15:13:36', 10),
(22, 4, 'En kommentar till', '2016-03-10 15:15:27', 14),
(23, 4, 'En kommentar', '2016-03-10 15:16:13', 11),
(24, 1, 'En kommentar', '2016-03-10 19:56:05', 25),
(25, 1, 'Ytterligare en kommentar', '2016-03-10 20:00:19', 25),
(26, 1, 'asdad', '2016-03-10 20:00:48', 25),
(27, 1, 'regegsd', '2016-03-10 20:01:25', 25),
(28, 1, 'ergerg', '2016-03-10 20:01:39', 25),
(29, 1, 'gaegdfg', '2016-03-10 20:02:24', 25),
(30, 1, 'dssfafs', '2016-03-10 20:05:59', 25),
(31, 1, 'sdfghgsga dgdf gsdg df', '2016-03-10 20:06:54', 24),
(32, 1, 'asfdsgasdg', '2016-03-10 20:07:50', 24),
(33, 1, 'agfSDFSADSF', '2016-03-10 20:08:22', 24),
(34, 1, 'ASDASDADsdfsdf', '2016-03-10 20:08:51', 24),
(35, 7, 'HÃ¤r Ã¤r en kommentar.\n\nDetta Ã¤r skrivit 2 rader ner.', '2016-03-11 13:55:10', 33),
(36, 7, '&lt;p&gt;En p-tagg&lt;/p&gt;\n&lt;br&gt;\n&lt;strong&gt;STRONG&lt;/strong&gt;', '2016-03-11 14:15:54', 21),
(37, 7, 'Rad 1\n\nRad 3\nRad 4', '2016-03-11 14:19:17', 21),
(38, 7, 'Rad 1\n\nRad 3\nRad 4', '2016-03-11 14:19:52', 21),
(39, 7, 'Rad 1\n\nRad 3\nRad 4', '2016-03-11 14:21:20', 21),
(40, 7, '&lt;p&gt;P-tagg&lt;/p&gt;\n&lt;em&gt;em&lt;/em&gt;\n\n&lt;h2&gt;rubrik 2&lt;/h2&gt;', '2016-03-11 14:23:55', 21),
(41, 7, 'En kommentar direkt med i diven', '2016-03-11 14:29:46', 21);

-- --------------------------------------------------------

--
-- Tabellstruktur `curriculum`
--

CREATE TABLE `curriculum` (
  `classCode` varchar(7) NOT NULL,
  `classId` tinyint(5) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `closingDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `curriculum`
--

INSERT INTO `curriculum` (`classCode`, `classId`, `startDate`, `endDate`, `closingDate`) VALUES
('1PF1505', 1, '2015-05-12', '2015-06-14', '2015-12-14'),
('1PF1602', 1, '2016-02-25', '2016-04-25', '2016-10-25'),
('1PF1605', 1, '2016-05-14', '2016-07-16', '2017-01-16'),
('1PF1608', 1, '2016-08-01', '2016-09-05', '2017-03-05'),
('2XT1601', 2, '2016-01-18', '2016-02-29', '2016-08-29'),
('2XT1606', 2, '2016-06-05', '2016-07-10', '2017-01-10'),
('2XT1608', 2, '2016-08-01', '2016-09-05', '2017-03-05'),
('3KT1512', 3, '2015-12-05', '2016-01-05', '2016-07-05'),
('3KT1602', 3, '2016-02-24', '2016-04-06', '2016-10-06'),
('3KT1608', 3, '2016-08-01', '2016-09-05', '2017-03-05'),
('FB1603', 4, '2016-03-13', '2016-04-17', '2016-10-17'),
('RH1606', 6, '2016-06-05', '2016-08-21', '2017-02-21');

-- --------------------------------------------------------

--
-- Tabellstruktur `dog`
--

CREATE TABLE `dog` (
  `dogId` tinyint(10) NOT NULL,
  `dogname` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `dogInfo` varchar(255) NOT NULL,
  `userId` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `dog`
--

INSERT INTO `dog` (`dogId`, `dogname`, `dob`, `dogInfo`, `userId`) VALUES
(1, 'Iris', '2009-06-04', 'Iris Ã¤r en irlÃ¤ndsk vattenspaniel som Ã¤lskar att trÃ¤na.', 1),
(2, 'Annie', '2014-03-20', 'Annie Ã¤r en galen irlÃ¤ndsk vattenspaniel som Ã¤lskar att bada, trÃ¤na och mysa.', 1),
(3, 'Milo', '2014-11-13', 'Milo &auml;r en grand danois pÃ¥ tillv&auml;xt.', 2),
(4, 'Britta', '2010-02-05', 'Britta &auml;r en pensionerad sport-rottis som gillar skogspromenader, hemmakv&auml;llar och mat.', 2),
(5, 'Bertil', '2015-08-17', 'Bertil &auml;r en boxer.', 3),
(6, 'Berit', '2007-03-24', 'IrlÃ¤ndsk vattenspaniel. Har tidigare tÃ¤vlat agility, men Ã¤r nu pensionerad. Ã„lskar att spexa, Ã¤ven vid 9 Ã¥rs Ã¥lder.', 10),
(7, 'Lilo', '2015-06-13', 'Dalmatiner', 9),
(8, 'Kiwi', '2009-12-23', 'Ettrig borderterrier', 9),
(9, 'Ville', '2008-03-13', 'Fralla', 9),
(10, 'Valle', '2008-03-13', 'Fralla', 9),
(11, 'Kalle', '2012-10-09', 'Kelpie\n\nTrÃ¤nar spÃ¥r, rapport och lydnad.', 9),
(12, 'Livia', '2015-07-24', 'Livia Ã¤r en sprallig boxer.', 15),
(13, 'Oliver', '2010-02-19', 'Boxer med mycket humor', 15),
(14, 'Luke', '2010-01-23', 'Border collie', 14);

-- --------------------------------------------------------

--
-- Tabellstruktur `photo`
--

CREATE TABLE `photo` (
  `photoId` tinyint(10) NOT NULL,
  `url` varchar(100) NOT NULL,
  `userId` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `photo`
--

INSERT INTO `photo` (`photoId`, `url`, `userId`) VALUES
(22, 'IWS.jpg', 10),
(30, 'IWS_0.jpg', 1),
(32, 'Peanut-PVC_0.JPG', 14),
(34, 'arne-ligger.jpg', 8);

-- --------------------------------------------------------

--
-- Tabellstruktur `post`
--

CREATE TABLE `post` (
  `postId` tinyint(20) NOT NULL,
  `userId` tinyint(5) NOT NULL,
  `postDate` datetime NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `classCode` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `post`
--

INSERT INTO `post` (`postId`, `userId`, `postDate`, `title`, `content`, `classCode`) VALUES
(1, 1, '2015-04-20 00:00:00', 'Vecka 1', 'Lite lektionsmaterial ...', '1PF1505'),
(2, 1, '2015-04-20 00:00:00', 'Vecka 2', 'Lite lektionsmaterial ...', '1PF1505'),
(3, 1, '2015-04-20 00:00:00', 'Vecka 3', 'Lite lektionsmaterial ...', '1PF1505'),
(4, 2, '2015-05-30 00:00:00', 'Titel1', 'Film maj 2015 INTE kurs 2016', '1PF1505'),
(5, 1, '2016-01-11 00:00:00', 'Lektion 1', 'Lite lektionsmaterial ...', '2XT1601'),
(6, 1, '2016-01-11 00:00:00', 'Lektion 2', 'Lite lektionsmaterial ...', '2XT1601'),
(7, 1, '2016-01-11 00:00:00', 'Lektion 3', 'Lite lektionsmaterial ...', '2XT1601'),
(8, 3, '2016-01-25 00:00:00', 'Titel2', 'Content1', '2XT1601'),
(9, 1, '2016-02-12 00:00:00', 'Tricks 1', 'Lite lektionsmaterial ...', '3KT1602'),
(10, 1, '2016-02-12 00:00:00', 'Tricks 2', 'Lite lektionsmaterial ...', '3KT1602'),
(11, 1, '2016-02-12 00:00:00', 'Tricks 3', 'Lite lektionsmaterial ...', '3KT1602'),
(12, 3, '2016-02-12 00:00:00', 'Titel3', 'Content2', '2XT1601'),
(13, 3, '2016-02-27 00:00:00', 'Titel4', 'Content3', '2XT1601'),
(14, 2, '2016-02-28 00:00:00', 'Titel5', 'Content4', '3KT1602'),
(15, 2, '2016-03-05 00:00:00', 'Titel6', 'Content5', '3KT1602'),
(16, 2, '2016-03-11 00:00:00', 'Titel7', 'Content6', '3KT1602'),
(17, 1, '2016-02-24 00:00:00', 'Vecka 1', '', '3KT1602'),
(18, 1, '2016-02-24 00:00:00', 'Vecka 1', '&lt;p&gt;Lektionsmaterial f&amp;ouml;r vecka 1&lt;/p&gt;\n\n&lt;ol&gt;\n	&lt;li&gt;&amp;Ouml;vning&lt;/li&gt;\n	&lt;li&gt;&amp;Ouml;vning&lt;/li&gt;\n	&lt;li&gt;&amp;Ouml;vning&lt;/li&gt;\n&lt;/ol&gt;', '3KT1602'),
(19, 1, '2016-02-25 00:00:00', 'FÃ¶rberedelser', '&lt;p&gt;F&amp;ouml;rberedelser inf&amp;ouml;r kursstart&lt;/p&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;exempel&lt;/li&gt;\n	&lt;li&gt;exempel&lt;/li&gt;\n	&lt;li&gt;exempel&lt;/li&gt;\n&lt;/ul&gt;', '1PF1602'),
(20, 1, '2016-06-28 00:00:00', 'Vecka 2', '&lt;p&gt;Lite kursmaterial&lt;/p&gt;', '1PF1605'),
(21, 1, '2016-06-17 00:00:00', 'Vecka 3', '&lt;p&gt;Material&lt;/p&gt;', '2XT1606'),
(22, 1, '2016-05-21 00:00:00', 'Vecka 4', '&lt;p&gt;Lektion 4 material&lt;/p&gt;', '2XT1606'),
(23, 10, '2016-03-08 23:01:12', 'Rubrik', '&lt;p&gt;Lektion 4 material&lt;/p&gt;', '1PF1602'),
(24, 1, '2016-03-09 00:00:00', 'Rubrik', '&lt;p&gt;&lt;strong&gt;Crawl Forward and Backward&lt;/strong&gt;&lt;/p&gt;\n\n&lt;p&gt;Crawling forward is an ALL body workout that engages the core while lengthening through the spine and engages the shoulders and hips.&lt;/p&gt;\n\n&lt;p&gt;&lt;strong&gt;Body Position:&lt;/strong&gt; Legs should be bent, chest should be as close to the ground or floor as possible, back should be flat (no arching or roaching), and all four legs should rotate forward or backward in a slow and controlled manner.&lt;/p&gt;\n\n&lt;p&gt;&lt;strong&gt;Benefits: &lt;/strong&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;strong&gt;Forward Movement: &lt;/strong&gt;strengthens shoulders in extension and flexion, rotates the hips and engages the Psoas, while lengthening through the spinal muscles.&lt;/p&gt;\n\n&lt;p&gt;&lt;strong&gt;Backward Movement: &lt;/strong&gt;strengthens shoulders in flexion and extension, rotates hips individually and engages the Psoas&lt;/p&gt;\n\n&lt;p&gt;&lt;strong&gt;Equipment/Setup:&lt;/strong&gt; Using cavaletti poles or something equivalent that your dog can crawl under, set up a &amp;ldquo;tunnel&amp;rdquo; that is 8&amp;prime; to 12&amp;prime; in length.&lt;/p&gt;\n\n&lt;p&gt;&lt;strong&gt;Repetitions:&lt;/strong&gt; 10 passes crawling forward for 8&amp;prime; to 12&amp;prime; and 10 passes crawling backward for 8&amp;prime; to 12&amp;prime;. If you are only having your dog crawl forward, complete 20 passes.&lt;/p&gt;\n\n&lt;p&gt;&lt;strong&gt;Training Tips&lt;/strong&gt;&lt;/p&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;Put your dog in a down position on one side of the &amp;ldquo;tunnel&amp;rdquo; and place treats or a target on the floor on the other side. Encourage your dog to come forward under the poles to the reward.&lt;/li&gt;\n	&lt;li&gt;To get your dog to crawl backward, simply block his exit while he&amp;rsquo;s crawling forward and ask him to &amp;ldquo;get back or back up.&amp;rdquo; Alternatively, if you are using cones with holes, as shown in the photo, have your dog crawl forward and then close the cones closest to you to encourage your dog to crawl backward.&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;p&gt;&lt;strong&gt;Increase the Difficulty&lt;/strong&gt;&lt;/p&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;Have your dog crawl forward uphill.&lt;/li&gt;\n	&lt;li&gt;You can also have him crawl forward downhill, as long as it is done in a slow and controlled manner.&lt;/li&gt;\n&lt;/ul&gt;', '1PF1602'),
(25, 1, '2016-03-09 00:00:00', 'Lektion 6', '&lt;p&gt;L&amp;auml;nsstyrelsen ansvarar l&amp;auml;tt partikelniv&amp;aring;erna b&amp;ouml;rjan. Sig m&amp;aring;ste regeringen jag vilka m&amp;ouml;jlig. Pl&amp;aring;nboken skulle trafikkontor material inf&amp;ouml;ra. Beh&amp;ouml;ver h&amp;ouml;g asfaltsort. Tisdagen vill &amp;auml;r f&amp;ouml;rslaget. Omfattas inf&amp;ouml;ra &amp;auml;n utretts bukt ska. Partiklar remiss bor. Utreda finns &amp;ouml;verlever avgift. In s&amp;aring; partikelniv&amp;aring;erna omfattas med milj&amp;ouml;problem. Lika b&amp;ouml;rjan skulle. Asfaltsort tycker kommuner luften st&amp;auml;llet. Kommande pendlar budgetf&amp;ouml;rhandlingar ska, utredning vintern en kronor. M&amp;ouml;jlig s&amp;ouml;nder har partikelniv&amp;aring;erna. Avgiften du inf&amp;ouml;ra det. H&amp;auml;r procent rapportera m&amp;aring;ste fattas f&amp;ouml;rslaget.&lt;/p&gt;\n\n&lt;p&gt;Koepke g&amp;ouml;teborg v&amp;auml;stkuststadens inf&amp;ouml;ra alliansen hoppas. Bli lika kommande l&amp;auml;n har f&amp;ouml;rorterna. Utredning rapportera vintern st&amp;ouml;rsta l&amp;auml;nsstyrelsen att annat procent. L&amp;auml;tt f&amp;ouml;rslaget annat han fr&amp;aring;n. Dubbd&amp;auml;ck inte f&amp;aring; riktigt jag i. Andelen d&amp;auml;refter pl&amp;aring;nboken. Utreda procent tomas. Redan br&amp;aring;ttom v&amp;auml;stkuststadens. In konstateras st&amp;ouml;rsta redan koepke dubbd&amp;auml;ck. Pl&amp;aring;nboken f&amp;ouml;resl&amp;aring;r omfattas alliansen. Kosta att trafikolycka l&amp;auml;tt regeringen. Bukt kommunfullm&amp;auml;ktige luften. Material m&amp;aring;ste in inf&amp;ouml;r. Inf&amp;ouml;r kom redan kommunfullm&amp;auml;ktige.&lt;/p&gt;', '1PF1602'),
(26, 10, '2016-03-09 19:32:58', 'Film fÃ¶r vecka 2', '&lt;p&gt;LÃ¤nsstyrelsen ansvarar lÃ¤tt partikelnivÃ¥erna bÃ¶rjan. Sig mÃ¥ste regeringen jag vilka mÃ¶jlig. PlÃ¥nboken skulle trafikkontor material infÃ¶ra. BehÃ¶ver hÃ¶g asfaltsort. Tisdagen vill Ã¤r fÃ¶rslaget. Omfattas infÃ¶ra Ã¤n utretts bukt ska. Partiklar remiss bor. Utreda finns Ã¶verlever avgift. In sÃ¥ partikelnivÃ¥erna omfattas med miljÃ¶problem. Lika bÃ¶rjan skulle. Asfaltsort tycker kommuner luften stÃ¤llet. Kommande pendlar budgetfÃ¶rhandlingar ska, utredning vintern en kronor. MÃ¶jlig sÃ¶nder har partikelnivÃ¥erna. Avgiften du infÃ¶ra det. HÃ¤r procent rapportera mÃ¥ste fattas fÃ¶rslaget.&lt;/p&gt;&lt;p&gt; Koepke gÃ¶teborg vÃ¤stkuststadens infÃ¶ra alliansen hoppas. Bli lika kommande lÃ¤n har fÃ¶rorterna. Utredning rapportera vintern stÃ¶rsta lÃ¤nsstyrelsen att annat procent. LÃ¤tt fÃ¶rslaget annat han frÃ¥n. DubbdÃ¤ck inte fÃ¥ riktigt jag i. Andelen dÃ¤refter plÃ¥nboken. Utreda procent tomas. Redan brÃ¥ttom vÃ¤stkuststadens. In konstateras stÃ¶rsta redan koepke dubbdÃ¤ck. PlÃ¥nboken fÃ¶reslÃ¥r omfattas alliansen. Kosta att trafikolycka lÃ¤tt regeringen. Bukt kommunfullmÃ¤ktige luften. Material mÃ¥ste in infÃ¶r. InfÃ¶r kom redan kommunfullmÃ¤ktige.&lt;/p&gt;', '1PF1602'),
(27, 10, '2016-03-09 19:37:05', 'Puppy yoga', '&lt;p&gt;&lt;a href=&quot;https://youtu.be/FRPu11pi4E0&quot;&gt;https://youtu.be/FRPu11pi4E0&lt;/a&gt;&lt;/p&gt;', '1PF1602'),
(28, 10, '2016-03-09 19:40:09', 'Stina', '&lt;p&gt;&amp;lt;iframe width=&amp;quot;420&amp;quot; height=&amp;quot;315&amp;quot; src=&amp;quot;https://www.youtube.com/embed/FRPu11pi4E0&amp;quot; frameborder=&amp;quot;0&amp;quot; allowfullscreen&amp;gt;&amp;lt;/iframe&amp;gt;&lt;/p&gt;', '1PF1602'),
(29, 10, '2016-03-09 19:40:35', 'dre', '&lt;iframe width=&quot;420&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/FRPu11pi4E0&quot; allowfullscreen&gt;&lt;/iframe&gt;', '1PF1602'),
(30, 10, '2016-03-10 20:32:30', 'Film', '&lt;iframe width=&quot;420&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/uj4yhhyPv_U&quot; allowfullscreen&gt;&lt;/iframe&gt;\r\n\r\n&lt;p&gt;En liten film&lt;/p&gt;', '1PF1602'),
(31, 7, '2016-03-11 00:00:00', 'Morgonbus', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/oOqhIiaOFjU&quot; allowfullscreen&gt;&lt;/iframe&gt;', '2XT1608'),
(32, 7, '2016-03-11 00:00:00', 'Test', '&lt;h1&gt;Rubrik 1&lt;/h1&gt;\n\n&lt;h2&gt;Rubrik 2&lt;/h2&gt;\n\n&lt;h3&gt;Rubrik 3&lt;/h3&gt;\n\n&lt;pre&gt;\nFormaterad&lt;/pre&gt;\n\n&lt;p&gt;&lt;strong&gt;Bold&lt;/strong&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;em&gt;Italic&lt;/em&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;s&gt;&amp;Ouml;verstruken&lt;/s&gt;&lt;/p&gt;\n\n&lt;ol&gt;\n	&lt;li&gt;Lista 1&lt;/li&gt;\n&lt;/ol&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;Lista A&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;p&gt;&lt;img alt=&quot;Pil&quot; src=&quot;images/arrow.png&quot; style=&quot;height:140px; width:252px&quot; /&gt;&lt;/p&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n\n&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/oOqhIiaOFjU&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;', '3KT1608'),
(33, 7, '2016-03-11 00:00:00', 'Test2', '&lt;h1&gt;Rubrik 1&lt;/h1&gt;\n\n&lt;h2&gt;Rubrik 2&lt;/h2&gt;\n\n&lt;h3&gt;Rubrik 3&lt;/h3&gt;\n\n&lt;pre&gt;\nFormaterad&lt;/pre&gt;\n\n&lt;p&gt;&lt;strong&gt;Bold&lt;/strong&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;em&gt;Italic&lt;/em&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;s&gt;&amp;Ouml;verstruken&lt;/s&gt;&lt;/p&gt;\n\n&lt;ol&gt;\n	&lt;li&gt;Lista 1&lt;/li&gt;\n&lt;/ol&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;Lista A&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;p&gt;&lt;img alt=&quot;Pil&quot; src=&quot;images/arrow.png&quot; style=&quot;height:140px; width:252px&quot; /&gt;&lt;/p&gt;\n\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n\n&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/oOqhIiaOFjU&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;', '2XT1608'),
(34, 1, '2016-03-13 00:00:00', 'Test', '&lt;p&gt;Detta borde bara instrukt&amp;ouml;rer se&lt;/p&gt;', '3KT1602'),
(35, 1, '2016-06-05 00:00:00', 'FÃ¶rberedelser', '&lt;h2&gt;En rubrik&lt;/h2&gt;\n\n&lt;p&gt;Innan kursen startar kan ni &lt;strong&gt;g&amp;auml;rna &lt;/strong&gt;f&amp;ouml;rbereda er p&amp;aring; f&amp;ouml;ljande vis:&lt;/p&gt;\n\n&lt;ol&gt;\n	&lt;li&gt;ferferf&lt;/li&gt;\n	&lt;li&gt;sdsfsfa&lt;/li&gt;\n	&lt;li&gt;bgsdbb&lt;/li&gt;\n	&lt;li&gt;sdfsaf&lt;/li&gt;\n&lt;/ol&gt;\n\n&lt;p&gt;Lite till text ...&lt;/p&gt;', 'RH1606');

-- --------------------------------------------------------

--
-- Tabellstruktur `type`
--

CREATE TABLE `type` (
  `typeId` tinyint(1) NOT NULL,
  `typeName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `type`
--

INSERT INTO `type` (`typeId`, `typeName`) VALUES
(1, 'admin'),
(2, 'student'),
(3, 'observer'),
(4, 'participant');

-- --------------------------------------------------------

--
-- Tabellstruktur `userclass`
--

CREATE TABLE `userclass` (
  `classCode` varchar(7) NOT NULL,
  `userId` tinyint(5) NOT NULL,
  `typeId` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `userclass`
--

INSERT INTO `userclass` (`classCode`, `userId`, `typeId`) VALUES
('1PF1505', 1, 1),
('1PF1602', 1, 1),
('1PF1605', 1, 1),
('2XT1601', 1, 1),
('2XT1606', 1, 1),
('3KT1512', 1, 1),
('3KT1602', 1, 1),
('FB1603', 1, 1),
('RH1606', 7, 1),
('1PF1505', 4, 3),
('1PF1602', 9, 3),
('1PF1602', 13, 3),
('2XT1601', 2, 3),
('2XT1601', 4, 3),
('3KT1602', 5, 3),
('3KT1602', 10, 3),
('3KT1602', 11, 3),
('3KT1608', 6, 3),
('1PF1505', 2, 4),
('1PF1505', 14, 4),
('1PF1602', 10, 4),
('1PF1602', 11, 4),
('1PF1602', 12, 4),
('1PF1605', 3, 4),
('1PF1605', 4, 4),
('1PF1605', 5, 4),
('2XT1601', 3, 4),
('2XT1606', 10, 4),
('3KT1602', 2, 4),
('3KT1602', 4, 4),
('3KT1608', 9, 4);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE `users` (
  `userId` tinyint(5) NOT NULL,
  `email` varchar(40) NOT NULL,
  `firstname` varchar(12) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`userId`, `email`, `firstname`, `lastname`, `password`, `type`) VALUES
(1, 'sara@doggie-zen.se', 'Sara', 'Pettersson', 'JDz1rRjHsFaB6', 1),
(2, 'martin@gmail.com', 'Martin', 'Lind', 'ijew3892hywet6W5R', 2),
(3, 'lisa@telia.se', 'Lisa', 'Karlsson', 'wkejfds7yguqb2367283wegf', 2),
(4, 'inga@gmail.com', 'Inga', 'Larsson', 'JDhk6yxIk6mQY', 2),
(5, 'lena@telia.se', 'Lena', 'Hansson', 'JDaskjdadw', 2),
(6, 'karin@gmail.com', 'Karin', 'Duval', 'JDoiwqedj29e', 2),
(7, 'hanna@doggie-zen.se', 'Hanna', 'Pettersson', 'JDkvTME/uT0p6', 1),
(8, 'lill@crona.se', 'Lill', 'Crona', 'JD7iwMOihWomg', 1),
(9, 'claes@lejon.se', 'Claes', 'Lejon', 'JDcwc.5l6kPIU', 2),
(10, 'lisa@gmail.com', 'Lisa', 'Bodin', 'JDz1rRjHsFaB6', 2),
(11, 'david@gmail.com', 'David', 'MÃ¥nsson', 'JDAkpokJXbO0c', 2),
(12, 'julia@telia.se', 'Julia', 'Jansson', 'JDl.Lvetaa6mg', 2),
(13, 'filip@comhem.se', 'Filip', 'FranzÃ©n', 'JDavoHLWEp1Jc', 2),
(14, 'ole@gmail.com', 'Ole', 'Hjelm', 'JDCKAc.pjEqbk', 2),
(15, 'vira@gmail.com', 'Vira', 'EnhÃ¶rning', 'JDHlUvHwU6/GI', 2),
(16, 'linda@gmail.com', 'Linda', 'Larsson', 'JD9nEFX7eaFXo', 2);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classId`);

--
-- Index för tabell `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `comment_email_FK` (`userId`),
  ADD KEY `comment_postId_FK` (`postId`);

--
-- Index för tabell `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`classCode`),
  ADD KEY `curriculum_FK` (`classId`);

--
-- Index för tabell `dog`
--
ALTER TABLE `dog`
  ADD PRIMARY KEY (`dogId`),
  ADD KEY `dog_FK` (`userId`);

--
-- Index för tabell `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`photoId`),
  ADD KEY `photo_FK` (`userId`);

--
-- Index för tabell `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `post_email_FK` (`userId`),
  ADD KEY `post_classCode_FK` (`classCode`);

--
-- Index för tabell `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`typeId`);

--
-- Index för tabell `userclass`
--
ALTER TABLE `userclass`
  ADD PRIMARY KEY (`classCode`,`userId`),
  ADD KEY `userClass_email_FK` (`userId`),
  ADD KEY `userClass_type_FK` (`typeId`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `class`
--
ALTER TABLE `class`
  MODIFY `classId` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT för tabell `comment`
--
ALTER TABLE `comment`
  MODIFY `commentId` tinyint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT för tabell `dog`
--
ALTER TABLE `dog`
  MODIFY `dogId` tinyint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT för tabell `photo`
--
ALTER TABLE `photo`
  MODIFY `photoId` tinyint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT för tabell `post`
--
ALTER TABLE `post`
  MODIFY `postId` tinyint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT för tabell `type`
--
ALTER TABLE `type`
  MODIFY `typeId` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
  MODIFY `userId` tinyint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_email_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `comment_postId_FK` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`);

--
-- Restriktioner för tabell `curriculum`
--
ALTER TABLE `curriculum`
  ADD CONSTRAINT `curriculum_FK` FOREIGN KEY (`classId`) REFERENCES `class` (`classId`);

--
-- Restriktioner för tabell `dog`
--
ALTER TABLE `dog`
  ADD CONSTRAINT `dog_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Restriktioner för tabell `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Restriktioner för tabell `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_classCode_FK` FOREIGN KEY (`classCode`) REFERENCES `curriculum` (`classCode`),
  ADD CONSTRAINT `post_email_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Restriktioner för tabell `userclass`
--
ALTER TABLE `userclass`
  ADD CONSTRAINT `userClass_classCode_FK` FOREIGN KEY (`classCode`) REFERENCES `curriculum` (`classCode`),
  ADD CONSTRAINT `userClass_email_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `userClass_type_FK` FOREIGN KEY (`typeId`) REFERENCES `type` (`typeId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
