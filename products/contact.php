<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

// ログイン画面を経由しているか確認する
if(!isset($_SESSION['User'])) {
  // セッション情報が無ければ元のページに戻す
  header('Location: /guiter_school/products/login.php');
  exit; // 処理を止める。exitがないと画面遷移しているのに、後続の処理が行われてしまうなどの不具合が起きることがある
}

try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if(isset($_POST['contact'])) {
    $user->addContact($_SESSION['User']['id'], $_POST['contact']);
    $message = 'お問い合わせありがとうございました。';
  }

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
<link rel="stylesheet" href="../css/contact.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>

  <?php require_once("header.php") ?>

  <main>
    <div class="main_wrap">
      <h2 class="main_title">お問い合わせ</h2>
      <p>ご意見、ご質問などなんでもお問合せください。</p>
      <p>ご質問はできるだけ具体的にお願いいたします。</p>
      <p>24時間以内の返信を心がけておりますが、内容によっては数日かかることもありますのでご了承ください。</p>
      <form class="" action="" method="post">
        <textarea name="contact" rows="8" cols="80"></textarea>
        <?php if(isset($message)) {echo $message.'<br>';} ?>
        <input class="submit" type="submit" name="" value="送信">
      </form>


    </div>
  </main>

  <?php require_once("footer.php") ?>

</body>
</html>
