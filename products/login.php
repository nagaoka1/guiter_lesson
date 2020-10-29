<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if($_POST) {
    $result = $user->login($_POST);
    $_SESSION['User'] = $result; // これでセッション情報が保持される
    if(!empty($result)) {
      // リダイレクト処理　・・・ ヘッダー関数を使う
      header('Location: /guiter_school/products/user.php'); // パスはマンプの場合ドキュメントルート以下
      exit;
      // これでセッション情報を保持したまま、次の画面に推移する
    }
    else {
      $message = "ログインできませんでした";
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
<link rel="stylesheet" href="../css/header_footer.css">
<link rel="stylesheet" href="../css/login.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- stripAPIを読み込みます -->
<script src="https://js.stripe.com/v3/"></script>
</head>

<body>

  <?php require_once("header.php") ?>

  <main>
    <div class="main_wrap">
      <h2 class="main_title">指弾きギター道場へログイン</h2>

      <div class="main_con1">
        <p class="sub_title">会員ログイン</p>

        <!-- ログイン失敗のメッセージ -->
        <?php if(isset($message)) echo "<p class='error'>".$message."</p>" ?>
        <form class="form1" action="" method="post">
          <label id="email">
            <p>メールアドレス</p>
            <input class="width100" type="email" name="email" value="">
          </label>
          <div class="height30"></div>
          <label id="password">
            <p>パスワード</p>
            <input class="width100" type="password" name="password" value="">
          </label>
          <div class="height30"></div>
          <input class="width100" type="submit" name="" value="ログイン">
        </form>

        <div class="height60"></div>
      </div>

      <div class="main_con1">
        <p class="sub_title">新規会員登録</p>
        <!-- 送り先はとりあえずこのページにしてある -->
        <form id="form_payment" class="form1" action="thanks.php" method="post">
          <label id="name">
            <p>名前（漢字）</p>
            <input id="name" class="width100" type="text" name="name">
          </label>
          <div class="height30"></div>
          <label id="name">
            <p>フリガナ</p>
            <input id="ruby" class="width100" type="text" name="ruby">
          </label>
          <div class="height30"></div>
          <label id="email">
            <p>メールアドレス</p>
            <input id="email" class="width100" type="text" name="email">
          </label>
          <div class="height30"></div>
          <label id="password">
            <p>パスワード</p>
            <input id="password" class="width100" type="password" name="password">
          </label>
          <div class="height30"></div>
          <label id="element">
            <p>クレジットカード情報</p>
            <div class="card_con">
              <div id="card-element" class="MyCardElement"></div>
            </div>
            <!-- ここにエラーメッセージが表示されます。 -->
            <div id="card-errors" role="alert"></div>
          </label>
          <div class="height30"></div>
          <button id="button" class="button width100">指びきギター道場に入門！</button>
        </form>
      </div>
      <div class="height30"></div>

      <div class="main_con1">
        <p class="sub_title">管理者ログイン</p>

        <form class="form1" action="admin.php" method="post">
          <label id="email">
            <p>メールアドレス</p>
            <input class="width100" type="email" name="email" value="">
          </label>
          <div class="height30"></div>
          <label id="password">
            <p>パスワード</p>
            <input class="width100" type="password" name="password" value="">
          </label>
          <div class="height30"></div>
          <input class="width100" type="submit" name="" value="ログイン">
        </form>

        <div class="height60"></div>
      </div>

    </div>
  </main>

  <?php require_once("footer.php") ?>

</body>
</html>

<!-- ストライプのスクリプト -->
<script>
  // 公開可能なAPIキーです。
  const stripe = Stripe('pk_test_51H82fCJ6QGf3q10OPfYfClLwGnKRX0itCzcG7XeLsYzYvjYbNQmOnl3ELf1KXBHDcmBRukIBSVj4bMnYOutJMTEc00Wzxsj7w0');
  // 入力フォームを生成します。スタイルを指定することもできます。
  const elements = stripe.elements();
  // 郵便番号の入力をなくす
  const cardElement = elements.create('card', {hidePostalCode: true});

  //　先程のdivタブにマウントします。
  cardElement.mount("#card-element");

  // クレジットカード番号や有効期限の入力に合わせてエラーメッセージを出力します。
  cardElement.addEventListener('change', ({error}) => {
      const displayError = document.getElementById('card-errors');
      if (error) {
        displayError.textContent = error.message;
      } else {
        displayError.textContent = '';
      }
  });

  const submit = document.getElementById('button');
  const name = document.getElementById('name');
  const email = document.getElementById('email');

  // 登録ボタンがクリックされたら、API通信をおこなう
  submit.addEventListener('click', async(e) => {
    e.preventDefault();
    const {paymentMethod, error} = await stripe.createPaymentMethod({
      type: 'card',
      card: cardElement,
        billing_details: {
          // 顧客名emailアドレスはなくてもOK
          name: name.value,
          email: email.value,
      },
    });
    // 通信エラー時
    if (error) {
      console.error(error)
    } else {
        // 成功したらトークンが返されるので、hiddenに埋め込む
        const form = document.getElementById('form_payment');
        const hiddenToken = document.createElement('input');
        hiddenToken.setAttribute('type', 'hidden');
        hiddenToken.setAttribute('value', paymentMethod.id);
        hiddenToken.setAttribute('name', 'token');
        form.appendChild(hiddenToken);
        form.submit();
      }
    });
</script>
