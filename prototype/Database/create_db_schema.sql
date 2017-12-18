CREATE DATABASE IF NOT EXISTS wc DEFAULT CHARACTER SET utf8;

USE wc;

CREATE TABLE IF NOT EXISTS compartment (
  seq_id SERIAL,
  comp_id integer(1),
  status varchar(1),
  upd_dt DATETIME,
  PRIMARY KEY (comp_id,
               upd_dt));

CREATE VIEW visit AS
SELECT a.seq_id,
          a.comp_id,
          a.status,
          a.upd_dt AS time1,
     (SELECT b.upd_dt
      FROM compartment b
      WHERE b.comp_id=a.comp_id
        AND b.seq_id > a.seq_id
      ORDER BY b.seq_id
      LIMIT 1) AS time2
   FROM compartment a
   ORDER BY seq_id;
