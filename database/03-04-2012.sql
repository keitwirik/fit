ALTER TABLE `users` ADD `cookie_hash` VARCHAR( 100 ) NOT NULL ,
ADD `password` VARCHAR( 100 ) NOT NULL ,
ADD UNIQUE (
`cookie_hash`
);
ALTER TABLE `users` ADD `email` VARCHAR( 50 ) NOT NULL AFTER `name`;

