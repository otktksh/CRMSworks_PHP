<?php
  namespace Model;

  require_once dirname(__FILE__) . '/DBHandler.php';
  use Model\DBHandler;

  class CompanyHandler extends DBHandler {
    protected $table = 'companies';

    public function getCompany() {
      try {
        $sql = "SELECT company_id, company FROM {$this->table}";
        return $this->query($sql);
      } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }
  }

?>