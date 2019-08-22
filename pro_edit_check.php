<?php
    session_start();
    session_regenerate_id(true);
    if (isset($_SESSION['login']) == false) {
        echo 'ログインされていません<br>';
        print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
        exit();
    } else {
        echo $_SESSION['staff_name'].'さんログイン中<br><br>';
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ろくまる農園</title>
  </head>
  <body>
    <?php
        require_once('../common/common.php');

        $post = sanitize($_POST);
      $pro_code = $post['code'];
      $pro_name = $post['name'];
      $pro_price = $post['price'];
      $pro_gazou_name_old = $post['gazou_name_old'];
      $pro_gazou = $_FILES['gazou'];
      
    if ($pro_name == '') {
        print '商品名が入力されていません。<br />';
    } else {
        print '商品名：';
        print $pro_name;
        print '<br />';
    }

    if (preg_match('/\A[0-9]+\z/', $pro_price) == 0) {
        print '価格が数値以外で入力されています<br />';
    } else {
        print '価格：'.$pro_price.'円<br>';
    }

    if ($pro_gazou['size'] > 0) {
        if ($pro_gazou['size'] > 1000000) {
            echo '画像の容量が大きすぎます';
        } else {
            move_uploaded_file($pro_gazou['tmp_name'], './gazou/'.$pro_gazou['name']);
            echo '<img src="./gazou/'.$pro_gazou['name'].'"><br>';
        }
    } else {
        // 画像を変更しない時の処理
        echo '<img src="./gazou/'.$pro_gazou_name_old.'"><br>';
    }
    if ($pro_name == '' || preg_match('/\A[0-9]+\z/', $pro_price) == 0 || $pro_gazou['size'] > 1000000) {
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
    } else {
        echo '上記のように変更します。<br>';
        print '<form method="post" action="pro_edit_done.php">';
        print '<input type="hidden" name="code" value="'.$pro_code.'">';
        print '<input type="hidden" name="name" value="'.$pro_name.'">';
        print '<input type="hidden" name="price" value="'.$pro_price.'">';
        // 画像変更しない時はここらへんいじれば良さそう
        echo  '<input type="hidden" name="gazou_name_old" value="'.$pro_gazou_name_old.'">';
        echo  '<input type="hidden" name="gazou_name" value="'.$pro_gazou['name'].'">';
        print '<br />';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '<input type="submit" value="OK">';
        print '</form>';
    }
    ?>
  </body>
</html>