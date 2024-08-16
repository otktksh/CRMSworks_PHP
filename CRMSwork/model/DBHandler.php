<!-- DB接続、操作ひな形スーパークラス -->
<?php
  require_once dirname(__FILE__) . '/../lib/DBcon.php';

  class Model {
    protected $dbCon;

    public function __construct() {
      $DBcon = new DBcon();
      $this->dbCon = $DBcon->getResource();
    }

    public function query($sql, $params = []) {
      $stmt = $this->dbCon->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params = []) {
      $stmt = $this->dbCon->prepare($sql);
      return $stmt->execute($params);
    }
  }
?>
