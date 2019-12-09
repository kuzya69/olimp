<?php
include_once('header.php');
unset($_SESSION['logged_user']);
header('location: index.php');
?>