<?php
require 'vendor/autoload.php'; // Carrega as dependências (incluindo DomPDF)
require 'conexao.php';

use Dompdf\Dompdf;

// Consulta os dados do banco
$consulta = $conexao->prepare("SELECT * FROM servicos_baixados");
$consulta->execute();
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

// Monta o HTML do relatório
if ($consulta->rowCount() > 0) {
    $html = "
        <meta charset='UTF-8'>
        <h2 style='text-align:center;'>Relatório de Serviços Executados</h2>
        <table style='width:100%; border-collapse: collapse;' border='1'>
            <thead>
                <tr>
                    <th>ID Serviço</th>
                    <th>Tipo de Serviço</th>
                    <th>Preço</th>
                    <th>Data do Serviço</th>
                    <th>Executante</th>
                </tr>
            </thead>
            <tbody>
    ";

    $totalPrecos = 0;

    foreach ($resultado as $row) {
        $dataFormatada = date('d/m/Y', strtotime($row['dataServico']));
        $preco = floatval($row['preco']);
        $precoFormatado = 'R$ ' . number_format($preco, 2, ',', '.');
        
        $html .= "
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['tipoServico']}</td>
                <td>{$precoFormatado}</td>
                <td>{$dataFormatada}</td>
                <td>{$row['executante']}</td>
            </tr>
        ";

        $totalPrecos += $preco;
    }

    $totalFormatado = 'R$ ' . number_format($totalPrecos, 2, ',', '.');

    $html .= "
            <tr>
                <td colspan='2'><strong>Total</strong></td>
                <td><strong>{$totalFormatado}</strong></td>
                <td colspan='2'></td>
            </tr>
        </tbody>
    </table>";
} else {
    $html = "<p>Nenhum dado encontrado</p>";
}

// Geração do PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->set_option('defaultFont', 'Arial'); 
$dompdf->setPaper('A4', 'portrait'); 
$dompdf->render();
$dompdf->stream("relatorio_servicos.pdf", ["Attachment" => false]);
?>
