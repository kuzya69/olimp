<?php
include_once('start_header.php');
include_once('db.php');
include_once('smtp/Send_Mail.php'); //можно убрать!
include_once('library.php');

// unset($_SESSION);
if(!empty($_SESSION['logged_user'])){
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: index.php');
	exit();
}

// if(!empty($_SESSION['message_type']) && $_SESSION['message_type'] == 'success'){
// 	echo '<div style="color: green;">'.$_SESSION['message'].'</div><hr>';
// }elseif(!empty($_SESSION['message_type']) && $_SESSION['message_type'] == 'error'){
// 	echo '<div style="color: red;">'.$_SESSION['message'].'</div><hr>';
// }
// $_SESSION['message_type'] = '';
// $_SESSION['message'] = '';
// print_r($_SESSION);
printAlertMessage('all');

$data = $_POST;

if(isset($data['login'])){
	// $errors = array();
	// print_r($data);

	$query = $db->prepare("SELECT * FROM `users` WHERE `username` = :un");
	$query->bindValue(':un', $data['username']);
	// $query->bindValue(':estatus', 1);
	$query->execute();
	$q_users = $query->fetch(PDO::FETCH_ASSOC);
	if(!empty($q_users) && $q_users){
		if( password_verify($data['password'], $q_users['password'])){
			if($q_users['email_status'] == 0){ //можно убрать!
				// $errors[] = "Подтвердите почту!"; //можно убрать!
				setAlertMessage("Подтвердите почту!", "warning");

				$token = $q_users['token']; //можно убрать!
				$base_url = "http://751c1245.ngrok.io/test/"; //можно убрать!
				// $base_url = "http://www.olimpiada24.ru/"; //можно убрать!
				// $to=(!empty($q_users['email'])?$q_users['email']:"kurbanvim@mail.ru");//"kurbanvim@mail.ru";//mysql_real_escape_string($data['email']);; //можно убрать!
				$to=trim(strip_tags($q_users['email']));//"kurbanvim@mail.ru";//mysql_real_escape_string($data['email']);; //можно убрать!
				$subject="Подтверждение электронной почты"; //можно убрать!
				$body='Здравствуйте! <br/> <br/> Мы должны убедиться в том, что вы человек. Пожалуйста, <a href="'.$base_url.'activation/'.$token.'">подтвердите адрес</a> вашей электронной почты, и можете начать использовать ваш аккаунт на сайте. <br/> <a href="'.$base_url.'activation/'.$token.'">Подтвердить</a>'; //можно убрать!
				// ini_set("SMTP", "scp26.hosting.reg.ru");
				// ini_set("sendmail_from", "support@olimpiada24.ru");
				// $message = "The mail message was sent with the following mail setting:\r\nSMTP = aspmx.l.google.com\r\nsmtp_port = 25\r\nsendmail_from = YourMail@address.com";
				$headers = "From: support@olimpiada24.ru";
				Send_Mail($to,$subject,$body); //можно убрать!
				mail($to,$subject,$body, $headers);
				// $_SESSION['message_type'] = 'success';
				// $_SESSION['message'] = "Вы успешно зарегистрировались! <b>Вам необходимо подтвердить свою почту</b>";
				setAlertMessage("Вы успешно зарегистрировались! <b>Вам необходимо подтвердить свою почту</b>", "success");
				// print_r($_SESSION);

			}//можно убрать!
			if($q_users['email_status'] == 1){ //можно убрать!
				// if( password_verify($data['password'], $q_users['password'])){
					// print_r($q_users);
					// exit();
					$_SESSION['logged_user'] = $q_users;
					// echo '<div style="color: green;">Вы успешно авторизованы!</div><hr>';
					// unset($_SESSION['logged_user']['lastname']);
					// exit();
					setAlertMessage("Добро пожаловать!", "success");
					
					// print_r($_SESSION);
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: index.php");
					exit();
				
			} //можно убрать!
		}else{
			// $errors[] = "Пароль не верный!";
			setAlertMessage("Пароль не верный!", "danger");
		}
	}else{
		// $errors[] = "Пользователь не найден!";
		setAlertMessage("Пользователь не найден!", "danger");
	}
	// if(!empty($errors)){
		// echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
	// }
	printAlertMessage("all");
}

?>
<section>
	<form action="login.php" method="POST" class="form-signin">
		<h1 class="h3 mb-3 font-weight-normal">Форма входа</h1>

		<label for="inputUsername" class="sr-only">Ваш логин</label>
		<input type="text" id="inputUsername" class="form-control" placeholder="Login" required="" autofocus="" name="username">
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
		<input type="submit" class="btn btn-lg btn-primary btn-block" name="login" value="Войти">

	</form>
</section>
<?php
include_once('footer.php');