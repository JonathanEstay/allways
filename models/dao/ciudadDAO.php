<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class ciudadDAO extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getCiudades($ciudad='')
    {
        $sql='SELECT C.nombre AS cnombre, C.codigo AS ccodigo 
		FROM ciudad C ';

        if(!empty($ciudad))
        {
            $sql.=' WHERE C.nombre LIKE "'.$ciudad.'%" OR C.codigo LIKE "'.$ciudad.'%" ';
        }

        $sql.=' GROUP BY C.nombre, C.codigo
        ORDER BY C.nombre ASC';
                
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();
            
            foreach ($ciudadArray as $ciuDB)
            {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['cnombre']));
                $ciudadObj->setCodigo(trim($ciuDB['ccodigo']));
                
                $objetosCiudad[]=$ciudadObj;
            }
            
            return $objetosCiudad;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getCiudadesPRG($ciudad='')
    {
        $sql='SELECT C.nombre AS cnombre, C.codigo AS ccodigo 
		FROM ciudad C
		JOIN h2h_Programa P ON (C.codigo = P.Ciudad)
		JOIN h2h_ProgramaOpc PO ON (P.Id = PO.IdProg)';
		
        if(!empty($ciudad))
        {
            $sql.=' WHERE C.nombre LIKE "'.$ciudad.'%" OR C.codigo LIKE "'.$ciudad.'%"  AND PO.record_c <> "" ';
        }
        else
        {
            $sql.=' WHERE PO.record_c <> "" ';
        }

        $sql.=' GROUP BY C.nombre, C.codigo
        ORDER BY C.nombre ASC';
                
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $ciudadArray = $this->_db->fetchAll($datos);
            $objetosCiudad = array();
            
            foreach ($ciudadArray as $ciuDB)
            {
                $ciudadObj = new ciudadDTO();
                $ciudadObj->setNombre(trim($ciuDB['cnombre']));
                $ciudadObj->setCodigo(trim($ciuDB['ccodigo']));
                
                $objetosCiudad[]=$ciudadObj;
            }
            
            return $objetosCiudad;
        }
        else
        {
            return false;
        }
    }
}