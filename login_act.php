<?php

session_start();

$userid = $_POST["userid"];
$userpw = $_POST["userpw"];

//1. 接続します
require_once('funcs.php');
$pdo = db_conn();





// try {
//   $pdo = new PDO('mysql:dbname=test;charset=utf8;host=localhost:8888','root','root');
// } catch (PDOException $e) {
//   exit('DbConnectError:'.$e->getMessage());
// }

//２．データ登録SQL作成
$sql = "select * from user WHERE userid=:userid AND userpw=:userpw";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userid', $userid);
$stmt->bindValue(':userpw', $userpw);
$res = $stmt->execute();

//SQL実行時にエラーがある場合
if($res==false){
  $error = $stmt->errorInfo();
  exit("QueryError:".$error[2]);
}

//３．抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//４. 該当レコードがあればSESSIONに値を代入
if( $val["id"] != "" ){
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["userid"]       = $val['userid'];
  $_SESSION["username"]       = $val['username'];
  //Login処理OKの場合select.phpへ遷移
  header("Location: genba.php");
}else{
  //Login処理NGの場合login.phpへ遷移
  header("Location: login.php");
}
//処理終了
exit();

?>


