<?php
class Jugador {
    use Entity;
    private $nombre;
    private $Reglas;
    private $UUID;

    public function __construct($nombre){
        $this->setNombre($nombre);
        $this->setUUID(uniqid());
    }

    public function verMano(){
        return $this->Mano->mostrarCartas();
    }

    public function darMano(Mano $Mano){
        $this->Mano = $Mano;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

}

class Jugadores {
    const CANTIDAD_MAXIMA_JUGADORES = 4;
    private $jugadores = array();
    public function __call($name,$arguments){
    }
    public function agregarJugador(Jugador &$jugador){
        $this->jugadores[$jugador->getUuid()] = &$jugador; 
    }

    public function __invoke($name){
        return $this->jugadores[$name]; 
    }

    public function getPlayerRegistry(){
        return array_keys($this->jugadores);
    }

    public function get($index){
        return $this->jugadores[$index];
    }

    public function getCantidadJugadores(){
        try{
            return count($this->jugadores);
        } catch (Exception $Exception){

        }
    }
}

trait Envido{
    protected $valor_cartas = [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 0,
        9 => 0, 
        10 => 0,
        11 => 0,
        12 => 0,
        ];

    public function calcularEnvido(){
        $mismo_palo = [];
        $total_envido = 0;
        foreach($this->cartas as $Carta){
            // agrupo las cartas del mismo palo
            // eligo las dos cartas mas altas del palo y las sumo

            if(array_key_exists($Carta->Palo->nombre,$mismo_palo)){
                $total_envido[$Carta->Palo->nombre] += '20';
            }
            $mismo_palo[$Carta->Palo->nombre]['n'][] = $this->valor_cartas[$Carta->numero];
        }
        // calculo el valor de mi envido

        foreach($mismo_palo as $pila => $palo){
            sort($mismo_palo[$pila]['n']);
        }
        foreach($mismo_palo as $pila => $palo){
            $cantidad_cartas_mismo_palo =count($mismo_palo[$pila]['n']); 

            if($cantidad_cartas_mismo_palo == 1){
                $mismo_palo[$pila]['total'] = $mismo_palo[$pila]['n'][0];
            }else if ($cantidad_cartas_mismo_palo == 2){
                $mismo_palo[$pila]['total'] = $mismo_palo[$pila]['n'][1] + $mismo_palo[$pila]['n'][0] + 20;
            }else if ($cantidad_cartas_mismo_palo == 3){
                $mismo_palo[$pila]['total'] = $mismo_palo[$pila]['n'][1] + $mismo_palo[$pila]['n'][2] + 20;
            }
            // eligo el mas alto
        }
        $anterior = 0;
        foreach($mismo_palo as $pila => $palo){
            if ($mismo_palo[$pila]['total'] > $anterior){
                $mas_puntaje = $pila;
                $anterior = $mismo_palo[$pila]['total'];
            }
        }
        return $mismo_palo[$mas_puntaje];
    }

}

class Mano {
    private $cartas = false;
    use Envido;
    use Debug;
    public function darCarta(Carta $Carta){
        $this->cartas[] = $Carta;
    }
    function getCarta($index){
        return $this->cartas[$index];
    }

    public function mostrarCartas(){
        return $this->cartas;
    }

}
