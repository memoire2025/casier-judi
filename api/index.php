<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// header("Content-Type: application/json");

require_once __DIR__ .'/vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

define("JWT_SECRET", "b6225498d918ac5c5f3bad651a2fc10bd06f590af1d4cb21f97d066dc7aeafc3");

function verifyJWT($token) {
    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
        return (array) $decoded; // Convertir en tableau
    } catch (Exception $e) {
        return null; // JWT invalide
    }
}

function testDebug($entre): never {
    echo json_encode(['message' => $entre]);
    exit;
}

function messageServer($statut, $message, $data = null, $total_page = null): never {
    echo json_encode(['status' => $statut, 'message' => $message, 'data' => $data, 'total_page'=> $total_page]);
    exit;
}

$requestUri = $_SERVER['REQUEST_URI'];

// Supprime les paramètres de requête, si présents
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Table de routage (URI => fichier PHP à inclure)
$routesGetMethode = [

    '/deconnexion' => __DIR__ . '/scripts/agent/deconnexion.php',

    '/get_personne' => __DIR__ . '/scripts/personne/get_personne.php',
    '/get_byCodePersonne' => __DIR__ . '/scripts/personne/get_byCode.php',
    '/search_personne' => __DIR__ . '/scripts/personne/recherche.php',
    '/get_infraction' => __DIR__ . '/scripts/infraction/get_infraction.php',
    '/get_byCodecasier' => __DIR__ . '/scripts/personne/get_byCode.php',
    '/get_personneIfraction' => __DIR__ . '/scripts/infraction/get_infractionByCodeCasier.php',
    '/search_infraction' => __DIR__ . '/scripts/infraction/recherche.php',
    '/get_agent' => __DIR__ . '/scripts/agent/get_user.php',
    '/search_agent' => __DIR__ . '/scripts/agent/search_agent',
];

$routesPostMethod = [
    '/login' => __DIR__ . '/scripts/agent/login.php',
    '/add_agent' => __DIR__ . '/scripts/agent/add_agent.php',
    '/add_personne' => __DIR__ . '/scripts/personne/add_personne.php',
    '/add_infraction' => __DIR__ . '/scripts/infraction/add_infraction.php',
    '/delete_agent' => __DIR__ . '/scripts/agent/delete_agent.php',
    
    '/refresh_token' => __DIR__ . '/scripts/refresh_token.php',
];


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if (array_key_exists($requestPath, $routesGetMethode)) {
        require $routesGetMethode[$requestPath];
    } else {
        http_response_code(404);
        echo "Page not found 404.";
    }   
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (array_key_exists($requestPath, $routesPostMethod)) {
        require $routesPostMethod[$requestPath];
    } else {
        http_response_code(404);
        echo "Page de scripts not found!";
    }
}else{
    echo "Méthode non autorisé";
}
