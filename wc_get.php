<?php
    //データベースへの接続
    $link = mysqli_connect("127.0.0.1","root","","wc");
    if(mysqli_connect_error()){
        die("データベースへの接続に失敗しました。");
    }
    //登録データを変数に格納
    $comp_id = $_GET['g_id']; 
    $status = $_GET['g_status'];
    date_default_timezone_set('Asia/Tokyo');
    $today = date("Y-m-d H:i:s");
    //データベースにデータを登録
    $query = "INSERT INTO `components` (`comp_id`,`status`,`upd_dt`) VALUES ('$comp_id','$status','$today')";
    
    if($result = mysqli_query($link,$query)){
        echo "INSERTクエリの発行に成功しました";
    }
    //$query = "SELECT * FROM components";
    //if($result = mysqli_query($link,$query)){
    //    echo "クエリの発行に成功しました";
    //}
    //$row = mysqli_fetch_array($result);
    //echo "<p>";
    //echo "トイレIDは".$row['comp_ID']."、利用状況は".$row['status']."です。";

?>