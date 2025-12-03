<?php
// Ejecutar este script UNA VEZ para crear la base de datos y la tabla users.
// php src/db_init.php

$config = require __DIR__ . '/config.php';

try {
    $db = new PDO('sqlite:' . $config['db_path']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear tabla users si no existe
    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            created_at TEXT NOT NULL
        );
    ");

    echo "Base de datos inicializada en: " . $config['db_path'] . PHP_EOL;
} catch (Exception $e) {
    echo "Error al inicializar DB: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
