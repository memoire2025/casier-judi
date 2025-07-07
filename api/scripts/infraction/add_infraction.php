<?php

use App\Infraction;
use App\CasierJudiciaire;

require_once __DIR__ . '/../function.php';

try {
    
        
    $code_casier = isset($_POST['code_casier']) ? securisation($_POST['code_casier']) : null;
    $type_infraction = isset($_POST['type_infraction']) ? securisation($_POST['type_infraction']) : null;
    $date_infraction = isset($_POST['date_infraction']) ? securisation($_POST['date_infraction']) : null;
    $description = isset($_POST['description']) ? securisation($_POST['description']) : null;
    $lieu = isset($_POST['lieu']) ? securisation($_POST['lieu']) : null;
    $peine = isset($_POST['peine']) ? securisation($_POST['peine']) : null;
    $duree_peine = isset($_POST['dure_pein']) ? securisation($_POST['dure_pein']) : null;
    
    if (!empty($code_casier) && !empty($type_infraction) && !empty($date_infraction) && !empty($description) && !empty($lieu) && !empty($peine) && !empty($duree_peine)) :

        $infraction_inst = new Infraction($code_casier, $type_infraction, $date_infraction, $description, $lieu, $peine, $duree_peine);
        
        if ($infraction_inst->add()) :
            
            $casier_inst = new CasierJudiciaire();

            $casier = $casier_inst->findOne($code_casier);

            if (empty($casier)) :
                echo json_encode(['status' => 'error', 'message' => 'Ce casier judiciaire n\'existe pas!']);
                exit;
            endif;

            if ($casier_inst->updateStatus($code_casier)) :
                // echo json_encode(['message' => $duree_peine]);
                // exit;
                echo json_encode([
                    'status' => 'success',
                    'message' => 'L\'infraction est ajouté avec success!'
                ]);
                exit;
            endif;

            echo json_encode(['status' => 'error', 'message' => 'Problème lors de l\'update status']);

        endif;

        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur lors de l\'insertion de l\'infraction'
        ]);
        exit;
    endif;

    echo json_encode([
        'status' => 'error',
        'message' => 'Veuillez renseiger tout le champs obligatoire'
    ]);
    exit;

} catch (\Throwable $th) {
    die('Erreur Serveur'. $th->getMessage());
}