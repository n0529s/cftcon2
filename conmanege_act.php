<?php

session_start();
if (isset($_SESSION['userid'], $_SESSION['username'], $_SESSION['gen_name'], $_SESSION['status22'])) {
    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];
    $gen_name = $_SESSION['gen_name'];
    $status22 = $_SESSION['status22'];
} else {
    exit("Session variables are not set.");
}

$design_contype = $_POST["Type"];
$design_strength = $_POST["Strength"];
$design_slump = $_POST["Slump"];
$design_air = $_POST["Air"];
$design_water = $_POST['Water'];
$design_ww = $_POST['Ww'];
$design_chlo = $_POST['Chlo'];
$design_bb = $_POST['Bb'];
$design_sink = $_POST['Sink'];

var_dump($design_bb);



// 1. 接続します
require_once('funcs.php');
$pdo = db_conn();

// 3. SQL文を用意(データ登録：INSERT)
if ($status22 == 0) {
    $stmt = $pdo->prepare(
        "INSERT INTO constmanege2 (id, gen_name, design_contype, design_strength, design_slump, design_air, design_water, design_ww, design_chlo, design_bb, design_sink)
        VALUES (NULL, :gen_name, :design_contype, :design_strength, :design_slump, :design_air, :design_water, :design_ww, :design_chlo, :design_bb, :design_sink)"
    );

    // 4. バインド変数を用意
    $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
    $stmt->bindValue(':design_contype', $design_contype, PDO::PARAM_STR);
    $stmt->bindValue(':design_strength', $design_strength, PDO::PARAM_STR);
    $stmt->bindValue(':design_slump', $design_slump, PDO::PARAM_STR);
    $stmt->bindValue(':design_air', $design_air, PDO::PARAM_STR);
    $stmt->bindValue(':design_water', $design_water, PDO::PARAM_STR);
    $stmt->bindValue(':design_ww', $design_ww, PDO::PARAM_STR);
    $stmt->bindValue(':design_chlo', $design_chlo, PDO::PARAM_STR);
    $stmt->bindValue(':design_bb', $design_bb, PDO::PARAM_STR);
    $stmt->bindValue(':design_sink', $design_sink, PDO::PARAM_STR);

    // 5. 実行
    $status = $stmt->execute();

    // 6. データ登録処理後
    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorMessage: " . $error[2]);
    } else {
        header('Location: conmanege.php');
        exit();
    }

} else {
    // 3. SQL文を用意(データ更新：UPDATE)
    $stmt = $pdo->prepare(
        "UPDATE constmanege2 
        SET gen_name=:gen_name, design_contype=:design_contype, design_strength=:design_strength, design_slump=:design_slump, 
        design_air=:design_air, design_water=:design_water, design_ww=:design_ww, design_chlo=:design_chlo, design_bb=:design_bb, design_sink=:design_sink 
        WHERE gen_name=:gen_name"
    );

    // 4. バインド変数を用意
    $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
    $stmt->bindValue(':design_contype', $design_contype, PDO::PARAM_STR);
    $stmt->bindValue(':design_strength', $design_strength, PDO::PARAM_STR);
    $stmt->bindValue(':design_slump', $design_slump, PDO::PARAM_STR);
    $stmt->bindValue(':design_air', $design_air, PDO::PARAM_STR);
    $stmt->bindValue(':design_water', $design_water, PDO::PARAM_STR);
    $stmt->bindValue(':design_ww', $design_ww, PDO::PARAM_STR);
    $stmt->bindValue(':design_chlo', $design_chlo, PDO::PARAM_STR);
    $stmt->bindValue(':design_bb', $design_bb, PDO::PARAM_STR);
    $stmt->bindValue(':design_sink', $design_sink, PDO::PARAM_STR);

    // 5. 実行
    $status = $stmt->execute();

    // 6. データ登録処理後
    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorMessage: " . $error[2]);
    } else {
        header('Location: conmanege.php');
        exit();
    }
}
?>



