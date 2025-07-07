<?php

    try {

        if (isset($_SESSION['casier'])) {
            unset($_SESSION['casier']['code']);
            unset($_SESSION['casier']['poste']);
            session_destroy();

            header('Location: /');
        }
   
    } catch (\Throwable $th) {
        echo json_encode([
            'error' => true,
            'status' => 'error',
            'message' => 'Erreur serveur : ' . $e->getMessage()
        ]);
    }
    exit;
    
?>