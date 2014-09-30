<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class bloqueoDTO
{
    private $_notas;
    
    public function setNotas($notas)
    {
        $this->_notas=$notas;
    }
    public function getNotas()
    {
        return $this->_notas;
    }
}