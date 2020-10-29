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
</head>

<body>

  <?php require_once("header.php") ?>

  <main>
    <div class="main_wrap">
      <div class="main_con1">
        <p class="sub_title">新規会員登録</p>
        <p>指弾きギター道場の月額プラン(1980円/税込)に登録する。</p>
        <div class="height30"></div>
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
            <input id="password" class="width100" type="text" name="password">
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

      <p class="sub_title">特定商取引法に基づく表記</p>
      <p class="padding_b30">
        【販売価格について】
        <br><br>
        販売価格は、表示された金額（表示価格/消費税込）と致します。
        <br><br>
        【代金の支払時期と方法】
        <br><br>
        支払方法 クレジットカード決済がご利用頂けます。
        支払時期 商品注文時点でお支払いが確定いたします。
        <br><br>
        月額定期支払いのプランは、初回の決済日から１か月後に次回の決済がされます。
        <br><br>
        それ以降、退会されるまで自動で１か月ごとに決済がされます。
        <br><br>
        いつでも退会可能です。次回課金前に退会希望の際は、決済日の３日前までにお問い合わせのページより退会の申し込みをお願いいたします。
        <br><br>
        【返品についての特約事項】
        <br><br>
        「オンライン動画講座」という商品サービスの特性上、返品には応じません。
        <br><br>
        一度入金されてからの返金には応じません。
        <br><br>
        【事業者の名称および連絡先】
        <br><br>
        事業者　小松洸陽
        <br><br>
        高知県高知市
        お問い合わせ 　englishman921@gmail.com
        連絡先電話番号、住所についても、メールにてご請求いただければ、遅滞なく開示いたします。
      </p>



    </div>
  </main>

  <?php require_once("footer.php") ?>

</body>
</html>
