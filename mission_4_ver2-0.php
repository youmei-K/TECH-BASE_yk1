<?php
//接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//入力
if( (!empty($_POST["name"])&&($_POST["comment"])&&($_POST["password1"])) && (empty($_POST["edit"])) ) {
	$sql = $pdo -> prepare("INSERT INTO G2B1 (name, comment, password) VALUES (:name, :comment, :pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass1, PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$pass1 = $_POST["password1"];
	$sql -> execute();
}

//編集選択
if(!empty($_POST["password2"])) {
	$pass2 = $_POST["password2"];
	$sql = 'SELECT * FROM G2B1';
	$results = $pdo -> query($sql);
	foreach ($results as $row) {
		$id = $row['password'];
		if( ($id == $pass2) && (!empty($_POST["editing"])) ) {
			$editing=$_POST["editing"];
			foreach ($results as $row) {
				$no = $row['id'];
				if($no == $editing) {
					$ID = $row['id'];
					$NAME = $row['name'];
					$COMMENT = $row['comment'];
				}
			}
		}
	}
}

//編集実行
if(!empty($_POST["edit"])) {
	$edit = $_POST["edit"];
	$sql = 'SELECT * FROM G2B1';
	$results = $pdo -> query($sql);
	foreach ($results as $row) {
		$NO = $row['id'];
		if($NO == $edit) {
			$nm=$_POST["name"];
			$kome=$_POST["comment"];
			$sql = "update G2B1 set name='$nm' , comment='$kome' where id = $NO";
			$result = $pdo->query($sql);
		}
	}
}

//削除
if(!empty($_POST["password3"])) {
	$pass3 = $_POST["password3"];
	$sql = 'SELECT * FROM G2B1';
	$results = $pdo -> query($sql);
	foreach ($results as $row) {
		$id = $row['password'];
		if( ($id == $pass3) && (!empty($_POST["delete"])) ) {
			$delete = $_POST["delete"];
			foreach ($results as $row) {
				$no = $row['id'];
				if($no == $delete) {
					$sql = "delete from G2B1 where id=$no";
					$result = $pdo->query($sql);
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
 <meta charset="UTF-8" />
 <title>掲示板</title>
</head>
<body>
 <h2 style="color: #d04255;padding: 10px 10px 10px 60px;position: relative;">Flower 〜掲示板〜</h2>
 <form method="POST" action=" ">
 <p>
<!--投稿-->
  <input type="text" name="name" placeholder="名前" value="<?php echo $NAME ?>"> <br />
  <input type="text" name="comment" placeholder="コメント" value="<?php echo $COMMENT ?>">

<!--編集実行-->
  <input type="hidden" name="edit" value="<?php  echo $ID ?>"> <br />
  
<!--パスワード欄-->
  <input type="text" name="password1" placeholder="パスワード">
  <input type="submit" value="投稿"> <br />
  <br />
  
<!--編集選択-->
  <input type="text" name="editing" placeholder="編集対象番号"> <br />
  <input type="text" name="password2" placeholder="パスワード">
  <input type="submit" value="編集"> <br />
  <br />
  
  <!--削除-->
  <input type="text" name="delete" placeholder="削除対象番号"> <br />
  <input type="text" name="password3" placeholder="パスワード">
  <input type="submit" value="削除"> <br />
 </p>
</form>
</body>
</html>

<?php
$sql = 'SELECT * FROM G2B1 ORDER BY id ASC';
$results = $pdo -> query($sql);
foreach ($results as $row) {
	echo '<br>';
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].'<br>';
}
?>