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
                    components.comp_id,
                    components.status,
                    components.upd_dt
                  FROM components
                  JOIN (
                    SELECT comp_id, MAX(upd_dt)
                    AS upd_dt
                    FROM components
                    GROUP BY comp_id
                  ) t2 ON components.comp_id = t2.comp_id
                  AND components.upd_dt = t2.upd_dt";

        $stmt = mysqli_query($this->conn, $query);

        return $stmt;
    }
}

?>
