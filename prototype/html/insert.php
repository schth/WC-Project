<?php
class get_stat
{

    // DBコネクション
    private $conn;

    // DBコネクションをコンストラクタ化
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function insert($comp_id,$status)
    {
        //現在日付時刻を変数に格納
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d H:i:s");
        //データベースにデータを登録
        $query = "INSERT INTO `compartment` (`comp_id`,`status`,`upd_dt`) VALUES ('$comp_id','$status','$today')";
        
        mysqli_query($this->conn, $query);
    }
}

?>