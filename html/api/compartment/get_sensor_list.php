<?php
// ヘッダー設定
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// ファイル読み込み
require_once '../config/database.php';
require_once '../objects/compartment.php';

// Databaseインスタンス生成
$database = new Database();

$db = $database->db_connect();

// 初期化
$compartment = new Compartment($db);

// compartmentからデータ抽出
$stmt = $compartment->get_sensor_list();
// 抽出した結果を$numに代入
$num = mysqli_num_rows($stmt);

// データのありかをチェック
if ($num > 0) {
    // 配列設定
    $sensors_arr=array();
    $sensors_arr["records"]=array();

    while ($row = mysqli_fetch_assoc($stmt)) {
		//array_push($sensors_arr, $row);
    //array_push($sensors_arr, array($row['sensor_id'] => $row['status']));
    array_push($sensors_arr["records"], $row);
		}
    //compartments_arrの要素をJSON 形式にした文字列を返します
    echo json_encode($sensors_arr);
} else {
	echo json_encode(
	array("message" => "No sensor found.")
	);
	}
?>
