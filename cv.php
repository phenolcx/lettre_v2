<?php
require_once(".config");
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;
// Établissement de la connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Spécifier le chemin vers le répertoire d'upload.
$uploadDirectory = "uploads/";
function logError($message)
{
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'trace.txt');
}

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
if (isset($_SESSION['user_id'])) {
    $pdf_content = "";
    $text_content = "";
    $text_prompt = "";
    $offre_content = "";
    logError("bonne session");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["pdf_file"]) && $_FILES["pdf_file"]["error"] == 0) {
            $pdf_file_path = $_FILES["pdf_file"]["tmp_name"];

            $parser = new Parser();
            $pdf = $parser->parseFile($pdf_file_path);

            foreach ($pdf->getPages() as $page) {
                $text_content .= $page->getText();
            }
            $text_content = preg_replace('/\s{2,}/', ' ', $text_content);
            $sql = "delete from cv where  id_user=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
            if (!mysqli_stmt_execute($stmt)) {
                $error = "Erreur système : Impossible d'enregistrer votre CV et/ou votre lettre de motivation pour le moment.";
                logError($error);
            }
            $sql1 = "INSERT INTO cv (cv, offres, prompt, id_user) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt, "sssi", $text_content, $offre_content, $text_prompt, $_SESSION['user_id']);
            logError("passage");
            if (!mysqli_stmt_execute($stmt)) {
                $error = "Erreur système : Impossible d'enregistrer votre CV et votre lettre de motivation pour le moment.";
                logError($error);
            }
        } else {
            $error = "Erreur de fichier : Le fichier PDF n'a pas pu être traité.";
            logError($error);
        }
    }
} else {
    logError("pas de session disponible");
}
if (isset($_FILES['pdfImage'])) {
    $imgTmpName = $_FILES['pdfImage']['tmp_name'];
    $imgType = $_FILES['pdfImage']['type'];
    $imgSize = $_FILES['pdfImage']['size'];
    $imageFileName = $_FILES['pdfImage']['name'];
    echo "laaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa" . $imageFileName;
    if ($imgType !== "image/png") {
        $error = "Le fichier n'est pas une image PNG.";
        logError($error);
        die($error);
    }

    if ($imgSize > 5 * 1024 * 1024) {
        $error = "L'image est trop volumineuse.";
        logError($error);
        die($error);
    }

    $imgName = $imageFileName;
    $imgDestination = $uploadDirectory . $imgName;

    if (!move_uploaded_file($imgTmpName, $imgDestination)) {
        $error = "Erreur lors de l'upload de l'image du PDF.";
        logError($error);
    }
} else {
    $error = "Aucun fichier image de cvvvvvvn'a été posté.";
    logError($error);
}
// Gestion de la connexion
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE email = ?";
    // 
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
            header("Location: index.php");
            exit();
        }
    } else {
        echo "Adresse e-mail non trouvée.";
    }
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/three.min.js"></script>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/html2canvas.min.js"></script>

    <!-- Template Main JS File -->
    <script src="pdfjs/build/pdf.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


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
<!-- Formulaire pour le téléchargement -->
<?php
require_once('menu.php');

if (isset($_SESSION["user_id"])) {
    $sql = "SELECT * FROM  cv where id_user =  ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $_SESSION["user_id"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        // Vérifier le mot de passe


        if ($row['cv']) {
            $_SESSION['cv'] = $row['cv'];
        }
    } else {
        echo "pas de cv encore";
    }
}
if (isset($_SESSION["user_id"])) {
    $imagecv = "uploads/" . $_SESSION["user_id"] . "_cv_image.png";
}
?>

<body>

    <!-- ======= Header ======= -->


    <!-- ======= Hero Section ======= -->
    <form method="post" enctype="multipart/form-data" action="offre.php" id="file-upload-form">

        <section id="hero" class="d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-1 order-lg-1" data-aos="fade-up">

                        <?php
                        if (isset($_SESSION["cv"]) && $_SESSION["cv"] != "") { ?>
                            <p><button id="submit" class="download-btn">Utiliser ce CV</button> <button type="button" id="cv_new">Charger un nouveau CV</button></p>
                            <img src=<?php echo $imagecv; ?> id="imagecv" width=90% alt="Proposez votre CV pour la lettre de motivation"></img><br>
                            <canvas id="pdfCanvas" width="90%" style="display:none;"></canvas>

                        <?php
                        } else { ?>
                            <p><button id="submit" style="display:none;" class="download-btn">Utiliser ce CV</button>
                                <button type="button" id="cv_new">Charger un nouveau CV</button>
                            </p>
                            <img id="imagecv" style="display:none;" width=90% alt="Proposez votre CV pour la lettre de motivation"></img><br>

                            <canvas id="pdfCanvas" width="90%"></canvas>

                        <?php
                        }
                        ?>
                        <input type="file" value="Fichier" class="cv_input" name="pdf_file" id="pdf_file" accept=".pdf" style="display:none;">
                        <textarea class="cv_input_in" name="cv_input" id="cv_input" rows="7" style="display:none;"><?php
                                                                                                                    if (isset($_SESSION['cv'])) {
                                                                                                                        echo $_SESSION['cv'];
                                                                                                                    }
                                                                                                                    ?></textarea>


                    </div>
                    <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                        <div>
                            <img src="assets/img/features.svg" class="img-fluid" alt="Lettre de motivation générateur" style="padding:15px;">
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </form>
</body>


<script>
    document.getElementById('pdf_file').addEventListener('change', function() {
        // Si vous voulez afficher le nom du fichier choisi ou faire d'autres actions après la sélection
        if (this.files[0]) {
            console.log(this.files[0].name);
        }
    });
    document.getElementById('cv_new').addEventListener('click', function() {
        document.getElementById('pdf_file').click();
    });
</script>
<script>
    const pdfInput = document.getElementById('pdf_file');
    const pdfCanvas = document.getElementById('pdfCanvas');
    const submitBtn = document.getElementById('submit');
    const imageCv = document.getElementById('imagecv');

    pdfInput.addEventListener('change', async function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = async function(ev) {
                const pdfData = ev.target.result;
                const pdf = await pdfjsLib.getDocument({
                    data: pdfData
                }).promise;
                const page = await pdf.getPage(1); // première page

                const viewport = page.getViewport({
                    scale: .7
                });
                pdfCanvas.width = viewport.width;
                pdfCanvas.height = viewport.height;
                imageCv.style.display = 'none';
                const renderContext = {
                    canvasContext: pdfCanvas.getContext('2d'),
                    viewport: viewport
                };
                await page.render(renderContext);

            };
            reader.readAsArrayBuffer(file);

            setTimeout(valider_cv, 2000);
        }
    });

    function valider_cv() {

        var canvas = document.getElementById('pdfCanvas');
        canvas.style.display='';
        // Convertir le canvas en une image PNG en base64
        var imageData = canvas.toDataURL('image/png');
        var submitBtn = document.getElementById('submit');

        // Créer un objet FormData pour l'envoyer via POST
        var formData = new FormData();
        formData.append('imageData', imageData);

        // Utiliser fetch ou XMLHttpRequest pour envoyer l'image au serveur
        fetch('ecrire_png.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error(error);
            });

        submitBtn.style.display = '';

    }
</script>

</html>