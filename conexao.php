<?php 
    try {
        // Conexão com o banco de dados MySQL
        $conexao = new PDO('mysql:host=localhost;dbname=auto_eletrica', 'root', '');
        // Configura o PDO para lançar exceções em caso de erro
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $erro) {
        // Exibe a mensagem de erro em caso de falha
        echo 'Erro de conexão: ' . $erro->getMessage();
        echo "<br>";
        echo 'Código do erro: ' . $erro->getCode();
    }
?>