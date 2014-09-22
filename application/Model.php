<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class Model
{
    protected $_db;
    public function __construct() {
        $this->_db= new Database;
    }
}