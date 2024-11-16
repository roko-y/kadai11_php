<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続
function db_conn(){
  try {
    $db_name = "kadai08_db" ;  //データベース名
    $db_id   = "root";        //アカウント名
    $db_pw   = "";            //パスワード：XAMPPはパスワード無しに修正してください。
    $db_host = "localhost";   //DBホスト
    //Password:MAMP='root',XAMPP=''
    return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host,$db_id,$db_pw); //rootはxamppのID名、パスワードはなし。　サクラサーバーなら自分のID名、パスワードとなる
  } catch (PDOException $e) {
    exit('DB_CONECT:'.$e->getMessage()); //exitは処理を止める
  }
}


//SQLエラー
function sql_error($stmt){
  $error = $stmt->errorInfo();   //stmtのエラーを感知したら、エラーの配列をみる
  exit("SQL_ERROR:".$error[2]);  //errorの二番名の配列を表記する
}  


//リダイレクト
function redirect($file_name){
  header("Location: ".$file_name); //Location: のあとは半角スペースをいれる
  exit();

  }

//SessionCheck(スケルトン)
function sschk(){
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){   //!がついていると「～されていなければ」という意味になる
    exit("Login Error");
  }else{
   session_regenerate_id(true); //sessionキーを入れ替える関数
   $_SESSION["chk_ssid"] = session_id();    //新しいセッションキーに入れ替える
  }
}
