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

        return $stmt;
    }
}

?>
