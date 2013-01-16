drop table if exists categoria;

drop table if exists cupon;

drop table if exists cupon_categ;

drop table if exists cupon_region;

drop table if exists empresa;

drop table if exists local;

drop table if exists localadherido;

drop table if exists promocion;

drop table if exists region;

/*==============================================================*/
/* Table: categoria                                             */
/*==============================================================*/
create table categoria
(
   cat_id               int not null auto_increment,
   cat_nombre           varchar(32) not null,
   cat_imagen_nombre    varchar(128),
   cat_imagen_tipo      varchar(64),
   cat_imagen_ancho     int,
   cat_imagen_alto      int,
   cat_imagen_size      int,
   cat_mostrar          bool,
   primary key (cat_id)
);

/*==============================================================*/
/* Table: cupon                                                 */
/*==============================================================*/
create table cupon
(
   cup_id               int not null auto_increment,
   emp_id               int,
   cup_nombre           varchar(128) not null,
   cup_preview_nombre   varchar(128),
   cup_preview_tipo     varchar(64),
   cup_preview_ancho    int,
   cup_preview_alto     int,
   cup_preview_size     int,
   cup_imagen_nombre    varchar(128),
   cup_imagen_tipo      varchar(64),
   cup_imagen_ancho     int,
   cup_imagen_alto      int,
   cup_imagen_size      int,
   cup_vigente          bool,
   primary key (cup_id)
);

/*==============================================================*/
/* Table: cupon_categ                                           */
/*==============================================================*/
create table cupon_categ
(
   cct_id               int not null auto_increment,
   cat_id               int,
   cup_id               int,
   primary key (cct_id)
);

/*==============================================================*/
/* Table: cupon_region                                          */
/*==============================================================*/
create table cupon_region
(
   crg_id               int not null auto_increment,
   reg_id               int,
   cup_id               int,
   primary key (crg_id)
);

/*==============================================================*/
/* Table: empresa                                               */
/*==============================================================*/
create table empresa
(
   emp_id               int not null auto_increment,
   emp_nomfantasia      varchar(64) not null,
   emp_razonsocial      varchar(64) not null,
   emp_rut              varchar(16) not null,
   primary key (emp_id)
);

/*==============================================================*/
/* Table: local                                                 */
/*==============================================================*/
create table local
(
   loc_id               int not null auto_increment,
   emp_id               int,
   loc_nombre           varchar(32) not null,
   loc_direccion        varchar(64) not null,
   loc_comuna           varchar(32),
   loc_ciudad           char(10),
   loc_googlemaps       text not null,
   loc_vigente          bool not null,
   primary key (loc_id)
);

/*==============================================================*/
/* Table: localadherido                                         */
/*==============================================================*/
create table localadherido
(
   lad_id               int not null auto_increment,
   emp_id               int,
   loc_id               int,
   cup_id               int,
   primary key (lad_id)
);

/*==============================================================*/
/* Table: promocion                                             */
/*==============================================================*/
create table promocion
(
   pro_id               int not null auto_increment,
   pro_titulo           varchar(128) not null,
   pro_texto            text not null,
   pro_imagen_nombre    varchar(128),
   pro_imagen_tipo      varchar(64),
   pro_imagen_ancho     int,
   pro_imagen_alto      int,
   pro_imagen_size      int,
   pro_vigente          bool,
   primary key (pro_id)
);

/*==============================================================*/
/* Table: region                                                */
/*==============================================================*/
create table region
(
   reg_id               int not null auto_increment,
   reg_num              smallint not null,
   reg_cod              varchar(4) not null,
   reg_nombre           varchar(64) not null,
   reg_alias            varchar(32) not null,
   reg_ordenmapa        smallint not null,
   primary key (reg_id)
);

alter table cupon add constraint FK_emp_cup foreign key (emp_id)
      references empresa (emp_id) on delete restrict on update restrict;

alter table cupon_categ add constraint FK_cat_cup foreign key (cat_id)
      references categoria (cat_id) on delete restrict on update restrict;

alter table cupon_categ add constraint FK_cup_cat foreign key (cup_id)
      references cupon (cup_id) on delete restrict on update restrict;

alter table cupon_region add constraint FK_cup_reg foreign key (cup_id)
      references cupon (cup_id) on delete restrict on update restrict;

alter table cupon_region add constraint FK_reg_cup foreign key (reg_id)
      references region (reg_id) on delete restrict on update restrict;

alter table local add constraint FK_emp_loc foreign key (emp_id)
      references empresa (emp_id) on delete restrict on update restrict;

alter table localadherido add constraint FK_cup_lad foreign key (cup_id)
      references cupon (cup_id) on delete restrict on update restrict;

alter table localadherido add constraint FK_emp_lad foreign key (emp_id)
      references empresa (emp_id) on delete restrict on update restrict;

alter table localadherido add constraint FK_loc_lad foreign key (loc_id)
      references local (loc_id) on delete restrict on update restrict;
