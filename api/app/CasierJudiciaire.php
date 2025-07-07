<?php

    namespace App;

    class CasierJudiciaire extends Database {
        protected $table = 'casierjudiciaire';
        private $code_personne;
        private $status;

        private static $config;

        public function __construct($code_personne = null, $status = null) {

            $this->code_personne = $code_personne;
            $this->status = $status;

            self::$config = (ConfigDB::getInstance())->getConfig();

            parent::__construct(self::$config);

        }

        public function exist(){
            return self::findByParams($this->table, 'code_personne = :code_personne', ['code_personne' => $this->code_personne]);
        }

        public function findOne($code) {
            return self::find($this->table, $code);
        }
        
        public function updateStatus($code_casier) {
            try {
                return self::updateByParam($this->table, 'statut = ?', 'code = ?', ['chargé', $code_casier]);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function add(): bool {

            try {
                return self::insert($this->table,  [
                    'code_personne' => $this->code_personne,
                    'statut' => $this->status,
                    'code' => bin2hex(random_bytes(16)),
                    'temps' => time(),
                ]);
            } catch (\Exception $th) {
                die('Erreur lors de l\'insertion utilisateur'. $th->getMessage());
            }
        
        }
    }