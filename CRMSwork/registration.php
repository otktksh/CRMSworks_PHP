<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>顧客管理システム-登録</title>
  <link href=".\css\reset.css" rel="stylesheet" type="text/css"/>
  <link href=".\css\style.css" rel="stylesheet" type="text/css"/>
  <meta name="description" content="【課題用】顧客管理システム 登録ページ">
</head>
<body>
  <?php
  require_once dirname(__FILE__) . '/model/CompanyHandler.php';

  $cv = new CompanyHandler();
  $companies = $cv->getCompany();
  ?>
  <div class="main-wrapper">
<!-- ヘッダー -->
    <header class="main-header">
      <div class="logo">
        <h1><a href="./top.php">顧客管理システム</a></h1>
      </div>
      <nav>
        <ul class="header_menu">
          <li><a href="./top.php">トップ</a></li>
          <li><a href="./search.php">検索</a></li>
          <li class="header_menu-child"><a href="./registration.php">登録</a></li>
        </ul>
      </nav>
    </header>
<!-- ヘッダー -->
<!-- メインコンテンツ -->
    <main class="main-content">
      <div class="content-registration">
        <div class="content-header">
          <h2>顧客登録</h2>
        </div>
        <form id="registration-form" action="./php/register_ex.php" method="post">
          <div class="registration-form__label">
            <h3>顧客名</h3>
            <div class="form__box">
              <input type="text" id="name" name="name" autocomplete="off" placeholder="3文字以上入力してください">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-name"></div>
          </div>
          <div class="registration-form__label">
            <h3>顧客名カナ</h3>
            <div class="form__box">
              <input type="text" id="name-kana" name="name_kana" autocomplete="off" placeholder="3文字以上入力してください">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-name-kana"></div>
          </div>
          <div class="registration-form__label">
            <h3>メールアドレス</h3>
            <div class="form__box">
              <input type="text" id="mail" name="mail" autocomplete="off" placeholder="xxx@xxx.xxx形式で入力してください">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-mail"></div>
          </div>
          <div class="registration-form__label">
            <h3>電話番号</h3>
            <div class="form__box">
              <input type="tel" id="tel" name="tel" autocomplete="off" placeholder="(-)ハイフン不要">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-tel"></div>
          </div>
          <div class="registration-form__label">
            <h3>性別</h3>
            <div class="form__box-gender" id="gender-box">
              <input type="radio" id="genderChoice1" name="gender" value="0">
              <label for="genderChoice1">男性</label>
              <input type="radio" id="genderChoice2" name="gender" value="1">
              <label for="genderChoice2">女性</label>
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-gender"></div>
          </div>
          <div class="registration-form__label">
            <h3>生年月日</h3>
            <div class="form__box-birth_date">
              <input type="date" id="calendar" name="calendar" max="9999-12-31" autocomplete="off">
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-date"></div>
          </div>
          <div class="registration-form__label">
            <h3>所属会社</h3>
            <div class="form__box">
              <select name="company" id="company-select" class="company-select-box">
                <option value="" disabled selected></option>
                  <?php foreach ($companies as $company): ?>
                    <option value="<?= $company["company_id"]; ?>"><?= $company["company"]; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="error-box">
            <div class="error-message" id="error-message-company"></div>
          </div>
          <div class="registration-form__submit">
            <input type="submit" id="submit" value='☟登録' >
          </div>
        </form>
      </div>
    </main>
<!-- メインコンテンツ -->
  </div>
  <script src="./js/app.js"></script>
</body>
</html>