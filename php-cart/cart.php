<?php
session_start();


if(isset($_POST['add_cart'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $id = htmlspecialchars($id, ENT_QUOTES);
    $name = htmlspecialchars($name, ENT_QUOTES);
    $price = htmlspecialchars($price, ENT_QUOTES);

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]['qty']++;
    }else{
        $_SESSION['cart'][$id] = array('name' => $name, 'price' => $price, 'qty' => 1);
    }
}

    if(isset($_POST['empty_cart'])){
        $_SESSION['cart'] = NULL;
}

if(isset($_POST['delete_item'])){
    $id = $_POST['id'];
    $id = htmlspecialchars($id, ENT_QUOTES);
    unset($_SESSION['cart'][$id]);
}

if(isset($_POST['change_qty'])) {
    $id = $_POST['id'];
    $qty = mb_convert_kana($_POST['qty'], "n", "utf-8");

    $id = htmlspecialchars($id, ENT_QUOTES);
    $qty = htmlspecialchars($qty, ENT_QUOTES);

    if((int)$qty !== 0){
        $_SESSION['cart'][$id]['qty'] = $qty;
    }else{
        unset($_SESSION['cart'][$id]);
    }
  }


echo "<pre>";
var_dump($_SESSION);
echo "</pre>";


?>

<!-- ここからhtmlです -->


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングカート</title>
</head>
<body>
    <h2>カート</h2>
    <?php

    $sum = 0;

    if(isset($_SESSION['cart']) && count($_SESSION["cart"]) !== 0) {

        echo "<table>";

        foreach($_SESSION['cart'] as $id => $item) {
            echo "<tr>";
            echo "<td>" . $item['name'] . "</td>";
            echo "<td>" . number_format($item['price']) . "円</td>";

            echo '<td><form method="post" action="cart.php">
            <input type="text" name="qty" value="' . $item['qty'] . '">個
            <input type="hidden" name="id" value="' .$id . '">
            <input type="submit" name="change_qty" value="数量を変更">
            </form></td>';


            echo '<td><form action="cart.php" method="post">
            <input type="hidden" name="id" value="'.$id.'">
            <input type="submit" name="delete_item" value="削除">
            </form>
            </td>';
            $sum += (int)$item['price'] * $item['qty'];
        }

        echo "</table>";

        echo "合計:" . number_format($sum) . "円";

    echo "<p>";
    echo '<form action="cart.php" method="post"><input type="submit" name="empty_cart" value="カートを空にする"></form>';
    echo "</p>";

    }else{
        echo "カートは空です。";
    }

    ?>

    <h2>商品一覧</h2>
    <dl>

        <dt>椅子</dt>
        <dd>20,000円</dd>
        <dd>
        <form action="cart.php" method="post">
        <input type="submit" name="add_cart" value="カートにいれる">
        <input type="hidden" name="id" value="154171">
        <input type="hidden" name="name" value="椅子">
        <input type="hidden" name="price" value="20000">
        </form>
        </dd>


        <dt>テーブル</dt>
        <dd>50,000円</dd>
        <dd><form action="cart.php" method="post">
        <input type="submit" name="add_cart" value="カートにいれる">
        <input type="hidden" name="id" value="154277">
        <input type="hidden" name="name" value="テーブル">
        <input type="hidden" name="price" value="50000">
        </form>
        </dd>

        <dt>ソファ</dt>
        <dd>80,000円</dd>
        <dd><form action="cart.php" method="post">
        <input type="submit" name="add_cart" value="カートにいれる">
        <input type="hidden" name="id" value="154671">
        <input type="hidden" name="name" value="ソファ">
        <input type="hidden" name="price" value="80000">
        </form>
        </dd>
    </dl>


</body>
</html>
