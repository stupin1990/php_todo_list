CREATE TABLE `todo`.`tasks` ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
    `email` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
    `post` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
    `done` TINYINT NOT NULL DEFAULT '0' , 
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_by` ENUM('guest','admin') NOT NULL DEFAULT 'guest'
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;