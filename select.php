<?php
session_start();

include("funcs.php");

//ログインのチェック＝セッションチェック
 sschk();

//1.  DB接続します
$pdo = db_conn();


//２．データ登録SQL作成
$sql = "SELECT * FROM gs_bm_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();  //ture or false

//３．データ表示
//$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  sql_error($stmt);
  // $error = $stmt->errorInfo();
  // exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BOOK登録表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
div{padding: 10px;font-size:16px;}
td{border: 1px solid black}
</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <?= $_SESSION["name"]?>さん、ようこそ！
      <a class="navbar-brand" href="index.php">データ登録</a>
      <a class="navbar-brand" href="user.php">アカウント登録</a>
      <a class="navbar-brand" href="user_select.php">アカウント一覧</a>
      <a class="navbar-brand" href="logout.php">ログアウト</a>
  
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
     <table>
     <?php foreach($values as $values){ ?>   <!--$valuesのなかのIDを取り出して、記載します。これをデータが終わるまでループで実行します-->
      <tr>
       <td><?=h($values["id"])?></td>
       <td><?=h($values["bookname"])?></td>
       <td><?=h($values["bookurl"])?></td>
       <td><?=h($values["bookcomment"])?></td>
       <td><?=h($values["indate"])?></td>
       <?php if($_SESSION["kanri_flg"]=="1"){?>
        <td><a href="detail.php?id=<?=h($values["id"])?>">更新</a></td>
        <td><a href="delete.php?id=<?=h($values["id"])?>">削除</a></td>
       <?php }?>
      </tr>
     <?php } ?>
     </table>
    </div>
</div>
<!-- Main[End] -->


<script>
//JSON受け取り
 $a = '<?=$json?>';
 const obj = JSON.parse($a);
 console.log(obj);


</script>
</body>
</html>
