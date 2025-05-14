<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Serviços Pendentes</title>
    
</head>

<body>

    <?php 
        require 'modulos.php';
        require 'conexao.php'; // Conexão com o banco de dados
        include 'menu.html';

        session_start();
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] != true) {
            login_necessario();
            exit();
        }
    ?>

    <br>
    <div class="container">
        <h1>Serviços Pendentes</h1>
        <table class="tabela-servicos">
            <thead>
                <tr>
                    <th scope= "col">Nome do Serviço</th>
                    <th scope= "col">Descrição</th>
                    <th scope= "col">Preço</th>
                    <th scope= "col">Data do Serviço</th>
                    <th scope= "col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Buscar serviços pendentes no banco de dados
                $dados = $conexao->prepare("SELECT * FROM servicos WHERE status = 'pendente'");
                $dados->execute();
                $servicos = $dados->fetchAll(PDO::FETCH_OBJ);

                if (count($servicos) > 0) {
                    foreach ($servicos as $servico) {
                        echo "
                        <table class='tabela-servicos'>
                            <tr>
                                <td>{$servico->nome_servico}</td>
                                <td>{$servico->descricao}</td>
                                <td>R$ {$servico->preco}</td>
                                <td>{$servico->data_criacao}</td>
                                <td>
                                    <form action='finalizar-servico.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$servico->id}'>
                                        <button type='submit' class='btn-finalizar' onclick=\"return confirm('Deseja finalizar este serviço?');\">
                                            Finalizar
                                        </button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum serviço pendente encontrado.</td></tr>";
                }
                
                ?>
            </tbody>
        </table>
    </div>
    <br>

    <div class="barra-superior">
            <ul>
                
                <li><a href="listar-alunos.php">Listagem de Usuários</a></li>
                <li><a href="listar-clientes.php">Listagem de Clientes</a></li>
                <li><a href="valores.php">Valores</a></li>
                <li><a href="pdf.php">Relatórios</a></li>
                <li><a href="servicos-baixados.php">Serviços Finalizados</a></li>
                
            </ul>
        </div>

</body>
</html>