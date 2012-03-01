ALTER TABLE `records` CHANGE `weight` `weight` DECIMAL( 4, 1 ) NULL DEFAULT NULL;
ALTER TABLE `records` CHANGE `bmi` `bmi` DECIMAL( 3, 1 ) NULL DEFAULT NULL;
ALTER TABLE `records` CHANGE `body_fat` `body_fat` DECIMAL( 3, 1 ) NULL DEFAULT NULL;
ALTER TABLE `records` CHANGE `muscle` `muscle` DECIMAL( 3, 1 ) NULL DEFAULT NULL;
ALTER TABLE `records` CHANGE `rm` `rm` INT(4) NULL DEFAULT NULL;
ALTER TABLE `records` CHANGE `body_age` `body_age` INT(3) NULL DEFAULT NULL;
ALTER TABLE `records` CHANGE `visceral_fat` `visceral_fat` INT(2) NULL DEFAULT NULL;
ALTER TABLE `records` CHANGE `waist` `waist` DECIMAL( 4, 2 ) NULL DEFAULT NULL;
UPDATE records SET `waist` = NULL  WHERE `waist` = 0;
