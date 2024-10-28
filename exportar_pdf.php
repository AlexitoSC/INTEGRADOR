<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

// Configuración y generación del cronograma en HTML
function generarCronograma($monto, $plazo, $tea) {
    $tasa_mensual = pow(1 + $tea, 1/12) - 1;
    $cuota = $monto * $tasa_mensual / (1 - pow(1 + $tasa_mensual, -$plazo));

    $html = '<div style="text-align: center;">
                <img src="bcp-logo.PNG" alt="Logo BCP" width="120">
                <h2 style="color: #0033A0;">Cronograma de Pago</h2>
             </div>
             <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #0033A0; color: #FFFFFF;">
                        <th style="padding: 8px; border: 1px solid #0033A0;">Mes</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Cuota</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Interés</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Amortización</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Saldo</th>
                    </tr>
                </thead>
                <tbody>';

    $saldo = $monto;
    for ($i = 1; $i <= $plazo; $i++) {
        $interes = $saldo * $tasa_mensual;
        $amortizacion = $cuota - $interes;
        $saldo -= $amortizacion;

        $html .= '<tr' . (($i % 2 == 0) ? ' style="background-color: #e0e7ff;"' : '') . '>
                    <td style="padding: 8px; border: 1px solid #0033A0;">' . $i . '</td>
                    <td style="padding: 8px; border: 1px solid #0033A0; color: #FF6600; font-weight: bold;">' . number_format($cuota, 2) . '</td>
                    <td style="padding: 8px; border: 1px solid #0033A0;">' . number_format($interes, 2) . '</td>
                    <td style="padding: 8px; border: 1px solid #0033A0;">' . number_format($amortizacion, 2) . '</td>
                    <td style="padding: 8px; border: 1px solid #0033A0;">' . number_format($saldo, 2) . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Generación del PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("cronograma_pago.pdf", array("Attachment" => false));
}

generarCronograma(50000, 60, 0.12);
?>
