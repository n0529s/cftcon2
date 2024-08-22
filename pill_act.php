<?php

session_start();

$pill_num = $_POST["pill_num"];
$pill_sign = $_POST["pill_sign"];

$stcore_numX = $_POST["stcore_numX"];
$stcore_numY = $_POST["stcore_numY"];
$offsetX = $_POST["offsetX"];
$offsetY = $_POST["offsetY"];
$gen_name = $_SESSION['gen_name'];
$offset_st = $_POST["offset_st"];
$offset_end = $_POST["offset_end"];

if($offsetX ==""){
  $offsetX2=0;
}else{
  $offsetX2 = intval($offsetX);
  var_dump($offsetX);
  $offsetXX = $offsetX/1000;
  var_dump($offsetXX);
}
  
  
if($offsetY ==""){
  $offsetY2=0;
}else{
  $offsetY2 = intval($offsetY);
  var_dump($offsetY);
  $offsetYY = $offsetY/1000;
  var_dump($offsetYY);
}
  






//1. 接続します
require_once('funcs.php');
$pdo = db_conn();



//2. 柱長さ情報抽出
$stmt = $pdo->prepare("select * from pillvirtispec where pill_sign = :pill_sign");
$stmt->bindValue(':pill_sign', $pill_sign, PDO::PARAM_STR);
$status = $stmt->execute();

$virtilength3 = 0;

if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
      $virtilength = ($result['floor_height']/1000);
      $virtilength2 =  $virtilength +  $virtilength3;
      $virtilength3 =  $virtilength2;   
  }
}
//  開始終了オフセット追加
if($offset_st =="" && $offset_end =="" ){
  $virtilength4 = $virtilength3;
}elseif($offset_st ==""){
  $virtilength4 = $virtilength3+ $offset_end;
}elseif($offset_end ==""){
  $virtilength4 = $virtilength3 - $offset_st;
}else{
  $virtilength4 = $virtilength3 - $offset_st + $offset_end;
}

// var_dump($virtilenght3);

//３.１ 座標情報抽出X
$stmt = $pdo->prepare("select * from stcore where stcore_num = :stcore_numX");
$stmt->bindValue(':stcore_numX', $stcore_numX, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    if($offsetX =0){
      $coordX = ($result['coord']);
    }else
      $coordXX = floatval($result['coord']);
      $coordX = $coordXX+$offsetXX;
}
}

var_dump($coordX);

//３.２ 座標情報抽出Y
$stmt = $pdo->prepare("select * from stcore where stcore_num = :stcore_numY");
$stmt->bindValue(':stcore_numY', $stcore_numY, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}
else{
//Selectデータの数だけ自動でループしてくれる
//FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    if($offsetY =0){
      $coordY = ($result['coord']);
    }else
      $coordYY = floatval($result['coord']);
      $coordY = $coordYY+$offsetYY;
}
}

var_dump($coordY);









// ３．SQL文を用意(データ登録：INSERT)
$stmt = $pdo->prepare(
  "INSERT INTO design( pill_id, gen_name, pill_num, pill_sign, virtilength, stcore_numX, stcore_numY, coordX, coordY, offsetX, offsetY)
  VALUES( NULL, :gen_name, :pill_num, :pill_sign, :virtilength, :stcore_numX, :stcore_numY, :coordX, :coordY, :offsetX, :offsetY)"
);

// 4. バインド変数を用意
$stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_num', $pill_num, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pill_sign', $pill_sign, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':virtilength', $virtilength4, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_numX', $stcore_numX, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stcore_numY', $stcore_numY, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':coordX', $coordX, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':coordY', $coordY, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':offsetX', $offsetX2, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':offsetY', $offsetY2, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

// 5. 実行
$status = $stmt->execute();

// 6．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("ErrorMassage:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: pill.php');//ヘッダーロケーション（リダイレクト）
}
//処理終了
exit();

?>


