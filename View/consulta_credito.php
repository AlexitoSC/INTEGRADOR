<?php
// Habilita la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Si hay un resultado en la sesión, lo asignamos a una variable y luego lo limpiamos
$resultadoConsulta = isset($_SESSION['resultadoConsulta']) ? $_SESSION['resultadoConsulta'] : "";
unset($_SESSION['resultadoConsulta']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Crédito</title>

    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #F3F4F6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h4 {
            color: #004481;
            margin-bottom: 10px;
        }

        label, p {
            color: #333;
            font-size: 16px;
        }

        .button, button[type="submit"] {
            display: inline-block;
            background-color: #FF6F00;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
        }

        .button:hover, button[type="submit"]:hover {
            background-color: #cc5700;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .result {
            margin-top: 20px;
            line-height: 1.6;
            text-align: left;
        }

        /* Ajuste para el formulario */
        form {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        // Mostrar solo el título adecuado según haya o no resultado de consulta
        if (empty($resultadoConsulta)) {
            echo "<h4>Consulta de Crédito</h4>";
            echo '<form action="../Controller/consultar_credito.php" method="POST">
                    <label for="dni">Ingrese DNI:</label>
                    <input type="text" name="dni" id="dni" required>
                    <button type="submit" class="button">Consultar Crédito</button>
                  </form>';
        } else {
            echo "<h4>Resultados de la consulta</h4>";
            echo "<div class='result'>$resultadoConsulta</div>";
            
            // Añade el botón para exportar a PDF
            echo '<form action="../exportar_consulta_pdf.php" method="post" target="_blank">
                    <button type="submit" class="button">Exportar a PDF</button>
                  </form>';
        }
        ?>
    </div>
</body>
</html>
