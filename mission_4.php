<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	制作実践、DB作り！
</head>
<body>

<?php

 $dsn='（データベース名）';

 $user='（ユーザー名）';

 $password='（パスワード）';

 $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	//3-1
	//データベース接続

 $sql="CREATE TABLE IF NOT EXISTS mission42"

 ."("
 ."num INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
 ."name char(32),"
 ."comment TEXT,"
 ."date TEXT,"
 ."password char(32)"
 .");";

 $stmt=$pdo -> query($sql);

	//3-2
	//テーブルの作成

 if(!empty($_POST["hensyu"])&& !empty($_POST["hensyupass"]) ){
	//if1
	//"hensyu"と"hensyupass"の中身が存在している時

	echo"編集";

 $hensyu=$_POST["hensyu"];

	 $sql='SELECT *FROM mission42 ';

	 $stmt=$pdo -> query($sql);

	foreach($stmt as $row){
		//$result を $rowとして反復処理

		if($_POST["hensyu"] === $row[0] && $_POST["hensyupass"] === $row[4] ){
			//if2 編集対処番号と行番号が一致したら


		$edit_num= $row[0];
		$edit_name= $row[1];
		$edit_comment= $row[2];
		$edit_date= $row[3];
		$edit_pass= $row[4];


			echo"編集対処番号と行番号が一致したので呼び出します！<br>";

		}
			//if2 の ｝

	}
		//foreach }
	
 }
	//if1 の ｝

 ?>


<form method="post" action="">
<p>
	<input type="text" name="namae" placeholder="お名前" value="<?php echo $edit_name;?>">
<br>
	<input type="text" name="comment"placeholder="コメント" value="<?php echo $edit_comment;?>">
<br>
	<input type="text" name="password" placeholder="パスワード" value="<?php echo $edit_pass;?>" >
	<input type="submit" name="sousin" value="送信">

<br>
	<input type="text" name="Hensyu" value="<?php echo $edit_num;?>" >
	<input type="text" name="pass" value="<?php echo $edit_pass;?>" >
</p>

<p>
	<input type="text" name="Rdkey" placeholder="削除対象番号">
<br>
	<input type="text" name="Rdkeypass" placeholder="パスワード">
	<input type="submit" name="delbtn" value="削除">
</p>

<p>
	<input type="text" name="hensyu" placeholder="編集対象番号">
<br>
	<input type="text" name="hensyupass" placeholder="パスワード">
	<input type="submit" name="henbtn" value="編集">
</p>


<?php

	//↓新規投稿

 $name=$_POST["namae"];

 $comment=$_POST["comment"];

 $date=date("Y/n/j G:i:s" );

 $password=$_POST["password"];

 $Hensyu=$_POST["Hensyu"];

if(!empty($comment) && !empty($name) && !empty($password)&& empty($Hensyu) ){

 echo"コメントありがとうございます！<br>";

 $sql=$pdo -> prepare("INSERT INTO mission42 (name,comment,date,password) VALUES(:name,:comment,:date,:password)");

 $sql -> bindParam(':name',$name,PDO::PARAM_STR);

 $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);

 $sql -> bindParam(':date',$date,PDO::PARAM_STR);

 $sql -> bindParam(':password',$password,PDO::PARAM_STR);

 $name=$_POST["namae"];

 $comment=$_POST["comment"];

 $date=date("Y/n/j G:i:s" );

 $password=$_POST["password"];

 $sql -> execute();

	//3-5
	//データ挿入

}
else{

 echo"お名前とコメントとパスワードをお願いします！<br/><br/>";

}

 ?>

<?php

	//↓削除機能

 if(!empty($_POST["Rdkey"]) && !empty($_POST["Rdkeypass"])){
	//if2
	//"Rdkey"の中身が存在していて かつ パスワードが存在する時


			 $sql='delete from mission42 where num=:num and password=:password';

			 $stmt=$pdo->prepare($sql);

			 $stmt->bindParam(':num',$num,PDO::PARAM_INT);

			 $stmt->bindParam(':password',$password,PDO::PARAM_INT);

			 $password=$_POST["Rdkeypass"];

			 $num=$_POST["Rdkey"];

			 $stmt->execute();

				//3-8
				//deleteで削除



	

 }
	//if2 の ｝

	//↓編集機能

 if(!empty($comment) && !empty($name) && !empty($_POST["Hensyu"]) ){	
	
	//if3

	
		 $sql='SELECT *FROM mission42';

		 $stmt=$pdo -> query($sql);

		 $results=$stmt -> fetchAll();


	foreach($results as $row){

		if($_POST["Hensyu"] === $row[0]  && $_POST["pass"]===$row[4] &&$_POST["pass"]===$_POST["password"]){
		$new_name=$_POST["namae"];
		$new_comment=$_POST["comment"];
		$new_time=date("Y/n/j G:i:s" ) ;
		$new_pass=$_POST["password"];

		 $sql='update mission42 set name=:name,comment=:comment,date=:date,password=:password where num=:num';

		 $stmt=$pdo->prepare($sql);

		 $stmt->bindParam(':name',$name,PDO::PARAM_STR);

		 $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);

		 $stmt->bindParam(':num',$num,PDO::PARAM_STR);

		 $stmt -> bindParam(':date',$date,PDO::PARAM_STR);

		 $stmt -> bindParam(':password',$password,PDO::PARAM_STR);


		 $num=$_POST["Hensyu"];

		 $name=$_POST["namae"];

		 $comment=$_POST["comment"];

		 $date=date("Y/n/j G:i:s" );

		 $password=$_POST["password"];


		 $stmt->execute();

			//3-7
			//編集

		echo"編集対処番号と行番号が一致したので編集しました！<br>";

		}else{

		}
	 }

		//foreach }

 }

	//if3 }

	
		 $sql='SELECT *FROM mission42';

		 $stmt=$pdo -> query($sql);

		 $results=$stmt -> fetchAll();

		 foreach($results as $row){

			echo $row['num'].',';

			echo $row['name'].',';

			echo $row['comment'].',';

			echo $row['date'].'<br>';

 		}

		//foreach の ｝

			//3-6
			//データ表示

 ?>


</form>
</body>
</html>