<?php

class Partida{
    use Debug;
    use Entity;
    const CANTIDAD_MAXIMA_PUNTOS = 30;
    private $puntos;
    const CANTIDAD_MAXIMA_CARTAS = 3;
    private $mano;
    const CANTIDAD_TURNOS = 3;
    private $num_turno;
    private $turnoActual = false;
    private $playerRegistry = array();
    /**
     * turno es la mano en el truco, pero para evitar ambiguaciones, uso turno como
     * denominador y ronda como numero de mano jugada
     */
    private $turno = false;
    private $ronda = false;


    public function __construct(Jugadores &$Jugadores, Mazo &$Mazo){
        $this->setUUID(uniqid());
        $this->Jugadores = $Jugadores;
        $this->playerRegistry = $Jugadores->getPlayerRegistry();
        $this->Mazo = $Mazo;
        $this->initPartida();
    }

    public function initPartida(){
        $this->turno = 1;
        $this->ronda = 1;
        $this->initRonda();
    }

    public function continuePartida($Event){
        echo '<pre>continuando partida</pre>'; 
        switch($Event['name']){
        default:
            $this->debug($this->Jugadores->get($this->playerRegistry[0])->verMano());
            break;
        case 'calcular_envido':
            $this->debug($this->Jugadores->get($this->playerRegistry[0])->verMano());
            echo '<br>Envido:<br>';
            $this->debug($this->Jugadores->get($this->playerRegistry[0])->Mano->calcularEnvido());
            break;
        };
    }

    public function initRonda(){
        $this->jugadorMano = $this->playerRegistry[$this->ronda % $this->Jugadores->getCantidadJugadores()]; 
        $this->initMano();
    }

    public function initMano(){
        $this->Mazo->mezclar();
        $this->repartir();
    }

    public function repartir(){
        // cartas repartidas = jugadores * CANTIDAD_MAXIMA_CARTAS
        $cantidad_jugadores = $this->Jugadores->getCantidadJugadores();
        $mano_jugador = array() ;
        // reparto cada carta a cada jugador 
        for ($cartas_repartidas = 0; $cartas_repartidas < ($cantidad_jugadores*3); $cartas_repartidas++){
            // el jugador sale del registro de jugadores
            $mano_jugador[$this->playerRegistry[$cartas_repartidas % 2]][] = $this->Mazo->darCarta(); 
        }

        foreach ($mano_jugador as $jugador=>$mano){
            $Mano = new Mano();
            foreach($mano as $carta){
                $Mano->darCarta($carta);
            }
            $this->Jugadores->get($jugador)->darMano($Mano);
        } 
    }
}
