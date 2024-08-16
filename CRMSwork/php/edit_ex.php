<?php
  require_once dirname(__FILE__) . '/../model/CustomerHandler.php';

  $edit = new CustomerHandler();

  $a = [
  $_POST["name"],
  $_POST["name_kana"],
  $_POST["mail"],
  $_POST["tel"],
  $_POST["gender"],
  $_POST["calendar"],
  $_POST["company"],
  $_POST["id"]
  ];

  $result = $edit->edit($a);
  
  // 削除が成功したら検索画面へ
  if ($result) {
      header("Location: ../search.php");
      exit();
  } else {
      echo "データの削除に失敗しました。";
  };
?>