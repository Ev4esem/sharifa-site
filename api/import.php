<?php
// Скрипт для массового импорта учеников
// Отправьте POST запрос с JSON массивом учеников

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Используйте POST запрос']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['students']) || !is_array($input['students'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Отправьте массив students']);
    exit;
}

$pdo = getDB();
$imported = 0;
$errors = [];

$sql = "INSERT INTO students (name, birth_year, branch) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);

foreach ($input['students'] as $index => $student) {
    if (!isset($student['name']) || !isset($student['branch'])) {
        $errors[] = "Строка $index: имя и филиал обязательны";
        continue;
    }

    try {
        $stmt->execute([
            $student['name'],
            isset($student['birth_year']) && $student['birth_year'] ? (int)$student['birth_year'] : null,
            $student['branch']
        ]);
        $imported++;
    } catch (PDOException $e) {
        $errors[] = "Строка $index: " . $e->getMessage();
    }
}

echo json_encode([
    'success' => true,
    'imported' => $imported,
    'errors' => $errors
]);
