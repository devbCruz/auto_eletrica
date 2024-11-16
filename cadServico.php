<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    <h2><i class="fa-brands fa-creative-commons-nd"></i>Cadastro de Serviço</h2>
    <a href="listar-alunos.php" class="link-voltar"><i class="fas fa-arrow-left"></i>Cancelar</a>
        <form action="" method="POST">
            <p>Tipo de Serviço:<input type="text" name="tipo" placeholder="Digite o tipo de serviço"></p>
            <p>Preço:<input type="text" name="preco" placeholder="Digite o preço"></p>
            <p>Data do serviço: <br> 
             <input type="date" name="data" placeholder="Digite a data do serviço"></p>
            <p>Executante: <span id='aviso-usuario'></span>
                <input type="text" name="executante" placeholder="Digite quem vai realizar o serviço">
            </p>
            <input type="submit" name="cadastrar" value="Cadastrar">
        </form>

    </div>

    <?php 
        else:
            login_necessario();
        endif
    ?>


</body>

</html>

<?php 

    $cadastrado = false;
    $usuario_existente = false;
    require 'conexao.php';

    if (isset($_POST['cadastrar'])) {

        if (existe_usuario($_POST['usuarios'])) {
            aviso_usuario_existente();
        } else {
            $tipoServico = $_POST['tipo'];
            $preco = $_POST['preco'];
            $dataServico = $_POST['data'];
            $executante = $_POST['executante'];
            $cadastro = $conexao->prepare(
                "INSERT INTO servicos (tipoServico, preco, dataServico, executante) VALUES (:tipoServico, :preco, :dataServico, :executante);"
            );
            $cadastro->bindValue(":tipoServico", $tipoServico);
            $cadastro->bindValue(":preco", $preco);
            $cadastro->bindValue(":dataServico", $dataServico);
            $cadastro->bindValue(":executante", $executante);
            $cadastro->execute();
            $cadastrado = true;
        }

    }

    if ($cadastrado):
?>

<script>
alert('Cadastrado com sucesso!')
</script>


<?php 
    endif
?>
