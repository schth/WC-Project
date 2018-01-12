<?php
// ファイル読み込み
require_once '../config/database.php';
require_once '../objects/compartment.php';

if ($_SERVER["REQUEST_METHOD"]==="POST") {
    if (!empty($_POST['g_id']) && !empty($_POST['g_status']) && !empty($_POST['g_battery'])) {
        // g_id: センサーID　g_status: ドアの開閉状況　Y or　N
        //POSTメソッドでセンサーから送信された値を取得し、変数に格納
        $sensor_id = htmlspecialchars($_POST['g_id'], ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($_POST['g_status'], ENT_QUOTES, 'UTF-8');
        $battery = htmlspecialchars($_POST['g_battery'], ENT_QUOTES, 'UTF-8');

        // Databaseインスタンス生成
        $database = new Database();
        $db = $database->db_connect();

        // 初期化
        $compartment = new compartment($db);

        //compartemtクラスのinsert関数をセンサーの値を引数にして実行
        $result =  $compartment->insert($sensor_id, $status, $battery);

        //insert文の実行結果を判定
        if ($result) {
            //tureの場合
            echo "** New record created successfully **";
        } else {
            //falseの場合
            echo  "Record insert error";
        }
    } else {
        //POSTされたデータに入力されていない項目がある場合
        echo "入力されていない項目があります。";
    }
} else {
    //POSTメソッド以外で接続された場合
    # code...
}
?>
