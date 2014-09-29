<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class reservaDTO
{
    private $_agencia;
    private $_num_file;
    private $_nompax;
    private $_totventa;
    private $_estado;
    private $_totpag;
    private $_usuario;
    private $_moneda;
    private $_fecha;
    private $_fecha2;
    private $_f_viaje;
    private $_f_viaje2;
    private $_row;
    
    public function setAgencia($agen)
    {
        $this->_agencia=$agen;
    }
    public function getAgencia()
    {
        return $this->_agencia;
    }
    
    
    public function setFile($file)
    {
        $this->_num_file=$file;
    }
    public function getFile()
    {
        return $this->_num_file;
    }
    
    
    public function setNomPax($nompax)
    {
        $this->_nompax=$nompax;
    }
    public function getNomPax()
    {
        return $this->_nompax;
    }
    
    
    public function setTotVenta($tventa)
    {
        $this->_totventa=$tventa;
    }
    public function getTotVenta()
    {
        return $this->_totventa;
    }
    
    
    public function setEstado($estado)
    {
        $this->_estado=$estado;
    }
    public function getEstado()
    {
        return $this->_estado;
    }
    
    
    public function setTotPag($tpag)
    {
        $this->_totpag=$tpag;
    }
    public function getTotPag()
    {
        return $this->_totpag;
    }
    
    
    public function setUsuario($user)
    {
        $this->_usuario=$user;
    }
    public function getUsuario()
    {
        return $this->_usuario;
    }
    
    
    public function setMoneda($mon)
    {
        $this->_moneda=$mon;
    }
    public function getMoneda()
    {
        return $this->_moneda;
    }
    
    
    public function setFecha($fecha)
    {
        $this->_fecha=$fecha;
    }
    public function getFecha()
    {
        return $this->_fecha;
    }
    
    
    public function setFecha2($fecha2)
    {
        $this->_fecha2=$fecha2;
    }
    public function getFecha2()
    {
        return $this->_fecha2;
    }
    
    
    public function setFViaje($fviaje)
    {
        $this->_f_viaje=$fviaje;
    }
    public function getFViaje()
    {
        return $this->_f_viaje;
    }
    
    
    public function setFViaje2($fviaje2)
    {
        $this->_f_viaje2=$fviaje2;
    }
    public function getFViaje2()
    {
        return $this->_f_viaje2;
    }
    
    
    public function setRow($row)
    {
        $this->_row=$row;
    }
    public function getRow()
    {
        return $this->_row;
    }
}