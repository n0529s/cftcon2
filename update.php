<?php
//1. POSTデータ取得
$num = $_POST["num"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$alt = $_POST["alt"];
$k_name = $_POST["k_name"];
$s_year = $_POST["s_year"];
$y_name = $_POST["y_name"];
$etc = $_POST["etc"];
$id = $_POST["id"];

//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQ
$stmt = $pdo->prepare( "UPDATE yama_kei_table SET num = :num,
 lat = :lat, lon = :lon, alt = :alt, k_name = :k_name, s_year = :s_year,
 y_name = :y_name, etc=:etc , indate = sysdate() WHERE id = :id;" );


$stmt->bindValue('k
:num', $num, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lat', $lat, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lon', $lon, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':alt', $alt, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':k_name', $k_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':s_year', $s_year, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':y_name', $y_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':etc', $etc, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();//実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}

