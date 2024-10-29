<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../Model/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];
    
    if (empty($dni)) {
        $_SESSION['resultadoConsulta'] = "El DNI está vacío.";
        header("Location: ../view/consulta_credito.php");
        exit;
    }

    // Guarda el DNI en la sesión
    $_SESSION['dni'] = $dni;
    
    // Instanciar la conexión correctamente
    $conexion = new Conexion();
    
    // Consulta para obtener los datos del crédito usando el DNI del cliente
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
    
    if (!$stmt) {
        $_SESSION['resultadoConsulta'] = "Error en la preparación de la consulta: " . $conexion->conexion->error;
        header("Location: ../view/consulta_credito.php");
        exit;
    }
    
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $credito = $result->fetch_assoc();
        $_SESSION['resultadoConsulta'] = "
            <h4>Resultados de la consulta</h4>
            <p><strong>Nombre del Cliente:</strong> " . htmlspecialchars($credito['nombre']) . "</p>
            <p><strong>Importe del Crédito Solicitado:</strong> S/ " . number_format($credito['monto_credito'], 2) . "</p>
            <p><strong>Cuota Inicial:</strong> S/ " . number_format($credito['cuota_inicial'], 2) . "</p>
            <p><strong>Número de cuotas:</strong> " . htmlspecialchars($credito['numero_cuotas']) . "</p>";
    } else {
        $_SESSION['resultadoConsulta'] = "<p class='text-danger'>No se encontraron datos para el DNI ingresado.</p>";
    }

    $stmt->close();
    $conexion->cerrarConexion();

    header("Location: ../view/consulta_credito.php");
    exit;
}
?>
