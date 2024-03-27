<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php $title = "Bienvenue Sur Colors";
include("includes/head.php");
?>

<body>
    <?php include("includes/header.php"); ?>
    <main>
        <h1><?= $title ?></h1>

        <?php
        if (
            isset($_GET['message']) && !empty($_GET['message'])
        ) {
            echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>


        <form action="verification_inscription.php" method="post" enctype="multipart/form-data">
            <p>Creer votre compte </p>
            <input type="email" name="email" placeholder="Votre Email" value="<?= isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>" required>
            <input type="password" name="mot_de_passe" placeholder="Votre MDP" required>
            <input type="file" name="image" accept="image/png, image/jpeg, image/gif">

            <p><button>Creation du compte</button></p>

            <p1>En vous inscrivant, vous acceptez nos <a href="condition générales">Conditions générales. </a>
                Découvrez comment nous collectons,<br> utilisons et partageons vos données en lisant
                notre <a href="pol-confi"> politique de confidentialité </a> et comment nous utilisons les cookies
                <br> autres technologies similaires en consultant notre Politique d’utilisation des cookies.
            </p1>

        </form>


    </main>

    <?php include("includes/footer.php"); ?>

</body>

</html>