<?php

use App\Personne;

require_once __DIR__ . '/../function.php';

try {
    
    $r = isset($_GET['r']) ? securisation($_GET['r']) : null;

    if (empty($r)) :
        echo json_encode(['status' => 'error', 'message', 'Champs obligatoire!']);
        exit;
    endif;

    $police_int = new Personne();

    if (empty($resultat = $police_int->searchOne($r))) :
        echo json_encode(['status' => 'error', 'message' => 'Aucun résultat trouvé!']);
        exit;
    endif;

    echo json_encode(['status' => 'success', 'message' => 'Résultat trouvé', 'data' => $resultat]);

} catch (\Throwable $th) {
    throw $th;
}