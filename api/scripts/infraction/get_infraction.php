<?php

use App\Personne;

try {
        
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page -1) * $limit;
    
    $infraction_inst = new Personne();
    
    $infractions = $infraction_inst->getInfractionPersonne($limit, $offset);
    
    $total_infraction = count($infractions);
    
    $total_page = ceil($total_infraction / $limit);

    if (empty($infractions)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Aucun individu avec infraction trouvé trouvé',
        ]);
        exit;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Individu trouvé avec success',
        'data' => $infractions,
        'total' => $total_infraction,
        'total_page' => $total_page,
    ]);

} catch (\Throwable $th) {
    die('Erreur serveur à la recuperation de données'. $th->getMessage());
}