<?php

use App\Personne;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page -1) * $limit;

        $personne_inst = new Personne();

        $total_personne = count($personne_inst->getAll());
        $total_page = ceil($total_personne / $limit);

        $personne = $personne_inst->getJoinTablePersonne($limit, $offset);
 
        if (empty($personne)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucun casier trouvé'
            ]);
            exit;
        }
        
        echo json_encode([
            'status' => 'success',
            'message' => 'personne trouvé avec success',
            'data' => $personne,
            'total_page' => $total_page,
            'total' => $total_personne
        ]);

    }else{
        echo json_encode([
            'status' => 'error',
            'message' => 'Methode non autoriser pour recuperer les données'
        ]);
        exit;
    }
} catch (\Throwable $th) {
    die('Erreur serveur à la recuperation de données'. $th->getMessage());
}