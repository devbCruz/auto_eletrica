<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Serviços executados</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <!-- Seu código PHP aqui -->
    <?php  
  require 'conexao.php';

$consulta = $conexao->prepare("SELECT * FROM servicos");
$consulta->execute();
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

if ($consulta->rowCount() > 0) {
    $html = "<table class='table'>";
    $html .= "<thead>";
    $html .= "<tr>";
    $html .= "<th scope='col'>ID Serviço</th>";
    $html .= "<th scope='col'>Tipo de Serviço</th>";
    $html .= "<th scope='col'>Preço</th>";
    $html .= "<th scope='col'>Data do Serviço</th>";
    $html .= "<th scope='col'>Executante</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody class='table-group-divider'>";

    $totalPrecos = 0;

    foreach ($resultado as $row) {
        $dataFormatada = date('d/m/Y', strtotime($row['dataServico']));
        $preco = floatval($row['preco']);
        $precoFormatado = 'R$ ' . number_format($preco, 2, ',', '.');
        $html .= "<tr>";
        $html .= "<th scope='row'>".$row['id']."</th>";
        $html .= "<td>".$row['tipoServico']."</td>";
        $html .= "<td>".$precoFormatado."</td>";
        $html .= "<td>".$dataFormatada."</td>";
        $html .= "<td>".$row['executante']."</td>";
        $html .= "</tr>";

        $totalPrecos += $preco;
    }

    $totalFormatado = 'R$ ' . number_format($totalPrecos, 2, ',', '.');

    $html .= "<tr>";
    $html .= "<td colspan='2'>Total</td>";
    $html .= "<td>".$totalFormatado."</td>";
    $html .= "<td colspan='2'></td>";
    $html .= "</tr>";

    $html .= "</tbody>";
    $html .= "</table>";
} else {
    $html = 'Nenhum dado encontrado';
}

use Dompdf\Dompdf;
require_once 'dompdf/autoload.inc.php';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->set_option('defaultFont', 'Arial');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream();
  
?>
</body>

</html>