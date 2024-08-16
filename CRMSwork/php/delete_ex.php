<?php
  const DB_HOST = "mysql:host=localhost;dbname=crms_db;charset=utf8";
  const DB_USER = "root";
  const DB_PASSWORD = "";

  try{
    $pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD);
    echo "接続成功";

  } catch(PDOException $e) {
    echo "接続失敗" . $e->getMessage() . "\n";
    exit();
  };

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTデータが取得できるか確認

  print_r($_POST);

  $id = $_POST["id"] ?? null;

  $sql = "UPDATE customers SET deleted_at = NOW() WHERE customers_id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $result = $stmt->execute();
  
  // 削除が成功したら検索画面へ
  if ($result) {
      header("Location: ../search.php");
      exit();
  } else {
      echo "データの削除に失敗しました。";
  };
} else {
  echo "POSTメソッドで送信されていません。";
}
  ?>
