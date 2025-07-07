<?php

require_once __DIR__ . '/../function.php';

use App\Personne;
use App\CasierJudiciaire;

try {
        
    $nom = isset($_POST['nom']) ? securisation($_POST['nom']) : "";
    $postnom = isset($_POST['postnom']) ? securisation($_POST['postnom']) : "";
    $prenom = isset($_POST['prenom']) ? securisation($_POST['prenom']) : "";
    $date_naissance = isset($_POST['date_naissance']) ? securisation($_POST['date_naissance']) : "";
    $lieu = isset($_POST['lieu']) ? securisation($_POST['lieu']) : "";
    $nationalite = isset($_POST['nationalite']) ? securisation($_POST['nationalite']) : "";
    $sexe = isset($_POST['sexe']) ? securisation($_POST['sexe']) : "";
    $num_identite = isset($_POST['num_identite']) ? securisation($_POST['num_identite']) : "";
    
    if (isset($_FILES['img'])) :
        // Traitement fichier img
        $fichier = $_FILES['img'];
        
        $nom_fichier = $fichier['name'];
        
        $fileExtension = pathinfo($nom_fichier, PATHINFO_EXTENSION);
        
        $newFileName = 'GST_'. time() . '.' . $fileExtension;
        
        $nom_temp = $_FILES['img']['tmp_name'];
        
        $emplacement = __DIR__ . '/../../ressources/img/personne/'.$newFileName;
        
        $img = 'http://casier-judiciaire.com/ressources/img/personne/'.$newFileName;
        
    else :
        echo json_encode(['status' => 'error', 'message' => 'Aucun fichier envoyé!']);
        exit;
    endif;
    
    if (!empty($nom) && !empty($postnom) && !empty($prenom) && !empty($date_naissance) && !empty($lieu) && !empty($nationalite) && !empty($sexe) && !empty($num_identite)) :

        $personne_inst = new Personne($nom, $postnom, $prenom, $date_naissance, $lieu, $sexe, $nationalite, $num_identite, $img);

        if ($personne_inst->exist()) :
            echo json_encode([
                'status' => 'error',
                'message' => 'Le personne renseigné existe déjà'
            ]);
            exit;
        endif;
        
        if (preg_match('/(.jpg)$/i', $newFileName) || preg_match('/(.jpeg)$/i', $newFileName) || preg_match('/(.png)$/i', $newFileName)) :
            
            if (move_uploaded_file($nom_temp, $emplacement)) :
                
                if ($personne = $personne_inst->add()) :
                    
                    $code_personne = $personne['code'];

                    $status_casier = "vierge";
                    $casier_inst = new CasierJudiciaire($code_personne, $status_casier);
                    
                    if ($casier_inst->exist()) :
                        echo json_encode(['status' => 'error', 'message' => 'Le casier judiciaire existe déjà!']);
                        exit;
                    endif;
                    // echo json_encode(['message' => $code_personne]);
                    // exit;
                    if ($casier_inst->add()) :
                        echo json_encode(['status' => 'success', 'message' => 'Casier judiciaire pour cette personne créé avec succèss!']);
                        exit;
                    endif;
                    if (file_exists($emplacement)) :
                    
                        unlink($emplacement);
                        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la création du casier! And file delete!']);
                    else :
                        echo json_encode(['status' => 'error', 'message' => 'File don\'t found!']);
                    endif;

                endif;

                unlink(filename: $emplacement);
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'insertion du personne And file delete!']);
                

            else :
                echo json_encode(['status' => 'Error', 'message' => 'Erreur lors du téléversement img']);
                exit;
            endif;
        else :
            echo json_encode(['status' => 'error', 'message' => 'Fichier non valid veillez choir une image svp!']);
            exit;
        endif;

    else :
        echo json_encode([
            'status' => 'error',
            'message' => 'Veuillez renseiger tout le champs obligatoire'
        ]);
        exit;
    endif;

    
} catch (\Throwable $th) {
    die('Erreur Serveur'. $th->getMessage());
}