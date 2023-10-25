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

    public function getLastSubmission() {
        $current_loufokerie_id = Loufokerie::getInstance()->getCurrent()['id_loufokerie'];
        $sql = "SELECT MAX(ordre_soumission) as 'last_submission_index' FROM `contribution` WHERE id_loufokerie = $current_loufokerie_id";
        return $this->query($sql)->fetch()['last_submission_index'];
    }
}
