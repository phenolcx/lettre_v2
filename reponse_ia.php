<?php
$api_key = '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'; // Remplacez par votre clé d'API ChatGPT

// Données de la requête
// Données de la requête
// Données de la requête
// Données de la requête
$payload = array(
    'messages' => array(
        array('role' => 'system', 'content' => 'Tu es un expert en rh, spécialiste des lettres de motivation.'),
        array('role' => 'user', 'content' => $text_prompt),
    ),
    'temperature' => 0.7,
    'max_tokens' => 1500,
    'model' => 'gpt-3.5-turbo' // Spécifiez le modèle GPT-3.5 Turbo ici
);

// ...


// ...


// Configuration de l'en-tête de la requête
$headers = array(
    'Authorization: Bearer ' . $api_key,
    'Content-Type: application/json'
);

// Initialisation de cURL
$ch = curl_init('https://api.openai.com/v1/chat/completions'); // Utilisez le point de terminaison chat/completions

// Configuration de la requête cURL
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Exécution de la requête
$response = curl_exec($ch);

// Gestion des erreurs
if (curl_errno($ch)) {
    echo 'Erreur cURL : ' . curl_error($ch);
} else {
    // Traitement de la réponse
    $response_json = json_decode($response, true);
    if (isset($response_json['choices'][0]['message']['content'])) {
        // Affichez la réponse générée
        $lettre = $response_json['choices'][0]['message']['content'];
        $file_path = 'lettre.txt';
        file_put_contents($file_path, $lettre);

        // Affichez la réponse
        //cho $lettre;
    } else {
        echo 'Aucune réponse n\'a été générée.';
        print_r($response_json);
    }
}

// Fermez la session cURL
curl_close($ch);

?>