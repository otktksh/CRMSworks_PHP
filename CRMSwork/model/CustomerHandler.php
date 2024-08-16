<!-- DB機能処理クラス サブクラス（親DBHandler） -->
<?php
  require_once dirname(__FILE__) . '/DBHandler.php';

  class CustomerHandler extends Model {
    protected $table = 'customers';
    protected $primary = 'customers_id';

    public function search($e = []) {
      $conditions = [];
      $params = [];

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

      $sql = "SELECT * FROM {$this->table}";
      
      if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
      } else {
        $sql .= " WHERE deleted_at IS NULL ORDER BY {$this->primary} ASC ";
        return $this->query($sql);
        exit;
      }

      return $this->query($sql, $params);
    }

    //親クラスへ持っていける
    public function findById($e) {

      $sql = "SELECT * FROM {$this->table} WHERE {$this->primary} = ? AND deleted_at IS NULL ";
      return $this->query($sql, [$e]);
    }

    public function insert($e) {

      $sql = "INSERT INTO {$this->table} (name, name_kana, tel, mail, gender, birth_date, company_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
      return $this->execute($sql, $e);
    }

    //親クラスへ持っていける
    public function delete($e) {

      $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE {$this->primary} = ?";
      return $this->execute($sql, [$e]);
    }

    public function edit($e) {

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
      return $this->execute($sql, $e);
    }

  }
?>