<?php
// Funciones comunes: respuestas JSON, validaciones y acceso a DB

$config = require __DIR__ . '/config.php';

/**
 * Conectar a la DB SQLite y devolver PDO.
 * @return PDO
 */
function get_db() {
    global $config;
    $pdo = new PDO('sqlite:' . $config['db_path']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

/**
 * Enviar respuesta JSON con código HTTP.
 */
function json_response($data, $status = 200) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($status);
    echo json_encode($data);
    exit;
}

/**
 * Validar formato del username (mínimo 3 caracteres, solo letras, números y _ )
 */
function validate_username($username) {
    if (!is_string($username)) return false;
    $username = trim($username);
    if (strlen($username) < 3) return false;
    if (!preg_match('/^[A-Za-z0-9_]+$/', $username)) return false;
    return true;
}

/**
 * Validar contraseña (mínimo 6 caracteres).
 */
function validate_password($password) {
    if (!is_string($password)) return false;
    if (strlen($password) < 6) return false;
    return true;
}

/**
 * Cabeceras CORS simples (desarrolllo). Ajustar en producción.
 */
function set_cors_headers() {
    global $config;
    header("Access-Control-Allow-Origin: " . ($config['allowed_origin'] ?? '*'));
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
}
