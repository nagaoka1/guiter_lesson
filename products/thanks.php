<?php

require_once('../stripe-php/init.php');

// シークレットキーをセットする
\Stripe\Stripe::setApiKey('sk_test_51H82fCJ6QGf3q10OleI8J0Nua8J0GyoDg139yayKRzo9M48FhrTK00L9G3BUrX7JD7FBHyKcJFIjL5Jx7u4VfWsF00Z4k52kj9');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ここではバリデーションは省略しています
    $name = $_POST['name'];
    $ruby = $_POST['ruby'];
    $email = $_POST['email'];
    $token = $_POST['token'];
    $password = $_POST['password'];

    // 顧客情報を登録
    $customer = \Stripe\Customer::create([
        'payment_method' => $token, // 登録する支払い方法
        'name' => $name,
        'email' => $email,
        'invoice_settings' => [
            'default_payment_method' => $token, // デフォルトで使用する支払い方法。必須。
        ],
    ]);

    // 顧客をプランに登録する
    $subscription = \Stripe\Subscription::create([
        // 先程登録した顧客情報のID
        'customer' => $customer->id,
        'items' => [
            [
              // 4-2で取得したプランID
              'plan' => 'price_1H82xzJ6QGf3q10OPns9Khvm',
            ],
        ],
        // トライアル期間設定
        // 'trial_end' => strtotime('+3 month'),
        // トライアル(無料)期間。UNIX秒で指定する。
    ]);
    // subsctiprionIDは、解約時に必要
    $sub_id = $subscription->id; // sub_GYJXuOff81PbZy


    // DBを準備
    try {
        $db = new PDO('mysql:dbname=guiter_school;host=localhost', 'root', 'root');
    } catch (PDOException $e) {
        print "Coudn't connet to the database: " . $e->getMessage();
        exit();
    }

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 顧客情報を登録
    try {
        $sql = "INSERT INTO users (name, ruby, email, password, role) VALUES (:name, :ruby, :email, :password, :role)";
        // 挿入する値は空のまま、SQL実行の準備をする
        $stmt = $db->prepare($sql);
        // 挿入する値を配列に格納する
        $params = array(':name' => $name, ':ruby' => $ruby, ':email' => $email, ':password' => $password, ':role' => 0);
        // 挿入する値が入った変数をexecuteにセットしてSQLを実行
        $stmt->execute($params);


    } catch (PDOException $e) {
        print "Coudn't connet to the database: " . $e->getMessage();
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>指弾きギター道場</title>
<link rel="icon" type="image/x-icon" href="../img/favicon.jpeg">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/header_footer.css">
<link rel="stylesheet" href="../css/thanks.css">
</head>

<body>

  <?php require_once("header.php") ?>

  <main>
    <div class="main_wrap">
      <div class="main_con1">
        <h1>Thank You!</h1>
        <p>お支払いが完了しました。
          <br>
           ご入力いただいたメールアドレスに、確認メールが届きます。
        </p>
      </div>
    </div>
  </main>

  <?php require_once("footer.php") ?>

</body>
</html>
