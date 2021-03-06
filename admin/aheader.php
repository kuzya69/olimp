<?php
session_start();
$array_script_name = explode("/", $_SERVER['SCRIPT_NAME']);
$current_page = array_pop($array_script_name);
// print_r($_SESSION['logged_user']);die();
if(empty($_SESSION['logged_user']) || $_SESSION['logged_user']['role'] != 9):
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: ../index.php');
	exit();
endif;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Онлайн олимпиады</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../lib/bootstrap-4.3.1-dist/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="../lib/bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="../style/questions_style.css"> -->
	<link rel="stylesheet" href="style/tablesorter-theme-blue.css">
	<link rel="stylesheet" href="../lib/jquery-content-scroller/css/jquery.mCustomScrollbar.min.css">
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="style/astyle.css">
	<script type="text/javascript">
		// (function($){
				// $(document).ready(function(){
					// alert("ok");
					// $(".table-responsive").mCustomScrollbar({
					// 	theme:"dark",
					// 	axis:"x",
					// 	mouseWheel: {
					// 		enable: true,
					// 		scrollAmount: 10000,
					// 		axis: "x",
					// 		preventDefault: false,
					// 		deltaFactor: 10000,
					// 	},
					// });
				// });
			// })(jQuery);
	</script>
</head>
<body>
	<div class="container"> <!--открывающийся тег контаинера-->
		<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglernNvigation" aria-controls="navbarTogglernNvigation" aria-expanded="true" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
                    
                        <div class="ml-auto navbar-toggler mr-1">
                            <?php if(!empty($_SESSION['logged_user'])):?>
                                <span>Добро пожаловать <?=$_SESSION['logged_user']['username']?>!</span>
                            <?php else:?>
                                <span></span>
                            <?php endif;?>
                        </div>

			<div class="collapse navbar-collapse" id="navbarTogglernNvigation">
				<?php if(!empty($_SESSION['logged_user'])):?>

					<?php if($current_page == "index.php"):?>
						<a class="navbar-brand nav-link active" href="#">Главная</a>
					<?php else:?>
						<a class="navbar-brand nav-link" href="index.php">Главная</a>
					<?php endif;?>

					<?php if($current_page == "add_subject.php"):?>
						<a class="navbar-brand nav-link active" href="#">Олимпиады</a>
					<?php else:?>
						<a class="navbar-brand nav-link" href="add_subject.php">Олимпиады</a>
					<?php endif;?>

					<?php if($current_page == "add_questions.php"):?>
						<a class="navbar-brand nav-link mr-auto active" href="#">Вопросы</a>
					<?php else:?>
						<a class="navbar-brand nav-link mr-auto" href="add_questions.php">Вопросы</a>
					<?php endif;?>

				<?php else:?>
					<?php if($current_page == "index.php"):?>
						<a class="navbar-brand nav-link mr-auto active" href="#">Главная</a>
					<?php else:?>
						<a class="navbar-brand nav-link mr-auto" href="../index.php">Главная</a>
					<?php endif;?>
				<?php endif;?>

				<?php if(empty($_SESSION['logged_user'])):?>
					<a class="navbar-brand nav-link login-button" href="../login.php">Войти</a>
					<a class="navbar-brand nav-link signup-button" href="../signup.php">Регистрация</a>
				<?php else: ?>
                                        <?php if(!empty($_SESSION['logged_user'])):?>
                                            <span class="mr-1 d-none d-lg-block d-xl-block">Добро пожаловать <?=$_SESSION['logged_user']['username']?>!</span>
                                        <?php else:?>
                                            <span class="d-none d-lg-block d-xl-block"></span>
                                        <?php endif;?>
					<a class="navbar-brand nav-link logout-button" href="../logout.php">Выйти</a>
				<?php endif; ?>
			</div>
			<!-- <a class="nav-link" href="#">Link</a> -->
			<!-- <a class="nav-link disabled" href="#">Disabled</a> -->
		</nav>
	<?php
	// if(empty($_SESSION['logged_user'])):
	// 	header('Location: index.php');
	// else:
	// 	echo "Вы авторизованы!";
	// 	echo '<a href="logout.php">Выйти</a>';
	// endif;
	?>
	<!-- <nav>
		<div class="navigation">
			<div class="button-menu"><i class="fa fa-bars" aria-hidden="true"></i><span>меню</span></div>
			<ul>
				<li><a href="index.php" class="color0"><i class="fa fa-home" aria-hidden="true"></i></a>
				<li><a href="#" class="color1">Аннотация</a>
				<li><a href="#" class="color2">Инструкции для пользователя</a>
				<li><a href="#" class="color6">Хрестоматия</a>
				<li><a href="#" class="color7">Рекомендуемая литература</a>
				<li><a href="page.php" class="color3">Лекции</a>
				<li><a href="labs.php" class="color4">Лабораторные занятия</a>
				<li><a href="prez.php" class="color5">Презентации</a>
				<li><a href="tests.php" class="color8">Тесты</a>
				<li><a href="video.php" class="color9">Видео</a>
			</ul>
		</div>
	</nav> -->
