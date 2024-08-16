//input動作で入力を逐一チェック。
document.getElementById("registration-form").addEventListener("input", function(event) {
  validateForm(false);  //ValidateForm関数で定義したcheckEmptyのブール値がfalseになって関数内の
                        //checkEmptyのif文はfalseの条件を設定していないから空白バリデーションは行われない
});

//submitボタンを押した際の処理
document.getElementById("registration-form").addEventListener("submit", function(event) {
  const errorFlag = validateForm(true); //このsubmitイベントでsubmitした際にvalidateForm関数の引数をtrueにした
                                      //空白バリ用if文も含めた処理がされる。そして関数内の最後にerrorFlagの
                                      //ブール値がreturnされて、それがここのerrorFlag変数に格納される。
  if (errorFlag) {
    event.preventDefault(); //上のreturnでerrorFlagにtrueが格納されていたら、この処理でフォームの挙動は行わない
  }                         //もしfalseだったら何も処理を書かれてないのでhtmlに書いてあるactionが行われる                          

});

//電話番号のボックスには数字だけしか入力できない処理
document.getElementById("tel").addEventListener("input", function(event) {

  //id"tel"に対してエリアにinput(入力)されたvalue(テキスト)をターゲットにして、それを変数に入れる
  const currentInput = event.target.value;
  //入力内容を取得しているcurrentInput変数に対してreplaceを使って0-9以外の文字が入ったら空白に置換してる
                                           //↓ ^で以外 gで文字列全体に対して ,カンマで区切って第二引数に""空白
  const filteredInput = currentInput.replace(/[^0-9]/g, "");

  if (currentInput !== filteredInput) {
    event.target.value = filteredInput;
  }
})

                    //↓これはブール値だけど変数ではない、ただ上のtrueとfalseを受け取る箱。引数
function validateForm(checkEmpty) {
  const inputName = document.getElementById("name").value;
  const nameKana = document.getElementById("name-kana").value;
  const mail = document.getElementById("mail").value;
  const tel = document.getElementById("tel").value;
  const gender = document.getElementsByName("gender");
  const calendar = document.getElementById("calendar").value;
  const company = document.getElementById("company-select").value;

  const errorMessageName = document.getElementById("error-message-name");
  const errorMessageNameKana = document.getElementById("error-message-name-kana");
  const errorMessageMail = document.getElementById("error-message-mail");
  const errorMessageTel = document.getElementById("error-message-tel");
  const errorMessageGen = document.getElementById("error-message-gender");
  const errorMessageDate = document.getElementById("error-message-date");
  const errorMessageCom = document.getElementById("error-message-company");

  errorMessageName.innerHTML = "";
  errorMessageNameKana.innerHTML = "";
  errorMessageMail.innerHTML = "";
  errorMessageTel.innerHTML = "";
  errorMessageGen.innerHTML = "";
  errorMessageDate.innerHTML = "";
  errorMessageCom.innerHTML = "";

  let errorFlag = false;

  //checkEmptyがtrueの時はこのif文のバリデーションが行われる
  //falseだったらこの空白用のバリデーションは無視されて下の入力内容のバリデーションが行われる
  if (checkEmpty) {
    if (inputName === "") {
      errorMessageName.innerHTML += "<p>※名前を入力してください</p>";
      errorFlag = true;
    }

    if (nameKana === "") {
      errorMessageNameKana.innerHTML += "<p>※カナ名を入力してください</p>";
      errorFlag = true;
    }

    if (mail === "") {
      errorMessageMail.innerHTML += "<p>※メールアドレスを入力してください</p>";
      errorFlag = true;
    }

    if (tel === "") {
      errorMessageTel.innerHTML += "<p>※電話番号を入力してください</p>";
      errorFlag = true;
    }

    let genderSelected = false;
    gender.forEach(choiceEl => {
      if (choiceEl.checked) {
        genderSelected = true;
      }
    });

    if (!genderSelected) {
      errorMessageGen.innerHTML += "<p>※性別を選択してください</p>";
      errorFlag = true;
    }

    if (calendar === "") {
      errorMessageDate.innerHTML += "<p>※生年月日を入力してください</p>";
      errorFlag = true;
    }

    if (company === "") {
      errorMessageCom.innerHTML += "<p>※所属会社を選択してください</p>";
      errorFlag = true;
    }
  }
      //空白ではない。アンド カタカナ ァ～ヶ～にマッチしない場合はエラー
  if (nameKana !== "" && !nameKana.match(/^[ァ-ヶー]+$/)) {
    errorMessageNameKana.innerHTML += "<p>※全角カタカナで入力してください</p>";
    errorFlag = true;
  }

  if (inputName.length > 0 && inputName.length < 3) {
    errorMessageName.innerHTML += "<p>※名前は3文字以上入力してください</p>";
    errorFlag = true;
  }

  if (nameKana.length > 0 && nameKana.length < 3) {
    errorMessageNameKana.innerHTML += "<p>※カナ名は3文字以上入力してください</p>";
    errorFlag = true;
  }

  if (mail.length > 0 && !mail.match(/.*@.*\..*/)) {
    errorMessageMail.innerHTML += "<p>※xxx@xxx.xxx形式で入力してください</p>";
    errorFlag = true;
  }
      //ハイフンのifを下にしたら10桁以上11桁以下の条件下でしか発動しなかったから上に置いたら発動した
  if (tel.match(/.*\-\.*/)) {
    errorMessageTel.innerHTML += "<p>※電話番号にハイフンを使用しないでください</p>";
    errorFlag = true;
  } else if (tel.length > 0 && tel.length < 10 || tel.length > 11) {
    errorMessageTel.innerHTML += "<p>※電話番号は10桁以上、11桁以下で入力してください</p>";
    errorFlag = true;
  }

  // ボタンの無効化/有効化
  const button = document.getElementById("submit");
  button.disabled = errorFlag;

  return errorFlag;
}