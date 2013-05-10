<?php
class Jugador {
    private $nombre;
    private $Reglas;

    public function __construct($nombre){
        $this->setNombre($nombre);

    }

    public function darMano(Mano $Mano){
        $this->Mano = $Mano;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function esTurno(){

    }

    public function tieneEnvido(){

    }

    public function anunciarEnvido(){

    }

    public function cantarEnvido(){

    }

    public function quererEnvido(Boolean $respuesta ){

    }
}

class Jugadores {
    public $jugador1 = false;
    public $jugador2 = false;
    public function __construct($jugador1, $jugador2){
        $this->jugador1 = $jugador1;
        $this->jugador2 = $jugador2; 
    }

    public function getCantidadJugadores(){
        return 2;
    }
}

class Mano {
    private $cartas = false;
    public function darCarta(Carta $Carta){
        $this->cartas[] = $Carta;
    }
}
