<?php



/**
 * Description of Tienda
 *
 * @author JaimeI
 */
class Tienda extends Model{
    //put your code here
    protected static $table = "Tienda";
    
    private $id;
    private $owner;
    private $titulo;
    
    private $has_one = array(
        
            'Owner' => array(
                'class' => 'Usuario',
                'join_as' => 'owner',
                'join_with' => 'id'
            )
        
        );
    
    function __construct($titulo, $id = null, $owner = null) {
        $this->id = $id;
        $this->owner = $owner;
        $this->titulo = $titulo;
    }
    
    public function getMyVars(){
        return get_object_vars($this);
    }

    function getId() {
        return $this->id;
    }

    function getOwner() {
        return $this->owner;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setOwner($owner) {
        $this->owner = $owner;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function getHas_one() {
        return $this->has_one;
    }

    function setHas_one($has_one) {
        $this->has_one = $has_one;
    }
    
}
