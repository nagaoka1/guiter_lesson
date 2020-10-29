<?php
session_start();

require_once("../config/config.php");
require_once("../model/Lesson.php");
// require_once("../model/User.php");

// ログイン画面を経由しているか確認する
if(!isset($_SESSION['User'])) {
  // セッション情報が無ければ元のページに戻す
  header('Location: /guiter_school/products/login.php');
  exit; // 処理を止める。exitがないと画面遷移しているのに、後続の処理が行われてしまうなどの不具合が起きることがある
}


try {
  $lesson = new Lesson($host, $dbname, $user, $pass);
  $lesson->connectDb();

  // レッスンごとのaタグからget送信された値を受け取る
  $lesNum = $_GET['lesNum'];
  $result['Lesson'] = $lesson->findById($lesNum); // 参照メソッドで返ってきた情報を変数に格納

  // 達成度編集
  if($_POST) {
    $lesson->editAchievement($_POST, $_SESSION['User']['id'], $lesNum);
  }

  // 達成度をデータベースから取ってくる
  $result['LessonAchieve'] = $lesson->findByLessonAchieve($_SESSION['User']['id'], $lesNum);

  // ラジオボタンとデータベース連携
  // まずチェックボックスの配列に全て空のものを入れておき、データベースから取ってきたものと合うものだけcheckedになるようにする。
  $checked1["check"]=["0"=>"","1"=>"","2"=>"","3"=>""];
  $checked1["check"][$result['LessonAchieve']['term1']]=" checked";
  $checked2["check"]=["0"=>"","1"=>"","2"=>"","3"=>""];
  $checked2["check"][$result['LessonAchieve']['term2']]=" checked";
  $checked3["check"]=["0"=>"","1"=>"","2"=>"","3"=>""];
  $checked3["check"][$result['LessonAchieve']['term3']]=" checked";

}
catch (PDOException $e) {
    print "エラー!: " . $e->getMessage() . "<br/gt;";
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
<link rel="stylesheet" href="../css/lesson.css">
<link rel="stylesheet" href="../css/header_footer.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>

  <?php require_once("header.php") ?>

  <main>
    <div class="main_wrap">
      <h2 class="title"><?= $result['Lesson']['title']?></h2>
      <form class="" action="" method="post">
        <!-- 動画１ -->
        <div class="video-wrap">
            <video controls poster="<?=$result['Lesson']['thu1'] ?>" id="video" class="video">
              <source src="<?=$result['Lesson']['mov1'] ?>" type="video/mp4" />
              <img src="test-movie.jpg" />
            </video>
            <div class="video-btn" id="video-btn"></div>
        </div>
        <a class="score" href="<?=$result['Lesson']['sco1'] ?>"><?=$result['Lesson']['sco_name1'] ?></a>

        <!-- ラジオボタンで達成度確認ツールを作成 -->
        <div class="radio">
          <label><input type="radio" name="check1" value="0" <?=$checked1["check"]["0"]?>>動画未視聴</label>
          <label><input type="radio" name="check1" value="1" <?=$checked1["check"]["1"]?>>視聴完了</label>
          <label><input type="radio" name="check1" value="2" <?=$checked1["check"]["2"]?>>ある程度弾ける</label>
          <label><input type="radio" name="check1" value="3" <?=$checked1["check"]["3"]?>>通して弾ける</label>
        </div>

        <!-- 動画２ -->
        <div class="video-wrap">
            <video controls poster="<?=$result['Lesson']['thu2'] ?>" id="video" class="video">
              <source src="<?=$result['Lesson']['mov2'] ?>" type="video/mp4" />
              <img src="test-movie.jpg" />
            </video>
            <div class="video-btn" id="video-btn"></div>
        </div>
        <a class="score" href="<?=$result['Lesson']['sco2'] ?>"><?=$result['Lesson']['sco_name2'] ?></a>

        <div class="radio">
          <label><input type="radio" name="check2" value="0" <?=$checked2["check"]["0"]?>>動画未視聴</label>
          <label><input type="radio" name="check2" value="1" <?=$checked2["check"]["1"]?>>視聴完了</label>
          <label><input type="radio" name="check2" value="2" <?=$checked2["check"]["2"]?>>ある程度弾ける</label>
          <label><input type="radio" name="check2" value="3" <?=$checked2["check"]["3"]?>>通して弾ける</label>
        </div>

        <!-- 動画3 -->
        <div class="video-wrap">
            <video controls poster="<?=$result['Lesson']['thu3'] ?>" id="video" class="video">
              <source src="<?=$result['Lesson']['mov3'] ?>" type="video/mp4" />
              <img src="test-movie.jpg" />
            </video>
            <div class="video-btn" id="video-btn"></div>
        </div>
        <a class="score" href="<?=$result['Lesson']['sco3'] ?>"><?=$result['Lesson']['sco_name3'] ?></a>

        <div class="radio">
          <label><input type="radio" name="check3" value="0" <?=$checked3["check"]["0"]?>>動画未視聴</label>
          <label><input type="radio" name="check3" value="1" <?=$checked3["check"]["1"]?>>視聴完了</label>
          <label><input type="radio" name="check3" value="2" <?=$checked3["check"]["2"]?>>ある程度弾ける</label>
          <label><input type="radio" name="check3" value="3" <?=$checked3["check"]["3"]?>>通して弾ける</label>
        </div>

        <input type="submit" name="" value="達成度変更">

      </form>
    </div>
  </main>

  <?php require_once("footer.php") ?>

</body>
</html>

<!-- 動画のコントロールバー設定 -->
<!-- このスクリプトを動かすと挙動がおかしくなるので消したら何も問題なく動いた。後で問題が出たら見直す -->
<!-- <script>
  const video = document.querySelector('#video');
  const video_btn = document.querySelector('#video-btn');
  let is_playing = false;

  video_btn.addEventListener('click', () => {
  if (!is_playing) {
    video.play();
    is_playing = true;
  } else {
    video.pause();
    is_playing = false;
  }
  });
</script> -->
