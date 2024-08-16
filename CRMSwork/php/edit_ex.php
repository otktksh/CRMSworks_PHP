<?php
  const DB_HOST = "mysql:dbname=crms_db;host=localhost;charset=utf8";
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

  $name = $_POST["name"];
  $nameKana = $_POST["name_kana"];
  $mail = $_POST["mail"];
  $tel = $_POST["tel"];
  $gender = $_POST["gender"];
  $birthDate = $_POST["calendar"];
  $company = $_POST["company"];
  //例外のnull定義は正直いらんかも
  $id = $_POST["id"] ?? null;



  $sql = "UPDATE customers 
          SET company_id = :company, 
              name = :name, 
              name_kana = :nameKana,
              tel = :tel,
              mail = :mail,
              gender = :gender,
              birth_date = :birthDate,
              update_at = NOW()
          WHERE customers_id = :id";

  
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":company", $company, PDO::PARAM_INT);
  $stmt->bindParam(":name", $name, PDO::PARAM_STR);
  $stmt->bindParam(":nameKana", $nameKana, PDO::PARAM_STR);
  $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
  $stmt->bindParam(":tel", $tel, PDO::PARAM_STR);
  $stmt->bindParam(":gender", $gender, PDO::PARAM_INT);
  $stmt->bindParam(":birthDate", $birthDate, PDO::PARAM_STR);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);

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