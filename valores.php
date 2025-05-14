<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
<?php 
        require 'modulos.php';
        include 'menu.html';
        session_start();
        if ($_SESSION['logado'] != true) {
            login_necessario();
        }
    ?>
    <br>
    <div class="container container-consulta">
        <?php
        require 'conexao.php';

        $consulta = $conexao->prepare("SELECT SUM(preco) AS total FROM servicos_baixados");
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        $total = $resultado['total'];

        echo "
            <div class='consulta'>
                <h2>Total de Serviços</h2>
                <div class='descricao-item-listagem'>
                    <ul>
                        <li>Total: R$ $total</li>
                    </ul>
                </div>
            </div>
        ";
        ?>
    </div>
</body>

</html>
