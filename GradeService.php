<?php
class GradeService {
    private PDO $pdo;

    public function __construct() {
        $cfg = require __DIR__ . '/config.php';
        $this->pdo = new PDO(
            $cfg['dsn'],
            $cfg['username'],
            $cfg['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    // 指定科目の全成績取得
    public function fetchGrades(string $courseId): array {
        $sql = "SELECT e.stu_id, s.name, e.grade, e.score
                FROM enrollment e
                JOIN student s ON e.stu_id=s.stu_id
                WHERE e.course_id=:cid AND e.status='COMPLETED'
                ORDER BY s.year, s.stu_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':cid' => $courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 集計：平均点・最高点・最低点
    public function aggregate(string $courseId): array {
        $sql = "SELECT AVG(score) AS avg_score,
                       MAX(score) AS max_score,
                       MIN(score) AS min_score,
                       COUNT(*) AS cnt
                FROM enrollment
                WHERE course_id=:cid AND status='COMPLETED'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':cid' => $courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
