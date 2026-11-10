
<?php
$host = "localhost";
$dbname = "instagram_db";
$user = "root";
$password = "";

try {
    $con = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die(json_encode(["erro" => $e->getMessage()]));
}
?>

