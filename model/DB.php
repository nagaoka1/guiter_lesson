<?php
// PDO接続するクラスを作って、必要毎に呼び出せるようにする
class DB {
  // プロパティ
  private $host;
  private $dbname;
  private $user;
  private $pass;
  protected $connect; // メソッドで所得した情報が格納される。protectedなので、子クラスでも使える

  // コンストラクタ
  function __construct($host, $dbname, $user, $pass) {
    $this->host = $host;
    $this->dbname = $dbname;
    $this->user = $user;
    $this->pass = $pass;
  }

  // メソッド ・・・ PDO接続する
  public function connectDb() {
    $this->connect = new PDO("mysql:host=$this->host; dbname=$this->dbname;", $this->user, $this->pass); // 動画の書き方が分かりにくかったので(というか、エラーが出て接続できなかった)、ダブルクォーテーションで変数そのままにした。参考サイト ・・・ https://gray-code.com/php/connection-db-by-using-pdo/
    if(!$this->connect) {
      echo 'DB接続できませんでした。';
      die();
    }
  }
}
