<?php

class RandomContribution extends Model {
    protected $tableName = APP_TABLE_PREFIX . 'contribution_aleatoire';
    protected static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function assign($id_loufok, $id_user) {
        $nbcontrib = count(Contribution::getInstance()->findBy(['id_loufokerie' => $id_loufok]));
        $rand = rand(1, $nbcontrib);
        $randomContrib = Contribution::getInstance()->findBy([
            'id_loufokerie' => $id_loufok,
            'ordre_soumission' => $rand
        ])[0];

        RandomContribution::getInstance()->create([
            'id_joueur' => $id_user,
            'id_loufokerie' => $id_loufok,
            'id_contribution' => $randomContrib['id_contribution']
        ]);
    }
}
