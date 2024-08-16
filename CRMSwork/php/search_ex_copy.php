<?php
  session_start();
  
  require_once dirname(__FILE__) . '/../model/CustomerHandler.php';
  $search = new CustomerHandler();

  $_SESSION['search_data'] = $_GET;

  $results = $search->search($_GET);

  if (empty($results)) {
    $_SESSION['search_message'] = "データが見つかりませんでした。";
    $results = $search->search();
  } else {
    $_SESSION['search_message'] = "";
  }

  $_SESSION['search_results'] = $results;

  header("Location: ../search.php");

?>