<?php

    use App\Rapport;
    
    require_once __DIR__ . '/../function.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') :


        $date = securisation($_POST['date']);
        $contenu = securisation($_POST['contenu']);
        $num_matricul = securisation($_POST['matricul']);
        $code_intervention = securisation($_POST['code_intervention']);
        
        if (isset($date) && isset($contenu) && isset($num_matricul) && isset($code_intervention)) :
            if (!empty($date) && !empty($contenu) && !empty($num_matricul) && !empty($code_intervention)) :
                
                    
                new Rapport($date = null, $contenu = null, $num_matricul = null, $code_intervention);

                if ($exist_user = Rapport::existRapport()) :
                    echo json_encode(['status' => 'error', 'message' => 'Le Rapport avec cet e-mail existe déjà!']);
                    exit;
                endif;

                if (Rapport::createRapport()) :
                    echo json_encode(['status' => 'success', 'message' => 'Rapport enregistré avec succès!']);
                    exit;
                else :
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement!']);
                    exit;
                endif;
                    
                
            else :
                echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs obligatoires!']);
                exit;
            endif;
        else :
            echo json_encode(['status' => 'error', 'message' => 'Clès non existante!']);
            exit;
        endif;
    endif;
?>