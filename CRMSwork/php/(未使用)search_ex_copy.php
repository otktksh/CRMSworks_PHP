<?php
  require_once dirname(__FILE__) . '/../model/CustomerHandler.php';
  $search = new CustomerHandler();

  $query = http_build_query($_GET);

  $results = $search->search($_GET);

  if (empty($results)) {
    $query .= '&error_message=データが見つかりませんでした。';
    $results = $search->search();
  }

  $query .= '$results=' . urlencode(json_encode($results));

  header("Location: ../search.php?$query");
  exit();
?>

