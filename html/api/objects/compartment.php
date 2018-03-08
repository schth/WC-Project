<?php
class Compartment
{

    // DBコネクション
    private $conn;

    // DBコネクションをコンストラクタ化
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        // SELECE文
        $query = "SELECT t2.comp_id,
                           events.status,
                           events.upd_dt
                    FROM   events
                    JOIN   (
                        SELECT events.sensor_id,
                               sensor_comp.comp_id,
                               MAX(events.upd_dt) AS upd_dt
                        FROM   events,
                               sensor_comp
                        WHERE  events.sensor_id = sensor_comp.sensor_id
                        AND    sensor_comp.floor = 2
                        -- AND  sensor_comp.gender = 1
                        GROUP BY events.sensor_id
                        ORDER BY sensor_comp.comp_id asc
                    ) t2
                    ON events.sensor_id = t2.sensor_id
                    AND    events.upd_dt = t2.upd_dt";

        $stmt = mysqli_query($this->conn, $query);

        //selectした結果を返す
        return $stmt;
    }

    public function insert($sensor_id, $status,$battery)
    {
        //現在日付時刻を変数に格納
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");
        //データベースにデータを登録
        $query = "INSERT INTO `events` (`sensor_id`,`status`,`upd_dt`, `sensor_battery`) VALUES ('$sensor_id','$status','$today','$battery')";

        $result = mysqli_query($this->conn, $query);

        if ($result == TRUE){
            // insert文の実行結果を返す
            return 1;
        }
        else {
            return mysqli_error($this->conn);
        }
    }

    public function get_sensor_list()
    {
        $query = "SELECT
                    events.sensor_id,
                    events.status
                  FROM events
                  JOIN (
                    SELECT sensor_id, max(upd_dt) as upd_dt
                    FROM events
                    GROUP BY sensor_id
                    ) t2
                    ON events.sensor_id = t2.sensor_id
                  AND events.upd_dt = t2.upd_dt";

        $stmt = mysqli_query($this->conn, $query);

        return $stmt;
    }
}
?>
