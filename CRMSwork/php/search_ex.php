<?php
  session_start();
  
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

    $name = $_POST["name"];
    $nameKana = $_POST["name_kana"];
    $gender = $_POST["gender"];
    $calendarStart = $_POST["calendar_start"];
    $calendarEnd = $_POST["calendar_end"];
    $company = $_POST["company"];

    $conditions = [];
    $params = [];

    if (!empty($name)) {
      //↓WHERE句に追加する検索条件を格納するための配列
      $conditions[] = "name LIKE :name";
      //上で使用したプレースホルダーに入れるための値を格納する配列
      $params[':name'] = "%$name%";
    }

    if (!empty($nameKana)) {
      $conditions[] = "name_kana LIKE :name_kana";
      $params[':name_kana'] = "%$nameKana%";
    }

    if ($gender != "" && $gender != 2) {
      $conditions[] = "gender = :gender";
      $params[':gender'] = $gender;
    }

    if (!empty($calendarStart)) {
      $conditions[] = "birth_date >= :calendar_start";
      $params[':calendar_start'] = $calendarStart;
    }

    if (!empty($calendarEnd)) {
      $conditions[] = "birth_date <= :calendar_end";
      $params[':calendar_end'] = $calendarEnd;
    }

    if (!empty($company)) {
      $conditions[] = "company_id = :company";
      $params[':company'] = $company;
    }

    $sql = "SELECT * FROM customers";
    if (!empty($conditions)) {
      $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
      $_SESSION['search_message'] = "データが見つかりませんでした。";
    } else {
      $_SESSION['search_message'] = "";
    }

    $_SESSION['search_results'] = $results;

    header("Location: ../search.php");
    exit();

  } else {
    
    $sql = "SELECT * FROM customers WHERE deleted_at IS NULL ORDER BY customers_id ASC";
    $stmt = $pdo->query($sql);
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['search_results'] = $results;

    header("Location: ../search.php");
    exit();
  }
?>