<?php
// interdit l'acces a un utilisateur non connecter
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php $title = "Profil";
include("includes/head.php");
?>

<body>
    <?php include("includes/header.php"); ?>
    <?php include("includes/db.php"); ?>

    <?php


    $q = 'SELECT image FROM users WHERE email = :email';
    $req = $bdd->prepare($q);
    $req->execute(['email' => $_SESSION['email']]);

    $results = $req->fetch(PDO::FETCH_ASSOC);
    ?>
    <main>
        <h1>Profil</h1>
        <p>
            <label> E-mail : </label> <?= $_SESSION['email']; ?>
        </p>
        <p>
            <label> Image de Profil : </label> <img src="upload/<?= $results['image'] ?>" alt="profil">
        </p>
    </main>



    <?php include("includes/footer.php"); ?>
</body>

</html>