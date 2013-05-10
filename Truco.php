<?php
require 'Mazo.php';
require 'Jugador.php';
require 'Mesa.php';
require 'Partida.php';


trait Session{
    public function initSession(){
        session_start();
    }

    public function setSession($name,$value){
        $_SESSION[$name] = $value ;
    }

    public function getSession($name){
        return $_SESSION[$name];
    }
}

class Truco {

    use Session;

    private $Mazo = false;
    private $Jugadores = false;

    private $Palos = [
        'Bastos',
        'Espadas',
        'Oros',
        'Copas'
        ];

    const CANTIDAD_CARTAS_POR_PALO = 12;

    public function __construct(){
        $this->initSession();
        $this->recoverState();
        $this->initJugadores();
        $this->initMazo();
        $this->initPartida();
    }

    public function recoverState(){
        if ( ($this->getSession('Mazo') instanceof Mazo)){
            echo 'recovered mazo</br>';
            $this->Mazo = $this->getSession('Mazo') ;
        }else{
            $this->initMazo();
        }

        if ( ($this->getSession('Jugadores') instanceof Jugadores)){
            echo 'recovered jugadores</br>';
            $this->Jugadores = $this->getSession('Jugadores');
        }else{
            $this->initJugadores();
        }

        if ( ($this->getSession('Partida') instanceof Partida)){
            echo 'recovered partida</br>';
            $this->Partida = $this->getSession('Partida');
        }else{
            $this->initPartida();
        }
    }

    public function initJugadores(){
        if (!$this->Jugadores){
            $Hernando = new Jugador('Hernando');
            $Enemigo = new Jugador('Enemigo');
            $Jugadores = new Jugadores($Hernando, $Enemigo);
            $this->Jugadores = $Jugadores;
            $this->setSession('Jugadores', $Jugadores);
        }
    }

    public function initMazo(){
        if ( !$this->Mazo ){
            $this->Mazo = new Mazo();
            foreach ( $this->Palos as $nombre_palo ){
                $Palo = new Palo($nombre_palo);
                for ( $i = 1; $i <= self::CANTIDAD_CARTAS_POR_PALO; $i++ ){
                    # le saco los 8 y 9 
                    if ($i <= 7 or $i >=10 ){ 
                        $this->Mazo->agregarCarta(new Carta($Palo, $i));
                    }
                }
            }
            $this->setSession('Mazo', $this->Mazo);
        }

        #$this->Mazo->printCartas();
    } 

    public function initPartida(){
        if (!$this->Partida && $this->Mazo instanceof Mazo && $this->Jugadores instanceof Jugadores){
            $Partida = new Partida($this->Jugadores, $this->Mazo);
            $this->setSession('Partida', $Partida);
        }
        $this->Partida->initMano();
    }
}

$Truco = new Truco();

