<?php
// Iniciar la sesión si es necesario
session_start();

// Cargar Dompdf y otras configuraciones
require '../vendor/autoload.php';
require '../Model/CreditoHipotecario.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Validar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $ingresoMensual = $_POST['ingreso_mensual'];
    $montoCredito = $_POST['monto_credito'];
    $plazoCredito = $_POST['plazo_credito'];
    $tipoSeguro = $_POST['tipo_seguro'];

    // Crear instancia de CreditoHipotecario
    $credito = new CreditoHipotecario($nombre, $apellidos, $dni, $correo, $ingresoMensual, $montoCredito, $plazoCredito, $tipoSeguro);

    // Obtener el cronograma de pagos en HTML
    $html = $credito->generarCronograma();

    // Configurar opciones de Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    // Crear la instancia de Dompdf
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);

    // Configurar el tamaño de papel y la orientación
    $dompdf->setPaper('A4', 'portrait');

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador
    $dompdf->stream("cronograma_pago.pdf", ["Attachment" => false]);
    exit;
}
