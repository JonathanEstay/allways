<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class programaDAO extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getPackages($cod)
    {
        $sql='SELECT * FROM packages WHERE codigo = "'.$cod.'" ';
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $objPackages= new programaDTO();
                
                $objPackages->setCodigo(trim($packDB['codigo']));
                $objPackages->setNombre(trim($packDB['nombre']));
                
                $objetosPack[]= $objPackages;
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getAdmProgramas($ciudad=0, $codProg=0)
    {
        $and='';
        $sql='SELECT P.id, P.nombre, P.codigo, C.nombre AS nombreC, PDF.ruta_pdf
            FROM h2h_programa P
            JOIN ciudad	C ON (C.codigo = P.Ciudad)
            LEFT JOIN h2h_pdfprog PDF ON (PDF.codigo= P.codigo)
            WHERE ';
        if(!empty($ciudad))
        {
            $sql.=' C.nombre = "'.trim($ciudad).'" ';
            $and=' AND ';
        }

        if(!empty($codProg))
        {
            $sql.=$and.' P.codigo="'.$codProg.'" ';
        }

        $sql.='ORDER BY P.nombre ASC ';
        
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $objPackages= new programaDTO();
                
                $objPackages->setCodigo(trim($packDB['codigo']));
                $objPackages->setNombre(trim($packDB['nombre']));
                $objPackages->setId(trim($packDB['id']));
                $objPackages->setCiudad(trim($packDB['nombreC']));
                $objPackages->setPDF(trim($packDB['ruta_pdf']));
                
                $objetosPack[]= $objPackages;
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
}