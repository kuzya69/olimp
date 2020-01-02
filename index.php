<?php
include_once('start_header.php');
include_once('db.php');
include_once('library.php');

date_default_timezone_set('UTC');
$time = time() + (3 * 60 * 60);// + (15 * 60);
// var_dump($time); echo "<br>";
$current_date = date('Y-m-d', $time);
// var_dump($current_date);echo "<br>";
$date = new DateTime($current_date);
// print_r($date); echo "<br>";
$c_date = $date->getTimestamp();

// var_dump($c_date)
// ;exit();
// if(empty($_SESSION['logged_user'])){
// 	echo "Вы не авторизованы!";
// 	echo '<a href="login.php">Войти</a>';
// 	echo '<a href="signup.php">Зарегистрироваться</a>';
// }else{
// 	echo "Вы авторизованы!";
// }
// print_r($_SESSION['logged_user']);
// print_r($_SESSION);
printAlertMessage('all');
?>
<br>
<!-- <nav class="nav">
	<ul>
		<li><a href="index.php">Главная</a></li>
		<li><a href="tests.php">Тесты</a></li>
	</ul>
</nav> -->
<section class="_index-section">
	<!-- <h1>Электронный Учебно-Методический Комплекс</h1> -->
	<!-- <p>по дисциплине:"Операционные системы"</p> -->

	<?php
	$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];

	$q_subjects = getSubjects($db, $user_information);
	
	$sort = array_column($q_subjects, 'sort');
	array_multisort($sort, SORT_DESC, $q_subjects);
	?>
	<!-- <div class="row"> -->
		<div class="test-button-group-tabs row" target="_blank">
                    <!--<div class="test-tabs-main">-->
                        <li class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2"><span class="test-tabs-btn act">Активные</span></li>
			<li class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2"><span class="test-tabs-btn arc">Архив</span></li>
			<li class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2"><span class="test-tabs-btn fut">Скоро</span></li>
                    <!--</div>-->
			<?php if(!empty($_SESSION['logged_user']['username'])):?>
                        <!--<div class="test-tabs-second">-->
                            <li class="col-6 col-sm-6 col-md-6 col-lg-2 col-xl-2"><span class="test-tabs-btn pas">Прошел</span></li>
                            <li class="col-6 col-sm-6 col-md-6 col-lg-2 col-xl-2"><span class="test-tabs-btn npas">Не прошел</span></li>
                        <!--</div>-->
			<?php endif;?>
		</div>
	<!-- </div> -->
	<br>
	<div class="row">
		<?php //if(!empty($_SESSION['logged_user']) && checkFillingUserInformation($_SESSION['logged_user']) == 0):?>
			<!-- <p>нужно заполнить профиль</p> -->
			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="card my-card text-white bg-dark mb-3">
					<div class="card-header my-card-header my-card-header-yellow">
						<div class="my-card-header-1">
							<span>ВНИМАНИЕ!</span>
						</div>
					</div>
					<div class="card-body my-card-body">
						<h5 class="card-title my-card-title">Необходимо заполнить профиль
							<span class="badge badge-warning">Важно!</span>
						</h5>
						<hr>
						<p class="card-text my-card-text text-break">Для учета результатов олимпиад и иных интеллектуальных состязаний необходимо заполнить профиль!</p>
						<span class="my-card-text-date"></span>
						<span class="my-card-text-date"></span>
					</div>
					<div class="card-body btn tab-btn-warning btn-warning">
						<a href="profile.php" class="card-link">Профиль</a>
					</div>
				</div>
			</div>
		<?php //else:?>
			<!-- <p>профиль польность заполнен</p> -->
			<!-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="card my-card text-white bg-dark mb-3">
					<div class="card-header my-card-header my-card-header-red">
						<div class="my-card-header-1">
							<span>ВНИМАНИЕ!</span>
						</div>
					</div>
					<div class="card-body my-card-body">
						<h5 class="card-title my-card-title">Заполнить профиль
							<span class="badge badge-danger">Важно!</span>
						</h5>
						<hr>
						<p class="card-text my-card-text">необходимо заполнить профиль!</p>
					</div>
					<div class="card-body btn tab-btn-danger btn-danger">
						<a href="profile.php" class="card-link">Профиль</a>
					</div>
				</div>
			</div> -->
		<?php //endif;?>
		<?php $count_subjects = -1; ?>
		<?php foreach($q_subjects as $key=>$value){ ?>
			<?php
			$count_subjects++;
			$publicity = getPublicity($db);
			if($count_subjects == 3):
			?>
			
			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<div class="card my-card text-white bg-dark mb-3">
					<div class="card-header my-card-header my-card-header-blue">
						<div class="my-card-header-1">
							<span>На правах рекламы</span>
						</div>
					</div>
					<div class="card-body my-card-body">
						<h5 class="card-title my-card-title">Высшее образование в ДГТУ
							<span class="badge badge-primary">Важно!</span>
						</h5>
						<hr>
						<p class="card-text my-card-text text-break">Направление подготовки бакалавров - "Программная инженерия"</p>
						<span class="my-card-text-date"></span>
						<span class="my-card-text-date"></span>
					</div>
					<div class="card-body btn tab-btn-primary btn-primary">
						<a href="http://dstu.ru/fakultety/fakultet-kompjuternykh-tekhnologii-vychislitelnoi-tekhniki-i-ehnergetiki/kafedra-programmnogo-obespechenija-vychislitelnoi-tekhniki-i-avtomatizirovannykh-sistem/" class="card-link">Перейти...</a>
					</div>
				</div>
			</div>
			
			<?php 
			endif;
			// echo "date_start: ".$value['date_start']."<->".$c_date."<br>";
			// echo "date_start: ".$value['date_end']."<->".$c_date."<br>";
			$s_date = new DateTime($value['date_start']);
			$date_start = $s_date->getTimestamp();		
			$e_date = new DateTime($value['date_end']);
			$date_end = $e_date->getTimestamp();		
			?>
			<?php if($c_date >= $date_start && $c_date <= $date_end):?>
				<?php if(!empty($_SESSION['logged_user']) && statusTestForUserAndSubject($db, $_SESSION['logged_user'], $value['id']) == 1):?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 tile act pas">
				<?php else:?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 tile act npas">
				<?php endif;?>
			<?php elseif($c_date >= $date_end):?>
				<?php if(!empty($_SESSION['logged_user']) && statusTestForUserAndSubject($db, $_SESSION['logged_user'], $value['id']) == 1):?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 tile arc pas">
				<?php else:?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 tile arc npas">
				<?php endif;?>
			<?php elseif($c_date <= $date_start):?>
			<div class="col-12 col-sm-6 col-md-4 col-lg-3 tile fut npas">
			<?php endif;?>
				<div class="card my-card text-white bg-dark mb-3">

					<?php if($c_date >= $date_start && $c_date <= $date_end):?>
					<div class="card-header my-card-header my-card-header-green">						
						<div class="my-card-header-1">
							<span><?=$value['amount']?> вопросов (<?=$value['time']?> мин.)</span>
						</div>					
					</div>
					<?php elseif($c_date >= $date_end):?>
					<div class="card-header my-card-header my-card-header-red">						
						<div class="my-card-header-1">
							<span><?=$value['amount']?> вопросов (<?=$value['time']?> мин.)</span>
						</div>					
					</div>
					<?php elseif($c_date <= $date_start):?>
					<div class="card-header my-card-header my-card-header-blue">						
						<div class="my-card-header-1">
							<span><?=$value['amount']?> вопросов (<?=$value['time']?> мин.)</span>
						</div>					
					</div>
					<?php endif;?>

					<div class="card-body my-card-body">
						<h5 class="card-title my-card-title"><?=$value['name']?>
						<?php if($c_date >= $date_start && $c_date <= $date_end):?>
							<span class="badge badge-success">Активный</span>
						<?php elseif($c_date >= $date_end):?>
							<span class="badge badge-danger">Истек срок</span>
						<?php elseif($c_date <= $date_start):?>
							<span class="badge badge-primary">Скоро начнется</span>
						<?php //else:?>
							<!-- <span class="badge badge-danger">Не активные</span></h5> -->
						<?php endif;?>
						</h5>

						<hr>
						
						<p class="card-text my-card-text"><?=$value['description']?></p>
							<span class="my-card-text-date">c <?=" ".$value['date_start']?></span>
							<span class="my-card-text-date">    по <?=" ".$value['date_end']?></span>
					</div>

						<?php if($c_date >= $date_start && $c_date <= $date_end):?>
							<!-- Проверка на вход пользователя -->
							<?php if(!empty($_SESSION['logged_user'])):?>
								<!-- Проверка на то проходил ли пользователь уже тест -->
								<?php if(!empty($_SESSION['logged_user']) && statusTestForUserAndSubject($db, $_SESSION['logged_user'], $value['id']) == 1):?>
									<div class="card-body btn tab-btn-success btn-success">
										<a href="test_results.php" class="card-link">Посмотреть результат</a>
									</div>
								<?php else:?>
									<div class="card-body btn tab-btn-success btn-success">
										<a href="tests.php?id=<?=$value['id']?>" class="card-link">Принять участие</a>
									</div>
								<?php endif;?>
							<?php else:?>
								<div class="card-body btn tab-btn-success btn-success">
									<a href="signup.php" class="card-link">Регистрация</a>
								</div>
							<?php endif;?>
						<?php elseif($c_date >= $date_end):?>
							<!-- Проверка на вход пользователя -->
							<?php if(!empty($_SESSION['logged_user'])):?>
								<!-- Проверка на то проходил ли пользователь уже тест -->
								<?php if(!empty($_SESSION['logged_user']) && statusTestForUserAndSubject($db, $_SESSION['logged_user'], $value['id']) == 1):?>
									<div class="card-body btn tab-btn-danger btn-danger">
										<a href="test_results.php" class="card-link">Посмотреть результат</a>
									</div>
								<?php else:?>
									<div class="card-body btn tab-btn-danger btn-danger">
										<span class="card-link">Принять участие</span>
									</div>
								<?php endif;?>
							<?php else:?>
								<div class="card-body btn tab-btn-danger btn-danger">
									<a href="signup.php" class="card-link">Регистрация</a>
								</div>
							<?php endif;?>
						<?php elseif($c_date <= $date_start):?>
							<?php if(!empty($_SESSION['logged_user'])):?>
								<div class="card-body btn tab-btn-primary btn-primary">
									<span class="card-link">Принять участие</span>
								</div>
							<?php else:?>
								<div class="card-body btn tab-btn-primary btn-primary">
									<a href="signup.php" class="card-link">Регистрация</a>
								</div>
							<?php endif;?>
						<?php endif;?>
						<!-- <a href="#" class="card-link">Другая ссылка</a> -->

				</div>
			</div>
			<!-- echo '<a href="tests.php?id='.<?//=$value['id']?>.'">'.<?//=$value['name']?>.'</a><br>'; -->
		<?php }unset($key);unset($value);?>
	</div>
	<?php
	// print_r($q_subjects);
	?>

	<!-- <a href="tests.php">Tests</a> -->

</section>
<?php

include_once('footer.php');