-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Фев 02 2021 г., 09:44
-- Версия сервера: 5.7.26
-- Версия PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `store`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `url` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `url`) VALUES
(1, 'Канцтовары', 'stationery'),
(2, 'Книги', 'books');

-- --------------------------------------------------------

--
-- Структура таблицы `img`
--

CREATE TABLE `img` (
  `id` int(11) NOT NULL,
  `img` blob NOT NULL,
  `img_name` varchar(64) NOT NULL,
  `img_type` varchar(64) NOT NULL,
  `img_size` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product` varchar(128) NOT NULL,
  `img` varchar(64) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `subCategoryId` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `product`, `img`, `quantity`, `price`, `description`, `subCategoryId`) VALUES
(1, 'Pilot ручка ', 'download.jpeg', 32, '13.50', 'Ручики перьевые, производитель Pilot, имеющиеся цыета: черный, красный, фиолетовый.', '1'),
(2, 'ручка  Corvina 51 ', 'download (1).jpeg', 64, '9.50', 'Ручики шариковые, производитель Corvina, имеющиеся цвета: синий, черный, красный, фиолетовый.', '1'),
(3, 'карандаши KOH-I-NOR H1', 'download (2).jpeg', 47, '5.70', 'Карандаши KOH-I-NOR, жесткость H1.', '2'),
(4, 'карандаши KOH-I-NOR H3', 'download (2).jpeg', 52, '5.70', 'Карандаши KOH-I-NOR, жесткость H3.', '2'),
(5, 'маркер TUKZAR', 'download (2).jpeg', 68, '20.80', 'Несмывающиеся маркеры TUKZAR, цвета в наличии: красный, синий, зеленый, черный, желный. ', '3'),
(6, 'маркер SCHOLZ', 'download (2).jpeg', 47, '20.80', 'Несмывающиеся маркеры SCHOLZ, цвета в наличии: красный, синий, зеленый, черный, желный. ', '3'),
(7, 'Руководство для желающих жениться', 'download (3).jpeg', 15, '150', 'Какой должна быть идеальная невеста? Не бледна, не красна, не худа, не полна, не высока, не низка, симпатична. Что она должна уметь? Петь, плясать, читать, писать, варить, жарить, поджаривать, нежничать, печь (но не распекать), занимать мужу деньги, со вкусом одеваться на собственные средства и жить в абсолютном послушании. И ни в коем случае не зудеть и не шипеть. И если вы желаете жениться, то стоит прислушаться к этому руководству.\r\nВ сборник вошли юмористические рассказы и пьесы Антона Чехова о женитьбе и сватовстве. Веселые приключения влюбленных пар, искрометный юмор, такие знакомые житейские ситуации, женихи и невесты, одни из которых мечтают о браке, а другие - боятся его как огня. Короткие и легкие рассказы о семейной жизни поднимут настроение и заставят забыть о проблемах.', '4'),
(8, 'Случайная Вакансия  Дж.К.Роулинг', 'download (4).jpeg', 23, '95', 'У Пегфорде на сорок пятому році життя раптово помер член місцевої ради Баррі Фейрбразер. Ця подія повалило городян в шок. У провінційному англійському містечку з брукованої ринковою площею і древнім монастирем, здавалося б, панує ідилія, але чи так це насправді? Що ховається за красивими англійськими фасадами? Насправді тихе містечко вже давно знаходиться в стані війни. Багаті конфліктують з бідними, підлітки - з батьками, дружини - з чоловіками, вчителі - з учнями ... Пегфорд не такий, яким здається на перший погляд. Але звільнене крісло в місцевій раді лише загострює всі ці конфлікти і загрожує привести до такої війни, якої ще не бачив маленьке містечко. Хто зуміє перемогти на виборах, наповнених пристрастю, лукавством і несподіваними викриттями? Це великий роман про маленькому місті і перша книга Джоан Роулінг для дорослих. Прекрасне твір, створений дивовижним оповідачем.', '5'),
(9, 'Воображаемый друг   Стивен Чбоски', 'download (4).jpeg', 12, '230', 'У новому місті, в новій школі Крістофер не самотній: він чує голос друга. Славна людина веде його за собою до лісу Місії, де напередодні Різдва хлопчикові належить побудувати будиночок на дереві і відкрити вхід до уявного світу. Хто ж він - людина або монстр? Бог або диявол? \"Уявний друг\" - довгоочікуваний роман від автора світового бестселера \"Добре бути тихонею\".', '5'),
(10, 'Октябрьская Революция   Марк Петров', 'download (3).jpeg', 63, '130', 'Переосмысление Октябрьской революции, ее причины и последствия для современного постсоветского пространства. ', '6'),
(59, 'пикачу карандаш ', 'images (1).jpeg', 32, '12.35', 'rfhfylfi', '2');

-- --------------------------------------------------------

--
-- Структура таблицы `profit`
--

CREATE TABLE `profit` (
  `id` int(11) NOT NULL,
  `productsId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(11) NOT NULL,
  `amount` varchar(32) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `profit`
--

INSERT INTO `profit` (`id`, `productsId`, `quantity`, `price`, `amount`, `date`) VALUES
(26, 2, 2, '9.50', '19', 1611154052),
(27, 2, 1, '9.50', '9.5', 1611154052),
(28, 4, 1, '5.70', '5.7', 1611225196),
(29, 5, 1, '20.80', '20.8', 1611225196),
(30, 3, 1, '5.70', '5.7', 1611314712),
(31, 9, 1, '230', '230', 1611314712),
(32, 1, 1, '13.50', '13.5', 1611751146),
(33, 2, 1, '9.50', '9.5', 1611751146),
(34, 3, 1, '5.70', '5.7', 1611751195),
(35, 1, 1, '13.50', '13.5', 1611751228),
(36, 59, 1, '12.35', '12.35', 1611751228);

-- --------------------------------------------------------

--
-- Структура таблицы `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `url` varchar(32) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sub_category`
--

INSERT INTO `sub_category` (`id`, `name`, `url`, `category_id`) VALUES
(1, 'ручки', 'pens', 1),
(2, 'карандаши', 'pencils', 1),
(3, 'маркеры', 'markers', 1),
(4, 'Класика', 'classic', 2),
(5, 'Художественная литература', 'fiction', 2),
(6, 'Историческая Литература', 'historical', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(32) NOT NULL,
  `age` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `status` varchar(8) NOT NULL,
  `role` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `email`, `age`, `phone_number`, `status`, `role`) VALUES
(1, 'Александр Сергеевич', 'alex', '$2y$10$QemhJCQKzj05eekHLX0yRO8XGzCfN.0xO7BHzWwAXGPiGf/lzAisC', 'SergeevishPushkin@icloud.com', 21, '+3234123423421', 'active', 'admin'),
(3, 'Иванов Иван', 'ivanov', '$2y$10$QemhJCQKzj05eekHLX0yRO8XGzCfN.0xO7BHzWwAXGPiGf/lzAisC', 'Ivanov@mail.ru', 23, '+3234123471432', 'baned', 'user'),
(7, 'Михаил Иващук', 'WillowPike', '$2y$10$QemhJCQKzj05eekHLX0yRO8XGzCfN.0xO7BHzWwAXGPiGf/lzAisC', 'ivashchuk@mail.ru', 25, '+3234123423427', 'active', 'moderator'),
(9, 'guest', 'guest', '$2y$10$JQOiA0al5zZuvpoCpgnKu.zY2nlSsaQjfPn30XoWjpUrjMuLIDie6', 'guest@mail.ru', 0, '0000000000000', 'active', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `profit`
--
ALTER TABLE `profit`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `img`
--
ALTER TABLE `img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT для таблицы `profit`
--
ALTER TABLE `profit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
