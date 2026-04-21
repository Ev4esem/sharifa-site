<?php
// API для работы с учениками

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

// Обработка preflight запросов
if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$pdo = getDB();

switch ($method) {
    case 'GET':
        // Получить список учеников
        $branch = isset($_GET['branch']) ? $_GET['branch'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
        $offset = ($page - 1) * $limit;

        $where = [];
        $params = [];

        if ($branch) {
            $where[] = "branch = ?";
            $params[] = $branch;
        }

        if ($search) {
            $where[] = "name LIKE ?";
            $params[] = "%$search%";
        }

        $whereSQL = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

        // Получаем общее количество
        $countSQL = "SELECT COUNT(*) as total FROM students $whereSQL";
        $stmt = $pdo->prepare($countSQL);
        $stmt->execute($params);
        $total = $stmt->fetch()['total'];

        // Получаем записи
        $sql = "SELECT * FROM students $whereSQL ORDER BY branch, name LIMIT $limit OFFSET $offset";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $students = $stmt->fetchAll();

        // Получаем список филиалов
        $branchesStmt = $pdo->query("SELECT DISTINCT branch FROM students ORDER BY branch");
        $branches = $branchesStmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode([
            'success' => true,
            'data' => $students,
            'branches' => $branches,
            'total' => (int)$total,
            'page' => $page,
            'pages' => ceil($total / $limit)
        ]);
        break;

    case 'POST':
        // Добавить ученика
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['name']) || !isset($input['branch'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Имя и филиал обязательны']);
            exit;
        }

        $sql = "INSERT INTO students (name, birth_year, branch) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $input['name'],
            isset($input['birth_year']) && $input['birth_year'] ? (int)$input['birth_year'] : null,
            $input['branch']
        ]);

        echo json_encode([
            'success' => true,
            'id' => $pdo->lastInsertId(),
            'message' => 'Ученик добавлен'
        ]);
        break;

    case 'DELETE':
        // Удалить ученика
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID не указан']);
            exit;
        }

        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        echo json_encode([
            'success' => true,
            'message' => 'Ученик удалён'
        ]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Метод не поддерживается']);
}
