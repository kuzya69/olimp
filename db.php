<?php
$host = 'localhost';
$database = 'tests_platform';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$database;";
$options = array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try {
    $db = new PDO($dsn, $user, $pass, $options);
    $db->exec('set names utf8');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}