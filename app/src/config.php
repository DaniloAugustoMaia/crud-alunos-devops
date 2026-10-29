<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=utf8mb4',
    getenv('DB_HOST') ?: 'db',
    getenv('DB_NAME') ?: 'crud_alunos'
);
try {
    $pdo = new PDO($dsn, getenv('DB_USER') ?: 'crud_user', getenv('DB_PASSWORD') ?: '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(503);
    exit('Banco de dados indisponível.');
}
function h($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function validData($value) {
    $d = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
    return $d && $d->format('Y-m-d') === $value;
}
function csrf() {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (!isset($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function checkCsrf() {
    if (!hash_equals(csrf(), $_POST['csrf'] ?? '')) { http_response_code(403); exit('Requisição inválida.'); }
}
function validateAluno() {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $curso = trim($_POST['curso'] ?? '');
    $data = $_POST['data_matricula'] ?? '';
    if ($nome === '' || mbSafeLen($nome) > 150 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190 || $curso === '' || mbSafeLen($curso) > 150 || !validData($data)) {
        http_response_code(422); exit('Dados inválidos. Volte e confira o formulário.');
    }
    return [$nome, $email, $curso, $data];
}
function mbSafeLen($s) { return function_exists('mb_strlen') ? mb_strlen($s) : strlen($s); }
