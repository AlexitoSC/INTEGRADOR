<?php
// Habilita la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluye el archivo de conexión
require_once("../Model/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];
    
    if (empty($dni)) {
        echo "El DNI está vacío.";
        exit;
    }

    // Crea una instancia de la conexión
    $conexion = new Conexion();

    // Consulta para obtener los datos del crédito usando el DNI del cliente
    $query = "
        SELECT 
            clientes.nombre,
            creditos_hipotecarios.monto AS monto_credito,
            creditos_hipotecarios.cuota_inicial,
            creditos_hipotecarios.plazo,
            creditos_hipotecarios.tea AS tasa_interes,
            creditos_hipotecarios.estado_credito
        FROM 
            creditos_hipotecarios
        INNER JOIN 
            clientes 
        ON 
            creditos_hipotecarios.cliente_id = clientes.cliente_id
        WHERE 
            clientes.dni = ?";

    $stmt = $conexion->conexion->prepare($query);
    
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $conexion->conexion->error;
        exit;
    }
    
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $credito = $result->fetch_assoc();
        echo "<h4>Resultados de la consulta</h4>";
        echo "<p><strong>Nombre del Cliente:</strong> " . htmlspecialchars($credito['nombre']) . "</p>";
        echo "<p><strong>Importe del Crédito Solicitado:</strong> S/ " . number_format($credito['monto_credito'], 2) . "</p>";
        echo "<p><strong>Cuota Inicial:</strong> S/ " . number_format($credito['cuota_inicial'], 2) . "</p>";
        echo "<p><strong>Plazo (años):</strong> " . htmlspecialchars($credito['plazo']) . "</p>";
        echo "<p><strong>Tasa Efectiva Anual (TEA):</strong> " . htmlspecialchars($credito['tasa_interes']) . "%</p>";
        echo "<p><strong>Estado del Crédito:</strong> " . htmlspecialchars($credito['estado_credito']) . "</p>";
    } else {
        echo "<p class='text-danger'>No se encontraron datos para el DNI ingresado.</p>";
    }

    $stmt->close();
    $conexion->cerrarConexion();
}
?>
