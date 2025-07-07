<?php

namespace App;

class Personne extends Database {

    protected $table = 'personne';
    private $nom;
    private $postnom;
    private $prenom;
    private $sexe;
    private $date_naissance;
    private $lieu;
    private $nationalite;
    private $num_identite;
    private $img;
    private static $config;

    public function __construct($nom = null, $postnom = null, $prenom = null, $date_naissance = null, $lieu = null, $sexe = null, $nationalite = null, $num_identite = null, $img = null)
    {
        $this->nom = $nom;
        $this->postnom = $postnom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->lieu = $lieu;
        $this->sexe = $sexe;
        $this->nationalite = $nationalite;
        $this->num_identite = $num_identite;
        $this->img = $img;

        self::$config = (ConfigDB::getInstance())->getConfig();
        parent::__construct(self::$config);
    }

    public function add(): mixed {

        try {

            self::insert($this->table, [
                'nom' => $this->nom,
                'postnom' => $this->postnom,
                'prenom' => $this->prenom,
                'date_naissance' => $this->date_naissance,
                'lieu' => $this->lieu,
                'sexe' => $this->sexe,
                'nationalite' => $this->nationalite,
                'num_identite' => $this->num_identite,
                'img' => $this->img,
                'code' => bin2hex(random_bytes(16)),
                'temps' => time(),
            ]);

            $id = self::$db->lastInsertId();
            return self::findByParams($this->table, 'id = :id', ['id' => $id]);

        } catch (\Throwable $th) {
            return ('Erreur lors de la recherche '. $th->getMessage());
            // error_log("Erreur d'insertion : " . $e->getMessage());
            // return ['error' => $e->getMessage()];
        }
    }

    public function getPaginate($limit, $offset) {
        try {
            return self::paginate($this->table, $limit, $offset);
        } catch (\Exception $th) {
            die('Erreur lors de la pagination'. $th->getMessage());
        }
    }

    public function getAll() {
        return self::all($this->table);
    }

    public function exist() {
        try {
            return self::findByParams($this->table, 'num_identite = :num_identite', ['num_identite' => $this->num_identite]);
        } catch (\Throwable $th) {
            die('Erreur lors de exist'. $th->getMessage());
        }
    }

    public function searchOne($r){
        try {
            return self::search($this->table, 'CONCAT(nom, postnom, prenom)', $r, '*');
        } catch (\Throwable $th) {
            die('Erreur lors de la recherche'. $th->getMessage());
        }
    }

    public function getByCode($code) {
        try {
            return self::find($this->table, $code);
        } catch (\Throwable $th) {
            die('Erreur lors de getByCode'. $th->getMessage());
        }
    }

    public function getJoinTablePersonne($limit, $offset): array{
        $stmt = self::$db->prepare(query: "
            SELECT p.code, p.id, p.nom, p.prenom, p.sexe, p.date_naissance, p.lieu, p.nationalite, p.img, p.num_identite, c.code AS code_casier
            FROM $this->table p
            INNER JOIN casierjudiciaire c
            ON p.code = c.code_personne
            ORDER BY p.id
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue('limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue('offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) :
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        endif;
        return [];
    }

    public function getJoinPersCasByCode($code_personne){
        $stmt = self::$db->prepare("
            SELECT p.code, p.nom, p.prenom, p.sexe, p.date_naissance, p.lieu, p.nationalite, p.num_identite, p.img, c.code AS code_casier, c.statut
            FROM $this->table p
            INNER JOIN casierjudiciaire c
            ON p.code = c.code_personne
            WHERE p.code = :code_personne
        ");
        $stmt->bindValue('code_personne', $code_personne, \PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) :
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        endif;
        return [];
    }

    public function getInfractionPersonne($limit, $offset, $statut = 'chargé'): array{
        $stmt = self::$db->prepare(query: "
            SELECT p.id, p.nom, p.prenom, p.sexe, p.date_naissance, p.lieu, p.num_identite, c.code, c.statut
            FROM $this->table p
            INNER JOIN casierjudiciaire c ON p.code = c.code_personne
            WHERE c.statut = :statut
            ORDER BY p.id
            LIMIT :limit OFFSET :offset
            
        ");
        
        $stmt->bindValue('statut', $statut, \PDO::PARAM_STR);
        $stmt->bindValue('limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue('offset', (int)$offset, \PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];

    }

    public function getSearchInfraction($r, $statut = 'chargé'): array{
        $stmt = self::$db->prepare(query: "
            SELECT p.id, p.nom, p.prenom, p.sexe, p.date_naissance, p.lieu, p.num_identite, c.code, c.statut
            FROM $this->table p
            INNER JOIN casierjudiciaire c ON p.code = c.code_personne
            WHERE CONCAT(p.nom, p.postnom, p.prenom) LIKE :search AND c.statut = :statut
            ORDER BY p.id
            
        ");
        $stmt->bindValue('search', '%'.$r.'%', \PDO::PARAM_STR);
        $stmt->bindValue('statut', $statut, \PDO::PARAM_STR);
        
        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];

    }

}