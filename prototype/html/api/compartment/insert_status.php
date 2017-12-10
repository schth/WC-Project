<?php
// ファイル読み込み
include_once '../config/database.php';
include_once '../objects/compartment.php';

// Databaseインスタンス生成
$database = new Database();

$db = $database->db_connect();

// 初期化
$compartment = new compartment($db);

//GETメソッドでセンサーから送信された値を取得し、変数に格納
$comp_id = $_POST['g_id'];
$status = $_POST['g_status'];

//get_statクラスのinsert関数をセンサーの値を引数にして実行
$compartment->insert($comp_id,$status);

?>
