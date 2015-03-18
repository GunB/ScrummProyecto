<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class M_equipo extends CI_Model {

    //var $sesion = null;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function existe_grupo($proyecto, $numero_iteracion) {
        $this->load->model('m_iteracion');
        $id_iteracion=$this->m_iteracion->obtener_id_numero_iteracion_proyecto($numero_iteracion, $proyecto);
        $query = $this->db->get_where('iteracion_has_integrante_equipo', array('iteracion_id' => $id_iteracion));
        if ($query->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    function obtener_equipo($iteracion) {
        $query = $this->db->get_where('iteracion_has_integrante_equipo', array('iteracion_id' => $iteracion));
        $resp = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($resp, $row->integrante_equipo_id);
            }
        }
        if(empty($resp))
        {
            return null;
        }
        else
        {
            $this->db->where_in('id', $resp);
            $query = $this->db->get('integrante_equipo');
            $resp = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row){
                    array_push($resp, $row);
                }
                return $resp;
            }
        }
    }
    
        function obtener_equipo_completo($proyecto,$iteracion_actual) {
        $this->load->model('m_iteracion');  
        $iditeraciones = $this->m_iteracion->obtener_id_iteraciones_proyecto($proyecto);
        $this->db->distinct();
        $this->db->select('integrante_equipo_id');
        $this->db->where_in('iteracion_id', $iditeraciones);
        $this->db->where('iteracion_id !=', $iteracion_actual); 
        $query = $this->db->get('iteracion_has_integrante_equipo');
        $resp = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($resp, $row->integrante_equipo_id);
            }
        }
        if(empty($resp))
        {
            return null;
        }
        else
        {
            $this->db->where_in('id', $resp);
            $query = $this->db->get('integrante_equipo');
            $resp = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row){
                    array_push($resp, $row);
                }
                return $resp;
            }
        }
    }
    
        function integrante_en_proyecto($id,$proyecto) {
            $this->load->model('m_iteracion');
            $iteraciones = $this->m_iteracion->obtener_id_iteraciones_proyecto($proyecto);
            $this->db->where_in('iteracion_id', $iteraciones);
            $this->db->where('integrante_equipo_id', $id);
            $query = $this->db->get('iteracion_has_integrante_equipo');
        if ($query->num_rows() > 0) 
        {
           return true;
        }
        else
        {
           return false;
        }
    }
    
            function obtener_datos_integrante($id) {
        $query = $this->db->get_where('integrante_equipo', array('id'=>$id));
        $resp = null;
        if ($query->num_rows() > 0) {
        $resp = array();    
        foreach ($query->result() as $row) {
            array_push($resp, $row);
        }
        }
        return $resp;
    }
    
            function actualizar_velocidad() {
        $this->load->model('m_historias');
        $this->load->model('m_iteracion');
        $id = $this->m_proyectos->obtener_id_proyecto_activo();
        $ultima = $this->m_iteracion->obtener_ultima_iteracion($id);
        $iteracion = $ultima->id;
        $historias = $this->m_historias->obtener_historias_iteracion($iteracion);
        $daily_scrums = $this->m_dailyscrum->obtener_cantidad_daily_scrums_terminados($iteracion)+1;
        $suma = 0;
        for($i=0;$i<sizeof($historias);$i++)
        {
            if($historias[$i]->estado == 'finalizada')
            {
               $suma += $historias[$i]->puntos_de_historia;  
            }
        }
        $velocidad = $suma / $daily_scrums;
        $data = array(
            'velocidad' => $velocidad
        );
        
        $this->db->where('id', $iteracion);
        $this->db->update('iteracion', $data); 
    }
    
                function calcular_velocidad($proyecto) {
        $query = $this->db->get_where('iteracion', array('proyecto_id'=>$proyecto));
        $vel = 0;
        $num_iteraciones = 0;
            foreach ($query->result() as $row) {
                if(is_numeric($row->velocidad))
                {
                    $vel = $vel + $row->velocidad;
                    $num_iteraciones++;
                }
            }
        if($num_iteraciones>0)
        {
        $resp = $vel / $num_iteraciones;
        }
        else
        {
            $resp = 0;
        }
        return $resp;
    }
    
                    function grafica_velocidad($proyecto) {
        $this->load->model('m_proyectos');                
        $query = $this->db->get_where('iteracion', array('proyecto_id'=>$proyecto));
        $grafica = array();
        array_push($grafica, array(0, 0));
            foreach ($query->result() as $row) {
                if(is_numeric($row->velocidad))
                {
                     $vel_iteracion = $row->velocidad * $this->m_proyectos->obtener_duracion_iteracion_proyecto_activo();
                     array_push($grafica, array(intval($row->numero), $vel_iteracion));
                }
            }
        return json_encode($grafica);
    }

    function vincular_integrante_iteracion($integrante,$iteracion) {
        $input = array(
            'iteracion_id' => $iteracion,
            'integrante_equipo_id' => $integrante,
        );
        $this->db->insert('iteracion_has_integrante_equipo', $input);
        return true;
    }
    
        function crear_integrante_equipo($nombre, $apellidos, $edad, $correo, $telefono,$iteracion) {
        $input = array(
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'edad' => $edad,
            'correo' => $correo,
            'telefono' => $telefono
        );
        $this->db->insert('integrante_equipo', $input);
        $integrante=$this->db->insert_id();
        $this->vincular_integrante_iteracion($integrante, $iteracion);
    }
    
        public function editar_integrante($id, $nombre, $apellidos, $edad, $correo, $telefono) {
        $data = array(
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'edad' => $edad,
            'correo' => $correo,
            'telefono' => $telefono
        );

        $this->db->where('id', $id);
        $this->db->update('integrante_equipo', $data);
    }

}

?>