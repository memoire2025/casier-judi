<?php

    use App\Agent;
    
    require_once __DIR__ . '/../function.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = securisation($_POST['nom']);
        $prenom = securisation($_POST['prenom']);
        $login = securisation($_POST['login']);
        $mdp = securisation($_POST['mdp']);
        $poste = securisation($_POST['poste']);
        
        if (isset($nom) && isset($prenom) && isset($login) && isset($poste) && isset($mdp)) {
            if (!empty($nom) && !empty($prenom) && !empty($login) && !empty($poste) && !empty($mdp)) {
                if (preg_match('/(@gmail.com)$/i', $login)) {
                    
                    new Agent($nom, $prenom, $login, $mdp, $poste);

                    if ($exist_user = Agent::exist()) :
                        echo json_encode(['status' => 'error', 'message' => 'L\'agent avec cet e-mail existe déjà!']);
                        exit;
                    endif;

                    if (Agent::add()) {

                        echo json_encode(['status' => 'success', 'message' => 'agent enregistré avec succès!']);
                        exit;
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement!']);
                        exit;
                    }
                    
                }else{
                    echo json_encode(['status' => 'error', 'message' => 'E-mail incorrecte!']);
                    exit;
                }
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs obligatoires!']);
                exit;
            }
        }else{
            echo json_encode(['status' => 'error', 'message' => 'Clès non existante!']);
            exit;
        }
    }
?>