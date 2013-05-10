<?php

class Mazo {
    private $cartas_init = [];
    private $cartas = [];

    public function agregarCarta( Carta $carta ){
        $this->cartas[] = $carta ;
        $this->cartas_init[] = $carta;
    }
    
    public function mezclar(){
        // vuelvo a tener todas las cartas del comienzo, deberia volver a
        // buscarlas de cada una de las manos, pero hoy no ;p
        $this->cartas = $this->cartas_init;
        shuffle($this->cartas);
    } 

    public function darCarta(){
        return array_shift($this->cartas); 
    }

    public function printCartas(){
        foreach ($this->cartas as $carta){
            print $carta . "\n";
        } 
    }
}

class Palo {
    public function __construct( $nombre ){
       $this->nombre = $nombre ; 
    }

    public function __toString(){
        return $this->nombre ;
    }
}

class Carta {

    public function __construct(Palo $palo, $numero){
        $this->palo = $palo;
        $this->numero = $numero;
    }

    public function __toString(){
        return sprintf('%s de %s', $this->numero, $this->palo);
    }

    public function esPalo( Palo $palo){
        return $this->palo === $palo;
    }

    public function getPalo(){
        return $this->palo;
    }

    public function getNumero(){
        return $this->numero;
    }
}


