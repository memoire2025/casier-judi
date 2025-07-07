<?php

use App\Agent;

try {
        
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page -1) * $limit;

    new Agent();
    
    $total_user = count(Agent::getAll());
    $total_page = ceil($total_user / $limit);

    $user = Agent::getPaginate($limit, $offset);
    if (empty($user)) {
        messageServer('error', 'Aucun user trouvé');
    }
    
    messageServer('success','user trouvé avec success', $user, $total_page);

} catch (\Throwable $th) {
    die('Erreur serveur à la recuperation de données'. $th->getMessage());
}