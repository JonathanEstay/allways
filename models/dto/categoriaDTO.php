<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class categoriaDTO
{
    private $_codigo;
    private $_nombre;
    
    public function setCodigo($cod)
    {
        $this->_codigo= $cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
    
    public function setNombre($nombre)
    {
        $this->_nombre= $nombre;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
}