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
      <p>
       <?php
          // APIを利用
          $url = 'http://127.0.0.1/api/compartment/read_status.php';
          $json = file_get_contents($url);
          // $json文字列をオブジェクト型に変換
          $result = json_decode($json);

// APIの結果から、個室の空室数を計算する処理
  if (count($result->records)) {
      $empty_number = 0;
      foreach ($result->records as $key => $value) {
          switch ($value->status) {
                // $value->statusの値がYなら、空室の数を＋１
                case 'Y':
                  $empty_number = $empty_number +1;
                  break;
                // $value->statusの値がNならBreak
                case 'N':
                  break;
              }
      }
      echo '<h4>男子トイレの空きは残り<font size="5" color="#ff0000">'.$empty_number.'</font>室！　走れ！!</h4>';
      //ここに見取り図を貼る
      echo '<img src="image/layout.png" alt="男子トイレ図" width="540" height="210" />';
  }
          if (count($result->records)) {
              // テーブルタグ出力
              echo '<table id="smp1">';
              // 1行目
              echo '<tr>';
              // 多次元連想配列から値を取得
              foreach ($result->records as $key => $value) {
                  // 行を出力
                  echo '<th>'.'00'.$value->comp_id.'</th>';
              }
              echo '</tr>';

              // 2行目
              echo '<tr>';
              foreach ($result->records as $key => $value) {
                  switch ($value->status) {
                    // $value->statusの値がYなら、○を出力
                    case 'Y':
                      echo '<td>○</td>';
                      break;
                    // $value->statusの値がNなら、×を出力
                    case 'N':
                      echo '<td>×</td>';
                      break;
                  }
              }
              echo '</tr>';
              // テーブルタグ閉じ
              echo '</table>';
          }
        ?>
      </p>
    </div>
  </body>

<footer>
<a href="privacyguide.html">プライバシーガイド</a>
<p>Copyright 2017</p>
</footer>

</html>
