<?php
// ===== Настройки базы данных (поменяй под свой XAMPP/OpenServer) =====
define('DB_HOST', 'MySQL-8.4:3306');
define('DB_NAME', 'adidas_shop');
define('DB_USER', 'root');
define('DB_PASS', '');          // в XAMPP по умолчанию пароль пустой

session_start();

// Подключение к MySQL через PDO (одно соединение на весь запрос)
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER, DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die('Database error: ' . $e->getMessage());
        }
    }
    return $pdo;
}
