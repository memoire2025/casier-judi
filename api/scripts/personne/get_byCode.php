<?php

use App\Personne;

try {
        
    $code_personne = isset($_GET['code']) ? $_GET['code'] : null;

    $personne_inst = new Personne();

    $personne = $personne_inst->getJoinPersCasByCode($code_personne);
    // echo json_encode(['message' => $code_personne]);
    // exit;
    if (empty($personne)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Aucune personne trouvé'
        ]);
        exit;
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => 'personne trouvé avec success',
        'data' => $personne
    ]);

} catch (\Throwable $th) {
    die('Erreur serveur à la recuperation de données'. $th->getMessage());
}