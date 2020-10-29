<footer>
  <div class="header_con2">
    <div class="con2_item1">
      <ul class="con2_ul1">
        <li class="li1"><a class="menu_a" href="index.php">指弾きギター道場とは</a></li>
        <li class="drop_bt menu_a li1">稽古場<span class="caret"></span><!-- spanでキャレットを作っている -->
          <ul class="drop_menu" style="display: none;">
            <a class="a2" href="user.php"><li class="li2 border1">控室</li></a>
            <a class="a2" href="lesson.php?lesNum=1"><li class="li2 border1">第１章</li></a>
            <a class="a2" href="lesson.php?lesNum=2"><li class="li2 border1">第２章</li></a>
            <a class="a2" href="#"><li class="li2 border1">第３章</li></a>
            <a class="a2" href="#"><li class="li2 border1">第４章</li></a>
            <a class="a2" href="#"><li class="li2 border1">応用編<br>「ハイブリッドピッキング」</li></a>
            <a class="a2" href="#"><li class="li2 border1">番外編<br>「指弾きのススメ」</li></a>
            <a class="a2" href="#"><li class="li2 border1">指弾きアドバンス伴奏</li></a>
            <li class="li2"><a class="a2" href="#">更新情報</li></a>
          </ul>
        </li>
        <li class="li1"><a class="menu_a" href="contact.php">お問い合わせ</a></li>
        <li class="li1"><a class="menu_a" href="login.php">ログイン</a></li>
      </ul>
    </div>
  </div>
  <div class="footer_con1">
    <div class="footer_con1_item3"></div>
    <div class="footer_con1_item1">
      <a href="index.php"><img src="../img/cover.JPG" alt="ミニカバー"></a>
    </div>
    <div class="footer_con1_item2">
      <p>© 2019 指弾きギター道場.</p>
    </div>
  </div>
</footer>

<!-- ドロップダウンメニュー -->
<script>
$(function(){
  $(".drop_bt").on('click',function(){
    $(".drop_menu").slideToggle();
  });
});
</script>
