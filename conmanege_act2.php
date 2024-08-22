<?php

session_start();
if (isset($_SESSION['userid'], $_SESSION['username'], $_SESSION['gen_name'], $_SESSION['status33'])) {
    $userid = $_SESSION['userid'];
    $username = $_SESSION['username'];
    $gen_name = $_SESSION['gen_name'];
    $status33 = $_SESSION['status33'];
} else {
    exit("Session variables are not set.");
}

$plant = $_POST["Plant"];
$plant_address = $_POST["Address"];
$plant_time = $_POST["Time"];
$plant_distance = $_POST["Distance"];
$plant_strength = $_POST["Strength"];
$plant_slump = $_POST['Slump'];
$plant_mix = $_POST['Mix'];
$plant_ceme = $_POST['Ceme'];
$plant_water = $_POST['Water'];
$plant_wcrate = $_POST['WCrate'];


var_dump($status33);


// 1. 接続します
require_once('funcs.php');
$pdo = db_conn();

// 3. SQL文を用意(データ登録：INSERT)
if ($status33 == 0) {
    $stmt = $pdo->prepare(
        "INSERT INTO plant (id, gen_name, plant, plant_address, plant_time, plant_distance, plant_strength, plant_slump, plant_mix, plant_ceme, plant_water, plant_wcrate)
        VALUES (NULL, :gen_name, :plant, :plant_address, :plant_time, :plant_distance, :plant_strength, :plant_slump, :plant_mix, :plant_ceme, :plant_water, :plant_wcrate)"
    );

    // 4. バインド変数を用意
    $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
    $stmt->bindValue(':plant', $plant, PDO::PARAM_STR);
    $stmt->bindValue(':plant_address', $plant_address, PDO::PARAM_STR);
    $stmt->bindValue(':plant_time', $plant_time, PDO::PARAM_STR);
    $stmt->bindValue(':plant_distance', $plant_distance, PDO::PARAM_STR);
    $stmt->bindValue(':plant_strength', $plant_strength, PDO::PARAM_STR);
    $stmt->bindValue(':plant_slump', $plant_slump, PDO::PARAM_STR);
    $stmt->bindValue(':plant_mix', $plant_mix, PDO::PARAM_STR);
    $stmt->bindValue(':plant_ceme', $plant_ceme, PDO::PARAM_STR);
    $stmt->bindValue(':plant_water', $plant_water, PDO::PARAM_STR);
    $stmt->bindValue(':plant_wcrate', $plant_wcrate, PDO::PARAM_STR);
    

    // 5. 実行
    $status = $stmt->execute();

    // 6. データ登録処理後
    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorMessage: " . $error[2]);
    } else {
        header('Location: conmanage.php');
        exit();
    }

} else {
    // 3. SQL文を用意(データ更新：UPDATE)
    $stmt = $pdo->prepare(
        "UPDATE plant
        SET gen_name=:gen_name, plant=:plant, plant_address=:plant_address, plant_time=:plant_time, 
        plant_distance=:plant_distance, plant_strength=:plant_strength, plant_slump=:plant_slump, plant_mix=:plant_mix, plant_ceme=:plant_ceme, plant_water=:plant_water,  plant_wcrate=:plant_wcrate,
        WHERE gen_name=:gen_name"
    );

    // 4. バインド変数を用意
    $stmt->bindValue(':gen_name', $gen_name, PDO::PARAM_STR);
    $stmt->bindValue(':plant', $plant, PDO::PARAM_STR);
    $stmt->bindValue(':plant_address', $plant_address, PDO::PARAM_STR);
    $stmt->bindValue(':plant_time', $plant_time, PDO::PARAM_STR);
    $stmt->bindValue(':plant_distance', $plant_distance, PDO::PARAM_STR);
    $stmt->bindValue(':plant_strength', $plant_strength, PDO::PARAM_STR);
    $stmt->bindValue(':plant_slump', $plant_slump, PDO::PARAM_STR);
    $stmt->bindValue(':plant_mix', $plant_mix, PDO::PARAM_STR);
    $stmt->bindValue(':plant_ceme', $plant_ceme, PDO::PARAM_STR);
    $stmt->bindValue(':plant_water', $plant_water, PDO::PARAM_STR);
    $stmt->bindValue(':plant_wcrate', $plant_wcrate, PDO::PARAM_STR);

    // 5. 実行
    $status = $stmt->execute();

    // 6. データ登録処理後
    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorMessage: " . $error[2]);
    } else {
        header('Location: conmanage.php');
        exit();
    }
}
?>



