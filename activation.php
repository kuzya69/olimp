<?php
include_once('db.php');
include_once('library.php');

$token = $_GET['code'];
print_r($_GET);
echo "<br>";

$query = $db->prepare("SELECT * FROM `users` WHERE `token` = :token AND `email_status` = :es");
$query->bindValue(':token', (string)trim(strip_tags(htmlspecialchars($token))));
$query->bindValue(':es', 0);
$query->execute();
$q_users = $query->fetchAll();

print_r($q_users);
echo "<br>";
if(!empty($q_users)){
	$query = $db->prepare("UPDATE `users` SET `email_status` = :es WHERE `token` = :token");
	$query->bindValue(':token', (string)trim(strip_tags(htmlspecialchars($token))));
	$query->bindValue(':es', 1);
	$query->execute();
	$cs_q = $query->rowCount();
	if($cs_q > 0){
		// echo "Аккаунт успешно активирован";
		// $_SESSION['message_type'] = 'success';
		// $_SESSION['message'] = "Аккаунт успешно активирован!";
		setAlertMessage("Аккаунт успешно активирован!", "success");
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: ../login.php');
		exit();
	}else{
		echo "Возможно этот аккаунт уже был активирован или не верный код активации!";	
	}
}else{
	echo "Возможно этот аккаунт уже был активирован или не верный код активации!";
}
// print_r($q_users);
?>