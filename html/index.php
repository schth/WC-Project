<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Watcher of Compartment</title>
	<link rel="icon" href="image/favicon.png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/jumbotron-narrow.css" rel="stylesheet">
    <link href="css/wc.css" rel="stylesheet" />
  </head>

<!--
                                                                                    .1&..
                                                                                    71._C,
                                                                                   _7&_6.z-
                                                                             .J+..dH}()(:(>
                                                                            dMgggH       _
                                                                            vHgggK
                                                                             (z7>
                                                                           .MMMMMN,
                    私達と一緒に「もりらぼ」しませんか？                 .dMMMMMMggm.
                                                                        dMM9MMMgggTHHo
                                                                         ` .Hggggg; !`
                                                                           jggHHggb
                                                                          .XgH{(HgR_
                                                                          (HND  4@M)
                                                                          .7=   ."=

          ..Jgg-             ..Jx.                    .......         ....,         ..(,d+
           dMM#:      .      JMMN>.dY""WMNm,            ?WMMMNp       (MMM% UB"""""YT9?MCT}
      ?M9""MMMMBYYYYYT9\     JMMM@!     dMMN,    .J&gg-    7MMD       (MMM:      .UMM#
           dMM#`             JMMN{      ,MMMb     ,MM#:               JMMM .JJJJJJdMMNJ+s.
      .....WMMN.......+,     JMMN{      .MMMN     JMM#~    ....       dMMN  ?`    JMM#
      .=```MMM@~~~~~~~~~`    JMMN{      .MMM#     dMM#(JVT"""WMMN+    dMM#        JMM#
           MMMb              JMMN{      .MMMF     MMMM=       (MMMb.  dMM@   .(JJ+dMM#
           MMMb        .x:    ~~~      .dMM@`     _~~`        .MMM#~  dMM@  dMMD  JMMMNx.
           dMMNm.....JgM^             .dMM@`       ..        .dMMM$   dMMN .MMM[  JMM#TMN)
            ?MMMMMMMMM9!           ..dMB=`          ?9QgggggMMMM9!    -MMM#!?MMN-.dM#^ (8`
               ``````            _?!``                  ~!!!!`          ~!     ````             　　　　　　　　　　　　　　　　　
 -->
  <body>
 	<div class="container">
		<header class="header">
			<h1>Watcher of Compartment</h1>
			<h4>～トイレとお腹の渋滞緩和から始める働き方改革～</h4>
		</header>
		
        <p class="lead">商船三井ビル2階　個室の空き状況を(ほぼ)リアルタイムにお知らせします</p>
  
<?php
          // APIを利用
          $url = 'http://127.0.0.1/api/compartment/read_status.php';
          $json = file_get_contents($url);
          // $json文字列をオブジェクト型に変換
          $result = json_decode($json);

          //個室の残数はとりあえず出さないことにした
        /* 
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
              //echo '<img src="image/layout.png" alt="男子トイレ図" width="540" height="210" />';
          } 
          */

        echo '<div class="container">';
          foreach ($result->records as $key => $value) {
              switch ($value->comp_id) {
                            // $value->statusの値がYなら、○を出力
                            case '1':
                                if ($value->status == 'Y') {
                                    echo '<div class="status1 greenBox">OPEN</div>';
                                } else {
                                echo '<div class="status1 redBox">CLOSE</div>';
                            }
                            break;
                            // $value->statusの値がNなら、×を出力
                            case '2':
                                if ($value->status == 'Y') {
                                    echo '<div class="status2 greenBox">OPEN</div>';
                                } else {
                                echo '<div class="status2 redBox">CLOSE</div>';
                            }
                            break;
                            case '3':
                                if ($value->status == 'Y') {
                                    echo '<div class="status3 greenBox">OPEN</div>';
                                } else {
                                echo '<div class="status3 redBox">CLOSE</div>';
                            }
                            break;
                            case '4':
                                if ($value->status == 'Y') {
                                    echo '<div class="status4 greenBox">OPEN</div>';
                                } else {
                                echo '<div class="status4 redBox">CLOSE</div>';
                            }
                            break;
                          }
          }
            echo '<img src="image/layout.png" alt="男子トイレ図" />';

        echo '</div>';

        /*   if (count($result->records)) {
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
          } */;
?>

	<footer	class="footer">
	 <ul class = "list-inline" style ="margin:auto;">
		<li>&copy; 2018 MOLIS Laboratory</li>
		<li><a href="index.php">Home</a></li>
		<li><a href="https://www.yammer.com/molgroup.com/topics/27207754"><img src="image/favicon.png" class="img-rounded" alt="logo"></li>
		<li><a href="privacy.html">Privacy</a></li>
		<li><a href="mailto:user@dammy.com">Contact</a></li>
		</ul>
	</footer>
</div>

</body>
</html>
