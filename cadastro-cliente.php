<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>

    <?php 
        require 'modulos.php';
        include 'menu.html';

        session_start();
        if ($_SESSION['logado']):
    ?>
    <br>

    <div class="container container-cadastro">
        <h2>Cadastro de Clientes</h2>
        <form action="" method="POST">
            <p>Nome:<input type="text" name="NomeCli" placeholder="Digite o nome do cliente" required></p>
            <p>Endereço:<input type="text" name="EnderCli" placeholder="Digite o endereço do cliente" required></p>
            <p>Email:<input type="text" name="Email" placeholder="Digite o e-mail do cliente" required></p> 
            <p>Telefone:<input type="text" name="FoneCli" placeholder="Digite o telefone do cliente" required></p>
            <p>Veículo: <input type="text" name="Veiculo" placeholder="Digite o veículo" required></p>
            <input type="submit" name="cadastrar" value="Cadastrar">
        </form>
    </div>

    <?php 
        else:
            login_necessario();
        endif;
    ?>

</body>
</html>

<?php 
    require 'conexao.php';

    if (isset($_POST['cadastrar'])) {

        // Verifica se os campos estão definidos e não vazios
        $NomeCli  = !empty($_POST['NomeCli']) ? $_POST['NomeCli'] : null;
        $EnderCli = !empty($_POST['EnderCli']) ? $_POST['EnderCli'] : null;
        $FoneCli  = !empty($_POST['FoneCli']) ? $_POST['FoneCli'] : null;
        $Veiculo  = !empty($_POST['Veiculo']) ? $_POST['Veiculo'] : null;

        // Validação extra para evitar erro de campos nulos
        if ($NomeCli === null || $EnderCli === null || $FoneCli === null || $Veiculo === null) {
            die("<script>alert('Erro: Todos os campos são obrigatórios!');</script>");
        }

        // Prepara a inserção no banco
        try {
            $cadastro = $conexao->prepare(
                "INSERT INTO cliente (NomeCli, EnderCli, FoneCli, Veiculo) 
                 VALUES (:nome, :endereco, :telefone, :veiculo)"
            );

            $cadastro->bindValue(":nome", $NomeCli);
            $cadastro->bindValue(":endereco", $EnderCli);
            $cadastro->bindValue(":telefone", $FoneCli);
            $cadastro->bindValue(":veiculo", $Veiculo);

            $cadastro->execute();

            echo "<script>alert('Cadastrado com sucesso!');</script>";

        } catch (PDOException $e) {
            echo "<script>alert('Erro ao cadastrar: " . $e->getMessage() . "');</script>";
        }
    }
?>
