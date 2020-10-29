<?php
require_once("DB.php");

class User extends DB {

  // ログインメソッド ・・・ ユーザ名とパスワードが一致するか確認する
  public function login($arr) {
    $sql = 'SELECT * FROM users WHERE email = :email AND password = :password';
    $stmt = $this->connect->prepare($sql);
    $params = array(':email'=>$arr['email'], ':password'=>$arr['password']);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  // 参照（select)メソッド
  public function findAll() {
    $sql = 'SELECT * FROM users';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result; // 呼び出しているところに参照結果を返す
  }

  // 参照（条件付き）　特定のIDの参照
  public function findById($id) {
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    // fetch()を使う。行を特定する関数？調べてもよくわからなかった。
    $result = $stmt->fetch();
    // 画面に出力しないといけないので、返り値で返してやる
    return $result;
  }

  // 特定のIDの達成度全参照
  public function findByAchievement($id) {
    $sql = "SELECT lesson_id, term1, term2, term3 FROM achieves WHERE user_id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    // 複数行あるので、fetchAll
    $result = $stmt->fetchAll();
    return $result;
  }

  // 達成度編集
  public function editAchievement($user_id, $lesson_id) {
    $sql = "UPDATE achieves SET user_name = :user_name, email = :email, password = :password, updated = :updated WHERE id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':id'=>$arr['id'],
      ':user_name'=>$arr['user_name'],
      ':email'=>$arr['email'],
      ':password'=>$arr['password'],
      ':updated'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }

  // お問い合わせ登録
  public function addContact($user_id, $contact) {
    $sql = "INSERT INTO contacts(user_id, contact, created) VALUES(:user_id, :contact, :created)";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':user_id'=>$user_id,
      ':contact'=>$contact,
      ':created'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }

  // お問い合わせ参照
  public function findContact() {
    $sql = "SELECT ";
    $sql .= "contacts.id, ";
    $sql .= "users.name as user_name, ";
    $sql .= "users.email, ";
    $sql .= "contacts.contact, ";
    $sql .= "contacts.created ";
    $sql .= "FROM contacts ";
    $sql .= "JOIN users ON users.id = contacts.user_id";
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  // レッスン参照
  public function findLesson() {
    $sql = 'SELECT * FROM lessons';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }


}
