<?php
require_once("DB.php");

class Lesson extends DB {

  // 参照（select)メソッド
  public function findAll() {
    $sql = 'SELECT * FROM lessons';
    $stmt = $this->connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result; // 呼び出しているところに参照結果を返す
  }

  // 参照（条件付き）　特定のIDの参照
  public function findById($id) {
    $sql = 'SELECT * FROM lessons WHERE id = :id';
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    // fetch()を使う。行を特定する関数？調べてもよくわからなかった。
    $result = $stmt->fetch();
    // 画面に出力しないといけないので、返り値で返してやる
    return $result;
  }

  // 特定のID、lessonの達成度参照
  public function findByLessonAchieve($user_id, $lesson_id) {
    $sql = "SELECT term1, term2, term3 FROM achieves WHERE user_id = :user_id AND lesson_id = :lesson_id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':user_id'=>$user_id, ':lesson_id'=>$lesson_id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }

  // 達成度編集
  public function editAchievement($arr, $user_id, $lesson_id) {
    $sql = "UPDATE achieves SET term1 = :term1, term2 = :term2, term3 = :term3, updated = :updated WHERE user_id = :user_id AND lesson_id = :lesson_id";
    $stmt = $this->connect->prepare($sql);
    $params = array(
      ':user_id'=>$user_id,
      ':lesson_id'=>$lesson_id,
      ':term1'=>$arr['check1'],
      ':term2'=>$arr['check2'],
      ':term3'=>$arr['check3'],
      ':updated'=>date('Y-m-d H:i:s')
    );
    $stmt->execute($params);
  }


}
