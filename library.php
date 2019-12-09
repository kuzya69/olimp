<?php
//date_default_timezone_set('UTC');
/**
 * Считает количество заработанных баллов
 * @param  array $mArr     	 вопросы
 * @param  integer $trueSlOp количество отгаданных вопросов
 * @return integer 			 балл          
 */
function ball($mArr, $trueSlOp){
	$trueAmount = (int)$trueSlOp;
	$amountAllQuest = (int)count($mArr);
	if($amountAllQuest == 0){
		$sum = 0;
	}else{
		$sum = ($trueAmount * 100)/$amountAllQuest;
	}
	return round($sum);
}

/**
 * Выводит количество отгаданных ответов в зависимости от указанного типа
 * @param  object  $db              подключение к базе данных
 * @param  array  $selectedOptions выбранные пользователем ответы
 * @param  boolean $type            правильные(true) или неправильные(false) ответы
 * @return integer                  возвращает количество правильных ответов
 */
function trueSlectedOptions($db, $selected_options, $type=true){
	$trueCount = 0;
	$falseCount = 0;
	foreach ($db->query("SELECT * FROM `questions`") as $row=>$value) {
		// print_r($value);
		if(count(explode(',', $value['answers'])) > 1){
			foreach($selected_options[1] as $row1=>$value1){
				if($row1 == $value['id']){
					$tempCount = 0;
					foreach ($value1 as $variable) {
						$array_id = explode(',', $value['answers']);
						$array_value = [];
						foreach($array_id as $id){
							array_push($array_value, $value['option_'.($id)]);
						}
						foreach ($array_value as $variable1) {
							if($variable == $variable1){
								$tempCount++;
							}
						}unset($variable1);		
					}unset($variable);unset($array_id);
					if($tempCount == count($array_value)){
						$trueCount++;
					}
					else{
						$falseCount++;
					}
				}
			}unset($row1);unset($value1);unset($array_value);
				
		}else{
			foreach($selected_options[0] as $row1=>$value1){
				if($row1 == $value['id']){
					if($value1 == $value['option_'.($value['answers'])]){
						++$trueCount;
					}
					else{
						++$falseCount;
					}
				}
			}unset($row1);unset($value1);
		}
	}unset($row);unset($value);

	if($type == true){
		return $trueCount;
	}
	else{
		return $falseCount;
	}
}

/**
 * Возвращает выбранные ответы пользователя
 * @param  object $db объект базы данных
 * @param  array $form_date данные с формы
 * @return array     массив[0] с одним прпавильным ответом, массив[1] с одним или более правильным ответом. Ключи внутренних массивов id вопроса в таблице
 */
function selectedOptions($db, $form_date){
	$answerArrayOne = [];
	$answerArrayMore = [];
	// $ansString = '';
	// $ansArray = [];
	// $tempAnsArr = [];
	foreach($form_date as $key=>$value){
		// print_r($value);echo "<br>";
		$option = explode('-', $value['name']);
		// print_r($option);echo "<br>";
		$type_option = $option[0];
		if($type_option == 'checkbox'){
			$id_num_option = explode(':', $option[1]);
			if(isset($answerArrayMore[$id_num_option[0]])){
				$answerArrayMore[$id_num_option[0]] += [$id_num_option[1] => $value['value']];
			}else{
				$answerArrayMore += [$id_num_option[0] => [$id_num_option[1] => $value['value']]];
			}
		}else{
			$answerArrayOne += [$option[1] => $value['value']];
		}
	}unset($key);unset($value);
	// print_r($answerArrayMore);echo "<br>";
	// print_r($answerArrayOne);
	// die();



	// print_r($_POST);echo "<br>";

	// $post_user_selected_option = $_POST;

	// $user_selected_option = [];

	// foreach($post_user_selected_option as $key=>$value){

	// 	$array = explode('-',$value);

	// 	$_array['question_id'] = $array[0];

	// 	$_array['answer'] = $array[1];

	// 	array_push($user_selected_option, $_array);

	// }unset($key);unset($value);unset($array);unset($_array);

	// echo "<pre>";

	// print_r( $user_selected_option ); echo "<br>";

	// echo "</pre>";

	// foreach ($db->query("SELECT * FROM `questions`") as $row=>$value) {

	// 	for($i=0; $i<6; $i++){

	// 		if(!empty($_POST['checkbox-'.$value['id'].$i])){

	// 			if(!empty($ansString)){

	// 				$ansString = $ansString.','.explode('-', $_POST['checkbox-'.$value['id'].$i])[1];

	// 			}

	// 			else{

	// 				$ansString = $_POST['checkbox-'.$value['id'].$i];

	// 			}

	// 		}

	// 	}unset($i);

	// 	// print_r($ansString);echo "<br>";

	// 	$ansArray = explode('-', $ansString);

	// 	if(!empty($ansArray[1])){

	// 		$tempAnsArr = explode(',', $ansArray[1]);

	// 	}

	// 	if(!empty($ansArray[0])){

	// 		$answerArrayMore += [$ansArray[0] => $tempAnsArr];

	// 	}

	// 	// print_r($ansArray);echo "<br>";

		

	// 	$ansString = '';

	// 	if(!empty($_POST['radio-'.$value['id']])){

	// 		$answerArrayOne += [explode('-', $_POST['radio-'.$value['id']])[0] => explode('-', $_POST['radio-'.$value['id']])[1]];

	// 	}

	// }unset($row);unset($value);

	// print_r($answerArrayOne);echo"<br><br>";

	// print_r($answerArrayMore);echo"<br>";

	return [$answerArrayOne, $answerArrayMore];
}


/**
 * Записывает переданные данные в таблицу user_selected_options
 * @param  object $db объект базы данных
 * @param  array  $selected_options выбранные пользователем ответы
 * @param  array  $subject_id id предмета
 * @param  array  $ball расчитанный балл за ответы
 * @param  array  $true_select_opt количество правильных ответов
 * @param  array  $time_left время оставшееся до окончания теста
 * @return  int возвращает количество затронутых строк  
 */
function saveUserLog($db, $selected_options, $subject_id, $ball, $true_select_opt, $time_left){
	$answer_string = '';
	foreach($selected_options[0] as $key=>$value){
		$answer_string.=$key."-:-".$value.';-;';
	}unset($key);unset($value);
	foreach($selected_options[1] as $key=>$value){
		$answer_string.=$key."-:-";
		for($i=0; $i<count($value); $i++){
			if(isset($value[$i])){
				if($i != (count($value)-1)){
					$answer_string.=$value[$i].',-,';
				}else{
					$answer_string.=$value[$i].';-;';
				}
			}
		}unset($i);
	}unset($key);unset($value);
	
	$time_now = getNowTime();// + (3 * 60 * 60);
	// $time_future = time() + (3 * 60 * 60) + (30 * 60);

	$query = $db->prepare("UPDATE `user_selected_options` SET `selected` = :s, `ball` = :b, `amount` = :a, `time_left` = :tl WHERE `user_id` = :uid AND `subject_id` = :sid AND `end_time` >= :ntime");
	$query->bindValue(':s', (string)trim(strip_tags(htmlspecialchars($answer_string))));
	$query->bindValue(':b', (int)trim($ball));
	$query->bindValue(':a', (int)trim($true_select_opt));
	$query->bindValue(':tl', (string)trim(strip_tags(htmlspecialchars($time_left))));
	$query->bindValue(':uid', (int)trim($_SESSION['logged_user']['id']));
	$query->bindValue(':sid', (int)trim($subject_id));
	$query->bindValue(':ntime', $time_now);
	$query->execute();
	return $query->rowCount();

}

/**
 * Записывает в таблицу информацию при начале теста
 * @param  object $db объект базы данных
 * @param  int $user_id номер пользователя
 * @param  int $subject_id номер предмета
 * @param  int $test_time время на тест в минутах
 * @return  int возвращает количество затронутых строк  
 */
function fixStartTest($db, $user_id, $subject_id, $test_time=30){
	$time_now = getNowTime();// + (3 * 60 * 60);
	$time_future = $time_now  + ($test_time * 60 + 10); //+ (3 * 60 * 60)

	// print_r(date("H:i:s", $time_future - $time_now));die();
	$query = $db->prepare("INSERT INTO `user_selected_options` (`user_id`,
		`subject_id`, `start_time`, `end_time`, `date_create`) VALUES (:uid, :sid, :stime, :etime, :dc)");
	$query->bindValue(':uid', (int)trim($user_id));
	$query->bindValue(':sid', (int)trim($subject_id));
	$query->bindValue(':stime', (int)$time_now); //Y-m-d H:i:s
	$query->bindValue(':etime', (int)$time_future); //Y-m-d H:i:s + 30 минут
	$query->bindValue(':dc', date("Y-m-d H:i:s", $time_now));
	$query->execute();
	return $query->rowCount();
}

/**
 * Удаляет из таблицы результаты теста
 * @param  object $db объект базы данных
 * @param  int $user_id номер пользователя
 * @param  int $subject_id номер предмета
 * @return  int возвращает количество затронутых строк          
 */
function fixStartDelete($db, $user_id, $subject_id){
	$query = $db->prepare("DELETE FROM `user_selected_options` WHERE `user_id` = :uid AND `subject_id` = :sid");
	$query->bindValue(':uid', (int)trim($user_id));
	$query->bindValue(':sid', (int)trim($subject_id));
	$query->execute();
	return $query->rowCount();
}

/**
 * Возвращает пройденное время с начала теста
 * @param  object $db объект базы данных
 * @param  int $subject_id номер предмета
 * @return date
 */
function getTestTime($db, $subject_id){
    $time_now = getNowTime();// + (3 * 60 * 60);
    $query = $db->prepare("SELECT `start_time` FROM `user_selected_options` WHERE `user_id`=:uid AND `subject_id`=:sid");
    $query->bindValue(':uid', (int)trim($_SESSION['logged_user']['id']));
    $query->bindValue(':sid', (int)trim($subject_id));
    $query->execute();
    $user_test_time = $query->fetch();
    return date('H:i:s', $time_now - $user_test_time['start_time']);
}


/**
 * Возвращает вопросы и варианты в перемешку
 * @param  object $db переменная для подключение к базе данных
 * @param  int $subject_id идентификатор предмета из таблицы subjects
 * @param  int $amount_questions максимальное количество вопросов, которые нужно вернуть
 * @return array     возвращает массив вопросов 
 */
function mixArray($db, $subject_id=null, $amount_questions=null){
	$array = [];
	$outArray = [];
	if(!empty($subject_id)){
		$query = $db->prepare("SELECT * FROM `questions` WHERE `subject_id` = :sid");
		$query->bindValue(':sid', $subject_id);
	}else{
		$query = $db->prepare("SELECT * FROM `questions`");
	}
	$query->execute();
	$list = $query->fetchAll();

	foreach ($list as $key) {
		array_push($array, $key);
	}unset($key);

	shuffle($array);

	if(!empty($amount_questions)){
		$intermediateArray = array_splice($array, 0, $amount_questions);
	}else{	
		$intermediateArray = array_splice($array, 0, 40);
	}



	foreach ($intermediateArray as $row=>$value) {
		$options = [];
		$options_key = [];
		$options_value = [];
		$count_answers = count(explode(',', $value['answers']));
		for($i=1; $i<=6; $i++){
			if(isset($value['option_'.$i]) && !empty($value['option_'.$i])){
				array_push($options_key, 'option_'.$i);
				array_push($options_value, $value['option_'.$i]);
				unset($value['option_'.$i]);
			}
		}unset($i);
		shuffle($options_value);
		$options = array_combine($options_key, $options_value);
		unset($value['answers']);
		$answers = ['answers' => 'one'];
		if($count_answers > 1){
			$answers = ['answers' => 'more'];
		}
		array_push($outArray, array_merge($value, $options, $answers));
	}unset($row);unset($value);

	return $outArray;
}

/**
 * Возвращает информацию о переданном предмете
 * @param  object $db объект базы данных
 * @param  int $subject_id номер предмета
 * @param  array $user_information    информация о пользователе
 * @return array     массив с данными о предмете
 */
function getSubjectInfo($db, $subject_id, $user_information=[]){
	if(!empty($user_information) && $user_information["role"] == 9){
	    $query = $db->prepare("SELECT * FROM `subjects` WHERE `id` = :sid");
	    $query->bindValue(':sid', $subject_id);
	}else{
	    $query = $db->prepare("SELECT * FROM `subjects` WHERE `id` = :sid AND `display` = :dis");
	    $query->bindValue(':sid', $subject_id);
	    $query->bindValue(':dis', 1);
	}
    $query->execute();
    $subject = $query->fetch();
    return $subject;
}

/**
 * Меняет вимимость предмета
 * @param  object $db объект базы данных
 * @param  int $subject_id номер предмета
 * @param  int $display видимость предмета: 1-видимый, 0-скрытый
 * @return  int возвращает количество затронутых строк          
 */
function updateSubjectStatus($db, $subject_id, $display){
	$query = $db->prepare("UPDATE `subjects` SET `display` = :dis WHERE `id` = :sid");
	$query->bindValue(':dis', (int)trim($display));
	$query->bindValue(':sid', (int)trim($subject_id));
	$query->execute();
	return $query->rowCount();
}

/**
 * Сохранияет новый предмет
 * @param  object $db объект базы данных
 * @param  int $data массив данных
 * @return  int возвращает количество затронутых строк          
 */
function saveSubjectData($db, $data){
	$query_select = $db->prepare("SELECT max(`sort`) as `sort` FROM `subjects`");
	$query_select->execute();
	$max_sort = $query_select->fetchAll()[0]['sort'];

	$query = $db->prepare("INSERT INTO `subjects` (`sort`, `name`, `description`, `time`, `amount`, `uprefix`, 
	`display`, `date_start`, `date_end`) VALUES (:s, :n, :d, :t, :a, :up, :dis, :ds, :de)");
	$query->bindValue(':s', $max_sort + 1);
	$query->bindValue(':n', (string)trim(strip_tags(htmlspecialchars($data['name']))));
	$query->bindValue(':d', (string)trim(strip_tags(htmlspecialchars($data['description']))));
	$query->bindValue(':t', (int)trim($data['time']));
	$query->bindValue(':a', (int)trim($data['amount']));
	$query->bindValue(':up', (string)trim(strip_tags(htmlspecialchars($data['uprefix']))));
	$query->bindValue(':dis', 1);
	$query->bindValue(':ds', (string)trim(strip_tags($data['date_start'])));
	$query->bindValue(':de', (string)trim(strip_tags($data['date_end'])));
	$query->execute();
	return $query->rowCount();
}

/**
 * Обновляет поля предмета
 * @param  object $db объект базы данных
 * @param  int $subject_id номер предмета
 * @param  int $data массив данных
 * @return  int возвращает количество затронутых строк          
 */
function updateSubjectData($db, $subject_id, $data){
	$pref = trim(strip_tags(htmlspecialchars($data['uprefix'])));
	$query = $db->prepare("UPDATE `subjects` 
	SET 
		`name` = :n, 
		`description` = :d,  
		`time` = :t,  
		`amount` = :a,  
		`uprefix` = :up,  
		`date_start` = :ds,  
		`date_end` = :de  
	WHERE `id` = :sid");
	$query->bindValue(':n', (string)trim(strip_tags(htmlspecialchars($data['name']))));
	$query->bindValue(':d', (string)trim(strip_tags(htmlspecialchars($data['description']))));
	$query->bindValue(':t', (int)trim($data['time']));
	$query->bindValue(':a', (int)trim($data['amount']));
	$query->bindValue(':up', $pref ? (string)$pref : null);
	$query->bindValue(':ds', (string)trim(strip_tags($data['date_start'])));
	$query->bindValue(':de', (string)trim(strip_tags($data['date_end'])));
	$query->bindValue(':sid', (int)trim($subject_id));
	$query->execute();
	return $query->rowCount();
}

/**
 * Обновляет поля вопроса
 * @param  object $db объект базы данных
 * @param  int $question_id номер вопроса
 * @param  int $subject_id номер предмета
 * @param  int $data массив данных
 * @return  int возвращает количество затронутых строк          
 */
function updateQuestionData($db, $question_id, $subject_id, $data){
	if(!empty($data['image'])){
		$query = $db->prepare("UPDATE `questions` 
		SET 
			`question_img` = :qimg, 
			`question` = :q,  
			`answers` = :a,  
			`subject_id` = :s,  
			`option_1` = :o1,  
			`option_2` = :o2,  
			`option_3` = :o3,  
			`option_4` = :o4,  
			`option_5` = :o5,  
			`option_6` = :o6  
		WHERE `id` = :qid");
		$query->bindValue(':qimg', (string)$data['image']);
		$query->bindValue(':q', (string)trim(strip_tags(htmlspecialchars($data['question']))));
		$query->bindValue(':a', (string)trim(strip_tags(htmlspecialchars($data['answers']))));
		$query->bindValue(':o1', (string)trim(strip_tags(htmlspecialchars($data['option_1']))));
		$query->bindValue(':o2', (string)trim(strip_tags(htmlspecialchars($data['option_2']))));
		$query->bindValue(':o3', (string)trim(strip_tags(htmlspecialchars($data['option_3']))));
		$query->bindValue(':o4', (string)trim(strip_tags(htmlspecialchars($data['option_4']))));
		$query->bindValue(':o5', (string)trim(strip_tags(htmlspecialchars($data['option_5']))));
		$query->bindValue(':o6', (string)trim(strip_tags(htmlspecialchars($data['option_6']))));
		$query->bindValue(':s', (int) $subject_id);
		$query->bindValue(':qid', (int) $question_id);
	}else{
		$query = $db->prepare("UPDATE `questions` 
		SET 
			-- `question_img` = :qimg, 
			`question` = :q,  
			`answers` = :a,  
			`subject_id` = :s,  
			`option_1` = :o1,  
			`option_2` = :o2,  
			`option_3` = :o3,  
			`option_4` = :o4,  
			`option_5` = :o5,  
			`option_6` = :o6  
		WHERE `id` = :qid");
		// $query->bindValue(':qimg', (string)$data['image']);
		$query->bindValue(':q', (string)trim(strip_tags(htmlspecialchars($data['question']))));
		$query->bindValue(':a', (string)trim(strip_tags(htmlspecialchars($data['answers']))));
		$query->bindValue(':o1', (string)trim(strip_tags(htmlspecialchars($data['option_1']))));
		$query->bindValue(':o2', (string)trim(strip_tags(htmlspecialchars($data['option_2']))));
		$query->bindValue(':o3', (string)trim(strip_tags(htmlspecialchars($data['option_3']))));
		$query->bindValue(':o4', (string)trim(strip_tags(htmlspecialchars($data['option_4']))));
		$query->bindValue(':o5', (string)trim(strip_tags(htmlspecialchars($data['option_5']))));
		$query->bindValue(':o6', (string)trim(strip_tags(htmlspecialchars($data['option_6']))));
		$query->bindValue(':s', (int) $subject_id);
		$query->bindValue(':qid', (int) $question_id);
	}
	$query->execute();
	return $query->rowCount();
}

function createNewQuestion($db, $question_id, $subject_id, $data){
	$query = $db->prepare("INSERT INTO `questions` (`question_img`, `question`, `answers`, `subject_id`, `option_1`, `option_2`, `option_3`, `option_4`, `option_5`, `option_6`) 
		VALUES (:qimg, :q, :a, :s, :o1, :o2, :o3, :o4, :o5, :o6)");
	$query->bindValue(':qimg', (string)$data['image']);
	$query->bindValue(':q', (string)trim(strip_tags(htmlspecialchars($data['question']))));
	$query->bindValue(':a', (string)trim(strip_tags(htmlspecialchars($data['answers']))));
	$query->bindValue(':s', (int) $subject_id);
	$query->bindValue(':o1', (string)trim(strip_tags(htmlspecialchars($data['option_1']))));
	$query->bindValue(':o2', (string)trim(strip_tags(htmlspecialchars($data['option_2']))));
	$query->bindValue(':o3', (string)trim(strip_tags(htmlspecialchars($data['option_3']))));
	$query->bindValue(':o4', (string)trim(strip_tags(htmlspecialchars($data['option_4']))));
	$query->bindValue(':o5', (string)trim(strip_tags(htmlspecialchars($data['option_5']))));
	$query->bindValue(':o6', (string)trim(strip_tags(htmlspecialchars($data['option_6']))));
	// $query->bindValue(':qid', (int) $question_id);
	$query->execute();
	return $query->rowCount();
}

/**
 * Возвращает информацию о предметах
 * @param  object $db объект базы данных
 * @param  array $user_information    информация о пользователе
 * @return array     массив с данными о предметах
 */
function getSubjects($db, $user_information=[]){
	if(!empty($user_information) && $user_information["role"] == 9){
		$query = $db->prepare("SELECT * FROM `subjects`");
	}else{
		$query = $db->prepare("SELECT * FROM `subjects` WHERE `display` = :dis");
		$query->bindValue(':dis', 1);
	}
	$query->execute();
	return $query->fetchAll();
}

/**
 * Возвращает вопросы по определенному предмету
 * @param  object $db         подключение к базе данных
 * @param  int $subject_id id предмета
 * @param  array $user_information    информация о пользователе
 * @return array возвращает вопросы
 */
function getQuestionsBySubject($db, $subject_id, $user_information){
    if (!empty($user_information) && $user_information["role"] == 9) {
        $query = $db->prepare("SELECT `id`, `question_img`, `question`, `answers`, `option_1`, `option_2`, `option_3`, `option_4`, `option_5`, `option_6` FROM `questions` WHERE `subject_id` = :sid");
        $query->bindValue(':sid', (int)trim($subject_id));
		$query->execute();
		return $query->fetchAll();
    }else{
		return [];
	}
}

/**
 * Возвращает информацию о переданном вопросе
 * @param  object $db объект базы данных
 * @param  int $question_id номер предмета
 * @param  array $user_information    информация о пользователе
 * @return array     массив с данными о вопросе
 */
function getQuestionInfo($db, $question_id, $user_information=[]){
	if (!empty($user_information) && $user_information["role"] == 9) {
		$query = $db->prepare("SELECT `id`, `question_img`, `question`, `answers`, `option_1`, `option_2`, `option_3`, `option_4`, `option_5`, `option_6` FROM `questions` WHERE `id` = :qid");
		$query->bindValue(':qid', $question_id);
		$query->execute();
		return $question = $query->fetch();
	}else{
		return [];
	}
}

/**
 * Проверка на прохождение теста пользоваетлем
 * @param  object $db         подключение к базе данных
 * @param  array $user_information    информация о пользователе
 * @param  int $subject_id id олимпиады
 * @return bool             возвращает прощел(1) или не прощел(0)
 */
function statusTestForUserAndSubject($db, $user_information, $subject_id){
	if($user_information['role'] == 9){
		return 0;
	}else{
		$query = $db->prepare("SELECT * FROM `user_selected_options` WHERE `user_id` = :uid AND `subject_id` = :sid");
		$query->bindValue(':uid', (int)trim($user_information['id']));
		$query->bindValue(':sid', (int)trim($subject_id));
		$query->execute();
		$user_selected_options_info = $query->fetch();
		if(!empty($user_selected_options_info)){
			return 1;
		}else{
			return 0;
		}
	}
}

/**
 * Проверяет зополнение полей в профиле
 * @param  array $user_information инфрмация о пользователе
 * @return int возвращает 1-если профиль полностью заполнен, 0-если есть не заполненнные поля                   
 */
function checkFillingUserInformation($user_information){
	if($user_information['username'] == ''){
		return 0;
	}elseif($user_information['email'] == ''){
		return 0;
	}elseif($user_information['lastname'] == ''){
		return 0;
	}elseif($user_information['firstname'] == ''){
		return 0;
	}elseif($user_information['middlename'] == ''){
		return 0;
	}elseif($user_information['phone'] == ''){
		return 0;
	}elseif($user_information['datebirth'] == '0000-00-00'){
		return 0;
	}elseif($user_information['institution'] == ''){
		return 0;
	}elseif($user_information['сity'] == ''){
		return 0;
	}elseif($user_information['course'] == 0){
		return 0;
	}elseif($user_information['groupnumber'] == ''){
		return 0;
	}elseif($user_information['trainingdirection_type'] == ''){
		return 0;
	}else{
		return 1;
	}
}

function getPublicity($db){
	$query = $db->prepare("SELECT * FROM `publicity`");
	// $query->bindValue();
	$query->execute();
	$publicity = $query->fetchAll();
	return $publicity;
}


/**
 * Проверка на возможность загрузки картинки
 * @param array $file - загружаемый файл
 * @return bool Возвтращает сообщение об ощибке или true
 */
function can_upload($file){
	// если имя пустое, значит файл не выбран
    if($file['name'] == '')
		return [false, 'Вы не выбрали файл.'];
	
	/* если размер файла 0, значит его не пропустили настройки 
	сервера из-за того, что он слишком большой */
	if($file['size'] == 0)
		return [false, 'Файл слишком большой.'];
	
	// разбиваем имя файла по точке и получаем массив
	$getMime = explode('.', $file['name']);
	// нас интересует последний элемент массива - расширение
	$mime = strtolower(end($getMime));
	// объявим массив допустимых расширений
	$types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');
	
	// если расширение не входит в список допустимых - return
	if(!in_array($mime, $types))
		return [false, 'Недопустимый тип файла.'];
	
	return [true, 'Загрузка возможна'];
  }
  
/**
 * Загрузить картинку (после проверки функцией can_upload)
 * @param string $directory - директория в которую необходимо загрузить файл
 * @param array $file - загружаемый файл
 */
function make_upload($directory = 'mas', $file){
	$directory = '../images'.DIRECTORY_SEPARATOR.$directory;
	// cоздадим папку если её нет
	if( ! is_dir( $directory ) ) mkdir( $directory, 0777 );	
	// формируем уникальное имя картинки: случайное число и name
	$name = mt_rand(1000000, 9999999) .'.'. end(explode('.', $file['name']));
	copy($file['tmp_name'], $directory.DIRECTORY_SEPARATOR.$name);
}

/**
 * Рекурсивное создание папок
 * @param string $dirName - путь к директории (dir/dir/dir)
 * @param int $rights - права на файл
 */
function mkdir_recursive($dirName, $rights=0777){
	$dirs = explode('/', $dirName);
	$dir='';
	foreach ($dirs as $part) {
			$dir.=$part.'/';
			if (!is_dir($dir) && strlen($dir)>0)
					mkdir($dir, $rights);
	}
}

/**
 * Максимальный номер вопроса
 * @param  object $db объект базы данных
 * @return int возвращает максимальный id среди вопросов
 */
function getMaxQuestionId($db){
	// $query = $db->prepare("SELECT max(`id`) as `id` FROM `questions`");
	$query = $db->prepare("SELECT Auto_increment FROM information_schema.tables WHERE table_name=:tn AND table_schema=:ts");
	$query->bindValue(':tn', (string) "questions");
	$query->bindValue(':ts', (string) "u0689399_tests_platform");
	$query->execute();
	$max_question_id = $query->fetch();
	// print_r($max_question_id);die();
	// return $max_question_id['id']+1;
	return $max_question_id['Auto_increment'];
}

/**
 * Удаляет выбранный файл
 * @param string $path путь к удаляемому файлу
 * @return int возвращает true или false
 */
function deleteFile($path){
	// foreach ($files as $file) {
		if (file_exists($path)) {
			unlink($path);
		} else {
			return false;
		}
	// }
}

/**
 * Удаляет данные вопросе
 * @param  object $db объект базы данных
 * @param int $question_id id вопроса
 * @return int возвращает количество удаленных строк
 */
function deleteQuestionData($db, $question_id){
	$query = $db->prepare("DELETE FROM `questions` WHERE `id` = :qid ");
	$query->bindValue(':qid', (int)trim($question_id));
	$query->execute();
	return $query->rowCount();
}

/**
 * Возвращает текущее время
 */
function getNowTime(){
	date_default_timezone_set('UTC');
	$time_now = time();
	return $time_now;
}
/**
 * Получить ответы выбранные пользователем по предмету, по определенному пользователю
 * @param  object $db объект базы данных
 * @param int $user_id id вопроса
 * @param int $subject_id id вопроса
 * @return array возвращает балл, выбранные ответы, время и количество ответов
 */
function getQuestionsByUser($db, $user_id, $subject_id){
	$query = $db->prepare("SELECT `selected`, `ball`, `amount`, `start_time`, `end_time`, `time_left` FROM `user_selected_options` WHERE `user_id` = :uid AND `subject_id` = :sid");
	$query->bindValue(':uid', (int)trim($user_id));
	$query->bindValue(':sid', (int)trim($subject_id));
	$query->execute();
	$user_selected_options = $query->fetchAll();
	return $user_selected_options;
}

?>