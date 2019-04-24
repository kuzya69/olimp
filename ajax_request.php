<?php

session_start();

include_once('db.php');

include_once('library.php');



if(isset($_POST['start']) && isset($_POST['id']) && $_POST['start'] == 'start'){

	// print_r($_POST);

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

	// print_r($_POST);echo "<br><br>";

	// selectedOptions($db, $_POST['formData']);

	$subject_id = $_POST['id'];
	$user_id = $_SESSION['logged_user']['id'];

	if(isset($_POST['formData'])){

		$form_data = $_POST['formData'];

                $subject_info = getSubjectInfo($db, $subject_id, $_SESSION['logged_user']);

                $subject_amount = $subject_info['amount'];

	

		$current_questions = mixArray($db, $subject_id, $subject_amount);

		$selected_options = selectedOptions($db, $form_data);

		$true_select_opt = trueSlectedOptions($db, $selected_options);

		$ball = ball($current_questions, $true_select_opt);

		$save_user_log = saveUserLog($db, selectedOptions($db, $_POST['formData']), $subject_id, $ball, $true_select_opt, $_POST['timeLeft']);

		if($save_user_log > 0){
			echo $ball."-".getTestTime($db, $subject_id)."-".$true_select_opt.'/'.count($current_questions);
		}else{
			echo "Не удалось сохранить результат";
			fixStartDelete($db, $user_id, $subject_id);
		}

		die();

	}else{

		echo "0";

		die();

	}

}

?>