<?php
// セッションを開始する
session_start();

//1. POSTデータ取得
$bookname   = $_POST["bookname"];
$bookurl    = $_POST["bookurl"];
$bookcommet = $_POST["bookcomment"];



//2. DB接続します  以下はデータベースのデータを取ってくる関数→関数化
// function db_conn(){
//   try {
//     $db_name = "kadai08_db"   //データベース名
//     $db_id   = "root";        //アカウント名
//     $db_pw   = "";            //パスワード：XAMPPはパスワード無しに修正してください。
//     $db_host = "localhost";   //DBホスト
//     //Password:MAMP='root',XAMPP=''
//     return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host,$db_id,$db_pw); //rootはxamppのID名、パスワードはなし。　サクラサーバーなら自分のID名、パスワードとなる
  
//   } catch (PDOException $e) {
//     exit('DB_CONECT:'.$e->getMessage()); //exitは処理を止める
//   }
// }
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO gs_bm_table(bookname,bookurl,bookcomment,indate)VALUES(:bookname,:bookurl,:bookcomment,sysdate());";
$stmt = $pdo->prepare($sql);   //SQLをセットする関数
$stmt->bindValue(':bookname',   $bookname,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT) 「->』は中のという意味 bindValuはクリーニングするという意味　STR：文字の形
$stmt->bindValue(':bookurl',  $bookurl , PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookcomment', $bookcommet, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();   //SQLの実行　ture or false

//$success_message = 'メッセージを書き込みました。';

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
//   function sql_error($stmt){
//     $error = $stmt->errorInfo();   //stmtのエラーを感知したら、エラーの配列をみる
//     exit("SQL_ERROR:".$error[2]);  //errorの二番名の配列を表記する
//  }  
 sql_error($stmt); //戻り値がないのでこれでOK　$stmtがデータ登録にてexecute();後のエラー内容をもつから
}else{
  // 成功メッセージをセッションに保存する
  $_SESSION['success_message'] = 'メッセージを書き込みました。';
  //５．index.phpへリダイレク
      // function redirect($file_name){
      // header("Location: index.php"); //Location: のあとは半角スペースをいれる
      // exit();

      // }
      redirect("index.php");  
}
?>
