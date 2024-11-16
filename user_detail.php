<?php
session_start();
$id = $_GET["id"]; //?id~**を受け取る
include("funcs.php");
//ログインのチェック＝セッションチェック
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_user_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
    sql_error($stmt);
}else{
  $values = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">アカウント一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<?php if( !empty($success_message) ): ?>
    <!-- <p class="success_message">--<?php /*echo $success_message; */?> </p> -->
    <p class="success_message" style="color:green; font-weight: bold;"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form method="POST" action="user_update.php" >
  <div class="jumbotron">
   <fieldset>
   <legend>アカウント更新</legend>
     <label>名前：<input type="text" name="name"></label><br>
     <label>Login ID：<input type="text" name="lid"></label><br>
     <label>Login PW<input type="text" name="lpw"></label><br>
     <label>管理FLG：
      一般<input type="radio" name="kanri_flg" value="0">
      管理者<input type="radio" name="kanri_flg" value="1">
    </label>
    <br>
    <input type="hidden" name="id" value="<?=h($values["id"])?>">
     <!-- <label>退会FLG：<input type="text" name="life_flg"></label><br> -->
     <input type="submit" value="送信">
     
    </fieldset>
  </div>
</form>
<!-- Main[End] -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/jquery-2.1.3.min.js"></script>
<script>
 $(function(){
    $(".form").on("click", function(){
        if(window.confirm('入力内容を確認して問題なければOKを押してください')) {
            return true;
        } else {
            return false;
        }
    });
});


