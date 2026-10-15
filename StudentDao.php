<?php
class StudentDao extends Dao {
    // INSERT
    public function add(array $data): string {
        $sql = "INSERT INTO student (stu_id,name,email,birth_date,gender,year,dept_id,phone,address)
                VALUES (:sid,:name,:email,:bd,:gender,:year,:dept,:phone,:addr)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId(); // stu_id が PK の場合
    }

    // SELECT (単体)
    public function get(string $sid): ?array {
        $sql = "SELECT * FROM student WHERE stu_id = :sid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':sid' => $sid]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update(string $sid, array $data): bool {
        $set = [];
        $params = [];
        foreach ($data as $col => $val) {
            $set[] = "$col = :$col";
            $params[":$col"] = $val;
        }
        $sql = "UPDATE student SET " . implode(', ', $set) . " WHERE stu_id = :sid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge($params, [':sid' => $sid]));
        return $stmt->rowCount() > 0;
    }

    // DELETE
    public function delete(string $sid): bool {
        $sql = "DELETE FROM student WHERE stu_id = :sid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':sid' => $sid]);
        return $stmt->rowCount() > 0;
    }
}
