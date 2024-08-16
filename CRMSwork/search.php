<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>顧客管理システム-検索</title>
  <link href=".\css\reset.css" rel="stylesheet" type="text/css"/>
  <link href=".\css\style.css" rel="stylesheet" type="text/css"/>
  <meta name="description" content="【課題用】顧客管理システム 検索ページ">
</head>
<body>
<?php
  session_start();

  require_once dirname(__FILE__) . '/model/CustomerHandler.php';
  require_once dirname(__FILE__) . '/model/CompanyHandler.php';
  $search = new CustomerHandler();
  $cv = new CompanyHandler();

  $customers = isset($_SESSION['search_results']) ? $_SESSION['search_results'] : [];
  $getE = isset($_SESSION['search_data']) ? $_SESSION['search_data'] : [];

  $companies = $cv->getCompany();

  if (empty($customers)) {
  $customers = $search->search();
  }

  $companyMap = [];
  foreach ($companies as $company) {
    $companyMap[$company["company_id"]] = $company["company"];
  }

  $message = isset($_SESSION['search_message']) ? $_SESSION['search_message'] : '';
  unset($_SESSION['search_message']);
  unset($_SESSION['search_data']);
  unset($_SESSION['search_results']);
  ?>

  <div class="main-wrapper">

    <header class="main-header">
      <div class="logo">
        <h1><a href="./top.php">顧客管理システム</a></h1>
      </div>
      <nav>
        <ul class="header_menu">
          <li><a href="./top.php">トップ</a></li>
          <li class="header_menu-child"><a href="./search.php">検索</a></li>
          <li><a href="./registration.php">登録</a></li>
        </ul>
      </nav>
    </header>

    <main class="main-content">
      <div class="content-search">
        <div class="content-header">
          <h2>検索条件</h2>
        </div>
        <form id="search-form" action="./php/search_ex_copy.php" method="get">
          <div class="search-form__label">
            <h3>顧客名</h3>
            <div class="form__box">
              <input type="text" id="name" name="name" value="<?= isset($getE['name']) ? htmlspecialchars($getE['name']) : ''; ?>" placeholder="※部分一致可" autocomplete="off">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-name"></div>
          </div>
          <div class="search-form__label">
            <h3>顧客名カナ</h3>
            <div class="form__box">
              <input type="text" id="name-kana" name="name_kana" value="<?= isset($getE['name_kana']) ? htmlspecialchars($getE['name_kana']) : ''; ?>" placeholder="※部分一致可" autocomplete="off">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-name-kana"></div>
          </div>
          <div class="search-form__label">
            <h3>性別</h3>
            <div class="form__box-gender">
              <input type="radio" id="genderChoice1" name="gender" value="0"
              <?= isset($getE['gender']) && $getE['gender'] == 0 ? 'checked' : ''; ?> > 
              <label for="genderChoice1">男性</label>
              <input type="radio" id="genderChoice2" name="gender" value="1"
              <?= isset($getE['gender']) && $getE['gender'] == 1 ? 'checked' : ''; ?> > 
              <label for="genderChoice2">女性</label>
              <input type="radio" id="genderChoice2" name="gender" value="2"
              <?= !isset($getE['gender']) || $getE['gender'] == 2 ? 'checked' : ''; ?> > 
              <label for="genderChoice3">全て</label>
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-gender"></div>
          </div>
          <div class="search-form__label">
            <h3>生年月日</h3>
            <div class="form__box-birth_date">
              <input type="date" id="calendar-start" name="calendar_start" max="9999-12-31" value="<?= isset($getE['calendar_start']) ? htmlspecialchars($getE['calendar_start']) : ''; ?>" >
              <p>～</p>
              <input type="date" id="calendar-end" name="calendar_end" max="9999-12-31" value="<?= isset($getE['calendar_end']) ? htmlspecialchars($getE['calendar_end']) : ''; ?>">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-date"></div>
          </div>
          <div class="search-form__label">
            <h3>所属会社</h3>
            <div class="form__box">
              <select name="company" id="company-select" class="company-select-box">
              <option value="">全て</option>
              <?php foreach ($companies as $company): ?>
                <option value="<?= htmlspecialchars($company["company_id"]); ?>"
                <?= isset($getE["company"]) && $getE["company"] == $company["company_id"] ? 'selected' : ""; ?>>
                <?= htmlspecialchars($company["company"]); ?>
                </option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-company"></div>
          </div>
          <div class="search-form__submit">
            <input type="submit" id="submit" value='🔍検索'>
          </div>
        </form>
      </div>
      <div class="content-list">
        <div class="content-list-box">
          <div class="list-header">
            <h2>検索結果一覧</h2>
          </div>
          <?php if (!empty($message)): ?>
            <p class="not-results" style='margin-left: auto; margin-right: auto; margin-top: 10px; color: red;'><?= htmlspecialchars($message); ?></p>
          <?php endif; ?>
          <div class="table-box">
            <div class="list-table-header">
              <table>
                <tr>
                  <th class="table-id">顧客ID</th>
                  <th class="table-name">顧客名<br>カナ</th>
                  <th class="table-mail_tel">メールアドレス<br>電話番号</th>
                  <th class="table-company">所属会社</th>
                  <th class="table-new_last">新規登録日時<br>最終更新日時</th>
                  <th class="table-edit-header">編集</th>
                  <th class="table-delete-header">削除</th>
                </tr>
              </table>
            </div>
            <table class="list-table">
              <?php foreach ($customers as $customer): ?>
              <tr class="list-table-child1">
                <td class="table-id"><?= htmlspecialchars($customer["customers_id"]); ?></td>
                <td class="table-name"><?= htmlspecialchars($customer["name"]); ?><br><?= htmlspecialchars($customer["name_kana"]); ?></td>
                <td class="table-mail_tel"><?= htmlspecialchars($customer["mail"]); ?><br><?= htmlspecialchars($customer["tel"]); ?></td>
                <td class="table-company"><?= htmlspecialchars($companyMap[$customer["company_id"]] ?? "不明"); ?></td>
                <td class="table-new_last"><?= htmlspecialchars(date("Y-m-d H:i", strtotime($customer["insert_at"]))); ?><br><?= htmlspecialchars(date("Y-m-d H:i", strtotime($customer["update_at"]))); ?></td>
                <td class="table-edit">
                  <form action="./edit.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($customer["customers_id"]); ?>">
                    <a href="#" onclick="this.parentNode.submit();">編集</a>
                  </form>
                </td>
                <td class="table-delete"> 
                  <form action="./delete.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($customer["customers_id"]); ?>">
                    <a href="#" onclick="this.parentNode.submit();">削除</a>
                  </form>
                </td>
                <!-- 8/6 17:50 編集、削除ボタンに対してidを紐づけて、遷移先のファイルでSELECTで表示とUPDATEを行えばいい -->
              </tr>
              <?php endforeach; ?>
            </table>

          </div>
        </div>
      </div>
    </main>

  </div>
  <script src="./js/app2.js"></script>

</body>
</html>