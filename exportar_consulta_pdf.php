<?php 
require 'vendor/autoload.php';

require 'Model/conexion.php';


use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
$dni = $_SESSION['dni'] ?? null;

if (!$dni) {
    echo "No se encontró información para generar el PDF.";
    exit;
}

$conexion = new Conexion();

$query = "
    SELECT 
        clientes.nombre,
        creditos_hipotecarios.monto AS monto_credito,
        creditos_hipotecarios.cuota_inicial,
        creditos_hipotecarios.plazo AS numero_cuotas
    FROM 
        creditos_hipotecarios
    INNER JOIN 
        clientes 
    ON 
        creditos_hipotecarios.cliente_id = clientes.cliente_id
    WHERE 
        clientes.dni = ?";
        
$stmt = $conexion->conexion->prepare($query);
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $credito = $result->fetch_assoc();
    
    // Genera cronograma en HTML
    $html = "<h4>Resultados de la consulta</h4>";
    $html .= "<p><strong>Nombre del Cliente:</strong> {$credito['nombre']}</p>";
    $html .= "<p><strong>Importe del Crédito Solicitado:</strong> S/ " . number_format($credito['monto_credito'], 2) . "</p>";
    $html .= "<p><strong>Cuota Inicial:</strong> S/ " . number_format($credito['cuota_inicial'], 2) . "</p>";
    $html .= "<p><strong>Número de cuotas:</strong> {$credito['numero_cuotas']}</p>";
    $html .= "<h4>Cronograma de Pagos</h4>";

    $cuotaMensual = $credito['monto_credito'] / $credito['numero_cuotas'];
    for ($i = 1; $i <= $credito['numero_cuotas']; $i++) {
        $html .= "<p>Mes $i: S/ " . number_format($cuotaMensual, 2) . "</p>";
    }

    // Configura Dompdf y genera el PDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("consulta_credito.pdf", ["Attachment" => true]);
    exit;
} else {
    echo "No se encontraron datos para generar el PDF.";
}
$stmt->close();
$conexion->cerrarConexion();
