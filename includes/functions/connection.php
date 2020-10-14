<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$bd = 'admintasks';

//Se puede usar PDO en vez de:
$conn = new mysqli($host, $user, $pass, $bd);
$conn->set_charset('utf8');

// echo '<pre>';
// var_dump($conn);
// var_dump($conn->ping());
// echo '</pre>';

if ($conn->connect_error) {
    echo $conn->connect_error;
}