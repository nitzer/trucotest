<?php
class Partida{
    private $uuid;
    const CANTIDAD_MAXIMA_PUNTOS = 30;
    private $puntos;
    const CANTIDAD_MAXIMA_CARTAS = 3;
    private $mano;
    const CANTIDAD_TURNOS = 3;
    private $num_turno;
    private $turnoActual = false;

    public function __construct(Jugadores $Jugadores, Mazo $Mazo){
        $this->uuid = uniqid();
        $this->Jugadores = $Jugadores;
        $this->Mazo = $Mazo;
        $this->initPartida();
    }

    public function initPartida(){
    }

    public function initMano(){
        $this->Mazo->mezclar();
        $this->repartir();
    }
    public function repartir(){
        // cartas repartidas = jugadores * CANTIDAD_MAXIMA_CARTAS
        $cantidad_jugadores = $this->Jugadores->getCantidadJugadores();
        $_jugador = 1;
        for ($cartas_repartidas = 0; $cartas_repartidas < ($cantidad_jugadores*3); $cartas_repartidas++){
            if ($_jugador > $cantidad_jugadores){
                $_jugador = 1;
            }
            $mano_jugador[$_jugador][] = $this->Mazo->darCarta(); 
            $_jugador ++;

        }
        foreach ($mano_jugador as $jugador){
            echo '<br> mano <br>';
            foreach($jugador as $mano){
                print $mano . '<br>';
            }
        } 
    }

    public function agregarPuntos(){
    } 

    public function setTurnoActual(Jugador $Jugador){
    }

}
