<?php
session_start();
include_once('db.php');
include_once('library.php');

if($_POST || isset($_POST)){	
	// print_r($_POST);
	if(isset($_POST['start']) && isset($_POST['id']) && $_POST['start'] == 'start'){
		 // echo "отобразить обнавленные вопросы";
		 $subject_id = $_POST['id'];
		 // $user_information = $_SESSION['logged_user'];
		$subject_info = getSubjectInfo($db, $subject_id, $_SESSION['logged_user']);
		$subject_time = $subject_info['time'];
		$subject_amount = $subject_info['amount'];
		 $user_id = $_SESSION['logged_user']['id'];
		 if($_SESSION['logged_user']['role'] == 9){
			 fixStartDelete($db, $user_id, $subject_id);
			  fixStartTest($db, $user_id, $subject_id, $subject_time);
		 }else{
			 fixStartTest($db, $user_id, $subject_id, $subject_time);
		 }
		 $subject_id = $_POST['id'];
		$current_questions = mixArray($db, $subject_id, $subject_amount);
		echo json_encode($current_questions, JSON_UNESCAPED_UNICODE);
		die();
	}

	if(isset($_POST['submit']) && isset($_POST['id']) && $_POST['submit'] == 'submit'){
		$subject_id = $_POST['id'];
		$true_select_opt = 0;
		$current_questions = [];
		$user_id = $_SESSION['logged_user']['id'];
		// print_r($_POST);
		// print_r($_POST['formData']);
		// print_r($_POST['timeLeft']);
		if((!empty($_POST['formData']) || isset($_POST['formData'])) && ($_POST['timeLeft'] || isset($_POST['timeLeft']))){
			$form_data = $_POST['formData'];
			$subject_info = getSubjectInfo($db, $subject_id, $_SESSION['logged_user']);
			$subject_amount = $subject_info['amount'];
	
			$current_questions = mixArray($db, $subject_id, $subject_amount);
			$selected_options = selectedOptions($db, $form_data);
			$true_select_opt = trueSlectedOptions($db, $selected_options);
			$ball = ball($current_questions, $true_select_opt);
			$save_user_log = saveUserLog($db, $selected_options, $subject_id, $ball, $true_select_opt, $_POST['timeLeft']);
			// echo "current_questions: ";
			// print_r($current_questions);
			// echo "selected_options: ";
			// print_r($selected_options);
			// echo "; true_select_opt: ";
			// print_r($true_select_opt);
			// echo "; ball: ";
			// print_r($ball);
			// echo "; save_user_log: ";
			// print_r($save_user_log);
			// echo "| ";
			if($save_user_log > 0){
				echo $ball." балла(ов)-".getTestTime($db, $subject_id)."-".$true_select_opt.'/'.count($current_questions);
			}else{
				// echo "Не удалось сохранить результат!";
				echo "Не удалось сохранить результат!-".getTestTime($db, $subject_id)."-".$true_select_opt.'/'.count($current_questions);
				fixStartDelete($db, $user_id, $subject_id);
			}
			die();
		}else{
			// echo "Не удалось получить данные!";
			echo "Не удалось получить данные! Возможно, вы даже не попытались пройти тест. -".getTestTime($db, $subject_id)."-".$true_select_opt.'/'.count($current_questions);
			die();
		}
	}
}
?>