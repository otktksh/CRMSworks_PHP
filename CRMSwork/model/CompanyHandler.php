<?php
  require_once dirname(__FILE__) . '/DBHandler.php';

  class CompanyHandler extends Model {
    protected $table = 'companies';

    public function getCompany() {
      $sql = "SELECT company_id, company FROM {$this->table}";
      return $this->query($sql);
    }
  }

?>