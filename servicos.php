<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Cadastrados</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <?php
    require 'modulos.php';
    require 'conexao.php';
    include 'menu.html';

    session_start();
    if (!isset($_SESSION['logado']) || $_SESSION['logado'] != true) {
        login_necessario();
        exit();
    }
    ?>

    <br>
    <div class="container container-listagem">
        <h2><i class="fa-solid fa-list"></i> Serviços Cadastrados</h2>
        <a href="cadServico.php" class="link-voltar"><i class="fas fa-plus-circle"></i> Cadastrar Novo Serviço</a>

        <ul>
            <?php
            try {
                $dados = $conexao->prepare("SELECT * FROM servicos");
                $dados->execute();
                $servicos = $dados->fetchAll(PDO::FETCH_OBJ);

                if (count($servicos) > 0) {
                    foreach ($servicos as $servico) {
                        echo "
                        <li>
                            <div class='dados'>
                                <a href='cadServico.php?id=$servico->id&nome_servico=" . urlencode($servico->nome_servico) . "&descricao=" . urlencode($servico->descricao) . "&preco=$servico->preco&data_criacao=$servico->data_criacao'>
                                    <span class='titulo-item-listagem'>$servico->nome_servico</span> <br>
                                    <div class='descricao-item-listagem'>
                                        <ul>
                                            <li>Descrição: " . (!empty($servico->descricao) ? $servico->descricao : 'Sem descrição') . "</li>
                                            <li>Preço: R$ " . number_format($servico->preco, 2, ',', '.') . "</li>
                                            <li>Data do Serviço: " . date('d/m/Y', strtotime($servico->data_criacao)) . "</li>
                                        </ul>
                                    </div>
                                </a>
                            </div>

                            <div class='icone-lista'>
                                <a href='excluir-serv.php?id=$servico->id' onclick=\"return confirm('Tem certeza que deseja excluir o serviço $servico->nome_servico?');\">
                                    <i class='fas fa-trash-alt' style='color: red;' title='Excluir'></i>
                                </a>
                            </div>
                        </li>";
                    }
                } else {
                    echo "<p>Nenhum serviço cadastrado.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Erro ao buscar serviços: " . $e->getMessage() . "</p>";
            }
            ?>
        </ul>
    </div>

</body>
</html>
