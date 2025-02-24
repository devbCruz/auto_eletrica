<?php
require 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados do serviço original
    $query = $conexao->prepare("SELECT * FROM servicos WHERE id = ?");
    $query->execute([$id]);
    $servico = $query->fetch(PDO::FETCH_ASSOC);

    if ($servico) {
        // Inserir na tabela de serviços baixados
        $insert = $conexao->prepare("INSERT INTO servicos_baixados (tipoServico, preco, dataServico, executante) 
                                     VALUES (?, ?, ?, ?)");
        $insert->execute([
            $servico['tipoServico'],
            $servico['preco'],
            $servico['dataServico'],
            $servico['executante']
        ]);

        // Remover da tabela original
        $delete = $conexao->prepare("DELETE FROM servicos WHERE id = ?");
        $delete->execute([$id]);

        // Redireciona para a tela de serviços com mensagem de sucesso
        header("Location: servicos.php?msg=Servico finalizado com sucesso!");
        exit();
    } else {
        echo "Erro: Serviço não encontrado.";
    }
} else {
    echo "ID não especificado.";
}
?>
