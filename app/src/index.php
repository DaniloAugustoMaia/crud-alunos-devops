<?php
require 'config.php';
$alunos = $pdo->query('SELECT * FROM alunos ORDER BY id DESC')->fetchAll();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>CRUD de Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <header>
            <div>
                <h1>CRUD de Alunos</h1>
                <p>Projeto DevOps — Deploy automático</p>
            </div>
            <a class="btn" href="create.php">+ Novo aluno</a>
        </header>
        <section class="panel">
            <h2>Alunos cadastrados</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Curso</th>
                            <th>Matrícula</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= h($aluno['id']) ?></td>
                                <td><?= h($aluno['nome']) ?></td>
                                <td><?= h($aluno['email']) ?></td>
                                <td><?= h($aluno['curso']) ?></td>
                                <td><?= h(date('d/m/Y', strtotime($aluno['data_matricula']))) ?></td>
                                <td class="actions">
                                    <a class="btn small secondary" href="edit.php?id=<?= h($aluno['id']) ?>">Editar</a>
                                    <form method="post" action="delete.php" onsubmit="return confirm('Excluir este aluno?')">
                                        <input type="hidden" name="csrf" value="<?= h(csrf()) ?>">
                                        <input type="hidden" name="id" value="<?= h($aluno['id']) ?>">
                                        <button class="btn small danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (!$alunos): ?>
                            <tr>
                                <td colspan="6">Nenhum aluno cadastrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
