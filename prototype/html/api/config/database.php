<?php

class Database
{

  // 静的変数を宣言。 複数回の接続を禁止
    public static $connection;

    public function db_connect()
    {
       try {
            // DBへの接続がまだ確立されていなければ、DBへの接続を試みる。
            if (!isset($connection)) {
                // ファイルのパスを指定してDB接続用のconfig.iniをLoadする
                $config = parse_ini_file('../../../config/config.ini');
                $connection = mysqli_connect('127.0.0.1', $config['username'], $config['password'], $config['dbname']);
            }// 接続失敗の場合、エラー処理が必要
            if ($connection === false) {
                // エラーハンドリング
                // 管理者に連絡,
                // エラーをログに吐き出す,
                // エラースクリーンを表示させる, など
                throw new Exception("Connect failed: %s\n", mysqli_connect_error());
                return mysqli_connect_error();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            // コネクションクローズ
            mysqli_close($connection);
        }
        return $connection;
    }
}
?>
