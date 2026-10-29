<?php

$csrfToken = csrf();

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= h($titulo) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container narrow">
        <a href="index.php">← Voltar</a>
        <section class="panel">
            <h1><?= h($titulo) ?></h1>
            <form method="post">
                <input type="hidden" name="csrf" value="<?= h($csrfToken) ?>">
                <label>
                    Nome
                    <input name="nome" maxlength="150" required value="<?= h($aluno['nome']) ?>">
                </label>
                <label>
                    E-mail
                    <input type="email" name="email" maxlength="190" required value="<?= h($aluno['email']) ?>">
                </label>
                <label>
                    Curso
                    <input name="curso" maxlength="150" required value="<?= h($aluno['curso']) ?>">
                </label>
                <label>
                    Data de matrícula
                    <input type="date" name="data_matricula" required value="<?= h($aluno['data_matricula']) ?>">
                </label>
                <button class="btn">Salvar</button>
            </form>
        </section>
    </main>
</body>
</html>
