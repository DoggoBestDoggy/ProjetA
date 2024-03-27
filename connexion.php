<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php $title = "Colors Connexion";
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

        <form action="verification.php" method="post">
            <input type="email" name="email" placeholder="Votre Email" value="<?= isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>">
            <input type="password" name="mot_de_passe" placeholder="Votre MDP">
            <input type="submit" value="Connexion">

        </form>


    </main>
    <?php include("includes/footer.php"); ?>

</body>

</html>