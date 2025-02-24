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
    <div class="container">

        <h1>Olá, você logou com o usuário: 
            <?php if (isset($_COOKIE['usuario'])) { echo $_COOKIE['usuario']; }?> !</h1>
        <!-- <h2>no sistema.</h2> -->
    </div>
    <br>
    <div class="barra-superior">
            <ul>
                
                <li><a href="listar-alunos.php">Listagem de Usuários</a></li>
                <li><a href="listar-clientes.php">Listagem de Clientes</a></li>
                <li><a href="valores.php">Valores</a></li>
                <li><a href="pdf.php">Relatórios</a></li>
                
            </ul>
        </div>

</body>

</html>