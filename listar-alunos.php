<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos Cadastrados</title>
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


    <div class="container container-listagem">

        <ul>

            <?php 
                $dados = $conexao->prepare("SELECT * FROM usuarios");
                $dados->execute();
                $usuarios = $dados->fetchAll(PDO::FETCH_OBJ);
                foreach ($usuarios as $usuario) {
                    echo "
                    <li>
                        <div class='dados'>
                            <a href='editar.php?id=$usuario->id&nome=$usuario->nome&enderco=$usuario->enderco&telefone=$usuario->telefone&usuario=$usuario->usuario'>
                                <span class='titulo-item-listagem'>
                                    $usuario->nome
                                </span> <br>
                                <div class='descricao-item-listagem'>
                                    <ul>
                                        <li>Telefone: $usuario->telefone</li>
                                        <li>Endereço: $usuario->enderco</li>
                                        <li>Usuário: $usuario->usuario</li>
                                    </ul>

                                </div>
                            </a>
                        </div>

                       <div class='icone-lista'>
                            <a href='excluir.php?id=$usuario->id' onclick=\"return confirm('Tem certeza que deseja excluir $usuario->nome?');\">
                                <i class='fas fa-trash-alt' style='color: red;' title='Excluir'></i>
                            </a>
                        </div>
                        <div class='icone-lista'>
                            <a href='editar.php?id=$usuario->id'>
                                <i class='fas fa-edit' style='color: blue;' title='Editar'></i>
                            </a>
                        </div>
                    </li>";
                }
            ?>

        </ul>

    </div>


</body>

</html>