-- マスターデータ
-- 2階男子トイレ1番目の個室
INSERT INTO sensor_comp(sensor_id, floor, gender,comp_id)VALUES ('10e27d0', 2, 1, 1);
INSERT INTO sensor_comp(sensor_id, floor, gender,comp_id)VALUES ('10e3533', 2, 1, 2);
INSERT INTO sensor_comp(sensor_id, floor, gender,comp_id)VALUES ('10e29b1', 2, 1, 3);
INSERT INTO sensor_comp(sensor_id, floor, gender,comp_id)VALUES ('10e34ee', 2, 1, 4);
-- トランザクションデータ

INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e27d0','N','2017-11-11 12:00:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e3533','N','2017-11-11 12:00:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e29b1','N','2017-11-11 12:00:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e34ee','N','2017-11-11 12:00:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e27d0','Y','2017-11-11 12:10:10');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e3533','Y','2017-11-11 12:20:20');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e27d0','N','2017-11-11 12:20:30');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e29b1','Y','2017-11-11 12:30:30');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e3533','N','2017-11-11 12:30:40');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e34ee','Y','2017-11-11 12:40:40');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e29b1','N','2017-11-11 12:40:50');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e34ee','N','2017-11-11 12:50:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e27d0','Y','2017-11-11 13:40:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e3533','Y','2017-11-11 13:50:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e29b1','Y','2017-11-11 14:10:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e34ee','Y','2017-11-11 14:20:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e27d0','N','2017-11-11 14:40:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e3533','N','2017-11-11 14:50:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e29b1','N','2017-11-11 15:10:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e27d0','Y','2017-11-11 15:15:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e34ee','N','2017-11-11 15:20:00');
INSERT INTO events(sensor_id, status, upd_dt)VALUES ('10e29b1','Y','2017-11-11 15:25:00');
