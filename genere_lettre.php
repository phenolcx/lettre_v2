<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Let'Motive - L'application qui génère une lettre de motivation sur mesure en fonction de ton CV et de l'offre de
        l'entreprise - Accueil</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/110/three.min.js"></script>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

</head>
<?php

require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;


require_once(".config");

// Établissement de la connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

?>

<body>
    <!-- ======= Header ======= -->
    <div id="animation-container"></div>

    <?php
    if (isset($_SESSION['user_id'])) {

        $pdf_content = "";
        $text_content = "";
        $offre_content = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Vérifie si le fichier PDF a été correctement envoyé
            if (isset($_FILES["pdf_file"]) && $_FILES["pdf_file"]["error"] == 0) {
                // Stocke le chemin du fichier PDF temporaire
                $pdf_file_path = $_FILES["pdf_file"]["tmp_name"];

                // Utilise PDFParser pour extraire le texte du PDF
                $parser = new Parser();
                $pdf    = $parser->parseFile($pdf_file_path);

                // Récupérer le texte de chaque page du PDF
                foreach ($pdf->getPages() as $page) {
                    $text_content .= $page->getText();
                }
            } else {
                echo "<p class='erreur'>Erreur système : Impossible d'enregistrer votre CV et votre lettre de motivation pour le moment. Nous nous excusons pour ce désagrément. Veuillez réessayer ultérieurement ou contacter notre support technique pour obtenir de l'aide. Nous sommes là pour résoudre ce problème rapidement et assurer la sécurité de vos données..</p>";
            }
 echo "cv:                ".$text_content;
            // Récupère le texte envoyé via le formulaire
            if (isset($_POST["text_input"])) {
                $offre_content .= $_POST["text_input"];
                $text_content = preg_replace('/\s{2,}/', ' ', $text_content);
                $text_prompt = "a partir de ce cv :" . $text_content . " et de cette offre d'emploi " . $offre_content . " merci de me rédiger la lettre de motivation la plus adaptée en tenant de l'offre et en s'appuyant sur le cv";
                ////////////////////////////////////////////////////
                //  Insertion CV et Offre dans la base de données
                ////////////////////////////////////////////////////
                $sql = "INSERT INTO cv (cv, offres,prompt,id_user) VALUES (?,?,?,?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssi", $text_content, $offre_content, $text_prompt, $_SESSION['user_id']);

                if (mysqli_stmt_execute($stmt)) {
                    //echo "<p class='erreur'>Erreur système : Impossible d'enregistrer votre CV et votre lettre de motivation pour le moment. Nous nous excusons pour ce désagrément. Veuillez réessayer ultérieurement ou contacter notre support technique pour obtenir de l'aide. Nous sommes là pour résoudre ce problème rapidement et assurer la sécurité de vos données..</p>";
                    require_once("reponse_ia.php");
                    //$lettre= $text_prompt;
                } else {
                    echo "<p class='erreur'>Erreur système : Impossible d'enregistrer votre CV et votre lettre de motivation pour le moment. Nous nous excusons pour ce désagrément. Veuillez réessayer ultérieurement ou contacter notre support technique pour obtenir de l'aide. Nous sommes là pour résoudre ce problème rapidement et assurer la sécurité de vos données..</p>";
                }
            } else {
                //echo "Erreur : Aucun texte n'a été envoyé.";
            }
        }
    }
    require_once('menu.php');
    ?>
    <!-- ======= Hero Section ======= -->
    <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="file-upload-form">
        <section id="hero" class="d-flex align-items-center">
            <div class="container">
                <center>
                    <?php echo $lettre; ?>
                </center>
            </div>
            <div class="container">
                <center>
                    <button class="download-btn" type="submit"><i class="bi bi-plugin"></i></i> Générer ma lettre <br>de motivation</button>
                </center>
            </div>
        </section>
    </form>
</body>
<!-- Vendor JS Files -->
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script>
    document.getElementById('customButton').addEventListener('click', function() {
        document.getElementById('pdf_file').click();
    });

    document.getElementById('pdf_file').addEventListener('change', function() {
        // Si vous voulez afficher le nom du fichier choisi ou faire d'autres actions après la sélection
        if (this.files[0]) {
            console.log(this.files[0].name);
        }
    });
</script>

</html>