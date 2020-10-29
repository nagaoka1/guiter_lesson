<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

// ログアウト処理
if(isset($_GET['logout'])) {
  // セッション情報を破棄する ・・・ セッション情報が入っているものに、空の配列に入れ直してやる
  $_SESSION = array();
  session_destroy(); // スタートしたセッションを破棄できる
}

// ログイン画面を経由しているか確認する
if(!isset($_SESSION['User'])) {
  // セッション情報が無ければ元のページに戻す
  header('Location: /guiter_school/products/login.php');
  exit; // 処理を止める。exitがないと画面遷移しているのに、後続の処理が行われてしまうなどの不具合が起きることがある
}

try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  // 達成度指数の入った数列$resultを作る
  $result = $user->findByAchievement($_SESSION['User']['id']);
}
catch(PDOException $e) {
  echo "エラー: ".$e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>指弾きギター道場</title>
<link rel="icon" type="image/x-icon" href="../img/favicon.jpeg">
<!-- モダンブラウザ用のリセットcss適用させておく -->
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/header_footer.css">
<link rel="stylesheet" href="../user.css/.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- グラフ専用のライブラリ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
</head>

<body>

  <?php require_once("header.php") ?>

  <main>
    <div class="main_wrap">
      <h2 class="main_title">こんにちは<?=$_SESSION['User']['name']?>さん</h2>
      <p><a href="?logout=1">ログアウト</a></p> <!-- ログアウトを伝えるキーを設定 -->
      <div class="height30"></div>
      <div class="barChart">
        <canvas id="myBarChart"></canvas>
      </div>

    </div>
  </main>

  <?php require_once("footer.php") ?>

</body>
</html>

<!-- グラフのスクリプト -->
<script>
var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
  type: 'horizontalBar',
  data: {
    labels: ['第１章', '第２章', '第３章', '第４章', '応用編', '番外編', '指弾きアドバンス伴奏'],
    datasets: [
      {
        label: 'パート１',
        // 保存してある達成度指数をいれる
        data: [<?=$result[0]['term1']?>,
               <?=$result[1]['term1']?>,
               <?=$result[2]['term1']?>,
               <?=$result[3]['term1']?>,
               <?=$result[4]['term1']?>,
               <?=$result[5]['term1']?>,
               <?=$result[6]['term1']?>
        ],
        backgroundColor: "rgba(130,201,169,0.5)"
      },{
        label: 'パート２',
        data: [<?=$result[0]['term2']?>,
               <?=$result[1]['term2']?>,
               <?=$result[2]['term2']?>,
               <?=$result[3]['term2']?>,
               <?=$result[4]['term2']?>,
               <?=$result[5]['term2']?>,
               <?=$result[6]['term2']?>
        ],
        backgroundColor: "rgba(255,183,76,0.5)"
      },{
        label: 'パート３',
        data: [<?=$result[0]['term3']?>,
               <?=$result[1]['term3']?>,
               <?=$result[2]['term3']?>,
               <?=$result[3]['term3']?>,
               <?=$result[4]['term3']?>,
               <?=$result[5]['term3']?>,
               <?=$result[6]['term3']?>
        ],
        backgroundColor: "rgba(219,39,91,0.5)"
      }
    ]
  },
  options: {
    // グラフの名前設定
    title: {
      display: true,
      text: '指弾きレッスン達成度'
    },
    scales: {
      yAxes: [{
        ticks: {
          // 設定されていたが意味がないっぽいので、いったん消してある。
          // suggestedMax: 3,
          // suggestedMin: 0,
          // stepSize: 1,
          callback: function(value, index, values){
            return  value +  ''
          }
        }
      }]
    },
  }
});
</script>
