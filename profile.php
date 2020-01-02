<?php
include_once('header.php');
include_once('db.php');
include_once('library.php');

header('Content-Type: text/html; charset=utf-8');

if(isset($_POST['profile'])){
	if(!empty($_SESSION['logged_user'])){
		$query = $db->prepare("SELECT * FROM `users` WHERE `id` = :uid");
		$query->bindValue(':uid', (int)trim($_SESSION['logged_user']['id']));
		$query->execute();
		$users_info = $query->fetch();
	}else{
		$users_info = null;
	}

	$data = $_POST;
	if(empty($data['profile'])){
		if(!empty($users_info)){
			$data = $users_info;
		}else{
			$data = [];
		}
	}
	date_default_timezone_set('UTC');
	$time_now = time() + (3 * 60 * 60);

	// print_r($data["trainingdirection_type"][0]);exit();
	$update_flag = 0;
	$query = $db->prepare("UPDATE `users` 
	SET 
		`username` = :un, 
		`email` = :e, 
		-- `password` = :p, 
		`lastname` = :ln, 
		`firstname` = :fn, 
		`middlename` = :mn,
		`phone` = :phone,
		`datebirth` = :dbirdth,
		`institution` = :ins,
		`сity` = :city,
		`course`= :course,
		`groupnumber`= :gn,
		`trainingdirection_type` = :tdt,
		`trainingdirection` = :td,
		`leveloftraining` = :lot
	WHERE `username` = :sun");

	// $query->bindValue(':un', (string)trim(strip_tags(htmlspecialchars($data['username'])))); // username не readonly
	$query->bindValue(':un', (string)trim(strip_tags(htmlspecialchars($users_info['username'])))); //пока username readonly
	$query->bindValue(':e', (string)trim(strip_tags(htmlspecialchars($data['email']))));
	// $query->bindValue(':p', password_hash($data['password'], PASSWORD_DEFAULT));
	$query->bindValue(':ln', (string)trim(strip_tags(htmlspecialchars($data['lastname']))));
	$query->bindValue(':fn', (string)trim(strip_tags(htmlspecialchars($data['firstname']))));
	$query->bindValue(':mn', (string)trim(strip_tags(htmlspecialchars($data['middlename']))));
	$query->bindValue(':phone', (string)trim(strip_tags(htmlspecialchars($data['phone']))));
	$query->bindValue(':dbirdth', trim($data['datebirth'])); //исправить проверку
	$query->bindValue(':ins', (string)trim(strip_tags(htmlspecialchars($data['institution']))));
	$query->bindValue(':city', (string)trim(strip_tags(htmlspecialchars($data['сity']))));
	$query->bindValue(':course', (int)trim($data['course']));
	$query->bindValue(':gn', (string)trim(strip_tags(htmlspecialchars($data['groupnumber']))));
	$query->bindValue(':tdt', (int)trim($data["trainingdirection_type"][0]));
	$query->bindValue(':td', (string)trim(strip_tags(htmlspecialchars($data['trainingdirection']))));
	$query->bindValue(':lot', (string)trim($data["leveloftraining"][0]));
	$query->bindValue(':sun', (string)trim($_SESSION['logged_user']['username']));
	$query->execute();
	$update_flag = $query->rowCount();
	unset($query);

	//Сохраниение пароля так как стоит readonly, закоментировано
	// if(!empty($data['password']) && $data['password'] == $data['repassword']){
	// 	$query = $db->prepare("UPDATE `users` 
	// 	SET 
	// 		`password` = :p 
	// 	WHERE `username` = :sun");
	// 	$query->bindValue(':p', password_hash($data['password'], PASSWORD_DEFAULT));
	// 	$query->bindValue(':sun', (string)trim($_SESSION['logged_user']['username']));
	// 	$query->execute();
	// 	$update_flag = $query->rowCount();
	// 	unset($query);
	// }

	$query = $db->prepare("SELECT * FROM `users` WHERE `username` = :un");
	$query->bindValue(':un', $data['username']);
	$query->execute();
	$q_users = $query->fetch(PDO::FETCH_ASSOC);
	unset($query);

	$_SESSION['logged_user'] = $q_users;
	if($update_flag > 0){
		// echo '<div style="color: green;">Данные обновлены!</div><hr>';
		setAlertMessage("Данные обновлены!", "success");
	}
}else{
	//echo '<div style="color: red;">Данные не получены!</div><hr>';

	if(!empty($_SESSION['logged_user'])){
		$query = $db->prepare("SELECT * FROM `users` WHERE `id` = :uid");
		$query->bindValue(':uid', (int)trim($_SESSION['logged_user']['id']));
		$query->execute();
		$users_info = $query->fetch();
	}else{
		$users_info = null;
	}

	$data = $_POST;
	if(empty($data['profile'])){
		if(!empty($users_info)){
			$data = $users_info;
		}else{
			$data = [];
		}
	}
}
printAlertMessage('all');
// print_r($data);

?>
<section>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Главная</a></li>
			<li class="breadcrumb-item active" aria-current="page">Профиль</li>
		</ol>
	</nav>

	<form action="profile.php" method="POST"  class="form-profile">
	<h1 class="h3 mb-3 font-weight-normal">Мой профиль</h1>

	<label for="inputUsername" class="sr-only">Ваш логин</label>
	<input type="text" id="inputUsername" class="form-control" placeholder="логин" autofocus="" readonly name="username" value="<?php echo @$data['username'];?>">

	<label for="inputEmail" class="sr-only">Ваш e-mail</label>
	<input type="email" id="inputEmail" class="form-control" placeholder="e-mail" autofocus="" name="email" value="<?php echo @$data['email'];?>">

	<label for="inputPassword" class="sr-only">Ваш пароль</label>
	<input type="password" id="inputPassword" class="form-control" placeholder="пароль" readonly name="password">

	<label for="inputRepassword" class="sr-only">Повтарите пароль</label>
	<input type="password" id="inputRepassword" class="form-control" placeholder="повтор пароля" readonly name="repassword">

	<label for="inputLastName" class="sr-only">Фамилия</label>
	<input type="text" id="inputLastName" class="form-control" placeholder="фамилия" name="lastname" value="<?php echo @$data['lastname'];?>">

	<label for="inputFirstName" class="sr-only">Имя</label>
	<input type="text" id="inputFirstName" class="form-control" placeholder="имя" name="firstname" value="<?php echo @$data['firstname'];?>">

	<label for="inputMiddleName" class="sr-only">Отчество</label>
	<input type="text" id="inputMiddleName" class="form-control" placeholder="отчество" name="middlename" value="<?php echo @$data['middlename'];?>">

	<label for="inputPhone" class="sr-only">Номер телефона</label>
	<input type="text" id="inputPhone" class="form-control" placeholder="номер телефона" name="phone" value="<?php echo @$data['phone'];?>">

	<label for="inputDateBirth" class="sr-only">Дата рождения</label>
	<input type="date" id="inputDateBirth" class="form-control" placeholder="дата рождения" name="datebirth" value="<?php echo @$data['datebirth'];?>">

	<label for="inputInstitution" class="sr-only">Учебное заведение</label>
	<input type="text" id="inputInstitution" class="form-control" placeholder="учебное заведение(полное название)" name="institution" value="<?php echo @$data['institution'];?>">

	<label for="inputCity" class="sr-only">Город</label>
	<input type="text" id="inputCity" class="form-control" placeholder="город(место нахождения учебного заведения)" name="сity" value="<?php echo @$data['сity'];?>">

	<label for="inputCourse" class="sr-only">Курс(класс)</label>
	<input type="number" id="inputCourse" class="form-control" placeholder="курс(класс)" name="course" value="<?php echo (!empty($data['course']))?$data['course']:"";?>">

	<label for="inputGroupNumber" class="sr-only">Номер группы(номер класса)</label>
	<input type="text" id="inputGroupNumber" class="form-control" placeholder="номер группы(номер класса)" name="groupnumber" value="<?php echo @$data['groupnumber'];?>">
	<?php
	// print_r($data);
	// echo "<br>";
	// echo $data['trainingdirection_type'];
	?>
	<!-- <label for="selectTrainingDiraction" class="sr-only">Номер группы</label>  -->
	<select class="form-control" id="selectTrainingDiraction" name="trainingdirection_type[]">
		<?php if(!empty($data['trainingdirection']) && $data['trainingdirection'] == 'школа' && $data['trainingdirection_type'][0] == 1):?>
			<option selected="selected" class="option-training-diraction" value="1">школа</option>
			<option value="2">ВУЗ</option>
			<option value="3">колледж</option>
		<?php elseif($data['trainingdirection_type'][0] == 2):?>
			<option class="option-training-diraction" value="1">школа</option>
			<option selected="selected" value="2">ВУЗ</option>
			<option value="3">колледж</option>
		<?php elseif($data['trainingdirection_type'][0] == 3):?>
			<option class="option-training-diraction" value="1">школа</option>
			<option value="2">ВУЗ</option>
			<option selected="selected" value="3">колледж</option>
		<?php else:?>
			<option selected="selected" class="option-training-diraction" value="0">Выберите учебное заведение</option>
			<option class="option-training-diraction" value="1">школа</option>
			<option value="2">ВУЗ</option>
			<option value="3">колледж</option>
		<?php endif;?>
	</select>
	
	<!-- <label for="inputlLevelOfTraining" class="sr-only">Уровень подготовки</label> -->
	<select class="form-control" id="inputlLevelOfTraining" name="leveloftraining[]">
		<?php if($data['leveloftraining'][0] == '1' && ($data['trainingdirection_type'][0] != 1 || $data['trainingdirection_type'][0] != 0)):?>
			<option class="option-level-of-training" value="0">Выберите уровень подготовки</option>
			<option selected="selected" value="1">бакалавриат</option>
			<option value="2">магистратура</option>
			<option value="3">специалитет</option>
			<option value="4">аспирантура</option>
		<?php elseif($data['leveloftraining'][0] == '2' && ($data['trainingdirection_type'][0] != 1 || $data['trainingdirection_type'][0] != 0)):?>
			<option class="option-level-of-training" value="0">Выберите уровень подготовки</option>
			<option value="1">бакалавриат</option>
			<option selected="selected" value="2">магистратура</option>
			<option value="3">специалитет</option>
			<option value="4">аспирантура</option>
		<?php elseif($data['leveloftraining'][0] == '3' && ($data['trainingdirection_type'][0] != 1 || $data['trainingdirection_type'][0] != 0)):?>
			<option class="option-level-of-training" value="0">Выберите уровень подготовки</option>
			<option value="1">бакалавриат</option>
			<option value="2">магистратура</option>
			<option selected="selected" value="3">специалитет</option>
			<option value="4">аспирантура</option>
		<?php elseif($data['leveloftraining'][0] == '4' && ($data['trainingdirection_type'][0] != 1 || $data['trainingdirection_type'][0] != 0)):?>
			<option class="option-level-of-training" value="0">Выберите уровень подготовки</option>
			<option value="1">бакалавриат</option>
			<option value="2">магистратура</option>
			<option value="3">специалитет</option>
			<option selected="selected" value="4">аспирантура</option>
		<?php else:?>
			<option selected="selected" class="option-level-of-training" value="0">Выберите уровень подготовки</option>
			<option value="1">бакалавриат</option>
			<option value="2">магистратура</option>
			<option value="3">специалитет</option>
			<option value="4">аспирантура</option>
		<?php endif;?>
	</select>

	<label for="inputTrainingDirection" class="sr-only">Направлени подготовки</label>
	<input type="text" id="inputTrainingDirection" class="form-control" placeholder="направление подготовки" name="trainingdirection" value="<?php echo @$data['trainingdirection'];?>">



	<input type="submit" class="btn btn-lg btn-primary btn-block" name="profile" value="Записать">
</form>
</section>
<?php
include_once('footer.php');
?>