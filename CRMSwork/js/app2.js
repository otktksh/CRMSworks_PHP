//input動作で入力を逐一チェック。
document.getElementById("search-form").addEventListener("input", function(event) {
  validateForm();  //ValidateForm関数で定義したcheckEmptyのブール値がfalseになって関数内の
                        //checkEmptyのif文はfalseの条件を設定していないから空白バリデーションは行われない
});

document.getElementById("search-form").addEventListener("submit", function(event) {
  const errorFlag = validateForm(); //このsubmitイベントでsubmitした際にvalidateForm関数の引数をtrueにした
                                      //空白バリ用if文も含めた処理がされる。そして関数内の最後にerrorFlagの
                                      //ブール値がreturnされて、それがここのerrorFlag変数に格納される。
  if (errorFlag) {
    event.preventDefault(); //上のreturnでerrorFlagにtrueが格納されていたら、この処理でフォームの挙動は行わない
  }                         //もしfalseだったら何も処理を書かれてないのでhtmlに書いてあるactionが行われる                          

});

function validateForm() {
  const nameKana = document.getElementById("name-kana").value;
  const errorMessageNameKana = document.getElementById("error-message-name-kana");

  errorMessageNameKana.innerHTML = "";

  let errorFlag = false;

  if (nameKana !== "" && !nameKana.match(/^[ァ-ヶー]+$/)) {
    errorMessageNameKana.innerHTML += "<p>※全角カタカナで入力してください</p>";
    errorFlag = true;
  }

  //↑までの処理でerrorFlagがtrueだとhtmlのsubmitボタンがdisabledされる
  const button = document.getElementById("submit");
  button.disabled = errorFlag;

  //関数を呼び出した奴にerrorFlagのブール値を投げる、このプログラムだとsubmit時DOM操作のerrorFlag変数
  return errorFlag;
}
