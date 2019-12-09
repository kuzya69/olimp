<?php
include_once('db.php');

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$subject = "SELECT name, description FROM lectures WHERE subject_id = ".$id;

	echo "ok";
}
?>