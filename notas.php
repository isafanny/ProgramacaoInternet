<?php
// Define o caminho para o arquivo de notas
$arquivoNotas = 'notas.txt';

// Função para adicionar uma nota
function adicionarNota($nota) {
    global $arquivoNotas;
    file_put_contents($arquivoNotas, $nota . PHP_EOL, FILE_APPEND);
}

// Função para obter todas as notas
function obterNotas() {
    global $arquivoNotas;
    if (file_exists($arquivoNotas)) {
        return file($arquivoNotas, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    return [];
}

// Adiciona uma nota se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nota'])) {
    $nota = strip_tags(trim($_POST['nota']));
    adicionarNota($nota);
    header('Location: notas.php'); // Redireciona para evitar reenvio do formulário
    exit();
}

// Obtém as notas para exibição
$notas = obterNotas();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciador de Notas</title>
</head>
<body>
    <h1>Gerenciador de Notas</h1>

    <form action="notas.php" method="post">
        <input type="text" name="nota" required>
        <button type="submit">Adicionar Nota</button>
    </form>

    <h2>Notas:</h2>
    <ul>
        <?php foreach ($notas as $nota): ?>
            <li><?php echo htmlspecialchars($nota); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>