<?php
// ファイル読み込み
include_once 'api/config/database.php';
include_once 'insert.php';

// Databaseインスタンス生成
$database = new Database();

$db = $database->db_connect();

// 初期化
$get_stat = new get_stat($db);

//GETメソッドでセンサーから送信された値を取得し、変数に格納
$comp_id = $_GET['g_id'];
$status = $_GET['g_status'];

//get_statクラスのinsert関数をセンサーの値を引数にして実行
$get_stat->insert($comp_id,$status);

?>
