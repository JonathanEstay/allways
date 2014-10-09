<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class programaDTO
{
    private $_codigo;
    private $_nombre;
    private $_id;
    private $_ciudad;
    
    
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