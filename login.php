<?php
include_once('start_header.php');
include_once('db.php');
include_once('smtp/Send_Mail.php'); //можно убрать!

if(!empty($_SESSION['logged_user'])){
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: index.php');
}

$data = $_POST;

if(isset($data['login'])){
	$errors = array();
	// print_r($data);

	$query = $db->prepare("SELECT * FROM `users` WHERE `username` = :un");
	$query->bindValue(':un', $data['username']);
	// $query->bindValue(':estatus', 1);
	$query->execute();
	$q_users = $query->fetch(PDO::FETCH_ASSOC);
	if(!empty($q_users)){
		// if($q_users['email_status'] == 0){ //можно убрать!
		// 	$errors[] = "Подтвердите почту!"; //можно убрать!

		// 	$token = $q_users['token']; //можно убрать!
		// 	$base_url = "http://www.olimpiada24.ru/"; //можно убрать!
		// 	$to=(!empty($q_users['email'])?$q_users['email']:"kurbanvim@mail.ru");//"kurbanvim@mail.ru";//mysql_real_escape_string($data['email']);; //можно убрать!
		// 	$subject="Подтверждение электронной почты"; //можно убрать!
		// 	$body='Здравствуйте! <br/> <br/> Мы должны убедиться в том, что вы человек. Пожалуйста, <a href="'.$base_url.'activation/'.$token.'">подтвердите адрес</a> вашей электронной почты, и можете начать использовать ваш аккаунт на сайте. <br/> <a href="'.$base_url.'activation/'.$token.'">Подтвердить</a>'; //можно убрать!
		// 	Send_Mail($to,$subject,$body); //можно убрать!

		// }//можно убрать!
		// if($q_users['email_status'] == 1){ //можно убрать!
			if( password_verify($data['password'], $q_users['password'])){
				$_SESSION['logged_user'] = $q_users;
				echo '<div style="color: green;">Вы успешно авторизованы!</div><hr>';
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: index.php");
			}else{
				$errors[] = "Пароль не верный!";
			}
		// } //можно убрать!
	}else{
		$errors[] = "Пользователь не найден!";
	}
	if(!empty($errors)){
		echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
	}
}

?>
<section>
	<form action="login.php" method="POST" class="form-signin">
		<h1 class="h3 mb-3 font-weight-normal">Форма входа</h1>

		<label for="inputLogin" class="sr-only">Ваш логин</label>
		<input type="text" id="inputLogin" class="form-control" placeholder="Login" required="" autofocus="" name="username">
		<label for="inputPassword" class="sr-only">Ваш пароль</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" required="" name="password">
		<!--
		<p>
			<strong>Введите ваш логин</strong>
			<input type="text" name="username">
		</p>

		<p>
			<strong>Введите ваш пароль</strong>
			<input type="password" name="password">
		</p>
	-->
		<br>
		<input type="submit" class="btn btn-lg btn-primary btn-block" name="login">

	</form>
</section>
<?php
include_once('footer.php');