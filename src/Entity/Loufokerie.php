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
        $today = date('Y-m-d');
        $sql = "SELECT * FROM `loufokerie` WHERE date_debut_loufokerie < '$today' AND date_fin_loufokerie >= '$today'";

        $current = $this->query($sql)->fetch();
        if (!$current) return false;

        return $current;
    }
}
