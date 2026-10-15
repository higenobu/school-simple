<?php
declare(strict_types=1);

namespace App\Dao;

use PDO;

class EnrollmentDao extends Dao {
    // 登録（新規または上書き）
    public function register(array $data): bool {
        $sql = "INSERT INTO enrollment (stu_id,course_id,enroll_term,status)
                VALUES (:sid,:cid,:term,'ENROLLED')
                ON DUPLICATE KEY UPDATE status='ENROLLED'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return true;
    }

    // 成績入力
    public function setGrade(array $data): bool {
        $sql = "UPDATE enrollment 
                SET grade=:grade, score=:score, status='COMPLETED'
                WHERE stu_id=:sid AND course_id=:cid AND enroll_term=:term";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }

    // 登録一覧取得
    public function listByStudent(string $sid, string $term): array {
        $sql = "SELECT e.*, c.title, c.credit 
                FROM enrollment e
                JOIN course c ON e.course_id=c.course_id
                WHERE e.stu_id=:sid AND e.enroll_term=:term
                ORDER BY c.title";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':sid' => $sid, ':term' => $term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
