<?php
require 'conexao.php';
require 'enviar-email.php';

// Ativa exibição de erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Buscar os dados do serviço original
        $query = $conexao->prepare("SELECT * FROM servicos WHERE id = ?");
        $query->execute([$id]);
        $servico = $query->fetch(PDO::FETCH_ASSOC);

        if (!$servico) {
            throw new Exception("Serviço não encontrado");
        }

        // Inserir na tabela de serviços baixados (com campos corrigidos)
        $insert = $conexao->prepare("INSERT INTO servicos_baixados 
                                    (tipoServico, preco, dataServico, executante) 
                                    VALUES (?, ?, ?, ?)");
        
        $insertSucesso = $insert->execute([
            $servico['nome_servico'],
            $servico['preco'],
            $servico['data_criacao'],
            $servico['executante'] ?? 'Não especificado'
        ]);

        if (!$insertSucesso) {
            throw new Exception("Falha ao mover para serviços finalizados");
        }

        // Remover da tabela original
        $delete = $conexao->prepare("DELETE FROM servicos WHERE id = ?");
        $delete->execute([$id]);

        // Enviar e-mail (se existir e-mail no registro)
        $destino = ['email'];
        if (!empty($servico['email'])) {
            $assunto = "Serviço finalizado - " . $servico['tipoServico'];
            $mensagem = "
                <h2>Serviço Finalizado</h2>
                <p><strong>Serviço:</strong> {$servico['tipoServico']}</p>
                <p><strong>Valor:</strong> R$ " . number_format($servico['preco'], 2, ',', '.') . "</p>
                <p><strong>Data:</strong> " . date('d/m/Y', strtotime($servico['dataServico'])) . "</p>
                <p><strong>Responsável:</strong> {$servico['executante']}</p>
            ";

            if (enviarEmail($servico['email'], $assunto, $mensagem, $destino)) {
                // Registrar sucesso se necessário
            } else {
                error_log("Falha ao enviar e-mail para: " . $servico['email']);
            }
        
        }

        header("Location: pagina-inicial.php?status=success&msg=Serviço+finalizado+com+sucesso");
        exit();

    } catch (Exception $e) {
        header("Location: pagina-inicial.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: pagina-inicial.php?status=error&msg=ID+não+especificado");
    exit();
}
?>