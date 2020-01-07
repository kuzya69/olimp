<?php
include_once('start_header.php');
include_once('db.php');
include_once('smtp/Send_Mail.php');
include_once('library.php');


header('Content-Type: text/html; charset=utf-8');

$data = $_POST;

// $to="kurbanvim@mail.ru";
// $subject="Подтверждение электронной почты";
// $body = "Письмо с <strong>сервера</strong>";
// Send_Mail($to,$subject,$body);

// if(mail("kurbanvim@mail.ru", "asd", "asd")){
// 	echo "ok";
// }else{
// 	echo "no";
// }

// echo "Регистрация временно закрыта!"; 
// include_once('footer.php'); 
// exit();

if(isset($data['signup'])){
	// $errors = array();
	$errors = 0;
	if(trim($data['username']) == ''){
		// $errors[] = 'Введите логин!';
		$errors++;
		setAlertMessage("Введите логин!", "danger");
	}
	if(trim($data['email']) == ''){
		// $errors[] = 'Введите email!';
		$errors++;
		setAlertMessage("Введите email!", "danger");
	}
	if($data['password'] == ''){
		// $errors[] = 'Введите пароль!';
		$errors++;
		setAlertMessage("Введите пароль!", "danger");
	}
	if($data['repassword'] == ''){
		// $errors[] = 'Введите повторно пароль!';
		$errors++;
		setAlertMessage("Введите повторно пароль!", "danger");
	}
	if($data['repassword'] != $data['password']){
		// $errors[] = 'Введенные пароли не совпадают!';
		$errors++;
		setAlertMessage("Введенные пароли не совпадают!", "danger");
	}
	if($data['lastname'] == ''){
		// $errors[] = 'Введите фамилию!';
		$errors++;
		setAlertMessage("Введите фамилию!", "danger");
	}
	if($data['firstname'] == ''){
		// $errors[] = 'Введите имя!';
		$errors++;
		setAlertMessage("Введите имя!", "danger");
	}
	// if($data['middlename'] == ''){
	// 	$errors[] = 'Введите отчество!';
	// }
	// if($data['phone'] == ''){
	// 	$errors[] = 'Введите номер телефона!';
	// }
	// if($data['datebirth'] == ''){
	// 	$errors[] = 'укажите дату рождения!';
	// }
	//if($data['institution'] == ''){
		//$errors[] = 'укажите учебное заведение!';
	//}
	// if($data['сity'] == ''){
	// 	$errors[] = 'введите город!';
	// }
	// if($data['course'] == ''){
	// 	$errors[] = 'Введите курс!';
	// }
	// if($data['groupnumber'] == ''){
	// 	$errors[] = 'Введите номер группы!';
	// }
	// if($data['trainingdirection'] == ''){
	// 	$errors[] = 'Укажите направление подготовки!';
	// }

	$q_users = getUserByUsername($db, $data['username'])['username'];
	if(count($q_users) > 0){
		// $errors[] = 'Пользователь с таким логином существует!';
		$errors++;
		setAlertMessage("Пользователь с таким логином существует!", "danger");
	}else{
		$q_users = getUserByEmail($db, $data['email'])['email'];
		if(count($q_users) > 0){
			// print_r($q_users);
			// $errors[] = 'Пользователь с таким емаилом существует!';
			$errors++;
			setAlertMessage("Пользователь с таким емаилом существует!", "danger");
		}
	}
	
	if(empty($errors)){
		insertNewUser($db, $data);
		
		$base_url = "http://751c1245.ngrok.io/test/";
		// $base_url = "http://www.olimpiada24.ru/";
		$to=trim(strip_tags($data['email']));//"kurbanvim@mail.ru";//
		$subject="Подтверждение электронной почты";
		// $body = "ok";
		$body='Здравствуйте! <br/> <br/> Мы должны убедиться в том, что вы человек. Пожалуйста, <a href="'.$base_url.'activation/'.$token.'">подтвердите адрес</a> вашей электронной почты, и можете начать использовать ваш аккаунт на сайте. <br/> <a href="'.$base_url.'activation/'.$token.'">Подтвердить</a>';
		$headers = "From: support@olimpiada24.ru";
		Send_Mail($to,$subject,$body);
		mail($to,$subject,$body,$headers);

		// echo '<div style="color: green;">Вы успешно зарегистрировались! <b>Необходимо подтвердить свою почту</b></div><hr>';
		// $_SESSION['message_type'] = 'success';
		// $_SESSION['message'] = "Вы успешно зарегистрировались! <b>Вам необходимо подтвердить свою почту</b>";
		setAlertMessage("Вы успешно зарегистрировались! <b>Вам необходимо подтвердить свою почту</b>", "success");
		// echo '<div style="color: green;">Вы успешно зарегистрировались!</div><hr>';
		
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: login.php');
		exit();
	}else{
		// echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
		printAlertMessage("danger");
	}
}
// printAlertMessage("all");
?>

<section>
	<form action="signup.php" method="POST"  class="form-signup">
		<h1 class="h3 mb-3 font-weight-normal">Форма регистрации</h1>

		<label for="inputUsername" class="sr-only">Ваш логин</label>
		<input type="text" id="inputUsername" class="form-control" placeholder="логин" required="" autofocus="" name="username" value="<?php echo @$data['username'];?>">

		<label for="inputEmail" class="sr-only">Ваш e-mail</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="e-mail" required="" autofocus="" name="email" value="<?php echo @$data['email'];?>">

		<label for="inputPassword" class="sr-only">Ваш пароль</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="пароль" required="" name="password">

		<label for="inputRepassword" class="sr-only">Повтарите пароль</label>
		<input type="password" id="inputRepassword" class="form-control" placeholder="повтор пароля" required="" name="repassword">

		<label for="inputLastName" class="sr-only">Фамилия</label>
		<input type="text" id="inputLastName" class="form-control" placeholder="фамилия" required="" name="lastname" value="<?php echo @$data['lastname'];?>">

		<label for="inputFirstName" class="sr-only">Имя</label>
		<input type="text" id="inputFirstName" class="form-control" placeholder="имя" required="" name="firstname" value="<?php echo @$data['firstname'];?>">

		<!-- <label for="inputMiddleName" class="sr-only">Отчество</label> -->
		<!-- <input type="text" id="inputMiddleName" class="form-control" placeholder="отчество" required="" name="middlename" value="<?php //echo @$data['middlename'];?>"> -->

		<!-- <label for="inputPhone" class="sr-only">Номер телефона</label> -->
		<!-- <input type="text" id="inputPhone" class="form-control" placeholder="номер телефона" required="" name="phone" value="<?php //echo @$data['phone'];?>"> -->

		<!-- <label for="inputDateBirth" class="sr-only">Дата рождения</label> -->
		<!-- <input type="date" id="inputDateBirth" class="form-control" placeholder="дата рождения" required="" name="datebirth" value="<?php //echo @$data['datebirth'];?>"> -->

		<!--<label for="inputInstitution" class="sr-only">Учебное заведение</label>-->
		<!--<input type="text" id="inputInstitution" class="form-control" placeholder="учебное заведение(полное название)" required="" name="institution" value="<?php //echo @$data['institution'];?>">-->

		<!-- <label for="inputCity" class="sr-only">Город</label> -->
		<!-- <input type="text" id="inputCity" class="form-control" placeholder="город(место нахождения учебного заведения)" required="" name="сity" value="<?php //echo @$data['сity'];?>"> -->

		<!-- <label for="inputCourse" class="sr-only">Курс</label> -->
		<!-- <input type="number" id="inputCourse" class="form-control" placeholder="курс(цифра)" required="" name="course" value="<?php //echo @$data['course'];?>"> -->

		<!-- <label for="inputGroupNumber" class="sr-only">Номер группы</label> -->
		<!-- <input type="text" id="inputGroupNumber" class="form-control" placeholder="номер группы" required="" name="groupnumber" value="<?php //echo @$data['groupnumber'];?>"> -->

	        <!-- <label for="inputGroupNumber" class="sr-only">Номер группы</label> -->

	        <!-- <select class="form-control" id="selectTrainingDiraction" required=""> -->
	            <!-- <option class="option-training-diraction" value="1">школа</option> -->
	            <!-- <option selected="" value="2">университет</option> -->
	        <!-- </select> -->

		<!-- <label for="inputTrainingDirection" class="sr-only">Направлени подготовки</label> -->
		<!-- <input type="text" id="inputTrainingDirection" class="form-control" placeholder="направление подготовки" required="" name="trainingdirection" value="<?php //echo @$data['trainingdirection'];?>"> -->
		<!--
		<p>
			<p><strong>Ваш логин</strong></p>
			<input type="text" name="username" value="<?//php echo @$data['username'];?>">
		</p>
		<p>
			<p><strong>Ваш e-mail</strong></p>
			<input type="email" name="email" value="<?//php echo @$data['email'];?>">
		</p>
		<p>
			<p><strong>Ваш пароль</strong></p>
			<input type="password" name="password">
		</p>
		<p>
			<p><strong>Повторите пароль</strong></p>
			<input type="password" name="repassword">
		</p>
	-->
		<input type="submit" class="btn btn-lg btn-primary btn-block" name="signup" value="Зарегистрироваться">
	</form>

</section>
<?php

include_once('footer.php');