CREATE DATABASE IF NOT EXISTS wc DEFAULT CHARACTER SET utf8;

USE wc;

-- Master Table
CREATE TABLE IF NOT EXISTS sensor_comp (
  sensor_id varchar(10),
  floor int(10),
  gender int(1),-- 1:Male 2:Feamale
  comp_id int(4),
  PRIMARY KEY (sensor_id)
);

-- Transaction Table
CREATE TABLE IF NOT EXISTS events (
  seq_id SERIAL,
  sensor_id VARCHAR(10),
  status VARCHAR(1),
  upd_dt DATETIME,
  sensor_battery INT(5),
  FOREIGN KEY(sensor_id) references sensor_comp(sensor_id),
  PRIMARY KEY (sensor_id,
               upd_dt)
);

CREATE VIEW visit AS
SELECT a.seq_id,
          a.sensor_id,
          a.status,
          a.upd_dt AS time1,
     (SELECT b.upd_dt
      FROM events b
      WHERE b.sensor_id=a.sensor_id
        AND b.seq_id > a.seq_id
      ORDER BY b.seq_id
      LIMIT 1) AS time2
   FROM events a
   ORDER BY seq_id;
