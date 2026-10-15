<?php
require_once 'StudentDao.php';
require_once 'EnrollmentDao.php';
require_once 'GradeService.php';

// ---------- 学生情報 ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_student') {
    $dao = new StudentDao();
    $sid = $_POST['stu_id'];
    $result = $dao->add([
        'sid'     => $sid,
        'name'    => $_POST['name'],
        'email'   => $_POST['email'],
        'bd'      => $_POST['birth_date'],
        'gender'  => $_POST['gender'],
        'year'    => (int) $_POST['year'],
        'dept'    => $_POST['dept_id'],
        'phone'   => $_POST['phone'],
        'addr'    => $_POST['address']
    ]);
    echo $result ? "学生登録成功" : "登録失敗";
    exit;
}

// ---------- 履修登録 ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $enrollDao = new EnrollmentDao();
    $enrollDao->register([
        'sid'  => $_POST['stu_id'],
        'cid'  => $_POST['course_id'],
        'term' => $_POST['term']
    ]);
    echo "履修登録完了";
    exit;
}

// ---------- 成績入力 ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'set_grade') {
    $enrollDao = new EnrollmentDao();
    $enrollDao->setGrade([
        'sid'    => $_POST['stu_id'],
        'cid'    => $_POST['course_id'],
        'term'   => $_POST['term'],
        'grade'  => $_POST['grade'],
        'score'  => (float) $_POST['score']
    ]);
    echo "成績登録完了";
    exit;
}

// ---------- 成績集計 ----------
if (isset($_GET['course_id'])) {
    $service = new GradeService();
    $grades  = $service->fetchGrades($_GET['course_id']);
    $agg     = $service->aggregate($_GET['course_id']);

    header('Content-Type: application/json');
    echo json_encode(array_merge($grades, $agg), JSON_UNESCAPED_UNICODE);
    exit;
}
