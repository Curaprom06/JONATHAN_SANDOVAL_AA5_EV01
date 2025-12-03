<?php
// Configuración de la aplicación
return [
    // ruta al archivo SQLite (si la carpeta src está en /path/to/project/src, DB estará en same folder)
    'db_path' => __DIR__ . '/database.sqlite',
    // Cabeceras CORS (ajusta dominio en producción)
    'allowed_origin' => '*',
];
