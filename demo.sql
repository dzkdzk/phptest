SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `postid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

TRUNCATE TABLE `comments`;
INSERT INTO `comments` (`id`, `text`, `userid`, `date`, `postid`) VALUES
(22, 'Первый ...', 25, 1411586337, 54);

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postid` int(10) unsigned NOT NULL,
  `filename` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

TRUNCATE TABLE `images`;
INSERT INTO `images` (`id`, `postid`, `filename`) VALUES
(60, 66, '043db7d405c6b00b043f27ebd3804bc28171a3cced656392e87b19a9832969a0.jpg'),
(59, 65, '0fddab25f014c593fc5de9ab6a9b8d90d71ebd568892441308307dfc53a2a3ac.jpg'),
(56, 62, 'b1b34b60f0a4bf111c9e87f90268c1bd9f87729dd11d8a6e6197d592eb21cfe1.jpg'),
(58, 64, '8ac74fde4a16e58ca4952b6a9b77eb4b1180450872fe78b38d162d1c0370e3b7.jpg'),
(57, 63, '3a2c343aaf7bd408d541f683f97d1c2acc205473a11b362ce512a6f7eba8cdcc.jpg'),
(55, 61, '304ede8ccae416933058128aae4beebef0b427d9c28b269aab38ad30a7dbf0c9.jpg'),
(54, 60, 'b1105f3f929125c6082935f0d33618a3255e6a46921b7e78ec22762bbdc06699.jpg'),
(52, 58, '0a0b960b455fcc367fdc41d2d17b07d71fac29ce7f37b81573af43b2d60eb7fc.jpg'),
(53, 59, 'deb415acc9a49f80411b6b1eddc6b9911b539737954f0d20f43449eed1235746.jpg'),
(51, 57, '68db88d1e27bf1c829080d6ef6da57da2fd43c112b4a42f1188f9af15dbfb315.jpg'),
(50, 56, '07fec2405b89dfaad845a4ba5f77c3ed48c9b0a3a2dae6bd57c75899a548b46e.jpg'),
(49, 55, 'd3acad57053b80208068bd218252e770f0428c1dc3fc0b21f06eaf9b5f59cf9b.jpg'),
(47, 53, 'bc79f4fbadcad9540011e0a56c72a5026081c7a40a87d85ed885091ddbe2232e.jpg'),
(48, 54, '539098f13651065505e352e70321877c077fe24d75ce4deebd93fd4b135b6a8c.jpg'),
(61, 67, '2ce4cc1343038d99c937131e03ab72a2a041be1decb3a6e1c05295adc9eea370.jpg'),
(62, 68, 'cfb7356129b167724908b4472b995cc059957d3d4162b691e5a8db07adc7f2ac.jpg'),
(63, 69, '0d45a4c353265ddc589bc688c7078f2967404093efb4c73e6268e4580c2881f0.jpg'),
(64, 70, '170166105f0f56214d70bd8bcbfaa5ba90d6e24a9ec5d5c4b0c8d43795e452a3.jpg'),
(65, 71, '13f9e016f923994d8b47153061217b760c32391e8d1b254b2cf2266b76f0c693.jpg'),
(66, 72, '419c201f209df76c4bb1c36b0128d3c2663280a7f9e784142ce636ef64b1580e.jpg');

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL,
  `browser` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `os` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fromurl` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `uniq` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3310 ;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

TRUNCATE TABLE `pages`;
INSERT INTO `pages` (`id`, `title`, `text`) VALUES
(1, 'Краткая информация об этом блоге', 'Lorem Ipsum'),
(2, 'Полезные ссылки по теме блога', 'http://google.com\r\nhttp://yandex.ru\r\nhttp://mail.ru\r\nhttp://aport.ru\r\nhttp://bigmir.net\r\nhttp://ukr.net\r\n');

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `date` int(10) unsigned NOT NULL DEFAULT '946684800',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=73 ;

TRUNCATE TABLE `posts`;
INSERT INTO `posts` (`id`, `userid`, `text`, `title`, `date`) VALUES
(54, 23, 'Самопровозглашенные власти аннексированного Россией Крыма обвиняют крымскотатарский телеканал ATR в экстремизме. Об этом со ссылкой на журналиста ATR Шевкета Наматуллаева передает 5 канал.\r\n\r\nПо его словам, руководство телекомпании получило письмо от Центра противодействия экстремизму, в котором сказано, что Управление Роскомнадзора по Крыму и Севастополю проинформировало МВД, что канал &quot;настойчиво закладывает мысль о возможных репрессиях по национальному и религиозному признаку, способствует формированию антироссийского общественного мнения, намеренно разжигает среди крымских татар недоверие к власти и ее действиям, косвенно несет угрозу экстремистской деятельности&quot;.\r\n\r\nУ владельцев канала требуют предоставить все правовые документы и список официально трудоустроенных лиц.\r\n\r\nНапомним, 22 сентября так называемый &quot;премьер&quot; Крыма Сергей Аксенов заявил, что юридически Меджлиса на Крымском полуострове не существует.\r\n\r\nЛидер крымскотатарского народа Мустафа Джемилев заявил, что в Крыму оккупанты составляют черные списки татар, которым может грозить ликвидация.\r\n\r\nМИД Украины в ответ на действия оккупационных властей Крыма призвал мировое сообщество отреагировать на нарушения прав крымских татар и украинцев.', 'В Крыму крымскотатарский телеканал ATR обвиняют в экстремизме', 1411583688),
(55, 23, '\r\n\r\nПечерский райсуд Киева в пятницу, 26 сентября, в 14:30 рассмотрит вопрос изменения меры пресечения сотруднику спецподразделения ныне расформированного &quot;Беркута&quot; Сергею Зинченко, обвиняемому в расстреле 39 активистов Майдана 20 февраля. Об этом на своей странице в Facebook сообщил активист Евромайдан SOS Тарас Гаталяк.\r\n\r\n&quot;Ходатайство подал адвокат Байдик О. А. Напомню, что тот же Печерский суд оставил под стражей двоих беркутовцев Зинченко и Аброськина 18 сентября, удовлетворив ходатайство Генеральной прокуратуры о продолжении содержания под стражей&quot;, - написал он.\r\n\r\nКак сообщил корреспонденту ЛІГАБізнесІнформ адвокат родственников убитых героев Небесной сотни Павел Дикань, решение Печерского суда по ходатайству Зинченко во многом будет зависеть от завтрашнего заседания Апелляционного суда, в котором будет рассмотрена жалоба на решение освободить Дмитрия Садовника - командира Зинченко и Аброськина.\r\n\r\n&quot;Многое зависит от завтрашнего решение Апелляционного суда. Если он оставит Садовника на свободе, то у адвокатов защиты есть законные основания считать, что доказательная база по Зинченко носит менее достоверный характер, чем по Садовнику. Они, наверное, этим и будут апеллировать. Какое решение примет суд - тяжело сказать&quot;, - сказал он.\r\n\r\nПо словам Диканя, если Садовника освободят, значит, ранее солидная доказательная база по нему считается недостаточной.\r\n\r\n&quot;Если его не будет или его освободят, это говорит о том, что доказательную базу по этому производству судебная ветвь власти считает недостаточной. Мужчина, которого обвиняют в убийстве 39 человек и которому грозит пожизненный срок, не может находиться под таким домашним арестом&quot;, - добавил адвокат.\r\n\r\nАдвокаты и семьи погибших призывают СМИ и общественность пристально следить за ходом расследования, чтобы не допустить нарушений.\r\n\r\nРанее сообщалось, что Генеральная прокуратура открыла уголовное производство в отношении судьи Печерского суда Светланы Волковой, которая 19 сентября освободила Дмитрия Садовника прямо в зале суда, изменив ему меру пресечения с содержания под стражей на частичный домашний арест. Волкова обвиняется в вынесении заведомо неправомерного решения.', 'Расстрелы на Майдане: суд может отпустить еще одного беркутовца', 1411583807),
(53, 23, 'Лукойл хочет получить доступ к экспорту сжиженного природного газа (СПГ), сказал президент Российского газового общества, замглавы комитета по энергетике Госдумы Павел Завальный в ходе ежегодной конференции Нефть и газ Сахалина. &quot;Лукойл часто выступает с различными инициативами, в частности, в рамках разработки месторождения Центральное в Каспийском море просит о доступе к экспорту СПГ. Но у них нет конкретики. А теоретические разговоры для того, чтобы дать этот доступ, недостаточны&quot;, - отметил Завальный.\r\n\r\nОн подчеркнул, что компания вряд ли получит это право, пока не предоставит конкретные предложения. Также глава РГО уверен, что проект &quot;Печора СПГ&quot; не получит доступа к экспорту СПГ, так как ориентирован на европейский рынок, а там &quot;российский газ не должен конкурировать с российским газом&quot;.\r\n\r\nКомпания Центр Каспнефтегаз, акционерами которой на паритетных условиях являются Лукойл и Газпром, владела лицензией на геологоразведку структуры Центральное. Но лицензия на геологоразведку истекла, а получить лицензию на добычу СП Лукойла и Газпрома не смогло из-за требований российского законодательства, по которому разрабатывать шельф могут только компании с государственным участием свыше 50%.\r\n\r\nРоснедра неоднократно отмечали, что изменить структуру акционеров ЦентрКаспнефтегаза сложно, так как она прописана в межправительственном соглашении России и Казахстана по разработке этого участка. ', 'Лукойл хочет получить доступ к экспорту СПГ', 1411583564),
(56, 23, '\r\nСергей Левочкин\r\nЭкс-глава Администрации президента Сергей Левочкин решил поучаствовать в парламентских выборах. Он баллотируется в народные депутаты в списке так называемого  &quot;Оппозиционного блока&quot; под номером 12. Об этом ЛІГАБізнесІнформ сообщили в пресс-службе кандидата.\r\n\r\nРанее блок обнародовал первую десятку кандидатов в народные депутаты на предстоящих парламентских выборах. В десятку вошли бывшие соратники Януковича, политики, близкие к Ахметову и лидеры Партии регионов и ее сателлитов. Список возглавил бывший вице-премьр-министр Украины Юрий Бойко.\r\n\r\nВ первую десятку партии также вошли глава фонда Украинская перспектива Александр Вилкул, экс-председатель Харьковской областной государственной администрации Михаил Добкин, президент Всеукраинского еврейского конгресса, глава партии ВО Центр Вадим Рабинович, председатель исполкома Партии развития Украины Сергей Ларин, экс-генеральный директор Азовстали Алексей Белый, депутат Верховной Рады Нестор Шуфрич, лидер партии Украина - вперед Наталия Королевская, председатель комитета Верховной Рады по вопросам здравоохранения Татьяна Бахтеева, первый заместитель главы Национального комитета Партии развития Украины Николай Скорик.\r\nДосрочные выборы в Верховную Раду назначены на 26 октября.', 'Левочкин баллотируется в Раду от &quot;Оппозиционного блока&quot;', 1411583891),
(57, 23, 'Президент Украины Петр Порошенко подписал Закон №1668-VII &quot;О внесении изменений в Налоговый кодекс Украины относительно некоторых вопросов налогообложения благотворительной помощи&quot;, которым временно, на время проведения антитеррористической операции, благотворительная помощь, предоставляемая на нужды ее проведения, освобождается от обложения налогом на доходы физических лиц. Об этом сегодня сообщила пресс-служба главы государства.\r\n\r\nЗакон, предложенный президентом по итогам встречи с волонтерами в августе, определяет, что суммы средств, полученных благотворителями - физическими лицами (которые внесены в Реестр волонтеров антитеррористической операции) на банковские счета для оказания благотворительной помощи в пользу АТО, не будут включаться в общий месячный (годовой) налогооблагаемый доход плательщика налога на доходы физических лиц.\r\n\r\nКроме того, временно, на период проведения АТО, без ограничений будут включаться в прочие расходы обычной деятельности плательщика налога на прибыль предприятий суммы средств или стоимость специальных средств индивидуальной защиты (касок, бронежилетов, изготовленных в соответствии с военными стандартами), технических средств наблюдения, лекарственных средств и медицинских изделий, средств личной гигиены, продуктов питания, предметов вещевого обеспечения, а также других товаров, выполненных работ, предоставленных услуг согласно перечню, который определяется Кабинетом министров Украины, добровольно перечисленные (переданные) для нужд обеспечения проведения АТО.\r\n\r\nКроме того, документ регулирует вопросы составления Реестра волонтеров антитеррористической операции.\r\n\r\nНапомним, ранее Порошенко упростил налогообложение лекарств для участников АТО. ', 'Волонтеров, помогающих силам АТО, освободили от налогов', 1411584002),
(58, 23, 'Аннексировав Крым, Россия продолжила антиукраинскую агрессию на территории Донбасса. Искусственные Донецкая и Луганская &quot;народные республики&quot; стали центрами объединения российских наемников, профессиональных боевиков, диверсионных групп на основе выходцев из Кавказа и местных пророссийских активистов. Получая из России через неохраняемые участки границы финансирование и вооружение, в том числе тяжелую бронетехнику, реактивные системы залпового огня &quot;Град&quot;, террористы регулярно обстреливают не только лагеря и блокпосты сил АТО, но и жилые дома, в результате чего гибнут мирные граждане.\r\n\r\nНовоизбранный президент Порошенко в рамках плана по мирному урегулированию ситуации на востоке Украины объявлял 10-дневное перемирие, за время которого силы АТО были атакованы боевиками более 100 раз, погибли 27 бойцов. В результате 1 июля активная фаза антитеррористической операции была возобновлена. С того времени силовики освободили ряд городов Донецкой и Луганской областей, в том числе Славянск, считавшийся неприступной крепостью террористов. Кольцо вокруг бандитов сжимается, украинская сторона хоть и несет потери, но продвигается вперед.\r\n\r\n24 СЕНТЯБРЯ\r\n\r\n15:59. Самопровозглашенные власти аннексированного Россией Крыма обвиняют крымскотатарский телеканал ATR в экстремизме.\r\n\r\n15:50. После боя. Три истории бойцов, выживших в войне за Донбасс (видео).\r\n\r\n15:21. Сотрудники Службы безопасности Украины задержали мужчину 1972 года рождения, который по заданию спецслужб РФ организовывал диверсии на территории Днепропетровской области для дестабилизации ситуации в мирном регионе.\r\n\r\n14:44. Идея президента Российской Федерации Владимира Путина о создании так называемого &quot;Русского мира&quot;, которой некоторые эксперты объясняют его агрессивную политику против соседей, не сработает и не разделит Украину на пророссийскую и прозападную, пишет The Washington Post. ', 'Война России против Украины: последние события в Донбассе', 1411584596),
(59, 23, '\r\nФото: EPA\r\n\r\nГосдума РФ сегодня приняла во втором чтении законопроект о долгосрочном бюджетном планировании, который разрешает с 1 января 2015 года направлять дополнительные нефтегазовые доходы, предназначенные для пополнения Резервного фонда, на покрытие дефицита бюджета. Об этом сообщает ИТАР-ТАСС.\r\n\r\nВозможность использования дополнительных нефтегазовых доходов на замещение госзаимствований предлагается разрешить не только на стадии исполнения, но и планирования федерального бюджета.\r\n\r\nСогласно &quot;бюджетному правилу&quot;, нефтегазовые доходы бюджета, получаемые сверх базовой цены на нефть ($96 за баррель), направляются в Резервный фонд.\r\n\r\n&quot;Мы предлагаем модифицировать это правило и не накапливать эти средства в Резервном фонде, а направлять их уже на этапе планирования на замещение государственных заимствований&quot;, - сказал ранее замминистра финансов РФ Алексей Лавров.\r\n\r\nОтметим, по мнению министра финансов России Антона Силуанова, при снижении цен на нефть резервные фонды страны могут исчерпаться за два года.', 'Госдума распечатала резервные фонды России ', 1411584653),
(60, 23, 'В Артемовский городской отдел милиции обратился местный житель, представитель руководства частного предприятия, с заявлением о том, что в Киевском районе Донецка неизвестные вооруженные лица похитили из автосалона десять автомобилей Тойота. Об этом сегодня сообщила пресс-служба Донецкого областного главка милиции.\r\n\r\nОткрыто уголовное производство по ч.3 ст.289 УК Украины (незаконное завладение транспортным средством, совершенное организованной группой или соединенное с насилием, опасным для жизни или здоровья потерпевшего, или с угрозой применения такого насилия, или если оно нанесло большой материальный ущерб).', 'Боевики ДНР угнали из салона десять иномарок', 1411584702),
(61, 23, 'В Луганске боевики террористической группировки ЛНР захватили и опечатали склад поставщика товаров для крупнейшего в Украине интернет-супермаркета Розетка. Об этом в Facebook сообщил основатель и руководитель компании Владислав Чечеткин.\r\n\r\n&quot;Склад в Луганске. Раскулачивание. Кажется, все это уже было… Где-то в 1917-1920&quot;, - написал он, прикрепив к записи фотографию объявления, которое террористы вывесили на дверях склада. Помещение и его содержимое они объявили собственностью так называемой ЛНР.\r\nВладислав сообщил AIN.UA, что в компании не ведут переговоров с террористами и пока не знают, как вернуть контроль над складом. &quot;Пока единственный план наших действий на будущее - отгородиться большой стеной&quot;, - сказал владелец Rozetka.ua. Насчет того, чего хотят боевики, двух мнений быть не может - они все хотят денег, уверен Чечеткин.', 'В Луганске террористы захватили склад Розетки', 1411584741),
(62, 23, 'Минобороны и МВД готовят заказ на несколько единиц вертолетов Ми-8 и беспилотники для зоны АТО. Об этом сообщил спикер Верховной Рады Александр Турчинов на выставке &quot;Оружие и безопасность&quot;, которая проходит в Международном выставочном центре в Киеве, - передает корреспондент ЛІГАБізнесІнформ.\r\n\r\n&quot;Прямо во врем переговоров, во время осмотра выставки уже договорились о непосредственной закупке нескольких таких вертолетов для Национальной гвардии. Покупает также такие вертолеты с вооружением Министерство обороны. Более того, нас заинтересовало предложение по беспилотникам. Вы знаете, это для нас достаточно актуально. Причем там наши польские коллеги имеют желание поставлять в Украину эту продукцию, и они имеют очень хорошие характеристики. В частности, они могут поднимать до 15 кг груза, в том числе и вооружение. Кроме того, еще одна из проблем в зоне АТО у нас - это поиск целей и уничтожение. Несколько комплексов прямо с выставки сейчас поедут в зону АТО, которые полностью могут нейтрализовать беспилотные аппараты, которые используют Вооруженные силы России для точного ведения огня по нашим позициям&quot;, - сказал он.\r\n\r\nНа вопрос корреспондента ЛІГАБізнесІнформ, на какую сумму планируется сделать заказ, министр обороны Валерий Гелетей ответил, что это будет определено бюджетом на 2015 год. В свою очередь, глава МВД Арсен Аваков отметил, что закупки для армии планируется продолжать и в этом году. По его словам, около трех недель назад премьер-министр Арсений Яценюк провел соответствующее совещание по этому поводу.\r\n\r\n&quot;До конца года мы в рамках оборонного заказа только для Национальной гвардии и для Вооруженных Сил закупаем БТР-4Е, БТР-3Е, КрАЗы, Кугуары, Спартаны - все отечественного производства. Программа очень мощная&quot;, - отметил он.\r\n\r\nГелетей добавил, что в ходе выставки руководство Нацгвардии и Минобороны также обращало внимание на амуницию и форму зимнего периода. &quot;Это очень серьезный вызов для Вооруженных Сил и Нацгвардии - вопрос зимней одежды, это сегодня приоритет. В том числе спальные мешки. Есть предложение спальных мешков, которые выдерживают температуру до минус 50 градусов. Все эти вещи сейчас анализируются - предложения, стоимость - чтобы обеспечить наших военных, которые должны быть готовы защищать Украину, в том числе и при низких температурах&quot;, - отметил он.', 'Минобороны и МВД готовятся закупить вертолеты Ми-8 и беспилотники', 1411584797),
(63, 24, 'Укртелеком приостановил оказание услуг в Севастополе в связи с решением так называемого правительства Севастополя о проведении &quot;инвентаризации&quot; предприятия. Об этом сообщает пресс-служба компании.\r\n\r\n&quot;Действия властей Севастополя посягают на частную собственность Укртелекома и противоречат законодательству Украины, Российской Федерации и нормам международного права о неприкосновенности частной собственности&quot;, - отмечает компания.\r\n\r\nУкртелеком уточняет, что на территории Севастополя уже остановлено предоставление услуг городской, междугородной и международной телефонной связи, а также доступа к интернету и передачи данных всем абонентам, как физическим, так и юридическим лицам.\r\n\r\nНапомним, 18 сентября оккупанты Крыма провели инвентаризацию имущества и изъятие документации санаторного комплекса Форос, принадлежащего структурам украинского олигарха Игоря Коломойского. Помимо прочих, в &quot;инвентаризации&quot; приняли участие около 40 сотрудников спецназа и самообороны.', 'Укртелеком приостанавливает работу в Севастополе', 1411586295),
(64, 24, 'Бывшего министра иностранных дел Польши Радослава Сикорского сегодня избрали председателем нижней палаты польского парламента - Сейма. За назначение Сикорского на эту должность отдали голоса 233 депутата при 220 необходимых для принятия решения, передает УНИАН.\r\n\r\nПротив кандидатуры Сикорского проголосовали 143 депутата и 62 воздержались от голосования.\r\n\r\n&quot;Благодарю фракции, которые не выдвинули другого кандидата на маршалка (председателя Сейма). Благодарю тех, кто за меня проголосовал и тех, кто еще не поверил в мою кандидатуру. Я хочу получить доверие действиями, а не речами&quot;, - сказал новоназначенный председатель главной законодательной палаты польского парламента.\r\n\r\nНапомним, 51-летний Сикорский покинул должность министра иностранных дел, которую он занимал с осени 2007 года, в начале этой недели после назначения нового Кабинета министров. Он создавался в связи с назначением предыдущего премьера Дональда Туска председателем Совета Евросоюза.', 'Экс-глава МИД Польши Сикорский возглавил Сейм', 1411585092),
(65, 24, 'Минимальные котировки покупки доллара на отчетное время составили 12,9, максимальные - 14,5. Что касается продажи, минимальные котировки с момента открытия составили 13,4, максимальные - 15.\r\n\r\nПо данным Нацбанка на 17:00, средневзвешенный курс доллара на межбанковском валютном рынке составил 12,9795 грн. Всего было заключено 143 сделки, общий объем продажи валюты - $269,0 млн\r\n\r\nДинамика межбанковского курса на графике\r\n\r\nТорги по российскому рублю открылись котировками 0,3784/0,3916, к закрытию котировки составили 0,3373/0,3505.\r\n\r\nВместе с тем, торги по евро начались с котировок 18,6325/19,272, к закрытию котировки составили 16,5029/17,1426.\r\n\r\nНапомним, вчера банкиры пообещали руководству НБУ держать курс наличногодоллара не выше 12,95 грн./долл. На среду, 24 сентября, запланирована встреча правления Нацбанка с руководителями 50 банков. ', 'К закрытию межбанка котировки доллара снизились до 12,9/13,4 грн', 1411585134),
(66, 24, 'На сайте Верховной Рады снова изменен текст закона об особом порядке местного самоуправления в отдельных районах Донецкой и Луганской областей. Теперь на сайте парламента снова появился текст, который был роздан депутатам перед голосованием 16 сентября.\r\n\r\nВ опубликованном законе снова указано, что &quot;на три года со дня вступления этого Закона в силу, вводится особый порядок местного самоуправления в отдельных районах Донецкой и Луганской областей, к которым принадлежат районы, города, поселки, села, которые определяются решением Верховной Рады Украины (далее - отдельные районы Донецкой и Луганской областей)&quot;.\r\n\r\nРанее было указано: &quot;Согласно этому Закону временно, на три года со дня вступления в силу настоящего Закона, вводится особый порядок местного самоуправления в отдельных районах Донецкой и Луганской областей, к которым относятся районы, города, поселки, села в пределах территории, определенной решением руководителя Антитеррористического центра при Службе безопасности Украины (далее - отдельные районы Донецкой и Луганской областей)&quot;.', 'Текст закона о статусе Донбассе снова изменили', 1411585188),
(67, 24, 'Кабинет министров Украины назначил Андрея Николаенко председателем Государственного агентства Украины по вопросам восстановления Донбасса. Текст соответствующего распоряжения от 23 сентября 2014 года № 874-р обнародован на сайте правительства.\r\n\r\n&quot;Назначить Николаенко Андрея Ивановича главой Государственного агентства Украины по вопросам восстановления Донбасса&quot;, - сказано в тексте распоряжения.\r\n\r\nНапомним, с 9 января 2013 года по 2 марта 2014-го Николаенко занимал должность главы Кировоградской областной государственной администрации, а с 17 марта 2014 года - первого заместителя председателя Донецкой ОГА.\r\n\r\n22 февраля 2014 года Николаенко вышел из Партии регионов.\r\n\r\nВо время Майдана Николаенко запомнился своими одиозными заявлениями против сторонников евроинтеграции и участников антиправительственных выступлений. ', 'Госагентство по восстановлению Донбасса возглавил экс-регионал', 1411585237),
(68, 24, 'Российская агрессия в Европе - в числе основных глобальных факторов риска. Об этом заявил президент США Барак Обама на сессии Генеральной ассамблеи ООН.\r\n\r\n&quot;Агрессия России в Европе, отметил Обама, напоминает нам о тех днях, когда большие народы растаптывали малые, преследуя свои территориальные амбиции&quot;. В своей речи президент США призвал Россию прекратить агрессию против Украины и вернуться на путь сотрудничества, - передает Голос Америки.\r\n\r\nПри этом Обама отметил, что США готовы восстановить отношения сотрудничества с Россией, если она изменит свой текущий политический курс, проводимый, прежде всего, в отношении Украины. Американский президент сказал, что подписанное в Минске 5 сентября соглашение о прекращении огня в Украине &quot;дает шанс выйти на путь дипломатии и мира&quot;.\r\n\r\n&quot;Если Россия выбирает этот путь, то тогда мы отменим свои санкции и приветствуем роль России в урегулировании общих вызовов. США и Россия были в состоянии заниматься этим в прошлые годы, начиная от сокращения своих ядерных арсеналов, до сотрудничества в целях ликвидации задекларированного арсенала химического оружия Сирии&quot;, - отметил американский лидер, которого цитирует ИТАР-ТАСС.', 'Обама в ООН призвал Россию прекратить агрессию против Украины ', 1411585278),
(69, 24, '\r\n\r\nЭкс-главу компании Башнефть Урала Рахимова суд может арестовать заочно. Об этом рассказал адвокат бизнесмена Ильнур Салимьянов, сообщает Прайм.\r\n\r\nПо имеющимся данным, Уралу Рахимову инкриминируют легализацию незаконно полученных денежных средств и растрату в период приватизации Башнефти. Его точное местонахождение неизвестно.\r\n\r\nНапомним, 23 сентября Башнефть расторгла сделку по продаже 98% активов Объединенной нейтехимической компании (ОНК) компании Система за 6,2 млрд рублей. По данным российских СМИ, решение о расторжении связано с домашним арестом владельца АФК Система Владимира Евтушенкова.\r\n\r\n16 сентября Евтушенкову было предъявлено обвинение в легализации (отмывании) имущества, приобретенного преступным путем, по делу о хищений акций предприятий ТЭК Башкирии (сейчас Башнефть).\r\n\r\nКак ранее заявил официальный представитель СК РФ Владимир Маркин, &quot;у следователей появились достаточные основания полагать, что Евтушенков причастен к легализации (отмыванию) имущества, приобретенного преступным путем, в связи с чем ему предъявлено обвинение и избрана мера пресечения в виде домашнего ареста сроком на два месяца. Через два дня защита Евтушенкова обжаловала это решение.\r\n', 'Бывшего главу Башнефти могут заочно арестовать', 1411585318),
(70, 24, 'По предположению адвокатов украинской летчицы Надежды Савченко, украинская летчица находится в московском СИЗО-6. Об этом у себя в Twitter сообщил адвокат Николай Полозов.\r\n\r\nПо его словам, адвокату Новикову в СИЗО Лефортово сегодня подтвердили, что Савченко привезли в московское СИЗО-6.\r\n\r\nПо словам адвокатов, в этом изоляторе им заявили, что &quot;все ушли домой&quot; и предложили звонить завтра.\r\n\r\nКак уточнил Полозов, СИЗО-6 - женский изолятор со спецблоком для бывших сотрудников органов.\r\n\r\nНапомним, сегодня стало известно, что Савченко увезли из СИЗО Воронежа в неизвестном направлении. Позже адвокаты украинки заявили, что их подзащитную везут в Москву для прохождения психиатрической экспертизы.\r\n\r\nРанее сообщалось, что Воронежский областной суд отказался отпустить Надежду Савченко под залог в 1 млн рублей.\r\n\r\nСавченко попала в плен к террористам ЛНР в середине июня. Позже стало известно, что украинский пилот находится в СИЗО Воронежа, и в России ее намерены судить по обвинению в причастности к гибели российских журналистов. В конце августа Воронежский суд продлил арест Савченко до 31 октября.', 'В Москве Надежду Савченко поместили в СИЗО-6 - адвокат', 1411585370),
(71, 24, 'В России Роскомнадзор заблокировал более 600 сайтов, которые якобы призывают к экстремизму и массовым беспорядкам, сообщает ИТАР-ТАСС со ссылкой на главу ведомства Александра Жарова.\r\n\r\nПо его словам, блокировка сайтов осуществляется оперативно, после того как генпрокурор или его заместитель принимают соответствующее решение.\r\n\r\n&quot;К нам поступило около 100 таких решений Генпрокуратуры. За это время мы заблокировали больше 600 сайтов, причем значительную часть сайтов-зеркал, на которые распространяется экстремистская информация, наши специалисты выявляли сами&quot;, - сказал Жаров.\r\n\r\nНапомним, ранее Роскомнадзор заблокировал российские оппозиционные интернет-СМИ и блоги.\r\n\r\nНадзорное ведомство предписывает провайдерам блокировать сайты в соответствии с законом 398-ФЗ. Он позволяет прокуратуре без решения суда ограничивать доступ к сайтам, которые призывают к массовым беспорядкам, разжиганию межнациональной и межконфессиональной розни, к участию в незаконных публичных массовых мероприятиях, в экстремистской и террористической деятельности.', 'Роскомнадзор заблокировал в РФ более 600 сайтов', 1411585412),
(72, 24, '\r\nЙенс Столтенберг (фото - ЕРА)\r\n\r\nНовый генсек НАТО Йенс Столтенберг, который официально займет пост главы Альянса1 октября, заявил, что разрешение ситуации в Украине станет для него главным приоритетом после официального вступления в должность.\r\n\r\n&quot;На серьезность сложившейся в Украине ситуации указывает тот факт, что военная сила применяется для изменения границ государств, - заявил Столтенберг. - Украина является партнером НАТО и, кроме того, граничит с государствами-членами Альянса&quot;.\r\n\r\nПри этом Столтенберг отметил, что возвращение к прежнему формату отношений между РФ и НАТО сейчас Североатлантическим альянсом не рассматривается.\r\n\r\n&quot;Возвращение к прежнему не рассматривается в качестве варианта, - заявил Столтенберг. - Россией было принято решение придерживаться более агрессивной линии. Поэтому мы не можем, как надеялись ранее, продолжать укрепление партнерства с Россией&quot;.', 'Новый генсек НАТО: Украина станет приоритетом Альянса', 1411585449);

DROP TABLE IF EXISTS `tagbp`;
CREATE TABLE IF NOT EXISTS `tagbp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postid` int(11) NOT NULL,
  `tagid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=181 ;

TRUNCATE TABLE `tagbp`;
INSERT INTO `tagbp` (`id`, `postid`, `tagid`) VALUES
(126, 58, 47),
(125, 58, 46),
(124, 58, 45),
(123, 58, 44),
(122, 58, 43),
(121, 58, 42),
(120, 57, 42),
(119, 57, 41),
(118, 57, 40),
(117, 56, 39),
(116, 56, 38),
(115, 56, 37),
(114, 56, 36),
(113, 56, 35),
(112, 55, 34),
(111, 55, 33),
(110, 55, 32),
(109, 55, 31),
(174, 54, 27),
(173, 54, 28),
(172, 54, 29),
(171, 54, 30),
(104, 53, 26),
(180, 63, 53),
(179, 63, 49),
(127, 59, 47),
(134, 61, 45),
(133, 60, 45),
(132, 60, 43),
(129, 59, 49),
(128, 59, 48),
(131, 60, 44),
(130, 60, 42),
(178, 63, 39),
(140, 62, 52),
(139, 62, 51),
(138, 62, 37),
(137, 62, 42),
(136, 61, 50),
(135, 61, 43),
(103, 53, 25),
(102, 53, 24),
(144, 64, 54),
(145, 64, 55),
(146, 64, 56),
(147, 65, 49),
(148, 65, 57),
(149, 65, 58),
(150, 66, 37),
(151, 66, 44),
(152, 66, 43),
(153, 66, 42),
(154, 67, 59),
(155, 67, 60),
(156, 67, 61),
(157, 68, 47),
(158, 68, 62),
(159, 68, 63),
(160, 69, 47),
(161, 69, 49),
(162, 69, 64),
(163, 70, 46),
(164, 70, 47),
(165, 70, 65),
(166, 71, 47),
(167, 71, 49),
(168, 72, 63),
(169, 72, 47),
(170, 72, 66);

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

TRUNCATE TABLE `tags`;
INSERT INTO `tags` (`id`, `tag`) VALUES
(35, 'Левочкин'),
(34, 'расстрелы'),
(33, 'прокуратура'),
(32, 'беркут'),
(31, 'майдан'),
(30, 'Меджлис'),
(29, 'Мустафа Джемилев'),
(28, 'Аннексия'),
(27, 'Крым'),
(26, 'СПГ'),
(25, 'экспорт'),
(24, 'лукойл'),
(36, 'выборы'),
(37, 'верховная рада'),
(38, 'Оппозиционный блок'),
(39, 'Ахметов'),
(40, 'Порошенко'),
(41, 'Волонтеры'),
(42, 'АТО'),
(43, 'ЛНР'),
(44, 'ДНР'),
(45, 'террористы'),
(46, 'Украина'),
(47, 'Россия'),
(48, 'Госдума'),
(49, 'Экономика'),
(50, 'Розетка'),
(51, 'Минобороны'),
(52, 'Турчинов'),
(53, 'Укртелеком'),
(54, 'Сикорский'),
(55, 'Польша'),
(56, 'Туск'),
(57, 'валюта'),
(58, 'курс'),
(59, 'Янукович'),
(60, 'Легитимный'),
(61, 'Кабмин'),
(62, 'Обама'),
(63, 'США'),
(64, 'санкции'),
(65, 'Савченко'),
(66, 'НАТО');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `passhash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sesshash` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(10) unsigned NOT NULL DEFAULT '3',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `login`, `fullname`, `passhash`, `sesshash`, `role`, `email`) VALUES
(25, 'user', 'User User', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', '10833ab354398e60d15a0ab4d13814e10dc7a5ff6ae5ab5245a496693f8a35d4', 3, ''),
(8, 'admin', 'Админ', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', 'f17a15f107ea7852e44fe7ac462594799aba3754cb853789daa130e50d5a2444', 1, 'admin@localhost'),
(23, 'editor', 'Editor One', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', '91488f29df72b34a8da8d4863bf8b7e2ec0b4fbe1931afbec287f94aa961a44c', 2, 'editor@localhost'),
(24, 'john', 'John Locke', '49b148bd4df6ba4ee192c3a3debf3eddbb7ff9eb1d0c4d83592a02b9decdf037', 'e2eedb974af95010c97d35438db7b09d24ca2e5387c21c20dece39f0f5f56682', 2, 'asdasdas@mail.ru');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
