<?php
  namespace Model;
  
  require_once dirname(__FILE__) . '/../lib/DBcon.php';
  use lib\DBCon;
  use PDO;
  use PDOException;

  class DBHandler {
    protected $dbCon;

    public function __construct() {
      $DBCon = new DBCon();
      $this->dbCon = $DBCon->getResource();
    }

    public function query($sql, $params = []) {
      try {
        $stmt = $this->dbCon->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }

    public function execute($sql, $params = []) {
      try {
        $stmt = $this->dbCon->prepare($sql);
        return $stmt->execute($params);
      } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }
    
    public function findById($e) {
      try {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primary} = ? AND deleted_at IS NULL ";
        //この配列指定がブサイクだから、最初から配列が来るように他ファイルで調整する
        return $this->query($sql, [$e]);

      } catch(PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }

    public function delete($e) {
      try {
        $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE {$this->primary} = ?";
        //この配列指定がブサイクだから、最初から配列が来るように他ファイルで調整する
        return $this->execute($sql, [$e]);

      } catch(PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }
  }
?>
