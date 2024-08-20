<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>顧客管理システム-顧客情報詳細</title>
  <link href=".\css\reset.css" rel="stylesheet" type="text/css"/>
  <link href=".\css\style.css" rel="stylesheet" type="text/css"/>
  <meta name="description" content="【課題用】顧客管理システム 編集ページ">
</head>
<body>
<?php
  require_once dirname(__FILE__) . '/model/CustomerHandler.php';
  require_once dirname(__FILE__) . '/model/CompanyHandler.php';

  use \Model\CustomerHandler;
  use \Model\CompanyHandler;

  $editController = new CustomerHandler();
  $cv = new CompanyHandler();

  $id = $_POST['id'];

  if (isset($_POST[("submit_edit")])) {

    $a = [
      $_POST["name"],
      $_POST["name_kana"],
      $_POST["mail"],
      $_POST["tel"],
      $_POST["gender"],
      $_POST["calendar"],
      $_POST["company"],
    ];

    $result = $editController->edit($a, $id);

    if ($result) {
      header("Location: ./search.php");
      exit();
    } else {
      $message = "データの編集に失敗しました。";
    }
  }

  $companies = $cv->getCompany();
  $customer = $editController->findById($id)[0];
  //配列が多重になってインデックス0に全て格納されてるから、0自体を代入しなおす
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
      <div class="content-edit">
        <div class="content-header">
          <h2>顧客編集</h2>
        </div>
        <?php if (!empty($message)): ?>
          <p class="not-results" style="text-align: center; margin-top: 10px; margin-bottom: 15px; color: red;"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="./edit.php" onsubmit="confirm_edit()" method="post">
          <div class="edit-form__label">
            <h3>顧客名</h3>
            <div class="form__box">
              <input type="text" name="name" autocomplete="off" value="<?= htmlspecialchars($customer["name"]); ?>">
            </div>
          </div>
          <div class="edit-form__label">
            <h3>顧客名カナ</h3>
            <div class="form__box">
              <input type="text" name="name_kana" autocomplete="off" value="<?= htmlspecialchars($customer["name_kana"]); ?>">
            </div>
          </div>
          <div class="edit-form__label">
            <h3>メールアドレス</h3>
            <div class="form__box">
              <input type="text" name="mail" autocomplete="off" value="<?= htmlspecialchars($customer["mail"]); ?>">
            </div>
          </div>
          <div class="edit-form__label">
            <h3>電話番号</h3>
            <div class="form__box">
              <input type="text" name="tel" autocomplete="off" value="<?= htmlspecialchars($customer["tel"]); ?>">
            </div>
          </div>
          <div class="edit-form__label">
            <h3>性別</h3>
            <div class="form__box-gender">
                <input type="radio" id="contactChoice1" name="gender" value="0" 
                <?php if ($customer["gender"] === 0) echo 'checked'; ?>>
                <label for="genderChoice1">男性</label>
                <input type="radio" id="contactChoice2" name="gender" value="1" 
                <?php if ($customer["gender"] === 1) echo 'checked'; ?>>
                <label for="genderChoice2">女性</label>
            </div>
          </div>
          <div class="edit-form__label">
            <h3>生年月日</h3>
            <div class="form__box-birth_date">
              <input type="date" name="calendar" max="9999-12-31" value="<?= htmlspecialchars($customer["birth_date"]); ?>">
            </div>
          </div>
          <div class="edit-form__label">
            <h3>所属会社</h3>
            <div class="form__box">
              <select name="company" id="companyselect" class="company-select-box" value="">
              <?php foreach ($companies as $company): ?>
                <option value="<?= htmlspecialchars($company["company_id"]); ?>"
                <?= $company["company_id"] == $customer["company_id"] ? 'selected' : ""; ?>>
                <?= htmlspecialchars($company["company"]); ?>
                </option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="edit-form__submit">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id); ?>">
            <input type="submit" name="submit_edit" value='🖊編集'>
          </div>
        </form>
      </div>
      
    </main>

  </div>
  <script src="./js/edit_confirm.js"></script>
</body>
</html>