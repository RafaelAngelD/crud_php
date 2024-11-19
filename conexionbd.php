<?php 
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'crud_php';
$puerto = '3306';

//Conexion a MySql con PDO
try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND=> "SET NAMES utf8") );   
    } catch (PDOException $e) {
      die('Connection Failed: ' . $e->getMessage());
    }