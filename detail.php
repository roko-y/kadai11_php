<?php
session_start();
$id = $_GET["id"]; //?id~**を受け取る
include("funcs.php");
//ログインのチェック＝セッションチェック
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_bm_table WHERE id=:id";
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
  <title>book登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<?php if( !empty($success_message) ): ?>
    <!-- <p class="success_message">--<?php /*echo $success_message; */?> </p> -->
    <p class="success_message" style="color:green; font-weight: bold;"><?php echo htmlspecialchars($success_message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form method="POST" action="update.php" >
  <div class="jumbotron">
   <fieldset>
    <legend>BOOK更新</legend>
 
     <label>書籍名：<input type="text" name="bookname" value="<?=h($values["bookname"])?>"></label><br>
     <label>書籍URL：<input type="text" name="bookurl" value="<?=h($values["bookurl"])?>"></label><br>
     <label>書籍コメント：<textArea name="bookcomment" rows="4" cols="40"><?=h($values["bookcomment"])?></textArea></label><br>  <!--row='4'は4行で　cols="40" は40文字でという意味-->
     <input type="hidden" name="id" value="<?=h($values["id"])?>">
     <input type="submit" value="送信" class="form">
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


