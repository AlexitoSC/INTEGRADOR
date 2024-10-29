<?php

class CreditoHipotecario {
    private $nombre;
    private $apellidos;
    private $dni;
    private $correo;
    private $ingresoMensual;
    private $montoCredito;
    private $plazoCredito;
    private $tasaInteres;
    private $tipoSeguro;
    private $departamento;
    private $provincia;
    private $distrito;
    private $fechaNacimiento;
    private $estadoCivil;
    private $tipoIngreso;

    public function __construct($nombre, $apellidos, $dni, $correo, $ingresoMensual, $montoCredito, $plazoCredito, $tipoSeguro, $departamento, $provincia, $distrito, $fechaNacimiento, $estadoCivil, $tipoIngreso) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->dni = $dni;
        $this->correo = $correo;
        $this->ingresoMensual = $ingresoMensual;
        $this->montoCredito = $montoCredito;
        $this->plazoCredito = $plazoCredito * 12; // Convertir años a meses
        $this->tipoSeguro = $tipoSeguro;
        $this->departamento = $departamento;
        $this->provincia = $provincia;
        $this->distrito = $distrito;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->estadoCivil = $estadoCivil;
        $this->tipoIngreso = $tipoIngreso;
        $this->tasaInteres = $this->calcularTasaInteres();
    }

    // Método para calcular la tasa de interés según el plazo del crédito
    private function calcularTasaInteres() {
        if ($this->plazoCredito >= 48 && $this->plazoCredito <= 120) {
            return 0.10; // 10% para 4 a 10 años
        } elseif ($this->plazoCredito >= 121 && $this->plazoCredito <= 240) {
            return 0.12; // 12% para 11 a 20 años
        } elseif ($this->plazoCredito >= 241 && $this->plazoCredito <= 300) {
            return 0.14; // 14% para 21 a 25 años
        } else {
            throw new Exception("El plazo del crédito no es válido.");
        }
    }

    // Método para calcular el seguro mensual en función del saldo restante
    private function calcularSeguroMensual($saldo) {
        $porcentajeSeguro = ($this->tipoSeguro === 'Desgravamen') ? 0.003 : 0.002; // 0.3% o 0.2% del saldo restante
        return $saldo * $porcentajeSeguro;
    }

    // Método para calcular la cuota mensual (sin el seguro) y luego se sumará cada mes
    private function calcularCuotaBase() {
        $tasaMensual = $this->tasaInteres / 12;
        return $this->montoCredito * ($tasaMensual / (1 - pow(1 + $tasaMensual, -$this->plazoCredito)));
    }

    // Método para generar el cronograma en HTML
    public function generarCronograma() {
        $saldo = $this->montoCredito;
        $tasaMensual = $this->tasaInteres / 12;
        $cuotaBase = $this->calcularCuotaBase();

        $html = '
            <h2 style="text-align: center; color: #0033A0;">Cronograma de Pago</h2>
            <p><strong>Nombre del Cliente:</strong> ' . $this->getNombreCompleto() . '</p>
            <p><strong>DNI:</strong> ' . $this->dni . '</p>
            <p><strong>Correo:</strong> ' . $this->correo . '</p>
            <p><strong>Ingreso Mensual:</strong> S/ ' . number_format($this->ingresoMensual, 2) . '</p>
            <p><strong>Departamento:</strong> ' . $this->departamento . '</p>
            <p><strong>Provincia:</strong> ' . $this->provincia . '</p>
            <p><strong>Distrito:</strong> ' . $this->distrito . '</p>
            <p><strong>Tasa de Interés:</strong> ' . $this->getTasaInteres() . '</p>
            <p><strong>Seguro:</strong> ' . $this->tipoSeguro . ' - Calculado sobre el saldo restante</p>
            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                <thead>
                    <tr style="background-color: #0033A0; color: white;">
                        <th style="padding: 8px; border: 1px solid #0033A0;">Mes</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Cuota</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Interés</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Amortización</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Seguro</th>
                        <th style="padding: 8px; border: 1px solid #0033A0;">Saldo</th>
                    </tr>
                </thead>
                <tbody>';

        for ($i = 1; $i <= $this->plazoCredito; $i++) {
            $interes = $saldo * $tasaMensual;
            $amortizacion = $cuotaBase - $interes;
            $saldo -= $amortizacion;
            $seguroMensual = $this->calcularSeguroMensual($saldo);
            $cuotaTotal = $cuotaBase + $seguroMensual;

            $html .= "<tr style='background-color:" . ($i % 2 == 0 ? "#e0e7ff" : "#ffffff") . ";'>
                        <td style='padding: 8px; border: 1px solid #0033A0;'>$i</td>
                        <td style='padding: 8px; border: 1px solid #0033A0;'>S/ " . number_format($cuotaTotal, 2) . "</td>
                        <td style='padding: 8px; border: 1px solid #0033A0;'>S/ " . number_format($interes, 2) . "</td>
                        <td style='padding: 8px; border: 1px solid #0033A0;'>S/ " . number_format($amortizacion, 2) . "</td>
                        <td style='padding: 8px; border: 1px solid #0033A0;'>S/ " . number_format($seguroMensual, 2) . "</td>
                        <td style='padding: 8px; border: 1px solid #0033A0;'>S/ " . number_format($saldo, 2) . "</td>
                    </tr>";
        }

        $html .= '</tbody></table>';

        return $html;
    }

    // Métodos para obtener los valores de los atributos
    public function getNombreCompleto() {
        return $this->nombre . ' ' . $this->apellidos;
    }

    public function getDNI() {
        return $this->dni;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getIngresoMensual() {
        return $this->ingresoMensual;
    }

    public function getMontoCredito() {
        return $this->montoCredito;
    }

    public function getPlazoCredito() {
        return $this->plazoCredito;
    }

    public function getTasaInteres() {
        return ($this->tasaInteres * 100) . '% (TEA)';
    }

    public function getTipoSeguro() {
        return $this->tipoSeguro;
    }
}

?>
