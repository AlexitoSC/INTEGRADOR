<!-- guarda este archivo como prueba_consulta.php en la carpeta view -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Crédito</title>
</head>
<body>
    <form action="../Controller/consultar_credito.php" method="POST">
        <label>Ingrese DNI:</label>
        <input type="text" name="dni" required>
        <button type="submit">Consultar Crédito</button>
    </form>
</body>
</html>
