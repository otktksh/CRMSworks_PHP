<?php
  require_once dirname(__FILE__) . '/../model/CustomerHandler.php';

  $delete = new CustomerHandler();

  $id = $_POST['id'];
  
  $result = $delete->delete($id);

  if ($result) {
      header("Location: ../search.php");
      exit();
  } else {
      echo "データの削除に失敗しました。";
  };
  ?>
