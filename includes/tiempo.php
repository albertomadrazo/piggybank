<?php

class Tiempo extends DatabaseObject{

    public $intervalo;
    public $intervalo_en_texto;

    public static function dia($dias=1){
        return $dias * 86400;
    }

    public static function fecha_de_hoy(){
        $timestamp = time();
        return strftime("%d-%m-%y", $timestamp);
    }

    public function convertir_intervalo_a_texto($intervalo){
        switch($intervalo){
            case 1:
                $intervalo_en_texto = "diario";
                break;
            case 7:
                $intervalo_en_texto = "semana";
                break;
            case 30:
                $intervalo_en_texto = "mes";
                break;
            case 365:
                $intervalo_en_texto = "a&ntilde;o";
                break;
            default:
                $intervalo_en_texto = "---";
        }

        return $intervalo_en_texto;
    }

    public static function calcular_periodo($desde, $hasta){
        $stamp_desde = strtotime($desde);
        $stamp_hasta = strtotime($hasta);

        $days = (int)(abs($stamp_hasta - $stamp_desde)/60/60/24);

        return $days;   
    }

    public static function cantidad_de_intervalos($fecha_inicial, $fecha_final, $intervalo){
        $fecha_inicial = strtotime($fecha_inicial);
        $fecha_final = strtotime($fecha_final);

        return (int)(($fecha_final - $fecha_inicial) / Tiempo::dia($intervalo));
    }

    public static function plazo_vencido($fecha, $intervalo){
        // Tiempo::plazo_vencido(strtotime('+369 days'), 'año');

        switch($intervalo){
            case 'dia':
                $plazo = '+1 day';
                break;
            case 'semana':
                $plazo = '+1 week';
                break;
            case 'quincena':
                $plazo = '+2 weeks 1 day';
                break;
            case 'mes':
                $plazo = '+1 month';
                break;
            case 'año':
                $plazo = '+1 year';
                break;
            default:
                $plazo = '+1 week';
        }

        if($fecha >= strtotime($plazo)){
            return true;
            echo "<br> Ha pasado mas de {$intervalo}<br>";
        } else{
            return false;
            echo "<br> No ha pasado {$intervalo} aun<br>"; 
        }
    }
}

?>