<header id="header" class="fixed-top header-transparent">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <div class="container d-flex align-items-center justify-content-between">
        <div>
            <h1><a href="index.php">Let' Motive</a></h1>
        </div>
        <button class="mobile-nav-toggle bi-list" id="mobileNavToggle">Menu</button>
        <nav id="navbar">

            <ul>
                <li><a class="nav-link scrollto active" href="index.php">Accueil</a></li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                <li>
                    <form method="post" action="formulaire.php" id="form_logout">
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <input type="hidden" id="hiddenInput" name="logout" value="">
                            <button type="submit" class="nav-link scrollto btn-logout">Déconnexion<i class="bi bi-box-arrow-in-left"></i></button>
                        <?php
                        } else {
                        ?>
                            <a class="nav-link scrollto" href="connection.php">Connexion<i class="bi bi-box-arrow-in-left"></i></a>
                        <?php
                        }
                        ?>
                    </form>

                </li>
                <li>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a class="nav-link scrollto" href="moncompte.php">Mon compte<i class="bi bi-box-arrow-in-left"></i></a>
                    <?php
                    }
                    ?>
                </li>
                <li><a class="nav-link scrollto" href="don.php" style="background-color: #5777ba; font-size:12px;;color: white;margin-left:15px;border-radius: 8px;padding:8px;">Faire un don</a></li>

            </ul>
        </nav>
    </div>

</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var navToggle = document.querySelector('.mobile-nav-toggle');
        var navbar = document.getElementById('navbar');

        navToggle.addEventListener('click', function() {
            navbar.classList.toggle('navbar-mobile');

            if (navToggle.classList.contains('bi-list')) {
                navToggle.classList.remove('bi-list');
                navToggle.classList.add('bi-x');
            } else {
                navToggle.classList.remove('bi-x');
                navToggle.classList.add('bi-list');
            }
        });

        // Masquer le menu après avoir cliqué sur un lien, uniquement pour les petits écrans
        document.querySelectorAll('#navbar a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 767) {
                    navbar.classList.remove('navbar-mobile');
                    navToggle.classList.remove('bi-x');
                    navToggle.classList.add('bi-list');
                }
            });
        });
    });
</script>