<?php

// affichage du fichier recu
// var_dump($_FILES);
// exit;

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
    header('location: inscription.php?message= Vous devez remplir les deux champs!!');
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: inscription.php?message= Adresse Email Invalide!!');
    exit;
}

if (strlen($_POST['mot_de_passe']) < 6 || strlen($_POST['mot_de_passe']) > 16) {
    header('location: inscription.php?message= Mot de passe invalide, il doit faire entre 6 et 16 caractere!!');
    exit;
}

// var_dump($_FILES);
// exit;

// verif du fichier recu ($_FILES)
if ($_FILES['image']['error'] == 0) {
    // verif du type
    $acceptable = ['image/png', 'image/jpeg', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $acceptable)) {
        header('location: inscription.php?message= Le fichier doit etre de type png ou jpeg !!');
        exit;
    }

    // verif de la taille
    $maxSize = 2 * 1024 * 1024; // 2 Mo
    if ($_FILES['image']['size'] > $maxSize) {
        header('location: inscription.php?message= Le fichier doit etre de taille inferieure a 2 mo!!');
        exit;
    }

    // crée un dossier uploads si il n'existe pas
    if (!file_exists('uploads')) {
        mkdir('uploads');
    }

    // on enregistre le fichier sur le serveur
    // tmp_name : nom de fichier temporaire
    $from = $_FILES['image']['tmp_name'];

    // profil.min.ext.png -> ['profil', 'min', 'ext', 'png']
    $array = explode('.', $_FILES['image']['name']);

    // expolde() : crée un tableau a partir du nom du fichier
    // end() :recup le dernier element du tableau

    $extension = end($array);

    // risque de doublons si deux images avec le même nom sont envoyées dans la meme seconde
    $filename = 'images-' . time() . '.' . $extension;
    $to = 'uploads/' . $filename;

    move_uploaded_file($from, $to);
}


try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=site2', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}

$q = 'SELECT id FROM users WHERE email = :email';
$req = $bdd->prepare($q);
$req->execute(['email' => $_POST['email']]);
$results = $req->fetchAll();


if (!empty($results)) {
    header('location: inscription.php?message= Adresse Email deja pris!!');
    exit;
}


// $bdd -> exec($q);

// $q ='INSERT INTO users (email, password) VALUES ("'. $_POST['email'].'", "'. $_POST['mot_de_passe'].'")';

// $q = 'INSERT INTO users (email, password) VALUES (?,?)';
// $req = $bdd -> prepare($q);

// $req -> execute([$_POST['email'], $_POST['mot_de_passe']]);

$salt = 'J4J4H5U6IR8EIE';
$mdp_salt = $_POST['mot_de_passe'] . $salt;
$mdp_hash = hash('sha256', $mdp_salt);


$q = 'INSERT INTO users (email, password, image) VALUES (:email, :password, :image)';
$req = $bdd->prepare($q);
$results = $req->execute(['email' => $_POST['email'], 'password' => $mdp_hash, 'image' => isset($filename) ? $filename : 'default.jpg']);

if (!$results) {
    header('location: inscription.php?message= Erreur lors de l\'inscription en base de données.!!');
    exit;
}

header('location: connexion.php?message= Compte crée avec succes!!');
exit;
