<?php 
session_start(); // Iniciar a sessão no topo do script

require 'modulos.php';
include 'menu.html';

if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {
    login_necessario();
    exit; // Impede execução do restante do código
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Serviço</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <br>

    <div class="container container-cadastro">
        <h2><i class="fa-solid fa-tools"></i> Cadastro de Serviço</h2>
        <a href="pagina-inicial.php" class="link-voltar"><i class="fas fa-arrow-left"></i> Voltar</a>

        <form action="" method="POST">
            <p>Tipo de Serviço:<input type="text" name="nome_servico" required placeholder="Digite o nome do serviço"></p>
            <p>Descriçã: <br><input name="descricao" placeholder="Digite a descrição do serviço"></input></p>
            <p>E-mail: <br><input name="e-mail" placeholder="Digite o email do cliente"></input></p>
            <p>Preço: <br><input type="number" step="0.01" name="preco" required placeholder="Digite o preço"></p>
            <p>Data do Serviço: <br> 
                <input type="date" name="data_criacao" required>
            </p>
            <input type="submit" name="cadastrar" value="Cadastrar">
        </form>
    </div>

</body>

</html>

<?php 
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    $nomeServico = trim($_POST['nome_servico'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = $_POST['preco'] ?? null;
    $dataCriacao = $_POST['data_criacao'] ?? null;

    // Verificação para evitar valores vazios
    if (empty($nomeServico) || empty($preco) || empty($dataCriacao)) {
        echo "<script>alert('Preencha todos os campos obrigatórios!');</script>";
        exit;
    }

    try {
        $cadastro = $conexao->prepare(
            "INSERT INTO servicos (nome_servico, descricao, preco, data_criacao) 
             VALUES (:nome_servico, :descricao, :preco, :data_criacao);"
        );

        $cadastro->bindValue(":nome_servico", $nomeServico, PDO::PARAM_STR);
        $cadastro->bindValue(":descricao", $descricao, PDO::PARAM_STR);
        $cadastro->bindValue(":preco", $preco, PDO::PARAM_STR);
        $cadastro->bindValue(":data_criacao", $dataCriacao, PDO::PARAM_STR);

        if ($cadastro->execute()) {
            echo "<script>alert('Serviço cadastrado com sucesso!'); window.location.href='servicos.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar o serviço!');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro no banco de dados: " . addslashes($e->getMessage()) . "');</script>";
    }
}
?>
