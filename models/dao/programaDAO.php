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
    
    public function getIncluye($idPRG)
    {
        $sql="exec WEB_TraeDetalle '".$idPRG."' ";
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosInc= array();
            $arrayIncluye= $this->_db->fetchAll($datos);
            
            foreach ($arrayIncluye as $incDB)
            {
                $objIncluye= new incluyeDTO();
                
                $objIncluye->setCodigo(trim($incDB['codsvr']));
                $objIncluye->setNombre(trim($incDB['nombre']));
                $objIncluye->setCiudad(trim($incDB['ciudadHotel']));
                $objIncluye->setNoches((int)trim($incDB['Noches']));
                
                $objetosInc[]= $objIncluye;
            }
            
            return $objetosInc;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getAdmProgramas($ciudad=0, $codProg=0)
    {
        $and='';
        $sql='SELECT P.id, P.nombre, P.codigo, C.nombre AS nombreC
            FROM h2h_programa P
            JOIN ciudad	C ON (C.codigo = P.Ciudad)
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
                
                $objetosPack[]= $objPackages;
            }
            
            return $objetosPack;
        }
        else
        {
            return false;
        }
    }
    
    
    public function exeTraeProgramas($sql)
    {
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosPack= array();
            $arrayPackages= $this->_db->fetchAll($datos);
            
            foreach ($arrayPackages as $packDB)
            {
                $hotel= array();
                $codHotel= array();
                $PA= array();
                $TH= array();
                $codTH= array();
                $cat= array();
                $ciudad= array();
                $incluye= array();
                $valorHab= array();
                
                
                $objPackages= new programaDTO();
                
                if(trim($packDB['Error']))
                {
                    $objPackages->setERROR(trim($packDB['Error']));
                    $objPackages->setLINEA(trim($packDB['Linea']));
                    $objPackages->setMENSAJE(trim($packDB['Mensaje']));
                }
                else
                {
                    $objPackages->setId(trim($packDB['idPRG']));
                    $objPackages->setNombre(trim($packDB['nombrePRG']));
                    $objPackages->setNota(trim($packDB['notaPRG']));
                    $objPackages->setIdOpc(trim($packDB['idOpcion']));
                    $objPackages->setDesde(trim($packDB['desde']));
                    
                    $objPackages->setNotaOpc(trim($packDB['notaOPC']));
                    $objPackages->setMoneda(trim($packDB['moneda']));
                    $objPackages->setItiVuelo(trim($packDB['itinerarioVuelo']));
                    
                    /* VALOR HABITACION */
                    for ($i=1; $i<=3; $i++)
                    {
                        $valorHab[]=trim($packDB['vHab_'.$i]);
                    }
                    $objPackages->setValorHab($valorHab);
                    /* VALOR HABITACION */
                    
                    
                    /* HOTELES */
                    for($i=1; $i<=5; $i++)
                    {
                        $hotel[]=trim($packDB['hotel_'.$i]);
                        $codHotel[]=trim($packDB['codHotel_'.$i]);
                        $PA[]=trim($packDB['PlanAlimenticio_'.$i]);
                        $TH[]=trim($packDB['TipoHabitacion_'.$i]);
                        $codTH[]=trim($packDB['codTipoHabitacion_'.$i]);
                        $cat[]=trim($packDB['cat_'.$i]);
                        $ciudad[]=trim($packDB['ciudad_'.$i]);
                    }
                    
                    $objPackages->setHoteles($hotel);
                    $objPackages->setCodHoteles($codHotel);
                    $objPackages->setPA($PA);
                    $objPackages->setTH($TH);
                    $objPackages->setCodTH($codTH);
                    $objPackages->setCat($cat);
                    $objPackages->setCiudad($ciudad);
                    /* HOTELES */
                    
                    
                    $incluye[]= $this->getIncluye(trim($packDB['idPRG']));
                    $objPackages->setIncluye($incluye);
                    
                    //$objPackages->setXXXX(trim($packDB['xxxxx']));
                }
                
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