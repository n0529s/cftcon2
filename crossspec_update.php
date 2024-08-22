<?php

session_start();

$pill_crossnum = $_POST["pill_crossnum"];
$pillsize_x = $_POST["pillsize_x"];
$pillsize_y = $_POST["pillsize_y"];
$thickness = $_POST["thickness"];
$mouth = $_POST["mouth"];
$sumiR = $_POST["sumiR"];
$cs_area = $_POST["cs_area"];
$gr_name = $_POST['gr_name'];
$id = $_POST['id'];

//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "UPDATE pillcrossspec SET gr_name = :gr_name, pill_crossnum= :pill_crossnum, pillsize_x= :pillsize_x, pillsize_y= :pillsize_y, thickness= :thickness, mouth= :mouth, sumiR= :sumiR, cs_area= :cs_area WHERE id = :id;"
);

// 4. バインド変数を用意
$stmt->bindValue(':id', $id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':gr_name', $gr_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_crossnum', $pill_crossnum, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pillsize_x', $pillsize_x, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pillsize_y', $pillsize_y, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':thickness', $thickness, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':mouth', $mouth, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':sumiR', $sumiR, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':cs_area', $cs_area, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)


// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: crossspec.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>


