<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Método não permitido.'); }
checkCsrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('ID inválido.'); }
$stmt = $pdo->prepare('DELETE FROM alunos WHERE id = ?');
$stmt->execute([$id]);
header('Location: index.php', true, 303);
exit;
