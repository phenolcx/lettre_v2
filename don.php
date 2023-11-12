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

<body>
    <!-- ======= Header ======= -->

    <!-- Gestion de la déconnexion -->
    <?php
    require_once('menu.php');

    if (isset($_POST['logout']) && isset($_SESSION['user_id'])) {
        // Détruire la session et rediriger vers la page d'accueil
        session_destroy();
        //header("Location: login.php");
        //exit();
    }
    ?>

    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 d-lg-flex flex-lg-column align-items-center order-1 order-lg-1 hero-img" data-aos="fade-up">
                    <script async src="https://js.stripe.com/v3/buy-button.js">
                    </script>

                    <stripe-buy-button buy-button-id="buy_btn_1O7lXLExFMBhDB6cpAeC7b7I" publishable-key="pk_live_51O7l18ExFMBhDB6c4D5RFc1wyug4lT2QyxI5hFqwjwL8u5G4zuaRfQZr5wrrL9HweAVsXrA6cppQm2bHwNCDwQY5009NWMNwKf">
                    </stripe-buy-button>

                </div>
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-center pt-5 pt-lg-0 order-2 order-lg-2" data-aos="fade-up">
                    <div class="container">
                        <h2>Cher utilisateur,</h2>

                        <p>Notre mission est de vous aider à décrocher l'emploi de vos rêves en vous offrant des lettres de motivation sur mesure à laquelle, il ne reste plus qu'à ajouter la toute petite touche finale. Pour continuer à développer et améliorer notre service, nous comptons sur votre soutien financier.</p>

                        <p>Avec une contribution aussi modeste que 2€ (et vous avez également la possibilité de personnaliser le montant de votre don en cliquant sur 'modifier le montant' juste en dessous des 2€), vous pouvez jouer un rôle essentiel dans l'amélioration de notre application. Votre don nous permettra de rendre notre service encore plus performant et d'aider davantage de personnes à atteindre leurs objectifs professionnels.</p>

                        <p>En rejoignant cette aventure et en investissant dans votre propre succès professionnel, vous faites partie intégrante de notre communauté. Chaque geste compte et nous vous en sommes profondément reconnaissants.</p>

                        <p>Et si vous décrochez un emploi grâce à l'une de nos lettres de motivation, n'oubliez pas que vous pouvez toujours revenir faire un geste. Votre succès est notre plus grande récompense.</p>

                        <p>Merci pour votre soutien précieux.</p>

                        <p>L'équipe Let'Motive</p>

                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>