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
                    <option value="Soltero(a)">Soltero(a)</option>
                    <option value="Casado(a)">Casado(a)</option>
                    <option value="Divorciado(a)">Divorciado(a)</option>
                    <option value="Viudo(a)">Viudo(a)</option>
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
            <div class="mb-3">
                <label>Dirección:</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
            <!-- Departamento, Provincia y Distrito -->
            <div class="mb-3">
                <label>Departamento:</label>
                <select id="departamento" name="departamento" class="form-control" required onchange="cargarProvincias()">
                    <option value="">Seleccione un Departamento</option>
                    <option value="Lima">Lima</option>

                    <option value="Amazonas">Amazonas</option>
                    <option value="Áncash">Áncash</option>
                    <option value="Apurímac">Apurímac</option>
                    <option value="Arequipa">Arequipa</option>
                    <option value="Ayacucho">Ayacucho</option>
                    <option value="Cajamarca">Cajamarca</option>
                    <option value="Cusco">Cusco</option>
                    <option value="Huancavelica">Huancavelica</option>
                    <option value="Huánuco">Huánuco</option>
                    <option value="Ica">Ica</option>
                    <option value="Junín">Junín</option>
                    <option value="La Libertad">La Libertad</option>
                    <option value="Lambayeque">Lambayeque</option>
                    <option value="Loreto">Loreto</option>
                    <option value="Madre de Dios">Madre de Dios</option>
                    <option value="Moquegua">Moquegua</option>
                    <option value="Pasco">Pasco</option>
                    <option value="Piura">Piura</option>
                    <option value="Puno">Puno</option>
                    <option value="San Martín">San Martín</option>
                    <option value="Tacna">Tacna</option>
                    <option value="Tumbes">Tumbes</option>
                    <option value="Ucayali">Ucayali</option>
               </select>
            </div>
            <div class="mb-3">
                <label>Provincia:</label>
                <select id="provincia" name="provincia" class="form-control" required onchange="cargarDistritos()">
                    <option value="">Seleccione una Provincia</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Distrito:</label>
                <select id="distrito" name="distrito" class="form-control" required>
                    <option value="">Seleccione un Distrito</option>
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
        // Arrays para departamentos, provincias y distritos
        const departamentos = {
            
    "Lima": {
        "Lima": ["Ancón", "Ate", "Barranco", "Breña","Callao", "Carabayllo", "Cercado de Lima", "Chaclacayo", "Chorrillos", "Cieneguilla", "Comas", "El Agustino", "Independencia", "Jesús María", "La Molina", "La Victoria", "Lince", "Los Olivos", "Lurigancho", "Lurín", "Magdalena del Mar", "Miraflores", "Pachacámac", "Pucusana", "Pueblo Libre", "Puente Piedra", "Punta Hermosa", "Punta Negra", "Rímac", "San Bartolo", "San Borja", "San Isidro", "San Juan de Lurigancho", "San Juan de Miraflores", "San Luis", "San Martín de Porres", "San Miguel", "Santa Anita", "Santa María del Mar", "Santa Rosa", "Santiago de Surco", "Surquillo", "Villa El Salvador", "Villa María del Triunfo"],
        "Barranca": ["Barranca", "Paramonga", "Pativilca", "Supe", "Supe Puerto"],
        "Cajatambo": ["Cajatambo", "Copa", "Gorgor", "Huancapón", "Manás"],
        "Canta": ["Canta", "Arahuay", "Huamantanga", "Huaros", "Lachaqui", "San Buenaventura", "Santa Rosa de Quives"],
        "Cañete": ["San Vicente de Cañete", "Asia", "Calango", "Cerro Azul", "Chilca", "Coayllo", "Imperial", "Lunahuaná", "Mala", "Nuevo Imperial", "Pacarán", "Quilmaná", "San Antonio", "San Luis de Cañete", "Santa Cruz de Flores", "Zúñiga"],
        "Huaral": ["Huaral", "Atavillos Alto", "Atavillos Bajo", "Aucallama", "Chancay", "Ihuarí", "Lampian", "Pacaraos", "Santa Cruz de Andamarca", "Sumbilca", "Veintisiete de Noviembre"],
        "Huarochirí": ["Matucana", "Antioquía", "Callahuanca", "Carampoma", "Chicla", "Cuenca", "Huachupampa", "Huanza", "Huarochirí", "Lahuaytambo", "Langa", "Laraos", "Mariatana", "Ricardo Palma", "San Andrés de Tupicocha", "San Antonio", "San Bartolomé", "San Damián", "San Juan de Iris", "San Juan de Tantaranche", "San Lorenzo de Quinti", "San Mateo", "San Mateo de Otao", "San Pedro de Casta", "San Pedro de Huancayre", "Sangallaya", "Santa Cruz de Cocachacra", "Santa Eulalia", "Santiago de Anchucaya", "Santiago de Tuna", "Santo Domingo de los Olleros", "Surco"],
        "Huaura": ["Huacho", "Ámbar", "Caleta de Carquín", "Checras", "Hualmay", "Huaura", "Leoncio Prado", "Paccho", "Santa Leonor", "Santa María", "Sayán", "Végueta"],
        "Oyón": ["Oyón", "Andajes", "Caujul", "Cochamarca", "Naván", "Pachangara"],
        "Yauyos": ["Yauyos", "Alis", "Ayauca", "Ayavirí", "Azángaro", "Cacra", "Carania", "Catahuasi", "Chocos", "Cochas", "Colonia", "Hongos", "Huampara", "Huancaya", "Huangáscar", "Huantán", "Huañec", "Laraos", "Lincha", "Madean", "Miraflores", "Omas", "Putinza", "Quinches", "Quinocay", "San Joaquín", "San Pedro de Pilas", "Tanta", "Tauripampa", "Tomas", "Tupe", "Viñac", "Vitis"]
    },

// inicio

    "Amazonas": {
        "Chachapoyas": ["Chachapoyas", "Asunción", "Balsas", "Cheto", "Chiliquín", "Chuquibamba", "Granada", "Huancas", "La Jalca", "Leimebamba", "Levanto", "Magdalena", "Mariscal Castilla", "Molinopampa", "Montevideo", "Olleros", "Quinjalca", "San Francisco de Daguas", "San Isidro de Maino", "Soloco", "Sonche"],
        "Bagua": ["Bagua", "Aramango", "Copallín", "El Parco", "Imaza", "La Peca"],
        "Bongará": ["Jumbilla", "Chisquilla", "Churuja", "Corosha", "Cuispes", "Florida", "Jazán", "Recta", "San Carlos", "Shipasbamba", "Valera", "Yambrasbamba"],
        "Condorcanqui": ["Santa María de Nieva", "El Cenepa", "Río Santiago"],
        "Luya": ["Lamud", "Camporredondo", "Cocabamba", "Colcamar", "Conila", "Inguilpata", "Longuita", "Lonya Chico", "Luya", "Luya Viejo", "María", "Ocalli", "Ocumal", "Pisuquia", "Providencia", "San Cristóbal", "San Francisco del Yeso", "San Jerónimo", "San Juan de Lopecancha", "Santa Catalina", "Santo Tomás", "Tingo", "Trita"],
        "Rodríguez de Mendoza": ["San Nicolás", "Chirimoto", "Cochamal", "Huambo", "Limabamba", "Longar", "Mariscal Benavides", "Milpuc", "Omia", "Santa Rosa", "Totora", "Vista Alegre"],
        "Utcubamba": ["Bagua Grande", "Cajaruro", "Cumba", "El Milagro", "Jamalca", "Lonya Grande", "Yamón"]
    },
    
    "Áncash": {
        "Huaraz": ["Huaraz", "Cochabamba", "Colcabamba", "Huanchay", "Independencia", "Jangas", "La Libertad", "Olleros", "Pampas", "Pariacoto", "Pira", "Tarica"],
        "Aija": ["Aija", "Coris", "Huacllán", "La Merced", "Succha"],
        "Antonio Raymondi": ["Llamellín", "Aczo", "Chaccho", "Chingas", "Mirgas", "San Juan de Rontoy"],
        "Asunción": ["Chacas", "Acochaca"],
        "Bolognesi": ["Chiquián", "Abelardo Pardo Lezameta", "Antonio Raymondi", "Aquia", "Cajacay", "Canis", "Colquioc", "Huallanca", "Huasta", "Huayllacayán", "La Primavera", "Mangas", "Pacllón", "San Miguel de Corpanqui", "Ticllos"],
        "Carhuaz": ["Carhuaz", "Acopampa", "Amashca", "Anta", "Ataquero", "Marcara", "Pariahuanca", "San Miguel de Aco", "Shilla", "Tinco", "Yungar"],
        "Carlos Fermín Fitzcarrald": ["Yauya", "San Luis", "San Nicolás"],
        "Casma": ["Casma", "Buena Vista Alta", "Comandante Noel", "Yaután"],
        "Corongo": ["Corongo", "Aco", "Bambas", "Cusca", "La Pampa", "Yanac", "Yupan"],
        "Huari": ["Huari", "Anra", "Cajay", "Chavín de Huántar", "Huacachi", "Huacchis", "Huántar", "Masin", "Paucas", "Pontó", "Rahuapampa", "Rapayán", "San Marcos", "San Pedro de Chaná", "Uco"],
        "Huarmey": ["Huarmey", "Cochapeti", "Culebras", "Huayan", "Malvas"],
        "Huaylas": ["Caraz", "Huallanca", "Huata", "Huaylas", "Mato", "Pamparomás", "Pueblo Libre", "Santa Cruz", "Santo Toribio", "Yuracmarca"],
        "Mariscal Luzuriaga": ["Piscobamba", "Casca", "Eleazar Guzmán Barrón", "Fidel Olivas Escudero", "Llama", "Llumpa", "Lucma", "Musga"],
        "Ocros": ["Ocros", "Acas", "Cajamarquilla", "Carhuapampa", "Cochas", "Congas", "Llipa", "San Cristóbal de Raján", "San Pedro", "Santiago de Chilcas"],
        "Pallasca": ["Cabana", "Bolognesi", "Conchucos", "Huacaschuque", "Huandoval", "Lacabamba", "Llapo", "Pallasca", "Pampas", "Santa Rosa", "Tauca"],
        "Pomabamba": ["Pomabamba", "Huayllán", "Parobamba", "Quinuabamba"],
        "Recuay": ["Recuay", "Catac", "Cotaparaco", "Huayllapampa", "Llacllín", "Marca", "Pampas Chico", "Pararín", "Tapacocha", "Ticapampa"],
        "Santa": ["Chimbote", "Cáceres del Perú", "Coishco", "Macate", "Moro", "Nepeña", "Samanco", "Santa"],
        "Sihuas": ["Sihuas", "Acobamba", "Alfonso Ugarte", "Cashapampa", "Chingalpo", "Huayllabamba", "Quiches", "Ragash", "San Juan", "Sicsibamba"],
        "Yungay": ["Yungay", "Cascapara", "Mancos", "Matacoto", "Quillo", "Ranrahirca", "Shupluy", "Yanama"]
    },
    
    "Apurímac": {
        "Abancay": ["Abancay", "Chacoche", "Circa", "Curahuasi", "Huanipaca", "Lambrama", "Pichirhua", "San Pedro de Cachora", "Tamburco"],
        "Andahuaylas": ["Andahuaylas", "Andarapa", "Chiara", "Huancarama", "Huancaray", "Huayana", "Kishuara", "Pacobamba", "Pacucha", "Pampachiri", "Pomacocha", "San Antonio de Cachi", "San Jerónimo", "San Miguel de Chaccrampa", "Santa María de Chicmo", "Talavera", "Tumay Huaraca", "Turpo"],
        "Antabamba": ["Antabamba", "El Oro", "Huaquirca", "Juan Espinoza Medrano", "Oropesa", "Pachaconas", "Sabaino"],
        "Aymaraes": ["Chalhuanca", "Capaya", "Caraybamba", "Chaparura", "Colcabamba", "Cotaruse", "Huayllo", "Justo Apu Sahuaraura", "Lucre", "Pocohuanca", "San Juan de Chacña", "Sañayca", "Soraya", "Tapairihua", "Tintay", "Toraya", "Yanaca"],
        "Cotabambas": ["Tambobamba", "Cotabambas", "Coyllurqui", "Haquira", "Mara", "Challhuahuacho"],
        "Chincheros": ["Chincheros", "Anco_Huallo", "Cocharcas", "Huaccana", "Ocobamba", "Ongoy", "Ranracancha", "Uranmarca"],
        "Grau": ["Chuquibambilla", "Curpahuasi", "Gamarra", "Huayllati", "Mamara", "Micaela Bastidas", "Pataypampa", "Progreso", "San Antonio", "Santa Rosa", "Turpay", "Vilcabamba", "Virundo", "Curasco"]
    },
    
    "Arequipa": {
        "Arequipa": ["Arequipa", "Alto Selva Alegre", "Cayma", "Cerro Colorado", "Characato", "Chiguata", "Jacobo Hunter", "La Joya", "Mariano Melgar", "Miraflores", "Mollebaya", "Paucarpata", "Pocsi", "Polobaya", "Quequeña", "Sabandía", "Sachaca", "San Juan de Siguas", "San Juan de Tarucani", "Santa Isabel de Siguas", "Santa Rita de Siguas", "Socabaya", "Tiabaya", "Uchumayo", "Vitor", "Yanahuara", "Yarabamba", "Yura"],
        "Camana": ["Camana", "Jose Maria Quimper", "Mariano Nicolas Valcarcel", "Mariscal Caceres", "Nicolas de Pierola", "Ocoña", "Quilca", "Samuel Pastor"],
        "Caraveli": ["Caraveli", "Acarí", "Atico", "Atiquipa", "Bella Unión", "Cahuacho", "Chala", "Chaparra", "Huanuhuanu", "Jaqui", "Lomas", "Quicacha", "Yauca"],
        "Castilla": ["Aplao", "Andagua", "Ayo", "Chachas", "Chilcaymarca", "Choco", "Huancarqui", "Machaguay", "Orcopampa", "Pampacolca", "Tipan", "Uñon", "Uraca", "Viraco"],
        "Caylloma": ["Chivay", "Achoma", "Cabanaconde", "Callalli", "Caylloma", "Coporaque", "Huambo", "Huanca", "Ichupampa", "Lari", "Lluta", "Maca", "Madrigal", "San Antonio de Chuca", "Sibayo", "Tapay", "Tisco", "Tuti", "Yanque"],
        "Condesuyos": ["Chuquibamba", "Andaray", "Cayarani", "Chichas", "Iray", "Río Grande", "Salamanca", "Yanaquihua"],
        "Islay": ["Mollendo", "Cocachacra", "Dean Valdivia", "Islay", "Mejia", "Punta de Bombón"],
        "La Unión": ["Cotahuasi", "Alca", "Charcana", "Huaynacotas", "Pampamarca", "Puyca", "Quechualla", "Sayla", "Tauria", "Tomepampa", "Toro"]
    },

    "Ayacucho": {
        "Huamanga": ["Ayacucho", "Acocro", "Acos Vinchos", "Carmen Alto", "Chiara", "Ocros", "Pacaycasa", "Quinua", "San José de Ticllas", "San Juan Bautista", "Santiago de Pischa", "Socos", "Tambillo", "Vinchos"],
        "Cangallo": ["Cangallo", "Chuschi", "Los Morochucos", "María Parado de Bellido", "Paras", "Totos"],
        "Huanca Sancos": ["Sancos", "Carapo", "Sacsamarca", "Santiago de Lucanamarca"],
        "Huanta": ["Huanta", "Ayahuanco", "Huamanguilla", "Iguain", "Luricocha", "Santillana", "Sivia", "Llochegua", "Canayre", "Uchuraccay", "Pucacolpa", "Chaca"],
        "La Mar": ["San Miguel", "Anco", "Ayna", "Chilcas", "Chungui", "Luis Carranza", "Santa Rosa", "Tambo", "Samugari", "Anchihuay", "Oronccoy"],
        "Lucanas": ["Puquio", "Aucara", "Cabana", "Carmen Salcedo", "Chaviña", "Chipao", "Huac-Huas", "Laramate", "Leoncio Prado", "Llauta", "Lucanas", "Ocaña", "Otoca", "Saisa", "San Cristóbal", "San Juan", "San Pedro", "San Pedro de Palco", "Sancos", "Santa Ana de Huaycahuacho", "Santa Lucia"],
        "Parinacochas": ["Coracora", "Chumpi", "Coronel Castañeda", "Pacapausa", "Pullo", "Puyusca", "San Francisco de Ravacayco", "Upahuacho"],
        "Páucar del Sara Sara": ["Pausa", "Colta", "Corculla", "Lampa", "Marcabamba", "Oyolo", "Pararca", "San Javier de Alpabamba", "San José de Ushua", "Sara Sara"],
        "Sucre": ["Querobamba", "Belén", "Chalcos", "Chilcayoc", "Huacaña", "Morcolla", "Paico", "San Pedro de Larcay", "San Salvador de Quije", "Santiago de Paucaray", "Soras"],
        "Víctor Fajardo": ["Huancapi", "Alcamenca", "Apongo", "Asquipata", "Canaria", "Cayara", "Colca", "Huamanquiquia", "Huancaraylla", "Huaya", "Sarhua", "Vilcanchos"],
        "Vilcas Huamán": ["Vilcas Huamán", "Accomarca", "Carhuanca", "Concepción", "Huambalpa", "Independencia", "Saurama", "Vischongo"]
    },

    "Cajamarca": {
        "Cajamarca": ["Cajamarca", "Asunción", "Chetilla", "Cospán", "Encañada", "Jesús", "Llacanora", "Los Baños del Inca", "Magdalena", "Matara", "Namora", "San Juan"],
        "Cajabamba": ["Cajabamba", "Cachachi", "Condebamba", "Sitacocha"],
        "Celendín": ["Celendín", "Chumuch", "Cortegana", "Huasmin", "Jorge Chávez", "José Gálvez", "La Libertad de Pallán", "Miguel Iglesias", "Oxamarca", "Sorochuco", "Sucre", "Utco"],
        "Chota": ["Chota", "Anguia", "Chadin", "Chiguirip", "Chimban", "Choropampa", "Cochabamba", "Conchan", "Huambos", "Lajas", "Llama", "Miracosta", "Paccha", "Pion", "Querocoto", "San Juan de Licupis", "Tacabamba", "Tocmoche"],
        "Contumazá": ["Contumazá", "Chilete", "Cupisnique", "Guzmango", "San Benito", "Santa Cruz de Toledo", "Tantarica", "Yonán"],
        "Cutervo": ["Cutervo", "Callayuc", "Choros", "Cujillo", "La Ramada", "Pimpingos", "Querocotillo", "San Andrés de Cutervo", "San Juan de Cutervo", "San Luis de Lucma", "Santa Cruz", "Santo Domingo de la Capilla", "Santo Tomas", "Socota", "Toribio Casanova"],
        "Hualgayoc": ["Bambamarca", "Chugur", "Hualgayoc"],
        "Jaén": ["Jaén", "Bellavista", "Chontali", "Colasay", "Huabal", "Las Pirias", "Pomahuaca", "Pucara", "Sallique", "San Felipe", "San José del Alto", "Santa Rosa"],
        "San Ignacio": ["San Ignacio", "Chirinos", "Huarango", "La Coipa", "Namballe", "San José de Lourdes", "Tabaconas"],
        "San Marcos": ["Pedro Gálvez", "Chancay", "Eduardo Villanueva", "Gregorio Pita", "Ichocán", "José Manuel Quiroz", "José Sabogal"],
        "San Miguel": ["San Miguel", "Bolívar", "Calquis", "Catilluc", "El Prado", "La Florida", "Llapa", "Nanchoc", "Niepos", "San Gregorio", "San Silvestre de Cochan", "Tongod", "Unión Agua Blanca"],
        "San Pablo": ["San Pablo", "San Bernardino", "San Luis", "Tumbaden"],
        "Santa Cruz": ["Santa Cruz", "Andabamba", "Catache", "Chancaybaños", "La Esperanza", "Ninabamba", "Pulan", "Saucepampa", "Sexi", "Uticyacu", "Yauyucan"]
    },

    "Cusco": {
        "Cusco": ["Cusco", "Ccorca", "Poroy", "San Jerónimo", "San Sebastián", "Santiago", "Saylla", "Wanchaq"],
        "Acomayo": ["Acomayo", "Acopia", "Acos", "Mosoc Llacta", "Pomacanchi", "Rondocan", "Sangarará"],
        "Anta": ["Anta", "Ancahuasi", "Cachimayo", "Chinchaypujio", "Huarocondo", "Limatambo", "Mollepata", "Pucyura", "Zurite"],
        "Calca": ["Calca", "Coya", "Lamay", "Lares", "Pisac", "San Salvador", "Taray", "Yanatile"],
        "Canas": ["Yanaoca", "Checca", "Kunturkanki", "Langui", "Layo", "Pampamarca", "Quehue", "Túpac Amaru"],
        "Canchis": ["Sicuani", "Checacupe", "Combapata", "Marangani", "Pitumarca", "San Pablo", "San Pedro", "Tinta"],
        "Chumbivilcas": ["Santo Tomás", "Capacmarca", "Chamaca", "Colquemarca", "Livitaca", "Llusco", "Quiñota", "Velille"],
        "Espinar": ["Espinar", "Condoroma", "Coporaque", "Ocoruro", "Pallpata", "Pichigua", "Suyckutambo", "Alto Pichigua"],
        "La Convención": ["Quillabamba", "Echarate", "Huayopata", "Inkawasi", "Kimbiri", "Maranura", "Megantoni", "Ocobamba", "Pichari", "Santa Ana", "Santa Teresa", "Vilcabamba", "Villa Virgen", "Villa Kintiarina"],
        "Paruro": ["Paruro", "Accha", "Ccapi", "Colcha", "Huanoquite", "Omacha", "Paccaritambo", "Pillpinto", "Yaurisque"],
        "Paucartambo": ["Paucartambo", "Caicay", "Challabamba", "Colquepata", "Huancarani", "Kosñipata"],
        "Quispicanchi": ["Urcos", "Andahuaylillas", "Camanti", "Ccarhuayo", "Ccatca", "Cusipata", "Huaro", "Lucre", "Marcapata", "Ocongate", "Oropesa", "Quiquijana"],
        "Urubamba": ["Urubamba", "Chinchero", "Huayllabamba", "Machupicchu", "Maras", "Ollantaytambo", "Yucay"]
    },

    "Huancavelica": {
        "Huancavelica": ["Huancavelica", "Acobambilla", "Acoria", "Conayca", "Cuenca", "Huachocolpa", "Huando", "Huayllahuara", "Izcuchaca", "Laria", "Manta", "Mariscal Cáceres", "Moya", "Nuevo Occoro", "Palca", "Pilchaca", "Vilca", "Yauli", "Ascensión"],
        "Acobamba": ["Acobamba", "Andabamba", "Anta", "Caja", "Marcas", "Paucara", "Pomacocha", "Rosario"],
        "Angaraes": ["Lircay", "Anchonga", "Callanmarca", "Ccochaccasa", "Chincho", "Congalla", "Huanca-Huanca", "Huayllay Grande", "Julcamarca", "San Antonio de Antaparco", "Santo Tomás de Pata", "Secclla"],
        "Castrovirreyna": ["Castrovirreyna", "Arma", "Aurahua", "Capillas", "Chupamarca", "Cocas", "Huachos", "Huamatambo", "Mollepampa", "San Juan", "Santa Ana", "Tantara", "Ticrapo"],
        "Churcampa": ["Churcampa", "Anco", "Chinchihuasi", "El Carmen", "La Merced", "Locroja", "Paucarbamba", "San Miguel de Mayocc", "San Pedro de Coris", "Pachamarca", "Cosme"],
        "Huaytará": ["Huaytará", "Ayavi", "Cordova", "Huayacundo Arma", "Laramarca", "Ocoyo", "Pilpichaca", "Querco", "Quito-Arma", "San Antonio de Cusicancha", "San Francisco de Sangayaico", "San Isidro", "Santiago de Chocorvos", "Santiago de Quirahuara", "Santo Domingo de Capillas", "Tambo"],
        "Tayacaja": ["Pampas", "Acostambo", "Acraquia", "Ahuaycha", "Colcabamba", "Daniel Hernández", "Huachocolpa", "Huaribamba", "Ñahuimpuquio", "Pazos", "Quishuar", "Salcabamba", "Salcahuasi", "San Marcos de Rocchac", "Surcubamba", "Tintay Puncu", "Quichuas", "Andaymarca", "Roble"]
    },

    "Huánuco": {
        "Huánuco": ["Huánuco", "Amarilis", "Chinchao", "Churubamba", "Margos", "Pillco Marca", "Quisqui", "San Francisco de Cayrán", "San Pedro de Chaulán", "Santa María del Valle", "Yarumayo"],
        "Ambo": ["Ambo", "Cayna", "Colpas", "Conchamarca", "Huacar", "San Francisco", "San Rafael", "Tomay Kichwa"],
        "Dos de Mayo": ["La Unión", "Chuquis", "Marías", "Pachas", "Quivilla", "Ripan", "Shunqui", "Sillapata", "Yanas"],
        "Huacaybamba": ["Huacaybamba", "Canchabamba", "Cochabamba", "Pinra"],
        "Huamalíes": ["Llata", "Arancay", "Chavín de Pariarca", "Jacas Grande", "Jircan", "Miraflores", "Monzón", "Punchao", "Puños", "Singa", "Tantamayo"],
        "Leoncio Prado": ["Rupa Rupa", "Daniel Alomía Robles", "Hermilio Valdizán", "José Crespo y Castillo", "Luyando", "Mariano Damaso Beraun", "Pucayacu", "Castillo Grande"],
        "Marañón": ["Huacrachuco", "Cholon", "San Buenaventura"],
        "Pachitea": ["Panao", "Chaglla", "Molino", "Umari"],
        "Puerto Inca": ["Puerto Inca", "Codo del Pozuzo", "Honoria", "Tournavista", "Yuyapichis"],
        "Lauricocha": ["Jesús", "Baños", "Jivia", "Queropalca", "Rondos", "San Francisco de Asís", "San Miguel de Cauri"],
        "Yarowilca": ["Chavinillo", "Cahuac", "Chacabamba", "Aparicio Pomares", "Jacas Chico", "Obas", "Pampamarca"]
    },

    "Ica": {
        "Ica": ["Ica", "La Tinguiña", "Los Aquijes", "Ocucaje", "Pachacutec", "Parcona", "Pueblo Nuevo", "Salas", "San José de los Molinos", "San Juan Bautista", "Santiago", "Subtanjalla", "Tate", "Yauca del Rosario"],
        "Chincha": ["Chincha Alta", "Alto Larán", "Chavín", "Chincha Baja", "El Carmen", "Grocio Prado", "Pueblo Nuevo", "San Juan de Yanac", "San Pedro de Huacarpana", "Sunampe", "Tambo de Mora"],
        "Nazca": ["Nazca", "Changuillo", "El Ingenio", "Marcona", "Vista Alegre"],
        "Palpa": ["Palpa", "Llipata", "Río Grande", "Santa Cruz", "Tibillo"],
        "Pisco": ["Pisco", "Huancano", "Humay", "Independencia", "Paracas", "San Andrés", "San Clemente", "Tupac Amaru Inca"]
    },

    "Junín": {
        "Huancayo": ["Huancayo", "Carhuacallanga", "Chacapampa", "Chicche", "Chilca", "Chongos Alto", "Chupaca", "Colca", "Cullhuas", "El Tambo", "Huacrapuquio", "Hualhuas", "Huancán", "Huasicancha", "Huayucachi", "Ingenio", "Pariahuanca", "Pilcomayo", "Pucará", "Quilcas", "San Agustín", "San Jerónimo de Tunán", "Santo Domingo de Acobamba", "Sapallanga", "Sicaya", "Viques"],
        "Concepción": ["Concepción", "Aco", "Andamarca", "Chambara", "Cochas", "Comas", "Heroínas Toledo", "Manzanares", "Mariscal Castilla", "Matahuasi", "Mito", "Nueve de Julio", "Orcotuna", "San José de Quero", "Santa Rosa de Ocopa"],
        "Chanchamayo": ["Chanchamayo", "San Ramón", "Perené", "Pichanaqui", "San Luis de Shuaro", "Vitoc"],
        "Jauja": ["Jauja", "Acolla", "Apata", "Ataura", "Canchayllo", "Curicaca", "El Mantaro", "Huamali", "Huaripampa", "Huertas", "Janjaillo", "Julcán", "Leonor Ordóñez", "Llocllapampa", "Marco", "Masma", "Masma Chicche", "Molinos", "Monobamba", "Muqui", "Muquiyauyo", "Paca", "Paccha", "Pancán", "Parco", "Pomacancha", "Ricran", "San Lorenzo", "San Pedro de Chunan", "Sausa", "Sincos", "Tunanmarca", "Yauli", "Yauyos"],
        "Junín": ["Junín", "Carhuamayo", "Ondores", "Ulcumayo"],
        "Satipo": ["Satipo", "Coviriali", "Llaylla", "Mazamari", "Pampa Hermosa", "Pangoa", "Río Negro", "Río Tambo"],
        "Tarma": ["Tarma", "Acobamba", "Huaricolca", "Huasahuasi", "La Unión", "Palca", "Palcamayo", "San Pedro de Cajas", "Tapo"],
        "Yauli": ["La Oroya", "Chacapalpa", "Huay-Huay", "Marcapomacocha", "Morococha", "Paccha", "Santa Bárbara de Carhuacayán", "Santa Rosa de Sacco", "Suitucancha", "Yauli"],
        "Chupaca": ["Chupaca", "Ahuac", "Chongos Bajo", "Huachac", "Huamancaca Chico", "San Juan de Yscos", "San Juan de Jarpa", "Tres de Diciembre", "Yanacancha"]
    },

    "La Libertad": {
        "Trujillo": ["Trujillo", "El Porvenir", "Florencia de Mora", "Huanchaco", "La Esperanza", "Laredo", "Moche", "Poroto", "Salaverry", "Simbal", "Victor Larco Herrera"],
        "Ascope": ["Ascope", "Casa Grande", "Chicama", "Chocope", "Magdalena de Cao", "Paiján", "Rázuri", "Santiago de Cao"],
        "Bolívar": ["Bolívar", "Bambamarca", "Condormarca", "Longotea", "Uchumarca", "Ucuncha"],
        "Chepén": ["Chepén", "Pacanga", "Pueblo Nuevo"],
        "Gran Chimú": ["Cascas", "Lucma", "Marmot", "Sayapullo"],
        "Julcán": ["Julcán", "Calamarca", "Carabamba", "Huaso"],
        "Otuzco": ["Otuzco", "Agallpampa", "Charat", "Huaranchal", "La Cuesta", "Mache", "Paranday", "Salpo", "Sinsicap", "Usquil"],
        "Pacasmayo": ["San Pedro de Lloc", "Guadalupe", "Jequetepeque", "Pacasmayo", "San José"],
        "Pataz": ["Tayabamba", "Buldibuyo", "Chillia", "Huancaspata", "Huaylillas", "Huayo", "Ongón", "Parcoy", "Pataz", "Pías", "Santiago de Challas", "Taurija", "Urpay"],
        "Sánchez Carrión": ["Huamachuco", "Chugay", "Cochorco", "Curgos", "Marcabal", "Sanagorán", "Sarin", "Sartimbamba"],
        "Santiago de Chuco": ["Santiago de Chuco", "Angasmarca", "Cachicadán", "Mollebamba", "Mollepata", "Quiruvilca", "Santa Cruz de Chuca", "Sitabamba"],
        "Gran Chimú": ["Cascas", "Lucma", "Marmot", "Sayapullo"],
        "Virú": ["Virú", "Chao", "Guadalupito"]
    },

    "Lambayeque": {
        "Chiclayo": ["Chiclayo", "Cayaltí", "Chongoyape", "Eten", "Eten Puerto", "José Leonardo Ortiz", "La Victoria", "Lagunas", "Monsefú", "Nueva Arica", "Oyotún", "Picsi", "Pimentel", "Pomalca", "Pucalá", "Reque", "Santa Rosa", "Saña", "Cruz de Lambayeque", "Tumán"],
        "Ferreñafe": ["Ferreñafe", "Cañaris", "Incahuasi", "Manuel Antonio Mesones Muro", "Pitipo", "Pueblo Nuevo"],
        "Lambayeque": ["Lambayeque", "Chochope", "Illimo", "Jayanca", "Mochumí", "Morrope", "Motupe", "Olmos", "Pacora", "Salas", "San José", "Túcume"]
    },
   
    "Loreto": {
        "Maynas": ["Iquitos", "Alto Nanay", "Fernando Lores", "Indiana", "Las Amazonas", "Mazan", "Napo", "Punchana", "Putumayo", "Torres Causana", "Belén", "San Juan Bautista"],
        "Alto Amazonas": ["Yurimaguas", "Balsapuerto", "Jeberos", "Lagunas", "Santa Cruz", "Teniente César López Rojas"],
        "Datem del Marañón": ["Barranca", "Cahuapanas", "Manseriche", "Morona", "Pastaza", "Andoas"],
        "Loreto": ["Nauta", "Parinari", "Tigre", "Trompeteros", "Urarinas"],
        "Mariscal Ramón Castilla": ["Ramón Castilla", "Pebas", "Yavari", "San Pablo"],
        "Requena": ["Requena", "Alto Tapiche", "Capelo", "Emilio San Martín", "Maquia", "Puinahua", "Saquena", "Soplin", "Tapiche", "Jenaro Herrera", "Yaquerana"],
        "Ucayali": ["Contamana", "Inahuaya", "Padre Márquez", "Pampa Hermosa", "Sarayacu", "Vargas Guerra"]
    },
   
    "Madre de Dios": {
        "Tambopata": ["Tambopata", "Inambari", "Las Piedras", "Laberinto"],
        "Manu": ["Manu", "Fitzcarrald", "Madre de Dios", "Huepetuhe"],
        "Tahuamanu": ["Iñapari", "Iberia", "Tahuamanu"]
    },
   
    "Moquegua": {
        "Mariscal Nieto": ["Moquegua", "Carumas", "Cuchumbaya", "Samegua", "San Cristóbal", "Torata"],
        "General Sánchez Cerro": ["Omate", "Chojata", "Coalaque", "Ichuña", "La Capilla", "Lloque", "Matalaque", "Puquina", "Quinistaquillas", "Ubinas", "Yunga"],
        "Ilo": ["Ilo", "El Algarrobal", "Pacocha"]
    },
   
    "Pasco": {
        "Pasco": ["Chaupimarca", "Huachon", "Huariaca", "Huayllay", "Ninacaca", "Pallanchacra", "Paucartambo", "San Francisco de Asís de Yarusyacan", "Simon Bolívar", "Ticlacayán", "Tinyahuarco", "Vicco", "Yanacancha"],
        "Daniel Alcides Carrión": ["Yanahuanca", "Chacayan", "Goyllarisquizga", "Paucar", "San Pedro de Pillao", "Santa Ana de Tusi", "Tapuc", "Vilcabamba"],
        "Oxapampa": ["Oxapampa", "Chontabamba", "Huancabamba", "Palcazú", "Pozuzo", "Puerto Bermúdez", "Villa Rica", "Constitución"]
    },

    "Piura": {
        "Piura": ["Piura", "Castilla", "Catacaos", "Cura Mori", "El Tallán", "La Arena", "La Unión", "Las Lomas", "Tambo Grande"],
        "Ayabaca": ["Ayabaca", "Frias", "Jilili", "Lagunas", "Montero", "Pacaipampa", "Paimas", "Sapillica", "Sicchez", "Suyo"],
        "Huancabamba": ["Huancabamba", "Canchaque", "El Carmen de la Frontera", "Huarmaca", "Lalaquiz", "San Miguel de El Faique", "Sondor", "Sondorillo"],
        "Morropón": ["Chulucanas", "Buenos Aires", "Chalaco", "La Matanza", "Morropon", "Salitral", "San Juan de Bigote", "Santa Catalina de Mossa", "Santo Domingo", "Yamango"],
        "Paita": ["Paita", "Amotape", "Arenal", "Colán", "La Huaca", "Tamarindo", "Vichayal"],
        "Sechura": ["Sechura", "Bellavista de la Unión", "Bernal", "Cristo Nos Valga", "Rinconada Llicuar", "Vice"],
        "Sullana": ["Sullana", "Bellavista", "Ignacio Escudero", "Lancones", "Marcavelica", "Miguel Checa", "Querecotillo", "Salitral"],
        "Talara": ["Pariñas", "El Alto", "La Brea", "Lobitos", "Los Órganos", "Máncora"]
    },

    "Puno": {
        "Puno": ["Puno", "Acora", "Amantani", "Atuncolla", "Capachica", "Chucuito", "Coata", "Huata", "Mañazo", "Paucarcolla", "Pichacani", "Platería", "San Antonio", "Tiquillaca", "Vilque"],
        "Azángaro": ["Azángaro", "Achaya", "Arapa", "Asillo", "Caminaca", "Chupa", "José Domingo Choquehuanca", "Muñani", "Potoni", "Saman", "San Antón", "San José", "San Juan de Salinas", "Santiago de Pupuja", "Tirapata"],
        "Carabaya": ["Macusani", "Ajoyani", "Ayapata", "Coasa", "Corani", "Crucero", "Ituata", "Ollachea", "San Gaban", "Usicayos"],
        "Chucuito": ["Juli", "Desaguadero", "Huacullani", "Kelluyo", "Pisacoma", "Pomata", "Zepita"],
        "El Collao": ["Ilave", "Capazo", "Pilcuyo", "Santa Rosa", "Conduriri"],
        "Huancané": ["Huancané", "Cojata", "Huatasani", "Inchupalla", "Pusi", "Rosaspata", "Taraco", "Vilque Chico"],
        "Lampa": ["Lampa", "Cabanilla", "Calapuja", "Nicasio", "Ocuviri", "Palca", "Paratia", "Pucará", "Santa Lucía", "Vilavila"],
        "Melgar": ["Ayaviri", "Antauta", "Cupi", "Llalli", "Macari", "Nuñoa", "Orurillo", "Santa Rosa", "Umachiri"],
        "Moho": ["Moho", "Conima", "Huayrapata", "Tilali"],
        "San Antonio de Putina": ["Putina", "Ananea", "Pedro Vilca Apaza", "Quilcapuncu", "Sina"],
        "San Román": ["Juliaca", "Cabana", "Cabanillas", "Caracoto"],
        "Sandia": ["Sandia", "Cuyocuyo", "Limbani", "Patambuco", "Phara", "Quiaca", "San Juan del Oro", "Yanahuaya", "Alto Inambari", "San Pedro de Putina Punco"],
        "Yunguyo": ["Yunguyo", "Anapia", "Copani", "Cuturapi", "Ollaraya", "Tinicachi", "Unicachi"]
    },

    "San Martín": {
        "Moyobamba": ["Moyobamba", "Calzada", "Habana", "Jepelacio", "Soritor", "Yantalo"],
        "Bellavista": ["Bellavista", "Alto Biavo", "Bajo Biavo", "Huallaga", "San Pablo", "San Rafael"],
        "El Dorado": ["San José de Sisa", "Agua Blanca", "San Martín", "Santa Rosa", "Shatoja"],
        "Huallaga": ["Saposoa", "Alto Saposoa", "El Eslabón", "Piscoyacu", "Sacanche", "Tingo de Saposoa"],
        "Lamas": ["Lamas", "Alonso de Alvarado", "Barranquita", "Caynarachi", "Cuñumbuqui", "Pinto Recodo", "Rumisapa", "San Roque de Cumbaza", "Shanao", "Tabalosos", "Zapatero"],
        "Mariscal Cáceres": ["Juanjuí", "Campanilla", "Huicungo", "Pachiza", "Pajarillo"],
        "Picota": ["Picota", "Buenos Aires", "Caspisapa", "Pilluana", "Pucacaca", "San Cristóbal", "San Hilarión", "Shamboyacu", "Tingo de Ponasa", "Tres Unidos"],
        "Rioja": ["Rioja", "Awajun", "Elias Soplin Vargas", "Nueva Cajamarca", "Pardo Miguel", "Posic", "San Fernando", "Yorongos", "Yuracyacu"],
        "San Martín": ["Tarapoto", "Alberto Leveau", "Cacatachi", "Chazuta", "Chipurana", "El Porvenir", "Huimbayoc", "Juan Guerra", "La Banda de Shilcayo", "Morales", "Papaplaya", "San Antonio", "Sauce", "Shapaja"],
        "Tocache": ["Tocache", "Nuevo Progreso", "Polvora", "Shunte", "Uchiza"]
    },

    "Tacna": {
        "Tacna": ["Tacna", "Alto de la Alianza", "Calana", "Ciudad Nueva", "Inclan", "Pachía", "Palca", "Pocollay", "Sama", "Coronel Gregorio Albarracín Lanchipa"],
        "Candarave": ["Candarave", "Cairani", "Camilaca", "Curibaya", "Huanuara", "Quilahuani"],
        "Jorge Basadre": ["Locumba", "Ilabaya", "Ite"],
        "Tarata": ["Tarata", "Chucatamani", "Estique", "Estique-Pampa", "Sitajara", "Susapaya", "Tarucachi", "Ticaco"]
    },

    "Tumbes": {
        "Tumbes": ["Tumbes", "Corrales", "La Cruz", "Pampas de Hospital", "San Jacinto", "San Juan de la Virgen"],
        "Contralmirante Villar": ["Zorritos", "Casitas", "Canoas de Punta Sal"],
        "Zarumilla": ["Zarumilla", "Aguas Verdes", "Matapalo", "Papayal"]
    },
    "Ucayali": {
        "Coronel Portillo": ["Pucallpa", "Calleria", "Campoverde", "Iparia", "Manantay", "Masisea", "Yarinacocha", "Nueva Requena"],
        "Atalaya": ["Raymondi", "Sepahua", "Tahuania", "Yurua"],
        "Padre Abad": ["Padre Abad", "Irazola", "Curimana", "Neshuya", "Alexander Von Humboldt"],
        "Purús": ["Purus"]
    }

// fin
        };

        function cargarProvincias() {
            const provinciaSelect = document.getElementById("provincia");
            const departamento = document.getElementById("departamento").value;
            provinciaSelect.innerHTML = "<option value=''>Seleccione una Provincia</option>";
            
            if (departamento && departamentos[departamento]) {
                for (const provincia in departamentos[departamento]) {
                    let option = document.createElement("option");
                    option.value = provincia;
                    option.textContent = provincia;
                    provinciaSelect.appendChild(option);
                }
            }
            cargarDistritos(); // Resetea el campo de distritos
        }

        function cargarDistritos() {
            const distritoSelect = document.getElementById("distrito");
            const departamento = document.getElementById("departamento").value;
            const provincia = document.getElementById("provincia").value;
            distritoSelect.innerHTML = "<option value=''>Seleccione un Distrito</option>";
            
            if (departamento && provincia && departamentos[departamento][provincia]) {
                departamentos[departamento][provincia].forEach(distrito => {
                    let option = document.createElement("option");
                    option.value = distrito;
                    option.textContent = distrito;
                    distritoSelect.appendChild(option);
                });
            }
        }

        // Validación de la edad mínima de 18 años y otros scripts aquí
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
