<?php
session_start();
include_once('../db.php');
include_once('../library.php');


if((isset($_POST['status']) && $_POST['status'] == 0) && isset($_POST['u']) && isset($_POST['s'])){
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
	exit();
}


if((isset($_POST['status']) && $_POST['status'] == 11) && isset($_POST['s'])){

	$sid = $_POST['s'];
	$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];
	$subject_info = getSubjectInfo($db, $sid, $user_information);

	// $subject_info += ['message' => ""];

	echo json_encode($subject_info, JSON_UNESCAPED_UNICODE);
 	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 10) && isset($_POST['s']) && isset($_POST['d'])){
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
 	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 12) && isset($_POST['s']) && isset($_POST['fd'])){
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
	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 13) && isset($_POST['fd'])){
	$form_data = $_POST['fd'];
	$data = [];
	$response = [];
	foreach($form_data as $key=>$value){
		$data[$value['name']] = $value['value'];
	}
	$save_subject_data = saveSubjectData($db, $data);
	if(!empty($save_subject_data)){
		$response += ['status' => 1, 'message' => "Данные успешно сохранены"];
	}else{
		$response += ['status' => 0, 'message' => "Не удалось сохранить данные"];
	}
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 14) && isset($_POST['s'])){
	$subject_id = $_POST['s'];
	$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];
	$response = [];
	$subject_data = getSubjectInfo($db, $subject_id, $user_information);
	$subject_name = $subject_data['name']."_".time();
	$subject_data['name'] = $subject_name;
	unset($subject_data['id']);
	unset($subject_data['sort']);
	$save_subject_data = saveSubjectData($db, $subject_data);
	$subject_data_by_name = getSubjectInfoByName($db, $subject_name, $user_information);
	if($save_subject_data == 1){
		$questions_by_subject = getQuestionsBySubject($db, $subject_id, $user_information);
		if(!empty($questions_by_subject)){
			for($i = 0; $i < count($questions_by_subject); $i++){
				unset($questions_by_subject[$i]['id']);
				$questions_by_subject[$i]['subject_id'] = $subject_data_by_name['id'];
			}
			$save_questions_to_subject = pdoMultiInsert("questions", $questions_by_subject, $db);
		}else{
			$save_questions_to_subject = 0;
			deleteSubject($db, $subject_data_by_name['id']);
		}
	}else{
		$save_questions_to_subject = 0;
	}
	if(!empty($save_questions_to_subject)){
		$response += ['status' => 1, 'message' => "Данные успешно склонированы", "result" => $subject_data_by_name];
	}else{
		$response += ['status' => 0, 'message' => "Не удалось склонировать данные", "result" => []];
	}
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 21) && isset($_POST['s'])){
	$sid = $_POST['s'];
	$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];
	$questions_by_subject = getQuestionsBySubject($db, $sid, $user_information);

	echo json_encode($questions_by_subject, JSON_UNESCAPED_UNICODE);
	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 22) && isset($_POST['q'])){
	$qid = $_POST['q'];
	$user_information = (!empty($_SESSION['logged_user']))?$_SESSION['logged_user']:[];
	$question_info = getQuestionInfo($db, $qid, $user_information);

	echo json_encode($question_info, JSON_UNESCAPED_UNICODE);
	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 23) && isset($_POST['fd']) && isset($_POST['q']) && isset($_POST['s'])){
	$sid = $_POST['s'];
	$qid = $_POST['q'];
	$selected_img = $_POST['si'];
	$form_data = $_POST['fd'];
	// $image = $_POST['img'];
	$answers = '';
	$_data = [];
	$data = [];
	// print_r($form_data);exit();
	// echo count($form_data);
	$i = 0;
	foreach($form_data as $value){
		@$update_type = explode(":", $value['name']);
		@$update_type_name = $update_type[0];
		@$update_type_value = $update_type[1];
		if($update_type_name == 'create-type'){
			$i++;
			$answers .= $update_type_value.",";
		}
		if($value['name'] == 'question'){
			// echo "q ";
			$_data['question'] = $value['value'];
		}
		if($value['name'] == 'option_1'){
			// echo "o1 ";
			$_data['option_1'] = $value['value'];
		}
		if($value['name'] == 'option_2'){
			// echo "o2 ";
			$_data['option_2'] = $value['value'];
		}
		if($value['name'] == 'option_3'){
			// echo "o3 ";
			$_data['option_3'] = $value['value'];
		}
		if($value['name'] == 'option_4'){
			// echo "o4 ";
			$_data['option_4'] = $value['value'];
		}
		if($value['name'] == 'option_5'){
			// echo "o5 ";
			$_data['option_5'] = $value['value'];
		}
		if($value['name'] == 'option_6'){
			// echo "o6 ";
			$_data['option_6'] = $value['value'];
		}
		// echo explode($value['name']).": ".$value['value']."<br>"; 
	}
	// if($i >= 1){
		$answers = substr($answers, 0, -1);
	// }
	// print_r($selected_img);
	if($selected_img && !empty($selected_img)){
		$data['image'] = "images/".$sid."/".$sid."_".$qid.".jpg";
		// echo "php save file";
	}else{
		$data['image'] = "";
		// echo "php no save file";
	}
	$data['question'] = $_data['question'];
	$data['answers'] = $answers;
	$data['option_1'] = $_data['option_1'];
	$data['option_2'] = $_data['option_2'];
	$data['option_3'] = $_data['option_3'];
	$data['option_4'] = $_data['option_4'];
	$data['option_5'] = $_data['option_5'];
	$data['option_6'] = $_data['option_6'];
	$response = [];
	// print_r($data);exit();
	// echo"<br>";
	// print_r($image);
	// echo"<br>";
	$create_question_data = createNewQuestion($db, $qid, $sid, $data);
	// exit();
	// foreach($form_data as $key=>$value){
	// 	$data[$value['name']] = $value['value'];
	// }
	// $update_question_data = updateQuestionData($db, $qid, $data);
	if($create_question_data > 0){
		$response += ['status' => 1, 'message' => "Данные успешно сохранены"];
	}else{
		$response += ['status' => 0, 'message' => "Не удалось сохранить данные"];
	}
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit();
}

// print_r($_REQUEST);
if((isset($_POST['status']) && $_POST['status'] == 24) && isset($_POST['fd']) && isset($_POST['q']) && isset($_POST['s'])){
	// echo "ok";
	// print_r($_POST['fd']);exit();
	$sid = $_POST['s'];
	$qid = $_POST['q'];
	$selected_img = $_POST['si'];
	$form_data = $_POST['fd'];
	// $image = $_POST['img'];
	$answers = '';
	$_data = [];
	$data = [];
	// print_r($form_data);
	// echo count($form_data);
	$i = 0;
	foreach($form_data as $value){
		@$update_type = explode(":", $value['name']);
		@$update_type_name = $update_type[0];
		@$update_type_value = $update_type[1];
		if($update_type_name == 'update-type'){
			$i++;
			$answers .= $update_type_value.",";
		}
		if($value['name'] == 'question'){
			// echo "q ";
			$_data['question'] = $value['value'];
		}
		if($value['name'] == 'option_1'){
			// echo "o1 ";
			$_data['option_1'] = $value['value'];
		}
		if($value['name'] == 'option_2'){
			// echo "o2 ";
			$_data['option_2'] = $value['value'];
		}
		if($value['name'] == 'option_3'){
			// echo "o3 ";
			$_data['option_3'] = $value['value'];
		}
		if($value['name'] == 'option_4'){
			// echo "o4 ";
			$_data['option_4'] = $value['value'];
		}
		if($value['name'] == 'option_5'){
			// echo "o5 ";
			$_data['option_5'] = $value['value'];
		}
		if($value['name'] == 'option_6'){
			// echo "o6 ";
			$_data['option_6'] = $value['value'];
		}
		// echo explode($value['name']).": ".$value['value']."<br>"; 
	}
	// if($i > 1){
		$answers = substr($answers, 0, -1);
	// }
	// print_r($_data);
	if($selected_img && !empty($selected_img)){
		$data['image'] = "images/".$sid."/".$sid."_".$qid.".jpg";
		// echo "php update file";
	}else{
		$data['image'] = "";
		// echo "php no update file";
	}
	$data['question'] = $_data['question'];
	$data['answers'] = $answers;
	$data['option_1'] = $_data['option_1'];
	$data['option_2'] = $_data['option_2'];
	$data['option_3'] = $_data['option_3'];
	$data['option_4'] = $_data['option_4'];
	$data['option_5'] = $_data['option_5'];
	$data['option_6'] = $_data['option_6'];
	$response = [];
	// print_r($data);
	// echo"<br>";
	// print_r($image);
	// echo"<br>";
	$update_question_data = updateQuestionData($db, $qid, $sid, $data);
	
	// exit();
	// foreach($form_data as $key=>$value){
	// 	$data[$value['name']] = $value['value'];
	// }
	// $update_question_data = updateQuestionData($db, $qid, $data);
	if($update_question_data > 0){
		$response += ['status' => 1, 'message' => "Данные успешно обновлены"];
	}else{
		$response += ['status' => 0, 'message' => "Не удалось обновить данные"];
	}
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit();
}

if((isset($_POST['status']) && $_POST['status'] == 25) && isset($_POST['q']) && isset($_POST['s'])){
	$question_id = $_POST['q'];
	$subject_id = $_POST['s'];
	$response = [];
	if(file_exists('..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$subject_id.DIRECTORY_SEPARATOR.$subject_id.'_'.$question_id.'.jpg')){
		if(unlink('..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$subject_id.DIRECTORY_SEPARATOR.$subject_id.'_'.$question_id.'.jpg')){
			// echo "file delete";
			if(deleteQuestionData($db, $question_id) > 0){
				// echo "success";
				$response += ['status' => 1, 'message' => "Данные успешно удалены"];
				// deleteFile('../images/'.$subject_id.'/'.$subject_id.'_'.$question_id.'jpg');
			}else{
				// echo "data is not delete";
				$response += ['status' => 0, 'message' => "Не удалось удалить данные"];
			}
		}else{
			// echo "file is not delete";
			$response += ['status' => 0, 'message' => "Не удалось удалить картинку"];
		}
	}else{
		if(deleteQuestionData($db, $question_id) > 0){
			// echo "success";
			$response += ['status' => 1, 'message' => "Картинка не была найдена, данные успешно удалены"];
			// deleteFile('../images/'.$subject_id.'/'.$subject_id.'_'.$question_id.'jpg');
		}else{
			$response += ['status' => 0, 'message' => "Не удалось удалить данные"];
			// echo "data is not delete";
		}
	}

	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit();
	// if(unlink('..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$subject_id.DIRECTORY_SEPARATOR.$subject_id.'_'.$question_id.'.jpg')){
	// 	// echo "file delete";
	// 	if(deleteQuestionData($db, $question_id) > 0){
	// 		echo "success";
	// 		// deleteFile('../images/'.$subject_id.'/'.$subject_id.'_'.$question_id.'jpg');
	// 	}else{
	// 		echo "data is not delete";
	// 	}
	// }else{
	// 	echo "file is not delete";
	// }
}

if(isset($_POST['status']) && $_POST['status'] == 26){
	// print_r(getMaxQuestionId($db));
	$response = getMaxQuestionId($db);
	// exit();

	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit();
}

if(isset($_POST['status']) && $_POST['status'] == 30 && isset($_POST['s']) && isset($_POST['u'])){
	$subject_id = $_POST['s'];
	$user_id = $_POST['u'];
	$user_selected_questions_id = [];
	$user_selected_questions_value = [];
	$user_selected_questions_origin = getQuestionsByUser($db, $user_id, $subject_id);

	$user_answers_on_questions = explode(";-;", $user_selected_questions_origin[0]['selected']);
	foreach($user_answers_on_questions as $value){
		if(!empty($value)){
			array_push($user_selected_questions_id, explode("-:-", $value)[0]);
			array_push($user_selected_questions_value, explode("-:-", $value)[1]);
		}
	}
	$_user_selected_questions_value = [];
	foreach($user_selected_questions_value as $value){
		// print_r(explode(",-,", $value));
		array_push($_user_selected_questions_value, (explode(",-,", $value)>0)?explode(",-,", $value):$value);
		// print_r((is_array(explode(",-,", $value)))?explode(",-,", $value)[0]:$value[0]);
	}
	$user_selected_questions = array_combine($user_selected_questions_id, $_user_selected_questions_value);
	$full_questions = getQuestionsById($db, $user_selected_questions_id);

	// print_r($user_selected_questions);

	$response = ['user_questions'=>$full_questions, 'user_selected_options'=>$user_selected_questions];
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit();
}

?>