<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços baixados</title>
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
        <h2><i class="fa-solid fa-list"></i> Serviços Baixados</h2>
        <a href="cadServico.php" class="link-voltar"><i class="fas fa-plus-circle"></i> Cadastrar Novo Serviço</a>

        <ul>
            <?php
            try {
                $dados = $conexao->prepare("SELECT * FROM servicos_baixados");
                $dados->execute();
                $servicos = $dados->fetchAll(PDO::FETCH_OBJ);

                if (count($servicos) > 0) {
                    foreach ($servicos as $servico) {
                        echo "
                        <li>
                            <div class='dados'>
                            <form action='enviar-email.php' method='POST' style='display:inline;'>    
                                <a href='cadServico.php?id=$servico->id&tipoServico=" . urlencode($servico->tipoServico) . "&preco=$servico->preco&dataServico=$servico->dataServico&executante=" . urlencode($servico->executante) . "'>
                                    <span class='titulo-item-listagem'>$servico->tipoServico</span> <br>
                                    <div class='descricao-item-listagem'>
                                        <ul>
                                            <li>Preço: R$ " . number_format($servico->preco, 2, ',', '.') . "</li>
                                            <li>Data do Serviço: " . date('d/m/Y', strtotime($servico->dataServico)) . "</li>
                                            <li>Executante: " . (!empty($servico->executante) ? $servico->executante : 'Não informado') . "</li>
                                            <li>Data de Baixa: " . date('d/m/Y H:i', strtotime($servico->dataBaixa)) . "</li>
                                            <button type='submit' class='btn-finalizar' onclick=\"return confirm('Deseja finalizar este serviço?');\">
                                            Finalizar
                                            </button>
                                        </ul>
                                    </div>
                                </a>
                            </form>   
                            </div>

                            <div class='icone-lista'>
                                <a href='excluir-cli.php?id=$servico->id' onclick=\"return confirm('Tem certeza que deseja excluir o serviço $servico->tipoServico?');\">
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