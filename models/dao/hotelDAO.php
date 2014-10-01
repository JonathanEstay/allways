<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class hotelDAO extends Model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getHoteles($hotel, $ciudad, $cat)
    {
        $sql='SELECT codigo, hotel, pais, ciudad, fono, direc, cat, ope, convert(varchar, nota) as nota, rut, dv, suc, fax, razon, nombre2, compve, compvn, compvr, prio, codsicon, codclisi, crubro, estado, 
	      timestamp_column, email, marca, usuariocrea, fechacrea, usuariomod, fechamod, marca_web, marca_web_R, Allot_web, Allot_web_R, Marca_Web_P, marca_sur, 
	      tipo_comag, femergen, fcomision, SWEB, restaurante, bar, cafeteria, s_habitacion, busness_center, internet_hotel, estacionamiento, piscina_cub, piscina_des, gym, 
	      spa, tenis, guarderia, salas_reunion, jardin, discapacitados, bautique, acondicionado, calefaccion, no_fuma, caja_fuerte, mini_bar, television, tv_cable, inter_hab, 
	      secador_pelo, barra_seguridad, lavanderia, telefono, img_encabezado, img_contenido, img_contenido2, img_contenido3, img_contenido4, mini_img_encabezado, 
	      mini_img_contenido, mini_img_contenido2, mini_img_contenido3, mini_img_contenido4, lat, lon, child_free, prepago, dias_prepago, comag
            FROM hotel WHERE 1=1 ';

        if(!empty($hotel))
        {
            $sql.='AND hotel LIKE "%'.$hotel.'%" ';
        }

        if(!empty($ciudad))
        {
            $sql.='AND ciudad="'.$ciudad.'" '; /*mb_convert_encoding(trim($ciudad), 'ISO-8859-1', 'UTF-8')*/
        }

        if(!empty($cat))
        {
            $sql.='AND cat="'.$cat.'" ';
        }

        $sql.=' ORDER BY hotel ASC';
        
        //echo $sql; exit;
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosHotel= array();
            $arrayHotel= $this->_db->fetchAll($datos);
            
            foreach ($arrayHotel as $hDB)
            {
                $objHotel= new hotelDTO();
                
                $objHotel->setCodigo(trim($hDB['codigo']));
                $objHotel->setHotel(trim($hDB['hotel']));
                $objHotel->setPais(trim($hDB['pais']));
                $objHotel->setCiudad(trim($hDB['ciudad']));
                $objHotel->setCat(trim($hDB['cat']));
                
                $objetosHotel[]= $objHotel;
            }
            
            return $objetosHotel;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getHotel($codHotel)
    {
        $sql='SELECT codigo, hotel, pais, ciudad, fono, direc, cat, ope, convert(varchar, nota) as nota, rut, dv, suc, fax, razon, nombre2, compve, compvn, compvr, prio, codsicon, codclisi, crubro, estado, 
	      timestamp_column, email, marca, usuariocrea, fechacrea, usuariomod, fechamod, marca_web, marca_web_R, Allot_web, Allot_web_R, Marca_Web_P, marca_sur, 
	      tipo_comag, femergen, fcomision, SWEB, restaurante, bar, cafeteria, s_habitacion, busness_center, internet_hotel, estacionamiento, piscina_cub, piscina_des, gym, 
	      spa, tenis, guarderia, salas_reunion, jardin, discapacitados, bautique, acondicionado, calefaccion, no_fuma, caja_fuerte, mini_bar, television, tv_cable, inter_hab, 
	      secador_pelo, barra_seguridad, lavanderia, telefono, img_encabezado, img_contenido, img_contenido2, img_contenido3, img_contenido4, mini_img_encabezado, 
	      mini_img_contenido, mini_img_contenido2, mini_img_contenido3, mini_img_contenido4, lat, lon, child_free, prepago, dias_prepago, comag
            FROM hotel WHERE codigo="'.$codHotel.'"';
        
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            $objetosHotel= array();
            $arrayHotel= $this->_db->fetchAll($datos);
            
            foreach ($arrayHotel as $hDB)
            {
                $objHotel= new hotelDTO();
                
                $objHotel->setCodigo(trim($hDB['codigo']));
                $objHotel->setHotel(trim($hDB['hotel']));
                
                
                $objetosHotel[]= $objHotel;
            }
            
            return $objetosHotel;
        }
        else
        {
            return false;
        }
    }
}