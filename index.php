
 <?php
        session_start();
       if (isset($_SESSION['user_id'])) { 
        
           
            header("Location: cv.php");
            exit();
            } 
    ?>
            <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Générateur de Lettres de Motivation Personnalisées | Let'Motive</title>
    <meta content="" name="description">
    <meta name="description" content="Créez rapidement et facilement des lettres de motivation personnalisées en fonction de votre CV et des offres d'emploi. Optimisez votre candidature avec Let'Motive, le générateur de lettres de motivation sur mesure qui s'appuie sur l'IA.">
    <meta name="keywords" content="lettres de motivation, générateur de lettres de motivation, CV, offre d'emploi">
    <meta name="author" content="Let'Motive">
    <meta name="robots" content="index, follow"> <!-- Permet l'indexation et le suivi par les robots -->
    <meta property="og:title" content="Générateur de Lettres de Motivation Personnalisées | Let'Motive">
    <meta property="og:description" content="Créez rapidement et facilement des lettres de motivation personnalisées en fonction de votre CV et des offres d'emploi. Optimisez votre candidature avec Let'Motive, le générateur de lettres de motivation sur mesure.">

    <meta content="lettres de motivation, générateur de lettres de motivation, CV, offre d'emploi" name="keywords"> <!-- Ajout des mots-clés ici -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<?php

require_once('menu.php');
?>

<body>
    <!-- ======= Header ======= -->

    <!-- Gestion de la déconnexion -->
    <?php

    if (isset($_POST['logout']) && isset($_SESSION['user_id'])) {
        // Détruire la session et rediriger vers la page d'accueil
        session_destroy();
        //header("Location: login.php");
        //exit();
    }
    ?>
    <!-- ======= Hero Section ======= -->

    <section id="hero" class="d-flex align-items-center">
        <?php if (!isset($_SESSION['user_id'])) { ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                        <div>
                            <h1> Votre CV + L'Offre d'Emploi = Une Lettre de Motivation Parfaite !</h1>
                            <h2>Obtenez votre Lettre de Motivation adaptée à l'offre en fonction de votre parcours et de vos atouts en 2 Clics. La Puissance de la Personnalisation</h2><br>
                            <a href="inscription.php" class="download-btn"><i class="bi bi-person-fill-check"></i>Je créé mon compte</a>
                            &nbsp;<a href="connection.php" class="download-btn"><i class="bi bi-person-fill"></i>Je me connecte</a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
                        <img src="assets/img/features.svg" class="img-fluid" alt="Lettre de motivation générateur" style="padding:15px;">
                    </div>
                </div>
            </div>
       
    </section>
<?php }?>
</body>

</html>