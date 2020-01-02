<?php
session_start();
include_once('../db.php');
include_once('../library.php');

// print_r(getMaxQuestionId($db));
const IMAGES_DIR = '..'.DIRECTORY_SEPARATOR.'images'; // папка c шаблонами

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'u'){
    $subject_id = $_REQUEST['sid'];
    $question_id = $_REQUEST['qid'];
    
    //путь к файлам шаблона
    $images_dir = IMAGES_DIR.DIRECTORY_SEPARATOR.$subject_id;
    // print_r($_FILES);exit();
    // Проверяем установлен ли массив файлов и массив с переданными данными
    if(isset($_FILES) && isset($_FILES['question-edit-image'])) {
    //    print_r($_FILES['question-edit-image']['error']);exit();
        if (0 < $_FILES['question-edit-image']['error'] && (1 == $_FILES['question-edit-image']['error'] || 2 == $_FILES['question-edit-image']['error'])){
            echo 'error_file_maxsize';exit();
        }
        if (0 < $_FILES['question-edit-image']['error'] && 4 == $_FILES['question-edit-image']['error']){
            echo 'error_file_check';exit();
        }
        if (0 < $_FILES['question-edit-image']['error']){
            echo 'error';exit();
        }
        
        //Переданный массив сохраняем в переменной
        $image = $_FILES['question-edit-image'];
      
        // Проверяем размер файла и если он превышает заданный размер
        // завершаем выполнение скрипта и выводим ошибку
        if ($image['size'] > 5000000) {
            exit('error');
        }
     
        // Достаем формат изображения
        $imageFormat = explode('.', $image['name']);
        if($imageFormat[1] == 'jpg'){
            $imageFormat = $imageFormat[1];
        }
        else{
            $imageFormat = 'jpg';
        }
     
        //Генерация названия файла
        $file = $subject_id.'_'.$question_id;
      
        //рекурсивное создание указанной директории
        mkdir_recursive($images_dir);
    
        // Генерируем новое имя для изображения. Можно сохранить и со старым
        // но это не рекомендуется делать
        $imageFullName = $images_dir.DIRECTORY_SEPARATOR.$file.'.'.$imageFormat;
     
        // Сохраняем тип изображения в переменную
        $imageType = $image['type'];
     
        // Сверяем доступные форматы изображений, если изображение соответствует,
        // копируем изображение в папку images
        if ($imageType == 'image/jpeg') {
            if (move_uploaded_file($image['tmp_name'], $imageFullName)) {
                echo 'success-'.$question_id;
            } else {
                echo 'error';
            }
        }else{
            echo 'error_type';
        }
    }else{
        echo "error_file_check";
    }
}elseif(isset($_REQUEST['type']) && $_REQUEST['type'] == 's'){
    $subject_id = $_REQUEST['sid'];
    $question_id = $_REQUEST['qid'];
    
    print_r($_REQUEST);
    //путь к файлам шаблона
    $images_dir = IMAGES_DIR.DIRECTORY_SEPARATOR.$subject_id;
    
    // Проверяем установлен ли массив файлов и массив с переданными данными
    if(isset($_FILES) && isset($_FILES['question-create-image'])) {
    //    print_r($_FILES['question-create-image']['error']);exit();
        if (0 < $_FILES['question-create-image']['error'] && (1 == $_FILES['question-create-image']['error'] || 2 == $_FILES['question-create-image']['error'])){
            echo 'error_file_maxsize';exit();
        }
        if (0 < $_FILES['question-create-image']['error'] && 4 == $_FILES['question-create-image']['error']){
            echo 'error_file_check';exit();
        }
        if (0 < $_FILES['question-create-image']['error']){
            echo 'error';exit();
        }
        
        //Переданный массив сохраняем в переменной
        $image = $_FILES['question-create-image'];
      
        // Проверяем размер файла и если он превышает заданный размер
        // завершаем выполнение скрипта и выводим ошибку
        if ($image['size'] > 5000000) {
            exit('error');
        }
     
        // Достаем формат изображения
        $imageFormat = explode('.', $image['name']);
        if($imageFormat[1] == 'jpg' || $imageFormat[1] == 'png'){
            $imageFormat = $imageFormat[1];
        }
        else{
            $imageFormat = 'jpg';
        }
     
        //Генерация названия файла
        $file = $subject_id.'_'.$question_id;
      
        //рекурсивное создание указанной директории
        mkdir_recursive($images_dir);
    
        // Генерируем новое имя для изображения. Можно сохранить и со старым
        // но это не рекомендуется делать
        $imageFullName = $images_dir.DIRECTORY_SEPARATOR.$file.'.'.$imageFormat;
     
        // Сохраняем тип изображения в переменную
        $imageType = $image['type'];
     
        // Сверяем доступные форматы изображений, если изображение соответствует,
        // копируем изображение в папку images
        if ($imageType == 'image/jpeg' || $imageType == 'image/png') {
            if (move_uploaded_file($image['tmp_name'], $imageFullName)) {
                echo 'success-'.$question_id;
            } else {
                echo 'error';
            }
        }else{
            echo 'error_type';
        }
    }else{
        echo "error_file_check";
    }
}else{
    echo "delete";
}

/**
 * Сохраняет картинку в указанную директорию
 */
function updateAndSaveImage(){

}

/**
 * Генерирует новое имя файла которого нет в директории с указанным расширением
 * @param string $directory путь к директорим
 * @param string $extention расширение файла
 * @return int количество файлов | 0
 */
function genFileName($dir_id, $file_id, $extention){ 
    // $dir = (string)$dir_id;
    // $file = (string)$file_id;
    // $ex = (string)$extention;
    // $file_name = [];
    // if(is_dir($dir)){
    //     if ($handle = opendir($dir)) {
    //         while (false !== ($entry = readdir($handle))) {
    //             if(false !== ($name = strstr($entry, $ex, true))){
    //                 $file_name[] = $name;
    //             }
    //         }
    //         closedir($handle);
    //         $file = rand(100000000, 999999999);
    //         foreach($file_name as $name){
    //             if((int)$name == $file){
    //                 $file = rand(100000000, 999999999);
    //             }
    //         }
    //         return $file;
    //     }
    // }
    // return 0;
}