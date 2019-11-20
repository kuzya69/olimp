<?php
include_once('db.php');

function generete_password(){
    // Символы, которые будут использоваться в пароле.
    $chars="qazxswedcvfrtgbnhyujmkiop123456789QAZXSWEDCVFRTGBNHYUJMKOLP$&*@";
    // Количество символов в пароле.
    $max=8;
    // Определяем количество символов в $chars
    $size=StrLen($chars)-1;
    // Определяем пустую переменную, в которую и будем записывать символы.
    $password=null;
    // Создаём пароль.
        while($max--)
        $password.=$chars[rand(0,$size)];
    // Возвращаем созданный пароль.
    return $password;
}
function generate_username($n, $i){
    return $n."User1119".$i;
}
$data = [];
$i=801;
// $f=0; 
// $x=0; 
// $r=0; 
// $m=0; 
// $o=0;
for($j=0; $j<200; $j++){
    // if($j >= 0 && $j < 1000){
        $data[$j] = [
            'username'=>generate_username('o', $i), 
            'password'=>generete_password(),
            'email'=>"email-o".$i."@email.ru"
        ];
        $i++;
    // }
    // }elseif($j >= 1000 && $j < 2000){
    //     $data[$j] = [
    //         'username'=>generate_username('f', $f), 
    //         'password'=>generete_password(),
    //         'email'=>"email-f".$f."@email.ru"
    //     ];
    //     $f++;
    // }elseif($j >= 2000 && $j < 3000){
    //     $data[$j] = [
    //         'username'=>generate_username('x', $x), 
    //         'password'=>generete_password(),
    //         'email'=>"email-x".$x."@email.ru"
    //     ];
    //     $x++;
    // }elseif($j >= 3000 && $j < 4000){
    //     $data[$j] = [
    //         'username'=>generate_username('r', $r), 
    //         'password'=>generete_password(),
    //         'email'=>"email-r".$r."@email.ru"
    //     ];
    //     $r++;
    // }elseif($j >= 4000 && $j < 5000){
    //     $data[$j] = [
    //         'username'=>generate_username('m', $m), 
    //         'password'=>generete_password(),
    //         'email'=>"email-m".$m."@email.ru"
    //     ];
    //     $m++;
    // }elseif($j >= 5000 && $j < 6000){
    //     $data[$j] = [
    //         'username'=>generate_username('o', $o), 
    //         'password'=>generete_password(),
    //         'email'=>"email-o".$o."@email.ru"
    //     ];
    //     $o++;
    // }
}
// echo "<pre>";
// print_r($data);
$v = 0;
foreach($data as $val){
    echo $val['username']." : ".$val['password']." : ".$val['email']."<br>";
    $token = md5($val['username'].$val['email'].md5($val['password']).time());
    date_default_timezone_set('UTC');
    $time_now = time() + (3 * 60 * 60);

    $query = $db->prepare("INSERT INTO `users` 
    (
        `username`, 
        `email`, 
        `email_status`, 
        `token`, 
        `password`, 
        `date_create`
    ) VALUES 
    (
        :un, 
        :e, 
        :e_st,
        :token,
        :p, 
        :dcreate
    )");
    $query->bindValue(':un', (string)trim(strip_tags(htmlspecialchars($val['username']))));
    $query->bindValue(':e', (string)trim(strip_tags(htmlspecialchars($val['email']))));
    $query->bindValue(':e_st', 1);
    $query->bindValue(':token', (string)$token);
    $query->bindValue(':p', password_hash($val['password'], PASSWORD_DEFAULT));
    $query->bindValue(':dcreate', date("Y-m-d H:i:s", $time_now));
    $query->execute();
    if(
        $v == 500 || $v == 1000
    ){
        sleep(1);
    }
    $v++;
}
// echo "</pre>";
// die;
// Выводим созданный пароль.
// echo
// "<center>
// Сгенерированный пароль:
// <hr><font face=verdana color=red size=7><b>".generete_password()."</b></font><hr>
// <a href=&#63;>Создать новый пароль.</a></center>";
// die();

// $data = [['username'=>'iuser_1211190123', '']['username'=>'']]

    // $query = $db->prepare("SELECT `username` FROM `users` WHERE `username` = :un");
    // $query->bindValue(':un', $data['username']);
    // $query->execute();
    // $q_users = $query->fetchAll();
    // if(count($q_users) > 0){
    //     $errors[] = 'Пользователь с таким логином существует!';
    // }else{
    //     $query = $db->prepare("SELECT `email` FROM `users` WHERE `email` = :e");
    //     $query->bindValue(':e', $data['email']);
    //     $query->execute();
    //     $q_users = $query->fetchAll();
    //     if(count($q_users) > 0){
    //         // print_r($q_users);
    //         $errors[] = 'Пользователь с таким емаилом существует!';
    //     }
    // }
    // unset($query);

    // if(empty($errors)){
        // $token = md5($val['username'].$val['email'].md5($val['password']).time());
        // date_default_timezone_set('UTC');
        // $time_now = time() + (3 * 60 * 60);

        // $query = $db->prepare("INSERT INTO `users` 
        // (
        //     `username`, 
        //     `email`, 
        //     `email_status`, 
        //     `token`, 
        //     `password`, 
        //     `date_create`
        // ) VALUES 
        // (
        //     :un, 
        //     :e, 
        //     :e_st,
        //     :token,
        //     :p, 
        //     :dcreate
        // )");
        // $query->bindValue(':un', (string)trim(strip_tags(htmlspecialchars($val['username']))));
        // $query->bindValue(':e', (string)trim(strip_tags(htmlspecialchars($val['email']))));
        // $query->bindValue(':e_st', 1);
        // $query->bindValue(':token', (string)$token);
        // $query->bindValue(':p', password_hash($val['password'], PASSWORD_DEFAULT));
        // $query->bindValue(':dcreate', date("Y-m-d H:i:s", $time_now));
        // $query->execute();
    // }   
?>