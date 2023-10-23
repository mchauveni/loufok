<?php

class Contribution extends Model {
    protected $tableName = APP_TABLE_PREFIX . 'contribution';
    protected static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function countBy($id_loufok) {
        $sql = "SELECT * FROM `contribution` WHERE id_loufokerie = $id_loufok";
        return count($this->query($sql)->fetchAll());
    }
}
