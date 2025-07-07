<?php

use App\Rapport;

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page -1) * $limit;

        $rapport_inst = new Rapport();

        $total_rapport = count($rapport_inst->getAll());

        $rapport = $rapport_inst->getPaginate($limit, $offset);
        if (empty($rapport)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aucun Rapport trouvé'
            ]);
            exit;
        }
        $role_session = $_SESSION['police']['role'];
        echo json_encode([
            'status' => 'success',
            'message' => 'rapport trouvé avec success',
            'data' => $rapport,
            'total' => $total_rapport,
            'session' => $role_session
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