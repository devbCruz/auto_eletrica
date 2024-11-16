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

        <h2>Cadastro de usuário</h2>
        <form action="" method="POST">
            <p>Nome:<input type="text" name="nome" placeholder="Digite seu nome"></p>
            <p>Endereço:<input type="text" name="enderco" placeholder="Digite seu endereço"></p> 
            <p>Telefone:<input type="text" name="telefone" placeholder="Digite seu número de telefone"></p>
            <p>Usuário: <span id='aviso-usuario'></span>
                <input type="text" name="usuario" placeholder="Digite um usuário único">
            </p>
            <p>Senha: <input type="password" name="senha" placeholder="Digite sua senha aqui"></p>
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

        // Verifica se o usuário já existe (com nome de campo correto)
        if (existe_usuario($_POST['usuario'])) {
            aviso_usuario_existente();
        } else {
            // Coleta os dados do formulário
            $nome = $_POST['nome'];
            $endereco = $_POST['enderco'];  
            $telefone = $_POST['telefone'];
            $usuario = $_POST['usuario'];
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            // Prepara e executa a consulta de inserção no banco
            $cadastro = $conexao->prepare(
                "INSERT INTO usuarios (nome, enderco, telefone, usuario, senha, status) 
                 VALUES (:nome, :enderco, :telefone, :usuario, :senha, 'ativo');"
            );
            $cadastro->bindValue(":nome", $nome);
            $cadastro->bindValue(":enderco", $endereco);  
            $cadastro->bindValue(":telefone", $telefone);
            $cadastro->bindValue(":usuario", $usuario);
            $cadastro->bindValue(":senha", $senha);
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
