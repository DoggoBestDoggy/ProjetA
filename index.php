<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php $title = "Accueil";
include("includes/head.php");
?>

<body>
    <?php include("includes/header.php"); ?>

    <main class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container text-center">
            <h1><?= $title ?></h1>
            <?php include('includes/message.php'); ?>
            <div>
                <p>
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo 'Voici votre contenu privé';
                    } else {
                        echo 'Contenu non disponible';
                    }
                    ?>
                </p>
            </div>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>

</body>

</html>