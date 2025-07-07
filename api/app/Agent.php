<?php

namespace App;
class Agent extends Database {

    protected static $table = 'agent';
    private static $nom;
    private static $prenom;
    private static $login;
    private static $mdp;
    private static $poste;
    
    private static $config;
    public function __construct($nom = null, $prenom = null, $login = null, $mdp = null, $poste = null) {

        self::$nom = $nom;
        self::$prenom = $prenom;
        self::$login = $login;
        self::$mdp = $mdp;
        self::$poste = $poste;

        self::$config = (ConfigDB::getInstance())->getConfig();

        parent::__construct(self::$config);

    }

    public static function getAll() {
        return self::all(self::$table);
    }

    public static function exist(){

        $params = 'login = :login';
        $data = [
            'login' => self::$login
        ];
        return self::findByParams(self::$table, $params, $data);
    }

    public static function getByCode($code){
        return self::find(self::$table, $code);
    }

    public static function getPaginate($limit, $offset) {
        return self::paginate(self::$table, $limit, $offset);
    }

    public static function add() {

        $data = [
            'nom' => self::$nom,
            'prenom' => self::$prenom,
            'login' => self::$login,
            'mdp' => password_hash(self::$mdp, PASSWORD_BCRYPT),
            'poste' => self::$poste,
            'code' => bin2hex(random_bytes(16)),
            'temps' => time()
        ];

        try {
            return self::insert(self::$table, $data);
        } catch (\Exception $th) {
            die('Erreur lors de l\'insertion utilisateur'. $th->getMessage());
        }
    
    }

    public static function login($login, $mdp) {

        $user = self::findByParams(self::$table, 'login = :login', ['login' => $login]);
        if ($user) {
            if (password_verify($mdp, $user['mdp'])) :
                return $user;
            endif;
        }
        return [];
    }

    public static function deleteOne($code) {
        try {
            return self::delete(self::$table, $code);
        } catch (\Throwable $th) {
            die('Erreur lors de la suppression'. $th->getMessage());
        }
    }
}
