<?php
session_start();
$array_script_name = explode("/", $_SERVER['SCRIPT_NAME']);
$current_page = array_pop($array_script_name);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Онлайн олимпиады</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="lib/bootstrap-4.3.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="style/style.css">
	<link rel="stylesheet" href="style/slider_style.css">
	<link rel="stylesheet" href="style/tabs_style.css">
</head>
<body>
	<div class="container"> <!--открывающийся тег контаинера-->
		<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglernNvigation" aria-controls="navbarTogglernNvigation" aria-expanded="true" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
                    
                        
						<?php if(!empty($_SESSION['logged_user'])):?>							<div class="ml-auto navbar-toggler mr-1">
								<span>Здравствуйте <?=$_SESSION['logged_user']['username']?>!</span>							</div>
						<?php else:?>
							<span></span>
						<?php endif;?>
                        
			<div class="collapse navbar-collapse" id="navbarTogglernNvigation">
				<?php if(!empty($_SESSION['logged_user'])):?>

					<?php if($current_page == "index.php"):?>
						<a class="navbar-brand nav-link active" href="#">Главная</a>
					<?php else:?>
						<a class="navbar-brand nav-link" href="index.php">Главная</a>
					<?php endif;?>

					<?php if($current_page == "test_results.php"):?>
						<a class="navbar-brand nav-link active" href="#">Результаты</a>
					<?php else:?>
						<a class="navbar-brand nav-link" href="test_results.php">Результаты</a>
					<?php endif;?>

					<?php if($current_page == "profile.php"):?>
						<a class="navbar-brand nav-link mr-auto active" href="#">Профиль</a>
					<?php else:?>
						<a class="navbar-brand nav-link mr-auto" href="profile.php">Профиль</a>
					<?php endif;?>

				<?php else:?>
					<?php if($current_page == "index.php"):?>
						<a class="navbar-brand nav-link mr-auto active" href="#">Главная</a>
					<?php else:?>
						<a class="navbar-brand nav-link mr-auto" href="index.php">Главная</a>
					<?php endif;?>
				<?php endif;?>


				<?php if(empty($_SESSION['logged_user'])):?>
					<a class="navbar-brand nav-link signup-button" href="login.php">Войти</a>
					<a class="navbar-brand nav-link login-button" href="signup.php">Регистрация</a>
				<?php else: ?>
                                        <?php if(!empty($_SESSION['logged_user'])):?>
                                            <span class="mr-1 d-none d-lg-block d-xl-block">Здравствуйте <?=$_SESSION['logged_user']['username']?>!</span>
                                        <?php else:?>
                                            <span class="d-none d-lg-block d-xl-block"></span>
                                        <?php endif;?>
					<a class="navbar-brand nav-link logout-button" href="logout.php">Выйти</a>
				<?php endif; ?>
			</div>
			<!-- <a class="nav-link" href="#">Link</a> -->
			<!-- <a class="nav-link disabled" href="#">Disabled</a> -->
		</nav>