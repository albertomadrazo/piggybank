<?php

class Calculo{
    // El total a ahorrar
    public $cantidad;
    // El tiempo en ahorrar la totalidad
    public $periodo;
    
    // Cada cuanto tiempo se va a meter un abono
    public $intervalo;
    public $residuo;

    public $ahorro_parcial;
    public $restante;
    
    public $abono;

    function __construct($cantidad, $periodo, $intervalo){
        $this->cantidad   = $cantidad;
        $this->periodo    = $periodo;
        $this->intervalo = $intervalo;
    }

    public function linear_savings(){
        $this->total_de_abonos = (int)($this->periodo / $this->intervalo);
        $this->residuo = $this->cantidad % $this->total_de_abonos;
        $this->abono = ($this->cantidad - $this->residuo) / $this->total_de_abonos;     
        // $this->residuo  = $this->periodo % $this->intervalo;
    }


}

?>