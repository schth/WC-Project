<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta name="generator"
    content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
    <meta charset="UTF-8" />
    <title>Watcher of Compartment</title>
    <link rel="stylesheet" href="css/wc.css" />
  </head>
  
  <body>
    <h1>Watcher of Compartment</h1>
    <h3>～トイレとお腹の渋滞緩和から始める働き方改革～</h3>
    <div id="container">
      <h4>商船三井ビル2階　個室の空き状況を(ほぼ)リアルタイムにお知らせします</h4>
      <h4>男子トイレの空きは残り(〇の数)室！　走れ！!</h4>
      <!--ここに見取り図を貼る-->
      <img src="image/layout.png" alt="男子トイレ図" width="540" height="210" />
      <p>
      <!--<table id="smp1">
        <tr>
          <th>001</th>
          <th>002</th>
          <th>003</th>
          <th>004</th>
        </tr>
        <tr>
          <td>〇</td>
          <td>〇</td>
          <td>〇</td>
          <td>〇</td>
        </tr>
      </table> -->
		<?php
        $url = 'http://127.0.0.1/api/compartment/read.php';
        $json = file_get_contents($url);
        // $json文字列をオブジェクト型に変換
        $result = json_decode($json);
        if (count($result->records)) {
            // テーブルタグ
            echo '<table id="smp1">';
            echo '<tr>';
            // 多次元連想配列から値を取得
            foreach ($result->records as $key => $value) {
                // 行を出力
                echo "<th>$value->comp_id</th>";
            }
            echo '</tr>';
            echo '<tr>';
            foreach ($result->records as $key => $value) {
                // 行を出力
                echo "<td>$value->status</td>";
            }
            echo '</tr>';
            // テーブルタグ閉じ
            echo '</table>';
        }

        ?>

		</p>
    </div>
  </body>
</html>
