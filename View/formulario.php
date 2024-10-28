<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Crédito Hipotecario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Colores y estilos personalizados del BCP */
        body {
            background-color: #f3f6f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            padding: 25px;
            border: 2px solid #0033A0;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h2 {
            color: #0033A0;
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            color: #0033A0;
            font-weight: bold;
            font-size: 14px;
        }
        .form-control {
            border-radius: 8px;
        }
        .form-control:focus {
            border-color: #FF6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
        }
        .highlight {
            color: #FF6600;
        }
        .btn-primary {
            background-color: #0033A0;
            border-color: #0033A0;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #00236a;
            border-color: #00236a;
        }
        .form-text {
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Solicita tu Crédito Hipotecario</h2>
        
        <form id="creditoForm" action="/credito_hipotecario/Controller/procesar.php" method="POST" onsubmit="return verificarAdvertencia()">
            <!-- Información del cliente -->
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label>Apellidos:</label>
                <input type="text" class="form-control" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label>DNI:</label>
                <input type="text" class="form-control" name="dni" required maxlength="8" pattern="\d{8}" 
                oninvalid="this.setCustomValidity('Ingrese un DNI válido de 8 dígitos.')" 
                oninput="this.setCustomValidity('')" title="Debe contener exactamente 8 dígitos">
            </div>
            <div class="mb-3">
                <label>Fecha de nacimiento:</label>
                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required 
                onblur="validarEdad()">
                <small id="edadAdvertencia" class="form-text text-danger" style="display: none;">
                    Debe tener al menos 18 años para aplicar.
                </small>
            </div>
            <div class="mb-3">
                <label>Dirección:</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
            <div class="mb-3">
                <label>Teléfono:</label>
                <input type="text" class="form-control" name="telefono" required pattern="9\d{8}" 
                maxlength="9" oninvalid="this.setCustomValidity('Ingrese un teléfono válido de 9 dígitos comenzando con 9.')"
                oninput="this.setCustomValidity('')" title="Debe contener exactamente 9 dígitos y comenzar con 9">
            </div>
            <div class="mb-3">
                <label>Correo:</label>
                <input type="email" class="form-control" name="correo" required placeholder="example@correo.com">
            </div>
            <div class="mb-3">
                <label>Ingreso mensual:</label>
                <input type="number" class="form-control" step="0.01" name="ingreso_mensual" id="ingreso_mensual" min="1500" required 
                oninvalid="this.setCustomValidity('Para calificar, debe ganar al menos S/ 1500.')"
                oninput="this.setCustomValidity('')" placeholder="Para calificar debe ganar más o igual a S/1500">
            </div>

            <div class="mb-3">
                <label>Estado civil:</label>
                <select name="estado_civil" class="form-control" required>
                    <option value="Soltero">Soltero</option>
                    <option value="Casado">Casado</option>
                    <option value="Divorciado">Divorciado</option>
                    <option value="Viudo">Viudo</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Tipo de ingreso:</label>
                <select name="tipo_ingreso" class="form-control" required>
                    <option value="Dependiente">Dependiente</option>
                    <option value="Independiente">Independiente</option>
                    <option value="Mixto">Mixto</option>
                </select>
            </div>

            <!-- Tipo de inmueble -->
            <div class="mb-3">
                <label>Tipo de inmueble:</label>
                <select name="tipo_inmueble" class="form-control" required>
                    <option value="Vivienda construida">Vivienda construida</option>
                    <option value="Vivienda en planos">Vivienda en planos</option>
                    <option value="Vivienda en construcción">Vivienda en construcción</option>
                    <option value="Casa de campo">Casa de campo</option>
                    <option value="Casa de playa">Casa de playa</option>
                </select>
            </div>

            <!-- Información del crédito hipotecario -->
            <div class="mb-3">
                <label>Monto del crédito (S/):</label>
                <input type="number" class="form-control" step="0.01" name="monto_credito" id="monto_credito" min="32000" required 
                oninput="calcularCuotaInicial(); calcularTasa();" placeholder="Puedes financiarte desde S/ 32,000">
            </div>
            <div class="mb-3">
                <label>Cuota inicial (10% del monto del crédito):</label>
                <span class="highlight" id="cuota_inicial">0.00</span>
            </div>

            <div class="mb-3">
                <label>Plazo del crédito (años):</label>
                <input type="number" class="form-control" name="plazo_credito" min="4" max="25" required 
                oninput="calcularTasa(); calcularCuotaMensual()" placeholder="De 4 a 25 años de plazo" id="plazo_credito">
            </div>

            <!-- Tipo de seguro -->
            <div class="mb-3">
                <label>Tipo de seguro:</label>
                <select name="tipo_seguro" id="tipo_seguro" class="form-control" required>
                    <option value="" disabled selected>Seleccione un seguro</option>
                    <option value="Desgravamen">Seguro de desgravamen</option>
                    <option value="Inmueble">Seguro de inmueble</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Porcentaje de cobro del seguro:</label>
                <input type="text" class="form-control" id="porcentaje_seguro" readonly>
            </div>

            <div class="mb-3">
                <label>Proveedor del seguro:</label>
                <input type="text" class="form-control" name="proveedor_seguro" value="Mapfre" readonly>
            </div>

            <!-- Tasa de interés -->
            <div class="mb-3">
                <label>Tasa de interés (%):</label>
                <span id="tasa_interes"></span>
            </div>

            <div class="mb-3 text-danger" id="advertenciaCuota" style="display:none;">
                La cuota mensual es igual o mayor al 50% de su ingreso mensual. Esto puede representar un riesgo financiero.
            </div>

            <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
        </form>
    </div>

    <script>
        // Validación de la edad mínima de 18 años
        function validarEdad() {
            const fechaNacimiento = new Date(document.getElementById('fecha_nacimiento').value);
            const hoy = new Date();
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            const mes = hoy.getMonth() - fechaNacimiento.getMonth();

            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }

            const advertencia = document.getElementById('edadAdvertencia');
            if (edad < 18) {
                advertencia.style.display = 'block';
                return false;
            } else {
                advertencia.style.display = 'none';
                return true;
            }
        }

        // Calcula y muestra la cuota inicial
        function calcularCuotaInicial() {
            const monto = parseFloat(document.getElementById('monto_credito').value) || 0;
            document.getElementById('cuota_inicial').textContent = (monto * 0.10).toFixed(2);
        }

        // Event listeners para tasa y porcentaje de seguro
        document.getElementById('tipo_seguro').addEventListener('change', function() {
            const porcentaje = (this.value === "Desgravamen") ? "1.5%" : "2%";
            document.getElementById('porcentaje_seguro').value = porcentaje;
        });

        // Calcula y muestra la tasa de interés según el plazo
        function calcularTasa() {
            const plazo = parseInt(document.getElementById('plazo_credito').value);
            let tasa = '';

            if (plazo >= 4 && plazo <= 10) {
                tasa = '10%';
            } else if (plazo >= 11 && plazo <= 20) {
                tasa = '12%';
            } else if (plazo >= 21 && plazo <= 25) {
                tasa = '14%';
            }

            document.getElementById('tasa_interes').textContent = tasa;
        }

        // Verifica que la cuota mensual no exceda el 50% del ingreso
        function verificarAdvertencia() {
            const ingresoMensual = parseFloat(document.getElementById('ingreso_mensual').value);
            const cuotaInicial = parseFloat(document.getElementById('cuota_inicial').textContent);

            if (cuotaInicial >= ingresoMensual * 0.5) {
                document.getElementById('advertenciaCuota').style.display = 'block';
                return confirm("La cuota mensual es igual o mayor al 50% de su ingreso mensual. ¿Desea continuar?");
            } else {
                document.getElementById('advertenciaCuota').style.display = 'none';
                return validarEdad();
            }
        }
    </script>
</body>
</html>
