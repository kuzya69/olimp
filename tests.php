<?php
include_once('header.php');
include_once('db.php');
include_once('library.php');

header('Content-Type: text/html; charset=utf-8');

$success = false;

if(!empty($_SESSION['logged_user']) && $_SESSION['logged_user']['role'] != 9){
	$query = $db->prepare("SELECT * FROM `user_selected_options` WHERE `user_id` = :uid");
	$query->bindValue(':uid', (int)trim($_SESSION['logged_user']['id']));
	$query->execute();
	$user_selected_options_info = $query->fetchAll();
}else{
	$user_selected_options_info = null;
}
?>
<style>
	footer {
		display: none;	
	}
</style>
<?php

?>

<?php
// Проверка на выбор тематики теста
if(!empty($_GET) && !empty($_GET['id'])){
	$username = $_SESSION['logged_user']['username'];
	$subject_id = $_GET['id'];

	$subject_info = getSubjectInfo($db, $subject_id, $_SESSION['logged_user']);
	$pos = strpos($username, "U");
	$prefix = substr($username, 0, $pos);
	if($subject_info['uprefix'] || isset($subject_info['uprefix'])){
		if($subject_info['uprefix'] == $prefix){
			$success = true;	
		}else{
			echo "У вас нет доступа к олимпиаде!";
			include_once('footer.php');
			die();
			// header("HTTP/1.1 301 Moved Permanently");
			// header('Location: index.php');
		}
	}else{
		$success = true;
	}
	if($success == true){
		//***расчет времени для вывода***//
		$subject_time = $subject_info['time'];
//        $subject_time = 30;
		if(empty($subject_time)){
			$subject_time_hour = '00';
			$subject_time_min = '00';
			$subject_time_sec = '00';
		}else if($subject_time >= 59){
			$subject_time_hour = $subject_time/60;
			$subject_time_min = '00';
			$subject_time_sec = '00';
			if(!is_int($subject_time_hour)){
				$subject_time_hour = round($subject_time_hour, 0, PHP_ROUND_HALF_DOWN);
				if($subject_time_hour < 10){
					$subject_time_hour = '0'.$subject_time_hour;
				}
				$subject_time_min = $subject_time%60;
				if($subject_time_min < 10){
					$subject_time_min = '0'.$subject_time_min;
				}
			}
		}else{
			$subject_time_hour = '00';
			$subject_time_min = $subject_time;
			$subject_time_sec = '00';
		}
		//--------------------------------//
//        echo $subject_time.":";
//        echo $subject_time_hour.":";
//        echo $subject_time_min.":";
//        echo $subject_time_sec;
		
		date_default_timezone_set('UTC');
		$time = time() + (3 * 60 * 60);
		$current_date = date('Y-m-d', $time);
		$date = new DateTime($current_date);
		$c_date = $date->getTimestamp();

		$query = $db->prepare("SELECT * FROM `subjects` WHERE `id` = :sid");
		$query->bindValue(':sid', (int)$subject_id);
		$query->execute();
		$subject = $query->fetch();

		$s_date = new DateTime($subject['date_start']);
		$date_start = $s_date->getTimestamp();		
		$e_date = new DateTime($subject['date_end']);
		$date_end = $e_date->getTimestamp();

		if($c_date > $date_end || $c_date < $date_start){
			header('Location: index.php');
		}

		//Проверка на то проходил ли пользователь уже тест 
		if(!empty($user_selected_options_info)){

			foreach ($user_selected_options_info as $key => $value) {
				// print_r($value);die();
				if ($subject_id==$value['subject_id']) {
					header("HTTP/1.1 301 Moved Permanently");
					header('Location: index.php');
				}
			}
		}
		// $current_questions = mixArray($db, $subject_id);
		// $selected_options = selectedOptions($db);
		// $true_select_opt = trueSlectedOptions($db, $selected_options);
		// $ball = ball($current_questions, $true_select_opt);
		// saveUserLog($db, selectedOptions($db), $ball);
		$current_questions = mixArray($db, $subject_id);
	}
}else{
	echo "Не выбрана тематика!"; 
	include_once('footer.php');
	die();
}
// $arr = mixArray($db);
// $current_questions = array_splice($arr, 1);
?>

<section>
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.php">Главная</a></li>
			<li class="breadcrumb-item active" aria-current="page">Тест</li>
		</ol>
	</nav>
	<div class="test-time-block">
		<div class="test-time row">
			<p class="col-5 col-sm-5 col-md-3 col-lg-3"></p>
			<div class="col-1 col-sm-1 col-md-7 col-lg-7"></div>
			<div class="col-6 col-sm-6 col-md-2 col-lg-2">
				<span class='test-minutes'><?=$subject_time_min?></span>
				<span class="test-delimiter">:</span>	
				<span class='test-seconds'><?=$subject_time_sec?></span>
			</div>
				<!-- <span class="hour">21</span>
				<span class="time-delimiter">:</span>
				<span class="minutes">12</span>
				<span class="time-delimiter">:</span>
				<span class="seconds">45</span> -->
		</div>
		<div class="start-timer test-time-start btn btn-primary">
			Начать тест
		</div>
	</div>
	<div class="section-test">
		<div class="all-questions">
			<ul></ul>
		</div>
		<form class="form-for-test" action="tests.php" method="post">
		<?php
		// foreach ($current_questions as $row=>$value) {
		// 	$options = [];
		// 	for($i=1; $i<=6; $i++){
		// 		if($value['answers'] == 'more'){
		// 			if(isset($value['option_'.$i]) && !empty($value['option_'.$i])){
		// 				array_push($options, $value['option_'.$i]);
		// 			}
		// 		}
		// 		else{
		// 			if(isset($value['option_'.$i]) && !empty($value['option_'.$i])){
		// 				array_push($options, $value['option_'.$i]);
		// 			}	
		// 		}
		// 	}
		// 	// shuffle($options);
		// 	?>
		<!-- //  	<div class="test-question tq-visible"> -->
		  		<?php
		// 		if(isset($value['question_img'])){
		// 			?>
		<!-- //  			<img src="<?//=$value['question_img']?>"> -->
		<!-- //  			<p class="question-middle"><?//=$value['question']?></p> -->
		  			<?php	
		// 		}else{
		// 			?>
		<!-- //  			<p class="question-first"><?//=$value['question']?></p> -->
		  			<?php	
		// 		}

		// 		if($value['answers'] == 'more'){
		// 			$i = 0;
		// 			foreach($options as $key){
		// 				// echo "this->".$key;
		// 				?>
		<!-- //  				<label for="checkbox-<?//=$value['id'].$i?>"><?//=$key?> -->
		<!-- //  					<input type="checkbox" name="checkbox-<?//=$value['id'].$i?>" id="checkbox-<?//=$value['id'].$i?>" value="<?//=$value['id']."-".$key?>"> -->
		<!-- //  				</label><br> -->
		  				<?php
		// 				$i++;
		// 			}unset($key);unset($i);
		// 		}else{
		// 			$i = 0;
		// 			foreach($options as $key){
		// 				// echo "this->".$key;
		//  				?>
		<!-- //  				<label for="radio-<?//=$value['id'].$i?>"><?//=$key?> -->
		<!-- //  					<input type="radio" name="radio-<?//=$value['id']?>" id="radio-<?//=$value['id'].$i?>" value="<?//=$value['id']."-".$key?>"> -->
		<!-- //  				</label><br> -->
		  				<?php
		// 				$i++;
		// 			}unset($key);unset($i);
		// 		}
		// 		?>
		<!-- //  	</div> -->
		  	<?php
		// }unset($row);unset($value);
		// $db = null;
		?>
		</form>
			<!-- <input class="submit-test btn btn-success" type="button" value='Отправить'> -->
			<!-- <button class="prev">Назад</button> -->
			<!-- <button class="next">Далее</button> -->
	</div>
	<script type="text/javascript">
		// $(document).ready(function(){
		// 	// $('.test-time-start').click(function(){
		// 		alert('start');
		// 	// });

		// 	function calcTime() {
		// 		var sec = parseInt($('.test-seconds').html());
		// 		alert(sec);
		// 	}
		// 	setTimeout(calcTime, 1000);
		// });
	</script>
</section>
<?php
include_once('footer.php');
