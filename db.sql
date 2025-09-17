/* plantas - Branches*/
drop table if exists `go_branches`;
create table `go_branches` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);


create table `go_employees` (
    `id` int unsigned auto_increment primary key,
    `employee_number` int unsigned,
    `first_name` varchar(100) not null default '',
    `last_name` varchar(100) not null default '',
    `full_name` varchar(255) generated always as (concat(coalesce(`first_name`,''),' ',coalesce(`last_name`,''))) stored,
    `phone` varchar(20) default null,
    `address` varchar(255) default null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_employee_number`(`employee_number`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);


create table `go_employment_areas` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);

create table `go_employment_titles` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);


create table `go_employments` (
    `id` int unsigned auto_increment primary key,

    `employee_id` int unsigned,
    `branch_id` smallint unsigned,
    `area_id` smallint unsigned,
    `title_id` smallint unsigned,
    `start_at` date not null,
    `end_at` date null default null,

    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    index(`employee_id`),

    foreign key (`employee_id`) references `go_employees`(`id`) on update cascade on delete restrict,
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);



create table `inventory_equipment_owners` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);

create table `inventory_equipment_brands` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);

create table `inventory_equipment_categories` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);

create table `inventory_equipment_models` (
    `id` int unsigned auto_increment primary key,
    `category_id` smallint unsigned,
    `brand_id` smallint unsigned,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`category_id`, `brand_id`, `name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);

create table `inventory_phoneline_modalities` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,

    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_number`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);

drop table if exists `inventory_phonelines`;
create table `inventory_phonelines` (
    `id` int unsigned auto_increment primary key,

    `number` varchar(50) not null,
    `iccid` varchar(100) not null,
    `company` enum( 'TELCEL', 'AT&T' ) not null,
    `modality_id` smallint unsigned default null,

    `scope` enum('Controlada','Abierta') not null,
    `status` enum('Disponible', 'Asignada') not null default 'Disponible',

    `notes` text,

    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_number`(`number`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);



drop table if exists `inventory_equipment_features`;
create table `inventory_equipment_features` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `type` enum('Campo de Texto','Valor Númerico','Checkbox','Lista desplegable','Conjunto de datos') not null default 'Campo de Texto',
    `categories` json,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);

create table `inventory_equipment_feature_options` (
    `id` int unsigned auto_increment primary key,
    `feature_id` smallint unsigned,
    `name` varchar(255) not null,
    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`feature_id`,`name`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);




/*
CREATE TABLE `inventory_equipment_status` (
    `id` tinyint unsigned auto_increment primary key,
    `name` varchar(100) not null,
);
insert into `inventory_equipment_status`() values
    (1,'Disponible'),
    (2,'Entregado'),
    (3,'En garantía/mantenimiento'),
    (4,'Dañado/desecho');

CREATE TABLE `inventory_equipment_status` (
    `id` tinyint unsigned auto_increment primary key,
    `name` varchar(100) not null,
);
insert into `inventory_equipment_status`() values
    (1,'Nuevo'),
    (2,'Seminuevo'),
    (3,'Usado'),
    (4,'Reparado');
*/



DROP TABLE IF EXISTS `inventory_equipments`;
CREATE TABLE `inventory_equipments` (
    `id` int unsigned auto_increment primary key,

    `status` enum('Disponible', 'Entregado', 'En Garantía / Mantenimiento', 'Dañado / Desecho') not null default 'Disponible',
    `lifecycle` enum('Nuevo', 'Usado') not null default 'Nuevo',

    `category_id` smallint unsigned,
    `brand_id` smallint unsigned,
    `model_id` int unsigned,
    `sku` int unsigned,
    `serial` varchar(100),
    `owner_id` smallint unsigned,
    `features` JSON,

    `purchase_year` year default null,
    `notes` text,

    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_sku`(`sku`),
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);


DROP TABLE IF EXISTS `inventory_equipment_responsives`;
CREATE TABLE `inventory_equipment_responsives` (
    `id` int unsigned auto_increment primary key,
    `equipment_id` int unsigned NOT NULL,
    `employment_id` int unsigned NOT NULL,
    `amount` decimal(10,2) NOT NULL,
    `accessories` json,

    `notes` text,
    `start_at` date not null,
    `end_at` date null default null,

    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,

    index(`equipment_id`),
    index(`employment_id`),

    foreign key (`equipment_id`) references `inventory_equipments`(`id`) on update cascade on delete restrict,
    foreign key (`employment_id`) references `go_employments`(`id`) on update cascade on delete restrict,
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);


/* accesorios */
drop table if exists `inventory_equipment_accessories`;
create table `inventory_equipment_accessories` (
    `id` smallint unsigned auto_increment primary key,
    `name` varchar(255) not null,

    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,
    foreign key (`created_by`) references `users`(`id`) on update cascade on delete restrict,
    foreign key (`updated_by`) references `users`(`id`) on update cascade on delete restrict
);


go_employment_titles

id 
planta 
placa
descripcion
marca
modelo
serie
procesador
ram
disco
area
condicion_af
responsable
responsable_an
observaciones
fecha
user
accesoprios
mac 
correo
contraseña
empresa


equipment_categories {
    id,
    name,
}

equipment_brands {
    id,
    name,
}

equipment_manufacturer {
    id,
    name,
}


go_empleados {
    id,
    name,

    nombre,
    puesto,
    planta
}
go_plantas {
    id,
    name,
}
go_areas {
    id,
    name,
}


for all {
    id
    planta
    placa
    descripcion (type)
    marca
    modelo
    serie

    mac 
    correo
    contraseña
    empresa
}

only laptops {
    procesador
    ram
    disco
}

only teléfonia {

}


responsives {
    fecha start_at
    condicion_af status
    responsable employee_id
    observaciones notes
    accesorios
}


id
numero
compañia
nombre
puesto
planta
imei
iccid
marcaModelo
plan
costo
correo
claveCorreo
status
correoAnt
claveCorreoAnt
fechaI
observaciones
accesorios
emp


numero
compañia
imei
iccid
marcaModelo
plan ?
costo ?
correo 
claveCorreo
correoAnt
claveCorreoAnt


/*
CREATE TABLE `go_equipment_responsive_accessories` (
    `id` int unsigned auto_increment primary key,
    `name` varchar(255) no null,

    `created_by` bigint unsigned default null,
    `updated_by` bigint unsigned default null,
    `created_at` timestamp not null default current_timestamp,
    `updated_at` timestamp not null default current_timestamp on update current_timestamp,
    `deleted_at` timestamp null default null,
    foreign key `created_by` references `users`(`id`) on update cascade on delete restrict.
    foreign key `updated_by` references `users`(`id`) on update cascade on delete restrict
);
*/


create table `mixes`(
    `id` int unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `tipo` varchar(250) not null,
    `supplies` json,
    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null
);

CREATE TABLE `mix_supply_categories`(
    `id` int unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null,
    unique key `unique_name`(`name`)
);
insert into`mix_supply_categories`(`id`,`name`) values
    (1, 'Proporciones Saco Base'),
    (2, 'Proporciones Saco Laminado');

CREATE TABLE `mix_supplies`(
    `id` int unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `category_id` int unsigned,
    `measurement` enum('lineal', 'percentage') not null,
    `is_percentage_part` boolean not null default 0,
    `fields` json default null,
    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null,
    unique key `unique_name`(`name`)
);

deja que los JSON resuelvan todo el "#$#$%##$" sistema de #"%"#%#$&#$%;

create table `mix_items`(
    `id` int unsigned auto_increment primary key,
    `mix_id` int unsigned default null,
    `mix_supply_id` int unsigned default null,

    `measurement` enum('lineal', 'percentage') not null,
    `value` varchar(100), /*esto es una m#"/(=/(a", pero es lo que hay*/
    `values` json, /*esto es una m#"/(=/(a" mas grande*/

    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null
);



CREATE TABLE `mix_supplies`(
    `id` int unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `category_id` int unsigned,
    `measurement` enum('lineal', 'percentage') not null,
    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null,
    unique key `unique_name`(`name`)
);



create table `mixes`(
    `id` int unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `tipo` varchar(250) not null,
    `supplies` json,
    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null
);






create table `mixes`(
    `id` int unsigned auto_increment primary key,
    `name` varchar(255) not null,
    `tipo` varchar(250) not null,

    `polipro` decimal(5,2) not null default 0.00,
    `polipro_ecologico` decimal(5,2) not null default 0.00,    
    `calcio` decimal(5,2) not null default 0.00,

    `polipro_lam` decimal(5,2) not null default 0.00,
    `polietileno` decimal(5,2) not null default 0.00,
    `tintas_min` decimal(15,10) not null default 0.00,
    `tintas_max` decimal(15,10) not null default 0.00,
    `hilo_min` decimal(15,10) not null default 0.00,
    `hilo_max` decimal(15,10) not null default 0.00,
    `linner` decimal(15,10) not null default 0.00,
    `recuperado` decimal(5,2) default null,
    `constantes` json,

    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null
);




create table `productos_mixes`(
    `id` int unsigned auto_increment primary key,
    `nombre` varchar(255) not null,
    `tipo` varchar(250) not null,

    `materias` json,
    `constantes` json,

    `created_at` timestamp not null default current_timestamp,
    `deleted_at` timestamp null default null,

    unique key `unique_name`(`nombre`)
);

create table `productos_mixes_materias`(
    `id` int unsigned auto_increment primary key,
    `mix_id` int unsigned,
    `presentacion_id` int unsigned,
    `materias` json,

    unique key `unique_mix_presentacion`(`mix_id`,`presentacion_id`)
);

