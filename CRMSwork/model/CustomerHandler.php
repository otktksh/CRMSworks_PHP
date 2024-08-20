<?php
  namespace Model;

  require_once dirname(__FILE__) . '/DBHandler.php';
  use \Model\DBHandler;

  class CustomerHandler extends DBHandler {
    protected $table = 'customers';
    protected $primary = 'customers_id';

    public function search($e = []) {
      $conditions = [];
      $params = [];
      
      try {
        if (!empty($e['name'])) {
          $conditions[] = "name LIKE :name";
          $params[':name'] = "%{$e['name']}%";
        }

        if (!empty($e['name_kana'])) {
          $conditions[] = "name_kana LIKE :name_kana";
          $params[':name_kana'] = "%{$e['name_kana']}%";
        }

        if (isset($e['gender']) && $e['gender'] != 2) {
          $conditions[] = "gender = :gender";
          $params[':gender'] = $e['gender'];
        }

        if (!empty($e['calendar_start'])) {
          $conditions[] = "birth_date >= :calendar_start";
          $params[':calendar_start'] = $e['calendar_start'];
        }

        if (!empty($e['calendar_end'])) {
          $conditions[] = "birth_date <= :calendar_end";
          $params[':calendar_end'] = $e['calendar_end'];
        }

        if(!empty($e['company'])) {
          $conditions[] = "company_id = :company";
          $params[':company'] = $e['company'];
        }

        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL";


        if (!empty($conditions)) {
          $sql .= " AND " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY {$this->primary} ASC";

        return $this->query($sql, $params);

      } catch(PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }

    public function insert($e) {
      try {
        $sql = "INSERT INTO {$this->table} (name, name_kana, tel, mail, gender, birth_date, company_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->execute($sql, $e);
      } catch(PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }

    public function edit($e, $id) {
      try {
        $sql = "UPDATE {$this->table} 
        SET 
            name = ?, 
            name_kana = ?,
            tel = ?,
            mail = ?,
            gender = ?,
            birth_date = ?,
            company_id = ?,
            update_at = NOW()
        WHERE {$this->primary} = ?";

        $e[] = $id;

        return $this->execute($sql, $e);
      } catch(PDOException $e) {
        error_log($e->getMessage());
        return false;
      }
    }
  }
?>