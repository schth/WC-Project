<?php
    //データベースへの接続
    $link = mysqli_connect("127.0.0.1","root","","wc");
    if(mysqli_connect_error()){
        die("データベースへの接続に失敗しました。");
    }
    
    //個室毎に最新の更新日時のレコードのStatusを抽出
    $query1  =   "SELECT *
                FROM components cmp1
                WHERE
                cmp1.comp_id = 1
                AND cmp1.upd_dt = 
                        (SELECT MAX(cmp2.upd_dt)
                        FROM components cmp2
                        WHERE cmp2.comp_id=1)";
    
    $query2  =   "SELECT *
                FROM components cmp1
                WHERE
                cmp1.comp_id = 2
                AND cmp1.upd_dt = 
                        (SELECT MAX(cmp2.upd_dt)
                        FROM components cmp2
                        WHERE cmp2.comp_id=2)";

    $query3  =   "SELECT *
                FROM components cmp1
                WHERE
                cmp1.comp_id = 3
                AND cmp1.upd_dt = 
                        (SELECT MAX(cmp2.upd_dt)
                        FROM components cmp2
                        WHERE cmp2.comp_id=3)";
    
    $query4  =   "SELECT *
                FROM components cmp1
                WHERE
                cmp1.comp_id = 4
                AND cmp1.upd_dt = 
                        (SELECT MAX(cmp2.upd_dt)
                        FROM components cmp2
                        WHERE cmp2.comp_id=4)";

    //個室毎に最新のレコードを変数に代入
    $result1 = mysqli_query($link,$query1);
    $result2 = mysqli_query($link,$query2);
    $result3 = mysqli_query($link,$query3);
    $result4 = mysqli_query($link,$query4);
    
    $row1 = mysqli_fetch_array($result1);
    $row2 = mysqli_fetch_array($result2);
    $row3 = mysqli_fetch_array($result3);
    $row4 = mysqli_fetch_array($result4);
    
    //取得した時間を表示
    date_default_timezone_set('Asia/Tokyo');
    $today = date("Y-m-d H:i:s");
    echo "これは ".$today." に取得した状況です。<p>";
    
    //個室毎にStatusに応じて、メッセージを出力
    if($row1['status'] == 'N'){
        echo "個室1が空いてます！急げ！！！";
        }   else{
        echo "個室1は使われてます。";
        }
    echo "<p>";
    if($row2['status'] == 'N'){
        echo "個室2が空いてます！急げ！！！";
        }   else{
        echo "個室2は使われてます。";
        }
    echo "<p>";
    if($row3['status'] == 'N'){
        echo "個室3が空いてます！急げ！！！";
        }   else{
        echo "個室3は使われてます。";
         }
    echo "<p>";
    if($row4['status'] == 'N'){
        echo "個室4が空いてます！急げ！！！";
        }   else{
        echo "個室4は使われてます。";
        }
    //$row = mysqli_fetch_array($result);
    //echo "<p>";
    //echo "トイレIDは".$row['comp_ID']."、利用状況は".$row['status']."です。";

?>