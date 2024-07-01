CREATE TABLE `book_admin`
(
    `admin_id`   int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username`   varchar(20) NOT NULL UNIQUE,
    `password`   varchar(255) NOT NULL,
    `created_at` int NOT NULL,
    `login_at`   int NOT NULL,
    `login_ip`   varchar(15) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `book_admin_log`
(
    `log_id`     int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `action`     tinyint NOT NULL,
    `msg`        varchar(100) NOT NULL,
    `created_at` int NOT NULL,
    `created_ip` varchar(15) NOT NULL,
    `params`     json DEFAULT NULL,
    `admin_id`   int NOT NULL,
    INDEX `idx_created_at` (`created_at`),
    INDEX `idx_admin_id` (`admin_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `book_book`
(
    `book_id`    int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `isbn`       bigint NOT NULL,
    `title`      varchar(100) NOT NULL,
    `author`     varchar(40) NOT NULL,
    `publisher`  varchar(40) NOT NULL,
    `storage_at` int NOT NULL,
    `created_at` int NOT NULL,
    `updated_at` int NOT NULL,
    `status`     tinyint NOT NULL,
    `price`      decimal(5, 2) NOT NULL,
    UNIQUE INDEX `idx_isbn` (`isbn`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `book_book_lending`
(
    `book_id`            int NOT NULL,
    `user_id`            int NOT NULL,
    `lending_date`       date NOT NULL,
    `should_return_date` date NOT NULL,
    `return_at`          int DEFAULT NULL,
    `created_at`         int NOT NULL,
    `updated_at`         int NOT NULL,
    `remark`             text,
    PRIMARY KEY (`book_id`, `user_id`),
    INDEX `idx_user` (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `book_book_log`
(
    `log_id`     int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `action`     tinyint NOT NULL,
    `msg`        varchar(100) NOT NULL,
    `created_at` int NOT NULL,
    `created_ip` varchar(15) NOT NULL,
    `params`     json NOT NULL,
    `book_id`    int DEFAULT NULL,
    INDEX `idx_book_id` (`book_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `blog_user`
(
    `user_id`    int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `realname`   varchar(20) NOT NULL,
    `sex`        tinyint NOT NULL,
    `phone`      char(11) NOT NULL UNIQUE,
    `created_at` int NOT NULL,
    `remark`     text
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;