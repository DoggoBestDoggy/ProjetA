<?php
$_SERVER['SERVER_NAME'];
$host = $_SERVER['SERVER_NAME'] == 'localhost' ? 'localhost:3306' : 'hoteDeProd';
$name = $_SERVER['SERVER_NAME'] == 'localhost' ? 'site2' : 'nomDeProd';
$user = $_SERVER['SERVER_NAME'] == 'localhost' ? 'root' : 'userDeProd';
$mdp = $_SERVER['SERVER_NAME'] == 'localhost' ? 'root' : 'mdpDeProd';
$attr = $_SERVER['SERVER_NAME'] == 'localhost' ? [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] : [];

try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=site2', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}
