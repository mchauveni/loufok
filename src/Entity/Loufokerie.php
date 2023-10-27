<?php

class Loufokerie extends Model {
    protected $tableName = APP_TABLE_PREFIX . 'loufokerie';
    protected static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getCurrent() {
        $now = new DateTime('now');
        $now = $now->format('Y-m-d H:i:s');
        $sql = "SELECT * FROM `loufokerie` WHERE date_debut_loufokerie < '$now' AND date_fin_loufokerie >= '$now'";

        $current = $this->query($sql)->fetch();
        if (!$current) return false;

        return $current;
    }
}
