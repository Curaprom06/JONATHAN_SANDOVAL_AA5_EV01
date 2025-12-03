<?php
// Endpoint: Registro de usuario
// Método: POST
// Body (JSON): { "username": "...", "password": "..." }

// Incluir funciones y config
require_once __DIR__ . '/../src/functions.php';
set_cors_headers();

// Permitir preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Método no permitido. Use POST.'], 405);
}

// Leer body JSON
$body = json_decode(file_get_contents('php://input'), true);
$username = $body['username'] ?? null;
$password = $body['password'] ?? null;

// Validaciones
if (!$username || !$password) {
    json_response(['error' => 'username y password son requeridos.'], 400);
}
if (!validate_username($username)) {
    json_response(['error' => 'username inválido. Mínimo 3 caracteres. Sólo letras, números y _.' ], 400);
}
if (!validate_password($password)) {
    json_response(['error' => 'password inválida. Mínimo 6 caracteres.'], 400);
}

try {
    $db = get_db();

    // Verificar si usuario existe
    $stmt = $db->prepare('SELECT id FROM users WHERE username = :username LIMIT 1');
    $stmt->execute([':username' => $username]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($existing) {
        json_response(['error' => 'El usuario ya existe.'], 409);
    }

    // Hashear contraseña usando password_hash (bcrypt)
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $db->prepare('INSERT INTO users (username, password_hash, created_at) VALUES (:username, :ph, :created)');
    $stmt->execute([
        ':username' => $username,
        ':ph' => $password_hash,
        ':created' => date('c')
    ]);

    json_response(['message' => 'Registro exitoso.'], 201);
} catch (Exception $e) {
    json_response(['error' => 'Error interno: ' . $e->getMessage()], 500);
}
