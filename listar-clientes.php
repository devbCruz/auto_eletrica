<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Cadastrados</title>
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

    <div class="container container-listagem">
        <h2>Lista de Clientes</h2>

        <ul>
            <?php 
                $dados = $conexao->prepare("SELECT * FROM cliente");
                $dados->execute();
                $clientes = $dados->fetchAll(PDO::FETCH_OBJ);

                if (count($clientes) > 0) {
                    foreach ($clientes as $cliente) {
                        echo "
                        <li>
                            <div class='dados'>
                                <a href='editar.php?id=$cliente->ID&nome=$cliente->NomeCli&endereco=$cliente->EnderCli&telefone=$cliente->FoneCli&veiculo=$cliente->Veiculo'>
                                    <span class='titulo-item-listagem'>
                                        $cliente->NomeCli
                                    </span> <br>
                                    <div class='descricao-item-listagem'>
                                        <ul>
                                            <li>Telefone: $cliente->FoneCli</li>
                                            <li>Endereço: $cliente->EnderCli</li>
                                            <li>Veículo: $cliente->Veiculo</li>
                                        </ul>
                                    </div>
                                </a>
                            </div>

                            <div class='icone-lista'>
                                <a href='excluir-cli.php?id=$cliente->ID' onclick=\"return confirm('Tem certeza que deseja excluir $cliente->NomeCli?');\">
                                    <i class='fas fa-trash-alt' style='color: red;' title='Excluir'></i>
                                </a>
                            </div>
                            <div class='icone-lista'>
                                <a href='editar.php?id=$cliente->ID'>
                                    <i class='fas fa-edit' style='color: blue;' title='Editar'></i>
                                </a>
                            </div>
                        </li>";
                    }
                } else {
                    echo "<p>Nenhum cliente cadastrado.</p>";
                }
            ?>
        </ul>
    </div>

</body>

</html>
