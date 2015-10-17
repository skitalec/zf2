-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 12 2015 г., 18:38
-- Версия сервера: 5.5.25
-- Версия PHP: 5.5.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `anketdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `anket`
--

CREATE TABLE IF NOT EXISTS `anket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_anket` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `type_equipment` varchar(200) NOT NULL,
  `comments` text NOT NULL,
  `call_back` tinyint(1) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=143 ;

--
-- Дамп данных таблицы `anket`
--

INSERT INTO `anket` (`id`, `name_anket`, `name`, `phone`, `email`, `type_equipment`, `comments`, `call_back`, `date`) VALUES
(132, 1, 'Семен Семенович', '555-5555-555', 'admin@admin.ua', 'холодильники', 'Дайте мне халадильнег, ф каторый я смагу кладеть разные фрукты и овощи и много многа йогурта тама диржать!', 1, '2015-10-12 17:15:15'),
(133, 1, 'Семен Семенович', '555-555-555', 'admin@admin.ua', 'холодильники', 'Дайте мне халадильнег, ф каторый я смагу кладеть разные фрукты и овощи и много многа йогурта тама диржать!', 0, '2015-10-12 17:21:50'),
(134, 2, 'Семен Семенович', '555-5555-555', 'admin@admin.ua', 'Микроволновая печь', 'Микроволновая печь, тест, тест........', 0, '2015-10-12 17:27:46'),
(135, 3, 'Семен Семенович', '555-555-555', 'admin@admin.ua', 'Чайник', 'Чайник — небольшой закрытый сосуд с носиком, крышкой (как правило, хотя бывают и исключения) и ручкой для подогревания и кипячения воды.', 1, '2015-10-12 17:30:21'),
(136, 4, 'Семен Семенович', '555-5555-555', 'admin@admin.ua', 'Овощи', 'Овощи — кулинарный термин, обозначающий съедобную часть (например, плод или клубень) растения, а также всякую твёрдую растительную пищу, за исключением фруктов, круп, грибов и орехов.', 0, '2015-10-12 17:32:09'),
(137, 1, 'Иван Иванович', '333-333-333', 'root@root.ua', 'Холодильник', 'Холодильник — устройство, поддерживающее низкую температуру в теплоизолированной камере.', 1, '2015-10-12 17:34:39'),
(138, 2, 'Иван Иванович', '333-333-333', 'root@root.ua', 'Микроволновая печь', 'Микроволно́вая печь или СВЧ-печь (устаревшее ударение микрово́лновая[1]; народное название микроволновка) — электроприбор, использующий явление разогрева водосодержащих веществ электромагнитным излучением дециметрового диапазона', 1, '2015-10-12 17:36:30'),
(139, 4, 'Иван Иванович', '333-333-333', 'root@root.ua', 'Овощи', 'Жаркое солнце и плодородная земля дарят нам возможность в полной мере насладиться неповторимым вкусом разнообразных овощных культур.', 1, '2015-10-12 17:39:20'),
(140, 4, 'Василий Васильевич', '222-555-333', 'h180268@trbvm.com', 'Овощи', 'Нам кажется, что мы знаем о фруктах и овощах практически все, и мы с легкостью можем отличить фрукт от овоща. Но на самом деле, вероятность этого мала. В действительности различия фруктов и овощей на так очевидны, как кажутся.', 0, '2015-10-12 17:41:21'),
(141, 2, 'Вова Семенович', '555-5555-222', 'h145268@trbvm.com', 'Микроволновка', 'Мощность волн, которые используются в микроволновке, уже давно будоражит моё сознание. Её магнетрон (генератор СВЧ) выдаёт электромагнитные волны мощностью около 800 Вт и частотой 2450 МГц. Только представьте, одна микроволновка вырабатывает', 1, '2015-10-12 17:44:00'),
(142, 2, 'Леонид Леонидович', '444-444-444', 'h1565268@trbgffvm.com', 'Микроволновая печь', 'Сразу хочу предупредить, электромагнитное излучение СВЧ диапазона может нанести вред вашему здоровью, а высокое напряжение вызвать летальный исход. Но меня это не остановит.', 0, '2015-10-12 17:46:15');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(100) NOT NULL,
  `usr_password` varchar(100) NOT NULL,
  `usr_password_salt` varchar(100) NOT NULL,
  `usr_email` varchar(100) NOT NULL,
  `usr_email_confirmed` tinyint(1) NOT NULL,
  `usr_active` tinyint(1) NOT NULL,
  `usr_registration_token` varchar(200) NOT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`usr_id`, `usr_name`, `usr_password`, `usr_password_salt`, `usr_email`, `usr_email_confirmed`, `usr_active`, `usr_registration_token`) VALUES
(15, 'root', '8db2305fbd3089feb7b6d862180d45d9', 'J:"ux[%`3vvP4f>eI3N3ps-7vsNdYk9{Ec_n66J]YJj:MxH%>m', 'root@root.ua', 1, 1, 'TUZ5612826195ed52.47651289'),
(16, 'admin', '8437da965b1ae5f0ffcb1d357acee465', '>V%ZLtvnCX-oZG&->TT`%fwxv2%sO[8}u8D3dlj"%O=EM%;k)`', 'admin@admin.ua', 1, 1, 'TUZ56138f71f3e055.16042307'),
(17, 'serg', 'a65349b6800e3c7409eb7659a9a0e28e', '}8e''+O&VxKB.v7r^!I=Ib-r?yx<a6wk@Pc)]8CFIIOJ&P3ICL''', 'serg@serg.ua', 1, 1, 'TUZ56138f9b855a25.17917820'),
(22, 'vova', '9ba4d6ca9b343d27beca19db790c9bfc', 'Vyh>G:@_(__T=K3'';Mxmg)>sv,>qOyGodCVH=g8aKxI8v:W3sX', 'vova@vova.ua', 1, 1, 'TUZ561a5057391044.28433215');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
