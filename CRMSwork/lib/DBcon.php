<?php
  namespace lib;

  use PDO;
  use PDOException;
  
  class DBCon {
    private const DB_HOST = "mysql:dbname=crms_db;host=localhost;charset=utf8";
    private const DB_USER = "root";
    private const DB_PASSWORD = "";
    private $resource;

    public function __construct() {
      try{
        $this->resource = new PDO(self::DB_HOST, self::DB_USER, self::DB_PASSWORD);
        echo "接続成功";
    
      } catch(PDOException $e) {
        error_log("接続失敗: " . $e->getMessage());
        echo "接続失敗" . $e->getMessage() . "\n";
        exit();
      };
    }

    public function getResource() {
      return $this->resource;
    }
  }
?>