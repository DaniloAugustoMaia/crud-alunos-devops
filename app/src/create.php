<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    [$nome, $email, $curso, $data] = validateAluno();
    $stmt = $pdo->prepare('INSERT INTO alunos (nome,email,curso,data_matricula) VALUES (?,?,?,?)');
    $stmt->execute([$nome,$email,$curso,$data]);
    header('Location: index.php', true, 303); exit;
}
$aluno = ['nome'=>'','email'=>'','curso'=>'','data_matricula'=>date('Y-m-d')];
$titulo = 'Cadastrar aluno';
require 'form.php';
