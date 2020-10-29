<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  // ログイン画面を軽油しかつ、管理者か確認
  if($_POST) {
    $result = $user->login($_POST);
    $_SESSION['User'] = $result; // これでセッション情報が保持される
    if(isset($result)) {
      if($_SESSION['User']['role'] == 1) {

        $resultUser = $user->findAll();

        $resultContact = $user->findContact();

        $resultLesson = $user->findLesson();
      }
      else {
        // リダイレクト処理　・・・ ヘッダー関数を使う
        header('Location: /guiter_school/products/login.php');
        exit;
      }
    }
    else {
      // リダイレクト処理　・・・ ヘッダー関数を使う
      header('Location: /guiter_school/products/login.php');
      exit;
      // これでセッション情報を保持したまま、次の画面に推移する -> 保持したままはまずい？（後で考える）
    }
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
<link rel="stylesheet" href="../css/admin.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>

  <div class="left">
    <h3 class="menu_title">指弾きギター道場<br>管理画面</h3>
    <div class="hr"></div>
    <ul>
      <li id="btn1">ユーザー一覧</li>
      <li id="btn2">お問合せ一覧</li>
      <li id="btn3">チャプター一覧、追加</li>
      <li><a href="index.php">ホーム</a></li>
    </ul>
  </div>

  <div class="right">
    <div class="user">
      <h2>ユーザー一覧</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>ユーザ名</th>
          <th>フリガナ</th>
          <th>メールアドレス</th>
          <th></th>
        </tr>
        <?php foreach($resultUser as $row): ?>
          <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['name']?></td>
            <td><?=$row['ruby']?></td>
            <td><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a></td>
            <td>
              <a href="?id=<?=$row['id']?>">達成度確認</a>
              <a href="?edit=<?=$row['id'] ?>">編集</a>
              <!-- onClickイベントで削除前の確認をする。JQではないので、外部ファイルの読み込みなしで実装可能 -->
              <a href="?del=<?=$row['id'] ?>" onClick="if(!confirm('ID:<?=$row['id'] ?>削除しますがよろしいですか？')) return false;">削除</a> <!-- キャンセルを押すとfalseが帰ってきて処理が止まる -->
            </td>
          </tr>
        <?php endforeach; ?> <!-- endifやendforeachの後のセミコロンはいるらしい。なくても動いたけど -->
      </table>
    </div>

    <div class="contact">
      <h2>お問い合わせ一覧</h2>
      <table>
        <tr>
          <th>ID</th>
          <th>ユーザ名</th>
          <th>メールアドレス</th>
          <th>お問い合わせ内容</th>
          <th>お問合せ日時</th>
          <th></th>
        </tr>
        <?php foreach($resultContact as $row): ?>
          <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['user_name']?></td>
            <td><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a></td>
            <td><?=$row['contact']?></td>
            <td><?=$row['created']?></td>
            <td>
              <!-- onClickイベントで削除前の確認をする。JQではないので、外部ファイルの読み込みなしで実装可能 -->
              <a href="?del=<?=$row['id'] ?>" onClick="if(!confirm('ID:<?=$row['id'] ?>削除しますがよろしいですか？')) return false;">削除</a> <!-- キャンセルを押すとfalseが帰ってきて処理が止まる -->
            </td>
          </tr>
        <?php endforeach; ?> <!-- endifやendforeachの後のセミコロンはいるらしい。なくても動いたけど -->
      </table>

    </div>

    <div class="chapter">
      <h2>チャプター一覧</h2>
      <table class="font10">
        <tr>
          <th>ID</th>
          <th>タイトル</th>
          <!-- <th>サムネ1</th>
          <th>サムネ2</th>
          <th>サムネ3</th> -->
          <th>動画1</th>
          <th>動画2</th>
          <th>動画3</th>
          <th>楽譜1</th>
          <th>楽譜2</th>
          <th>楽譜3</th>
          <th>楽譜名1</th>
          <th>楽譜名2</th>
          <th>楽譜名3</th>
          <th></th>
        </tr>
        <?php foreach($resultLesson as $row): ?>
          <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['title']?></td>
            <!-- <td><//?=$row['thu1']?></td>
            <td><//?=$row['thu2']?></td>
            <td><//?=$row['thu3']?></td> -->
            <td><?=$row['mov1']?></td>
            <td><?=$row['mov2']?></td>
            <td><?=$row['mov3']?></td>
            <td><?=$row['sco1']?></td>
            <td><?=$row['sco2']?></td>
            <td><?=$row['sco3']?></td>
            <td><?=$row['sco_name1']?></td>
            <td><?=$row['sco_name2']?></td>
            <td><?=$row['sco_name3']?></td>
            <td>
              <a href="?edit=<?=$row['id'] ?>">編集</a>
              <a href="?del=<?=$row['id'] ?>" onClick="if(!confirm('ID:<?=$row['id'] ?>削除しますがよろしいですか？')) return false;">削除</a> <!-- キャンセルを押すとfalseが帰ってきて処理が止まる -->
            </td>
          </tr>
        <?php endforeach; ?>
      </table>

      <h2 class="margin30">チャプター追加、編集</h2>
      <form class="" action="" method="post">
        <label id="title">
          <p>タイトル</p>
          <input id="title" class="width100 margin20" type="text" name="title">
        </label>
        <label id=thu1>
          <!-- <p>サムネ1</p>
          <input id="thu1" class="width100 margin20" type="text" name="thu1">
        </label>
        <label id="thu2">
          <p>サムネ2</p>
          <input id="thu2" class="width100 margin20" type="text" name="thu2">
        </label>
        <label id="thu3">
          <p>サムネ3</p>
          <input id="thu3" class="width100 margin20" type="text" name="thu3">
        </label>
        <label id="mov1"> -->
          <p>動画1</p>
          <input id="mov1" class="width100 margin20" type="text" name="mov1">
        </label>
        <label id="mov2">
          <p>動画2</p>
          <input id="mov2" class="width100 margin20" type="text" name="mov2">
        </label>
        <label id="mov3">
          <p>動画3</p>
          <input id="mov3" class="width100 margin20" type="text" name="mov3">
        </label>
        <label id="sco1">
          <p>楽譜1</p>
          <input id="sco1" class="width100 margin20" type="text" name="sco1">
        </label>
        <label id="sco2">
          <p>楽譜2</p>
          <input id="sco2" class="width100 margin20" type="text" name="sco2">
        </label>
        <label id="sco3">
          <p>楽譜3</p>
          <input id="sco3" class="width100 margin20" type="text" name="sco3">
        </label>
        <label id="sco_name1">
          <p>楽譜名1</p>
          <input id="sco_name1" class="width100 margin20" type="text" name="sco_name1">
        </label>
        <label id="sco_name2">
          <p>楽譜名2</p>
          <input id="sco_name2" class="width100 margin20" type="text" name="sco_name2">
        </label>
        <label id="sco_name3">
          <p>楽譜名3</p>
          <input id="sco_name3" class="width100 margin20" type="text" name="sco_name3">
        </label>
        <br>
        <input type="submit" name="" value="チャプター追加">
      </form>

    </div>
  </div>

</body>
</html>

<script>
$(function() {

  //#btn1をクリックしたら発動
  $('#btn1').click(function() {
    $('.user').css('display','block');
    $('.contact').css('display','none');
    $('.chapter').css('display','none');
  });
  //#btn2をクリックしたら発動
  $('#btn2').click(function() {
    $('.contact').css('display','block');
    $('.user').css('display','none');
    $('.chapter').css('display','none');
  });
  //#btn3をクリックしたら発動
  $('#btn3').click(function() {
    $('.chapter').css('display','block');
    $('.user').css('display','none');
    $('.contact').css('display','none');
  });

});
</script>
