DROP DATABASE IF EXISTS `hello_immo`;

CREATE DATABASE `hello_immo`;

USE `hello_immo`;

CREATE TABLE `users` (
  `id` INTEGER AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `type` ENUM('user', 'admin') DEFAULT 'admin',
  `created_at` DATETIME DEFAULT NOW(),
  `updated_at` DATETIME
);

INSERT INTO `users` (`name`, `email`, `password`, `type`)
VALUES (
    "Brian Johnson",
    "user@test.com",
    "$argon2i$v=19$m=65536,t=4,p=1$NDRSTnNHalN3UWhlSWM0dg$p0V/qlJ5KDBPkoWtp4ONtNkAM7fCQZ2u3FcEWfsRyWI",
    -- password: HelloImmo_1234+
    "user"
  ),
  (
    "John Doe",
    "admin@helloimmo.com",
    "$argon2i$v=19$m=65536,t=4,p=1$ME02YVRLUm1PMFZwZXVnWQ$Y2uuDvO8TwPOO8pSw2QDLWxfj6sus3Dv7kU/XToFNvA",
    -- password: HelloImmo_1234+
    "admin"
  );

CREATE TABLE `estates` (
  `id` INTEGER AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `type` ENUM('maison', 'appartement', 'studio') NOT NULL,
  `city` TEXT NOT NULL,
  `acquisition_type` ENUM('location', 'achat') NOT NULL,
  `rooms` INT NOT NULL,
  `bedrooms` INT NOT NULL,
  `bathrooms` INT DEFAULT 1,
  `area` INTEGER NOT NULL,
  `price` INTEGER NOT NULL,
  `description` TEXT NOT NULL,
  `build_year` INTEGER,
  `floor` INT,
  `max_floor` INT,
  `created_at` DATETIME DEFAULT NOW(),
  `updated_at` DATETIME
);

INSERT INTO `estates`
VALUES (
    1,
    'Superbe maison de campagne',
    'maison',
    'Verdun',
    'achat',
    6,
    3,
    1,
    120,
    345000,
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dapibus ipsum sem, et finibus tortor porttitor sed. Sed vel eleifend nibh. Praesent suscipit facilisis enim, ut placerat elit commodo vitae. Sed eget sapien a dui faucibus dignissim at id sapien. Sed dignissim enim nisl, eget suscipit libero finibus vitae. Maecenas egestas arcu posuere, scelerisque ipsum sed, tempus turpis. Nam id posuere odio. Vestibulum commodo justo quis convallis egestas. Nunc dapibus pretium dui, eu hendrerit est blandit nec. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pretium, orci nec accumsan pharetra, diam diam fermentum diam, eget pulvinar ante elit ut est. Sed vel nibh non magna tristique ornare ac non nunc. Phasellus vulputate diam eget arcu tristique, eget sagittis turpis congue. Nullam augue massa, auctor vel pretium non, aliquet non massa. Cras tortor augue, aliquet egestas dictum eu, maximus sed erat.',
    1974,
    NULL,
    NULL,
    '2021-09-23 17:53:37',
    NULL
  ),
  (
    2,
    'Maison en bord de mer',
    'maison',
    'Saint-Malo',
    'achat',
    8,
    4,
    2,
    170,
    390000,
    'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dapibus ipsum sem, et finibus tortor porttitor sed. Sed vel eleifend nibh. Praesent suscipit facilisis enim, ut placerat elit commodo vitae. Sed eget sapien a dui faucibus dignissim at id sapien. Sed dignissim enim nisl, eget suscipit libero finibus vitae. Maecenas egestas arcu posuere, scelerisque ipsum sed, tempus turpis. Nam id posuere odio. Vestibulum commodo justo quis convallis egestas. Nunc dapibus pretium dui, eu hendrerit est blandit nec. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pretium, orci nec accumsan pharetra, diam diam fermentum diam, eget pulvinar ante elit ut est. Sed vel nibh non magna tristique ornare ac non nunc. Phasellus vulputate diam eget arcu tristique, eget sagittis turpis congue. Nullam augue massa, auctor vel pretium non, aliquet non massa. Cras tortor augue, aliquet egestas dictum eu, maximus sed erat.',
    1997,
    NULL,
    NULL,
    '2021-09-23 17:53:37',
    NULL
  ),
  (
    11,
    'Appartement modeste',
    'appartement',
    'testville',
    'location',
    3,
    1,
    1,
    57,
    180000,
    'ghurhgurhg',
    1974,
    2,
    9,
    '2021-09-24 14:25:57',
    NULL
  ),
  (
    12,
    'test',
    'appartement',
    'Nantes',
    'achat',
    3,
    2,
    2,
    175,
    200000,
    'jgezijgij',
    NULL,
    1,
    2,
    '2021-09-24 14:46:32',
    NULL
  );

CREATE TABLE `images` (
  `id` INTEGER AUTO_INCREMENT PRIMARY KEY,
  `url` TEXT NOT NULL,
  `estate_id` INTEGER REFERENCES `estates`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `created_at` DATETIME DEFAULT NOW(),
  `updated_at` DATETIME
);

INSERT INTO `images`
VALUES (
    9,
    '/public/assets/images/biens/appartement/location/ddca44b0-d00f-4031-8e21-3d3e9a067afd.jpg',
    11,
    '2021-09-24 14:25:57',
    NULL
  ),
  (
    10,
    '/public/assets/images/biens/appartement/location/7bfc9003-f382-46fd-83a1-59856321e066.jpg',
    11,
    '2021-09-24 14:25:57',
    NULL
  ),
  (
    11,
    '/public/assets/images/biens/appartement/location/93c6a3f9-03ce-430a-bfd1-ce554eb1a3ea.jpg',
    11,
    '2021-09-24 14:25:57',
    NULL
  ),
  (
    12,
    '/public/assets/images/biens/appartement/achat/bc4dd673-fca1-4a22-bdfe-2b8be7b0d1f2.jpg',
    12,
    '2021-09-24 14:46:32',
    NULL
  ),
  (
    13,
    '/public/assets/images/biens/appartement/achat/dd5d81ea-3df0-4625-9d4c-1426424f17c5.jpg',
    12,
    '2021-09-24 14:46:32',
    NULL
  ),
  (
    14,
    '/public/assets/images/biens/appartement/achat/1f74f68a-53c2-435e-b5d6-1db32d9653ca.jpg',
    12,
    '2021-09-24 14:46:32',
    NULL
  ),
  (
    15,
    '/public/assets/images/biens/appartement/achat/0f24907e-e289-4051-a8f9-f9c1ce330889.jpg',
    12,
    '2021-09-24 14:46:32',
    NULL
  ),
  (
    16,
    '/public/assets/images/biens/appartement/achat/35135312-19b5-4ee9-8d4f-68fbbe794d24.jpg',
    12,
    '2021-09-24 14:46:32',
    NULL
  );