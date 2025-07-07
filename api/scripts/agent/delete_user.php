<?php

use App\Agent;

try {
    if ($_SERVER['REQUEST_METHOD'] === "POST") :

        // $data = json_decode(file_get_contents('php://input'), true);

        $code = $_POST['code'] ?? null;
        
        new Agent();
        
        Agent::deleteOne($code);
        echo json_encode([
            'status' => 'success',
            'message' => 'agent supprimer avec succès'
        ]);
    else :
        json_encode([
            'status' => 'error',
            'message' => 'Méthode non autorisé'
        ]);
        exit;
    endif;
} catch (\Throwable $th) {
    die('Erreur serveur à la suppression d\'agent'. $th->getMessage());
}