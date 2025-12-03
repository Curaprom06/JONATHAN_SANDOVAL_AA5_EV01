<?php
// Endpoint: Inicio de sesión (autenticación)
// Método: POST
// Body (JSON): { "username": "...", "password": "..." }
// Respuestas:
//  - 200 con message 'Autenticación satisfactoria' (si correcto)
//  - 401 con error 'Credenciales inválidas' (si falla)

require_once __DIR__ . '/../src/functions.php';
set_cors_headers();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['error' => 'Método no permitido. Use POST.'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
$username = $body['username'] ?? null;
$password = $body['password'] ?? null;

if (!$username || !$password) {
    json_response(['error' => 'username y password son requeridos.'], 400);
}

try {
    $db = get_db();

    // Buscar usuario
    $stmt = $db->prepare('SELECT id, password_hash FROM users WHERE username = :username LIMIT 1');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // No revelar si el username existe o no, devolver error genérico
        json_response(['error' => 'Error en la autenticación.'], 401);
    }

    // Verificar contraseña
    if (!password_verify($password, $user['password_hash'])) {
        json_response(['error' => 'Error en la autenticación.'], 401);
    }

    // Si se quisiera devolver un token, aquí se generaría (ej. JWT).
    // Para la evidencia pedida: devolvemos mensaje de autenticación satisfactoria.
    json_response(['message' => 'Autenticación satisfactoria.'], 200);
} catch (Exception $e) {
    json_response(['error' => 'Error interno: ' . $e->getMessage()], 500);
}
