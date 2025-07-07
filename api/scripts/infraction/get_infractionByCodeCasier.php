<?php

use App\Infraction;

try {

    $code_casier = isset($_GET['code']) ? $_GET['code'] : null;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page -1) * $limit;

    $infraction_inst = new Infraction();

    $infraction = $infraction_inst->getInfractionByCode($code_casier);

    $total_infraction = count($infraction);
    $total_page = ceil($total_infraction / $limit);
    
    if (empty($infraction)) {
        messageServer("error", "Aucune infraction trouvé pour cette individu");
    }
    
    messageServer("success","infraction trouvé avec success pour cette infraction", $infraction, $total_page);

} catch (\Throwable $th) {
    die('Erreur serveur à la recuperation de données'. $th->getMessage());
}