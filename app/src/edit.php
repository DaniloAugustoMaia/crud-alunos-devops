<?php
require 'config.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(400); exit('ID inválido.'); }
$stmt = $pdo->prepare('SELECT * FROM alunos WHERE id = ?');
$stmt->execute([$id]);
$aluno = $stmt->fetch();
if (!$aluno) { http_response_code(404); exit('Aluno não encontrado.'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    [$nome, $email, $curso, $data] = validateAluno();
    $stmt = $pdo->prepare('UPDATE alunos SET nome=?,email=?,curso=?,data_matricula=? WHERE id=?');
    $stmt->execute([$nome,$email,$curso,$data,$id]);
    header('Location: index.php', true, 303); exit;
}
$titulo = 'Editar aluno';
require 'form.php';
