



<?php
  // ここにDBに登録する処理を記述する
	//データベースに接続し、SQLを実行し、切断する部分を記述しましょう。
	//insert文でデータを保存するところまで宿題。


	  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
	  $user = 'root'; 
	  $password=''; 
	  $dbh = new PDO($dsn, $user, $password);
	  $dbh->query('SET NAMES utf8');

	//POST送信されたらINSERT文を実行するためのif文が必要
	 if (!empty($_POST)) {
		  $nickname = htmlspecialchars($_POST['nickname']);
		  $comment = htmlspecialchars($_POST['comment']);

	// ２．SQL文を実行する
		  $sql = 'INSERT INTO `posts`(`nickname`, `comment`,`created`) VALUES ("'. $nickname.'", "'.$comment.'",now());'; //←ここ以外テンプレートで用意しとくと楽！。
		  //INSERT文を実行
		  $stmt = $dbh->prepare($sql); 
		  $stmt->execute();
	 }


  // ３．データベースを切断する
  $dbh = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p><br>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->
	<div>
	    <h3>あなたのつぶやき内容</h3>
	    <p>ニックネーム：<?php echo $nickname; ?></p>
	    <p>つぶやき内容：<?php echo $comment; ?></p>
	    <!-- <p>日付：<?php echo now; ?></p> -->

		<span id="view_time"></span>
		<script type="text/javascript">
		document.getElementById("view_time").innerHTML = getNow();

		function getNow() {
			var now = new Date();
			var year = now.getFullYear();
			var mon = now.getMonth()+1; //１を足すこと
			var day = now.getDate();
			var hour = now.getHours();
			var min = now.getMinutes();
			var sec = now.getSeconds();

			//出力用
			var s = year + "年" + mon + "月" + day + "日" + hour + "時" + min + "分" + sec + "秒"; 
			return s;
		}
		</script>
		<br><br>
	</div>



	 <?php
	  // １．データベースに接続する
	  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
	  $user = 'root';
	  $password = '';
	  $dbh = new PDO($dsn, $user, $password);
	 	// dbh : Database Handle
		// PDO : PHP Data Objects
		// dsn : Data Source Name
	  $dbh->query('SET NAMES utf8');

	  // POSTでデータが送信された時のみSQLを実行する
	  if (!empty($_POST)) {
		  // ２．SQL文を実行する
	  	$sql = 'SELECT * FROM `posts` ORDER BY id DESC'; //into型。
	  	// $data[] =  $_POST['code']; //何も指定してないと1番最後になる。[]が付かないと只の代入。[]がつくと配列(重箱)の下に順々に入っていく。
		  // SQLを実行
		$stmt = $dbh->prepare($sql);
		  // $stmt->execute();
		$stmt->execute(); //?に配列の0番目を入れる。


	    // データを取得する
	    while (1) {
	      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
	      if ($rec == false) {
	        break;
	      }
	      echo $rec['nickname'] . '<br>';
	      echo $rec['comment'] . '<br>';
	      echo $rec['created'] . '<br>';
	      echo '<hr>';
	    }//SQLｲﾝｼﾞｪｸｼｮﾝを防げていない。3 or 1で全件表示されるのはcode=3と、1(無条件。無限ループみたいなもの)ということになる。
  	  }

// SELECT * FROM `users` ORDER BY id DESC;
	  // ３．データベースを切断する
	  $dbh = null;
 	 ?>







</body>
</html>





