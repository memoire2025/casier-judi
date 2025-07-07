<?php

namespace App;

class Infraction extends Database {
    protected $table = 'infraction';
    private $code_casier;
    private $type_infraction;
    private $description;
    private $date_infraction;
    private $lieu;
    private $peine;
    private $duree_peine;

    private static $config;

    public function __construct($code_casier = null, $type_infraction = null, $date_infraction = null, $description = null, $lieu = null, $peine = null, $duree_peine = null) {

        $this->code_casier = $code_casier;
        $this->type_infraction = $type_infraction;
        $this->description = $description;
        $this->date_infraction = $date_infraction;
        $this->lieu = $lieu;
        $this->peine = $peine;
        $this->duree_peine = $duree_peine;

        self::$config = (ConfigDB::getInstance())->getConfig();

        parent::__construct(self::$config);

    }

    public function getAll() {
        return self::all($this->table);
    }

    public function exist(){
        return self::findByParams($this->table, 'type_infraction = :type AND date_infraction = :date AND lieu = :lieu AND peine = :peine', [
            'type' => $this->type_infraction,
            'date' => $this->date_infraction,
            'lieu' => $this->lieu,
            'peine' => $this->peine,
        ]);
    }

    public  function findOne($code) {
        return self::find($this->table, $code);
    }

    public function getByCodeCasier($code_casier){
        return self::findByParams($this->table, 'code_casier = :code_casier', ['code_casier' => $code_casier]);
    }


    public function getAllJoined($limit , $offset): array{
        $stmt = self::$db->prepare("
            SELECT p.id, p.nom, p.postnom, p.prenom, p.sexe, p.date_naissance, c.code, c.statut
            FROM $this->table i
            INNER JOIN casierjudiciaire c ON c.code = i.code_casier
            INNER JOIN personne p ON p.code = c.code_personne
            ORDER BY p.id
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue('limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->bindValue('offset', (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];

    }

    public function searchOne($r): array{
        $stmt = self::$db->prepare(query: "
            SELECT p.id, p.nom, p.postnom, p.prenom, p.sexe, p.date_naissance, c.code, c.statut
            FROM $this->table i
            INNER JOIN casierjudiciaire c ON c.code = i.code_casier
            INNER JOIN personne p ON p.code = c.code_personne
            WHERE CONCAT(p.nom, p.postnom, p.prenom) LIKE :search
        ");
        $stmt->bindValue('search', '%'.$r.'%', \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];

    }

    public function getInfractionByCode($code_casier): array{
        try {
            $stmt = self::$db->prepare(query:"
                SELECT c.code, i.id, i.type_infraction, i.date_infraction, i.description, i.lieu, i.peine, i.dure_pein
                FROM {$this->table} i
                INNER JOIN casierjudiciaire c ON i.code_casier = c.code
                INNER JOIN personne p ON c.code_personne = p.code
                WHERE c.code = :code_casier
                ORDER BY i.id
            ");
            $stmt->bindValue(param: 'code_casier', value: $code_casier, type: \PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount() > 0 ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];

        } catch (\Exception $th) {
            die("Problème recuperation!". $th->getMessage());
        }
        
    }

    public function add(): bool {

        $data = [
            'code_casier' => $this->code_casier,
            'type_infraction' => $this->type_infraction,
            'date_infraction' => $this->date_infraction,
            'description' => $this->description,
            'lieu' => $this->lieu,
            'peine' => $this->peine,
            'dure_pein' => $this->duree_peine,
            'code' => bin2hex(random_bytes(16)),
            'temps' => time()
        ];

        try {
            return self::insert($this->table, $data);
        } catch (\Exception $th) {
            die('Erreur lors de l\'insertion utilisateur'. $th->getMessage());
        }
    
    }
}