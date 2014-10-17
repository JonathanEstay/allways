<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class programaDTO
{
    private $_ERROR;
    private $_LINEA;
    private $_MSG;
    
    private $_codigo;
    private $_nombre;
    private $_id;
    private $_ciudad;
    private $_nota;
    private $_id_opc;
    private $_vhab_1;
    private $_vhab_2;
    private $_vhab_3;
    private $_nota_opc;
    private $_moneda;
    private $_itinerario_vuelo;
    
    private $_hoteles;
    private $_cod_hoteles;
    private $_pa;
    private $_th;
    private $_cod_th;
    private $_cat;
    
    private $_incluye;
    
    
    
    
    public function getIncluye()
    {
        return $this->_incluye;
    }
    public function setIncluye($inc)
    {
        $this->_incluye=$inc;
    }
    
    
    public function getCat()
    {
        return $this->_cat;
    }
    public function setCat($cat)
    {
        $this->_cat=$cat;
    }
    
    
    public function getCodTH()
    {
        return $this->_cod_th;
    }
    public function setCodTH($cth)
    {
        $this->_cod_th=$cth;
    }
    
    
    public function getTH()
    {
        return $this->_th;
    }
    public function setTH($th)
    {
        $this->_th=$th;
    }
    
    
    public function getPA()
    {
        return $this->_pa;
    }
    public function setPA($pa)
    {
        $this->_pa=$pa;
    }
    
    
    public function getHoteles()
    {
        return $this->_hoteles;
    }
    public function setHoteles($h)
    {
        $this->_hoteles=$h;
    }
    
    
    public function getCodHoteles()
    {
        return $this->_cod_hoteles;
    }
    public function setCodHoteles($ch)
    {
        $this->_cod_hoteles=$ch;
    }
    
    
    public function getIdOpc()
    {
        return $this->_id_opc;
    }
    public function setIdOpc($id)
    {
        $this->_id_opc=$id;
    }
    
    
    public function getNota()
    {
        return $this->_nota;
    }
    public function setNota($nota)
    {
        $this->_nota=$nota;
    }
    
    
    public function getLINEA()
    {
        return $this->_LINEA;
    }
    public function setLINEA($linea)
    {
        $this->_LINEA=$linea;
    }
    
    public function getMSG()
    {
        return $this->_MSG;
    }
    public function setMSG($msg)
    {
        $this->_MSG=$msg;
    }
    
    public function getERROR()
    {
        return $this->_ERROR;
    }
    public function setERROR($error)
    {
        $this->_ERROR=$error;
    }
    
    public function getCiudad()
    {
        return $this->_ciudad;
    }
    public function setCiudad($ciu)
    {
        $this->_ciudad=$ciu;
    }
    
    
    public function getId()
    {
        return $this->_id;
    }
    public function setId($id)
    {
        $this->_id=$id;
    }
    
    public function setCodigo($cod)
    {
        $this->_codigo=$cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
    
    public function setNombre($nombre)
    {
        $this->_nombre=$nombre;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
}