<?php 
require 'conexao.php';
require 'modulos.php';
session_start();

if ($_SESSION['logado']) {
    try {
        // Pegando o id do usuário para a edição
        $id = $_GET['id'];

        // Checando se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $endereco = $_POST['enderco']; // Certifique-se de que o nome do campo está correto
            $telefone = $_POST['telefone'];
            $usuario = $_POST['usuario'];

            // Query de atualização com placeholders para parâmetros
            $atualizar = $conexao->prepare("UPDATE usuarios SET nome = :nome, enderco = :enderco, telefone = :telefone, usuario = :usuario WHERE id = :id");
            
            // Vinculando valores aos parâmetros da query
            $atualizar->bindValue(':nome', $nome);
            $atualizar->bindValue(':enderco', $endereco);
            $atualizar->bindValue(':telefone', $telefone);
            $atualizar->bindValue(':usuario', $usuario);
            $atualizar->bindValue(':id', $id);

            // Executando a query de atualização
            $atualizar->execute();

            // Redirecionando para a página de listagem após a atualização
            header('Location: listar-alunos.php');
            exit;
        }

        // Puxando os dados do usuário para exibir no formulário
        $consulta = $conexao->prepare("SELECT * FROM usuarios WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->execute();
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $erro) {
        echo "<h1> NÃO FOI POSSÍVEL CONCLUIR! </h1><br>" . $erro->getMessage() . "<br><br> <a href='listar-alunos.php' class='botao botao-voltar'>Voltar para listagem</a>";
    }

} else {
    login_necessario();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

    </style>
</head>
<body>
    <div class="container container-cadastro">
    <h2><i class="fas fa-edit"></i> Editar Usuário</h2>
    <a href="listar-alunos.php" class="link-voltar"><i class="fas fa-arrow-left"></i>Cancelar</a>
        <form action="" method="POST">
            <p>Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>"></p>
            <p>Endereço: <input type="text" name="enderco" value="<?php echo htmlspecialchars($usuario['enderco']); ?>"></p>
            <p>Telefone: <input type="text" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>"></p>
            <p>Usuário: <input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>"></p>
            <input type="submit" value="Atualizar" class="botao botao-atualizar">
        </form>

        
        
    </div>
</body>
</html>
