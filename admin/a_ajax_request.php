<?php

session_start();

include_once('../db.php');

include_once('../library.php');



if($_POST['status'] == 0 && isset($_POST['u']) && isset($_POST['s'])){
	$result = [];
	$uid = $_POST['u'];
	$sid = $_POST['s'];
	$del = fixStartDelete($db, $uid, $sid);
	if($del > 0){
		$result = ['status'=>1, 'message'=>"Данные удалены!"];
	}else{
		$result = ['status'=>0, 'message'=>"Не удалось удалить данные!"];
	}

	echo json_encode($result, JSON_UNESCAPED_UNICODE);

	die();
}


if($_POST['status'] == 11 && isset($_POST['s'])){

	$sid = $_POST['s'];
	$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];
	$subject_info = getSubjectInfo($db, $sid, $user_information);

	// $subject_info += ['message' => ""];

	echo json_encode($subject_info, JSON_UNESCAPED_UNICODE);

 	die();
}

if($_POST['status'] == 10 && isset($_POST['s']) && isset($_POST['d'])){
	$sid = $_POST['s'];
	$display = $_POST['d'];
	$update_subject_status = updateSubjectStatus($db, $sid, $display);

	$update_status = ['status' => $display];
	if($display == 1 && $update_subject_status > 0){
		$update_status +=['message' => "Предмет видимый"];
	}elseif($display == 0 && $update_subject_status > 0){
		$update_status +=['message' => "Предмет скрытый"];
	}else{
		$update_status +=['message' => "Не удалось выполнить операцию"];
	}
	echo json_encode($update_status, JSON_UNESCAPED_UNICODE);

 	die();
}

if($_POST['status'] == 12 && $_POST['s'] && $_POST['fd']){
	$sid = $_POST['s'];
	$form_data = $_POST['fd'];
	$data = [];
	$response = [];
	foreach($form_data as $key=>$value){
		$data[$value['name']] = $value['value'];
	}
	$update_subject_data = updateSubjectData($db, $sid, $data);
	if($update_subject_data > 0){
		$response += ['status' => 1, 'message' => "Данные успешно обновлены"];
	}else{
		$response += ['status' => 0, 'message' => "Не удалось обновить данные"];
	}
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	die();
}

?>