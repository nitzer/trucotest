<?php
require 'Mazo.php';
require 'Jugador.php';
require 'Mesa.php';
require 'Partida.php';

trait Events{
    protected $Event = array();
    public function setEvent($event,$val){
        $this->Event = array('name'=>$event,'context'=>$val);
        return $this->setSession($event,$val);
    }

    public function getEvent(){
        return $this->Event;
    }
}

trait Debug {
    public function debug($message){
        echo '<pre>';
        var_dump($message);
        echo '</pre>';
    }
}

trait Entity {
    private $uuid;
    public function setUuid($uuid){
        $this->uuid = $uuidu;
    }

    public function getUuid(){
        return $this->uuid;
    }
}

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
    use Events;

    private $Mazo = false;
    private $Jugadores = false;
    private $Palos = [
        'Bastos',
        'Espadas',
        'Oros',
        'Copas'
        ];

    const CANTIDAD_CARTAS_POR_PALO = 12;

    public function run(){
        $this->recoverState();
        $this->initJugadores();
        $this->initMazo();
        $this->initPartida();
    }
    public function __construct(){
        $this->initSession();
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
            // hardcoded very villanger
            $Hernando = new Jugador('Hernando');
            $Enemigo = new Jugador('Enemigo');
            $Jugadores = new Jugadores();
            $Jugadores->agregarJugador($Hernando);
            $Jugadores->agregarJugador($Enemigo);
            $this->Jugadores = &$Jugadores;
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
    } 

    public function initPartida(){
        if (!($this->Partida instanceof Partida) && $this->Mazo instanceof Mazo && $this->Jugadores instanceof Jugadores){
            $Partida = new Partida($this->Jugadores, $this->Mazo);
            $this->Partida = $Partida;
            $this->setSession('Partida', $Partida);
        }else{
            $this->Partida->continuePartida( $this->Event );
        }
    }
}

$Truco = new Truco();

