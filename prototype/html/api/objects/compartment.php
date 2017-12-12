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
        $query = "SELECT
                    compartment.comp_id,
                    compartment.status,
                    compartment.upd_dt
                  FROM compartment
                  JOIN (
                    SELECT comp_id, MAX(upd_dt)
                    AS upd_dt
                    FROM compartment
                    GROUP BY comp_id
                  ) t2 ON compartment.comp_id = t2.comp_id
                  AND compartment.upd_dt = t2.upd_dt";

        $stmt = mysqli_query($this->conn, $query);

        //selectした結果を返す
        return $stmt;
    }

    public function insert($comp_id, $status)
    {
        //現在日付時刻を変数に格納
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");
        //データベースにデータを登録
        $query = "INSERT INTO `compartment` (`comp_id`,`status`,`upd_dt`) VALUES ('$comp_id','$status','$today')";

        $result = mysqli_query($this->conn, $query);

        // insert文の実行結果を返す
        return $result;
    }
}
?>
