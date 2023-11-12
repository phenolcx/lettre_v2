<?php
session_start();
if (isset($_POST['imageData'])) {
// Extrait les données de l'image
$imageData = $_POST['imageData'];
// Supprimer l'en-tête de données URL (partie `data:image/png;base64,`)
$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = str_replace(' ', '+', $imageData);
// Convertir base64 en données binaires
$imageData = base64_decode($imageData);
// Définir le chemin de destination de l'image
$filePath = 'uploads/' .$_SESSION["user_id"].'_cv_image.png';
// Écrire les données binaires dans le fichier
file_put_contents($filePath, $imageData);
}
?>