<!DOCTYPE html>
<html lang="en">

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
    if ($_SESSION['logado'] != true) {
        login_necessario();
    }
    ?>
    <br>


    <div class="container container-listagem">

        <ul>

            <?php
            $dados = $conexao->prepare("SELECT * FROM servicos");
            $dados->execute();
            $servicos = $dados->fetchAll(PDO::FETCH_OBJ);
            foreach ($servicos as $servico) {
                echo "
                    <li>
                        <div class='dados'>
                           <a href='atualizar-servico.php?id=$servico->id&tipo=$servico->tipoServico&preco=$servico->preco&data=$servico->dataServico&executante=$servico->executante'>

                                <span class='titulo-item-listagem'>
                                    $servico->tipoServico
                                </span> <br>
                                <div class='descricao-item-listagem'>
                                    <ul>
                                        <li>Preço: R$ $servico->preco</li>
                                        <li>Data do Serviço: $servico->dataServico</li>
                                        <li>Executante: $servico->executante</li>
                                    </ul>

                                </div>
                            </a>
                        </div>

                        <div class='icone-lista'>
                           <a href='excluir-serv.php?id=$servico->id' onclick=\"return confirm('Tem certeza que deseja excluir o serviço $servico->tipoServico?'); return false;\">

                                <i class='fas fa-trash-alt' style='color: red;' title='Excluir'></i>
                            </a>
                        </div>

                    </li>
                    ";
            }
            ?>

        </ul>

    </div>


</body>

</html>
