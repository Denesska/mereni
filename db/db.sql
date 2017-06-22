create table angajati
(
  id int auto_increment
    primary key,
  surname text not null,
  middle text null,
  `name` text not null,
  cnp varchar(15) not null,
  gender text not null,
  birth_day date not null,
  telefon varchar(15) not null,
  tel_fix varchar(15) not null,
  insurance varchar(20) not null,
  hire_date date not null,
  type_em text not null,
  cities text not null,
  comments varchar(200) not null,
  create_date date not null,
  deleted tinyint(1) default '0' not null
)
;

create table creante
(
  id int auto_increment
    primary key,
  id_angajat int not null,
  tip_creanta text not null,
  sum_creanta int not null,
  `data` date not null,
  data_adaugat date not null,
  deleted tinyint(1) default '0' not null
)
;

create table lichidare
(
  id int auto_increment
    primary key,
  id_angajat int not null,
  salarii int not null,
  creante int not null,
  platit int not null,
  rest int not null,
  `data` date not null,
  `comment` text null,
  deleted tinyint(1) default '0' not null
)
;

create table loc_activitate
(
  id int auto_increment
    primary key,
  locatie text not null,
  added timestamp default CURRENT_TIMESTAMP not null,
  deleted tinyint(1) default '0' not null
)
;

create table login
(
  id int auto_increment
    primary key,
  `name` varchar(11) not null,
  surname varchar(10) not null,
  `user` varchar(10) not null,
  email varchar(20) not null,
  `hash` varchar(255) not null,
  pin int(4) not null
)
;

create table salarii
(
  id int auto_increment
    primary key,
  id_angajat int not null,
  prezent tinyint(1) default '0' not null,
  motiv tinyint(1) default '0' not null,
  detalii varchar(50) not null,
  suma int not null,
  `data` date not null,
  data_adaugat date not null,
  platit int not null,
  deleted tinyint(1) default '0' not null
)
;

create table work_days
(
  id int auto_increment
    primary key,
  id_angajat int not null,
  id_loc_activitate int not null,
  `comment` varchar(100) not null,
  submission_date date not null,
  completed tinyint(1) default '0' not null,
  deleted tinyint(1) default '0' not null
)
;


create view total_bani as
  SELECT
    `an`.`surname`      AS `surname`,
    `an`.`name`         AS `name`,
    `li`.`id_angajat`   AS `id_angajat`,
    sum(`li`.`platit`)  AS `totalP`,
    sum(`li`.`creante`) AS `totalC`,
    sum(`li`.`salarii`) AS `totalS`,
    sum(`li`.`rest`)    AS `totalR`
  FROM (`lichidare` `li`
    JOIN `angajati` `an` ON ((`li`.`id_angajat` = `an`.`id`)))
  GROUP BY `li`.`id_angajat`;


create view total as
  SELECT
    `tb`.`surname`                                              AS `surname`,
    `tb`.`name`                                                 AS `name`,
    `lichidare`.`id`                               AS `id`,
    `tb`.`id_angajat`                                           AS `id_angajat`,
    `lichidare`.`salarii`                          AS `salarii`,
    `lichidare`.`creante`                          AS `creante`,
    `lichidare`.`platit`                           AS `platit`,
    `lichidare`.`rest`                             AS `rest`,
    date_format(`lichidare`.`data`, '%a %d %m %Y') AS `dat_db`,
    `tb`.`totalP`                                               AS `totalP`,
    `tb`.`totalC`                                               AS `totalC`,
    `tb`.`totalS`                                               AS `totalS`,
    `tb`.`totalR`                                               AS `totalR`
  FROM (`lichidare`
    JOIN `total_bani` `tb` ON ((`lichidare`.`id_angajat` = `tb`.`id_angajat`)))
  WHERE (NOT (exists(SELECT 1
                     FROM `lichidare` `l2`
                     WHERE ((`l2`.`id_angajat` = `lichidare`.`id_angajat`) AND
                            (`l2`.`id` > `lichidare`.`id`)))));

