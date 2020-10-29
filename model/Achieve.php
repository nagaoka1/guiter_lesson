<?php
require_once("DB.php");

class Achieve extends DB {

  // 参照（条件付き）　特定のIDの参照
  public function findByAchievement($id) {
    $sql = "SELECT lesson_id, term1, term2, term3 FROM achieves WHERE user_id = :id";
    $stmt = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result;
  }


}
