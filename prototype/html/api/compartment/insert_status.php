<?php
// ファイル読み込み
require_once '../config/database.php';
require_once '../objects/compartment.php';

if ($_SERVER["REQUEST_METHOD"]==="POST") {
    if (!empty($_POST['g_id']) && !empty($_POST['g_status'])) {

   //POSTメソッドでセンサーから送信された値を取得し、変数に格納
        $comp_id = htmlspecialchars($_POST['g_id'], ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($_POST['g_status'], ENT_QUOTES, 'UTF-8');

        // Databaseインスタンス生成
        $database = new Database();
        $db = $database->db_connect();

        // 初期化
        $compartment = new compartment($db);

        //get_statクラスのinsert関数をセンサーの値を引数にして実行
        $compartment->insert($comp_id, $status);
    } else {
        $err = "入力されていない項目があります。";
        echo $err;
    }
} else {
    # code...
}
?>
