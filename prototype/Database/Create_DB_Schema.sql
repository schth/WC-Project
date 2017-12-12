CREATE DATABASE IF NOT EXISTS wc;

USE wc;

CREATE TABLE IF NOT EXISTS compartment (
  seq_id SERIAL,
  comp_id integer(1),
  status varchar(1),
  upd_dt DATETIME,
  PRIMARY KEY (comp_id,
               upd_dt));
               
