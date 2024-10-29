<?php
// Iniciar la sesión si es necesario
session_start();

// Cargar Dompdf y otras configuraciones
require '../vendor/autoload.php';
require '../Model/CreditoHipotecario.php';
require '../Model/conexion.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Validar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Capturar datos del formulario
     $nombre = $_POST['nombre'];
     $apellidos = $_POST['apellidos'];
     $dni = $_POST['dni'];
     $correo = $_POST['correo'];
     $telefono = $_POST['telefono']; // Añadir teléfono
     $direccion = $_POST['direccion']; // Añadir dirección
     $ingresoMensual = $_POST['ingreso_mensual'];
     $montoCredito = $_POST['monto_credito'];
     $plazoCredito = $_POST['plazo_credito'];
     $tipoSeguro = $_POST['tipo_seguro'];
     $departamento = $_POST['departamento'];
     $provincia = $_POST['provincia'];
     $distrito = $_POST['distrito'];
     $fechaNacimiento = $_POST['fecha_nacimiento'];
     $estadoCivil = $_POST['estado_civil'];
     $tipoIngreso = $_POST['tipo_ingreso'];

    // Crear instancia de CreditoHipotecario
    $credito = new CreditoHipotecario(
        $nombre,
        $apellidos,
        $dni,
        $correo,
        $ingresoMensual,
        $montoCredito,
        $plazoCredito,
        $tipoSeguro,
        $departamento,
        $provincia,
        $distrito,
        $fechaNacimiento,
        $estadoCivil,
        $tipoIngreso
    );

    // Crear la conexión a la base de datos
    $conexion = new Conexion();
    
    // Verificar si el cliente ya existe
    $queryCliente = "SELECT cliente_id FROM clientes WHERE dni = ?";
    $stmtCliente = $conexion->conexion->prepare($queryCliente);
    $stmtCliente->bind_param("s", $dni);
    $stmtCliente->execute();
    $resultCliente = $stmtCliente->get_result();

    if ($resultCliente->num_rows > 0) {
        // Si el cliente existe, obtener su ID y actualizar la información de ubicación
        $clienteData = $resultCliente->fetch_assoc();
        $clienteId = $clienteData['cliente_id'];

        $queryUpdateCliente = "UPDATE clientes SET nombre = ?, apellidos = ?, correo = ?, departamento = ?, provincia = ?, distrito = ?, fecha_nacimiento = ?, estado_civil = ?, tipo_ingreso = ?, ingreso_mensual = ? WHERE cliente_id = ?";
        $stmtUpdateCliente = $conexion->conexion->prepare($queryUpdateCliente);
        $stmtUpdateCliente->bind_param("ssssssssdsi", $nombre, $apellidos, $correo, $departamento, $provincia, $distrito, $fechaNacimiento, $estadoCivil, $tipoIngreso, $ingresoMensual, $clienteId);
        $stmtUpdateCliente->execute();

    } else {
        // Si el cliente no existe, insertarlo en la tabla "clientes" junto con la información de ubicación y otros detalles
        $queryInsertCliente = "INSERT INTO clientes (nombre, apellidos, dni, correo, departamento, provincia, distrito, fecha_nacimiento, estado_civil, tipo_ingreso, ingreso_mensual) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsertCliente = $conexion->conexion->prepare($queryInsertCliente);
        $stmtInsertCliente->bind_param("ssssssssssd", $nombre, $apellidos, $dni, $correo, $departamento, $provincia, $distrito, $fechaNacimiento, $estadoCivil, $tipoIngreso, $ingresoMensual);
        $stmtInsertCliente->execute();
        $clienteId = $stmtInsertCliente->insert_id;
    }

    // Insertar el estado_credito en la base de datos
    $estadoCredito = 'Pendiente'; // Estado inicial
    $cuotaInicial = $montoCredito * 0.1; // Ejemplo de cálculo para cuota inicial

    $queryCredito = "INSERT INTO creditos_hipotecarios (cliente_id, monto, cuota_inicial, plazo, estado_credito) VALUES (?, ?, ?, ?, ?)";
    $stmtCredito = $conexion->conexion->prepare($queryCredito);
    $stmtCredito->bind_param("iddis", $clienteId, $montoCredito, $cuotaInicial, $plazoCredito, $estadoCredito);
    $stmtCredito->execute();

    // Generar y mostrar el cronograma en PDF
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
?>
