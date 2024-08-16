<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>顧客管理システム-顧客情報削除</title>
  <link href=".\css\reset.css" rel="stylesheet" type="text/css"/>
  <link href=".\css\style.css" rel="stylesheet" type="text/css"/>
  <meta name="description" content="【課題用】顧客管理システム 削除ページ">
</head>
<body>
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

  $sql = "SELECT company_id, company FROM companies";
  $stmt = $pdo->query($sql);
  $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $id = $_POST["id"] ?? null;

  $sql = "SELECT * FROM customers WHERE customers_id = '$id' AND deleted_at IS NULL ";
  $stmt = $pdo->query($sql);
  $customer = $stmt->fetch(PDO::FETCH_ASSOC);
?>
  <div class="main-wrapper">

    <header class="main-header">
      <div class="logo">
        <h1><a href="./top.php">顧客管理システム</a></h1>
      </div>
      <nav>
        <ul class="header_menu">
          <li><a href="./top.php">トップ</a></li>
          <li><a href="./search.php">検索</a></li>
          <li><a href="./registration.php">登録</a></li>
        </ul>
      </nav>
    </header>

    <main class="main-content">
      <div class="content-delete">
        <div class="content-header">
          <h2>顧客削除</h2>
        </div>

        <form action="./php/delete_ex.php" onsubmit="confirm_delete()" method="post">
          <div class="delete-form__label">
            <h3>顧客名</h3>
            <div class="form__box">
              <input type="text" name="name" value="<?= htmlspecialchars($customer["name"]); ?>" readonly>
            </div>
          </div>
          <div class="delete-form__label">
            <h3>顧客名カナ</h3>
            <div class="form__box">
              <input type="text" name="name_kana" value="<?= htmlspecialchars($customer["name_kana"]); ?>" readonly>
            </div>
          </div>
          <div class="delete-form__label">
            <h3>メールアドレス</h3>
            <div class="form__box">
              <input type="text" name="mail" value="<?= htmlspecialchars($customer["mail"]); ?>" readonly>
            </div>
          </div>
          <div class="delete-form__label">
            <h3>電話番号</h3>
            <div class="form__box">
              <input type="text" name="tel" value="<?= htmlspecialchars($customer["tel"]); ?>" readonly>
            </div>
          </div>
          <div class="delete-form__label">
            <h3>性別</h3>
            <div class="form__box-gender">
                <input type="radio" id="genderChoice1" name="gender" value="0" 
                <?php if ($customer["gender"] === 0) echo 'checked'; ?>>
                <label for="genderChoice1">男性</label>
                <input type="radio" id="genderChoice2" name="gender" value="1" 
                <?php if ($customer["gender"] === 1) echo 'checked'; ?>>
                <label for="genderChoice2">女性</label>
            </div>
          </div>
          <div class="delete-form__label">
            <h3>生年月日</h3>
            <div class="form__box-birth_date">
              <input type="date" name="calendar" max="9999-12-31" value="<?= htmlspecialchars($customer["birth_date"]); ?>" readonly>
            </div>
          </div>
          <div class="delete-form__label">
            <h3>所属会社</h3>
            <div class="form__box">
            <select name="company" id="companyselect" class="company-select-box" value="" disabled>
              <?php foreach ($companies as $company): ?>
                <option value="<?= htmlspecialchars($company["company_id"]); ?>"
                <?= $company["company_id"] == $customer["company_id"] ? 'selected' : ""; ?>>
                <?= htmlspecialchars($company["company"]); ?>
                </option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="delete-form__submit">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">
            <input type="submit" value='✖削除'>
          </div>
        </form>
      </div>
    </main>

  </div>
  <script src="./js/delete_confirm.js"></script>
</body>
</html>