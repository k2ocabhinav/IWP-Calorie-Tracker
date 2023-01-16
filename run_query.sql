CREATE DATABASE project;

USE project;

CREATE TABLE `customer` (
    `id` int NOT NULL AUTO_INCREMENT,
    `gender` char(1) DEFAULT NULL,
    `name` varchar(30) DEFAULT NULL,
    `email` varchar(50) DEFAULT NULL,
    `password` varchar(20) DEFAULT NULL,
    `doj` date DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `food` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(30) DEFAULT NULL,
    `carb` float(6, 2) DEFAULT NULL,
    `fats` float(6, 2) DEFAULT NULL,
    `protein` float(6, 2) DEFAULT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO
    `food`
VALUES
    (7, 'Apple(Medium)', 11.83, 0.10, 0.35),
    (8, 'Apricots', 11.96, 0.42, 1.50),
    (9, 'Banana (Medium)', 20.90, 0.30, 1.20),
    (
        10,
        'Blackberries (1 serving, 28g)',
        5.10,
        0.20,
        0.90
    ),
    (
        11,
        'Blackcurrants(1 serving, 80g)',
        6.60,
        0.00,
        0.90
    ),
    (
        12,
        'Blueberries(1 serving, 68g)',
        14.40,
        2.40,
        0.74
    ),
    (13, 'Dried dates (20g)', 64.10, 0.40, 2.80);

CREATE TABLE `records` (
    `id` int DEFAULT NULL,
    `dor` date DEFAULT NULL,
    `dfid` int DEFAULT NULL,
    `qnty` int DEFAULT NULL
);

INSERT INTO
    `records`
VALUES
    (1, '2022-03-30', 8, 0),
    (1, '2022-03-30', 7, 1),
    (1, '2022-03-30', 9, 9),
    (1, '2022-03-30', 10, 0),
    (1, '2022-03-30', 13, 0);