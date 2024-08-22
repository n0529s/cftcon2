<?php

session_start();

$axle = $_POST["axle"];
$stcore_num = $_POST["stcore_num"];
$stcore_coordineate = $_POST["stcore_coordineate"];
$gen_name = $_SESSION['gen_name'];

$coord_new = $stcore_coordineate/1000;

var_dump($gen_name);


//1. 接続します
require_once('funcs.php');
$pdo = db_conn();

// 座標検索
$stmt = $pdo->prepare("SELECT * FROM stcore WHERE gen_name = :gen_name and axle = :axle");
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
$stmt->bindValue(':axle', $axle, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      $coord1 = $cood2 +$result['stcore_coordineate']/1000;
      $cood2 = $coord1;
    }
  }

$coord = $coord1 + $coord_new;

var_dump($coord);




// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO stcore( stcore_id, gen_name, axle, stcore_num, stcore_coordineate, coord)
  VALUES( NULL, :gen_name, :axle, :stcore_num, :stcore_coordineate, :coord)"
);

// 4. バインド変数を用意
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':axle', $axle, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_num', $stcore_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_coordineate', $stcore_coordineate, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':coord', $coord, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)


 
// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: core.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>


