<?php
        
    require_once __DIR__ . '/../function.php';

    use App\Agent;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    $exp = time() + 10600;

    function generateJWT($code, $poste, $nom, $exp) {
        $payload = [
            "code-casier" => $code,
            "poste-casier" => $poste,
            "nom-casier" => $nom,
            "exp-casier" => $exp
        ];
        return JWT::encode($payload, JWT_SECRET, 'HS256');
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $login = securisation($data['email']);
    $mdp = securisation($data['mdp']);
    
    if (!empty($login) && !empty($mdp)) :
        
        new Agent();
        
        $user_info = Agent::login($login, $mdp);

        if (!empty($user_info)) :
            
            $accessToken = generateJWT($user_info['code'], $user_info['poste'], $user_info['nom'], $exp);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Connexion réussie!',
                'accessToken' => $accessToken,
                'poste' => $user_info['poste'],
                'code' => $user_info['code'],
                'nom' => $user_info['nom'],
                'exp' => $exp,
            ]);
            exit;
        else :

            echo json_encode(['status' => 'error', 'message' => 'E-mail ou mot de passe incorrect !']);
    
        endif;        
    else :
        echo json_encode(['status' => 'error', 'message' => 'Champs vides !']);
        exit;
    endif;
