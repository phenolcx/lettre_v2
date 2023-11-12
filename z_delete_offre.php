<?php
require_once(".config");
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;
// Établissement de la connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}
// Fonction pour hacher le mot de passe
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fonction pour vérifier le mot de passe haché
function verifyPassword($password, $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}
// Initialisation des variables pour éviter les erreurs de variable non définie
$offre_content = "";
$text_content = "";

// Gestion de la connexion
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Vérifier le mot de passe

        if (verifyPassword($password, $row['password'])) {
            // Mot de passe correct, créer une session et rediriger vers la page d'accueil
            $_SESSION['user_id'] = $row['id'];
            session_regenerate_id(true);
        } else {
            echo "Mot de passe incorrect.";
            echo $row['password'];
        }
    } else {
        echo "Adresse e-mail non trouvée.";
    }
}

// Gestion de l'inscription
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier si l'adresse e-mail existe déjà dans la base de données
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<div>Cette adresse e-mail est déjà utilisée.</div>";
    } else {
        // Insérer le nouvel utilisateur dans la base de données
        $hashedPassword = hashPassword($password);
        $sql = "INSERT INTO user (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
        if (mysqli_stmt_execute($stmt)) {
            echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }
}
//session_start();
?>
<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
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


?>

<body>
    <!-- ======= Header ======= -->

    <?php
    require_once('menu.php');
    ?>
    <!-- ======= Hero Section ======= -->
    <form method="post" enctype="multipart/form-data" action="genere_lettre.php" id="file-upload-form">
        <section id="hero" class="d-flex align-items-center">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                        <div>
                            <div class="container mt-5">

                                <div class="cv-input">
                                    <div class="form-group">
                                        <div class="file-container">
                                            <button type="button" id="customButton">Charger un nouveau CV</button>
                                            <input type="file" value="Fichier" class="offre_input" name="pdf_file" id="pdf_file" accept=".pdf" required style="display: none;">
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                        <div>
                            <div class="container mt-5">

                                <div class="cv-input">
                                    <div class="form-group">
                                        <div class="file-container">
                                            <button type="button" id="customButton">Utiliser mon cv enregistré</button>
                                            <input type="file" value="Fichier" class="offre_input" name="pdf_file" id="pdf_file" accept=".pdf" required style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
</section>
    </form>
</body>

<script>
    document.getElementById('monBouton').addEventListener('click', function() {
        // Afficher le spinner
        $('.loading-spinner').show();
    });
    document.getElementById('customButton').addEventListener('click', function() {
        document.getElementById('pdf_file').click();
    });

    document.getElementById('pdf_file').addEventListener('change', function() {
        // Si vous voulez afficher le nom du fichier choisi ou faire d'autres actions après la sélection
        if (this.files[0]) {
            console.log(this.files[0].name);
        }
    });

    // Afficher l'animation d'attente lorsque l'utilisateur clique
</script>

</html>