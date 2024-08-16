<!-- DB機能処理クラス サブクラス（親DBHandler） -->
<?php
  require_once dirname(__FILE__) . '/DBHandler.php';

  class CustomerHandler extends Model {
    protected $table = 'customers';

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
        $sql .= " WHERE deleted_at IS NULL ORDER BY customers_id ASC ";
        return $this->query($sql);
        exit;
      }

      return $this->query($sql, $params);
    }

    public function insert($e) {

      $sql = "INSERT INTO {$this->table} (name, name_kana, tel, mail, gender, birth_date, company_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
      return $this->execute($sql, $e);
    }
  }
?>