<header class="d-flex justify-content-center align-items-start" style="height: 100vh;">
    <div class="container text-center">
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Accueil</a>
                </li>
                <?php if (!isset($_SESSION['email'])) {
                    echo '<li class="nav-item">
                <a href="connexion.php" class="nav-link">Connexion</a>
            </li> ';
                    echo '<li class="nav-item">
                <a href="inscription.php" class="nav-link">inscription</a>
            </li> ';
                } else {
                    echo '<li class="nav-item">
                <a href="profile.php" class="nav-link">profil</a>
            </li>';
                    echo '<li class="nav-item">
                <a href="deconnexion.php" class="nav-link">Deconnexion</a>
            </li>';
                }

                ?>
            </ul>
        </nav>
    </div>
</header>