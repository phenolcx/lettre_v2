<?php
require_once('.config');
//session_start();
// Vérifiez si l'utilisateur est déjà connecté, redirigez-le s'il l'est
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}

// Traitement de l'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if (!$conn) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash du mot de passe

    // Vérifiez d'abord si l'adresse e-mail existe déjà
    $sql_check = "SELECT email FROM user WHERE email = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        // L'adresse e-mail existe déjà, vous pouvez afficher un message d'erreur
        $compte_existant="Cette adresse e-mail est déjà utilisée.";
        echo "<p class='erreur' align='center'><br>Cette adresse e-mail est déjà utilisée. Merci de vous connecter.<br><br><a href='connection.php' id='customButton' ><i class='bi bi-plugin'></i> Je me connecte</a><a href='index.php' id='customButton' ><i class='bi bi-plugin'></i> Fermer</a><br><br><br></p>";
                
    } else {
        // L'adresse e-mail n'existe pas encore, procédez à l'insertion
        $sql_insert = "INSERT INTO user (email, password, is_verified, roles) VALUES (?, ?, 0, '[]')";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "ss", $email, $password);

        if (mysqli_stmt_execute($stmt_insert)) {
            // Générez un jeton d'activation
            $token = bin2hex(random_bytes(32));

            // Stockez le jeton d'activation dans la base de données
            $sql_update = "UPDATE user SET activation_token = ? WHERE email = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "ss", $token, $email);
            mysqli_stmt_execute($stmt_update);
            // Fermez les déclarations
            mysqli_stmt_close($stmt_check);
            mysqli_stmt_close($stmt_insert);
            mysqli_stmt_close($stmt_update);
            // Adresse e-mail de retour (Return-Path)
            // En-têtes de l'e-mail
            $headers = "From: $return_path\r\n";
            $headers .= "Reply-To: $return_path\r\n";
            $headers .= "Return-Path: $return_path\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // Envoyez un email de confirmation à l'utilisateur avec le lien d'activation
            $subject = "Confirmez votre compte";
            $message = "Cliquez sur le lien suivant pour activer votre compte : http://localhost/activate.php?token=$token";

            // Utilisez l'adresse de retour dans la fonction mail()
            mail($email, $subject, $message, $headers);
        } else {
            // Une erreur s'est produite lors de l'insertion
            echo "Une erreur s'est produite lors de la création du compte.";
        }
    }

   

    // Fermeture de la connexion à la base de données
    mysqli_close($conn);


    
}
?>

<!DOCTYPE html>
<html>
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
<link href="style.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">

<head>
    <title>Inscription</title>
    <!-- Inclure les fichiers CSS ou Bootstrap ici -->
</head>

<body>
    <!-- ======= Header ======= -->
   
    <!-- Gestion de la déconnexion -->
    <?php
    require_once('menu.php');
    if (isset($_POST['logout'])) {
        // Détruire la session et rediriger vers la page d'accueil
        session_destroy();
        //header("Location: login.php");
        //exit();
    }
    ?>
    <!-- ======= Hero Section ======= -->
    <div class="container d-flex align-items-center justify-content-between">
        <section id="hero" class="d-flex align-items-center">
            <div>
                <div class="row">
                    <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                      Mon compte 
                    </div>
                    <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
                        
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>