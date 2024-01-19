
INSERT INTO `pages` (`id`, `titel`, `description`, `content`, `author`, `created`, `updated`) VALUES
    (1, 'Hallo Welt!', 'Willkommen liebe Welt bei unserem erster Post im Blog.', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', 'Franc Drabin', '2022-06-30 18:05:30', '2022-06-30 21:56:27');

INSERT INTO `user` SET `name` = 'username', `password` = 'secret';
INSERT INTO `user` SET `name` = 'benutzer', `password` = 'geheim';

INSERT INTO `todo_type` SET `name` = 'Haushalt';
INSERT INTO `todo_type` SET `name` = 'Küche';
INSERT INTO `todo_type` SET `name` = 'Einkaufen';
INSERT INTO `todo_type` SET `name` = 'Büro';
INSERT INTO `todo_type` SET `name` = 'Auto';

INSERT INTO `todo` SET `user_id` = 2, `type_id` = 2, `title` = 'Spühlmaschine ausräumen';
