INSERT INTO `user` SET `name` = 'username', `password` = 'secret';
INSERT INTO `user` SET `name` = 'benutzer', `password` = 'geheim';

INSERT INTO `content_type` SET `name` = 'text';
INSERT INTO `content_type` SET `name` = 'markdown';
INSERT INTO `content_type` SET `name` = 'html';

INSERT INTO
  `page`
SET
  `id` = 1,
  `type_id` = 2,
  `title` = 'Hallo Welt!',
  `description` = 'Willkommen liebe Welt auf unserer neuen Internetseite und unserem Blog',
  `content` = '# Willkommen liebe Welt auf unserer neuen Internetseite!

Schön, dass du den Weg zu uns gefunden hast! Unsere neue Website und unser Blog sind endlich online – ein Ort voller spannender Inhalte, Inspiration und Austausch. Hier möchten wir dir Einblicke in unsere Welt geben, aktuelle Themen diskutieren und hilfreiche Informationen bereitstellen.

Egal, ob du auf der Suche nach Neuigkeiten, Tipps oder einfach nur etwas Unterhaltung bist – wir freuen uns, dass du hier bist! Schau dich um, entdecke unsere Beiträge und lass dich inspirieren.

## Unser Blog – Deine Quelle für spannende Inhalte

In unserem Blog erwarten dich regelmäßig neue Artikel zu verschiedenen Themen. Wir teilen Wissen, Erfahrungen und Geschichten, die dich weiterbringen und begeistern sollen. Dabei legen wir großen Wert auf Qualität und Relevanz – für dich und alle anderen, die sich für unsere Inhalte interessieren.

Wir laden dich herzlich ein, mit uns in den Dialog zu treten. Hinterlasse uns gerne einen Kommentar, teile deine Gedanken und werde Teil unserer Community. Gemeinsam machen wir diese Plattform lebendig!',
  `author` = 'Franc Drabin'
;

INSERT INTO `todo_type` SET `name` = 'Haushalt';
INSERT INTO `todo_type` SET `name` = 'Küche';
INSERT INTO `todo_type` SET `name` = 'Einkaufen';
INSERT INTO `todo_type` SET `name` = 'Büro';
INSERT INTO `todo_type` SET `name` = 'Auto';

INSERT INTO `todo` SET `user_id` = 2, `type_id` = 2, `title` = 'Spühlmaschine ausräumen';
