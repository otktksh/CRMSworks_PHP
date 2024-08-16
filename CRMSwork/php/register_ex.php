<?php
  require_once dirname(__FILE__) . '/../model/CustomerHandler.php';

  $insert = new CustomerHandler();
  //俺の考えた最強の整頓術
  $a = [
    $_POST['name'],
    $_POST['name_kana'],
    $_POST['mail'],
    $_POST['tel'],
    ($_POST['gender'] === '0') ? 0 : 1,
    $_POST['calendar'],
    $_POST['company']
  ];

  // $name = $_POST['name'];
  // $nameKana = $_POST['name_kana'];
  // $mail = $_POST['mail'];
  // $tel = $_POST['tel'];
  // $gender = ($_POST['gender'] === '0') ? 0 : 1;
  // $birthDate = $_POST['calendar'];
  // $company = $_POST['company'];

  // $sql = "INSERT INTO customers (name, name_kana, mail, tel, gender, birth_date, company_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
  // $stmt = $pdo->prepare($sql);
  // $result = $stmt->execute($a);
  
  $results = $insert->insert($a);

  if ($results) {
      header("Location: ../search.php");
      exit();
  } else {
      echo "データの登録に失敗しました。";
  }
  ?>
