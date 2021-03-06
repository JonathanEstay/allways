<?php

/* 
 * Proyecto : Allways
 * Autor    : Tsyacom Ltda.
 * Fecha    : Martes, 4 de marzo de 2014
 */

class Acl
{
    private $_db;
    private $_id;
    private $_role;
    private $_permisos;
    
    public function __construct($id = false)
    {
        if($id)
        {
            $this->_id = (int) $id; 
        }
        else
        {
            if(Session::get('sess_id_usuario'))
            {
                $this->_id = Session::get('sess_id_usuario');
            }
            else
            {
                $this->_id = 0;
            }
        }
        
        $this->_db = new Database();
        $this->_role = $this->getRole();
        $this->_permisos = $this->getPermisosRole();
        $this->compilarAcl();
    }
    
    public function getRole()
    {
        $sql= 'SELECT rc_role '
            . 'FROM rc_tbl_restaurantes_user '
            . 'WHERE rc_id_ru = '.$this->_id;
        
        $role = $this->_db->consulta($sql);
        $role = $this->_db->fetchAll($role);
        
        return $role[0]['rc_role'];
    }
    
    public function getPermisosRoleId()
    {
        $sql= 'SELEC permiso FROM permisos_role '
            . 'WHERE role = '.$this->_role;
        
        $ids = $this->_db->consulta($sql);
        
        return $this->_db->fetchAll($ids);
    }
    
    public function getPermisosRole()
    {
        $sql= 'SELEC * FROM permisos_role '
            . 'WHERE role = '.$this->_role;
        
        $permisos = $this->_db->consulta($sql);
        $permisos = $this->_db->fetchAll($permisos);
        $data = array();
        
        $i=0;
        foreach($permisos as $columnPermisos)
        {
            ++$i;
            $key = $this->getPermisoKey($columnPermisos['permiso']);
            //if($key == ''){continue;}
            
            if($columnPermisos['valor'] == 1)
            {
                $v = true;
            }
            else
            {
                $v = false;
            }
            
            $data[$key] = array(
                'key' => $key,
                'permiso' => $this->getPermisoNombre($permisos[$i]['permiso']),
                'valor' => $v,
                'heredado' => true,
                'id' => $permisos[$i]['permiso']
            );
        }
        
        
        //return $this->_db->fetchAll($permisos);
    }
    
    public function getPermisoKey($permisoID)
    {
        $permisoID = (int) $permisoID;
        
        $sql= 'SELECT key_ FROM permisos '
            . 'WHERE id_permiso = '.$permisoID;
        
        $key = $this->_db->consulta($sql);
        $key = $this->_db->fetchAll($key);
        
        return $key[0]['key_'];
    }
}