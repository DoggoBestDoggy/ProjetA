<?php

function writeLogLine($success, $email)
{

    $log = fopen('log.txt', 'a+');

    $line = date('T/m/d - H:i:s') . ' - Tentative de connexion ' . ($success ? 'reussi' : 'echoué') . ' de : ' . $email . "\r";

    fputs($log, $line);

    fclose($log);
}



// si un email a ete envoyer et que cet email n'est pas vide, alors crée un cookie contenant cet email et qui dure 30j
if (isset($_POST["email"]) && !empty($_POST["email"])) {
    setcookie('email', $_POST["email"], time() + 30 + 24 + 3600);
}

// si email ou password sont vide alors redirection vers le formulaire avec un msg d'erreur
if (
    !isset($_POST['email'])
    || empty($_POST['email'])
    || !isset($_POST['mot_de_passe'])
    || empty($_POST['mot_de_passe'])
) {
    header('location: connexion.php?message= Vous devez remplir les deux champs !!');
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: connexion.php?message= Adresse Email Invalide !!');
    exit;
}

try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=site2', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die('ERREUR : ' . $e->getMessage());
}

$q = 'SELECT id FROM users WHERE email = :email AND password = :password';

$req = $bdd->prepare($q);

$salt = 'J4J4H5U6IR8EIE';
$mdp_salt = $_POST['mot_de_passe'] . $salt;
$mdp_hash = hash('sha256', $mdp_salt);

$req->execute(['email' => $_POST['email'], 'password' => $mdp_hash]);

$results = $req->fetchAll();

if (!empty($results)) {
    header('location: connexion.php?message= Identifiant Incorrect !!');
    exit;
}

writeLogLine(true, $_POST['email']);

session_start();

$_SESSION['email'] = $_POST['email'];
header('location: profile.php');
exit;
