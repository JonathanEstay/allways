<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class ciudadDTO
{
    private $_nombre;
    private $_codigo;
    
    public function setNombre($ciudad)
    {
        $this->_nombre=$ciudad;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
    
    public function setCodigo($cod)
    {
        $this->_codigo=$cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
}